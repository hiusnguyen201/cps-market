@extends('layouts.admin.index')
@if (session('success'))
    <input hidden type="text" name="message-success" value="{{ session('success') }}">
@endif
@if (session('error'))
    <input hidden type="text" name="message-error" value="{{ session('error') }}">
@endif

@section('content')

    <div class="card">
        <div class="card-body mb-3">
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
                                                href="/admin/brands/details/{{ $brand->id }}">{{ $brand->name }}</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>


            <label>Specifications:</label>
            <div class="row align-items-center">
                <div class="col-sm-3 col-sm-6 col-12 mb-3">
                    <a href="/admin/categories/details/{{ $category->id }}/specifications/add"
                        class="btn btn-success w-100 py-2">Add</a>
                </div>
                <div class="col-sm-3 col-sm-6 col-12 mb-3">
                    <button class="btn btn-danger w-100 py-2" data-toggle="modal" data-target="#modal-deleteAll">Delete
                        All</button>
                </div>
            </div>

            @if ($category->specifications && count($category->specifications) > 0)
                <table id="dataTable" name='categories/details/{{ $category->id }}/specifications' class="display mb-3"
                    style="width:100%">
                    <thead>
                        <tr>
                            <th width='1%'></th>
                            <th>Name</th>
                            <th width="1%">
                                <input type="checkbox" class="form-check-input" id="selectAll">
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($category->specifications as $specification)
                            @php
                                $html = '';
                                foreach ($specification->attributes as $attribute) {
                                    $html = $html . '<li>' . $attribute->key . '</li>';
                                }
                            @endphp
                            <tr data-row='{{ $specification->id }}' data-child-name="Attributes"
                                data-child-value="<ul class='mb-0'>{{ $html }}</ul>">
                                <td></td>
                                <td>{{ $specification->name }}</a>
                                </td>
                                <td>
                                    <input type="checkbox" class="form-check-input" style="margin-top: 10px" name="id"
                                        value="{{ $specification->id }}">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="table-responsive mb-3">
                    <table id="normalTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th width='1%'>
                                    <input type="checkbox" class="form-check-input" id="selectAll">
                                </th>
                                <th width='25%'>Name</th>
                                <th>Attribute</th>
                                <th width='1%'>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($category->specifications as $specification)
                                <tr>
                                    <td class="align-middle">
                                        <input type="checkbox" class="form-check-input" name="id"
                                            value="{{ $specification->id }}">
                                    </td>

                                    <td>{{ $specification->name }}</td>

                                    <td class="px-0 py-0">
                                        <ul class="mb-0">
                                            @foreach ($specification->attributes as $attribute)
                                                <li>{{ $attribute->key }}</li>
                                            @endforeach
                                        </ul>
                                    </td>

                                    <td class="text-center align-middle">
                                        <a class="btn btn-warning"
                                            href="/admin/categories/details/{{ $category->id }}/specifications/edit/{{ $specification->id }}">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <button type="button" class="btn btn-danger mt-2" data-toggle="modal"
                                            data-target="#modal-delete-{{ $specification->id }}">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>

                                <div class="modal fade" id="modal-delete-{{ $specification->id }}" aria-modal="true"
                                    role="dialog">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Warning!</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are you really want delete?</p>
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">Close</button>
                                                <form action="/admin/categories/details/{{ $category->id }}/specifications"
                                                    method="POST">
                                                    <input type="hidden" name="id" value="{{ $specification->id }}">
                                                    <button class="btn btn-primary" type="submit">Submit</button>
                                                    <input type="hidden" name="_method" value="delete">
                                                    @csrf
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            <a href="/admin/categories" class="btn btn-danger py-2 w-100">Back</a>
        </div>
    </div>

    <!-- Modal delete -->
    <div class="modal fade" id="modal-deleteAll" aria-modal="true" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Warning!</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you really want delete?</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <form class="form-delete-all" action="/admin/categories/details/{{ $category->id }}/specifications"
                        method="POST">
                        <button class="btn btn-primary btn-deleteAll" type="submit">Submit</button>
                        <input type="hidden" name="_method" value="delete">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
