@extends('layouts.master')
@section('title','Business Book Show')

@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">

            <div class="row">
                <div class="col-sm-12 col-md-12 col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i>
                            Business Book - Create
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="form-group row">
                                        <label class="col-md-4" for="inlineFormInputGroupUsername">Date (AD)</label>
                                        <div class="col-md-8">
                                            {{$business_book->date_en}}
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-4" for="inlineFormInputGroupUsername">Date (BS)</label>
                                        <div class="col-md-8">
                                            {{$business_book->date}}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-4" for="inlineFormInputGroupUsername">Organization
                                            Branch</label>
                                        <div class="col-md-8">
                                            {{$business_book->organizationbranch->branch_name}}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-4" for="amount">Amount</label>
                                        <div class="col-md-8">
                                            {{$business_book->amount}}
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-4" for="notes">Note</label>
                                        <div class="col-md-8">
                                            {!! $business_book->notes !!}
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
