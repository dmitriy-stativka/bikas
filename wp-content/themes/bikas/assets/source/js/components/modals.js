import vars from "../_vars";
import { disableScroll } from "../functions/disable-scroll";
import { enableScroll } from "../functions/enable-scroll";
import {
  removeClassInArray,
  addCustomClass,
  removeCustomClass,fadeOut,fadeIn
} from "../functions/customFunctions";
import { data } from "autoprefixer";

export function modalClickHandler(attribute, activeClass) {
  const curentModal = overlay.querySelector(`[data-popup="${attribute}"]`);
  removeClassInArray(modals, activeClass);
  addCustomClass(overlay, activeClass);
  addCustomClass(curentModal, activeClass);
  fadeIn(curentModal, 200)
  disableScroll();
  innerButton = overlay.querySelector(`${"[data-popup]"}.${activeClass} .close`
  );
}

const {
  overlay,
  activeClass,
  modalsButton,
  mobileMenu,
  modals,
  innerButtonModal,
  activeMode,
  bodyEl,
  burger
} = vars;
let innerButton;
let innerButtonMode;
const commonFunction = function () {
  removeCustomClass(overlay, activeMode);
  removeCustomClass(overlay, activeClass);
  removeClassInArray(modals, activeClass);

  modals.forEach((modal) => fadeOut(modal, 300))
  enableScroll();
};

function buttonClickHandler(e, buttonAttribute, activeClass) {
  e.preventDefault();
  const currentModalId = e.target.getAttribute(`${buttonAttribute}`);
  const curentModal = overlay.querySelector(`[data-popup="${currentModalId}"]`);
  removeCustomClass(mobileMenu, 'active');
  removeClassInArray(burger, 'active');

  removeClassInArray(modals, activeClass);
  addCustomClass(overlay, activeClass);
  addCustomClass(curentModal, activeClass);
  fadeIn(curentModal, 200)
  disableScroll();
  innerButton = overlay.querySelector(`${"[data-popup]"}.${activeClass} .close`);
  innerButtonMode = overlay.querySelector(`${"[data-popup]"}.${activeClass} .close.mode`);
}

function overlayClickHandler(e, activeClass) {
  if (e.target === overlay || e.target === innerButton || e.target === innerButtonMode) commonFunction();
}

function modalInit(buttonsArray, buttonAttribute, activeClass) {
  buttonsArray.map(function (btn) {
    btn.addEventListener("click", (e) =>
      buttonClickHandler(e, buttonAttribute, activeClass)
    );
  });
}

overlay && overlay.addEventListener("click", function (e) {
  overlayClickHandler(e, activeClass);
});

modalInit(modalsButton, "data-btn-modal", activeClass);

innerButtonModal && innerButtonModal.map(function (btn) {
  btn.addEventListener("click", function (e) {
    e.preventDefault();
    const prevId = this.closest('[data-popup]').getAttribute('data-popup');

    const currentModalId = this.getAttribute("data-btn-inner");
    const curentModal = overlay.querySelector(
      `[data-popup="${currentModalId}"]`
    );
    removeClassInArray(modals, activeClass);
    addCustomClass(overlay, activeClass);
    fadeOut(document.querySelector(`[data-popup="${prevId}"]`), 0);
    fadeIn(curentModal, 200);
    addCustomClass(curentModal, activeClass);
    disableScroll();
    innerButton = overlay.querySelector(
      `${"[data-popup]"}.${activeClass} .close`
    );
  });
});


bodyEl.classList.contains('open-login') && modalClickHandler('sign', 'active');
bodyEl.classList.contains('open-register') && modalClickHandler('register', 'active');
