<style>
    
    table {
        border-collapse: collapse;
    }

    table, td, th {
        border: 1px solid black;
    }
</style>
<table class="table" >
    <thead>
    <tr>
        <th>Fiscal Year</th>
        <th>Transaction Date</th>
        <th>Institution Code</th>
        <th>Branch</th>
        <th>Deposit Type</th>
        <th>Duration (Days)</th>
        <th>Mature Date</th>
        <th>FD No.</th>
        {{--<th>Interest Payment <br> method</th>--}}
        <th>Deposit Amount</th>
        <th>Withdraw Amount</th>
        <th>Interest Rate/Year</th>
        <th>Estimated Earning</th>
        <th>Actual Earning <span style="font-size: 8px;">As of {{date('Y-m-d')}}</span></th>
        <th>Alert Days</th>
        <th>Earmarked</th>
        <th>Status</th>
    </tr>
    </thead>
    <?php $total_interest_amount = 0; ?>
    <?php $total_deposit_amount = 0; ?>
    @if(!empty($deposits) or count($deposits) > 0)
        @foreach($deposits as $deposit)
            <tr class="@if($deposit->status == 4)  @elseif($deposit->status == 3) rowexpire
                                                @elseif($deposit->status == 2) rowalert @else rowalive @endif">
                <td>{{$deposit->fiscalyear->code}}</td>
                <td>{{$deposit->trans_date_en}}</td>
                <td>{{$deposit->institute->institution_name}}</td>
                <td>{{$deposit->branch->branch_name or 'NA'}}</td>
                <td>{{$deposit->deposit_type->name}}</td>
                <td>{{$deposit->days}} days</td>
                <td>{{$deposit->mature_date_en}}</td>
                <td>{{$deposit->document_no}}</td>
                <?php $total_deposit_amount += $deposit->deposit_amount;  ?>
                <td>{{$deposit->deposit_amount}}</td>
                <td>-</td>
                <td>{{$deposit->interest_rate}}</td>
                <td>{{$deposit->estimated_earning}}</td>
                <td>{{$deposit->actualEarning->sum('amount')}}</td>
                <?php $total_interest_amount += $deposit->estimated_earning;  ?>
                <td>{{$deposit->alert_days}} ({{$deposit->expiry_days}})</td>
                <td>@if($deposit->earmarked)
                        Yes
                    @else
                        No
                    @endif
                </td>
                {{--<td>{{$deposit->reference_number}}</td>--}}
                <td>@if($deposit->status == 1)
                        Active
                    @elseif($deposit->status == 2)
                        Renew Soon
                    @elseif($deposit->status == 3)
                        Expired
                    @elseif($deposit->status == 4)
                        Renewed
                    @else
                        WithDrawn
                    @endif
                </td>

            </tr>
            @if(!empty($deposit->withdraw))
                <tr>
                    <td>{{$fiscal_year->where('start_date_en','<=',$deposit->withdraw->withdrawdate_en)->where('end_date_en','>=',$deposit->withdraw->withdrawdate_en)->first()->code}}</td>
                    <td>{{$deposit->trans_date_en}}</td>
                    <td>{{$deposit->institute->institution_name}}</td>
                    <td>{{$deposit->branch->branch_name or 'NA'}}</td>
                    <td>{{$deposit->deposit_type->name}}</td>
                    <td>{{$deposit->days}} days</td>
                    <td>{{$deposit->mature_date_en}}</td>
                    <td>{{$deposit->document_no}}</td>
                    <td>0</td>
                    <td>{{$deposit->withdraw->withdraw_amount or '-'}}</td>
                    <td>{{$deposit->interest_rate}}</td>
                    <td>{{$deposit->estimated_earning}}</td>
                    <td>{{$deposit->alert_days}} ({{$deposit->expiry_days}})
                    </td>
                    <td>@if($deposit->earmarked)
                            Yes
                        @else
                            No
                        @endif
                    </td>
                    <td>
                        Withdraw Date: [{{$deposit->withdraw->withdrawdate_en}}]
                    </td>

                </tr>
            @endif
        @endforeach
        <tr>
            <td colspan="8" style="text-align:right;">Total</td>
            <td style="text-align:left;"
                colspan="">{{ $total_deposit_amount }}</td>
            <td colspan="2"></td>
            <td style="text-align:left;"
                colspan="5">{{ $total_interest_amount }}</td>
        </tr>
    @else
        <tr>
            <td>No Data Found</td>
        </tr>
    @endif
    <tbody>
    </tbody>
</table>