<?php

namespace App\Http\Controllers;

use App\Helpers\IdGenerator;
use App\Models\Order;
use App\Services\BonusToken\IBonusTokenService;
use App\Services\Checkout\ICheckoutService;
use App\Services\PurchaseToken\IPurchaseTokenService;
use App\Services\User\IUserService;
use App\Models\User;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use net\authorize\api\constants\ANetEnvironment;
use Omnipay\Common\CreditCard;
use Omnipay\Omnipay;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;
use Exception;

class PaymentController extends Controller
{
    public $gateway;
    public $checkoutService;
    private $purchaseTokenService;
    private $bonusTokenService;
    private $userService;

    public function __construct(ICheckoutService $checkoutService,
                                IPurchaseTokenService $purchaseTokenService,
                                IBonusTokenService $bonusTokenService, IUserService $userService)
    {
        $this->checkoutService = $checkoutService;
        $this->purchaseTokenService = $purchaseTokenService;
        $this->bonusTokenService = $bonusTokenService;
        $this->userService = $userService;
    }

    public function checkProductCategory(){
        $products = Cart::content();
        $printPublication = 1;
        foreach ($products as $product){
            if ($product->options['category'] == "Memberships" ||
                $product->options['category'] == "Tokens" ||
                $product->options['category'] == "Online Publication" ||
                $product->options['category'] == "Services"){

                $printPublication = 0;
                break;
            }
        }
        if ($printPublication == 1)
            if (Auth::check())
                return redirect()->route("cardPayment");
            else
                return redirect()->route("guestCardPayment");
        else
            return redirect()->route("cardPayment");
    }

    public function checkoutView()
    {
        $user = Auth::user();
        return view('ccheckout.checkout',compact('user'));
    }

    public function guestPaymentView()
    {
        return view('ccheckout.guestCheckout');
    }

    public function remainingPayment(){
        $user = Auth::user();
        return view('ccheckout.remainingPaymentCheckout',compact('user'));
    }

    public function charge(Request $request)
    {
        $payment = Cart::total();

        /* Create a merchantAuthenticationType object with authentication details
         retrieved from the constants file */
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName(env('ANET_API_LOGIN_ID'));
        $merchantAuthentication->setTransactionKey(env('ANET_TRANSACTION_KEY'));

        // Set the transaction's refId
        $refId = 'ref' . time();
        $cardNumber = preg_replace('/\s+/', '', $request->input('cc_number'));

        // Create the payment data for a credit card
        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber($cardNumber);
        $creditCard->setExpirationDate($request->input('expiry_year') . "-" .$request->input('expiry_month'));
        $creditCard->setCardCode($request->input('cvv'));

        // Add the payment data to a paymentType object
        $paymentOne = new AnetAPI\PaymentType();
        $paymentOne->setCreditCard($creditCard);

        // Create order information
        $invoiceId =IdGenerator::IDGenerator(new Order, 'invoice', 8, 'ORD'.time());
        $order = new AnetAPI\OrderType();
        $order->setInvoiceNumber($invoiceId);
        $order->setDescription("Product Payment");

        // Set the customer's Bill To address
        $customerAddress = new AnetAPI\CustomerAddressType();
        $customerAddress->setFirstName($request->input('firstname'));
        $customerAddress->setLastName($request->input('lastname'));
        $customerAddress->setAddress($request->input('address'));
        $customerAddress->setCity($request->input('city'));
        $customerAddress->setState($request->input('state'));
        $customerAddress->setZip($request->input('postal'));
        $customerAddress->setCountry($request->input('country'));

        // Create a TransactionRequestType object and add the previous objects to it
        $transactionRequestType = new AnetAPI\TransactionRequestType();
        $transactionRequestType->setTransactionType("authCaptureTransaction");
        $transactionRequestType->setAmount($payment);
        $transactionRequestType->setPayment($paymentOne);
        $transactionRequestType->setOrder($order);
        $transactionRequestType->setBillTo($customerAddress);

        // Assemble the complete transaction request
        $requests = new AnetAPI\CreateTransactionRequest();
        $requests->setMerchantAuthentication($merchantAuthentication);
        $requests->setRefId($refId);
        $requests->setTransactionRequest($transactionRequestType);

        // Create the controller and get the response
        $controller = new AnetController\CreateTransactionController($requests);
        $response = $controller->executeWithApiResponse(ANetEnvironment::PRODUCTION);

        if ($response != null) {
            // Check to see if the API request was successfully received and acted upon
            if ($response->getMessages()->getResultCode() == "Ok") {
                // Since the API request was successful, look for a transaction response
                // and parse it to display the results of authorizing the card
                $tresponse = $response->getTransactionResponse();

                if ($tresponse != null && $tresponse->getMessages() != null) {
                    $message_text = $tresponse->getMessages()[0]->getDescription().", Transaction ID: " . $tresponse->getTransId();
                    $msg_type = "successMessage";

                    //place order
                    $this->checkoutService->CardCheckout($invoiceId, $tresponse->getMessages()[0]->getCode(), $tresponse->getTransId(), $request->input('cc_number'));
                    return redirect()->route('shop')->with($msg_type,$message_text);
                } else {
                    $message_text = 'There were some issue with the payment. Please try again later.';
                    $msg_type = "errorMessage";

                    if ($tresponse->getErrors() != null) {
                        $message_text = $tresponse->getErrors()[0]->getErrorText();
                        $msg_type = "errorMessage";
                    }
                }
                // Or, print errors if the API request wasn't successful
            } else {
                $message_text = 'There were some issue with the payment. Please try again later.';
                $msg_type = "errorMessage";

                $tresponse = $response->getTransactionResponse();

                if ($tresponse != null && $tresponse->getErrors() != null) {
                    $message_text = $tresponse->getErrors()[0]->getErrorText();
                    $msg_type = "errorMessage";
                } else {
                    $message_text = $response->getMessages()->getMessage()[0]->getText();
                    $msg_type = "errorMessage";
                }
            }
        } else {
            $message_text = "No response returned";
            $msg_type = "errorMessage";
        }
        return redirect()->route('cart.show')->with($msg_type, $message_text);
    }

