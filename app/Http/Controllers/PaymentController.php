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
use Omnipay\Common\CreditCard;
use Omnipay\Omnipay;
use App\Models\Payment;
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
        $this->gateway->setAuthName(env('ANET_API_LOGIN_ID'));
        $this->gateway->setTransactionKey(env('ANET_TRANSACTION_KEY'));
        $this->gateway->setTestMode(true); //comment this line when move to 'live'

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
            $transactionId =IdGenerator::IDGenerator(new Order, 'transaction_id', 8, 'TRN');
            $invoiceId =IdGenerator::IDGenerator(new Order, 'invoice', 8, 'ORD');

            $response = $this->gateway->authorize([
                'amount' => $payment,
                'currency' => 'USD',
                'description' => 'Product Payment',
                'invoiceNumber' => $invoiceId,
                'transactionId' => $transactionId,
                'card' => $creditCard,
            ])->send();

            if($response->isSuccessful()) {

                // Captured from the authorization response.
                $transactionReference = $response->getTransactionReference();
                $transactionId = $response->getTransactionId();
                $transaction = $this->gateway->fetchTransaction([
                    'transactionReference' => $transactionReference,
                ])->send();


                $response = $this->gateway->capture([
                    'amount' => $payment,
                    'currency' => 'USD',
                    'transactionReference' => $transactionReference,
                ])->send();

                $placeorder = $this->checkoutService->CardCheckout();
                return redirect()->route('shop')->with("successMessage","Order Placed Successfully");
            } else {
                // not successful
                return redirect()->route('cart.show')->with("errorMessage",$response->getMessage());
            }
        } catch(Exception $e) {
            return redirect()->route('cart.show')->with("errorMessage",$e->getMessage());
        }
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
            $transactionId =IdGenerator::IDGenerator(new Payment, 'transaction_id', 8, 'TRN');
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

                $placeorder = $this->checkoutService->remainingPaymentWithCard($payment, $remainingPaymant);
                return redirect()->route('shop')->with("successMessage","Order Placed Successfully");
            } else {
                // not successful
                return redirect()->route('cart.show')->with("errorMessage",$response->getMessage());
            }
        } catch(Exception $e) {
            return redirect()->route('cart.show')->with("errorMessage",$e->getMessage());
        }
    }
}
