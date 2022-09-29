@extends('adminlte::page')

@section('title', 'Error 404')

@section('content_header')
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="display-4">404 | Page not found</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="{{ route('admin.index')}}">Home</a></li>
						<li class="breadcrumb-item active">Page not found</li>
					</ol>
				</div>
			</div>
		</div>
	</section>
@stop

@section('content')
	<section class="content">
		<div class="error-page">
			<h2 class="headline text-warning"> 404</h2>
			<div class="error-content">
				<h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Page not found.</h3>
				<p>
					We could not find the page you were looking for.
					Meanwhile, you may <a href="{{ route('admin.index')}}">return to dashboard</a> or try using the search form.
				</p>
				<form class="search-form">
					<div class="input-group">
						<input type="text" name="search" class="form-control" placeholder="Search">
						<div class="input-group-append">
							<button type="submit" name="submit" class="btn btn-warning"><i class="fas fa-search"></i>
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</section>
@stop

@section('css')
	@include('admin.layout.styles')
@stop

@section('js')
	@include('admin.layout.scripts')
@stop