@extends('layouts.master')
@section('title','Investment Institute')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">

                <div class="col-sm-12 col-md-6 col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i>
                            Investment Institute - {{$invest_type}}
                            <div class="card-header-actions">
                                <a href="#" class="card-header-action btn-minimize" data-toggle="collapse"
                                   data-target="#collapseExamples" aria-expanded="true">
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">

                                <div class="card col-xl-12">
                                    <form id="maindiv" method="post"
                                          action="{{route('investmentinstitution.store')}}"
                                          enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="invest_type_id" value="{{$type_id}}">
                                        <div class="form-group row">
                                            <label for="start_date" class="col-sm-3 col-form-label"><sup
                                                        class="required-field">*</sup>Organization Name</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="institution_name"
                                                       name="institution_name"
                                                       value="{{ old('institution_name') }}"
                                                       data-validation="required">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="institution_code" class="col-sm-3 col-form-label"><sup
                                                        class="required-field">*</sup>Code</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="institution_code"
                                                       name="institution_code"
                                                       value="{{ old('institution_code') }}"
                                                       data-validation="required">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="description"
                                                   class="col-sm-3 col-form-label">Description</label>
                                            <div class="col-sm-9">
                                                    <textarea type="text" class="form-control" id="description"
                                                              name="description"
                                                              rows="3"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="invest_group_id" class="col-sm-3 col-form-label"><sup
                                                        class="required-field">*</sup>Organization Group</label>
                                            <div class="col-sm-9">
                                                <select name="invest_group_id" id="invest_group_id"
                                                        class="form-control" data-validation="required">
                                                    <option value="">Select</option>
                                                    @foreach($all_groups as $group)
                                                        <option value="{{$group->id}}">{{$group->group_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="invest_group_id" class="col-sm-3 col-form-label"><sup
                                                        class="required-field">*</sup>Organization Sector</label>
                                            <div class="col-sm-9">
                                                <select name="invest_subtype_id" id="invest_subtype_id"
                                                        class="form-control" data-validation="required">
                                                    <option value="">Select</option>
                                                    @foreach($all_sectors as $sector)
                                                        <option value="{{$sector->id}}">{{$sector->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="invest_group_id" class="col-sm-3 col-form-label"><sup
                                                        class="required-field">*</sup>Is Listed Organization?</label>
                                            <div class="col-sm-9">
                                                {!! Form::select('is_listed',['No','Yes'],old('is_listed',1),['class'=>'form-control','data-validation'=>'required']) !!}
                                            </div>
                                        </div>
                                        <div style="text-align: center">
                                            <button type="submit" class="btn btn-primary">
                                                Submit
                                            </button>
                                            <button type="reset" class="btn btn-outline-secondary" value="Reset">
                                                Clear
                                            </button>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-sm-12 col-md-6 col-xl-6">

                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i>
                            Investment Institute - {{$invest_type}}
                            <div class="card-header-actions">
                                <a href="#" class="card-header-action btn-minimize" data-toggle="collapse"
                                   data-target="#collapseExamples" aria-expanded="true">
                                </a>
                            </div>
                            @if($invest_type == "Share")
                                <div class="card-header-rights"><a href="{{route('update.sharetable')}}">
                                        <button class="btn btn-info">
                                            Update Share Data
                                        </button>
                                    </a></div> @endif
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!--                                --><?php //if( $invest_type == "Share" || $invest_type == "Deposit") { $col=12; } else {$col=7;} ?>
                                <div class="card col-xl-12">
                                    <table class="table text-center">
                                        <thead>
                                        <tr>
                                            <th>S.N</th>
                                            <th>Organization Name</th>
                                            <th>Organization Code</th>
                                            <th>Description</th>
                                            <th>Group Name</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $count = 1; ?>
                                        @if(!empty($investmentinstitutes))
                                            @foreach($investmentinstitutes as $investmentinstitution)
                                                <tr>
                                                    <td>{{$count++}}</td>
                                                    <td>{{$investmentinstitution->institution_name}}</td>
                                                    <td>{{$investmentinstitution->institution_code}}</td>
                                                    <td>{{$investmentinstitution->description ?? 'NA'}}</td>
                                                    @if(!empty($investmentinstitution->invest_group))
                                                        <td>{{$investmentinstitution->invest_group->group_name}}</td>
                                                    @else
                                                        <td>NA</td>
                                                    @endif
                                                    {{--                                                @if($invest_type != "Share")--}}
                                                    <td class="td-actions">
                                                        <a href="{{route('investmentinstitution.edit',$investmentinstitution->id)}}"
                                                           class="btn btn-success btn-sm"><i
                                                                    class="fa fa-edit"></i>Edit</a>
                                                        <a href="javascript:void(0)"
                                                           data-id="{{ $investmentinstitution->id }}"
                                                           class="btn btn-danger btn-sm btndel">
                                                            <i class="fa fa-times"></i>Delete
                                                        </a>
                                                    </td>
                                                    {{--@endif--}}
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
    </div>
    @include('layouts.deleteModal')
@endsection

@section('scripts')
    <script>

        $('.btndel').click(function (e) {
            e.preventDefault();
            var del_url = '{{ URL::to('investmentinstitution') }}/' + $(this).data('id');
            console.log(del_url);
            $('#firstform')[0].setAttribute('action', del_url);
            $('#deleteModal')
                .modal('show')
            ;
        });
    </script>
@endsection
