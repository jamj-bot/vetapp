@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="display-4">
						{{ $pet->name != null ? $pet->name : $pet->code }}
						@if($pet->status == 'Dead')
		                    <sup><i class="fas fa-cross"></i></sup>
		                @endif
					</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
					  <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
					   <li class="breadcrumb-item"><a href="{{ route('admin.users') }}">Users</a></li>
					   <li class="breadcrumb-item"><a href="{{ route('admin.users.show', $pet->user) }}">{{ $pet->user->name }}</a></li>
					  <li class="breadcrumb-item active">@if($pet->name) {{ $pet->name }} @else {{ $pet->code }} @endif </li>
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

                    <!-- about card -->
                    @include('common.about-card')
                    <!-- /.card -->
				</div>
				<!-- /.col -->


				<div class="col-md-9">
					<!-- Alerts -->
					@include('common.alerts')
                    <!-- /.Alerts -->

					<div class="card">
						<div class="card-header p-2">
							<ul class="nav nav-pills">
								<li class="nav-item">
									<a class="nav-link active" href="#consultations" data-toggle="tab">
										Consultations
									</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" href="#vaccinations" data-toggle="tab">
										Vaccinations
										{{-- <sup class="py-0 px-1"><i class="fas fa-fw fa-circle text-danger"></i></sup> --}}
									</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" href="#dewormings" data-toggle="tab">
										Dewormings
										{{-- <sup class="py-0 px-1"><i class="fas fa-fw fa-circle text-warning"></i></sup> --}}
									</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" href="#images" data-toggle="tab">
										Pictures
										<sup class="py-0 px-1">{{ $pet->images->count() }}</sup>
									</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" href="#lab-tests" data-toggle="tab">
										Documents
										<sup class="py-0 px-1">{{ $pet->tests->count() }}</sup>
									</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" href="#weight-chart" data-toggle="tab">
										Wt chart
									</a>
								</li>
							</ul>
						</div><!-- /.card-header -->
						<div class="card-body">
							<div class="tab-content">
								<div class="active tab-pane" id="consultations">
									<!-- Consultations link -->
									<div class="small-box font-weight-light">
						              	<div class="inner">
											<ol class="fa-ul">
											    <li>
											    	<span class="fa-li"><i class="fas fa-check-square text-success"></i></span>
											    	{{ $open_consultations }} open consultations
											    </li>
											    <li>
											    	<span class="fa-li"><i class="fas fa-times-circle text-danger"></i></span>
											    	{{ $closed_consultations }} closed consultations
											    </li>
											    <li>
											    	<span class="fa-li"><i class="fas fa-plus"></i></span>
											    	{{ $total_consultations }} total consultations
											    </li>
											    <li>
											    	<span class="fa-li"><i class="far fa-trash-alt text-muted"></i></span>
											    	{{ $trashed_consultations }} trashed consultations
											    </li>
											 </ol>
						              	</div>

						              	<div class="icon">
						                	<i class="fas fa-stethoscope"></i>
						              	</div>

						              	<a href="{{ route('admin.pets.consultations', $pet) }}"
						              		class="small-box-footer pt-3 pb-3">
						                	<span class="text-muted">
						                		Go to consultations
						                		<i class="fas fa-arrow-circle-right"></i>
						                	</span>
						              	</a>
						            </div>
									<!-- ./ Consultations link -->
								</div>
								<!-- /.tab-pane -->

								<div class="tab-pane" id="vaccinations">
									@livewire('vaccinations', ['pet' => $pet])
								</div>
								<!-- /.tab-pane -->

								<div class="tab-pane" id="dewormings">
									@livewire('dewormings', ['pet' => $pet])
								</div>
								<!-- /.tab-pane -->

								<div class="tab-pane" id="images">
									<div class="card">
									  	<div class="card-header border-transparent">
									    	<h3 class="card-title">
                								Pictures
            								</h3>

									    	<div class="card-tools">
									      		<!-- Maximize Button -->
									      		<button type="button" class="btn btn-tool pt-3" data-card-widget="maximize">
									      			<i class="fas fa-expand"></i>
									      		</button>
									    	</div>
									    <!-- /.card-tools -->
									  	</div>
									  	<!-- /.card-header -->
									  	<div class="card-body">
											<div class="row ">
												@forelse($pet->images as $image)
													<div class="col-sm-12 col-md-4 col-lg-3 text-center">
														<div class="border border-1 rounded-top mb-1 overflow-hidden">
															<!-- Button trigger modal -->
															<a href="javascript:void(0)" data-toggle="modal" data-target="#modalImages"
																onclick="changeSrcHref('{{ asset('/storage/'.$image->url) }}', '{{url('admin/pets/'.$pet->id.'/consultations/'.$image->imageable_id)}}')"
																title="View">
																<img src="{{ asset('/storage/'. $image->url) }}"
																	class="img-fluid"
																	style="width: 100%; height: 120px; object-fit: cover;" alt="Image">
															</a>
														</div>

														<div class="mb-3 border border-1 rounded-bottom overflow-hidden">
														    <p class="text-xs m-1" title="{{ $image->name }}">
															    @if( strlen($image->name) > 30)
	                                                                {{ substr($image->name, 0, 27) }}...
	                                                            @else
	                                                                {{ $image->name }}
	                                                            @endif
                                                            </p>
															<a href="{{route('admin.pets.consultations.show', ['pet' => $pet, 'consultation' => $image->imageable]) }}"
																class="btn btn-block btn-default btn-xs btn-flat border border-0"
																target="_blank"
																rel="noopener noreferrer">
																Consultation {{ $image->imageable_id }}
																<i class="fas fa-fw fa-external-link-alt"></i>
															</a>
														</div>
													</div>
												@empty
													<div class="container">
														<div class="row text-center text-muted pt-3">
														    <div class="col-12">
														        <svg xmlns="http://www.w3.org/2000/svg" width="76" height="76" fill="currentColor" class="bi bi-images" viewBox="0 0 16 16">
														          <path d="M4.502 9a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z"/>
														          <path d="M14.002 13a2 2 0 0 1-2 2h-10a2 2 0 0 1-2-2V5A2 2 0 0 1 2 3a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v8a2 2 0 0 1-1.998 2zM14 2H4a1 1 0 0 0-1 1h9.002a2 2 0 0 1 2 2v7A1 1 0 0 0 15 11V3a1 1 0 0 0-1-1zM2.002 4a1 1 0 0 0-1 1v8l2.646-2.354a.5.5 0 0 1 .63-.062l2.66 1.773 3.71-3.71a.5.5 0 0 1 .577-.094l1.777 1.947V5a1 1 0 0 0-1-1h-10z"/>
														        </svg>
														    </div>
														    <div class="col-12">
															    <p class="text-lg lead">
															         No attached images
															    </p>
														    </div>
														 </div>
													</div>
												@endforelse
											</div>
									  	</div>

									  	<!-- /.card-body -->
									</div>
									<!-- /.card -->
								</div>
								<!-- /.tab-pane -->

								<div class="tab-pane" id="lab-tests">
									<div class="card">
										<div class="card-header border-transparent">
											<h3 class="card-title">
												Documents
											</h3>
											<div class="card-tools">
								                <!-- Maximize Button -->
								                <button type="button" class="btn btn-tool pt-3" data-card-widget="maximize">
								                    <i class="fas fa-expand"></i>
								                </button>
								            </div>
										</div>
										<!-- /.card-header -->

										<div class="card-body">
                                            <div class="row">
                                                @forelse($pet->tests as $test)
                                                    <div class="col-sm-12 col-md-4 col-lg-3 text-center">

                                                        <div class="border border-1 rounded-top mb-1 p-1 overflow-hidden bg-gradient-navy">
                                                            <!-- Button trigger modal -->
                                                            <a href="javascript:void(0)" data-toggle="modal" data-target="#modalImages"
                                                                onclick="changeSrcHref('{{ asset('/storage/'. $test->url) }}', '{{url('admin/pets/'.$pet->id.'/consultations/'.$test->testable_id)}}', '2048px')"
                                                                title="View">
                                                                <img src="{{ url('vendor/adminlte/dist/img/pdf.png') }}"
                                                                    style="width: 64px; height: 64px; object-fit: cover;">
                                                            </a>
                                                        </div>

														<div class="mb-3 border border-1 rounded-bottom overflow-hidden">
														    <p class="text-xs m-1" title="{{ $test->name }}">
															    @if( strlen($test->name) > 30)
	                                                                {{ substr($test->name, 0, 27) }}...
	                                                            @else
	                                                                {{ $test->name }}
	                                                            @endif
                                                            </p>
															<a href="{{route('admin.pets.consultations.show', ['pet' => $pet, 'consultation' => $test->testable]) }}"
																class="btn btn-block btn-default btn-xs btn-flat border border-0"
																target="_blank"
																rel="noopener noreferrer">
																Consultation {{ $test->testable_id }}
																<i class="fas fa-fw fa-external-link-alt"></i>
															</a>
														</div>
                                                    </div>
                                                @empty
                                                    <div class="container">
                                                        <div class="row text-center text-muted pt-3">
                                                            <div class="col-12">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="76" height="76" fill="currentColor" class="bi bi-filetype-pdf" viewBox="0 0 16 16">
                                                                    <path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5L14 4.5ZM1.6 11.85H0v3.999h.791v-1.342h.803c.287 0 .531-.057.732-.173.203-.117.358-.275.463-.474a1.42 1.42 0 0 0 .161-.677c0-.25-.053-.476-.158-.677a1.176 1.176 0 0 0-.46-.477c-.2-.12-.443-.179-.732-.179Zm.545 1.333a.795.795 0 0 1-.085.38.574.574 0 0 1-.238.241.794.794 0 0 1-.375.082H.788V12.48h.66c.218 0 .389.06.512.181.123.122.185.296.185.522Zm1.217-1.333v3.999h1.46c.401 0 .734-.08.998-.237a1.45 1.45 0 0 0 .595-.689c.13-.3.196-.662.196-1.084 0-.42-.065-.778-.196-1.075a1.426 1.426 0 0 0-.589-.68c-.264-.156-.599-.234-1.005-.234H3.362Zm.791.645h.563c.248 0 .45.05.609.152a.89.89 0 0 1 .354.454c.079.201.118.452.118.753a2.3 2.3 0 0 1-.068.592 1.14 1.14 0 0 1-.196.422.8.8 0 0 1-.334.252 1.298 1.298 0 0 1-.483.082h-.563v-2.707Zm3.743 1.763v1.591h-.79V11.85h2.548v.653H7.896v1.117h1.606v.638H7.896Z"/>
                                                                </svg>
                                                            </div>
                                                            <div class="col-12">
                                                                <p class="text-lg lead">
                                                                     No attached documents
                                                                </p>
                                                            </div>
                                                         </div>
                                                    </div>
                                                @endforelse
                                            </div>
										</div>
									</div>
								</div>
								<!-- /.tab-pane -->

								<div class="tab-pane" id="weight-chart">
									<canvas id="myChart" width="400" height="400"></canvas>
									<script>
										const weights_chart = {!! json_encode($weights_chart->toArray()) !!};
										const data = [];
										const data2 = [];

										for (var i = weights_chart.length - 1; i >= 0; i--) {
											data[i] = weights_chart[i].weight;
											data2[i] = weights_chart[i].weight * 5 ;
										}

										const labels = [];
										for (var i = 0; i < weights_chart.length; i++) {
											labels[i] = i+1
										}

										const ctx = document.getElementById('myChart').getContext('2d');
										const myChart = new Chart(ctx, {
										    type: 'bar',
										    data: {
										        labels: labels,
										        datasets: [
											        {
											            label: 'bars',
											            data: data,
											            backgroundColor: [
											                'rgba(255, 99, 132, 0.4)',
											                'rgba(54, 162, 235, 0.4)',
											                'rgba(255, 206, 86, 0.4)',
											                'rgba(75, 192, 192, 0.4)',
											                'rgba(153, 102, 255, 0.4)',
											                'rgba(255, 159, 64, 0.4)'
											            ],
											            borderColor: [
											                'rgba(255, 99, 132, 1)',
											                'rgba(54, 162, 235, 1)',
											                'rgba(255, 206, 86, 1)',
											                'rgba(75, 192, 192, 1)',
											                'rgba(153, 102, 255, 1)',
											                'rgba(255, 159, 64, 1)'
											            ],
											            borderWidth: 1,
											            pointStyle: 'triangle',
											      		pointRadius: 5,
											      		pointHoverRadius: 10,
											      		order: 1
											        },
											        {
											            label: 'lines',
											            data: data,
											            backgroundColor: [
											                'rgba(255, 99, 132, 0.4)',
											                'rgba(54, 162, 235, 0.4)',
											                'rgba(255, 206, 86, 0.4)',
											                'rgba(75, 192, 192, 0.4)',
											                'rgba(153, 102, 255, 0.4)',
											                'rgba(255, 159, 64, 0.4)'
											            ],
											            borderColor: [
											                'rgba(255, 99, 132, 1)',
											                'rgba(54, 162, 235, 1)',
											                'rgba(255, 206, 86, 1)',
											                'rgba(75, 192, 192, 1)',
											                'rgba(153, 102, 255, 1)',
											                'rgba(255, 159, 64, 1)'
											            ],
											            borderWidth: 1,
											            pointStyle: 'circle',
											      		pointRadius: 3,
											      		pointHoverRadius: 5,
											      		type: 'line',
											      		order: 0
											        }
										        ]
										    },
										  	options: {
										    	responsive: true,
										    	plugins: {
										      		title: {
										        		display: true,
										        		// text: (ctx) => 'Point Style: ' + ctx.chart.data.datasets[0].pointStyle,
										        		text: 'Weight chart',
										      		}
										    	}
										  	}
										});
									</script>
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
	@include('common.modal-image')
@stop

<!-- Alpine Plugins -->
<script defer src="https://unpkg.com/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"
	integrity="sha256-ErZ09KkZnzjpqcane4SCyyHsKAXMvID9/xwbl/Aq1pc="
	crossorigin="anonymous">
</script>

@section('css')
	@include('admin.layout.styles')
@stop

@section('js')
	@include('admin.layout.scripts')
<script type="text/javascript">
    function changeSrcHref(source, link, height = null) {
        document.getElementById('myObject').data=source
        document.getElementById('myAnchor').href=link

        if (height) {
            document.getElementById('myObject').height = height
        } else {
        	document.getElementById('myObject').height = ''
        }
    }
</script>
@stop