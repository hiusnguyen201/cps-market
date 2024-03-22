function addCart(product_id) {
    $('#product_id_add').val(product_id);
    $('#addCart').submit();
}

function updateQuantity(qty) {
    $('#cart_id').val($(qty).data('cart-id'));
    $('#quantity').val($(qty).val());
    $('#updateCartQty').submit();
}

function deleteCart(cart_id) {
    $('#cart_id_del').val(cart_id);
    $('#deleteCart').submit();
}

function clearCart() {
    $('#clearCart').submit();
}

document.addEventListener("DOMContentLoaded", function() {
    var checkboxes = document.querySelectorAll('.product-checkbox');
    var totalPriceDisplay = document.getElementById('totalPriceDisplay');
    var selectAllCheckbox = document.getElementById('selectAll');

    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            calculateTotalPrice();
        });
    });

    function calculateTotalPrice() {
        var total = 0;
        checkboxes.forEach(function(checkbox) {
            if (checkbox.checked) {
                var productPrice = parseFloat(checkbox.dataset.productPrice);
                var productQty = parseFloat(checkbox.dataset.productQty);
                total = total + (productPrice * productQty);
            }
        });
        var formattedTotal = total.toLocaleString('vi-VN');
        totalPriceDisplay.textContent = formattedTotal + ' ₫';
    }

    $("#selectAll").click(function() {
        $("input[type=checkbox]").prop("checked", $(this).prop("checked"));
        calculateTotalPrice();
    });

    $("input[type=checkbox]").click(function() {
        if (!$(this).prop("checked")) {
            $("#selectAll").prop("checked", false);
            calculateTotalPrice();
        }
    });

});