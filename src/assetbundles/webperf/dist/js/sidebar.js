/*!
 * @project        webperf
 * @name           sidebar.js
 * @author         Andrew Welch
 * @build          Wed Dec 09 2020 03:41:55 GMT+0000 (Coordinated Universal Time)
 * @copyright      Copyright (c) 2020 ©2020 nystudio107.com
 *
 */
(self.webpackChunkwebperf=self.webpackChunkwebperf||[]).push([[541],{3470:function(t,e,a){"use strict";a(9653),a(6977);var r=a(7757),s=a.n(r),n=a(9713),i=a.n(n),l=(a(5666),a(8926)),o=a.n(l),u=a(9669),c=a.n(u),p=a(7166),d=a.n(p),h=a(1177);function f(t,e){var a=Object.keys(t);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(t);e&&(r=r.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),a.push.apply(a,r)}return a}function g(t){for(var e=1;e<arguments.length;e++){var a=null!=arguments[e]?arguments[e]:{};e%2?f(Object(a),!0).forEach((function(e){i()(t,e,a[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(a)):f(Object(a)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(a,e))}))}return t}var m,v=function(t,e,a,r){t.get(e,{params:a}).then((function(t){r&&r(t.data)})).catch((function(t){console.log(t)}))},y={components:{apexcharts:d()},props:{title:String,start:String,end:String,column:String,pageUrl:{type:String,default:""},fastColor:{type:String,default:"#00C800"},averageColor:{type:String,default:"#FFFF00"},slowColor:{type:String,default:"#C80000"},maxValue:Number,siteId:{type:Number,default:0},apiUrl:{type:String,default:""}},methods:{getSeriesData:(m=o()(s().mark((function t(){var e,a,r=this;return s().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return e=c().create({baseURL:this.apiUrl,headers:{"X-Requested-With":"XMLHttpRequest"}}),a={column:this.column,start:this.displayStart,end:this.displayEnd,pageUrl:this.pageUrl,siteId:this.siteId},t.next=4,v(e,"",a,(function(t){if(void 0!==t.avg){var e=t.avg/1e3;e>r.displayMaxValue&&(r.displayMaxValue=e),e=100*e/r.displayMaxValue;var a=r.triBlend.colorFromPercentage(e);r.chartOptions=g(g({},r.chartOptions),{colors:[a],plotOptions:{radialBar:{dataLabels:{value:{color:a}}}}}),r.series=[e]}}));case 4:case"end":return t.stop()}}),t,this)}))),function(){return m.apply(this,arguments)}),onChangeRange:function(t){this.displayStart=t.start,this.displayEnd=t.end,this.getSeriesData()}},created:function(){this.getSeriesData()},mounted:function(){var t=this;void 0!==this.$events&&this.$events.$on("change-range",(function(e){return t.onChangeRange(e)}))},data:function(){var t=this;return{chartOptions:{chart:{id:"vuechart-dashboard-radial-bar",fontFamily:"inherit",toolbar:{show:!1}},states:{hover:{filter:{type:"none",value:0}}},colors:["#000000"],plotOptions:{radialBar:{startAngle:-135,endAngle:135,hollow:{size:"65%"},track:{background:"#dae1e7",strokeWidth:"97%",margin:5,shadow:{enabled:!0,top:2,left:0,color:"#999",opacity:1,blur:2}},dataLabels:{name:{show:!1,fontSize:"16px",color:"#333",offsetY:100},value:{offsetY:6,fontSize:"18px",color:"#333",style:{cssClass:"apexcharts-datalabel-value"},formatter:function(e){return e=e*t.displayMaxValue/100,Number(e).toFixed(2)+"s"}}}}},labels:[this.title],title:{text:this.title,offsetY:20,align:"center",style:{color:"#606f7b",fontSize:"15px",cssClass:"apexcharts-title-text"}},stroke:{width:1,lineCap:"round"}},series:[0],displayStart:this.start,displayEnd:this.end,displayMaxValue:this.maxValue,triBlend:new h.Z(this.fastColor,this.averageColor,this.slowColor)}}},b=a(1900),S=(0,b.Z)(y,(function(){var t=this,e=t.$createElement;return(t._self._c||e)("apexcharts",{attrs:{width:"100%",height:"180px",type:"radialBar",options:t.chartOptions,series:t.series}})}),[],!1,null,null,null).exports,x=function(t,e,a,r){t.get(e,{params:a}).then((function(t){r&&r(t.data)})).catch((function(t){console.log(t)}))},C={components:{},props:{title:String,start:String,end:String,column:String,pageUrl:{type:String,default:""},fastColor:{type:String,default:"#00C800"},averageColor:{type:String,default:"#FFFF00"},slowColor:{type:String,default:"#C80000"},maxValue:Number,siteId:{type:Number,default:0},apiUrl:{type:String,default:""}},methods:{getSeriesData:function(){var t=o()(s().mark((function t(){var e,a,r=this;return s().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return e=c().create({baseURL:this.apiUrl,headers:{"X-Requested-With":"XMLHttpRequest"}}),a={column:this.column,start:this.displayStart,end:this.displayEnd,pageUrl:this.pageUrl,siteId:this.siteId},t.next=4,x(e,"",a,(function(t){if(void 0!==t.avg){var e=t.avg/1e3;e>r.displayMaxValue&&(r.displayMaxValue=e),e=100*e/r.displayMaxValue,r.barColor=r.triBlend.colorFromPercentage(e),r.series=[e]}}));case 4:case"end":return t.stop()}}),t,this)})));return function(){return t.apply(this,arguments)}}(),onChangeRange:function(t){this.displayStart=t.start,this.displayEnd=t.end,this.getSeriesData()},statFormatter:function(t){return t=t*this.displayMaxValue/100,Number(t).toFixed(2)+"s"}},created:function(){this.getSeriesData()},mounted:function(){var t=this;void 0!==this.$events&&this.$events.$on("change-range",(function(e){return t.onChangeRange(e)}))},data:function(){return{barColor:"#000",series:[0],displayStart:this.start,displayEnd:this.end,displayMaxValue:this.maxValue,triBlend:new h.Z(this.fastColor,this.averageColor,this.slowColor)}}},w=(0,b.Z)(C,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"simple-bar-chart-wrapper px-3 py-1"},[a("div",{staticClass:"clearafter py-1"},[a("div",{staticClass:"simple-bar-chart-label text-sm font-bold text-gray-600"},[t._v(t._s(t.title))]),t._v(" "),a("div",{staticClass:"simple-bar-chart-value text-sm font-bold text-gray-600"},[t._v(t._s(t.statFormatter(t.series[0])))])]),t._v(" "),a("div",{staticClass:"py-1"},[a("div",{staticClass:"simple-bar-chart-track rounded-full bg-gray-300"},[a("div",{staticClass:"simple-bar-line h-1 rounded-full",style:{width:t.series[0]+"%",backgroundColor:t.barColor}})])])])}),[],!1,null,null,null).exports,_=(a(1539),a(4916),a(9714),a(5306),function(t,e,a,r){t.get(e,{params:a}).then((function(t){r&&r(t.data)})).catch((function(t){console.log(t)}))}),O={components:{},props:{start:String,end:String,column:String,displayDevModeWarning:{type:Boolean,default:!1},pageUrl:{type:String,default:""},subject:{type:String,default:""},siteId:{type:Number,default:0},apiUrl:{type:String,default:""}},methods:{getSeriesData:function(){var t=o()(s().mark((function t(){var e,a,r=this;return s().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return e=c().create({baseURL:this.apiUrl,headers:{"X-Requested-With":"XMLHttpRequest"}}),a={column:this.column,start:this.displayStart,end:this.displayEnd,pageUrl:this.pageUrl,siteId:this.siteId},t.next=4,_(e,"",a,(function(t){void 0!==t.cnt&&(r.samples=t.cnt)}));case 4:case"end":return t.stop()}}),t,this)})));return function(){return t.apply(this,arguments)}}(),onChangeRange:function(t){this.displayStart=t.start,this.displayEnd=t.end,this.getSeriesData()},formatNumber:function(t){return t.toString().replace(/\B(?=(\d{3})+(?!\d))/g,",")}},created:function(){this.getSeriesData()},mounted:function(){var t=this;void 0!==this.$events&&this.$events.$on("change-range",(function(e){return t.onChangeRange(e)}))},data:function(){return{samples:0,displayEnd:this.end,displayMaxValue:this.maxValue}}},U=(0,b.Z)(O,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"field"},[t.samples>=100?a("div",{staticClass:"heading"},[a("p",{staticClass:"instructions"},[t._v("Average of "),a("strong",[t._v(t._s(t.formatNumber(t.samples)))]),t._v(" data sample"),1!==t.samples?a("span",[t._v("s")]):t._e(),t._v(".")])]):t._e(),t._v(" "),t.samples<100?a("p",{staticClass:"warning"},[t._v("Average of only "),a("strong",[t._v(t._s(t.formatNumber(t.samples)))]),t._v(" data sample"),1!==t.samples?a("span",[t._v("s")]):t._e(),t._v(".")]):t._e()])}),[],!1,null,null,null).exports;new Vue({el:"#cp-nav-content",components:{"small-radial-bar-chart":S,"small-simple-bar-chart":w,"small-sample-pane-footer":U},data:{},mounted:function(){}})}},0,[[3470,666,216,351]]]);
//# sourceMappingURL=sidebar.js.map