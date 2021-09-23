$(document).ready(function () {
  $(".hero__slider__image").owlCarousel({
    items: 1,
    dots: false,
    nav: false,
  });
  $(".fixer-slider-main-wrap").owlCarousel({
    items: 4,
  });
  $(".upcoming-match-list-wrap").owlCarousel({
    items: 2,
    margin: 20,
    nav: true,
    navText: [
      "<img src='assets/img/left-arrow.svg'>",
      "<img src='assets/img/right-arrow.svg'>",
    ],
  });
  $(".best-player-slider-inner-wrap").owlCarousel({
    items: 1,
    loop: true,
    nav: true,
    navText: [
      `<i class="fal fa-long-arrow-left"></i>`,
      `<i class="fal fa-long-arrow-right"></i>`,
    ],
  });
  $(".store-product-slider").owlCarousel({
    items: 4,
    loop: true,
    margin: 25,
    nav: true,
    navText: [
      `<i class="fal fa-long-arrow-left"></i>`,
      `<i class="fal fa-long-arrow-right"></i>`,
    ],
  });
  $(".awards-slider").owlCarousel({
    items: 4,
    loop: true,
    margin: 25,
    nav: true,
    navText: [
      `<i class="fal fa-long-arrow-left"></i>`,
      `<i class="fal fa-long-arrow-right"></i>`,
    ],
  });
  $(".brand-image-inner-wrap").owlCarousel({
    items: 5,
    loop: true,
    margin: 25,
    nav: true,
    navText: [
      `<i class="fal fa-long-arrow-left"></i>`,
      `<i class="fal fa-long-arrow-right"></i>`,
    ],
  });
  $(".video-popup-inner-wrap").owlCarousel({
    items: 4,
    loop: true,
    margin: 25,
    nav: true,
    navText: [
      `<i class="fal fa-long-arrow-left"></i>`,
      `<i class="fal fa-long-arrow-right"></i>`,
    ],
  });
  // ==============================
  $(window).on("scroll", function () {
    var scroll = $(window).scrollTop();
    if (scroll < 1) {
      $(".header-main-area").removeClass("scroll-header");
    } else {
      $(".header-main-area").addClass("scroll-header");
    }
  });
  jQuery(window).on("load", function () {
    $("#status").fadeOut();
    $("#preloader").delay(350).fadeOut("slow");
    $("body").delay(350).css({ overflow: "visible" });
  });
});

jQuery(document).ready(function ($) {
  // Define App Namespace
  var popup = {
    // Initializer
    init: function () {
      popup.popupVideo();
    },
    popupVideo: function () {
      $(".video_model").magnificPopup({
        type: "iframe",
        mainClass: "mfp-fade",
        removalDelay: 160,
        preloader: false,
        fixedContentPos: false,
        gallery: {
          enabled: true,
        },
      });

      /* Image Popup*/
      $(".gallery_container").magnificPopup({
        delegate: "a",
        type: "image",
        mainClass: "mfp-fade",
        removalDelay: 160,
        preloader: false,
        fixedContentPos: false,
        gallery: {
          enabled: true,
        },
      });
    },
  };
  popup.init($);
});
