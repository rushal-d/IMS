@extends('layouts.master')
@section('title','Menu Builder')
@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet"/>
    <style type="text/css">
        .permission-list {
            min-height: 70vh;
            overflow-y: scroll;
            max-height: 70vh;
            -webkit-box-shadow: 10px 10px 31px -6px rgba(0, 0, 0, 0.75);
            -moz-box-shadow: 10px 10px 31px -6px rgba(0, 0, 0, 0.75);
            box-shadow: 10px 10px 31px -6px rgba(0, 0, 0, 0.75);
        }

        .scroll {
            margin-left: 15px;
        }

        .selectize-control {
            position: relative;
            display: none;
        }

        .selectize-input {
            min-height: 25px !important;
        }

        .selectize-control.select.single {
            margin: -5px 0px -7px 0px;
        }

        .custom-row .col-md-4 {
            padding: 0px 6px !important;
            height: 25px;
        }

        a, a:visited {

            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        pre, code {
            font-size: 12px;
        }

        pre {
            width: 100%;
            overflow: auto;
        }

        small {
            font-size: 90%;
        }

        small code {
            font-size: 11px;
        }

        .placeholder {
            outline: 1px dashed #4183C4;
        }

        .mjs-nestedSortable-error {
            background: #fbe3e4;
            border-color: transparent;
        }

        #tree {
            width: 550px;
            margin: 0;
        }

        ol {
            max-width: 800px;
            padding-left: 25px;
        }

        ol.sortable, ol.sortable ol {
            list-style-type: none;
        }

        .sortable li div {

            -webkit-border-radius: 3px;
            -moz-border-radius: 3px;
            border-radius: 3px;
            cursor: move;
            border-color: #D4D4D4 #D4D4D4 #BCBCBC;
            margin: 0;
            padding: 0 3px 3px 3px;
            width: 100%;
        }

        li.mjs-nestedSortable-collapsed.mjs-nestedSortable-hovering div {
            border-color: #999;
        }

        .disclose, .expandEditor {
            cursor: pointer;
            width: 20px;
            display: none;
        }

        .sortable li.mjs-nestedSortable-collapsed > ol {
            display: none;
        }

        .sortable li.mjs-nestedSortable-branch > div > .disclose {
            display: inline-block;
        }

        .sortable span.ui-icon {
            display: inline-block;
            margin: 0;
            padding: 0;
        }

        .menuDiv {
            border: 1px solid #d4d4d4;
            background: #EBEBEB;
        }

        .menuEdit {
            background: #FFF;
        }

        .itemTitle {
            vertical-align: middle;
            cursor: pointer;
        }

        .deleteMenu {
            float: right;
            cursor: pointer;
        }

        h1 {
            font-size: 2em;
            margin-bottom: 0;
        }

        h2 {
            font-size: 1.2em;
            font-weight: 400;
            font-style: italic;
            margin-top: .2em;
            margin-bottom: 1.5em;
        }

        h3 {
            font-size: 1em;
            margin: 1em 0 .3em;
        }

        p, ol, ul, pre, form {
            margin-top: 0;
            margin-bottom: 1em;
        }

        dl {
            margin: 0;
        }

        dd {
            margin: 0;
            padding: 0 0 0 1.5em;
        }

        code {
            background: #e5e5e5;
        }

        input {
            vertical-align: text-bottom;
        }

        .notice {
            color: #c33;
        }

        form input {
            margin-top: 0px;
        }

    </style>
    <style>
        span.help-block.form-error {
            display: block;
            position: initial;
        }
    </style>

