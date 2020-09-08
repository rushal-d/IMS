@extends('layouts.master')
@section('title','User Edit')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" data-background-color="custom-color">
                        <h6 class="title"><i class="far fa-plus-square"></i> Edit Users</h6>
                    </div>
                    <div class="row">
                        <div class="col-lg-8 col-md-offset-2">
                                <form method="post" action="{{ route('user.update',$user->id) }}"
                                      enctype="multipart/form-data"
                                      id="maindiv">
                                    {{method_field('PATCH')}}
                                    @csrf
                                    <div class="form-group col-md-12 row">
                                        <label for="name" class="col-md-2">User Name </label>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control" id="user_name"
                                                   name="name" placeholder="Enter User Name"
                                                   data-validation="required" value="{{ $user->name }}">
                                        </div>
                                    </div>
                                    <div class="form-group row col-md-12">
                                        <label for="display_name" class="col-md-2">Email Address</label>
                                        <div class="col-md-10">
                                            <input type="email" class="form-control" id="email"
                                                   name="email" placeholder="Enter Email"
                                                   value="{{ $user->email }}"
                                                   data-validation="required email">
                                            </div>
                                        </div>
                                    <div class="form-group row col-md-12">
                                            <label for="display_name" class="col-md-2">Password</label>
                                            <div class="col-md-10">
                                                <input type="password" class="form-control" name="password"
                                                       placeholder="Enter Password"
                                                       data-validation-error-msg="Please enter the password">

                                            </div>
                                        </div>
                                     <div class="form-group row col-md-12">
                                            <label for="display_name" class="col-md-2">Confirm Password</label>
                                            <div class="col-md-10">
                                                <input type="password" class="form-control" name="password_confirmation"
                                                       placeholder="Enter Password"
                                                       data-validation-error-msg="Please enter the password">

                                            </div>
                                        </div>
                                        @role('administrator')
                                        <div class="form-group row col-md-12">
                                            <label for="role" class="col-md-2">Roles</label>
                                            <div class="col-md-10">
                                                @foreach($roles as $role)
                                                    <input type="checkbox" value="{{$role->id}}"
                                                           name="roles[]" {{in_array($role->id, $userRoles) ? "checked" : null}}>{{ $role->name }}
                                                @endforeach
                                            </div>
                                        </div>
                                        @endrole
                                    <div style="text-align: center">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                        <button type="reset" class="btn btn-outline-secondary" value="Reset">Cancel
                                        </button>
                                    </div>
                                </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

@endsection
