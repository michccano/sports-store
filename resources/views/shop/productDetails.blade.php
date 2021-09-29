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
                        <p  class="btn btn-danger">In Cart</p>
                    @else
                        <p id="inCart"  class="btn btn-danger">In Cart</p>
                        <button id="addCart" class="btn btn-danger" onclick="addToCart({{$product->id}})">Add to Cart</button>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection

@section("scripts")
    <script>
        $('#inCart').hide();
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
                    $('#inCart').show();
                    $('#addCart').hide();
                    $('#message').html(data);
                    $('#message').attr("class","alert alert-success");
                },
                error: function () {
                    console.log('error');
                }
            });
        }
    </script>
@endsection
