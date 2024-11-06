// initialize swiper js

const swiper_say = new Swiper('.swiper-say', {
    loop: true,
    pagination: {
        el: '.swiper-pagination',
    },

    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
    autoplay: {
        delay: 3000,
        disableOnInteraction: false,
    },
});

var swiper_ads = new Swiper(".mySwiper", {
    grabCursor: true,
    effect: "creative",
    creativeEffect: {
        prev: {
            shadow: true,
            translate: [0, 0, -800],
            rotate: [180, 0, 0],
        },
        next: {
            shadow: true,
            translate: [0, 0, -800],
            rotate: [-180, 0, 0],
        },
    },
    autoplay: {
        delay: 5000,
        disableOnInteraction: false,
    },
});