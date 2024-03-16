@if (session('success'))
    <input hidden type="text" name="message-success" value="{{ session('success') }}">
@endif
@if (session('error'))
    <input hidden type="text" name="message-error" value="{{ session('error') }}">
@endif

@extends('layouts.admin.index')
@section('content')
    <div class="card py-2 px-3">
        <div class="d-flex mb-2">
            <div class="col-2 px-0 mr-2">
                <a href="/admin/users/create" class="btn btn-success w-100 py-2">Create</a>
            </div>
            <div class="col-2 px-0 mr-2">
                <button class="btn btn-danger w-100 py-2" data-toggle="modal" data-target="#modal-deleteAll">Delete
                    All</button>
            </div>
        </div>
        <form action="" class="d-flex align-items-center mb-2" method="GET">
            <div class="col-1 px-0 mr-2">
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
            <div class="col-2 px-0 mr-2">
                <select name="role" id="" class="form-control">
                    <option value="">All role</option>
                    @if (!is_null($roles))
                        @foreach ($roles as $role)
                            <option {{ request()->role == $role->id ? 'selected' : '' }} value="{{ $role->id }}">
                                {{ $role->name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="col-2 px-0 mr-2">
                <select name="status" id="" class="form-control">
                    <option value="">All status</option>
                    @if (!is_null($user_status))
                        @foreach ($user_status as $index => $status)
                            <option {{ request()->status == $index ? 'selected' : '' }} value="{{ $index }}">
                                {{ $index }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="col-3 px-0 ml-auto">
                <div class="form-group d-flex mb-0">
                    <input class="form-control" name="keyword" id="" placeholder="Search by keyword"
                        value="{{ request()->keyword }}">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="home-table table table-hover">
                <thead>
                    <tr>
                        <th width="1%">
                            <input type="checkbox" class="form-check-input" id="selectAll">
                        </th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Role</th>
                        <th width="1%">Operation</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td class="align-middle">
                                <input type="checkbox" class="form-check-input" name="id" value="{{ $user->id }}">
                            </td>
                            <td class="align-middle"><a
                                    href="/admin/users/details/{{ $user->id }}">{{ $user->name }}</a></td>
                            <td class="align-middle">{{ $user->email }}</td>
                            <td class="align-middle">{{ $user->phone }}</td>
                            <td class="align-middle">
                                {{ array_search($user->status, $user_status) }}
                            </td>
                            <td class="align-middle">
                                {{ $user->role->name }}
                            </td>
                            <td class="text-center align-middle">
                                <a class="btn btn-warning" href="/admin/users/edit/{{ $user->id }}">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <button type="button" class="btn btn-danger mt-2" data-toggle="modal"
                                    data-target="#modal-delete-{{ $user->id }}">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                        <div class="modal " id="modal-delete-{{ $user->id }}" aria-modal="true" role="dialog">
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
                                            <input type="hidden" name="id" value="{{ $user->id }}">
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
            {{ $users->appends(Request::all())->links() }}
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
