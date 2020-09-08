@extends('layouts.master')
@section('title','Total Deposit Report')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-header-rights">
                                <i class="fas fa-chart-line"></i> Total: {{ count($details) ?? ''}}
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
                            <form id="summary-report" action="{{route('report-total-deposit-report')}}" method="get">
                                <div class="row">
                                    <div class="col-sm-2 my-1">
                                        <label class="" for="fiscal_year_id">
                                            Fiscal Year</label>
                                        <div class="input-group">
                                            {{Form::select('fiscal_year_id',$fiscal_years->pluck('code','id'),$_GET['fiscal_year_id'] ?? $fiscal_years->where('status',1)->first()->id ?? null,['class'=>'form-control','placeholder'=>'ALL'])}}
                                        </div>
                                    </div>
                                    <div class="col-sm-4 my-1">
                                        <label class="" for="institution_id">
                                            Bank Name</label>
                                        <div class="input-group">
                                            {!! Form::select('institution_id', $institutions, $_GET['institution_id'] ?? null, ['class'=>'form-control','placeholder'=>'ALL']) !!}
                                        </div>
                                    </div>
                                    <div class="col-sm-2 my-1">
                                        <label class="" for="start_date_en">Transaction Date(AD)
                                            : </label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="start_date_en"
                                                   name="start_date_en" placeholder="Start Date En"
                                                   value="{{$_GET['start_date_en'] ?? null}}">
                                        </div>
                                    </div>
                                    <div class="col-sm-2 my-1">
                                        <label class="" for="start_date">Transaction Date(BS)
                                            : </label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="start_date"
                                                   name="start_date" placeholder="Start Date"
                                                   value="{{$_GET['start_date'] ?? null}}"
                                                   readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-2 my-1">
                                        <label class="" for="end_date_en">Mature Date(AD)
                                            : </label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="end_date_en"
                                                   name="end_date_en" placeholder="End Date En"
                                                   value="{{$_GET['end_date_en'] ?? null}}">
                                        </div>
                                    </div>
                                    <div class="col-sm-2 my-1">
                                        <label class="" for="end_date">Mature Date(BS)
                                            : </label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="end_date"
                                                   name="end_date" placeholder="End Date"
                                                   value="{{$_GET['end_date'] ?? null}}"
                                                   readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-2 my-1">
                                        <label class="" for="investment_subtype_id">
                                            Deposit Type</label>
                                        <div class="input-group">
                                            {!! Form::select('investment_subtype_id',$investment_subtypes,$_GET['investment_subtype_id'] ?? null,['class'=>'form-control','placeholder'=>'ALL']) !!}
                                        </div>
                                    </div>
                                    <div class="col-sm-2 my-1">
                                        <label class="" for="fresh_only">Fresh Deposits Only</label>
                                        <div class="input-group">
                                            {!! Form::checkbox('fresh_only',1,$_GET['fresh_only'] ?? false) !!}
                                        </div>
                                    </div>
                                    <div class="col-sm-2 mt-4">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        {{--                                        <label for="">Clear All</label>--}}
                                        <a href="{{route('report-total-deposit-report')}}" class="btn btn-danger">Reset</a>
                                    </div>
                                </div>
                            </form>
                                <div class="row">
                                    <div id="printableArea" class="col-xl-12 freezeHeaderTableContainer">
                                        <table class="table table-bordered freezeHeaderTable">
                                            <thead>
                                            <tr>
                                                <th>SN</th>
                                                <th>Bank Name</th>
                                                <th>Nos. of Deposit</th>
                                                <th>Total Deposit Amount</th>
                                            </tr>
                                            </thead>
                                                @foreach($details as $deposit)
                                                    <tr>
                                                        <td>{{$loop->iteration}}</td>
                                                        <td>{{$deposit['institution_name']}}</td>
                                                        <td>{{$deposit['deposit_count']}}</td>
                                                        <td>{{$deposit['total_deposit']}}</td>
                                                    </tr>
                                                @endforeach
                                            <tr>
                                                <td colspan="2" style="text-align:right;">Total</td>
                                                <td style="text-align:center;"
                                                    colspan="">{{$no_of_deposit}}</td>
                                                <td style="text-align:center;"
                                                    colspan="">{{$total_deposit}}</td>
                                            </tr>

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
        $('#start_date_en,#end_date_en').flatpickr();


        $('#start_date_en').change(function () {
            $('#start_date').val(AD2BS($('#start_date_en').val()));
            enddate();
        });

        $('#end_date_en').change(function () {
            $('#end_date').val(AD2BS($('#end_date_en').val()));
        });

        $('#end_date_en').change(function () {
            $('#end_date').val(AD2BS($('#end_date_en').val()));
        });

        $('#start_date').nepaliDatePicker({
            npdMonth: true,
            npdYear: true,
            npdYearCount: 10,
            onChange: function (e) {
                $('#start_date_en').val(BS2AD($('#start_date').val()));
                var end_date = $('#end_date').val();
                nepadate();
                if (end_date !== '') {
                }
            }
        });

        $('#start_date').nepaliDatePicker({
            npdMonth: true,
            npdYear: true,
            npdYearCount: 10,
            onChange: function (e) {
                $('#start_date_en').val(BS2AD($('#start_date').val()));
                var end_date = $('#end_date').val();
                enddate();
                $('#end_date_en').prop('disabled', false);
                $('#end_date_en').flatpickr({
                    minDate: $('#start_date_en').val()
                });
                if (end_date !== '') {
                    // $('#depositFilter').submit();
                }
            }
        });

        $('.downexcel').on("click", function () {
            $('#summary-report').attr('action', '{{route('total-deposit-report-excel')}}');
            $('#summary-report').submit();
            $('#summary-report').attr('action', '{{route('report-total-deposit-report')}}');

        });
    </script>
    <script src="{{asset('js/print.js')}}"></script>
@endsection