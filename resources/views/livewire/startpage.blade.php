<div>
    <!--Content header (Page header)-->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="display-4">{{-- $pageTitle --}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                      <li class="breadcrumb-item"><a href="{{ route('admin.index')}}">Home</a></li>
                      <li class="breadcrumb-item active">{{-- $pageTitle --}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- AQUÍ VA EL CONTENIDO PRINCIPAL-->
        </div><!-- /.container-fluid -->
    </section>

    {{--@include('livewire.role.form')--}}
</div>
