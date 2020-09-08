@extends('layouts.master')
@section('title','Investment Institute')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12 col-md-4 col-xl-4">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i>
                            Investment Institute - {{$investmentinstitution->invest_type->name}} Update
                            <div class="card-header-actions">
                                <a href="#" class="card-header-action btn-minimize" data-toggle="collapse" data-target="#collapseExamples" aria-expanded="true">
                                    <i class="icon-arrow-up"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-12">
                                    <form id="maindiv" method="post"
                                          action="{{route('investmentinstitution.update',$investmentinstitution->id)}}"
                                          enctype="multipart/form-data">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="invest_type_id" value="{{$investmentinstitution->invest_type_id}}">
                                        <div class="form-group row">
                                            <label for="start_date" class="col-sm-3 col-form-label"><sup class="required-field">*</sup>Organization Name</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="institution_name" name="institution_name"
                                                       value="{{ $investmentinstitution->institution_name }}" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="institution_code" class="col-sm-3 col-form-label"><sup class="required-field">*</sup>Code</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="institution_code" name="institution_code"
                                                       value="{{ $investmentinstitution->institution_code }}" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="description" class="col-sm-3 col-form-label">Description</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="description" name="description"
                                                       value="{{ $investmentinstitution->description }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="invest_group_id" class="col-sm-3 col-form-label"><sup class="required-field">*</sup>Organization Group</label>
                                            <div class="col-sm-9">
                                                <select name="invest_group_id" id="invest_group_id" class="form-control" required>
                                                    <option value="">Select</option>
                                                    @foreach($all_groups as $group)
                                                        <option value="{{$group->id}}"
                                                        @if($group->id == $investmentinstitution->invest_group_id)
                                                            selected
                                                        @endif>{{$group->group_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="invest_subtype_id" class="col-sm-3 col-form-label"><sup class="required-field">*</sup>Organization Group</label>
                                            <div class="col-sm-9">
                                                {!! Form::select('invest_subtype_id', $all_sectors->pluck('name', 'id'), $investmentinstitution->invest_subtype_id, ['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="invest_group_id" class="col-sm-3 col-form-label"><sup
                                                        class="required-field">*</sup>Is Listed Organization?</label>
                                            <div class="col-sm-9">
                                                {!! Form::select('is_listed',['No','Yes'],old('is_listed',$investmentinstitution->is_listed),['class'=>'form-control','data-validation'=>'required']) !!}
                                            </div>
                                        </div>
                                        <div style="text-align: center">
                                            <button type="submit" class="btn btn-primary">
                                                Update
                                            </button>
                                            <button type="reset" class="btn btn-outline-secondary" value="Reset">Clear</button>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>

                    </div>
                </div> <div class="col-sm-12 col-md-8 col-xl-8">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i>
                            Investment Institute - {{$investmentinstitution->invest_type->name}} Update
                            <div class="card-header-actions">
                                <a href="#" class="card-header-action btn-minimize" data-toggle="collapse" data-target="#collapseExamples" aria-expanded="true">
                                    <i class="icon-arrow-up"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-12">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>Organization Name</th>
                                            <th>Organization Code</th>
                                            <th>Description</th>
                                            <th>Group Name</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(!empty($investmentinstitutes))
                                            @foreach($investmentinstitutes as $investmentinstitution)
                                                <tr>
                                                    <td>{{$investmentinstitution->institution_name}}</td>
                                                    <td>{{$investmentinstitution->institution_code}}</td>
                                                    <td>{{$investmentinstitution->description}}</td>
                                                    <td>{{$investmentinstitution->invest_group->group_name ?? 'N/A'}}</td>
                                                    <td class="td-actions">
                                                        <a href="{{route('investmentinstitution.edit',$investmentinstitution->id)}}" class="btn btn-success btn-sm"><i class="fa fa-edit"></i>Edit</a>
                                                        <a href="javascript:void(0)" data-id="{{ $investmentinstitution->id }}" class="btn btn-danger btn-sm btndel">
                                                            <i class="fa fa-times"></i>Delete
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
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

        $('.btndel').click(function(e){
            e.preventDefault();
            var del_url = '{{ URL::to('investmentinstitution') }}/'+$(this).data('id');
            console.log(del_url);
            $('#firstform')[0].setAttribute('action', del_url);
            $('#deleteModal')
                .modal('show')
            ;
        });
    </script>
@endsection
