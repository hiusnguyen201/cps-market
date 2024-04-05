/////////////////////////// EDIT /////////////////////////

$("#addAttribute").click(function () {
    $("#attributeFieldsNew").append(
        '<div class="att mb-3"><label for="name">New attribute</label><div class="d-flex align-items-center mb-2"><div class="col-9"><input type="text" name="attributes_new[]" class="form-control" placeholder="Enter attribute..."></div><div class="col-3"> <button type="button" class="btn btn-danger" id="removeAttribute"><i class="fas fa-trash-alt"></i></button></div></div></div>'
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
        '<div class="d-flex align-items-center mb-2"><div class="col-9"><input type="text" name="attributes[]" class="form-control" placeholder="Enter attribute..."></div><div class="col-3"> <button type="button" class="btn btn-danger" id="removeAttribute"><i class="fas fa-trash-alt"></i></button></div></div>'
    );
});
