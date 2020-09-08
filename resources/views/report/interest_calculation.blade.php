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
                                <a href="{{route('report-interest-calc-print',$_GET)}}" target="_blank" class="btn btn-sm btn-dropbox">
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
                                    <div id="printableArea" class="col-xl-12  freezeHeaderTableContainer">
                                        <table class="table table-bordered table-responsive freezeHeaderTable">
                                            <thead>
                                            <tr>
                                                <th>Fiscal Year</th>
                                                <th>Start Date</th>
                                                <th>Mature Date</th>
                                                <th>Bank</th>
                                                <th>Deposit Type</th>
                                                <th>Duration (Days)</th>
                                                <th>FD Number</th>
                                                <th>Deposit Amount</th>
                                                <th>Interest Rate/Year</th>
                                                <th>Estimated Earning</th>
                                                <th>Interest Calc. Start</th>
                                                <th>Interest Calc. End</th>
                                                <th>Status</th>
                                                <th>Received Interest</th>
                                                <th>Accured Interest</th>
                                            </tr>
                                            </thead>
                                            <?php $total_interest_amount = 0; ?>
                                            @if(count($deposits) > 0)
                                                @foreach($deposits as $deposit)
                                                    <tr class="@if($deposit['status'] == 4)  @elseif($deposit['status'] == 3) rowexpire
                                                @elseif($deposit['status'] == 2) rowalert @else rowalive @endif">
                                                        <td>{{$deposit['fiscal_code']}}</td>
                                                        <td>{{$deposit['trans_date_en']}}</td>
                                                        <td>{{$deposit['mature_date_en']}}</td>
                                                        <td>{{$deposit['institution_name']}}
                                                            , {{$deposit['branch_name'] or ''}}</td>
                                                        <td>{{$deposit['deposit_type']}}</td>
                                                        <td>{{$deposit['days']}} days</td>
                                                        <td>{{$deposit['fd_number']}}</td>
                                                        <td>{{$deposit['deposit_amount']}}</td>
                                                        <td>{{$deposit['interest_rate']}}</td>
                                                        <td>{{$deposit['estimated_earning']}}</td>
                                                        <td>{{$deposit['interest_start']}}</td>
                                                        <td>{{$deposit['interest_end']}}</td>
                                                        <?php $total_interest_amount += $deposit['estimated_earning'];  ?>
                                                        <td>@if($deposit['status'] == 1)
                                                                Active
                                                            @elseif($deposit['status'] == 2)
                                                                Renew Soon
                                                            @elseif($deposit['status'] == 3)
                                                                Expired
                                                            @elseif($deposit['status'] == 4)
                                                                Renewed
                                                            @else
                                                                WithDrawn
                                                            @endif
                                                        </td>
                                                        <td>{{$deposit['received_interest']}}</td>
                                                        <td>{{$deposit['accured_interest']}}</td>

                                                    </tr>

                                                @endforeach
                                                <tr>
                                                    <td colspan="9" style="text-align:right;">Total</td>
                                                    <td style="text-align:left;"
                                                        colspan="6">{{ $total_interest_amount }}</td>
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
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.deleteModal')
    <div class="modal fade" id="withdrawModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"><i class="far fa-trash-alt"></i> Confirm WithDraw</h4>
                </div>
                <form id="secondform" action="" method="get">
                    <div class="modal-body">
                        Are you Sure You Want To WithDraw ?
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary modal-delete">Yes
                        </button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
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

        /*$("#fiscal_year_id").on("change", function () {
            $('#depositFilter').submit();
        });

        $("#institution_id").on("change", function () {
            $('#depositFilter').submit();
        });

        $("#investment_subtype_id").on("change", function () {
            $('#depositFilter').submit();
        });

        $("#branch_id").on("change", function () {
            $('#depositFilter').submit();
        });

        $("#status").on("change", function () {
            $('#depositFilter').submit();
        });

        $("#mature_days").on("change", function () {
            $('#depositFilter').submit();
        });*/

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
