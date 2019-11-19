/*!
 * @project        Webperf
 * @name           dashboard.js
 * @author         Andrew Welch
 * @build          Tue, Nov 19, 2019 8:28 PM ET
 * @release        7793e440bc01b6cb1cfe3d702ed8ef77e20dbb35 [develop]
 * @copyright      Copyright (c) 2019 nystudio107
 *
 */!function(t){function e(e){for(var n,i,l=e[0],o=e[1],c=e[2],d=0,p=[];d<l.length;d++)i=l[d],Object.prototype.hasOwnProperty.call(r,i)&&r[i]&&p.push(r[i][0]),r[i]=0;for(n in o)Object.prototype.hasOwnProperty.call(o,n)&&(t[n]=o[n]);for(u&&u(e);p.length;)p.shift()();return s.push.apply(s,c||[]),a()}function a(){for(var t,e=0;e<s.length;e++){for(var a=s[e],n=!0,l=1;l<a.length;l++){var o=a[l];0!==r[o]&&(n=!1)}n&&(s.splice(e--,1),t=i(i.s=a[0]))}return t}var n={},r={2:0},s=[];function i(e){if(n[e])return n[e].exports;var a=n[e]={i:e,l:!1,exports:{}};return t[e].call(a.exports,a,a.exports,i),a.l=!0,a.exports}i.m=t,i.c=n,i.d=function(t,e,a){i.o(t,e)||Object.defineProperty(t,e,{enumerable:!0,get:a})},i.r=function(t){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})},i.t=function(t,e){if(1&e&&(t=i(t)),8&e)return t;if(4&e&&"object"==typeof t&&t&&t.__esModule)return t;var a=Object.create(null);if(i.r(a),Object.defineProperty(a,"default",{enumerable:!0,value:t}),2&e&&"string"!=typeof t)for(var n in t)i.d(a,n,function(e){return t[e]}.bind(null,n));return a},i.n=function(t){var e=t&&t.__esModule?function(){return t.default}:function(){return t};return i.d(e,"a",e),e},i.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},i.p="";var l=window.webpackJsonp=window.webpackJsonp||[],o=l.push.bind(l);l.push=e,l=l.slice();for(var c=0;c<l.length;c++)e(l[c]);var u=o;s.push([94,0]),a()}({20:function(t,e,a){"use strict";var n=function(){var t=this.$createElement;return(this._self._c||t)("apexcharts",{attrs:{width:"100%",height:"300px",type:"radialBar",options:this.chartOptions,series:this.series}})};n._withStripped=!0;var r=a(1),s=a.n(r),i=a(5),l=a.n(i),o=a(2),c=a.n(o),u=a(6),d=a.n(u),p=a(4);function h(t,e){var a=Object.keys(t);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(t);e&&(n=n.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),a.push.apply(a,n)}return a}function f(t){for(var e=1;e<arguments.length;e++){var a=null!=arguments[e]?arguments[e]:{};e%2?h(a,!0).forEach((function(e){l()(t,e,a[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(a)):h(a).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(a,e))}))}return t}var g=function(t,e,a,n){t.get(e,{params:a}).then((function(t){n&&n(t.data)})).catch((function(t){console.log(t)}))},v={components:{apexcharts:d.a},props:{title:String,start:String,end:String,column:String,pageUrl:{type:String,default:""},fastColor:{type:String,default:"#00C800"},averageColor:{type:String,default:"#FFFF00"},slowColor:{type:String,default:"#C80000"},maxValue:Number,siteId:{type:Number,default:0},apiUrl:{type:String,default:""}},methods:{getSeriesData:function(){var t,e,a=this;return s.a.async((function(n){for(;;)switch(n.prev=n.next){case 0:return t=c.a.create({baseURL:this.apiUrl,headers:{"X-Requested-With":"XMLHttpRequest"}}),e={column:this.column,start:this.displayStart,end:this.displayEnd,pageUrl:this.pageUrl,siteId:this.siteId},n.next=4,s.a.awrap(g(t,"",e,(function(t){if(void 0!==t.avg){var e=t.avg/1e3;e>a.displayMaxValue&&(a.displayMaxValue=e),e=100*e/a.displayMaxValue;var n=a.triBlend.colorFromPercentage(e);a.chartOptions=f({},a.chartOptions,{},{colors:[n],plotOptions:{radialBar:{dataLabels:{value:{color:n}}}}}),a.series=[e]}})));case 4:case"end":return n.stop()}}),null,this)},onChangeRange:function(t){this.displayStart=t.start,this.displayEnd=t.end,this.getSeriesData()}},created:function(){this.getSeriesData()},mounted:function(){var t=this;void 0!==this.$events&&this.$events.$on("change-range",(function(e){return t.onChangeRange(e)}))},data:function(){var t=this;return{chartOptions:{chart:{id:"vuechart-dashboard-radial-bar",fontFamily:"inherit",toolbar:{show:!1}},states:{hover:{filter:{type:"none",value:0}}},colors:["#000000"],plotOptions:{radialBar:{startAngle:-135,endAngle:135,hollow:{size:"65%"},track:{background:"#f1f5f8",strokeWidth:"97%",margin:5,shadow:{enabled:!0,top:2,left:0,color:"#999",opacity:1,blur:2}},dataLabels:{name:{show:!1,fontSize:"16px",color:"#333",offsetY:100},value:{offsetY:10,fontSize:"40px",color:"#333",style:{cssClass:"apexcharts-datalabel-value"},formatter:function(e){return e=e*t.displayMaxValue/100,Number(e).toFixed(2)+"s"}}}}},labels:[this.title],title:{text:this.title,offsetY:18,align:"center",style:{fontSize:"16px",cssClass:"apexcharts-title-text"}},stroke:{width:1,lineCap:"round"}},series:[0],displayStart:this.start,displayEnd:this.end,displayMaxValue:this.maxValue,triBlend:new p.a(this.fastColor,this.averageColor,this.slowColor)}}},m=a(0),b=Object(m.a)(v,n,[],!1,null,null,null);b.options.__file="src/assetbundles/webperf/src/vue/charts/common/RadialBarChart.vue";e.a=b.exports},21:function(t,e,a){"use strict";var n=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"simple-bar-chart-wrapper px-5 py-3"},[a("div",{staticClass:"clearafter py-2"},[a("div",{staticClass:"simple-bar-chart-label text-base font-bold"},[t._v(t._s(t.title))]),t._v(" "),a("div",{staticClass:"simple-bar-chart-value text-base font-bold"},[t._v(t._s(t.statFormatter(t.series[0])))])]),t._v(" "),a("div",{staticClass:"py-2"},[a("div",{staticClass:"simple-bar-chart-track rounded-full bg-gray-200"},[a("div",{staticClass:"simple-bar-line h-3 rounded-full",style:{width:t.series[0]+"%",backgroundColor:t.barColor}})])])])};n._withStripped=!0;var r=a(1),s=a.n(r),i=a(2),l=a.n(i),o=a(4),c=function(t,e,a,n){t.get(e,{params:a}).then((function(t){n&&n(t.data)})).catch((function(t){console.log(t)}))},u={components:{},props:{title:String,start:String,end:String,column:String,pageUrl:{type:String,default:""},fastColor:{type:String,default:"#00C800"},averageColor:{type:String,default:"#FFFF00"},slowColor:{type:String,default:"#C80000"},maxValue:Number,siteId:{type:Number,default:0},apiUrl:{type:String,default:""}},methods:{getSeriesData:function(){var t,e,a=this;return s.a.async((function(n){for(;;)switch(n.prev=n.next){case 0:return t=l.a.create({baseURL:this.apiUrl,headers:{"X-Requested-With":"XMLHttpRequest"}}),e={column:this.column,start:this.displayStart,end:this.displayEnd,pageUrl:this.pageUrl,siteId:this.siteId},n.next=4,s.a.awrap(c(t,"",e,(function(t){if(void 0!==t.avg){var e=t.avg/1e3;e>a.displayMaxValue&&(a.displayMaxValue=e),e=100*e/a.displayMaxValue,a.barColor=a.triBlend.colorFromPercentage(e),a.series=[e]}})));case 4:case"end":return n.stop()}}),null,this)},onChangeRange:function(t){this.displayStart=t.start,this.displayEnd=t.end,this.getSeriesData()},statFormatter:function(t){return t=t*this.displayMaxValue/100,Number(t).toFixed(2)+"s"}},created:function(){this.getSeriesData()},mounted:function(){var t=this;void 0!==this.$events&&this.$events.$on("change-range",(function(e){return t.onChangeRange(e)}))},data:function(){return{barColor:"#000",series:[0],displayStart:this.start,displayEnd:this.end,displayMaxValue:this.maxValue,triBlend:new o.a(this.fastColor,this.averageColor,this.slowColor)}}},d=a(0),p=Object(d.a)(u,n,[],!1,null,null,null);p.options.__file="src/assetbundles/webperf/src/vue/charts/common/SimpleBarChart.vue";e.a=p.exports},23:function(t,e,a){"use strict";var n=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[t.series.length?t._e():a("div",{staticClass:"text-3xl text-center py-10"},[t._v("\n        🎉 No recommendations found. Nice job!\n    ")]),t._v(" "),t._l(t.series,(function(e){return a("div",[a("div",{staticClass:"field pb-4"},[a("p",{staticClass:"warning text-2xl leading-normal"},[a("span",{domProps:{innerHTML:t._s(e.summary)}})]),t._v(" "),a("div",{staticClass:"heading",staticStyle:{"padding-left":"26px"}},[a("p",{staticClass:"instructions text-xl leading-tight"},[a("span",{domProps:{innerHTML:t._s(e.detail)}}),t._v(" "),a("span",{staticClass:"field inline-block m-0"},[""!==e.learnMoreUrl?a("a",{staticClass:"go notice",attrs:{href:e.learnMoreUrl,target:"_blank",rel:"noopener,nofollow"}},[t._v("Learn More")]):t._e()])])])])])})),t._v(" "),a("sample-pane-footer",{attrs:{start:"start",end:"end",subject:"recommendations",column:"id","page-url":t.pageUrl,"site-id":t.siteId,"display-dev-mode-warning":t.devModeWarning}})],2)};n._withStripped=!0;var r=a(1),s=a.n(r),i=a(2),l=a.n(i),o=a(7),c=function(t,e,a,n){t.get(e,{params:a}).then((function(t){n&&n(t.data)})).catch((function(t){console.log(t)}))},u={components:{"sample-pane-footer":o.a},props:{start:String,end:String,devModeWarning:{type:Boolean,default:!1},pageUrl:{type:String,default:""},siteId:{type:Number,default:0},apiUrl:{type:String,default:""}},methods:{getSeriesData:function(){var t,e,a=this;return s.a.async((function(n){for(;;)switch(n.prev=n.next){case 0:return t=l.a.create({baseURL:this.apiUrl,headers:{"X-Requested-With":"XMLHttpRequest"}}),e={start:this.displayStart,end:this.displayEnd,pageUrl:this.pageUrl,siteId:this.siteId},n.next=4,s.a.awrap(c(t,"",e,(function(t){void 0!==t[0]&&(a.series=t)})));case 4:case"end":return n.stop()}}),null,this)},onChangeRange:function(t){this.displayStart=t.start,this.displayEnd=t.end,this.getSeriesData()}},created:function(){this.getSeriesData()},mounted:function(){var t=this;this.$events.$on("change-range",(function(e){return t.onChangeRange(e)}))},data:function(){return{series:[],displayStart:this.start,displayEnd:this.end}}},d=a(0),p=Object(d.a)(u,n,[],!1,null,null,null);p.options.__file="src/assetbundles/webperf/src/vue/common/RecommendationsList.vue";e.a=p.exports},28:function(t,e,a){"use strict";var n=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"field webperf-tooltip text-sm font-normal inline-block"},[t.sample<100?a("p",{staticClass:"warning display-block"},[t._v(" ")]):t._e(),t._v(" "),a("span",{staticClass:"webperf-tooltiptext webperf-sample-tooltip"},[t._v("\n        Only "+t._s(t.sample)+" data sample"),1!==t.sample?a("span",[t._v("s")]):t._e(),t._v(".\n    ")])])};n._withStripped=!0;var r={name:"sample-size-warning",props:{sample:Number}},s=a(0),i=Object(s.a)(r,n,[],!1,null,null,null);i.options.__file="src/assetbundles/webperf/src/vue/common/SampleSizeWarning.vue";e.a=i.exports},4:function(t,e,a){"use strict";a.d(e,"a",(function(){return l}));var n=a(16),r=a.n(n),s=a(17),i=a.n(s),l=function(){function t(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"#00C800",a=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"#FFFF00",n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:"#C80000";r()(this,t),this.clr1=this.HexToRGB(e),this.clr2=this.HexToRGB(a),this.clr3=this.HexToRGB(n)}return i()(t,[{key:"RGBToHex",value:function(t,e,a){var n;return n=(t<<16|e<<8|a).toString(16).toUpperCase(),new Array(7-n.length).join("0")+n}},{key:"HexToRGB",value:function(t){var e=/^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(t);return e?{r:parseInt(e[1],16),g:parseInt(e[2],16),b:parseInt(e[3],16)}:null}},{key:"colorFromPercentage",value:function(t){var e=this.clr1,a=this.clr2;t>=50&&(e=this.clr2,a=this.clr3,t-=50);var n=t/50,r=Math.round(e.r+n*(a.r-e.r)),s=Math.round(e.g+n*(a.g-e.g)),i=Math.round(e.b+n*(a.b-e.b));return"#"+this.RGBToHex(r,s,i)}}]),t}()},7:function(t,e,a){"use strict";var n=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"field"},[a("div",{staticClass:"heading"},[a("p",{staticClass:"instructions"},[t._v("The "+t._s(t.subject)+" data is an "),a("em",[t._v("average")]),t._v(" of "),a("strong",[t._v(t._s(t.formatNumber(t.samples)))]),t._v(" data sample"),1!==t.samples?a("span",[t._v("s")]):t._e(),t._v(".")])]),t._v(" "),t.samples<100?a("p",{staticClass:"warning"},[t._v("Webperf has collected less than "),a("strong",[t._v("100")]),t._v(" data samples. The sample size is not statistically significant, so above averaged results may not be meaningful.")]):t._e(),t._v(" "),t.displayDevModeWarning?a("p",{staticClass:"warning"},[t._v("Craft performance will be slower than normal with "),a("code",[t._v("devMode")]),t._v(" enabled due to extensive logging and disabling of some caches. "),t._m(0)]):t._e()])};n._withStripped=!0;var r=a(1),s=a.n(r),i=a(2),l=a.n(i),o=function(t,e,a,n){t.get(e,{params:a}).then((function(t){n&&n(t.data)})).catch((function(t){console.log(t)}))},c={components:{},props:{start:String,end:String,column:String,displayDevModeWarning:{type:Boolean,default:!1},pageUrl:{type:String,default:""},subject:{type:String,default:""},siteId:{type:Number,default:0},apiUrl:{type:String,default:""}},methods:{getSeriesData:function(){var t,e,a=this;return s.a.async((function(n){for(;;)switch(n.prev=n.next){case 0:return t=l.a.create({baseURL:this.apiUrl,headers:{"X-Requested-With":"XMLHttpRequest"}}),e={column:this.column,start:this.displayStart,end:this.displayEnd,pageUrl:this.pageUrl,siteId:this.siteId},n.next=4,s.a.awrap(o(t,"",e,(function(t){void 0!==t.cnt&&(a.samples=t.cnt)})));case 4:case"end":return n.stop()}}),null,this)},onChangeRange:function(t){this.displayStart=t.start,this.displayEnd=t.end,this.getSeriesData()},formatNumber:function(t){return t.toString().replace(/\B(?=(\d{3})+(?!\d))/g,",")}},created:function(){this.getSeriesData()},mounted:function(){var t=this;this.$events.$on("change-range",(function(e){return t.onChangeRange(e)}))},data:function(){return{samples:0,displayEnd:this.end,displayMaxValue:this.maxValue}}},u=a(0),d=Object(u.a)(c,n,[function(){var t=this.$createElement,e=this._self._c||t;return e("span",{staticClass:"field inline-block m-0"},[e("a",{staticClass:"notice go",attrs:{href:"https://craftcms.com/guides/what-dev-mode-does",target:"_blank"}},[this._v("Learn More")])])}],!1,null,null,null);d.options.__file="src/assetbundles/webperf/src/vue/common/SamplePaneFooter.vue";e.a=d.exports},8:function(t,e,a){"use strict";var n=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"readable inline-block"},[a("vue-ctk-date-time-picker",{attrs:{range:!0,"no-header":!0,"only-date":!0,"no-value-to-custom-elem":!0,"custom-shortcuts":t.customShortcuts,label:"Data Sample Date Range",format:"YYYY-MM-DD",formatted:"YYYY-MM-DD",color:"dimgray","no-button":!0,"auto-close":!0},on:{input:function(e){return t.onInput()}},model:{value:t.dateRange,callback:function(e){t.dateRange=e},expression:"dateRange"}},[a("button",{staticClass:"btn menubtn text-sm leading-normal text-left",staticStyle:{"min-width":"237px"},attrs:{type:"button","data-icon":"date",tabindex:"0",role:"combobox","aria-haspopup":"true","aria-expanded":"false"}},[t._v("\n            "+t._s(t.dateRange.start)+" → "+t._s(t.dateRange.end)+"\n        ")])])],1)};n._withStripped=!0;var r=a(18),s=a.n(r),i=(a(25),{name:"sample-range-picker",components:{"vue-ctk-date-time-picker":s.a},data:function(){return{dateRange:{},customShortcuts:[{label:"Today",value:"day",isSelected:!1},{label:"Yesterday",value:"-day",isSelected:!1},{label:"This Month",value:"month",isSelected:!1},{label:"Last Month",value:"-month",isSelected:!1},{label:"This Year",value:"year",isSelected:!1},{label:"Last Year",value:"-year",isSelected:!1},{label:"Last 365 days",value:365,isSelected:!0}]}},methods:{onInput:function(){this.$events.fire("change-range",this.dateRange)}}}),l=a(0),o=Object(l.a)(i,n,[],!1,null,null,null);o.options.__file="src/assetbundles/webperf/src/vue/common/SampleRangePicker.vue";e.a=o.exports},94:function(t,e,a){"use strict";a.r(e);var n=a(3),r=a.n(n),s=a(15),i=a.n(s),l=function(){var t=this.$createElement;return(this._self._c||t)("main")};l._withStripped=!0;var o=a(49),c=a.n(o);r.a.use(c.a);var u={mounted:function(){var t=this;this.$confetti.start({shape:"rect",colors:["DodgerBlue","OliveDrab","Gold","pink","SlateBlue","lightblue","Violet","PaleGreen","SteelBlue","SandyBrown","Chocolate","Crimson"]}),setTimeout((function(){t.$confetti.stop()}),5e3)},methods:{}},d=a(0),p=Object(d.a)(u,l,[],!1,null,null,null);p.options.__file="src/assetbundles/webperf/src/vue/common/Confetti.vue";var h=p.exports,f=a(20),g=a(21),v=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("section",{staticClass:"px-3 py-3"},[a("div",{staticClass:"text-left text-base font-bold px-2 pt-2"},[t._v("\n        Slowest pages\n    ")]),t._v(" "),t._l(t.series,(function(e){return a("div",{staticClass:"file-list-wrapper p-2"},[a("dashboard-file-list-cell",{attrs:{title:e.title,url:e.url,"detail-page-url":e.detailPageUrl,data:t.statFormatter(e.data,e.maxValue),cnt:e.cnt,width:e.data,color:e.barColor}})],1)}))],2)};v._withStripped=!0;var m=a(1),b=a.n(m),y=a(2),_=a.n(y),S=a(4),C=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{on:{click:function(e){return t.redirectTo(t.detailPageUrl)}}},[a("div",{staticClass:"clearafter pb-1"},[a("div",{staticClass:"simple-bar-chart-label text-base font-normal truncate-label",staticStyle:{width:"90%"},attrs:{title:t.title}},[t.title?a("a",{staticStyle:{color:"rgb(26, 13, 171)"},attrs:{href:t.url,target:"_blank"},on:{click:function(t){t.stopPropagation()}}},[t._v("\n                "+t._s(t.title)+"\n            ")]):a("span",{staticClass:"text-gray-300"},[a("em",[t._v("Craft backend route")])])]),t._v(" "),a("div",{staticClass:"simple-bar-chart-value"},[a("sample-size-warning",{attrs:{sample:t.cnt}})],1)]),t._v(" "),a("div",{staticClass:"clearafter pb-1"},[a("cite",{staticClass:"simple-bar-chart-label text-sm font-normal truncate-label",staticStyle:{width:"80%"},attrs:{title:t.url}},[a("a",{staticClass:"hover:no-underline",staticStyle:{color:"rgb(0, 102, 33)"},attrs:{href:t.url,target:"_blank"},on:{click:function(t){t.stopPropagation()}}},[t._v("\n                "+t._s(t.url)+"\n            ")])]),t._v(" "),a("div",{staticClass:"simple-bar-chart-value text-sm font-bold"},[t._v(t._s(t.data))])]),t._v(" "),a("div",{staticClass:"py-1"},[a("div",{staticClass:"file-list-chart-track rounded-full bg-gray-200"},[a("div",{staticClass:"simple-bar-line h-2 rounded-full",style:{width:t.width+"%",backgroundColor:t.color}})])])])};C._withStripped=!0;var x={name:"dashboard-file-list-cell",components:{SampleSizeWarning:a(28).a},props:{title:String,url:String,detailPageUrl:String,data:String,cnt:Number,width:Number,color:String},methods:{redirectTo:function(t){window.location.href=t}}},w=Object(d.a)(x,C,[],!1,null,null,null);w.options.__file="src/assetbundles/webperf/src/vue/charts/dashboard/DashboardFileListCell.vue";var O=w.exports,R=function(t,e,a,n){t.get(e,{params:a}).then((function(t){n&&n(t.data)})).catch((function(t){console.log(t)}))},M={name:"dashboard-file-list",components:{"dashboard-file-list-cell":O},props:{start:String,end:String,column:String,fastColor:{type:String,default:"#00C800"},averageColor:{type:String,default:"#FFFF00"},slowColor:{type:String,default:"#C80000"},limit:{type:Number,default:3},maxValue:Number,siteId:{type:Number,default:0},apiUrl:{type:String,default:""}},methods:{getSeriesData:function(){var t,e,a=this;return b.a.async((function(n){for(;;)switch(n.prev=n.next){case 0:return t=_.a.create({baseURL:this.apiUrl,headers:{"X-Requested-With":"XMLHttpRequest"}}),e={column:this.column,start:this.displayStart,end:this.displayEnd,siteId:this.siteId},n.next=4,b.a.awrap(R(t,"",e,(function(t){t.forEach((function(t,e,n){var r=t.avg/1e3,s=a.maxValue;r>s&&(s=r),r=100*r/s,n[e].data=r,n[e].maxValue=s,n[e].barColor=a.triBlend.colorFromPercentage(r)})),a.series=t})));case 4:case"end":return n.stop()}}),null,this)},onChangeRange:function(t){this.displayStart=t.start,this.displayEnd=t.end,this.getSeriesData()},statFormatter:function(t,e){return t=t*e/100,Number(t).toFixed(2)+"s"}},created:function(){this.getSeriesData()},mounted:function(){var t=this;this.$events.$on("change-range",(function(e){return t.onChangeRange(e)}))},data:function(){return{series:[],displayStart:this.start,displayEnd:this.end,triBlend:new S.a(this.fastColor,this.averageColor,this.slowColor)}}},k=Object(d.a)(M,v,[],!1,null,null,null);k.options.__file="src/assetbundles/webperf/src/vue/charts/dashboard/DashboardFileList.vue";var U=k.exports,j=a(8),D=a(7),F=a(23);r.a.use(i.a);new r.a({el:"#cp-nav-content",components:{confetti:h,"radial-bar-chart":f.a,"simple-bar-chart":g.a,"dashboard-file-list":U,"sample-range-picker":j.a,"sample-pane-footer":D.a,"recommendations-list":F.a},data:{},mounted:function(){}})}});
//# sourceMappingURL=dashboard.js.map