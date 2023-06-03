{{-- @extends('adminlte::page', ['iFrameEnabled' => true]) --}}
@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <p>Welcome to this beautiful admin panel.</p>
{{--     <label for="darkMode">
        <input type="checkbox" name="darkMode" id="theme">
        Dark mode
    </label> --}}

@stop

@section('css')
    @livewireStyles
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

    @livewireScripts
@section('js')

@stop

