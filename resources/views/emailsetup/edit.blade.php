@extends('layouts.master')
@section('title','Email Setup Edit')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i>
                            Fiscal year
                            <div class="card-header-actions">
                                <a href="#" class="card-header-action btn-minimize" data-toggle="collapse"
                                   data-target="#collapseExamples" aria-expanded="true">
                                    <i class="icon-arrow-up"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div id="maindiv" class="card col-xl-7">
                                    <form method="post"
                                          action="{{route('emailsetup.update',$emailsetup->id)}}"
                                          enctype="multipart/form-data">
                                        @csrf
                                        @method('PATCH')
                                        <div class="form-group row">
                                            <label for="start_date" class="col-sm-3 col-form-label">Driver</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="driver"
                                                       name="driver"
                                                       value="{{ old('driver',$emailsetup->driver) }}"
                                                       data-validation="required">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="start_date" class="col-sm-3 col-form-label">Host</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="host" name="host"
                                                       value="{{ old('host',$emailsetup->host) }}"
                                                       data-validation="required">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="start_date" class="col-sm-3 col-form-label">Port</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="port"
                                                       name="port"
                                                       value="{{ old('port',$emailsetup->port) }}"
                                                       data-validation="required">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="start_date" class="col-sm-3 col-form-label">From
                                                Address</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="from_address"
                                                       name="from_address"
                                                       value="{{ old('from_address',$emailsetup->from_address) }}"
                                                       data-validation="required">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="end_date" class="col-sm-3 col-form-label">From Name</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="from_name"
                                                       name="from_name"
                                                       value="{{ old('from_name',$emailsetup->from_name) }}"
                                                       data-validation="required">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="end_date" class="col-sm-3 col-form-label">Encryption</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="encryption"
                                                       name="encryption"
                                                       value="{{ old('encryption',$emailsetup->encryption) }}"
                                                       data-validation="required">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="end_date" class="col-sm-3 col-form-label">Username</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="username"
                                                       name="username"
                                                       value="{{ old('username',$emailsetup->username) }}"
                                                       data-validation="required">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="end_date" class="col-sm-3 col-form-label">Password</label>
                                            <div class="col-sm-9">
                                                <input type="password" class="form-control" id="password"
                                                       name="password"
                                                       value="{{ old('password') }}" >
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
        $('.nep-date').nepaliDatePicker({
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
