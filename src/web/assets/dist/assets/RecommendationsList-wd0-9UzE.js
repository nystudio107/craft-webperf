import{n as i,A as r}from"./vue-apexcharts-KYvHKhev.js";import{S as o}from"./SamplePaneFooter-TQ6iosc3.js";const l=s=>({baseURL:s,headers:{"X-Requested-With":"XMLHttpRequest"}}),d=(s,e,t,a)=>{s.get(e,{params:t}).then(n=>{a&&a(n.data)}).catch(n=>{console.log(n)})},p={components:{"sample-pane-footer":o},props:{start:{type:String,default:""},end:{type:String,default:""},devModeWarning:{type:Boolean,default:!1},pageUrl:{type:String,default:""},siteId:{type:Number,default:0},apiUrl:{type:String,default:""}},data:function(){return{series:[],displayStart:this.start,displayEnd:this.end}},created(){this.getSeriesData()},mounted(){this.$events.$on("change-range",s=>this.onChangeRange(s))},methods:{getSeriesData:async function(){const s=r.create(l(this.apiUrl));let e={start:this.displayStart,end:this.displayEnd,pageUrl:this.pageUrl,siteId:this.siteId};await d(s,"",e,t=>{t[0]!==void 0&&(this.series=t)})},onChangeRange(s){this.displayStart=s.start,this.displayEnd=s.end,this.getSeriesData()}}};var c=function(){var e=this,t=e._self._c;return t("div",[e.series.length?e._e():t("div",{staticClass:"text-3xl text-center py-10"},[e._v(" 🎉 No recommendations found. Nice job! ")]),e._l(e.series,function(a,n){return t("div",{key:n},[t("div",{staticClass:"field pb-4"},[t("p",{staticClass:"warning text-2xl leading-normal"},[t("span",{domProps:{innerHTML:e._s(a.summary)}})]),t("div",{staticClass:"heading",staticStyle:{"padding-left":"26px"}},[t("p",{staticClass:"instructions text-xl leading-tight"},[t("span",{domProps:{innerHTML:e._s(a.detail)}}),t("span",{staticClass:"field inline-block m-0"},[a.learnMoreUrl!==""?t("a",{staticClass:"go notice",attrs:{href:a.learnMoreUrl,rel:"noopener,nofollow",target:"_blank"}},[e._v("Learn More")]):e._e()])])])])])}),t("sample-pane-footer",{attrs:{"display-dev-mode-warning":e.devModeWarning,"page-url":e.pageUrl,"site-id":e.siteId,column:"id",end:"end",start:"start",subject:"recommendations"}})],2)},g=[],u=i(p,c,g,!1,null,null,null,null);const h=u.exports;export{h as R};
//# sourceMappingURL=RecommendationsList-wd0-9UzE.js.map
