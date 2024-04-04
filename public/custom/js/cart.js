function updateQuantity(input) {
    const form = $("#updateCart");
    form.find("input[name='quantity']").val(input.value);
    form.find("input[name='cart_id']").val(input.getAttribute("data-cart-id"));
    form.submit();
}
