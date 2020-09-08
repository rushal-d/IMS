@extends('layouts.master')
@section('title','Investment Request Edit')

@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form method="post" class="" action="{{route('investment-request.update',$investmentRequest->id)}}">
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-xl-6">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-3">
                                        <i class="fa fa-align-justify"></i>
                                        Investment Request - Edit
                                    </div>
                                    <div class="text-right col-9">
                                        {{--adding bank branch through ajax through modal--}}
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                                data-target="#myModal">
                                            Add Bank Branch
                                        </button>

                                        {{--adding organization branch through ajax through modal--}}
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                                data-target="#add_organization_branch">
                                            Add Org. Branch
                                        </button>

                                        {{--adding staff through ajax through modal--}}
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                                data-target="#add_staff">
                                            Add Staff
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="form-group row">
                                            <label class="col-md-4" for="inlineFormInputGroupUsername">Date (AD)</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" id="date_en"
                                                       value="{{$investmentRequest->request_date_en}}"
                                                       name="request_date_en" placeholder="Date AD"
                                                       data-validation="required">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-4" for="inlineFormInputGroupUsername">Date (BS)</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control nep-date" id="date"
                                                       value="{{$investmentRequest->request_date}}"
                                                       name="request_date" placeholder="Date BS"
                                                       data-validation="required"
                                                       data-validation-format="yyyy-mm-dd" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-4" for="inlineFormInputGroupUsername">Bank
                                            </label>
                                            <div class="col-md-8">
                                                {!! Form::select('institution_id',$investment_institutions,$investmentRequest->institution_id,['class'=>'form-control','placeholder'=>'Select Bank','id'=>'institution_id']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-4" for="inlineFormInputGroupUsername">Bank
                                                Branch</label>
                                            <div class="col-md-8">
                                                {!! Form::select('branch_id',$bank_branches,$investmentRequest->branch_id,['class'=>'form-control bank_branch','placeholder'=>'Select Bank Branch','id'=>'branch_id']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-4" for="inlineFormInputGroupUsername">Amount</label>
                                            <div class="col-md-8">
                                                {!! Form::number('deposit_amount',$investmentRequest->deposit_amount,['class'=>'form-control','placeholder'=>'Enter Deposit Amount','id'=>'deposit_amount','min'=>"0", 'step'=>"0.01"]) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-4" for="inlineFormInputGroupUsername">Interest
                                                Rate</label>
                                            <div class="col-md-8">
                                                <input type="number" step="0.01"
                                                       data-validation-allowing="range[1;100], float"
                                                       class="form-control" name="interest_rate"
                                                       id="interest_rate" value="{{$investmentRequest->interest_rate}}"
                                                       placeholder="Interest Rate/Year"></div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-4" for="inlineFormInputGroupUsername">Days</label>
                                            <div class="col-md-8">
                                                {!! Form::number('days',$investmentRequest->days,['class'=>'form-control','placeholder'=>'Enter Days','id'=>'days','min'=>"0"]) !!}
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-4" for="inlineFormInputGroupUsername">Interest Payment
                                                Method</label>
                                            <div class="col-md-8">
                                                {!! Form::select('interest_payment_method',$investment_payment_methods,$investmentRequest->interest_payment_method,['class'=>'form-control','placeholder'=>'Select Interest Payment Method']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-xl-6">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-3">
                                        <i class="fa fa-align-justify"></i>
                                        Investment Request- Edit
                                    </div>

                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-12">


                                        <div class="form-group row">
                                            <label class="col-md-4" for="inlineFormInputGroupUsername">Organization
                                                Branch</label>
                                            <div class="col-md-8">
                                                {!! Form::select('organization_branch_id',$organization_branches,$investmentRequest->organization_branch_id,['class'=>'form-control','placeholder'=>'Select Organization Branch','id'=>'organization_branch']) !!}
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-4" for="inlineFormInputGroupUsername">Staff
                                            </label>
                                            <div class="col-md-8">
                                                {{Form::select('staff_id',$staffs,$investmentRequest->staff_id,array('class'=>'form-control','id'=>'staff_id','placeholder'=>'Select Staff'))}}                                            </div>
                                        </div>

                                        <div class="form-group  row">
                                            <label class="col-md-4" for="inlineFormInputGroupUsername">Uploaded
                                                Documents</label>
                                            <div class="col-md-8">
                                                <?php $fileManagerURL = asset('') . 'filemanager/dialog.php?field_id=image&relative_url=1'; ?>
                                                <a class="btn btn-sm text-primary open-filemanager" data-fancybox
                                                   data-type="iframe" data-src="{{ $fileManagerURL  }}"
                                                   href="javascript:;">Set Document</a>

                                            </div>

                                            {{ Form::hidden('image', '', array('id' => 'image', 'class' => 'form-control')) }}
                                         <div class="col-12">
                                             <div class="row">
                                                 @foreach($investmentRequest->documents as $uploaded_document)
                                                     <?php
                                                     $root = URL::to('/');
                                                     $img = $uploaded_document->name;
                                                     $ext = substr(strrchr($img, '.'), 1);
                                                     $thumbImgURL = $root . '/thumbs/' . $img;
                                                     $fullImgURL = $root . '/uploads/' . $img;
                                                     if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png') {
                                                         $selectedImg = '<div class="selected-img-box col-4" data-toggle="tooltip" data-placement="top" title="' . $img . '"><div class="selected-img" ><a data-fancybox data-type="iframe" data-src="' . $fileManagerURL . '" href="javascript:;">
	                                                      <img src="' . $thumbImgURL . '" class="img-fluid"></a></div>';
                                                     } elseif ($ext == 'doc' || $ext == 'docx') {
                                                         $selectedImg = '<div class="selected-img-box col-4" data-toggle="tooltip" data-placement="top" title="' . $img . '"><div class="selected-img"><a data-fancybox data-type="iframe" data-src="' . $fileManagerURL . '" href="javascript:;">
	                                                      <i class="fas fa-file-word fa-4x"></i></a></div>';
                                                     } else {
                                                         $selectedImg = '<div class="selected-img-box col-4" data-toggle="tooltip" data-placement="top" title="' . $img . '"><div class="selected-img"><a data-fancybox data-type="iframe" data-src="' . $fileManagerURL . '" href="javascript:;">
	                                                      <i class="fas fa-file-pdf fa-4x"></i></a></div>';
                                                     }
                                                     $docs = '<input type="hidden" name="docs[]" value="' . $img . '">';

                                                     $removeImg = '<a class="btn btn-sm btn-outline-danger remove-image"><i class="fas fa-minus"></i> Remove</a></div>';
                                                     echo $selectedImg . $docs . $removeImg;
                                                     ?>
                                                 @endforeach
                                             </div>
                                         </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-4" for="inlineFormInputGroupUsername">Status
                                            </label>
                                            <div class="col-md-8">
                                                @if(!empty($investmentRequest->deposit))
                                                    {{Form::select('status',$investment_request_status,$investmentRequest->status,array('class'=>'form-control','id'=>'staff_id','placeholder'=>'Select Status'))}}
                                                @else
                                                    {{$investment_request_status[$investmentRequest->status] ?? ''}}
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-4" for="notes">Note</label>
                                            <div class="col-md-8">
                                                <textarea name="remarks" class="form-control" id="" cols="30"
                                                          rows="10">
                                                    {{$investmentRequest->remarks}}
                                                </textarea>
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>

    <!-- The Modal -->
    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Add Bank Branch</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <label for="">New Bank Branch</label>
                    <input type="text" class="form-control" id="new_bank_branch" placeholder="New Bank Branch">
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="new_bank_branch_submit" data-dismiss="modal">Add
                    </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>


    <div class="modal fade" id="add_organization_branch">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Add Organization Branch</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <label for="">New Organization Branch</label>
                    <input type="text" class="form-control" id="new_organization_branch"
                           placeholder="New Organization Branch">
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="new_organization_branch_submit"
                            data-dismiss="modal">Add
                    </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>


    <div class="modal fade" id="add_staff">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Add Staff</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <label for="">Staff Name</label>
                    <input type="text" name="staff" id="new_staff_name" class="form-control"
                           placeholder="Enter Staff Name">
                    <label for="">Organization Branch</label>
                    {{Form::select('staff_branch',$organization_branches,null,array('class'=>'form-control','id'=>'staff_organization_branch','placeholder'=>'Select Organization Branch'))}}
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="new_staff_submit"
                            data-dismiss="modal">Add
                    </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>


@endsection
@section('scripts')
    <script>

        //responsive filemanager on select callback
        function responsive_filemanager_callback(field_id) {
            var url = "{{ asset('') }}thumbs/" + jQuery('#' + field_id).val();
            var files = jQuery('#' + field_id).val();
            if (files.indexOf('[') !== -1) {
                var mFiles = JSON.parse(files);
                mFiles.forEach(function (file) {
                    var ext = file.split(".");
                    ext = (ext[(ext.length) - 1]);
                    var filePath = "{{ asset('') }}thumbs/" + file;
                    var docs = '<input type="hidden" name="docs[]" value="' + file + '"/>';
                    var field = '#' + field_id;
                    var fileManagerURL = jQuery(field).prev().data('src');
                    //jQuery(field).parent().find('.selected-img-box').remove();
                    var selectedImg = '<div class="selected-img-box col-4" data-toggle="tooltip" data-placement="top" title="' + file + '"><div class="selected-img">';

                    if (ext == 'jpg' || ext == 'jpeg' || ext == 'png') {
                        selectedImg += '<a data-fancybox data-type="iframe" data-src="' + fileManagerURL + '" href="javascript:;">' +
                            '<img src="' + filePath + '" class="img-fluid>' +
                            '</a>';
                    } else if (ext == 'doc' || ext == 'docx') {
                        selectedImg += '<a data-fancybox data-type="iframe" data-src="' + fileManagerURL + '" href="javascript:;">' +
                            '<i class="fas fa-file-word fa-4x"></i>' +
                            '</a>';
                    } else {
                        selectedImg += '<a data-fancybox data-type="iframe" data-src="' + fileManagerURL + '" href="javascript:;">' +
                            '<i class="fas fa-file-pdf fa-4x"></i>' +
                            '</a>';
                    }
                    selectedImg += '</div>';


                    var removeImg = '<a class="btn btn-sm btn-outline-danger remove-image"><i class="fas fa-minus"></i> Remove</a></div>';
                    jQuery(field).parent().after(selectedImg + docs + removeImg);
                });

            } else {
                var filePath = "{{ asset('') }}thumbs/" + files;
                var docs = '<input type="hidden" name="docs[]" value="' + files + '"/>';
                var ext = files.split(".");
                ext = (ext[(ext.length) - 1]);
                var field = '#' + field_id;
                var fileManagerURL = jQuery(field).prev().data('src');
                // jQuery(field).parent().find('.selected-img-box').remove();
                var selectedImg = '<div class="selected-img-box col-4"  data-toggle="tooltip" data-placement="top" title="' + files + '"><div class="selected-img">';

                if (ext == 'jpg' || ext == 'jpeg' || ext == 'png') {
                    selectedImg += '<a data-fancybox data-type="iframe" data-src="' + fileManagerURL + '" href="javascript:;">' +
                        '<img src="' + filePath + '" class="img-fluid">' +
                        '</a>';
                } else if (ext == 'doc' || ext == 'docx') {
                    selectedImg += '<a data-fancybox data-type="iframe" data-src="' + fileManagerURL + '" href="javascript:;">' +
                        '<i class="fas fa-file-word fa-4x"></i>' +
                        '</a>';
                } else {
                    selectedImg += '<a data-fancybox data-type="iframe" data-src="' + fileManagerURL + '" href="javascript:;">' +
                        '<i class="fas fa-file-pdf fa-4x"></i>' +
                        '</a>';
                }
                selectedImg += '</div>';
                var removeImg = '<a class="btn btn-sm btn-outline-danger remove-image"><i class="fas fa-minus"></i> Remove</a></div>';
                jQuery(field).next().children('.row').append(selectedImg + docs + removeImg);
            }

            $('.selected-img-box').tooltip();
        }

        //remove image
        $(document).on('click', '.remove-image', function () {
            var removeImage = $(this);
            vex.dialog.confirm({
                className: 'vex-theme-default', // Overwrites defaultOptions
                message: 'Are you absolutely sure you want to remove the image?',
                callback: function (value) {
                    if (value) {
                        $(removeImage).parent().prev().val(''); //clear the value of image field
                        $(removeImage).parent().remove(); //remove image box
                    }
                }
            });
        });

        $('#date_en').flatpickr();

        $('#date_en').change(function () {
            $('#date').val(AD2BS($('#date_en').val()));
        });

        $('#date').nepaliDatePicker({
            npdMonth: true,
            npdYear: true,
            npdYearCount: 10,
            onChange: function (e) {
                $("#date").blur();
                $('#date_en').val(BS2AD($('#date').val()));
            }
        });
        /*add bank branch through ajax and show in options*/
        $('#new_bank_branch_submit').click(function () {
            let new_bank_branch = $('#new_bank_branch').val();
            $.ajax(({
                url: '{{route('bankbranch-ajaxEntry')}}',
                type: 'post',
                data: {
                    '_token': '{{csrf_token()}}',
                    branch_name: new_bank_branch
                },
                success: function (data) {
                    /*deposit branch*/
                    var $select = $('#branch_id').selectize({plugins: ['remove_button']});
                    var selectize = $select[0].selectize;
                    selectize.addOption({value: data, text: new_bank_branch});
                    // selectize.addItem(data);

                    /*Interest Credited Branch*/
                    var $select = $('#bank_branch_id').selectize();
                    var selectize = $select[0].selectize;
                    selectize.addOption({value: data, text: new_bank_branch});
                    // selectize.addItem(data);


                }
            }))
        });

        /*add organization branch through ajax and show in options*/
        $('#new_organization_branch_submit').click(function () {
            let organization_branch = $('#new_organization_branch').val();
            $.ajax(({
                url: '{{route('organization_branch-ajaxEntry')}}',
                type: 'post',
                data: {
                    '_token': '{{csrf_token()}}',
                    branch_name: organization_branch
                },
                success: function (data) {
                    var $select = $('#organization_branch').selectize();
                    var selectize = $select[0].selectize;
                    selectize.addOption({value: data, text: organization_branch});
                    selectize.addItem(data);

                    /*Add Staff Select Organization Brancj*/
                    var $select = $('#staff_organization_branch').selectize();
                    var selectize = $select[0].selectize;
                    selectize.addOption({value: data, text: organization_branch});
                    // selectize.addItem(data);
                }
            }))
        });

        /*add staff through ajax and show in options*/
        $('#new_staff_submit').click(function () {
            let staff_name = $('#new_staff_name').val();
            let staff_organization_branch = $('#staff_organization_branch').val();
            $.ajax(({
                url: '{{route('staff-ajaxEntry')}}',
                type: 'post',
                data: {
                    '_token': '{{csrf_token()}}',
                    name: staff_name,
                    organization_branch_id: staff_organization_branch
                },
                success: function (data) {
                    var $select = $('#staff_id').selectize();
                    var selectize = $select[0].selectize;
                    selectize.addOption({value: data, text: staff_name});
                    selectize.addItem(data);
                }
            }))
        });
    </script>
@endsection
