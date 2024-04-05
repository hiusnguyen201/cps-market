const provinceInitSelect = document.querySelector("select[name='province']");
const wardInitSelect = document.querySelector("select[name='ward']");
const districtInitSelect = document.querySelector("select[name='district']");

if (provinceInitSelect && wardInitSelect && districtInitSelect) {
    var localpicker = new LocalPicker({
        province: "province",
        district: "district",
        ward: "ward",

        provinceText: "Select province",
        districtText: "Select district",
        wardText: "Select ward",
    });
}
