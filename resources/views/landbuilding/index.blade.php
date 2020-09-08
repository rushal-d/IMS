@extends('layouts.master')
@section('title','Land & Building Investment')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-header-actions">
                                <a href="{{route('land-building-investments.create')}}" class="btn btn-sm btn-info">
                                    Add New <i class="nav-icon icon-plus"></i>
                                </a>
                            </div>
                            <div class="card-header-rights">

                                {{--<button class="downexcel btn btn-sm btn-dribbble">
                                    Export to Excel <i class="far fa-file-excel"></i>
                                </button>--}}


                                <a onclick="printDiv('printableArea')" class="btn btn-sm btn-dropbox">
                                    Print <i class="fa fa-print"></i>
                                </a>
                                &nbsp;
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="filterForm" action="{{route('land-building-investments.index')}}" method="get">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-2 my-1">
                                        <label class="" for="fiscal_year_id">
                                            Fiscal Year</label>
                                        <div class="input-group">
                                            {{Form::select('fiscal_year_id',$fiscal_years->pluck('code','id'),$_GET['fiscal_year_id'] ?? null,['class'=>'form-control','placeholder'=>'All'] )}}
                                        </div>
                                    </div>
                                    <div class="col-sm-2 my-1">
                                        <label class="" for="start_date">From
                                            : </label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="start_date" name="start_date"
                                                   placeholder="Start Date"
                                                   value="{{$_GET['start_date'] ?? null}}"
                                                   readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-2 my-1">
                                        <label class="" for="end_date">To
                                            : </label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="end_date" name="end_date"
                                                   placeholder="End Date"
                                                   value="{{$_GET['end_date'] ?? null}}"
                                                   readonly>

                                        </div>
                                    </div>
                                    <div class="col-sm-2 my-1">
                                        <label class="" for="inlineFormInputGroupUsername">
                                           Site Location</label>
                                        <div class="input-group">
                                            {{Form::text('site_location',$_GET['site_location'] ?? null,['class'=>'form-control','placeholder'=>'Site Location'])}}
                                        </div>
                                    </div>
                                    <div class="col-sm-2 my-1">
                                        <label class="" for="investment_subtype_id">
                                            Type</label>
                                        <div class="input-group">

                                            {!! Form::select('investment_through', $investment_through , $_GET['investment_through'] ?? null,['class'=>'form-control','placeholder'=>'All'] ) !!}

                                        </div>
                                    </div>

                                    <div class="col-sm-1 text-right">
                                        <label for=""></label>
                                        <input type="submit" class="btn btn-primary form-control" value="Filter">
                                    </div>
                                    <div class="col-sm-1 text-right">
                                        <label for=""></label>
                                        <a href="{{route('land-building-investments.index')}}" class="btn btn-danger">Reset</a>
                                    </div>
                                </div>
                            </form>
                            <div class="row">
                                <div id="printableArea" class="col-xl-12 freezeHeaderTableContainer">
                                    <table class="table freezeHeaderTable">
                                        <thead>
                                        <tr>
                                            <th>Fiscal Year</th>
                                            <th>Date</th>
                                            <th>Site Location</th>
                                            <th>Type</th>
                                            <th>Total Amount</th>
                                            <th id="action">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @if(count($investments) > 0)
                                            @foreach($investments as $investment)
                                                <tr>
                                                    <td>{{$investment->fiscalyear->code ?? ''}}</td>
                                                    <td>{{$investment->date_en}}</td>
                                                    <td>{{$investment->site_location}}</td>
                                                    <td>{{$investment_through[$investment->type] ?? ''}}</td>
                                                    <td>{{$investment->amount}}</td>

                                                    <td class="actionbutton">
                                                        <a class="btn btn-info btn-sm"
                                                           href="{{ route('land-building-investments.show',$investment->id) }}"><i
                                                                    class="fa fa-eye"></i></a>
                                                        <a href="{{route('land-building-investments.edit',$investment->id)}}"
                                                           class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a>

                                                        <a href="javascript:void(0)" data-id="{{ $investment->id }}"
                                                           class="btn btn-danger btn-sm btndel">
                                                            <i class="fa fa-times"></i>
                                                        </a>

                                                    </td>
                                                </tr>
                                            @endforeach
                                            <tr class="total">
                                                <td colspan="4" class="text-center">Total Rs</td>
                                                <td>@if(!empty($investment_total)) {{$investment_total}} @endif</td>
                                                <td colspan="2"></td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td colspan="6">No Data Found</td>
                                            </tr>
                                        @endif
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


        $('.btndel').click(function (e) {
            e.preventDefault();
            var del_url = '{{ URL::to('land-building-investments') }}/' + $(this).data('id');
            console.log(del_url);
            $('#firstform')[0].setAttribute('action', del_url);
            $('#deleteModal')
                .modal('show')
            ;
        });

        $('#start_date,#end_date').flatpickr()

    </script>
    <script src="{{asset('js/print.js')}}"></script>
@endsection
