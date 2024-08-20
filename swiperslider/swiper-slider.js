jQuery(document).ready(function($) {
    var swiper = new Swiper(".swiper", {
        slidesPerView: 4,
        spaceBetween: 30,
        centeredSlides: true,
        pagination: {
          el: ".swiper-pagination",
          clickable: true,
        },
      });

});