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

                <div class="form-group">
                    <label for="attribute"><span class="mr-2">Attribute</span><button type="button"
                            class="btn btn-primary" id="addAttribute">+</button></label>

                    @foreach ($specification->attributes as $attribute)
                        <div class="attributeFields">
                            <div class="d-flex align-items-center mb-2 ">
                                <div class="col-9">
                                    <input type="text" name="attributes[]" class="form-control attributeData"
                                        placeholder="Enter attribute..." value="{{ old('attribute') ?? $attribute->key }}"
                                        data-attId="{{ $attribute->id }}">
                                </div>

                                <div class="col-3">
                                    <button type="button" class="btn btn-danger removeAttributeCurrent"><i
                                            class="fas fa-trash-alt"></i></button>
                                </div>
                                @error('attributes')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    @endforeach

                    <div id="attributeFieldsNew" class="mt-3"></div>
                </div>

                @csrf
                @method('PATCH')
                <input type="hidden" name="specification_id" value="{{ $specification->id }}">
                <input type="hidden" name="category_id" value="{{ $specification->category->id }}">
                <button type="submit" class="btn btn-success py-2 w-100">Save</button>
            </div>
        </form>
    </div>
@endsection
