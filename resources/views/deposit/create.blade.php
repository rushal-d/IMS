@extends('layouts.master')
@section('title','Deposit Create')
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
            <form method="post" id="deposit_form" action="{{route('deposit.store')}}">
                @csrf
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-xl-8">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-3">
                                        <i class="fa fa-align-justify"></i>
                                        Deposit - Create
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

                                    <div class="col-sm-6 my-1">
                                        <label class="" for="inlineFormInputGroupUsername"><sup
                                                    class="required-field">*</sup>Bank Name</label>
                                        <div class="input-group">
{{--                                            {!! Form::select('institution_id',$institutes->pluck('institution_name','id'),null,['class'=>'form-control','id'=>'institution_id','placeholder'=>'Select Bank', 'data-validation' => 'required']) !!}--}}
                                            <select name="institution_id" class="form-control" id="institution_id" data-validation="required">
                                                <option value="">Select Bank</option>
                                                @foreach($institutes as $institution)
                                                    <option value="{{$institution->id}}">{{$institution->institution_name}} {{$institution->is_merger==1? '(Merged)':''}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-3 my-1">
                                        <label class="" for="inlineFormInputGroupUsername"><sup
                                                    class="required-field">*</sup>Bank Branch</label>
                                        <div class="input-group">
                                            <select name="branch_id" id="branch_id"
                                                    class="form-control bank_branch"
                                                    data-validation="required"
                                                    data-validation-error-msg="Select Bank Branch">
                                                <option value="">Select Bank Branch</option>
                                                @foreach($bankbranches as $bankbranch)
                                                    <option value="{{$bankbranch->id}}">{{$bankbranch->branch_name}}</option>
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
                                                    <option value="{{$organization_branch->id}}">{{$organization_branch->branch_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 my-1 max-20">
                                        <label class="" for="trans_date"><sup
                                                    class="required-field">*</sup>Tranx.
                                            Date (AD)</label>
                                        <div class="input-group">
                                            <input type="date" class="form-control" id="trans_date_en"
                                                   name="trans_date_en" data-validation="required within_2months"
                                                   data-validation-error-msg="Please Enter Transaction Date"
                                            >

                                        </div>
                                    </div>
                                    <div class="col-sm-3 my-1 max-20">
                                        <label class="" for="trans_date"><sup
                                                    class="required-field">*</sup>Tranx.
                                            Date (BS)</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control nep-date"
                                                   id="trans_date"
                                                   name="trans_date" data-validation="required"
                                                   data-validation-error-msg="Please Enter Transaction Date"

                                                   data-validation-format="yyyy-mm-dd" readonly>
                                        </div>
                                    </div>

                                    <div class="col-sm-3 my-1  max-20">
                                        <label class="" for="days"><sup
                                                    class="required-field">*</sup>Days</label>
                                        <div class="input-group">
                                            <input type="number" min="0" class="form-control"
                                                   name="days"
                                                   id="days"
                                                   data-validation="required"
                                                   data-validation-error-msg="Please Enter Days">
                                        </div>
                                    </div>

                                    <div class="col-sm-3 my-1 max-20">
                                        <label class="" for="mature_date"><sup
                                                    class="required-field">*</sup>Mature Date (AD)</label>
                                        <div class="input-group">
                                            <input type="date" class="form-control"
                                                   id="mature_date_en" name="mature_date_en"
                                                   data-validation="required"
                                                   data-validation-error-msg="Please Enter Mature Date"
                                                   value="">
                                        </div>
                                    </div>
                                    <div class="col-sm-3 my-1  max-20">
                                        <label class="" for="mature_date"><sup
                                                    class="required-field">*</sup>Mature Date
                                            (BS)</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control nep-date"
                                                   id="mature_date" name="mature_date"
                                                   data-validation="required"
                                                   data-validation-error-msg="Please Enter Mature Date"
                                                   value="" readonly>
                                        </div>
                                    </div>

                                    <div class="col-sm-3 my-2">
                                        <label class="" for="interest_rate"><sup
                                                    class="required-field">*</sup>Interest Rate/Year
                                        </label>
                                        <div class="input-group">
                                            <input type="number" step="0.01"
                                                   data-validation-allowing="range[1;100], float"
                                                   class="form-control" name="interest_rate"
                                                   id="interest_rate" data-validation="number"
                                                   data-validation-error-msg="Enter Interest Rate"
                                                   placeholder="%">
                                        </div>
                                    </div>
                                    <div class="col-sm-3 my-2">
                                        <label class="" for="inlineFormInputGroupUsername"><sup
                                                    class="required-field">*</sup>Deposit Amount</label>
                                        <div class="input-group">
                                            <input type="number" min="0" step="0.01"
                                                   name="deposit_amount"
                                                   data-validation-allowing="float" class="form-control"
                                                   id="deposit_amount" data-validation="required"
                                                   data-validation-error-msg="Enter Deposit Amount"
                                                   placeholder="Rs.">
                                        </div>

                                    </div>
{{--                                    <div class="col-sm-3 my-1">--}}
{{--                                        <label class="" for="interest_payment_method"><sup--}}
{{--                                                    class="required-field">*</sup>Interest Pay.--}}
{{--                                            Method</label>--}}
{{--                                        <div class="input-group">--}}
{{--                                            <select name="interest_payment_method"--}}
{{--                                                    id="interest_payment_method" class="form-control"--}}
{{--                                                    data-validation="required" data-validation="required"--}}
{{--                                                    data-validation-error-msg="Select Interest Payment Method">--}}
{{--                                                <option value="">Select payment method</option>--}}

{{--                                            </select>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
                                    <div class="col-sm-3 my-1">
                                        <label class="" for="estimated_earning"><sup
                                                    class="required-field">*</sup>Interest Payment Method</label>
                                        <div class="input-group">
                                            {!! Form::select('interest_payment_method', $interest_payment_methods, null,['class'=>'form-control','placeholder'=>'Interest Payment Method']) !!}
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="" for="estimated_earning"><sup
                                                    class="required-field">*</sup>Estimated
                                            Earning</label>
                                        <div class="input-group">
                                            <input type="number" min="0" step="0.01"
                                                   class="form-control" placeholder="Rs."
                                                   name="estimated_earning" id="estimated_earning"
                                                   data-validation="required" data-validation="required"
                                                   data-validation-error-msg="Please check the fields to calculate estimated earning are valid.">

                                        </div>
                                    </div>

                                    <div class="col-sm-3 my-1">
                                        <label class="" for="document_no"><sup
                                                    class="required-field">*</sup>FD Number</label>
                                        <div class="input-group">
                                            <input type="text" min="0" class="form-control"
                                                   id="document_no"
                                                   name="document_no"
                                                   placeholder="Enter FD Number"
                                                   data-validation="required"
                                                   data-validation-error-msg="Enter FD Number">
                                        </div>
                                    </div>




                                    <div class="col-sm-3 my-1">
                                        <label class="" for="investment_subtype_id">Staff</label>
                                        <div class="input-group">
                                            {{Form::select('staff_id',$staffs,null,array('class'=>'form-control','id'=>'staff_id','placeholder'=>'Select Staff'))}}
                                        </div>
                                    </div>


                                    <div class="col-sm-3 my-1">
                                        <label class="" for="totalamount">Reference Number</label>
                                        <div class="input-group">
                                            <input type="text" min="0" class="form-control"
                                                   name="reference_number" id="reference_number"
                                                   placeholder="Enter Reference Number">
                                        </div>
                                    </div>
                                    <div class="col-sm-3 my-1">
                                        <label class="" for="inlineFormInputGroupUsername">Cheque Bank</label>
                                        <div class="input-group">
                                            {!! Form::select('cheque_bank_id', $institutes->pluck('institution_name', 'id'), null, ['class' => 'form-control', 'placeholder' => 'Bank']) !!}
                                        </div>
                                    </div>

                                    <div class="col-sm-3 my-1">
                                        <label class="" for="inlineFormInputGroupUsername">Cheque Number</label>
                                        <div class="input-group">
                                            <input type="text" name="cheque_no" class="form-control"
                                                   id="cheque_no">
                                        </div>
                                    </div>

                                    <div class="col-sm-3 my-1">
                                        <label class="" for="cheque_date">Cheque Date</label>
                                        <div class="input-group">
                                            <input type="date" class="form-control"
                                                   name="cheque_date" id="cheque_date">
                                        </div>
                                    </div>
                                    <div class="col-sm-3 my-1">
                                        <label class="" for="cheque_date">Debit Bank</label>
                                        <div class="input-group">
                                            <select name="debit_bank_id" id="debit_bank_id"
                                                    class="form-control">
                                                <option value=""></option>
                                                @foreach($institutes as $institute)
                                                    <option value="{{$institute->id}}">{{$institute->institution_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 my-1">
                                        <label class="" for="debit_branch">Debit Bank Branch</label>
                                        <div class="input-group">
                                            {!! Form::select('debit_branch_id', $bankbranches->pluck('branch_name', 'id'), null, ['class' => 'form-control', 'placeholder' => 'Debit branch']) !!}
                                        </div>
                                    </div>
                                    <div class="col-sm-3 my-1">
                                        <label class="" for="inlineFormInputGroupUsername">Debit Bank Account Number</label>
                                        <div class="input-group">
                                            <input type="text" name="debit_account_number" class="form-control"
                                                   id="debit_account_number">
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-3 my-1">
                                        <label class="" for="totalamount">Receipt Number</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control"
                                                   name="receipt_no" id="receipt_no">
                                        </div>
                                    </div>


                                    <div class="col-sm-3 my-1">
                                        <label class="" for="totalamount">Voucher Number</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control"
                                                   name="voucher_number" id="voucher_number">
                                        </div>
                                    </div>

                                    <div class="col-sm-3 my-1">
                                        <label class="" for="credit_date">Credit
                                            Date (AD)</label>
                                        <div class="input-group">
                                            <input type="date" class="form-control" id="credit_date"
                                                   name="credit_date">
                                        </div>
                                    </div>

                                    <div class="col-sm-3 my-1">
                                        <label class="" for="credit_date_np">Credit
                                            Date (BS)</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control nep-date"
                                                   id="credit_date_np"
                                                   name="credit_date_np">
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
                                                    <option value="{{$institute->id}}">{{$institute->institution_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-3 my-1">
                                        <label class="" for="inlineFormInputGroupUsername">Bank
                                            Branch</label>
                                        <div class="input-group">
                                            <select name="bank_branch_id" id="bank_branch_id"
                                                    class="form-control bank_branch">
                                                <option value=""></option>
                                                @foreach($bankbranches as $bankbranch)
                                                    <option value="{{$bankbranch->id}}">{{$bankbranch->branch_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-3 my-1">
                                        <label class="" for="account_head">Account Head</label>
                                        <div class="input-group">
                                            <input type="text" min="0" class="form-control"
                                                   name="account_head" id="account_head">
                                        </div>
                                    </div>


                                    <div class="col-sm-3 my-1">
                                        <label class="" for="accountnumber">Account Number</label>
                                        <div class="input-group">
                                            <input type="text" min="0" class="form-control"
                                                   name="accountnumber" id="accountnumber">
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
                                        <label class="" for="inlineFormInputGroupUsername">Upload Document</label>
                                        <div class="input-group col-12 text-center">
                                            <a class="text-primary btn btn-info btn-sm" data-fancybox data-type="iframe"
                                               data-src="{{ asset('') }}filemanager/dialog.php?type=0&field_id=image&relative_url=1"
                                               href="javascript:;">Select Documents</a>
                                            {{ Form::hidden('image', '', array('id' => 'image', 'class' => 'form-control')) }}

                                        </div>
                                    </div>

                                    <div class="col-sm-12 my-1 row">
                                        <label class="" for="inlineFormInputGroupUsername">FD Receipt Location</label>
                                        <div class="input-group col-12">
                                            {!! Form::select('fd_document_current_location',$fd_locations,old('fd_document_current_location'),['class'=>'form-control','placeholder'=>'Select Location']) !!}

                                        </div>
                                    </div>
                                    <div class="col-sm-6 my-1">
                                        <label class="" for="earmarked"><sup
                                                    class="required-field">*</sup>Earmarked
                                            ?</label>
                                        <div class="input-group">
                                            <select name="earmarked" id="earmarked" class="form-control"
                                                    data-validation="required"
                                                    data-validation-error-msg="Select Earmarked">
                                                <option value="1">Yes</option>
                                                <option value="0" selected>No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 my-1">
                                        <label class="" for="alert_days"><sup
                                                    class="required-field">*</sup>Alert
                                            Days</label>
                                        <div class="input-group">
                                            <input type="number" min="0" class="form-control" value="30"
                                                   name="alert_days" id="alert_days"
                                                   data-validation="required"
                                                   data-validation-error-msg="Enter Alert Days">
                                            <input type="hidden" name="status" value="1">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 my-1">
                                        <label class="" for="inlineFormInputGroupUsername">Narration</label>
                                        <div class="input-group">
                                            <textarea name="narration" id="narration" cols="30" rows="5"
                                                      class="form-control"></textarea>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 my-1">
                                        <label class="" for="inlineFormInputGroupUsername">Remarks</label>
                                        <div class="input-group">
                                            <textarea name="notes" id="notes" cols="30" rows="5"
                                                      class="form-control"></textarea>
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
                                            <button type="button" id="submit-button" class="btn btn-primary">
                                                Submit
                                            </button>
                                            <button type="reset" class="btn btn-secondary" value="Reset">Clear</button>
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
                    <?php $organization_branches_plucked = $organization_branches->pluck('branch_name', 'id')?>
                    {{Form::select('staff_branch',$organization_branches_plucked,null,array('class'=>'form-control','id'=>'staff_organization_branch','placeholder'=>'Select Organization Branch'))}}
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

    <div class="modal fade" id="confirm_days">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Confirm Days</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <p id="days-confirmation-mesg"></p>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="confirm_and_submit"
                            data-dismiss="modal">Confirm and Submit
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
            console.log(files);
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
                    var selectedImg = '<div class="selected-img-box col-4"  data-toggle="tooltip" data-placement="top" title="' + file + '"><div class="selected-img">';

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
                    jQuery(field).parent().after(docs + selectedImg + removeImg);
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
                jQuery(field).parent().after(selectedImg + docs + removeImg);
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

        $('#mature_date').nepaliDatePicker({
            npdMonth: true,
            npdYear: true,
            npdYearCount: 10,
            onChange: function (e) {
                $("#mature_date").blur();
                $('#mature_date_en').val(BS2AD($('#mature_date').val()));
                var mature_date_en = $('#mature_date_en').val();
                var trans_date_en = $('#trans_date_en').val();

                var date1 = new Date(trans_date_en);
                var date2 = new Date(mature_date_en);
                var diffDays = parseInt((date2 - date1) / (1000 * 60 * 60 * 24)) + 1;
                $('#days').val(diffDays).blur();
                calculate_estearning();
            }
        });

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

        $('#submit-button').click(function (e) {
            e.preventDefault();
            let days = $('#days').val();
            if (days > 365 || days < 365) {
                if(days>365){
                    $('#days-confirmation-mesg').text('The number of days for the transaction is greater than 365 days. Do you confirm?')
                }else{
                    $('#days-confirmation-mesg').text('The number of days for the transaction is less than 365 days. Do you confirm?')
                }
                $('#confirm_days').modal()
            } else {
                $('#deposit_form').submit();
            }
        });

        $('#confirm_and_submit').click(function () {
            $('#deposit_form').submit();
        })
    </script>
@endsection
