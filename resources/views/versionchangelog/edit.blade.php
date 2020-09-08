@extends('layouts.master')
@section('title','Version Log Edit')
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
                                Edit Version Log
                            </div>
                            <div class="card-header-rights">

                            </div>
                        </div>
                        <div class="card-body">
                            {!! Form::open(['route' => 'version-change-log.edit','method'=>'PATCH','files'=>true]) !!}
                            {{ Form::token()}}

                            <div class="row form-group">
                                <div class="col-4">
                                    {{ Form::label('version_code', 'Version Code')}}
                                </div>
                                <div class="col-8">
                                    {{Form::text('version_code',$version->version_code,['class'=>'form-control','placeholder'=>'Add Version Code'])}}
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-4">
                                    {{ Form::label('version_description', 'Version Description')}}
                                </div>
                                <div class="col-8">
                                    {{Form::textarea('version_description',$version->version_description,['class'=>'form-control','placeholder'=>'Version Description'])}}
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

@endsection

@section('scripts')
    <script>
        CKEDITOR.replace("version_description", {
            tabSpaces: 5
        });
    </script>
@endsection
