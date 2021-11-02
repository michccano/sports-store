<?php

namespace App\Http\Controllers;

use App\Helpers\IdGenerator;
use App\Models\Order;
use App\Services\BonusToken\IBonusTokenService;
use App\Services\Checkout\ICheckoutService;
use App\Services\PurchaseToken\IPurchaseTokenService;
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

    public function __construct(ICheckoutService $checkoutService,
                                IPurchaseTokenService $purchaseTokenService,
                                IBonusTokenService $bonusTokenService)
    {
        $this->gateway = Omnipay::create('AuthorizeNetApi_Api');
        $this->gateway->setAuthName(strval(env('ANET_API_LOGIN_ID')));
        $this->gateway->setTransactionKey(strval(env('ANET_TRANSACTION_KEY')));
        /*$this->gateway->setUsername('insidescores');
        $this->gateway->setPassword('5I4n3s2I!!$$aP8668');*/
        $this->gateway->initialize([
            'username' => strval("insidescores"),
            'password' => strval('5I4n3s2I!!$$aP8668'),
        ]);
        //$this->gateway->setTestMode(true); //comment this line when move to 'live'

        $this->checkoutService = $checkoutService;
        $this->purchaseTokenService = $purchaseTokenService;
        $this->bonusTokenService = $bonusTokenService;
    }

    public function index()
    {
        $user = Auth::user();
        return view('payment',compact('user'));
    }

    public function remainingPayment(){
        $user = Auth::user();
        return view('payment2',compact('user'));
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
        $invoiceId =IdGenerator::IDGenerator(new Order, 'invoice', 8, 'ORD');
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

    public function remainingCharge(Request $request)
    {
        $payment=Cart::total();
        $purchaseToken = $this->purchaseTokenService->getOwnedToken();
        $bonusToken = $this->bonusTokenService->getOwnedToken();
        $userTotalToken = $purchaseToken->total + $bonusToken->total;
        $remainingPaymant =$payment - $userTotalToken;

        try {
            $creditCard = new CreditCard([
                'firstName' => $request->input('firstname'),
                'lastName' => $request->input('lastname'),
                'billingAddress1' => $request->input('address'),
                'billingCity' => $request->input('city'),
                'billingPostcode' => $request->input('postal'),
                'billingState' => $request->input('state'),
                'billingCountry' => $request->input('country'),
                'billingPhone' => $request->input('phone'),
                'number' => $request->input('cc_number'),
                'expiryMonth' => $request->input('expiry_month'),
                'expiryYear' => $request->input('expiry_year'),
                'cvv' => $request->input('cvv'),
            ]);

            // Generate a unique merchant site transaction ID.
            $transactionId =IdGenerator::IDGenerator(new Order, 'transactionId', 8, 'TRN');
            $invoiceId =IdGenerator::IDGenerator(new Order, 'invoice', 8, 'ORD');

            $response = $this->gateway->authorize([
                'amount' => $remainingPaymant,
                'currency' => 'USD',
                'description' => 'Product Payment',
                'invoiceNumber' => $invoiceId,
                'transactionReference' => $transactionId,
                'card' => $creditCard,
            ])->send();

            if($response->isSuccessful()) {

                // Captured from the authorization response.
                $transactionReference = $response->getTransactionReference();


                $response = $this->gateway->capture([
                    'amount' => $payment,
                    'currency' => 'USD',
                    'transactionReference' => $transactionReference,
                ])->send();

                $placeorder = $this->checkoutService->CardCheckout($invoiceId, $transactionReference, $transactionId, $request->input('cc_number'));
                return redirect()->route('shop')->with("successMessage","Order Placed Successfully");
            } else {
                // not successful
                return redirect()->route('cart.show')->with("errorMessage",$response->getMessage());
            }
        } catch(Exception $e) {
            return redirect()->route('cart.show')->with("errorMessage",$e->getMessage());
        }
    }

    public function refundView(){
        return view('admin.refund');
    }

    public function refund(Request $request){
       try{
           $response = $this->gateway->refund([
               'amount' => $request->amount,
               'currency' => 'USD',
               'description' => 'Payment Refund',
               'transactionReference' => $request->transactionReference,
               'numberLastFour' => $request->cc_number,
           ])->send();

           if($response->isSuccessful()) {
               return redirect()->route('orderList')->with("successMessage",$response->getMessage()."Refund successfully");
           } else {
               // not successful
               return redirect()->route('refundView')->with("errorMessage",$response->getMessage()."or the transaction is not settled");
           }
       }
        catch(Exception $e) {
            return redirect()->route('refundView')->with("errorMessage",$e->getMessage()."or the transaction is not settled");
        }
    }
}
