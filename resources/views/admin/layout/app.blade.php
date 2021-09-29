{{-- @extends('adminlte::page', ['iFrameEnabled' => true]) --}}
@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content')
@stop

@section('css')
    @include('admin.layout.styles')
@stop


@section('js')
    @include('admin.layout.scripts')
@stop
