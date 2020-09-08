@extends('layouts.master')
@section('title','Bond Create')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form method="post" action="{{route('bond.store')}}">
                @csrf
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-xl-8">
                        <div class="card">
                            <div class="card-header">
                                <i class="fa fa-align-justify"></i>
                                Bond - Create
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-12">

                                        <div class="row">
{{--                                            <div class="col-sm-4 my-1">--}}
{{--                                                <label class="" for="fiscal_year_id"><sup--}}
{{--                                                            class="required-field">*</sup>Fiscal Year</label>--}}
{{--                                                <div class="input-group">--}}
{{--                                                    <select name="fiscal_year_id" id="fiscal_year_id"--}}
{{--                                                            class="form-control" data-validation="required">--}}
{{--                                                        <option value=""></option>--}}
{{--                                                        @foreach($fiscal_years as $fiscal_year)--}}
{{--                                                            <option value="{{$fiscal_year->id}}"--}}
{{--                                                                    @if($fiscal_year->status ==1) selected @endif>{{$fiscal_year->code}}</option>--}}
{{--                                                        @endforeach--}}
{{--                                                    </select>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
                                            <div class="col-sm-4 my-1">
                                                <label class="" for="trans_date"><sup class="required-field">*</sup>Transaction
                                                    Date (AD)</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="trans_date_en"
                                                           name="trans_date_en" placeholder="Transaction Date (AD)"
                                                           value="" data-validation="required">
                                                </div>
                                            </div>
                                            <div class="col-sm-4 my-1">
                                                <label class="" for="trans_date"><sup class="required-field">*</sup>Transaction
                                                    Date (BS)</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control nep-date" id="trans_date"
                                                           name="trans_date" placeholder="Transaction Date (BS)"
                                                           value="" readonly data-validation="required">
                                                </div>
                                            </div>

                                            <div class="col-sm-4 my-1">
                                                <label class="" for="days"><sup class="required-field">*</sup>Duration
                                                    (Days)</label>
                                                <div class="input-group">
                                                    <input type="number" min="0" class="form-control" name="days"
                                                           id="days" placeholder="days" data-validation="required">
                                                </div>
                                            </div>
                                            <div class="col-sm-4 my-1">
                                                <label class="" for="mature_date"><sup
                                                            class="required-field">*</sup>Mature Date (AD)</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control " id="mature_date_en"
                                                           name="mature_date_en" placeholder="Mature  Date (AD)"
                                                           value="" readonly data-validation="required">
                                                </div>
                                            </div>
                                            <div class="col-sm-4 my-1">
                                                <label class="" for="mature_date"><sup
                                                            class="required-field">*</sup>Mature Date (BS)</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control nep-date"
                                                           id="mature_date" name="mature_date"
                                                           placeholder="Mature Date (BS)"
                                                           value="" readonly data-validation="required">
                                                </div>
                                            </div>

                                            <div class="col-sm-4 my-1">
                                                <label class="" for="inlineFormInputGroupUsername"><sup
                                                            class="required-field">*</sup>Organization Name</label>
                                                <div class="input-group">
                                                    <select name="institution_id" id="institution_id"
                                                            class="form-control">
                                                        <option value=""></option>
                                                        @foreach($institutes as $institute)
                                                            <option value="{{$institute->id}}">{{$institute->institution_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-4 my-1">
                                                <label class="" for="estimated_earning"><sup
                                                            class="required-field">*</sup>Organization Branch</label>
                                                <div class="input-group">
                                                    {!! Form::select('organization_branch_id', $organization_branch, null,['class'=>'form-control','placeholder'=>'Organization Branch', 'data-validation' => 'required']) !!}
                                                </div>
                                            </div>
                                            <div class="col-sm-4 my-1">
                                                <label class="" for="estimated_earning"><sup
                                                            class="required-field">*</sup>Receipt Location</label>
                                                <div class="input-group">
                                                    {!! Form::select('receipt_location_id', $receipt_location, null,['class'=>'form-control','placeholder'=>'Receipt Location', 'data-validation' => 'required']) !!}
                                                </div>
                                            </div>
                                            <div class="col-sm-4 my-1">
                                                <label class="" for="estimated_earning"><sup
                                                            class="required-field">*</sup>Interest Payment Methods</label>
                                                <div class="input-group">
                                                    {!! Form::select('interest_payment_method_id', $interest_payment_method, null,['class'=>'form-control','placeholder'=>'Interest Payment Method', 'data-validation' => 'required']) !!}
                                                </div>
                                            </div>
{{--                                            <div class="col-sm-4 my-1">--}}
{{--                                                <label class="" for="investment_subtype_id"><sup--}}
{{--                                                            class="required-field">*</sup>Bond Type</label>--}}
{{--                                                <div class="input-group">--}}
{{--                                                    <select name="investment_subtype_id" id="investment_subtype_id"--}}
{{--                                                            class="form-control" data-validation="required">--}}
{{--                                                        <option value=""></option>--}}
{{--                                                        @foreach($investment_subtypes as $investment_subtype)--}}
{{--                                                            <option value="{{$investment_subtype->id}}">{{$investment_subtype->name}}</option>--}}
{{--                                                        @endforeach--}}
{{--                                                    </select>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
                                            <div class="col-sm-4 my-1">
                                                <label class="" for="interest_rate"><sup
                                                            class="required-field">*</sup>Interest rate/year</label>
                                                <div class="input-group">
                                                    <input type="number" step="0.01"
                                                           data-validation-allowing="range[1.00;100.00], float"
                                                           class="form-control" name="interest_rate"
                                                           id="interest_rate" data-validation="number">
                                                </div>
                                            </div>

                                            <div class="col-sm-4 my-1">
                                                <label class="" for="rateperunit"><sup
                                                            class="required-field">*</sup>Par Value</label>
                                                <div class="input-group">
                                                    <input type="number" step="0.01" class="form-control"
                                                           data-validation-allowing="float" name="rateperunit"
                                                           id="rateperunit"
                                                           placeholder="par value" data-validation="required">
                                                </div>
                                            </div>

                                            <div class="col-sm-4 my-1">
                                                <label class="" for="totalunit"><sup class="required-field">*</sup>Total
                                                    Unit</label>
                                                <div class="input-group">
                                                    <input type="number" min="0" class="form-control"
                                                           name="totalunit" id="totalunit" placeholder="totalunit"
                                                           data-validation="required">
                                                </div>
                                            </div>

                                            <div class="col-sm-4 my-1">
                                                <label class="" for="totalamount"><sup
                                                            class="required-field">*</sup>Total Amount</label>
                                                <div class="input-group">
                                                    <input type="text" min="0" class="form-control"
                                                           name="totalamount" id="totalamount" readonly
                                                           data-validation="required">
                                                </div>
                                            </div>

                                            <div class="col-sm-6 my-1">
                                                <label class="" for="estimated_earning"><sup
                                                            class="required-field">*</sup>Estimated
                                                    Earning</label>
                                                <div class="input-group">
                                                    <input type="number" data-validation-allowing="float"
                                                           class="form-control" name="estimated_earning"
                                                           id="estimated_earning" readonly
                                                           data-validation="required">
                                                </div>
                                            </div>


                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-header">
                                <i class="fa fa-align-justify"></i>
                                Bond - Create
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6 my-1">
                                        <label class="" for="totalamount">Reference Number</label>
                                        <div class="input-group">
                                            <input type="text" min="0" class="form-control"
                                                   name="reference_number" id="reference_number">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 my-1">
                                        <label class="" for="alert_days"><sup class="required-field">*</sup>Alert
                                            Days</label>
                                        <div class="input-group">
                                            <input type="number" min="0" class="form-control" value="30"
                                                   name="alert_days" id="alert_days"
                                                   data-validation="required">
                                            <input type="hidden" name="status" value="1">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 my-1">
                                        <label class="" for="unitdetails">Details</label>
                                        <div class="input-group">
                                        <textarea name="unitdetails" id="unitdetails" cols="30" rows="5"
                                                  class="form-control"></textarea>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div style="text-align: center">
                                    <button type="submit" class="btn btn-primary">
                                        Submit
                                    </button>
                                    <button type="reset" class="btn btn-secondary" value="Reset">Clear</button>
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
        $('select').selectize({
            allowEmptyOption: false,
            placeholder: 'Select One',
        });
        $('#trans_date_en,#mature_date_en').flatpickr();
        $('#trans_date').nepaliDatePicker({
            npdMonth: true,
            npdYear: true,
            npdYearCount: 10,
            onChange: function (e) {
                $("#trans_date").blur();
                $('#trans_date_en').val(BS2AD($('#trans_date').val()));
                var trans_date = $('#trans_date').val();
                var days = $('#days').val();

                if (days !== '') {
                    adddays(trans_date, days);
                }
            }
        });
        $('#trans_date_en').change(function () {
            $('#trans_date').val(AD2BS($('#trans_date_en').val()));
            var trans_date = $('#trans_date').val();
            var days = $('#days').val();

            if (days !== '') {
                adddays(trans_date, days);
            }
        });
        /*to calcualte the total amount based upon the input rate and total units*/
        $(document).on('keyup', '#rateperunit', function () {
            var rate = $(this).val();
            var total = $('#totalunit').val();
            calculate_totalamount(rate, total);
        });

        $(document).on('keyup', '#totalunit', function () {
            var total = $(this).val();
            var rate = $('#rateperunit').val();
            calculate_totalamount(rate, total);
        });

        function calculate_totalamount(rate, total) {
            var firsval = isNaN(rate) ? 0 : rate;
            var secondval = isNaN(total) ? 0 : total;
            var totalamount = firsval * secondval;
            $('#totalamount').val(totalamount).blur();
            calculate_estearning();
        }

        $(document).on('keyup', '#days', function () {
            var days = $('#days').val();
            var trans_date = $('#trans_date').val();
            adddays(trans_date, days);
        });

        //add days to transaction date and show mature date
        function adddays(trans_date, days) {
            console.log('lolo');
            if (days !== '' && trans_date !== '') {
                if (!isNaN(days)) {
                    $.ajax({
                        url: '{{ URL::to('adddays')}}',
                        type: 'post',
                        aysnc: false,
                        data: {
                            '_token': $('input[name=_token]').val(),
                            'date': trans_date,
                            'days': days,
                        },
                        success: function (data) {
                            $('#mature_date').val(data['mature_date']);
                            $('#mature_date_en').val(data['mature_date_en']);
                            calculate_estearning();
                        },
                        error: function () {
                        }
                    });
                } else {
                    $('#mature_date').empty();
                    $('#mature_date_en').empty();
                    alert('please enter days in number');
                }
            }

        }

        $(document).on('keyup', '#interest_rate', function () {
            calculate_estearning();
        });

        function calculate_estearning() {
            var total_amount = $('#totalamount').val();
            var interest_rate = $('#interest_rate').val();
            var days = $('#days').val();
            var est_earning = 0;

            if (total_amount !== '' && interest_rate !== '' && days !== '') {
                est_earning = (((total_amount * interest_rate) / (100 * 365)) * days);
            }
            $('#estimated_earning').val(est_earning.toFixed(2)).blur();
            $("#mature_date").blur();
        }

        $('#mature_date').nepaliDatePicker({
            npdMonth: true,
            npdYear: true,
            npdYearCount: 10,
            onChange: function (e) {
                $("#mature_date").blur();
                $('#mature_date_en').val(BS2AD($('#mature_date').val()));
                var mature_date_en = $('#mature_date_en').val();
                var trans_date_en = $('#trans_date_en').val();

                var date1 = new Date(trans_date_en);
                var date2 = new Date(mature_date_en);
                var diffDays = parseInt((date2 - date1) / (1000 * 60 * 60 * 24)) + 1;
                $('#days').val(diffDays).blur();
                calculate_estearning();
            }
        });
        $('#mature_date_en').change(function () {
            $('#mature_date').val(AD2BS($('#mature_date_en').val()));
            var mature_date_en = $('#mature_date_en').val();
            var trans_date_en = $('#trans_date_en').val();

            var date1 = new Date(trans_date_en);
            var date2 = new Date(mature_date_en);
            var diffDays = parseInt((date2 - date1) / (1000 * 60 * 60 * 24)) + 1;
            $('#days').val(diffDays).blur();
            calculate_estearning();
        });
    </script>
@endsection
