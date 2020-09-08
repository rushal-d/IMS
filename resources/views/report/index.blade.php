@extends('layouts.master')
@section('title','Report')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i>
                            Deposit Report
                            <div class="card-header-rights">
                                <a onclick="printDiv('printableArea')" class="btn btn-sm btn-dropbox">
                                    Print <i class="fa fa-print"></i>
                                </a>
                                &nbsp;
                                <button class="downexcel btn btn-sm btn-dribbble">
                                    Export to Excel <i class="far fa-file-excel"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="depositForm" action="{{route('deposit.filter')}}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-2 my-1">
                                        <label class="" for="fiscal_year_id"><sup class="required-field">*</sup>Fiscal
                                            Year</label>
                                        <div class="input-group">
                                            <select name="fiscal_year_id" id="fiscal_year_id" class="form-control">
                                                <option value="">All</option>
                                                @foreach($fiscal_years as $fiscal_year)
                                                    <option value="{{$fiscal_year->id}}"
                                                            @if(!empty($fiscal_year_f_id))
                                                            @if($fiscal_year_f_id == $fiscal_year->id)
                                                            selected
                                                            @endif
                                                            @endif
                                                    >{{$fiscal_year->code}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-2 my-1">
                                        <label class="" for="start_date">From (AD)
                                            : </label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="start_date_en"
                                                   name="start_date_en"
                                                   placeholder="Start Date (AD)"
                                                   value="@if(!empty($start_date_en)){{$start_date_en}}@endif"
                                                   readonly>

                                        </div>
                                    </div>

                                    <div class="col-sm-2 my-1">
                                        <label class="" for="start_date">From (BS)
                                            : </label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="start_date" name="start_date"
                                                   placeholder="Start Date (BS)"
                                                   value="@if(!empty($start_date)){{$start_date}}@endif"
                                                   readonly>

                                        </div>
                                    </div>
                                    <div class="col-sm-2 my-1">
                                        <label class="" for="end_date">To (AD)
                                            : </label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="end_date_en" name="end_date_en"
                                                   placeholder="End Date (AD)"
                                                   value="@if(!empty($end_date_en)) {{$end_date_en}} @endif"
                                                   readonly>

                                        </div>
                                    </div>

                                    <div class="col-sm-2 my-1">
                                        <label class="" for="end_date">To (BS)
                                            : </label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="end_date" name="end_date"
                                                   placeholder="End Date (BS)"
                                                   value="@if(!empty($end_date)) {{$end_date}} @endif"
                                                   readonly>

                                        </div>
                                    </div>
                                    <div class="col-sm-2 my-1">
                                        <label class="" for="earmarked">Earmarked</label>
                                        <div class="input-group">
                                            <select name="earmarked" id="earmarked" class="form-control">
                                                <option value="">All</option>
                                                <option value="0"
                                                        @if(isset($earmarked_f_id))
                                                        @if($earmarked_f_id == 0)
                                                        selected
                                                        @endif
                                                        @endif>No
                                                </option>
                                                <option value="1"
                                                        @if(!empty($earmarked_f_id))
                                                        @if($earmarked_f_id == 1)
                                                        selected
                                                        @endif
                                                        @endif>Yes
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-4 my-1">
                                        <label class="" for="inlineFormInputGroupUsername"><sup
                                                    class="required-field">*</sup>Bank Name</label>
                                        <div class="input-group">
                                            <select name="institution_id" id="institution_id" class="form-control">
                                                <option value="">All</option>
                                                @foreach($institutes as $institute)
                                                    <option value="{{$institute->id}}"
                                                            @if(!empty($institution_f_id))
                                                            @if($institution_f_id == $institute->id)
                                                            selected
                                                            @endif
                                                            @endif
                                                    >{{$institute->institution_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-sm-2 my-1">
                                        <label class="" for="bank"><sup class="required-field">*</sup>Branch
                                            Name</label>
                                        <div class="input-group">
                                            <select name="branch_id" id="branch_id" class="form-control">
                                                <option value="">All</option>
                                                @foreach($banks as $bank)
                                                    <option value="{{$bank->id}}"
                                                            @if(!empty($bank_f_id))
                                                            @if($bank_f_id == $bank->id)
                                                            selected
                                                            @endif
                                                            @endif
                                                    >{{$bank->branch_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-2 my-1">
                                        <label class="" for="investment_subtype_id"><sup class="required-field">*</sup>Deposit
                                            Type</label>
                                        <div class="input-group">
                                            <select name="investment_subtype_id" id="investment_subtype_id"
                                                    class="form-control">
                                                <option value="">All</option>
                                                @foreach($investment_subtypes as $investment_subtype)
                                                    <option value="{{$investment_subtype->id}}"
                                                            @if(!empty($deposit_type_f_id))
                                                            @if($deposit_type_f_id == $investment_subtype->id)
                                                            selected
                                                            @endif
                                                            @endif
                                                    >{{$investment_subtype->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-2 my-1">
                                        <label class="" for="status">Status </label>
                                        <div class="input-group">
                                            <select name="status" id="status" class="form-control">
                                                <option value="">All</option>
                                                <option value="1"
                                                        @if(!empty($status_f)) @if($status_f == 1) selected @endif @endif>
                                                    Active
                                                </option>
                                                <option value="2"
                                                        @if(!empty($status_f)) @if($status_f == 2) selected @endif @endif>
                                                    Renew Soon
                                                </option>
                                                <option value="3"
                                                        @if(!empty($status_f)) @if($status_f == 3) selected @endif @endif>
                                                    Expired
                                                </option>
                                                <option value="4"
                                                        @if(!empty($status_f)) @if($status_f == 4) selected @endif @endif>
                                                    Renewed
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-2 my-1">
                                        <label class="mature_days" for="status">Mature Days</label>
                                        <div class="input-group">
                                            <select name="mature_days" id="mature_days" class="form-control">
                                                <option value="">All</option>
                                                <option value="10"
                                                        @if(!empty($mature_days)) @if($mature_days == 10) selected @endif @endif>
                                                    <=10 days
                                                </option>
                                                <option value="25"
                                                        @if(!empty($mature_days)) @if($mature_days == 25) selected @endif @endif>
                                                    <=25 days
                                                </option>
                                                <option value="30"
                                                        @if(!empty($mature_days)) @if($mature_days == 30) selected @endif @endif>
                                                    <=30 days
                                                </option>
                                                <option value="60"
                                                        @if(!empty($mature_days)) @if($mature_days == 60) selected @endif @endif>
                                                    <=60 days
                                                </option>
                                                <option value="90"
                                                        @if(!empty($mature_days)) @if($mature_days == 90) selected @endif @endif>
                                                    <=90 days
                                                </option>
                                                <option value="100"
                                                        @if(!empty($mature_days)) @if($mature_days == 100) selected @endif @endif>
                                                    <=100 days
                                                </option>
                                                <option value="200"
                                                        @if(!empty($mature_days)) @if($mature_days == 200) selected @endif @endif>
                                                    <=200 days
                                                </option>
                                                <option value="300"
                                                        @if(!empty($mature_days)) @if($mature_days == 300) selected @endif @endif>
                                                    <=300 days
                                                </option>
                                                <option value="301"
                                                        @if(!empty($mature_days)) @if($mature_days == 301) selected @endif @endif>
                                                    >=301 days
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-2 my-1">
                                        <label class="" for="start_date">Calc. Interest From (AD): </label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="interest_start_date_en"
                                                   name="interest_start_date_en" placeholder="Interest Start Date"
                                                   value="@if(!empty($interest_start_en)){{$interest_start_en}}@endif"
                                                   readonly>

                                        </div>
                                    </div>

                                    <div class="col-sm-2 my-1">
                                        <label class="" for="start_date">Calc. Interest From (BS) : </label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="interest_start_date"
                                                   name="interest_start_date" placeholder="Interest Start Date (BS)"
                                                   value="@if(!empty($interest_start)){{$interest_start}}@endif"
                                                   readonly>

                                        </div>
                                    </div>
                                    <div class="col-sm-2 my-1">
                                        <label class="" for="end_date">Calc. Interest To (AD): </label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="interest_end_en"
                                                   name="interest_end_en" placeholder="End Date"
                                                   value="@if(!empty($interest_end_en)){{$interest_end_en}}@endif"
                                                   readonly>

                                        </div>
                                    </div>

                                    <div class="col-sm-2 my-1">
                                        <label class="" for="end_date">Calc. Interest To (BS)
                                            : </label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="interest_end_date"
                                                   name="interest_end_date" placeholder="End Date"
                                                   value="@if(!empty($interest_end)){{$interest_end}}@endif"
                                                   readonly>
                                        </div>
                                    </div>
                                    {{-- <div class="col-sm-2 my-1">
                                         <label for="calculate">Calculate (Enter days) </label>
                                         <div class="input-group">
                                             <label for="estimated_days"></label>
                                             <input id="estimated_days" type="number" name="estimated_days" class="form-control"
                                                    value="@if(!empty($calculated_days)){{ $calculated_days }}@endif">
                                         </div>
                                     </div>--}}
                                    <div class="col-sm-1">
                                        <label for="" style="visibility:hidden;">Submit</label>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                    <div class="col-sm-1">
                                        <label for="">Clear All</label>
                                        <a href="{{route('deposit.index')}}" class="btn btn-danger">Reset</a>
                                    </div>
                                </div>
                            </form>
                            <div class="row">
                                <div id="printableArea" class="col-xl-12">
                                    <table class="table table-bordered table-responsive">
                                        <thead>
                                        <tr>
                                            <th>Fiscal Year</th>
                                            <th>Transaction Date</th>
                                            <th>Institution Name</th>
                                            <th>Branch</th>
                                            <th>Deposit Type</th>
                                            <th>Duration (Days)</th>
                                            <th>Mature Date</th>
                                            {{--<th>Document No.</th>--}}
                                            {{--<th>Interest Payment <br> method</th>--}}
                                            <th>Deposit Amount</th>
                                            <th>Withdraw Amount</th>
                                            <th>Interest Rate/Year</th>
                                            <th>Estimated Earning</th>
                                            <th>Alert Days</th>
                                            {{--<th>Reference No.</th>--}}
                                            <th>Status</th>
                                        </tr>
                                        </thead>
                                        <?php $total_interest_amount = 0; ?>
                                        @if(!empty($deposits) or count($deposits) > 0)
                                            @foreach($deposits as $deposit)
                                                <tr class="@if($deposit->status == 4)  @elseif($deposit->status == 3) rowexpire
                                                @elseif($deposit->status == 2) rowalert @else rowalive @endif">
                                                    <td>{{$deposit->fiscalyear->code}}</td>
                                                    <td>{{$deposit->trans_date}}</td>
                                                    <td>{{$deposit->institute->institution_code}}</td>
                                                    <td>{{$deposit->branch->branch_name or 'NA'}}</td>
                                                    <td>{{$deposit->deposit_type->name}}</td>
                                                    <td>{{$deposit->days}} days</td>
                                                    <td>{{$deposit->mature_date}}</td>
                                                    <td>{{$deposit->deposit_amount}}</td>
                                                    <td>-</td>
                                                    <td>{{$deposit->interest_rate}}</td>
                                                    <td>{{$deposit->estimated_earning}}</td>
                                                    <?php $total_interest_amount += $deposit->estimated_earning;  ?>
                                                    <td>{{$deposit->alert_days}} ({{$deposit->expiry_days}})</td>
                                                    {{--<td>{{$deposit->reference_number}}</td>--}}
                                                    <td>@if($deposit->status == 1)
                                                            Active
                                                        @elseif($deposit->status == 2)
                                                            Renew Soon
                                                        @elseif($deposit->status == 3)
                                                            Expired
                                                        @elseif($deposit->status == 4)
                                                            Renewed
                                                        @else
                                                            WithDrawn
                                                        @endif
                                                    </td>
                                                </tr>
                                                @if(!empty($deposit->withdraw))
                                                    <tr>
                                                        <td>{{$deposit->fiscalyear->code}}</td>
                                                        <td>{{$deposit->trans_date}}</td>
                                                        <td>{{$deposit->institute->institution_name}}</td>
                                                        <td>{{$deposit->branch->branch_name or 'NA'}}</td>
                                                        <td>{{$deposit->deposit_type->name}}</td>
                                                        <td>{{$deposit->days}} days</td>
                                                        <td>{{$deposit->mature_date}}</td>
                                                        <td>0</td>
                                                        <td>{{$deposit->withdraw->withdraw_amount or '-'}}</td>
                                                        <td>{{$deposit->interest_rate}}</td>
                                                        <td>{{$deposit->estimated_earning}}</td>
                                                        <td>{{$deposit->alert_days}} ({{$deposit->expiry_days}})</td>
                                                        <td>
                                                            Withdraw Date: [{{$deposit->withdraw->withdrawdate}}]
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                            <tr>
                                                <td colspan="10" style="text-align:right;">Total</td>
                                                <td style="text-align:left;"
                                                    colspan="3">{{ $total_interest_amount }}</td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td>No Data Found</td>
                                            </tr>
                                        @endif
                                        <tbody>
                                        </tbody>
                                    </table>
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

        $('#start_date_en,#interest_start_date_en').flatpickr();
        $('#end_date_en,#interest_end_date_en').flatpickr({
            disable: true
        });

        $('#start_date_en').change(function () {
            $('#start_date').val(AD2BS($('#start_date_en').val()));
            nepadate();
        });

        $('#end_date_en').change(function () {
            $('#end_date').val(AD2BS($('#end_date_en').val()));
            $('#depositForm').submit();
        });

        $('#interest_start_date_en').change(function () {
            $('#interest_start_date').val(AD2BS($('#interest_start_date_en').val()));
            enddate();
        });

        $('#interest_end_date_en').change(function () {
            $('#interest_end_date_en').val(AD2BS($('#interest_end_date_en').val()));
            $('#depositForm').submit();
        });
        $('.downexcel').on("click", function () {
            $('#depositForm').attr('action', '{{route('deposit.excel')}}');
            $('#depositForm').submit();
            $('#depositForm').attr('action', '{{route('deposit.filter')}}');
        });
        /*
                $("#fiscal_year_id").on("change", function() {
                    $('#filterForm').submit();
                });

                $("#institution_id").on("change", function() {
                    $('#filterForm').submit();
                });

                $("#investment_subtype_id").on("change", function() {
                    $('#filterForm').submit();
                });

                $("#branch_id").on("change", function() {
                    $('#filterForm').submit();
                });

                $("#status").on("change", function() {
                    $('#filterForm').submit();
                });

                $("#mature_days").on("change", function() {
                    $('#filterForm').submit();*/
        // });


        $('#start_date').nepaliDatePicker({
            npdMonth: true,
            npdYear: true,
            npdYearCount: 10,
            onChange: function (e) {
                $('#start_date_en').val(BS2AD($('#start_date').val()));


                var end_date = $('#end_date').val();
                nepadate();
                if (end_date !== '') {
                    // $('#filterForm').submit();
                }
            }
        });

        function nepadate() {
            var start_date = $('#start_date').val();
            var new_date = start_date.split('-');
            yes_date = new_date[1] + '/' + new_date[2] + '/' + new_date[0];
            $('#end_date_en').flatpickr({
                minDate: $('#start_date_en').val()
            });
            $('#end_date').nepaliDatePicker({
                disableBefore: yes_date,
                npdMonth: true,
                npdYear: true,
                npdYearCount: 10,
                onChange: function (e) {
                    $('#end_date_en').val(BS2AD($('#end_date').val()));
                    // $('#filterForm').submit();
                }
            });
        }

        $('#interest_start_date').nepaliDatePicker({
            npdMonth: true,
            npdYear: true,
            npdYearCount: 10,
            onChange: function (e) {
                $('#interest_start_date_en').val(BS2AD($('#interest_start_date').val()));
                var end_date = $('#interest_end_date').val();
                enddate();
                if (end_date !== '') {
                    // $('#filterForm').submit();
                }
            }
        });

        function enddate() {
            var start_date = $('#interest_start_date').val();
            var new_date = start_date.split('-');
            yes_date = new_date[1] + '/' + new_date[2] + '/' + new_date[0];

            $('#interest_end_date_en').flatpickr({
                minDate: $('#interest_start_date_en').val()
            });
            $('#interest_end_date').nepaliDatePicker({
                disableBefore: yes_date,
                npdMonth: true,
                npdYear: true,
                npdYearCount: 10,
                onChange: function (e) {
                    $('#interest_end_date_en').val(BS2AD($('#interest_end_date').val()));
                    // $('#filterForm').submit();
                }

            });
        }

        $(document).ready(function () {
            if ($('#interest_start_date').val() !== '' && $('#interest_end_date').val() !== '') {
                $('#interest_start_date_en').val(BS2AD($('#interest_start_date').val()));
                $('#interest_end_date_en').val(BS2AD($('#interest_end_date').val()));
            }

            if ($('#start_date').val() !== '' && $('#end_date').val() !== '') {
                $('#start_date_en').val(BS2AD($('#start_date').val()));
                $('#end_date_en').val(BS2AD($('#end_date').val()));
            }
        });
    </script>
    <script src="{{asset('js/print.js')}}"></script>
@endsection

