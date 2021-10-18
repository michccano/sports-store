@extends('layouts.admin')

@section('title', 'Order Details')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Order Details</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <p><b>Invoice No: </b>{{$order->invoice}}</p>
                                <p><b>Customer Name : </b>{{$order->user->firstname}} {{$order->user->lastname}}</p>
                                <p><b>Total Bill: </b>{{$order->total_bill}}</p>
                                <p><b>Card Payment: </b>{{$order->card_payment_amount}}</p>
                                <p><b>Token Payment: </b>{{$order->token_payment_amount}}</p>
                                <b>Products Details :</b>
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Purchase Type</th>
                                    </thead>
                                    <tbody>
                                    @foreach($order->products as $product)
                                        <tr>
                                            <td>{{$product->name}}</td>
                                            <td>{{$product->pivot->price}}</td>
                                            <td>{{$product->pivot->quantity}}</td>
                                            <td>{{$product->pivot->type}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                            </div>
                            <div class="card-footer">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

