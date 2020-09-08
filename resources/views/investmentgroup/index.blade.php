@extends('layouts.master')
@section('title',' Investment Group')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i>
                            Investment Group
                            <div class="card-header-actions">
                                <a href="#" class="card-header-action btn-minimize" data-toggle="collapse"
                                   data-target="#collapseExamples" aria-expanded="true">
                                    <i class="icon-arrow-up"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-4">
                                    <div class="card">
                                        <form id="maindiv" method="post" action="{{route('investmentgroup.store')}}">
                                            @csrf
                                            <div class="form-group row">
                                                <label for="start_date" class="col-sm-4 col-form-label"><sup
                                                            class="required-field">*</sup>Group Name</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="group_name"
                                                           name="group_name"
                                                           value="{{ old('group_name') }}" data-validation="required">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="start_date" class="col-sm-4 col-form-label"><sup
                                                            class="required-field">*</sup>Group Code</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="group_code"
                                                           name="group_code"
                                                           value="{{ old('group_code') }}" data-validation="required">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="description"
                                                       class="col-sm-4 col-form-label">Description</label>
                                                <div class="col-sm-8">
                                                    <textarea type="text" class="form-control" id="description"
                                                              name="description"
                                                              rows="3"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="percentage"
                                                       class="col-sm-4 col-form-label">Percentage</label>
                                                <div class="col-sm-8">
                                                    <input type="number" min="0" max="100" step="0.01"
                                                           class="form-control"
                                                           id="percentage" name="percentage"
                                                           value="{{ old('description') }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="invest_type_id" class="col-sm-4 col-form-label"><sup
                                                            class="required-field">*</sup>Investment Type</label>
                                                <div class="col-sm-8">
                                                    <select name="invest_type_id" id="invest_type_id"
                                                            class="form-control" data-validation="required">
                                                        <option value="">Select</option>
                                                        @foreach($investmenttypes as $investmenttype)
                                                            <option value="{{$investmenttype->id}}">{{$investmenttype->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="parent_id" class="col-sm-4 col-form-label">Group
                                                    Parent</label>
                                                <div class="col-sm-8">
                                                    <select name="parent_id" id="parent_id" class="form-control">
                                                        <option value="">Select</option>
                                                        @if(!empty($group_parents))
                                                            @foreach($group_parents as $group_parent)
                                                                <option value="{{$group_parent->id}}">{{$group_parent->group_name}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="parent_id" class="col-sm-4 col-form-label">Status</label>
                                                <div class="col-sm-8">
                                                    {{Form::select('enable',['Disable','Enable'],null,['class'=>'form-control'])}}
                                                </div>
                                            </div>

                                            <div style="text-align: center">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                                <button type="reset" class="btn btn-outline-secondary" value="Reset">
                                                    Clear
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-xl-8">
                                    <div class="">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>Group Name</th>
                                                <th>Group Code</th>
                                                <th>Description</th>
                                                <th>Percentage</th>
                                                <th>Investment Type</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if(!empty($investmentgroups) or count($investmentgroups) > 0)
                                                @foreach($investmentgroups as $investmentgroup)
                                                    <tr>
                                                        <td>{{$investmentgroup->group_name}}</td>
                                                        <td>{{$investmentgroup->group_code}}</td>
                                                        <td>{{$investmentgroup->description or 'NA'}}</td>
                                                        <td>{{$investmentgroup->percentage}}%</td>
                                                        <td>{{$investmentgroup->invest_type->name}}</td>

                                                        <td class="td-actions">
                                                            <a href="{{route('investmentgroup.edit',$investmentgroup->id)}}"
                                                               class="btn btn-success btn-sm"><i class="fa fa-edit"></i>Edit</a>
                                                            <a href="javascript:void(0)"
                                                               data-id="{{ $investmentgroup->id }}"
                                                               class="btn btn-danger btn-sm btndel">
                                                                <i class="fa fa-times"></i>Delete
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    @if(($investmentgroup->child->count())>0)
                                                        @foreach($investmentgroup->child as $investmentgroup)
                                                            <tr>
                                                                <td>{{$investmentgroup->group_name}}</td>
                                                                <td>{{$investmentgroup->group_code}} </td>
                                                                <td>{{$investmentgroup->description or 'NA'}}</td>
                                                                <td>{{$investmentgroup->percentage}}%</td>
                                                                <td>{{$investmentgroup->invest_type->name}}</td>

                                                                <td class="td-actions">
                                                                    <a href="{{route('investmentgroup.edit',$investmentgroup->id)}}"
                                                                       class="btn btn-success btn-sm"><i class="fa fa-edit"></i>Edit</a>
                                                                    <a href="javascript:void(0)"
                                                                       data-id="{{ $investmentgroup->id }}"
                                                                       class="btn btn-danger btn-sm btndel">
                                                                        <i class="fa fa-times"></i>Delete
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td>No Data Available</td>
                                                </tr>
                                            @endif
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
        $('.btndel').click(function (e) {
            e.preventDefault();
            var del_url = '{{ URL::to('investmentgroup') }}/' + $(this).data('id');
            console.log(del_url);
            $('#firstform')[0].setAttribute('action', del_url);
            $('#deleteModal')
                .modal('show')
            ;
        });

    </script>
@endsection
