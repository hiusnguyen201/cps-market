const successDiv = $("div.alert.alert-success");

if (successDiv.length) {
    Toastify({
        text: successDiv.html(),
        duration: 1500,
        newWindow: true,
        close: true,
        gravity: "top", // `top` or `bottom`
        position: "right", // `left`, `center` or `right`
        stopOnFocus: false, // Prevents dismissing of toast on hover
        style: {
            background: "#28C76F",
        },
    }).showToast();
}

const errorDiv = $("div.alert.alert-danger");
if (errorDiv.length) {
    Toastify({
        text: errorDiv.html(),
        duration: 1500,
        newWindow: true,
        close: true,
        gravity: "top", // `top` or `bottom`
        position: "right", // `left`, `center` or `right`
        stopOnFocus: false, // Prevents dismissing of toast on hover
        style: {
            background: "#F05F57",
        },
    }).showToast();
}
