@extends('layouts.admin')

@section('title', 'Edit Product')

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
                            @if(count($errors) > 0 )
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <ul class="p-0 m-0" style="list-style: none;">
                                        @foreach($errors->all() as $error)
                                            <li>{{$error}}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form action="{{route("updateProduct",$product->id)}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label >Name</label>
                                        <input type="text" class="form-control" name="name"
                                               placeholder="Enter Name" value="{{$product->name}}">
                                    </div>
                                    <div class="form-group">
                                        <label >Description</label>
                                        <textarea class="form-control description" name="description"
                                                  placeholder="Enter Description" value="">{!! $product->description !!}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label >Price</label>
                                        <input type="text" class="form-control" name="price"
                                               placeholder="Enter Price" value="{{$product->price}}">
                                    </div>
                                    <div class="form-group">
                                        <label >Image</label>
                                        <input type="file" class="form-control" name="img" placeholder="Enter Image"
                                               onchange="previewImage(this)">
                                        <img id="previewImg" style="height: 100px; width: 130px" src="{{asset('images/' . $product->img)}}" />
                                    </div>
                                    <div class="form-group">
                                        <label >Status</label>
                                        <select name="status" class="form-control">
                                            <option>Active</option>
                                            <option>Inactive</option>
                                        </select>
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
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script type="text/javascript">
        tinymce.init({
            selector:'textarea.description',
            height: 300,
            menubar: true,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code help wordcount'
            ],
            toolbar: 'undo redo | formatselect | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help',
            content_css: '//www.tiny.cloud/css/codepen.min.css'
        });
    </script>
    <script>
        function previewImage(input){
            var file = $("input[type=file]").get(0).files[0];
            if (file){
                var reader = new FileReader()
                reader.onload = function (){
                    $('#previewImg').attr("src",reader.result);
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
@endsection
