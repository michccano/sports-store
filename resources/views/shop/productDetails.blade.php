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

            let url = "{{ route('cart.store', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                url: url,
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
                    $('#message').html("Remove From Cart");
                    $('#message').attr("class","alert alert-danger");
                    $('#cartItemsNumber').html("Cart "+data);
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
                    $('#message').html("Remove From Cart");
                    $('#message').attr("class","alert alert-danger");
                    $('#cartItemsNumber').html("Cart "+data);
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
                    $('#message').html("Added To Cart");
                    $('#message').attr("class","alert alert-success");
                    $('#cartItemsNumber').html("Cart "+data);
                },
                error: function () {
                }
            });
        }
    </script>
@endsection
