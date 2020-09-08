@extends('layouts.master')
@section('title','Pending Deposit')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-header-actions">
                                <a href="{{route('pending-deposit-create')}}" class="btn btn-sm btn-info">
                                    Add New Pending Deposit <i class="nav-icon icon-plus"></i>
                                </a>
                            </div> &nbsp;

                            <div class="card-header-rights">

                                <i class="fas fa-chart-line"></i> Total: {{ $deposits->total() ?? '' }}
                                <button class="downexcel btn btn-sm btn-dribbble">
                                    Export to Excel <i class="far fa-file-excel"></i>
                                </button>
                            </div>

                        </div>

                        <div class="card-body">
                            <form action="{{route('pending-deposit')}}" method="get" id="depositFilter">
                                <div class="row">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label for="filter_by">Field</label>

                                            {!! Form::select('filter_by',$filter_by,$_GET['filter_by'] ?? null,['class'=>'form-control', 'data-validation'=>"required"]) !!}
                                        </div>
                                    </div>

                                    <div class="col-3">
                                        <div class="form-group">
                                            <label for="value">Value</label>
                                            <input type="text" class="form-control" name="value"
                                                   placeholder="Filter Value" value="{{$_GET['value'] ?? ''}}">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label for="created_at_from">Created at(From)</label>
                                            <input type="text" class="form-control" name="createdat_from" id="from_date"
                                                   placeholder="Select Date" value="{{$_GET['createdat_from'] ?? ''}}">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label for="created_at_from">Created at(To)</label>
                                            <input type="text" class="form-control" name="createdat_to" id="to_date"
                                                   placeholder="Select Date" value="{{$_GET['createdat_to'] ?? ''}}">
                                        </div>
                                    </div>

                                    <div class="col-3">
                                        <div class="form-group">
                                            <label for="date_missing">Missing Date Records</label>
                                            <input type="checkbox"  name="date_missing"
                                                   id="date_missing"
                                                   value="1" {{isset($_GET['date_missing']) ? 'checked' : ''}}>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="form-group mt-4">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                            <a href="{{route('pending-deposit')}}" class="btn btn-danger">Reset</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="row">
                                <div id="printableArea" class="col-xl-12 freezeHeaderTableContainer">
                                    <table class="table freezeHeaderTable">
                                        <thead>
                                        <tr>
                                            <th>SN</th>
                                            <th>Cheque Date</th>
                                            <th>Cheque Number</th>
                                            <th>Account Head</th>
                                            <th>Bank</th>
                                            <th>Bank Branch</th>
                                            <th>Org. Branch</th>
                                            <th>Voucher Number</th>
                                            <th>Amount</th>
                                            <th>Created At</th>
                                            <th>Status</th>
                                            <th id="action">Action</th>
                                        </tr>
                                        </thead>
                                        <?php $total_interest_amount = 0; ?>
                                        <?php $total_deposit_amount = 0; ?>
                                        @if(!empty($deposits) or count($deposits) > 0)
                                            @php
                                                $allow_delete=false;
                                            @endphp
                                            @permission('deposit.destroy')
                                            @php
                                                $allow_delete=true;
                                            @endphp
                                            @endpermission

                                            @foreach($deposits as $deposit)
                                                <tr>
                                                    <td>{{$i++}}</td>
                                                    <td>{{$deposit->cheque_date}}</td>
                                                    <td>{{$deposit->cheque_no}}</td>
                                                    <td>{{$deposit->account_head ?? ''}}</td>
                                                    <td>{{$deposit->institute->institution_name ?? ''}}</td>
                                                    <td>{{$deposit->branch->branch_name ?? 'NA'}}</td>
                                                    <td>{{$deposit->organization_branch->branch_name ?? 'NA'}}</td>
                                                    <td>{{$deposit->voucher_number}}</td>
                                                    <td>{{$deposit->deposit_amount}}</td>
                                                    <td>{{$deposit->created_at->format('Y-m-d')}}</td>
                                                    <td>Pending</td>
                                                    <td class="actionbutton">
                                                        <a class="btn btn-info btn-sm"
                                                           href="{{ route('deposit.show',$deposit->id) }}"><i
                                                                    class="fa fa-eye"></i></a>
                                                        <a href="{{route('deposit.edit',$deposit->id) .'?'.$parameters }}"
                                                           data-toggle="tooltip" data-placement="top"
                                                           title="Complete Info." class="btn btn-success btn-sm"><i
                                                                    class="fas fa-share"></i></a>
                                                        <a href="{{route('pending-deposit-edit', $deposit->id). '?' .$parameters}}"
                                                           data-toggle="tooltip" data-placement="top" title="Edit"
                                                           class="btn btn-warning btn-sm"><i class="fa fa-edit"></i>
                                                        </a>
                                                        @if($allow_delete)
                                                            <a href="javascript:void(0)"
                                                               data-id="{{ $deposit->id }}"
                                                               data-toggle="tooltip" data-placement="top" title="Delete"
                                                               class="btn btn-danger btn-sm btndel">
                                                                <i class="fa fa-times"></i>
                                                            </a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td>No Data Found</td>
                                            </tr>
                                        @endif
                                    </table>
                                    {{ $deposits->appends($_GET)->links()  }}
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

        $('#to_date, #from_date').flatpickr();

        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })

        $(document).ready(function () {
            $('form').keydown(function (event) {
                // enter has keyCode = 13, change it if you want to use another button
                if (event.keyCode == 13) {
                    $(this).submit();
                    return false;
                }
            });
        });

        $('.btndel').click(function (e) {
            e.preventDefault();
            var del_url = '{{ URL::to('deposit') }}/' + $(this).data('id');
            console.log(del_url);
            $('#firstform')[0].setAttribute('action', del_url);
            $('#deleteModal')
                .modal('show')
            ;
        });

        $('.downexcel').on("click", function () {
            $('#depositFilter').attr('action', '{{route('pending-deposit-excel-download')}}');
            $('#depositFilter').submit();
            $('#depositFilter').attr('action', '{{route('pending-deposit')}}');
        });
    </script>
@endsection
