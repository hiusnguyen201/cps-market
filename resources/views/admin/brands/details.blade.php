@extends('layouts.admin.index')
@section('content')
<div class="card">
    <section class="content">
        <div class="card mb-0">
            <div class="card-body">
                <div class="tab-content">
                    <form class="form-horizontal">
                        <div class="form-group row align-items-center">
                            <label for="inputName" class="col-sm-2 col-form-label">Name:</label>
                            <div class="col-sm-10">
                                {{ $brand->name }}
                            </div>
                        </div>

                        <div class="form-group row align-items-center">
                            <label for="inputCategory" class="col-sm-2 col-form-label">Category:</label>
                            <div class="col-sm-10">
                                <a href="/admin/categories/details/{{ $brand->categories[0]->id }}">{{ $brand->categories[0]->name }}</a>
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
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection