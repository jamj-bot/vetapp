@extends('adminlte::page')

@section('title', $user->name)

@section('content_header')
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="display-4">{{ $user->name }}</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
					  <li class="breadcrumb-item"><a href="{{ route('admin.index')}}">Home</a></li>
					   <li class="breadcrumb-item"><a href="{{ route('admin.users')}}">Users</a></li>
					  <li class="breadcrumb-item active">{{ $user->name }}</li>
					</ol>
				</div>
			</div>
		</div>
	</section>
@stop

@section('content')
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-3">

					<!-- Profile Image -->
					<div class="card card-primary card-outline font-weight-light">
						<div class="card-body box-profile">
							<div class="text-center">
								<img class="profile-user-img img-fluid img-circle shadow"
									loading="lazy"
									src="{{ $user->profile_photo_url }}"
									style="width: 100px; height: 100px; object-fit: cover;"
									alt="User profile picture">
							</div>

							<h3 class="profile-username text-center">{{ $user->name }}</h3>

							<p class="text-muted text-center">{{ $user->user_type }}</p>

							<ul class="list-group list-group-unbordered mb-3">
								<li class="list-group-item">
									<b>Live pets</b>
									<a class="float-right text-success">
										{{ $user->pets->where('status', 'Alive')->count() }}
									</a>
								</li>
								<li class="list-group-item">
									<b>Dead pets</b>
									<a class="float-right text-danger">
										{{ $user->pets->where('status', 'Dead')->count() }}
									</a>
								</li>
								<li class="list-group-item">
									<b>Total pets</b>
									<a class="float-right">
										{{ $user->pets->count() }}
									</a>
								</li>
							</ul>

							<a href="#" class="btn btn-primary btn-block"><b>Create</b></a>
						</div>
						<!-- /.card-body -->
					</div>
					<!-- /.card -->

					<!-- About Me Box -->
					<div class="card card-primary font-weight-light">
						<div class="card-header">
							<h3 class="card-title">About Me</h3>
						</div>
						<!-- /.card-header -->
						<div class="card-body">
							<strong><i class="fas fa-fw fa-envelope mr-1"></i> Email</strong>

							<p class="text-muted">
								{{ $user->email }}
							</p>

							<hr>

							<strong><i class="fas fa-fw fa-phone mr-1"></i> Phone</strong>

							<p class="text-muted">
								{{ $user->phone }}
							</p>

							<hr>

							<strong><i class="fas fa-fw fa-calendar mr-1"></i> Registered</strong>

							<p class="text-muted">
								{{ $user->created_at->diffForHumans() }}
							</p>

							<hr>

							<strong><i class="fas fa-fw fa-calendar mr-1"></i> Updated</strong>

							<p class="text-muted">
								{{ $user->updated_at->diffForHumans() }}
							</p>

							<hr>

							<strong><i class="fas fa-fw fa-door-open mr-1"></i> Items</strong>

							<p class="text-muted">
								<span class="tag tag-danger">UI Design</span>
								<span class="tag tag-success">Coding</span>
								<span class="tag tag-info">Javascript</span>
								<span class="tag tag-warning">PHP</span>
								<span class="tag tag-primary">Node.js</span>
							</p>

							<hr>

							<strong><i class="far fa-file-alt mr-1"></i> Notes</strong>

							<p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
						</div>
						<!-- /.card-body -->
					</div>
					<!-- /.card -->
				</div>
				<!-- /.col -->

				<div class="col-md-9">
					<div class="card">
						<div class="card-header p-2">
							<ul class="nav nav-pills">
								<li class="nav-item"><a class="nav-link active" href="#pets" data-toggle="tab">Pets</a></li>
								<li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Timeline</a></li>
								<li class="nav-item"><a class="nav-link" href="#add_pet" data-toggle="tab">Add Pet</a></li>
							</ul>
						</div><!-- /.card-header -->
						<div class="card-body">
							<div class="tab-content">

								<div class="active tab-pane" id="pets">
									{{-- @livewire('index-pets', ['user' => $user]) --}}
									@livewire('pets', ['user' => $user])
								</div>
								<!-- /.tab-pane -->

								<div class="tab-pane" id="timeline">
									Timeline
								</div>
								<!-- /.tab-pane -->

								<div class="tab-pane" id="add_pet">
									Add pet
								</div>
								<!-- /.tab-pane -->
							</div>
							<!-- /.tab-content -->
						</div><!-- /.card-body -->
					</div>
					<!-- /.card -->
				</div>
				<!-- /.col -->
			</div>
			<!-- /.row -->
		</div><!-- /.container-fluid -->
	</section>
@stop

@section('css')
	@include('admin.layout.styles')
@stop

@section('js')
	@include('admin.layout.scripts')
@stop