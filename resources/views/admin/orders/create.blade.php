@if (session('success'))
    <input hidden type="text" name="message-success" value="{{ session('success') }}">
@endif
@if (session('error'))
    <input hidden type="text" name="message-error" value="{{ session('error') }}">
@endif

@extends('layouts.admin.index')
@section('content')
    <div class="card card-primary">
        <form action="" method="POST">
            <div class="card-body">
                <div class="d-grid">
                    @csrf
                    <button type="submit" class="btn btn-primary w-100 py-2">Submit</button>
                </div>
            </div>
        </form>
    </div>
@endsection
