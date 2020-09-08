@extends('layouts.master')
@section('title','Active Deposit At Date')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="float-left">
                                <h5>Active Deposit At Date</h5>
                            </div>

                            <div class="float-right">
                                <a href="{{route('active-deposit-at-date-excel',$_GET)}}"
                                   class=" btn btn-sm btn-dribbble">
                                    Export to Excel <i class="far fa-file-excel"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="active-deposit-at-date" action="" method="get">
                                <div class="row">
                                    <div class="col-sm-2 my-1">
                                        <label class="" for="fiscal_year_id">Fiscal
                                            Year</label>
                                        <div class="input-group">
                                            {!! Form::select('fiscal_year_id',$fiscal_years,$_GET['fiscal_year_id'] ?? $current_fiscal_year_id ??'',['class'=>'form-control','id'=>'fiscal-year-id','placeholder'=>'Select Fiscal Year']) !!}
                                        </div>
                                    </div>

                                    <div class="col-sm-2 my-1">
                                        <label class="" for="start_date_en">Start Date (En)
                                            : </label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="start_date_en"
                                                   name="start_date_en" placeholder="Start Date En"
                                                   value="{{$_GET['start_date_en'] ?? null}}">
                                        </div>
                                    </div>

                                    <div class="col-sm-2 my-1">
                                        <label class="" for="start_date">Start Date
                                            : </label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="start_date"
                                                   name="start_date" placeholder="Start Date"
                                                   value="{{$_GET['start_date'] ?? null}}"
                                                   readonly>
                                        </div>
                                    </div>

                                    <div class="col-sm-2 my-1">
                                        <label class="" for="end_date_en">End Date (En)
                                            : </label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="end_date_en"
                                                   name="end_date_en" placeholder="End Date"
                                                   data-validation="date_selector_validation"
                                                   value="{{$_GET['end_date_en'] ?? null}}">
                                        </div>
                                    </div>

                                    <div class="col-sm-2 my-1">
                                        <label class="" for="end_date">End Date
                                            : </label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="end_date"
                                                   name="end_date" placeholder="End Date"
                                                   value="{{$_GET['end_date'] ?? null}}"
                                                   readonly>

                                        </div>

                                    </div>

                                    <div class="col-sm-4 my-1">
                                        <label class="" for="fiscal_year_id">
                                            Institution Name
                                        </label>
                                        <div class="input-group">
                                            {!! Form::select('institution_id',$institutions,$_GET['institution_id'] ?? null,['class'=>'form-control','id'=>'institution-id','placeholder'=>'Select Bank']) !!}

                                        </div>
                                    </div>

                                    <div class="col-sm-2 my-1">
                                        <label class="" for="branch_id">
                                            Bank Branch
                                        </label>
                                        <div class="input-group">
                                            {!! Form::select('branch_id',$branches,$_GET['branch_id'] ?? null,['class'=>'form-control','id'=>'branch-id','placeholder'=>'Select Bank Branch']) !!}

                                        </div>
                                    </div>

                                    <div class="col-sm-2 my-1">
                                        <label class="" for="branch_id">
                                            Org. Branch
                                        </label>
                                        <div class="input-group">
                                            {!! Form::select('organization_branch_id',$organizaion_branches,$_GET['organization_branch_id'] ?? null,['class'=>'form-control','id'=>'organization-branch-id','placeholder'=>'Select Org. Branch']) !!}

                                        </div>
                                    </div>

                                    <div class="col-sm-2 my-1">
                                        <label class="" for="fiscal_year_id">
                                            Deposit Type
                                        </label>
                                        <div class="input-group">
                                            {!! Form::select('invest_subtype_id',$invest_sub_types,$_GET['invest_subtype_id'] ?? null,['class'=>'form-control','id'=>'invest-subtype-id','placeholder'=>'Select Deposit Type']) !!}

                                        </div>
                                    </div>

                                    <div class="col-sm-2 mt-4">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        <a href="{{route('active-deposit-at-date')}}" class="btn btn-danger">Reset</a>
                                    </div>
                                </div>
                            </form>
                            <br>
                            @include('report.active-deposit-at-date-table')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $.formUtils.addValidator({
            name: 'date_selector_validation',
            validatorFunction: function (value, $el, config, language, $form) {
                if (value != '' && value != 0) {
                    let start_date = $('#start_date_en').val();
                    return (start_date != '');
                }
                return true;
            },
            errorMessage: 'Start Date Must Be Selected if End Date is Selected',
            errorMessageKey: 'badEvenNumber'
        });

        $('#start_date_en,#end_date_en').flatpickr();


        $('#start_date_en').change(function () {
            let start_date_en = $('#start_date_en').val()
            if (start_date_en != null && start_date_en != '') {
                $('#start_date').val(AD2BS(start_date_en));
            } else {
                $('#start_date').val('');
            }
        });

        $('#end_date_en').change(function () {
            let end_date_en = $('#end_date_en').val()
            if (end_date_en != null && end_date_en != '') {
                $('#end_date').val(AD2BS(end_date_en));
            } else {
                $('#end_date').val('');
            }

        });

        $('#start_date').nepaliDatePicker({
            npdMonth: true,
            npdYear: true,
            npdYearCount: 10,
            onChange: function (e) {
                $('#start_date_en').val(BS2AD($('#start_date').val()));
            }
        });

        $('#end_date').nepaliDatePicker({
            npdMonth: true,
            npdYear: true,
            npdYearCount: 10,
            onChange: function (e) {
                $('#end_date_en').val(BS2AD($('#end_date').val()));
            }
        });

    </script>

@endsection