this.wc=this.wc||{},this.wc.blocks=this.wc.blocks||{},this.wc.blocks["product-template"]=function(e){function t(t){for(var o,l,i=t[0],u=t[1],s=t[2],p=0,d=[];p<i.length;p++)l=i[p],Object.prototype.hasOwnProperty.call(r,l)&&r[l]&&d.push(r[l][0]),r[l]=0;for(o in u)Object.prototype.hasOwnProperty.call(u,o)&&(e[o]=u[o]);for(a&&a(t);d.length;)d.shift()();return c.push.apply(c,s||[]),n()}function n(){for(var e,t=0;t<c.length;t++){for(var n=c[t],o=!0,i=1;i<n.length;i++){var u=n[i];0!==r[u]&&(o=!1)}o&&(c.splice(t--,1),e=l(l.s=n[0]))}return e}var o={},r={46:0,3:0},c=[];function l(t){if(o[t])return o[t].exports;var n=o[t]={i:t,l:!1,exports:{}};return e[t].call(n.exports,n,n.exports,l),n.l=!0,n.exports}l.m=e,l.c=o,l.d=function(e,t,n){l.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:n})},l.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},l.t=function(e,t){if(1&t&&(e=l(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var n=Object.create(null);if(l.r(n),Object.defineProperty(n,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var o in e)l.d(n,o,function(t){return e[t]}.bind(null,o));return n},l.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return l.d(t,"a",t),t},l.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},l.p="";var i=window.webpackWcBlocksJsonp=window.webpackWcBlocksJsonp||[],u=i.push.bind(i);i.push=t,i=i.slice();for(var s=0;s<i.length;s++)t(i[s]);var a=u;return c.push([546,0]),n()}({0:function(e,t){e.exports=window.wp.element},1:function(e,t){e.exports=window.wp.i18n},17:function(e,t,n){"use strict";n.d(t,"p",(function(){return c})),n.d(t,"n",(function(){return l})),n.d(t,"m",(function(){return i})),n.d(t,"o",(function(){return u})),n.d(t,"k",(function(){return s})),n.d(t,"e",(function(){return a})),n.d(t,"h",(function(){return p})),n.d(t,"l",(function(){return d})),n.d(t,"c",(function(){return f})),n.d(t,"d",(function(){return b})),n.d(t,"g",(function(){return m})),n.d(t,"a",(function(){return w})),n.d(t,"b",(function(){return O})),n.d(t,"i",(function(){return k})),n.d(t,"j",(function(){return h})),n.d(t,"f",(function(){return _}));var o,r=n(3);const c=Object(r.getSetting)("wcBlocksConfig",{buildPhase:1,pluginUrl:"",productCount:0,defaultAvatar:"",restApiRoutes:{},wordCountType:"words"}),l=c.pluginUrl+"images/",i=c.pluginUrl+"build/",u=c.buildPhase,s=null===(o=r.STORE_PAGES.shop)||void 0===o?void 0:o.permalink,a=r.STORE_PAGES.checkout.id,p=(r.STORE_PAGES.checkout.permalink,r.STORE_PAGES.privacy.permalink),d=(r.STORE_PAGES.privacy.title,r.STORE_PAGES.terms.permalink),f=(r.STORE_PAGES.terms.title,r.STORE_PAGES.cart.id),b=r.STORE_PAGES.cart.permalink,m=(r.STORE_PAGES.myaccount.permalink?r.STORE_PAGES.myaccount.permalink:Object(r.getSetting)("wpLoginUrl","/wp-login.php"),Object(r.getSetting)("localPickupEnabled",!1)),g=Object(r.getSetting)("countries",{}),y=Object(r.getSetting)("countryData",{}),w=Object.fromEntries(Object.keys(y).filter((e=>!0===y[e].allowBilling)).map((e=>[e,g[e]||""]))),O=Object.fromEntries(Object.keys(y).filter((e=>!0===y[e].allowBilling)).map((e=>[e,y[e].states||[]]))),k=Object.fromEntries(Object.keys(y).filter((e=>!0===y[e].allowShipping)).map((e=>[e,g[e]||""]))),h=Object.fromEntries(Object.keys(y).filter((e=>!0===y[e].allowShipping)).map((e=>[e,y[e].states||[]]))),_=Object.fromEntries(Object.keys(y).map((e=>[e,y[e].locale||[]])))},2:function(e,t){e.exports=window.wp.components},3:function(e,t){e.exports=window.wc.wcSettings},336:function(e){e.exports=JSON.parse('{"$schema":"https://schemas.wp.org/trunk/block.json","apiVersion":2,"name":"woocommerce/product-template","title":"Product Template","category":"woocommerce","description":"Contains the block elements used to render a product.","keywords":["WooCommerce"],"textdomain":"woo-gutenberg-products-block","usesContext":["queryId","query","queryContext","displayLayout","templateSlug"],"supports":{"inserter":false,"reusable":false,"html":false,"align":["wide","full"],"anchor":true,"__experimentalLayout":{"allowEditing":false},"color":{"gradients":true,"link":true,"__experimentalDefaultControls":{"background":true,"text":true}},"typography":{"fontSize":true,"lineHeight":true,"__experimentalFontFamily":true,"__experimentalFontWeight":true,"__experimentalFontStyle":true,"__experimentalTextTransform":true,"__experimentalTextDecoration":true,"__experimentalLetterSpacing":true,"__experimentalDefaultControls":{"fontSize":true}}}}')},5:function(e,t){e.exports=window.wp.blockEditor},546:function(e,t,n){e.exports=n(576)},547:function(e,t){},576:function(e,t,n){"use strict";n.r(t);var o=n(85),r=n(336),c=n(0),l=n(4),i=n.n(l),u=n(6),s=n(1),a=n(5),p=n(2),d=n(78),f=n(3),b=n(82);const m=()=>{const e=Object(a.useInnerBlocksProps)({className:"wc-block-product"},{__unstableDisableLayoutClassNames:!0});return Object(c.createElement)("li",{...e})},g=Object(c.memo)((({blocks:e,blockContextId:t,isHidden:n,setActiveBlockContextId:o})=>{const r=Object(a.__experimentalUseBlockPreview)({blocks:e,props:{className:"wc-block-product"}}),l=()=>{o(t)},i={display:n?"none":void 0};return Object(c.createElement)("li",{...r,tabIndex:0,role:"button",onClick:l,onKeyPress:l,style:i})}));n(547);const y={...r,icon:()=>Object(c.createElement)("svg",{width:"24",height:"24",viewBox:"0 0 24 24",fill:"none",xmlns:"http://www.w3.org/2000/svg"},Object(c.createElement)("path",{fillRule:"evenodd",clipRule:"evenodd",d:"M6 4H18C19.1046 4 20 4.89543 20 6V18C20 19.1046 19.1046 20 18 20H6C4.89543 20 4 19.1046 4 18V6C4 4.89543 4.89543 4 6 4ZM18 5.5H6C5.72386 5.5 5.5 5.72386 5.5 6V9H18.5V6C18.5 5.72386 18.2761 5.5 18 5.5ZM18.5 10.5H10L10 18.5H18C18.2761 18.5 18.5 18.2761 18.5 18V10.5ZM8.5 10.5H5.5V18C5.5 18.2761 5.72386 18.5 6 18.5H8.5L8.5 10.5Z",fill:"#1E1E1E"})),edit:({clientId:e,context:{query:{perPage:t,offset:n=0,order:o,orderBy:r,author:l,search:y,exclude:w,sticky:O,inherit:k,taxQuery:h,parents:_,pages:j,...x},queryContext:v=[{page:1}],templateSlug:E,displayLayout:{type:S,columns:C}={type:"flex",columns:3}},__unstableLayoutClassNames:P})=>{const[{page:T}]=v,[B,I]=Object(c.useState)(),A="product",R=Object(f.getSettingWithCoercion)("loop_shop_per_page",12,b.a),{products:G,blocks:H}=Object(u.useSelect)((c=>{const{getEntityRecords:i,getTaxonomies:u}=c(d.store),{getBlocks:s}=c(a.store),p=u({type:A,per_page:-1,context:"view"}),f=k&&(null==E?void 0:E.startsWith("category-"))&&i("taxonomy","category",{context:"view",per_page:1,_fields:["id"],slug:E.replace("category-","")}),b={postType:A,offset:t?t*(T-1)+n:0,order:o,orderby:r};if(h&&!k){const e=Object.entries(h).reduce(((e,[t,n])=>{const o=null==p?void 0:p.find((({slug:e})=>e===t));return null!=o&&o.rest_base&&(e[null==o?void 0:o.rest_base]=n),e}),{});Object.keys(e).length&&Object.assign(b,e)}var m;(t&&(b.per_page=t),l&&(b.author=l),y&&(b.search=y),null!=w&&w.length&&(b.exclude=w),null!=_&&_.length&&(b.parent=_),O&&(b.sticky="only"===O),k)&&(f&&(b.categories=null===(m=f[0])||void 0===m?void 0:m.id),b.per_page=R);return{products:i("postType",A,{...b,...x}),blocks:s(e)}}),[t,T,n,o,r,e,l,y,A,w,O,k,E,h,_,x]),L=Object(c.useMemo)((()=>null==G?void 0:G.map((e=>({postType:e.type,postId:e.id})))),[G]),M="flex"===S&&C>1,N=Object(a.useBlockProps)({className:i()(P,"wc-block-product-template",{"is-flex-container":M,[`columns-${C}`]:M})});return G?G.length?Object(c.createElement)("ul",{...N},L&&L.map((e=>{var t,n;return Object(c.createElement)(a.BlockContextProvider,{key:e.postId,value:e},e.postId===(B||(null===(t=L[0])||void 0===t?void 0:t.postId))?Object(c.createElement)(m,null):null,Object(c.createElement)(g,{blocks:H,blockContextId:e.postId,setActiveBlockContextId:I,isHidden:e.postId===(B||(null===(n=L[0])||void 0===n?void 0:n.postId))}))}))):Object(c.createElement)("p",{...N}," ",Object(s.__)("No results found.","woo-gutenberg-products-block")):Object(c.createElement)("p",{...N},Object(c.createElement)(p.Spinner,null))},save:function(){return Object(c.createElement)(a.InnerBlocks.Content,null)}};Object(o.c)(r.name,y)},6:function(e,t){e.exports=window.wp.data},7:function(e,t){e.exports=window.wp.blocks},78:function(e,t){e.exports=window.wp.coreData},82:function(e,t,n){"use strict";n.d(t,"a",(function(){return o}));const o=e=>"number"==typeof e},85:function(e,t,n){"use strict";n.d(t,"c",(function(){return c})),n.d(t,"a",(function(){return l})),n.d(t,"b",(function(){return i}));var o=n(7),r=n(17);const c=(e,t)=>{if(r.o>2)return Object(o.registerBlockType)(e,t)},l=()=>r.o>2,i=()=>r.o>1}});