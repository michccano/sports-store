@extends('layouts.mainApp')

@section('title', 'Profile')

@section('content')
    <section class="profile-top-area">
        <div class="container">
            <div class="shop-category-inner-wrap">
                <div class="row">
                    <div class="row">
                        <div class="col">
                            <div class="shop-category-title">
                                <h3>Order List</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
    <section class="cart-product-body">
        <div class="container-md container-fluid">
            <div class="cart-product-inner-wrap">
                <div class="cart-product-top">
                    <div class="row">
                        <table>
                            <th>Invoice No.</th>
                            <th>Total Bill</th>
                            <th>Token Payment</th>
                            <th>Card Payment</th>
                            <th>Products</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            @foreach($orders as $order)
                                <tr>
                                    <td>{{$order->invoice}}</td>
                                    <td>{{$order->total_bill}}</td>
                                    <td>{{$order->token_payment_amount}}</td>
                                    <td>{{$order->card_payment_amount}}</td>
                                    <td>
                                    @foreach($order->products as $product)
                                        {{$product->name}}
                                        <br>
                                    @endforeach
                                    </td>
                                    <td>
                                        @foreach($order->products as $product)
                                            {{$product->pivot->quantity}}
                                            <br>
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach($order->products as $product)
                                            {{$product->pivot->price}}
                                            <br>
                                        @endforeach
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
