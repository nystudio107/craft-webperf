import{n as r,a as o}from"./vue-apexcharts.159e071b.js";import{S as l}from"./SamplePaneFooter.eadc9035.js";var d=function(){var e=this,s=e.$createElement,t=e._self._c||s;return t("div",[e.series.length?e._e():t("div",{staticClass:"text-3xl text-center py-10"},[e._v(" \u{1F389} No recommendations found. Nice job! ")]),e._l(e.series,function(a,n){return t("div",{key:n},[t("div",{staticClass:"field pb-4"},[t("p",{staticClass:"warning text-2xl leading-normal"},[t("span",{domProps:{innerHTML:e._s(a.summary)}})]),t("div",{staticClass:"heading",staticStyle:{"padding-left":"26px"}},[t("p",{staticClass:"instructions text-xl leading-tight"},[t("span",{domProps:{innerHTML:e._s(a.detail)}}),t("span",{staticClass:"field inline-block m-0"},[a.learnMoreUrl!==""?t("a",{staticClass:"go notice",attrs:{href:a.learnMoreUrl,rel:"noopener,nofollow",target:"_blank"}},[e._v("Learn More")]):e._e()])])])])])}),t("sample-pane-footer",{attrs:{"display-dev-mode-warning":e.devModeWarning,"page-url":e.pageUrl,"site-id":e.siteId,column:"id",end:"end",start:"start",subject:"recommendations"}})],2)},p=[];const c=e=>({baseURL:e,headers:{"X-Requested-With":"XMLHttpRequest"}}),u=(e,s,t,a)=>{e.get(s,{params:t}).then(n=>{a&&a(n.data)}).catch(n=>{console.log(n)})},g={components:{"sample-pane-footer":l},props:{start:{type:String,default:""},end:{type:String,default:""},devModeWarning:{type:Boolean,default:!1},pageUrl:{type:String,default:""},siteId:{type:Number,default:0},apiUrl:{type:String,default:""}},data:function(){return{series:[],displayStart:this.start,displayEnd:this.end}},created(){this.getSeriesData()},mounted(){this.$events.$on("change-range",e=>this.onChangeRange(e))},methods:{getSeriesData:async function(){const e=o.create(c(this.apiUrl));let s={start:this.displayStart,end:this.displayEnd,pageUrl:this.pageUrl,siteId:this.siteId};await u(e,"",s,t=>{t[0]!==void 0&&(this.series=t)})},onChangeRange(e){this.displayStart=e.start,this.displayEnd=e.end,this.getSeriesData()}}},i={};var f=r(g,d,p,!1,h,null,null,null);function h(e){for(let s in i)this[s]=i[s]}var v=function(){return f.exports}();export{v as R};
//# sourceMappingURL=RecommendationsList.281cf6fa.js.map
