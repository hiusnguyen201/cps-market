function updateQty(input) {
    const form = $("form#updateCartQty");
    form.find("input[name='rowId']").val(input.getAttribute("data-cart-id"));
    form.find("input[name='qty']").val(input.value);
    form.submit();
}
