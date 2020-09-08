@extends('layouts.master')
@section('title', 'Placement Letter')

@section('styles')
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                @if(empty($placementLetter))
                    <p>Please set up the organization first here <a href="{{route('userorganization.index')}}" class="btn btn-sm btn-primary">Setup Organization</a></p>
                @else
                {{ Form::open(['route' => ['placement-letter1.update', $deposit->id], 'method' => 'PATCH']) }}
                    <textarea class="form-control ok" name="okay" rows="60">
                        @if($deposit->placement_letter != null)
                            {{$deposit->placement_letter}}
                        @else
                            {{ strtr($placementLetter, array('%%bank_name%%' => $deposit->institute->institution_name ?? $deposit->bank->institution_name ?? '', '%%date%%' => $deposit->created_at->format('Y-m-d') ?? '',
                                                            '%%branch_name%%' => $deposit->branch->branch_name ?? $deposit->bank_branch->branch_name ?? '',
                                                            '%%deposit_amount%%' => $deposit->deposit_amount ?? '', '%%in_words%%' => $money->get($deposit->deposit_amount ?? "0") ?? "N/A", '%%account_number%%' => $deposit->accountnumber ?? "N/A",
                                                            '%%interest_rate%%' => $deposit->interest_rate ?? '', '%%document_no%%' => $deposit->document_no ?? '', '%%interest_method%%' => config('constants.investment_payment_methods')[$deposit->interest_payment_method] ?? '',
                                                            '%%duration_months%%' => $months ?? '', '%%interest_credited_branch%%' => $deposit->bank_branch->branch_name ?? $deposit->branch->branch_name ?? '',
                                                            '%%interest_credited_bank%%' => $deposit->bank->institution_name ?? $deposit->institute->institution_name ?? '',
                                                            '%%debit_bank%%' => $deposit->debit_bank->institution_name ?? $deposit->institute->institution_name ??  '',
                                                            '%%debit_bank_account_number%%' => $deposit->debit_account_number ?? '',
                                                            '%%debit_bank_branch%%' => $deposit->debit_branch->branch_name ?? '', '%%cheque_bank%%' => $deposit->cheque_bank->institution_name ?? '',
                                                            '%%todays_date%%' => $todays_date)) }}
                        @endif
                    </textarea>
                    <div class="col-lg-12 text-center mb-1" style="margin-top: 5px;">
                        <button type="submit" id="submit-button" class="btn btn-primary">
                            Save
                        </button>
                    </div>
                {!! Form::close() !!}
                @endif
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        CKEDITOR.replace("okay", {
            tabSpaces: 5
        });
    </script>

@endsection
