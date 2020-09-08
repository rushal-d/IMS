@extends('layouts.master')
@section('title','Users')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" data-background-color="custom-color">
                        <i class="fa fa-align-justify"></i>
                        Users
                        <div class="card-header-actions">
                            <a class="btn btn-success btn-sm" href="{{route('user.create')}}">Add
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
                            <th>Email</th>
                            <th>Role</th>
                            <th id="action-th">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if ($users->count() > 0)
                                @foreach($users as $user )
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $user->name or 'no data present' }}</td>
                                        <td>{{ $user->email or 'no data present' }}</td>
                                        <td>@foreach($user->roles as $r) [{{$r->name}}] @endforeach </td>
                                        <td class="td-actions">
                                            {{--<a type="button" rel="tooltip" title="View"--}}
                                               {{--class="btn btn-info btn-simple btn-lg "--}}
                                               {{--href="{{ route('userdetail',$user->id) }}">--}}
                                                {{--<i class="fas fa-eye"></i>--}}
                                            {{--</a>--}}

                                            @if($user->id == Auth::user()->id)
                                            <a type="button" rel="tooltip" title="Edit"
                                               href="{{ route('user.edit',$user->id) }}"
                                               class="btn btn-success btn-simple btn-sm ">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            @else
                                                @role('administrator')
                                                <a type="button" rel="tooltip" title="Edit"
                                                   href="{{ route('user.edit',$user->id) }}"
                                                   class="btn btn-success btn-simple btn-sm ">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                @endrole
                                            @endif
                                            @role('administrator')
                                            <a type="button" href="javascript:void(0)" data-id="{{ $user->id }}"
                                               class="btn btn-danger btn-sm btndel"><i class="fa fa-times"></i>
                                            </a>
                                            @endrole
                                            {{--@role('administrator')--}}
                                            {{--<a type="button" href="{{route('user-change-password',$user->id)}}"--}}
                                               {{--rel="tooltip" title="Change Password"--}}
                                               {{--class="btn btn-danger btn-simple btn-lg"> <i class="fa fa-edit"></i></a>--}}
                                            {{--@endrole--}}
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
            var del_url = '{{ URL::to('user') }}/'+$(this).data('id');
            console.log(del_url);
            $('#firstform')[0].setAttribute('action', del_url);
            $('#deleteModal')
                .modal('show')
            ;
        });
    </script>
@endsection