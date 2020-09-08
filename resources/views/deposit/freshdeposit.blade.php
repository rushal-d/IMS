@extends('layouts.master')
@section('title','Fresh Deposits')
@section('styles')

@endsection
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i>
                            Fresh Deposit

                            <div class="card-header-rights">

                                <i class="fas fa-chart-line"></i> Total: {{ $deposits->count() ?? '' }}

                            </div>
                        </div>
                        <div class="card-body">
                            <form id="depositFilter" action="{{route('fresh-deposit')}}" method="get">
                                <div class="row">
                                    <div class="col-sm-2 my-1">
                                        <label class="" for="fiscal_year_id">
                                            Fiscal Year</label>
                                        <div class="input-group">
                                            {{Form::select('fiscal_year_id',$fiscal_years->pluck('code','id'),$_GET['fiscal_year_id'] ?? $fiscal_years->where('status',1)->first()->id ?? null,['class'=>'form-control','placeholder'=>'ALL'])}}
                                        </div>
                                    </div>

                                    <div class="col-sm-4 my-1">
                                        <label class="" for="institution_id">
                                            Bank Name</label>
                                        <div class="input-group">
                                            {!! Form::select('institution_id',$institutes,$_GET['institution_id'] ?? null,['class'=>'form-control','placeholder'=>'ALL']) !!}
                                        </div>
                                    </div>


                                    <div class="col-sm-2 my-1">
                                        <label class="" for="bank">Branch
                                            Name</label>
                                        <div class="input-group">
                                            {!! Form::select('branch_id',$branches,$_GET['branch_id'] ?? null,['class'=>'form-control','placeholder'=>'ALL']) !!}
                                        </div>
                                    </div>

                                    <div class="col-sm-2 my-1">
                                        <label class="" for="investment_subtype_id">
                                            Deposit Type</label>
                                        <div class="input-group">
                                            {!! Form::select('investment_subtype_id',$investment_subtypes,$_GET['investment_subtype_id'] ?? null,['class'=>'form-control','placeholder'=>'ALL']) !!}
                                        </div>
                                    </div>


                                    <div class="col-sm-2 my-1">
                                        <label class="" for="organization_branch_id">Organization Branch</label>
                                        <div class="input-group">
                                            {!! Form::select('organization_branch_id',$organization_branches,$_GET['organization_branch_id'] ?? null,['class'=>'form-control','placeholder'=>'ALL']) !!}
                                        </div>
                                    </div>


                                    <div class="col-sm-4 mt-4">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        <a href="{{route('fresh-deposit')}}" class="btn btn-danger">Reset</a>
                                        <a href="{{route('fresh-deposit',$_GET)}}{{count($_GET)==0 ? '?':'&'}}export=1"
                                           class="btn btn-warning">Export</a>
                                    </div>
                                </div>
                            </form>
                            <div class="mt-2"></div>
                            <div class="row">
                                <div class="col-xl-12 ">
                                    <div class="card">
                                        <div class="card-header" id="placement-deposit-section">
                                            Fresh Deposit

                                            <div class="float-right">
                                                {{--<a href="#placement-deposit-section" type="button" class="btn btn-sm btn-primary">Go
                                                    To Placement</a>--}}
                                                <a href="#renew-deposit-section" type="button" class="btn btn-sm btn-warning">Go
                                                    To Renew</a>
                                                <a href="#withdraw-deposit-section" type="button" class="btn btn-sm btn-danger">Go
                                                    To Withdraw</a>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="freezeHeaderTableContainer">
                                                @include('deposit.freshdeposit.placement')
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-xl-12 ">
                                    <div class="card">
                                        <div class="card-header" id="renew-deposit-section">
                                            Renew At Period

                                            <div class="float-right">
                                                <a href="#placement-deposit-section" type="button" class="btn btn-sm btn-primary">Go
                                                    To Placement</a>
                                                {{--<a href="#renew-deposit-section" type="button" class="btn btn-sm btn-warning">Go
                                                    To Renew</a>--}}
                                                <a href="#withdraw-deposit-section" type="button" class="btn btn-sm btn-danger">Go
                                                    To Withdraw</a>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="freezeHeaderTableContainer">
                                                @include('deposit.freshdeposit.renew')
                                            </div>
                                        </div>
                                    </div>

                                </div>


                                <div class="col-xl-12 ">
                                    <div class="card">
                                        <div class="card-header" id="withdraw-deposit-section">
                                            Fresh Withdraw
                                            <div class="float-right">
                                                <a href="#placement-deposit-section" type="button" class="btn btn-sm btn-primary">Go
                                                    To Placement</a>
                                                <a href="#renew-deposit-section" type="button" class="btn btn-sm btn-warning">Go
                                                    To Renew</a>
                                                {{--<a href="#withdraw-deposit-section" type="button" class="btn btn-sm btn-danger">Go
                                                    To Withdraw</a>--}}
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="freezeHeaderTableContainer">
                                                @include('deposit.freshdeposit.withdraw')
                                            </div>
                                        </div>
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


        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });

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


        $('#start_date_en,#end_date_en,#interest_start_date_en,#interest_end_date_en').flatpickr();

        $('#start_date_en').change(function () {
            let start_date_en = $('#start_date_en').val();
            if (start_date_en != '') {
                $('#start_date').val(AD2BS(start_date_en));
            } else {
                $('#start_date').val('');
            }

        });


        $('#end_date_en').change(function () {
            let end_date_en = $('#end_date_en').val();
            if (end_date_en != '') {
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


        $('.downexcel').on("click", function () {
            $('#depositFilter').attr('action', '{{route('deposit.excel')}}');
            $('#depositFilter').submit();
            $('#depositFilter').attr('action', '{{route('deposit.index')}}');
        });
    </script>




@endsection
