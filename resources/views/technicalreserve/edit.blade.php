@extends('layouts.master')
@section('title', 'Technical Reserve')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12 col-md-5 col-xl-5">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i>
                            Technical Reserve

                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class=" col-xl-12">
                                    <form id="maindiv" method="post"
                                          action="{{route('technicalReserve.update',$technicalReserve->id)}}">
                                        @method('PATCH')
                                        @csrf
                                        <div class="form-group row">
                                            <label for="approved_date" class="col-sm-3 col-form-label">Approved
                                                Date</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control nep-date" id="approved_date"
                                                       name="approved_date" placeholder="Approved Date"
                                                       value="{{ old('approved_date',$technicalReserve->approved_date) }}"
                                                       readonly>
                                                <input type="hidden" id="approved_date_en" name="approved_date_en"
                                                       value="{{ old('approved_date_en',$technicalReserve->approved_date_en) }}" >
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="code" class="col-sm-3 col-form-label">Fiscal Year</label>
                                            <div class="col-sm-9">
                                                {{Form::select('fiscal_year_id',$fiscal_years, $technicalReserve->fiscal_year_id,['class'=>'form-control','placeholder'=>'Fiscal Year'])}}
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="code" class="col-sm-3 col-form-label">Amount</label>
                                            <div class="col-sm-9">
                                                {{Form::number('amount',$technicalReserve->amount,['step'=>'0.1','class'=>'form-control','placeholder'=>'Amount'])}}
                                            </div>
                                        </div>
                                        <div style="text-align: center">
                                            <button type="submit" class="btn btn-primary">
                                                Update
                                            </button>
                                            <button type="reset" class="btn btn-outline-secondary" value="Reset">Clear
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-7 col-xl-7">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i>
                            Technical Reserve

                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class=" col-xl-12">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Approved Date (AD)</th>
                                            <th>Approved Date (BS)</th>
                                            <th>Fiscal Year</th>
                                            <th>Amount</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(!empty($technicalReserves))
                                            @foreach($technicalReserves as $technicalReserve)
                                                <tr>
                                                    <td>{{$technicalReserve->approved_date_en}}</td>
                                                    <td>{{$technicalReserve->approved_date}}</td>
                                                    <td>{{$technicalReserve->fiscalYear->code ?? ''}}</td>
                                                    <td>{{$technicalReserve->amount ?? ''}}</td>

                                                    <td class="td-actions">
                                                        <a href="{{route('technicalReserve.edit',$technicalReserve->id)}}"
                                                           class="btn btn-success btn-sm"><i class="fa fa-edit"></i>Edit</a>
                                                        <a href="javascript:void(0)"
                                                           data-id="{{ $technicalReserve->id }}"
                                                           class="btn btn-danger btn-sm btndel">
                                                            <i class="fa fa-times"></i>Delete
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
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
    @include('layouts.deleteModal')
@endsection
@section('scripts')
    <script>
        var yes_date = '';
        $('#approved_date').nepaliDatePicker({
            closeOnDateSelect: true,
            npdMonth: true,
            npdYear: true,
            npdYearCount: 10,
            onChange: function (e) {
                $('#approved_date_en').val(BS2AD($('#approved_date').val()));
                nepadate();
            }
        });


        $('.btndel').click(function (e) {
            e.preventDefault();
            var del_url = '{{ URL::to('fiscalyear') }}/' + $(this).data('id');
            console.log(del_url);
            $('#firstform')[0].setAttribute('action', del_url);
            $('#deleteModal')
                .modal('show')
            ;
        });
    </script>
@endsection
