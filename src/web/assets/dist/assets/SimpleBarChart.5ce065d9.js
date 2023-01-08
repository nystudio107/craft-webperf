import{n,A as p,a as o}from"./vue-apexcharts.159e071b.js";import{T as d}from"./tri-color-blend.3ecffd12.js";var h=function(){var t=this,s=t.$createElement,e=t._self._c||s;return e("apexcharts",{attrs:{options:t.chartOptions,series:t.series,height:"300px",type:"radialBar",width:"100%"}})},u=[];const c=t=>({baseURL:t,headers:{"X-Requested-With":"XMLHttpRequest"}}),f=(t,s,e,a)=>{t.get(s,{params:e}).then(r=>{a&&a(r.data)}).catch(r=>{console.log(r)})},g={components:{apexcharts:p},props:{title:{type:String,default:""},start:{type:String,default:""},end:{type:String,default:""},column:{type:String,default:""},pageUrl:{type:String,default:""},fastColor:{type:String,default:"#00C800"},averageColor:{type:String,default:"#FFFF00"},slowColor:{type:String,default:"#C80000"},maxValue:{type:Number,default:1e4},siteId:{type:Number,default:0},apiUrl:{type:String,default:""}},data:function(){return{chartOptions:{chart:{id:"vuechart-dashboard-radial-bar",fontFamily:"inherit",toolbar:{show:!1}},states:{hover:{filter:{type:"none",value:0}}},colors:["#000000"],plotOptions:{radialBar:{startAngle:-135,endAngle:135,hollow:{size:"65%"},track:{background:"#f1f5f8",strokeWidth:"97%",margin:5,shadow:{enabled:!0,top:2,left:0,color:"#999",opacity:1,blur:2}},dataLabels:{name:{show:!1,fontSize:"16px",color:"#333",offsetY:100},value:{offsetY:10,fontSize:"40px",color:"#333",style:{cssClass:"apexcharts-datalabel-value"},formatter:t=>(t=t*this.displayMaxValue/100,Number(t).toFixed(2)+"s")}}}},labels:[this.title],title:{text:this.title,offsetY:18,align:"center",style:{fontSize:"16px",cssClass:"apexcharts-title-text"}},stroke:{width:1,lineCap:"round"}},series:[0],displayStart:this.start,displayEnd:this.end,displayMaxValue:this.maxValue,triBlend:new d(this.fastColor,this.averageColor,this.slowColor)}},created(){this.getSeriesData()},mounted(){this.$events!==void 0&&this.$events.$on("change-range",t=>this.onChangeRange(t))},methods:{getSeriesData:async function(){const t=o.create(c(this.apiUrl));let s={column:this.column,start:this.displayStart,end:this.displayEnd,pageUrl:this.pageUrl,siteId:this.siteId};await f(t,"",s,e=>{if(e.avg!==void 0){let a=e.avg/1e3;a>this.displayMaxValue&&(this.displayMaxValue=a),a=a*100/this.displayMaxValue;let r=this.triBlend.colorFromPercentage(a);this.chartOptions={...this.chartOptions,colors:[r],plotOptions:{radialBar:{dataLabels:{value:{color:r}}}}},this.series=[a]}})},onChangeRange(t){this.displayStart=t.start,this.displayEnd=t.end,this.getSeriesData()}}},i={};var y=n(g,h,u,!1,m,null,null,null);function m(t){for(let s in i)this[s]=i[s]}var M=function(){return y.exports}(),v=function(){var t=this,s=t.$createElement,e=t._self._c||s;return e("div",{staticClass:"simple-bar-chart-wrapper px-5 py-3"},[e("div",{staticClass:"clearafter py-2"},[e("div",{staticClass:"simple-bar-chart-label text-base font-bold"},[t._v(" "+t._s(t.title)+" ")]),e("div",{staticClass:"simple-bar-chart-value text-base font-bold"},[t._v(" "+t._s(t.statFormatter(t.series[0]))+" ")])]),e("div",{staticClass:"py-2"},[e("div",{staticClass:"simple-bar-chart-track rounded-full bg-gray-200"},[e("div",{staticClass:"simple-bar-line h-3 rounded-full",style:{width:t.series[0]+"%",backgroundColor:t.barColor}})])])])},C=[];const _=t=>({baseURL:t,headers:{"X-Requested-With":"XMLHttpRequest"}}),S=(t,s,e,a)=>{t.get(s,{params:e}).then(r=>{a&&a(r.data)}).catch(r=>{console.log(r)})},x={components:{},props:{title:{type:String,default:""},start:{type:String,default:""},end:{type:String,default:""},column:{type:String,default:""},pageUrl:{type:String,default:""},fastColor:{type:String,default:"#00C800"},averageColor:{type:String,default:"#FFFF00"},slowColor:{type:String,default:"#C80000"},maxValue:{type:Number,default:1e4},siteId:{type:Number,default:0},apiUrl:{type:String,default:""}},data:function(){return{barColor:"#000",series:[0],displayStart:this.start,displayEnd:this.end,displayMaxValue:this.maxValue,triBlend:new d(this.fastColor,this.averageColor,this.slowColor)}},created(){this.getSeriesData()},mounted(){this.$events!==void 0&&this.$events.$on("change-range",t=>this.onChangeRange(t))},methods:{getSeriesData:async function(){const t=o.create(_(this.apiUrl));let s={column:this.column,start:this.displayStart,end:this.displayEnd,pageUrl:this.pageUrl,siteId:this.siteId};await S(t,"",s,e=>{if(e.avg!==void 0){let a=e.avg/1e3;a>this.displayMaxValue&&(this.displayMaxValue=a),a=a*100/this.displayMaxValue,this.barColor=this.triBlend.colorFromPercentage(a),this.series=[a]}})},onChangeRange(t){this.displayStart=t.start,this.displayEnd=t.end,this.getSeriesData()},statFormatter(t){return t=t*this.displayMaxValue/100,Number(t).toFixed(2)+"s"}}},l={};var b=n(x,v,C,!1,F,null,null,null);function F(t){for(let s in l)this[s]=l[s]}var R=function(){return b.exports}();export{M as R,R as S};
//# sourceMappingURL=SimpleBarChart.5ce065d9.js.map