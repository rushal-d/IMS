@extends('layouts.master')
@section('title','Agri. Tour. Water Investment Show')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">

            <div class="row">
                <div class="col-sm-12 col-md-12 col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i>
                            Agri. Tour. Water Investment Show
                        </div>
                        <div class="card-body">
                            @csrf
                            <div class="row">

                                <div class="col-sm-4 my-1">
                                    <label class="" for="date_en">Transaction Date
                                        (AD)</label>
                                    <div class="input-group">
                                        <p>{{$investment->date_en}}</p>
                                    </div>
                                </div>
                                <div class="col-sm-4 my-1">
                                    <label class="" for="date">Transaction
                                        Date (BS)</label>
                                    <div class="input-group">
                                        <p>{{$investment->date}}</p>
                                    </div>
                                </div>
                                <div class="col-sm-4 my-1">
                                    <label class="" for="date">Investment
                                        Type</label>
                                    <div class="input-group">
                                        <p>{{$investment_through[$investment->type]?? ''}}</p>
                                    </div>
                                </div>

                                <div class="col-sm-4 my-1">
                                    <label class="" for="date">Investment
                                        Area</label>
                                    <div class="input-group">
                                        <p>{{$investment_areas[$investment->investment_area] ?? ''}}</p>
                                    </div>
                                </div>

                                <div class="col-sm-4 my-1">
                                    <label class="" for="date">Amount</label>
                                    <div class="input-group">
                                    <p>{{$investment->amount}}</p>
                                    </div>
                                </div>
                                <div class="col-sm-12 my-1">
                                    <label class="" for="date">Remarks</label>
                                    <div class="input-group">
                                        <p>{{$investment->remarks}}</p>
                                    </div>
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
