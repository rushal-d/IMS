@extends('layouts.master')
@section('title','Total Deposit by Org. Branch')
@section('styles')
    <style>
        .table-bordered th, .table-bordered td {
            border: 1px solid #c8ced3;
            /* text-align: center; */
            text-align: left;
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i>
                    Investment Report
                    <div class="card-header-rights">
                        <a onclick="printPortraitDiv('printableArea')" class="btn btn-sm btn-dropbox">
                            Print <i class="fa fa-print"></i>
                        </a>
                        &nbsp
                    </div>
                </div>
                <div class="card-body">
                    <form id="organization-branch-deposit" action="{{route('deposit-org-branch')}}"
                          method="get">
                        <div class="row col-xl-12">
                            <div class="col-sm-3 my-1">
                                <label class="" for="fiscal_year_id"><sup class="required-field"></sup>Fiscal
                                    Year</label>
                                <div class="input-group">
                                    <select name="fiscal_year_id" id="fiscal_year_id" class="form-control">
                                        <option value="">Select One</option>
                                        @foreach($fiscal_years as $fiscal_year)
                                            <option value="{{$fiscal_year->id}}"
                                                    @if(!empty($_GET['fiscal_year_id'] ))
                                                    @if(($_GET['fiscal_year_id'] ?? null) == $fiscal_year->id)
                                                    selected
                                                    @endif

                                                    @endif
                                            >{{$fiscal_year->code}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3 my-1">
                                <label class="" for="org_branch">
                                    Organization Branch</label>
                                <div class="input-group">
                                    {!! Form::select('org_branch', $organization_branches, $_GET['org_branch'] ?? null, ['class'=>'form-control','placeholder'=>'ALL']) !!}
                                </div>
                            </div>
                            <div class="col-sm-3 my-1">
                                <label class="" for="start_date_en">Transaction Date(AD)
                                    : </label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="start_date_en"
                                           name="start_date_en" placeholder="Start Date En"
                                           value="{{$_GET['start_date_en'] ?? null}}">
                                </div>
                            </div>
                            <div class="col-sm-3 my-1">
                                <label class="" for="start_date">Transaction Date(BS)
                                    : </label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="start_date"
                                           name="start_date" placeholder="Start Date"
                                           value="{{$_GET['start_date'] ?? null}}"
                                           readonly>
                                </div>
                            </div>
                            <div class="col-sm-3 my-1">
                                <label class="" for="end_date_en">Mature Date(AD)
                                    : </label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="end_date_en"
                                           name="end_date_en" placeholder="End Date En"
                                           value="{{$_GET['end_date_en'] ?? null}}">
                                </div>
                            </div>
                            <div class="col-sm-3 my-1">
                                <label class="" for="end_date">Mature Date(BS)
                                    : </label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="end_date"
                                           name="end_date" placeholder="End Date"
                                           value="{{$_GET['end_date'] ?? null}}"
                                           readonly>
                                </div>
                            </div>
                            <div class="col-sm-2 mt-4">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                {{--                                        <label for="">Clear All</label>--}}
                                <a href="{{route('deposit-org-branch')}}" class="btn btn-danger">Reset</a>
                            </div>
                        </div>


                    </form>
                    <div class="row">
                        <div id="printableArea" class="col-xl-12">
                            <h4 class="">
                                Deposit by Organization Branch
                            </h4>
                            <div class="row">
                                <div class="col-md-12 freezeHeaderTableContainer">
                                    <table class="table-bordered table freezeHeaderTable">
                                        <thead>
                                        <th>SN</th>
                                        <th>Organization Branch</th>
                                        <th>Total Deposit</th>
                                        <th>Estimated Earning</th>
                                        </thead>
                                        <tbody>
                                        @php $i=1 @endphp

                                        @foreach($details as $detail)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$detail['organization_branch']}}</td>
                                                <td>{{$detail['total_deposit']}}</td>
                                                <td>{{$detail['estimated_earning']}}</td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="2" style="text-align:right;">Total</td>
                                            <td style="text-align:center;"
                                                colspan="">{{$total_deposits}}</td>
                                        </tr>
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
        // $("#fiscal_year_id").on("change", function () {
        //     $('#organization-branch-deposit').submit();
        // });
        //
        // $("#quarter").on("change", function () {
        //     $('#organization-branch-deposit').submit();
        // });

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

        function nepadate() {
            var start_date = $('#start_date').val();
            var new_date = start_date.split('-');
            yes_date = new_date[1] + '/' + new_date[2] + '/' + new_date[0];
            $('#end_date_en').prop('disabled', false);
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
                    // $('#depositFilter').submit();
                }
            });
        }

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


        function enddate() {
            var start_date = $('#start_date').val();
            var new_date = start_date.split('-');
            yes_date = new_date[1] + '/' + new_date[2] + '/' + new_date[0];

            $('#end_date').nepaliDatePicker({
                disableBefore: yes_date,
                npdMonth: true,
                npdYear: true,
                npdYearCount: 10,

                onChange: function (e) {
                    $('#end_date_en').val(BS2AD($('#end_date').val()));
                    // $('#depositFilter').submit();
                }

            });
        }

        $(document).ready(function () {
            if ($('#start_date').val() !== '' && $('#end_date').val() !== '') {
                $('#start_date_en').val(BS2AD($('#start_date').val()));
                $('#end_date_en').val(BS2AD($('#end_date').val()));
            }

            /* if ($('#start_date').val() !== '' && $('#end_date').val() !== '') {
                 $('#start_date_en').val(BS2AD($('#start_date').val()));
                 $('#end_date_en').val(BS2AD($('#end_date').val()));
             }*/
        });

    </script>
    <script src="{{asset('js/print.js')}}"></script>
@endsection
