@extends('layouts.master')
@section('title','Deposit-Renew')
@section('styles')
    <style>
        @media (min-width: 576px) {
            .max-20 {
                max-width: 20% !important;
            }
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form method="post" class="" action="{{route('deposit.store')}}">
                @csrf
                <div class="row">

                    <div class="col-sm-12 col-md-12 col-xl-8">
                        <div class="card">
                            <div class="card-header">
                                <i class="fa fa-align-justify"></i>
                                Deposit - ReNew
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <input type="hidden" name="parent_id" value="{{$old_deposit->id}}">
                                    <input type="hidden" name="old_deposit" value="1">
                                    <div class="col-sm-6 my-1">
                                        <label class="" for="inlineFormInputGroupUsername"><sup
                                                    class="required-field"></sup>Bank Name</label>
                                        <div class="input-group">
                                            <select name="institution_id" id="institution_id"
                                                    class="form-control">
                                                <option value="">All</option>
                                                @foreach($institutes as $institute)
                                                    <option value="{{$institute->id}}"
                                                            @if($old_deposit->institution_id==$institute->id) selected @endif>{{$institute->institution_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-3 my-1">
                                        <label class="" for="inlineFormInputGroupUsername"><sup
                                                    class="required-field"></sup>Bank Branch</label>
                                        <div class="input-group">
                                            <select name="branch_id" id="branch_id" class="form-control"
                                            >
                                                <option value="">All</option>
                                                @foreach($bankbranches as $bankbranch)
                                                    <option value="{{$bankbranch->id}}"
                                                            @if($old_deposit->branch_id==$bankbranch->id) selected @endif>{{$bankbranch->branch_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 my-1">
                                        <label class="" for="inlineFormInputGroupUsername"><sup
                                                    class="required-field">*</sup>Organization Branch</label>
                                        <div class="input-group">
                                            <select name="organization_branch_id" id="organization_branch"
                                                    class="form-control"
                                                    data-validation="required"
                                                    data-validation-error-msg="Select Organization Branch">
                                                <option value="">Select Org Branch</option>
                                                @foreach($organization_branches as $organization_branch)
                                                    <option value="{{$organization_branch->id}}"
                                                            @if($organization_branch->id == $old_deposit->organization_branch_id) selected @endif
                                                    >{{$organization_branch->branch_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-3 my-1 max-20">
                                        <label class="" for="trans_date_en"><sup
                                                    class="required-field"></sup>Transaction
                                            Date (AD)</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control nep-date"
                                                   id="trans_date_en" name="trans_date_en"
                                                   placeholder="Transaction Date (AD)"
                                                   data-validation-format="yyyy-mm-dd" readonly
                                                   value="{{$new_transaction_start_en}}">

                                        </div>
                                    </div>
                                    <div class="col-sm-3 my-1 max-20">
                                        <label class="" for="trans_date"><sup
                                                    class="required-field"></sup>Transaction
                                            Date (BS)</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control nep-date"
                                                   id="trans_date"
                                                   name="trans_date"
                                                   placeholder="Transaction Date (BS)"
                                                   data-validation-format="yyyy-mm-dd" readonly
                                                   value="">
                                        </div>
                                    </div>

                                    <div class="col-sm-3 my-1 max-20">
                                        <label class="" for="days"><sup
                                                    class="required-field"></sup>Days</label>
                                        <div class="input-group">
                                            <input type="number" min="0" class="form-control"
                                                   name="days"
                                                   id="days" placeholder="Days"
                                                   value="{{$old_deposit->days}}">
                                        </div>
                                    </div>

                                    <div class="col-sm-3 my-1 max-20">
                                        <label class="" for="mature_date_en"><sup
                                                    class="required-field"></sup>Mature Date
                                            (AD)</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="mature_date_en"
                                                   name="mature_date_en" placeholder="Mature Date (AD)"
                                                   value="" readonly>
                                        </div>

                                    </div>
                                    <div class="col-sm-3 my-1 max-20">
                                        <label class="" for="mature_date"><sup
                                                    class="required-field"></sup>Mature Date
                                            (BS)</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control nep-date"
                                                   id="mature_date" name="mature_date"
                                                   placeholder="Mature Date (BS)"
                                                   value="" readonly>

                                        </div>
                                    </div>

                                    <div class="col-sm-3 my-1">
                                        <label class="" for="interest_rate"><sup
                                                    class="required-field"></sup>Interest rate/year
                                        </label>
                                        <div class="input-group">
                                            <input type="number" step="0.01"
                                                   data-validation-allowing="range[1;100], float"
                                                   class="form-control"
                                                   value="{{$old_deposit->interest_rate}}"
                                                   name="interest_rate" id="interest_rate"
                                            >
                                        </div>
                                    </div>

                                    <div class="col-sm-3 my-1">
                                        <label class="" for="deposit_amount"><sup
                                                    class="required-field"></sup>Deposit Amount</label>
                                        <div class="input-group">
                                            <input type="number" min="0" name="deposit_amount"
                                                   class="form-control"
                                                   value="{{$old_deposit->deposit_amount}}"
                                                   id="deposit_amount">
                                        </div>
                                    </div>

                                    <div class="col-sm-3 my-1">
                                        <label class="" for="estimated_earning"><sup
                                                    class="required-field">*</sup>Interest Payment Method</label>
                                        <div class="input-group">
                                            {!! Form::select('interest_payment_method', $interest_payment_methods, $old_deposit->interest_payment_method,['class'=>'form-control','placeholder'=>'Interest Payment Method']) !!}
                                        </div>
                                    </div>

                                    <div class="col-sm-3 my-1">
                                        <label class="" for="estimated_earning"><sup
                                                    class="required-field"></sup>Estimated
                                            Earning</label>
                                        <div class="input-group">
                                            <input type="number" min="0" step="0.01"
                                                   class="form-control"
                                                   name="estimated_earning" id="estimated_earning"
                                            >
                                        </div>
                                    </div>
                                    <div class="col-sm-3 my-1">
                                        <label class="" for="document_no"><sup
                                                    class="required-field"></sup>FD Number</label>
                                        <div class="input-group">
                                            <input type="text" min="0" class="form-control"
                                                   id="document_no"
                                                   name="document_no"
                                                   placeholder="document no."
                                                   value="{{$old_deposit->document_no}}">
                                        </div>
                                    </div>

                                    <div class="col-sm-3 my-1">
                                        <label class="" for="inlineFormInputGroupUsername"><sup
                                                    class="required-field"></sup>Organization
                                            Branch</label>
                                        <div class="input-group">
                                            <select name="organization_branch_id"
                                                    id="organizatioan_branch_id" class="form-control"
                                            >
                                                <option value="">

                                                </option>
                                                @foreach($organization_branches as $organization_branch)
                                                    <option value="{{$organization_branch->id}}"
                                                            @if($organization_branch->id == $old_deposit->organization_branch_id) selected @endif
                                                    >{{$organization_branch->branch_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-sm-3 my-1">
                                        <label class="" for="staff_id">Staff</label>
                                        <div class="input-group">
                                            {{Form::select('staff_id',$staffs,$old_deposit->staff_id,array('class'=>'form-control','id'=>'staff_id','placeholder'=>'Select Staff'))}}
                                        </div>
                                    </div>


                                    <div class="col-sm-3 my-1">
                                        <label class="" for="totalamount">Reference Number</label>
                                        <div class="input-group">
                                            <input type="text" min="0" class="form-control"
                                                   name="reference_number" id="reference_number"
                                                   value="{{$old_deposit->reference_number}}">
                                        </div>
                                    </div>

                                    <div class="col-sm-3 my-1">
                                        <label class="" for="inlineFormInputGroupUsername">Cheque Number</label>
                                        <div class="input-group">
                                            <input type="text" name="cheque_no" class="form-control"
                                                   id="cheque_no" value="{{$old_deposit->cheque_no ?? ''}}">
                                        </div>
                                    </div>

                                    <div class="col-sm-3 my-1">
                                        <label class="" for="cheque_date">Cheque Date</label>
                                        <div class="input-group">
                                            <input type="date" class="form-control"
                                                   name="cheque_date" id="cheque_date"
                                                   value="{{$old_deposit->cheque_date ?? ''}}">
                                        </div>
                                    </div>


                                </div>


                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-3 my-1">
                                        <label class="" for="receipt_no">Receipt Number</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control"
                                                   value="{{$old_deposit->receipt_no}}"
                                                   name="receipt_no" id="receipt_no">
                                        </div>
                                    </div>

                                    <div class="col-sm-3 my-1">
                                        <label class="" for="totalamount">Voucher Number</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control"
                                                   name="voucher_number" id="voucher_number"
                                                   value="{{$old_deposit->voucher_number}}">
                                        </div>
                                    </div>

                                    <div class="col-sm-3 my-1">
                                        <label class="" for="credit_date"><sup
                                                    class="required-field"></sup>Credit
                                            Date (AD)</label>
                                        <div class="input-group">
                                            <input type="date" class="form-control" id="credit_date"
                                                   name="credit_date" value="{{$old_deposit->credit_date ?? ''}}">
                                        </div>
                                    </div>

                                    <div class="col-sm-3 my-1">
                                        <label class="" for="credit_date_np"><sup
                                                    class="required-field"></sup>Credit
                                            Date (BS)</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control nep-date"
                                                   id="credit_date_np"
                                                   name="credit_date_np"
                                                   value="{{$old_deposit->credit_date_np ?? ''}}"
                                                   data-validation-format="yyyy-mm-dd" readonly>
                                        </div>
                                    </div>

                                    <div class="col-sm-3 my-1">
                                        <label class="" for="inlineFormInputGroupUsername">Interest
                                            Credited
                                            Bank</label>
                                        <div class="input-group">
                                            <select name="bank_id" id="institution_id"
                                                    class="form-control">
                                                <option value=""></option>
                                                @foreach($institutes as $institute)
                                                    <option value="{{$institute->id}}"
                                                            @if($old_deposit->bank_id==$institute->id) selected @endif>{{$institute->institution_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 my-1">
                                        <label class="" for="inlineFormInputGroupUsername">Bank
                                            Branch</label>
                                        <div class="input-group">
                                            <select name="bank_branch_id" id="branch_id"
                                                    class="form-control">
                                                <option value=""></option>
                                                @foreach($bankbranches as $bankbranch)
                                                    <option value="{{$bankbranch->id}}"
                                                            @if($old_deposit->bank_branch_id==$bankbranch->id) selected @endif>{{$bankbranch->branch_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-3 my-1">
                                        <label class="" for="account_head">Account Head</label>
                                        <div class="input-group">
                                            <input type="text" min="0" class="form-control"
                                                   name="account_head"
                                                   id="account_head" {{$old_deposit->account_head}}>
                                        </div>
                                    </div>

                                    <div class="col-sm-3 my-1">
                                        <label class="" for="accountnumber">Account Number</label>
                                        <div class="input-group">
                                            <input type="text" min="0" class="form-control"
                                                   name="accountnumber"
                                                   id="accountnumber" {{$old_deposit->accountnumber}}>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-header">
                                <i class="fa fa-align-justify"></i>

                            </div>
                            <div class="card-body">

                                <div class="row">


                                    <div class="col-sm-12 my-1 row">
                                        <label class="" for="inlineFormInputGroupUsername">Uploaded
                                            Documents</label>
                                        <div class="input-group">
                                            <?php $fileManagerURL = asset('') . 'filemanager/dialog.php?field_id=image&relative_url=1'; ?>
                                            <a class="btn text-primary open-filemanager" data-fancybox
                                               data-type="iframe" data-src="{{ $fileManagerURL  }}"
                                               href="javascript:;">Set Document</a>

                                        </div>
                                        {{ Form::hidden('image', '', array('id' => 'image', 'class' => 'form-control')) }}


                                    </div>

                                    <div class="col-sm-12 my-1 row">
                                        <label class="" for="inlineFormInputGroupUsername">FB Receipt Location</label>
                                        <div class="input-group col-12">
                                            {!! Form::select('fd_document_current_location',$fd_locations,old('fd_document_current_location',$old_deposit->fd_document_current_location),['class'=>'form-control','placeholder'=>'Select Location']) !!}

                                        </div>
                                    </div>


                                    <div class="col-sm-6 my-1">
                                        <label class="" for="earmarked"><sup
                                                    class="required-field"></sup>Earmarked
                                            ?</label>
                                        <div class="input-group">
                                            <select name="earmarked" id="earmarked" class="form-control"
                                            >
                                                <option value="1"
                                                        @if($old_deposit->earmarked==1) selected @endif>
                                                    Yes
                                                </option>
                                                <option value="0"
                                                        @if($old_deposit->earmarked==0) selected @endif>
                                                    No
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 my-1">
                                        <label class="" for="alert_days"><sup
                                                    class="required-field"></sup>Alert
                                            Days</label>
                                        <div class="input-group">
                                            <input type="text" min="0" class="form-control"
                                                   value="{{$old_deposit->alert_days}}"
                                                   name="alert_days" id="alert_days"
                                            >
                                            <input type="hidden" value="1" name="status">
                                        </div>
                                    </div>

                                    <div class="col-sm-12 my-1">
                                        <label class="" for="inlineFormInputGroupUsername">Narration</label>
                                        <div class="input-group">
                                            <textarea name="narration" id="narration" cols="30" rows="5"
                                                      class="form-control">{{$old_deposit->narration ?? ''}}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 my-1">
                                        <label class="" for="inlineFormInputGroupUsername">Remarks</label>
                                        <div class="input-group">
                                                    <textarea name="notes" id="notes" cols="30" rows="5"
                                                              class="form-control">{{$old_deposit->notes}}</textarea>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div style="text-align: right">
                                            <button type="submit" class="btn btn-primary">
                                                Submit
                                            </button>
                                            <button type="reset" class="btn btn-outline-secondary" value="Reset">Clear
                                            </button>
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
                jQuery(field).after(selectedImg + docs + removeImg);
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

        $('#trans_date_en,#mature_date_en,#cheque_date,#credit_date').flatpickr();

        $('#trans_date').val(AD2BS($('#trans_date_en').val()));
        var trans_date = $('#trans_date').val();
        var days = $('#days').val();

        if (days !== '') {
            adddays(trans_date, days);
        }

        $('#trans_date').nepaliDatePicker({
            npdMonth: true,
            npdYear: true,
            npdYearCount: 10,
            onChange: function (e) {
                $("#trans_date").blur();
                $('#trans_date_en').val(BS2AD($('#trans_date').val()));
                var trans_date = $('#trans_date').val();
                var days = $('#days').val();

                if (days !== '') {
                    adddays(trans_date, days);
                }
            }
        });


        $('#trans_date_en').change(function () {
            $('#trans_date').val(AD2BS($('#trans_date_en').val()));
            var trans_date = $('#trans_date').val();
            var days = $('#days').val();

            if (days !== '') {
                adddays(trans_date, days);
            }
        });

        $('#credit_date').change(function () {
            $('#credit_date_np').val(AD2BS($('#credit_date').val()));
        });

        $('#credit_date_np').nepaliDatePicker({
            npdMonth: true,
            npdYear: true,
            npdYearCount: 10,
            onChange: function (e) {
                $("#credit_date_np").blur();
                $('#credit_date').val(BS2AD($('#credit_date_np').val()));

            }
        });

        $(document).on('keyup', '#days', function () {
            var days = $('#days').val();
            var trans_date = $('#trans_date').val();

            adddays(trans_date, days);
            calculate_estearning();
        });

        $(document).on('keyup', '#deposit_amount', function () {
            calculate_estearning();
        });

        // /*to calcualte the total amount based upon the
        $(document).on('keyup', '#interest_rate', function () {
            calculate_estearning();
        });

        //add days to transaction date and show mature date
        function adddays(trans_date, days) {
            if (days !== '' && trans_date !== '') {
                if (!isNaN(days)) {
                    $.ajax({
                        url: '{{ URL::to('adddays')}}',
                        type: 'post',
                        aysnc: false,
                        data: {
                            '_token': $('input[name=_token]').val(),
                            'date': trans_date,
                            'days': days,
                        },
                        success: function (data) {
                            $('#mature_date').val(data['mature_date']);
                            $('#mature_date_en').val(data['mature_date_en']);
                            calculate_estearning();
                        },
                        error: function () {
                        }
                    });
                } else {
                    $('#mature_date').empty();
                    $('#mature_date_en').empty();
                    alert('please enter days in number');
                }
            } else {
                $('#mature_date').val('');
                $('#mature_date_en').val('');
            }
        }

        function calculate_estearning() {
            var deposit_amount = $('#deposit_amount').val();
            var interest_rate = $('#interest_rate').val();
            var days = $('#days').val();
            var est_earning = 0;
            if (deposit_amount !== '' && interest_rate !== '' && days !== '') {
                est_earning = (((deposit_amount * interest_rate) / (100 * 365)) * days);
            }
            $('#estimated_earning').val(est_earning.toFixed(2)).blur();
            $("#mature_date").blur();
        }

        $('#mature_date_en').change(function () {
            $('#mature_date').val(AD2BS($('#mature_date_en').val()));
            var mature_date_en = $('#mature_date_en').val();
            var trans_date_en = $('#trans_date_en').val();

            var date1 = new Date(trans_date_en);
            var date2 = new Date(mature_date_en);
            var diffDays = parseInt((date2 - date1) / (1000 * 60 * 60 * 24)) + 1;
            $('#days').val(diffDays).blur();
            calculate_estearning();
        });
        // $('#trans_date_en').trigger('click')
    </script>
@endsection
