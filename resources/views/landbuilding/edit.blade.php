@extends('layouts.master')
@section('title','Land & Building Edit')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form method="post" class="" action="{{route('land-building-investments.update',$investment->id)}}">
                @method('PATCH')
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-xl-6">
                        <div class="card">
                            <div class="card-header">
                                <i class="fa fa-align-justify"></i>
                                Land & Building Edit
                            </div>
                            <div class="card-body">
                                @csrf
                                <div class="row">

                                    <div class="col-sm-4 my-1">
                                        <label class="" for="date_en"><sup
                                                    class="required-field">*</sup>Transaction Date
                                            (AD)</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="date_en"
                                                   name="date_en" placeholder="Transaction Date (AD)"
                                                   value="{{old('date_en',$investment->date_en)}}" readonly
                                                   data-validation="required">
                                        </div>
                                    </div>
                                    <div class="col-sm-4 my-1">
                                        <label class="" for="date"><sup class="required-field">*</sup>Transaction
                                            Date (BS)</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control nep-date" id="date"
                                                   name="date" placeholder="Transaction Date (BS)"
                                                   value="{{old('date',$investment->date)}}" readonly
                                                   data-validation="required">
                                        </div>
                                    </div>
                                    <div class="col-sm-4 my-1">
                                        <label class="" for="date"><sup class="required-field">*</sup>Investment
                                            Type</label>
                                        <div class="input-group">
                                            {!! Form::select('type',$investment_types,old('type',$investment->type),['class'=>'form-control','placeholder'=>'Select One','data-validation'=>'required']) !!}
                                        </div>
                                    </div>

                                    <div class="col-sm-4 my-1">
                                        <label class="" for="date"><sup class="required-field">*</sup>Investment
                                            Area</label>
                                        <div class="input-group">
                                            {!! Form::text('site_location',old('site_location',$investment->site_location),['class'=>'form-control','placeholder'=>'Site Location','data-validation'=>'required']) !!}
                                        </div>
                                    </div>

                                    <div class="col-sm-4 my-1">
                                        <label class="" for="date"><sup class="required-field">*</sup>Amount</label>
                                        <div class="input-group">
                                            {!! Form::number('amount',old('amount',$investment->amount),['class'=>'form-control','placeholder'=>'Amount','step'=>0.5,'data-validation'=>'required']) !!}
                                        </div>
                                    </div>
                                    <div class="col-sm-12 my-1">
                                        <label class="" for="date">Remarks</label>
                                        <div class="input-group">
                                            {!! Form::textarea('remarks',old('remarks',$investment->remarks),['class'=>'form-control','placeholder'=>'Remarks']) !!}
                                        </div>
                                    </div>

                                    <div class="col-md-12 text-center">
                                        <input type="submit" class="btn btn-primary">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $('#date_en,#mature_date_en').flatpickr();

        $('.nep-date').nepaliDatePicker({
            npdMonth: true,
            npdYear: true,
            npdYearCount: 10,
            onChange: function (e) {
                $("#date").blur();
                $('#date_en').val(BS2AD($('#date').val()));
            }
        });

        $('#date_en').change(function () {
            $('#date').val(AD2BS($('#date_en').val()));
        });


    </script>
@endsection
