<table class="table freezeHeaderTable">
    <thead>
    <tr>
        <th>Institution Name</th>
        <th>Branch</th>
        <th>Org. Branch</th>
        <th>Renew. Date</th>
        <th>FD No.</th>
        <th>Class</th>
        <th>Deposit Amount</th>
        <th>Rate</th>
    </tr>
    </thead>
    <tbody>
    @foreach($renews as $deposit)
        <tr>
            <td>
                <a href="{{route('deposit.show', $deposit->child->id)}}">{{$deposit->institute->institution_name ?? $deposit->child->account_head ?? ''}} @if(!empty($deposit->institute->mergedTo))
                        ({{ $deposit->institute->mergedTo->institution_code ?? '' }}
                        )@endif
                </a>
                @if(!empty($deposit->approved_by))
                    <i class="fas fa-certificate" data-toggle="tooltip"
                       data-placement="top" title="Approved Record"></i>
                @endif
            </td>
            <td>{{$deposit->child->branch->branch_name ?? 'NA'}}</td>
            <td>{{$deposit->child->organization_branch->branch_name ?? 'NA'}}</td>
            <td>{{$deposit->child->trans_date_en ?? ''}}</td>
            <td>{{$deposit->child->document_no}}</td>
            <td>{{$deposit->child->deposit_type->name ?? 'N/A'}}</td>
            <td>{{$deposit->child->deposit_amount}}</td>
            <td>{{$deposit->child->interest_rate}}</td>

        </tr>
    @endforeach

    <tr>
        <td colspan="5">Total</td>
        <td>{{$renews->sum('child.deposit_amount')}}</td>
        <td></td>
    </tr>
    </tbody>
</table>