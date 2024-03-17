@extends('layouts.customer.index')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>


<div class="row">
    @foreach($products as $product)
    <div class="col-md-3 col-6 mb-4">
        <div class="card">
            <div class="card-body">
                <p class="card-title">Name: {{$product->name}}</p>
                <p class="card-title">Price: {{$product->price}}</p>
                <p class="card-title">Descrip: {{$product->description}}</p>
                <p class="btn-holder"><a href="cart/product/{{ $product->id }}" class="btn btn-outline-danger">Add</a></p>
            </div>
        </div>
    </div>
    @endforeach

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

