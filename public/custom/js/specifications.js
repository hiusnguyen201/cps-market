/////////////////////////// EDIT /////////////////////////

$("#addAttribute").click(function () {
    $("#attributeFieldsNew").append(
        '<div class="att mb-3"><label for="name">New attribute</label><div class="row mb-2"><div class="col-9"><input type="text" name="attributes[]" class="form-control" placeholder="Enter attribute..."></div><div class="col-3"> <button type="button" class="btn btn-danger" id="removeAttribute"><i class="fas fa-trash-alt"></i></button></div></div></div>'
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
});

/////////////////////////// CREATE /////////////////////////
$("#attributeFields").on("click", "#removeAttribute", function () {
    $(this).closest(".row").remove();
});

$("#addAttribute").click(function () {
    $("#attributeFields").append(
        '<div class="row mb-2"><div class="col-9"><input type="text" name="attributes[]" class="form-control" placeholder="Enter attribute..."></div><div class="col-3"> <button type="button" class="btn btn-danger" id="removeAttribute"><i class="fas fa-trash-alt"></i></button></div></div>'
    );
});
