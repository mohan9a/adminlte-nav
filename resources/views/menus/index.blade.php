@extends('adminlte::page')
@section('title', 'Menus')
@section('content_header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1>Menus</h1>
    </div>
    {{-- <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Simple Tables</li>
        </ol>
    </div> --}}
    <div class="col-sm-6">
        <a href="{{ route('menus.create') }}" class="float-sm-right btn btn-sm btn-primary"><b>Add Menu</b></a>
    </div>
</div>
@stop

@section('plugins.Datatables', true)
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Small boxes (Stat box) -->
    <div class="card card-primary card-outline">
        <div class="card-body">
        
            <table id="menus_tbl" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th width="10%">{{ __("No") }}</th>
                        <th width="45%">{{ __("Name") }}</th>
                        <th width="45%">{{ __("Action") }}</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($menus as $menu)
                        <tr>
                            <th scope="row">{{ $menu->id }}</th>
                            <td>{{ $menu->name }}</td>
                            <td>
                                <a class="btn btn-sm btn-success" href="{{ route('menus.builder',$menu->id) }}" title="View">
                                    <span class="fa fa-list"></span> Builder
                                </a>
                                
                                <a class="btn btn-sm btn-secondary" href="{{ route('menus.edit',$menu->id) }}" title="Edit">
                                    <span class="fa fa-edit"></span> Edit
                                </a>
                                
                                <a class="btn btn-sm btn-danger" onclick="deleteRow({{$menu->id}});" data-url="#" href="javascript:;" title="Delete">
                                    <span class="fa fa-trash"></span> Delete
                                </a>
                            </td>
                        </tr>
                        @endforeach

                </tbody>
            </table>
        </div>
        
        {{-- Pagination --}}
        <div class="card-footer clearfix">
            {!! $menus->links() !!}
        </div>
          
        
</div>
    <!-- /.row -->
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
    <style>
        i.fa.fa-times.no {
            color: red;
        }
        i.fa.fa-check.yes {
            color: green;
        }
        #menus_tbl_wrapper { width: 100%; }
    </style>
@stop
@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>    
<script type="text/javascript">
function deleteRow(id) {
    debugger;
    var token = $("meta[name='csrf-token']").attr("content");

    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            //window.location = $("#"+id).data('url');
            $.ajax({
                type:"DELETE",
                url: "menus/"+id,
                data: {
                    "id": id,
                    "_token": token,
                },
                dataType: 'json',
                success: function(res){
                    //show toaster
                    Swal.fire( 'Deleted!', 'Menu has been deleted.', 'success' )
                    setTimeout(function () {
                        location.reload(true);
                    }, 1000);
                }
            });
        }
    })
    return false;
}
</script>
@stop