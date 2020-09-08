@extends('layouts.master')
@section('title','Share Value At Date')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-header-rights">
                                Share Summary Report
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{route('share-price-at-date')}}" method="get">
                                <div class="row">
                                    <div class="col-sm-2 my-1">
                                        <label class="" for="fiscal_year_id"><sup class="required-field">*</sup>Fiscal
                                            Year</label>
                                        <div class="input-group">
                                            {{Form::select('fiscal_year_id',$fiscal_years,$_GET['fiscal_year_id'] ?? null,['class'=>'form-control','placeholder'=>'All'])}}
                                        </div>
                                    </div>
                                    <div class="col-sm-2 my-1">
                                        <label class="" for="start_date">Date
                                            : </label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="start_date" name="at_date"
                                                   placeholder="At Date"
                                                   value="{{$_GET['at_date'] ?? null}}"
                                                   readonly required>
                                        </div>
                                    </div>

                                    <div class="col-sm-3 my-1">
                                        <label class="" for="inlineFormInputGroupUsername"><sup
                                                    class="required-field">*</sup>Organization Name</label>
                                        <div class="input-group">
                                            {{Form::select('institution_code',$institutions,$_GET['institution_code'] ?? null,['class'=>'form-control','placeholder'=>'All'])}}
                                        </div>
                                    </div>
                                    <div class="col-sm-2 my-1">
                                        <label class="" for="investment_subtype_id"><sup class="required-field">*</sup>
                                            Investment Sector</label>
                                        <div class="input-group">
                                            {{Form::select('invest_subtype_id',$investment_sectors,$_GET['invest_subtype_id'] ?? null,['class'=>'form-control','placeholder'=>'All'])}}

                                        </div>
                                    </div>
                                    <div class="col-sm-1 text-right">
                                        <button type="submit" class="btn btn-primary form-group">Submit</button>
                                        <a href="{{route('share.index')}}" class="btn btn-danger">Reset</a>
                                    </div>
                                </div>
                            </form>
                            <div class="row">
                                <div id="printableArea" class="col-xl-12 freezeHeaderTableContainer">
                                    <table class="table table-bordered table-responsive freezeHeaderTable">
                                        <thead>
                                        <tr>
                                            <th>Organization Name</th>
                                            <th>Investment Sector</th>
                                            <th>IPO</th>
                                            <th>Promoter</th>
                                            <th>Secondary</th>
                                            <th>Bonus</th>
                                            <th>Right</th>
                                            <th>Sales</th>
                                            <th>Balance</th>
                                            <th>Nepse Rate</th>
                                            <th>Investment Amount</th>
                                            <th>Sales Amount</th>
                                            <th>Closing Balance</th>
                                            <th>Nepse Value</th>
                                            <th>Difference</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($share_institutions as $share_institutions)
                                            @php $temp_share=$share->where('institution_code',$share_institutions->institution_code) @endphp
                                            <tr>
                                                <td>{{$share_institutions->instituteByCode->institution_name}}</td>
                                                <td>{{$temp_share->first()->investment_sector->name ?? ''}}</td>
                                                <td>{{$temp_share->where('share_type_id',1)->sum('purchase_kitta') ?? ''}}</td>
                                                <td>{{$temp_share->where('share_type_id',2)->sum('purchase_kitta') ?? ''}}</td>
                                                <td>{{$temp_share->where('share_type_id',3)->sum('purchase_kitta') ?? ''}}</td>
                                                <td>{{$temp_share->where('share_type_id',4)->sum('purchase_kitta') ?? ''}}</td>
                                                <td>{{$temp_share->where('share_type_id',5)->sum('purchase_kitta') ?? ''}}</td>
                                                <td>{{$temp_share->where('share_type_id',6)->sum('purchase_kitta') ?? ''}}</td>
                                                @php $balance=$temp_share->where('share_type_id','<>',6)->sum('purchase_kitta')-$temp_share->where('share_type_id',6)->sum('purchase_kitta') ?? 0 @endphp
                                                <td>{{ $balance}}</td>
                                                <td>@if(!empty($share_institutions->share_price_last)){{$share_institutions->share_price_last->closing_value}} @else {{'N/A'}} @endif</td>
                                                <td>{{$temp_share->where('share_type_id','<>',6)->sum('total_amount') }}</td>
                                                <td>{{$temp_share->where('share_type_id',6)->sum('total_amount') }}</td>
                                                <td>{{$temp_share->where('share_type_id','<>',6)->sum('total_amount') - $temp_share->where('share_type_id',6)->sum('total_amount') }}</td>
                                                @php $nepseValue=0;
                                                if(!empty($share_institutions->share_price_last))
                                                   {
                                                       $nepseValue= $balance * $share_institutions->share_price_last->closing_value;
                                                   }
                                                @endphp
                                                <td>
                                                    {{$nepseValue ?? 'N/A'}}
                                                </td>
                                                <td>
                                                    {{($nepseValue!=0)?($nepseValue- $temp_share->where('share_type_id','<>',6)->sum('total_amount') - $temp_share->where('share_type_id',6)->sum('total_amount')):'N/A' }}
                                                </td>
                                            </tr>
                                        @endforeach
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
    @include('layouts.deleteModal')
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            $('form').keydown(function (event) {
                // enter has keyCode = 13, change it if you want to use another button
                if (event.keyCode == 13) {
                    $(this).submit();
                    return false;
                }
            });
        });
        $('#start_date,#end_date').flatpickr()
    </script>
@endsection
