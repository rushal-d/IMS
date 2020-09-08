@extends('layouts.master')
@section('title','Fiscal Year')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i>
                            Fiscal year
                            <div class="card-header-actions">
                                <a href="#" class="card-header-action btn-minimize" data-toggle="collapse" data-target="#collapseExamples" aria-expanded="true">
                                    <i class="icon-arrow-up"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-5">
                                    <form method="post"
                                          action="{{route('fiscalyear.update',$fiscalyear->id)}}"
                                          enctype="multipart/form-data">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="0">
                                        <div class="form-group row">
                                            <label for="start_date" class="col-sm-2 col-form-label">Start Date</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control nep-date" id="start_date" name="start_date" placeholder="Start Date (BS)"
                                                       value="{{$fiscalyear->start_date}}">
                                                <input type="hidden" id="start_date_en" name="start_date_en" value="{{$fiscalyear->start_date_en}}" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="end_date" class="col-sm-2 col-form-label">End Date</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control nep-date" id="end_date" name="end_date" placeholder="End Date (BS)"
                                                       value="{{$fiscalyear->end_date}}">
                                                <input type="hidden" id="end_date_en" name="end_date_en" value="{{$fiscalyear->end_date_en}}" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="code" class="col-sm-2 col-form-label">Fiscal Year</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="fiscal_code" name="code"
                                                       placeholder="code" value=" {{$fiscalyear->code}}" readonly required>
                                            </div>
                                        </div>
                                        <div style="text-align: center">
                                            <button type="submit" class="btn btn-primary">
                                               Update
                                            </button>
                                            <button type="reset" class="btn btn-outline-secondary" value="Reset">Clear</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-xl-7">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Fiscal Year</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(!empty($fiscalyears))
                                            @foreach($fiscalyears as $fiscalyear)
                                                <tr>
                                                    <td>{{$fiscalyear->start_date}} ({{$fiscalyear->start_date_en}})</td>
                                                    <td>{{$fiscalyear->end_date}} ({{$fiscalyear->end_date_en}})</td>
                                                    <td>{{$fiscalyear->code}}</td>
                                                    <td>
                                                        <span class="label label-{{  ($fiscalyear->status == '1') ? 'success' : 'danger' }}">
                                                            {{ $fiscalyear->status=='1'? 'Active':'Deactive' }}
                                                        </span>
                                                    </td>
                                                    <td class="td-actions">
                                                        <a href="{{route('fiscalyear.edit',$fiscalyear->id)}}" class="btn btn-success btn-sm"><i class="fa fa-edit"></i>Edit</a>
                                                        <a href="javascript:void(0)" data-id="{{ $fiscalyear->id }}" class="btn btn-danger btn-sm btndel">
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
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"><i class="far fa-trash-alt"></i> Confirm Delete</h4>
                </div>
                <form id="firstform" action="" method="post">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        Are you Sure You Want To Delete ?
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary modal-delete">Yes
                        </button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection

@section('scripts')
    <script>
        $('.nep-date').nepaliDatePicker({
            npdMonth: true,
            npdYear: true,
            npdYearCount: 10,
            onChange: function(e){
                $('#start_date_en').val(BS2AD($('#start_date').val()));
                $('#end_date_en').val(BS2AD($('#end_date').val()));
                generateFiscalYearCode()
            }
        });

        $('#fiscal_code').focus(function(){
            generateFiscalYearCode()
        });
        $(document).ready(function () {
            generateFiscalYearCode();
        });
        function generateFiscalYearCode(){
            var from_date = $('#start_date').val();
            var to_date = $('#end_date').val();
            var fiscal_code = '';
            var fiscal_code_first = '';
            var fiscal_code_last = '';
            if(from_date != ''){
                fiscal_code_first = from_date.split('-')[0];
            }
            if(to_date != ''){
                var fiscal_code_last_split = to_date.split('-')[0];
                fiscal_code_last = fiscal_code_last_split.substr(2,4);
            }
            fiscal_code= fiscal_code_first + '/' +  fiscal_code_last;
            if(fiscal_code != '/') {
                $('#fiscal_code').val(fiscal_code);
            }
        }

        $('.btndel').click(function(e){
            e.preventDefault();
            var del_url = '{{ URL::to('fiscalyear') }}/'+$(this).data('id');
            console.log(del_url);
            $('#firstform')[0].setAttribute('action', del_url);
            $('#deleteModal')
                .modal('show')
            ;
        });
    </script>
@endsection
