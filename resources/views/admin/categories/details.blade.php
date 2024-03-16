@extends('layouts.admin.index')
@section('content')
    <section class="content">
        <div class="card">
            <div class="card-body">
                <form class="form-horizontal">
                    <div class="form-group row align-items-center">
                        <label class="col-sm-2 col-form-label">Name:</label>
                        <div class="col-sm-10">
                            {{ $category->name }}
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label class="col-sm-2 col-form-label">Created At:</label>
                        <div class="col-sm-10">
                            {{ date(config('constants.date_format'), strtotime($category->created_at)) }}
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label class="col-sm-2 col-form-label">Updated At:</label>
                        <div class="col-sm-10">
                            {{ date(config('constants.date_format'), strtotime($category->updated_at)) }}
                        </div>
                    </div>
                    <div class="form-group row align-items-start">
                        <label class="col-sm-2 col-form-label">Brand:</label>
                        <div class="col-sm-8">
                            @if (count($category->brands) > 0)
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($category->brands as $index => $brand)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td><a class=""
                                                        href="/admin/brands/{{ $brand->id }}">{{ $brand->name }}</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    </div>
@endsection
