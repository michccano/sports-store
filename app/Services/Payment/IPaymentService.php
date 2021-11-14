<?php

namespace App\Services\Payment;

interface IPaymentService{
    public function gatewaySetup($payment, $request, $invoiceId);
}
