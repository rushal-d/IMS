<table class="table table-bordered table-responsive freezeHeaderTable">
    <thead>
    <tr>
        <th>Organization Name</th>
        <th>Investment Sector</th>
        <th>Opening Kitta</th>
        <th>Opening Balance Amt</th>
        <th>IPO</th>
        <th>Promoter</th>
        <th>Secondary</th>
        <th>Bonus</th>
        <th>Right</th>
        <th>Sales</th>
        <th>Balance Kitta</th>
        <th>Investment Amount</th>
        <th>Sales Amount</th>
        <th>Closing Balance Amt</th>
        <th>Dividend</th>
        <th>Nepse Rate</th>
        <th>Nepse Value</th>
        <th>Difference</th>
    </tr>
    </thead>
    <tbody>
    @php
        $total_ipo=$total_promoter=$total_secondary
        =$total_bonus=$total_right=$total_sales=$total_balance=$total_investment
        =$total_sale_amount=$total_dividend=$total_nepse_value=$netDifference=$total_opening_amount=$total_opening_balance=0
    @endphp
    @foreach($share_institutions as $share_institution)
        @php $temp_share=$share->where('institution_code',$share_institution->institution_code) @endphp
        <tr>
            <td>
                @if($for_excel)
                    {{$share_institution->institution_name}}
                @else
                    <a href="{{route('share.index',['institution_code'=>$share_institution->institution_code ?? null,
                        'fiscal_year_id'=>$_GET['fiscal_year_id'] ?? null,
                        'start_date'=>$_GET['start_date'] ?? null,
                        'end_date'=>$_GET['end_date'] ?? null,
                        ])}}"

                       target="_blank">
                        {{$share_institution->institution_name}}
                    </a>
                @endif
            </td>
            <td>{{$share_institution->invest_sector->name ?? ''}}</td>
            @php
                $institution_code=$share_institution->institution_code;
                if(!empty($openingBalancePurchase)){
                    $openingPurchaseAMT=$openingBalancePurchase->where('institution_code',$institution_code)->first()->purchase_amount ?? 0;
                    $openingPurchaseKITTA=$openingBalancePurchase->where('institution_code',$institution_code)->first()->purchase_kitta ?? 0;

                }else{
                    $openingPurchaseAMT=0;
                    $openingPurchaseKITTA=0;
                }
                if(!empty($openingBalanceSales)){
                    $openingSalesAMT=$openingBalanceSales->where('institution_code',$institution_code)->first()->sales_amount ?? 0;
                    $openingSalesKITTA=$openingBalanceSales->where('institution_code',$institution_code)->first()->sales_kitta ?? 0;
                }else{
                    $openingSalesAMT=0;
                    $openingSalesKITTA=0;
                }
                $openingBalanceAmount= round(($openingPurchaseAMT- $openingSalesAMT),2);
                $openingBalanceKitta=round(($openingPurchaseKITTA- $openingSalesKITTA),2);
                 $total_opening_amount+=$openingBalanceAmount;
                 $total_opening_balance+=$openingBalanceKitta;
            @endphp
            <td>
                {{$openingBalanceKitta}}
            </td>
            <td>
                {{$openingBalanceAmount}}
            </td>

            @php
                $ipo=$temp_share->where('share_type_id',1)->sum('purchase_kitta');
                $total_ipo+=$ipo;
                $promoter=$temp_share->where('share_type_id',2)->sum('purchase_kitta');
                $total_promoter+=$promoter;
                $secondary=$temp_share->where('share_type_id',3)->sum('purchase_kitta');
                $total_secondary+=$secondary;
                $bonus=$temp_share->where('share_type_id',4)->sum('purchase_kitta');
                $total_bonus+=$bonus;
                $right=$temp_share->where('share_type_id',5)->sum('purchase_kitta');
                $total_right+=$right;
                $sales=$temp_share->where('share_type_id',6)->sum('purchase_kitta');
                $total_sales+=$sales;

                $balance=$openingBalanceKitta+$temp_share->where('share_type_id','<>',6)->sum('purchase_kitta')-$temp_share->where('share_type_id',6)->sum('purchase_kitta');
                $total_balance+=$balance;

            $investment=round($temp_share->where('share_type_id','<>',6)->sum('total_amount'),2);
            $total_investment+=$investment;

            $sale_amount=round($temp_share->where('share_type_id',6)->sum('total_amount'),2);
            $total_sale_amount+=$sale_amount;

            $dividend=$share_institution->dividends->sum('amount');
            $total_dividend+=$dividend;
            if(!empty($share_institution->latest_share_price))
            {
            $closing_value=$share_institution->latest_share_price->closing_value;
            $nepse_value=$balance * $share_institution->latest_share_price->closing_value;
            $total_nepse_value+=$nepse_value;
            }else{
            $closing_value="N/A";
            $nepse_value=0;
            }

            @endphp
            <td>{{$ipo ?? ''}}</td>
            <td>{{$promoter ?? ''}}</td>
            <td>{{$secondary ?? ''}}</td>
            <td>{{$bonus ?? ''}}</td>
            <td>{{$right?? ''}}</td>
            <td>{{$sales ?? ''}}</td>
            <td>{{ $balance ?? 0}}</td>
            <td>{{$investment }}</td>
            <td>{{$sale_amount }}</td>
            <td>{{$openingBalanceAmount+$investment-$sale_amount}}</td>
            <td>{{$dividend}}</td>
            <td>{{$closing_value}}</td>
            <td>{{$nepse_value}}</td>
            @php $netDifference+= ($nepse_value -( $openingBalanceAmount+ $investment-$sale_amount)) @endphp
            <td>{{$nepse_value -  ($openingBalanceAmount+$investment-$sale_amount)}}</td>

        </tr>
    @endforeach
    <tr>
        <td colspan="2">Total</td>
        <td>{{$total_opening_amount}}</td>
        <td>{{$total_opening_balance}}</td>
        <td>{{$total_ipo}}</td>
        <td>{{$total_promoter}}</td>
        <td>{{$total_secondary}}</td>
        <td>{{$total_bonus}}</td>
        <td>{{$total_right}}</td>
        <td>{{$total_sales}}</td>
        <td>{{$total_opening_balance+$total_balance}}</td>
        <td>{{$total_investment}}</td>
        <td>{{$total_sale_amount}}</td>
        <td>{{$total_opening_amount+$total_investment-$total_sale_amount}}</td>
        <td>{{$total_dividend}}</td>
        <td></td>
        <td>{{$total_nepse_value}}</td>
        <td>{{$netDifference}}</td>
    </tr>
    </tbody>
</table>