(window.webpackWcBlocksJsonp=window.webpackWcBlocksJsonp||[]).push([[61],{947:function(e,t,c){"use strict";c.r(t);var n=c(0),a=c(1),s=c(4),r=c.n(s),o=c(12),l=c(948),d=c(11),i=c(7),b=c(10),u=c(369);t.default=Object(d.withInstanceId)(({text:e,checkbox:t,instanceId:c,className:s})=>{const[d,m]=Object(n.useState)(!1),{isDisabled:O}=Object(l.a)(),h="terms-and-conditions-"+c,{setValidationErrors:E,clearValidationError:_}=Object(i.useDispatch)(b.VALIDATION_STORE_KEY),j=Object(i.useSelect)(e=>e(b.VALIDATION_STORE_KEY).getValidationError(h)),k=!(null==j||!j.message||null!=j&&j.hidden);return Object(n.useEffect)(()=>{if(t)return d?_(h):E({[h]:{message:Object(a.__)("Please read and accept the terms and conditions.","woo-gutenberg-products-block"),hidden:!0}}),()=>{_(h)}},[t,d,h,_,E]),Object(n.createElement)("div",{className:r()("wc-block-checkout__terms",{"wc-block-checkout__terms--disabled":O},s)},t?Object(n.createElement)(n.Fragment,null,Object(n.createElement)(o.CheckboxControl,{id:"terms-and-conditions",checked:d,onChange:()=>m(e=>!e),hasError:k,disabled:O},Object(n.createElement)("span",{dangerouslySetInnerHTML:{__html:e||u.a}}))):Object(n.createElement)("span",{dangerouslySetInnerHTML:{__html:e||u.b}}))})}}]);