<table class="table freezeHeaderTable">
    <thead>
    <tr>
        <th>Institution Name</th>
        <th>Branch</th>
        <th>Org. Branch</th>
        <th>Mat. Date</th>
        <th>Class</th>
        <th>Deposit Amount</th>
        <th>Status</th>
        <th>Renew Rate</th>
        <th>Rate</th>
        @for($year=1;$year<=$number_of_years;$year++)
            <th>{{$year}} Year Before</th>
        @endfor
    </tr>
    </thead>
    <tbody>
    @foreach($deposits as $deposit)
        <tr>
            <td>{{$deposit->institute->institution_name ?? 'N/A'}}</td>
            <td>{{$deposit->branch->branch_name ?? 'NA'}}</td>
            <td>{{$deposit->organization_branch->branch_name ?? 'NA'}}</td>
            <td>{{$deposit->mature_date_en ?? 'NA'}}</td>
            <td>{{$deposit->deposit_type->name ?? 'NA'}}</td>
            <td>{{$deposit->deposit_amount ?? 'NA'}}</td>
            <td>
                @if($deposit->status==5)
                    Withdrawn
                @elseif($deposit->status==4)
                    Renewed
                @elseif($deposit->status==3)
                    Expired
                @else
                    Active
                @endif
            </td>
            <td>
                @if(!empty($deposit->child))
                    {{$deposit->child->interest_rate ?? 'N/A'}}
                @endif
            </td>
            <td>{{$deposit->interest_rate ?? 'NA'}}</td>
            @php $parent=$deposit @endphp
            @for($year=1;$year<=$number_of_years;$year++)
                @if(!empty($parent))
                    @php $parent=$parent->parent; @endphp
                    <td>{{$parent->interest_rate ?? ''}}</td>
                @else
                    <td></td>
                @endif
            @endfor
        </tr>
    @endforeach
    </tbody>
</table>