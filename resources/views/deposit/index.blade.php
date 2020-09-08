@extends('layouts.master')
@section('title','Deposits')
@section('styles')
    <style>
        .hide {
            display: none;
        }

        .blink_me {
            color: red;
            animation: blinker 3s linear infinite;
        }

        .fa-check-circle {
            color: green;
        }

        .fa-stop-circle {
            color: red;
        }

        .fa-retweet {
            color: blue;
        }

        @keyframes blinker {
            50% {
                opacity: 0;
            }
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
                            {{--<i class="fa fa-align-justify"></i>--}}
                            {{--Deposit--}}
                            <div class="card-header-actions">
                                <a href="{{route('deposit.create')}}" class="btn btn-sm btn-info">
                                    Add New Deposit <i class="nav-icon icon-plus"></i>
                                </a>
                                <label for="">Active</label>
                                <i class="far fa-check-circle"></i>

                                <label for="">Renew Soon</label>
                                <i class="fa fa-exclamation-triangle blink_me"
                                   aria-hidden="true"></i>

                                <label for="">Expired</label>
                                <i class="far fa-stop-circle"></i>

                                <label for="">Renewed</label>
                                <i class="fas fa-retweet"></i>

                                <label for="">Withdrawn</label>
                                <i class="fas fa-money-bill-wave-alt"></i>

                            </div>
                            <div class="card-header-rights">

                                <i class="fas fa-chart-line"></i> Total: {{ $totalCount ?? '' }}
                                {{-- <a onclick="printDiv('printableArea')" class="btn btn-sm btn-dropbox">
                                     Print <i class="fa fa-print"></i>
                                 </a>--}}
                                <a href="{{route('depsit-excel-export-column')}}" class="btn btn-sm btn-dropbox">
                                    <i class="fa fa-cogs" data-toggle="tooltip" data-placement="top"
                                       title="Export Column Config"></i>
                                </a>
                                &nbsp;
                                <button class="excelimport btn btn-sm btn-success">
                                    Import from Excel <i class="far fa-file-excel"></i>
                                    <form action="{{route('deposit.import')}}" method="post"
                                          enctype="multipart/form-data" id="import_form">
                                        @csrf
                                        <input type="file" id="deposit_excel" name="deposit_excel" hidden>
                                    </form>
                                </button>

                                <button class="downexcel btn btn-sm btn-dribbble">
                                    Export to Excel <i class="far fa-file-excel"></i>
                                </button>

                                <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#exportLedger">
                                    Export Ledger <i class="far fa-file-excel"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="depositFilter" action="{{route('deposit.index')}}" method="get">
                                <div class="row">
                                    <div class="col-sm-2 my-1">
                                        <label class="" for="fiscal_year_id">
                                            Fiscal Year</label>
                                        <div class="input-group">
                                            {{Form::select('fiscal_year_id',$fiscal_years->pluck('code','id'),$_GET['fiscal_year_id'] ?? $fiscal_years->where('status',1)->first()->id ?? null,['class'=>'form-control','placeholder'=>'ALL'])}}
                                        </div>
                                    </div>

                                    <div class="col-sm-2 my-1">
                                        <label class="" for="start_date">From (En)
                                            : </label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="start_date_en"
                                                   name="start_date_en"
                                                   placeholder="Start Date En"
                                                   value="{{$_GET['start_date_en'] ?? null}}">

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
                                        <label class="" for="end_date">To (En)
                                            : </label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="end_date_en" name="end_date_en"
                                                   placeholder="End Date" data-validation="date_selector_validation"
                                                   value="{{$_GET['end_date_en'] ?? null}}">
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
                                        <label class="" for="earmarked">Earmarked</label>
                                        <div class="input-group">
                                            {!! Form::select('earmarked',$earmarked_constants,$_GET['earmarked'] ?? null,['class'=>'form-control','placeholder'=>'ALL']) !!}
                                        </div>
                                    </div>
                                    <div class="col-sm-2 my-1">
                                        <label class="" for="earmarked">Fd Document Location</label>
                                        <div class="input-group">
                                            {!! Form::select('fd_document_locations',$fd_document_locations,$_GET['fd_document_locations'] ?? null,['class'=>'form-control','placeholder'=>'ALL']) !!}
                                        </div>
                                    </div>
                                    <div class="col-sm-4 my-1">
                                        <label class="" for="institution_id">
                                            Bank Name</label>
                                        <div class="input-group">
                                            {!! Form::select('institution_id',$institutes,$_GET['institution_id'] ?? null,['class'=>'form-control','placeholder'=>'ALL']) !!}
                                        </div>
                                    </div>

                                    <div class="col-sm-2 my-1">
                                        <label class="" for="bank">FD Number</label>
                                        <div class="input-group">
                                            {!! Form::text('fd_number',$_GET['fd_number'] ?? null,['class'=>'form-control','placeholder'=>'FD Number']) !!}
                                        </div>
                                    </div>

                                    <div class="col-sm-2 my-1">
                                        <label class="" for="bank">Branch
                                            Name</label>
                                        <div class="input-group">
                                            {!! Form::select('branch_id',$banks,$_GET['branch_id'] ?? null,['class'=>'form-control','placeholder'=>'ALL']) !!}
                                        </div>
                                    </div>

                                    <div class="col-sm-2 my-1">
                                        <label class="" for="investment_subtype_id">
                                            Deposit Type</label>
                                        <div class="input-group">
                                            {!! Form::select('investment_subtype_id',$investment_subtypes,$_GET['investment_subtype_id'] ?? null,['class'=>'form-control','placeholder'=>'ALL']) !!}
                                        </div>
                                    </div>

                                    <div class="col-sm-2 my-1">
                                        <label class="" for="status">Status </label>
                                        <div class="input-group">
                                            {!! Form::select('status[]',$deposit_statuses,$_GET['status'] ?? null,['class'=>'form-control','placeholder'=>'ALL','multiple'=>true]) !!}
                                        </div>
                                    </div>

                                    <div class="col-sm-2 my-1">
                                        <label class="mature_days" for="status">Mature Days</label>
                                        <div class="input-group">
                                            {!! Form::select('mature_days',$mature_days_filter,$_GET['mature_days'] ?? null,['class'=>'form-control','placeholder'=>'ALL']) !!}
                                        </div>
                                    </div>

                                    <div class="col-sm-2 my-1">
                                        <label class="" for="organization_branch_id">Organization Branch</label>
                                        <div class="input-group">
                                            {!! Form::select('organization_branch_id',$organization_branches,$_GET['organization_branch_id'] ?? null,['class'=>'form-control','placeholder'=>'ALL']) !!}
                                        </div>
                                    </div>

                                    <div class="col-sm-2 my-1">
                                        <label class="" for="staff_id">Staff</label>
                                        <div class="input-group">
                                            {!! Form::select('staff_id',$staffs,$_GET['staff_id'] ?? null,['class'=>'form-control','placeholder'=>'ALL']) !!}
                                        </div>
                                    </div>

                                    <div class="col-sm-2 my-1">
                                        <label class="" for="staff_id">Include Pending</label>
                                        <div class="input-group">
                                            {!! Form::checkbox('include_pending',1,$_GET['include_pending'] ?? false) !!}
                                        </div>
                                    </div>

                                    <div class="col-sm-2 mt-4">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        <a href="{{route('deposit.index')}}" class="btn btn-danger">Reset</a>
                                    </div>
                                </div>
                            </form>
                            @if($show_index)
                                <div class="row">
                                    <div id="printableArea" class="col-xl-12 freezeHeaderTableContainer">
                                        <table class="table freezeHeaderTable">
                                            <thead>
                                            <tr>
                                                <th>Status</th>
                                                {{--reference number for LGI--}}
                                                @if(!empty($userOrganization) && $userOrganization->organization_code== '0415')
                                                    <th>Ref Number</th>
                                                @endif
                                                <th>Institution Name</th>
                                                <th>Branch</th>
                                                <th>Txn Date</th>
                                                <th>Mature Date</th>
                                                <th>FD No.</th>
                                                <th>Deposit Amount</th>
                                                <th>Withdraw Amount</th>
                                                <th>Rate</th>
                                                <th>Status</th>
                                                <th id="action">Action</th>
                                            </tr>
                                            </thead>
                                            @if(!empty($deposits) or count($deposits) > 0)
                                                @php
                                                    $allow_delete=false;
                                                @endphp
                                                @permission('deposit.destroy')
                                                @php
                                                    $allow_delete=true;
                                                @endphp
                                                @endpermission
                                                <tbody>
                                                @foreach($details as $deposit)
                                                    <tr>
                                                        <td>
                                                            @if($deposit->status == 1)
                                                                <i class="far fa-check-circle" data-toggle="tooltip"
                                                                   data-placement="top" title="Active"></i>
                                                            @elseif($deposit->status == 2)
                                                                <i class="fa fa-exclamation-triangle blink_me"
                                                                   data-toggle="tooltip" data-placement="top"
                                                                   title="Renew Soon"
                                                                   aria-hidden="true"></i>
                                                            @elseif($deposit->status == 3)
                                                                <i class="far fa-stop-circle" data-toggle="tooltip"
                                                                   data-placement="top" title="Expired"></i>
                                                            @elseif($deposit->status == 4)
                                                                <i class="fas fa-retweet" data-toggle="tooltip"
                                                                   data-placement="top" title="Renewed"></i>
                                                            @endif
                                                            <br>
                                                            <br>
                                                            <a href="{{route('interestearnedentry.create',['id'=>$deposit->id])}}"
                                                               class="btn btn-dark btn-sm" target="_blank">
                                                                <i class="far fa-money-bill-alt" data-toggle="tooltip"
                                                                   data-placement="top" title="Interest Earned"></i></a>

                                                        </td>
                                                        @if(!empty($userOrganization) && $userOrganization->organization_code== '0415')
                                                            <th>{{$deposit->reference_number}}</th>
                                                        @endif
                                                        <td>
                                                            <a href="{{route('deposit.show', $deposit->id)}}">
                                                                {{$deposit->institute->institution_name ?? $deposit->account_head ?? ''}}
                                                                @if(!empty($deposit->institute->mergedTo) && !empty($deposit->bank_merger_id))
                                                                    ({{ $deposit->institute->mergedTo->institution_code ?? '' }}
                                                                    )
                                                                @endif
                                                            </a>
                                                            @if(!empty($deposit->approved_by))
                                                                <i class="fas fa-certificate" data-toggle="tooltip"
                                                                   data-placement="top" title="Approved Record"></i>
                                                            @endif
                                                        </td>
                                                        <td>{{$deposit->branch->branch_name ?? 'NA'}}</td>
                                                        <td>{{$deposit->trans_date_en}}</td>
                                                        <td>{{$deposit->mature_date_en}}</td>
                                                        <td>{{$deposit->document_no}}</td>
                                                        <td>{{$deposit->deposit_amount}}</td>
                                                        <td>-</td>
                                                        <td>{{$deposit->interest_rate}}</td>
                                                        <td>
                                                            @if($deposit->is_pending==1)
                                                                Pending
                                                            @endif
                                                            @if($deposit->status == 1)
                                                                @if(!empty($deposit->parent_id))
                                                                    Renewed & Active
                                                                @else
                                                                    Active
                                                                @endif

                                                            @elseif($deposit->status == 2)
                                                                Renew Soon<br>
                                                                <a href="{{route('deposit.renew', $deposit->id)}}"
                                                                   class="btn btn-success">Renew</a><br>
                                                                <a href="javascript:void(0)"
                                                                   data-id="{{ $deposit->id }}"
                                                                   class="btn btn-warning btnwithdraw">WithDraw</a>
                                                            @elseif($deposit->status == 3)
                                                                Expired<br>
                                                                <a href="{{route('deposit.renew', $deposit->id)}}"
                                                                   class="btn btn-success">Renew</a><br>
                                                                <a href="javascript:void(0)"
                                                                   data-id="{{ $deposit->id }}"
                                                                   class="btn btn-warning btnwithdraw">WithDraw</a>
                                                            @elseif($deposit->status == 4)
                                                                Expired & Has Been Renewed
                                                            @else
                                                                WithDrawn
                                                            @endif

                                                        </td>
                                                        <td class="actionbutton">
                                                            <a class="btn btn-info btn-sm"
                                                               href="{{ route('deposit.show',$deposit->id) }}"
                                                               data-toggle="tooltip" data-placement="top"
                                                               title="Show"><i
                                                                        class="fa fa-eye"></i></a>
                                                            <a href="{{route('deposit.edit',$deposit->id)  .'?'.$parameters  }}"
                                                               class="btn btn-success btn-sm" data-toggle="tooltip"
                                                               data-placement="top" title="Edit"><i
                                                                        class="fa fa-edit"></i></a>
                                                            @if($allow_delete)
                                                                <a href="javascript:void(0)"
                                                                   data-id="{{ $deposit->id }}"
                                                                   class="btn btn-danger btn-sm btndel"
                                                                   data-toggle="tooltip" data-placement="top"
                                                                   title="Delete">
                                                                    <i class="fa fa-times"></i>
                                                                </a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @if(!empty($deposit->withdraw))
                                                        <tr>
                                                            <td><i class="fas fa-money-bill-wave-alt"
                                                                   data-toggle="tooltip" data-placement="top"
                                                                   title="Withdrawn"></i></td>
                                                            @if(!empty($userOrganization) && $userOrganization->organization_code== '0415')
                                                                <th>{{$deposit->reference_number}}</th>
                                                            @endif
                                                            <td>
                                                                {{$deposit->institute->institution_name ?? 'NA'}}
                                                                @if(!empty($deposit->withdraw->approved_by))
                                                                    <i class="fas fa-certificate" data-toggle="tooltip"
                                                                       data-placement="top" title="Delete"></i>
                                                                @endif
                                                            </td>
                                                            <td>{{$deposit->branch->branch_name or 'NA'}}</td>
                                                            <td>{{$deposit->trans_date_en}}</td>
                                                            <td>{{$deposit->mature_date_en}}</td>
                                                            <td>{{$deposit->document_no}}</td>
                                                            <td>0</td>
                                                            <td>{{$deposit->withdraw->withdraw_amount ?? '-'}}</td>
                                                            <td>{{$deposit->interest_rate}}</td>
                                                            <td>
                                                                Withdraw Date: [{{$deposit->withdraw->withdrawdate_en}}]
                                                            </td>
                                                            <td>
                                                                <a href="{{route('deposit.withdrawedit',$deposit->withdraw->id)}}"
                                                                   class="btn btn-success btn-sm"><i
                                                                            class="fa fa-edit" data-toggle="tooltip"
                                                                            data-placement="top" title="Edit"></i></a>
                                                                @if($allow_delete)
                                                                    <a href="javascript:void(0)"
                                                                       data-id="{{ $deposit->withdraw->id }}"
                                                                       class="btn btn-danger btn-sm btndelwithdraw"
                                                                       data-toggle="tooltip" data-placement="top"
                                                                       title="Delete">
                                                                        <i class="fa fa-times"></i>
                                                                    </a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                                <tr>
                                                    @if(!empty($userOrganization) && $userOrganization->organization_code== '0415')
                                                        <td></td>
                                                    @endif
                                                    <td colspan="6" style="text-align:right;">Total</td>
                                                    <td style="text-align:left;"
                                                        colspan="">{{ $deposittotalamount ?? '-' }}</td>
                                                    <td>{{$deposite_withdraw_total?? ''}}</td>
                                                    <td colspan="3"></td>
                                                </tr>
                                                @else
                                                    <tr>
                                                        <td>No Data Found</td>
                                                    </tr>
                                                @endif

                                                </tbody>
                                        </table>
                                        {{$details->appends($_GET)->links()}}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Next Status</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <label for="">Select a Status</label>
                    {{Form::select('next_status', ['1' => 'Withdraw', '2' => 'Renew'], null, ['class' => 'form-control', 'id' => 'next_status', 'placeholder' => 'Select A Status', 'data-validation' => 'required'] )}}
                    <div id="next_interest">
                        <label for="">New Interest Rate</label>
                        {!! Form::text('next_interest_rate', null, ['class' => 'form-control', 'id' => 'next_interest_rate', 'placeholder' => 'Interest Rate']) !!}
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="update_next_status" data-dismiss="modal">Update
                    </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.deleteModal')
    <div class="modal fade" id="withdrawModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"><i class="far fa-trash-alt"></i> Confirm WithDraw</h4>
                </div>
                <form id="secondform" action="" method="get">
                    <div class="modal-body">
                        Are you Sure You Want To WithDraw ?
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary modal-delete">Yes
                        </button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- Modal -->
    <div class="modal fade" id="exportLedger" tabindex="-1" role="dialog" aria-labelledby="exportLedgerlabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Export Ledger</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{route('deposit.ledger.excel')}}" method="GET">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="">Fiscal Year</label>
                            </div>
                            <div class="col-md-9">
                                {!! Form::select('ledger_fiscal_year',$fiscal_years->pluck('code','id'),$_GET['ledger_fiscal_year'] ?? $fiscal_years->where('status',1)->first()->id ?? null,['class'=>'form-control','placeholder'=>'ALL']) !!}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <label for="">Bank Name</label>
                            </div>
                            <div class="col-md-9">
                                {!! Form::select('bank_institution_id',$institutes,$_GET['bank_institution_id']?? null,['class'=>'form-control','placeholder'=>'ALL']) !!}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <label for="">Deposit Type</label>
                            </div>
                            <div class="col-md-9">
                                {!! Form::select('ledger_deposit_type',$investment_subtypes,$_GET['ledger_deposit_type']?? null,['class'=>'form-control','placeholder'=>'ALL']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Export</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $('#next_interest').hide();
        $('#next_status').change(function () {
            var x = $('#next_status').val();
            if (x == 2) {
                $('#next_interest').show();
            } else {
                $('#next_interest').hide();
            }
        });

        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });

        $.formUtils.addValidator({
            name: 'date_selector_validation',
            validatorFunction: function (value, $el, config, language, $form) {
                if (value != '' && value != 0) {
                    let start_date = $('#start_date_en').val();
                    return (start_date != '');
                }
                return true;
            },
            errorMessage: 'Start Date Must Be Selected if End Date is Selected',
            errorMessageKey: 'badEvenNumber'
        });

        $(document).ready(function () {
            $('#depositFilter').keydown(function (event) {
                // enter has keyCode = 13, change it if you want to use another button
                if (event.keyCode == 13) {
                    $(this).submit();
                    return false;
                }
            });
        });

        //select next status via ajax modal
        $('.next_status_change').on('click', function () {
            new_id = $(this).data('id');
            $('#myModal').modal('show');
        });

        //update next status via ajax
        $('#update_next_status').click(function () {
            let updated_next_interest_rate = $('#next_interest_rate').val();
            let updated_next_status = $('#next_status').val();
            $.ajax(({
                url: '{{route('deposit.next-status-ajax')}}',
                type: 'patch',
                data: {
                    '_token': '{{csrf_token()}}',
                    id: new_id,
                    next_status: updated_next_status,
                    next_interest_rate: updated_next_interest_rate
                },

                success: function (data) {
                    setInterval('location.reload()', 1500);
                    Swal.fire({
                        position: 'center',
                        type: 'success',
                        title: 'Your work has been saved',
                        showConfirmButton: false,
                        timer: 1500
                    })
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

        $('.excelimport').click(function () {
            openDialog();
        });

        function openDialog() {
            document.getElementById('deposit_excel').click();
        }

        $('#deposit_excel').change(function () {
            document.getElementById("import_form").submit();
        });


        $('#start_date_en,#end_date_en,#interest_start_date_en,#interest_end_date_en').flatpickr();

        $('#start_date_en').change(function () {
            let start_date_en = $('#start_date_en').val();
            if (start_date_en != '') {
                $('#start_date').val(AD2BS(start_date_en));
            } else {
                $('#start_date').val('');
            }

        });


        $('#end_date_en').change(function () {
            let end_date_en = $('#end_date_en').val();
            if (end_date_en != '') {
                $('#end_date').val(AD2BS(end_date_en));
            } else {
                $('#end_date').val('');
            }

        });


        $('.btndel').click(function (e) {
            e.preventDefault();
            var del_url = '{{ URL::to('deposit') }}/' + $(this).data('id');
            console.log(del_url);
            $('#firstform')[0].setAttribute('action', del_url);
            $('#deleteModal')
                .modal('show')
            ;
        });

        $('.btndelwithdraw').click(function (e) {
            e.preventDefault();
            var del_url = '{{ URL::to('deposit/withdraw/delete') }}/' + $(this).data('id');
            console.log(del_url);
            $('#firstform')[0].setAttribute('action', del_url);
            $('#deleteModal')
                .modal('show')
            ;
        });

        $('.btnwithdraw').click(function (e) {
            e.preventDefault();
            var del_url = '{{ URL::to('deposit/withdraw') }}/' + $(this).data('id');
            console.log(del_url);

            $('#secondform')[0].setAttribute('action', del_url);
            $('#withdrawModal')
                .modal('show')
            ;
        });


        $(document).ready(function () {
            var delay = (function () {
                var timer = 0;
                return function (callback, ms) {
                    clearTimeout(timer);
                    timer = setTimeout(callback, ms);
                };
            })();

            $("#estimated_days").keyup(function () {
                var days = $('#estimated_days').val();

                delay(function () {
                    // $('#depositFilter').submit();
                }, 3000);
            });
        });

        $('#start_date').nepaliDatePicker({
            npdMonth: true,
            npdYear: true,
            npdYearCount: 10,
            onChange: function (e) {
                $('#start_date_en').val(BS2AD($('#start_date').val()));
            }
        });
        $('#end_date').nepaliDatePicker({
            npdMonth: true,
            npdYear: true,
            npdYearCount: 10,
            onChange: function (e) {
                $('#end_date_en').val(BS2AD($('#end_date').val()));
            }
        });


        $('.downexcel').on("click", function () {
            $('#depositFilter').attr('action', '{{route('deposit.excel')}}');
            $('#depositFilter').submit();
            $('#depositFilter').attr('action', '{{route('deposit.index')}}');
        });
    </script>
    {{--<script src="{{asset('js/print.js')}}"></script>--}}
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/floatthead/2.1.2/jquery.floatThead.js"></script>--}}
    {{--<script>--}}
    {{--var $table = $('#floatable_table');--}}
    {{--var $fd_number = $table.find("tr>:nth-child(8)");--}}
    {{--var $actual_earning = $table.find("tr>:nth-child(13)");--}}
    {{--var $alert_days = $table.find("tr>:nth-child(14)");--}}
    {{--var $earmarked = $table.find("tr>:nth-child(15)");--}}
    {{--$table.floatThead({--}}
    {{--top: 50,--}}
    {{--});--}}

    {{--$fd_number.addClass("hide");--}}
    {{--$actual_earning.addClass("hide");--}}
    {{--$alert_days.addClass("hide");--}}
    {{--$earmarked.addClass("hide");--}}
    {{--$table.floatThead("reflow"); //make floatThead notice the missing column--}}

    {{--$('#hidden_values').change(function (e) {--}}
    {{--e.preventDefault();--}}
    {{--if ($(this).is(':checked')) {--}}
    {{--$('body').removeClass("sidebar-lg-show");--}}

    {{--$fd_number.removeClass("hide");--}}
    {{--$actual_earning.removeClass("hide");--}}
    {{--$alert_days.removeClass("hide");--}}
    {{--$earmarked.removeClass("hide");--}}

    {{--$table.floatThead("reflow"); //make floatThead notice the missing column--}}
    {{--}--}}
    {{--})--}}
    {{--</script>--}}



@endsection
