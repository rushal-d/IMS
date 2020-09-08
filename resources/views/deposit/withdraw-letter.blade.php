@extends('layouts.master')
@section('title', 'Withdraw Letter')

@section('styles')
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                @if(empty($withdrawLetter))
                    <p>Please set up the organization first here <a href="{{route('userorganization.index')}}" class="btn btn-sm btn-primary">Setup Organization</a></p>
                @else
                {{ Form::open(['route' => ['withdraw-letter.update', $deposit->id], 'method' => 'PATCH']) }}
                    <textarea class="form-control ok" name="okay" rows="60">
                        @if($deposit->withdraw_letter != null)
                            {{$deposit->withdraw_letter}}
                        @else
                            {{strtr($withdrawLetter, array('%%date%%' => $deposit->created_at->format('Y-m-d'), '%%bank_name%%' => $deposit->deposit->institute->institution_name ?? '',
                                                            '%%branch_name%%' => $deposit->deposit->branch->branch_name ?? $deposit->withdrawbranch->branch_name ?? '',
                                                            '%%document_no%%' => $deposit->deposit->document_no, '%%deposit_amount%%' => $deposit->withdraw_amount,
                                                            '%%account_number%%' => $deposit->withdraw_account_no ?? $deposit->accountnumber ?? "N/A",
                                                            '%%in_words%%' => $money->get($deposit->withdraw_amount ?? 0), '%%todays_date%%' => $todays_date,
                                                            '%%interest_credited_branch%%' => $deposit->withdrawbranch->branch_name ?? $deposit->deposit->branch->branch_name ?? $deposit->deposit->bank_branch->branch_name ?? '',
                                                            '%%withdraw_bank%%' => $deposit->withdrawbank->institution_name ?? '', '%%withdraw_branch%%' => $deposit->withdrawbranch->branch_name))}}
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
