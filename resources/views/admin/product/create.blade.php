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
                            <form action="{{route("storeProduct")}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label >Name</label>
                                        <input type="text" class="form-control" name="name" placeholder="Enter Name" value="{{ old('name') }}">
                                    </div>
                                    <div class="form-group">
                                        <label >Price</label>
                                        <input type="text" class="form-control" name="price" placeholder="Enter Price" value="{{ old('price') }}">
                                    </div>
                                    <div class="form-group">
                                        <label >Image</label>
                                        <input type="file" class="form-control" name="img" placeholder="Enter Image" onchange="previewImage(this)">
                                        <img id="previewImg" style="height: 100px; width: 130px"  />
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

@section("scripts")
    <script>
        $('#previewImg').hide();
        function previewImage(input){
            var file = $("input[type=file]").get(0).files[0];
            if (file){
                var reader = new FileReader()
                reader.onload = function (){
                    $('#previewImg').attr("src",reader.result);
                    $('#previewImg').show();
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
@endsection
