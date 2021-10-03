@extends('layouts.mainApp')

@section('title', 'Cart')

@section('content')
        <section class="shop-category-main-area">
            <div class="container">
                <div class="shop-category-inner-wrap">
                    <div class="shop-category-title">
                        <h3>Cart</h3>
                    </div>
                </div>
            </div>
        </section>
        <section class="shop-product-main-area">
            <div class="container">
                <div class="shop-product-inner-wrap">
                    <div class="shop-product-title">
                        <p id="message" class=""></p>
                        <h3>Cart</h3>
                    </div>
                    <div class="shop-product-item-wrap">
                        <div class="row">

                            @foreach($products as $product)
                                <div class="col-md-4" id="product{{$product->id}}">
                                    <div class="card" style="width: 18rem;">
                                        <img class="card-img-top" src="{{asset('images/' . $product->options['img'])}}" >
                                        <div class="card-body">
                                            <h5 class="card-title">Name: {{$product->name}}</h5>
                                            <p class="card-text">Price: {{$product->price}}</p>
                                            <p class="card-text">Quantuty: {{$product->qty}}</p>
                                            <button onclick="removeFromCart({{$product->id}})" class="btn btn-danger">Remove from Cart</button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <br>
                        @if(count($products) >0)
                            <a href="{{route("cart.checkout")}}" class="btn btn-info" id="checkoutButton">
                                Checkout</a>
                        @else
                            <p>Did not added any product to the cart</p>
                        @endif
                        <p id="emptyMessage"></p>
                    </div>
                </div>
            </div>
        </section>
@endsection

@section("scripts")
    <script>
        function removeFromCart(id){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: 'http://localhost:8000/cart/delete/'+id,
                {{--/*url: {{route("cart.store",id)}},*/--}}
                type: 'GET',
                success: function (data) {
                    $('#product'+id).hide();
                    $('#message').html("Remove From Cart");
                    $('#message').attr("class","alert alert-danger");
                    $('#cartItemsNumber').html("Cart "+data);
                    if (data == 0){
                        $('#emptyMessage').html("Removed all products from the cart");
                        $('#checkoutButton').hide();
                    }

                },
                error: function () {
                    console.log('error');
                }
            });
        }
    </script>
@endsection

