@extends('layouts.master')
@section('title','Investment Report')
@section('styles')
    <style>
        .table-bordered th, .table-bordered td {
            border: 1px solid #c8ced3;
            /* text-align: center; */
            text-align: left;
        }

        #printableArea {
            padding: 10px;
        }

        .blink_me {
            color: red;
            animation: blinker 3s linear infinite;
        }

        .fa-check-circle {
            color: green;
        }

        @keyframes blinker {
            50% {
                opacity: 0;
            }
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
                        </div>
                    </div>
                </form>
                <div id="printableArea">
                    <h4 class="text-center">
                        Investment Sector Percentage
                    </h4>

                    <table class="table table-bordered">
                        <thead>
                        <th>Investment Sector</th>
                        <th>Limit</th>
                        <th>Occured</th>
                        <th>Status</th>
                        </thead>

                        <tbody>

                        @if(!empty($investment_sector))

                            @foreach($investment_sector as $sector_name=> $sector)
                                <tr>
                                    <td>{{$sector_name}}</td>
                                    <td>{{$sector['to_be_percentage']}}%</td>
                                    <td>{{$sector['present_percentage']}}%</td>
                                    <td>
                                        @if($sector['status'])
                                            <i class="far fa-check-circle"></i>
                                        @else
                                            <i class="fa fa-exclamation-triangle blink_me"
                                               aria-hidden="true"></i>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <div class="text-center"><a class="btn btn-danger"
                                                        href="{{ route('technicalReserve.index')  }}">Please
                                    enter Technical Reserve for selected fiscal year! </a></div>
                        @endif

                        </tbody>
                    </table>

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
