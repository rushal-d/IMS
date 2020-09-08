<div id="printableArea" class="col-xl-12">
    <table class="table table-bordered ">

        <tr>
            <td><b>SN</b></td>
            <td><b>Deposit Type</b></td>

            <td><b>Closing Balance</b></td>
            <td><b>Interest Earned</b></td>

        </tr>

        @if(count($details) > 0)
            @foreach($details as $detail)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>
                        <a href="{{route('report-interest-calc',['fiscal_year_id'=>$_GET['fiscal_year_id'] ?? null,'investment_subtype_id'=>$detail['id'],'interest_start_date_en'=>$_GET['interest_start_date_en'] ?? null,'interest_start_date'=>$_GET['interest_start_date'] ?? null,'interest_end_date_en'=>$_GET['interest_end_date_en'] ?? null,'interest_end_date'=>$_GET['interest_end_date'] ?? null])}}">
                            {{$detail['deposit_type']}}</a>
                    </td>
                    <td>{{$detail['closing_balance']}}</td>

                    <td>{{$detail['estimated_earning'] ?? 0}}</td>
                </tr>

            @endforeach
        @else
            <tr>
                <td>No Data Found</td>
            </tr>
        @endif
    </table>
</div>