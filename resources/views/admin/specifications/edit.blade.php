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
                <h1>Edit Specification</h1>
            </h3>
        </div>

        <form class="form-update-all" action="" method="POST">
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="Enter name..." value="{{ old('name') ?? $specification->name }}">
                    @error('name')
                    <span style="color: red">{{ $message }}</span>
                    @enderror
                </div>

                <button type="button" class="btn btn-success" id="addAttribute">Add attribute</button>

                @foreach ($specification->attributes as $attribute)
                <div class="form-group mt-1 attributeFields">

                    <label for="name">Attribute</label>
                    <div class="row">
                        <div class="col-11">
                            <input type="text" class="form-control mt-2 attributeData" placeholder="Enter attribute..." value="{{ old('attribute') ?? $attribute->key }}" data-attId="{{ $attribute->id }}">
                        </div>

                        <div class="col-1" style="margin-top: .5rem !important;">
                            <button type="button" class="btn btn-danger removeAttributeCurrent"><i class="fas fa-trash-alt"></i></button>
                        </div>
                        @error('attributes')
                        <span style="color: red">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
                @endforeach

                <div class="form-group" id="attributeFieldsNew"></div>

            </div>

            <div class="card-footer">
                @csrf
                @method('PATCH')
                <input type="hidden" name="id" value="{{ $specification->id }}">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="{{ asset('custom/js/specifications.js') }}"></script>
@endsection