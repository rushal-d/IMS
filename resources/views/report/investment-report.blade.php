@extends('layouts.master')
@section('title','Investment Report')
@section('styles')
    <style>
        .table-bordered th, .table-bordered td {
            border: 1px solid #c8ced3;
            /* text-align: center; */
            text-align: left;
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
                            Investment Report
                            <div class="card-header-rights">
                                <a onclick="printPortraitDiv('printableArea')" class="btn btn-sm btn-dropbox">
                                    Print <i class="fa fa-print"></i>
                                </a>
                                &nbsp
                            </div>
                        </div>
                        <form id="investment-report" action="{{route('investment-report')}}" method="get">
                            <div class="card-body">
                                <div class="row col-xl-8 offset-3">
                                    <div class="col-sm-4 my-1">
                                        <label class="" for="fiscal_year_id"><sup class="required-field">*</sup>Fiscal
                                            Year</label>
                                        <div class="input-group">
                                            <select name="fiscal_year_id" id="fiscal_year_id" class="form-control"
                                                    required>
                                                @foreach($fiscal_years as $fiscal_year)
                                                    <option value="{{$fiscal_year->id}}"
                                                            @if(!empty($_GET['fiscal_year_id'] ))
                                                            @if(($_GET['fiscal_year_id'] ?? null) == $fiscal_year->id)
                                                            selected
                                                            @endif
                                                            @elseif ($fiscal_year->status==1)
                                                            selected
                                                            @endif
                                                    >{{$fiscal_year->code}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 my-1">
                                        <label class="" for="months">Quarter : </label>
                                        {!! Form::select('quarter',$quarters,$quarter ?? null,['class'=>'form-control','id'=>'quarter','placeholder'=>'Select Quarter']) !!}
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div id="printableArea" class="col-xl-12">
                            <h4 class="text-center">
                                <u>
                                    अनुसूची - ३ <br>
                                    लगानीको विवरण <br>
                                    दफा (१३) संग सम्बन्धित
                                </u>
                            </h4>

                            <b>
                                <p>बीमकको नाम : {{$organization->organization_name ?? ''}}</p>
                                <p>पेश गर्नुपर्ने अवधि :</p>
                                <p>पेस भएको अवधि : {{$quarters[$quarter] ?? ''}} </p>
                                <p> पेस भएको मिति : {{\App\Helpers\BSDateHelper::AdToBsEn('-',date('Y-m-d'))}}</p>
                            </b>
                            <table class="table-bordered table">
                                <thead>
                                <th>क्रम</th>
                                <th>लगानी क्षेत्र</th>
                                <th>वास्तविक लगानी रकम</th>
                                <th>समितिबाट स्वीकृत भएको पछिल्लो वितिय बिवरण बमोजिमको कुल टेक्निकल रेजेर्भमा
                                    वास्तविक लगानी प्रतीसत
                                </th>
                                <th>कुल जम्मा लगानीमा लगानीको क्षेत्रको प्रतिसद</th>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>१</td>
                                    <td>नेपाल सरकार वा नेपाल राष्ट्र बैंकको बचतपत्र वा ऋणपत्र वा नेपाल सरकारको जमानत
                                        प्राप्त बचतपत्र वा ऋणपत्र
                                    </td>
                                    <td>{{$bonds_investment}}</td>
                                    <td>
                                        @if(!empty($total_technical_reserve))
                                            {{round(($bonds_investment/$total_technical_reserve)*100,3)}} %
                                        @endif
                                    </td>
                                    <td>
                                        @if(!empty($total_technical_reserve))
                                            {{round(($bonds_investment/$total)*100,3)}} %
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <td>२</td>
                                    <td>नेपाल राष्ट्र बैंकबाट इजाजतपत्र प्राप्त 'क' वर्गको बैंकको मुध्ती निचेप</td>
                                    <td>{{$class_A_investment}}</td>
                                    <td>
                                        @if(!empty($total_technical_reserve))
                                            {{round(($class_A_investment/$total_technical_reserve)*100,3)}} %
                                        @endif
                                    </td>
                                    <td>
                                        @if(!empty($total_technical_reserve))
                                            {{round(($class_A_investment/$total)*100,3)}} %
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <td>३</td>
                                    <td>नेपाल राष्ट्र बैंकबाट इजाजतपत्र प्राप्त नेपाल पूर्वाधार बैंक लिमिटेडको
                                        मुध्ती निचेप
                                    </td>
                                    <td>{{$infrastructure_bank_investment}}</td>
                                    <td>
                                        @if(!empty($total_technical_reserve))
                                            {{round(($infrastructure_bank_investment/$total_technical_reserve)*100,3)}}
                                            %
                                        @endif
                                    </td>
                                    <td>
                                        @if(!empty($total_technical_reserve))
                                            {{round(($infrastructure_bank_investment/$total)*100,3)}}
                                            %
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <td>४</td>
                                    <td>२ र ३ को जम्मा</td>
                                    <td>{{$class_A_investment+$infrastructure_bank_investment}}</td>
                                    <td>
                                        @if(!empty($total_technical_reserve))
                                            {{round((($class_A_investment+$infrastructure_bank_investment)/$total_technical_reserve)*100,3)}}
                                            %
                                        @endif
                                    </td>
                                    <td>
                                        @if(!empty($total_technical_reserve))
                                            {{round((($class_A_investment+$infrastructure_bank_investment)/$total)*100,3)}}
                                            %
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <td>५</td>
                                    <td>१ र ४ को जम्मा</td>
                                    <td>{{$bonds_investment+$class_A_investment+$infrastructure_bank_investment}}</td>
                                    <td>
                                        @if(!empty($total_technical_reserve))
                                            {{round((($bonds_investment+$class_A_investment+$infrastructure_bank_investment)/$total_technical_reserve)*100,3)}}
                                            %
                                        @endif
                                    </td>
                                    <td>
                                        @if(!empty($total_technical_reserve))
                                            {{round((($bonds_investment+$class_A_investment+$infrastructure_bank_investment)/$total)*100,3)}}
                                            %
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <td>६</td>
                                    <td>घर जग्गा व्यवसाय</td>
                                    <td>-</td>
                                    <td>
                                        @if(!empty($total_technical_reserve))
                                            0%
                                        @endif
                                    </td>
                                    <td>
                                        @if(!empty($total_technical_reserve))
                                            0%
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <td>७</td>
                                    <td>नेपाल धितोपत्र बॉर्दबाट इजाजतपत्र प्राप्त धितोपत्र विनिमय बजारबाट सुचिकृत
                                        पुब्लिक लिमिटेड कम्पनीको शेयर
                                    </td>
                                    <td>{{$investment_on_share}}</td>
                                    <td>
                                        @if(!empty($total_technical_reserve))
                                            {{round(($investment_on_share/$total_technical_reserve)*100,3)}}
                                            %
                                        @endif
                                    </td>
                                    <td>
                                        @if(!empty($total_technical_reserve))
                                            {{round(($investment_on_share/$total)*100,3)}}
                                            %
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <td>८</td>
                                    <td>नेपाल राष्ट्र बैंकबाट इजजत्पत्र प्राप्त क, ख, ग वर्गको बैंकतथा वितिय
                                        संस्थाको आग्राधिकार शेयर (साधारण शेयरमा परिणत नहुने) र ऋणपत्र
                                    </td>
                                    <td>{{$investment_on_preferential_share}}</td>
                                    <td>
                                        @if(!empty($total_technical_reserve))
                                            {{round(($investment_on_preferential_share/$total_technical_reserve)*100,3)}}
                                            %
                                        @endif
                                    </td>
                                    <td>
                                        @if(!empty($total_technical_reserve))
                                            {{round(($investment_on_preferential_share/$total)*100,3)}}
                                            %
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <td>९</td>
                                    <td>नेपाल धितोपत्र बॉर्दबाट इजाजतपत्र प्राप्त धितोपत्र विनिमय बजारबाट सुचिकृत
                                        पुब्लिक लिमिटेड कम्पनीको सुरच्चित डिबेनचर
                                    </td>
                                    <td>{{$investment_on_debenture}}</td>
                                    <td>
                                        @if(!empty($total_technical_reserve))
                                            {{round(($investment_on_debenture/$total_technical_reserve)*100,3)}}
                                            %
                                        @endif
                                    </td>
                                    <td>
                                        @if(!empty($total_technical_reserve))
                                            {{round(($investment_on_debenture/$total)*100,3)}}
                                            %
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <td>१०</td>
                                    <td>कृषि, पर्यटन र जलसर्वोत् लगायतका पूर्वाधार</td>
                                    <td>{{$investment_on_agri_tour_and_water}}</td>
                                    <td>
                                        @if(!empty($total_technical_reserve))
                                            {{round(($investment_on_agri_tour_and_water/$total_technical_reserve)*100,3)}}
                                            %
                                        @endif
                                    </td>
                                    <td>
                                        @if(!empty($total_technical_reserve))
                                            {{round(($investment_on_agri_tour_and_water/$total)*100,3)}}
                                            %
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <td>११</td>
                                    <td>म्युचल फुन्द वा नागरिक लगानी कोषका योजनाहरु</td>
                                    <td>{{$investment_on_cit_and_MF}}</td>
                                    <td>
                                        @if(!empty($total_technical_reserve))
                                            {{round(($investment_on_cit_and_MF/$total_technical_reserve)*100,3)}}
                                            %
                                        @endif
                                    </td>
                                    <td>
                                        @if(!empty($total_technical_reserve))
                                            {{round(($investment_on_cit_and_MF/$total)*100,3)}}
                                            %
                                        @endif
                                    </td>
                                </tr>


                                <tr>
                                    <td>१२</td>
                                    <td>नेपाल राष्ट्र बैंकबाट इजाजतपत्र प्राप्त 'ख' वर्गको बैंकको तथा वितिय संसथामा
                                        मुध्ती निचेप
                                    </td>
                                    <td>{{$class_B_investment}}</td>
                                    <td>
                                        @if(!empty($total_technical_reserve))
                                            {{round(($class_B_investment/$total_technical_reserve)*100,3)}}
                                            %
                                        @endif
                                    </td>
                                    <td>
                                        @if(!empty($total_technical_reserve))
                                            {{round(($class_B_investment/$total)*100,3)}}
                                            %
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <td>१३</td>
                                    <td>नेपाल राष्ट्र बैंकबाट इजाजतपत्र प्राप्त 'ग' वर्गको बैंकको तथा वितिय संसथामा
                                        मुध्ती निचेप
                                    </td>
                                    <td>{{$class_C_investment}}</td>
                                    <td>
                                        @if(!empty($total_technical_reserve))
                                            {{round(($class_C_investment/$total_technical_reserve)*100,3)}}
                                            %
                                        @endif
                                    </td>
                                    <td>
                                        @if(!empty($total_technical_reserve))
                                            {{round(($class_C_investment/$total)*100,3)}}
                                            %
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <td>१४</td>
                                    <td>आन्य</td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                    </td>
                                </tr>
                                @foreach($investment_on_non_listed_companies_details as $non_listed_companies)
                                    <tr>
                                        <td></td>
                                        <td>{{$non_listed_companies['institution_name']}}</td>
                                        <td>{{$non_listed_companies['amount']}}</td>
                                        <td>
                                            @if(!empty($total_technical_reserve))
                                                {{round(($non_listed_companies['amount']/$total_technical_reserve)*100,3)}}
                                                %
                                            @endif
                                        </td>
                                        <td>
                                            @if(!empty($total_technical_reserve))
                                                {{round(($non_listed_companies['amount']/$total)*100,3)}}
                                                %
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach

                                <tr>
                                    <td>१५</td>
                                    <td>६ देखि १४ सम्मको कुल जम्मा</td>
                                    <td>{{$investment_on_share+$investment_on_preferential_share+$investment_on_debenture+$investment_on_agri_tour_and_water
                                                   +$investment_on_cit_and_MF+$class_B_investment+$class_C_investment+$investment_on_non_listed_companies}}</td>
                                    <td>
                                        @if(!empty($total_technical_reserve))
                                            {{round((($investment_on_share+$investment_on_preferential_share+$investment_on_debenture+$investment_on_agri_tour_and_water
                                               +$investment_on_cit_and_MF+$class_B_investment+$class_C_investment+$investment_on_non_listed_companies)/$total_technical_reserve)*100,3)}}
                                            %
                                        @endif
                                    </td>
                                    <td>
                                        @if(!empty($total_technical_reserve))
                                            {{round((($investment_on_share+$investment_on_preferential_share+$investment_on_debenture+$investment_on_agri_tour_and_water
                                               +$investment_on_cit_and_MF+$class_B_investment+$class_C_investment+$investment_on_non_listed_companies)/$total)*100,3)}}
                                            %
                                        @endif
                                    </td>
                                </tr>

                                <tr>

                                    <td colspan="2"> कुल जम्मा लगानी</td>
                                    <td>{{$total}}</td>
                                    <td>
                                        @if(!empty($total_technical_reserve))
                                            {{round(($total/$total_technical_reserve)*100,3)}}
                                            %
                                        @endif
                                    </td>
                                    <td>100%</td>
                                </tr>

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $("#fiscal_year_id").on("change", function () {
            $('#investment-report').submit();
        });

        $("#quarter").on("change", function () {
            $('#investment-report').submit();
        });


    </script>
    <script src="{{asset('js/print.js')}}"></script>
@endsection
