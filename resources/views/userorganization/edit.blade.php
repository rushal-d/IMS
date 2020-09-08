@extends('layouts.master')
@section('title','User Organization')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i>
                            Organziation Edit
                            <div class="card-header-actions">
                                <a href="#" class="card-header-action btn-minimize" data-toggle="collapse"
                                   data-target="#collapseExamples" aria-expanded="true">
                                    <i class="icon-arrow-up"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{route('userorganization.update', $userorganization->id)}}" method="post">
                                @csrf
                                @method('PATCH')
                                <div class="form-group row">
                                    <label for="start_date" class="col-sm-2 col-form-label">Organization Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="organization_name"
                                               name="organization_name" data-validation="required"
                                               value="{{$userorganization->organization_name}}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="start_date" class="col-sm-2 col-form-label">Organization Code</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="organization_code"
                                               name="organization_code" data-validation="required"
                                               value="{{$userorganization->organization_code}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="start_date" class="col-sm-2 col-form-label">Address</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="address" name="address"
                                               value="{{ $userorganization->address  }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="start_date" class="col-sm-2 col-form-label">Contact Person</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="contact_person"
                                               name="contact_person"
                                               value="{{ $userorganization->contact_person }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="start_date" class="col-sm-2 col-form-label">Effective Date</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control nep-date" id="effect_date"
                                               name="effect_date"
                                               value="{{ $userorganization->effect_date }}" readonly>
                                        <input type="hidden" id="effect_date_en" name="effect_date_en"
                                               value="{{$userorganization->effect_date_en}}" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="end_date" class="col-sm-2 col-form-label">Valid Date</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control nep-date" id="valid_date"
                                               name="valid_date"
                                               value="{{ $userorganization->valid_date}}" readonly>
                                        <input type="hidden" id="valid_date_en" name="valid_date_en"
                                               value="{{$userorganization->valid_date_en}}" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="code" class="col-sm-2 col-form-label">Status</label>
                                    <div class="col-sm-10">
                                        <select name="status" id="status" class="form-control"
                                                data-validation="required">
                                            <option value="">Select</option>
                                            <option value="1" @if($userorganization->status == 1) selected @endif>
                                                Active
                                            </option>
                                            <option value="0" @if($userorganization->status == 0) selected @endif>
                                                Inactive
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="code" class="col-sm-2 col-form-label">Implement Merger</label>
                                    <div class="col-sm-10">
                                        <select name="implement_merger" id="implement_merger" class="form-control"
                                                data-validation="required">
                                            <option value="">Select</option>
                                            <option value="1"
                                                    @if($userorganization->implement_merger == 1) selected @endif>Yes
                                            </option>
                                            <option value="0"
                                                    @if($userorganization->implement_merger == 0) selected @endif>No
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="letter1" class="col-sm-2 col-form-label">Placement Letter :</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control ok" name="placement_letter" rows="30">
                                            {{$userorganization->placement_letter}}
                                        </textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="letter2" class="col-sm-2 col-form-label">Placement Letter2 :</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control ok" name="placement_letter2" rows="60">
                                            {{$userorganization->placement_letter2}}
                                        </textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="letter3" class="col-sm-2 col-form-label">Renew Letter :</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control ok" name="renew_letter" rows="60">
                                            {{$userorganization->renew_letter}}
                                        </textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="letter4" class="col-sm-2 col-form-label">Withdraw Letter: </label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control ok" name="withdraw_letter" rows="60">
                                            {{$userorganization->withdraw_letter}}
                                        </textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="letter5" class="col-sm-2 col-form-label">TDS Certification
                                        Letter: </label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control ok" name="tds_certification_letter" rows="60">
                                            {{$userorganization->tds_certification_letter}}
                                        </textarea>
                                    </div>
                                </div>
                                <div style="text-align: center">
                                    <button type="submit" class="btn btn-primary">
                                        Update
                                    </button>
                                    <button type="reset" class="btn btn-outline-secondary" value="Reset">
                                        Clear
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        CKEDITOR.replace("placement_letter", {
            tabSpaces: 5,
            uploadUrl: '{{route('upload-ckeditor',['_token'=>csrf_token()])}}'
        });
        CKEDITOR.replace("placement_letter2", {
            tabSpaces: 5,
            uploadUrl: '{{route('upload-ckeditor',['_token'=>csrf_token()])}}'
        });
        CKEDITOR.replace("withdraw_letter", {
            tabSpaces: 5,
            uploadUrl: '{{route('upload-ckeditor',['_token'=>csrf_token()])}}'
        });
        CKEDITOR.replace("renew_letter", {
            tabSpaces: 5,
            uploadUrl: '{{route('upload-ckeditor',['_token'=>csrf_token()])}}'
        });
        CKEDITOR.replace("tds_certification_letter", {
            tabSpaces: 5,
            uploadUrl: '{{route('upload-ckeditor',['_token'=>csrf_token()])}}'
        });

        $('.nep-date').nepaliDatePicker({
            npdMonth: true,
            npdYear: true,
            npdYearCount: 10,
            onChange: function (e) {
                $('#effect_date_en').val(BS2AD($('#effect_date').val()));
                $('#valid_date_en').val(BS2AD($('#valid_date').val()));
            }
        });
    </script>
@endsection
