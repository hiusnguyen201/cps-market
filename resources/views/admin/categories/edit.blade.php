@if (session('success'))
    <input hidden type="text" name="message-success" value="{{ session('success') }}">
@endif
@if (session('error'))
    <input hidden type="text" name="message-error" value="{{ session('error') }}">
@endif

@extends('layouts.admin.index')
@section('content')
    <div class="card">

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">
                    <h1>Edit category</h1>
                </h3>
            </div>

            <form action="" method="POST">
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="Enter name..."
                            value="{{ old('name') ?? $category->name }}">
                        @error('name')
                            <span style="color: red">{{ $message }}</span>
                        @enderror
                    </div>


                </div>

                <div class="card-footer">
                    <input type="hidden" name="id" value="{{ $category->id }}">
                    <input type="hidden" name="_method" value="PUT">
                    <button type="submit" class="btn btn-primary">update</button>
                </div>
                @csrf
            </form>
        </div>
    </div>
@endsection
