import{g as l,r as c}from"./params.f0608262.js";import{S as d}from"./LogoGear.c42c709f.js";import{r as p,o as u,c as g,a as h,d as m}from"./vue.runtime.esm-bundler.b39e1078.js";import{_}from"./_plugin-vue_export-helper.b97bdf23.js";const P={mounted(){var i,n;const t=l()["aioseo-scroll"]||((i=history.state)==null?void 0:i.scroll);t&&typeof t=="string"&&setTimeout(()=>{var o;this.$scrollTo(`#${t}`,{offset:-130,container:this.scrollContainer||"body"}),c("aioseo-scroll"),(o=history.state)==null||delete o.scroll},this.scrollTimeout||500);const s=l()["aioseo-highlight"]||((n=history.state)==null?void 0:n.highlight);if(s&&typeof s=="string"){const o=t?this.scrollAndHighlightTimeout||1500:this.highlightTimeout||500;setTimeout(()=>{var r;const e=document.querySelectorAll(`#${s.replace(/,/g,", #").replace(/%2C/ig,", #")}`);e.length&&e.forEach(a=>{a.classList.add("aioseo-row-highlight"),setTimeout(()=>{a.classList.remove("aioseo-row-highlight")},1500)}),(r=history.state)==null||delete r.highlight,c("aioseo-highlight")},o)}}};const f={components:{SvgAioseoLogoGear:d},data(){return{strings:{boldText:this.$t.sprintf("<strong>%1$s %2$s</strong>","AIOSEO",this.$isPro?"Pro":""),linkText:this.$t.__("Click here to learn more",this.$td)}}},computed:{link(){return this.$t.sprintf('<strong><a href="%1$s" target="_blank" class="text-white">%2$s</a></strong>',this.$links.getDocUrl("restApi"),this.strings.linkText)},upgradeText(){return this.$t.sprintf(this.$t.__("%1$s relies on the WordPress Rest API and your site might have it disabled. %2$s.",this.$td),this.strings.boldText,this.link)}},mounted(){document.body.classList.add("aioseo-has-bar")},beforeUnmount(){document.body.classList.remove("aioseo-has-bar")}},$={class:"aioseo-api-bar"},y={class:"upgrade-text"},x=["innerHTML"];function T(t,s,i,n,o,e){const r=p("svg-aioseo-logo-gear");return u(),g("div",$,[h("div",y,[m(r),h("div",{innerHTML:e.upgradeText},null,8,x)])])}const B=_(f,[["render",T]]),v={};function A(t,s){return u(),g("div")}const S=_(v,[["render",A]]);export{B as C,P as S,S as a};