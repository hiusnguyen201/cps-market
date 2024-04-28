const swiper = new Swiper(".swiper", {
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    loop: false,
    breakpoints: {
        0: {
            slidesPerView: 1,
            spaceBetween: 10,
        },
        600: {
            slidesPerView: 3,
            spaceBetween: 10,
        },
        800: {
            slidesPerView: 3,
            spaceBetween: 10,
        },
        1025: {
            slidesPerView: 5,
            spaceBetween: 10,
        },
        1281: {
            slidesPerView: 5,
            spaceBetween: 10,
        },
    },
});

const swiper2 = new Swiper(".swiper-member", {
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    loop: false,
    breakpoints: {
        0: {
            slidesPerView: 1,
        },
        420: {
            slidesPerView: 2,
            spaceBetween: 10,
        },
        600: {
            slidesPerView: 2,
            spaceBetween: 10,
        },
        800: {
            slidesPerView: 3,
            spaceBetween: 10,
        },
        1025: {
            slidesPerView: 3,
            spaceBetween: 10,
        },
        1281: {
            slidesPerView: 4,
            spaceBetween: 10,
        },
    },
});
