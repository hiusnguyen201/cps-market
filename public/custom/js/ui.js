const allPaymentInput = document.querySelectorAll(
    "input[name='payment_method']"
);
const formPaymentInfo = document.querySelector("form#payment-info_form");
const btnPlaceOrder = document.querySelector("button#place-order-btn");

function changeStyleBtn(input) {
    if (input) {
        btnPlaceOrder.disabled = false;
        btnPlaceOrder.style.opacity = 1;
        btnPlaceOrder.style.cursor = "pointer";
    } else {
        btnPlaceOrder.disabled = true;
        btnPlaceOrder.style.opacity = 0.6;
        btnPlaceOrder.style.cursor = "unset";
    }
}

if (
    allPaymentInput &&
    allPaymentInput.length &&
    btnPlaceOrder &&
    formPaymentInfo
) {
    allPaymentInput.forEach((input) => {
        input.addEventListener("click", (e) => {
            changeStyleBtn(e.target);
        });
    });

    changeStyleBtn(
        formPaymentInfo.querySelector("input[name='payment_method']:checked")
    );
}

if (formPaymentInfo) {
    formPaymentInfo.addEventListener("submit", (e) => {
        formPaymentInfo.action = formPaymentInfo
            .querySelector("input[name='payment_method']:checked")
            .getAttribute("data");
    });
}
