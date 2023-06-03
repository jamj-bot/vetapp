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
                            <sup class="font-weight-light">Inactive</sup>
                        @endif
					</h1>
				</div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right text-sm">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.index')}}"><i class="fas fa-house-user"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.users') }}">Users</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.users.show', $pet->user) }}">{{ $pet->user->name }}</a>
                        </li>
                        <li class="breadcrumb-item active">
                            {{ $pet->name ? $pet->name:$pet->code }}
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
			        <div class="card mb-4">
						<div class="card-body text-center">
							<img src="{{$pet->pet_profile_photo ? asset('storage/pet-profile-photos/' . $pet->pet_profile_photo) : 'https://ui-avatars.com/api/?name='.$pet->name.'&color=FFF&background=random&size=128'}}" alt="avatar"
							  class="rounded-circle img-fluid elevation-2" style="width: 100px; height: 100px; object-fit: cover;">
							<h5 class="my-3">{{ $pet->name }}</h5>
							<p class="text-muted mb-1">1 open consultation(s)</p>
							<p class="text-muted mb-4">Vaccination schedule incompleted</p>
							{{-- <div class="d-flex justify-content-center mb-2"> --}}
						  		<a href="{{ route('admin.users.show', $pet->user) }}" class="btn btn-sm btn-block bg-gradient-lightblue">{{ $pet->user->name }}</a>
								{{-- <button type="button" class="btn btn-sm btn-block btn-outline-info">Message</button> --}}
							{{-- </div> --}}
						</div>
			        </div>
					<!-- /.card -->

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
										{{-- Consultations --}} <i class="fas fa-book-medical"></i>
									</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" href="#vaccinations" data-toggle="tab">
										{{-- Vaccinations --}} <i class="fas fa-syringe"></i>
										{{-- <sup class="py-0 px-1"><i class="fas fa-fw fa-circle text-danger"></i></sup> --}}
									</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" href="#dewormings" data-toggle="tab">
										{{-- Dewormings --}} <i class="fas fa-bug"></i>
										{{-- <sup class="py-0 px-1"><i class="fas fa-fw fa-circle text-warning"></i></sup> --}}
									</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" href="#images" data-toggle="tab">
										{{-- Pictures --}} <i class="fas fa-x-ray"></i>
										<sup class="py-0 px-1">{{ $pet->images->count() }}</sup>
									</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" href="#lab-tests" data-toggle="tab">
										{{-- Documents --}} <i class="fas fa-file-medical"></i>
										<sup class="py-0 px-1">{{ $pet->tests->count() }}</sup>
									</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" href="#weight-chart" data-toggle="tab">
										{{-- Wt chart --}} <i class="fas fa-weight"></i>
									</a>
								</li>

								<li class="nav-item">
									<a class="nav-link" href="#configuration" data-toggle="tab">
										<i class="fas fa-cogs"></i>
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
									@livewire('inline.vaccinations', ['pet' => $pet])
								</div>
								<!-- /.tab-pane -->

								<div class="tab-pane" id="dewormings">
									@livewire('inline.dewormings', ['pet' => $pet])
								</div>
								<!-- /.tab-pane -->

								<div class="tab-pane" id="images">
									@livewire('inline.recently-added-images', ['pet' => $pet])
								</div>
								<!-- /.tab-pane -->

								<div class="tab-pane" id="lab-tests">
									@livewire('inline.recently-added-tests', ['pet' => $pet])
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


								<div class="tab-pane" id="configuration">
									<ul class="nav nav-tabs" id="custom-content-above-tab" role="tablist">
									    <li class="nav-item">
									        <a class="nav-link active" id="photo-tab" data-toggle="pill" href="#photo" role="tab" aria-controls="photo" aria-selected="true">Pet profile photo</a>
									    </li>
									    <li class="nav-item">
									        <a class="nav-link" id="change-tab" data-toggle="pill" href="#change" role="tab" aria-controls="change" aria-selected="false">Ownership transfer</a>
									    </li>
									</ul>

{{-- 									<div class="tab-custom-content">
									    <p class="lead mb-0">Configuration</p>
									</div> --}}

									<div class="tab-content" id="custom-content-above-tabContent">
									    <div class="tab-pane fade active show" id="photo" role="tabpanel" aria-labelledby="photo-tab">
									        @livewire('pet-profile-photo', ['pet' => $pet, 'user' => $pet->user])
									    </div>
									    <div class="tab-pane fade" id="change" role="tabpanel" aria-labelledby="change-tab">
									    	@can('pets_change_owner')
									    		@livewire('select2-change-owner', ['pet' => $pet, 'user' => $pet->user])
											@else
												<h4 class="lead">Forbidden You don't have permission to change the owner</h4>
											@endcan
									    </div>
									</div>
								</div>
								<!-- /. tab-pane -->
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

@section('css')
	@include('admin.layout.styles')

	<!-- Chart Plugins -->
	<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"
		integrity="sha256-ErZ09KkZnzjpqcane4SCyyHsKAXMvID9/xwbl/Aq1pc="
		crossorigin="anonymous">
	</script>
@stop

@section('js')
	<!-- Alpine Plugins -->
	<script defer src="https://unpkg.com/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
	<script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/persist@3.x.x/dist/cdn.min.js"></script>

	@include('admin.layout.scripts')
@stop