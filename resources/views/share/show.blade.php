@extends('layouts.master')
@section('title','Share-Show')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-xl-7">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-3">
                                    <i class="fa fa-align-justify"></i>
                                    Share - Show
                                </div>
                                <div class="col-9 text-right">
                                    Add Right Share
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="row">

                                        <div class="col-sm-4 my-1">
                                            <label class="" for="inlineFormInputName"><sup
                                                        class="required-field">*</sup>Fiscal Year</label>
                                            <div class="input-group">
                                                <select name="fiscal_year_id" id="fiscal_year_id"
                                                        class="form-control" data-validation="required">
                                                    <option value="">{{$share->fiscalyear->code}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 my-1">
                                            <label class="" for="trans_date"><sup class="required-field">*</sup>Transaction
                                                Date (AD)</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control nep-date" id="trans_date"
                                                       name="trans_date" placeholder="transaction date"
                                                       value="{{$share->trans_date_en}}" readonly
                                                       data-validation="required">
                                            </div>
                                        </div>
                                        <div class="col-sm-4 my-1">
                                            <label class="" for="trans_date"><sup class="required-field">*</sup>Transaction
                                                Date (BS)</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control nep-date" id="trans_date"
                                                       name="trans_date" placeholder="transaction date"
                                                       value="{{$share->trans_date}}" readonly
                                                       data-validation="required">
                                            </div>
                                        </div>

                                        <div class="col-sm-4 my-1">
                                            <label class="" for="inlineFormInputGroupUsername"><sup
                                                        class="required-field">*</sup>Organization Name</label>
                                            <div class="input-group">
                                                <select name="institution_id" id="institution_id"
                                                        class="form-control" data-validation="required">
                                                    <option value="">{{$share->instituteByCode->institution_name}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 my-1">
                                            <label class="" for="purchase_kitta"><sup class="required-field">*</sup>Purchase
                                                Kitta</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control" id="purchase_kitta"
                                                       name="purchase_kitta"
                                                       value="{{$share->purchase_kitta}}"
                                                       data-validation="required">
                                            </div>
                                        </div>
                                        <div class="col-sm-4 my-1">
                                            <label class="" for="rateperunit"><sup class="required-field">*</sup>Nepse
                                                Rate</label>
                                            <div class="input-group">
                                                <input type="number" step="0.01" class="form-control"
                                                       data-validation-allowing="float"
                                                       name="rateperunit" id="rateperunit"
                                                       value="{{$share->rateperunit}}" data-validation="required"
                                                       readonly>
                                            </div>
                                        </div>

                                        <div class="col-sm-4 my-1">
                                            <label class="" for="investment_subtype_id"><sup
                                                        class="required-field">*</sup>Investment Sector</label>
                                            <div class="input-group">
                                                <select name="investment_subtype_id" id="investment_subtype_id"
                                                        class="form-control" data-validation="required">
                                                    <option value="">{{$share->investment_sector->name}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 my-1">
                                            <label class="" for="closing_value"><sup class="required-field">*</sup>Nepse
                                                Value</label>
                                            <div class="input-group">
                                                <input type="text" min="0" class="form-control" id="closing_value"
                                                       name="closing_value"
                                                       value="{{$share->closing_value}}" data-validation="required">
                                            </div>
                                        </div>


                                        <div class="col-sm-4 my-1">
                                            <label class="" for="purcahse_value"><sup class="required-field">*</sup>Purchase
                                                Value</label>
                                            <div class="input-group">
                                                <input type="number" min="0" step="0.01"
                                                       data-validation-allowing="float" class="form-control"
                                                       id="purchase_value" name="purchase_value"
                                                       value="{{$share->purchase_value}}"
                                                       data-validation="required">
                                            </div>
                                        </div>

                                        <div class="col-sm-4 my-1">
                                            <label class="" for="purcahse_value"><sup class="required-field">*</sup>
                                                Share Type
                                            </label>
                                            <div class="input-group">
                                                <input type="text" class="form-control"
                                                       id="purchase_value"
                                                       value="{{$share_types[$share->share_type_id]}}"
                                                       data-validation="required">
                                            </div>
                                        </div>

                                        <div class="col-sm-4 my-1">
                                            <label class="" for="totalamount">Reference Number</label>
                                            <div class="input-group">
                                                <input type="text" min="0" value="{{$share->reference_number}}"
                                                       class="form-control" name="reference_number"
                                                       id="reference_number">
                                            </div>
                                        </div>
                                        <div class="col-sm-4 my-1">
                                            <label class="" for="total_amount"><sup class="required-field">*</sup>Total
                                                Amount</label>
                                            <div class="input-group">
                                                <input type="number" min="0" step="0.01"
                                                       data-validation-allowing="float" class="form-control"
                                                       id="total_amount" name="total_amount"
                                                       value="{{$share->total_amount}}" data-validation="required">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-5">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i>
                            Share - Show
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="row">
                                        <div class="col-sm-12 my-1">
                                            <label class="" for="kitta_details"><sup class="required-field">*</sup>Kitta
                                                Details</label>
                                            <div class="input-group">
                                                <input type="text" min="0" class="form-control" id="kitta_details"
                                                       name="kitta_details"
                                                       value="{{$share->kitta_details}}" data-validation="required">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{--  <div class="card">
                          <div class="card-header">
                              <i class="fa fa-align-justify"></i>
                              Bonus Share History
                          </div>
                          <div class="card-body">
                              <div class="row">
                                  <div class="col-xl-12">
                                      <a href="{{route('bonussharehistory.create',['id'=>$share->id])}}">
                                          <button class="btn btn-info btn-sm">Add</button>
                                      </a>
                                      <table class="table table-bordered">
                                          <thead>
                                          <th>SN</th>
                                          <th>Date</th>
                                          <th>No. of Kitta</th>
                                          <th>Action</th>
                                          </thead>
                                          <tbody>
                                          @foreach($bonus_share_histories as $bonus_share_history)
                                              <tr>
                                                  <td>{{$count++}}</td>
                                                  <td>{{$bonus_share_history->date_en}}</td>
                                                  <td>{{$bonus_share_history->no_of_kitta}}</td>
                                                  <td>
                                                      <a class="btn btn-info btn-sm"
                                                         href="{{ route('bonussharehistory.show',$bonus_share_history->id) }}"><i
                                                                  class="fa fa-eye"></i></a>
                                                      <a href="{{route('bonussharehistory.edit',$bonus_share_history->id)}}"
                                                         class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a>
                                                      <a href="javascript:void(0)"
                                                         data-id="{{ $bonus_share_history->id }}"
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
                      </div>--}}
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
            var del_url = '{{ URL::to('bonussharehistory') }}/' + $(this).data('id');
            console.log(del_url);
            $('#firstform')[0].setAttribute('action', del_url);
            $('#deleteModal')
                .modal('show')
            ;
        });


    </script>
@endsection