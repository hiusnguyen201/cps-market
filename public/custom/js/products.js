/**
 * Description: Get Brands By Category
 */
let textInactive = [];

const inactiveCards = (cardArr) => {
    cardArr.forEach((card, index) => {
        card.addClass("hide");
        card.parent().addClass("inactive-content");
        card.parent().find(".inactive-text").html(textInactive[index]);
    });
    textInactive = [];
};

const activeCards = (cardArr) => {
    cardArr.forEach((card) => {
        card.removeClass("hide");
        card.parent().removeClass("inactive-content");
        const text = card.parent().find(".inactive-text");
        textInactive.push(text.html());
        text.html("");
    });
};

const cardArr = [$("#specification"), $("#sales")];

const selectFormCategory = $("select#product[name='category']");
selectFormCategory.change(async (e) => {
    const selectedOption = selectFormCategory.find("option:selected");
    const selectFormBrand = $("select#product[name='brand']");

    $.ajax({
        url: `/api/categories/${selectedOption[0].value}/attributes`,
        type: "GET",
        success: (data) => {
            const { brands, specifications } = data;
            const firstOption = selectFormBrand.find("option")[0];
            selectFormBrand.empty();
            selectFormBrand.append(firstOption);

            let brandsHtml = `<option value=''>Please select</option>`;
            brands.forEach((brand) => {
                brandsHtml += `<option value='${brand.id}'>${brand.name}</option>`;
            });
            activeCards(cardArr);

            let attributesHtml = `<div class='col-6 d-flex mb-3'>
                        <div class="col-4"><span>Brand</span><span class="required-text ml-1">*</span></div>
                        <div class="col-8 input-product_form">
                            <div class="input-group">
                                <select id="product" name="brand" class="form-control">
                                    ${brandsHtml}
                                </select>
                            </div>
                        </div>
                    </div>`;

            specifications.forEach((spec) => {
                spec.attributes.forEach((attribute, index) => {
                    attributesHtml += `<div class='col-6 d-flex mb-3'>
                        <div class="col-4"><span>${attribute.key}</span></div>
                        <div class="col-8 input-product_form">
                            <input id='product' hidden name='attribute_ids[]' value='${attribute.id}'>
                            <input id='product' class='form-control' name='attribute_values[]' placeholder='Please enter...'>
                        </div>
                    </div>
                    `;
                });
            });

            $("#specification").find("div.input-block").html("");
            $("#specification").find("div.input-block").append(attributesHtml);
        },
        error: (err) => {
            inactiveCards(cardArr);
            selectFormBrand.empty();
        },
    });
});

/**
 * Description: Create or Update Product
 */
const enableInputs = (formElement) => {
    $.each(formElement.find("input"), function (i, element) {
        element.disabled = false;
    });
};

const printAllMessage = (inputArr, errors) => {
    let i = 0,
        oldName = [];
    inputArr.each(async (index, input) => {
        if (input.name.includes("[]")) {
            oldName.push(input.name);

            const index =
                oldName.filter((item) => input.name == item).length - 1;

            input.name = input.name.split("[]")[0] + `.${index}`;
            i++;
        }

        let parent = input;
        while (!parent.classList.contains("input-product_form")) {
            parent = parent.parentNode;
        }

        const existSpan = parent.querySelector(".error-message");
        if (existSpan) existSpan.remove();

        if (input.name in errors) {
            const message = errors[input.name];

            const span = document.createElement("span");
            span.classList.add("error-message");
            span.innerHTML = message[0];

            parent.appendChild(span);
        }

        if (input.name.includes(".")) {
            input.name = input.name.split(".")[0] + "[]";
        }
    });
};

const formElement = $("form#product[enctype='multipart/form-data']");
formElement.find("button[type='submit']").click((e) => {
    e.preventDefault();
    enableInputs(formElement);
    const inputMethod = formElement.find("input[name='_method']");
    const inputId = formElement.find("input[name='id']");
    const urlApi = {
        POST: "/api/products",
        PATCH: `/api/products/${inputId.val() ?? ""}`,
    };

    $.ajax({
        url: urlApi[inputMethod.val()],
        type: "POST",
        crossDomain: true,
        data: new FormData(formElement[0]),
        processData: false,
        contentType: false,
        success: (data) => {
            const { message } = data;
            sessionStorage.setItem("success", message);
            window.location.reload();
        },
        error: (err) => {
            const { errors, message } = err?.responseJSON;
            console.log(errors);
            if (err.status == 422) {
                Toastify({
                    text: message,
                    duration: 2000,
                    newWindow: true,
                    gravity: "top",
                    position: "right",
                    stopOnFocus: false,
                    style: {
                        background: "#F05F57",
                    },
                }).showToast();

                printAllMessage(
                    $("input#product, select#product, textarea#product"),
                    errors
                );
            }
        },
    });
});

document.addEventListener("DOMContentLoaded", () => {
    const message = sessionStorage.getItem("success");

    if (!message) return;

    Toastify({
        text: message,
        duration: 2000,
        newWindow: true,
        gravity: "top",
        position: "right",
        stopOnFocus: false,
        style: {
            background: "#28C76F",
        },
    }).showToast();

    sessionStorage.removeItem("success");
});
