@extends('layouts.master')
@section('title','Deposit-Show')
<style>
    @media (min-width: 576px) {
        .max-20 {
            max-width: 20% !important;
        }
    }
</style>
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-xl-8">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-4">
                                    <i class="fa fa-align-justify"></i>
                                    Deposit - Show
                                </div>

                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3 my-1">
                                    <p><b>Fiscal Year </b>: {{$deposit->fiscalyear->code ?? ''}}</p>
                                </div>

                                <div class="col-sm-6 my-1">
                                    <p><b>Bank Name </b>: {{$deposit->institute->institution_name ?? ''}}</p>
                                </div>
                                <div class="col-sm-3 my-1">
                                    <p><b>Bank Branch </b>: {{$deposit->branch->branch_name ?? ''}}</p>
                                </div>


                                <div class="col-sm-5 my-1">
                                    <p><b>Transaction
                                            Date </b>: {{$deposit->trans_date_en}}/{{$deposit->trans_date}}</p>
                                </div>


                                <div class="col-sm-2 my-1">
                                    <p><b>Days </b>: {{$deposit->days}}</p>
                                </div>


                                <div class="col-sm-5 my-1">
                                    <p><b>Mature
                                            Date </b>: {{$deposit->mature_date_en}}/{{$deposit->mature_date}}</p>
                                </div>


                                <div class="col-sm-2 my-1">
                                    <p><b>Interest
                                            Rate </b>: {{$deposit->interest_rate}}</p>
                                </div>
                                <div class="col-sm-4 my-1">
                                    <p><b>Deposit
                                            Amount </b>: {{$deposit->deposit_amount}}</p>
                                </div>
                                <div class="col-sm-3 my-1">
                                    <p><b>Int. Pay.
                                            Method</b>: {{config('constants.investment_payment_methods')[$deposit->interest_payment_method] ?? ''}}
                                    </p>
                                </div>

                                <div class="col-sm-3 my-1">
                                    <p><b>Estimated Earning </b>: {{$deposit->estimated_earning}}</p>
                                </div>

                                <div class="col-sm-3 my-1">
                                    <p><b>FD Number </b>: {{$deposit->document_no}}</p>
                                </div>

                                <div class="col-sm-3 my-1">
                                    <p><b>Organization Branch </b>: {{$deposit->organization_branch->branch_name ?? ''}}
                                    </p>
                                </div>

                                <div class="col-sm-3 my-1">
                                    <p><b>Staff </b>: {{$deposit->staff->name ?? ''}}</p>
                                </div>

                                <div class="col-sm-3 my-1">
                                    <p><b>Reference Number </b>: {{$deposit->reference_number ?? ''}}</p>
                                </div>

                                <div class="col-sm-3 my-1">
                                    <p><b>Cheque Bank </b>: {{$deposit->cheque_bank->institution_name ?? ''}}</p>
                                </div>

                                <div class="col-sm-3 my-1">
                                    <p><b>Cheque Number </b>: {{$deposit->cheque_no ?? ''}}</p>
                                </div>

                                <div class="col-sm-3 my-1">
                                    <p><b>Cheque Date </b>: {{$deposit->cheque_date ?? ''}}</p>
                                </div>

                                <div class="col-sm-3 my-1">
                                    <p><b>Debit Bank </b>: {{$deposit->debit_bank->institution_name ?? ''}}</p>
                                </div>

                                <div class="col-sm-3 my-1">
                                    <p><b>Debit Bank Branch </b>: {{$deposit->debit_branch->branch_name ?? ''}}</p>
                                </div>

                                <div class="col-sm-3 my-1">
                                    <p><b>Debit Bank Account Number</b>: {{$deposit->debit_account_number ?? ''}}</p>
                                </div>

                            </div>

                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3 my-1">
                                    <p><b>Receipt Number</b>: {{$deposit->receipt_no ?? ''}}</p>
                                </div>

                                <div class="col-sm-3 my-1">
                                    <p><b>Voucher Number</b>: {{$deposit->voucher_number ?? ''}}</p>
                                </div>

                                <div class="col-sm-4 my-1">
                                    <p><b>Credit
                                            Date </b>: {{$deposit->credit_date ?? ''}}
                                        /{{$deposit->credit_date_np ?? ''}}</p>
                                </div>

                                <div class="col-sm-3 my-1">
                                    <p><b>Interest Credited Bank</b>: {{$deposit->bank->institution_name ?? ''}}</p>
                                </div>

                                <div class="col-sm-3 my-1">
                                    <p><b>Interest Credited Bank
                                            Branch</b>: {{$deposit->bank_branch->branch_name or 'N/A'}}</p>
                                </div>

                                <div class="col-sm-3 my-1">
                                    <p><b>Account Head</b>: {{$deposit->account_head or 'N/A'}}</p>
                                </div>

                                <div class="col-sm-3 my-1">
                                    <p><b>Account Number</b>: {{$deposit->accountnumber or 'N/A'}}</p>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            Deposit History
                        </div>

                        <div class="card-body">
                            <table class="table table-bordered">

                                <thead>
                                <th>SN</th>
                                <th>Trans Date (AD)</th>
                                <th>Trans Date (BS)</th>
                                <th>Mature Date (AD)</th>
                                <th>Mature Date (BS)</th>
                                <th>Amount</th>
                                <th>FD Number</th>
                                <th>Ref Number</th>
                                <th>Detail</th>
                                </thead>
                                <tbody>
                                @foreach($deposit_collection as $depositHistory)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$depositHistory->trans_date_en}}</td>
                                        <td>{{$depositHistory->trans_date}}</td>
                                        <td>{{$depositHistory->mature_date_en}}</td>
                                        <td>{{$depositHistory->mature_date}}</td>
                                        <td>{{$depositHistory->deposit_amount}}</td>
                                        <td>{{$depositHistory->document_no}}</td>
                                        <td>{{$depositHistory->reference_number}}</td>
                                        <td>
                                            @if($depositHistory->id!=$deposit->id)
                                                <a href="{{ route('deposit.show',$depositHistory->id) }}"
                                                   class="btn btn-primary">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify mr-1"></i>Information
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="row">

                                        <div class="col-sm-12 my-1 row">
                                            <label class="" for="inlineFormInputGroupUsername">Uploaded
                                                Documents</label>
                                            <div class="input-group">
                                                <?php $fileManagerURL = asset('') . 'filemanager/dialog.php?field_id=image&relative_url=1'; ?>
                                            </div>
                                            {{ Form::hidden('image', '', array('id' => 'image', 'class' => 'form-control')) }}

                                            @foreach($uploaded_documents as $uploaded_document)
                                                <?php
                                                //                                                $root = URL::to('/');
                                                $img = $uploaded_document->name;
                                                $ext = substr(strrchr($img, '.'), 1);
                                                $thumbImgURL = asset('/thumbs/' . $img);
                                                $fullImgURL = asset('/uploads/' . $img);
                                                if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png') {
                                                    $selectedImg = '<div class="selected-img-box col-4" data-toggle="tooltip" data-placement="top" title="' . $img . '"><div class="selected-img" ><a data-fancybox="gallery"  href="' . $fullImgURL . '" >
	                                                      <img src="' . $thumbImgURL . '" class="img-fluid"></a></div>';
                                                } elseif ($ext == 'doc' || $ext == 'docx') {
                                                    $selectedImg = '<div class="selected-img-box col-4" data-toggle="tooltip" data-placement="top" title="' . $img . '"><div class="selected-img"><a target="_blank"  href="' . $fullImgURL . '" >
	                                                      <i class="fas fa-file-word fa-4x"></i></a></div>';
                                                } else {
                                                    $selectedImg = '<div class="selected-img-box col-4" data-toggle="tooltip" data-placement="top" title="' . $img . '"><div class="selected-img"><a target="_blank"  href="' . $fullImgURL . '" >
	                                                      <i class="fas fa-file-pdf fa-4x"></i></a></div>';
                                                }
                                                $docs = '<input type="hidden" name="docs[]" value="' . $img . '">';


                                                $image_name = '<p>' . $uploaded_document->name . '</p></div>';
                                                echo $selectedImg . $docs . $image_name;
                                                ?>
                                            @endforeach
                                        </div>

                                        <div class="col-sm-12 my-1">
                                            <p><b>FB Receipt
                                                    Location</b>: {{$fd_locations[$deposit->fd_document_current_location] ?? ''}}
                                            </p>
                                        </div>

                                        <div class="col-sm-6 my-1">
                                            <p><b>Earmarked ?</b>: {{($deposit->earmarked==1)?'Yes':'No'}}</p>
                                        </div>

                                        <div class="col-sm-6 my-1">
                                            <p><b>Alert
                                                    Days</b>: {{$deposit->alert_days}}</p>
                                        </div>


                                        <div class="col-sm-12 my-1">
                                            <label class="" for="alert_days">Narration</label>
                                            <div class="input-group">
                                                {{$deposit->narration}}
                                            </div>
                                        </div>

                                        <div class="col-sm-12 my-1">
                                            <label class="" for="alert_days">Remarks</label>
                                            <div class="input-group">
                                                {{$deposit->notes}}
                                            </div>
                                        </div>
                                        <div class="col-sm-6 my-1">
                                            <label class="" for="alert_days">Created By</label>
                                            <div class="input-group">
                                                {{$deposit->created_by->name ?? ''}}
                                            </div>
                                        </div>
                                        <div class="col-sm-6 my-1">
                                            <label class="" for="alert_days">Created At</label>
                                            <div class="input-group">
                                                {{$deposit->created_at?? ''}}
                                            </div>
                                        </div>
                                        <div class="col-sm-6 my-1">
                                            <label class="" for="alert_days">Updated By</label>
                                            <div class="input-group">
                                                {{$deposit->updated_by->name ?? ''}}
                                            </div>
                                        </div>
                                        <div class="col-sm-6 my-1">
                                            <label class="" for="alert_days">Updated At</label>
                                            <div class="input-group">
                                                {{$deposit->updated_at?? ''}}
                                            </div>
                                        </div>

                                        @if(empty($deposit->approved_by))
                                            <div class="col-sm-12 my-1">
                                                <div class="text-center">
                                                    <button class="btn btn-outline-success btn-sm approve_deposit">
                                                        Approve
                                                        Record
                                                    </button>
                                                </div>
                                            </div>
                                        @else
                                            <div class="col-sm-6 my-1">
                                                <label>Approved By</label>
                                                <div class="input-group">
                                                    {{$deposit->approvalUser->name ?? ''}}
                                                </div>
                                            </div>
                                            <div class="col-sm-6 my-1">
                                                <label>Approved Date At</label>
                                                <div class="input-group">
                                                    {{$deposit->approved_date ?? ''}}
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i>
                            Actual Interest Earned History
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-12">
                                    <a href="{{route('interestearnedentry.create',['id'=>$deposit->id])}}">
                                        <button class="btn btn-info btn-sm form-group">Add New</button>
                                    </a>
                                    <table class="table table-bordered">
                                        <thead>
                                        <th>SN</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Actions</th>
                                        </thead>
                                        <tbody>
                                        @foreach($interestearnings as $interestearning)
                                            <tr>
                                                <td>{{$i++}}</td>
                                                <td>{{$interestearning->date_en}}</td>
                                                <td>{{$interestearning->amount}}</td>
                                                <td>
                                                    <a class="btn btn-info btn-sm"
                                                       href="{{ route('interestearnedentry.show',$interestearning->id) }}"><i
                                                                class="fa fa-eye"></i></a>
                                                    <a href="{{route('interestearnedentry.edit',$interestearning->id)}}"
                                                       class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a>
                                                    <a href="javascript:void(0)" data-id="{{ $interestearning->id }}"
                                                       class="btn btn-danger btn-sm btndel">
                                                        <i class="fa fa-times"></i>
                                                    </a>

                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="2">Total</td>
                                            <td colspan="2">Rs. {{$interestearnings->sum('amount')}}</td>
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
    <div class="modal fade" id="nextStatusModal">
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
@endsection
@section('scripts')
    <script>
        $('.arko_bank').on('click', function () {
            $("#myModal").modal('show');
        })

        $('.btndel').click(function (e) {
            e.preventDefault();
            var del_url = '{{ URL::to('interestearnedentry') }}/' + $(this).data('id');
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

        //select next status via ajax modal
        $('.next_status_change').on('click', function () {
            new_id = $(this).data('id');
            $('#nextStatusModal').modal('show');
        });

        //update next status via ajax
        $('#update_next_status').click(function () {
            let updated_next_status = $('#next_status').val();
            $.ajax(({
                url: '{{route('deposit.next-status-ajax')}}',
                type: 'patch',
                data: {
                    '_token': '{{csrf_token()}}',
                    id: new_id,
                    next_status: updated_next_status
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

        $('.approve_deposit').click(function () {
            $this = $(this);
            $.ajax({
                url: '{{route('deposit.approve',$deposit->id)}}',
                type: 'POST',
                data: {
                    '_token': '{{csrf_token()}}'
                }, success: function (response, status) {
                    $this.text(response);
                }, error: function (response) {
                    console.log(response.responseText);
                    $this.text(response.responseText);
                }
            })
        });


    </script>
@endsection