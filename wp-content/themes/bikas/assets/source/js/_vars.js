export default {
    activeClass: "active",
    windowEl: window,
    documentEl: document,
    htmlEl: document.documentElement,
    bodyEl: document.body,
    // accParrent:[...document.querySelectorAll('[data-acc-init]')],
    // overlay: document.querySelector('[data-overlay]'),
    // header: document.querySelector('header'),
    // portfolioGallery: document.querySelectorAll('.portfolio-gallery'),
    // mobileMenu: document.querySelector('.main-nav'),
    burger: [...document.querySelectorAll(".burger")],

    mainSlider: document.querySelectorAll(".banner-section__inner"),
    productsSlider: document.querySelectorAll(".product-section__inner"),
    sortBlock: document.querySelector('.woocommerce-ordering')
};
