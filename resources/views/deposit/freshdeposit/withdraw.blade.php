<table class="table freezeHeaderTable">
    <thead>
    <tr>
        <th>Institution Name</th>
        <th>Branch</th>
        <th>Org. Branch</th>
        <th>Withd. Date</th>
        <th>FD No.</th>
        <th>Class</th>
        <th>Deposit Amount</th>
        <th>Rate</th>
    </tr>
    </thead>
    <tbody>
    @foreach($withdraws as $deposit)
        <tr>
            <td>
                <a href="{{route('deposit.show', $deposit->id)}}">{{$deposit->institute->institution_name ?? $deposit->account_head ?? ''}} @if(!empty($deposit->institute->mergedTo))
                        ({{ $deposit->institute->mergedTo->institution_code ?? '' }}
                        )@endif
                </a>
                @if(!empty($deposit->approved_by))
                    <i class="fas fa-certificate" data-toggle="tooltip"
                       data-placement="top" title="Approved Record"></i>
                @endif
            </td>
            <td>{{$deposit->branch->branch_name ?? 'NA'}}</td>
            <td>{{$deposit->organization_branch->branch_name ?? 'NA'}}</td>
            <td>{{$deposit->withdraw->withdrawdate_en ?? ''}}</td>
            <td>{{$deposit->document_no}}</td>
            <td>{{$deposit->deposit_type->name ?? 'N/A'}}</td>
            <td>{{$deposit->deposit_amount}}</td>
            <td>{{$deposit->interest_rate}}</td>

        </tr>
    @endforeach

    <tr>
        <td colspan="5">Total</td>
        <td>{{$withdraws->sum('deposit_amount')}}</td>
        <td></td>
    </tr>
    </tbody>
</table>