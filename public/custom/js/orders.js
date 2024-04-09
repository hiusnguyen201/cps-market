function convertToVnd(money) {
    return money.toLocaleString("vi-VN", {
        style: "currency",
        currency: "VND",
    });
}

function updatePriceInOrderSummary(orderSummaryCard) {
    const productRows = $(`#cartOrder>tbody>tr`);
    let subtotalPriceInput = orderSummaryCard
        .find("#subtotalPriceInput")
        .val(0);
    let totalPriceInput = orderSummaryCard.find("#totalPriceInput").val(0);

    let subtotal = 0;
    productRows.each((index, row) => {
        const priceInput = row.querySelector("input[name='priceProduct']");
        const quantityInput = row.querySelector("input[name='quantity[]']");
        subtotal += +priceInput.value * +quantityInput.value;
    });

    subtotalPriceInput.val(subtotal);
    subtotalPriceInput.next().html(convertToVnd(+subtotalPriceInput.val()));

    totalPriceInput.val(
        +orderSummaryCard.find("#shippingFeeInput").val() +
            +subtotalPriceInput.val()
    );

    totalPriceInput.next().html(convertToVnd(+totalPriceInput.val()));
}

function appendProduct(product) {
    const imagePin = product.images.find((image) => image.pin == 1);
    const existProduct = $(`#cartOrder>tbody>tr[data-product=${product.id}]`);
    const orderSummaryCard = $("#orderSummaryCard");

    if (existProduct.length) {
        const input = existProduct.find("input[name='quantity[]']");
        input.val(+input.val() + 1);
        updatePriceInOrderSummary(orderSummaryCard);

        input.change(() => {
            updatePriceInOrderSummary(orderSummaryCard);
        });
        return;
    }

    $("#cartOrder>tbody").append(`
    <tr data-product='${product.id}'>
        <td class='align-middle'>
            <div class='row'>
            <div class='col-sm-4 col-12'>
                <div class='d-flex justify-content-sm-end justify-content-center'>
                    <img class='float-left table-img' src="${
                        window.location.origin
                    }/${imagePin.thumbnail}" alt="">
                </div>
            </div>
            <div class='col-sm-8 col-12'>
                <div class='row flex-column text-sm-left text-center'> 
                    <div class='col-12'>
                        <a href="/admin/products/details/${product.id}">${
        product.name
    }</a>
                        <input type="hidden" name="product_id[]" value="${
                            product.id
                        }">        
                    </div>
                    <div class='col-12'>
                        <span>
                            <span style='color:red'>${convertToVnd(
                                product.sale_price ?? product.price
                            )}</span>
                            ${
                                product.sale_price
                                    ? `<span style='color:#333; text-decoration:line-through;font-size:14px;'>${convertToVnd(
                                          product.price
                                      )}</span>`
                                    : ""
                            }
                        </span>
                    </div>
                </div>     
            </div>
            </div>
        </td>
        <td width='30%' class='align-middle'>
            <input type="number" class="form-control" min="1" name="quantity[]" value="1" placeholder="Quantity...">        
            <input type="hidden" class="form-control" name="priceProduct" value="${
                product.sale_price ?? product.price
            }">        
        </td>
        <td class='align-middle'>
            <button type="button" class="btn btn-danger removeSelectProduct">
            <i class="fas fa-trash-alt"></i>
            </button>  
        </td>
    </tr>
    `);

    updatePriceInOrderSummary(orderSummaryCard);

    $("#cartOrder").on("click", ".removeSelectProduct", function (e) {
        updatePriceInOrderSummary(orderSummaryCard);
        $(this).closest("tr").remove();
    });
}

const removeSelectsProduct = document.querySelectorAll(".removeSelectProduct");
if (removeSelectsProduct && removeSelectsProduct.length) {
    removeSelectsProduct.forEach((element) => {
        element.addEventListener("click", () => {
            element.parentNode.parentNode.remove();
        });
    });
}

$("#searchProduct-btn").click(() => {
    const input = $("#modal-searchProduct").find("input[name='code']");
    const span = $("#modal-searchProduct").find("span.error-message");

    $.ajax({
        url: `/api/products?code=${input.val()}`,
        type: "GET",
        success: (data) => {
            const { product } = data;
            span.html("");
            input.val("");
            appendProduct(product);
            Toastify({
                text: "Add product success",
                duration: 2000,
                newWindow: true,
                gravity: "top",
                close: true,
                position: "center",
                stopOnFocus: true,
                style: {
                    background: "#28C76F",
                },
            }).showToast();
        },
        error: (data) => {
            const { message } = data?.responseJSON;
            span.html(message);
        },
    });
});
