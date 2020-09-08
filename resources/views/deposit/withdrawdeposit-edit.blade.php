@extends('layouts.master')
@section('title','Deposit-Withdraw Edit')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <i class="fa fa-align-justify"></i>
                            Deposit - Withdraw
                        </div>
                        <div class="col-6 text-right">
                            <a href="{{route('deposit.withdraw-letter', $withdraw->id)}}" class="btn btn-sm btn-warning">@if($withdraw->withdraw_letter != null) <i class="fas fa-check"></i> @endif Withdraw</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{route('deposit.withdrawupdate',$withdraw->id)}}">
                        @csrf
                        {{method_field('PATCH')}}
                        <div class="row">
                            <input type="hidden" name="deposit_id" value="{{$deposit->id}}">
                            <input type="hidden" name="withdraw_amount"
                                   value="{{$deposit->deposit_amount}}">
                            <div class="card-body">
                                <div class="col-xl-10 offset-1 row">
                                    <div class="col-xl-6">
                                        <ul class="list-group">
                                            <li class="list-group-item">Fiscal Year
                                                : {{$deposit->fiscalyear->code}}</li>
                                            <li class="list-group-item">Transaction Date
                                                : {{$deposit->trans_date_en}} ({{$deposit->trans_date}})
                                            </li>
                                            <li class="list-group-item">Mature Date
                                                : {{$deposit->mature_date_en}}
                                                ( {{$deposit->mature_date}})
                                            </li>
                                            <li class="list-group-item">No of Days
                                                : {{$deposit->days}} </li>
                                            <li class="list-group-item">Institution Name
                                                :{{$deposit->institute->institution_name}}</li>
                                            <li class="list-group-item">Branch
                                                :{{$deposit->branch->branch_name}}</li>
                                            <li class="list-group-item">Interest Payment Method
                                                : {{ $deposit->interest_payment_method }}</li>
                                            <li class="list-group-item">Account Number
                                                : {{ $deposit->accountnumber }}</li>
                                        </ul>
                                    </div>
                                    <div class="col-xl-6">
                                        <ul class="list-group">
                                            <li class="list-group-item">Deposit Type
                                                : {{$deposit->deposit_type->name}}</li>
                                            <li class="list-group-item">Document Number
                                                : {{$deposit->document_no}}</li>
                                            <li class="list-group-item">Reference Number
                                                : {{$deposit->reference_number}}</li>
                                            <li class="list-group-item">Deposit Amount
                                                : {{$deposit->deposit_amount}}</li>
                                            <li class="list-group-item">Interest Rate
                                                : {{$deposit->interest_rate}}</li>
                                            <li class="list-group-item">Estimated
                                                Earning: {{$deposit->estimated_earning}}</li>
                                            <li class="list-group-item">Interest Credited
                                                Bank: {{$deposit->bank->institution_name ?? ''}}</li>
                                            <li class="list-group-item">Interest Credited
                                                Branch: {{$deposit->bank_branch->branch_name ?? ''}}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm-4">
                                <label class="">Account Number</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="acc_no" name="withdraw_account_no"
                                           value="{{$withdraw->withdraw_account_no}}">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <label class=""><sup
                                            class="required-field">*</sup>Bank Name</label>
                                <div class="input-group">
                                    {!! Form::select('withdraw_bank_id',$institutes->pluck('institution_name','id'),$withdraw->withdraw_bank_id ?? null,['class'=>'form-control','id'=>'institution_id','placeholder'=>'Select Bank', 'data-validation' => 'required']) !!}
                                </div>
                            </div>
                            <div class="col-sm-4 my-1">
                                <label class=""><sup
                                            class="required-field">*</sup>Bank Branch</label>
                                <div class="input-group">
                                    <select name="withdraw_bank_branch_id" id="branch_id"
                                            class="form-control bank_branch"
                                            data-validation="required"
                                            data-validation-error-msg="Select Bank Branch">
                                        <option value="">Select Bank Branch</option>
                                        @foreach($bankbranches as $bankbranch)
                                            <option value="{{$bankbranch->id}}"
                                                    @if($bankbranch->id == $withdraw->withdraw_bank_branch_id) selected @endif>
                                                {{$bankbranch->branch_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <label class="" for="withdrawdate"><sup class="required-field">*</sup>Withdraw
                                    Date(AD)</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="withdrawdate_en"
                                           name="withdrawdate_en" data-validation="required"
                                           placeholder="withdraw date"
                                           value="{{$withdraw->withdrawdate_en}}"
                                           data-validation-format="yyyy-mm-dd" readonly>
                                </div>
                            </div>

                            <div class="col-sm-4 ">
                                <label class="" for="withdrawdate"><sup class="required-field">*</sup>Withdraw
                                    Date(BS)</label>
                                <div class="input-group">
                                    <input type="text" class="form-control nep-date" id="withdrawdate"
                                           name="withdrawdate" data-validation="required"
                                           placeholder="withdraw date"
                                           value="{{$withdraw->withdrawdate}}"
                                           data-validation-format="yyyy-mm-dd" readonly>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <label for="">Notes</label>
                                <textarea name="notes" id="notes" cols="30" rows="10"
                                          class="form-control">{{$withdraw->notes}}
                                                </textarea>
                            </div>
                        </div>
                        <div style="text-align: center; padding: 2%;">
                            <button type="submit" class="btn btn-primary">
                                Edit Withdraw
                            </button>
                        </div>
                        <div style="text-align: center; padding: 2%;">
                            @if(empty($withdraw->approved_by))
                                <button type="button" class="btn btn-danger approval">
                                    Approve Deposit
                                </button>
                            @else
                                <button type="button" class="btn btn-danger approval">
                                    Approved By {{$withdraw->approvalUser->name ?? ''}}
                                </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $('#withdrawdate_en').flatpickr();

        $('#withdrawdate_en').change(function () {
            $('#withdrawdate').val(AD2BS($('#withdrawdate_en').val()));
        });

        $('#withdrawdate').nepaliDatePicker({
            npdMonth: true,
            npdYear: true,
            npdYearCount: 10,
            onChange: function (e) {
                $("#withdrawdate").blur();
                $('#withdrawdate_en').val(BS2AD($('#withdrawdate').val()));
            }
        });

        $('.approval').click(function () {
            $this = $(this);
            $.ajax({
                url: '{{route('deposit.withdraw.approve',$withdraw->id)}}',
                type: 'POST',
                data: {
                    '_token': '{{csrf_token()}}'
                }, success: function (response) {
                    $this.text(response);
                }, error: function (response) {
                    console.log(response.responseText);
                    $this.text(response.responseText);
                }
            })
        });
    </script>
@endsection
