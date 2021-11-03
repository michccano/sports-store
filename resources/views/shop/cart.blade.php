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
                                                <span class="" id="price{{$product->id}}"> {{$product->price * $product->qty}}</span>
                                            </span>
                                        </td>
                                        <td class="product-quantity" data-title="Quantity">
                                            <div class="quantity">
                                                <button class="btn" id="decrement-btn{{$product->id}}" type=button  onclick="button2({{$product->id}})" ><i class="fal fa-minus"></i></button>
                                                <input type="text" id="qty-input{{$product->id}}" value="{{$product->qty}}" min="1" max="10" maxlength="2"/>
                                                <button class="btn" id="increment-btn{{$product->id}}" type=button  onclick="button1({{$product->id}})" ><i class="fal fa-plus"></i></button>
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
                                    <div class="col-md-12">
                                        <div class="coupon-right checkoutButton">
                                            <div class="hero-button-area">
                                                <a id="TokenCheckout1" href="{{route("checkoutWithToken")}}" class="btn btn-info checkoutButton">TokenCheckout</a>
                                            </div>
                                            <div class="hero-button-area">
                                                <a href="{{route("checkProductCategory")}}" class="btn btn-info checkoutButton"> CCheckout</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                                @else
                                    <div class="coupon-right checkoutButton">
                                        <div class="hero-button-area">
                                            <a id="TokenCheckout2" href="{{route("checkoutWithToken")}}" class="btn btn-info checkoutButton">
                                                TokenCheckout</a>
                                        </div>
                                        <div class="hero-button-area">
                                            <a href="{{route("cardPayment")}}" class="btn btn-info checkoutButton">
                                                CCheckout</a>
                                        </div>
                                    </div>
                                @endif
                            @else
                                <p>Did not added any product to the cart</p>
                            @endif
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
                    $('#cartItemsNumber').html(`Cart<span class="product-count"> ${data.cartCount}</span>`);
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
        function button1(id) {

            var incre_value = $('#qty-input'+id).val();
            var value = parseInt(incre_value, 10);
            value = isNaN(value) ? 0 : value;
            if(value<100){
                value++;
                $('#qty-input'+id).val(value);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                let url = "{{ route('update', ':id') }}";
                url = url.replace(':id', id);
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {qty: value},
                    success: function (data) {
                            $('#price'+id).html(data);
                    },
                    error: function () {
                    }
                });
            }
        }
        function button2(id) {
            var decre_value = $('#qty-input'+id).val();
            var value = parseInt(decre_value, 10);
            value = isNaN(value) ? 0 : value;
            if(value>1){
                value--;
                $('#qty-input'+id).val(value);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                let url = "{{ route('update', ':id') }}";
                url = url.replace(':id', id);
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {qty: value},
                    success: function (data) {
                        $('#price'+id).html(data);
                    },
                    error: function () {
                    }
                });
            }
        }
    </script>
@endsection

