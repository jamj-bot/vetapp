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
                    <ol class="breadcrumb float-sm-right text-sm">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.index')}}"><i class="fas fa-house-user"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.users') }}">Users</a>
                        </li>
                        <li class="breadcrumb-item active">
                            {{ $user->name }}
                        </li>
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
					<div class="card card-widget widget-user">
						<div class="widget-user-header text-white" style="background: url('https://cdn.pixabay.com/photo/2016/06/02/02/25/background-1430099_960_720.png') center center;">
							{{--<h3 class="widget-user-username text-right">Elizabeth Pierce</h3>--}}
							<h5 class="widget-user-desc text-right text-uppercase">{{ $user->user_type }}</h5>
						</div>
						<div class="widget-user-image">
							<img class="img-fluid img-circle elevation-2 shadow"
								loading="lazy"
								src="{{ $user->profile_photo_url }}"
								style="width: 100px; height: 100px; object-fit: cover;"
								alt="User profile picture">
						</div>
						<div class="card-footer p-0">
							<ul class="nav flex-column pt-5">
								<li class="nav-item">
									<span class="nav-link text-black">
										Active pets
										<span class="float-right badge bg-primary">{{ $user->pets->where('status', 'Alive')->count() }}</span>
									</span>
								</li>
								<li class="nav-item">
									<span class="nav-link text-black">
										Dead pets
										<span class="float-right badge bg-dark">{{ $user->pets->where('status', 'Dead')->count() }}</span>
									</span>
								</li>
							</ul>
						</div>
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

{{-- 							<p class="text-muted">
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

							<p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p> --}}
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
								<li class="nav-item">
									<a class="nav-link active" href="#pets" data-toggle="tab">
										<i class="fas fa-dog"></i>
									</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" href="#timeline" data-toggle="tab">
										<i class="fas fa-clock"></i>
									</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" href="#add_pet" data-toggle="tab">
										<i class="fas fa-user-cog"></i>
									</a>
								</li>
							</ul>
						</div><!-- /.card-header -->
						<div class="card-body">
							<div class="tab-content">

								<div class="active tab-pane" id="pets">
									{{-- @livewire('index-pets', ['user' => $user]) --}}
									{{-- @livewire('pets', ['user' => $user]) --}}
									<livewire:pets :user="$user">
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