<table>
    <tr>
        <td>SN</td>
        <td>Bank Name</td>
        <td>Date</td>
        <td>Dr Amount</td>
        <td>Cr Amount</td>
        <td>Balance</td>
        <td>Type</td>
        <td>Branch</td>
        <td>Cheque No</td>
    </tr>
    <tr>
        <td colspan="2">Opening Balance</td>
        <td>{{$previousFiscalYear->code ?? ''}}</td>
        <td>{{$opening_balance}}</td>
        <td></td>
        <td>{{$opening_balance}}</td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    @foreach($record_collections as $record)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$record['institute'] ?? ''}}</td>
            <td>{{$record['trans_date_en'] ?? ''}}</td>
            <td>{{$record['dr_amount'] ?? ''}}</td>
            <td>{{$record['cr_amount'] ?? ''}}</td>
            @php $opening_balance+=(float)$record['dr_amount'];$opening_balance-=(float)$record['cr_amount']; @endphp
            <td>
                {{$opening_balance}}
            </td>
            <td>{{$record['deposit_type'] ?? ''}}</td>
            <td>{{$record['branch'] ?? ''}}</td>
            <td>{{$record['cheque_number'] ?? ''}}</td>
        </tr>
    @endforeach

</table>