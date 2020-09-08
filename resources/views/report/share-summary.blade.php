@extends('layouts.master')
@section('title','Share Summary')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            Share Summary Report
                            <div class="card-header-rights">
                                <a onclick="printDiv('printableArea')" class="btn btn-sm btn-dropbox">
                                    Print <i class="fa fa-print"></i>
                                </a>
                                <a href="{{route('report-share-summary-export',$_GET)}}" class="btn btn-sm btn-dribbble">
                                    Export <i class="fa-file-excel-o"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{route('report-share-summary')}}" method="get">
                                <div class="row">
                                    <div class="col-sm-2 my-1">
                                        <label class="" for="fiscal_year_id">Fiscal
                                            Year</label>
                                        <div class="input-group">
                                            {{Form::select('fiscal_year_id',$fiscal_years,$_GET['fiscal_year_id'] ?? null,['class'=>'form-control','placeholder'=>'All'])}}
                                        </div>
                                    </div>
                                    <div class="col-sm-2 my-1">
                                        <label class="" for="start_date">From (AD)
                                            : </label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="start_date" name="start_date"
                                                   placeholder="Start Date"
                                                   value="{{$_GET['start_date'] ?? null}}"
                                                   readonly>
                                        </div>
                                    </div>

                                    <div class="col-sm-2 my-1">
                                        <label class="" for="start_date_np">From (BS)
                                            : </label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="start_date_np" name="start_date_np"
                                                   placeholder="Start Date (BS)"
                                                   value="{{$_GET['start_date_np'] ?? null}}"
                                                   readonly>
                                        </div>
                                    </div>

                                    <div class="col-sm-2 my-1">
                                        <label class="" for="end_date">To (AD)
                                            : </label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="end_date" name="end_date"
                                                   placeholder="End Date"
                                                   value="{{$_GET['end_date'] ?? null}}"
                                                   readonly>
                                        </div>
                                    </div>

                                    <div class="col-sm-2 my-1">
                                        <label class="" for="end_date_np">To (BS)
                                            : </label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="end_date_np" name="end_date_np"
                                                   placeholder="End Date (BS)"
                                                   value="{{$_GET['end_date_np'] ?? null}}"
                                                   readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 my-1">
                                        <label class="" for="institution_code">Organization Name</label>
                                        <div class="input-group">
                                            {{Form::select('institution_code',$institutions,$_GET['institution_code'] ?? null,['class'=>'form-control','placeholder'=>'All'])}}
                                        </div>
                                    </div>
                                    <div class="col-sm-2 my-1">
                                        <label class="" for="investment_subtype_id">
                                            Investment Sector</label>
                                        <div class="input-group">
                                            {{Form::select('invest_subtype_id',$investment_sectors,$_GET['invest_subtype_id'] ?? null,['class'=>'form-control','placeholder'=>'All'])}}

                                        </div>
                                    </div>
                                    <div class="col-sm-1 text-right">
                                        <button type="submit" class="btn btn-primary form-group">Submit</button>
                                        <a href="{{route('report-share-summary')}}" class="btn btn-danger">Reset</a>
                                    </div>
                                </div>
                            </form>
                            <div class="row">
                                <div id="printableArea" class="col-xl-12 freezeHeaderTableContainer">
                                    @include('report.share-summary-table')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.deleteModal')
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            $('form').keydown(function (event) {
                // enter has keyCode = 13, change it if you want to use another button
                if (event.keyCode == 13) {
                    $(this).submit();
                    return false;
                }
            });
        });
        $('#start_date,#end_date').flatpickr()

        $('#start_date').change(function () {
            let start_date_en = $('#start_date').val();
            if (start_date_en != '') {
                $('#start_date_np').val(AD2BS(start_date_en));
            } else {
                $('#start_date_np').val('');
            }
        });

        $('#end_date').change(function () {
            let end_date_en = $('#end_date').val();
            if (end_date_en != '') {
                $('#end_date_np').val(AD2BS(end_date_en));
            } else {
                $('#end_date_np').val('');
            }
        });

        $('#start_date_np').nepaliDatePicker({
            npdMonth: true,
            npdYear: true,
            npdYearCount: 10,
            onChange: function (e) {
                $('#start_date').val(BS2AD($('#start_date_np').val()));
            }
        });
        $('#end_date_np').nepaliDatePicker({
            npdMonth: true,
            npdYear: true,
            npdYearCount: 10,
            onChange: function (e) {
                $('#end_date').val(BS2AD($('#end_date_np').val()));
            }
        });
    </script>
    <script src="{{asset('js/print.js')}}"></script>
@endsection
