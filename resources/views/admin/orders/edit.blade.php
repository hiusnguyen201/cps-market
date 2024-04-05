@if (session('success'))
    <input hidden type="text" name="message-success" value="{{ session('success') }}">
@endif
@if (session('error'))
    <input hidden type="text" name="message-error" value="{{ session('error') }}">
@endif

@extends('layouts.admin.index')
@section('content')
    <div class="card card-primary mb-0">
        <form action="" method="POST">
            <div class="card-body">


                @csrf
                @method('PATCH')
                <button type="submit" class="btn btn-success w-100 py-2">Save</button>
            </div>
        </form>
    </div>
@endsection
