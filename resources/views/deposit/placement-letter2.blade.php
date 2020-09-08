@extends('layouts.master')
@section('title', 'Placement Letter 2')

@section('styles')
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                @if(empty($placementLetter2))
                    <p>Please set up the organization first here <a href="{{route('userorganization.index')}}" class="btn btn-sm btn-primary">Setup Organization</a></p>
                @else
                {{ Form::open(['route' => ['placement-letter2.update', $deposit->id], 'method' => 'PATCH']) }}
                    <textarea class="form-control ok" name="okay" rows="60">
                        @if($deposit->placement_letter2 != null)
                            {{$deposit->placement_letter2}}
                        @else
                            {{strtr($placementLetter2, array('%%date%%' => $deposit->created_at->format('Y-m-d'), '%%bank_name%%' => $deposit->institute->institution_name ?? $deposit->bank->institution_name ?? '',
                                                            '%%branch_name%%' => $deposit->branch->branch_name ?? $deposit->bank_branch->branch_name ?? '',
                                                            '%%deposit_amount%%' => $deposit->deposit_amount ?? '', '%%in_words%%' => $money->get($deposit->deposit_amount ?? 0) ?? '',
                                                            '%%interest_rate%%' => $deposit->interest_rate ?? '', '%%account_number%%' => $deposit->accountnumber ?? "N/A",
                                                            '%%another_bank_name%%' => $another_bank ?? '', '%%document_no%%' => $deposit->document_no ?? '', '%%duration_months%%' => $months ?? '',
                                                            '%%interest_method%%' => config('constants.investment_payment_methods')[$deposit->interest_payment_method] ?? '',
                                                            '%%interest_credited_bank%%' => $deposit->bank->institution_name ?? $deposit->institute->institution_name ?? '',
                                                            '%%interest_credited_branch%%' => $deposit->bank_branch->branch_name ?? $deposit->branch->branch_name ?? '',
                                                            '%%debit_bank_branch%%' => $deposit->debit_branch->branch_name ?? '', '%%cheque_bank%%' => $deposit->cheque_bank->institution_name ?? '',
                                                            '%%debit_bank%%' => $deposit->debit_bank->institution_name ?? $deposit->institute->institution_name ?? '',
                                                            '%%todays_date%%' => $todays_date))}}
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

        $(document).ready(function() {
            $("#myselection").change(function () {
                var a = $("#myselection option:selected").text();
                console.log(a);
                $("div#yeiho").text(a);
            });
        });

    </script>

@endsection
