@extends('layouts.master')
@section('title','Dividend Create')
@section('styles')

@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-6 col-xl-6">
                <div class="card">
                    <div class="card-header">

                        <div class="card-header-actions">
                            Add Dividend
                        </div>
                        <div class="card-header-rights">

                        </div>
                    </div>
                    <div class="card-body">
                        {!! Form::open(['route' => 'dividend.store','method'=>'POST']) !!}
                        {{ Form::token()}}

                        <div class="row form-group">
                            <div class="col-4">
                                {{ Form::label('institution_code', 'Institution')}}
                            </div>
                            <div class="col-8">
                                {{Form::select('institution_code',$share_institutions,null,['class'=>'form-control','placeholder'=>'Select an institution','required'=>'required'])}}
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-4">
                                {{ Form::label('date', 'Date (AD)')}}
                            </div>
                            <div class="col-8">
                                {{Form::date('date',null,['id'=>'dividend_date_en','class'=>'form-control','placeholder'=>'Add Date (AD)'])}}
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-4">
                                {{ Form::label('date', 'Date (BS)')}}
                            </div>
                            <div class="col-8">
                                {{Form::text('date_np',null,['id'=>'dividend_date_np','class'=>'form-control','placeholder'=>'Add Date (BS)'])}}
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-4">
                                {{ Form::label('amount', 'Amount')}}
                            </div>
                            <div class="col-8">
                                {{Form::number('amount',null,['step'=>'0.01','class'=>'form-control','placeholder'=>'Amount'])}}
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-4">
                                {{ Form::label('remarks', 'Remarks')}}
                            </div>
                            <div class="col-8">
                                {{Form::textarea('remarks',null,['class'=>'form-control','placeholder'=>'Remarks'])}}
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-12 text-center">
                                {{Form::submit('Submit',['class'=>'btn btn-primary'])}}
                            </div>
                        </div>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        $('#dividend_date_en').flatpickr();
        $('#dividend_date_en').change(function (e) {
            e.preventDefault();
            $('#dividend_date_np').val(AD2BS($('#dividend_date_en').val()));
        })
        $('#dividend_date_np').nepaliDatePicker({
            npdMonth: true,
            npdYear: true,
            npdYearCount: 10,
            onChange: function (e) {
                $('#dividend_date_en').val(BS2AD($('#dividend_date_np').val()));

            }
        });
    </script>
@endsection

