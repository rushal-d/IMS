@extends('layouts.master')
@section('title','E-Mail Setup')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12 col-md-7 col-xl-7">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i>
                            Email Configuration
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-12">
                                    @if(!empty($email_setup))
                                        <div>
                                            <a href="{{route('emailsetup.edit', $email_setup->id)}}"
                                               class="btn btn-info">
                                                Edit
                                            </a>
                                        </div>
                                        <div class="form-group row">
                                            <label for="start_date" class="col-sm-3 col-form-label">Driver :</label>
                                            <div class="col-sm-9"><h6>{{$email_setup->driver}}</h6></div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="start_date" class="col-sm-3 col-form-label">Host :</label>
                                            <div class="col-sm-9"><h6>{{ $email_setup->host }}</h6></div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="start_date" class="col-sm-3 col-form-label">Port :</label>
                                            <div class="col-sm-9"><h6>{{ $email_setup->port }} </h6></div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="start_date" class="col-sm-3 col-form-label">From Address
                                                :</label>
                                            <div class="col-sm-9"><h6>{{ $email_setup->from_address }}</h6></div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="end_date" class="col-sm-3 col-form-label">From Name :</label>
                                            <div class="col-sm-9"><h6>{{ $email_setup->from_name}}</h6></div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="end_date" class="col-sm-3 col-form-label">Encryption :</label>
                                            <div class="col-sm-9"><h6>{{ $email_setup->encryption}}</h6></div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="end_date" class="col-sm-3 col-form-label">Username :</label>
                                            <div class="col-sm-9"><h6>{{ $email_setup->username}}</h6></div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="code" class="col-sm-3 col-form-label">Password :</label>
                                            {{--<div class="col-sm-9"><h6>{{ $email_setup->password}}</h6></div>--}}
                                        </div>
                                    @else
                                        <form method="post"
                                              action="{{route('emailsetup.store')}}"
                                              enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group row">
                                                <label for="start_date" class="col-sm-3 col-form-label">Driver</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="driver"
                                                           name="driver"
                                                           value="{{ old('driver') }}" data-validation="required">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="start_date" class="col-sm-3 col-form-label">Host</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="host" name="host"
                                                           value="{{ old('host') }}" data-validation="required">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="start_date" class="col-sm-3 col-form-label">Port</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="port"
                                                           name="port"
                                                           value="{{ old('port') }}" data-validation="required">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="start_date" class="col-sm-3 col-form-label">From
                                                    Address</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="from_address"
                                                           name="from_address"
                                                           value="{{ old('from_address') }}" data-validation="required">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="end_date" class="col-sm-3 col-form-label">From Name</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="from_name"
                                                           name="from_name"
                                                           value="{{ old('from_name') }}" data-validation="required">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="end_date" class="col-sm-3 col-form-label">Encryption</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="encryption"
                                                           name="encryption"
                                                           value="{{ old('encryption') }}" data-validation="required">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="end_date" class="col-sm-3 col-form-label">Username</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="username"
                                                           name="username"
                                                           value="{{ old('username') }}" data-validation="required">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="end_date" class="col-sm-3 col-form-label">Password</label>
                                                <div class="col-sm-9">
                                                    <input type="password" class="form-control" id="password"
                                                           name="password"
                                                           value="{{ old('password') }}" data-validation="required">
                                                </div>
                                            </div>
                                            <div style="text-align: center">
                                                <button type="submit" class="btn btn-primary">
                                                    Submit
                                                </button>
                                                <button type="reset" class="btn btn-outline-secondary" value="Reset">
                                                    Clear
                                                </button>
                                            </div>
                                        </form>
                                    @endif
                                </div>
                                <div class="col-xl-5">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $('').nepaliDatePicker({
            npdMonth: true,
            npdYear: true,
            npdYearCount: 10,
            onChange: function (e) {
                $('#effect_date_en').val(BS2AD($('#effect_date').val()));
                $('#valid_date_en').val(BS2AD($('#valid_date').val()));
            }
        });
    </script>
@endsection
