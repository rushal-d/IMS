@extends('layouts.master')

@section('styles')
    <style>

    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-11 text-left">
                                TDS Certification Letter
                            </div>
                            <div class="col-1 text-left">
                                <b>Total: {{$tds->count()}}</b>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- filter -->
                        <div class="filter">
                            <div class="row form-group">
                                <h3 class="d-md-none text-center btn custom-filter-button">Toggle Filter <i class="custom-filter-caret fas fa-caret-down"></i></h3>
                                <div class="filter custom-filter-bar do-not-display-filter-bar-for-small-device col-md-12">
                                    {!! Form::open(['route' => 'tds-search', 'method' => 'GET', 'id' => 'department-form']) !!}
                                    <div class="row">
                                        <div class="col-lg-2 form-group">
                                            <label>Fiscal Year</label>
                                            {!! Form::select('fiscal_year_id', $fiscal_years->pluck('code', 'id'), $_GET['fiscal_year_id'] ?? null, ['class' => 'form-control', 'placeholder' => 'Fiscal year']) !!}
                                        </div>
                                        <div class="col-lg-4 form-group">
                                            <label>Bank Name</label>
                                            {!! Form::select('institution_id', $institutes->pluck('institution_name', 'id'), $_GET['institution_id'] ?? null, ['class' => 'form-control', 'placeholder' => 'Bank']) !!}
                                        </div>
                                        <div class="col-lg-2">
                                            <p class="mt-4">
                                                <button class="btn custom-btn btn-primary" type="submit">Search
                                                </button>
                                                <button class="btn custom-btn btn-danger" type="reset" id="reset">
                                                    Reset
                                                </button>
                                            </p>
                                        </div><!--  -->
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                        <div class="already">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>S.N.</th>
                                        <th>Bank</th>
                                        <th>Fiscal Year</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if(!empty($tds))
                                    @foreach($tds->get() as $td)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$td->institute->institution_name}}</td>
                                            <td>{{$td->fiscal_year->code}}</td>
                                            <td>{{$td->created_at}}</td>
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
@endsection

@section('scripts')
    <script>
        CKEDITOR.replace("okay");
    </script>
@endsection