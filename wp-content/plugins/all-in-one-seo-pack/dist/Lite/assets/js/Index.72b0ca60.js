import{i as J,k as V,u as P}from"./links.b05f56db.js";import{C as B,S as H,c as z,d as O}from"./Caret.164d8058.js";import{C as N,S as q}from"./index.0eabb636.js";import{r as u,o,c as m,a as i,F as T,h as L,b as g,w as h,g as U,t as p,f as d,i as W,d as c,n as $,e as Q,S as G}from"./vue.runtime.esm-bundler.b39e1078.js";import{_ as w}from"./_plugin-vue_export-helper.b97bdf23.js";/* empty css                                            *//* empty css                                              */import"./default-i18n.3881921e.js";import"./constants.1758f66e.js";import{J as K}from"./JsonValues.870a4901.js";/* empty css                                              */import{s as k}from"./strings.616cfce5.js";import{C as Z}from"./ProBadge.34da75c2.js";import{S as X}from"./External.8186427a.js";import{S as Y}from"./Exclamation.2f8bed1f.js";import{B as ee}from"./Checkbox.17c05fc5.js";import{G as te,a as se}from"./Row.5242dafa.js";import{S as re}from"./Gear.a85d4a2b.js";import{T as F}from"./Slide.cdf6c622.js";import{C as le}from"./Tooltip.6979830f.js";import{S as ie}from"./Plus.3a43a085.js";const oe={emits:["set-url"],components:{CoreProBadge:Z,SvgExternal:X},props:{results:{type:Array,required:!0},url:String},data(){return{strings:{DRAFT:this.$t.__("DRAFT",this.$td),PENDING:this.$t.__("PENDING",this.$td),FUTURE:this.$t.__("FUTURE",this.$td)}}},methods:{getOptionTitle(e){const t=new RegExp(`(${this.url})`,"gi");return e.replace(t,'<span class="search-term">$1</span>')},getStatusLabel(e){switch(e.toLowerCase()){case"draft":return this.strings.DRAFT;case"future":return this.strings.FUTURE;case"pending":return this.strings.PENDING}}}},ne={class:"aioseo-add-redirection-url-results"},ue=["onClick"],ae={class:"option"},ce={class:"option-title"},de=["innerHTML"],he={class:"option-details"},ge=["href","onClick"];function _e(e,t,r,v,s,l){const a=u("core-pro-badge"),y=u("svg-external");return o(),m("div",ne,[i("ul",null,[(o(!0),m(T,null,L(r.results,(f,E)=>(o(),m("li",{key:E,onClick:C=>e.$emit("set-url",f.link)},[i("span",null,[i("div",ae,[i("div",ce,[i("div",{innerHTML:l.getOptionTitle(f.label)},null,8,de),f.status!=="publish"?(o(),g(a,{key:0},{default:h(()=>[U(p(l.getStatusLabel(f.status)),1)]),_:2},1024)):d("",!0)]),i("div",he,[i("span",null,p(f.link),1)])]),i("a",{class:"option-permalink",href:f.link,target:"_blank",onClick:W(()=>{},["stop"])},[c(y)],8,ge)])],8,ue))),128))])])}const j=w(oe,[["render",_e]]);const me={setup(){return{postEditorStore:J(),redirectsStore:V(),rootStore:P()}},components:{CoreAddRedirectionUrlResults:j,CoreLoader:B,SvgCircleCheck:H,SvgCircleClose:z,SvgCircleExclamation:Y},props:{url:String,errors:Array,warnings:Array},data(){return{showResults:!1,isLoading:!1,value:null,results:[]}},watch:{value(){this.value&&(this.value=this.value.replace(/(https?:\/)(\/)+|(\/)+/g,"$1$2$3"),this.value=this.value.replace(/\s+/g,""))},url:{immediate:!0,handler(){this.value=this.url}}},methods:{onBlur(){setTimeout(()=>{this.$emit("update:modelValue",this.value)},150)},searchChange(){if(this.value){if(this.value.startsWith("/")||this.value.startsWith("http:")||this.value.startsWith("https:")){this.isLoading=!1;return}this.isLoading=!0,O(()=>{if(!this.value){this.isLoading=!1;return}this.showResults=!0,this.ajaxSearch(this.value).then(()=>this.isLoading=!1)},500)}},ajaxSearch(e){return this.redirectsStore.getPosts({query:e,postId:this.postEditorStore.currentPost.id}).then(t=>{this.results=t.body.objects})},setUrl(e){this.showResults=!1,this.value=e.replace(this.rootStore.aioseo.urls.mainSiteUrl,"",e),this.$emit("update:modelValue",this.value)},documentClick(e){if(!this.showResults)return;const t=e&&e.target?e.target:null,r=this.$refs["redirect-target-url"];r&&r!==t&&!r.contains(t)&&(this.showResults=!1)}},mounted(){document.addEventListener("click",this.documentClick)},beforeUnmount(){document.removeEventListener("click",this.documentClick)}},pe={class:"aioseo-add-redirection-target-url",ref:"redirect-target-url"},fe={class:"append-icon"};function Re(e,t,r,v,s,l){const a=u("svg-circle-close"),y=u("svg-circle-check"),f=u("svg-circle-exclamation"),E=u("core-loader"),C=u("base-input"),b=u("core-add-redirection-url-results");return o(),m("div",pe,[c(C,{modelValue:s.value,"onUpdate:modelValue":[t[0]||(t[0]=S=>s.value=S),t[2]||(t[2]=S=>e.$emit("update:modelValue",s.value))],onKeyup:l.searchChange,onFocus:t[1]||(t[1]=S=>s.showResults=!0),onBlur:t[3]||(t[3]=S=>e.$emit("blur",s.value)),size:"medium",placeholder:"/target-page/",class:$({"aioseo-error":r.errors.length,"aioseo-active":!r.errors.length&&!r.warnings.length&&r.url,"aioseo-warning":r.warnings.length})},{"append-icon":h(()=>[i("div",fe,[s.isLoading?d("",!0):(o(),m(T,{key:0},[r.errors.length?(o(),g(a,{key:0})):d("",!0),!r.errors.length&&!r.warnings.length&&r.url?(o(),g(y,{key:1})):d("",!0),r.warnings.length?(o(),g(f,{key:2})):d("",!0)],64)),s.isLoading?(o(),g(E,{key:1,dark:""})):d("",!0)])]),_:1},8,["modelValue","onKeyup","class"]),s.showResults&&s.results.length?(o(),g(b,{key:0,results:s.results,url:s.value,onSetUrl:l.setUrl},null,8,["results","url","onSetUrl"])):d("",!0)],512)}const ve=w(me,[["render",Re]]),Ue=function(e,t){if(typeof e!="string")return e;const r=new RegExp("^"+t.replace(/\/$/,""),"i");return e.replace(r,"")};const ye={setup(){return{redirectsStore:V(),rootStore:P()}},emits:["updated-url","remove-url","updated-option"],components:{BaseCheckbox:ee,CoreAddRedirectionUrlResults:j,CoreAlert:N,CoreLoader:B,GridColumn:te,GridRow:se,SvgCircleCheck:H,SvgCircleClose:z,SvgCircleExclamation:Y,SvgGear:re,SvgTrash:q,TransitionSlide:F},props:{url:{type:Object,default(){return{id:null,url:null,regex:!1,ignoreSlash:!0,ignoreCase:!0,errors:[],warnings:[]}}},allowDelete:Boolean,targetUrl:String,log404:Boolean,disableSource:Boolean},data(){return{showResults:!1,isLoading:!1,showOptions:!1,strings:{ignoreSlash:this.$t.__("Ignore Slash",this.$td),ignoreCase:this.$t.__("Ignore Case",this.$td),regex:this.$t.__("Regex",this.$td)},results:[]}},watch:{targetUrl(){this.updateSourceUrl(this.url.url)}},computed:{maybeRegex(){return this.url.url.match(/[*\\()[\]^$]/)!==null||this.url.url.indexOf(".?")!==-1},invalidUrl(){if(!this.url.url)return!1;const e=[];if(this.url.regex)try{new RegExp(this.url.url)}catch{return e.push(this.$t.__("The regex syntax is invalid.",this.$td)),e}if(!this.url.regex&&!k(this.url.url))return e.push(this.$t.__("Your URL is invalid.",this.$td)),e;if(this.url.url.substr(0,4)==="http"&&e.push(this.$t.__("Please enter a valid relative source URL.",this.$td)),this.url.url.match(/%[a-zA-Z]+%/)&&e.push(this.$t.__("Permalinks are not currently supported.",this.$td)),(this.url.url==="/(.*)"||this.url.url==="^/(.*)")&&e.push(this.$t.__("This redirect is supported using the Relocate Site feature under Full Site Redirect tab.",this.$td)),this.url.url&&this.url.url.length&&this.targetUrl&&this.targetUrl.length){let t=this.url.ignoreSlash?this.$links.unTrailingSlashIt(this.url.url):this.url.url,r=this.url.ignoreSlash?this.$links.unTrailingSlashIt(this.targetUrl):this.targetUrl;t=this.url.ignoreCase?t.toLowerCase():t,r=this.url.ignoreCase?r.toLowerCase():r,(t===r||this.url.regex&&r.match(t))&&e.push(this.$t.__("Your source is the same as a target and this will create a loop.",this.$td))}return e},iffyUrl(){if(!this.url.url||this.disableSource)return[];const e=[];return this.url.url.substr(0,4)!=="http"&&this.url.url.substr(0,1)!=="/"&&0<this.url.url.length&&!this.url.regex&&e.push(this.$t.sprintf(this.$t.__("The source URL should probably start with a %1$s",this.$td),"<code>/</code>")),this.url.url.indexOf("#")!==-1&&e.push(this.$t.__("Anchor values are not sent to the server and cannot be redirected.",this.$td)),!this.log404&&this.maybeRegex&&!this.url.regex&&e.push(this.$t.sprintf(this.$t.__("Remember to enable the %1$s option if this is a regular expression.",this.$td),"<code>Regex</code>")),this.url.regex&&(this.url.url.indexOf("^")===-1&&this.url.url.indexOf("$")===-1&&e.push(this.$t.sprintf(this.$t.__("To prevent a greedy regular expression you can use %1$s to anchor it to the start of the URL. For example: %2$s",this.$td),"<code>^/</code>","<code>^/"+k(this.url.url.replace(/^\//,""))+"</code>")),0<this.url.url.indexOf("^")&&e.push(this.$t.sprintf(this.$t.__("The caret %1$s should be at the start. For example: %2$s",this.$td),"<code>^/</code>","<code>^/"+k(this.url.url.replace("^","").replace(/^\//,""))+"</code>")),this.url.url.indexOf("^")===0&&this.url.url.indexOf("^/")===-1&&e.push(this.$t.sprintf(this.$t.__("The source URL should probably start with a %1$s",this.$td),"<code>^/</code>")),this.url.url.length-1!==this.url.url.indexOf("$")&&this.url.url.indexOf("$")!==-1&&e.push(this.$t.sprintf(this.$t.__("The dollar symbol %1$s should be at the end. For example: %2$s",this.$td),"<code>$</code>","<code>"+k(this.url.url.replace(/\$/g,""))+"$</code>"))),this.url.url.match(/(\.html|\.htm|\.php|\.pdf|\.jpg)$/)!==null&&e.push(this.$t.__("Some servers may be configured to serve file resources directly, preventing a redirect occurring.",this.$td)),e},urlOptionsActive(){return this.url.regex||this.showOptions}},methods:{updateSourceUrl(e){e&&(this.disableSource||(e&&(e=e.replace(/(https?:\/)(\/)+|(\/)+/g,"$1$2$3")),this.url.regex||(e=e.replace(/\s+/g,"")),e=Ue(e,this.rootStore.aioseo.urls.home)),this.url.url=e,this.url.errors=this.invalidUrl,this.url.warnings=this.iffyUrl,this.$emit("updated-url",this.url))},updateOption(e,t){this.url[e]=t,this.updateSourceUrl(this.url.url),this.$emit("updated-option",this.url)},searchChange(){if(!(!this.url.url||this.url.regex)){if(this.url.url.startsWith("/")||this.url.url.startsWith("^")||this.url.url.startsWith("http:")||this.url.url.startsWith("https:")){this.isLoading=!1;return}this.isLoading=!0,O(()=>{if(!this.url.url){this.isLoading=!1;return}this.showResults=!0,this.ajaxSearch(this.url.url).then(()=>this.isLoading=!1)},500)}},ajaxSearch(e){return this.redirectsStore.getPosts({query:e}).then(t=>{this.results=t.body.objects})},setUrl(e){this.showResults=!1,this.updateOption("url",e.replace(this.rootStore.aioseo.urls.mainSiteUrl,"",e))},documentClick(e){if(!this.showResults)return;const t=e&&e.target?e.target:null,r=this.$refs["redirect-source-url"];r&&r!==t&&!r.contains(t)&&(this.showResults=!1)}},mounted(){this.url.showOptions&&(this.showOptions=!0,this.updateSourceUrl(this.url.url)),document.addEventListener("click",this.documentClick)},beforeUnmount(){document.removeEventListener("click",this.documentClick)}},Se={class:"aioseo-redirect-source-url",ref:"redirect-source-url"},be={class:"append-icon"};function Te(e,t,r,v,s,l){const a=u("svg-circle-close"),y=u("svg-circle-check"),f=u("svg-circle-exclamation"),E=u("svg-gear"),C=u("svg-trash"),b=u("core-loader"),S=u("base-input"),D=u("core-add-redirection-url-results"),n=u("base-checkbox"),_=u("grid-column"),I=u("grid-row"),A=u("transition-slide"),M=u("core-alert");return o(),m("div",Se,[c(S,{modelValue:r.url.url,"onUpdate:modelValue":t[2]||(t[2]=R=>l.updateSourceUrl(R)),onKeyup:l.searchChange,onFocus:t[3]||(t[3]=R=>s.showResults=!0),disabled:r.log404||r.disableSource,size:"medium",placeholder:"/source-page/",class:$({"aioseo-error":r.url.errors.length,"aioseo-active":!r.url.errors.length&&!r.url.warnings.length&&r.url.url,"aioseo-warning":r.url.warnings.length})},{"append-icon":h(()=>[i("div",be,[s.isLoading?d("",!0):(o(),m(T,{key:0},[r.url.errors.length?(o(),g(a,{key:0})):d("",!0),!r.url.errors.length&&!r.url.warnings.length&&r.url.url?(o(),g(y,{key:1})):d("",!0),r.url.warnings.length?(o(),g(f,{key:2})):d("",!0),c(E,{class:$({active:l.urlOptionsActive}),onClick:t[0]||(t[0]=R=>s.showOptions=!s.showOptions)},null,8,["class"]),r.allowDelete?(o(),g(C,{key:3,onClick:t[1]||(t[1]=R=>e.$emit("remove-url"))})):d("",!0)],64)),s.isLoading?(o(),g(b,{key:1,dark:""})):d("",!0)])]),_:1},8,["modelValue","onKeyup","disabled","class"]),!r.url.regex&&s.showResults&&s.results.length?(o(),g(D,{key:0,results:s.results,url:r.url.url,onSetUrl:l.setUrl},null,8,["results","url","onSetUrl"])):d("",!0),r.log404?d("",!0):Q(e.$slots,"source-url-description",{key:1}),c(A,{active:s.showOptions,class:"source-url-options"},{default:h(()=>[i("div",null,[c(I,null,{default:h(()=>[c(_,{xs:"4"},{default:h(()=>[c(n,{size:"medium",modelValue:r.url.ignoreSlash,"onUpdate:modelValue":t[4]||(t[4]=R=>l.updateOption("ignoreSlash",R))},{default:h(()=>[U(p(s.strings.ignoreSlash),1)]),_:1},8,["modelValue"])]),_:1}),c(_,{xs:"4"},{default:h(()=>[c(n,{size:"medium",modelValue:r.url.ignoreCase,"onUpdate:modelValue":t[5]||(t[5]=R=>l.updateOption("ignoreCase",R))},{default:h(()=>[U(p(s.strings.ignoreCase),1)]),_:1},8,["modelValue"])]),_:1}),!r.log404&&!r.disableSource?(o(),g(_,{key:0,xs:"4"},{default:h(()=>[c(n,{size:"medium",modelValue:r.url.regex,"onUpdate:modelValue":t[6]||(t[6]=R=>l.updateOption("regex",R))},{default:h(()=>[U(p(s.strings.regex),1)]),_:1},8,["modelValue"])]),_:1})):d("",!0)]),_:1})])]),_:1},8,["active"]),c(A,{active:!!r.url.errors.length},{default:h(()=>[(o(!0),m(T,null,L(r.url.errors,(R,x)=>(o(),g(M,{key:x,class:"source-url-error",type:"red",size:"small",innerHTML:R},null,8,["innerHTML"]))),128))]),_:1},8,["active"]),c(A,{active:!!r.url.warnings.length},{default:h(()=>[(o(!0),m(T,null,L(r.url.warnings,(R,x)=>(o(),g(M,{key:x,class:"source-url-warning",type:"yellow",size:"small",innerHTML:R},null,8,["innerHTML"]))),128))]),_:1},8,["active"])],512)}const Ee=w(ye,[["render",Te]]);const Ce={type:null,key:null,value:null,regex:null},Le={setup(){return{rootStore:P()}},components:{CoreTooltip:le,SvgCirclePlus:ie,SvgTrash:q},props:{editCustomRules:Array},data(){return{strings:{customRules:this.$t.__("Custom Rules",this.$td),selectMatchRule:this.$t.__("Select Rule",this.$td),delete:this.$t.__("Delete",this.$td),add:this.$t.__("Add Custom Rule",this.$td),regex:this.$t.__("Regex",this.$td),selectAValue:this.$t.__("Select a Value or Add a New One",this.$td),key:this.$t.__("Key",this.$td),value:this.$t.__("Value",this.$td)},customRules:[],types:[{label:this.$constants.REDIRECTS_CUSTOM_RULES_LABELS.login,value:"login",placeholder:this.$t.__("Select Status",this.$td),singleRule:!0,options:[{label:this.$constants.REDIRECTS_CUSTOM_RULES_LABELS.loggedin,value:"loggedin"},{label:this.$constants.REDIRECTS_CUSTOM_RULES_LABELS.loggedout,value:"loggedout"}]},{label:this.$constants.REDIRECTS_CUSTOM_RULES_LABELS.role,value:"role",multiple:!0,placeholder:this.$t.__("Select Roles",this.$td),options:Object.entries(this.rootStore.aioseo.user.roles).map(e=>({label:e[1],value:e[0]}))},{label:this.$constants.REDIRECTS_CUSTOM_RULES_LABELS.referrer,value:"referrer",regex:!0,singleRule:!0},{label:this.$constants.REDIRECTS_CUSTOM_RULES_LABELS.agent,value:"agent",regex:!0,taggable:!0,multiple:!0,options:[{label:this.$constants.REDIRECTS_CUSTOM_RULES_LABELS.mobile,value:"mobile",docLink:this.$links.getDocLink(this.$t.__("Learn more",this.$td),"redirectCustomRulesUserAgent",!0)},{label:this.$constants.REDIRECTS_CUSTOM_RULES_LABELS.feeds,value:"feeds",docLink:this.$links.getDocLink(this.$t.__("Learn more",this.$td),"redirectCustomRulesUserAgent",!0)},{label:this.$constants.REDIRECTS_CUSTOM_RULES_LABELS.libraries,value:"libraries",docLink:this.$links.getDocLink(this.$t.__("Learn more",this.$td),"redirectCustomRulesUserAgent",!0)}]},{label:this.$constants.REDIRECTS_CUSTOM_RULES_LABELS.cookie,value:"cookie",keyValuePair:!0,regex:!0},{label:this.$constants.REDIRECTS_CUSTOM_RULES_LABELS.ip,value:"ip",placeholder:this.$t.__("Enter an IP Address",this.$td),taggable:!0,regex:!0,singleRule:!0},{label:this.$constants.REDIRECTS_CUSTOM_RULES_LABELS.server,value:"server",placeholder:this.$t.__("Enter the Server Name",this.$td),regex:!0,singleRule:!0},{label:this.$constants.REDIRECTS_CUSTOM_RULES_LABELS.header,value:"header",keyValuePair:!0,regex:!0},{label:this.$constants.REDIRECTS_CUSTOM_RULES_LABELS.wp_filter,value:"wp_filter",placeholder:this.$t.__("Enter a WordPress Filter Name",this.$td),taggable:!0},{label:this.$constants.REDIRECTS_CUSTOM_RULES_LABELS.locale,value:"locale",taggable:!0,regex:!0,placeholder:this.$t.__("Enter a Locale Code, e.g.: en_GB, es_ES",this.$td),singleRule:!0}]}},computed:{hasCustomRules(){return 0<this.customRules.length},filteredTypes(){return this.types.map(e=>(e.$isDisabled=!1,e.singleRule&&this.customRules.find(t=>e.value===t.type)&&(e.$isDisabled=!0),e))}},methods:{removeRule(e){this.customRules.splice(e,1),this.hasCustomRules||this.addRule(null)},addRule(e,t=!1){e||(e=JSON.parse(JSON.stringify(Ce))),(!t||t&&this.customRules.filter(r=>r===e).length===0)&&this.customRules.push(e)},updateRule(e,t,r){const v=this.customRules[r];t=typeof t.value<"u"?t.value:t,t=typeof t=="object"&&t.length?t.map(s=>s.value):t,v[e]=t,e==="type"&&(v.value=""),this.customRules[r]=v},getRuleValue(e,t,r=!1){if(!this.customRules[t])return;let s=this.customRules[t][e],l=null;if(r)return s;switch(e){case"type":s=this.types.find(a=>s===a.value);break;case"value":l=this.getType(t,"options"),l&&(typeof s=="object"?s=s.map(a=>l.find(y=>a===y.value)||a).filter(a=>!!a):s=l.find(a=>s===a.value)||s),this.getType(t,"taggable")&&(s=typeof s=="object"?s.map(a=>typeof a.label>"u"?{label:a,value:a}:a):[]);break}return s},getType(e,t){const r=this.getRuleValue("type",e);return t?r&&typeof r[t]<"u"?r[t]:!1:r}},mounted(){this.editCustomRules&&(this.customRules=this.editCustomRules),this.hasCustomRules||this.addRule(null)}},$e={class:"custom-rules"},ke={class:"redirects-options-table",cellspacing:"0",cellpadding:"0","aria-label":"Custom Rules"},we={colspan:"2"},De={class:"rule-settings"},Ae={class:"actions"},xe={colspan:"2"};function Ve(e,t,r,v,s,l){const a=u("base-select"),y=u("base-input"),f=u("base-toggle"),E=u("svg-trash"),C=u("core-tooltip"),b=u("svg-circle-plus"),S=u("base-button");return o(),m("div",$e,[i("table",ke,[i("thead",null,[i("tr",null,[i("td",we,p(s.strings.customRules),1)])]),i("tbody",null,[(o(!0),m(T,null,L(s.customRules,(D,n)=>(o(),m("tr",{class:$(["rule",{even:n%2===0}]),key:n},[i("td",De,[c(a,{options:l.filteredTypes,size:"medium",placeholder:s.strings.selectMatchRule,modelValue:l.getRuleValue("type",n),"onUpdate:modelValue":_=>l.updateRule("type",_,n)},null,8,["options","placeholder","modelValue","onUpdate:modelValue"]),l.getType(n,"options")||l.getType(n,"taggable")?(o(),g(a,{key:0,options:l.getType(n,"options")||[],size:"medium",modelValue:l.getRuleValue("value",n),"onUpdate:modelValue":_=>l.updateRule("value",_,n),multiple:l.getType(n,"multiple")||l.getType(n,"taggable"),taggable:l.getType(n,"taggable"),placeholder:l.getType(n,"placeholder")||s.strings.selectAValue},null,8,["options","modelValue","onUpdate:modelValue","multiple","taggable","placeholder"])):d("",!0),l.getType(n,"keyValuePair")?(o(),g(y,{key:1,modelValue:l.getRuleValue("key",n),"onUpdate:modelValue":_=>l.updateRule("key",_,n),size:"medium",placeholder:l.getType(n,"placeholderKey")||s.strings.key},null,8,["modelValue","onUpdate:modelValue","placeholder"])):d("",!0),!l.getType(n,"options")&&!l.getType(n,"taggable")?(o(),g(y,{key:2,modelValue:l.getRuleValue("value",n),"onUpdate:modelValue":_=>l.updateRule("value",_,n),size:"medium",placeholder:l.getType(n,"placeholder")||s.strings.value,disabled:!l.getType(n)},null,8,["modelValue","onUpdate:modelValue","placeholder","disabled"])):d("",!0),l.getType(n,"regex")?(o(),g(f,{key:3,modelValue:l.getRuleValue("regex",n),"onUpdate:modelValue":_=>l.updateRule("regex",_,n)},{default:h(()=>[U(p(s.strings.regex),1)]),_:2},1032,["modelValue","onUpdate:modelValue"])):d("",!0)]),i("td",Ae,[c(C,{class:"action",type:"action"},{tooltip:h(()=>[U(p(s.strings.delete),1)]),default:h(()=>[c(E,{onClick:_=>l.removeRule(n)},null,8,["onClick"])]),_:2},1024)])],2))),128))]),i("tfoot",null,[i("tr",null,[i("td",xe,[c(S,{size:"small-table",type:"black",onClick:t[0]||(t[0]=D=>l.addRule(null))},{default:h(()=>[c(b),U(" "+p(s.strings.add),1)]),_:1})])])])])])}const Pe=w(Le,[["render",Ve],["__scopeId","data-v-f2939b25"]]),Oe={},Ie={width:"36",height:"16",viewBox:"0 0 36 16",fill:"none",xmlns:"http://www.w3.org/2000/svg",class:"aioseo-right-arrow"},Me=i("path",{d:"M36 8L28.4211 0.5V6.125H0V9.875H28.4211V15.5L36 8Z",fill:"currentColor"},null,-1),Be=[Me];function He(e,t){return o(),m("svg",Ie,Be)}const ze=w(Oe,[["render",He]]),Ne={methods:{redirectHasUnPublishedPost(e){return e.post_id&&e.postStatus!=="publish"}}};const qe={setup(){return{redirectsStore:V()}},emits:["cancel","added-redirect"],components:{CoreAddRedirectionTargetUrl:ve,CoreAddRedirectionUrl:Ee,CoreAlert:N,CustomRules:Pe,SvgRightArrow:ze,TransitionSlide:F},mixins:[K,Ne],props:{edit:Boolean,log404:Boolean,disableSource:Boolean,url:Object,urls:Array,target:String,type:Number,query:String,slash:Boolean,case:Boolean,rules:{type:Array,default(){return[]}},postId:Number,postStatus:String},data(){return{genericError:!1,showAdvancedSettings:!1,addingRedirect:!1,targetUrl:null,targetUrlErrors:[],targetUrlWarnings:[],sourceUrls:[],redirectType:null,queryParam:null,customRules:[],strings:{redirectType:this.$t.__("Redirect Type:",this.$td),targetUrl:this.$t.__("Target URL",this.$td),targetUrlDescription:this.$t.__("Enter a URL or start by typing a page or post title, slug or ID.",this.$td),addUrl:this.$t.__("Add URL",this.$td),sourceUrlDescription:this.$t.sprintf(this.$t.__("Enter a relative URL to redirect from or start by typing in page or post title, slug or ID. You can also use regex (%1$s)",this.$td),this.$links.getDocLink(this.$t.__("what's this?",this.$td),"redirectManagerRegex")),advancedSettings:this.$t.__("Advanced Settings",this.$td),queryParams:this.$t.__("Query Parameters:",this.$td),saveChanges:this.$t.__("Save Changes",this.$td),cancel:this.$t.__("Cancel",this.$td),genericErrorMessage:this.$t.__("An error occurred while adding your redirects. Please try again later.",this.$td),sourceUrlSetOncePublished:this.$t.__("source url set once post is published",this.$td)},sourceDisabled:!1}},watch:{sourceUrls:{deep:!0,handler(){O(()=>this.checkForDuplicates(),500)}}},computed:{saveIsDisabled(){return!!this.sourceUrls.filter(e=>!e.url).length||!!this.sourceUrls.filter(e=>0<e.errors.length).length||this.redirectTypeHasTarget()&&!this.targetUrl},getRelativeAbsolute(){const e=this.targetUrl.match(/^\/([a-zA-Z0-9_\-%]*\..*)\//);return e?e[0]:null},sourceUrl(){return 1<this.sourceUrls.length?this.$t.__("Source URLs",this.$td):this.$t.__("Source URL",this.$td)},addRedirect(){return 1<this.sourceUrls.length?this.$t.__("Add Redirects",this.$td):this.$t.__("Add Redirect",this.$td)},hasTargetUrlErrors(){if(!this.targetUrl)return[];const e=[],t=k(this.targetUrl);if(!t)return e.push(this.$t.__("Your target URL is not valid.",this.$td)),e;this.targetUrl&&!this.beginsWith(this.targetUrl,"https://")&&!this.beginsWith(this.targetUrl,"http://")&&this.targetUrl.substr(0,1)!=="/"&&e.push(this.$t.sprintf(this.$t.__("Your target URL should be an absolute URL like %1$s or start with a slash %2$s.",this.$td),"<code>https://domain.com/"+t+"</code>","<code>/"+t+"</code>"));const r=this.targetUrl.match(/[|\\$]/g);return r!==null&&(this.sourceUrls.map(s=>s.regex).every(s=>s)||e.push(this.$t.sprintf(this.$t.__("Your target URL contains the invalid character(s) %1$s",this.$td),"<code>"+r+"</code>"))),e},hasTargetUrlWarnings(){if(!k(this.targetUrl))return[];const e=[];return this.getRelativeAbsolute&&e.push(this.$t.sprintf(this.$t.__("Your URL appears to contain a domain inside the path: %1$s. Did you mean to use %2$s instead?",this.$td),"<code>"+this.getRelativeAbsolute+"</code>","<code>https:/"+this.getRelativeAbsolute+"</code>")),e},getDefaultRedirectType(){let e=this.getJsonValue(this.redirectsStore.options.redirectDefaults.redirectType);return e||(e=this.$constants.REDIRECT_TYPES[0]),e},getDefaultQueryParam(){let e=this.getJsonValue(this.redirectsStore.options.redirectDefaults.queryParam);return e||(e=this.$constants.REDIRECT_QUERY_PARAMS[0]),e},getDefaultSlash(){return this.redirectsStore.options.redirectDefaults.ignoreSlash},getDefaultCase(){return this.redirectsStore.options.redirectDefaults.ignoreCase},getDefaultSourceUrls(){return[JSON.parse(JSON.stringify(this.getDefaultSourceUrl))]},getDefaultSourceUrl(){return{id:null,url:null,regex:!1,ignoreSlash:this.slash||this.getDefaultSlash||!1,ignoreCase:this.case||this.getDefaultCase||!1,errors:[],warnings:[]}},redirectQueryParams(){return 0<this.sourceUrls.filter(e=>e.regex).length?this.$constants.REDIRECT_QUERY_PARAMS.map(e=>(e.$isDisabled=!1,e.value==="exact"&&(e.$isDisabled=!0,this.queryParam.value==="exact"&&(this.queryParam=this.$constants.REDIRECT_QUERY_PARAMS.find(t=>!t.$isDisabled))),e)):this.$constants.REDIRECT_QUERY_PARAMS.map(e=>(e.$isDisabled=!1,e))},unPublishedPost(){return this.redirectHasUnPublishedPost({post_id:this.postId,postStatus:this.postStatus})}},methods:{beginsWith(e,t){return t.indexOf(e)===0||e.substr(0,t.length)===t},addUrl(){this.sourceUrls.push(JSON.parse(JSON.stringify(this.getDefaultSourceUrl)))},removeUrl(e){this.sourceUrls.splice(e,1)},addRedirects(){this.genericError=!1,this.addingRedirect=!0,this.sourceUrls.map(e=>(e.url.substr(0,4)!=="http"&&e.url.substr(0,1)!=="/"&&0<e.url.length&&!e.regex&&(e.url="/"+e.url),e)),this.redirectsStore.create({sourceUrls:this.sourceUrls,targetUrl:this.targetUrl,queryParam:this.queryParam.value,customRules:this.customRules,redirectType:this.redirectType.value,redirectTypeHasTarget:this.redirectTypeHasTarget(),group:this.log404?"404":"manual",postId:this.postId}).then(()=>{this.$emit("added-redirect"),window.aioseoBus.$emit("added-redirect"),this.reset()}).catch(e=>{this.handleError(e)})},saveChanges(){this.genericError=!1,this.addingRedirect=!0,this.sourceUrls[0].url.substr(0,4)!=="http"&&this.sourceUrls[0].url.substr(0,1)!=="/"&&0<this.sourceUrls[0].url.length&&!this.sourceUrls[0].regex&&(this.sourceUrls[0].url="/"+this.sourceUrls[0].url),this.redirectsStore.update({id:this.sourceUrls[0].id,payload:{sourceUrls:this.sourceUrls,targetUrl:this.targetUrl,queryParam:this.queryParam.value,customRules:this.customRules,redirectType:this.redirectType.value,redirectTypeHasTarget:this.redirectTypeHasTarget(),postId:this.postId}}).then(()=>{this.reset()}).catch(e=>{console.error(e),this.handleError(e)})},handleError(e){if(e.response.status!==409||!e.response.body.failed||!e.response.body.failed.length){this.genericError=!0,this.addingRedirect=!1;return}const t=[],r=e.response.body.failed,v=this.$t.__("A redirect already exists for this source URL. To make changes, edit the original instead.",this.$td);r.forEach(s=>{const l=this.sourceUrls.findIndex(a=>a.url===s.url||s);l!==-1&&(this.sourceUrls[l].errors.find(a=>a===s.error||a===v)||this.sourceUrls[l].errors.push(s.error||v),t.push(l))});for(let s=this.sourceUrls.length-1;0<=s;s--)t.includes(s)||this.sourceUrls.splice(s,1);this.addingRedirect=!1},updateTargetUrl(e){this.targetUrl=e,this.targetUrlErrors=this.hasTargetUrlErrors,this.targetUrlWarnings=this.hasTargetUrlWarnings},reset(){if(this.showAdvancedSettings=!1,this.addingRedirect=!1,this.edit)return;const e=this.$constants.REDIRECT_TYPES.find(r=>r.value===this.type)||this.getDefaultRedirectType,t=this.$constants.REDIRECT_QUERY_PARAMS.find(r=>r.value===this.query)||this.getDefaultQueryParam;this.sourceUrls=[JSON.parse(JSON.stringify(this.getDefaultSourceUrl))],this.targetUrl=null,this.targetUrlErrors=[],this.targetUrlWarnings=[],this.redirectType=e||{label:"301 "+this.$t.__("Moved Permanently",this.$td),value:301},this.queryParam=t||{label:this.$t.__("Ignore all parameters",this.$td),value:"ignore"},this.customRules=[]},checkForDuplicates(){const e=[];this.sourceUrls.forEach((t,r)=>{if(!(!t.url||t.errors.length)){if(e.includes(t.url.replace(/\/$/,""))){this.sourceUrls[r].errors.push(this.$t.__("This is a duplicate of a URL you are already adding. You can only add unique source URLs.",this.$td));return}e.push(t.url.replace(/\/$/,""))}}),this.updateTargetUrl(this.targetUrl)},redirectTypeHasTarget(){return this.redirectType&&(typeof this.redirectType.noTarget>"u"||!this.redirectType.noTarget)}},mounted(){this.sourceUrls=this.getDefaultSourceUrls,this.url&&(this.sourceUrls=[{...this.getDefaultSourceUrl,...this.url}]),this.urls&&this.urls.length&&(this.sourceUrls=this.urls.map(r=>({...this.getDefaultSourceUrl,...r}))),this.sourceDisabled=this.disableSource,this.unPublishedPost&&(this.sourceUrls=this.sourceUrls.map(r=>(r.url="("+this.strings.sourceUrlSetOncePublished+")",r)),this.sourceDisabled=!0),this.target&&(this.targetUrl=this.target),this.rules&&(this.customRules=this.rules);const e=this.$constants.REDIRECT_TYPES.find(r=>r.value===this.type)||this.getDefaultRedirectType;e&&(this.redirectType=e);const t=this.$constants.REDIRECT_QUERY_PARAMS.find(r=>r.value===this.query)||this.getDefaultQueryParam;t&&(this.queryParam=t)}},We={class:"urls"},Ye={class:"source"},Fe={class:"aioseo-settings-row no-border no-margin small-padding"},je={class:"settings-name"},Je={class:"name small-margin"},Qe=["innerHTML"],Ge={key:0,class:"url-arrow"},Ke={key:1,class:"target"},Ze={class:"aioseo-settings-row no-border no-margin small-padding"},Xe={class:"settings-name"},et={class:"name small-margin"},tt={class:"url"},st={class:"aioseo-description"},rt=i("div",{class:"break"},null,-1),lt={class:"source"},it=["innerHTML"],ot=i("div",{class:"url-arrow"},null,-1),nt=i("div",{class:"target"},null,-1),ut={class:"all-settings"},at={class:"all-settings-content"},ct={class:"redirect-type"},dt={class:"query-params"};function ht(e,t,r,v,s,l){const a=u("core-alert"),y=u("core-add-redirection-url"),f=u("base-button"),E=u("svg-right-arrow"),C=u("core-add-redirection-target-url"),b=u("transition-slide"),S=u("base-select"),D=u("custom-rules");return o(),m("div",{class:$(["aioseo-add-redirection",{"edit-url":r.edit,"log-404":r.log404}])},[s.genericError?(o(),g(a,{key:0,class:"generic-error",type:"red"},{default:h(()=>[U(p(s.strings.genericErrorMessage),1)]),_:1})):d("",!0),i("div",We,[i("div",Ye,[i("div",Fe,[i("div",je,[i("div",Je,p(l.sourceUrl)+": ",1)]),(o(!0),m(T,null,L(s.sourceUrls,(n,_)=>(o(),g(y,{key:_,url:n,"allow-delete":1<s.sourceUrls.length,onRemoveUrl:I=>l.removeUrl(_),"target-url":s.targetUrl,log404:r.log404,disableSource:s.sourceDisabled},G({_:2},[r.edit&&!s.sourceDisabled?{name:"source-url-description",fn:h(()=>[i("div",{class:"aioseo-description source-description",innerHTML:s.strings.sourceUrlDescription},null,8,Qe)]),key:"0"}:void 0]),1032,["url","allow-delete","onRemoveUrl","target-url","log404","disableSource"]))),128)),!r.edit&&!r.log404&&!s.sourceDisabled?(o(),g(f,{key:0,size:"small",type:"gray",onClick:l.addUrl},{default:h(()=>[U(p(s.strings.addUrl),1)]),_:1},8,["onClick"])):d("",!0)])]),l.redirectTypeHasTarget()?(o(),m("div",Ge,[c(E)])):d("",!0),l.redirectTypeHasTarget()?(o(),m("div",Ke,[i("div",Ze,[i("div",Xe,[i("div",et,p(s.strings.targetUrl)+": ",1)]),i("div",tt,[c(C,{url:s.targetUrl,errors:s.targetUrlErrors,warnings:s.targetUrlWarnings,"onUpdate:modelValue":l.updateTargetUrl},null,8,["url","errors","warnings","onUpdate:modelValue"]),i("div",st,p(s.strings.targetUrlDescription),1),c(b,{active:!!s.targetUrlErrors.length},{default:h(()=>[i("div",null,[(o(!0),m(T,null,L(s.targetUrlErrors,(n,_)=>(o(),g(a,{key:_,class:"target-url-error",type:"red",size:"small",innerHTML:n},null,8,["innerHTML"]))),128))])]),_:1},8,["active"]),c(b,{active:!!s.targetUrlWarnings.length},{default:h(()=>[i("div",null,[(o(!0),m(T,null,L(s.targetUrlWarnings,(n,_)=>(o(),g(a,{key:_,class:"target-url-warning",type:"yellow",size:"small",innerHTML:n},null,8,["innerHTML"]))),128))])]),_:1},8,["active"])])])])):d("",!0),!r.edit&&!r.log404&&!s.sourceDisabled?(o(),m(T,{key:2},[rt,i("div",lt,[i("div",{class:"aioseo-description source-description",innerHTML:s.strings.sourceUrlDescription},null,8,it)]),ot,nt],64)):d("",!0)]),i("div",{class:$(["settings",{advanced:s.showAdvancedSettings}])},[i("div",ut,[i("div",at,[i("div",ct,[U(p(s.strings.redirectType)+" ",1),c(S,{options:e.$constants.REDIRECT_TYPES,modelValue:s.redirectType,"onUpdate:modelValue":t[0]||(t[0]=n=>s.redirectType=n),size:"medium"},null,8,["options","modelValue"])]),c(b,{class:"advanced-settings",active:s.showAdvancedSettings},{default:h(()=>[i("div",dt,[U(p(s.strings.queryParams)+" ",1),c(S,{options:l.redirectQueryParams,modelValue:s.queryParam,"onUpdate:modelValue":t[1]||(t[1]=n=>s.queryParam=n),size:"medium"},null,8,["options","modelValue"])])]),_:1},8,["active"]),s.showAdvancedSettings?d("",!0):(o(),m("a",{key:0,class:"advanced-settings-link",href:"#",onClick:t[2]||(t[2]=W(n=>s.showAdvancedSettings=!s.showAdvancedSettings,["prevent"]))},p(s.strings.advancedSettings),1))])]),c(b,{class:"advanced-settings",active:s.showAdvancedSettings},{default:h(()=>[c(D,{"edit-custom-rules":s.customRules},null,8,["edit-custom-rules"])]),_:1},8,["active"]),i("div",{class:$(["actions",{advanced:s.showAdvancedSettings}])},[c(f,{size:"medium",type:"blue",onClick:t[3]||(t[3]=n=>r.edit?l.saveChanges():l.addRedirects()),loading:s.addingRedirect,disabled:l.saveIsDisabled},{default:h(()=>[U(p(r.edit?s.strings.saveChanges:l.addRedirect),1)]),_:1},8,["loading","disabled"]),r.edit?(o(),g(f,{key:0,size:"medium",type:"gray",onClick:t[4]||(t[4]=n=>e.$emit("cancel",!0)),class:"cancel-edit-row"},{default:h(()=>[U(p(s.strings.cancel),1)]),_:1})):d("",!0)],2)],2)],2)}const Vt=w(qe,[["render",ht]]);export{Vt as C};
