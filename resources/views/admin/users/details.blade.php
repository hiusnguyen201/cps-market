@extends('layouts.admin.index')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="tab-content">
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
                            <label for="inputExperience" class="col-sm-2 col-form-label">Gender:</label>
                            <div class="col-sm-10">
                                @if (config('constants.genders') && count(config('constants.genders')))
                                    @foreach (config('constants.genders') as $gender)
                                        @if ($gender['value'] == $user->status)
                                            {{ $gender['title'] }}
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="form-group row align-items-center">
                            <label for="inputExperience" class="col-sm-2 col-form-label">Status:</label>
                            <div class="col-sm-10">
                                @if (config('constants.user_status') && count(config('constants.user_status')))
                                    @foreach (config('constants.user_status') as $status)
                                        @if ($user->status == $status['value'])
                                            <span class="{{ $status['css'] }}">{{ $status['title'] }}</span>
                                        @endif
                                    @endforeach
                                @endif
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
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
