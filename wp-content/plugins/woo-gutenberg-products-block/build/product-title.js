(window.webpackWcBlocksJsonp=window.webpackWcBlocksJsonp||[]).push([[47],{118:function(e,t,n){"use strict";var c=n(0),a=n(10),r=n(4),o=n.n(r);n(181),t.a=({className:e="",disabled:t=!1,name:n,permalink:r="",target:l,rel:s,style:i,onClick:u,...d})=>{const b=o()("wc-block-components-product-name",e);if(t){const e=d;return Object(c.createElement)("span",{className:b,...e,dangerouslySetInnerHTML:{__html:Object(a.decodeEntities)(n)}})}return Object(c.createElement)("a",{className:b,href:r,target:l,...d,dangerouslySetInnerHTML:{__html:Object(a.decodeEntities)(n)},style:i})}},181:function(e,t){},215:function(e,t,n){"use strict";n.d(t,"a",(function(){return p}));var c=n(0),a=n(4),r=n.n(a),o=n(24),l=n(85),s=n(48),i=n(118),u=n(96),d=n(84);n(274);const b=({children:e,headingLevel:t,elementType:n=`h${t}`,...a})=>Object(c.createElement)(n,{...a},e),p=e=>{const{className:t,headingLevel:n=2,showProductLink:a=!0,linkTarget:s,align:p}=e,m=Object(d.a)(e),{parentClassName:k}=Object(o.useInnerBlockLayoutContext)(),{product:j}=Object(o.useProductDataContext)(),{dispatchStoreEvent:O}=Object(u.a)();return j.id?Object(c.createElement)(b,{headingLevel:n,className:r()(t,m.className,"wc-block-components-product-title",{[`${k}__product-title`]:k,[`wc-block-components-product-title--align-${p}`]:p&&Object(l.b)()}),style:Object(l.b)()?m.style:{}},Object(c.createElement)(i.a,{disabled:!a,name:j.name,permalink:j.permalink,target:s,onClick:()=>{O("product-view-link",{product:j})}})):Object(c.createElement)(b,{headingLevel:n,className:r()(t,m.className,"wc-block-components-product-title",{[`${k}__product-title`]:k,[`wc-block-components-product-title--align-${p}`]:p&&Object(l.b)()}),style:Object(l.b)()?m.style:{}})};t.b=Object(s.withProductDataContext)(p)},274:function(e,t){},342:function(e,t,n){"use strict";var c=n(85);let a={headingLevel:{type:"number",default:2},showProductLink:{type:"boolean",default:!0},linkTarget:{type:"string"},productId:{type:"number",default:0}};Object(c.b)()&&(a={...a,align:{type:"string"}}),t.a=a},650:function(e,t,n){"use strict";n.r(t);var c=n(48),a=n(215),r=n(342);t.default=Object(c.withFilteredAttributes)(r.a)(a.b)},85:function(e,t,n){"use strict";n.d(t,"c",(function(){return r})),n.d(t,"a",(function(){return o})),n.d(t,"b",(function(){return l}));var c=n(7),a=n(17);const r=(e,t)=>{if(a.o>2)return Object(c.registerBlockType)(e,t)},o=()=>a.o>2,l=()=>a.o>1}}]);