<?php

namespace App\Http\Controllers;

use App\Helpers\IdGenerator;
use App\Services\BonusToken\IBonusTokenService;
use App\Services\Checkout\ICheckoutService;
use App\Services\PurchaseToken\IPurchaseTokenService;
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
        return view('payment');
    }

    public function remainingPayment(){
        return view('payment2');
    }

    public function charge(Request $request)
    {
        $payment = Cart::total();
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
                'amount' => $payment,
                'currency' => 'USD',
                'transactionId' => $transactionId,
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
                'number' => $request->input('cc_number'),
                'expiryMonth' => $request->input('expiry_month'),
                'expiryYear' => $request->input('expiry_year'),
                'cvv' => $request->input('cvv'),
            ]);

            // Generate a unique merchant site transaction ID.
            $transactionId =IdGenerator::IDGenerator(new Payment, 'transaction_id', 8, 'TRN');

            $response = $this->gateway->authorize([
                'amount' => $remainingPaymant,
                'currency' => 'USD',
                'transactionId' => $transactionId,
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
