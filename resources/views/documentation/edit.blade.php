@extends('layouts.master')
@section('title','Documentation Edit')
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
                                Edit Document
                            </div>
                            <div class="card-header-rights">

                            </div>
                        </div>
                        <div class="card-body">
                            {!! Form::open(['route' => 'documentation.edit','method'=>'PATCH','files'=>true]) !!}
                            {{ Form::token()}}

                            <div class="row form-group">
                                <div class="col-4">
                                    {{ Form::label('title', 'Document Title')}}
                                </div>
                                <div class="col-8">
                                    {{Form::text('title',null,['class'=>'form-control','placeholder'=>'Add Document Title'])}}
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-4">
                                    {{ Form::label('filename', 'File')}}
                                </div>
                                <div class="col-8">
                                    {{Form::file('filename',null,['class'=>'form-control','placeholder'=>'Add Document Title'])}}
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-12 text-center">
                                    {{Form::submit('Add Document',['class'=>'btn btn-primary'])}}
                                </div>
                            </div>

                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.deleteModal')

@endsection


