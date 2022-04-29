{{-- @extends('adminlte::page', ['iFrameEnabled' => true]) --}}
@extends('adminlte::page')

@section('title', 'Credits')

@section('content_header')
     <!--Content header (Page header)-->
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="display-4">Credits</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                  <li class="breadcrumb-item active">Credits</li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
    <section class="content">
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Icons</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body" style="display: block;">
 {{--                <div>
                    <img src="{{url('vendor/adminlte/dist/img/veterinary.png')}}" class="img-rounded elevation-4 shadow shadow-sm mr-1" style="width: 20px; height: 20px; object-fit: cover;">
                    Icons made by <a href="https://www.freepik.com" title="Freepik">Freepik</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a>
                </div>
                <div>
                    <img src="{{url('vendor/adminlte/dist/img/veterinary.png')}}" class="img-rounded elevation-4 shadow shadow-sm mr-1" style="width: 20px; height: 20px; object-fit: cover;">
                    Icons made by <a href="https://www.freepik.com" title="Freepik">Freepik</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a>
                </div>
                <div>
                    <img src="{{url('vendor/adminlte/dist/img/veterinary.png')}}" class="img-rounded elevation-4 shadow shadow-sm mr-1" style="width: 20px; height: 20px; object-fit: cover;">
                    Icons made by <a href="https://www.freepik.com" title="Freepik">Freepik</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a>
                </div> --}}
                <div>
                    <img src="{{url('vendor/adminlte/dist/img/veterinary.png')}}" class="img-rounded elevation-4 shadow shadow-sm mr-1" style="width: 48px; height: auto; object-fit: cover;">
                    Icons made by <a href="https://www.freepik.com" title="Freepik">Freepik</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a>
                </div>
                <br>
{{--                 <div>
                    <img src="{{ url('vendor/adminlte/dist/img/doc.png') }}" class="img-rounded elevation-4 shadow shadow-sm mr-1" style="width: 48px; height: auto; object-fit: cover;">
                    Icon made by <a href="https://www.flaticon.com/free-icons/document" title="document icons">Document icons created by Smashicons - Flaticon</a>
                </div>
                <br>
                <div>
                    <img src="{{ url('vendor/adminlte/dist/img/pdf.png') }}" class="img-rounded elevation-4 shadow shadow-sm mr-1" style="width: 48px; height: auto; object-fit: cover;">
                    Icon made by <a href="https://www.flaticon.com/free-icons/pdf" title="pdf icons">Pdf icons created by Smashicons - Flaticon</a>
                </div> --}}

                <a href="https://www.flaticon.com/free-icons/file" title="file icons">File icons created by Roman Káčerek - Flaticon</a> <br>
                <a href="https://www.flaticon.com/free-icons/excel" title="excel icons">Excel icons created by Roman Káčerek - Flaticon</a> <br>
                <a href="https://www.flaticon.com/free-icons/file" title="file icons">File icons created by Roman Káčerek - Flaticon</a> <br>
                <a href="https://www.flaticon.com/free-icons/pdf" title="pdf icons">Pdf icons created by Roman Káčerek - Flaticon</a> <br>

            </div>
            <!-- /.card-body -->
            <div class="card-footer" style="display: block;">
            </div>
            <!-- /.card-footer-->
        </div>
        <!-- /.card -->

    </section>
@stop

@section('css')
    @livewireStyles
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    @livewireScripts
@stop