    public function guestCharge(Request $request): \Illuminate\Http\RedirectResponse
    {
        $payment = Cart::total();

        /* Create a merchantAuthenticationType object with authentication details
         retrieved from the constants file */
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName(env('ANET_API_LOGIN_ID'));
        $merchantAuthentication->setTransactionKey(env('ANET_TRANSACTION_KEY'));

        // Set the transaction's refId
        $refId = 'ref' . time();
        $cardNumber = preg_replace('/\s+/', '', $request->input('cc_number'));

        // Create the payment data for a credit card
        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber($cardNumber);
        $creditCard->setExpirationDate($request->input('expiry_year') . "-" .$request->input('expiry_month'));
        $creditCard->setCardCode($request->input('cvv'));

        // Add the payment data to a paymentType object
        $paymentOne = new AnetAPI\PaymentType();
        $paymentOne->setCreditCard($creditCard);

        // Create order information
        $invoiceId =IdGenerator::IDGenerator(new Order, 'invoice', 8, 'ORD'.time());
        $order = new AnetAPI\OrderType();
        $order->setInvoiceNumber($invoiceId);
        $order->setDescription("Product Payment");

        // Set the customer's Bill To address
        $customerAddress = new AnetAPI\CustomerAddressType();
        $customerAddress->setFirstName($request->input('firstname'));
        $customerAddress->setLastName($request->input('lastname'));
        $customerAddress->setAddress($request->input('address'));
        $customerAddress->setCity($request->input('city'));
        $customerAddress->setState($request->input('state'));
        $customerAddress->setZip($request->input('postal'));
        $customerAddress->setCountry($request->input('country'));

        // Create a TransactionRequestType object and add the previous objects to it
        $transactionRequestType = new AnetAPI\TransactionRequestType();
        $transactionRequestType->setTransactionType("authCaptureTransaction");
        $transactionRequestType->setAmount($payment);
        $transactionRequestType->setPayment($paymentOne);
        $transactionRequestType->setOrder($order);
        $transactionRequestType->setBillTo($customerAddress);

        // Assemble the complete transaction request
        $requests = new AnetAPI\CreateTransactionRequest();
        $requests->setMerchantAuthentication($merchantAuthentication);
        $requests->setRefId($refId);
        $requests->setTransactionRequest($transactionRequestType);

        // Create the controller and get the response
        $controller = new AnetController\CreateTransactionController($requests);
        $response = $controller->executeWithApiResponse(ANetEnvironment::PRODUCTION);

        if ($response != null) {
            // Check to see if the API request was successfully received and acted upon
            if ($response->getMessages()->getResultCode() == "Ok") {
                // Since the API request was successful, look for a transaction response
                // and parse it to display the results of authorizing the card
                $tresponse = $response->getTransactionResponse();

                if ($tresponse != null && $tresponse->getMessages() != null) {
                    $message_text = $tresponse->getMessages()[0]->getDescription().", Transaction ID: " . $tresponse->getTransId();
                    $msg_type = "successMessage";

                    //place order
                    $this->userService->createGuestUser($request->all(),$payment, $invoiceId, $tresponse->getMessages()[0]->getCode(), $tresponse->getTransId(), $request->input('cc_number'));
                    return redirect()->route('shop')->with($msg_type,$message_text);
                } else {
                    $message_text = 'There were some issue with the payment. Please try again later.';
                    $msg_type = "errorMessage";

                    if ($tresponse->getErrors() != null) {
                        $message_text = $tresponse->getErrors()[0]->getErrorText();
                        $msg_type = "errorMessage";
                    }
                }
                // Or, print errors if the API request wasn't successful
            } else {
                $message_text = 'There were some issue with the payment. Please try again later.';
                $msg_type = "errorMessage";

                $tresponse = $response->getTransactionResponse();

                if ($tresponse != null && $tresponse->getErrors() != null) {
                    $message_text = $tresponse->getErrors()[0]->getErrorText();
                    $msg_type = "errorMessage";
                } else {
                    $message_text = $response->getMessages()->getMessage()[0]->getText();
                    $msg_type = "errorMessage";
                }
            }
        } else {
            $message_text = "No response returned";
            $msg_type = "errorMessage";
        }
        return redirect()->route('cart.show')->with($msg_type, $message_text);
    }

