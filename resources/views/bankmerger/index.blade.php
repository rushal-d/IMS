@extends('layouts.master')
@section('title','Bank Merger')
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
                                <a href="{{route('bank-merger.create')}}" class="btn btn-sm btn-info">
                                    Add New <i class="nav-icon icon-plus"></i>
                                </a>
                            </div>
                            <div class="card-header-rights">

                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                <th>SN</th>
                                <th>Merged Bank Name</th>
                                <th>Merged Bank Code</th>
                                <th>Merge Date</th>
                                <th>Merged Bank Count</th>
                                <th>Action</th>
                                </thead>
                                <tbody>
                                @foreach($bankMergers as $bankMerger)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$bankMerger->bank_name_after_merger}}</td>
                                        <td>{{$bankMerger->bank_code_after_merger }}</td>
                                        <td>{{$bankMerger->merger_date }}</td>
                                        <td>
                                            {{$bankMerger->mergeBankList->count()}}
                                            <br>
                                            @php $mergedBanks=$bankMerger->mergeBankList->pluck('bank_name')->toArray() @endphp
                                            [{{implode(',',$mergedBanks)}}]
                                        </td>
                                        <td>
                                            <a href="{{route('bank-merger.edit',$bankMerger->id)}}"
                                               class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a>
                                            <a href="javascript:void(0)"
                                               data-id="{{ $bankMerger->id }}"
                                               class="btn btn-danger btn-sm btndel">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{$bankMergers->appends($_GET)->links()}}
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
            $('#firstform')[0].setAttribute('action', del_url);
            $('#deleteModal')
                .modal('show')
            ;
        });
    </script>
@endsection


