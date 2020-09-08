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
                                <div class="col-xl-5">
                                    <div class="card">
                                        <form id="maindiv" method="post"
                                              action="{{route('investmentgroup.update', $investmentgroup->id)}}">
                                            @csrf
                                            @method('PATCH')
                                            <div class="form-group row">
                                                <label for="start_date" class="col-sm-3 col-form-label"><sup
                                                            class="required-field">*</sup>Group Name</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="group_name"
                                                           name="group_name"
                                                           value="{{$investmentgroup->group_name}}">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="start_date" class="col-sm-3 col-form-label"><sup
                                                            class="required-field">*</sup>Group Code</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="group_code"
                                                           name="group_code"
                                                           value="{{$investmentgroup->group_code}}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="description"
                                                       class="col-sm-3 col-form-label">Description</label>
                                                <div class="col-sm-8">
                                                    <textarea type="text" class="form-control" id="description"
                                                              name="description"
                                                              rows="3">{{$investmentgroup->description}}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="percentage"
                                                       class="col-sm-3 col-form-label">Percentage</label>
                                                <div class="col-sm-8">
                                                    <input type="number" min="0" max="100" class="form-control"
                                                           id="percentage" value="{{$investmentgroup->percentage}}"
                                                           name="percentage">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="invest_type_id" class="col-sm-3 col-form-label"><sup
                                                            class="required-field">*</sup>Investment Type</label>
                                                <div class="col-sm-8">
                                                    <select name="invest_type_id" id="invest_type_id"
                                                            class="form-control" required>
                                                        <option value="null">Select</option>
                                                        @foreach($investmenttypes as $investmenttype)
                                                            <option value="{{$investmenttype->id}}"
                                                                    @if($investmenttype->id == $investmentgroup->invest_type->id)
                                                                    selected @endif>{{$investmenttype->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="parent_id" class="col-sm-3 col-form-label">Group
                                                    Parent</label>
                                                <div class="col-sm-8">
                                                    <select name="parent_id" id="parent_id" class="form-control">
                                                        <option value="">Select</option>
                                                        @if(!empty($group_parents))
                                                            @foreach($group_parents as $group_parent)
                                                                <option value="{{$group_parent->id}}"
                                                                        @if($investmentgroup->parent_id != null)
                                                                        @if($group_parent->id == $investmentgroup->parent->id)
                                                                        selected
                                                                        @endif
                                                                        @endif
                                                                >{{$group_parent->group_name}}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>



                                            <div class="form-group row">
                                                <label for="parent_id" class="col-sm-3 col-form-label">Status</label>
                                                <div class="col-sm-8">
                                                    {{Form::select('enable',['Disable','Enable'],$investmentgroup->enable,['class'=>'form-control'])}}
                                                </div>
                                            </div>
                                            <div style="text-align: center">
                                                <button type="submit" class="btn btn-primary">Update</button>
                                                <button type="reset" class="btn btn-outline-secondary" value="Reset">
                                                    Clear
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-xl-7">
                                    <div class="">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>Group Name</th>
                                                <th>Description</th>
                                                <th>Percentage</th>
                                                <th>Investment Type</th>
                                                <th>Parent</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if(!empty($investmentgroups) or count($investmentgroups) > 0)
                                                @foreach($investmentgroups as $investmentgroup)
                                                    <tr>
                                                        <td>{{$investmentgroup->group_name}}</td>
                                                        <td>{{$investmentgroup->description or 'NA'}}</td>
                                                        <td>{{$investmentgroup->percentage}} %</td>
                                                        <td>{{$investmentgroup->invest_type->name}}</td>
                                                        <td>@if($investmentgroup->parent_id == null)
                                                                NA @else {{$investmentgroup->parent->group_name ?? 'NA'}}@endif </td>
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
                                                                <td>{{$investmentgroup->description or 'NA'}}</td>
                                                                <td>{{$investmentgroup->percentage}}%</td>
                                                                <td>{{$investmentgroup->invest_type->name}}</td>
                                                                <td>@if($investmentgroup->parent_id == null) NA
                                                                    @else {{$investmentgroup->parent->group_name or 'NA'}}
                                                                    @endif
                                                                </td>
                                                                <td class="td-actions">
                                                                    <a href="{{route('investmentgroup.edit',$investmentgroup->id)}}"
                                                                       class="btn btn-success btn-sm"><i
                                                                                class="fa fa-edit"></i>Edit</a>
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
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"><i class="far fa-trash-alt"></i> Confirm Delete</h4>
                </div>
                <form id="firstform" action="" method="post">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        Are you Sure You Want To Delete ?
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary modal-delete">Yes
                        </button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
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
