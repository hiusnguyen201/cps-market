@extends('layouts.admin.index')
@section('content')
    <section class="content">
        <div class="card">
            <div class="card-body">
                <form class="form-horizontal">
                    <div class="form-group row align-items-center">
                        <label for="inputName" class="col-sm-2 col-form-label">Name:</label>
                        <div class="col-sm-10">
                            {{ $category->name }}
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="inputExperience" class="col-sm-2 col-form-label">Created At:</label>
                        <div class="col-sm-10">
                            {{ date(config('constants.date_format'), strtotime($category->created_at)) }}
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="inputExperience" class="col-sm-2 col-form-label">Updated At:</label>
                        <div class="col-sm-10">
                            {{ date(config('constants.date_format'), strtotime($category->updated_at)) }}
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    </div>
@endsection
