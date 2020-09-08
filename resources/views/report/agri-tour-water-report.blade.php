@extends('layouts.master')
@section('title','Investment Report')
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
            <div class="row">
                <div class="col-sm-12 col-md-12 col-xl-12">
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
                        <form id="investment-report" action="{{route('agri-tour-water-report')}}" method="get">
                            <div class="card-body">
                                <div class="row col-xl-8 offset-3">
                                    <div class="col-sm-4 my-1">
                                        <label class="" for="fiscal_year_id"><sup class="required-field">*</sup>Fiscal
                                            Year</label>
                                        <div class="input-group">
                                            <select name="fiscal_year_id" id="fiscal_year_id" class="form-control"
                                                    required>
                                                @foreach($fiscal_years as $fiscal_year)
                                                    <option value="{{$fiscal_year->id}}"
                                                            @if(!empty($_GET['fiscal_year_id'] ))
                                                            @if(($_GET['fiscal_year_id'] ?? null) == $fiscal_year->id)
                                                            selected
                                                            @endif
                                                            @elseif ($fiscal_year->status==1)
                                                            selected
                                                            @endif
                                                    >{{$fiscal_year->code}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 my-1">
                                        <label class="" for="months">Quarter : </label>
                                        {!! Form::select('quarter',$quarters,$quarter ?? null,['class'=>'form-control','id'=>'quarter','placeholder'=>'Select Quarter']) !!}
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div id="printableArea" class="col-xl-12">
                            <h4 class="text-center">
                                <u>
                                    अनुसूची - ३ <br>
                                    लगानीको विवरण <br>
                                    दफा (१३) संग सम्बन्धित
                                </u>
                            </h4>

                            <b>
                                <p>बीमकको नाम : {{$organization->organization_name ?? ''}}</p>
                                <p>पेश गर्नुपर्ने अवधि :</p>
                                <p>पेस भएको अवधि : {{$quarters[$quarter] ?? ''}} </p>
                                <p> पेस भएको मिति : {{\App\Helpers\BSDateHelper::AdToBsEn('-',date('Y-m-d'))}}</p>
                            </b>

                            <table class="table-bordered table">
                                <tr>
                                    <td rowspan="3">SN</td>
                                    <td rowspan="3">Investment Sector</td>
                                    <td colspan="9">Present quarter</td>
                                </tr>
                                <tr>
                                    <td colspan="3">Loan Investment</td>
                                    <td colspan="3">Cash Investment</td>
                                    <td colspan="3">Total Investment</td>
                                </tr>
                                <tr>
                                    <td>Initial</td>
                                    <td>Current</td>
                                    <td>Total</td>
                                    <td>Initial</td>
                                    <td>Current</td>
                                    <td>Total</td>
                                    <td>Initial</td>
                                    <td>Current</td>
                                    <td>Total</td>
                                </tr>
                                @foreach($investment_areas as $name=> $investment_area)
                                    <tr>
                                        <td>{{$i++}}</td>
                                        <td>{{$name}}</td>
                                        <td>{{$investment_area['initial_loan_amount']}}</td>
                                        <td>{{$investment_area['present_loan_amount']}}</td>
                                        <td>{{$investment_area['initial_loan_amount']+$investment_area['present_loan_amount']}}</td>
                                        <td>{{$investment_area['initial_cash_amount']}}</td>
                                        <td>{{$investment_area['present_cash_amount']}}</td>
                                        <td>{{$investment_area['initial_cash_amount']+$investment_area['present_cash_amount']}}</td>

                                        <td>{{$investment_area['initial_loan_amount']+$investment_area['initial_cash_amount']}}</td>
                                        <td>{{$investment_area['present_loan_amount']+$investment_area['present_cash_amount']}}</td>
                                        <td>{{$investment_area['initial_loan_amount']+$investment_area['present_loan_amount']+$investment_area['initial_cash_amount']+$investment_area['present_cash_amount']}}</td>
                                    </tr>
                                @endforeach
                            </table>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $("#fiscal_year_id").on("change", function () {
            $('#investment-report').submit();
        });

        $("#quarter").on("change", function () {
            $('#investment-report').submit();
        });


    </script>
    <script src="{{asset('js/print.js')}}"></script>
@endsection
