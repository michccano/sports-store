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
                            <!-- form start -->
                            <form action="{{route("storeProduct")}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" class="form-control" name="name" placeholder="Enter Name" value="{{ old('name') }}">
                                    </div>
                                    <div class="form-group">
                                        <label >Description</label>
                                        <textarea class="form-control description" name="description" placeholder="Enter Description" value="">{{ old('description') }}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label >Image</label>
                                        <input type="file" class="form-control" name="img" placeholder="Enter Image" onchange="previewImage(this)">
                                        <img id="previewImg" style="height: 100px; width: 130px"  />
                                    </div>

                                    <div class="form-group">
                                        <label >Document</label>
                                        <input type="file" class="form-control" name="file">
                                    </div>

                                    <div class="form-group">
                                        <label >Display Date</label>
                                        <input type="date" class="form-control" name="display_date"  value="{{ $today }}">
                                    </div>
                                    <div class="form-group">
                                        <label >Product Expire Date</label>
                                        <input type="date" class="form-control" name="expire_date"  value="{{ old('expire_date') }}">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label >Season Price</label>
                                                <input type="text" class="form-control" name="price" placeholder="Enter Season Price" value="{{ old('price') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label >Expire Date</label>
                                                <input type="date" class="form-control" name="season_price_expire_date"  value="{{ old('season_price_expire_date') }}">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                       <div class="col-md-6">
                                           <div class="form-group">
                                               <label >Single/Weekly Price</label>
                                               <input type="text" class="form-control" name="weekly_price" placeholder="Enter Single Price" value="{{ old('weekly_price') }}">
                                           </div>
                                       </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label >Expire Date</label>
                                                <input type="date" class="form-control" name="weekly_price_expire_date"  value="{{ old('weekly_price_expire_date') }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label >Category</label>
                                        <select name="category" class="form-control">
                                            @foreach($categories as $category)
                                                <option value="{{$category->id}}">{{$category->name}}</option>
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
    {{--<script src="{{ asset('node_modules/tinymce/tinymce.js') }}"></script>--}}
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
