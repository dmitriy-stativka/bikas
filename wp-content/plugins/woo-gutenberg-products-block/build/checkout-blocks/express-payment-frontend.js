(window.webpackWcBlocksJsonp=window.webpackWcBlocksJsonp||[]).push([[38],{111:function(e,t,c){"use strict";var s=c(0);c(131),t.a=()=>Object(s.createElement)("span",{className:"wc-block-components-spinner","aria-hidden":"true"})},131:function(e,t){},145:function(e,t,c){"use strict";var s=c(0),n=c(1),a=c(5),o=c.n(a),r=(c(221),c(111));t.a=({children:e,className:t,screenReaderLabel:c,showSpinner:a=!1,isLoading:i=!0})=>Object(s.createElement)("div",{className:o()(t,{"wc-block-components-loading-mask":i})},i&&a&&Object(s.createElement)(r.a,null),Object(s.createElement)("div",{className:o()({"wc-block-components-loading-mask__children":i}),"aria-hidden":i},e),i&&Object(s.createElement)("span",{className:"screen-reader-text"},c||Object(n.__)("Loading…","woo-gutenberg-products-block")))},221:function(e,t){},290:function(e,t,c){"use strict";var s=c(0),n=c(5),a=c.n(n);c(291),t.a=({children:e,className:t,headingLevel:c,...n})=>{const o=a()("wc-block-components-title",t),r=`h${c}`;return Object(s.createElement)(r,{className:o,...n},e)}},291:function(e,t){},525:function(e,t,c){"use strict";c.r(t);var s=c(0),n=c(71),a=c(1),o=c(57),r=c(36),i=c(9),l=c(290),m=c(145),b=c(2),p=c(3),d=c(4),u=c(410);c(409);var E=()=>{const{isCalculating:e,isProcessing:t,isAfterProcessing:c,isBeforeProcessing:n,isComplete:E,hasError:O}=Object(d.useSelect)((e=>{const t=e(p.CHECKOUT_STORE_KEY);return{isCalculating:t.isCalculating(),isProcessing:t.isProcessing(),isAfterProcessing:t.isAfterProcessing(),isBeforeProcessing:t.isBeforeProcessing(),isComplete:t.isComplete(),hasError:t.hasError()}})),{availableExpressPaymentMethods:g,expressPaymentMethodsInitialized:h,isExpressPaymentMethodActive:j}=Object(d.useSelect)((e=>{const t=e(p.PAYMENT_STORE_KEY);return{availableExpressPaymentMethods:t.getAvailableExpressPaymentMethods(),expressPaymentMethodsInitialized:t.expressPaymentMethodsInitialized(),isExpressPaymentMethodActive:t.isExpressPaymentMethodActive()}})),{isEditor:k}=Object(o.a)();if(!h||h&&0===Object.keys(g).length)return k||b.CURRENT_USER_IS_ADMIN?Object(s.createElement)(i.StoreNoticesContainer,{context:r.d.EXPRESS_PAYMENTS}):null;const P=t||c||n||E&&!O;return Object(s.createElement)(s.Fragment,null,Object(s.createElement)(m.a,{isLoading:e||P||j},Object(s.createElement)("div",{className:"wc-block-components-express-payment wc-block-components-express-payment--checkout"},Object(s.createElement)("div",{className:"wc-block-components-express-payment__title-container"},Object(s.createElement)(l.a,{className:"wc-block-components-express-payment__title",headingLevel:"2"},Object(a.__)("Express Checkout","woo-gutenberg-products-block"))),Object(s.createElement)("div",{className:"wc-block-components-express-payment__content"},Object(s.createElement)(i.StoreNoticesContainer,{context:r.d.EXPRESS_PAYMENTS}),Object(s.createElement)(u.a,null)))),Object(s.createElement)("div",{className:"wc-block-components-express-payment-continue-rule wc-block-components-express-payment-continue-rule--checkout"},Object(a.__)("Or continue below","woo-gutenberg-products-block")))};t.default=({className:e})=>{const{cartNeedsPayment:t}=Object(n.a)();return t?Object(s.createElement)("div",{className:e},Object(s.createElement)(E,null)):null}}}]);