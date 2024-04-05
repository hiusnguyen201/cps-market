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

const province = document.querySelector("select#province");
console.log(province);
