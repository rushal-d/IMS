@extends('layouts.master')
@section('title','SMS Setup')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">

            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i>
                    SMS Configuration

                    <p for="">Mobile Number Value :{mobile_number} and Message : {message}</p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-12">
                            <form action="{{route('sms-setup.store')}}" method="post">
                                @csrf
                                <div class="form-group row">
                                    <div class="col-3">
                                        <label for="url">URL</label>
                                    </div>
                                    <div class="col-9">
                                        {{Form::text('url',$sms_setups->where('parameter','url')->first()->value ?? null,['class'=>'form-control','placeholder'=>'URL','data-validation'=>'required'])}}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-sm btn-outline-primary add-more">Add
                                        More
                                    </button>
                                </div>
                                <div class="collection">
                                    @if(!empty($sms_setups->count()))
                                        @foreach($sms_setups->where('parameter','<>','url') as $sms_setup)
                                            @php $count++@endphp
                                            <div class="form-group row content-row">
                                                <div class="col-5">
                                                    {{Form::text('parameter[]',$sms_setup->parameter,['class'=>'form-control','multiple'=>true,'placeholder'=>'Parameter'])}}
                                                </div>

                                                <div class="col-5">
                                                    {{Form::text('value[]',$sms_setup->value,['class'=>'form-control','multiple'=>true,'placeholder'=>'Value'])}}
                                                </div>
                                                @if($count>1)
                                                    <div class="col-2">
                                                        <button class="btn btn-sm btn-danger remove-button"
                                                                type="button">-
                                                        </button>
                                                    </div>
                                                @endif

                                            </div>
                                        @endforeach
                                    @else
                                        <div class="form-group row content-row">
                                            <div class="col-5">
                                                {{Form::text('parameter[]',null,['class'=>'form-control','multiple'=>true,'placeholder'=>'Parameter'])}}
                                            </div>
                                            <div class="col-5">
                                                {{Form::text('value[]',null,['class'=>'form-control','multiple'=>true,'placeholder'=>'Value'])}}
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group text-center">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('scripts')
    <script>
        let remove_button = '<div class="col-2">\n' +
            '                                                    <button class="btn btn-sm btn-danger remove-button" type="button">-</button>\n' +
            '                                                </div>';

        $('.add-more').click(function (e) {
            $contentRow = $('.content-row').first().clone();
            $contentRow.append(remove_button);
            $('.collection').append($contentRow);
        });
        $(document).on('click', '.remove-button', function (e) {
            $(this).parent().parent().remove();
        });
    </script>
@endsection
