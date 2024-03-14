let inputFileForm = document.querySelectorAll("input.input-file_form");
const removeInputFileForm = (input, img) => {
    if (input.multiple) {
        input.parentNode.remove();
        return;
    }

    input.value = null;
    input.files = null;
    img.src = "";
    img.hidden = true;
    input.parentNode.classList.replace(
        "input-file_uploaded",
        "input-file_block"
    );
    setTimeout(() => {
        input.disabled = false;
    }, 100);
};

const addInputFileForm = (e) => {
    const parent = e.target.parentNode;
    if (parent) {
        if (!e.target.files.length > 0) return;

        const img = parent.querySelector("img");
        img.src = URL.createObjectURL(e.target.files[0]);
        img.hidden = false;

        e.target.disabled = true;

        setTimeout(() => {
            parent.classList.replace("input-file_block", "input-file_uploaded");
        }, 100);

        const removeBtn = parent.querySelector("div.remove-btn_block>i");
        removeBtn.addEventListener("click", () => {
            removeInputFileForm(e.target, img);
        });

        if (!e.target.multiple) return;

        if (inputFileForm.length <= 7) {
            const labelNode = document.createElement("label");
            labelNode.classList.add("input-file_block");
            labelNode.setAttribute(
                "for",
                `product_images[${inputFileForm.length - 1}]`
            );
            labelNode.innerHTML = `<img hidden class="input-file_image" src="" alt="">
                            <i class="far fa-file-image"></i>
                            <span class="input-file_text">Add File</span>
                            <input class="input-file_form" hidden type="file" name="product_images[${
                                inputFileForm.length - 1
                            }]"
                                id="product_images[${
                                    inputFileForm.length - 1
                                }]" multiple><div class="remove-btn_block">
                                    <i class="fas fa-trash"></i>
                                </div>`;

            parent.after(labelNode);

            inputFileForm = document.querySelectorAll("input.input-file_form");
            inputFileForm.forEach((input) => {
                input.addEventListener("change", addInputFileForm);
            });
        }
    }
};

inputFileForm.forEach((input) => {
    input.addEventListener("change", addInputFileForm);
});

document
    .querySelector("form[enctype='multipart/form-data']")
    .addEventListener("submit", () => {
        const fileInputs = document.querySelectorAll("input[type=file]");
        fileInputs.forEach((input) => {
            input.disabled = false;
        });
    });
