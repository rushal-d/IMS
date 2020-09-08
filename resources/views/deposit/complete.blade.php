@extends('layouts.master')
@section('title', 'Placement Letter')

@section('styles')
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                {{ Form::open(['route' => ['letter.update', $deposit->id], 'method' => 'PATCH']) }}
                <textarea class="form-control ok" name="okay" rows="60">
                        {{$deposit->letter}}
                    </textarea>
                <div class="col-lg-12 text-right" style="margin-top: 5px;">
                    <button type="submit" id="submit-button" class="btn btn-primary">
                        Update
                    </button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        CKEDITOR.replace("okay");
    </script>

@endsection
