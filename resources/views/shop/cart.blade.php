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
        <div class="container">
            <div class="cart-product-inner-wrap">
                <div class="cart-product-top">
                    <form class="product-cart-form" action="" method="post">
                        <div class="cart-product-table-wrapper">
                            <table class="cart-product-form__contents" cellspacing="0">
                            @foreach($products as $product)
                                <tbody>
                                    <tr class="product-cart-form__cart-item">
                                        <td class="product-thumbnail"> <a href="">
                                        <img class="card-img-top" src="{{asset('images/' . $product->options['img'])}}" >
                                            </a></td>
                                        <td class="product-name" data-title="Product">
                                            <a href="">Name: {{$product->name}}</a>
                                        </td>
                                        <td class="product-price" data-title="Price">
                                            <span class="">
                                                <span class="">Price: {{$product->price}}</span>
                                            </span>
                                        </td>
                                        <td class="product-quantity" data-title="Quantity">
                                            <div class="quantity">
                                                <input type="number" id="" class="input-text " step="1" name=""
                                                    value="1" placeholder="" inputmode="numeric">
                                            </div>
                                        </td>
                                        <td class="product-subtotal" data-title="Total">
                                            <span class="product-Price-amount amount">Quantuty: {{$product->qty}}</span>
                                        </td>
                                        <td class="product-remove">
                                            <a href="" class="remove">
                                            <button onclick="removeFromCart({{$product->id}})" class="btn btn-danger"><i class="fa fa-times"></i></button>

                                            </a>
                                        </td>
                                    </tr>

                                </tbody>
                                @endforeach
                            </table>

                            <div class="coupon-area">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="coupon-left">
                                            <input type="text" placeholder="Coupon code">
                                            <button>Apply</button>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="coupon-right">
                                            <div class="hero-button-area">
                                                <a href="#">Update Cart</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if(count($products) >0)
                                <a href="{{route("cart.checkout")}}" class="btn btn-info" id="checkoutButton">
                                    Checkout</a>
                                @else
                                    <p>Did not added any product to the cart</p>
                                @endif
                            <p id="emptyMessage"></p>
                        </div>
                    </form>
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
                type: 'post',
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

