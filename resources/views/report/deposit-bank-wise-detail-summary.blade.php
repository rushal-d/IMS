@extends('layouts.master')
@section('title','Bank Wise Detail Summary')
@section('styles')

@endsection
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">

            <div class="row">
                @foreach ($institutionAllRecords as $institutionRecord)

                    @if($institutionRecord['opening_balance']!=0 || count($institutionRecord['records'])!=0 )

                        <div class="col-4">
                            <div class="card">
                                <div class="card-header">
                                    {{$institutionRecord['institution_name']}}
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <tr>
                                            <td>SN</td>
                                            <td>Date</td>
                                            <td>Dr Amount</td>
                                            <td>Cr Amount</td>
                                            <td>Balance</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Opening Balance</td>
                                            <td>{{$institutionRecord['opening_balance']}}</td>
                                            <td></td>
                                            <td>{{$institutionRecord['opening_balance']}}</td>
                                        </tr>
                                        @php $opening_balance=$institutionRecord['opening_balance'] @endphp
                                        @foreach($institutionRecord['records'] as $record)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$record['trans_date_en'] ?? ''}}</td>
                                                <td>{{$record['dr_amount'] ?? ''}}</td>
                                                <td>{{$record['cr_amount'] ?? ''}}</td>
                                                @php $opening_balance+=(float)$record['dr_amount'];$opening_balance-=(float)$record['cr_amount']; @endphp
                                                <td>
                                                    {{$opening_balance}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

        </div>
    </div>
@endsection
@section('scripts')

@endsection
