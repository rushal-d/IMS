@extends('layouts.master')
@section('title','Share-Edit')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form method="post" class="" action="{{route('share.update', $share->id)}}">
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-xl-8">
                        <div class="card">
                            <div class="card-header">
                                <i class="fa fa-align-justify"></i>
                                Share - Edit
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="row">
                                            {{--                                            <div class="col-sm-4 my-1">--}}
                                            {{--                                                <label class="" for="inlineFormInputName"><sup--}}
                                            {{--                                                            class="required-field">*</sup>Fiscal Year</label>--}}
                                            {{--                                                <div class="input-group">--}}
                                            {{--                                                    <select name="fiscal_year_id" id="fiscal_year_id"--}}
                                            {{--                                                            class="form-control" data-validation="required">--}}
                                            {{--                                                        <option value="">select</option>--}}
                                            {{--                                                        @foreach($fiscal_years as $fiscal_year)--}}
                                            {{--                                                            <option value="{{$fiscal_year->id}}"--}}
                                            {{--                                                                    @if($fiscal_year->id == $share->fiscalyear->id) selected @endif--}}
                                            {{--                                                            >{{$fiscal_year->code}}</option>--}}
                                            {{--                                                        @endforeach--}}
                                            {{--                                                    </select>--}}
                                            {{--                                                </div>--}}
                                            {{--                                            </div>--}}
                                            <div class="col-sm-4 my-1">
                                                <label class="" for="trans_date_en"><sup
                                                            class="required-field">*</sup>Transaction Date
                                                    (AD)</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control " id="trans_date_en"
                                                           name="trans_date_en" placeholder="Transaction Date (AD)"
                                                           value="{{$share->trans_date_en}}" readonly
                                                           data-validation="required">
                                                </div>
                                            </div>
                                            <div class="col-sm-4 my-1">
                                                <label class="" for="trans_date"><sup class="required-field">*</sup>Transaction
                                                    Date (BS)</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control nep-date" id="trans_date"
                                                           name="trans_date" placeholder="Transaction Date (BS)"
                                                           value="{{$share->trans_date}}" readonly
                                                           data-validation="required">
                                                </div>
                                            </div>

                                            <div class="col-sm-4 my-1">
                                                <label class="" for="inlineFormInputGroupUsername"><sup
                                                            class="required-field">*</sup>Organization Name</label>
                                                <div class="input-group">
                                                    <select name="institution_code" id="institution_code"
                                                            class="form-control selectorg" data-validation="required">
                                                        <option value="">select</option>
                                                        @foreach($institutes as $institute)
                                                            <option value="{{$institute->institution_code}}"
                                                                    @if($institute->institution_code == $share->institution_code) selected @endif
                                                            >{{$institute->institution_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-4 my-1">
                                                <label class="" for="purchase_kitta"><sup
                                                            class="required-field">*</sup>No. Of Kitta</label>
                                                <div class="input-group">
                                                    <input type="number" class="form-control" id="purchase_kitta"
                                                           name="purchase_kitta"
                                                           value="{{$share->purchase_kitta}}"
                                                           data-validation="required">
                                                </div>
                                            </div>
                                            <div class="col-sm-4 my-1">
                                                <label class="" for="rateperunit"><sup
                                                            class="required-field">*</sup>Nepse Rate</label>
                                                <div class="input-group">
                                                    <input type="number" step="0.01" class="form-control"
                                                           data-validation-allowing="float"
                                                           name="rateperunit" id="rateperunit"
                                                           value="{{$share->rateperunit}}"
                                                           data-validation="required" readonly>
                                                </div>
                                            </div>

                                            <div class="col-sm-4 my-1">
                                                <label class="" for="investment_subtype_id"><sup
                                                            class="required-field">*</sup>Investment Sector</label>
                                                <div class="input-group">
                                                    <select name="investment_subtype_id" id="investment_subtype_id"
                                                            class="form-control" data-validation="required">
                                                        <option value="">select</option>
                                                        @foreach($investment_subtypes as $investment_subtype)
                                                            <option value="{{$investment_subtype->id}}"
                                                                    @if($investment_subtype->id == $share->investment_sector->id) selected @endif
                                                            >{{$investment_subtype->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-4 my-1">
                                                <label class="" for="closing_value"><sup
                                                            class="required-field">*</sup>Nepse Value</label>
                                                <div class="input-group">
                                                    <input type="text" min="0" class="form-control"
                                                           id="closing_value" name="closing_value"
                                                           value="{{$share->closing_value}}"
                                                           data-validation="required">
                                                </div>
                                            </div>
                                            <div class="col-sm-4 my-1">
                                                <label class="" for="purcahse_value"><sup
                                                            class="required-field">*</sup>Rate per Unit</label>
                                                <div class="input-group">
                                                    <input type="text" min="0"
                                                           data-validation-allowing="float" class="form-control"
                                                           id="purchase_value" name="purchase_value"
                                                           value="{{$share->purchase_value}}"
                                                           data-validation="required">
                                                </div>
                                            </div>

                                            <div class="col-sm-4 my-1">
                                                <label class="" for="totalamount">Share Type</label>
                                                <div class="input-group">
                                                    {{Form::select('share_type_id',$share_types,$share->share_type_id,['class'=>'form-control','id'=>'share_type_id','data-validation'=>"required"])}}
                                                </div>
                                            </div>

                                            <div class="col-sm-4 my-1">
                                                <label class="" for="totalamount">Reference Number</label>
                                                <div class="input-group">
                                                    <input type="text" min="0" value="{{$share->reference_number}}"
                                                           class="form-control" name="reference_number"
                                                           id="reference_number">
                                                </div>
                                            </div>
                                            <div class="col-sm-4 my-1">
                                                <label class="" for="total_amount"><sup
                                                            class="required-field">*</sup>Total Amount</label>
                                                <div class="input-group">
                                                    <input type="text"
                                                           data-validation-allowing="float" class="form-control"
                                                           id="total_amount" name="total_amount"
                                                           value="{{$share->total_amount}}"
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
                                Share - Edit
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-12">

                                        <div class="row">
                                            <div class="col-sm-12 my-1">
                                                <label class="" for="kitta_details"><sup
                                                            class="required-field"></sup>Kitta Details</label>
                                                <div class="input-group">
                                                    <input type="text" min="0" class="form-control"
                                                           id="kitta_details" name="kitta_details"
                                                           value="{{$share->kitta_details}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div style="text-align: center">
                                    <button type="submit" class="btn btn-primary">
                                        Update
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
        $('#trans_date_en,#mature_date_en').flatpickr();

        $('.nep-date').nepaliDatePicker({
            npdMonth: true,
            npdYear: true,
            npdYearCount: 10,
            onChange: function (e) {
                $('#trans_date_en').val(BS2AD($('#trans_date').val()));
                askClosingValue();
            }
        });

        $('#trans_date_en').change(function () {
            $('#trans_date').val(AD2BS($('#trans_date_en').val()));
            askClosingValue();
        });

        $(document).on('change', '.selectorg', function () {
            askClosingValue();
        });

        function askClosingValue() {
            var date = $('#trans_date_en').val();
            var orgCode = $('.selectorg').val();
            if (orgCode != '' && date != '') {

                $.ajax({
                    url: '{{ URL::to('/askclosevalue/ajax').'/' }}' + orgCode + '/' + date,
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        if (data != '') {
                            $('#rateperunit').val(data).blur();
                            if ($('#purchase_kitta').val() != '') {
                                $('#closing_value').val($('#purchase_kitta').val() * data).blur();
                            }
                        } else {
                            // alert('NA');
                            $('#rateperunit').prop('readonly', false)
                            $('#rateperunit').val('NA');
                            $('#closing_value').val('');
                        }
                    },
                    error: function () {

                    }
                });
            }
        }

        $(document).on('keyup', '#purchase_kitta', function () {
            var rate = $(this).val();
            var nepse_rate = $('#rateperunit').val();
            if (nepse_rate !== '') {
                $('#closing_value').val(rate * nepse_rate).blur();
            }

            var total = $('#purchase_value').val();
            calculate_totalamount(rate, total);
        });
        $(document).on('keyup', '#rateperunit', function () {
            data = $('#rateperunit').val();
            if ($('#purchase_kitta').val() != '' || data != '') {
                $('#closing_value').val($('#purchase_kitta').val() * data).blur();
            }
        });
        $(document).on('keyup', '#purchase_value', function () {
            var total = $(this).val();
            var rate = $('#purchase_kitta').val();
            calculate_totalamount(rate, total);
        });

        $(document).on('keyup', '#total_amount', function () {
            total_amount = $('#total_amount').val();
            if ($('#purchase_kitta').val() != '' && total_amount != '') {
                $('#purchase_value').val($('#purchase_kitta').val() / total_amount).blur();
            }
        });

        function calculate_totalamount(rate, total) {
            var firsval = isNaN(rate) ? 0 : rate;
            var secondval = isNaN(total) ? 0 : total;
            if (firsval != 0 && secondval != 0) {
                var totalamount = firsval * secondval;
                $('#total_amount').val(totalamount).blur();
            }
        }

    </script>
@endsection
