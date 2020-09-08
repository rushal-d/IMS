@extends('layouts.master')
@section('title',' Bank Branch')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">

            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i>
                    Bank Branch
                    <div class="card-header-actions">
                        <a href="#" class="card-header-action btn-minimize" data-toggle="collapse"
                           data-target="#collapseExamples" aria-expanded="true">
                            <i class="icon-arrow-up"></i>
                        </a>
                    </div>

                    <div class="card-header-rights">
                        <button class="excelimport btn btn-sm btn-success">
                            Import from Excel <i class="far fa-file-excel"></i>
                            <form action="{{route('bankbranch.import')}}" method="post"
                                  enctype="multipart/form-data" id="import_form">
                                @csrf
                                <input type="file" id="bankbranch_excel" name="bankbranch_excel"
                                       hidden>
                            </form>
                        </button>


                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-4">
                            <div class="card">
                                <form id="maindiv" method="post" action="{{route('bankbranch.store')}}">
                                    @csrf
                                    <div class="form-group row">
                                        <label for="start_date" class="col-sm-4 col-form-label"><sup
                                                    class="required-field">*</sup>Branch Name</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="branch_name" name="branch_name"
                                                   value="{{ old('branch_name') }}" data-validation="required">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="description" class="col-sm-4 col-form-label">Description</label>
                                        <div class="col-sm-8">
                                                    <textarea type="text" class="form-control" id="description"
                                                              name="description"
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
                        <div class="col-xl-8">
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
                                                <td>{{$bankbranch->branch_name}}({{$bankbranch->depositBankB1->count()}})({{$bankbranch->depositBankB2->count()}})</td>
                                                <td>{{$bankbranch->description or 'NA'}}</td>
                                                <td class="td-actions">
                                                    <a href="{{route('bankbranch.edit',$bankbranch->id)}}"
                                                       class="btn btn-success btn-sm"><i class="fa fa-edit"></i>Edit</a>
                                                    <a href="javascript:void(0)" data-id="{{ $bankbranch->id }}"
                                                       class="btn btn-danger btn-sm btndel">
                                                        <i class="fa fa-times"></i>Delete
                                                    </a>
                                                </td>
                                            </tr>
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
    @include('layouts.deleteModal')
@endsection
@section('scripts')
    <script>
        $('.btndel').click(function (e) {
            e.preventDefault();
            var del_url = '{{ URL::to('bankbranch') }}/' + $(this).data('id');
            console.log(del_url);
            $('#firstform')[0].setAttribute('action', del_url);
            $('#deleteModal')
                .modal('show')
            ;
        });

    </script>
    <script>
        $('.excelimport').click(function () {
            openDialog();
        });

        function openDialog() {
            document.getElementById('bankbranch_excel').click();
        }

        $('#bankbranch_excel').change(function () {
            $("#import_form").submit();
        })
    </script>
@endsection
