<?php

namespace App\Services\Order;

use App\Helpers\IdGenerator;
use App\Models\Order;
use App\Repository\Order\IOrderRepository;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;

class OrderService implements IOrderService {

    private $orderRepository;

    public function __construct(IOrderRepository $orderRepository){
        $this->orderRepository = $orderRepository;
    }

    public function create($tokenBill , $cardBill, $invoice, $message_code, $transactionId,
                           $cardNumber, $user){
        $order = $this->orderRepository->create([
            "invoice" => $invoice,
            "total_bill" => Cart::total(),
            "token_payment_amount" => $tokenBill,
            "card_payment_amount" => $cardBill,
            "message_code" => $message_code,
            "transactionId" => $transactionId,
            "cardNumber" => $cardNumber,
            'user_id' => $user->id,
        ]);
        $this->addOrderProduct($order,$user);
    }

    public function addOrderProduct($order,$user){
        $products = Cart::content();

        foreach ($products as $product){
            $order->products()->attach($product->id,
                ['quantity' => $product->qty,'price'=> $product->price,
                    'type' => $product->options['type']]);

            $user->products()->attach($product->id,
                ['type' => $product->options['type']]);
        }
    }
}
