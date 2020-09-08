@extends('layouts.master')
@section('title',' Staff')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-xl-5">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i>
                            Staff
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-12">

                                    <div class="form-group row">
                                        <label for="start_date" class="col-sm-4 col-form-label"><sup
                                                    class="required-field">*</sup>Staff Name</label>
                                        <div class="col-sm-8">
                                            {{$staff->name}}
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="start_date" class="col-sm-4 col-form-label"><sup
                                                    class="required-field">*</sup>Branch</label>
                                        <div class="col-sm-8">
                                            {{$staff->organizationBranch->branch_name}}
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="start_date" class="col-sm-4 col-form-label">Position</label>
                                        <div class="col-sm-8">
                                            {{$staff->position}}
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="description" class="col-sm-4 col-form-label">Notes</label>
                                        <div class="col-sm-8">
                                            {{$staff->note}}
                                        </div>
                                    </div>

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



@endsection
