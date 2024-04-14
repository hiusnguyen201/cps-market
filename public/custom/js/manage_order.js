$("#my-order-sort").change(function () {
    orders_Filter();
});

function orders_Filter() {
    let time_sort = $("#my-order-sort").val();

    let searchParams = new URLSearchParams(window.location.search);

    searchParams.forEach((value, key) => {
        searchParams.set(key, value);
    });

    searchParams.set("time_sort", time_sort);

    let newUrl = window.location.pathname + "?" + searchParams.toString();
    window.location.href = newUrl;
}
