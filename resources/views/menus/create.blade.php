@extends('adminlte::page')
@section('title', 'Add Menu')
@section('content_header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1>Add Menu</h1>
    </div>
    {{-- <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Simple Tables</li>
        </ol>
    </div> --}}
    <div class="col-sm-6">
        <a href="{{ route('menus.index') }}" class="float-sm-right btn btn-sm btn-secondary"><b>Back</b></a>
    </div>
</div>
@stop

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Small boxes (Stat box) -->
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card card-primary card-outline">
        <form action="{{ route('menus.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" value="" placeholder="Enter menu name" class="form-control" />
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
    <!-- /.row -->
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop
@section('js')

@stop