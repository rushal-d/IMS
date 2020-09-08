@extends('layouts.master')
@section('title','Bank Merger Create')
@section('styles')
    <style>
        .form-error {
            margin-top: 0px !important;
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12 col-md-9 col-xl-9">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-header-actions">
                                Merger Create
                            </div>
                            <div class="card-header-rights">

                            </div>
                        </div>
                        <div class="card-body">
                            {!! Form::open(['route'=>'bank-merger.store','id'=>'bank-merge']) !!}
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-3">
                                        {!! Form::label('After Merger Bank') !!}
                                    </div>
                                    <div class="col-9">
                                        {!! Form::select('bank_code_after_merger',$institutions,old('bank_code_after_merger'),['class'=>'form-control bank-code-after-merger','placeholder'=>'Select Bank Name After Merger','data-validation'=>'required','data-validation-error-msg'=>'You must select the bank name after merger.']) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-3">
                                        {!! Form::label('Merge Date') !!}
                                    </div>
                                    <div class="col-9">
                                        {!! Form::text('merger_date',old('merger_date'),['class'=>'form-control flatpickr','id'=>'merger-date','placeholder'=>'Select Merge Date','data-validation'=>'required','data-validation-error-msg'=>'Merge Date is required']) !!}
                                    </div>
                                </div>
                            </div>
                            <p>
                                <b>Merged Bank List</b>
                            </p>
                            <div class="form-group">
                                <button type="button" class="btn btn-sm btn-primary add-more">Add More</button>
                            </div>
                            <div class="bank-list">
                                <div class="bank">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-3">
                                                {!! Form::label('Merged Bank') !!}
                                            </div>
                                            <div class="col-8">
                                                {!! Form::select('bank_code[]',$institutions,old('bank_code[]'),['class'=>'form-control bank_code','placeholder'=>'Select Bank','data-validation'=>'required','data-validation-error-msg'=>'You must select the merged bank']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="bank">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-3">
                                                {!! Form::label('Merged Bank') !!}
                                            </div>
                                            <div class="col-8">
                                                {!! Form::select('bank_code[]',$institutions,old('bank_code[]'),['class'=>'form-control bank_code','placeholder'=>'Select Bank','data-validation'=>'required','data-validation-error-msg'=>'You must select the merged bank']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="button" class="btn btn-primary" id="submitButton">
                                    Submit Merge
                                </button>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="mergeConfirmModal" tabindex="-1" role="dialog" aria-labelledby="mergeConfirmModal"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Merger Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to confirm these mergers?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary save-merger">Save changes</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="errorDisplayModal" tabindex="-1" role="dialog" aria-labelledby="errorDisplayModal"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Error Message</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul id="error-list"></ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary save-merger">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $('.add-more').click(function () {
            $selected_value = $('.bank:first').find('.bank_code').val();
            $('.bank:first').find('.bank_code')[0].selectize.destroy();
            let bank_div = $('.bank:first').clone();
            bank_div.find('.row').append('<div class="col-1"><button type="button" class="btn btn-danger btn-sm remove-bank-code">-</button></div>')
            $('.bank-list').append(bank_div);
            $('.bank:last').find('.bank_code').selectize();
            var $select = $('.bank:first').find('.bank_code').selectize();
            var selectize = $select[0].selectize;
            selectize.setValue($selected_value, false);
        });

        $(document).on('click', '.remove-bank-code', function () {
            $(this).parents('.bank').remove();
        });

        $('#submitButton').click(function (e) {
            e.preventDefault();

            let acquiringBank = $('.bank-code-after-merger').val();
            let mergerDate = $('.merger-date').val();
            let mergingBanks = [];
            let mergingBankElements = $('.bank_code.selectized')
            console.log(mergingBankElements);
            $.each(mergingBankElements, function (index, value) {
                if (acquiringBank != $(value).val()) {
                    mergingBanks.push($(value).val());
                }
            })

            $.ajax({
                url: '{{route('check-if-merger-bank-exists')}}',
                type: 'POST',
                data: {
                    '_token': '{{csrf_token()}}',
                    'acquiringBank': acquiringBank,
                    'mergingBanks': mergingBanks,
                    'mergerDate': mergerDate,
                }, success: function (response) {
                    if (response['errors'].length == 0) {
                        $('#mergeConfirmModal').modal()
                    } else {
                        let error_list = '';
                        $.each(response['errors'], function (index, value) {
                            error_list += '<li>' + value + '</li>'
                        })
                        $('#error-list').html(error_list);
                        $('#errorDisplayModal').modal();
                    }
                }
            })

        })

        $('.save-merger').click(function () {
            $('#bank-merge').submit();
            $('#mergeConfirmModal').modal('hide')
        });
        $('.flatpickr').flatpickr();
    </script>
@endsection


