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
                            User Organization
                            <div class="card-header-actions">
                                <a href="#" class="card-header-action btn-minimize" data-toggle="collapse"
                                   data-target="#collapseExamples" aria-expanded="true">
                                    <i class="icon-arrow-up"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">

                            @if(!empty($userorganization))
                                <div>
                                    <a href="{{route('userorganization.edit', $userorganization->id)}}"
                                       class="btn btn-info">
                                        Edit
                                    </a>

                                    <a href="{{route('depsit-excel-export-column')}}"
                                       class="btn btn-info">
                                       Deposit Export Columns
                                    </a>
                                </div>
                                <div class="form-group row">
                                    <label for="start_date" class="col-sm-2 col-form-label">Organization Name
                                        :</label>
                                    <div class="col-sm-9"><h6>{{$userorganization->organization_name}}</h6>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="start_date" class="col-sm-2 col-form-label">Organization Code
                                        :</label>
                                    <div class="col-sm-9"><h6>{{$userorganization->organization_code}}</h6>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="start_date" class="col-sm-2 col-form-label">Address :</label>
                                    <div class="col-sm-9"><h6>{{ $userorganization->address }}</h6></div>
                                </div>
                                <div class="form-group row">
                                    <label for="start_date" class="col-sm-2 col-form-label">Contact Person
                                        :</label>
                                    <div class="col-sm-9"><h6>{{ $userorganization->contact_person }} </h6>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="start_date" class="col-sm-2 col-form-label">Effective Date
                                        :</label>
                                    <div class="col-sm-9"><h6>{{ $userorganization->effect_date }}</h6></div>
                                </div>
                                <div class="form-group row">
                                    <label for="end_date" class="col-sm-2 col-form-label">Valid Date :</label>
                                    <div class="col-sm-9"><h6>{{ $userorganization->valid_date}}</h6></div>
                                </div>
                                <div class="form-group row">
                                    <label for="code" class="col-sm-2 col-form-label">Status :</label>
                                    <div class="col-sm-9"><h6>@if($userorganization->status == 1) Active @else
                                                Inactive @endif</h6></div>
                                </div>
                                <div class="form-group row">
                                    <label for="code" class="col-sm-2 col-form-label">Implement Merger :</label>
                                    <div class="col-sm-9"><h6>@if($userorganization->implement_merger == 1) Yes @else
                                                No @endif</h6></div>
                                </div>
                                <div class="form-group row">
                                    <label for="letter1" class="col-sm-2 col-form-label">Placement Letter :</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control ok" name="placement_letter" rows="30" disabled="disabled">
                                            {{$userorganization->placement_letter}}
                                        </textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="letter1" class="col-sm-2 col-form-label">Placement Letter 2:</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control ok" name="placement_letter2" rows="60" disabled="disabled">
                                            {{$userorganization->placement_letter2}}
                                        </textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="letter1" class="col-sm-2 col-form-label">Renew Letter :</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control ok" name="renew_letter" rows="60" disabled="disabled">
                                            {{$userorganization->renew_letter}}
                                        </textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="letter1" class="col-sm-2 col-form-label">Withdraw Letter :</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control ok" name="withdraw_letter" rows="60" disabled="disabled">
                                            {{$userorganization->withdraw_letter}}
                                        </textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="letter1" class="col-sm-2 col-form-label">TDS Certification Letter: </label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control ok" name="tds_certification_letter" rows="60" disabled="disabled">
                                            {{$userorganization->tds_certification_letter}}
                                        </textarea>
                                    </div>
                                </div>
                            @else
                                <form method="post"
                                      action="{{route('userorganization.store')}}"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group row">
                                        <label for="start_date" class="col-sm-2 col-form-label">Organization
                                            Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="organization_name"
                                                   name="organization_name" data-validation="required"
                                                   value="{{ old('organization_name') }}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="start_date" class="col-sm-2 col-form-label">Organization
                                            Code</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="organization_code"
                                                   name="organization_code" data-validation="required"
                                                   value="{{ old('organization_code') }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="start_date" class="col-sm-2 col-form-label">Address</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="address" name="address"
                                                   value="{{ old('address') }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="start_date" class="col-sm-2 col-form-label">Contact
                                            Person</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="contact_person"
                                                   name="contact_person"
                                                   value="{{ old('contact_person') }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="start_date" class="col-sm-2 col-form-label">Effective
                                            Date</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control nep-date" id="effect_date"
                                                   name="effect_date"
                                                   value="{{ old('effect_date') }}" readonly>
                                            <input type="hidden" id="effect_date_en" name="effect_date_en"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="end_date" class="col-sm-2 col-form-label">Valid Date</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control nep-date" id="valid_date"
                                                   name="valid_date"
                                                   value="{{ old('valid_date') }}" readonly>
                                            <input type="hidden" id="valid_date_en" name="valid_date_en"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="code" class="col-sm-2 col-form-label">Status</label>
                                        <div class="col-sm-9">
                                            <select name="status" id="status" class="form-control">
                                                <option value="null">Select</option>
                                                <option value="1">Active</option>
                                                <option value="0">Inactive</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="code" class="col-sm-2 col-form-label">Implement
                                            Merger</label>
                                        <div class="col-sm-9">
                                            <select name="status" id="status" class="form-control">
                                                <option value="null">Select</option>
                                                <option value="1">Yes</option>
                                                <option value="0">No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="letter1" class="col-sm-2 col-form-label">Placement Letter :</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control ok" name="placement_letter" rows="30">

                                            </textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="letter2" class="col-sm-2 col-form-label">Placement Letter2 :</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control ok" name="placement_letter2" rows="60">

                                            </textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="letter3" class="col-sm-2 col-form-label">Renew Letter :</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control ok" name="renew_letter" rows="60">

                                            </textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="letter4" class="col-sm-2 col-form-label">Withdraw Letter: </label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control ok" name="withdraw_letter" rows="60">

                                            </textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="letter5" class="col-sm-2 col-form-label">TDS Certification Letter: </label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control ok" name="tds_certification_letter" rows="60">

                                            </textarea>
                                        </div>
                                    </div>
                                    <div style="text-align: center">
                                        <button type="submit" class="btn btn-primary">
                                            Submit
                                        </button>
                                        <button type="reset" class="btn btn-outline-secondary" value="Reset">
                                            Clear
                                        </button>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $('.nep-date').nepaliDatePicker({
            npdMonth: true,
            npdYear: true,
            npdYearCount: 10,
            onChange: function (e) {
                $('#effect_date_en').val(BS2AD($('#effect_date').val()));
                $('#valid_date_en').val(BS2AD($('#valid_date').val()));
            }
        });
        CKEDITOR.replace("placement_letter", {
            tabSpaces: 5
        });
        CKEDITOR.replace("placement_letter2", {
            tabSpaces: 5
        });
        CKEDITOR.replace("withdraw_letter", {
            tabSpaces: 5
        });
        CKEDITOR.replace("renew_letter", {
            tabSpaces: 5
        });
        CKEDITOR.replace("tds_certification_letter", {
            tabSpaces: 5
        });
    </script>
@endsection
