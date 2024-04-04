const successDiv = $("input[name='message-success']");

if (successDiv.length) {
    console.log(successDiv);
    Toastify({
        text: successDiv.val(),
        duration: 2000,
        newWindow: true,
        gravity: "top", // `top` or `bottom`
        position: "right", // `left`, `center` or `right`
        stopOnFocus: false, // Prevents dismissing of toast on hover
        style: {
            background: "#28C76F",
        },
    }).showToast();
}

const errorDiv = $("input[name='message-error']");
if (errorDiv.length) {
    Toastify({
        text: errorDiv.val(),
        duration: 2000,
        newWindow: true,
        gravity: "top", // `top` or `bottom`
        position: "right", // `left`, `center` or `right`
        stopOnFocus: false, // Prevents dismissing of toast on hover
        style: {
            background: "#F05F57",
        },
    }).showToast();
}

const input = document.querySelector("input#term-and-condition");
const btn = document.querySelector("button#place-order-btn");
if (input && btn) {
    function changeStyleBtn(input) {
        if (input.checked) {
            btn.disabled = false;
            btn.style.opacity = 1;
            btn.style.cursor = "pointer";
        } else {
            btn.disabled = true;
            btn.style.opacity = 0.6;
            btn.style.cursor = "unset";
        }
    }

    input.addEventListener("change", (e) => {
        changeStyleBtn(input);
    });
    changeStyleBtn(input);
}
