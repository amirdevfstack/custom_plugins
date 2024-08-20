jQuery(document).ready(function($) {
    var swiper = new Swiper(".mySwiper", {
        slidesPerView: 4, 
        slidesPerGroup: 1, 
        navigation: {
          nextEl: ".swiper-button-next",
          prevEl: ".swiper-button-prev",
        },
        grabCursor: true, // Make the slider draggable
        breakpoints: {
          300: {
            slidesPerView: 1,
            slidesPerGroup: 1,
          },
          600: {
            slidesPerView: 2,
            slidesPerGroup: 2,
          },
          991: {
            slidesPerView: 3,
            slidesPerGroup: 2,
          },
          1400: {
            slidesPerView: 4,
            slidesPerGroup: 1,
          },
        },
      });
});    