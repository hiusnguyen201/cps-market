@extends('layouts.admin.index')
@section('content')
    <div class="card">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3">

                        <div class="card card-primary card-outline">
                            <div class="card-body box-profile">
                                <div class="text-center">
                                    <img class="profile-user-img img-fluid img-circle" src="../../dist/img/user4-128x128.jpg"
                                        alt="User profile picture">
                                </div>
                                <h3 class="profile-username text-center">Nina Mcintire</h3>
                                <p class="text-muted text-center">Software Engineer</p>
                                <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item">
                                        <b>Followers</b> <a class="float-right">1,322</a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Following</b> <a class="float-right">543</a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Friends</b> <a class="float-right">13,287</a>
                                    </li>
                                </ul>
                                <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
                            </div>

                        </div>


                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">About Me</h3>
                            </div>

                            <div class="card-body">
                                <strong><i class="fas fa-book mr-1"></i> Education</strong>
                                <p class="text-muted">
                                    B.S. in Computer Science from the University of Tennessee at Knoxville
                                </p>
                                <hr>
                                <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>
                                <p class="text-muted">Malibu, California</p>
                                <hr>
                                <strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>
                                <p class="text-muted">
                                    <span class="tag tag-danger">UI Design</span>
                                    <span class="tag tag-success">Coding</span>
                                    <span class="tag tag-info">Javascript</span>
                                    <span class="tag tag-warning">PHP</span>
                                    <span class="tag tag-primary">Node.js</span>
                                </p>
                                <hr>
                                <strong><i class="far fa-file-alt mr-1"></i> Notes</strong>
                                <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam
                                    fermentum enim neque.</p>
                            </div>

                        </div>

                    </div>

                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-body">
                                <div class="tab-content">
                                    <form class="form-horizontal">
                                        <div class="form-group row align-items-center">
                                            <label for="inputName" class="col-sm-2 col-form-label">Name:</label>
                                            <div class="col-sm-10">
                                                {{ $user->name }}
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center">
                                            <label for="inputEmail" class="col-sm-2 col-form-label">Email:</label>
                                            <div class="col-sm-10">
                                                {{ $user->email }}
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center">
                                            <label for="inputName2" class="col-sm-2 col-form-label">Phone:</label>
                                            <div class="col-sm-10">
                                                {{ $user->phone }}
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center">
                                            <label for="inputExperience" class="col-sm-2 col-form-label">Address:</label>
                                            <div class="col-sm-10">
                                                {{ $user->address }}
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center">
                                            <label for="inputExperience" class="col-sm-2 col-form-label">Status:</label>
                                            <div class="col-sm-10">
                                                {{ $user_status[$user->status] }}
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center">
                                            <label for="inputExperience" class="col-sm-2 col-form-label">Role:</label>
                                            <div class="col-sm-10">
                                                {{ $user->role->name }}
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center">
                                            <label for="inputExperience" class="col-sm-2 col-form-label">Created At:</label>
                                            <div class="col-sm-10">
                                                {{ date(config('constants.date_format'), strtotime($user->created_at)) }}
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center">
                                            <label for="inputExperience" class="col-sm-2 col-form-label">Updated At:</label>
                                            <div class="col-sm-10">
                                                {{ date(config('constants.date_format'), strtotime($user->updated_at)) }}
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </section>
    </div>
@endsection