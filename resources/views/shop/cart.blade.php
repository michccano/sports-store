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
        <section class="cart-product-body">
        <div class="container-md container-fluid">
            <div class="cart-product-inner-wrap">
                <div class="cart-product-top">
                    @if(session('successMessage'))
                        <p class="alert alert-success">{{session('successMessage')}}</p>
                    @elseif(session('errorMessage'))
                        <p class="alert alert-danger">{{session('errorMessage')}}</p>
                    @endif
                    <p id="message" class=""></p>
                        <div class="cart-product-table-wrapper">
                            <table class="cart-product-form__contents" cellspacing="0">
                                <tbody>
                                @foreach($products as $product)
                                    <tr class="product-cart-form__cart-item" id="product{{$product->id}}">
                                        <td class="product-thumbnail"> <a href="">
                                        <img class="card-img-top" src="{{asset('images/' . $product->options['img'])}}" >
                                            </a></td>
                                        <td class="product-name" data-title="Product">
                                            <a href="">Name: {{$product->name}}</a>
                                        </td>
                                        <td class="product-price" data-title="Price">
                                            <span class="">
                                                <span class=""> {{$product->price}}</span>
                                            </span>
                                        </td>
                                        <td class="product-quantity" data-title="Quantity">
                                            <div class="quantity">
                                                <button class="btn" type=button  onclick="button2()" ><i class="fal fa-minus"></i></button>
                                                <span id="output-area">{{$product->qty}}</span>
                                                <button class="btn" type=button  onclick="button1()" ><i class="fal fa-plus"></i></button>

                                            </div>
                                        </td>
                                        <td class="product-subtotal" data-title="Total">

                                        </td>
                                        <td class="product-remove">
                                            <a class="remove">
                                            <button onclick="removeFromCart({{$product->id}})" class="btn btn-danger"><i class="fa fa-times"></i></button>

                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            @if(count($products) >0)
                                @if($hasToken != 1)
                            <div class="coupon-area">
                                <div class="row">
                                    <!-- <div class="col-md-6">
                                        <div class="coupon-left">
                                            {{--<input type="text" placeholder="Coupon code">
                                            <button>Apply</button>--}}
                                        </div>
                                    </div> -->
                                    <div class="col-md-12">
                                        <div class="coupon-right checkoutButton">
                                            <div class="hero-button-area">
                                                <!-- <a href="#">Update Cart</a> -->
                                                <a href="{{route("CardCheckout")}}" class="btn btn-info checkoutButton"> CCheckout</a>
                                            </div>
                                            <div class="hero-button-area">
                                                <!-- <a href="#">Update Cart</a> -->
                                                <a id="TokenCheckout1" href="{{route("checkoutWithToken")}}" class="btn btn-info checkoutButton">TokenCheckout</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


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
    <script>
        var x = 0;
        document.getElementById('output-area').innerHTML = x;
        function button1() {
        document.getElementById('output-area').innerHTML = ++x;
        }
        function button2() {
        document.getElementById('output-area').innerHTML = --x;
        }
    </script>
@endsection

