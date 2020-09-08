@extends('layouts.master')
@section('title','Investment Sectors')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i>
                            Investment Sectors
                            <div class="card-header-actions">
                                <a href="#" class="card-header-action btn-minimize" data-toggle="collapse" data-target="#collapseExamples" aria-expanded="true">
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-4">
                                    <div class="card">
                                        <div class="card-header">
                                            Investment Sector
                                        </div>
                                        {{--this might need in future--}}
                                        {{--<form id="maindiv" method="post" action="{{route('investmenttype.store')}}">--}}
                                            {{--@csrf--}}
                                            {{--<div class="form-group row">--}}
                                                {{--<label for="start_date" class="col-sm-3 col-form-label"><sup class="required-field">*</sup>Name</label>--}}
                                                {{--<div class="col-sm-8">--}}
                                                    {{--<input type="text" class="form-control nep-date" id="name" name="name"--}}
                                                           {{--value="{{ old('name') }}" >--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                            {{--<div class="form-group row">--}}
                                                {{--<label for="end_date" class="col-sm-3 col-form-label">Description</label>--}}
                                                {{--<div class="col-sm-8">--}}
                                                    {{--<input type="text" class="form-control nep-date" id="end_date" name="description"                                                       value="{{ old('description') }}">--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                            {{--<div style="text-align: center">--}}
                                                {{--<button type="submit" class="btn btn-primary">Submit</button>--}}
                                                {{--<button type="reset" class="btn btn-outline-secondary" value="Reset">Clear</button>--}}
                                            {{--</div>--}}
                                        {{--</form>--}}
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Description</th>
                                                <th>Sub Sectors</th>
                                                {{--<th>Action</th>--}}
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($investmenttypes as $investmenttype)
                                            <tr>
                                                <td>{{$investmenttype->name}}</td>
                                                <td>{{$investmenttype->description or '-'}}</td>
                                                <td>
                                                @if(!empty($investmenttype->investment_subtype))
                                                    <ul>
                                                        @foreach($investmenttype->investment_subtype as $invest)
                                                           <li>{{$invest->name}}</li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                                </td>
                                                {{--this might need in future--}}
                                                {{--<td class="td-actions">--}}
                                                    {{--<a href="{{route('investmenttype.edit',$investmenttype->id)}}" class="btn btn-success btn-sm">--}}
                                                        {{--<i class="fa fa-edit"></i>Edit</a>--}}
                                                    {{--<a href="javascript:void(0)" data-id="{{ $investmenttype->id }}" class="btn btn-danger btn-sm btndel">--}}
                                                        {{--<i class="fa fa-times"></i>Delete--}}
                                                    {{--</a>--}}
                                                {{--</td>--}}
                                            </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-xl-8">
                                    <div class="card">
                                        <div class="card-header">
                                            Investment Sub Sectors
                                        </div>
                                        <form id="maindiv" method="post" action="{{route('investmentsubtype.store')}}">
                                            @csrf
                                            <div class="form-group row">
                                                <label for="start_date" class="col-sm-3 col-form-label"><sup class="required-field">*</sup>Name </label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="name" name="name" data-validation="required">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="description" class="col-sm-3 col-form-label">Description</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="description" name="description"                                                       value="{{ old('description') }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="start_date" class="col-sm-3 col-form-label"><sup class="required-field">*</sup>Code </label>
                                                <div class="col-sm-8">
                                                    <input type="number" min="0" class="form-control" id="code" value="{{$code}}" name="code" readonly
                                                           data-validation="required">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="code" class="col-sm-3 col-form-label"><sup class="required-field">*</sup>Investment Type</label>
                                                <div class="col-sm-8">
                                                    <select name="invest_type_id" id="invest_type_id" class="form-control" data-validation="required">
                                                        <option value="">Select</option>
                                                        @foreach($investmenttypes as $investmenttype)
                                                            <option value="{{$investmenttype->id}}">{{$investmenttype->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="percentage"
                                                       class="col-sm-3 col-form-label">Percentage</label>
                                                <div class="col-sm-8">
                                                    <input type="number" min="0" max="100" step="0.01"
                                                           class="form-control"
                                                           id="percentage" name="percentage"
                                                           value="{{ old('percentage') }}">
                                                </div>
                                            </div>
                                            <div style="text-align: center">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                                <button type="reset" class="btn btn-outline-secondary" value="Reset">Clear</button>
                                            </div>
                                        </form>
                                        <table class="table table-striped">
                                            <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Description</th>
                                                <th>Percentage</th>
                                                <th>Code</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($investmentsubtypes as $investmentsubtype)
                                                <tr>
                                                    <td>{{$investmentsubtype->name}}</td>
                                                    <td>{{$investmentsubtype->description or '-'}}</td>
                                                    <td>{{$investmentsubtype->percentage}} %</td>
                                                    <td>{{$investmentsubtype->code}}</td>
                                                    <td class="td-actions">
                                                        <a href="{{route('investmentsubtype.edit',$investmentsubtype->id)}}" class="btn btn-success btn-sm">
                                                            <i class="fa fa-edit"></i>Edit</a>
                                                        <a href="javascript:void(0)" data-id="{{ $investmentsubtype->id }}" class="btn btn-danger btn-sm btndel1">
                                                            <i class="fa fa-times"></i>Delete
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.deleteModal')
@endsection
@section('scripts')
    <script>
        $('.btndel').click(function(e){
            e.preventDefault();
            var del_url = '{{ URL::to('investmenttype') }}/'+$(this).data('id');
            console.log(del_url);
            $('#firstform')[0].setAttribute('action', del_url);
            $('#deleteModal')
                .modal('show')
            ;
        });

        $('.btndel1').click(function(e){
            e.preventDefault();
            var del_url = '{{ URL::to('investmentsubtype') }}/'+$(this).data('id');
            console.log(del_url);
            $('#firstform')[0].setAttribute('action', del_url);
            $('#deleteModal')
                .modal('show')
            ;
        });
    </script>
@endsection
