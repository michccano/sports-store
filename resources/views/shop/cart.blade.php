<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bootstrap Card</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-sm bg-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="{{route("shop")}}">Shop</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route("cart.show")}}">Cart</a>
        </li>
    </ul>
</nav>
<br>
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
</body>
</html>
