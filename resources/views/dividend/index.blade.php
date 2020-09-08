@extends('layouts.master')
@section('title','Dividends')
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
                                <a href="{{route('dividend.create')}}" class="btn btn-sm btn-info">
                                    Add New Diviend <i class="nav-icon icon-plus"></i>
                                </a>
                            </div>
                            <div class="card-header-rights">
                                <i class="fas fa-chart-line"></i> Total: {{ $dividends->total() ?? '' }}
                            </div>
                        </div>
                        <div class="card-body">
                           <div class="freezeHeaderTableContainer">
                               <table class="table table-bordered freezeHeaderTable">
                                   <thead>
                                   <th>SN</th>
                                   <th>Institution Name</th>
                                   <th>Date</th>
                                   <th>Amount</th>
                                   <th>Action</th>
                                   </thead>
                                   <tbody>
                                   @foreach($dividends as $dividend)
                                       <tr>
                                           <td>{{$i++}}</td>
                                           <td>{{$dividend->institution_code}}</td>
                                           <td>{{$dividend->date}}</td>
                                           <td>{{$dividend->amount}}</td>
                                           <td>
                                               <a href="{{route('dividend.edit',$dividend->id)}}"
                                                  class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a>
                                               <a href="javascript:void(0)"
                                                  data-id="{{ $dividend->id }}"
                                                  class="btn btn-danger btn-sm btndel">
                                                   <i class="fa fa-times"></i>
                                               </a>
                                           </td>
                                       </tr>
                                   @endforeach
                                   </tbody>
                               </table>
                           </div>
                            {{$dividends->links()}}
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
            var del_url = '{{ URL::to('dividend') }}/' + $(this).data('id');
            console.log(del_url);
            $('#firstform')[0].setAttribute('action', del_url);
            $('#deleteModal')
                .modal('show')
            ;
        });
    </script>
@endsection


