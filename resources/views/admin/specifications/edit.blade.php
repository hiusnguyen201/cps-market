@if (session('success'))
    <input hidden type="text" name="message-success" value="{{ session('success') }}">
@endif
@if (session('error'))
    <input hidden type="text" name="message-error" value="{{ session('error') }}">
@endif

@extends('layouts.admin.index')
@section('content')
    <div class="card py-3 px-3">
        <form class="form-update-all" action="" method="POST">
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Name</label>

                    <input type="text" name="name" class="form-control" id="name" placeholder="Enter name..."
                        value="{{ old('name') ?? $specification->name }}">


                    @error('name')
                        <span style="color: red">{{ $message }}</span>
                    @enderror
                </div>



                <label for="attribute">Attribute</label>
                <button type="button" class="btn btn-success py-2 w-100" id="addAttribute">+</button>
                @foreach ($specification->attributes as $attribute)
                    <div class="attributeFields">
                        <div class="row">
                            <div class="col-11">
                                <input type="text" class="form-control mt-2 attributeData"
                                    placeholder="Enter attribute..." value="{{ old('attribute') ?? $attribute->key }}"
                                    data-attId="{{ $attribute->id }}">
                            </div>

                            <div class="col-1" style="margin-top: .5rem !important;">
                                <button type="button" class="btn btn-danger removeAttributeCurrent"><i
                                        class="fas fa-trash-alt"></i></button>
                            </div>
                            @error('attributes')
                                <span style="color: red">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                @endforeach

                <div class="form-group" id="attributeFieldsNew"></div>
                @csrf
                @method('PATCH')
                <input type="hidden" name="id" value="{{ $specification->id }}">
                <button type="submit" class="btn btn-primary py-2 w-100">Update</button>
            </div>
        </form>
    </div>
@endsection
