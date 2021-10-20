@extends('layouts.admin')

@section('title', 'Refund Payment')

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
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Refund Payment</h3>
                            </div>
                            @if(session('errorMessage'))
                                <p class="alert alert-danger">{{session('errorMessage')}}</p>
                            @endif

                            <form action="{{route("refund")}}" method="POST">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label >Amount</label>
                                        <input type="text" class="form-control" name="amount" placeholder="Enter Amount" value="{{ old('amount') }}">
                                    </div>
                                    <div class="form-group">
                                        <label >Transaction Reference</label>
                                        <input type="text" class="form-control" name="transactionReference"
                                               placeholder="Enter Transaction Reference" value="{{ old('transactionReference') }}">
                                    </div>
                                    <div class="form-group">
                                        <label >Card Number</label>
                                        <input type="text" class="form-control" name="cc_number"
                                               placeholder="Enter Last Four Card Digit" value="{{ old('cc_number') }}">
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="form-control btn-info" >Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
@endsection
