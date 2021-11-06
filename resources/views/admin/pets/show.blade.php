@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="display-4">{{ $pet->name }}</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
					  <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
					   <li class="breadcrumb-item"><a href="{{ route('admin.users') }}">Users</a></li>
					   <li class="breadcrumb-item"><a href="{{ route('admin.users.show', $pet->user) }}">{{ $pet->user->name }}</a></li>
					  <li class="breadcrumb-item active">{{ $pet->name }}</li>
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

					<a href="{{ route('admin.users.show', $pet->user) }}"
						class="btn btn-block btn-default mb-3">
						<i class="far fa-arrow-alt-circle-left"></i>
						Owner
					</a>


{{-- 					<!-- Profile Image -->
					<div class="card card-primary card-outline font-weight-light">
						<div class="card-body box-profile">
							<div class="text-center">
								<img class="profile-user-img img-fluid img-circle shadow"
									loading="lazy"
									src="{{ $pet->user->profile_photo_url }}"
									style="width: 100px; height: 100px; object-fit: cover;"
									alt="User profile picture">
							</div>

							<h3 class="profile-username text-center"><a href="{{ route('admin.users.show', $pet->user) }}">{{ $pet->user->name }}</a></h3> --}}

{{-- 							<p class="text-muted text-center mb-0">
								{{ $pet->user->name }}
							</p> --}}

