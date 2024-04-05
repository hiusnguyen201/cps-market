const swiper = new Swiper(".swiper", {
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    loop: false,
    breakpoints: {
        0: {
            slidesPerView: 1,
            spaceBetween: 5,
        },
        600: {
            slidesPerView: 3,
            spaceBetween: 10,
        },
        800: {
            slidesPerView: 3,
            spaceBetween: 15,
        },
        1025: {
            slidesPerView: 5,
            spaceBetween: 15,
        },
        1281: {
            slidesPerView: 5,
            spaceBetween: 15,
        },
    },
});
