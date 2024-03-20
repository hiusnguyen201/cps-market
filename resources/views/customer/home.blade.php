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

                <button type="submit" class="btn btn-outline-danger add-to-cart-btn" data-product-id="{{$product->id}}">
                    ADD</button>


            </div>
        </div>
    </div>
    @endforeach


    <div id="cart-message" style="display: none;"></div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var addToCartButtons = document.querySelectorAll('.add-to-cart-btn');
            addToCartButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    var productId = this.getAttribute('data-product-id');
                    addToCart(productId);
                });
            });

            function addToCart(productId) {
                fetch('/cart', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            product_id: productId
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Xử lý kết quả trả về từ máy chủ nếu cần
                        showMessage(data.message, 'success');
                    })
                    .catch(error => {
                        showMessage(error.message, 'error');
                        console.error('There has been a problem with your fetch operation:', error);
                    });
            }
        });

        function showMessage(message, type) {
            // Chọn phần tử HTML để hiển thị thông báo
            var messageElement = document.getElementById('cart-message');

            // Thiết lập nội dung thông báo
            messageElement.innerHTML = message;

            // Thiết lập lớp CSS cho thông báo dựa trên loại
            if (type === 'success') {
                messageElement.classList.add('alert', 'alert-success');
            } else if (type === 'error') {
                messageElement.classList.add('alert', 'alert-danger');
            }

            // Hiển thị phần tử thông báo
            messageElement.style.display = 'block';
        }
    </script>