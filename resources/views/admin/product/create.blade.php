@extends('layouts.admin')

@section('title', 'Create Product')

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
                                <h3 class="card-title">Create New Product</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form action="{{route("storeProduct")}}" method="POST">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label >Name</label>
                                        <input type="text" class="form-control" name="name" placeholder="Enter Name">
                                    </div>
                                    <div class="form-group">
                                        <label >Price</label>
                                        <input type="text" class="form-control" name="price" placeholder="Enter Price">
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
