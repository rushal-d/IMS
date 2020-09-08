<table class="table table-bordered">
    <tr>
        <td><b>SN</b></td>
        @if ($userOrganization->organization_code == '0415')
            <td><b>Ref Number</b></td>
        @endif
        <td><b>Bank Name</b></td>
        <td><b>Bank Branch</b></td>
        <td><b>Or. Branch</b></td>
        <td><b>Tranx Date</b></td>
        <td><b>Tranx Date (BS)</b></td>
        <td><b>Mature Date</b></td>
        <td><b>Mature Date (BS)</b></td>
        <td><b>Amount</b></td>
        <td><b>FD Number</b></td>
        <td><b>Status</b></td>
    </tr>
    @foreach($activeDeposits as $activeDeposit)
        <tr>
            <td>{{$loop->iteration}}</td>
            @if ($userOrganization->organization_code == '0415')
                <td>{{$activeDeposit->reference_number ?? ''}}</td>
            @endif
            <td>{{$activeDeposit->institute->institution_name ?? ''}}
                @if($activeDeposit->bank_merger_id!=null)
                    ({{$activeDeposit->bankMerger->bank_code_after_merger ?? null}})@endif
            </td>
            <td>{{$activeDeposit->branch->branch_name ?? ''}}</td>
            <td>{{$activeDeposit->organization_branch->branch_name ?? ''}}</td>
            <td>{{$activeDeposit->trans_date_en}}</td>
            <td>{{$activeDeposit->trans_date}}</td>
            <td>{{$activeDeposit->mature_date_en}}</td>
            <td>{{$activeDeposit->mature_date}}</td>
            <td>{{$activeDeposit->deposit_amount}}</td>
            <td>{{$activeDeposit->document_no}}</td>
            <td>{{$activeDeposit->is_pending==1 ? 'Pending':''}}</td>
        </tr>
    @endforeach
    <tr>
        @if ($userOrganization->organization_code == '0415')
            <td></td>
        @endif
        <td colspan="7">Total</td>
        <td>{{$activeDeposits->sum('deposit_amount')}}</td>
        <td></td>
        <td></td>
    </tr>
</table>