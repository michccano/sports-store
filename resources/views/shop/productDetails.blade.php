@extends('layouts.mainApp')

@section('title', 'Product Info')

@section('content')
    <section class="shop-category-main-area">
        <div class="container">
            <div class="shop-category-inner-wrap">
                <div class="shop-category-title">
                    <h3>Product Info</h3>
                </div>
            </div>
        </div>
    </section>
    <section class="product_page_wrap sticky_header">
        <div class="container-xxl container g-0">
            <div class="product_inner_page">
                <!-- product details top  -->
                <div class="product_page_content">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="product-detail-left">
                                <div class="sp-wrap">
                                    <a href="{{asset('images/' . $product->img)}}"><img src="{{asset('images/' . $product->img)}}"
                                            alt=""></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="product-detail-right">
                                <div class="product_page_title">
                                    <h2>Name: {{$product->name}}</h2>
                                </div>
                                <div class="product_page_p_code">
                                    <h4>Category: Sports</h4>
                                </div>

                                <div class="product_page_product_price">
                                    <h3>Price: {{$product->price}}</h3>
                                    <span>Description: {!! $product->description !!}</span>
                                </div>
                                <div class="product_page_select_product">
                                    <div class="product_page_product_quantity">
                                        <label for="cars">Quantity:</label>
                                        <select id="cars">
                                            <option value="volvo" selected>Only</option>
                                            <option value="saab">Saab</option>
                                            <option value="vw">VW</option>
                                            <option value="audi">Audi</option>
                                        </select>
                                    </div>

                                </div>
                                <div class="add_to_cart_btn_p">
                                @if($cart->where('id',$product->id)->count())
                                    <button id="inCart2" class="btn btn-info">In Cart</button>
                                    <button id="removeFromCart2" class="btn btn-danger" onclick="removeFromCart2({{$product->id}})">
                                        Remove from Cart</button>
                                    <button id="addCart2" class="btn btn-danger" onclick="addToCart2({{$product->id}})">Add to Cart</button>
                                @else
                                    <button id="inCart1"  class="btn btn-info">In Cart</button>
                                    <button id="removeFromCart1" class="btn btn-danger" onclick="removeFromCart({{$product->id}})">
                                        Remove from Cart</button>
                                    <button id="addCart1" class="btn btn-danger" onclick="addToCart({{$product->id}})">Add to Cart</button>
                                @endif

                                </div>

                            </div>
                        </div>

                    </div>
                </div>
                <!-- product details top  -->
            </div>
        </div>
    </section>
    <section class="shop-product-main-area">
        <div class="container">
            <div class="card">
                <p id="message" class=""></p>
            <img class="card-img-top" src="{{asset('images/' . $product->img)}}" style="height: 400px; width: 360px">
                <div class="card-body">
                    <h5 class="card-title">Name: {{$product->name}}</h5>
                    <p class="card-text">Price: {{$product->price}}</p>
                    <p class="card-text">Description: {!! $product->description !!}</p>
                    <p class="card-text">To order click on ADD TO CART below or call
                    954.377.8000</p>
                    @if($cart->where('id',$product->id)->count())
                        <button id="inCart2" class="btn btn-info">In Cart</button>
                        <button id="removeFromCart2" class="btn btn-danger" onclick="removeFromCart2({{$product->id}})">
                            Remove from Cart</button>
                        <button id="addCart2" class="btn btn-danger" onclick="addToCart2({{$product->id}})">Add to Cart</button>
                    @else
                        <button id="inCart1"  class="btn btn-info">In Cart</button>
                        <button id="removeFromCart1" class="btn btn-danger" onclick="removeFromCart({{$product->id}})">
                            Remove from Cart</button>
                        <button id="addCart1" class="btn btn-danger" onclick="addToCart({{$product->id}})">Add to Cart</button>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection

@section("scripts")
    <script>
        $('#inCart1').hide();
        $('#removeFromCart1').hide();
        $('#addCart2').hide();
        function addToCart(id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: 'http://localhost:8000/cart/store/'+id,
                {{--/*url: {{route("cart.store",id)}},*/--}}
                type: 'GET',
                success: function (data) {
                    $('#inCart1').show();
                    $('#removeFromCart1').show();
                    $('#addCart1').hide();
                    $('#message').html("Added To Cart");
                    $('#message').attr("class","alert alert-success");
                    $('#cartItemsNumber').html("Cart "+data);
                },
                error: function () {
                    console.log('error');
                }
            });
        }

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
                    $('#inCart1').hide();
                    $('#removeFromCart1').hide();
                    $('#addCart1').show();
                    $('#message').html("Remove From Cart");
                    $('#message').attr("class","alert alert-danger");
                    $('#cartItemsNumber').html("Cart "+data);
                },
                error: function () {
                    console.log('error');
                }
            });
        }

        function removeFromCart2(id){
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
                    $('#inCart2').hide();
                    $('#removeFromCart2').hide();
                    $('#addCart2').show();
                    $('#message').html("Remove From Cart");
                    $('#message').attr("class","alert alert-danger");
                    $('#cartItemsNumber').html("Cart "+data);
                },
                error: function () {
                    console.log('error');
                }
            });
        }

        function addToCart2(id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: 'http://localhost:8000/cart/store/'+id,
                {{--/*url: {{route("cart.store",id)}},*/--}}
                type: 'GET',
                success: function (data) {
                    $('#inCart2').show();
                    $('#removeFromCart2').show();
                    $('#addCart2').hide();
                    $('#message').html("Added To Cart");
                    $('#message').attr("class","alert alert-success");
                    $('#cartItemsNumber').html("Cart "+data);
                },
                error: function () {
                    console.log('error');
                }
            });
        }
        $(function () {
            $(".sp-wrap").smoothproducts();
        });
    </script>
@endsection
