@extends('layouts.admin.index')
@section('content')
    <section class="content">
        <div class="card">
            <div class="card-body">
                <div class="tab-content">
                    <div class="form-group row align-items-center">
                        <label class="col-sm-2 col-form-label">Name:</label>
                        <div class="col-sm-10">
                            {{ $brand->name }}
                        </div>
                    </div>

                    <div class="form-group row align-items-center">
                        <label class="col-sm-2 col-form-label">Created At:</label>
                        <div class="col-sm-10">
                            {{ date(config('constants.date_format'), strtotime($brand->created_at)) }}
                        </div>
                    </div>

                    <div class="form-group row align-items-center">
                        <label class="col-sm-2 col-form-label">Updated At:</label>
                        <div class="col-sm-10">
                            {{ date(config('constants.date_format'), strtotime($brand->updated_at)) }}
                        </div>
                    </div>

                    <div class="form-group row align-items-start">
                        <label class="col-sm-2 col-form-label">Category:</label>
                        <div class="col-sm-8">
                            @if (count($brand->categories) > 0)
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($brand->categories as $index => $category)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td><a class=""
                                                        href="/admin/categories/details/{{ $category->id }}">{{ $category->name }}</a>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
