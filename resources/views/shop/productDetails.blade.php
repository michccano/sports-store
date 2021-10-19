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
                                <h4>Available : {{$product->created_at}}</h4>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="product-detail-right">
                                <div class="product_page_title">
                                    <h2>Name: {{$product->name}}</h2>
                                </div>
                                <div class="product_page_p_code">
                                    <h4>Category: {{$product->category->name}}</h4>
                                </div>

                                <div class="product_page_product_price">
                                    @if($product->weekly_price == null)
                                        <h3>Price: {{$product->price}}</h3>
                                    @else
                                        <h4>Single Price: {{$product->price}}</h4>
                                        <h4>Seasonal Price: {{$product->weekly_price}}</h4>
                                    @endif
                                        <h3>Description: </h3><span> {!! $product->description !!}</span>
                                        <b>Delivery Method: <span>{!! $product->delivery_method !!} </span> </b>
                                </div>

                                <div class="add_to_cart_btn_p">
                                    @if($product->weekly_price == null)
                                        @if($cart->where('id',$product->id)->count())
                                            <p id="inCart2" >In Cart</p>
                                            <button id="removeFromCart2" class="btn btn-danger" onclick="removeFromCart2({{$product->id}})">
                                                Remove from Cart</button>
                                            <button id="addCart2" class="btn btn-danger" onclick="addToCart2({{$product->id}})">Add to Cart</button>
                                        @else
                                            <p id="inCart1"  >In Cart</p>
                                            <button id="removeFromCart1" class="btn btn-danger" onclick="removeFromCart({{$product->id}})">
                                                Remove from Cart</button>
                                            <button id="addCart1" class="btn btn-danger" onclick="addToCart({{$product->id}})">Add to Cart</button>
                                        @endif
                                    @else
                                        @if($cart->where('id',$product->id)->count())
                                            <p id="inCart2" >In Cart</p>
                                            <button id="removeFromCart2" class="btn btn-danger" onclick="removeFromCart2({{$product->id}})">
                                                Remove from Cart</button>
                                            <button id="addCart2" class="btn btn-danger" onclick="addToCart2({{$product->id}})">Add to Cart Single</button>
                                            <button id="addCartSeasonal2" class="btn btn-danger" onclick="addToCartSeasonal2({{$product->id}})">Add to Cart Seasonal</button>
                                        @else
                                            <p id="inCart1"  >In Cart</p>
                                            <button id="removeFromCart1" class="btn btn-danger" onclick="removeFromCart({{$product->id}})">
                                                Remove from Cart</button>
                                            <button id="addCart1" class="btn btn-danger" onclick="addToCart({{$product->id}})">Add to Cart Single</button>
                                            <button id="addCartSeasonal1" class="btn btn-danger" onclick="addToCartSeasonal({{$product->id}})">Add to Cart Seasonal</button>
                                        @endif
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
@endsection

@section("scripts")
    <script>
        $('#inCart1').hide();
        $('#removeFromCart1').hide();
        $('#addCart2').hide();
        $('#addCartSeasonal2').hide();


        function addToCart(id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let url = "{{ route('cart.store', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                type: 'GET',
                success: function (data) {
                    $('#inCart1').show();
                    $('#removeFromCart1').show();
                    $('#addCart1').hide();
                    $('#addCartSeasonal1').hide();

                    $('#message').html("Added To Cart");
                    $('#message').attr("class","alert alert-success");
                    $('#cartItemsNumber').html(`Cart<span class="product-count"> ${data}</span>`);;
                },
                error: function () {
                }
            });
        }

        function addToCartSeasonal(id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let url = "{{ route('cart.storeSeasonal', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                type: 'GET',
                success: function (data) {
                    $('#inCart1').show();
                    $('#removeFromCart1').show();
                    $('#addCart1').hide();
                    $('#addCartSeasonal1').hide();
                    $('#message').html("Added To Cart");
                    $('#message').attr("class","alert alert-success");
                    $('#cartItemsNumber').html(`Cart<span class="product-count"> ${data}</span>`);;
                },
                error: function () {
                }
            });
        }

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
                {{--/*url: {{route("cart.store",id)}},*/--}}
                type: 'GET',
                success: function (data) {
                    $('#inCart1').hide();
                    $('#removeFromCart1').hide();
                    $('#addCart1').show();
                    $('#addCartSeasonal1').show();
                    $('#message').html("Remove From Cart");
                    $('#message').attr("class","alert alert-danger");
                    $('#cartItemsNumber').html(`Cart<span class="product-count"> ${data.cartCount}</span>`);
                },
                error: function () {
                }
            });
        }

        function removeFromCart2(id){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let url = "{{ route('cart.remove', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                {{--/*url: {{route("cart.store",id)}},*/--}}
                type: 'GET',
                success: function (data) {
                    $('#inCart2').hide();
                    $('#removeFromCart2').hide();
                    $('#addCart2').show();
                    $('#addCartSeasonal2').show();
                    $('#message').html("Remove From Cart");
                    $('#message').attr("class","alert alert-danger");
                    $('#cartItemsNumber').html(`Cart<span class="product-count"> ${data.cartCount}</span>`);
                },
                error: function () {
                }
            });
        }

        function addToCart2(id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let url = "{{ route('cart.store', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                {{--/*url: {{route("cart.store",id)}},*/--}}
                type: 'GET',
                success: function (data) {
                    $('#inCart2').show();
                    $('#removeFromCart2').show();
                    $('#addCart2').hide();
                    $('#addCartSeasonal2').hide();
                    $('#message').html("Added To Cart");
                    $('#message').attr("class","alert alert-success");
                    $('#cartItemsNumber').html(`Cart<span class="product-count"> ${data}</span>`);
                },
                error: function () {
                }
            });
        }

        function addToCartSeasonal2(id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let url = "{{ route('cart.storeSeasonal', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                {{--/*url: {{route("cart.store",id)}},*/--}}
                type: 'GET',
                success: function (data) {
                    $('#inCart2').show();
                    $('#removeFromCart2').show();
                    $('#addCart2').hide();
                    $('#addCartSeasonal2').hide();
                    $('#message').html("Added To Cart");
                    $('#message').attr("class","alert alert-success");
                    $('#cartItemsNumber').html(`Cart<span class="product-count"> ${data}</span>`);
                },
                error: function () {
                }
            });
        }

        $(function () {
            $(".sp-wrap").smoothproducts();
        });
    </script>
@endsection
