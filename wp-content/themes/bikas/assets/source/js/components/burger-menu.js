import { disableScroll } from '../functions/disable-scroll';
import { enableScroll } from '../functions/enable-scroll';
import vars from '../_vars';

import {
  toggleClassInArray,
  toggleCustomClass,
  removeCustomClass,
  removeClassInArray,
} from '../functions/customFunctions';

const { overlay, burger, mobileMenu, catalogMenu, catalogBtn } = vars;

const mobileMenuHandler = function (overlay, mobileMenu, burger, customClass = 'active') {
  burger.forEach(btn => {
    btn.addEventListener('click', function (e) {
      e.preventDefault();

      toggleCustomClass(mobileMenu, 'active');
      toggleClassInArray(burger, 'active');
      toggleCustomClass(overlay, customClass);

      if (btn.classList.contains('burger') && document.querySelector('.catalog-trigger.active')) {
        removeCustomClass(document.querySelector('.catalog-trigger'), 'active')
      }

      if (btn.classList.contains('burger') && document.querySelector('.catalog-trigger.active')) {
        removeCustomClass(document.querySelector('.catalog-trigger'), 'active')
        removeCustomClass(document.querySelector('.catalog-menu'), 'active')
      }

      if (btn.classList.contains('catalog-trigger') && document.querySelector('.mobile-menu.active')) {
        removeCustomClass(document.querySelector('.mobile-menu'), 'active')
        removeCustomClass(document.querySelector('header .burger'), 'active')
        removeCustomClass(overlay, 'active-mode')
      }

      if (btn.classList.contains('active')) {
        disableScroll();
      } else {
        enableScroll();
      }
    });
  });
};

const hideMenuHandler = function (overlay, mobileMenu, burger, customClass = 'active') {
  removeCustomClass(mobileMenu, 'active');
  removeClassInArray(burger, 'active');
  removeCustomClass(overlay, customClass);

  enableScroll();
};

if (overlay) {

  mobileMenuHandler(overlay, mobileMenu, burger, 'active-mode');


  mobileMenuHandler(overlay, catalogMenu, catalogBtn);



  overlay.addEventListener('click', function (e) {
    if (e.target.classList.contains('overlay')) {
      hideMenuHandler(overlay, mobileMenu, burger, 'active-mode');


      hideMenuHandler(overlay, catalogMenu, catalogBtn);
    }
  });
}
