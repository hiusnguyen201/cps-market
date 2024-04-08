function convertToVnd(money) {
    return money.toLocaleString("vi-VN", {
        style: "currency",
        currency: "VND",
    });
}

function appendProduct(product) {
    const imagePin = product.images.find((image) => image.pin == 1);
    const existProduct = $(`#cartOrder>tbody>tr[data-product=${product.id}]`);

    if (existProduct.length) {
        const input = existProduct.find("input[name='quantity[]']");
        input.val(+input.val() + 1);
        return;
    }

    $("#cartOrder>tbody").append(`
    <tr data-product='${product.id}'>
        <td class='align-middle row'>
            <div class='col-sm-3 col-12'>
                <img class='float-left table-img' src="${
                    window.location.origin
                }/${imagePin.thumbnail}" alt="">
            </div>
            <div class='col-sm-6 col-12'>
                <div class='row flex-column justify-content-center'> 
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
        </td>
        <td width='30%' class='align-middle'>
            <input type="number" class="form-control" min="1" name="quantity[]" value="1" placeholder="Quantity...">        
        </td>
        <td class='align-middle'>
            <button type="button" class="btn btn-danger removeSelectProduct">
            <i class="fas fa-trash-alt"></i>
            </button>  
        </td>
    </tr>
    `);

    $("#cartOrder").on("click", ".removeSelectProduct", function (e) {
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
        },
        error: (data) => {
            const { message } = data?.responseJSON;
            span.html(message);
        },
    });
});
