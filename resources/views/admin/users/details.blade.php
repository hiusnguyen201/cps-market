@extends('layouts.admin.index')
@section('content')
    <section class="content">
        <div class="container-fluid">
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
    </section>
@endsection