    public function remainingCharge(Request $request)
    {
        $payment=Cart::total();
        $purchaseToken = $this->purchaseTokenService->getOwnedToken();
        $bonusToken = $this->bonusTokenService->getOwnedToken();
        $userTotalToken = $purchaseToken->total + $bonusToken->total;
        $remainingPaymant =$payment - $userTotalToken;

        /* Create a merchantAuthenticationType object with authentication details
         retrieved from the constants file */
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName(env('ANET_API_LOGIN_ID'));
        $merchantAuthentication->setTransactionKey(env('ANET_TRANSACTION_KEY'));

        // Set the transaction's refId
        $refId = 'ref' . time();
        $cardNumber = preg_replace('/\s+/', '', $request->input('cc_number'));

        // Create the payment data for a credit card
        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber($cardNumber);
        $creditCard->setExpirationDate($request->input('expiry_year') . "-" .$request->input('expiry_month'));
        $creditCard->setCardCode($request->input('cvv'));

        // Add the payment data to a paymentType object
        $paymentOne = new AnetAPI\PaymentType();
        $paymentOne->setCreditCard($creditCard);

        // Create order information
        $invoiceId =IdGenerator::IDGenerator(new Order, 'invoice', 8, 'ORD'.time());
        $order = new AnetAPI\OrderType();
        $order->setInvoiceNumber($invoiceId);
        $order->setDescription("Product Payment");

        // Set the customer's Bill To address
        $customerAddress = new AnetAPI\CustomerAddressType();
        $customerAddress->setFirstName($request->input('firstname'));
        $customerAddress->setLastName($request->input('lastname'));
        $customerAddress->setAddress($request->input('address'));
        $customerAddress->setCity($request->input('city'));
        $customerAddress->setState($request->input('state'));
        $customerAddress->setZip($request->input('postal'));
        $customerAddress->setCountry($request->input('country'));

        // Create a TransactionRequestType object and add the previous objects to it
        $transactionRequestType = new AnetAPI\TransactionRequestType();
        $transactionRequestType->setTransactionType("authCaptureTransaction");
        $transactionRequestType->setAmount($remainingPaymant);
        $transactionRequestType->setPayment($paymentOne);
        $transactionRequestType->setOrder($order);
        $transactionRequestType->setBillTo($customerAddress);

        // Assemble the complete transaction request
        $requests = new AnetAPI\CreateTransactionRequest();
        $requests->setMerchantAuthentication($merchantAuthentication);
        $requests->setRefId($refId);
        $requests->setTransactionRequest($transactionRequestType);

        // Create the controller and get the response
        $controller = new AnetController\CreateTransactionController($requests);
        $response = $controller->executeWithApiResponse(ANetEnvironment::PRODUCTION);

        if ($response != null) {
            // Check to see if the API request was successfully received and acted upon
            if ($response->getMessages()->getResultCode() == "Ok") {
                // Since the API request was successful, look for a transaction response
                // and parse it to display the results of authorizing the card
                $tresponse = $response->getTransactionResponse();

                if ($tresponse != null && $tresponse->getMessages() != null) {
                    $message_text = $tresponse->getMessages()[0]->getDescription().", Transaction ID: " . $tresponse->getTransId();
                    $msg_type = "successMessage";

                    //place order
                    $this->checkoutService->remainingPaymentWithCard($payment, $remainingPaymant, $invoiceId, $tresponse->getMessages()[0]->getCode(), $tresponse->getTransId(), $request->input('cc_number'));
                    return redirect()->route('shop')->with($msg_type,$message_text);
                } else {
                    $message_text = 'There were some issue with the payment. Please try again later.';
                    $msg_type = "errorMessage";

                    if ($tresponse->getErrors() != null) {
                        $message_text = $tresponse->getErrors()[0]->getErrorText();
                        $msg_type = "errorMessage";
                    }
                }
                // Or, print errors if the API request wasn't successful
            } else {
                $message_text = 'There were some issue with the payment. Please try again later.';
                $msg_type = "errorMessage";

                $tresponse = $response->getTransactionResponse();

                if ($tresponse != null && $tresponse->getErrors() != null) {
                    $message_text = $tresponse->getErrors()[0]->getErrorText();
                    $msg_type = "errorMessage";
                } else {
                    $message_text = $response->getMessages()->getMessage()[0]->getText();
                    $msg_type = "errorMessage";
                }
            }
        } else {
            $message_text = "No response returned";
            $msg_type = "errorMessage";
        }
        return redirect()->route('cart.show')->with($msg_type, $message_text);
    }

