import Swiper from "../vendor/swiper";
import vars from "../_vars";
import swiper from "../vendor/swiper";
import {
    addCustomClass,
    toggleCustomClass,
    removeCustomClass,
} from "../functions/customFunctions";

const { mainSlider , productsSlider } = vars;

mainSlider.forEach((item) => {
    const pagination = item.querySelector(".swiper-pagination");
    const slider = item.querySelector(".swiper-container");

    new Swiper(slider, {
        slidesPerView: 1,
        spaceBetween: 50,
        observer: true,
        // loop: true,
        observeParents: true,
        watchOverflow: true,
        speed: 1500,

        pagination: {
            el: pagination,
            type: "bullets",
            clickable: true,
        },

        autoplay: {
            delay: 8000,
        },
    });
});

productsSlider.forEach((item) => {

    const fakeContainer = item.querySelector('.woocommerce');
    const fakeWrapper = item.querySelector('.products');
    const fakeSlide = item.querySelectorAll('.product-card');


    if (fakeContainer) {
        addCustomClass(fakeContainer, 'swiper-container');
        addCustomClass(fakeWrapper, 'swiper-wrapper');

        fakeSlide.forEach(function(fakeSlide) {
            const liElement = document.createElement("li");
            addCustomClass(liElement, 'swiper-slide');
            fakeSlide.parentNode.insertBefore(liElement, fakeSlide);
            liElement.appendChild(fakeSlide);
        });

    }

    const slider = item.querySelector('.swiper-container');
  
    const prevBtn = item.querySelector('.swiper-button-prev');
    const nextBtn = item.querySelector('.swiper-button-next');
  
    let slidesPerView = 4;
  
    new Swiper(slider, {
      slidesPerView: slidesPerView,
      spaceBetween: 20,
      observer: true,
      observeParents: true,
      watchOverflow: true,
      speed: 1500,

      navigation: {
        nextEl: nextBtn,
        prevEl: prevBtn,
      },
  
      autoplay: {
        delay: 8000,
      },
  
      breakpoints: {
        320:{
          slidesPerView: 2,
        },
        768:{
          slidesPerView: 3,
        },
        1024: {
          slidesPerView: slidesPerView
        }
      }
    });
  });




  document.querySelectorAll('.product-card__like').forEach((item) => {
    item.addEventListener('click', (e) => {
      e.preventDefault();
      toggleCustomClass(item,'active')
    })
  })