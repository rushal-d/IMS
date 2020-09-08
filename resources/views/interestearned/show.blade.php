@extends('layouts.master')
@section('title',' Actual Interest Earned')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i>
                            Actual Interest Earned Show

                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="form-group  row">
                                        <label for="amount" class="col-sm-4 col-form-label"><sup
                                                    class="required-field">*</sup>Amount</label>
                                        <div class="col-sm-8">
                                            {{$interestearned->amount}}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="description" class="col-sm-4 col-form-label">Date (AD)</label>
                                        <div class="col-sm-8">
                                            {{$interestearned->date_en}}
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="description" class="col-sm-4 col-form-label">Date (BS)</label>
                                        <div class="col-sm-8">
                                            {{$interestearned->date}}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="description" class="col-sm-4 col-form-label">Notes</label>
                                        <div class="col-sm-8">
                                            {{$interestearned->notes}}
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
        $('#date_en').flatpickr();

        $('#date_en').change(function () {
            $('#date').val(AD2BS($('#date_en').val()));
        });

        $('#date').nepaliDatePicker({
            npdMonth: true,
            npdYear: true,
            npdYearCount: 10,
            onChange: function (e) {
                $("#date").blur();
                $('#date_en').val(BS2AD($('#date').val()));
            }
        });

    </script>
@endsection