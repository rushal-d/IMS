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
                            Actual Interest Earned

                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-12">

                                    <form id="maindiv" method="post"
                                          action="{{route('interestearnedentry.update',$interestearned->id)}}">
                                        {{method_field('PATCH')}}
                                        @csrf
                                        <input type="hidden" name="deposit_id" value="{{$interestearned->deposit_id}}">
                                        <div class="form-group  row">
                                            <label for="amount" class="col-sm-4 col-form-label"><sup
                                                        class="required-field">*</sup>Amount</label>
                                            <div class="col-sm-8">
                                                <input type="number" step="0.01" class="form-control" id="amount"
                                                       name="amount"
                                                       value="{{ old('amount',$interestearned->amount) }}"
                                                       data-validation="required">
                                            </div>
                                        </div>

                                        <div class="form-group  row">
                                            <label for="amount" class="col-sm-4 col-form-label">Tax</label>
                                            <div class="col-sm-8">
                                                <input type="number" step="0.01" class="form-control" id="tax"
                                                       name="tax"
                                                       value="{{ old('tax',$interestearned->tax) }}">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="description" class="col-sm-4 col-form-label">Date (AD)</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" name="date_en" id="date_en"
                                                       data-validation="required" value="{{$interestearned->date_en}}">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="description" class="col-sm-4 col-form-label">Date (BS)</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" name="date" id="date" readonly
                                                       data-validation="required" value="{{$interestearned->date}}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="description" class="col-sm-4 col-form-label">Notes</label>
                                            <div class="col-sm-8">
                                                <textarea name="notes" id="notes" class="form-control" cols="30"
                                                          rows="10">{{ $interestearned->notes}}
                                                </textarea>
                                            </div>
                                        </div>
                                        <div style="text-align: center">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                            <button type="reset" class="btn btn-outline-secondary" value="Reset">Clear
                                            </button>
                                        </div>
                                    </form>
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