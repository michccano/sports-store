@extends('layouts.app')

@section('title', 'Cart')

@section('content')
<div class="container">
    @if(session('message'))
        <p>{{session('message')}}</p>
    @endif
    <div class="row">

        @foreach($products as $product)
            <div class="col-md-4">
                <div class="card" style="width: 18rem;">
                    <img class="card-img-top" src="..." alt="Card image cap">
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
@endsection

