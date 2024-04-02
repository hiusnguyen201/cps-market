@if (session('success'))
    <input hidden type="text" name="message-success" value="{{ session('success') }}">
@endif
@if (session('error'))
    <input hidden type="text" name="message-error" value="{{ session('error') }}">
@endif

@extends('layouts.admin.index')
@section('content')
    <div class="card py-3 px-3">
        <form action="" method="POST">
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Specification Name:</label>
                    <input type="text" name="name" class="form-control" id="name"
                        placeholder="Enter specification name..." value="{{ old('name') }}">
                    @error('name')
                        <span style="color: red">{{ $message }}</span>
                    @enderror
                </div>

                <label for="name">Attributes:</label>
                <button type="button" class="btn btn-success d-block w-100 py-2" id="addAttribute">+</button>

                <div class="form-group" id="attributeFields">
                    @error('attributes')
                        <span style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <input type="hidden" name="id" value="{{ $category->id }}">
                <button type="submit" class="btn btn-primary w-100 p-2 d-block">Submit</button>
                @csrf
            </div>
        </form>
    </div>
@endsection
