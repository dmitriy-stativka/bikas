(window.webpackWcBlocksJsonp=window.webpackWcBlocksJsonp||[]).push([[40],{290:function(e,t,c){"use strict";var o=c(0),n=c(5),s=c.n(n);c(291),t.a=({children:e,className:t,headingLevel:c,...n})=>{const a=s()("wc-block-components-title",t),l=`h${c}`;return Object(o.createElement)(l,{className:a,...n},e)}},291:function(e,t){},292:function(e,t){},316:function(e,t,c){"use strict";var o=c(0),n=c(5),s=c.n(n),a=c(290);c(292);const l=({title:e,stepHeadingContent:t})=>Object(o.createElement)("div",{className:"wc-block-components-checkout-step__heading"},Object(o.createElement)(a.a,{"aria-hidden":"true",className:"wc-block-components-checkout-step__title",headingLevel:"2"},e),!!t&&Object(o.createElement)("span",{className:"wc-block-components-checkout-step__heading-content"},t));t.a=({id:e,className:t,title:c,legend:n,description:a,children:r,disabled:d=!1,showStepNumber:i=!0,stepHeadingContent:b=(()=>{})})=>{const u=n||c?"fieldset":"div";return Object(o.createElement)(u,{className:s()(t,"wc-block-components-checkout-step",{"wc-block-components-checkout-step--with-step-number":i,"wc-block-components-checkout-step--disabled":d}),id:e,disabled:d},!(!n&&!c)&&Object(o.createElement)("legend",{className:"screen-reader-text"},n||c),!!c&&Object(o.createElement)(l,{title:c,stepHeadingContent:b()}),Object(o.createElement)("div",{className:"wc-block-components-checkout-step__container"},!!a&&Object(o.createElement)("p",{className:"wc-block-components-checkout-step__description"},a),Object(o.createElement)("div",{className:"wc-block-components-checkout-step__content"},r)))}},452:function(e,t){},514:function(e,t,c){"use strict";c.r(t);var o=c(0),n=c(5),s=c.n(n),a=c(1),l=c(316),r=c(91),d=c(4),i=c(3),b=c(9);c(452);const u=({className:e="",disabled:t=!1,onTextChange:c,placeholder:n,value:a=""})=>Object(o.createElement)("textarea",{className:s()("wc-block-components-textarea",e),disabled:t,onChange:e=>{c(e.target.value)},placeholder:n,rows:2,value:a});var p=({disabled:e,onChange:t,placeholder:c,value:n})=>{const[s,l]=Object(o.useState)(!1),[r,d]=Object(o.useState)("");return Object(o.createElement)("div",{className:"wc-block-checkout__add-note"},Object(o.createElement)(b.CheckboxControl,{disabled:e,label:Object(a.__)("Add a note to your order","woo-gutenberg-products-block"),checked:s,onChange:e=>{l(e),e?n!==r&&t(r):(t(""),d(n))}}),s&&Object(o.createElement)(u,{disabled:e,onTextChange:t,placeholder:c,value:n}))};t.default=({className:e})=>{const{needsShipping:t}=Object(r.a)(),{isProcessing:c,orderNotes:n}=Object(d.useSelect)((e=>{const t=e(i.CHECKOUT_STORE_KEY);return{isProcessing:t.isProcessing(),orderNotes:t.getOrderNotes()}})),{__internalSetOrderNotes:b}=Object(d.useDispatch)(i.CHECKOUT_STORE_KEY);return Object(o.createElement)(l.a,{id:"order-notes",showStepNumber:!1,className:s()("wc-block-checkout__order-notes",e),disabled:c},Object(o.createElement)(p,{disabled:c,onChange:b,placeholder:t?Object(a.__)("Notes about your order, e.g. special notes for delivery.","woo-gutenberg-products-block"):Object(a.__)("Notes about your order.","woo-gutenberg-products-block"),value:n}))}}}]);