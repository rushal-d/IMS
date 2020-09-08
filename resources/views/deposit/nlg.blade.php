<table>
    <tr>
        <td>SN</td>
        <td>Bank Name</td>
        <td>Bank Branch</td>
        <td>FD No</td>
        <td>Start</td>
        <td>End</td>
        <td>Amount</td>
        <td>Rate</td>
        <td>Type</td>
        <td>Payable</td>
        <td>Office Branch</td>
        <td>Days</td>
        <td>Period</td>
        <td>Mark</td>
        <td>Cheque Number</td>
        <td>Interest Start Date</td>
        <td>Interest End Date</td>
        <td>Interest Days</td>
        <td>Earning</td>
        <td>Approved By</td>
        <td>System ID</td>
    </tr>
    @foreach($deposit_records as $deposit)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$deposit['bank_name']}}</td>
            <td>{{$deposit['bank_branch']}}</td>
            <td>{{$deposit['fd_number']}}</td>
            <td>{{$deposit['start']}}</td>
            <td>{{$deposit['end']}}</td>
            <td>{{$deposit['amount']}}</td>
            <td>{{$deposit['rate']}}</td>
            <td>{{$deposit['type']}}</td>
            <td>{{$deposit['payable']}}</td>
            <td>{{$deposit['organization_branch']}}</td>
            <td>{{$deposit['days']}}</td>
            <td>{{$deposit['month']}}</td>
            <td>{{$deposit['mark']}}</td>
            <td>{{$deposit['cheque_no']}}</td>
            <td>{{$deposit['interest_start']}}</td>
            <td>{{$deposit['interest_end']}}</td>
            <td>{{$deposit['interest_days']}}</td>
            <td>{{$deposit['earning']}}</td>
            <td>{{$deposit['approved_by']}}</td>
            <td>{{$deposit['system_id']}}</td>
        </tr>
    @endforeach

</table>