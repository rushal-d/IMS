@extends('layouts.master')
@section('title','Roles')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i>
                        Role
                        <div class="card-header-actions">
                            <a class="btn btn-success btn-sm" href="{{route('role.create')}}">Add
                                New <i class="nav-icon icon-plus"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-content table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>SN</th>
                                <th>Name</th>
                                <th>Display Name</th>
                                <th>Description</th>
                            <th id="action-th">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if ($roles->count() > 0)
                                @foreach($roles as $role )
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $role->name or 'no data present' }}</td>
                                        <td>{{ $role->display_name or 'no data present' }}</td>
                                        <td>{{ $role->description or '-' }}</td>
                                        <td class="td-actions">
                                            <a type="button" rel="tooltip" title="Edit"
                                               href="{{ route('role.edit',$role->id) }}"
                                               class="btn btn-success btn-simple btn-sm ">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <a type="button" href="javascript:void(0)" data-id="{{ $role->id }}"
                                               class="btn btn-danger btn-sm btndel"><i class="fa fa-times"></i>
                                            </a>
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
    @include('layouts.deleteModal')
@endsection
@section('scripts')
    <script>
        $('.btndel').click(function(e){
            e.preventDefault();
            var del_url = '{{ URL::to('role') }}/'+$(this).data('id');
            console.log(del_url);
            $('#firstform')[0].setAttribute('action', del_url);
            $('#deleteModal')
                .modal('show')
            ;
        });
    </script>
@endsection