@extends('layouts.master')
@section('title','Investment Request Show')

@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form method="post" class="" action="{{route('investment-request.update',$investmentRequest->id)}}">
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-xl-6">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-12">
                                        <i class="fa fa-align-justify"></i>
                                        Investment Request - Show
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-12">

                                        <div class="form-group row">
                                            <label class="col-md-4" for="inlineFormInputGroupUsername">Date (AD)</label>
                                            <div class="col-md-8">
                                                {{$investmentRequest->request_date_en}}
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-4" for="inlineFormInputGroupUsername">Date (BS)</label>
                                            <div class="col-md-8">
                                                {{$investmentRequest->request_date}}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-4" for="inlineFormInputGroupUsername">Bank
                                            </label>
                                            <div class="col-md-8">
                                                {{$investmentRequest->institution->institution_name ?? 'N/A'}}
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-4" for="inlineFormInputGroupUsername">Bank
                                                Branch</label>
                                            <div class="col-md-8">
                                                {{$investmentRequest->branch->branch_name ?? 'N/A'}}
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-4" for="inlineFormInputGroupUsername">Amount</label>
                                            <div class="col-md-8">
                                                {{$investmentRequest->deposit_amount}}
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-4" for="inlineFormInputGroupUsername">Interest
                                                Rate</label>
                                            <div class="col-md-8">
                                                {{$investmentRequest->interest_rate}}
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-4" for="inlineFormInputGroupUsername">Days</label>
                                            <div class="col-md-8">
                                                {{$investmentRequest->days}} Days
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-4" for="inlineFormInputGroupUsername">Interest Payment
                                                Method</label>
                                            <div class="col-md-8">
                                                {{$investment_payment_methods[$investmentRequest->interest_payment_method] ?? ''}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-xl-6">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-12">
                                        <i class="fa fa-align-justify"></i>
                                        Investment Request- Show
                                    </div>

                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-12">


                                        <div class="form-group row">
                                            <label class="col-md-4" for="inlineFormInputGroupUsername">Organization
                                                Branch</label>
                                            <div class="col-md-8">
                                                {{$investmentRequest->organization_branch->branch_name ?? 'N/A'}}
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-4" for="inlineFormInputGroupUsername">Staff
                                            </label>
                                            <div class="col-md-8">
                                                {{$investmentRequest->staff->name ?? 'N/A'}}
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-4" for="inlineFormInputGroupUsername">Created By
                                            </label>
                                            <div class="col-md-8">
                                                {{$investmentRequest->created_by->name ?? 'N/A'}}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-4" for="inlineFormInputGroupUsername">Updated By
                                            </label>
                                            <div class="col-md-8">
                                                {{$investmentRequest->updated_by->name ?? 'N/A'}}
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-4" for="inlineFormInputGroupUsername">Status
                                            </label>
                                            <div class="col-md-8">
                                                {{Form::select('status',$investment_request_status,$investmentRequest->status,array('class'=>'form-control','id'=>'staff_id','placeholder'=>'Select Status'))}}

                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-4" for="notes">Note</label>
                                            <div class="col-md-8">
                                                {{$investmentRequest->remarks}}
                                            </div>
                                        </div>

                                        <div class="text-center">

                                            @if(empty($investmentRequest->deposit))
                                                <button type="submit" class="btn btn-primary">Update Status</button>
                                                @if($investmentRequest->status==2)
                                                    <a href="{{route('investment.request.to.deposits',$investmentRequest->id)}}"
                                                       class="btn btn-primary">Create Deposit</a>
                                                @endif
                                            @else
                                                <a href="#" class="btn btn-primary">Deposit Already Created</a>
                                            @endif
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>



@endsection
@section('scripts')

@endsection
