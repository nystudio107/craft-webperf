/*!
 * @project        Webperf
 * @name           dashboard.js
 * @author         Andrew Welch
 * @build          Mon, Jan 7, 2019 4:54 AM ET
 * @release        e888f9861ad1029ed1ed1d79fefd4a05f960c0a8 [develop]
 * @copyright      Copyright (c) 2019 nystudio107
 *
 */!function(e){function t(t){for(var n,i,s=t[0],u=t[1],l=t[2],f=0,h=[];f<s.length;f++)i=s[f],a[i]&&h.push(a[i][0]),a[i]=0;for(n in u)Object.prototype.hasOwnProperty.call(u,n)&&(e[n]=u[n]);for(c&&c(t);h.length;)h.shift()();return o.push.apply(o,l||[]),r()}function r(){for(var e,t=0;t<o.length;t++){for(var r=o[t],n=!0,s=1;s<r.length;s++){var u=r[s];0!==a[u]&&(n=!1)}n&&(o.splice(t--,1),e=i(i.s=r[0]))}return e}var n={},a={0:0},o=[];function i(t){if(n[t])return n[t].exports;var r=n[t]={i:t,l:!1,exports:{}};return e[t].call(r.exports,r,r.exports,i),r.l=!0,r.exports}i.m=e,i.c=n,i.d=function(e,t,r){i.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:r})},i.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},i.t=function(e,t){if(1&t&&(e=i(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var r=Object.create(null);if(i.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var n in e)i.d(r,n,function(t){return e[t]}.bind(null,n));return r},i.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return i.d(t,"a",t),t},i.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},i.p="";var s=window.webpackJsonp=window.webpackJsonp||[],u=s.push.bind(s);s.push=t,s=s.slice();for(var l=0;l<s.length;l++)t(s[l]);var c=u;o.push([111,2]),r()}({111:function(e,t,r){"use strict";r.r(t);var n=r(12),a=r.n(n),o=r(50),i=r.n(o),s=function(){var e=this.$createElement;return(this._self._c||e)("main")};s._withStripped=!0;var u=r(51),l=r.n(u);a.a.use(l.a);var c={mounted:function(){var e=this;this.$confetti.start({shape:"rect",colors:["DodgerBlue","OliveDrab","Gold","pink","SlateBlue","lightblue","Violet","PaleGreen","SteelBlue","SandyBrown","Chocolate","Crimson"]}),setTimeout(function(){e.$confetti.stop()},5e3)},methods:{}},f=r(16),h=Object(f.a)(c,s,[],!1,null,null,null);h.options.__file="src/assetbundles/webperf/src/vue/Confetti.vue";var p=h.exports,d=function(){var e=this.$createElement;return(this._self._c||e)("apexcharts",{attrs:{width:"100%",height:"300px",type:"radialBar",options:this.chartOptions,series:this.series}})};d._withStripped=!0;r(56),r(72),r(78),r(79),r(87);var v=r(52),b=r.n(v),g=r(53);function m(e,t,r,n,a,o,i){try{var s=e[o](i),u=s.value}catch(e){return void r(e)}s.done?t(u):Promise.resolve(u).then(n,a)}var y={r:0,g:200,b:0},w={r:255,g:255,b:0},x={r:200,g:0,b:0},S=function(e,t,r){e.get(t).then(function(e){r&&r(e.data)}).catch(function(e){console.log(e)})},O={components:{apexcharts:r.n(g).a},props:{title:String,range:String,column:String,maxValue:Number,siteId:{type:Number,default:0}},methods:{getSeriesData:function(){var e,t=(e=regeneratorRuntime.mark(function e(){var t,r,n=this;return regeneratorRuntime.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return t=b.a.create({baseURL:"/webperf/charts/dashboard-radial-bar/",headers:{"X-Requested-With":"XMLHttpRequest"}}),r=this.displayRange+"/"+this.column,0!==this.siteId&&(r+="/"+this.siteId),e.next=5,S(t,r,function(e){var t=Object.assign({},n.chartOptions);if(void 0!==e[0]){var r=e[0]/1e3;r>n.maxValue&&(n.maxValue=Math.round(r)),r=100*r/n.maxValue;var a=n.colorFromPercentage(r);t.colors=[a],n.chartOptions=t,n.series=[r]}});case 5:case"end":return e.stop()}},e,this)}),function(){var t=this,r=arguments;return new Promise(function(n,a){var o=e.apply(t,r);function i(e){m(o,n,a,i,s,"next",e)}function s(e){m(o,n,a,i,s,"throw",e)}i(void 0)})});return function(){return t.apply(this,arguments)}}(),onChangeRange:function(e){this.displayRange=e,this.getSeriesData()},colorFromPercentage:function(e){var t=y,r=w;e>=50&&(t=w,r=x,e-=50);var n=e/50;return"#"+function(e,t,r){var n;return n=(e<<16|t<<8|r).toString(16).toUpperCase(),new Array(7-n.length).join("0")+n}(Math.round(t.r+n*(r.r-t.r)),Math.round(t.g+n*(r.g-t.g)),Math.round(t.b+n*(r.b-t.b)))}},created:function(){this.getSeriesData()},mounted:function(){var e=this;this.$events.$on("change-range",function(t){return e.onChangeRange(t)}),setInterval(function(){},3e3)},data:function(){var e=this;return{chartOptions:{chart:{id:"vuechart-dashboard-radial-bar",toolbar:{show:!1}},colors:["#000000"],plotOptions:{radialBar:{startAngle:-135,endAngle:135,hollow:{size:"65%"},track:{background:"#e7e7e7",strokeWidth:"97%",margin:5,shadow:{enabled:!0,top:2,left:0,color:"#999",opacity:1,blur:2}},dataLabels:{name:{show:!1,fontSize:"16px",color:"#333",offsetY:100},value:{offsetY:10,fontSize:"40px",color:"#333",style:{cssClass:"apexcharts-datalabel-value"},formatter:function(t){return t=t*e.maxValue/100,Number(t).toFixed(2)+"s"}}}}},labels:[this.title],title:{text:this.title,offsetX:10,offsetY:20,style:{fontSize:"18px",cssClass:"apexcharts-title-text"}},stroke:{width:1,lineCap:"round"}},series:[0],displayRange:this.range}}},_=Object(f.a)(O,d,[],!1,null,null,null);_.options.__file="src/assetbundles/webperf/src/vue/DashboardRadialBarChart.vue";var j=_.exports;a.a.use(i.a);new a.a({el:"#cp-nav-content",components:{confetti:p,"dashboard-radial-bar-chart":j},data:{},mounted:function(){setTimeout(function(){},5e3)}})}});
//# sourceMappingURL=dashboard.js.map