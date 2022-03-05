var g=Object.defineProperty,m=Object.defineProperties;var y=Object.getOwnPropertyDescriptors;var l=Object.getOwnPropertySymbols;var v=Object.prototype.hasOwnProperty,_=Object.prototype.propertyIsEnumerable;var o=(t,a,e)=>a in t?g(t,a,{enumerable:!0,configurable:!0,writable:!0,value:e}):t[a]=e,d=(t,a)=>{for(var e in a||(a={}))v.call(a,e)&&o(t,e,a[e]);if(l)for(var e of l(a))_.call(a,e)&&o(t,e,a[e]);return t},p=(t,a)=>m(t,y(a));import{n as i,A as S,b as n}from"./vendor.cae9834c.js";import{T as f}from"./tri-color-blend.3ecffd12.js";var C=function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("apexcharts",{attrs:{options:t.chartOptions,series:t.series,height:"180px",type:"radialBar",width:"100%"}})},x=[];const b=t=>({baseURL:t,headers:{"X-Requested-With":"XMLHttpRequest"}}),$=(t,a,e,s)=>{t.get(a,{params:e}).then(r=>{s&&s(r.data)}).catch(r=>{console.log(r)})},w={components:{apexcharts:S},props:{title:{type:String,default:""},start:{type:String,default:""},end:{type:String,default:""},column:{type:String,default:""},pageUrl:{type:String,default:""},fastColor:{type:String,default:"#00C800"},averageColor:{type:String,default:"#FFFF00"},slowColor:{type:String,default:"#C80000"},maxValue:{type:Number,default:1e4},siteId:{type:Number,default:0},apiUrl:{type:String,default:""}},data:function(){return{chartOptions:{chart:{id:"vuechart-dashboard-radial-bar",fontFamily:"inherit",toolbar:{show:!1}},states:{hover:{filter:{type:"none",value:0}}},colors:["#000000"],plotOptions:{radialBar:{startAngle:-135,endAngle:135,hollow:{size:"65%"},track:{background:"#dae1e7",strokeWidth:"97%",margin:5,shadow:{enabled:!0,top:2,left:0,color:"#999",opacity:1,blur:2}},dataLabels:{name:{show:!1,fontSize:"16px",color:"#333",offsetY:100},value:{offsetY:6,fontSize:"18px",color:"#333",style:{cssClass:"apexcharts-datalabel-value"},formatter:t=>(t=t*this.displayMaxValue/100,Number(t).toFixed(2)+"s")}}}},labels:[this.title],title:{text:this.title,offsetY:20,align:"center",style:{color:"#606f7b",fontSize:"15px",cssClass:"apexcharts-title-text"}},stroke:{width:1,lineCap:"round"}},series:[0],displayStart:this.start,displayEnd:this.end,displayMaxValue:this.maxValue,triBlend:new f(this.fastColor,this.averageColor,this.slowColor)}},created(){this.getSeriesData()},mounted(){this.$events!==void 0&&this.$events.$on("change-range",t=>this.onChangeRange(t))},methods:{getSeriesData:async function(){const t=n.create(b(this.apiUrl));let a={column:this.column,start:this.displayStart,end:this.displayEnd,pageUrl:this.pageUrl,siteId:this.siteId};await $(t,"",a,e=>{if(e.avg!==void 0){let s=e.avg/1e3;s>this.displayMaxValue&&(this.displayMaxValue=s),s=s*100/this.displayMaxValue;let r=this.triBlend.colorFromPercentage(s);this.chartOptions=p(d({},this.chartOptions),{colors:[r],plotOptions:{radialBar:{dataLabels:{value:{color:r}}}}}),this.series=[s]}})},onChangeRange(t){this.displayStart=t.start,this.displayEnd=t.end,this.getSeriesData()}}},u={};var F=i(w,C,x,!1,R,null,null,null);function R(t){for(let a in u)this[a]=u[a]}var M=function(){return F.exports}(),U=function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("div",{staticClass:"simple-bar-chart-wrapper px-3 py-1"},[e("div",{staticClass:"clearafter py-1"},[e("div",{staticClass:"simple-bar-chart-label text-sm font-bold text-gray-600"},[t._v(" "+t._s(t.title)+" ")]),e("div",{staticClass:"simple-bar-chart-value text-sm font-bold text-gray-600"},[t._v(" "+t._s(t.statFormatter(t.series[0]))+" ")])]),e("div",{staticClass:"py-1"},[e("div",{staticClass:"simple-bar-chart-track rounded-full bg-gray-300"},[e("div",{staticClass:"simple-bar-line h-1 rounded-full",style:{width:t.series[0]+"%",backgroundColor:t.barColor}})])])])},V=[];const A=t=>({baseURL:t,headers:{"X-Requested-With":"XMLHttpRequest"}}),B=(t,a,e,s)=>{t.get(a,{params:e}).then(r=>{s&&s(r.data)}).catch(r=>{console.log(r)})},E={components:{},props:{title:{type:String,default:""},start:{type:String,default:""},end:{type:String,default:""},column:{type:String,default:""},pageUrl:{type:String,default:""},fastColor:{type:String,default:"#00C800"},averageColor:{type:String,default:"#FFFF00"},slowColor:{type:String,default:"#C80000"},maxValue:{type:Number,default:1e4},siteId:{type:Number,default:0},apiUrl:{type:String,default:""}},data:function(){return{barColor:"#000",series:[0],displayStart:this.start,displayEnd:this.end,displayMaxValue:this.maxValue,triBlend:new f(this.fastColor,this.averageColor,this.slowColor)}},created(){this.getSeriesData()},mounted(){this.$events!==void 0&&this.$events.$on("change-range",t=>this.onChangeRange(t))},methods:{getSeriesData:async function(){const t=n.create(A(this.apiUrl));let a={column:this.column,start:this.displayStart,end:this.displayEnd,pageUrl:this.pageUrl,siteId:this.siteId};await B(t,"",a,e=>{if(e.avg!==void 0){let s=e.avg/1e3;s>this.displayMaxValue&&(this.displayMaxValue=s),s=s*100/this.displayMaxValue,this.barColor=this.triBlend.colorFromPercentage(s),this.series=[s]}})},onChangeRange(t){this.displayStart=t.start,this.displayEnd=t.end,this.getSeriesData()},statFormatter(t){return t=t*this.displayMaxValue/100,Number(t).toFixed(2)+"s"}}},c={};var I=i(E,U,V,!1,D,null,null,null);function D(t){for(let a in c)this[a]=c[a]}var N=function(){return I.exports}(),q=function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("div",{staticClass:"field"},[t.samples>=100?e("div",{staticClass:"heading"},[e("p",{staticClass:"instructions"},[t._v(" Average of "),e("strong",[t._v(t._s(t.formatNumber(t.samples)))]),t._v(" data sample"),t.samples!==1?e("span",[t._v("s")]):t._e(),t._v(". ")])]):t._e(),t.samples<100?e("p",{staticClass:"warning"},[t._v(" Average of only "),e("strong",[t._v(t._s(t.formatNumber(t.samples)))]),t._v(" data sample"),t.samples!==1?e("span",[t._v("s")]):t._e(),t._v(". ")]):t._e()])},L=[];const O=t=>({baseURL:t,headers:{"X-Requested-With":"XMLHttpRequest"}}),P=(t,a,e,s)=>{t.get(a,{params:e}).then(r=>{s&&s(r.data)}).catch(r=>{console.log(r)})},X={components:{},props:{start:{type:String,default:""},end:{type:String,default:""},column:{type:String,default:""},displayDevModeWarning:{type:Boolean,default:!1},pageUrl:{type:String,default:""},subject:{type:String,default:""},siteId:{type:Number,default:0},apiUrl:{type:String,default:""}},data:function(){return{samples:0,displayEnd:this.end,displayMaxValue:this.maxValue}},created(){this.getSeriesData()},mounted(){this.$events!==void 0&&this.$events.$on("change-range",t=>this.onChangeRange(t))},methods:{getSeriesData:async function(){const t=n.create(O(this.apiUrl));let a={column:this.column,start:this.displayStart,end:this.displayEnd,pageUrl:this.pageUrl,siteId:this.siteId};await P(t,"",a,e=>{e.cnt!==void 0&&(this.samples=e.cnt)})},onChangeRange(t){this.displayStart=t.start,this.displayEnd=t.end,this.getSeriesData()},formatNumber(t){return t.toString().replace(/\B(?=(\d{3})+(?!\d))/g,",")}}},h={};var z=i(X,q,L,!1,W,null,null,null);function W(t){for(let a in h)this[a]=h[a]}var j=function(){return z.exports}();const k=window.Vue;new k({el:"#cp-nav-content",components:{SmallRadialBarChart:M,SmallSimpleBarChart:N,SmallSamplePaneFooter:j}});
//# sourceMappingURL=sidebar.20f1383b.js.map