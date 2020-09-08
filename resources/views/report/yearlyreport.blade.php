@extends('layouts.master')
@section('title','Yearly Report')
@section('styles')
    <style>
       caption{
           display: block;
           text-align: center;
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
                            Yearly Report
                            <div class="card-header-rights">
                                <a onclick="printPortraitDiv('printableArea')" class="btn btn-sm btn-dropbox">
                                    Print  <i class="fa fa-print"></i>
                                </a>
                                &nbsp;
                               {{-- <button class="downexcel btn btn-sm btn-dribbble">
                                    Export to Excel  <i class="far fa-file-excel"></i>
                                </button>--}}
                            </div>
                        </div>
                        <form id="bimafilter" action="{{route('yearly-report')}}" method="get">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-1"></div>
                                    <div class="col-xl-4"></div>
                                    <div class=" col-xl-2">
                                        <div class="col-sm-12">
                                            <label class="" for="fiscal_year_id"><sup class="required-field">*</sup>Fiscal Year</label>
                                            <div class="input-group">
                                                <select name="fiscal_year_id" id="fiscal_year_id" class="form-control" required>
                                                    @foreach($fiscal_years as $fiscal_year)
                                                        <option value="{{$fiscal_year->id}}"
                                                                @if(!empty($fiscal_year_now_id))
                                                                @if($fiscal_year_now_id == $fiscal_year->id)
                                                                    selected
                                                                @endif
                                                                @endif
                                                        >{{$fiscal_year->code}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4"></div>
                                    <div class="col-xl-1"></div>
                                </div>
                            </div>
                        </form>
                        <div class="row">
                            <div id="printableArea" class="col-xl-12">
                                <div style="display: block;text-align: center;">
                                    <h5><b>{{\App\UserOrganization::first()->organization_name ?? ''}}</b></h5>
                                    <h4>
                                        आ.व {{$fiscal_year_now->code}}
                                    </h4>
                                    <h4>वित्तीय विवरणको अभिन्न अंगको रुपमा रहने अनुसुचीहरु</h4>
                                </div>
                                <table id="Table1" class="table table-bordered" style="width: 100%">
                                    <tr>
                                        <td style="width: 1%;">क्र.स</td>
                                        <td> विवरण </td>
                                        <td>यस वर्ष</td>
                                    </tr>
                                    <tr>
                                       <td>(क)</td>
                                       <td colspan="1">
                                           दिर्घकालिन लगानी :
                                       </td>
                                   </tr>
                                    <tr>
                                        <td></td>
                                        <td>
                                            सरकारी र सरकारको जमानत प्राप्त सेक्युरिटी
                                        </td>
                                        <td>{{number_format($bonds,2)}}</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>
                                            बैंक तथा वित्तिय संस्थाको अग्राधिकार शेयर / डिवेन्चर
                                        </td>
                                        <td>{{number_format($ga_1_shares,2)}}</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>
                                            नेपाल पुनर्बिमाकमा लगानी
                                        </td>
                                        <td>{{number_format($ga_5_shares,2)}}</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td colspan="1">जम्मा </td>
                                        <td>{{number_format($total_one,2)}}</td>
                                    </tr>
                                    <tr>
                                        <td>(ख)</td>
                                        <td colspan="1">
                                            अल्पकालीन लगानी  :
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td> बाणिज्य बैंकको मुद्दती</td>
                                        <td>{{number_format($kha_1_deposits,2)}}</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>
                                            विकास  बैंकको मुद्दती</td>
                                        <td>{{number_format($kha_2_deposits,2)}}</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td> नागरिक लगानी योजना</td>
                                        <td>{{number_format($kha_3_deposits,2)}}</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>वित्तीय संस्थाको मुद्दती</td>
                                        <td>{{number_format($ga_2_shares,2)}}</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td colspan="1">जम्मा </td>
                                        <td>{{number_format($total_two,2)}}</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td colspan="1">
                                            कुल
                                        </td>
                                        <td>{{number_format($grand_total,2)}}</td>
                                    </tr>
                                </table>
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
