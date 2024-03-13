const selectFormCategory = $("select#product[name='category']");
const selectFormBrand = $("select#product[name='brand']");
const cardSpecification = $("#specification");
const cardSales = $("#sales");

// Select specifications and sales
const cardArr = [cardSpecification, cardSales];
var inactiveText = [];
selectFormCategory.change(async (e) => {
    const selectedOption = selectFormCategory.find("option:selected");

    $.ajax({
        url: `/api/categories/${selectedOption[0].value}/brands`,
        type: "GET",
        success: (data) => {
            const { brands } = data;
            cardArr.forEach((card) => {
                inactiveText.push(
                    $(card.parent()).find("span.inactive-text").html()
                );

                card.removeClass("hide");
                card.parent().removeClass("inactive-content");
                $(card.parent()).find("span.inactive-text").html("");
            });

            // Remove old option
            const brandOptions = selectFormBrand.find("option");
            brandOptions.toArray().forEach((element, index) => {
                if (index > 0) {
                    element.remove();
                }
            });

            brands.forEach((brand) => {
                selectFormBrand.append(
                    `<option value='${brand.id}'>${brand.name}</option>`
                );
            });
        },
        error: (err) => {
            cardArr.forEach((card, index) => {
                card.addClass("hide");
                card.parent().addClass("inactive-content");
                $(card.parent())
                    .find("span.inactive-text")
                    .html(inactiveText[index]);
            });

            return;
        },
    });
});
