@extends('layouts.master')
@section('title', 'Fiscal year')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i>
                            Fiscal year
                            <div class="card-header-actions">
                                <a href="#" class="card-header-action btn-minimize" data-toggle="collapse" data-target="#collapseExamples" aria-expanded="true">
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-5">
                                    <form id="maindiv" method="post"
                                          action="{{route('fiscalyear.store')}}"
                                          enctype="multipart/form-data">
                                      @csrf
                                      <input type="hidden" name="status" value="0">
                                        <div class="form-group row">
                                          <label for="start_date" class="col-sm-3 col-form-label">Start Date</label>
                                          <div class="col-sm-9">
                                              <input type="text" class="form-control nep-date" id="start_date" name="start_date" placeholder="Start Date (BS)"
                                                     value="{{ old('start_date') }}" readonly>
                                                <input type="hidden" id="start_date_en" name="start_date_en"  readonly data-validation="required">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="end_date" class="col-sm-3 col-form-label">End Date</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control nep-date" id="end_date" name="end_date" placeholder="End Date (BS)"
                                                       value="{{ old('end_date') }}" readonly>
                                                <input type="hidden" id="end_date_en" name="end_date_en" readonly data-validation="required">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="code" class="col-sm-3 col-form-label">Fiscal Year</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="fiscal_code" name="code"
                                                       placeholder="code" value=" {{ old('code') }}" readonly data-validation="required">
                                            </div>
                                        </div>
                                        <div style="text-align: center">
                                            <button type="submit" class="btn btn-primary">
                                                    Submit
                                            </button>
                                            <button type="reset" class="btn btn-outline-secondary" value="Reset">Clear</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-xl-7">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Start Date</th>
                                                    <th>End Date</th>
                                                    <th>Fiscal Year</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @if(!empty($fiscalyears))
                                                @foreach($fiscalyears as $fiscalyear)
                                                <tr>
                                                    <td>{{$fiscalyear->start_date}} ({{$fiscalyear->start_date_en}})</td>
                                                    <td>{{$fiscalyear->end_date}} ({{$fiscalyear->end_date_en}})</td>
                                                    <td>{{$fiscalyear->code}}</td>
                                                    <td>
                                                        <span class="btn btn-pill btn-{{  ($fiscalyear->status == '1') ? 'success' : 'danger' }}">
                                                            {{ $fiscalyear->status=='1'? 'Active':'Deactive' }}
                                                        </span>
                                                    </td>
                                                    <td class="td-actions">
                                                        <a href="{{route('fiscalyear.edit',$fiscalyear->id)}}" class="btn btn-success btn-sm"><i class="fa fa-edit"></i>Edit</a>
                                                        <a href="javascript:void(0)" data-id="{{ $fiscalyear->id }}" class="btn btn-danger btn-sm btndel">
                                                            <i class="fa fa-times"></i>Delete
                                                        </a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            @endif
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
    @include('layouts.deleteModal')
@endsection
@section('scripts')
    <script>
        var yes_date = '';
        $('#start_date').nepaliDatePicker({
            closeOnDateSelect: true,
            npdMonth: true,
            npdYear: true,
            npdYearCount: 20,
            onChange: function(e){
                $('#start_date_en').val(BS2AD($('#start_date').val()));
                nepadate();
                generateFiscalYearCode()
            }
        });

        function nepadate(){
            var start_date = $('#start_date').val();
            var new_date = start_date.split('-');
            yes_date = new_date[1]+'/'+new_date[2]+'/'+new_date[0];

            $('#end_date').nepaliDatePicker({
                disableBefore:yes_date,
                npdMonth: true,
                npdYear: true,
                npdYearCount: 20,
                onChange: function(e){
                    $('#end_date_en').val(BS2AD($('#end_date').val()));
                    generateFiscalYearCode();
                    console.log(yes_date);
                },
            });
        }

        $('#fiscal_code').focus(function(){
            generateFiscalYearCode()
        });
        $(document).ready(function () {
           generateFiscalYearCode();
        });
        function generateFiscalYearCode(){
            var from_date = $('#start_date').val();
            var to_date = $('#end_date').val();


            var fiscal_code = '';
            var fiscal_code_first = '';
            var fiscal_code_last = '';
            if(from_date != ''){
                fiscal_code_first = from_date.split('-')[0];
            }
            if(to_date != ''){
                var fiscal_code_last_split = to_date.split('-')[0];
                fiscal_code_last = fiscal_code_last_split.substr(2,4);
            }
            fiscal_code= fiscal_code_first + '/' +  fiscal_code_last;
            if(fiscal_code != '/') {
                $('#fiscal_code').val(fiscal_code).blur();
            }
        }

        $('.btndel').click(function(e){
            e.preventDefault();
            var del_url = '{{ URL::to('fiscalyear') }}/'+$(this).data('id');
            console.log(del_url);
            $('#firstform')[0].setAttribute('action', del_url);
            $('#deleteModal')
                .modal('show')
            ;
        });
    </script>
@endsection
