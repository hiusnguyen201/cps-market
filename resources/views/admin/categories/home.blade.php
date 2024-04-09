@if (session('success'))
    <input hidden type="text" name="message-success" value="{{ session('success') }}">
@endif
@if (session('error'))
    <input hidden type="text" name="message-error" value="{{ session('error') }}">
@endif

@extends('layouts.admin.index')
@section('content')
    <div class="card py-3 px-3">
        <div class="row">
            <div class="col-md-12 col-lg-3 mb-3">
                <a href="/admin/categories/create" class="btn btn-success w-100 py-2">Create</a>
            </div>
            <div class="col-md-12 col-lg-3 mb-3">
                <button class="btn btn-danger w-100 py-2" data-toggle="modal" data-target="#modal-deleteAll">Delete
                    All</button>
            </div>
        </div>

        <form action="" method="GET">
            <div class="row">
                <div class="col-lg-2 col-4 mb-3">
                    <select name="limit" id="" class="form-control">
                        @if (!is_null($limit_page))
                            @foreach ($limit_page as $limit)
                                <option {{ request()->limit == $limit ? 'selected' : '' }} value="{{ $limit }}">
                                    {{ $limit }} </option>
                            @endforeach
                        @else
                            <option selected value="10">10</option>
                        @endif
                    </select>
                </div>

                <div class="col-lg-4 col-12 mb-3 ml-auto">
                    <div class="form-group d-flex mb-0">
                        <input class="form-control" name="keyword" id="" placeholder="Search by keyword"
                            value="{{ request()->keyword }}">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <div class="table-responsive mb-3">
            <table class="home-table table table-hover">
                <thead>
                    <tr>
                        <th width='1%'>
                            <input type="checkbox" class="form-check-input" id="selectAll">
                        </th>
                        <th>Name</th>
                        <th width='1%'>Operation</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td class="align-middle">
                                <input type="checkbox" class="form-check-input" name="id" value="{{ $category->id }}">
                            </td>
                            <td class="align-middle"><a
                                    href="/admin/categories/details/{{ $category->id }}">{{ $category->name }}</a></td>

                            <td class="text-center align-middle">
                                <a class="btn btn-warning" href="/admin/categories/edit/{{ $category->id }}">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <button type="button" class="btn btn-danger mt-2" data-toggle="modal"
                                    data-target="#modal-delete-{{ $category->id }}">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                        <div class="modal " id="modal-delete-{{ $category->id }}" aria-modal="true" role="dialog">
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
                                        <form action="" method="POST">
                                            <input type="hidden" name="id" value="{{ $category->id }}">
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

        <!-- Paginate -->
        <div class="d-flex ml-auto">
            {{ $categories->appends(Request::all())->links() }}
        </div>
    </div>

    <!-- Modal delete -->
    <div class="modal " id="modal-deleteAll" aria-modal="true" role="dialog">
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
                    <form class="form-delete-all" action="" method="POST">
                        <button class="btn btn-primary btn-deleteAll" type="submit">Submit</button>
                        <input type="hidden" name="_method" value="delete">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
