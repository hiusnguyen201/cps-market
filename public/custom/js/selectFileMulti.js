const form = document.querySelector("form[enctype='multipart/form-data']");
if (form) {
    form.addEventListener("submit", (e) => {
        const fileInputs = document.querySelectorAll("input[type=file]");
        fileInputs.forEach((input) => {
            input.disabled = false;
        });
    });
}

const clearInputFileForm = (input, img) => {
    input.value = null;
    input.files = null;
    img.src = "";
    img.hidden = true;
    input.parentNode.classList.replace(
        "input-file_uploaded",
        "input-file_block"
    );
};

const getInputFileForm = () => {
    const divNode = document.createElement("div");
    divNode.classList.add("input-file_block");
    divNode.innerHTML = `<img hidden class="input-file_image">
                            <i class="far fa-file-image"></i>
                            <span class="input-file_text">Add File</span>
                            <input class="input-file_form" hidden type="file" name="product_images[]"
                                multiple><div class="remove-btn_block">
                                    <i class="fas fa-trash"></i>
                                </div>`;
    return divNode;
};

const addInputFileForm = (parent) => {
    const element = getInputFileForm();
    parent.after(element);
    element.addEventListener("click", clickInput);
    const input = element.querySelector("input.input-file_form[type=file]");
    input.addEventListener("change", handleChangeFile);
};

const clickInput = (e) => {
    const checkInput = e.target.classList.contains("input-file_block");
    const parent = checkInput ? e.target : e.target.parentNode;
    const input = parent.querySelector("input[type='file']");
    if (!input || input.files.length) return;
    input.click();
};

const handleChangeFile = (e) => {
    const parent = e.target.parentNode;
    const img = parent.querySelector("img");
    img.src = URL.createObjectURL(e.target.files[0]);
    img.hidden = false;
    setTimeout(() => {
        parent.classList.replace("input-file_block", "input-file_uploaded");
    }, 100);

    const removeBtn = parent.querySelector("div.remove-btn_block>i");
    removeBtn.addEventListener("click", () => {
        if (!parent.nextElementSibling) {
            addInputFileForm(parent);
        }
        parent.remove();
    });

    if (!e.target.multiple) return;

    const inputElements = document.querySelectorAll(
        "input.input-file_form[type=file][multiple]"
    );
    if (inputElements.length >= 7) return;

    addInputFileForm(parent);
};

const divBlock = document.querySelectorAll("div.input-file_block");
divBlock.forEach((element) => {
    element.addEventListener("click", clickInput);
});

const inputElements = document.querySelectorAll(
    "input.input-file_form[type=file]"
);
inputElements.forEach((input) => {
    input.addEventListener("change", handleChangeFile);
});
