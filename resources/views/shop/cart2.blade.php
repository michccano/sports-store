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
                    @if(session('successMessage'))
                        <p class="alert alert-success">{{session('successMessage')}}</p>
                    @elseif(session('errorMessage'))
                        <p class="alert alert-danger">{{session('errorMessage')}}</p>
                    @endif
                    <p id="message" class=""></p>
                    <h3>Cart</h3>
                </div>
                <div class="shop-product-item-wrap">
                    <div class="row">

                        @foreach($products as $product)
                            <div class="col-md-4" id="product{{$product->id}}">
                                <div class="card" style="width: 18rem;">
                                    <img class="card-img-top" src="{{asset('images/' . $product->options['img'])}}" style="height: 200px; width: 260px">
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
                        @if($hasToken != 1)
                            <a href="#" class="btn btn-info checkoutButton">
                                CCheckout</a>
                            <a id="TokenCheckout1" href="{{route("checkoutWithToken")}}" class="btn btn-info checkoutButton">
                                TokenCheckout</a>
                        @else
                            <a href="{{route("CardCheckout")}}" class="btn btn-info checkoutButton">
                                CCheckout</a>
                        @endif
                    @else
                        <p>Did not added any product to the cart</p>
                    @endif
                    <a id="TokenCheckout2" href="{{route("checkoutWithToken")}}" class="btn btn-info checkoutButton">
                        TokenCheckout</a>
                    <p id="emptyMessage"></p>
                </div>
            </div>
        </div>
    </section>
@endsection

@section("scripts")
    <script>
        $('#TokenCheckout2').hide();
        function removeFromCart(id){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let url = "{{ route('cart.remove', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                type: 'GET',
                success: function (data) {
                    $('#product'+id).hide();
                    if (data.hasToken == 0){
                        $('#TokenCheckout1').hide();
                        $('#TokenCheckout2').show();
                    }

                    $('#message').html("Remove From Cart");
                    $('#message').attr("class","alert alert-danger");
                    $('#cartItemsNumber').html("Cart "+data.cartCount);
                    if (data.cartCount == 0){
                        $('#emptyMessage').html("Removed all products from the cart");
                        $('.checkoutButton').hide();
                    }

                },
                error: function () {
                }
            });
        }
    </script>
@endsection

