export default {
    activeClass: "active",
    windowEl: window,
    documentEl: document,
    htmlEl: document.documentElement,
    bodyEl: document.body,

    overlay: document.querySelector('[data-overlay]'),
    // tabsParrents: [...document.querySelectorAll("[data-tabs-parrent]")],
    modals: [...document.querySelectorAll('[data-popup]')],
    modalsButton: [...document.querySelectorAll("[data-btn-modal]")],
    accParrent: document.querySelectorAll('[data-accordion]'),
    innerButtonModal: [...document.querySelectorAll("[data-btn-inner]")],

    burger: document.querySelectorAll('header .burger'),
    mobileMenu: document.querySelector('.mobile-menu'),
    catalogBtn: document.querySelectorAll(".catalog-trigger"),
    catalogMenu: document.querySelector(".catalog-menu"),


    // accParrent:[...document.querySelectorAll('[data-acc-init]')],
    // overlay: document.querySelector('[data-overlay]'),
    header: document.querySelector('header'),
    // portfolioGallery: document.querySelectorAll('.portfolio-gallery'),
    // mobileMenu: document.querySelector('.main-nav'),
    // burger: [...document.querySelectorAll(".burger")],

    mainSlider: document.querySelectorAll(".banner-section__inner"),
    productsSlider: document.querySelectorAll(".product-section__inner"),
    sortBlock: document.querySelector('.woocommerce-ordering'),

};
