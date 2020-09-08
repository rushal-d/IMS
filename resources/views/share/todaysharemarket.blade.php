@extends('layouts.master')
@section('title','Today Share Market')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i>
                            Today's ShareMarket Closing Price ac to Nepse
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div id="printableArea" class="col-xl-12">
                                    <table class="table table-bordered table-responsive">
                                        <thead>
                                        <tr>
                                            <th>S.N</th>
                                            <th>Institution Name</th>
                                            <th>Closing Value</th>
                                            <th>Date</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $count =0 ; ?>
                                        @if(!empty($shares) or count($shares) > 0)
                                            @foreach($shares as $share)
                                                <tr>
                                                    <td>{{$count++}}</td>
                                                    <td>{{$share->organization_name}}</td>
                                                    <td>{{$share->closing_value}}</td>
                                                    <td>{{$share->created_at}}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr><td>No Data Found</td></tr>
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
@endsection

