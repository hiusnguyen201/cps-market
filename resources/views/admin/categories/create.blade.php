@if (session('success'))
    <input hidden type="text" name="message-success" value="{{ session('success') }}">
@endif
@if (session('error'))
    <input hidden type="text" name="message-error" value="{{ session('error') }}">
@endif

@extends('layouts.admin.index')
@section('content')
    <div class="card card-body">
        <form action="" method="POST">
            <div class="mb-3 row align-items-center">
                <div class="col-lg-3 col-12">
                    <label class="mb-0" for="name">Name&nbsp;<span class="required-text">*</span></label>
                </div>
                <div class="col-lg-7 col-12">
                    <input type="text" name="name" class="form-control" id="name" placeholder="Enter name..."
                        value="{{ old('name') }}">

                    @error('name')
                        <span style="color: red">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="row actions-block">
                @csrf

                <div class="col-lg-6 col-12 mb-3 back-btn"><a class="btn btn-danger w-100 py-2"
                        href="/admin/categories">Back</a>
                </div>
                <div class="col-lg-6 col-12 mb-3 keepon-btn"><button type="submit"
                        class="btn btn-success w-100 py-2">Create</button>
                </div>
            </div>
        </form>
    </div>
@endsection
