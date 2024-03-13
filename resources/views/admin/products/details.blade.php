@extends('layouts.admin.index')
@section('content')
    <section class="content">
        <div class="card mb-0">
            <div class="card-body">
                <div class="tab-content">
                    <div class="form-group row align-items-center">
                        <label for="inputName" class="col-sm-2 col-form-label">Name:</label>
                        <div class="col-sm-10">
                            {{ $brand->name }}
                        </div>
                    </div>

                    <div class="form-group row align-items-center">
                        <label for="inputExperience" class="col-sm-2 col-form-label">Created At:</label>
                        <div class="col-sm-10">
                            {{ date(config('constants.date_format'), strtotime($brand->created_at)) }}
                        </div>
                    </div>

                    <div class="form-group row align-items-center">
                        <label for="inputExperience" class="col-sm-2 col-form-label">Updated At:</label>
                        <div class="col-sm-10">
                            {{ date(config('constants.date_format'), strtotime($brand->updated_at)) }}
                        </div>
                    </div>

                    <div class="form-group row align-items-center">
                        <label for="inputCategory" class="col-sm-2 col-form-label">Category:</label>
                        <div class="col-sm-10">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
