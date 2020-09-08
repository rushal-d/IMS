@extends('layouts.master')
@section('title','Version Change Log')
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
                                <a href="{{route('version-change-log.create')}}" class="btn btn-sm btn-info">
                                    Add New Version <i class="nav-icon icon-plus"></i>
                                </a>
                            </div>
                            <div class="card-header-rights">

                            </div>
                        </div>
                        <div class="card-body">

                            @foreach($versions as $version)

                                <p><b>{{$version->version_code}}</b></p>
                                <div>
                                {!! $version->version_description !!}

                                <td>

                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.deleteModal')

@endsection


