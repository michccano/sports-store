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
                        @if(session('message'))
                            <p class="alert alert-danger">{{session('message')}}</p>
                        @endif
                        <h3>Cart</h3>
                    </div>
                    <div class="shop-product-item-wrap">
                        <div class="row">

                            @foreach($products as $product)
                                <div class="col-md-4">
                                    <div class="card" style="width: 18rem;">
                                        <img class="card-img-top" src="{{asset('images/' . $product->options['img'])}}" style="height: 200px; width: 260px">
                                        <div class="card-body">
                                            <h5 class="card-title">Name: {{$product->name}}</h5>
                                            <p class="card-text">Price: {{$product->price}}</p>
                                            <p class="card-text">Quantuty: {{$product->qty}}</p>
                                            <form action="{{route("cart.remove")}}" method="post">
                                                @csrf
                                                <input type="hidden" name="rowId" value="{{$product->rowId}}">
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <br>
                        @if(count($products) >0)
                            <a href="{{route("cart.checkout")}}" class="btn btn-info">Checkout</a>
                        @else
                            <p>Did not added any product to the cart</p>
                        @endif
                    </div>
                </div>
            </div>
        </section>
@endsection

