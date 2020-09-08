@extends('layouts.master')
@section('title','Deposit % Report')
@section('styles')
    <style>
        .table-bordered th, .table-bordered td {
            border: 1px solid #c8ced3;
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
                    Deposit % Report
                    <div class="card-header-rights">
                        <a onclick="printPortraitDiv('printableArea')" class="btn btn-sm btn-dropbox">
                            Print <i class="fa fa-print"></i>
                        </a>
                        &nbsp
                    </div>
                </div>
                <form id="investment-report" action="{{route('institution.deposit.percentage')}}" method="get">
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

                            <div class="col-sm-3 my-1">
                                <label class="" for="months">Upto Date : </label>
                                {!! Form::text('upto_date',$_GET['upto_date'] ?? null,['class'=>'form-control flatpickr','id'=>'quarter','placeholder'=>'Select Upto Date']) !!}
                            </div>
                            <div class="col-sm-1">
                                <button class="btn btn-sm btn-primary btn-cleardate" type="button">Clear Date</button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <div id="printableArea" class="col-xl-12">
                        <h4 class="text-center">
                            Deposit Percentage
                        </h4>
                        <div class="row">
                            @foreach($investment_sector_records as $investment_sector=>$institutions)

                                <div class="col-md-4">
                                    <table class="table-bordered table">
                                        <thead>
                                        <th>SN</th>
                                        <th>Institution Name [{{$investment_sector}}]</th>
                                        <th>Amount</th>
                                        <th>Total Percentage</th>
                                        </thead>
                                        <tbody>
                                        @php $i=1 @endphp
                                        @foreach($institutions as $institution_name=>$amount)
                                            <tr>
                                                <td>{{$i++}}</td>
                                                <td>{{$institution_name}}</td>
                                                <td>{{$amount}} </td>
                                                <td>{{round(($amount/$technical_reserve)*100,3)}} %</td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td>{{$i++}}</td>
                                            <td>Total</td>
                                            <td>{{array_sum($institutions)}} </td>
                                            <td>{{round((array_sum($institutions)/$technical_reserve)*100,3)}} %</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            @endforeach
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

        $(".flatpickr").on("change", function () {
            $('#investment-report').submit();
        });
        $('.flatpickr').flatpickr()
        $('.btn-cleardate').click(function () {
            $('.flatpickr').val('')
            $('.flatpickr').trigger('change')
        })
    </script>
    <script src="{{asset('js/print.js')}}"></script>
@endsection
