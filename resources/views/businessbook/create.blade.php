@extends('layouts.master')
@section('title','Business Book Create')

@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">

            <div class="row">
                <div class="col-sm-12 col-md-12 col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i>
                            Business Book - Create
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-12">
                                    <form method="post" class="" action="{{route('businessbook.store')}}">
                                        @csrf
                                        <div class="form-group row">
                                            <label class="col-md-4" for="inlineFormInputGroupUsername">Date (AD)</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" id="date_en"
                                                       name="date_en" placeholder="Date AD" data-validation="required">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-4" for="inlineFormInputGroupUsername">Date (BS)</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control nep-date" id="date"
                                                       name="date" placeholder="Date BS" data-validation="required"
                                                       data-validation-format="yyyy-mm-dd" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-4" for="inlineFormInputGroupUsername">Organization
                                                Branch</label>
                                            <div class="col-md-8">
                                                <select name="organization_branch_id" id="organization_branch_id"
                                                        class="form-control" data-validation="required">
                                                    <option value=""></option>
                                                    @foreach($organization_branches as $organization_branch)
                                                        <option value="{{$organization_branch->id}}">{{$organization_branch->branch_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-4" for="amount">Amount</label>
                                            <div class="col-md-8">
                                                <input type="number" min="0" step="0.01" class="form-control"
                                                       name="amount" id="amount" data-validation="required">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-4" for="notes">Note</label>
                                            <div class="col-md-8">
                                                <textarea name="notes" class="form-control" id="" cols="30"
                                                          rows="10"></textarea>
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">Save</button>
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
