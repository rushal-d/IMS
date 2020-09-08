@extends('layouts.master')
@section('title','Deposit Column Select')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i>
                            Deposit Column Select
                        </div>
                        <div class="card-body">
                            <form action="{{route('depsit-excel-export-column-save')}}" method="POST">
                                @csrf
                                <div class="row">
                                    @foreach($depositExcelFields as $key=> $depositExcelField)
                                        <div class="col-2">
                                            <label>{{$depositExcelField}}</label>
                                            <input type="checkbox" value="{{$key}}" multiple
                                                   name="fieldSelected[]" {{in_array($key,$depositExcelSelected) ? 'checked':''}}>
                                        </div>
                                    @endforeach

                                    <div class="col-12">
                                        <div class="text-center form-group">
                                            <button class="btn btn-success">Save</button>
                                        </div>
                                    </div>
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

@endsection