    public function refundView(){
        return view('admin.refund');
    }

    public function refund(Request $request){

        /* Create a merchantAuthenticationType object with authentication details
       retrieved from the constants file */
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName(env('ANET_API_LOGIN_ID'));
        $merchantAuthentication->setTransactionKey(env('ANET_TRANSACTION_KEY'));

        // Set the transaction's refId
        $refId = 'ref' . time();

        // Create the payment data for a credit card
        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber($request->cc_number);
        $creditCard->setExpirationDate($request->input('expiry_year') . "-" .$request->input('expiry_month'));

        $paymentOne = new AnetAPI\PaymentType();
        $paymentOne->setCreditCard($creditCard);

        //create a transaction
        $transactionRequest = new AnetAPI\TransactionRequestType();
        $transactionRequest->setTransactionType( "refundTransaction");
        $transactionRequest->setAmount($request->amount);
        $transactionRequest->setPayment($paymentOne);
        $transactionRequest->setRefTransId($request->transactionReference);


        $request = new AnetAPI\CreateTransactionRequest();
        $request->setMerchantAuthentication($merchantAuthentication);
        $request->setRefId($refId);
        $request->setTransactionRequest( $transactionRequest);
        $controller = new AnetController\CreateTransactionController($request);
        $response = $controller->executeWithApiResponse( ANetEnvironment::PRODUCTION);

        if ($response != null)
        {
            if($response->getMessages()->getResultCode() == "Ok")
            {
                $tresponse = $response->getTransactionResponse();

                if ($tresponse != null && $tresponse->getMessages() != null)
                {
                    $message_text = $tresponse->getMessages()[0]->getDescription().", Response code: " . $tresponse->getResponseCode().", Refund SUCCESS: " . $tresponse->getTransId();
                    $msg_type = "successMessage";
                    return redirect()->route('orderList')->with($msg_type, $message_text);
                }
                else
                {
                    $message_text = "Transaction Failed" ;
                    $msg_type = "errorMessage";
                    if($tresponse->getErrors() != null)
                    {
                        $message_text = $tresponse->getErrors()[0]->getErrorText() ;
                        $msg_type = "errorMessage";
                    }
                }
            }
            else
            {
                $message_text = "Transaction Failed" ;
                $msg_type = "errorMessage";
                $tresponse = $response->getTransactionResponse();
                if($tresponse != null && $tresponse->getErrors() != null)
                {
                    $message_text = $tresponse->getErrors()[0]->getErrorText()  ;
                    $msg_type = "errorMessage";
                }
                else
                {
                    $message_text = $response->getMessages()->getMessage()[0]->getText()  ;
                    $msg_type = "errorMessage";
                }
            }
        }
        else
        {
            $message_text = "No response returned" ;
            $msg_type = "errorMessage";
        }

        return redirect()->route('refundView')->with($msg_type,$message_text);
    }
}
