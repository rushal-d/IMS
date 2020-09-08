@extends('layouts.master')
@section('title','Documentations')
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
                                <a href="{{route('documentation.create')}}" class="btn btn-sm btn-info">
                                    Add New Document <i class="nav-icon icon-plus"></i>
                                </a>
                            </div>
                            <div class="card-header-rights">

                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                <th>SN</th>
                                <th>Document Title</th>
                                <th>Download</th>
                                <th>Action</th>
                                </thead>
                                <tbody>
                                @foreach($documentations as $documentatation)
                                    <tr>
                                        <td>{{$i++}}</td>
                                        <td>{{$documentatation->title}}</td>
                                        <td>
                                            <a href="{{asset('documents/'.$documentatation->filename)}}" target="_blank"><i class="fa fa-download" aria-hidden="true"></i>
                                            </a>

                                        <td>
                                            <a href="{{route('documentation.edit',$documentatation->id)}}"
                                               class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a>
                                            <a href="javascript:void(0)"
                                               data-id="{{ $documentatation->id }}"
                                               class="btn btn-danger btn-sm btndel">
                                                <i class="fa fa-times"></i>
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
    @include('layouts.deleteModal')

@endsection


