@extends('layouts.auth')

@section('title', 'Edit Information')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Edit Information</h3>
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
                        <form action="{{route("updateInfo")}}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label >First Name</label>
                                            <input type="text" class="form-control" name="firstname"
                                                   placeholder="Enter Name" value="{{ $member->firstname }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label >Last Name</label>
                                            <input type="text" class="form-control" name="lastname"
                                                   placeholder="Enter Name" value="{{ $member->lastname }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label >Email</label>
                                            <input type="email" class="form-control" name="email"
                                                   placeholder="Enter Email Address" value="{{ $member->email }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label >Address1</label>
                                            <input type="text" class="form-control" name="address1"
                                                   placeholder="Enter Address1" value="{{ $member->address1}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label >Address2</label>
                                            <input type="text" class="form-control" name="address2"
                                                   placeholder="Enter Address2" value="{{ $member->address2 }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label >City</label>
                                            <input type="text" class="form-control" name="city"
                                                   placeholder="Enter City" value="{{ $member->city }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label >State</label>
                                            <input type="text" class="form-control" name="state"
                                                   placeholder="Enter State" value="{{ $member->state }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label >Postal Code</label>
                                            <input type="text" class="form-control" name="postal"
                                                   placeholder="Enter Postal Code" value="{{ $member->postal }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label >Country</label>
                                            <input type="text" class="form-control" name="country"
                                                   placeholder="Enter Country" value="USA (united states)">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label >Day Phone</label>
                                            <input type="text" class="form-control" name="dayphone"
                                                   placeholder="Enter Day Phone" value="{{ $member->dayphone }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label >Eve Phone</label>
                                            <input type="text" class="form-control" name="evephone"
                                                   placeholder="Enter Eve Phone" value="{{ $member->evephone }}">
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Edit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </div>
@endsection
