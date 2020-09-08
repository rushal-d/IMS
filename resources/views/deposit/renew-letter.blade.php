@extends('layouts.master')
@section('title', 'Renew Letter')

@section('styles')
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                @if(empty($renewLetter))
                    <p>Please set up the organization first here <a href="{{route('userorganization.index')}}" class="btn btn-sm btn-primary">Setup Organization</a></p>
                @else
                {{ Form::open(['route' => ['renew-letter.update', $deposit->id], 'method' => 'PATCH']) }}
                    <textarea class="form-control ok" name="okay" rows="60">
                        @if($deposit->renew_letter != null)
                            {{$deposit->renew_letter}}
                        @else
                            {{strtr($renewLetter, array('%%date%%' => $deposit->created_at->format('Y-m-d'), '%%bank_name%%' => $deposit->institute->institution_name, '%%branch_name%%' => $deposit->branch->branch_name ?? '',
                                                        '%%account_number%%' => $deposit->accountnumber ?? "N/A", '%%deposit_amount%%' => $deposit->deposit_amount ?? '',
                                                        '%%in_words%%' => $money->get($deposit->deposit_amount ?? 0), '%%interest_rate%%' => $deposit->next_interest_rate ?? $deposit->interest_rate ?? '', '%%document_no%%' => $deposit->document_no ?? '',
                                                        '%%duration_months%%' => $months ?? "N/A", '%%interest_method%%' => config('constants.investment_payment_methods')[$deposit->interest_payment_method] ?? "N/A",
                                                        '%%debit_bank%%' => $deposit->debit_bank->institution_name ?? $deposit->institute->institution_name ??  '',
                                                        '%%debit_bank_account_number%%' => $deposit->debit_account_number ?? '', '%%todays_date%%' => $todays_date))}}
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
