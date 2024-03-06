@extends('layouts.index')
@section('content')
    <div class="card py-2 px-3">
        <div class="d-flex mb-2">
            <div class="col-2 px-0 mr-2">
                <a href="/categories/create" class="btn btn-success w-100 py-2">Create</a>
            </div>
            <div class="col-2 px-0 mr-2">
                <button class="btn btn-danger w-100 py-2" data-toggle="modal" data-target="#modal-deleteAll">Delete
                    All</button>
            </div>
        </div>


        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-warning">
                {{ session('error') }}
            </div>
        @endif

        <form action="" class="form-inline" >
            <div class="form-group">

                <input class="form-control" name="kw" id="" placeholder="Search by Name...">
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i>
            </button>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="selectAll">
                                <label class="form-check-label" for="selectAll">&nbsp;</label>
                            </div>
                        </th>
                        <th>Name</th>
                        <th class="text-right">Operation</th>
                    </tr>

                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="id"
                                        value="{{ $category->id }}">
                                </div>
                            </td>
                            <td>{{ $category->name }}</td>

                        <td class="text-right">
                            <a class="btn btn-primary" href="/categories/edit/{{ $category->id }}" role="button">
                                <i class="fas fa-pen"></i>
                            </a>
                            <button type="button" class="btn btn-danger" data-toggle="modal"
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
        {{ $categories->links() }}
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
