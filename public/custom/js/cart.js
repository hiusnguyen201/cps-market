function deleteCart(cart_id) {
    $('#cart_id_del').val(cart_id);
    $('#deleteCart').submit();
}

document.addEventListener("DOMContentLoaded", function () {
    var checkboxes = document.querySelectorAll('.product-checkbox');
    var totalPriceDisplay = document.getElementById('totalPriceDisplay');
    checkboxes.forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            calculateTotalPrice();
        });
    });

    function calculateTotalPrice() {
        var total = 0;
        checkboxes.forEach(function (checkbox) {
            if (checkbox.checked) {
                var productPrice = parseFloat(checkbox.dataset.productPrice);
                var productQty = parseFloat(checkbox.dataset.productQty);
                total = total + (productPrice * productQty);
            }
        });
        var formattedTotal = total.toLocaleString('vi-VN');
        totalPriceDisplay.textContent = formattedTotal + ' ₫';
    }

    $("#selectAll").on("click", function () {
        if ($(this).is(":checked")) {
            $(".form-check-input").prop("checked", true);
        } else {
            $(".form-check-input").prop("checked", false);
        }
        calculateTotalPrice();
    });
});



$("form.form-delete-all").submit((event) => {
    const formCheckboxChecked = $("input.form-check-input:checked:not(#selectAll)");
    for (var i = 0; i < formCheckboxChecked.length; i++) {
        $("form.form-delete-all").append(
            `<input type="hidden" name="id[${i}]" value="${formCheckboxChecked[i].value}">`)
    }
});

$("form.form-update-all").submit((event) => {
    event.preventDefault(); // Ngăn chặn việc submit mặc định của biểu mẫu
    const formData = []; // Khởi tạo mảng JSON để lưu các cặp cart_id và quantity
    $("input.input-counter__text").each(function() {
        const cartId = $(this).data("cart-id");
        const quantity = $(this).val();
        formData.push({ cart_id: cartId, quantity: quantity });
    });
    // Thêm một input ẩn duy nhất chứa dữ liệu JSON vào biểu mẫu
    $("form.form-update-all").append(`<input type="hidden" name="cart_data" value='${JSON.stringify(formData)}'>`);
    // Submit biểu mẫu
    $("form.form-update-all").unbind('submit').submit();
});

