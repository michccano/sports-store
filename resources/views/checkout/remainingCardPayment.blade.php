@extends('layouts.mainApp')

@section('title', 'Cart')

@section('content')
    <section class="shop-category-main-area">
        <div class="container">
            <div class="shop-category-inner-wrap">
                <div class="shop-category-title">
                    <h3>Pay From Card</h3>
                </div>
            </div>
        </div>
    </section>
    <section class="shop-product-main-area">
        <div class="container">
            <div class="shop-product-inner-wrap">
                <div class="shop-product-title">
                    @if(session('successMessage'))
                        <p class="alert alert-success">{{session('successMessage')}}</p>
                    @elseif(session('errorMessage'))
                        <p class="alert alert-danger">{{session('errorMessage')}}</p>
                    @endif
                    <p id="message" class=""></p>
                </div>
                <p>Your Total Bill is: {{$payment}}</p>
                <p>Your Total Token is: {{$payment - $remainingPayment}}</p>
                <p>Your remaininng payment is : {{$remainingPayment}}. Do you agree to pay from Card?</p>
                <form action="{{route('remainingCardPayment')}}" method="post">
                    @csrf
                    <input type="hidden" name="payment" value="{{$payment}}">
                    <input type="hidden" name="remainingPayment" value="{{$remainingPayment}}">
                    <button type="submit" class="btn btn-success">Agree</button>
                </form>
                <a href="#" class="btn btn-secondary">Buy Token</a>
            </div>
        </div>
    </section>
@endsection
