@extends('layouts.master')
@section('title','Deposit Interest Calculation Report')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-xl-12">
                    <div class="card">
                        <div class="card-header">

                            <div class="card-header-rights">
                                <a href="{{route('report-interest-calc-print',$_GET)}}" target="_blank"
                                   class="btn btn-sm btn-dropbox">
                                    Print <i class="fa fa-print"></i>
                                </a>
                                &nbsp;
                                <button class="downexcel btn btn-sm btn-dribbble">
                                    Export to Excel <i class="far fa-file-excel"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="depositFilter" action="{{route('report-interest-calc')}}" method="get">
                                <div class="row">
                                    <div class="col-sm-2 my-1">
                                        <label class="" for="fiscal_year_id"><sup class="required-field">*</sup>Fiscal
                                            Year</label>
                                        <div class="input-group">
                                            <select name="fiscal_year_id" id="fiscal_year_id" class="form-control">
                                                <option value="">All</option>
                                                @foreach($fiscal_years as $fiscal_year)
                                                    <option value="{{$fiscal_year->id}}"
                                                            @if(isset($_GET['fiscal_year_id']))
                                                            @if($_GET['fiscal_year_id'] == $fiscal_year->id)
                                                            selected
                                                            @endif
                                                            @endif
                                                    >{{$fiscal_year->code}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-2 my-1">
                                        <label class="" for="interest_start_date_en">Calc. Interest From (En)
                                            : </label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="interest_start_date_en"
                                                   name="interest_start_date_en" placeholder="Start Date En"
                                                   value="{{$_GET['interest_start_date_en'] ?? null}}">
                                        </div>
                                    </div>

                                    <div class="col-sm-2 my-1">
                                        <label class="" for="interest_start_date">Calculate Interest From
                                            : </label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="interest_start_date"
                                                   name="interest_start_date" placeholder="Start Date"
                                                   value="{{$_GET['interest_start_date'] ?? null}}"
                                                   readonly>
                                        </div>
                                    </div>

                                    <div class="col-sm-2 my-1">
                                        <label class="" for="end_date">Calc. Interest To (En)
                                            : </label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="interest_end_date_en"
                                                   name="interest_end_date_en" placeholder="End Date"
                                                   value="{{$_GET['interest_end_date_en'] ?? null}}">
                                        </div>
                                    </div>

                                    <div class="col-sm-2 my-1">
                                        <label class="" for="end_date">Calculate Interest To
                                            : </label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="interest_end_date"
                                                   name="interest_end_date" placeholder="End Date"
                                                   value="{{$_GET['interest_end_date'] ?? null}}"
                                                   readonly>

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
                                                            @if(isset($_GET['investment_subtype_id']))
                                                            @if($_GET['investment_subtype_id'] == $investment_subtype->id)
                                                            selected
                                                            @endif
                                                            @endif
                                                    >{{$investment_subtype->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-sm-1 offset-sm-10">
                                        <label for="" style="visibility: hidden;">Submit</label>
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            Submit
                                        </button>
                                    </div>

                                    <div class="col-sm-1">
                                        <label for="">Clear All</label>
                                        <a href="{{route('report-interest-calc')}}" class="btn btn-danger">Reset</a>
                                    </div>
                                </div>
                            </form>
                            @if($show_index)
                                <div class="row">
                                       @include('report.lgi.interest-calculation-report-table')
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        $('#interest_start_date_en,#interest_end_date_en').flatpickr();


        $('#interest_start_date_en').change(function () {
            $('#interest_start_date').val(AD2BS($('#interest_start_date_en').val()));
            enddate();
            /*$('#interest_end_date_en').flatpickr({
                minDate: $('#interest_start_date_en').val()
            });*/
        });

        $('#end_date_en').change(function () {
            $('#end_date').val(AD2BS($('#end_date_en').val()));
            // $('#depositFilter').submit();
        });

        $('#interest_end_date_en').change(function () {
            $('#interest_end_date').val(AD2BS($('#interest_end_date_en').val()));
            // $('#depositFilter').submit();
        });

        $('.btndel').click(function (e) {
            e.preventDefault();
            var del_url = '{{ URL::to('deposit') }}/' + $(this).data('id');
            console.log(del_url);
            $('#firstform')[0].setAttribute('action', del_url);
            $('#deleteModal')
                .modal('show')
            ;
        });

        $('.btndelwithdraw').click(function (e) {
            e.preventDefault();
            var del_url = '{{ URL::to('deposit/withdraw/delete') }}/' + $(this).data('id');
            console.log(del_url);
            $('#firstform')[0].setAttribute('action', del_url);
            $('#deleteModal')
                .modal('show')
            ;
        });

        $('.btnwithdraw').click(function (e) {
            e.preventDefault();
            var del_url = '{{ URL::to('deposit/withdraw') }}/' + $(this).data('id');
            console.log(del_url);

            $('#secondform')[0].setAttribute('action', del_url);
            $('#withdrawModal')
                .modal('show')
            ;
        });


        $(document).on('click', '.submiteee', function () {
            alert('i am clicked submit');
            $('#depositFilter').submit();
        });


        $(document).ready(function () {
            var delay = (function () {
                var timer = 0;
                return function (callback, ms) {
                    clearTimeout(timer);
                    timer = setTimeout(callback, ms);
                };
            })();

            $("#estimated_days").keyup(function () {
                var days = $('#estimated_days').val();

                delay(function () {
                    // $('#depositFilter').submit();
                }, 3000);
            });
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
                    // $('#depositFilter').submit();
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

        $('#interest_start_date').nepaliDatePicker({
            npdMonth: true,
            npdYear: true,
            npdYearCount: 10,
            onChange: function (e) {
                $('#interest_start_date_en').val(BS2AD($('#interest_start_date').val()));
                var end_date = $('#interest_end_date').val();
                enddate();
                $('#interest_end_date_en').prop('disabled', false);
                $('#interest_end_date_en').flatpickr({
                    minDate: $('#interest_start_date_en').val()
                });
                if (end_date !== '') {
                    // $('#depositFilter').submit();
                }
            }
        });


        function enddate() {
            var start_date = $('#interest_start_date').val();
            var new_date = start_date.split('-');
            yes_date = new_date[1] + '/' + new_date[2] + '/' + new_date[0];

            $('#interest_end_date').nepaliDatePicker({
                disableBefore: yes_date,
                npdMonth: true,
                npdYear: true,
                npdYearCount: 10,

                onChange: function (e) {
                    $('#interest_end_date_en').val(BS2AD($('#interest_end_date').val()));
                    // $('#depositFilter').submit();
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

        $('.downexcel').on("click", function () {
            $('#depositFilter').attr('action', '{{route('report-interest-calc-excel')}}');
            $('#depositFilter').submit();
            $('#depositFilter').attr('action', '{{route('report-interest-calc')}}');

        });
    </script>
    <script src="{{asset('js/print.js')}}"></script>
@endsection
