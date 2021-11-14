<?php

namespace App\Services\Payment;

use App\Helpers\IdGenerator;
use App\Models\Order;
use net\authorize\api\constants\ANetEnvironment;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

class PaymentService implements IPaymentService{

    public function gatewaySetup($payment, $request, $invoiceId){
        /* Create a merchantAuthenticationType object with authentication details
 retrieved from the constants file */
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName(env('ANET_API_LOGIN_ID'));
        $merchantAuthentication->setTransactionKey(env('ANET_TRANSACTION_KEY'));

        // Set the transaction's refId
        $refId = 'ref' . time();
        $cardNumber = preg_replace('/\s+/', '', $request['cc_number']);

        // Create the payment data for a credit card
        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber($cardNumber);
        $creditCard->setExpirationDate($request['expiry_year'] . "-" .$request['expiry_month']);
        $creditCard->setCardCode($request['cvv']);

        // Add the payment data to a paymentType object
        $paymentOne = new AnetAPI\PaymentType();
        $paymentOne->setCreditCard($creditCard);

        // Create order information
        $order = new AnetAPI\OrderType();
        $order->setInvoiceNumber($invoiceId);
        $order->setDescription("Product Payment");

        // Set the customer's Bill To address
        $customerAddress = new AnetAPI\CustomerAddressType();
        $customerAddress->setFirstName($request['firstname']);
        $customerAddress->setLastName($request['lastname']);
        $customerAddress->setAddress($request['address']);
        $customerAddress->setCity($request['city']);
        $customerAddress->setState($request['state']);
        $customerAddress->setZip($request['postal']);
        $customerAddress->setCountry($request['country']);

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
        return $controller->executeWithApiResponse(ANetEnvironment::PRODUCTION);
    }
}
