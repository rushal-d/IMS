@extends('layouts.master')
@section('title','Permissions')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" data-background-color="custom-color">
                        <i class="fa fa-align-justify"></i>
                        Permission
                        <div class="card-header-actions">
                            <a class="btn btn-success btn-sm" href="{{route('permission.create')}}">
                                Reload Permission<i class="nav-icon icon-plus"></i>
                            </a>

                            <a class="btn btn-primary btn-sm" href="javascript:void(0);" id="send-permission-to-kb"><i
                                        class="fa fa-upload"></i>
                                Send Permission to KB
                            </a>

                            <a class="btn btn-danger btn-sm" href="javascript:void(0);" id="get-permission-from-kb"><i
                                        class="fa fa-download"></i>
                                Download Permission From KB
                            </a>
                        </div>
                    </div>
                    <div class="card-content table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>SN</th>
                                <th>Name</th>
                                <th>URI</th>
                                <th>Parent ID</th>
                                <th>Order</th>
                                <th>Icon</th>
                                <th id="action-th">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if ($permissions->count() > 0)
                                @foreach($permissions as $permission )
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $permission->name or 'no data present' }}</td>
                                        <td>{{ $permission->uri or 'no data present' }}</td>
                                        <td>{{ $permission->parents->name or '-' }}</td>
                                        <td>{{ $permission->order or 'no data present' }}</td>
                                        <td>{{ $permission->icon or 'no data present' }}</td>
                                        <td class="td-actions">
                                            <a type="button" rel="tooltip" title="Edit"
                                               href="{{ route('permission.edit',$permission->id) }}"
                                               class="btn btn-success btn-simple btn-sm">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <button type="button" rel="tooltip" title="Delete"
                                                    class="btn btn-danger btn-simple btn-sm deleteRecord"
                                                    data-toggle="modal" data-target="#deleteModal"
                                                    data-id="{{ $permission->id }}"
                                                    data-token="{{ csrf_token() }}">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5">No Data Found</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="alertDialog" tabindex="-1" role="dialog" aria-labelledby="alertDialogLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="alertDialog-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="alertDialog-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')

    <script>
        $('#send-permission-to-kb').click(function () {
            $.ajax({
                url: '{{route('send-permission-to-kb')}}',
                success: function (response) {
                    if (response) {
                        $('#alertDialog-title').text('Response !')
                        $('#alertDialog-body').text(response)
                        $('#alertDialog').modal();
                    } else {
                        $('#alertDialog-title').text('Response !')
                        $('#alertDialog-body').text(response)
                        $('#alertDialog').modal();
                    }
                }
            })
        });

        $('#get-permission-from-kb').click(function () {
            $.ajax({
                url: '{{route('get-permission-from-kb')}}',
                success: function (response) {
                    if (response) {
                        $('#alertDialog-title').text('Response!')
                        $('#alertDialog-body').text(response)
                        $('#alertDialog').modal();
                    } else {
                        $('#alertDialog-title').text('Response!')
                        $('#alertDialog-body').text(response)
                        $('#alertDialog').modal();
                    }
                }
            })
        });
    </script>
@endsection