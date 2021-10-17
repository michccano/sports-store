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
                    <form action="{{ route('charge') }}" method="post">
                        @csrf
                        <p><input type="hidden" name="amount" placeholder="Enter Amount" value="{{$payment}}" /></p>
                        <p><input type="text" name="cc_number" placeholder="Card Number" /></p>
                        <p><input type="text" name="expiry_month" placeholder="Month" /></p>
                        <p><input type="text" name="expiry_year" placeholder="Year" /></p>
                        <p><input type="text" name="cvv" placeholder="CVV" /></p>
                        <input type="submit" name="submit" value="Submit" />
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

