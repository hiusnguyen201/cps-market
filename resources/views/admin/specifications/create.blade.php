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
                <h1>Create new specification</h1>
            </h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="" method="POST">
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Specification Name</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="Enter specification name..." value="{{ old('name') }}">
                    @error('name')
                    <span style="color: red">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group" id="attributeFields">
                    <label for="name">Attribute</label>
                    <button type="button" class="btn btn-success" id="addAttribute">+</button>

                    <input type="text" name="attributes[]" class="form-control mt-2" placeholder="Enter attribute..." value="{{ old('attribute') }}">

                    @error('attributes')
                    <span style="color: red">{{ $message }}</span>
                    @enderror
                </div>


            </div>
            <!-- /.card-body -->
            <input type="hidden" name="id" value="{{ $category->id }}">

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            @csrf
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="{{ asset('custom/js/specifications.js') }}"></script>
@endsection