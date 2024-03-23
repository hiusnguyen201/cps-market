@extends('layouts.customer.index')

@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>



<script src="{{ asset('custom/js/cart.js') }}"></script>
<section>
    <form id="addCart" action="/cart" method="post">
        @csrf
        @method('post')
        <input type="hidden" id="product_id_add" name="product_id">
    </form>
</section>

<div class="row">
    @foreach($products as $product)
    <div class="col-md-3 col-6 mb-4">
        <div class="card">
            <div class="card-body">
                <p class="card-title">Name: {{$product->name}}</p>
                <p class="card-title">Price: {{$product->price}}</p>
                <p class="card-title">qty: {{$product->quantity}}</p>
                <form action="/cart" method="post">
                    @csrf
                    <input type="hidden" name='product_id' value="{{$product->id}}">
                    <button type="submit" class="btn btn-outline-danger add-to-cart-btn">
                        ADD</button>
                </form>

            </div>
        </div>
    </div>
    @endforeach
</div>


@if(session('success'))
<div class="alert alert-success">
    {{ session('success')}}
</div>
@endif

@if(session('error'))
<div class="alert alert-danger">
    {{ session('error')}}
</div>
@endif

@endsection