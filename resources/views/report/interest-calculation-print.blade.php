<html>
<head>
    <title>Interest Calculation Print</title>
    <style>
        table {

            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
    </style>
</head>
<body>
<div id="printableArea" class="col-xl-12">
    <table class="">
        <thead>
        <tr>
            <th>Fiscal Year</th>
            <th>Start Date</th>
            <th>Mature Date</th>
            <th>Bank</th>
            <th>Deposit Type</th>
            <th>Duration (Days)</th>
            <th>FD Number</th>
            <th>Deposit Amount</th>
            <th>Interest Rate/Year</th>
            <th>Estimated Earning</th>
            <th>Interest Calc. Start</th>
            <th>Interest Calc. End</th>
            <th>Status</th>
            <th>Received Interest</th>
            <th>Accured Interest</th>
        </tr>
        </thead>
        <?php $total_interest_amount = 0; ?>
        @if(count($deposits) > 0)
            @foreach($deposits as $deposit)
                <tr class="@if($deposit['status'] == 4)  @elseif($deposit['status'] == 3) rowexpire
                                                @elseif($deposit['status'] == 2) rowalert @else rowalive @endif">
                    <td>{{$deposit['fiscal_code']}}</td>
                    <td>{{$deposit['trans_date_en']}}</td>
                    <td>{{$deposit['mature_date_en']}}</td>
                    <td>{{$deposit['institution_name']}}
                        , {{$deposit['branch_name'] or ''}}</td>
                    <td>{{$deposit['deposit_type']}}</td>
                    <td>{{$deposit['days']}} days</td>
                    <td>{{$deposit['fd_number']}}</td>
                    <td>{{$deposit['deposit_amount']}}</td>
                    <td>{{$deposit['interest_rate']}}</td>
                    <td>{{$deposit['estimated_earning']}}</td>
                    <td>{{$deposit['interest_start']}}</td>
                    <td>{{$deposit['interest_end']}}</td>
                    <?php $total_interest_amount += $deposit['estimated_earning'];  ?>
                    <td>@if($deposit['status'] == 1)
                            Active
                        @elseif($deposit['status'] == 2)
                            Renew Soon
                        @elseif($deposit['status'] == 3)
                            Expired
                        @elseif($deposit['status'] == 4)
                            Renewed
                        @else
                            WithDrawn
                        @endif
                    </td>
                    <td>{{$deposit['received_interest']}}</td>
                    <td>{{$deposit['accured_interest']}}</td>

                </tr>

            @endforeach
            <tr>
                <td colspan="9" style="text-align:right;">Total</td>
                <td style="text-align:left;"
                    colspan="6">{{ $total_interest_amount }}</td>
            </tr>
        @else
            <tr>
                <td>No Data Found</td>
            </tr>
        @endif
        <tbody>
        </tbody>
    </table>
</div>
<script>

    printDiv("printableArea");

    function printDiv(divName) {
        var css = '@page { size: landscape; }',
            head = document.head || document.getElementsByTagName('head')[0],
            style = document.createElement('style');
        style.type = 'text/css';
        style.media = 'print';

        if (style.styleSheet){
            style.styleSheet.cssText = css;
        } else {
            style.appendChild(document.createTextNode(css));
        }
        head.appendChild(style);
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents =  document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        // window.close();
    }
</script>
</body>
</html>