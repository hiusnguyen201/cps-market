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

function addEventToUpdatePrice(orderSummaryCard) {
    updatePriceInOrderSummary(orderSummaryCard);

    $("#cartOrder").on("change", "input[name='quantity[]']", function (e) {
        updatePriceInOrderSummary(orderSummaryCard);
    });

    $("#cartOrder").on("click", ".removeSelectProduct", function (e) {
        $(this).closest("tr").remove();
        updatePriceInOrderSummary(orderSummaryCard);
    });
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
                <div class='ml-lg-2 mx-auto'>
                    <img class='float-left table-img' src="${
                        window.location.origin
                    }/${imagePin.thumbnail}" alt="">
                </div>
                <div style='flex:1' class='ml-lg-1 ml-0 row text-sm-left text-center'> 
                    <div class='col-12'>
                        <a class='product-name' href="/admin/products/details/${
                            product.id
                        }">${product.name}</a>
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

    addEventToUpdatePrice(orderSummaryCard);
}

addEventToUpdatePrice($("#orderSummaryCard"));

// Search Product
$("#searchProduct-btn").click(() => {
    const input = $("#modal-searchProduct").find("input[name='code']");
    const span = $("#modal-searchProduct").find("span.error-message");

    $.ajax({
        url: `/api/products?code=${input.val()}`,
        type: "GET",
        success: (data) => {
            const { product } = data;
            if (!product.quantity) {
                Toastify({
                    text: "Product is out of stock",
                    duration: 5000,
                    newWindow: true,
                    gravity: "top",
                    position: "center",
                    stopOnFocus: true,
                    style: {
                        background: "#F05F57",
                    },
                    close: true,
                }).showToast();

                return;
            }

            const trElement = document.querySelector(
                `tr[data-product='${product.id}']`
            );
            if (trElement) {
                const value = trElement.querySelector(
                    "input[name='quantity[]']"
                ).value;

                if (+value > product.quantity) {
                    Toastify({
                        text: "Product is out of stock",
                        duration: 5000,
                        newWindow: true,
                        gravity: "top",
                        position: "center",
                        stopOnFocus: true,
                        style: {
                            background: "#F05F57",
                        },
                        close: true,
                    }).showToast();

                    return;
                }
            }

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
