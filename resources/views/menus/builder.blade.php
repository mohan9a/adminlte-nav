@extends('adminlte::page')
@section('title', 'Menus')
@section('content_header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1>Menu Builder</h1>
    </div>
    {{-- <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Simple Tables</li>
        </ol>
    </div> --}}
    <div class="col-sm-6">
        <a class="float-sm-right btn btn-sm btn-secondary " href="{{ route('menus.index'); }}"><b>Back</b></a>
        <div class="float-sm-right btn btn-sm btn-primary add_item mr-2"><b>Add Menu Item</b></div>
        
    </div>
</div>
@stop

@section('plugins.Datatables', true)
@section('content')

    @include('adminltenav::menus.partial.notice')

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Small boxes (Stat box) -->
    <div class="card card-primary card-outline">
        <div class="card-body">
            <div class="dd">
                {!! menu($menu->name, 'admin' ) !!}
            </div>            
        </div>
        
</div>
    <!-- /.row -->

    {{-- Delete box --}}
    <div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><i class="fa fa-trash"></i>  Are you sure you want to delete this menu item?</h4>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('menus.item.destroy', ['menu' => $menu->id, 'id' => '__id']) }}"
                          id="delete_form"
                          method="POST">
                        {{ method_field("DELETE") }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger pull-right delete-confirm"
                               value="Delete Menu Item">
                    </form>
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cancel</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


    {{-- add/edit box --}}

    <div class="modal modal-info fade" tabindex="-1" id="menu_item_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 id="m_hd_add" class="modal-title hidden"><i class="fa fa-fw fa-plus"></i> Create a New Menu Item</h4>
                    <h4 id="m_hd_edit" class="modal-title hidden"><i class="fa fa-fw fa-times"></i> Edit Menu Item</h4>
                </div>
                <form action="" id="m_form" method="POST"
                      data-action-add="{{ route('menus.item.add', ['menu' => $menu->id]) }}"
                      data-action-update="{{ route('menus.item.update', ['menu' => $menu->id]) }}"
                      >

                    <input id="m_form_method" type="hidden" name="_method" value="POST">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div>
                            <label for="name">Title of the Menu Item</label>
                            <input type="text" class="form-control" id="m_title" name="title" placeholder="Title"><br>
                        </div>
                        <label for="type">Link type</label>
                        <select id="m_link_type" class="form-control" name="type">
                            <option value="url" selected="selected">Static URL</option>
                            <option value="route">Dynamic URL</option>
                        </select><br>
                        <div id="m_url_type">
                            <label for="url">URL for the Menu Item</label>
                            <input type="text" class="form-control" id="m_url" name="url" placeholder="URL"><br>
                        </div>
                        <div id="m_route_type">
                            <label for="route">Route for the menu item</label>
                            <input type="text" class="form-control" id="m_route" name="route" placeholder="Route"><br>
                            <label for="parameters">Route parameters (if any)</label>
                            <textarea rows="3" class="form-control" id="m_parameters" name="parameters" placeholder="{{ json_encode(['key' => 'value'], JSON_PRETTY_PRINT) }}"></textarea><br>
                        </div>
                        <label for="icon_class">Font Icon class for the Menu Item 
                            <a href="#" target="_blank">Test</a></label>
                        <input type="text" class="form-control" id="m_icon_class" name="icon_class"
                               placeholder="Icon Class (optional)"><br>
                        <label for="target">Open In</label>
                        <select id="m_target" class="form-control" name="target">
                            <option value="_self" selected="selected">Same Tab/Window</option>
                            <option value="_blank">New Tab/Window</option>
                        </select>
                        <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                        <input type="hidden" name="id" id="m_id" value="">
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-success pull-right delete-confirm__" value="Add">
                        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
    <style>
    .colored-toast.swal2-icon-success {
    background-color: #a5dc86 !important;
    }

    .colored-toast.swal2-icon-error {
    background-color: #f27474 !important;
    }

    .colored-toast.swal2-icon-warning {
    background-color: #f8bb86 !important;
    }

    .colored-toast.swal2-icon-info {
    background-color: #3fc3ee !important;
    }

    .colored-toast.swal2-icon-question {
    background-color: #87adbd !important;
    }

    .colored-toast .swal2-title {
    color: white;
    }

    .colored-toast .swal2-close {
    color: white;
    }

    .colored-toast .swal2-html-container {
    color: white;
    }
    </style>

    <style>
        code {
            border: 1px solid #bcd8f1;
        }
        code, kbd {
            padding: 2px 4px;
            font-size: 90%;
        }
        code {
            color: #c7254e;
            background-color: #f9f2f4;
            border-radius: 4px;
        }



        .dd .item_actions {
            z-index: 9;
            position: relative;
            top: 10px;
            right: 10px
        }

        .dd .item_actions .delete,
        .dd .item_actions .edit {
            cursor: pointer
        }

        .dd .item_actions .edit {
            margin-right: 5px
        }

        .dd .dd-handle .url {
            font-weight: 400;
            margin-left: 10px
        }

        .dd {
            font-size: 13px;
            line-height: 20px
        }

        .dd,
        .dd-list {
            position: relative;
            display: block;
            margin: 0;
            padding: 0;
            list-style: none
        }

        .dd-list .dd-list {
            padding-left: 30px
        }

        .dd-collapsed .dd-list {
            display: none
        }

        .dd-empty,
        .dd-item,
        .dd-placeholder {
            display: block;
            position: relative;
            margin: 0;
            padding: 0;
            min-height: 20px;
            font-size: 13px;
            line-height: 20px
        }

        .dd-handle {
            display: block;
            height: 50px;
            margin: 5px 0;
            padding: 14px 25px;
            color: #333;
            text-decoration: none;
            font-weight: 700;
            border: 1px solid #ccc;
            background: #fafafa;
            border-radius: 3px;
            box-sizing: border-box;
            -moz-box-sizing: border-box
        }

        .dd-handle:hover {
            color: #2ea8e5;
            background: #fff
        }

        .dd-item>button {
            display: block;
            position: relative;
            cursor: pointer;
            float: left;
            width: 40px;
            height: 37px;
            margin: 5px 0;
            padding: 0;
            text-indent: 100%;
            white-space: nowrap;
            overflow: hidden;
            border: 0;
            background: transparent;
            font-size: 12px;
            line-height: 1;
            text-align: center;
            font-weight: 700
        }

        .dd-item>button:before {
            content: "+";
            display: block;
            position: absolute;
            width: 100%;
            text-align: center;
            text-indent: 0
        }

        .dd-item>button[data-action=collapse]:before {
            content: "-"
        }

        .dd-empty,
        .dd-placeholder {
            margin: 5px 0;
            padding: 0;
            min-height: 30px;
            background: #f2fbff;
            border: 1px dashed #b6bcbf;
            box-sizing: border-box;
            -moz-box-sizing: border-box
        }

        .dd-empty {
            border: 1px dashed #bbb;
            min-height: 100px;
            background-color: #e5e5e5;
            background-image: linear-gradient(45deg, #fff 25%, transparent 0, transparent 75%, #fff 0, #fff), linear-gradient(45deg, #fff 25%, transparent 0, transparent 75%, #fff 0, #fff);
            background-size: 60px 60px;
            background-position: 0 0, 30px 30px
        }

        .dd-dragel {
            position: absolute;
            pointer-events: none;
            z-index: 9999
        }

        .dd-dragel>.dd-item .dd-handle {
            margin-top: 0
        }

        .dd-dragel .dd-handle {
            box-shadow: 2px 4px 6px 0 rgba(0, 0, 0, .1)
        }

        .nestable-lists {
            display: block;
            clear: both;
            padding: 30px 0;
            width: 100%;
            border: 0;
            border-top: 2px solid #ddd;
            border-bottom: 2px solid #ddd
        }

        #nestable-menu {
            padding: 0;
            margin: 20px 0
        }

        #nestable2-output,
        #nestable-output {
            width: 100%;
            height: 7em;
            font-size: .75em;
            line-height: 1.333333em;
            font-family: Consolas, monospace;
            padding: 5px;
            box-sizing: border-box;
            -moz-box-sizing: border-box
        }

        #nestable2 .dd-handle {
            color: #fff;
            border: 1px solid #999;
            background: #bbb;
            background: linear-gradient(180deg, #bbb 0, #999)
        }

        .menus .table>tbody>tr>td {
            line-height: 44px
        }

        #nestable2 .dd-handle:hover {
            background: #bbb
        }

        #nestable2 .dd-item>button:before {
            color: #fff
        }

        @media only screen and (min-width: 700px) {
            .dd {
                float: left;
                width: 100%
            }

            .dd+.dd {
                margin-left: 2%
            }
        }

        .dd-hover>.dd-handle {
            background: #2ea8e5 !important
        }

        .dd3-content {
            display: block;
            height: 30px;
            margin: 5px 0;
            padding: 5px 10px 5px 40px;
            color: #333;
            text-decoration: none;
            font-weight: 700;
            border: 1px solid #ccc;
            background: #fafafa;
            background: linear-gradient(180deg, #fafafa 0, #eee);
            border-radius: 3px;
            box-sizing: border-box;
            -moz-box-sizing: border-box
        }

        .dd3-content:hover {
            color: #2ea8e5;
            background: #fff
        }

        .dd-dragel>.dd3-item>.dd3-content {
            margin: 0
        }

        .dd3-item>button {
            margin-left: 30px
        }

        .dd3-handle {
            position: absolute;
            margin: 0;
            left: 0;
            top: 0;
            cursor: pointer;
            width: 30px;
            text-indent: 100%;
            white-space: nowrap;
            overflow: hidden;
            border: 1px solid #aaa;
            background: #ddd;
            background: linear-gradient(180deg, #ddd 0, #bbb);
            border-top-right-radius: 0;
            border-bottom-right-radius: 0
        }

        .dd3-handle:before {
            content: "≡";
            display: block;
            position: absolute;
            left: 0;
            top: 3px;
            width: 100%;
            text-align: center;
            text-indent: 0;
            color: #fff;
            font-size: 20px;
            font-weight: 400
        }

        .dd3-handle:hover {
            background: #ddd
        }
        .pull-right {
            float: right!important;
        }

        
        //mistake not added in media query
        .modal-dialog {
            width: 600px;
            margin: 30px auto;
        }
    </style>

    
@stop
@section('js')

<script type="text/javascript" src="https://dbushell.github.io/Nestable/jquery.nestable.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> 
<script type="text/javascript">
    var Toast;
    $(document).ready(function () {
        $('.dd').nestable({
                expandBtnHTML: '',
                collapseBtnHTML: ''
        });

        Toast = Swal.mixin({
            toast: true,
            position: 'top-right',
            iconColor: 'white',
            customClass: {
                popup: 'colored-toast'
            },
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true
            })

        /**
         * Reorder items
         */
        $('.dd').on('change', function (e) {
            $.post('{{ route('menus.order_item',['menu' => $menu->id]) }}', {
                order: JSON.stringify($('.dd').nestable('serialize')),
                _token: '{{ csrf_token() }}'
            }, function (data) {
                //toastr.success("{{ __('voyager::menu_builder.updated_order') }}");
                 Toast.fire({ icon: 'success', title: 'Menu order successfully changed.' })
            });
        });

        /**
         * Set Variables
         */
            var $m_modal       = $('#menu_item_modal'),
            $m_hd_add      = $('#m_hd_add').hide().removeClass('hidden'),
            $m_hd_edit     = $('#m_hd_edit').hide().removeClass('hidden'),
            $m_form        = $('#m_form'),
            $m_form_method = $('#m_form_method'),
            $m_title       = $('#m_title'),
            $m_title_i18n  = $('#title_i18n'),
            $m_url_type    = $('#m_url_type'),
            $m_url         = $('#m_url'),
            $m_link_type   = $('#m_link_type'),
            $m_route_type  = $('#m_route_type'),
            $m_route       = $('#m_route'),
            $m_parameters  = $('#m_parameters'),
            $m_icon_class  = $('#m_icon_class'),
            $m_color       = $('#m_color'),
            $m_target      = $('#m_target'),
            $m_id          = $('#m_id');

        /**
         * Add Menu
         */
            $('.add_item').click(function() {
            $m_form.trigger('reset');
            $m_form.find("input[type=submit]").val('Add');
            $m_modal.modal('show', {data: null});
        });

        /**
         * Edit Menu
         */
            $('.item_actions').on('click', '.edit', function (e) {
            $m_form.find("input[type=submit]").val('Update');
            $m_modal.modal('show', {data: $(e.currentTarget)});
        });

        /**
         * Menu Modal is Open
         */
            $m_modal.on('show.bs.modal', function(e, data) {
            var _adding      = e.relatedTarget.data ? false : true,
                translatable = $m_modal.data('multilingual'),
                $_str_i18n   = '';

            if (_adding) {
                $m_form.attr('action', $m_form.data('action-add'));
                $m_form_method.val('POST');
                $m_hd_add.show();
                $m_hd_edit.hide();
                $m_target.val('_self').change();
                $m_link_type.val('url').change();
                $m_url.val('');
                $m_icon_class.val('');

            } else {
                $m_form.attr('action', $m_form.data('action-update'));
                $m_form_method.val('PUT');
                $m_hd_add.hide();
                $m_hd_edit.show();

                var _src = e.relatedTarget.data, // the source
                    id   = _src.data('id');

                $m_title.val(_src.data('title'));
                $m_url.val(_src.data('url'));
                $m_route.val(_src.data('route'));
                $m_parameters.val(JSON.stringify(_src.data('parameters')));
                $m_icon_class.val(_src.data('icon_class'));
                $m_color.val(_src.data('color'));
                $m_id.val(id);

                if(translatable){
                    $_str_i18n = $("#title" + id + "_i18n").val();
                }

                if (_src.data('target') == '_self') {
                    $m_target.val('_self').change();
                } else if (_src.data('target') == '_blank') {
                    $m_target.find("option[value='_self']").removeAttr('selected');
                    $m_target.find("option[value='_blank']").attr('selected', 'selected');
                    $m_target.val('_blank');
                }
                if (_src.data('route') != "") {
                    $m_link_type.val('route').change();
                    $m_url_type.hide();
                } else {
                    $m_link_type.val('url').change();
                    $m_route_type.hide();
                }
                if ($m_link_type.val() == 'route') {
                    $m_url_type.hide();
                    $m_route_type.show();
                } else {
                    $m_route_type.hide();
                    $m_url_type.show();
                }
            }

            if (translatable) {
                $m_title_i18n.val($_str_i18n);
                translatable.refresh();
            }
        });

        /**
         * Toggle Form Menu Type
         */
            $m_link_type.on('change', function (e) {
            if ($m_link_type.val() == 'route') {
                $m_url_type.hide();
                $m_route_type.show();
            } else {
                $m_url_type.show();
                $m_route_type.hide();
            }
        });

        /**
         * Delete menu item
         */
        $('.item_actions').on('click', '.delete', function (e) {
            id = $(e.currentTarget).data('id');
            $('#delete_form')[0].action = '{{ route('menus.item.destroy', ['menu' => $menu->id, 'id' => '__id']) }}'.replace('__id', id);
            $('#delete_modal').modal('show');
        });
        
    });
</script>
@stop