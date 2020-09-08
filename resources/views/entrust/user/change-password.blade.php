@extends('admin.layouts.app',['crumbroute' => 'vehicle-create'])
@section('title','User Change Password')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" data-background-color="custom-color">
                        <h5 class="title"><i class="far fa-plus-square"></i> Edit Users</h5>
                        <p class="category">
                            Edit Users
                        </p>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                    </div>
                    <div class="row">
                        <div class="col-lg-8 col-md-offset-2">
                            {{--form start--}}
                            <form method="post" action="{{ route('user-password-update',$user->id) }}"
                                  enctype="multipart/form-data"
                                  id="user-form">
                                {{method_field('PATCH')}}

                                @csrf
                                <div class="form-group col-md-12 row">
                                    <label for="name" class="col-md-2">User Name </label>
                                    <div class="col-md-10">

                                        <p>
                                            {{ $user->name }}
                                        </p>


                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="display_name" class="col-md-2">Email Address</label>
                                        <div class="col-md-10">
                                           <p>{{ $user->email }}</p>

                                        </div>
                                    </div>
                                </div>
                                @role('administrator')
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="display_name" class="col-md-2">Password</label>
                                            <div class="col-md-10">
                                                <input type="password" class="form-control" name="password"
                                                       placeholder="Enter Password" data-validation="required"
                                                       data-validation-error-msg="Please enter the password">
                                                <small class="form-text text-muted"><span class="label label-warning">* Required Field</span>
                                                </small>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="display_name" class="col-md-2">Confirm Password</label>
                                            <div class="col-md-10">
                                                <input type="password" class="form-control" name="password_confirmation"
                                                       placeholder="Enter Password" data-validation="required"
                                                       data-validation-error-msg="Please enter the password">
                                                <small class="form-text text-muted"><span class="label label-warning">* Required Field</span>
                                                </small>

                                            </div>
                                        </div>
                                    </div>
                                @endrole

                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="role" class="col-md-2">Roles</label>
                                        <div class="col-md-10">

                                            @foreach($roles as $role)

                                                <input type="checkbox" value="{{$role->id}}"
                                                       name="roles[]" {{in_array($role->id, $userRoles) ? "checked" : null}}>{{ $role->name }}
                                            @endforeach
                                        </div>
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
    <style>
        span.help-block.form-error {
            display: block;
            position: initial;
        }
    </style>
@endsection

@section('scripts')

@endsection
