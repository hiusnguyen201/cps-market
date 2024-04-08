const addCartBtn = $("button#addCartBtn");

if (addCartBtn) {
    addCartBtn.click(() => {
        const parent = addCartBtn.parent().parent();
        parent.append(`<div class="row mb-3">
                        <div class="col-6">
                            <input type="text" class="form-control w-100" name="code[]" placeholder="Code...">
                        </div>
                        <div class="col-2">
                            <input type="number" class="form-control" min="1" name="quantity[]" value="1"
                                placeholder="Quantity...">
                        </div>
                        <div class="col-2">
                            <button type="button" class="btn btn-danger removeSelectProduct"><i
                                    class="fas fa-trash-alt"></i></button>
                        </div>
                    </div>`);

        parent.find(".removeSelectProduct").each((index, element) => {
            element.addEventListener("click", () => {
                element.parentNode.parentNode.remove();
            });
        });
    });
}

const removeSelectsProduct = document.querySelectorAll(".removeSelectProduct");
if (removeSelectsProduct && removeSelectsProduct.length) {
    removeSelectsProduct.forEach((element) => {
        element.addEventListener("click", () => {
            element.parentNode.parentNode.remove();
        });
    });
}
