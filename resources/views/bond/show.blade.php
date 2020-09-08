@extends('layouts.master')
@section('title','Bond-Show')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-xl-8">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i>
                            Bond - Show
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="row">
                                        <div class="col-sm-4 my-1">
                                            <label class="" for="fiscal_year_id"><sup class="required-field">*</sup>Fiscal
                                                Year</label>
                                            <div class="input-group">
                                                <select name="fiscal_year_id" id="fiscal_year_id" class="form-control"
                                                        data-validation="required">
                                                    <option value="">{{$bond->fiscalyear->code}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 my-1">
                                            <label class="" for="trans_date"><sup class="required-field">*</sup>Transaction
                                                Date En</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="trans_date"
                                                       name="trans_date" placeholder="transaction date"
                                                       value="{{$bond->trans_date_en}}" readonly
                                                       data-validation="required">
                                            </div>
                                        </div>
                                        <div class="col-sm-4 my-1">
                                            <label class="" for="trans_date"><sup class="required-field">*</sup>Transaction
                                                Date</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control nep-date" id="trans_date"
                                                       name="trans_date" placeholder="transaction date"
                                                       value="{{$bond->trans_date}}" readonly
                                                       data-validation="required">
                                            </div>
                                        </div>

                                        <div class="col-sm-4 my-1">
                                            <label class="" for="days"><sup class="required-field">*</sup>Duration
                                                (Days)</label>
                                            <div class="input-group">
                                                <input type="number" min="0" class="form-control"
                                                       value="{{$bond->days}}" name="days" id="days" placeholder="days"
                                                       data-validation="required">
                                            </div>
                                        </div>
                                        <div class="col-sm-4 my-1">
                                            <label class="" for="mature_date"><sup class="required-field">*</sup>Mature
                                                Date</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control nep-date" id="mature_date"
                                                       name="mature_date" placeholder="mature date"
                                                       value="{{$bond->mature_date}}" readonly
                                                       data-validation="required">
                                            </div>
                                        </div>
                                        <div class="col-sm-4 my-1">
                                            <label class="" for="mature_date"><sup class="required-field">*</sup>Mature
                                                Date</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control nep-date" id="mature_date"
                                                       name="mature_date" placeholder="mature date"
                                                       value="{{$bond->mature_date}}" readonly
                                                       data-validation="required">
                                            </div>
                                        </div>

                                        <div class="col-sm-4 my-1">
                                            <label class="" for="inlineFormInputGroupUsername"><sup
                                                        class="required-field">*</sup>Organization Name</label>
                                            <div class="input-group">
                                                <select name="institution_id" id="institution_id" class="form-control"
                                                        data-validation="required">
                                                    <option value="">{{$bond->institute->institution_name}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 my-1">
                                            <label class="" for="inlineFormInputGroupUsername"><sup
                                                        class="required-field">*</sup>Organization Branch</label>
                                            <div class="input-group">
                                                <select name="organization_branch" id="organization_branch" class="form-control"
                                                        data-validation="required">
                                                    <option value="">{{$bond->organization_branch->branch_name}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 my-1">
                                            <label class="" for="inlineFormInputGroupUsername"><sup
                                                        class="required-field">*</sup>Receipt Location</label>
                                            <div class="input-group">
                                                <select name="receipt_location" id="receipt_location" class="form-control"
                                                        data-validation="required">
                                                    <option value="">{{config('constants.receipt_location')[$bond->receipt_location_id]}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 my-1">
                                            <label class="" for="inlineFormInputGroupUsername"><sup
                                                        class="required-field">*</sup>Interest Payment Method</label>
                                            <div class="input-group">
                                                <select name="interest_payment_method" id="interest_payment_method" class="form-control"
                                                        data-validation="required">
                                                    <option value="">{{config('constants.investment_payment_methods')[$bond->interest_payment_method_id]}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 my-1">
                                            <label class="" for="investment_subtype_id"><sup
                                                        class="required-field">*</sup>Bond Type</label>
                                            <div class="input-group">
                                                <select name="investment_subtype_id" id="investment_subtype_id"
                                                        class="form-control" data-validation="required">
                                                    <option value="">{{$bond->bond_type->name}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 my-1">
                                            <label class="" for="interest_rate"><sup class="required-field">*</sup>Interest
                                                rate/year</label>
                                            <div class="input-group">
                                                <input type="number" step="0.01"
                                                       data-validation-allowing="range[1.00;100.00], float"
                                                       class="form-control" value="{{$bond->interest_rate}}"
                                                       name="interest_rate" id="interest_rate" data-validation="number">
                                            </div>
                                        </div>


                                        <div class="col-sm-4 my-1">
                                            <label class="" for="rateperunit"><sup class="required-field">*</sup>Par
                                                Value</label>
                                            <div class="input-group">
                                                <input type="number" step="0.01" class="form-control"
                                                       data-validation-allowing="float" name="rateperunit"
                                                       id="rateperunit"
                                                       placeholder="par value" value="{{$bond->rateperunit}}"
                                                       data-validation="required">
                                            </div>
                                        </div>
                                        <div class="col-sm-4 my-1">
                                            <label class="" for="totalunit"><sup class="required-field">*</sup>Total
                                                Unit</label>
                                            <div class="input-group">
                                                <input type="number" min="0" class="form-control"
                                                       value="{{$bond->totalunit}}" name="totalunit" id="totalunit"
                                                       placeholder="totalunit" data-validation="required">
                                            </div>
                                        </div>
                                        <div class="col-sm-4 my-1">
                                            <label class="" for="totalamount"><sup class="required-field">*</sup>Total
                                                Amount</label>
                                            <div class="input-group">
                                                <input type="text" min="0" class="form-control"
                                                       value="{{$bond->totalamount}}" name="totalamount"
                                                       id="totalamount" readonly data-validation="required">
                                            </div>
                                        </div>

                                        <div class="col-sm-6 my-1">
                                            <label class="" for="estimated_earning"><sup class="required-field">*</sup>Estimated
                                                Earning</label>
                                            <div class="input-group">
                                                <input type="number" data-validation-allowing="float"
                                                       value="{{$bond->estimated_earning}}" class="form-control"
                                                       name="estimated_earning" id="estimated_earning" readonly
                                                       data-validation="required">
                                            </div>
                                        </div>
                                        {{---third column--}}

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i>
                            Bond - Show
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="row">
                                        <div class="col-sm-6 my-1">
                                            <label class="" for="totalamount">Reference Number</label>
                                            <div class="input-group">
                                                <input type="text" min="0" class="form-control"
                                                       value="{{$bond->reference_number}}" name="reference_number"
                                                       id="reference_number">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 my-1">
                                            <label class="" for="alert_days"><sup class="required-field">*</sup>Alert
                                                Days</label>
                                            <div class="input-group">
                                                <input type="text" min="0" class="form-control"
                                                       value="{{$bond->alert_days}}" name="alert_days" id="alert_days"
                                                       data-validation="required">
                                            </div>
                                        </div>

                                        <div class="col-sm-6 my-1">
                                            <label class="" for="status"><sup
                                                        class="required-field">*</sup>Status</label>
                                            <div class="input-group">
                                                <select name="status" id="status" class="form-control"
                                                        data-validation="required">
                                                    <option value="1" @if($bond->status == 1) selected @endif>Active
                                                    </option>
                                                    <option value="2" @if($bond->status == 2) selected @endif>Loan
                                                    </option>
                                                    <option value="3" @if($bond->status == 3) selected @endif>Matured
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 my-1">
                                            <label class="" for="unitdetails">Details</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" value="{{$bond->unitdetails}}"
                                                       name="unitdetails" id="unitdetails">
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
