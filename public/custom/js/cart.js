$(document).ready(function () {
    var checkboxes = $('.product-checkbox');
    var subPriceDisplay = $('#subPriceDisplay');
    var totalPriceDisplay = $('#totalPriceDisplay');
    var inputCounters = $('.input-counter__text');

    checkboxes.change(calculateTotalPrice);
    inputCounters.change('input', calculateTotalPrice);

    function calculateTotalPrice() {
        var shipping = 0;
        var sub = 0;
        var total = 0;

        checkboxes.each(function () {
            if ($(this).is(':checked')) {
                var productPrice = parseFloat($(this).data('product-price'));
                var productQty = parseFloat($(this).closest('tr').find('.input-counter__text').val());
                sub += productPrice * productQty;
            }
        });

        total = sub + shipping;

        var formattedSub = sub.toLocaleString('vi-VN');
        var formattedTotal = total.toLocaleString('vi-VN');

        subPriceDisplay.text(formattedSub + ' ₫');
        totalPriceDisplay.text(formattedTotal + ' ₫');
    }

    $("#selectAll").on("click", function () {
        if ($(this).is(":checked")) {
            $(".form-check-input").prop("checked", true);
        } else {
            $(".form-check-input").prop("checked", false);
        }
        calculateTotalPrice();
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
        $("input.input-counter__text").each(function () {
            const cartId = $(this).data("cart-id");
            const quantity = $(this).val();
            formData.push({ cart_id: cartId, quantity: quantity });
        });
        // Thêm một input ẩn duy nhất chứa dữ liệu JSON vào biểu mẫu
        $("form.form-update-all").append(`<input type="hidden" name="cart_data" value='${JSON.stringify(formData)}'>`);
        // Submit biểu mẫu
        $("form.form-update-all").unbind('submit').submit();
    });

});

function deleteCart(cart_id) {
    $('#cart_id_del').val(cart_id);
    $('#deleteCart').submit();
}













