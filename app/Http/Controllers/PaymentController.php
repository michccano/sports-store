<?php

namespace App\Http\Controllers;

use App\Helpers\IdGenerator;
use App\Services\Checkout\ICheckoutService;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Omnipay\Common\CreditCard;
use Omnipay\Omnipay;
use App\Models\Payment;
use Exception;

class PaymentController extends Controller
{
    public $gateway;
    public $checkoutService;

    public function __construct(ICheckoutService $checkoutService)
    {
        $this->gateway = Omnipay::create('AuthorizeNetApi_Api');
        $this->gateway->setAuthName(env('ANET_API_LOGIN_ID'));
        $this->gateway->setTransactionKey(env('ANET_TRANSACTION_KEY'));
        $this->gateway->setTestMode(true); //comment this line when move to 'live'

        $this->checkoutService = $checkoutService;
    }

    public function index()
    {
        $payment = Cart::total();
        return view('payment',compact("payment"));
    }

    public function remainingPayment(Request $request){
        $payment = $request->input('payment');
        $remainingPaymant = $request->input('remainingPayment');
        return view('payment2',compact("payment","remainingPaymant"));
    }

    public function charge(Request $request)
    {
        try {
            $creditCard = new CreditCard([
                'number' => $request->input('cc_number'),
                'expiryMonth' => $request->input('expiry_month'),
                'expiryYear' => $request->input('expiry_year'),
                'cvv' => $request->input('cvv'),
            ]);

            // Generate a unique merchant site transaction ID.
            $transactionId =IdGenerator::IDGenerator(new Payment, 'transaction_id', 8, 'TRN');

            $response = $this->gateway->authorize([
                'amount' => $request->input('amount'),
                'currency' => 'USD',
                'transactionId' => $transactionId,
                'card' => $creditCard,
            ])->send();

            if($response->isSuccessful()) {

                // Captured from the authorization response.
                $transactionReference = $response->getTransactionReference();

                $response = $this->gateway->capture([
                    'amount' => $request->input('amount'),
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
        $payment=$request->input('payment');
        $remainingPaymant =$request->input('amount');
        try {
            $creditCard = new CreditCard([
                'number' => $request->input('cc_number'),
                'expiryMonth' => $request->input('expiry_month'),
                'expiryYear' => $request->input('expiry_year'),
                'cvv' => $request->input('cvv'),
            ]);

            // Generate a unique merchant site transaction ID.
            $transactionId =IdGenerator::IDGenerator(new Payment, 'transaction_id', 8, 'TRN');

            $response = $this->gateway->authorize([
                'amount' => $request->input('amount'),
                'currency' => 'USD',
                'transactionId' => $transactionId,
                'card' => $creditCard,
            ])->send();

            if($response->isSuccessful()) {

                // Captured from the authorization response.
                $transactionReference = $response->getTransactionReference();

                $response = $this->gateway->capture([
                    'amount' => $request->input('amount'),
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
