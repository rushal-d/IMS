@extends('layouts.master')
@section('title','Alter Accounts')
@section('styles')

@endsection
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-xl-12">
                    <div class="card">
                        <div class="card-header">

                            <div class="card-header-actions">
                                <a href="{{route('alertEmails.create')}}" class="btn btn-sm btn-info">
                                    Add New <i class="nav-icon icon-plus"></i>
                                </a>

                                <a href="{{route('artisan.call','investment:alert')}}" class="btn btn-success btn-sm">Send
                                    Notification</a>
                            </div>
                            <div class="card-header-rights">

                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                <th>SN</th>
                                <th>Name</th>
                                <th>Organization Branch</th>
                                <th>Email</th>
                                <th>Mobile Number</th>
                                <th>Action</th>
                                </thead>
                                <tbody>
                                @foreach($alert_emails as $alertEmail)
                                    <tr>
                                        <td>{{$i++}}</td>
                                        <td>{{$alertEmail->name}}</td>
                                        <td>{{$alertEmail->organizationBranch->branch_name ?? "N/A"}}</td>
                                        <td>{{$alertEmail->email}}</td>
                                        <td>{{$alertEmail->mobile_number}}</td>
                                        <td>
                                            <a href="{{route('alertEmails.edit',$alertEmail->id)}}"
                                               class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a>
                                            <a href="javascript:void(0)"
                                               data-id="{{ $alertEmail->id }}"
                                               class="btn btn-danger btn-sm btndel">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{$alert_emails->appends($_GET)->links()}}
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
            var del_url = '{{ URL::to('alertEmails') }}/' + $(this).data('id');
            console.log(del_url);
            $('#firstform')[0].setAttribute('action', del_url);
            $('#deleteModal')
                .modal('show')
            ;
        });
    </script>
@endsection


