@extends('layouts.master')
@section('title','Business Books')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-xl-12">
                    <div class="card">
                        <div class="card-header">

                            <div class="card-header-actions">
                                <a href="{{route('businessbook.create')}}" class="btn btn-sm btn-info">
                                    Add New <i class="nav-icon icon-plus"></i>
                                </a>
                            </div>
                            <div class="card-header-rights">
                                <i class="fas fa-chart-line"></i> Total: {{ $business_books->total() ?? '' }}
                                <button type="button" class="btn btn-primary btn-sm btn-dribbble" data-toggle="modal"
                                        data-target="#excel_import">
                                    Import from Excel <i class="far fa-file-excel"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{route('businessbook.index')}}" method="get">
                                <div class="row">
                                    <div class="col-sm-2 my-1">
                                        <label class="" for="fiscal_year_id"><sup class="required-field">*</sup>Fiscal
                                            Year</label>
                                        <div class="input-group">
                                            {{Form::select('fiscal_year_id',$fiscal_years,$fiscal_year_id ?? '',array('class'=>'form-control','placeholder'=>'All'))}}
                                        </div>
                                    </div>

                                    <div class="col-sm-2 my-1">
                                        <label class="" for="from_date_en"><sup class="required-field">*</sup>Date From
                                            (AD)
                                        </label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="from_date_en"
                                                   id="from_date_en" value="{{$from_date_en ?? ''}}">
                                        </div>
                                    </div>

                                    <div class="col-sm-2 my-1">
                                        <label class="" for="from_date"><sup class="required-field">*</sup>Date From
                                            (BS)
                                        </label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="from_date" id="from_date"
                                                   value="{{$from_date ?? ''}}">
                                        </div>
                                    </div>

                                    <div class="col-sm-2 my-1">
                                        <label class="" for="to_date_en"><sup class="required-field">*</sup>Date To (AD)
                                        </label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="to_date_en" id="to_date_en"
                                                   value="{{$to_date_en ?? ''}}">
                                        </div>
                                    </div>

                                    <div class="col-sm-2 my-1">
                                        <label class="" for="to_date"><sup class="required-field">*</sup>Date To (BS)
                                        </label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="to_date" id="to_date"
                                                   value="{{$to_date_en ?? ''}}">
                                        </div>
                                    </div>

                                    <div class="col-sm-2 my-1">
                                        <label class="" for="organization_branch_id"><sup class="required-field">*</sup>Org.
                                            Branch
                                        </label>
                                        <div class="input-group">
                                            {{Form::select('organization_branch_id',$organization_branches,$organization_branch_id ?? '',array('class'=>'form-control','placeholder'=>'All'))}}

                                        </div>
                                    </div>

                                    <div class="col-sm-2 offset-sm-10 mb-2">
                                        <button type="submit" class="btn btn-primary">Submit</button>
{{--                                        <label for="">Clear All</label>--}}
                                        <a href="{{route('businessbook.index')}}" class="btn btn-danger">Reset</a>
                                    </div>
                                </div>
                            </form>
                            <div class="row">
                                <div class="col-xl-12">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>SN</th>
                                            <th>Fiscal Year</th>
                                            <th>Date</th>
                                            <th>Amount</th>
                                            <th>Branch</th>
                                            <th id="action">Action</th>
                                        </tr>
                                        </thead>
                                        @foreach($business_books as $business_book)
                                            <tr>
                                                <td>{{$i++}}</td>
                                                <td>{{$business_book->fiscalyear->code}}</td>
                                                <td>{{$business_book->date_en}}</td>
                                                <td>{{$business_book->amount}}</td>
                                                <td>{{$business_book->organizationbranch->branch_name or 'NA'}}</td>
                                                <td class="actionbutton">
                                                    <a class="btn btn-info btn-sm"
                                                       href="{{ route('businessbook.show',$business_book->id) }}"><i
                                                                class="fa fa-eye"></i></a>
                                                    <a href="{{route('businessbook.edit',$business_book->id)}}"
                                                       class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a>
                                                    @permission('deposit.destroy')
                                                    <a href="javascript:void(0)" data-id="{{ $business_book->id }}"
                                                       class="btn btn-danger btn-sm btndel">
                                                        <i class="fa fa-times"></i>
                                                    </a>
                                                    @endpermission
                                                </td>
                                            </tr>

                                        @endforeach

                                    </table>
                                </div>
                            </div>
                            <div class="pagination-links">{{ $business_books->appends($_GET)->links()
	  		                    }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="excel_import" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{route('business-book-excel')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Business Book</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Please select a branch</p>
                        <div class="row">
                            <label for="" class="col-md-3">Organization Branch</label>
                            <div class="col-md-9">
                                {{Form::select('organization_branch_id',$organization_branches,$organization_branch_id ?? '',array('class'=>'form-control','placeholder'=>'Select Branch','required'=>'required'))}}
                            </div>

                            <label for="" class="col-md-3">Excel File</label>
                            <div class="col-md-9">
                                <input type="file" name="business_book" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
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
        $('#from_date_en,#to_date_en').flatpickr();

        $('#from_date').nepaliDatePicker({
            npdMonth: true,
            npdYear: true,
            npdYearCount: 10,
            onChange: function (e) {
                $("#from_date").blur();
                $('#from_date_en').val(BS2AD($('#from_date').val()));
            }
        });

        $('#to_date').nepaliDatePicker({
            npdMonth: true,
            npdYear: true,
            npdYearCount: 10,
            onChange: function (e) {
                $("#to_date").blur();
                $('#to_date_en').val(BS2AD($('#to_date').val()));
            }
        });

        $('#from_date_en').change(function () {
            $('#from_date').val(AD2BS($('#from_date_en').val()));
        });

        $('#to_date_en').change(function () {
            $('#to_date').val(AD2BS($('#to_date_en').val()));
        });

        $('.btndel').click(function (e) {
            e.preventDefault();
            var del_url = '{{ URL::to('businessbook') }}/' + $(this).data('id');
            console.log(del_url);
            $('#firstform')[0].setAttribute('action', del_url);
            $('#deleteModal')
                .modal('show')
            ;
        });
    </script>
@endsection
