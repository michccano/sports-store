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
                                                  placeholder="Enter Description" >{!! $product->description !!}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label >Image</label>
                                        <input type="file" class="form-control" name="img" placeholder="Enter Image"
                                               onchange="previewImage(this)">
                                        <img id="previewImg" style="height: 100px; width: 130px" src="{{asset('images/' . $product->img)}}" />
                                    </div>

                                    <div class="row">
                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <label >Document</label>
                                                <input type="file" class="form-control" name="file" id="file">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label ></label>
                                                <br>
                                                <a class="btn-danger form-control" style="text-align: center" onclick="document.getElementById('file').value = ''">
                                                    Remove</a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-1">
                                                <input type="checkbox" id="remember" name="delete_document"
                                                       value="1" {{ old('delete_document') ? 'checked' : '0' }}>
                                            </div>
                                            <div class="col-md-6">
                                                <label >Remove Existing Document</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label >Display Date</label>
                                        <input type="date" class="form-control" name="display_date"  value="{{ $product->display_date }}">
                                    </div>

                                    <div class="form-group">
                                        <label >Product Expire Date</label>
                                        <input type="date" class="form-control" name="expire_date"  value="{{$product->expire_date}}">
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label >Season Price</label>
                                                <input type="text" class="form-control" name="price"
                                                       placeholder="Enter Season Price" value="{{$product->price}}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label >Expire Date</label>
                                                <input type="date" class="form-control" name="season_price_expire_date"  value="{{ $product->season_price_expire_date }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label >Single/Weekly Price</label>
                                                <input type="text" class="form-control" name="weekly_price"
                                                       placeholder="Enter Price" value="{{$product->weekly_price}}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label >Expire Date</label>
                                                <input type="date" class="form-control" name="weekly_price_expire_date"  value="{{ $product->weekly_price_expire_date }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label >Category</label>
                                        <select name="category" class="form-control">
                                            @foreach($categories as $category)
                                                @if($category->name == $product->category->name)
                                                    <option value="{{$category->id}}" selected>{{$category->name}}</option>
                                                @else
                                                <option value="{{$category->id}}">{{$category->name}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label >Delivery Method</label>
                                        <select name="delivery_method" class="form-control">
                                            <option>Online</option>
                                            <option>Email</option>
                                        </select>
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
    <script src="https://cdn.tiny.cloud/1/jc9qegq89pzzpomshmsl4xqcjx9w53rv2or1obd5uyds5lrf/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
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
