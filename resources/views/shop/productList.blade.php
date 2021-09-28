@extends('layouts.app')

@section('title', 'Shop')

@section('content')
<div class="container">
    @if(session('message'))
        <p>{{session('message')}}</p>
    @endif
    <div class="row">

        @foreach($products as $product)
        <div class="col-md-4">
            <div class="card" style="width: 18rem;">
                <img class="card-img-top" src="{{asset('images/' . $product->img)}}" style="height: 200px; width: 260px">
                <div class="card-body">
                    <h5 class="card-title">{{$product->name}}</h5>
                    <p class="card-text">{{$product->price}}</p>
                    @if($cart->where('id',$product->id)->count())
                        <b>In Cart</b>
                    @else
                    <form action="{{route("cart.store")}}" method="post">
                        @csrf
                        <input type="hidden" name="product_id" value="{{$product->id}}">
                        <button type="submit" class="btn btn-primary">Add to cart</button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
