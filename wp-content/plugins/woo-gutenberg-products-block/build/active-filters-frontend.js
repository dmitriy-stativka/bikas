!function(e){var t={};function r(n){if(t[n])return t[n].exports;var c=t[n]={i:n,l:!1,exports:{}};return e[n].call(c.exports,c,c.exports,r),c.l=!0,c.exports}r.m=e,r.c=t,r.d=function(e,t,n){r.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:n})},r.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},r.t=function(e,t){if(1&t&&(e=r(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var n=Object.create(null);if(r.r(n),Object.defineProperty(n,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var c in e)r.d(n,c,function(t){return e[t]}.bind(null,c));return n},r.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return r.d(t,"a",t),t},r.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},r.p="",r(r.s=238)}({0:function(e,t){e.exports=window.wp.element},1:function(e,t){e.exports=window.wp.i18n},109:function(e,t,r){"use strict";r.d(t,"a",(function(){return c})),r.d(t,"b",(function(){return o}));var n=r(45);const c=(e=[],t,r,c="")=>{const o=e.filter((e=>e.attribute===r.taxonomy)),s=o.length?o[0]:null;if(!(s&&s.slug&&Array.isArray(s.slug)&&s.slug.includes(c)))return;const a=s.slug.filter((e=>e!==c)),i=e.filter((e=>e.attribute!==r.taxonomy));a.length>0&&(s.slug=a.sort(),i.push(s)),t(Object(n.a)(i).asc("attribute"))},o=(e=[],t,r,c=[],o="in")=>{if(!r||!r.taxonomy)return[];const s=e.filter((e=>e.attribute!==r.taxonomy));return 0===c.length?t(s):(s.push({attribute:r.taxonomy,operator:o,slug:c.map((({slug:e})=>e)).sort()}),t(Object(n.a)(s).asc("attribute"))),s}},117:function(e,t,r){"use strict";r.d(t,"a",(function(){return o})),r.d(t,"b",(function(){return s}));var n=r(2);r(138),r(4);const c=Object(n.getSetting)("attributes",[]).reduce(((e,t)=>{const r=(n=t)&&n.attribute_name?{id:parseInt(n.attribute_id,10),name:n.attribute_name,taxonomy:"pa_"+n.attribute_name,label:n.attribute_label}:null;var n;return r&&r.id&&e.push(r),e}),[]),o=e=>{if(e)return c.find((t=>t.id===e))},s=e=>{if(e)return c.find((t=>t.taxonomy===e))}},12:function(e,t,r){var n=r(39);e.exports=function(e,t,r){return(t=n(t))in e?Object.defineProperty(e,t,{value:r,enumerable:!0,configurable:!0,writable:!0}):e[t]=r,e},e.exports.__esModule=!0,e.exports.default=e.exports},13:function(e,t){e.exports=window.wp.primitives},137:function(e){e.exports=JSON.parse('{"name":"woocommerce/active-filters","version":"1.0.0","title":"Active Filters Controls","description":"Display the currently active filters.","category":"woocommerce","keywords":["WooCommerce"],"supports":{"html":false,"multiple":false,"inserter":false,"color":{"text":true,"background":false},"lock":false},"attributes":{"displayStyle":{"type":"string","default":"list"},"headingLevel":{"type":"number","default":3}},"textdomain":"woo-gutenberg-products-block","apiVersion":2,"$schema":"https://schemas.wp.org/trunk/block.json"}')},138:function(e,t,r){"use strict";r.d(t,"b",(function(){return c})),r.d(t,"c",(function(){return o})),r.d(t,"a",(function(){return a}));var n=r(20);const c=e=>Object(n.b)(e,"count")&&Object(n.b)(e,"description")&&Object(n.b)(e,"id")&&Object(n.b)(e,"name")&&Object(n.b)(e,"parent")&&Object(n.b)(e,"slug")&&"number"==typeof e.count&&"string"==typeof e.description&&"number"==typeof e.id&&"string"==typeof e.name&&"number"==typeof e.parent&&"string"==typeof e.slug,o=e=>Array.isArray(e)&&e.every(c),s=e=>Object(n.b)(e,"attribute")&&Object(n.b)(e,"operator")&&Object(n.b)(e,"slug")&&"string"==typeof e.attribute&&"string"==typeof e.operator&&Array.isArray(e.slug)&&e.slug.every((e=>"string"==typeof e)),a=e=>Array.isArray(e)&&e.every(s)},14:function(e,t){e.exports=window.wp.isShallowEqual},15:function(e,t){e.exports=window.wp.url},157:function(e,t,r){"use strict";var n=r(0),c=r(1),o=r(30),s=r(2),a=r(5),i=r.n(a),l=r(19),u=r(63),b=r(20),p=r(138),f=r(66),d=r(60);r(224);var m=r(117),g=r(43),O=r(52),j=r(23),y=r(109),_=({attributeObject:e,slugs:t=[],operator:r="in",displayStyle:a,isLoadingCallback:i})=>{const{results:l,isLoading:b}=Object(O.a)({namespace:"/wc/store/v1",resourceName:"products/attributes/terms",resourceValues:[e.id]}),[f,d]=Object(o.b)("attributes",[]);if(Object(n.useEffect)((()=>{i(b)}),[b,i]),!Array.isArray(l)||!Object(p.c)(l)||!Object(p.a)(f))return null;const m=e.label,_=Object(s.getSettingWithCoercion)("is_rendering_php_template",!1,u.a);return Object(n.createElement)("li",null,Object(n.createElement)("span",{className:"wc-block-active-filters__list-item-type"},m,":"),Object(n.createElement)("ul",null,t.map(((t,o)=>{const s=l.find((e=>e.slug===t));if(!s)return null;let i="";return o>0&&"and"===r&&(i=Object(n.createElement)("span",{className:"wc-block-active-filters__list-item-operator"},Object(c.__)("All","woo-gutenberg-products-block"))),Object(g.f)({type:m,name:Object(j.decodeEntities)(s.name||t),prefix:i,isLoading:b,removeCallback:()=>{const r=f.find((({attribute:t})=>t===`pa_${e.name}`));1===(null==r?void 0:r.slug.length)?Object(g.e)(`query_type_${e.name}`,`filter_${e.name}`):Object(g.e)({[`filter_${e.name}`]:t}),_||Object(y.a)(f,d,e,t)},showLabel:!1,displayStyle:a})}))))},w=({displayStyle:e,isLoading:t})=>t?Object(n.createElement)(n.Fragment,null,[...Array("list"===e?2:3)].map(((t,r)=>Object(n.createElement)("li",{className:"list"===e?"show-loading-state-list":"show-loading-state-chips",key:r},Object(n.createElement)("span",{className:"show-loading-state__inner"}))))):null,v=r(46);t.a=({attributes:e,isEditor:t=!1})=>{const r=Object(v.b)(),a=function(){const e=Object(n.useRef)(!1);return Object(n.useEffect)((()=>(e.current=!0,()=>{e.current=!1})),[]),Object(n.useCallback)((()=>e.current),[])}()(),O=Object(s.getSettingWithCoercion)("is_rendering_php_template",!1,u.a),[j,y]=Object(n.useState)(!0),E=Object(g.c)()&&!t&&j,[h,k]=Object(o.b)("attributes",[]),[S,x]=Object(o.b)("stock_status",[]),[A,P]=Object(o.b)("min_price"),[N,R]=Object(o.b)("max_price"),[C,T]=Object(o.b)("rating"),B=Object(s.getSetting)("stockStatusOptions",[]),L=Object(s.getSetting)("attributes",[]),M=Object(n.useMemo)((()=>{if(E||0===S.length||(t=S,!Array.isArray(t)||!t.every((e=>["instock","outofstock","onbackorder"].includes(e))))||!(e=>Object(b.a)(e)&&Object.keys(e).every((e=>["instock","outofstock","onbackorder"].includes(e))))(B))return null;var t;const r=Object(c.__)("Stock Status","woo-gutenberg-products-block");return Object(n.createElement)("li",null,Object(n.createElement)("span",{className:"wc-block-active-filters__list-item-type"},r,":"),Object(n.createElement)("ul",null,S.map((t=>Object(g.f)({type:r,name:B[t],removeCallback:()=>{if(Object(g.e)({filter_stock_status:t}),!O){const e=S.filter((e=>e!==t));x(e)}},showLabel:!1,displayStyle:e.displayStyle})))))}),[E,B,S,x,e.displayStyle,O]),F=Object(n.useMemo)((()=>E||!Number.isFinite(A)&&!Number.isFinite(N)?null:Object(g.f)({type:Object(c.__)("Price","woo-gutenberg-products-block"),name:Object(g.b)(A,N),removeCallback:()=>{Object(g.e)("max_price","min_price"),O||(P(void 0),R(void 0))},displayStyle:e.displayStyle})),[E,A,N,e.displayStyle,P,R,O]),Q=Object(n.useMemo)((()=>!Object(p.a)(h)&&a||!h.length&&!Object(g.g)(L)?(j&&y(!1),null):h.map((t=>{const r=Object(m.b)(t.attribute);return r?Object(n.createElement)(_,{attributeObject:r,displayStyle:e.displayStyle,slugs:t.slug,key:t.attribute,operator:t.operator,isLoadingCallback:y}):(j&&y(!1),null)}))),[h,a,L,j,e.displayStyle]);Object(n.useEffect)((()=>{var e;if(!O)return;if(C.length&&C.length>0)return;const t=null===(e=Object(f.d)("rating_filter"))||void 0===e?void 0:e.toString();t&&T(t.split(","))}),[O,C,T]);const G=Object(n.useMemo)((()=>{if(E||0===C.length||(t=C,!Array.isArray(t)||!t.every((e=>["1","2","3","4","5"].includes(e)))))return null;var t;const r=Object(c.__)("Rating","woo-gutenberg-products-block");return Object(n.createElement)("li",null,Object(n.createElement)("span",{className:"wc-block-active-filters__list-item-type"},r,":"),Object(n.createElement)("ul",null,C.map((t=>Object(g.f)({type:r,name:Object(c.sprintf)(/* translators: %s is referring to the average rating value */
Object(c.__)("Rated %s out of 5","woo-gutenberg-products-block"),t),removeCallback:()=>{if(Object(g.e)({rating_filter:t}),!O){const e=C.filter((e=>e!==t));T(e)}},showLabel:!1,displayStyle:e.displayStyle})))))}),[E,C,T,e.displayStyle,O]);if(!E&&!(h.length>0||S.length>0||C.length>0||Number.isFinite(A)||Number.isFinite(N))&&!t)return r(!1),null;const U=`h${e.headingLevel}`,$=Object(n.createElement)(U,{className:"wc-block-active-filters__title"},e.heading),q=E?Object(n.createElement)(d.a,null,$):$;if(!Object(s.getSettingWithCoercion)("has_filterable_products",!1,u.a))return r(!1),null;r(!0);const Y=i()("wc-block-active-filters__list",{"wc-block-active-filters__list--chips":"chips"===e.displayStyle,"wc-block-active-filters--loading":E});return Object(n.createElement)(n.Fragment,null,!t&&e.heading&&q,Object(n.createElement)("div",{className:"wc-block-active-filters"},Object(n.createElement)("ul",{className:Y},t?Object(n.createElement)(n.Fragment,null,Object(g.f)({type:Object(c.__)("Size","woo-gutenberg-products-block"),name:Object(c.__)("Small","woo-gutenberg-products-block"),displayStyle:e.displayStyle}),Object(g.f)({type:Object(c.__)("Color","woo-gutenberg-products-block"),name:Object(c.__)("Blue","woo-gutenberg-products-block"),displayStyle:e.displayStyle})):Object(n.createElement)(n.Fragment,null,Object(n.createElement)(w,{isLoading:E,displayStyle:e.displayStyle}),F,M,Q,G)),E?Object(n.createElement)("span",{className:"wc-block-active-filters__clear-all-placeholder"}):Object(n.createElement)("button",{className:"wc-block-active-filters__clear-all",onClick:()=>{Object(g.a)(),O||(P(void 0),R(void 0),k([]),x([]),T([]))}},Object(n.createElement)(l.a,{label:Object(c.__)("Clear All","woo-gutenberg-products-block"),screenReaderLabel:Object(c.__)("Clear All Filters","woo-gutenberg-products-block")}))))}},16:function(e,t,r){"use strict";var n=r(12),c=r.n(n),o=r(0),s=r(1),a=r(29),i=({imageUrl:e=`${a.n}/block-error.svg`,header:t=Object(s.__)("Oops!","woo-gutenberg-products-block"),text:r=Object(s.__)("There was an error loading the content.","woo-gutenberg-products-block"),errorMessage:n,errorMessagePrefix:c=Object(s.__)("Error:","woo-gutenberg-products-block"),button:i,showErrorBlock:l=!0})=>l?Object(o.createElement)("div",{className:"wc-block-error wc-block-components-error"},e&&Object(o.createElement)("img",{className:"wc-block-error__image wc-block-components-error__image",src:e,alt:""}),Object(o.createElement)("div",{className:"wc-block-error__content wc-block-components-error__content"},t&&Object(o.createElement)("p",{className:"wc-block-error__header wc-block-components-error__header"},t),r&&Object(o.createElement)("p",{className:"wc-block-error__text wc-block-components-error__text"},r),n&&Object(o.createElement)("p",{className:"wc-block-error__message wc-block-components-error__message"},c?c+" ":"",n),i&&Object(o.createElement)("p",{className:"wc-block-error__button wc-block-components-error__button"},i))):null;r(41);class l extends o.Component{constructor(...e){super(...e),c()(this,"state",{errorMessage:"",hasError:!1})}static getDerivedStateFromError(e){return void 0!==e.statusText&&void 0!==e.status?{errorMessage:Object(o.createElement)(o.Fragment,null,Object(o.createElement)("strong",null,e.status),": ",e.statusText),hasError:!0}:{errorMessage:e.message,hasError:!0}}render(){const{header:e,imageUrl:t,showErrorMessage:r=!0,showErrorBlock:n=!0,text:c,errorMessagePrefix:s,renderError:a,button:l}=this.props,{errorMessage:u,hasError:b}=this.state;return b?"function"==typeof a?a({errorMessage:u}):Object(o.createElement)(i,{showErrorBlock:n,errorMessage:r?u:null,header:e,imageUrl:t,text:c,errorMessagePrefix:s,button:l}):this.props.children}}t.a=l},19:function(e,t,r){"use strict";var n=r(0),c=r(5),o=r.n(c);t.a=({label:e,screenReaderLabel:t,wrapperElement:r,wrapperProps:c={}})=>{let s;const a=null!=e,i=null!=t;return!a&&i?(s=r||"span",c={...c,className:o()(c.className,"screen-reader-text")},Object(n.createElement)(s,{...c},t)):(s=r||n.Fragment,a&&i&&e!==t?Object(n.createElement)(s,{...c},Object(n.createElement)("span",{"aria-hidden":"true"},e),Object(n.createElement)("span",{className:"screen-reader-text"},t)):Object(n.createElement)(s,{...c},e))}},2:function(e,t){e.exports=window.wc.wcSettings},20:function(e,t,r){"use strict";r.d(t,"a",(function(){return c})),r.d(t,"b",(function(){return o}));var n=r(37);const c=e=>!Object(n.a)(e)&&e instanceof Object&&e.constructor===Object;function o(e,t){return c(e)&&t in e}},22:function(e,t,r){"use strict";r.d(t,"a",(function(){return o}));var n=r(0);const c=Object(n.createContext)("page"),o=()=>Object(n.useContext)(c);c.Provider},222:function(e,t){},223:function(e,t,r){"use strict";var n=r(0),c=r(13);const o=Object(n.createElement)(c.SVG,{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24"},Object(n.createElement)(c.Path,{d:"M12 13.06l3.712 3.713 1.061-1.06L13.061 12l3.712-3.712-1.06-1.06L12 10.938 8.288 7.227l-1.061 1.06L10.939 12l-3.712 3.712 1.06 1.061L12 13.061z"}));t.a=o},224:function(e,t){},23:function(e,t){e.exports=window.wp.htmlEntities},233:function(e,t,r){"use strict";var n=r(0),c=r(5),o=r.n(c),s=r(1),a=r(84),i=r(223);r(222);var l=({text:e,screenReaderText:t="",element:r="li",className:c="",radius:s="small",children:a=null,...i})=>{const l=r,u=o()(c,"wc-block-components-chip","wc-block-components-chip--radius-"+s),b=Boolean(t&&t!==e);return Object(n.createElement)(l,{className:u,...i},Object(n.createElement)("span",{"aria-hidden":b,className:"wc-block-components-chip__text"},e),b&&Object(n.createElement)("span",{className:"screen-reader-text"},t),a)};t.a=({ariaLabel:e="",className:t="",disabled:r=!1,onRemove:c=(()=>{}),removeOnAnyClick:u=!1,text:b,screenReaderText:p="",...f})=>{const d=u?"span":"button";if(!e){const t=p&&"string"==typeof p?p:b;e="string"!=typeof t?/* translators: Remove chip. */
Object(s.__)("Remove","woo-gutenberg-products-block"):Object(s.sprintf)(/* translators: %s text of the chip to remove. */
Object(s.__)('Remove "%s"',"woo-gutenberg-products-block"),t)}const m={"aria-label":e,disabled:r,onClick:c,onKeyDown:e=>{"Backspace"!==e.key&&"Delete"!==e.key||c()}},g=u?m:{},O=u?{"aria-hidden":!0}:m;return Object(n.createElement)(l,{...f,...g,className:o()(t,"is-removable"),element:u?"button":f.element,screenReaderText:p,text:b},Object(n.createElement)(d,{className:"wc-block-components-chip__remove",...O},Object(n.createElement)(a.a,{className:"wc-block-components-chip__remove-icon",icon:i.a,size:16})))}},238:function(e,t,r){e.exports=r(239)},239:function(e,t,r){"use strict";r.r(t);var n=r(50),c=r(157),o=r(43);Object(n.a)({selector:".wp-block-woocommerce-active-filters",Block:c.a,getProps:e=>({attributes:Object(o.d)(e.dataset),isEditor:!1})})},25:function(e,t,r){"use strict";r.d(t,"a",(function(){return s}));var n=r(0),c=r(14),o=r.n(c);function s(e){const t=Object(n.useRef)(e);return o()(e,t.current)||(t.current=e),t.current}},26:function(e,t){function r(t){return e.exports=r="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e},e.exports.__esModule=!0,e.exports.default=e.exports,r(t)}e.exports=r,e.exports.__esModule=!0,e.exports.default=e.exports},28:function(e,t,r){"use strict";r.d(t,"a",(function(){return n}));const n=e=>"string"==typeof e},29:function(e,t,r){"use strict";r.d(t,"p",(function(){return o})),r.d(t,"n",(function(){return s})),r.d(t,"m",(function(){return a})),r.d(t,"o",(function(){return i})),r.d(t,"k",(function(){return l})),r.d(t,"d",(function(){return u})),r.d(t,"h",(function(){return b})),r.d(t,"l",(function(){return p})),r.d(t,"c",(function(){return f})),r.d(t,"g",(function(){return d})),r.d(t,"f",(function(){return m})),r.d(t,"a",(function(){return j})),r.d(t,"b",(function(){return y})),r.d(t,"i",(function(){return _})),r.d(t,"j",(function(){return w})),r.d(t,"e",(function(){return v}));var n,c=r(2);const o=Object(c.getSetting)("wcBlocksConfig",{buildPhase:1,pluginUrl:"",productCount:0,defaultAvatar:"",restApiRoutes:{},wordCountType:"words"}),s=o.pluginUrl+"images/",a=o.pluginUrl+"build/",i=o.buildPhase,l=null===(n=c.STORE_PAGES.shop)||void 0===n?void 0:n.permalink,u=(c.STORE_PAGES.checkout.id,c.STORE_PAGES.checkout.permalink),b=c.STORE_PAGES.privacy.permalink,p=(c.STORE_PAGES.privacy.title,c.STORE_PAGES.terms.permalink),f=(c.STORE_PAGES.terms.title,c.STORE_PAGES.cart.id,c.STORE_PAGES.cart.permalink),d=c.STORE_PAGES.myaccount.permalink?c.STORE_PAGES.myaccount.permalink:Object(c.getSetting)("wpLoginUrl","/wp-login.php"),m=Object(c.getSetting)("localPickupEnabled",!1),g=Object(c.getSetting)("countries",{}),O=Object(c.getSetting)("countryData",{}),j=Object.fromEntries(Object.keys(O).filter((e=>!0===O[e].allowBilling)).map((e=>[e,g[e]||""]))),y=Object.fromEntries(Object.keys(O).filter((e=>!0===O[e].allowBilling)).map((e=>[e,O[e].states||[]]))),_=Object.fromEntries(Object.keys(O).filter((e=>!0===O[e].allowShipping)).map((e=>[e,g[e]||""]))),w=Object.fromEntries(Object.keys(O).filter((e=>!0===O[e].allowShipping)).map((e=>[e,O[e].states||[]]))),v=Object.fromEntries(Object.keys(O).map((e=>[e,O[e].locale||[]])))},3:function(e,t){e.exports=window.wc.wcBlocksData},30:function(e,t,r){"use strict";r.d(t,"a",(function(){return b})),r.d(t,"b",(function(){return p})),r.d(t,"c",(function(){return f}));var n=r(3),c=r(4),o=r(0),s=r(14),a=r.n(s),i=r(25),l=r(53),u=r(22);const b=e=>{const t=Object(u.a)();e=e||t;const r=Object(c.useSelect)((t=>t(n.QUERY_STATE_STORE_KEY).getValueForQueryContext(e,void 0)),[e]),{setValueForQueryContext:s}=Object(c.useDispatch)(n.QUERY_STATE_STORE_KEY);return[r,Object(o.useCallback)((t=>{s(e,t)}),[e,s])]},p=(e,t,r)=>{const s=Object(u.a)();r=r||s;const a=Object(c.useSelect)((c=>c(n.QUERY_STATE_STORE_KEY).getValueForQueryKey(r,e,t)),[r,e]),{setQueryValue:i}=Object(c.useDispatch)(n.QUERY_STATE_STORE_KEY);return[a,Object(o.useCallback)((t=>{i(r,e,t)}),[r,e,i])]},f=(e,t)=>{const r=Object(u.a)();t=t||r;const[n,c]=b(t),s=Object(i.a)(n),p=Object(i.a)(e),f=Object(l.a)(p),d=Object(o.useRef)(!1);return Object(o.useEffect)((()=>{a()(f,p)||(c(Object.assign({},s,p)),d.current=!0)}),[s,p,f,c]),d.current?[n,c]:[e,c]}},37:function(e,t,r){"use strict";r.d(t,"a",(function(){return n}));const n=e=>null===e},38:function(e,t){e.exports=window.wc.priceFormat},39:function(e,t,r){var n=r(26).default,c=r(40);e.exports=function(e){var t=c(e,"string");return"symbol"===n(t)?t:String(t)},e.exports.__esModule=!0,e.exports.default=e.exports},4:function(e,t){e.exports=window.wp.data},40:function(e,t,r){var n=r(26).default;e.exports=function(e,t){if("object"!==n(e)||null===e)return e;var r=e[Symbol.toPrimitive];if(void 0!==r){var c=r.call(e,t||"default");if("object"!==n(c))return c;throw new TypeError("@@toPrimitive must return a primitive value.")}return("string"===t?String:Number)(e)},e.exports.__esModule=!0,e.exports.default=e.exports},41:function(e,t){},43:function(e,t,r){"use strict";r.d(t,"b",(function(){return d})),r.d(t,"f",(function(){return m})),r.d(t,"e",(function(){return g})),r.d(t,"a",(function(){return y})),r.d(t,"c",(function(){return _})),r.d(t,"g",(function(){return w})),r.d(t,"d",(function(){return v}));var n=r(0),c=r(1),o=r(38),s=r(233),a=r(19),i=r(15),l=r(66),u=r(84),b=r(223),p=r(28),f=r(137);const d=(e,t)=>Number.isFinite(e)&&Number.isFinite(t)?Object(c.sprintf)(/* translators: %1$s min price, %2$s max price */
Object(c.__)("Between %1$s and %2$s","woo-gutenberg-products-block"),Object(o.formatPrice)(e),Object(o.formatPrice)(t)):Number.isFinite(e)?Object(c.sprintf)(/* translators: %s min price */
Object(c.__)("From %s","woo-gutenberg-products-block"),Object(o.formatPrice)(e)):Object(c.sprintf)(/* translators: %s max price */
Object(c.__)("Up to %s","woo-gutenberg-products-block"),Object(o.formatPrice)(t)),m=({type:e,name:t,prefix:r="",removeCallback:o=(()=>null),showLabel:i=!0,displayStyle:l})=>{const p=r?Object(n.createElement)(n.Fragment,null,r," ",t):t,f=Object(c.sprintf)(/* translators: %s attribute value used in the filter. For example: yellow, green, small, large. */
Object(c.__)("Remove %s filter","woo-gutenberg-products-block"),t);return Object(n.createElement)("li",{className:"wc-block-active-filters__list-item",key:e+":"+t},i&&Object(n.createElement)("span",{className:"wc-block-active-filters__list-item-type"},e+": "),"chips"===l?Object(n.createElement)(s.a,{element:"span",text:p,onRemove:o,radius:"large",ariaLabel:f}):Object(n.createElement)("span",{className:"wc-block-active-filters__list-item-name"},Object(n.createElement)("button",{className:"wc-block-active-filters__list-item-remove",onClick:o},Object(n.createElement)(u.a,{className:"wc-block-components-chip__remove-icon",icon:b.a,size:16}),Object(n.createElement)(a.a,{screenReaderLabel:f})),p))},g=(...e)=>{if(!window)return;const t=window.location.href,r=Object(i.getQueryArgs)(t),n=Object(i.removeQueryArgs)(t,...Object.keys(r));e.forEach((e=>{if("string"==typeof e)return delete r[e];if("object"==typeof e){const t=Object.keys(e)[0],n=r[t].toString().split(",");r[t]=n.filter((r=>r!==e[t])).join(",")}}));const c=Object.fromEntries(Object.entries(r).filter((([,e])=>e))),o=Object(i.addQueryArgs)(n,c);Object(l.c)(o)},O=["min_price","max_price","rating_filter","filter_","query_type_"],j=e=>{let t=!1;for(let r=0;O.length>r;r++){const n=O[r];if(n===e.substring(0,n.length)){t=!0;break}}return t},y=()=>{if(!window)return;const e=window.location.href,t=Object(i.getQueryArgs)(e),r=Object(i.removeQueryArgs)(e,...Object.keys(t)),n=Object.fromEntries(Object.keys(t).filter((e=>!j(e))).map((e=>[e,t[e]]))),c=Object(i.addQueryArgs)(r,n);Object(l.c)(c)},_=()=>{if(!window)return!1;const e=window.location.href,t=Object(i.getQueryArgs)(e),r=Object.keys(t);let n=!1;for(let e=0;r.length>e;e++){const t=r[e];if(j(t)){n=!0;break}}return n},w=e=>{if(!window)return!1;const t=e.map((e=>`filter_${e.attribute_name}`)),r=window.location.href,n=Object(i.getQueryArgs)(r),c=Object.keys(n);let o=!1;for(let e=0;c.length>e;e++){const r=c[e];if(t.includes(r)){o=!0;break}}return o},v=e=>({heading:Object(p.a)(null==e?void 0:e.heading)?e.heading:"",headingLevel:Object(p.a)(null==e?void 0:e.headingLevel)&&parseInt(e.headingLevel,10)||f.attributes.headingLevel.default,displayStyle:Object(p.a)(null==e?void 0:e.displayStyle)&&e.displayStyle||f.attributes.displayStyle.default})},45:function(e,t,r){"use strict";r.d(t,"a",(function(){return u}));var n=function(e){return function(t,r,n){return e(t,r,n)*n}},c=function(e,t){if(e)throw Error("Invalid sort config: "+t)},o=function(e){var t=e||{},r=t.asc,o=t.desc,s=r?1:-1,a=r||o;return c(!a,"Expected `asc` or `desc` property"),c(r&&o,"Ambiguous object with `asc` and `desc` config properties"),{order:s,sortBy:a,comparer:e.comparer&&n(e.comparer)}};function s(e,t,r){if(void 0===e||!0===e)return function(e,n){return t(e,n,r)};if("string"==typeof e)return c(e.includes("."),"String syntax not allowed for nested properties."),function(n,c){return t(n[e],c[e],r)};if("function"==typeof e)return function(n,c){return t(e(n),e(c),r)};if(Array.isArray(e)){var n=function(e){return function t(r,n,c,s,a,i,l){var u,b;if("string"==typeof r)u=i[r],b=l[r];else{if("function"!=typeof r){var p=o(r);return t(p.sortBy,n,c,p.order,p.comparer||e,i,l)}u=r(i),b=r(l)}var f=a(u,b,s);return(0===f||null==u&&null==b)&&n.length>c?t(n[c],n,c+1,s,a,i,l):f}}(t);return function(c,o){return n(e[0],e,1,r,t,c,o)}}var a=o(e);return s(a.sortBy,a.comparer||t,a.order)}var a=function(e,t,r,n){return Array.isArray(t)?(Array.isArray(r)&&r.length<2&&(r=r[0]),t.sort(s(r,n,e))):t};function i(e){var t=n(e.comparer);return function(r){var n=Array.isArray(r)&&!e.inPlaceSorting?r.slice():r;return{asc:function(e){return a(1,n,e,t)},desc:function(e){return a(-1,n,e,t)},by:function(e){return a(1,n,e,t)}}}}var l=function(e,t,r){return null==e?r:null==t?-r:typeof e!=typeof t?typeof e<typeof t?-1:1:e<t?-1:e>t?1:0},u=i({comparer:l});i({comparer:l,inPlaceSorting:!0})},46:function(e,t,r){"use strict";r.d(t,"a",(function(){return c})),r.d(t,"b",(function(){return o}));var n=r(0);const c=Object(n.createContext)({}),o=()=>{const{wrapper:e}=Object(n.useContext)(c);return t=>{e&&e.current&&(e.current.hidden=!t)}}},5:function(e,t,r){var n;!function(){"use strict";var r={}.hasOwnProperty;function c(){for(var e=[],t=0;t<arguments.length;t++){var n=arguments[t];if(n){var o=typeof n;if("string"===o||"number"===o)e.push(n);else if(Array.isArray(n)){if(n.length){var s=c.apply(null,n);s&&e.push(s)}}else if("object"===o)if(n.toString===Object.prototype.toString)for(var a in n)r.call(n,a)&&n[a]&&e.push(a);else e.push(n.toString())}}return e.join(" ")}e.exports?(c.default=c,e.exports=c):void 0===(n=function(){return c}.apply(t,[]))||(e.exports=n)}()},50:function(e,t,r){"use strict";r.d(t,"a",(function(){return a}));var n=r(0),c=r(16);const o=[".wp-block-woocommerce-cart"],s=({Block:e,containers:t,getProps:r=(()=>({})),getErrorBoundaryProps:o=(()=>({}))})=>{0!==t.length&&Array.prototype.forEach.call(t,((t,s)=>{const a=r(t,s),i=o(t,s),l={...t.dataset,...a.attributes||{}};(({Block:e,container:t,attributes:r={},props:o={},errorBoundaryProps:s={}})=>{Object(n.render)(Object(n.createElement)(c.a,{...s},Object(n.createElement)(n.Suspense,{fallback:Object(n.createElement)("div",{className:"wc-block-placeholder"})},e&&Object(n.createElement)(e,{...o,attributes:r}))),t,(()=>{t.classList&&t.classList.remove("is-loading")}))})({Block:e,container:t,props:a,attributes:l,errorBoundaryProps:i})}))},a=e=>{const t=document.body.querySelectorAll(o.join(",")),{Block:r,getProps:n,getErrorBoundaryProps:c,selector:a}=e;(({Block:e,getProps:t,getErrorBoundaryProps:r,selector:n,wrappers:c})=>{const o=document.body.querySelectorAll(n);c&&c.length>0&&Array.prototype.filter.call(o,(e=>!((e,t)=>Array.prototype.some.call(t,(t=>t.contains(e)&&!t.isSameNode(e))))(e,c))),s({Block:e,containers:o,getProps:t,getErrorBoundaryProps:r})})({Block:r,getProps:n,getErrorBoundaryProps:c,selector:a,wrappers:t}),Array.prototype.forEach.call(t,(t=>{t.addEventListener("wc-blocks_render_blocks_frontend",(()=>{(({Block:e,getProps:t,getErrorBoundaryProps:r,selector:n,wrapper:c})=>{const o=c.querySelectorAll(n);s({Block:e,containers:o,getProps:t,getErrorBoundaryProps:r})})({...e,wrapper:t})}))}))}},52:function(e,t,r){"use strict";r.d(t,"a",(function(){return a}));var n=r(3),c=r(4),o=r(0),s=r(25);const a=e=>{const{namespace:t,resourceName:r,resourceValues:a=[],query:i={},shouldSelect:l=!0}=e;if(!t||!r)throw new Error("The options object must have valid values for the namespace and the resource properties.");const u=Object(o.useRef)({results:[],isLoading:!0}),b=Object(s.a)(i),p=Object(s.a)(a),f=(()=>{const[,e]=Object(o.useState)();return Object(o.useCallback)((t=>{e((()=>{throw t}))}),[])})(),d=Object(c.useSelect)((e=>{if(!l)return null;const c=e(n.COLLECTIONS_STORE_KEY),o=[t,r,b,p],s=c.getCollectionError(...o);if(s){if(!(s instanceof Error))throw new Error("TypeError: `error` object is not an instance of Error constructor");f(s)}return{results:c.getCollection(...o),isLoading:!c.hasFinishedResolution("getCollection",o)}}),[t,r,p,b,l]);return null!==d&&(u.current=d),u.current}},53:function(e,t,r){"use strict";r.d(t,"a",(function(){return c}));var n=r(0);function c(e,t){const r=Object(n.useRef)();return Object(n.useEffect)((()=>{r.current===e||t&&!t(e,r.current)||(r.current=e)}),[e,t]),r.current}},60:function(e,t,r){"use strict";var n=r(0);r(87),t.a=({children:e})=>Object(n.createElement)("div",{className:"wc-block-filter-title-placeholder"},e)},63:function(e,t,r){"use strict";r.d(t,"a",(function(){return n}));const n=e=>"boolean"==typeof e},66:function(e,t,r){"use strict";r.d(t,"b",(function(){return a})),r.d(t,"a",(function(){return i})),r.d(t,"d",(function(){return l})),r.d(t,"c",(function(){return u})),r.d(t,"e",(function(){return b}));var n=r(15),c=r(2),o=r(63);const s=Object(c.getSettingWithCoercion)("is_rendering_php_template",!1,o.a),a="query_type_",i="filter_";function l(e){return window?Object(n.getQueryArg)(window.location.href,e):null}function u(e){s?((e=e.replace(/(?:query-(?:\d+-)?page=(\d+))|(?:page\/(\d+))/g,"")).endsWith("?")&&(e=e.slice(0,-1)),window.location.href=e):window.history.replaceState({},"",e)}const b=e=>{const t=Object(n.getQueryArgs)(e);return Object(n.addQueryArgs)(e,t)}},84:function(e,t,r){"use strict";var n=r(0);t.a=function(e){let{icon:t,size:r=24,...c}=e;return Object(n.cloneElement)(t,{width:r,height:r,...c})}},87:function(e,t){}});