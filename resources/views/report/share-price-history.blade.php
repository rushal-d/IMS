@extends('layouts.master')
@section('title','Share Price History')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-header-rights">
                                Share History
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{route('share-history')}}" method="get">
                                <div class="row">
                                    <div class="col-sm-4 my-1">
                                        <label class="" for="start_date">Date
                                            : </label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="date" name="date"
                                                   placeholder="Share Date"
                                                   value="{{$_GET['date'] ?? null}}"
                                                   readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 my-1">
                                        <label class="" for="inlineFormInputGroupUsername"><sup
                                                    class="required-field">*</sup>Organization Name</label>
                                        <div class="input-group">
                                            {{Form::select('institution_code',$select_institutions->pluck('institution_name','institution_code'),$_GET['institution_code'] ?? null,['class'=>'form-control','placeholder'=>'All'])}}
                                        </div>
                                    </div>
                                    <div class="col-sm-2 text-right">
                                        <button type="submit" class="btn btn-primary form-group">Submit</button>
                                    </div>
                                </div>
                            </form>
                            <div class="row">
                                <div id="printableArea" class="col-xl-12 freezeHeaderTableContainer">
                                    <table class="table table-bordered freezeHeaderTable">
                                        <thead>
                                        <tr>
                                            <th>SN</th>
                                            <th>Organization Name</th>
                                            <th>Closing Value</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($institutions as $institution)
                                            <tr>
                                                <td>{{$i++}}</td>
                                                <td>{{$institution->institution_name}}</td>
                                                <td>


                                                    {{$institution->latest_share_price->closing_value ?? 0}}


                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>

                                    {{--                                    {{$institutions->appends($_GET)->links()}}--}}
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
        $('#date').flatpickr()
    </script>
@endsection
