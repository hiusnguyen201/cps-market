const successDiv = $("input[name='message-success']");

if (successDiv.length) {
    Toastify({
        text: successDiv.val(),
        duration: 2000,
        newWindow: true,
        gravity: "top", // `top` or `bottom`
        position: "center", // `left`, `center` or `right`
        stopOnFocus: true, // Prevents dismissing of toast on hover
        style: {
            background: "#28C76F",
        },
        close: true,
    }).showToast();
}

const errorDiv = $("input[name='message-error']");
if (errorDiv.length) {
    Toastify({
        text: errorDiv.val(),
        duration: 2000,
        newWindow: true,
        gravity: "top", // `top` or `bottom`
        position: "center", // `left`, `center` or `right`
        stopOnFocus: true, // Prevents dismissing of toast on hover
        style: {
            background: "#F05F57",
        },
        close: true,
    }).showToast();
}
