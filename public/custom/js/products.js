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
        url: `/api/categories/${selectedOption[0].value}/brands`,
        type: "GET",
        success: (data) => {
            const { brands } = data;
            const firstOption = selectFormBrand.find("option")[0];
            selectFormBrand.empty();
            selectFormBrand.append(firstOption);
            brands.forEach((brand) => {
                selectFormBrand.append(
                    `<option value='${brand.id}'>${brand.name}</option>`
                );
            });
            activeCards(cardArr);
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
    for (const [key, value] of Object.entries(errors)) {
        if (key.includes(".")) {
            const newKey = key.split(".")[0] + "[]";
            errors[newKey] = value;
        }
    }

    inputArr.each((index, input) => {
        let parent = input;
        while (!parent.classList.contains("col-7")) {
            parent = parent.parentNode;
        }

        const existSpan = parent.querySelector(".error-message");
        if (input.name in errors) {
            const message = errors[input.name];
            existSpan.innerHTML = message[0];
        } else {
            existSpan.innerHTML = "";
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
            const { error, message } = err?.responseJSON;
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
                    error
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
