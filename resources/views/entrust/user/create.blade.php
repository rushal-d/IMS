@extends('layouts.master')
@section('title','User Create')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" data-background-color="custom-color">
                        <h6><i class="far fa-plus-square"></i> Add Users</h6>
                    </div>
                    <div class="row">
                        <div class="col-lg-8 col-md-offset-2">
                            <form method="post" action="{{ route('user.store') }}" enctype="multipart/form-data" id="maindiv">
                                @csrf
                                <div class="form-group row col-md-12">
                                    <label for="name" class="col-md-2">User Name</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="user_name"
                                               name="name" placeholder="Enter User Name"
                                               data-validation="required" value="{{ old('name') }}">
                                    </div>
                                </div>
                                <div class="form-group row col-md-12">
                                    <label for="display_name" class="col-md-2">Email Address</label>
                                    <div class="col-md-8">
                                        <input type="email" class="form-control" id="email"
                                               name="email" placeholder="Enter Email"
                                               value="{{ old('email') }}"
                                               data-validation="required email">
                                    </div>
                                </div>
                                <div class="form-group row col-md-12">
                                        <label for="display_name" class="col-md-2">Password</label>
                                        <div class="col-md-8">
                                            <input type="password" class="form-control" name="password"
                                                   placeholder="Enter Password" data-validation="required">
                                        </div>
                                    </div>
                                <div class="form-group row col-md-12">
                                    <label for="display_name" class="col-md-2">Confirm Password</label>
                                    <div class="col-md-8">
                                            <input type="password" class="form-control" name="password_confirmation"
                                                   placeholder="Enter Password" data-validation="required">
                                        </div>
                                    </div>
                                <div class="form-group row col-md-12">
                                    <label for="role" class="col-md-2">Roles</label>
                                    <div class="col-md-10">
                                        @foreach($roles as $role)
                                            <input type="checkbox" value="{{$role->id}}" name="roles[]">{{ $role->name }}
                                        @endforeach
                                    </div>
                                </div>
                                <div style="text-align: center">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <button type="reset" class="btn btn-outline-secondary" value="Reset">Cancel
                                    </button>
                                </div>
                            </form>
                            {{--form end--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
