import{a as h,n as o,b as m,_}from"./vendor.cae9834c.js";import{R as v,S as g}from"./SimpleBarChart.9900cd81.js";import{T as b}from"./tri-color-blend.3ecffd12.js";import{S as y}from"./SampleSizeWarning.0b034383.js";import{S as C}from"./SampleRangePicker.49ea8317.js";import{S}from"./SamplePaneFooter.90ac6a0d.js";import{R as w}from"./RecommendationsList.d7c9e75e.js";var $=function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("main")},x=[];const p=window.Vue;p.use(h);const F=p.extend({mounted:function(){this.$confetti.start({shape:"rect",colors:["DodgerBlue","OliveDrab","Gold","pink","SlateBlue","lightblue","Violet","PaleGreen","SteelBlue","SandyBrown","Chocolate","Crimson"]}),setTimeout(()=>{this.$confetti.stop()},5e3)},methods:{}}),c={};var R=o(F,$,x,!1,P,null,null,null);function P(t){for(let a in c)this[a]=c[a]}var V=function(){return R.exports}(),k=function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("div",{on:{click:function(r){return t.redirectTo(t.detailPageUrl)}}},[e("div",{staticClass:"clearafter pb-1"},[e("div",{staticClass:"simple-bar-chart-label text-base font-normal truncate-label",staticStyle:{width:"90%"},attrs:{title:t.title}},[t.title?e("a",{staticStyle:{color:"rgb(26 13 171)"},attrs:{href:t.url,target:"_blank"},on:{click:function(r){r.stopPropagation()}}},[t._v(" "+t._s(t.title)+" ")]):e("span",{staticClass:"text-gray-300"},[e("em",[t._v("Craft backend route")])])]),e("div",{staticClass:"simple-bar-chart-value"},[e("sample-size-warning",{attrs:{sample:t.cnt}})],1)]),e("div",{staticClass:"clearafter pb-1"},[e("cite",{staticClass:"simple-bar-chart-label text-sm font-normal truncate-label",staticStyle:{width:"80%"},attrs:{title:t.url}},[e("a",{staticClass:"hover:no-underline",staticStyle:{color:"rgb(0 102 33)"},attrs:{href:t.url,target:"_blank"},on:{click:function(r){r.stopPropagation()}}},[t._v(" "+t._s(t.url)+" ")])]),e("div",{staticClass:"simple-bar-chart-value text-sm font-bold"},[t._v(" "+t._s(t.data)+" ")])]),e("div",{staticClass:"py-1"},[e("div",{staticClass:"file-list-chart-track rounded-full bg-gray-200"},[e("div",{staticClass:"simple-bar-line h-2 rounded-full",style:{width:t.width+"%",backgroundColor:t.color}})])])])},B=[];const D={name:"DashboardFileListCell",components:{SampleSizeWarning:y},props:{title:{type:String,default:""},url:{type:String,default:""},detailPageUrl:{type:String,default:""},data:{type:String,default:""},cnt:{type:Number,default:0},width:{type:Number,default:0},color:{type:String,default:""}},methods:{redirectTo(t){window.location.href=t}}},u={};var E=o(D,k,B,!1,L,null,null,null);function L(t){for(let a in u)this[a]=u[a]}var N=function(){return E.exports}(),U=function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("section",{staticClass:"px-3 py-3"},[e("div",{staticClass:"text-left text-base font-bold px-2 pt-2"},[t._v(" Slowest pages ")]),t._l(t.series,function(r,s){return e("div",{key:s,staticClass:"file-list-wrapper p-2"},[e("dashboard-file-list-cell",{attrs:{cnt:r.cnt,color:r.barColor,data:t.statFormatter(r.data,r.maxValue),"detail-page-url":r.detailPageUrl,title:r.title,url:r.url,width:r.data}})],1)})],2)},T=[];const I=t=>({baseURL:t,headers:{"X-Requested-With":"XMLHttpRequest"}}),M=(t,a,e,r)=>{t.get(a,{params:e}).then(s=>{r&&r(s.data)}).catch(s=>{console.log(s)})},j={name:"DashboardFileList",components:{"dashboard-file-list-cell":N},props:{start:{type:String,default:""},end:{type:String,default:""},column:{type:String,default:""},fastColor:{type:String,default:"#00C800"},averageColor:{type:String,default:"#FFFF00"},slowColor:{type:String,default:"#C80000"},limit:{type:Number,default:3},maxValue:{type:Number,default:1e4},siteId:{type:Number,default:0},apiUrl:{type:String,default:""}},data:function(){return{series:[],displayStart:this.start,displayEnd:this.end,triBlend:new b(this.fastColor,this.averageColor,this.slowColor)}},created(){this.getSeriesData()},mounted(){this.$events.$on("change-range",t=>this.onChangeRange(t))},methods:{getSeriesData:async function(){const t=m.create(I(this.apiUrl));let a={column:this.column,start:this.displayStart,end:this.displayEnd,siteId:this.siteId};await M(t,"",a,e=>{e.forEach((r,s,n)=>{let l=r.avg/1e3,i=this.maxValue;l>i&&(i=l),l=l*100/i,n[s].data=l,n[s].maxValue=i,n[s].barColor=this.triBlend.colorFromPercentage(l)}),this.series=e})},onChangeRange(t){this.displayStart=t.start,this.displayEnd=t.end,this.getSeriesData()},statFormatter(t,a){return t=t*a/100,Number(t).toFixed(2)+"s"}}},d={};var q=o(j,U,T,!1,z,null,null,null);function z(t){for(let a in d)this[a]=d[a]}var A=function(){return q.exports}();const f=window.Vue;f.use(_);new f({el:"#cp-nav-content",components:{ConfettiParty:V,RadialBarChart:v,SimpleBarChart:g,DashboardFileList:A,SampleRangePicker:C,SamplePaneFooter:S,RecommendationsList:w}});
//# sourceMappingURL=dashboard.f439b4a6.js.map