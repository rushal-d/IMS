<div id="printableArea" class="col-xl-12  freezeHeaderTableContainer">
    <table class="table table-bordered table-responsive freezeHeaderTable">
        <thead>
        <tr>
            <th>SN</th>
            <th>Ref.No</th>
            <th>Bank</th>
            <th>FD Amount</th>
            <th>Withdrawn Amount</th>
            <th>Total FD amount for interest calculation</th>
            <th>Starting Period</th>
            <th>Maturity Period</th>
            <th>Interest Rate</th>
            <th>FD Number</th>
            <th>Earmarked</th>
            <th>No of Days</th>
            <th>Interest Calculation</th>
            <th>Received Interest</th>
            <th>Accured Interest</th>
        </tr>
        </thead>
        <?php $total_interest_amount = $total_deposit_amount = $total_withdraw_amount = $total_received_interest_amount = $total_accured_interest_amount = 0; ?>
        @if(count($deposits) > 0)
            @foreach($deposits as $deposit)
                <tr class="@if($deposit['status'] == 4)  @elseif($deposit['status'] == 3) rowexpire
                                                @elseif($deposit['status'] == 2) rowalert @else rowalive @endif">
                    <td>{{$loop->iteration}}</td>
                    <td>{{$deposit['reference_number']}}</td>

                    <td>{{$deposit['institution_name']}}
                        , {{$deposit['branch_name'] or ''}}</td>
                    @php
                        $deposit_amount=0;
                        $withdrawn_amount=0;
                        if(($deposit['status']==5 && $deposit['has_withdraw'])){
                           $deposit_amount=0;
                        $withdrawn_amount=$deposit['deposit_amount'];
                        }else{
                        $deposit_amount=$deposit['deposit_amount'];
                        $withdrawn_amount=0;
                        }
                        $total_deposit_amount+=$deposit_amount;
                        $total_withdraw_amount+=$withdrawn_amount;
                    @endphp
                    <td>{{$deposit_amount}}</td>
                    <td>
                        {{$withdrawn_amount}}
                    </td>
                    <td>{{$deposit['deposit_amount']}}</td>
                    <td>{{$deposit['interest_start']}}</td>
                    <td>{{$deposit['interest_end']}}</td>
                    <td>{{$deposit['interest_rate']}}</td>
                    <td>{{$deposit['fd_number']}}</td>
                    <td>{{$deposit['earmarked']}}</td>
                    <td>{{$deposit['days']}} days</td>
                    <td>{{$deposit['estimated_earning']}}</td>
                    <td>{{$deposit['received_interest']}}</td>
                    <td>{{$deposit['accured_interest']}}</td>
                    @php
                        $total_interest_amount += $deposit['estimated_earning'];
                        $total_received_interest_amount+=$deposit['received_interest'];
                        $total_accured_interest_amount+=$deposit['accured_interest'];
                    @endphp

                </tr>

            @endforeach
            <tr>
                <td colspan="3" style="text-align:right;">Total</td>
                <td>{{$total_deposit_amount}}</td>
                <td>{{$total_withdraw_amount}}</td>
                <td>{{$total_deposit_amount+$total_withdraw_amount}}</td>
                <td style="text-align:left;"
                    colspan="6"></td>
                <td>{{ $total_interest_amount }}</td>
                <td>{{ $total_received_interest_amount }}</td>
                <td>{{ $total_accured_interest_amount }}</td>
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

@if($printRecord)
    <style>
        table {

            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
        }
    </style>
    <script>

        printDiv("printableArea");

        function printDiv(divName) {
            var css = '@page { size: landscape; }',
                head = document.head || document.getElementsByTagName('head')[0],
                style = document.createElement('style');
            style.type = 'text/css';
            style.media = 'print';

            if (style.styleSheet) {
                style.styleSheet.cssText = css;
            } else {
                style.appendChild(document.createTextNode(css));
            }
            head.appendChild(style);
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
            // window.close();
        }
    </script>
@endif