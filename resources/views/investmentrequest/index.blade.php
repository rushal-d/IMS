@extends('layouts.master')
@section('title','Investment Request')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-header-actions">
                                <a href="{{route('investment-request.create')}}" class="btn btn-sm btn-info">
                                    Add New <i class="nav-icon icon-plus"></i>
                                </a>
                            </div>
                            <div class="card-header-rights">
                                <i class="fas fa-chart-line"></i> Total: {{ $investment_requests->total() ?? '' }}
                                <button class="downexcel btn btn-sm btn-dribbble">
                                    Export to Excel <i class="far fa-file-excel"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="filterForm" action="{{route('investment-request.index')}}" method="get">
                                <div class="row">
                                    <div class="col-sm-2 my-1">
                                        <label class="" for="from_date_en">Date From
                                            (AD)
                                        </label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="from_date_en"
                                                   id="from_date_en" value="{{$_GET['from_date_en']  ?? ''}}">
                                        </div>
                                    </div>
                                    <div class="col-sm-2 my-1">
                                        <label class="" for="from_date">Date From
                                            (BS)
                                        </label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="from_date" id="from_date"
                                                   value="{{$_GET['from_date']  ?? ''}}">
                                        </div>
                                    </div>

                                    <div class="col-sm-2 my-1">
                                        <label class="" for="to_date_en">Date To (AD)
                                        </label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="to_date_en" id="to_date_en"
                                                   value="{{$_GET['to_date_en']  ?? ''}}">
                                        </div>
                                    </div>

                                    <div class="col-sm-2 my-1">
                                        <label class="" for="to_date">Date To (BS)
                                        </label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="to_date" id="to_date"
                                                   value="{{$_GET['to_date'] ?? ''}}">
                                        </div>
                                    </div>

                                    <div class="col-sm-2 my-1">
                                        <label class="" for="organization_branch_id">Org.
                                            Branch
                                        </label>
                                        <div class="input-group">
                                            {{Form::select('organization_branch_id',$organization_branches,$_GET['organization_branch_id'] ?? '',array('class'=>'form-control','placeholder'=>'All'))}}

                                        </div>
                                    </div>

                                    <div class="col-sm-3 my-1">
                                        <label class="" for="organization_branch_id">Bank
                                        </label>
                                        <div class="input-group">
                                            {{Form::select('institution_id',$investment_institutions,$_GET['institution_id'] ?? '',array('class'=>'form-control','placeholder'=>'All'))}}

                                        </div>
                                    </div>

                                    <div class="col-sm-2 mt-4">
                                        <button type="submit" class="btn btn-primary">Submit</button>
{{--                                        <label for="">Clear All</label>--}}
                                        <a href="{{route('investment-request.index')}}" class="btn btn-danger">Reset</a>
                                    </div>
                                </div>
                            </form>
                            <div class="row">
                                <div class="col-xl-12">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>SN</th>
                                            <th>Date</th>
                                            <th>Bank</th>
                                            <th>Amount</th>
                                            <th>Interest Rate</th>
                                            <th>Status</th>
                                            <th id="action">Action</th>
                                        </tr>
                                        </thead>
                                        @foreach($investment_requests as $investment_request)
                                            <tr>
                                                <td>{{$i++}}</td>
                                                <td>{{$investment_request->request_date_en}}</td>
                                                <td>{{$investment_request->institution->institution_name or 'NA'}}</td>
                                                <td>{{$investment_request->deposit_amount or 'NA'}}</td>
                                                <td>{{$investment_request->interest_rate or 'NA'}}</td>
                                                <td>{{$investment_request_status[$investment_request->status] or 'NA'}}</td>
                                                <td class="actionbutton">
                                                    <a class="btn btn-info btn-sm"
                                                       href="{{ route('investment-request.show',$investment_request->id) }}"><i
                                                                class="fa fa-eye"></i></a>
                                                    <a href="{{route('investment-request.edit',$investment_request->id)}}"
                                                       class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a>
                                                    @permission('deposit.destroy')
                                                    <a href="javascript:void(0)" data-id="{{ $investment_request->id }}"
                                                       class="btn btn-danger btn-sm btndel">
                                                        <i class="fa fa-times"></i>
                                                    </a>
                                                    @endpermission
                                                    @if($investment_request->status != 2)
                                                    <a href="javascript:void(0)" data-toggle = "modal" data-id = "{{$investment_request->id}}" data-status-id = "{{$investment_request->status}}"
                                                       class="btn btn-warning btn-sm status_change" >
                                                        <i class="fas fa-exchange-alt"></i>
                                                    </a>
                                                    @endif
                                                </td>
                                            </tr>

                                        @endforeach

                                    </table>
                                </div>
                            </div>
                            <div class="pagination-links">{{ $investment_requests->appends($_GET)->links()
	  		                    }}
                            </div>
                            <div class="modal fade" id="myModal">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Edit Status</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>

                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            <label for="">Select Request Status</label>
                                            <?php $investment_request_status = Config::get('constants.investment_request_status');?>
                                            {{Form::select('request_status', $investment_request_status, null, ['class' => 'form-control', 'id' => 'request_status', 'placeholder' => 'Select Request Status', 'data-validation' => 'required'] )}}
                                        </div>

                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-success" id="update_request_status_submit" data-dismiss="modal">Update
                                            </button>
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                        </div>

                                    </div>
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
        $('#from_date_en,#to_date_en').flatpickr();

        //edit in modal
            let new_id = null;
        $('.status_change').on('click', function(){
            new_id = $(this).data('id');
            // console.log('hello');
            $('#myModal').modal('show');
                $('#request_status')[0].selectize.setValue($(this).data('status-id'));
        });
        //ajax update
        $('#update_request_status_submit').click(function () {

            let updated_request_status = $('#request_status').val();
            $.ajax(({
                url: '{{route('investment-request.ajaxUpdate')}}',
                type: 'patch',
                data: {
                    '_token': '{{csrf_token()}}',
                    id: new_id,
                    request_status: updated_request_status
                },
                success: function (data) {
                    console.log(updated_request_status);
                    if(updated_request_status == 2){
                        $.ajax(({
                            url: 'investment-request/transfer-to-deposits/'+new_id,
                            data:{
                                id: new_id,
                                is_ajax: true
                            },
                            success:function(response){
                                if(response.status == true){
                                    Swal.fire({
                                        position: 'center',
                                        type: 'success',
                                        title: 'Your work has been saved',
                                        showConfirmButton: false,
                                        timer: 1500
                                    })
                                    setInterval('location.reload()', 1500);
                                }
                            }
                        }));
                    }
                    else{
                        setInterval('location.reload()', 1500);
                        Swal.fire({
                            position: 'center',
                            type: 'success',
                            title: 'Your work has been saved',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                },
                error: function (data) {
                    Swal.fire({
                        type: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!',
                        footer: '<a href>Why do I have this issue?</a>'
                    })
                }
            }));
        });

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

        //Excel export
        $('.downexcel').on("click", function () {
            $('#filterForm').attr('action', '{{route('investment-request.excel')}}');
            $('#filterForm').submit()
        });

        $('.btndel').click(function (e) {
            e.preventDefault();
            var del_url = '{{ URL::to('investment-request') }}/' + $(this).data('id');
            console.log(del_url);
            $('#firstform')[0].setAttribute('action', del_url);
            $('#deleteModal')
                .modal('show')
            ;
        });

        /*update request_status from ajax*/



    </script>
@endsection
