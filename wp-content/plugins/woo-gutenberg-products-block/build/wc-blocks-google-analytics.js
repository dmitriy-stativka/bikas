!function(e){var t={};function o(c){if(t[c])return t[c].exports;var n=t[c]={i:c,l:!1,exports:{}};return e[c].call(n.exports,n,n.exports,o),n.l=!0,n.exports}o.m=e,o.c=t,o.d=function(e,t,c){o.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:c})},o.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},o.t=function(e,t){if(1&t&&(e=o(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var c=Object.create(null);if(o.r(c),Object.defineProperty(c,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var n in e)o.d(c,n,function(t){return e[t]}.bind(null,n));return c},o.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return o.d(t,"a",t),t},o.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},o.p="",o(o.s=20)}({2:function(e,t){e.exports=window.wp.i18n},20:function(e,t,o){"use strict";o.r(t);var c=o(2),n=o(5);const r="woocommerce-google-analytics",i="experimental__woocommerce_blocks",a=(e,t)=>{const o=e.sku?e.sku:"#"+e.id,c="categories"in e&&e.categories.length?e.categories[0].name:"";return{id:o,name:e.name,quantity:t,category:c,price:(parseInt(e.prices.price,10)/10**e.prices.currency_minor_unit).toString()}},u=(e,t)=>{const o=e.sku?e.sku:"#"+e.id,c=e.categories.length?e.categories[0].name:"";return{id:o,name:e.name,list_name:t,category:c,price:(parseInt(e.prices.price,10)/10**e.prices.currency_minor_unit).toString()}},s=(e,t)=>{if("function"!=typeof gtag)throw new Error("Function gtag not implemented.");console.log(`Tracking event ${e}`),window.gtag("event",e,t)};let d=-1;const p=e=>({storeCart:t})=>{var o;d!==e&&(s(0===e?"begin_checkout":"checkout_progress",{items:t.cartItems.map(a),coupon:(null===(o=t.cartCoupons[0])||void 0===o?void 0:o.code)||"",currency:t.cartTotals.currency_code,value:(parseInt(t.cartTotals.total_price,10)/10**t.cartTotals.currency_minor_unit).toString(),checkout_step:e}),d=e)},l=({step:e,option:t,value:o})=>()=>{s("set_checkout_option",{checkout_step:e,checkout_option:t,value:o}),d=e};Object(n.addAction)(`${i}-checkout-render-checkout-form`,r,p(0)),Object(n.addAction)(`${i}-checkout-set-email-address`,r,p(1)),Object(n.addAction)(`${i}-checkout-set-shipping-address`,r,p(2)),Object(n.addAction)(`${i}-checkout-set-billing-address`,r,p(3)),Object(n.addAction)(`${i}-checkout-set-phone-number`,r,(({step:e,...t})=>{p("shipping"===e?2:3)(t)})),Object(n.addAction)(`${i}-checkout-set-selected-shipping-rate`,r,(({shippingRateId:e})=>{l({step:4,option:Object(c.__)("Shipping Method","woo-gutenberg-products-block"),value:e})()})),Object(n.addAction)(`${i}-checkout-set-active-payment-method`,r,(({paymentMethodSlug:e})=>{l({step:5,option:Object(c.__)("Payment Method","woo-gutenberg-products-block"),value:e})()})),Object(n.addAction)(`${i}-checkout-submit`,r,(()=>{s("add_payment_info")})),Object(n.addAction)(`${i}-cart-add-item`,r,(({product:e,quantity:t=1})=>{s("add_to_cart",{event_category:"ecommerce",event_label:Object(c.__)("Add to Cart","woo-gutenberg-products-block"),items:[a(e,t)]})})),Object(n.addAction)(`${i}-cart-remove-item`,r,(({product:e,quantity:t=1})=>{s("remove_from_cart",{event_category:"ecommerce",event_label:Object(c.__)("Remove Cart Item","woo-gutenberg-products-block"),items:[a(e,t)]})})),Object(n.addAction)(`${i}-cart-set-item-quantity`,r,(({product:e,quantity:t=1})=>{s("change_cart_quantity",{event_category:"ecommerce",event_label:Object(c.__)("Change Cart Item Quantity","woo-gutenberg-products-block"),items:[a(e,t)]})})),Object(n.addAction)(`${i}-product-list-render`,r,(({products:e,listName:t=Object(c.__)("Product List","woo-gutenberg-products-block")})=>{0!==e.length&&s("view_item_list",{event_category:"engagement",event_label:Object(c.__)("Viewing products","woo-gutenberg-products-block"),items:e.map(((e,o)=>({...u(e,t),list_position:o+1})))})})),Object(n.addAction)(`${i}-product-view-link`,r,(({product:e,listName:t})=>{s("select_content",{content_type:"product",items:[u(e,t)]})})),Object(n.addAction)(`${i}-product-search`,r,(({searchTerm:e})=>{s("search",{search_term:e})})),Object(n.addAction)(`${i}-product-render`,r,(({product:e,listName:t})=>{e&&s("view_item",{items:[u(e,t)]})})),Object(n.addAction)(`${i}-store-notice-create`,r,(({status:e,content:t})=>{"error"===e&&s("exception",{description:t,fatal:!1})}))},5:function(e,t){e.exports=window.wp.hooks}});