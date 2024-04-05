const clearInputFileForm = (input, img) => {
    input.value = null;
    input.files = null;
    img.src = "";
    img.hidden = true;
    input.parentNode.classList.replace(
        "input-file_uploaded",
        "input-file_block"
    );
    input.parentNode.addEventListener("click", clickInput);
    const newInput = input.parentNode.querySelector(
        "input.input-file_form[type=file]"
    );
    newInput.addEventListener("change", handleChangeFile);
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

const addInputFileForm = (inputDivPrevious) => {
    const element = getInputFileForm();

    const blocks = document.querySelectorAll(
        "input.input-file_form[type=file][multiple]"
    );

    inputDivPrevious.parentNode.appendChild(element);
    if (blocks.length >= 7) {
        element.hidden = true;
    }

    element.addEventListener("click", clickInput);
    const input = element.querySelector("input.input-file_form[type=file]");
    input.addEventListener("change", handleChangeFile);
};

const clickInput = (e) => {
    const checkInput = e.target.classList.contains("input-file_block");
    const parent = checkInput ? e.target : e.target.parentNode;
    const input = parent.querySelector("input[type='file']");

    if (!input) return;
    input.click();
};

const handleChangeFile = (e) => {
    const parent = e.target.parentNode;
    if (!e.target.files.length) return;
    const img = parent.querySelector("img");
    img.src = URL.createObjectURL(e.target.files[0]);
    img.hidden = false;
    setTimeout(() => {
        parent.classList.replace("input-file_block", "input-file_uploaded");
    }, 100);
    e.target.disabled = true;

    const removeBtn = parent.querySelector("div.remove-btn_block>i");
    removeBtn.addEventListener("click", () => {
        if (!e.target.multiple) {
            clearInputFileForm(e.target, img);
            e.target.disabled = false;
            return;
        }

        const div = document.querySelector(
            ".multiple-input_block>div.input-file_block"
        );

        if (div) {
            div.hidden = false;
        }

        parent.remove();
    });

    if (!e.target.multiple) return;

    addInputFileForm(parent);
};

const divBlock = document.querySelectorAll("div.input-file_block");
divBlock.forEach((element) => {
    element.addEventListener("click", clickInput);
    const input = element.querySelector("input.input-file_form[type=file]");
    input.addEventListener("change", handleChangeFile);
});

const divUploadedBlock = document.querySelectorAll("div.input-file_uploaded");
divUploadedBlock.forEach(async (element) => {
    const input = element.querySelector("input[type=file]");
    const img = element.querySelector("img");
    const content = await fetch(img.src).then((res) => res.blob());

    const file = new File([content], null, { type: content.type });
    const dataTransfer = new DataTransfer();
    dataTransfer.items.add(file);
    input.files = dataTransfer.files;

    element
        .querySelector("div.remove-btn_block>i")
        .addEventListener("click", () => {
            if (!input.multiple) {
                clearInputFileForm(input, img);
                input.disabled = false;
                return;
            }

            const parent = document.querySelector(".multiple-input_block");
            parent.querySelector(".input-file_block").hidden = false;

            element.remove();
        });
});
