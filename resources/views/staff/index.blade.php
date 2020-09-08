@extends('layouts.master')
@section('title',' Staff')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-xl-5">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i>
                            Staff
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-12">
                                    <form id="maindiv" method="post" action="{{route('staff.store')}}">
                                        @csrf
                                        <div class="form-group row">
                                            <label for="start_date" class="col-sm-4 col-form-label"><sup
                                                        class="required-field">*</sup>Staff Name</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="name"
                                                       name="name"
                                                       value="{{ old('name') }}" data-validation="required">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="start_date" class="col-sm-4 col-form-label"><sup
                                                        class="required-field">*</sup>Branch</label>
                                            <div class="col-sm-8">
                                                {{Form::select('organization_branch_id',$branches,null,array('class'=>'form-control','id'=>'branch_id','required'=>'required'))}}
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="start_date" class="col-sm-4 col-form-label">Position</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="position"
                                                       name="position"
                                                       value="{{ old('position') }}" data-validation="required">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="description" class="col-sm-4 col-form-label">Notes</label>
                                            <div class="col-sm-8">
                                                    <textarea type="text" class="form-control" id="note"
                                                              name="note"
                                                              rows="3"></textarea>
                                            </div>
                                        </div>
                                        <div style="text-align: center">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                            <button type="reset" class="btn btn-outline-secondary" value="Reset">Clear
                                            </button>
                                        </div>
                                    </form>
                                </div>


                            </div>
                        </div>
                    </div>


                </div>
                <div class="col-sm-12 col-md-12 col-xl-7">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i>
                            Staffs

                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-12">
                                    <table class="table table-bordered">
                                        <thead>
                                        <th>SN</th>
                                        <th>Name</th>
                                        <th>Branch</th>
                                        <th>Action</th>
                                        </thead>
                                        <tbody>
                                        @foreach($staffs as $staff)
                                            <tr>
                                                <td>{{$i++}}</td>
                                                <td>{{$staff->name}}</td>
                                                <td>{{$staff->organizationBranch->branch_name}}</td>
                                                <td class="td-actions">
                                                    <a href="{{route('staff.show',$staff->id)}}"
                                                       class="btn btn-info btn-sm"><i class="fa fa-eye"></i>Show</a>

                                                    <a href="{{route('staff.edit',$staff->id)}}"
                                                       class="btn btn-success btn-sm"><i class="fa fa-edit"></i>Edit</a>
                                                    <a href="javascript:void(0)"
                                                       data-id="{{ $staff->id }}"
                                                       class="btn btn-danger btn-sm btndel">
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
    @include('layouts.deleteModal')
@endsection
@section('scripts')
    <script>
        $('.btndel').click(function (e) {
            e.preventDefault();
            var del_url = '{{ URL::to('staff') }}/' + $(this).data('id');
            console.log(del_url);
            $('#firstform')[0].setAttribute('action', del_url);
            $('#deleteModal')
                .modal('show')
            ;
        });

    </script>


@endsection
