// import { disableScroll } from '../functions/disable-scroll';
// import { enableScroll } from '../functions/enable-scroll';
// import vars from '../_vars';
// import { elementHeight } from '../functions/customFunctions';

// import {addCustomClass, removeCustomClass, removeClassInArray} from '../functions/customFunctions'

// let mobileMenu = document.querySelector('.main-nav');
// let burger = [...document.querySelectorAll('.burger')];
// let innerClose = [...document.querySelectorAll('.inner-close')];

// let mobileAside = document.querySelector('.dashboard-aside');
// let burgerAside = [...document.querySelectorAll('.dashboard-burger')];

// const mobileMenuHandler = function( menu, button, body) {
//   button.addEventListener('click', function(){
//     elementHeight(vars.menu, "menu-height");
//     menu.classList.toggle('active');
//     button.classList.toggle('active');
//     body.classList.toggle('fixed-body');
//   })
// }


// const linksAside = [...document.querySelectorAll('.aside-nav__button')]

// if(burger) {
//   burger.map(function(btn){
//     mobileMenuHandler(mobileMenu,btn, vars.bodyEl);
//   });

//   const links = [...document.querySelectorAll('.mobile-menu__link')]

//   links.map(function(btn){
//     btn.addEventListener('click', function(){
//       removeCustomClass(mobileMenu, 'active')
//       removeCustomClass(btn, 'active')
//       removeCustomClass(burger, 'active')
//     })
//   })
// }


// if (burgerAside) {
//   burgerAside.map(function(btn){
//     mobileMenuHandler(mobileAside,btn, vars.bodyEl);
//   })

//   linksAside.map(function(btn){
//     btn.addEventListener('click', function(){
//       removeCustomClass(mobileAside, 'active');
//       removeCustomClass(btn, 'active');
//       removeCustomClass(vars.bodyEl, 'fixed-body');
//       removeClassInArray(burgerAside, 'active');
//     })
//   })
// }

// innerClose.map(function(btn){

//   if (btn) {
//     btn.addEventListener('click', function(){
//       removeCustomClass(mobileAside, 'active');
//       removeCustomClass(vars.bodyEl, 'fixed-body');
//       removeClassInArray(burgerAside, 'active');
//     })
//   }



// })



