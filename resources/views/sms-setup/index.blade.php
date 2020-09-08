@extends('layouts.master')
@section('title','SMS Setup')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12 col-md-7 col-xl-7">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i>
                            SMS Configuration
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-12">
                                    @if(!empty($sms_setups))
                                        <div>
                                            <a href="{{route('sms-setup.create')}}"
                                               class="btn btn-info">
                                                Edit
                                            </a>
                                        </div>
                                        @foreach($sms_setups as $sms_setup)
                                            <div class="form-group row">
                                                <label for="start_date"
                                                       class="col-sm-3 col-form-label">{{$sms_setup->parameter}}
                                                    :</label>
                                                <div class="col-sm-9"><h6>{{$sms_setup->value}}</h6></div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="col-xl-5">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-md-5 col-xl-5">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i>
                            TEST SMS
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-12">
                                    @if(!empty($sms_setups))
                                        <form action="{{route('sms-setup.test')}}" method="post">
                                            @csrf
                                            @foreach($sms_setups as $sms_setup)
                                                <div class="form-group row">
                                                    <label for="start_date"
                                                           class="col-sm-3 col-form-label">{{$sms_setup->parameter}}
                                                        :</label>
                                                    <div class="col-sm-9">
                                                        @if(strcasecmp($sms_setup->value,'{mobile_number}')==0)
                                                            {{Form::text('mobile_number',null,['class'=>'form-control','placeholder'=>'Mobile Number'])}}

                                                        @elseif(strcasecmp($sms_setup->value,'{message}')==0)
                                                            {{Form::text('message',null,['class'=>'form-control','placeholder'=>'Message'])}}
                                                        @else
                                                            <h6>{{$sms_setup->value}}</h6>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                            <div class="form-group">
                                                <button class="btn btn-primary">Send</button>
                                            </div>
                                        </form>
                                    @endif
                                    <div class="col-xl-5">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
@section('scripts')
@endsection
