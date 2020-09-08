@extends('layouts.master')
@section('title','Share')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form method="post" class="" action="{{route('right.share.store',$parent_share->id)}}">
                <div class="row">

                    <div class="col-sm-12 col-md-12 col-xl-8">
                        <div class="card">
                            <div class="card-header">
                                <i class="fa fa-align-justify"></i>
                                Right Share - Create
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-12">

                                        @csrf
                                        <div class="col-xl-12">
                                            <div class="row">

                                                <div class="col-sm-4 my-1">
                                                    <label class="" for="inlineFormInputName"><sup
                                                                class="required-field">*</sup>Fiscal Year</label>
                                                    <div class="input-group">
                                                        <select name="fiscal_year_id" id="fiscal_year_id"
                                                                class="form-control" data-validation="required">
                                                            <option value="">select</option>
                                                            @foreach($fiscal_years as $fiscal_year)
                                                                <option value="{{$fiscal_year->id}}"
                                                                        @if($fiscal_year->status == 1) selected @endif>{{$fiscal_year->code}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4 my-1">
                                                    <label class="" for="trans_date_en"><sup
                                                                class="required-field">*</sup>Transaction Date
                                                        (AD)</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id="trans_date_en"
                                                               name="trans_date_en" placeholder="Transaction Date (AD)"
                                                               value="" readonly data-validation="required">
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
                                                    <label class="" for="inlineFormInputGroupUsername"><sup
                                                                class="required-field">*</sup>Organization Name</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control"  readonly value="{{$parent_share->institute->institution_name}}">
                                                        {{--<select name="institution_id" id="institution_id"
                                                                class="selectorg form-control"
                                                                data-validation="required">
                                                            <option value="">select</option>
                                                            @foreach($institutes as $institute)
                                                                <option value="{{$institute->id}}">{{$institute->institution_name}}</option>
                                                            @endforeach
                                                        </select>--}}
                                                    </div>
                                                </div>
                                                <div class="col-sm-4 my-1">
                                                    <label class="" for="purchase_kitta"><sup
                                                                class="required-field">*</sup>Purchase Kitta</label>
                                                    <div class="input-group">
                                                        <input type="number" class="form-control" id="purchase_kitta"
                                                               name="purchase_kitta"
                                                               placeholder="" data-validation="required">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4 my-1">
                                                    <label class="" for="rateperunit">Nepse Rate</label>
                                                    <div class="input-group">
                                                        <input type="number" step="0.01" class="form-control"
                                                               data-validation-allowing="float"
                                                               name="rateperunit" id="rateperunit"
                                                               data-validation="required" readonly value="{{$closing_value}}">
                                                    </div>
                                                </div>

                                                <div class="col-sm-4 my-1">
                                                    <label class="" for="investment_subtype_id"><sup
                                                                class="required-field">*</sup>Share Type</label>
                                                    <div class="input-group">
                                                        <select name="investment_subtype_id" id="investment_subtype_id"
                                                                class="form-control" data-validation="required">
                                                            <option value="">select</option>
                                                            @foreach($investment_subtypes as $investment_subtype)
                                                                <option value="{{$investment_subtype->id}}">{{$investment_subtype->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4 my-1">
                                                    <label class="" for="closing_value">Nepse Value</label>
                                                    <div class="input-group">
                                                        <input type="text" min="0" class="form-control"
                                                               id="closing_value" name="closing_value"
                                                               placeholder="" data-validation="required" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4 my-1">
                                                    <label class="" for="purcahse_value"><sup
                                                                class="required-field">*</sup>Purchase Rate per
                                                        Unit</label>
                                                    <div class="input-group">
                                                        <input type="number" min="0" step="0.01"
                                                               data-validation-allowing="float" class="form-control"
                                                               id="purchase_value" name="purchase_value"
                                                               placeholder="" data-validation="required">
                                                    </div>
                                                </div>

                                                <div class="col-sm-6 my-1">
                                                    <label class="" for="totalamount">Reference Number</label>
                                                    <div class="input-group">
                                                        <input type="text" min="0" class="form-control"
                                                               name="reference_number" id="reference_number">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 my-1">
                                                    <label class="" for="total_amount">Total Amount</label>
                                                    <div class="input-group">
                                                        <input type="number" min="0" class="form-control"
                                                               id="total_amount" name="total_amount"
                                                               placeholder="" data-validation="required" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 ">
                        <div class="card">
                            <div class="card-header">
                                <i class="fa fa-align-justify"></i>
                                Share - Create
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6 my-1">
                                        <label class="" for="sales_kitta">Sales Kitta</label>
                                        <div class="input-group">
                                            <input type="number" min="0" class="form-control" value="0"
                                                   name="sales_kitta" id="sales_kitta"
                                                   placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 my-1">
                                        <label class="" for="status"><sup class="required-field">*</sup>Status</label>
                                        <div class="input-group">
                                            <select name="status" id="status" class="form-control"
                                                    data-validation="required">
                                                <option value="1" selected>Active</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 my-1">
                                        <label class="" for="kitta_details"><sup
                                                    class="required-field">*</sup>Kitta Details</label>
                                        <div class="input-group">
                                            <input type="text" min="0" class="form-control"
                                                   id="kitta_details" name="kitta_details"
                                                   placeholder="" data-validation="required">
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
        $('#trans_date_en,#mature_date_en').flatpickr();
        $('select').selectize({
            allowEmptyOption: false,
            create: true,
            placeholder: 'select one',
        });

        $('.nep-date').nepaliDatePicker({
            npdMonth: true,
            npdYear: true,
            npdYearCount: 10,
            onChange: function (e) {
                $("#trans_date").blur();
                $('#trans_date_en').val(BS2AD($('#trans_date').val()));
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

        $(document).on('keyup', '#purchase_kitta', function () {
            var rate = $(this).val();
            var nepse_rate = $('#rateperunit').val();

            if (nepse_rate !== '') {
                $('#closing_value').val(rate * nepse_rate).blur();
            }

            var total = $('#purchase_value').val();
            calculate_totalamount(rate, total);
        });

        $(document).on('keyup', '#purchase_value', function () {
            var total = $(this).val();
            var rate = $('#purchase_kitta').val();
            calculate_totalamount(rate, total);
        });

        function calculate_totalamount(rate, total) {
            var firsval = isNaN(rate) ? 0 : rate;
            var secondval = isNaN(total) ? 0 : total;
            var totalamount = firsval * secondval;
            $('#total_amount').val(totalamount).blur();
        }

        $(document).on('change', '.selectorg', function () {
            var selectedItem = $(this);
            var orgID = selectedItem.val();
            if (orgID) {
                $.ajax({
                    url: '{{ URL::to('/askclosevalue/ajax').'/' }}' + orgID,
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        if (data != '') {
                            $('#rateperunit').val(data).blur();
                            if ($('#purchase_kitta').val() != '') {
                                $('#closing_value').val($('#purchase_kitta').val() * data).blur();
                            }
                        } else {
                            alert('NA');
                            $('#rateperunit').val('NA');
                        }
                    },
                    error: function () {

                    }
                });
            } else {

            }
        });

    </script>
@endsection
