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
					<div class="card">
						<div class="card-body text-center">
							<div class="mt-3 mb-4">
							  <img src="{{ $user->profile_photo_url }}"
							    class="rounded-circle img-fluid elevation-2 shadow" style="width: 100px; height: 100px; object-fit: cover;" alt="avatar" />
							</div>
							<h5 class="mb-2">{{ $user->name }}</h5>
							<p class="text-muted mb-4 text-uppercase text-sm">{{ $user->user_type }}{{--  <span class="mx-2">|</span> <a
							    href="#!">mdbootstrap.com</a> --}}
							</p>
							<div class="mb-4 pb-2">
								<a href="#!">
									<img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-2.webp" alt="avatar"
								  		class="img-fluid rounded-circle elevation-2 shadow mb-1 mx-n2" style="width: 35px; height: 35px; object-fit: cover;">
								</a>
								<a href="#!">
									<img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-3.webp" alt="avatar"
								  		class="img-fluid rounded-circle elevation-2 shadow  mb-1 mx-n2" style="width: 35px; height: 35px; object-fit: cover;">
								</a>
								<a href="#!">
									<img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-4.webp" alt="avatar"
								  		class="img-fluid rounded-circle elevation-2 shadow  mb-1 mx-n2"style="width: 35px; height: 35px; object-fit: cover;">
								</a>
							</div>

							<button type="button" class="btn btn-primary btn-rounded btn-block">
							  Contact now
							</button>

							<div class="d-flex justify-content-between text-center mt-5 mb-2">
								<div>
									<p class="mb-2 h5 text-bold">{{ $user->pets->where('status', 'Alive')->count() }}</p>
									<p class="text-muted mb-0">Active Pets</p>
								</div>
								<div class="px-3">
									<p class="mb-2 h5 text-bold">{{ $user->pets->where('status', 'Dead')->count() }}</p>
									<p class="text-muted mb-0">Inactive Pets</p>
								</div>
								<div>
									<p class="mb-2 h5 text-bold">{{ $user->pets->count() }}</p>
									<p class="text-muted mb-0">Total Pets</p>
								</div>
							</div>
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
 					@if(!empty($appointment))
						<div class="card">
							<div class="card-header">
								<h3 class="card-title">Appointment details</h3>
								<div class="card-tools">
									<button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
										<i class="fas fa-minus"></i>
									</button>
									<button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
										<i class="fas fa-times"></i>
									</button>
								</div>
							</div>
							<!-- /.header -->

							<div class="card-body">
								<div class="row">
									 <div class="col-12 col-md-12 col-lg-4 order-1">
										<h4>Info</h4>
										<h6 class="font-weight-bold">{{ $appointment->veterinarian->user->name }}, DVM</h6>
										<h6>
											<span class="font-weight-bold">DGP: </span>
											{{ $appointment->veterinarian->dgp }}
										</h6>
										<h6>
											<span class="font-weight-bold">Date: </span>
											{{ $appointment->start_time->format('j/F/Y') }}
										</h6>
										<h6>
											<span class="font-weight-bold">Time: </span>
											{{ $appointment->start_time->format('H:i') }} hrs
										</h6>
										<h6>
											<span class="font-weight-bold">Status: </span>
											{{ $appointment->canceled == 1 ? 'Canceled' : 'Confirmed' }}
										</h6>
									</div>
									<div class="col-12 col-md-12 col-lg-8 order-1">
										<div class="row">
											<div class="col-12">
												<h4>Booked services</h4>
												<div>
													<div class="table-responsive">
														<table class="table table-hover table-borderless table-sm">
															<thead>
															<tr>
																<th>ID</th>
																<th>Service</th>
																<th class="text-right">Price</th>
															</tr>
															</thead>
															<tbody>
																@foreach($appointment->services as $service)
																	<tr>
																		<td> {{ $service->id }} </td>
																		<td> {{ $service->service_name }}</td>
																		<td class="text-right"> ${{ number_format($service->price, 2) }} </td>
																	</tr>
																@endforeach
																<tr class="text-right">
																	<td scope="row"  colspan="2">Price expected</td>
																	<td>${{ number_format($appointment->price_expected, 2) }}</td>
																</tr>
																<tr class="text-right">
																	<td scope="row"  colspan="2">Discount</td>
																	<td> -${{ number_format($appointment->discount, 2) }}</td>
																</tr>
																<tr class="text-right font-weight-bold table-active">
																	<td scope="row"  colspan="2">Price final</td>
																	<td> ${{ number_format($appointment->price_final, 2) }}</td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
											</div>
										</div>
									</div>
									<!-- /.col -->
								</div>
							</div>
						</div>
 					@endif
					<div class="card">
						<div class="card-header p-2">
							<ul class="nav nav-pills">
{{-- 								<li class="nav-item">
									<a class="nav-link active" href="#calendar" data-toggle="tab">
										<i class="fas fa-calendar"></i>
									</a>
								</li> --}}
								<li class="nav-item">
									<a class="nav-link active" href="#pets" data-toggle="tab">
										<i class="fas fa-dog"></i>
									</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" href="#appointments" data-toggle="tab">
										<i class="fas fa-calendar-check"></i>
									</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" href="#dumpster" data-toggle="tab">
										<i class="fas fa-trash"></i>
									</a>
								</li>
							</ul>
						</div><!-- /.card-header -->
						<div class="card-body">
							<div class="tab-content">
{{-- 								<div class="active tab-pane" id="calendar">
									<livewire:calendar :user="$user">
								</div> --}}
								<!-- /.tab-pane -->

								<div class="active tab-pane" id="pets">
									{{-- @livewire('index-pets', ['user' => $user]) --}}
									{{-- @livewire('pets', ['user' => $user]) --}}
									<livewire:inline.pets :user="$user">
								</div>
								<!-- /.tab-pane php artisan livewire:clear-cache-->

								<div class="tab-pane" id="appointments">
									<livewire:inline.appointments :user="$user">
									 {{-- @livewire('appointments', ['user' => $user]) --}}
								</div>
								<!-- /.tab-pane -->

								<div class="tab-pane" id="dumpster">
									<livewire:inline.dumpster :user="$user">
									 {{-- @livewire('appointments', ['user' => $user]) --}}
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
	<!-- Alpine Plugins -->
	<script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/persist@3.x.x/dist/cdn.min.js"></script>
	@include('admin.layout.scripts')
@stop