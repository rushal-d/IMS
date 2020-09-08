@extends('layouts.master')

@section('styles')
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
                                <b>Total: {{$deposit->count()}}</b>
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
                        @if($previous_exists)
                            {!! Form::open(['route' => ['tds-update', $previous->id], 'method' => 'PATCH']) !!}
                                <textarea class="form-control ok" name="okay" rows="60">
                                    {{$previous->content}}
                                </textarea>
{{--                                <div class="col-lg-12 text-center" style="margin-top: 5px;">--}}
{{--                                    <button type="submit" id="submit-button" class="btn btn-primary">--}}
{{--                                        Update--}}
{{--                                    </button>--}}
{{--                                </div>--}}
                            {!! Form::close() !!}

                        @else
                            {!! Form::open(['route' => 'tds-save', 'method' => 'post']) !!}
                            {!! Form::hidden('fiscal_year_id', $deposit->first()->fiscal_year_id ?? "-") !!}
                            {!! Form::hidden('institution_id', $deposit->first()->institution_id ?? "-") !!}
                            <textarea class="form-control ok" name="okay" rows="60">

                                @php  $table = '<table><thead><tr><th>Bank Name</th><th>FD Amount</th><th>Starting Period</th><th>Maturity Period</th><th>FD Number</th></tr></thead>'; @endphp
                                @foreach($deposit as $d)
                                    @php
                                        $table .= '<tr><td>'.$d->institute->institution_name. "," .$d->branch->branch_name.'</td><td>'.$d->deposit_amount.'</td><td>'.$d->trans_date_en.'</td><td>'.$d->mature_date_en.'</td><td>'.$d->document_no.'</td></tr>';
                                    @endphp
                                @endforeach
                                {{$table}}
                                {{ strtr($letter_tds, array('%%date%%' => $deposit->first()->trans_date_en ?? "N/A", '%%bank_name%%' => $deposit->first()->institute->institution_name ?? "N/A",
                                                            '%%fiscal_year%%' => $deposit->first()->fiscalyear->code ?? "N/A")) }}

                            </textarea>
                            <div class="col-lg-12 text-center" style="margin-top: 5px;">
                                <button type="submit" id="submit-button" class="btn btn-primary">
                                    Save
                                </button>
                            </div>
                            {!! Form::close() !!}
                        @endif
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