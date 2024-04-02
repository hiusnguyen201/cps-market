/////////////////////////// EDIT /////////////////////////

$("#addAttribute").click(function () {
    $("#attributeFieldsNew").append(
        '<div class="att"><label class="mt-2" for="name">New attribute</label><div class="row"><div class="col-11"><input type="text" name="attributes_new[]" class="form-control mt-2" placeholder="Enter attribute..."></div><div style="margin-top: .5rem !important;" class="col-1"> <button type="button" class="btn btn-danger" id="removeAttribute"><i class="fas fa-trash-alt"></i></button></div></div></div>'
    );
});

$("#attributeFieldsNew").on("click", "#removeAttribute", function () {
    $(this).closest(".att").remove();
});

const attributeToDelete = [];
$(".attributeFields").on("click", ".removeAttributeCurrent", function () {
    const attributeId = $(this)
        .closest(".row")
        .find(".attributeData")
        .data("attid");
    attributeToDelete.push(attributeId);
    $(this).closest(".attributeFields").remove();
    $("form.form-update-all").append(
        `<input type="hidden" name="attributes_delete" value='${JSON.stringify(
            attributeToDelete
        )}'>`
    );
});

$("form.form-update-all").submit((event) => {
    event.preventDefault();
    const formData = [];
    $(".attributeData").each(function () {
        const attributeId = $(this).data("attid");
        const key = $(this).val();
        formData.push({
            attributeId: attributeId,
            key: key,
        });
    });
    $("form.form-update-all").append(
        `<input type="hidden" name="attributes_update" value='${JSON.stringify(
            formData
        )}'>`
    );
    $("form.form-update-all").unbind("submit").submit();
});

/////////////////////////// CREATE /////////////////////////
$("#attributeFields").on("click", "#removeAttribute", function () {
    $(this).closest(".row").remove();
});

$("#addAttribute").click(function () {
    $("#attributeFields").append(
        '<div class="row"><div class="col-11"> <input type="text" name="attributes[]" class="form-control mt-2" placeholder="Enter attribute..."></div><div style="margin-top: .5rem !important;" class="col-1"> <button type="button" class="btn btn-danger" id="removeAttribute"><i class="fas fa-trash-alt"></i></button></div></div>'
    );
});
