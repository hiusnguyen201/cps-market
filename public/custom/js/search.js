
$('#perPageSelect, #sortBySelect').change(function () {
    sort_show_Filter();
});

$('#price-filter').submit(function (event) {
    event.preventDefault();
    priceFilter();
});

$('.brand-checkbox').change(function (e) {
    brandFilter(e.target);
});

$('.category-checkbox').change(function (e) {
    categoryFilter(e.target);
});

function sort_show_Filter() {
    let perPage = $('#perPageSelect').val();
    let sortBy = $('#sortBySelect').val();

    let searchParams = new URLSearchParams(window.location.search);

    searchParams.forEach((value, key) => {
        searchParams.set(key, value);
    });

    searchParams.set('per_page', perPage);
    searchParams.set('sort_by', sortBy);
    searchParams.set('page', 1);

    let newUrl = window.location.pathname + '?' + searchParams.toString();
    window.location.href = newUrl;
}

function priceFilter() {
    let price_min = $('#price-min').val();
    let price_max = $('#price-max').val();

    if (price_min && price_max && price_min > price_max) {
        price_max = parseInt(price_min) + 1;
    }

    let searchParams = new URLSearchParams(window.location.search);
    searchParams.forEach((value, key) => {
        searchParams.set(key, value);
    });

    searchParams.set('price_min', price_min);
    searchParams.set('price_max', price_max);
    searchParams.set('page', 1);

    let newUrl = window.location.pathname + '?' + searchParams.toString();
    window.location.href = newUrl;
}

function brandFilter(input) {
    let searchParams = new URLSearchParams(window.location.search);

    searchParams.set('page', 1);
    searchParams.set('brand_id', searchParams.get('brand_id') == input.value ? '' : input.value);
    let newUrl = window.location.pathname + '?' + searchParams.toString();
    window.location.href = newUrl;
}

function categoryFilter(input) {
    let searchParams = new URLSearchParams(window.location.search);
    searchParams.set('category_id', searchParams.get('category_id') == input.value ? '' : input.value);
    searchParams.set('page', 1);
    let newUrl = window.location.pathname + '?' + searchParams.toString();
    window.location.href = newUrl;
}

////////////////////////////////////////
const rangeInput = document.querySelectorAll(".range-input input"),
    priceInput = document.querySelectorAll(".price-input input"),
    range = document.querySelector(".slider .progress");
let priceGap = 1000;

priceInput.forEach(input => {
    input.addEventListener("input", e => {
        let minPrice = parseInt(priceInput[0].value),
            maxPrice = parseInt(priceInput[1].value);

        if ((maxPrice - minPrice >= priceGap) && maxPrice <= rangeInput[1].max) {
            if (e.target.className === "input-min") {
                rangeInput[0].value = minPrice;
                range.style.left = ((minPrice / rangeInput[0].max) * 100) + "%";
            } else {
                rangeInput[1].value = maxPrice;
                range.style.right = 100 - (maxPrice / rangeInput[1].max) * 100 + "%";
            }
        }
    });
});

rangeInput.forEach(input => {
    input.addEventListener("input", e => {
        let minVal = parseInt(rangeInput[0].value),
            maxVal = parseInt(rangeInput[1].value);

        if ((maxVal - minVal) < priceGap) {
            if (e.target.className === "range-min") {
                rangeInput[0].value = maxVal - priceGap
            } else {
                rangeInput[1].value = minVal + priceGap;
            }
        } else {
            priceInput[0].value = minVal;
            priceInput[1].value = maxVal;
            range.style.left = ((minVal / rangeInput[0].max) * 100) + "%";
            range.style.right = 100 - (maxVal / rangeInput[1].max) * 100 + "%";
        }
    });
});

