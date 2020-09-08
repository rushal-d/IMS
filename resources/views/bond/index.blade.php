@extends('layouts.master')
@section('title','Bonds')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-header-actions">
                                <a href="{{route('bond.create')}}" class="btn btn-sm btn-info">
                                    Add New Bond <i class="nav-icon icon-plus"></i>
                                </a>
                            </div>
                            <div class="card-header-rights">
                                <i class="fas fa-chart-line"></i> Total: {{ $bonds->total() ?? '' }}
                                <a onclick="printDiv('printableArea')" class="btn btn-sm btn-dropbox">
                                    Print <i class="fa fa-print"></i>
                                </a>
                                &nbsp;
                                <button class="downexcel btn btn-sm btn-dribbble">
                                    Export to Excel <i class="far fa-file-excel"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="filterForm" action="{{route('bond.index')}}" method="get">
                                <div class="row">
                                    <div class="col-sm-2 my-1">
                                        <label class="" for="fiscal_year_id">Fiscal Year</label>
                                        <div class="input-group">
                                            {!! Form::select('fiscal_year_id',$fiscal_years,$_GET['fiscal_year_id'] ?? null,['class'=>'form-control','id'=>'fiscal_year_id','placeholder'=>'Select Fiscal Year']) !!}
                                        </div>
                                    </div>

                                    <div class="col-sm-2 my-1">
                                        <label class="" for="start_date_en">From (AD)
                                            :</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="start_date_en"
                                                   name="start_date_en" placeholder="Start Date En"
                                                   value="{{$_GET['start_date_en'] ?? ''}}"
                                                   readonly>
                                        </div>
                                    </div>

                                    <div class="col-sm-2 my-1">
                                        <label class="" for="start_date">From (BS)
                                            :</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="start_date" name="start_date"
                                                   placeholder="Start Date"
                                                   value="{{$_GET['start_date'] ?? ''}}"
                                                   readonly>
                                        </div>
                                    </div>



                                    <div class="col-sm-2 my-1">
                                        <label class=""
                                               for="end_date">To(AD): </label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="end_date_en" name="end_date_en"
                                                   placeholder="End Date En"
                                                   value="{{$_GET['end_date_en'] ?? ''}}" disabled>
                                        </div>
                                    </div>

                                    <div class="col-sm-2 my-1">
                                        <label class="" for="end_date">To (BS)
                                            : </label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="end_date" name="end_date"
                                                   placeholder="End Date"
                                                   value="{{$_GET['end_date'] ?? ''}}"
                                                   readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 my-1">
                                        <label class="" for="inlineFormInputGroupUsername"><sup
                                                    class="required-field">*</sup>Organization Name</label>
                                        <div class="input-group">
                                           {!! Form::select('institution_id',$institutes,$_GET['institution_id'] ?? null,['class'=>'form-control','id'=>'institution_id','placeholder'=>'Select Organization']) !!}
                                        </div>
                                    </div>
                                    <div class="col-sm-2 my-1">
                                        <label class="" for="status">Status </label>
                                        <div class="input-group">
                                          {!! Form::select('status',$bond_statuses,$_GET['status'] ?? null,['class'=>'form-control','id'=>'status','placeholder'=>'Select Status']) !!}
                                        </div>
                                    </div>
                                    <div class="col-sm-1">
                                        <button type="submit" class="btn btn-success">Submit</button>
                                    </div>
                                    <div class="col-sm-1">
                                        <label for="">Clear All</label>
                                        <a href="{{route('bond.index')}}" class="btn btn-danger">Reset</a>
                                    </div>
                                </div>
                            </form>
                            <div class="row">
                                <div id="printableArea" class="col-xl-12 freezeHeaderTableContainer">
                                    <table class="table table-bordered freezeHeaderTable">
                                        <thead>
                                        <tr>
                                            <th>Fiscal Year</th>
                                            <th>Transaction Date</th>
                                            <th>Mature Date</th>
                                            <th>Institution Name</th>
{{--                                            <th>Bond Type</th>--}}
                                            <th>Duration in Days (Years)</th>
                                            <th>Amount</th>
                                            <th>Interest Rate</th>
                                            <th>Estimated Earning</th>
                                            <th>Alert Days</th>
                                            <th>Status</th>
                                            <th id="action">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(!empty($bonds) or count($bonds) > 0)
                                            @foreach($bonds as $bond)
                                                <tr class="@if($bond->status == 3) rowexpire
                                                            @elseif($bond->status == 2) rowalert @else rowalive @endif">
                                                    <td>{{$bond->fiscalyear->code}}</td>
                                                    <td>{{$bond->trans_date}}</td>
                                                    <td>{{$bond->mature_date}}</td>
                                                    <td>{{$bond->institute->institution_name}}</td>
{{--                                                    <td>{{$bond->bond_type->name}}</td>--}}
                                                    <td>{{$bond->days}} ({{number_format(($bond->days)/365, 1)}} Years)</td>
                                                    <td>{{$bond->totalamount}}</td>
                                                    <td>{{$bond->interest_rate}}</td>
                                                    <td>{{$bond->estimated_earning}}</td>
                                                    <td>{{$bond->alert_days}} ({{$bond->expiry_days}})</td>
                                                    <td>@if($bond->status == 1) Active @elseif( $bond->status == 2 )
                                                            Renew Soon @else Expired @endif</td>
                                                    <td class="actionbutton">
                                                        <a class="btn btn-info btn-sm"
                                                           href="{{ route('bond.show',$bond->id) }}"><i
                                                                    class="fa fa-eye"></i></a>

                                                        <a href="{{route('bond.edit',$bond->id)}}"
                                                           class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a>

                                                        <a href="javascript:void(0)" data-id="{{ $bond->id }}"
                                                           class="btn btn-danger btn-sm btndel"><i
                                                                    class="fa fa-times"></i>
                                                        </a>

                                                    </td>
                                                </tr>
                                            @endforeach
                                            <tr class="total">
                                                <td colspan="5" class="text-center">Total Rs</td>
                                                <td>@if(!empty($bondtotalamount)) {{$bondtotalamount}} @endif</td>
                                                <td></td>
                                                <td>@if(!empty($bondestimated_earning)) {{$bondestimated_earning}} @endif</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td>No Data Found</td>
                                            </tr>
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
        $('#start_date_en,#end_date_en').flatpickr();
        $('#start_date_en').change(function () {
            $('#start_date').val(AD2BS($('#start_date_en').val()));
            nepadate();
            $('#end_date_en').prop('disabled', false);
            $('#end_date_en').flatpickr({
                minDate: $('#start_date_en').val()
            });
        });


        $('#end_date_en').change(function () {
            $('#end_date').val(AD2BS($('#end_date_en').val()));
        });

        $('.btndel').click(function (e) {
            e.preventDefault();
            var del_url = '{{ URL::to('bond') }}/' + $(this).data('id');
            console.log(del_url);
            $('#firstform')[0].setAttribute('action', del_url);
            $('#deleteModal')
                .modal('show')
            ;
        });

        $('#start_date').nepaliDatePicker({
            npdMonth: true,
            npdYear: true,
            npdYearCount: 10,
            onChange: function (e) {
                $('#start_date_en').val(BS2AD($('#start_date').val()));
                var end_date = $('#end_date').val();

                nepadate();
                $('#end_date_en').prop('disabled', false);
                $('#end_date_en').flatpickr({
                    minDate: $('#start_date_en').val()
                });

            }
        });

        function nepadate() {
            var start_date = $('#start_date').val();
            var new_date = start_date.split('-');
            yes_date = new_date[1] + '/' + new_date[2] + '/' + new_date[0];

            $('#end_date').nepaliDatePicker({
                disableBefore: yes_date,
                npdMonth: true,
                npdYear: true,
                npdYearCount: 10,
                onChange: function (e) {
                    $('#end_date_en').val(BS2AD($('#end_date').val()));
                }
            });
        }

        $('.downexcel').on("click", function () {
            $('#filterForm').attr('action', '{{route('bond.excel')}}');
            $('#filterForm').submit()
        });
    </script>
    <script src="{{asset('js/print.js')}}"></script>
@endsection