{{-- 							<ul class="list-group list-group-unbordered mb-3">
								<li class="list-group-item">
									<b>Vaccinations</b>
									<a class="float-right text-primary">
										{{-- $pet->pets->where('status', 'Alive')->count() --}}
{{-- 									</a>
								</li>
								<li class="list-group-item">
									<b>Appointments</b>
									<a class="float-right text-danger">
										{{-- $pet->pets->where('status', 'Dead')->count() --}}
{{-- 									</a>
								</li>
								<li class="list-group-item">
									<b>Consultations</b>
									<a class="float-right">
										{{-- $pet->pets->count() --}}
{{-- 									</a>
								</li>
							</ul> --}}

							{{-- <a href="#" class="btn btn-primary btn-block"><b>Create</b></a> --}}
{{-- 						</div>
						<!-- /.card-body -->
					</div>
					<!-- /.card --> --}}

					<!-- About Me Box -->
					<div class="card card-primary font-weight-light">
						<div class="card-header">
							<h3 class="card-title">About {{ $pet->name }}</h3>
							<span class="float-right badge badge-dark">{{ $pet->status == 'Dead' ? 'Dead':''}}</span>
						</div>
						<!-- /.card-header -->
						<div class="card-body">
							<strong><i class="fas fa-fw fa-fingerprint mr-1"></i> Code</strong>

							<p class="text-muted">
								{{ $pet->code }}
							</p>

							<hr>
							<strong><i class="fas fa-fw fa-paw mr-1"></i> Species</strong>

							<p class="text-muted">
								{{ $pet->species->name }} / <span class="font-italic">{{ $pet->species->scientific_name }}</span>
							</p>

							<hr>
							<strong><i class="fas fa-fw fa-award mr-1"></i> Breed</strong>

							<p class="text-muted">
								{{ $pet->breed }}
							</p>

							<hr>

							<strong><i class="fas fa-fw fa-hard-hat mr-1"></i> Zootechnical function</strong>

							<p class="text-muted">
								{{ $pet->zootechnical_function }}
							</p>

							<hr>

							<strong><i class="fas fa-fw fa-venus mr-1"></i> Sex</strong>

							<p class="text-muted">
								{{ $pet->sex }}
							</p>

							<hr>

							<strong><i class="fas fa-fw fa-neuter mr-1"></i> Neutered / Spayed</strong>

							<p class="text-muted">
								{{ $pet->neuteredOrSpayed }}
							</p>

							<hr>

							<strong><i class="fas fa-fw fa-birthday-cake mr-1"></i> DOB</strong>

							<p class="text-muted">
								{{ $pet->dob->format('d-M-Y') }} /

								@if($pet->dob->diffInDays(\Carbon\Carbon::now()) < 59)
									{{ $pet->dob->diffInDays(\Carbon\Carbon::now()) }} days
								@elseif($pet->dob->diffInDays(\Carbon\Carbon::now()) >= 60 && $pet->dob->diffInMonths(\Carbon\Carbon::now()) < 24)
									{{ $pet->dob->diffInMonths(\Carbon\Carbon::now())}} months
								@elseif($pet->dob->diffInMonths(\Carbon\Carbon::now()) >= 24)
									{{ $pet->dob->diffInYears(\Carbon\Carbon::now()) }} years
								@endif
							</p>

							<hr>

							<strong><i class="fas fa-fw fa-calendar mr-1"></i> Registered</strong>

							<p class="text-muted">
								{{ $pet->created_at->diffForHumans() }}
							</p>

							<hr>

							<strong><i class="fas fa-fw fa-door-open mr-1"></i> Items</strong>
							<p class="text-muted">
								<a href="{{ route('admin.pets.consultations', $pet) }}">Consultas de la mascota</a>
							</p>
							<p class="text-muted">
								<span class="tag tag-danger">UI Design</span>
								<span class="tag tag-success">Coding</span>
								<span class="tag tag-info">Javascript</span>
								<span class="tag tag-warning">PHP</span>
								<span class="tag tag-primary">Node.js</span>
							</p>

							<hr>

							<strong><i class="far fa-file-alt mr-1"></i> Diseases</strong>

							<p class="text-muted">{{ $pet->diseases }}</p>
						</div>
						<!-- /.card-body -->
					</div>
					<!-- /.card -->
				</div>
				<!-- /.col -->


				<div class="col-md-9">

                    @if($pet->diseases)
						<div class="callout callout-warning alert alert-dismissible">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  			<h5>Pre-existing conditions</h5>
                  			{{ $pet->diseases }}
                		</div>
                    @endif
                    @if($pet->allergies)
                        <div class="callout callout-danger alert alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h5>Allergies</h5>
                            {{ $pet->allergies }}
                        </div>
                    @endif

					<div class="card">
						<div class="card-header p-2">
							<ul class="nav nav-pills">
								<li class="nav-item"><a class="nav-link active" href="#consultations" data-toggle="tab">Consultations</a></li>
								<li class="nav-item"><a class="nav-link" href="#vaccinations" data-toggle="tab">Vaccinations</a></li>
								<li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Timeline</a></li>
								<li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Deworming</a></li>
							</ul>
						</div><!-- /.card-header -->
						<div class="card-body">
							<div class="tab-content">
								<div class="active tab-pane" id="consultations">

									<!-- Consultations link -->
									<div class="small-box font-weight-light">
						              	<div class="inner">
						                	<h4>{{ $consultations_quantity }} registered consultations</h4>
						                	<p>{{$open_consultations_quantity}} open consultation</p>
						              	</div>

						              	<div class="icon">
						                	<i class="fas fa-stethoscope"></i>
						              	</div>

						              	<a href="{{ route('admin.pets.consultations', $pet) }}" class="small-box-footer">
						                	<span class="text-muted">Go to consultations <i class="fas fa-arrow-circle-right"></i></span>
						              	</a>
						            </div>
									<!-- ./ Consultations link -->


{{-- 									<!-- Post -->
									<div class="post">
										<div class="user-block">
											<img class="img-circle img-bordered-sm" src="{{ $pet->profile_photo_url }}" alt="user image">
											<span class="username">
												<a href="#">Jonathan Burke Jr.</a>
												<a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
											</span>
											<span class="description">Shared publicly - 7:30 PM today</span>
										</div>
										<!-- /.user-block -->
										<p>
											Lorem ipsum represents a long-held tradition for designers,
											typographers and the like. Some people hate it and argue for
											its demise, but others ignore the hate as they create awesome
											tools to help create filler text for everyone from bacon lovers
											to Charlie Sheen fans.
										</p>

										<p>
											<a href="#" class="link-black text-sm mr-2"><i class="fas fa-share mr-1"></i> Share</a>
											<a href="#" class="link-black text-sm"><i class="far fa-thumbs-up mr-1"></i> Like</a>
											<span class="float-right">
												<a href="#" class="link-black text-sm">
													<i class="far fa-comments mr-1"></i> Comments (5)
												</a>
											</span>
										</p>

										<input class="form-control form-control-sm" type="text" placeholder="Type a comment">
									</div>
									<!-- /.post -->

									<!-- Post -->
									<div class="post clearfix">
										<div class="user-block">
											<img class="img-circle img-bordered-sm" src="{{ $pet->profile_photo_url }}" alt="User Image">
											<span class="username">
												<a href="#">Sarah Ross</a>
												<a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
											</span>
											<span class="description">Sent you a message - 3 days ago</span>
										</div>
										<!-- /.user-block -->
										<p>
											Lorem ipsum represents a long-held tradition for designers,
											typographers and the like. Some people hate it and argue for
											its demise, but others ignore the hate as they create awesome
											tools to help create filler text for everyone from bacon lovers
											to Charlie Sheen fans.
										</p>

										<form class="form-horizontal">
											<div class="input-group input-group-sm mb-0">
												<input class="form-control form-control-sm" placeholder="Response">
												<div class="input-group-append">
													<button type="submit" class="btn btn-danger">Send</button>
												</div>
											</div>
										</form>
									</div>
									<!-- /.post -->

									<!-- Post -->
									<div class="post">
										<div class="user-block">
											<img class="img-circle img-bordered-sm" src="{{ $pet->profile_photo_url }}" alt="User Image">
											<span class="username">
												<a href="#">Adam Jones</a>
												<a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
											</span>
											<span class="description">Posted 5 photos - 5 days ago</span>
										</div>
										<!-- /.user-block -->
										<div class="row mb-3">
											<div class="col-sm-6">
												<img class="img-fluid" src="{{ $pet->profile_photo_url }}" alt="Photo">
											</div>
											<!-- /.col -->
											<div class="col-sm-6">
												<div class="row">
													<div class="col-sm-6">
														<img class="img-fluid mb-3" src="{{ $pet->profile_photo_url }}" alt="Photo">
														<img class="img-fluid" src="{{ $pet->profile_photo_url }}" alt="Photo">
													</div>
													<!-- /.col -->
													<div class="col-sm-6">
														<img class="img-fluid mb-3" src="{{ $pet->profile_photo_url }}" alt="Photo">
														<img class="img-fluid" src="{{ $pet->profile_photo_url }}" alt="Photo">
													</div>
													<!-- /.col -->
												</div>
												<!-- /.row -->
											</div>
											<!-- /.col -->
										</div>
										<!-- /.row -->

										<p>
											<a href="#" class="link-black text-sm mr-2"><i class="fas fa-share mr-1"></i> Share</a>
											<a href="#" class="link-black text-sm"><i class="far fa-thumbs-up mr-1"></i> Like</a>
											<span class="float-right">
												<a href="#" class="link-black text-sm">
													<i class="far fa-comments mr-1"></i> Comments (5)
												</a>
											</span>
										</p>

										<input class="form-control form-control-sm" type="text" placeholder="Type a comment">
									</div>
									<!-- /.post --> --}}
								</div>
								<!-- /.tab-pane -->

								<div class="tab-pane" id="vaccinations">
									@livewire('vaccinations', ['pet' => $pet])
								</div>
								<!-- /.tab-pane -->

								<div class="tab-pane" id="timeline">
									The timeline
									<div class="timeline timeline-inverse">
										<!-- timeline time label -->
										<div class="time-label">
											<span class="bg-danger">
												10 Feb. 2014
											</span>
										</div>
										<!-- /.timeline-label -->
										<!-- timeline item -->
										<div>
											<i class="fas fa-envelope bg-primary"></i>

											<div class="timeline-item">
												<span class="time"><i class="far fa-clock"></i> 12:05</span>

												<h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>

												<div class="timeline-body">
													Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
													weebly ning heekya handango imeem plugg dopplr jibjab, movity
													jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
													quora plaxo ideeli hulu weebly balihoo...
												</div>
												<div class="timeline-footer">
													<a href="#" class="btn btn-primary btn-sm">Read more</a>
													<a href="#" class="btn btn-danger btn-sm">Delete</a>
												</div>
											</div>
										</div>
										<!-- END timeline item -->
										<!-- timeline item -->
										<div>
											<i class="fas fa-user bg-info"></i>

											<div class="timeline-item">
												<span class="time"><i class="far fa-clock"></i> 5 mins ago</span>

												<h3 class="timeline-header border-0"><a href="#">Sarah Young</a> accepted your friend request
												</h3>
											</div>
										</div>
										<!-- END timeline item -->
										<!-- timeline item -->
										<div>
											<i class="fas fa-comments bg-warning"></i>

											<div class="timeline-item">
												<span class="time"><i class="far fa-clock"></i> 27 mins ago</span>

												<h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>

												<div class="timeline-body">
													Take me to your leader!
													Switzerland is small and neutral!
													We are more like Germany, ambitious and misunderstood!
												</div>
												<div class="timeline-footer">
													<a href="#" class="btn btn-warning btn-flat btn-sm">View comment</a>
												</div>
											</div>
										</div>
										<!-- END timeline item -->
										<!-- timeline time label -->
										<div class="time-label">
											<span class="bg-success">
												3 Jan. 2014
											</span>
										</div>
										<!-- /.timeline-label -->
										<!-- timeline item -->
										<div>
											<i class="fas fa-camera bg-purple"></i>

											<div class="timeline-item">
												<span class="time"><i class="far fa-clock"></i> 2 days ago</span>

												<h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>

												<div class="timeline-body">
													<img src="https://placehold.it/150x100" alt="...">
													<img src="https://placehold.it/150x100" alt="...">
													<img src="https://placehold.it/150x100" alt="...">
													<img src="https://placehold.it/150x100" alt="...">
												</div>
											</div>
										</div>
										<!-- END timeline item -->
										<div>
											<i class="far fa-clock bg-gray"></i>
										</div>
									</div>
								</div>
								<!-- /.tab-pane -->

								<div class="tab-pane" id="settings">
{{-- 									<form class="form-horizontal">
										<div class="form-group row">
											<label for="inputName" class="col-sm-2 col-form-label">Name</label>
											<div class="col-sm-10">
												<input type="email" class="form-control" id="inputName" placeholder="Name">
											</div>
										</div>
										<div class="form-group row">
											<label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
											<div class="col-sm-10">
												<input type="email" class="form-control" id="inputEmail" placeholder="Email">
											</div>
										</div>
										<div class="form-group row">
											<label for="inputName2" class="col-sm-2 col-form-label">Name</label>
											<div class="col-sm-10">
												<input type="text" class="form-control" id="inputName2" placeholder="Name">
											</div>
										</div>
										<div class="form-group row">
											<label for="inputExperience" class="col-sm-2 col-form-label">Experience</label>
											<div class="col-sm-10">
												<textarea class="form-control" id="inputExperience" placeholder="Experience"></textarea>
											</div>
										</div>
										<div class="form-group row">
											<label for="inputSkills" class="col-sm-2 col-form-label">Skills</label>
											<div class="col-sm-10">
												<input type="text" class="form-control" id="inputSkills" placeholder="Skills">
											</div>
										</div>
										<div class="form-group row">
											<div class="offset-sm-2 col-sm-10">
												<div class="checkbox">
													<label>
														<input type="checkbox"> I agree to the <a href="#">terms and conditions</a>
													</label>
												</div>
											</div>
										</div>
										<div class="form-group row">
											<div class="offset-sm-2 col-sm-10">
												<button type="submit" class="btn btn-danger">Submit</button>
											</div>
										</div>
									</form> --}}
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
		</div>
		<!-- /.container-fluid -->
	</section>
@stop

@section('css')
	@include('admin.layout.styles')
@stop

@section('js')
	@include('admin.layout.scripts')
@stop