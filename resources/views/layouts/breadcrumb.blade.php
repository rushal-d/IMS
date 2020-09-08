<?php
$breadcrumb_end = \Illuminate\Support\Facades\Route::currentRouteName();
$end_name = \App\Permission::where('name', $breadcrumb_end)->first();
//dd($end_name);
if(!empty($end_name)){
    $parent = \App\Permission::where('id', $end_name->parent_id)->first();
}

?>
<ol class="breadcrumb">
    @if(!empty($parent->display_name))
        @if(strpos($parent->name,'#') === false)
            <li class="breadcrumb-item">
                <a href="{{route($parent->name)}}">{{$parent->display_name ?? ''}}</a>
            </li>
        @endif
        <li class="breadcrumb-item active">{{$end_name->display_name ?? ''}}</li>
    @else
        <li class="breadcrumb-item active">{{$end_name->display_name ?? ''}}</li>
    @endif
    <!-- Breadcrumb Menu-->
   {{-- <li class="breadcrumb-menu d-md-down-none">
        <div class="btn-group" role="group" aria-label="Button group">
            <a class="btn" href="#">
                <i class="icon-speech"></i>
            </a>
            <a class="btn" href="./">
                <i class="icon-graph"></i>  Dashboard</a>
            <a class="btn" href="#">
                <i class="icon-settings"></i>  Settings</a>
        </div>
    </li>--}}
</ol>