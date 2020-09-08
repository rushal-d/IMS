@extends('layouts.master')
@section('title','Permissions')
@section('styles')
    <link rel="stylesheet" href="{{asset('css/permission.css')}}">
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" data-background-color="custom-color">
                        <i class="fa fa-align-justify"></i>
                        MENU
                        <div class="card-header-actions">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                Add Permission/Menu
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-8 col-md-offset-2">
                            <!-- The Modal -->
                            <div class="modal" id="myModal">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Create a Sidebar Head Menu</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            <form action="{{route('permission.add')}}" method="post">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="Name" class="col-md-2">Name</label>
                                                            <div class="col-md-8">
                                                                <input type="text" class="form-control" name="name">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <button type="submit" class="btn btn-success">Submit</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <form id="submitForm" action="{{route('permission.addmenu')}}" method="post">
                                @csrf
                                <section id="demo">
                                    <ol class="sortable ui-sortable mjs-nestedSortable-branch mjs-nestedSortable-expanded">
                                        @each('entrust.permission.permission-recursive', $permissions, 'permission', 'entrust.permission.permission-recursive-none')
                                    </ol>
                                    <div class="text-center">
                                        <input id="toArray" name="toArray" type="button" value=
                                        "Change Order" class="btn btn-warning">
                                    </div>
                                </section>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    {{--for hiearchy menu--}}
    <link rel="stylesheet" href="{{asset('css/jquery-ui.css')}}"/>
    <script src="{{asset('js/jquery-ui.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/nestedSortable.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('#select-gear').selectize({
                sortField: 'text'
            });
            $('#select-beast').selectize({
                create: true,
                sortField: 'text'
            });
        });
    </script>
    <script>
        var ns = $('ol.sortable').nestedSortable({
            forcePlaceholderSize: true,
            handle: 'div',
            helper: 'clone',
            items: 'li',
            opacity: .6,
            placeholder: 'placeholder',
            revert: 250,
            tabSize: 25,
            tolerance: 'pointer',
            toleranceElement: '> div',
            maxLevels: 4,
            isTree: true,
            expandOnHover: 700,
            startCollapsed: false
        });

        $('.expandEditor').attr('title', 'Click to show/hide item editor');
        $('.disclose').attr('title', 'Click to show/hide children');
        $('.deleteMenu').attr('title', 'Click to delete item.');

        $('.disclose').on('click', function () {
            $(this).closest('li').toggleClass('mjs-nestedSortable-collapsed').toggleClass('mjs-nestedSortable-expanded');
            $(this).toggleClass('ui-icon-plusthick').toggleClass('ui-icon-minusthick');
        });

        $('.expandEditor, .itemTitle').click(function () {
            var id = $(this).attr('data-id');
            $('#menuEdit' + id).toggle();
            $(this).toggleClass('ui-icon-triangle-1-n').toggleClass('ui-icon-triangle-1-s');
        });

        $('.deleteMenu').click(function () {
            var id = $(this).attr('data-id');
            $('#menuItem_' + id).remove();
        });

        $('#serialize').click(function () {
            serialized = $('ol.sortable').nestedSortable('serialize');
            $('#serializeOutput').text(serialized + '\n\n');
        })

        $('#toHierarchy').click(function (e) {
            hiered = $('ol.sortable').nestedSortable('toHierarchy', {startDepthCount: 0});
            hiered = dump(hiered);

            (typeof($('#toHierarchyOutput')[0].textContent) != 'undefined') ?
                $('#toHierarchyOutput')[0].textContent = hiered : $('#toHierarchyOutput')[0].innerText = hiered;
        })

        $('#toArray').click(function (e) {

            arraied = $('ol.sortable').nestedSortable('toArray', {startDepthCount: 0});
            // var json = JSON.stringify(arraied);
            var token = $('input[name=_token]').val();
            $.ajax({
                url: '{{route('permission.store')}}',
                type: "POST",
                dataType: "json",
                data: {
                    '_token':token,
                    "menu": arraied,
                },
                success: function (data) {
                    // alert(data);
                    $('#submitForm').submit();
                }
            });
            arraied = dump(arraied);

            (typeof($('#toArrayOutput')[0].textContent) != 'undefined') ?
                $('#toArrayOutput')[0].textContent = arraied : $('#toArrayOutput')[0].innerText = arraied;
        });


        function dump(arr, level) {
            var dumped_text = "";
            if (!level) level = 0;

            //The padding given at the beginning of the line.
            var level_padding = "";
            for (var j = 0; j < level + 1; j++) level_padding += "    ";

            if (typeof(arr) == 'object') { //Array/Hashes/Objects
                for (var item in arr) {
                    var value = arr[item];

                    if (typeof(value) == 'object') { //If it is an array,
                        dumped_text += level_padding + "'" + item + "' ...\n";
                        dumped_text += dump(value, level + 1);
                    } else {
                        dumped_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
                    }
                }
            } else { //Strings/Chars/Numbers etc.
                dumped_text = "===>" + arr + "<===(" + typeof(arr) + ")";
            }
            return dumped_text;
        }
    </script>
    <script>
        $(document).ready(function () {
            $.get('{{asset('https://raw.githubusercontent.com/FortAwesome/Font-Awesome/master/advanced-options/metadata/icons.json')}}',
                function (data) {
                var icons = [];
                $.each(JSON.parse(data), function (index, icon) {
                    //get type of icon
                    var style = icon.styles[0];
                    var prefix = 'fa' + style.substring(0, 1);
                    var iconName = 'fa-' + index;
                    var label = icon.label;
                    var iconFullName = prefix + ' ' + iconName;
                    icons.push({id: iconFullName, title: label});
                });

                //show items in selectize
                $('.select').selectize({
                    maxItems: 1,
                    valueField: 'id',
                    searchField: 'title',
                    options: icons,
                    render: {
                        option: function (data, escape) {  // options to show
                            return '<div class="option">' +
                                '<i class="' + data.id + '"></i> ' + data.title +
                                '</div>';
                        },
                        item: function (data, escape) { //selected option
                            return '<div class="option">' +
                                '<i class="' + data.id + '"></i> ' + data.title +
                                '</div>';
                        }
                    },
                    create: function (input) { //create item
                        return {
                            id: input,
                            title: input,
                        };
                    }
                });

            });

        });
    </script>
@endsection
