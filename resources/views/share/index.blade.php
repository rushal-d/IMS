@extends('layouts.master')
@section('title','Share')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">

            <div class="card">
                <div class="card-header">
                    <div class="card-header-actions">

                        <a href="{{route('share.create')}}" class="btn btn-sm btn-info">
                            Add New Share <i class="nav-icon icon-plus"></i>
                        </a>

                        <a href="{{route('dividend.create')}}" class="btn btn-sm btn-success">
                            Add Dividend <i class="nav-icon icon-plus"></i>
                        </a>
                    </div>
                    <div class="card-header-rights">
                        <i class="fas fa-chart-line"></i> Total: {{ $shares->total() ?? '' }}
                        <button class="downexcel btn btn-sm btn-dribbble">
                            Export to Excel <i class="far fa-file-excel"></i>
                        </button>
                        <button class="excelimport btn btn-sm btn-success">
                            Import from Excel <i class="far fa-file-excel"></i>
                            <form action="{{route('share.import')}}" method="post"
                                  enctype="multipart/form-data" id="import_form">
                                @csrf
                                <input type="file" id="share_excel" name="share_excel" hidden>
                            </form>
                        </button>

                        <a onclick="printDiv('printableArea')" class="btn btn-sm btn-dropbox">
                            Print <i class="fa fa-print"></i>
                        </a>
                        &nbsp;
                    </div>
                </div>
                <div class="card-body">
                    <form id="filterForm" action="{{route('share.index')}}" method="get">
                        <div class="row">
                            <div class="col-sm-2 my-1">
                                <label class="" for="fiscal_year_id">
                                    Fiscal Year</label>
                                <div class="input-group">
                                    {{Form::select('fiscal_year_id',$fiscal_years->pluck('code','id'),$_GET['fiscal_year_id'] ?? null,['class'=>'form-control','placeholder'=>'All'] )}}
                                </div>
                            </div>
                            <div class="col-sm-2 my-1">
                                <label class="" for="start_date">From (AD)
                                    : </label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="start_date" name="start_date"
                                           placeholder="Start Date"
                                           value="{{$_GET['start_date'] ?? null}}"
                                           readonly>
                                </div>
                            </div>

                            <div class="col-sm-2 my-1">
                                <label class="" for="start_date_np">From (BS)
                                    : </label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="start_date_np" name="start_date_np"
                                           placeholder="Start Date (BS)"
                                           value="{{$_GET['start_date_np'] ?? null}}"
                                           readonly>

                                </div>
                            </div>

                            <div class="col-sm-2 my-1">
                                <label class="" for="end_date">To (AD)
                                    : </label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="end_date" name="end_date"
                                           placeholder="End Date"
                                           value="{{$_GET['end_date'] ?? null}}"
                                           readonly>

                                </div>
                            </div>

                            <div class="col-sm-2 my-1">
                                <label class="" for="end_date_np">To (BS)
                                    : </label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="end_date_np" name="end_date_np"
                                           placeholder="End Date (BS)"
                                           value="{{$_GET['end_date_np'] ?? null}}"
                                           readonly>
                                </div>
                            </div>

                            <div class="col-sm-5 my-1">
                                <label class="" for="inlineFormInputGroupUsername">
                                    Organization Name</label>
                                <div class="input-group">
                                    {{Form::select('institution_code',$institutes->pluck('institution_name','institution_code'),$_GET['institution_code'] ?? null,['class'=>'form-control','placeholder'=>'All'])}}
                                </div>
                            </div>
                            <div class="col-sm-4 my-1">
                                <label class="" for="investment_subtype_id">
                                    Investment Sector</label>
                                <div class="input-group">

                                    {!! Form::select('investment_subtype_id', $investment_subtypes->pluck('name','id') , $_GET['investment_subtype_id'] ?? null,['class'=>'form-control','placeholder'=>'All'] ) !!}

                                </div>
                            </div>

                            <div class="col-sm-2 my-1">
                                <label class="" for="investment_subtype_id">
                                    Share Type</label>
                                <div class="input-group">

                                    {!! Form::select('share_type',$share_types , $_GET['share_type'] ?? null,['class'=>'form-control','placeholder'=>'All'] ) !!}

                                </div>
                            </div>
                            <div class="col-sm-5 text-left mt-4">
                                <input type="submit" class="btn btn-primary" value="Filter">
                                <a href="{{route('share.index')}}" class="btn btn-danger">Reset</a>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div id="printableArea" class="col-xl-12 freezeHeaderTableContainer">
                            <table class="table freezeHeaderTable">
                                <thead>
                                <tr>
                                    <th>Fiscal Year</th>
                                    <th>Transaction Date</th>
                                    <th>Institution Code</th>
                                    <th>Investment Sector</th>
                                    <th>Share Type</th>
                                    <th>No. Of Kitta</th>
                                    <th>Rate Per Unit</th>
                                    <th>Total Amount</th>
                                    <th id="action">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(!empty($shares) or count($shares) > 0)
                                    @foreach($shares as $share)
                                        <tr>
                                            <td>{{$share->fiscalyear->code}}</td>
                                            <td>{{$share->trans_date}}</td>
                                            <td>{{$share->instituteByCode->institution_name}}</td>
                                            <td>{{$share->investment_sector->name}}</td>
                                            <td>{{$share_types[$share->share_type_id]}}</td>
                                            <td>{{$share->purchase_kitta}}</td>
                                            <td>{{round($share->purchase_value,3)}}</td>
                                            <td>{{round($share->total_amount,3)}}</td>
                                            <td class="actionbutton">
                                                <a class="btn btn-info btn-sm"
                                                   href="{{ route('share.show',$share->id) }}"><i
                                                            class="fa fa-eye"></i></a>
                                                <a href="{{route('share.edit',$share->id)}}"
                                                   class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a>
                                                {{--@permission('share.destroy')--}}
                                                <a href="javascript:void(0)" data-id="{{ $share->id }}"
                                                   class="btn btn-danger btn-sm btndel">
                                                    <i class="fa fa-times"></i>
                                                </a>
                                                {{--@endpermission--}}
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr class="total">
                                        <td colspan="8" class="text-center">Opening Balance</td>
                                        <td> {{$openingBalance}} </td>
                                        <td colspan="2"></td>
                                    </tr>
                                    <tr class="total">
                                        <td colspan="8" class="text-center">Total Rs</td>
                                        <td>@if(!empty($sharetotalamount)) {{$sharetotalamount}} @endif</td>
                                        <td colspan="2"></td>
                                    </tr>
                                    <tr class="total">
                                        <td colspan="8" class="text-center">Closing Balance</td>
                                        <td>{{$openingBalance+$sharetotalamount}}</td>
                                        <td colspan="2"></td>
                                    </tr>
                                @else
                                    <tr>
                                        <td>No Data Found</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>

                            {{$shares->appends($_GET)->links()}}
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

        $('.excelimport').click(function () {
            openDialog();
        });

        function openDialog() {
            document.getElementById('share_excel').click();
        }

        $('#share_excel').change(function () {
            document.getElementById("import_form").submit();
        })

        $('.btndel').click(function (e) {
            e.preventDefault();
            var del_url = '{{ URL::to('share') }}/' + $(this).data('id');
            console.log(del_url);
            $('#firstform')[0].setAttribute('action', del_url);
            $('#deleteModal')
                .modal('show')
            ;
        });

        $('#start_date,#end_date').flatpickr()

        $('.downexcel').on("click", function () {
            $('#filterForm').attr('action', '{{route('share.excel')}}');
            $('#filterForm').submit()
        });

        $('#start_date').change(function () {
            let start_date_en = $('#start_date').val();
            if (start_date_en != '') {
                $('#start_date_np').val(AD2BS(start_date_en));
            } else {
                $('#start_date_np').val('');
            }
        });

        $('#end_date').change(function () {
            let end_date_en = $('#end_date').val();
            if (end_date_en != '') {
                $('#end_date_np').val(AD2BS(end_date_en));
            } else {
                $('#end_date_np').val('');
            }
        });

        $('#start_date_np').nepaliDatePicker({
            npdMonth: true,
            npdYear: true,
            npdYearCount: 10,
            onChange: function (e) {
                $('#start_date').val(BS2AD($('#start_date_np').val()));
            }
        });
        $('#end_date_np').nepaliDatePicker({
            npdMonth: true,
            npdYear: true,
            npdYearCount: 10,
            onChange: function (e) {
                $('#end_date').val(BS2AD($('#end_date_np').val()));
            }
        });
    </script>
    <script src="{{asset('js/print.js')}}"></script>
@endsection
