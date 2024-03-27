@extends('layouts.customer.index')

@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

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
<div class="alert alert-success" style="color: red;">
    {{ session('success')}}
</div>
@endif

@if(session('error'))
<div class="alert alert-danger" style="color: red;">
    {{ session('error')}}
</div>
@endif

<script src="{{ asset('custom/js/cart.js') }}"></script>
@endsection