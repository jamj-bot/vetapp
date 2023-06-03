<div>
    <!--Content header (Page header)-->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="display-4">{{ $pageTitle }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right text-sm">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.index')}}"><i class="fas fa-house-user"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.veterinarians') }}">Veterinarians</a>
                        </li>
                        <li class="breadcrumb-item active">
                            {{ $user->name }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
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

{{--                             <div class="mb-4 pb-2">
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
                            </div> --}}

                            <button type="button" class="btn bg-gradient-purple btn-rounded btn-block">
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
                </div>

                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#calendar" data-toggle="tab">Calendar</a></li>
                            <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Timeline</a></li>
                            <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a></li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane" id="calendar">

                                    <livewire:inline.calendar :user="$user">

                                </div>

                                <div class="tab-pane" id="timeline">

                                    <div class="timeline timeline-inverse">

                                    <div class="time-label">
                                    <span class="bg-danger">
                                    10 Feb. 2014
                                    </span>
                                    </div>


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


                                    <div>
                                    <i class="fas fa-user bg-info"></i>
                                    <div class="timeline-item">
                                    <span class="time"><i class="far fa-clock"></i> 5 mins ago</span>
                                    <h3 class="timeline-header border-0"><a href="#">Sarah Young</a> accepted your friend request
                                    </h3>
                                    </div>
                                    </div>


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


                                    <div class="time-label">
                                    <span class="bg-success">
                                    3 Jan. 2014
                                    </span>
                                    </div>


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

                                    <div>
                                    <i class="far fa-clock bg-gray"></i>
                                    </div>
                                    </div>
                                </div>

                                <div class="tab-pane" id="settings">
                                <form class="form-horizontal">
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
                                </form>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    {{-- @include('livewire.user.form') --}}
</div>