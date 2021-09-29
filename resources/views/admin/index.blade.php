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

{{--     <script>

        // dark-mode media query matched or not
        let matched = window.matchMedia('(prefers-color-scheme: dark)').matches;

        if(matched) {
            document.body.classList.add('dark-mode')
        }

        // Enable and unable dark-mode
        var checkbox = document.getElementById('theme');

        checkbox.addEventListener('change', function() {
            if(this.checked) {
                document.body.classList.add('dark-mode')
            } else {
                document.body.classList.remove('dark-mode')
            }
        });

    </script>--}}
@stop

