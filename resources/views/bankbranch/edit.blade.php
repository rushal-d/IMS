@extends('layouts.master')
@section('title',' Bank Branch Edit')
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
                                <a href="#" class="card-header-action btn-minimize" data-toggle="collapse" data-target="#collapseExamples" aria-expanded="true">
                                    <i class="icon-arrow-up"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-5">
                                    <div class="card">
                                        <form id="maindiv" method="post" action="{{route('bankbranch.update', $bankbranch->id)}}">
                                            @csrf
                                            @method('PATCH')
                                            <div class="form-group row">
                                                <label for="start_date" class="col-sm-3 col-form-label"><sup class="required-field">*</sup>Branch Name</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="branch_name" name="branch_name"
                                                           value="{{$bankbranch->branch_name}}" >
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="description" class="col-sm-3 col-form-label">Description</label>
                                                <div class="col-sm-8">
                                                    <textarea type="text" class="form-control" id="description" name="description"
                                                              rows="3">{{$bankbranch->description}}</textarea>
                                                </div>
                                            </div>
                                            <div style="text-align: center">
                                                <button type="submit" class="btn btn-primary">Update</button>
                                                <button type="reset" class="btn btn-outline-secondary" value="Reset">Clear</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-xl-7">
                                    <div class="">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>S.N</th>
                                                <th>Branch Name</th>
                                                <th>Description</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $count = 1 ?>
                                            @if(!empty($bankbranches) or count($bankbranches) > 0)
                                                @foreach($bankbranches as $bankbranch)
                                                    <tr>
                                                        <td>{{$count ++}}</td>
                                                        <td>{{$bankbranch->branch_name}}</td>
                                                        <td>{{$bankbranch->description or 'NA'}}</td>
                                                        <td class="td-actions">
                                                            <a href="{{route('bankbranch.edit',$bankbranch->id)}}" class="btn btn-success btn-sm"><i class="fa fa-edit"></i>Edit</a>
                                                            <a href="javascript:void(0)" data-id="{{ $bankbranch->id }}" class="btn btn-danger btn-sm btndel">
                                                                <i class="fa fa-times"></i>Delete
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr><td>No Data Available</td></tr>
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
        $('.btndel').click(function(e){
            e.preventDefault();
            var del_url = '{{ URL::to('bankbranch') }}/'+$(this).data('id');
            console.log(del_url);
            $('#firstform')[0].setAttribute('action', del_url);
            $('#deleteModal')
                .modal('show')
            ;
        });

    </script>
@endsection