@endsection
@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="form-title text-center">Menu Builder</div>
                    </div>
                    <div class="card-body">
                        <button class="btn btn-sm btn-success" type="button" data-toggle="modal"
                                data-target="#newHeading">Add Menu Heading
                        </button>
                        <a class="btn btn-primary btn-sm" href="javascript:void(0);" id="send-menu-to-kb"><i
                                    class="fa fa-upload"></i>
                            Send Menu to KB
                        </a>

                        <a class="btn btn-danger btn-sm" href="javascript:void(0);" id="get-menu-from-kb"><i
                                    class="fa fa-download"></i>
                            Download Menu From KB
                        </a>
                        <div class="modal fade" id="newHeading" tabindex="-1" role="dialog"
                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Menu Heading</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="text" class="form-control" id="menu_heading" value="#">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                                        </button>
                                        <button type="button" class="btn btn-primary" id="add_menu_heading"
                                                data-dismiss="modal">Save changes
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-3 permission-list">
                <input type="text" id="search_item">
                <button class="button button-search">Search</button>

                <div class="scroll">
                    @foreach($permissions as $permission)
                        {{$permission->name}}
                        <input type="hidden" class="menu_name" value="{{$permission->name}}">
                        <input type="checkbox" class="route" value="{{$permission->id}}"
                               style="position: absolute;right: 30px;"
                               @if(in_array($permission->id,$menu_ids))
                               checked
                                @endif
                        ><br>
                        <div style="border-bottom: 1px solid blue"></div>
                    @endforeach
                </div>
            </div>

            <div class="col-md-9">
                <section id="demo">
                    <form action="{{route('display-name-store')}}" method="post"
                          id="display_name_store">
                        @csrf
                        <ol class="sortable">
                            @each('entrust.menu.menu-recursive', $menus, 'permission')
                        </ol>
                    </form>
                    <p class="text-center"><input id="toArray" name="toArray" type="button" value=
                        "Build Menu" class="btn btn-warning"></p>
                </section>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="iconModal" role="dialog" aria-labelledby="iconModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="iconModalLabel">Select an icon</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal-for-select-icon">
                    <select id="select-icon" class="select2"></select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="save-changes-icon-modal">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="alertDialog" tabindex="-1" role="dialog" aria-labelledby="alertDialogLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="alertDialog-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="alertDialog-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
    <link rel="stylesheet" href="{{asset('css/jquery-ui.css')}}"/>
    <script src="{{asset('js/jquery-ui.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/nestedSortable.js')}}"></script>
    <script>
        let input_field = '';
        let icon_display_field = '';
        $(document).on('click', '.choose-icon-button', function () {
            var menu_for = $(this).data('menu-name');
            input_field = $(this).prev();
            icon_display_field = $(this).prev().prev();
            $('#iconModal').attr('data-from-menu', menu_for);
            $('#iconModal').modal('show');
        });
        // $('.select2')[0].selectize.destroy();
        $('#select-icon').on('select2:select', function (e) {
            var new_selected_icon_value = $("#select-icon").val();
            input_field.val(new_selected_icon_value);
            icon_display_field.html('<i class="' + new_selected_icon_value + '"></i>');
            $('#iconModal').modal('hide');
        });

        $('.input-field-for-icon').keyup(function (e) {
            // e.previousSibling.html = '<i class="'+this.value+'"></i>';
            $(this).prev().html('<i class="' + this.value + '"></i>');
        });

        $('#iconModal').ready(function () {
            $.get('{{asset('fontawesome/icons.json')}}', function (data) {
                var icons = [];
                $.each(data, function (index, icon) {
                    //get type of icon
                    var style = icon.styles[0];
                    var prefix = 'fa' + style.substring(0, 1);
                    var iconName = 'fa-' + index;
                    var label = icon.label;
                    var iconFullName = prefix + ' ' + iconName;
                    var icon_label = '<i class="' + iconFullName + '"></i> ' + label;
                    icons.push({id: iconFullName, text: label, data: id = iconFullName});
                });

                function iformat(icon) {
                    var originalOption = icon;
                    return $('<span><i class="fa ' + $(originalOption).attr('id') + '"></i> ' + icon.text + '</span>');
                }

                $('#select-icon').select2({
                    data: icons,
                    width: "100%",
                    templateSelection: iformat,
                    templateResult: iformat,
                    allowHtml: true
                });
            });


        });
    </script>

    <script>
        var delay = (function () {
            var timer = 0;
            return function (callback, ms) {
                clearTimeout(timer);
                timer = setTimeout(callback, ms);
            };
        })();

        $('#search_item').keyup(function () {
            delay(function () {
                search();
            }, 1000)
        });
        $('.button-search').click(function () {
            search()
        });

        $('#menu_heading').keyup(function () {
            if (this.value.indexOf('#') !== 0) {
                this.value = '#' + this.value;
            }
        });

        $('#add_menu_heading').click(function () {
            new_menu_heading = $('#menu_heading').val();
            $.ajax({
                url: '{{route('permission.add')}}',
                type: 'post',
                data: {
                    '_token': '{{csrf_token()}}',
                    'name': new_menu_heading,
                    'isAjax': 1,
                },
                success: function (data) {
                    // console.log(data);
                    // addToSortable(data['id'], new_menu_heading);
                    replace_div = new_menu_heading;
                    replace_div += '<input type="hidden" class="menu_name" value="' + new_menu_heading + '">';
                    replace_div += '<input type="checkbox" class="route" value="' + data['id'] + '"' +
                        '                                               style="position: absolute;right: 30px;"'
                    replace_div += "checked=checked";
                    replace_div += '><br>';
                    replace_div += '<div style="border-bottom: 1px solid blue"></div>';
                    $('.scroll').append(replace_div);

                }
            });
        });

        function search() {
            search_item = $('#search_item').val();
            $.ajax({
                url: '{{route('menu.search')}}',
                type: 'get',
                data: {
                    'search': search_item
                },
                success: function (data) {
                    var replace_div = "<div class=\"scroll\">";
                    $.each(data['permission'], function (index, value) {
                        replace_div += value['name'];
                        replace_div += '<input type="hidden" class="menu_name" value="' + value['name'] + '">';
                        replace_div += '<input type="checkbox" class="route" value="' + value['id'] + '"' +
                            '                                               style="position: absolute;right: 30px;"'
                        if (data['menu'].includes(value['id'])) {
                            replace_div += "checked=checked";
                        }
                        replace_div += '><br>';
                        replace_div += '   <div style="border-bottom: 1px solid blue"></div>';
                    });
                    replace_div += '</div>';
                    $('.scroll').remove();
                    $('.permission-list').append(replace_div);
                }
            });


        }

        $(document).on('change', '.route', function () {

            var menu_name = $(this).prev().val();
            var id = $(this).val();
            if ($(this).is(":checked")) {
                addToSortable(id, menu_name)
            } else {
                $.ajax({
                    url: '{{route('menu.delete')}}',
                    type: 'post',
                    data: {
                        '_token': '{{csrf_token()}}',
                        'id': id
                    },
                    success: function (data) {
                        if (data == "success") {
                            new_parent = $('#menuItem_' + id).parent();
                            console.log(new_parent);
                            inner_element = $('#menuItem_' + id).find('ol li');
                            length = inner_element.length;
                            for (i = 0; i < length; i++) {
                                new_parent.append(inner_element[i]);
                            }
                            $('#menuItem_' + id).remove();
                        }
                    }
                });
            }
        });

        function addToSortable(id, menu_name) {

            $.ajax({
                url: '{{route('menu.store')}}',
                type: 'post',
                data: {
                    '_token': '{{csrf_token()}}',
                    'id': id,
                    'order': 0,
                    'menu_name': menu_name
                },
                success: function (data) {
                    if (data == "success") {
                        listItem = '<li style="display: list-item;" class="mjs-nestedSortable-leaf" id="menuItem_' + id + '">\n' +
                            '    <div class="row custom-row menuDiv">\n' +
                            '        <div data-id="' + id + '" class="itemTitle">\n' +
                            '          <div class="row">\n' +
                            '            <div class="col-md-4">\n' +
                            '                <span title="Click to show/hide children" class="disclose ui-icon ui-icon-minusthick">\n' +
                            '                    <span></span>\n' +
                            '                </span>' + menu_name +
                            '            </div>\n' +
                            '            <div class="col-md-4"> <input type="text" class="" name="permission[' + menu_name + '][display_name]" value=""></div>\n' +
                            '            <div class="col-md-4">\n' +
                            '<div class="input-group">\n' +
                            '                        <div class="input-group-append">\n' +
                            '                            <i style="font-size: 2em" id="permission[][icon]" class=""></i>\n' +
                            '                            <input type="text" id="permission[' + menu_name + '][name]" name="permission[' + menu_name + '][icon]" value="" class="input-field-for-icon">\n' +
                            '                            <span class="input-group-text choose-icon-button" data-menu-name="' + menu_name + '">Choose icon</span>\n' +
                            '                        </div>\n' +
                            '                    </div>' +
                            '            </div>\n' +
                            '        </div>\n' +
                            '    </div>\n' +
                            ' </div>\n' +
                            '    \n' +
                            '    </li>';
                        $('.sortable').append(listItem);
                    }
                }
            });
        }
    </script>


    <script>

        $().ready(function () {
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

                (typeof ($('#toHierarchyOutput')[0].textContent) != 'undefined') ?
                    $('#toHierarchyOutput')[0].textContent = hiered : $('#toHierarchyOutput')[0].innerText = hiered;
            });

            $('#toArray').click(function (e) {

                arraied = $('ol.sortable').nestedSortable('toArray', {startDepthCount: 0});
                var json = JSON.stringify(arraied);
                var token = $('input[name=_token]').val();
                $.ajax({
                    url: "{{route('menu.build')}}",
                    type: "POST",
                    dataType: "json",
                    data: {
                        '_token': token,
                        "menu": arraied,
                    },
                    success: function (msg) {
                        $('#display_name_store').submit();
                    }
                });
            });
        });

        $('#send-menu-to-kb').click(function () {
            $.ajax({
                url: '{{route('send-menu-to-kb')}}',
                success: function (response) {
                    if (response) {
                        $('#alertDialog-title').text('Response !')
                        $('#alertDialog-body').text(response)
                        $('#alertDialog').modal();
                    } else {
                        $('#alertDialog-title').text('Response !')
                        $('#alertDialog-body').text(response)
                        $('#alertDialog').modal();
                    }
                }
            })
        });

        $('#get-menu-from-kb').click(function () {
            $.ajax({
                url: '{{route('get-menu-from-kb')}}',
                success: function (response) {
                    if (response) {
                        $('#alertDialog-title').text('Response!')
                        $('#alertDialog-body').text(response)
                        $('#alertDialog').modal();
                    } else {
                        $('#alertDialog-title').text('Response!')
                        $('#alertDialog-body').text(response)
                        $('#alertDialog').modal();
                    }
                }
            })
        });

    </script>

@endsection
