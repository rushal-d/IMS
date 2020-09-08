@extends('layouts.master')
@section('title','Report')
@section('styles')
    <style>
        .trclass{
            font-family:Kalimati;text-align:center;font-size:11px;
            color:#000000;
            font-weight:bold;border:1px solid;
            border-left-color:#000000;
            border-right-color:#000000;border-top-color:#000000;
            border-bottom-color:#000000;min-width:50px;
        }

        .tdclass{
            font-family:Kalimati;font-size:11px;color:#000000;
            -weight:bold;border:1px solid;border-left-color:#000000;border-right-color:#000000;
            border-top-color:#000000;border-bottom-color:#000000;min-width:50px;
        }

        .blankcell{
            border:1px solid;border-left-color:#000000;border-right-color:#000000;border-top-color:#000000;border-bottom-color:#000000;min-width:50px;
        }

        .totalclass{
            font-family:Kalimati;text-align:right;font-size:11px;
            color:#000000;font-weight:bold;border:1px solid;
            border-left-color:#000000;border-right-color:#000000;
            border-top-color:#000000;border-bottom-color:#000000;
            min-width:50px; text-align: center;
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i>
                            BSIB Report
                            <div class="card-header-rights">
                                <a onclick="printDiv('printableArea')" class="btn btn-sm btn-dropbox">
                                    Print  <i class="fa fa-print"></i>
                                </a>
                                &nbsp
                                {{--<button class="downexcel btn btn-sm btn-dribbble">
                                    Export to Excel  <i class="far fa-file-excel"></i>
                                </button>--}}
                            </div>
                        </div>
                        <form id="bimafilter" action="{{route('bimasamiti-filter')}}" method="get">
                        <div class="card-body">
                            <div class="row col-xl-8 offset-3">
                                <div class="col-sm-4 my-1">
                                    <label class="" for="fiscal_year_id"><sup class="required-field">*</sup>Fiscal Year</label>
                                    <div class="input-group">
                                        <select name="fiscal_year_id" id="fiscal_year_id" class="form-control" required>
                                            @foreach($fiscal_years as $fiscal_year)
                                                <option value="{{$fiscal_year->id}}"
                                                        @if(!empty($fiscal_year_f_id))
                                                            @if($fiscal_year_f_id == $fiscal_year->id)
                                                                selected <?php $current_year = $fiscal_year->code; ?>
                                                            @endif
                                                        @endif
                                                >{{$fiscal_year->code}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4 my-1">
                                    <label class="" for="months">Session : </label>
                                    <select name="months" id="months">
                                        <option value="4" @if(!empty($quarter)) @if($quarter == 4) selected @endif @endif >Baishak - Asar</option>
                                        <option value="1" @if(!empty($quarter)) @if($quarter == 1) selected @endif @endif >Shrawan - Asoj</option>
                                        <option value="2" @if(!empty($quarter)) @if($quarter == 2) selected @endif @endif >Kartik - Poush</option>
                                        <option value="3" @if(!empty($quarter)) @if($quarter == 3) selected @endif @endif >Magh - Chaitra</option>
                                    </select>
                                    </div>
                                </div>
                            </div>
                         </form>
                                <div class="row">
                                <div id="printableArea" class="col-xl-12">
                                    <table class="table table-responsive-lg" cellspacing=0 border=1>
                                        <tbody>
                                        <tr style="height:25px;">
                                            <td class="trclass" colspan=7>
                                                <h5><b>{{\App\UserOrganization::first()->organization_name ?? ''}}</b></h5>
                                            </td>
                                        </tr>
                                        <tr style="height:25px;">
                                            <td class="trclass" colspan=7>
                                                <nobr>आ.व @if(!empty($current_year)) {{$current_year}} @endif</nobr>
                                            </td>
                                        </tr>
                                        <tr style="height:25px;">
                                            <td class="trclass" colspan=7>
                                                <nobr>{{$start_month}} देखि {{$end_month}} सम्मको निर्जीवन वीमा तर्फको</nobr>
                                                Grand Total : {{number_format($grandtotal)}}
                                            </td>
                                        </tr>
                                        <tr style="height:25px;">
                                            <td class="trclass" rowspan=2 style="width: 1%;">
                                                <nobr>लगानीको बर्ग </nobr>
                                            </td>
                                            <td class="trclass" rowspan=2>
                                                <nobr>लगानी को क्षेत्र</nobr>
                                            </td>
                                            <td class="trclass" rowspan=2>
                                                <nobr>लगानी गरीएको रकम</nobr>
                                            </td>
                                            <td class="trclass" rowspan=2>
                                                <nobr>लगानीको प्रतिशत</nobr>
                                            </td>
                                            <td class="trclass" colspan=2>
                                                <nobr>लगानीको अबधी</nobr>
                                            </td>
                                            <td class="trclass" rowspan=2>
                                                <nobr>लगानीको प्रतिफल</nobr>
                                            </td>
                                        </tr>
                                        <tr style="height:35px;">
                                            <td class="tdclass">
                                                <nobr>शुरु मिति</nobr>
                                            </td>
                                            <td class="tdclass">
                                                <nobr>अन्तीम मिति</nobr>
                                            </td>
                                        </tr>
                                        <?php
                                        $row_span = 2;
                                        if(!empty($allbonds)){
	                                        $row_span = count($allbonds) + 2;
                                        }
                                        ?>
                                        <tr>
                                            <td class="trclass" rowspan="{{$row_span}}">
                                                <nobr>क बर्ग </nobr>
                                            </td>
                                        </tr>
                                        <?php $count = 0; $bondtotal = 0; $kul_lagani = 0; $ka_kha_total = 0;?>
                                        @foreach($allbonds as $allbond)
                                        <tr style="height:44px;">
                                            {{--@if($count == 0)
                                            <td class="trclass" @if($count == 0) rowspan="{{count($allbonds) + 1}}" @endif>
                                                <nobr>क बर्ग </nobr>
                                            </td>
                                            @endif--}}
                                            <td style="font-family:Segoe UI;font-size:11px;color:#333333;
                                            border:1px solid;border-left-color:#000000;border-right-color:#000000;
                                            border-top-color:#000000;border-bottom-color:#000000;min-width:50px">
                                                <nobr>{{$allbond->institute->institution_name}}( {{$allbond->days}} days)</nobr>
                                            </td>
                                            <td class="tdclass">
                                                <?php $bondtotal += $allbond->totalamount; ?>
                                                <nobr>{{$allbond->totalamount}}</nobr>
                                            </td>
                                            <td class="tdclass">
                                                <nobr>{{round(($allbond->totalamount/$grandtotal) * 100,2)}} %</nobr>
                                            </td>
                                            <td class="tdclass">
                                                <nobr>{{$allbond->trans_date}}</nobr>
                                            </td>
                                            <td class="tdclass">
                                                <nobr>{{$allbond->mature_date}}</nobr>
                                            </td>
                                            <td class="tdclass">
                                                <nobr>&nbsp{{$allbond->estimated_earning}}</nobr>
                                            </td>
                                        </tr>
                                        <?php $count++; ?>
                                        @endforeach
                                        @if(!empty($allbonds))
                                        <tr style="height:25px;">
                                            <td style="font-family:Kalimati;text-align:right;
                                            font-size:11px;color:#000000;font-weight:bold;border:1px solid;
                                            border-left-color:#000000;border-right-color:#000000;
                                            border-top-color:#000000;border-bottom-color:#000000;min-width:50px; text-align: center;" colspan="1">
                                                <nobr>जम्मा</nobr>
                                            </td>
                                            <td class="tdclass">
                                                <?php $ka_kha_total += $bondtotal; ?>
                                                <nobr>{{number_format($bondtotal)}}</nobr>
                                            </td>
                                            <td class="tdclass">
                                                <nobr>&nbsp;</nobr>
                                            </td>
                                            <td class="tdclass">
                                                <nobr>&nbsp;</nobr>
                                            </td>
                                            <td class="tdclass">
                                                <nobr>&nbsp;</nobr>
                                            </td>
                                            <td class="tdclass">
                                                <nobr>&nbsp;</nobr>
                                            </td>
                                        </tr>
                                        @endif
                                        <tr style="height:25px;">
                                            <td class="trclass" rowspan={{$kha_count + 6}}>
                                                <nobr>ख बर्ग </nobr>
                                            </td>
                                            <td class="tdclass">
                                                <nobr><b>१ बाणिज्य बैंकको मुद्दति निक्षेप</b></nobr>
                                            </td>
                                            <td class="tdclass">
                                                <nobr>&nbsp;</nobr>
                                            </td>
                                            <td class="tdclass">
                                                <nobr>&nbsp;</nobr>
                                            </td>
                                            <td class="tdclass">
                                                <nobr>&nbsp;</nobr>
                                            </td>
                                            <td class="tdclass">
                                                <nobr>&nbsp;</nobr>
                                            </td>
                                            <td class="tdclass">
                                                <nobr>&nbsp;</nobr>
                                            </td>
                                        </tr>
                                        <?php $kha_1_total = 0; ?>
                                        @foreach($kha_1_deposits as $kha_1_deposit)
                                        <tr style="height:25px;">
                                            <td style="font-family:Segoe UI;font-size:11px;
                                            color:#333333;border:1px solid;border-left-color:#000000;
                                            border-right-color:#000000;border-top-color:#000000;
                                            border-bottom-color:#000000;min-width:50px">
                                                <nobr>{{$kha_1_deposit->institute->institution_name}} ( {{$kha_1_deposit->days}} days)</nobr>
                                            </td>
                                            <td class="tdclass">
                                                <?php $kha_1_total += $kha_1_deposit->deposit_amount; ?>
                                                <nobr>{{$kha_1_deposit->deposit_amount}}</nobr>
                                            </td>
                                            <td class="tdclass">
                                                <nobr>{{round(($kha_1_deposit->deposit_amount/$grandtotal) * 100,2)}} %</nobr>
                                            </td>
                                            <td class="tdclass">
                                                <nobr>{{$kha_1_deposit->trans_date}}</nobr>
                                            </td>
                                            <td class="tdclass">
                                                <nobr>{{ $kha_1_deposit->mature_date }}</nobr>
                                            </td>
                                            <td class="tdclass">
                                                <nobr> {{$kha_1_deposit->estimated_earning}}</nobr>
                                            </td>
                                        </tr>
                                        @endforeach
                                        <tr style="height:25px;">
                                            <td class="totalclass" colspan="1">
                                                <nobr>जम्मा</nobr>
                                            </td>
                                            <td class="tdclass">
                                                <?php $ka_kha_total += $kha_1_total; ?>
                                                <nobr>@if(!empty($kha_1_deposits)){{number_format($kha_1_total,2)}} @endif</nobr>
                                            </td>
                                            <td class="tdclass">
                                                <nobr>&nbsp;</nobr>
                                            </td>
                                            <td class="tdclass">
                                                <nobr>&nbsp;</nobr>
                                            </td>
                                            <td class="tdclass">
                                                <nobr>&nbsp;</nobr>
                                            </td>
                                            <td class="tdclass">
                                                <nobr>&nbsp;</nobr>
                                            </td>
                                        </tr>
                                        <tr style="height:25px;">
                                            <td class="tdclass">
                                                <nobr><b>२ विकास बैंकको मुद्दति निक्षेप</b></nobr>
                                            </td>
                                            <td class="tdclass">
                                                <nobr>&nbsp;</nobr>
                                            </td>
                                            <td class="tdclass">
                                                <nobr>&nbsp;</nobr>
                                            </td>
                                            <td class="tdclass">
                                                <nobr>&nbsp;</nobr>
                                            </td>
                                            <td class="tdclass">
                                                <nobr>&nbsp;</nobr>
                                            </td>
                                            <td class="tdclass">
                                                <nobr>&nbsp;</nobr>
                                            </td>
                                        </tr>
                                        <?php $kha_2_total = 0; ?>
                                        @foreach($kha_2_deposits as $kha_2_deposit)
                                            <tr style="height:25px;">
                                                <td style="font-family:Segoe UI;font-size:11px;
                                            color:#333333;border:1px solid;border-left-color:#000000;
                                            border-right-color:#000000;border-top-color:#000000;
                                            border-bottom-color:#000000;min-width:50px">
                                                    <nobr>{{$kha_2_deposit->institute->institution_name}} ( {{$kha_2_deposit->days}} days)</nobr>
                                                </td>
                                                <td class="tdclass">
			                                        <?php $kha_2_total += $kha_2_deposit->deposit_amount; ?>
                                                    <nobr>{{$kha_2_deposit->deposit_amount}}</nobr>
                                                </td>
                                                <td class="tdclass">
                                                    <nobr>{{round(($kha_2_deposit->deposit_amount/$grandtotal) * 100,2)}} %</nobr>
                                                </td>
                                                <td class="tdclass">
                                                    <nobr>{{$kha_2_deposit->trans_date}}</nobr>
                                                </td>
                                                <td class="tdclass">
                                                    <nobr>{{ $kha_2_deposit->mature_date }}</nobr>
                                                </td>
                                                <td class="tdclass">
                                                    <nobr> {{$kha_2_deposit->estimated_earning}}</nobr>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr style="height:25px;">
                                            <td style="font-family:Kalimati;font-size:11px;
                                            color:#000000;font-weight:bold;border:1px solid;
                                            border-left-color:#000000;border-right-color:#000000;
                                            border-top-color:#000000;border-bottom-color:#000000;
                                            min-width:50px; text-align: center;" colspan="1">
                                                <nobr>जम्मा</nobr>
                                            </td>
                                            <td class="tdclass">
                                                <?php $ka_kha_total += $kha_2_total; ?>
                                                <nobr>{{number_format($kha_2_total,2)}}</nobr>
                                            </td>
                                            <td class="tdclass">
                                                <nobr>&nbsp;</nobr>
                                            </td>
                                            <td class="tdclass">
                                                <nobr>&nbsp;</nobr>
                                            </td>
                                            <td class="tdclass">
                                                <nobr>&nbsp;</nobr>
                                            </td>
                                            <td class="tdclass">
                                                <nobr>&nbsp;</nobr>
                                            </td>
                                        </tr>
                                        <tr style="height:25px;">
                                            <td class="tdclass">
                                                <nobr><b>३ नागरिक लगानी कोस एकांकी नागरिक लगानी</b></nobr>
                                            </td>
                                            <td class="tdclass">
                                                <nobr>&nbsp;</nobr>
                                            </td>
                                            <td class="tdclass">
                                                <nobr>&nbsp;</nobr>
                                            </td>
                                            <td class="tdclass">
                                                <nobr>&nbsp;</nobr>
                                            </td>
                                            <td class="tdclass">
                                                <nobr>&nbsp;</nobr>
                                            </td>
                                            <td class="tdclass">
                                                <nobr>&nbsp;</nobr>
                                            </td>
                                        </tr>
                                        <?php $kha_3_total = 0; ?>
                                        @foreach($kha_3_deposits as $kha_3_deposit)
                                            <tr style="height:25px;">
                                                <td style="font-family:Segoe UI;font-size:11px;
                                            color:#333333;border:1px solid;border-left-color:#000000;
                                            border-right-color:#000000;border-top-color:#000000;
                                            border-bottom-color:#000000;min-width:50px">
                                                    <nobr>{{$kha_3_deposit->institute->institution_name}} ( {{$kha_3_deposit->days}} days)</nobr>
                                                </td>
                                                <td class="tdclass">
			                                        <?php $kha_3_total += $kha_3_deposit->deposit_amount; ?>
                                                    <nobr>{{$kha_3_deposit->deposit_amount}}</nobr>
                                                </td>
                                                <td class="tdclass">
                                                    <nobr>{{round(($kha_3_deposit->deposit_amount/$grandtotal) * 100,2)}} %</nobr>
                                                </td>
                                                <td class="tdclass">
                                                    <nobr>{{$kha_3_deposit->trans_date}}</nobr>
                                                </td>
                                                <td class="tdclass">
                                                    <nobr>{{ $kha_3_deposit->mature_date }}</nobr>
                                                </td>
                                                <td class="tdclass">
                                                    <nobr> {{$kha_3_deposit->estimated_earning}}</nobr>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr style="height:25px;">
                                            <td class="totalclass">
                                                <nobr>जम्मा</nobr>
                                            </td>
                                            <td class="tdclass">
                                                <?php $ka_kha_total += $kha_3_total; ?>
                                                <nobr>{{number_format($kha_3_total,2)}}</nobr>
                                            </td>
                                            <td class="tdclass">
                                                <nobr>&nbsp;</nobr>
                                            </td>
                                            <td class="tdclass">
                                                <nobr>&nbsp;</nobr>
                                            </td>
                                            <td class="tdclass">
                                                <nobr>&nbsp;</nobr>
                                            </td>
                                            <td class="tdclass">
                                                <nobr>&nbsp;</nobr>
                                            </td>
                                        </tr>
                                        <tr style="height:25px;">
                                            <td class="tdclass">
                                                <nobr>क + ख बर्ग़</nobr>
                                            </td>
                                            <td class="tdclass">
                                                <nobr>अनिवार्य लगानी क र ख बर्ग़को जम्मा</nobr>
                                            </td>
                                            <td class="tdclass">
                                                <?php $kul_lagani += $ka_kha_total; ?>
                                                <nobr><?php echo  number_format($ka_kha_total,2); ?></nobr>
                                            </td>
                                            <td class="tdclass">
                                                <nobr>&nbsp;</nobr>
                                            </td>
                                            <td class="tdclass">
                                                <nobr>&nbsp;</nobr>
                                            </td>
                                            <td class="tdclass">
                                                <nobr>&nbsp;</nobr>
                                            </td>
                                            <td class="tdclass">
                                                <nobr>&nbsp;</nobr>
                                            </td>
                                        </tr>
                                        <tr style="height:25px;">
                                            <td style="min-width:50px" rowspan={{$ga_count + 5}}>
                                                <nobr>ग बर्ग </nobr>
                                            </td>
                                            <td class="tdclass">
                                                <nobr><b>१ बाणिज्य बैंकहरुको अगराधिकार शेयर पब्लिक लिमिटेड कम्पनिको सुरक्षत डीबेन्चर </b></nobr>
                                            </td>
                                            <td class="tdclass">
                                                <nobr>&nbsp;</nobr>
                                            </td>
                                            <td class="tdclass">
                                                <nobr>&nbsp;</nobr>
                                            </td>
                                            <td class="tdclass">
                                                <nobr>&nbsp;</nobr>
                                            </td>
                                            <td class="tdclass">
                                                <nobr>&nbsp;</nobr>
                                            </td>
                                            <td class="tdclass">
                                                <nobr>&nbsp;</nobr>
                                            </td>
                                        </tr>
                                        <?php $ga_total = 0; ?>
                                        @foreach($ga_1_shares as $ga_1_share)
                                            <tr style="height:25px;">
                                                <td style="font-family:Segoe UI;font-size:11px;
                                            color:#333333;border:1px solid;border-left-color:#000000;
                                            border-right-color:#000000;border-top-color:#000000;
                                            border-bottom-color:#000000;min-width:50px">
                                                    <nobr>{{$ga_1_share->instituteByCode->institution_name}}</nobr>
                                                </td>
                                                <td class="tdclass">
                                                    <?php $ga_total += $ga_1_share->total_amount; ?>
                                                    <nobr>{{$ga_1_share->total_amount}}</nobr>
                                                </td>
                                                <td class="tdclass">
                                                    <nobr>{{round(($ga_1_share->total_amount/$grandtotal) * 100,2)}} %</nobr>
                                                </td>
                                                <td class="tdclass">
                                                    <nobr>{{$ga_1_share->trans_date}}</nobr>
                                                </td>
                                                <td class="tdclass">
                                                    <nobr>-</nobr>
                                                </td>
                                                <td class="tdclass">
                                                    <nobr>-</nobr>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr style="height:25px;">
                                            <td class="tdclass">
                                                <nobr><b>२ वित्त कम्पनिको निक्ष्ँेप </b></nobr>
                                            </td>
                                            <td class="blankcell">
                                                <nobr>&nbsp;</nobr>
                                            </td>
                                            <td class="blankcell">
                                                <nobr>&nbsp;</nobr>
                                            </td>
                                            <td class="blankcell">
                                                <nobr>&nbsp;</nobr>
                                            </td>
                                            <td class="blankcell">
                                                <nobr>&nbsp;</nobr>
                                            </td>
                                            <td class="blankcell">
                                                <nobr>&nbsp;</nobr>
                                            </td>
                                        </tr>
                                        @foreach($ga_2_shares as $ga_2_share)
                                            <tr style="height:25px;">
                                                <td style="font-family:Segoe UI;font-size:11px;
                                            color:#333333;border:1px solid;border-left-color:#000000;
                                            border-right-color:#000000;border-top-color:#000000;
                                            border-bottom-color:#000000;min-width:50px">
                                                    <nobr>{{$ga_2_share->instituteByCode->institution_name}}</nobr>
                                                </td>
                                                <td class="tdclass">
	                                                <?php $ga_total += $ga_2_share->total_amount; ?>
                                                    <nobr>{{$ga_2_share->total_amount}}</nobr>
                                                </td>
                                                <td class="tdclass">
                                                    <nobr>{{round(($ga_2_share->total_amount/$grandtotal) * 100,2)}} %</nobr>
                                                </td>
                                                <td class="tdclass">
                                                    <nobr>{{$ga_2_share->trans_date}}</nobr>
                                                </td>
                                                <td class="tdclass">
                                                    <nobr>-</nobr>
                                                </td>
                                                <td class="tdclass">
                                                    <nobr>-</nobr>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr style="height:25px;">
                                            <td class="tdclass">
                                                <nobr><b>३ पब्लिक लिमिटेड कं को साधारण शेयर</b></nobr>
                                            </td>
                                            <td class="blankcell">
                                                <nobr>&nbsp;</nobr>
                                            </td>
                                            <td class="blankcell">
                                                <nobr>&nbsp;</nobr>
                                            </td>
                                            <td class="blankcell">
                                                <nobr>&nbsp;</nobr>
                                            </td>
                                            <td class="blankcell">
                                                <nobr>&nbsp;</nobr>
                                            </td>
                                            <td class="blankcell">
                                                <nobr>&nbsp;</nobr>
                                            </td>
                                        </tr>
                                        @foreach($ga_3_shares as $ga_3_share)
                                            <tr style="height:25px;">
                                                <td style="font-family:Segoe UI;font-size:11px;
                                            color:#333333;border:1px solid;border-left-color:#000000;
                                            border-right-color:#000000;border-top-color:#000000;
                                            border-bottom-color:#000000;min-width:50px">
                                                    <nobr>{{$ga_3_share->instituteByCode->institution_name}}</nobr>
                                                </td>
                                                <td class="tdclass">
	                                                <?php $ga_total += $ga_3_share->total_amount; ?>
                                                    <nobr>{{$ga_3_share->total_amount}}</nobr>
                                                </td>
                                                <td class="tdclass">
                                                    <nobr>{{round(($ga_3_share->total_amount/$grandtotal) * 100,2)}} %</nobr>
                                                </td>
                                                <td class="tdclass">
                                                    <nobr>{{$ga_3_share->trans_date}}</nobr>
                                                </td>
                                                <td class="tdclass">
                                                    <nobr>-</nobr>
                                                </td>
                                                <td class="tdclass">
                                                    <nobr>-</nobr>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr style="height:25px;">
                                            <td class="tdclass">
                                                <nobr><b>अ. नेपाल मार्केट पूल</b></nobr>
                                            </td>
                                            <td class="blankcell">
                                                <nobr>&nbsp;</nobr>
                                            </td>
                                            <td class="blankcell">
                                                <nobr>&nbsp;</nobr>
                                            </td>
                                            <td class="blankcell">
                                                <nobr>&nbsp;</nobr>
                                            </td>
                                            <td class="blankcell">
                                                <nobr>&nbsp;</nobr>
                                            </td>
                                            <td class="blankcell">
                                                <nobr>&nbsp;</nobr>
                                            </td>
                                        </tr>
                                        @foreach($ga_4_shares as $ga_4_share)
                                            <tr style="height:25px;">
                                                <td style="font-family:Segoe UI;font-size:11px;
                                            color:#333333;border:1px solid;border-left-color:#000000;
                                            border-right-color:#000000;border-top-color:#000000;
                                            border-bottom-color:#000000;min-width:50px">
                                                    <nobr>{{$ga_4_share->instituteByCode->institution_name}}</nobr>
                                                </td>
                                                <td class="tdclass">
	                                                <?php $ga_total += $ga_4_share->total_amount; ?>
                                                    <nobr>{{$ga_4_share->total_amount}}</nobr>
                                                </td>
                                                <td class="tdclass">
                                                    <nobr>{{round(($ga_4_share->total_amount/$grandtotal) * 100,2)}} %</nobr>
                                                </td>
                                                <td class="tdclass">
                                                    <nobr>{{$ga_4_share->trans_date}}</nobr>
                                                </td>
                                                <td class="tdclass">
                                                    <nobr>-</nobr>
                                                </td>
                                                <td class="tdclass">
                                                    <nobr>-</nobr>
                                                </td>
                                            </tr>
                                        @endforeach
                                       {{-- <tr style="height:25px;">
                                            <td class="tdclass">
                                                <nobr><b>आ. अन्य पब्लिक लिमिटेड कं को साधारण शेयर</b></nobr>
                                            </td>
                                            <td class="blankcell">
                                                <nobr>&nbsp;</nobr>
                                            </td>
                                            <td class="blankcell">
                                                <nobr>&nbsp;</nobr>
                                            </td>
                                            <td class="blankcell">
                                                <nobr>&nbsp;</nobr>
                                            </td>
                                            <td class="blankcell">
                                                <nobr>&nbsp;</nobr>
                                            </td>
                                            <td class="blankcell">
                                                <nobr>&nbsp;</nobr>
                                            </td>
                                        </tr>--}}

                                        @php
                                            $ga_5_shares=array()
                                        @endphp {{--for non life--}}
                                        @foreach($ga_5_shares as $ga_5_share)
                                            <tr style="height:25px;">
                                                <td style="font-family:Segoe UI;font-size:11px;
                                            color:#333333;border:1px solid;border-left-color:#000000;
                                            border-right-color:#000000;border-top-color:#000000;
                                            border-bottom-color:#000000;min-width:50px">
                                                    <nobr>{{$ga_5_share->instituteByCode->institution_name}}</nobr>
                                                </td>
                                                <td class="tdclass">
	                                                <?php $ga_total += $ga_5_share->total_amount; ?>
                                                    <nobr>{{$ga_5_share->total_amount}}</nobr>
                                                </td>
                                                <td class="tdclass">
                                                    <nobr>{{round(($ga_4_share->total_amount/$grandtotal) * 100,2)}} %</nobr>
                                                </td>
                                                <td class="tdclass">
                                                    <nobr>{{$ga_5_share->trans_date}}</nobr>
                                                </td>
                                                <td class="tdclass">
                                                    <nobr>-</nobr>
                                                </td>
                                                <td class="tdclass">
                                                    <nobr>-</nobr>
                                                </td>
                                            </tr>
                                        @endforeach

                                        <tr style="height:25px;">
                                          {{--  <td style="min-width:50px">
                                                <nobr>&nbsp;</nobr>
                                            </td>--}}
                                            <td style="font-family:Kalimati;text-align:center;
                                            font-size:11px;color:#000000;font-weight:bold;
                                            border:1px solid;border-left-color:#000000;border-right-color:#000000;
                                            border-top-color:#000000;border-bottom-color:#000000;min-width:50px;">
                                                <nobr>जम्मा</nobr>
                                            </td>
                                            <td class="blankcell">
                                                <?php $kul_lagani += $ga_total; ?>
                                                <nobr><?php echo number_format($ga_total,2) ?></nobr>
                                            </td>
                                            <td class="blankcell">
                                                <nobr>&nbsp;</nobr>
                                            </td>
                                            <td class="blankcell">
                                                <nobr>&nbsp;</nobr>
                                            </td>
                                            <td class="blankcell">
                                                <nobr>&nbsp;</nobr>
                                            </td>
                                            <td class="blankcell">
                                                <nobr>&nbsp;</nobr>
                                            </td>
                                        </tr>
                                        <tr style="height:25px;">
                                            <td style="min-width:50px">
                                                <nobr>&nbsp;</nobr>
                                            </td>
                                            <td style="font-family:Kalimati;text-align:center;font-size:11px;
                                            color:#000000;font-weight:bold;border:1px solid;border-left-color:#000000;
                                            border-right-color:#000000;border-top-color:#000000;border-bottom-color:#000000;min-width:50px">
                                                <nobr>कूल लगानी</nobr>
                                            </td>
                                            <td class="blankcell">
                                                <nobr><?php echo number_format($kul_lagani); ?></nobr>
                                            </td>
                                            <td class="blankcell">
                                                <nobr>&nbsp;</nobr>
                                            </td>
                                            <td class="blankcell">
                                                <nobr>&nbsp;</nobr>
                                            </td>
                                            <td class="blankcell">
                                                <nobr>&nbsp;</nobr>
                                            </td>
                                            <td class="blankcell">
                                                <nobr>&nbsp;</nobr>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $("#fiscal_year_id").on("change", function() {
            $('#bimafilter').submit();
        });

        $("#months").on("change", function() {
            $('#bimafilter').submit();
        });


        $('.downexcel').on("click", function () {
            $('#bimafilter').attr('action', '{{route('bimasamiti.excel')}}');
            $('#bimafilter').submit()
        });
    </script>
    <script src="{{asset('js/print.js')}}"></script>
@endsection
