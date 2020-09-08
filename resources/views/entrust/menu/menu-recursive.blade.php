<?php
$levelTwos = \App\Menu::nextLevel($permission->id)->get();
?>
<li style="display: list-item;"
    class=""
    id="menuItem_{{$permission->id}}">
    <div class="row custom-row menuDiv">
        <div data-id="{{$permission->id}}" class="itemTitle">
            <div class="row col-12">
                <div class="col-md-4">
                <span title="Click to show/hide children" class="disclose ui-icon ui-icon-minusthick">
                </span>{{$permission->menu_name}}
                </div>
                <div class="col-md-4">
                    <input type="text" class="" name="permission[{{$permission->menu_name}}][display_name]"
                           value="{{$permission->display_name}}">
                </div>

                {{--<div class="col-md-4">
                    <select id="" class="select2" name="permission[{{$permission->menu_name}}][icon]">
                        <option value="{{$permission->icon}}"
                                selected="selected">{{$permission->icon}}</option>
                    </select>
                </div>--}}
                <div class="col-md-4">
                    <div class="input-group">
                        <div class="input-group-append" >
                            <i style="font-size: 2em"
                               id="permission[{{$permission->name}}][icon]" class="{{$permission->icon}}"></i>
                            <input type="text"
                                   id="permission[{{$permission->menu_name}}][name]"
                                   name="permission[{{$permission->menu_name}}][icon]"
                                   value="{{$permission->icon}}" class="input-field-for-icon">
                            <span class="input-group-text choose-icon-button" data-menu-name="{{$permission->menu_name}}">Choose icon</span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    {{--@each('admin.entrust.permission.project', $levelTwos, 'permission', 'admin.entrust.permission.projects-none')--}}
    @if($levelTwos->count()>0)
        <ol class="">
            @foreach($levelTwos as $permission)
                @include('entrust.menu.menu-recursive', $permission)
            @endforeach
        </ol>
    @endif
</li>






