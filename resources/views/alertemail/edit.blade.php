@extends('layouts.master')
@section('title','Alter Account Edit')
@section('styles')

@endsection
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12 col-md-6 col-xl-6">
                    <div class="card">
                        <div class="card-header">

                            <div class="card-header-actions">
                                Edit Alert Account
                            </div>
                            <div class="card-header-rights">

                            </div>
                        </div>
                        <div class="card-body">
                            {!! Form::open(['route' => ['alertEmails.update',$alertEmail->id],'method'=>'POST']) !!}
                            {{ Form::token()}}
                            @method('PATCH')

                            <div class="row form-group">
                                <div class="col-4">
                                    {{ Form::label('name', 'Name')}}
                                </div>
                                <div class="col-8">
                                    {{Form::text('name',$alertEmail->name,['class'=>'form-control','placeholder'=>'Name'])}}
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-4">
                                    {{ Form::label('organization_branch_id', 'Organization Branch')}}
                                </div>
                                <div class="col-8">
                                    {{Form::select('organization_branch_id',$organization_branches,$alertEmail->organization_branch_id,['class'=>'form-control','placeholder'=>'Select Organization Branch'])}}
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-4">
                                    {{ Form::label('email', 'Email')}}
                                </div>
                                <div class="col-8">
                                    {{Form::email('email',$alertEmail->email,['class'=>'form-control','placeholder'=>'Email Address'])}}
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-4">
                                    {{ Form::label('mobile_number', 'Mobile Number')}}
                                </div>
                                <div class="col-8">
                                    {{Form::text('mobile_number',$alertEmail->mobile_number,['class'=>'form-control','placeholder'=>'Mobile Number'])}}
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-12 text-center">
                                    {{Form::submit('Update',['class'=>'btn btn-primary'])}}
                                </div>
                            </div>

                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


