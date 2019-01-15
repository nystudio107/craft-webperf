/*!
 * @project        Webperf
 * @name           dashboard.js
 * @author         Andrew Welch
 * @build          Tue, Jan 15, 2019 10:20 PM ET
 * @release        c21083c73f8721f6e02548104263babf772e0087 [develop]
 * @copyright      Copyright (c) 2019 nystudio107
 *
 */!function(t){function e(e){for(var a,i,o=e[0],l=e[1],u=e[2],d=0,h=[];d<o.length;d++)i=o[d],n[i]&&h.push(n[i][0]),n[i]=0;for(a in l)Object.prototype.hasOwnProperty.call(l,a)&&(t[a]=l[a]);for(c&&c(e);h.length;)h.shift()();return s.push.apply(s,u||[]),r()}function r(){for(var t,e=0;e<s.length;e++){for(var r=s[e],a=!0,o=1;o<r.length;o++){var l=r[o];0!==n[l]&&(a=!1)}a&&(s.splice(e--,1),t=i(i.s=r[0]))}return t}var a={},n={0:0},s=[];function i(e){if(a[e])return a[e].exports;var r=a[e]={i:e,l:!1,exports:{}};return t[e].call(r.exports,r,r.exports,i),r.l=!0,r.exports}i.m=t,i.c=a,i.d=function(t,e,r){i.o(t,e)||Object.defineProperty(t,e,{enumerable:!0,get:r})},i.r=function(t){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})},i.t=function(t,e){if(1&e&&(t=i(t)),8&e)return t;if(4&e&&"object"==typeof t&&t&&t.__esModule)return t;var r=Object.create(null);if(i.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:t}),2&e&&"string"!=typeof t)for(var a in t)i.d(r,a,function(e){return t[e]}.bind(null,a));return r},i.n=function(t){var e=t&&t.__esModule?function(){return t.default}:function(){return t};return i.d(e,"a",e),e},i.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},i.p="";var o=window.webpackJsonp=window.webpackJsonp||[],l=o.push.bind(o);o.push=e,o=o.slice();for(var u=0;u<o.length;u++)e(o[u]);var c=l;s.push([118,2]),r()}({118:function(t,e,r){"use strict";r.r(e);var a=r(17),n=r.n(a),s=r(58),i=r.n(s),o=function(){var t=this.$createElement;return(this._self._c||t)("main")};o._withStripped=!0;var l=r(59),u=r.n(l);n.a.use(u.a);var c={mounted:function(){var t=this;this.$confetti.start({shape:"rect",colors:["DodgerBlue","OliveDrab","Gold","pink","SlateBlue","lightblue","Violet","PaleGreen","SteelBlue","SandyBrown","Chocolate","Crimson"]}),setTimeout(function(){t.$confetti.stop()},5e3)},methods:{}},d=r(5),h=Object(d.a)(c,o,[],!1,null,null,null);h.options.__file="src/assetbundles/webperf/src/vue/Confetti.vue";var f=h.exports,p=function(){var t=this.$createElement;return(this._self._c||t)("apexcharts",{attrs:{width:"100%",height:"300px",type:"radialBar",options:this.chartOptions,series:this.series}})};p._withStripped=!0;r(22),r(45),r(33),r(34);var v=r(12),b=r.n(v),m=r(60),g=r.n(m);r(106);function y(t,e){for(var r=0;r<e.length;r++){var a=e[r];a.enumerable=a.enumerable||!1,a.configurable=!0,"value"in a&&(a.writable=!0),Object.defineProperty(t,a.key,a)}}var x=function(){function t(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{r:0,g:200,b:0},r=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{r:255,g:255,b:0},a=arguments.length>2&&void 0!==arguments[2]?arguments[2]:{r:200,g:0,b:0};!function(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}(this,t),this.clr1=e,this.clr2=r,this.clr3=a}var e,r,a;return e=t,(r=[{key:"RGBToHex",value:function(t,e,r){var a;return a=(t<<16|e<<8|r).toString(16).toUpperCase(),new Array(7-a.length).join("0")+a}},{key:"colorFromPercentage",value:function(t){var e=this.clr1,r=this.clr2;t>=50&&(e=this.clr2,r=this.clr3,t-=50);var a=t/50,n=Math.round(e.r+a*(r.r-e.r)),s=Math.round(e.g+a*(r.g-e.g)),i=Math.round(e.b+a*(r.b-e.b));return"#"+this.RGBToHex(n,s,i)}}])&&y(e.prototype,r),a&&y(e,a),t}();function w(t,e,r,a,n,s,i){try{var o=t[s](i),l=o.value}catch(t){return void r(t)}o.done?e(l):Promise.resolve(l).then(a,n)}var _=function(t,e,r){t.get(e).then(function(t){r&&r(t.data)}).catch(function(t){console.log(t)})},C={components:{apexcharts:g.a},props:{title:String,days:{type:Number,default:30},column:String,maxValue:Number,siteId:{type:Number,default:0}},methods:{getSeriesData:function(){var t,e=(t=regeneratorRuntime.mark(function t(){var e,r,a=this;return regeneratorRuntime.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return e=b.a.create({baseURL:"/webperf/charts/dashboard-stats-average/",headers:{"X-Requested-With":"XMLHttpRequest"}}),r=this.displayDays+"/"+this.column,0!==this.siteId&&(r+="/"+this.siteId),t.next=5,_(e,r,function(t){var e=Object.assign({},a.chartOptions);if(void 0!==t[0]){var r=t[0]/1e3;r>a.displayMaxValue&&(a.displayMaxValue=r),r=100*r/a.displayMaxValue;var n=a.triBlend.colorFromPercentage(r);e.colors=[n],e.plotOptions.radialBar.dataLabels.value.color=n,a.chartOptions=e,a.series=[r]}});case 5:case"end":return t.stop()}},t,this)}),function(){var e=this,r=arguments;return new Promise(function(a,n){var s=t.apply(e,r);function i(t){w(s,a,n,i,o,"next",t)}function o(t){w(s,a,n,i,o,"throw",t)}i(void 0)})});return function(){return e.apply(this,arguments)}}(),onChangeRange:function(t){this.displayDays=t,this.getSeriesData()}},created:function(){this.getSeriesData()},mounted:function(){var t=this;this.$events.$on("change-range",function(e){return t.onChangeRange(e)}),setInterval(function(){},3e3)},data:function(){var t=this;return{chartOptions:{chart:{id:"vuechart-dashboard-radial-bar",fontFamily:"inherit",toolbar:{show:!1}},states:{hover:{filter:{type:"none",value:0}}},colors:["#000000"],plotOptions:{radialBar:{startAngle:-135,endAngle:135,hollow:{size:"65%"},track:{background:"#f1f5f8",strokeWidth:"97%",margin:5,shadow:{enabled:!0,top:2,left:0,color:"#999",opacity:1,blur:2}},dataLabels:{name:{show:!1,fontSize:"16px",color:"#333",offsetY:100},value:{offsetY:10,fontSize:"40px",color:"#333",style:{cssClass:"apexcharts-datalabel-value"},formatter:function(e){return e=e*t.displayMaxValue/100,Number(e).toFixed(2)+"s"}}}}},labels:[this.title],title:{text:this.title,offsetY:18,align:"center",style:{fontSize:"16px",cssClass:"apexcharts-title-text"}},stroke:{width:1,lineCap:"round"}},series:[0],displayDays:this.days,displayMaxValue:this.maxValue,triBlend:new x}}},S=Object(d.a)(C,p,[],!1,null,null,null);S.options.__file="src/assetbundles/webperf/src/vue/DashboardRadialBarChart.vue";var O=S.exports,R=function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",{staticClass:"simple-bar-chart-wrapper px-5 py-3"},[r("div",{staticClass:"clearafter py-2"},[r("div",{staticClass:"simple-bar-chart-label text-base font-bold"},[t._v(t._s(t.title))]),t._v(" "),r("div",{staticClass:"simple-bar-chart-value text-base font-bold"},[t._v(t._s(t.statFormatter(t.series[0])))])]),t._v(" "),r("div",{staticClass:"py-2"},[r("div",{staticClass:"simple-bar-chart-track rounded-full bg-grey-lighter"},[r("div",{staticClass:"simple-bar-line h-3 rounded-full",style:{width:t.series[0]+"%",backgroundColor:t.barColor}})])])])};function D(t,e,r,a,n,s,i){try{var o=t[s](i),l=o.value}catch(t){return void r(t)}o.done?e(l):Promise.resolve(l).then(a,n)}R._withStripped=!0;var M=function(t,e,r){t.get(e).then(function(t){r&&r(t.data)}).catch(function(t){console.log(t)})},V={components:{},props:{title:String,days:{type:Number,default:30},column:String,maxValue:Number,siteId:{type:Number,default:0}},methods:{getSeriesData:function(){var t,e=(t=regeneratorRuntime.mark(function t(){var e,r,a=this;return regeneratorRuntime.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return e=b.a.create({baseURL:"/webperf/charts/dashboard-stats-average/",headers:{"X-Requested-With":"XMLHttpRequest"}}),r=this.displayDays+"/"+this.column,0!==this.siteId&&(r+="/"+this.siteId),t.next=5,M(e,r,function(t){Object.assign({},a.chartOptions);if(void 0!==t[0]){var e=t[0]/1e3;e>a.displayMaxValue&&(a.displayMaxValue=e),e=100*e/a.displayMaxValue,a.barColor=a.triBlend.colorFromPercentage(e),a.series=[e]}});case 5:case"end":return t.stop()}},t,this)}),function(){var e=this,r=arguments;return new Promise(function(a,n){var s=t.apply(e,r);function i(t){D(s,a,n,i,o,"next",t)}function o(t){D(s,a,n,i,o,"throw",t)}i(void 0)})});return function(){return e.apply(this,arguments)}}(),onChangeRange:function(t){this.displayDays=t,this.getSeriesData()},statFormatter:function(t){return t=t*this.displayMaxValue/100,Number(t).toFixed(2)+"s"}},created:function(){this.getSeriesData()},mounted:function(){var t=this;this.$events.$on("change-range",function(e){return t.onChangeRange(e)}),setInterval(function(){},3e3)},data:function(){return{triBlend:new x,barColor:"#000",series:[0],displayDays:this.days,displayMaxValue:this.maxValue}}},P=Object(d.a)(V,R,[],!1,null,null,null);P.options.__file="src/assetbundles/webperf/src/vue/DashboardSimpleBarChart.vue";var k=P.exports,B=function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("section",{staticClass:"px-3 py-3"},[r("div",{staticClass:"text-left text-base font-bold px-2 pt-2"},[t._v("\n        Slowest pages\n    ")]),t._v(" "),t._l(t.series,function(e){return r("div",{staticClass:"file-list-wrapper p-2"},[r("div",{staticClass:"text-base font-normal truncate-label",staticStyle:{color:"rgb(26, 13, 171)",width:"99%"}},[t._v(t._s(e.title))]),t._v(" "),r("div",{staticClass:"clearafter pb-1"},[r("cite",{staticClass:"simple-bar-chart-label text-sm font-normal truncate-label",staticStyle:{color:"rgb(0, 102, 33)",width:"80%"}},[t._v(t._s(e.url))]),t._v(" "),r("div",{staticClass:"simple-bar-chart-value text-sm font-bold"},[t._v(t._s(t.statFormatter(e.data,e.maxValue)))])]),t._v(" "),r("div",{staticClass:"py-1"},[r("div",{staticClass:"file-list-chart-track rounded-full bg-grey-lighter"},[r("div",{staticClass:"simple-bar-line h-2 rounded-full",style:{width:e.data+"%",backgroundColor:e.barColor}})])])])})],2)};B._withStripped=!0;r(108);function j(t,e,r,a,n,s,i){try{var o=t[s](i),l=o.value}catch(t){return void r(t)}o.done?e(l):Promise.resolve(l).then(a,n)}var F=function(t,e,r){t.get(e).then(function(t){r&&r(t.data)}).catch(function(t){console.log(t)})},N={components:{},props:{days:{type:Number,default:30},column:String,limit:{type:Number,default:3},maxValue:Number,siteId:{type:Number,default:0}},methods:{getSeriesData:function(){var t,e=(t=regeneratorRuntime.mark(function t(){var e,r,a=this;return regeneratorRuntime.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return e=b.a.create({baseURL:"/webperf/charts/dashboard-slowest-pages/",headers:{"X-Requested-With":"XMLHttpRequest"}}),r=this.displayDays+"/"+this.column+"/"+this.limit,0!==this.siteId&&(r+="/"+this.siteId),t.next=5,F(e,r,function(t){console.log(t),t.forEach(function(t,e,r){var n=t.avg/1e3,s=a.maxValue;n>s&&(s=n),n=100*n/s,r[e].data=n,r[e].maxValue=s,r[e].barColor=a.triBlend.colorFromPercentage(n)}),a.series=t});case 5:case"end":return t.stop()}},t,this)}),function(){var e=this,r=arguments;return new Promise(function(a,n){var s=t.apply(e,r);function i(t){j(s,a,n,i,o,"next",t)}function o(t){j(s,a,n,i,o,"throw",t)}i(void 0)})});return function(){return e.apply(this,arguments)}}(),onChangeRange:function(t){this.displayDays=days,this.getSeriesData()},statFormatter:function(t,e){return t=t*e/100,Number(t).toFixed(2)+"s"}},created:function(){this.getSeriesData()},mounted:function(){var t=this;this.$events.$on("change-range",function(e){return t.onChangeRange(e)}),setInterval(function(){},3e3)},data:function(){return{series:[],displayDays:this.days,triBlend:new x}}},I=Object(d.a)(N,B,[],!1,null,null,null);I.options.__file="src/assetbundles/webperf/src/vue/DashboardFileList.vue";var $=I.exports;n.a.use(i.a);new n.a({el:"#cp-nav-content",components:{confetti:f,"dashboard-radial-bar-chart":O,"dashboard-simple-bar-chart":k,"dashboard-file-list":$},data:{},mounted:function(){setTimeout(function(){},5e3)}})}});
//# sourceMappingURL=dashboard.js.map