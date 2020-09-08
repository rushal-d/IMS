@extends('layouts.master')
@section('title',' Organization Branch Branch')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-xl-4">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i>
                            Organization Branch
                            <div class="card-header-actions">
                                <a href="#" class="card-header-action btn-minimize" data-toggle="collapse"
                                   data-target="#collapseExamples" aria-expanded="true">
                                    <i class="icon-arrow-up"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-12">

                                    <form id="maindiv" method="post"
                                          action="{{route('organizationbranch.update',$organization_branch->id)}}">
                                        {{method_field('PATCH')}}
                                        @csrf
                                        <div class="row">
                                            <label for="start_date" class="col-sm-4 col-form-label"><sup
                                                        class="required-field">*</sup>Branch</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="branch_name"
                                                       name="branch_name"
                                                       value="{{ old('branch_name',$organization_branch->branch_name) }}"
                                                       data-validation="required">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <label for="start_date" class="col-sm-4 col-form-label"><sup
                                                        class="required-field">*</sup>Branch Code</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="branch_code"
                                                       name="branch_code"
                                                       value="{{ old('branch_code', $organization_branch->branch_code) }}"
                                                       data-validation="required">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="description" class="col-sm-4 col-form-label">Description</label>
                                            <div class="col-sm-8">
                                                    <textarea type="text" class="form-control" id="description"
                                                              name="description"
                                                              rows="3">{{$organization_branch->description}}</textarea>
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
                <div class="col-sm-12 col-md-12 col-xl-8">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i>
                            Organization Branches
                            <div class="card-header-actions">
                                <a href="#" class="card-header-action btn-minimize" data-toggle="collapse"
                                   data-target="#collapseExamples" aria-expanded="true">
                                    <i class="icon-arrow-up"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-12">
                                    <table class="table table-bordered">
                                        <thead>
                                        <th>SN</th>
                                        <th>Branch</th>
                                        <th>Code</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                        </thead>
                                        <tbody>
                                        @foreach($organization_branches as $organization_branch)
                                            <tr>
                                                <td>{{$i++}}</td>
                                                <td>{{$organization_branch->branch_name}}</td>
                                                <td>{{$organization_branch->branch_code}}</td>
                                                <td>{{$organization_branch->description}}</td>
                                                <td class="td-actions">
                                                    <a href="{{route('organizationbranch.edit',$organization_branch->id)}}"
                                                       class="btn btn-success btn-sm"><i class="fa fa-edit"></i>Edit</a>
                                                    <a href="javascript:void(0)"
                                                       data-id="{{ $organization_branch->id }}"
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
            var del_url = '{{ URL::to('organizationbranch') }}/' + $(this).data('id');
            console.log(del_url);
            $('#firstform')[0].setAttribute('action', del_url);
            $('#deleteModal')
                .modal('show')
            ;
        });

    </script>
@endsection
