/*!
 * @project        Webperf
 * @name           errors-detail.js
 * @author         Andrew Welch
 * @build          Thu, Feb 7, 2019 11:55 PM ET
 * @release        52a1c86400b596449435dad4743783d1cbb6203b [develop]
 * @copyright      Copyright (c) 2019 nystudio107
 *
 */!function(t){function e(e){for(var n,i,o=e[0],l=e[1],c=e[2],d=0,p=[];d<o.length;d++)i=o[d],r[i]&&p.push(r[i][0]),r[i]=0;for(n in l)Object.prototype.hasOwnProperty.call(l,n)&&(t[n]=l[n]);for(u&&u(e);p.length;)p.shift()();return s.push.apply(s,c||[]),a()}function a(){for(var t,e=0;e<s.length;e++){for(var a=s[e],n=!0,o=1;o<a.length;o++){var l=a[o];0!==r[l]&&(n=!1)}n&&(s.splice(e--,1),t=i(i.s=a[0]))}return t}var n={},r={4:0},s=[];function i(e){if(n[e])return n[e].exports;var a=n[e]={i:e,l:!1,exports:{}};return t[e].call(a.exports,a,a.exports,i),a.l=!0,a.exports}i.m=t,i.c=n,i.d=function(t,e,a){i.o(t,e)||Object.defineProperty(t,e,{enumerable:!0,get:a})},i.r=function(t){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})},i.t=function(t,e){if(1&e&&(t=i(t)),8&e)return t;if(4&e&&"object"==typeof t&&t&&t.__esModule)return t;var a=Object.create(null);if(i.r(a),Object.defineProperty(a,"default",{enumerable:!0,value:t}),2&e&&"string"!=typeof t)for(var n in t)i.d(a,n,function(e){return t[e]}.bind(null,n));return a},i.n=function(t){var e=t&&t.__esModule?function(){return t.default}:function(){return t};return i.d(e,"a",e),e},i.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},i.p="";var o=window.webpackJsonp=window.webpackJsonp||[],l=o.push.bind(o);o.push=e,o=o.slice();for(var c=0;c<o.length;c++)e(o[c]);var u=l;s.push([178,0,1]),a()}({11:function(t,e,a){"use strict";var n=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"field"},[a("div",{staticClass:"heading"},[a("p",{staticClass:"instructions"},[t._v("The "+t._s(t.subject)+" data is an "),a("em",[t._v("average")]),t._v(" of "),a("strong",[t._v(t._s(t.formatNumber(t.samples)))]),t._v(" data sample"),1!==t.samples?a("span",[t._v("s")]):t._e(),t._v(".")])]),t._v(" "),t.samples<100?a("p",{staticClass:"warning"},[t._v("Webperf has collected less than "),a("strong",[t._v("100")]),t._v(" data samples. The sample size is not statistically significant, so above averaged results may not be meaningful.")]):t._e(),t._v(" "),t.displayDevModeWarning?a("p",{staticClass:"warning"},[t._v("Craft performance will be slower than normal with "),a("code",[t._v("devMode")]),t._v(" enabled due to extensive logging and disabling of some caches. "),t._m(0)]):t._e()])};n._withStripped=!0;a(6),a(22),a(26),a(7),a(1),a(8),a(5),a(9);var r=a(2),s=a.n(r);function i(t,e,a,n,r,s,i){try{var o=t[s](i),l=o.value}catch(t){return void a(t)}o.done?e(l):Promise.resolve(l).then(n,r)}var o=function(t,e,a,n){for(var r="?",s=Object.keys(a),i=0;i<s.length;i++){var o=s[i];e=e+r+encodeURIComponent(o)+"="+encodeURIComponent(a[o]),r="&"}t.get(e).then(function(t){n&&n(t.data)}).catch(function(t){console.log(t)})},l={components:{},props:{start:String,end:String,column:String,displayDevModeWarning:{type:Boolean,default:!1},pageUrl:{type:String,default:""},subject:{type:String,default:""},siteId:{type:Number,default:0}},methods:{getSeriesData:function(){var t,e=(t=regeneratorRuntime.mark(function t(){var e,a,n,r=this;return regeneratorRuntime.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return e=s.a.create({baseURL:"/webperf/charts/dashboard-stats-average/",headers:{"X-Requested-With":"XMLHttpRequest"}}),a=this.column,0!==this.siteId&&(a+="/"+this.siteId),n={start:this.displayStart,end:this.displayEnd,pageUrl:this.pageUrl},t.next=6,o(e,a,n,function(t){void 0!==t.cnt&&(r.samples=t.cnt)});case 6:case"end":return t.stop()}},t,this)}),function(){var e=this,a=arguments;return new Promise(function(n,r){var s=t.apply(e,a);function o(t){i(s,n,r,o,l,"next",t)}function l(t){i(s,n,r,o,l,"throw",t)}o(void 0)})});return function(){return e.apply(this,arguments)}}(),onChangeRange:function(t){this.displayStart=t.start,this.displayEnd=t.end,this.getSeriesData()},formatNumber:function(t){return t.toString().replace(/\B(?=(\d{3})+(?!\d))/g,",")}},created:function(){this.getSeriesData()},mounted:function(){var t=this;this.$events.$on("change-range",function(e){return t.onChangeRange(e)})},data:function(){return{samples:0,displayEnd:this.end,displayMaxValue:this.maxValue}}},c=a(0),u=Object(c.a)(l,n,[function(){var t=this.$createElement,e=this._self._c||t;return e("span",{staticClass:"field inline-block m-0"},[e("a",{staticClass:"notice go",attrs:{href:"https://craftcms.com/guides/what-dev-mode-does",target:"_blank"}},[this._v("Learn More")])])}],!1,null,null,null);u.options.__file="src/assetbundles/webperf/src/vue/common/SamplePaneFooter.vue";e.a=u.exports},13:function(t,e,a){"use strict";var n=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"readable inline-block"},[a("vue-ctk-date-time-picker",{attrs:{range:!0,"no-header":!0,"only-date":!0,"no-value-to-custom-elem":!0,"custom-shortcuts":t.customShortcuts,label:"Data Sample Date Range",format:"YYYY-MM-DD",formatted:"YYYY-MM-DD",color:"dimgray","no-button":!0,"auto-close":!0},on:{input:function(e){t.onInput()}},model:{value:t.dateRange,callback:function(e){t.dateRange=e},expression:"dateRange"}},[a("button",{staticClass:"btn menubtn text-sm leading-normal text-left",staticStyle:{"min-width":"237px"},attrs:{type:"button","data-icon":"date",tabindex:"0",role:"combobox","aria-haspopup":"true","aria-expanded":"false"}},[t._v("\n            "+t._s(t.dateRange.start)+" → "+t._s(t.dateRange.end)+"\n        ")])])],1)};n._withStripped=!0;var r=a(24),s=a.n(r),i=(a(47),{name:"sample-range-picker",components:{"vue-ctk-date-time-picker":s.a},data:function(){return{dateRange:{},customShortcuts:[{label:"Today",value:"day",isSelected:!1},{label:"Yesterday",value:"-day",isSelected:!1},{label:"This Month",value:"month",isSelected:!1},{label:"Last Month",value:"-month",isSelected:!1},{label:"This Year",value:"year",isSelected:!1},{label:"Last Year",value:"-year",isSelected:!1},{label:"Last 365 days",value:365,isSelected:!0}]}},methods:{onInput:function(){this.$events.fire("change-range",this.dateRange)}}}),o=a(0),l=Object(o.a)(i,n,[],!1,null,null,null);l.options.__file="src/assetbundles/webperf/src/vue/common/SampleRangePicker.vue";e.a=l.exports},178:function(t,e,a){"use strict";a.r(e);var n=a(3),r=a.n(n),s=a(23),i=a.n(s),o=a(50),l=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"py-4"},[a("vuetable-filter-bar"),t._v(" "),a("div",{staticClass:"vuetable-pagination clearafter"},[a("vuetable-pagination-info",{ref:"paginationInfoTop",attrs:{infoTemplate:"Displaying {from} to {to} of {total} data samples"}}),t._v(" "),a("vuetable-pagination",{ref:"paginationTop",on:{"vuetable-pagination:change-page":t.onChangePage}})],1),t._v(" "),a("vuetable",{ref:"vuetable",attrs:{"api-url":"/webperf/tables/errors-detail","per-page":20,fields:t.fields,css:t.css,"sort-order":t.sortOrder,"append-params":t.moreParams},on:{"vuetable:pagination-data":t.onPaginationData,"vuetable:row-clicked":t.onRowClicked,"vuetable:loaded":t.onLoaded},scopedSlots:t._u([{key:"error-date",fn:function(t){return[a("data-sample-date",{attrs:{date:t.rowData.dateCreated,url:t.rowData.url,query:t.rowData.query}})]}},{key:"error-sample",fn:function(t){return[a("error-sample",{attrs:{"page-errors":t.rowData.pageErrors,type:t.rowData.type}})]}},{key:"sample-device",fn:function(t){return[a("data-sample-device",{attrs:{mobile:t.rowData.mobile,device:t.rowData.device}})]}},{key:"load-time-bar",fn:function(t){return[a("request-bar-chart",{attrs:{rowData:t.rowData}})]}}])}),t._v(" "),a("div",{staticClass:"vuetable-pagination clearafter"},[a("vuetable-pagination-info",{ref:"paginationInfo",attrs:{infoTemplate:"Displaying {from} to {to} of {total} data samples"}}),t._v(" "),a("vuetable-pagination",{ref:"pagination",on:{"vuetable-pagination:change-page":t.onChangePage}})],1)],1)};l._withStripped=!0;a(1);var c=[{name:"__slot:error-date",sortField:"dateCreated",title:"Error Date",titleClass:"text-left",dataClass:"text-left align-top",width:"15%"},{name:"__slot:error-sample",sortField:"pageErrors",title:"Errors",titleClass:"text-left",dataClass:"text-left align-top",width:"42%"},{name:"__slot:sample-device",sortField:"device",title:"Device",titleClass:"text-left",dataClass:"text-left align-top",width:"10%"},{name:"os",sortField:"os",title:"OS",titleClass:"text-left",dataClass:"text-left align-top",width:"10%"},{name:"browser",sortField:"browser",title:"Browser",titleClass:"text-left",dataClass:"text-left align-top",width:"10%"},{name:"countryCode",sortField:"countryCode",title:"Country",titleClass:"text-left",dataClass:"text-left align-top",width:"10%"},{name:"deleteLink",sortField:"deleteLink",title:"",titleClass:"text-center",dataClass:"text-center align-top",callback:"deleteFormatter",width:"3%"},{name:"maxTotalPageLoad",visible:!1},{name:"domInteractive",visible:!1},{name:"firstContentfulPaint",visible:!1},{name:"firstPaint",visible:!1},{name:"firstByte",visible:!1},{name:"connect",visible:!1},{name:"dns",visible:!1},{name:"mobile",visible:!1}],u=a(33),d=a(19),p=a(18),f=a(20),h=a(28),v=a(21),g=a(31),b=a(49),m=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[t.parsedErrors?a("div",["craft"===t.type?a("div",[a("h4",{staticClass:"text-red-dark m-0"},[t._v("Craft Errors:")]),t._v(" "),t._l(t.parsedErrors,function(e){return a("div",[a("div",{staticClass:"field text-sm font-normal inline-block pt-2"},[a("p",{staticClass:"warning display-block",class:["error"===e.level?"webperf-error-color":""]},[t._v("\n                        "+t._s(t.uppercaseFirstChar(e.level))+" → "+t._s(e.message)+"\n                    ")]),t._v(" "),a("p",{staticClass:"m-0 text-grey-darker"},[t._v("\n                        From → "+t._s(e.category)+"\n                    ")])])])})],2):"boomerang"===t.type?a("div",[a("h4",{staticClass:"text-green-dark m-0"},[t._v("JavaScript Errors:")]),t._v(" "),t._l(t.parsedErrors,function(e){return a("div",[a("div",{staticClass:"field text-sm font-normal inline-block pt-2"},[a("p",{staticClass:"warning display-block webperf-error-color"},[t._v("\n                        Error → "+t._s(e.t)+" "+t._s(e.c)+" "+t._s(e.m)+" "+t._s(e.x)+"\n                    ")]),t._v(" "),a("p",{staticClass:"m-0 text-grey-darker"},[t._v("\n                        Stack Trace →\n                        "),a("ul",{staticClass:"list-reset"},t._l(e.f,function(e){return a("li",{staticClass:"text-grey-darker pl-2"},[t._v("\n                                "+t._s(e.l)+":"+t._s(e.c)+" "+t._s(e.f)+" "+t._s(e.w)+" "+t._s(e.wo)+"\n                            ")])}),0)])])])})],2):t._e()]):a("div",[a("span",[a("code",[t._v("\n                "+t._s(t.pageErrors)+"\n            ")])])])])};m._withStripped=!0;var _={name:"error-sample",props:{pageErrors:String,type:String},data:function(){return{parsedErrors:void 0}},methods:{uppercaseFirstChar:function(t){return t.charAt(0).toUpperCase()+t.slice(1)}},mounted:function(){try{this.parsedErrors=JSON.parse(this.pageErrors)}catch(t){console.log(t.message)}}},y=a(0),w=Object(y.a)(_,m,[],!1,null,null,null);w.options.__file="src/assetbundles/webperf/src/vue/tables/Errors/ErrorSample.vue";var C=w.exports,x={components:{vuetable:u.a,"vuetable-pagination":d.a,"vuetable-pagination-info":p.a,"vuetable-filter-bar":f.a,"request-bar-chart":h.a,"page-result-cell":v.a,"data-sample-date":g.a,"data-sample-device":b.a,"error-sample":C},props:{start:String,end:String,fastColor:{type:String,default:"#00C800"},averageColor:{type:String,default:"#FFFF00"},slowColor:{type:String,default:"#C80000"},maxValue:{type:Number,default:1e4},pageUrl:String,siteId:{type:Number,default:0}},data:function(){return{moreParams:{siteId:this.siteId,pageUrl:this.pageUrl,start:this.start,end:this.end,filter:""},css:{tableClass:"data fullwidth webperf-page-detail",ascendingIcon:"menubtn webperf-menubtn-asc",descendingIcon:"menubtn webperf-menubtn-desc"},sortOrder:[{field:"__slot:error-date",sortField:"dateCreated",direction:"desc"}],fields:c}},mounted:function(){var t=this;this.$events.$on("filter-set",function(e){return t.onFilterSet(e)}),this.$events.$on("filter-reset",function(e){return t.onFilterReset()}),this.$events.$on("change-range",function(e){return t.onChangeRange(e)})},methods:{onFilterSet:function(t){this.moreParams.filter=t,this.$events.fire("refresh-table",this.$refs.vuetable)},onFilterReset:function(){this.moreParams.filter="",this.$events.fire("refresh-table",this.$refs.vuetable)},onLoaded:function(){this.$events.fire("refresh-table-components",this.$refs.vuetable)},onPaginationData:function(t){this.$refs.paginationTop.setPaginationData(t),this.$refs.paginationInfoTop.setPaginationData(t),this.$refs.pagination.setPaginationData(t),this.$refs.paginationInfo.setPaginationData(t)},onChangePage:function(t){this.$refs.vuetable.changePage(t)},onRowClicked:function(t,e){},onChangeRange:function(t){this.moreParams.start=t.start,this.moreParams.end=t.end,this.$events.fire("refresh-table",this.$refs.vuetable)},statFormatter:function(t){return Number(t/1e3).toFixed(2)+"s"},countFormatter:function(t){return Number(t).toFixed(0)},memoryFormatter:function(t){return Number(t/1048576).toFixed(2)+" Mb"},dateFormatter:function(t){return t},deleteFormatter:function(t){return""===t?"":'\n            <a class="delete icon" href="'.concat(t,'" title="Delete"></a>\n            ')}}},S=Object(y.a)(x,l,[],!1,null,null,null);S.options.__file="src/assetbundles/webperf/src/vue/tables/Errors/ErrorsDetailTable.vue";var P=S.exports,k=a(29),O=a(30),F=a(13),D=a(11);r.a.use(i.a);new r.a({el:"#cp-nav-content",components:{"errors-detail-area-chart":o.a,"errors-detail-table":P,"radial-bar-chart":k.a,"simple-bar-chart":O.a,"sample-range-picker":F.a,"sample-pane-footer":D.a},data:{},methods:{onTableRefresh:function(t){r.a.nextTick(function(){return t.refresh()})}},mounted:function(){var t=this;this.$events.$on("refresh-table",function(e){return t.onTableRefresh(e)})}})},18:function(t,e,a){"use strict";var n=function(){var t=this.$createElement;return(this._self._c||t)("div",{class:["vuetable-pagination-info",this.css.infoClass],domProps:{innerHTML:this._s(this.paginationInfo)}})};n._withStripped=!0;a(26);var r={props:{css:{type:Object,default:function(){return{infoClass:"left floated left py-5 text-grey-dark"}}},infoTemplate:{type:String,default:function(){return"Displaying {from} to {to} of {total} items"}},noDataTemplate:{type:String,default:function(){return"No relevant data"}}},data:function(){return{tablePagination:null}},computed:{paginationInfo:function(){return null==this.tablePagination||0==this.tablePagination.total?this.noDataTemplate:this.infoTemplate.replace("{from}",this.tablePagination.from||0).replace("{to}",this.tablePagination.to||0).replace("{total}",this.tablePagination.total||0)}},methods:{setPaginationData:function(t){this.tablePagination=t},resetData:function(){this.tablePagination=null}}},s=a(0),i=Object(s.a)(r,void 0,void 0,!1,null,null,null);i.options.__file="src/assetbundles/webperf/src/vue/tables/common/VuetablePaginationInfoMixin.vue";var o={mixins:[i.exports]},l=Object(s.a)(o,n,[],!1,null,null,null);l.options.__file="src/assetbundles/webperf/src/vue/tables/common/VuetablePaginationInfo.vue";e.a=l.exports},19:function(t,e,a){"use strict";var n=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{directives:[{name:"show",rawName:"v-show",value:t.tablePagination&&t.tablePagination.last_page>1,expression:"tablePagination && tablePagination.last_page > 1"}],class:t.css.wrapperClass},[a("a",{class:["btn-nav",t.css.linkClass,t.isOnFirstPage?t.css.disabledClass:""],on:{click:function(e){t.loadPage(1)}}},[""!=t.css.icons.first?a("i",{class:[t.css.icons.first]}):a("span",[t._v("«")])]),t._v(" "),a("a",{class:["btn-nav",t.css.linkClass,t.isOnFirstPage?t.css.disabledClass:""],on:{click:function(e){t.loadPage("prev")}}},[""!=t.css.icons.next?a("i",{class:[t.css.icons.prev]}):a("span",[t._v(" ‹")])]),t._v(" "),t.notEnoughPages?[t._l(t.totalPage,function(e){return[a("a",{class:[t.css.pageClass,t.isCurrentPage(e)?t.css.activeClass:""],domProps:{innerHTML:t._s(e)},on:{click:function(a){t.loadPage(e)}}})]})]:[t._l(t.windowSize,function(e){return[a("a",{class:[t.css.pageClass,t.isCurrentPage(t.windowStart+e-1)?t.css.activeClass:""],domProps:{innerHTML:t._s(t.windowStart+e-1)},on:{click:function(a){t.loadPage(t.windowStart+e-1)}}})]})],t._v(" "),a("a",{class:["btn-nav",t.css.linkClass,t.isOnLastPage?t.css.disabledClass:""],on:{click:function(e){t.loadPage("next")}}},[""!=t.css.icons.next?a("i",{class:[t.css.icons.next]}):a("span",[t._v("› ")])]),t._v(" "),a("a",{class:["btn-nav",t.css.linkClass,t.isOnLastPage?t.css.disabledClass:""],on:{click:function(e){t.loadPage(t.totalPage)}}},[""!=t.css.icons.last?a("i",{class:[t.css.icons.last]}):a("span",[t._v("»")])])],2)};n._withStripped=!0;a(1);var r={props:{css:{type:Object,default:function(){return{wrapperClass:"vuetable pagination float-right py-4",activeClass:"active large",disabledClass:"disabled",pageClass:"item btn",linkClass:"item btn",paginationClass:"ui bottom attached segment grid",paginationInfoClass:"left floated left aligned six wide column",dropdownClass:"ui search dropdown",icons:{first:"",prev:"",next:"",last:""}}}},onEachSide:{type:Number,default:function(){return 2}}},data:function(){return{eventPrefix:"vuetable-pagination:",tablePagination:null}},computed:{totalPage:function(){return null===this.tablePagination?0:this.tablePagination.last_page},isOnFirstPage:function(){return null!==this.tablePagination&&1===this.tablePagination.current_page},isOnLastPage:function(){return null!==this.tablePagination&&this.tablePagination.current_page===this.tablePagination.last_page},notEnoughPages:function(){return this.totalPage<2*this.onEachSide+4},windowSize:function(){return 2*this.onEachSide+1},windowStart:function(){return!this.tablePagination||this.tablePagination.current_page<=this.onEachSide?1:this.tablePagination.current_page>=this.totalPage-this.onEachSide?this.totalPage-2*this.onEachSide:this.tablePagination.current_page-this.onEachSide}},methods:{loadPage:function(t){this.$emit(this.eventPrefix+"change-page",t)},isCurrentPage:function(t){return t===this.tablePagination.current_page},setPaginationData:function(t){this.tablePagination=t},resetData:function(){this.tablePagination=null}}},s=a(0),i=Object(s.a)(r,void 0,void 0,!1,null,null,null);i.options.__file="src/assetbundles/webperf/src/vue/tables/common/VuetablePaginationMixin.vue";var o={mixins:[i.exports]},l=Object(s.a)(o,n,[],!1,null,null,null);l.options.__file="src/assetbundles/webperf/src/vue/tables/common/VuetablePagination.vue";e.a=l.exports},20:function(t,e,a){"use strict";var n=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"filter-bar"},[a("div",{staticClass:"ui form"},[a("div",{staticClass:"inline field"},[a("label",{staticClass:"text-grey-dark"},[t._v("Search for:")]),t._v(" "),a("input",{directives:[{name:"model",rawName:"v-model",value:t.filterText,expression:"filterText"}],staticClass:"text nicetext",attrs:{type:"text",placeholder:""},domProps:{value:t.filterText},on:{keyup:t.doFilter,input:function(e){e.target.composing||(t.filterText=e.target.value)}}}),t._v(" "),a("button",{staticClass:"btn delete icon",on:{click:t.resetFilter}},[t._v("Reset")])])])])};n._withStripped=!0;var r={data:function(){return{filterText:""}},methods:{doFilter:function(){this.$events.fire("filter-set",this.filterText)},resetFilter:function(){this.filterText="",this.$events.fire("filter-reset")}}},s=a(0),i=Object(s.a)(r,n,[],!1,null,null,null);i.options.__file="src/assetbundles/webperf/src/vue/tables/common/VuetableFilterBar.vue";e.a=i.exports},21:function(t,e,a){"use strict";var n=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("div",{staticClass:"relative single-line-truncate-wrapper"},[a("div",{staticClass:"text-base font-normal truncate-label",staticStyle:{width:"100%",height:"20px"},attrs:{title:t.title}},[t.title?a("a",{staticStyle:{color:"rgb(26, 13, 171)"},attrs:{href:t.url,target:"_blank"},on:{click:function(t){t.stopPropagation()}}},[t._v("\n                "+t._s(t.title)+"\n            ")]):a("span",{staticClass:"text-grey-light"},[a("em",[t._v("Craft backend route")])])])]),t._v(" "),a("div",{staticClass:"relative single-line-truncate-wrapper"},[a("cite",{staticClass:"text-sm font-normal truncate-label single-line-truncate",staticStyle:{width:"100%"},attrs:{title:t.url}},[a("a",{staticClass:"hover:no-underline",staticStyle:{color:"rgb(0, 102, 33)"},attrs:{href:t.url,target:"_blank"},on:{click:function(t){t.stopPropagation()}}},[t._v("\n                "+t._s(t.url)+"\n            ")])])]),t._v(" "),t.width?a("div",{staticClass:"py-2"},[a("div",{staticClass:"simple-bar-chart-track rounded-full bg-grey-lighter"},[a("div",{staticClass:"simple-bar-line h-2 rounded-full",style:{width:t.width+"%",backgroundColor:t.color}})])]):t._e()])};n._withStripped=!0;a(1);var r={name:"page-result-cell",props:{title:String,url:String,width:Number,color:String}},s=a(0),i=Object(s.a)(r,n,[],!1,null,null,null);i.options.__file="src/assetbundles/webperf/src/vue/tables/common/PageResultCell.vue";e.a=i.exports},28:function(t,e,a){"use strict";var n=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"flex flex-no-wrap"},["both"===t.rowData.type?a("div",{staticClass:"flex-shrink",attrs:{title:"Combined Frontend & Craft Beacon"}},[a("div",{staticClass:"w-2 h-2 bg-blue-dark rounded-full mb-1"}),t._v(" "),a("div",{staticClass:"w-2 h-2 bg-orange-dark rounded-full"})]):t._e(),t._v(" "),"frontend"===t.rowData.type?a("div",{staticClass:"flex-shrink",attrs:{title:"Frontend Beacon only"}},[a("div",{staticClass:"w-2 h-2 bg-blue-dark rounded-full mb-1"}),t._v(" "),a("div",{staticClass:"w-2 h-2 bg-transparent rounded-full"})]):t._e(),t._v(" "),"craft"===t.rowData.type?a("div",{staticClass:"flex-shrink",attrs:{title:"Craft Beacon only"}},[a("div",{staticClass:"w-2 h-2 bg-transparent rounded-full mb-1"}),t._v(" "),a("div",{staticClass:"w-2 h-2 bg-orange-dark rounded-full"})]):t._e(),t._v(" "),a("div",{staticClass:"flex-grow"},[a("request-bar-recursive",{attrs:{column:t.root.column,color:t.root.color,label:t.root.label,value:t.root.value,parentValue:t.root.parentValue,nodes:t.root.nodes}})],1),t._v(" "),a("div",{staticClass:"flex-shrink"},[t._v("\n        "+t._s(t.statFormatter(t.root.value))+"\n    ")])])};n._withStripped=!0;a(1);var r=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"h-5",class:t.color,style:{width:t.value/t.parentValue*100+"%"},attrs:{title:t.label+" "+t.statFormatter(t.value)}},t._l(t.nodes,function(t){return a("request-bar-recursive",{key:t.column,attrs:{column:t.column,color:t.color,label:t.label,value:t.value,parentValue:t.parentValue,nodes:t.nodes}})}),1)};r._withStripped=!0;var s={name:"request-bar-recursive",props:{column:String,color:String,label:String,value:Number,parentValue:Number,nodes:Array},methods:{statFormatter:function(t){return Number(t/1e3).toFixed(2)+"s"}}},i=a(0),o=Object(i.a)(s,r,[],!1,null,null,null);o.options.__file="src/assetbundles/webperf/src/vue/charts/common/RequestBarRecursive.vue";var l=o.exports,c=[{column:"pageLoad",color:"bg-blue-lighter",label:"Page Loaded"},{column:"domInteractive",color:"bg-blue-light",label:"DOM Interactive"},{column:"firstContentfulPaint",color:"bg-blue",label:"First Contentful Paint"},{column:"firstPaint",color:"bg-blue-dark",label:"First Paint"},{column:"firstByte",color:"bg-orange-light",label:"First Byte"},{column:"connect",color:"bg-orange",label:"Connect"},{column:"dns",color:"bg-orange-dark",label:"DNS Lookup"},{column:"craftTotalMs",color:"bg-red-light",label:"Craft Rendering"},{column:"craftTwigMs",color:"bg-red",label:"Twig Rendering"},{column:"craftDbMs",color:"bg-red-dark",label:"Database Queries"}],u={name:"request-bar-chart",components:{"request-bar-recursive":l},props:{rowData:Object},data:function(){return{root:void 0}},mounted:function(){var t=this;this.$events.$on("refresh-table-components",function(e){return t.onTableRefresh(e)})},created:function(){this.calculateNodes()},methods:{onTableRefresh:function(t){this.calculateNodes()},statFormatter:function(t){return Number(t/1e3).toFixed(2)+"s"},calculateNodes:function(){var t=this;this.root=void 0,c.forEach(function(e){var a={column:e.column,color:e.color,label:e.label,value:parseFloat(t.rowData[e.column])||null,parentValue:parseFloat(t.rowData.maxTotalPageLoad)||null,nodes:void 0};if(a.value)if(t.root)for(var n=t.root;n;)!n.nodes||!n.value||a.value>n.value?(a.nodes=n.nodes,a.parentValue=n.parentValue||n.value,n.nodes=[a],n=a.nodes||void 0):n=n.nodes[0]||void 0;else t.root=a})}}},d=Object(i.a)(u,n,[],!1,null,null,null);d.options.__file="src/assetbundles/webperf/src/vue/charts/common/RequestBarChart.vue";e.a=d.exports},29:function(t,e,a){"use strict";var n=function(){var t=this.$createElement;return(this._self._c||t)("apexcharts",{attrs:{width:"100%",height:"300px",type:"radialBar",options:this.chartOptions,series:this.series}})};n._withStripped=!0;a(27),a(6),a(7),a(1),a(8),a(5),a(9);var r=a(2),s=a.n(r),i=a(10),o=a.n(i),l=a(4);function c(t){for(var e=1;e<arguments.length;e++)if(e%2){var a=null!=arguments[e]?arguments[e]:{},n=Object.keys(a);"function"==typeof Object.getOwnPropertySymbols&&(n=n.concat(Object.getOwnPropertySymbols(a).filter(function(t){return Object.getOwnPropertyDescriptor(a,t).enumerable}))),n.forEach(function(e){u(t,e,a[e])})}else Object.defineProperties(t,Object.getOwnPropertyDescriptors(arguments[e]));return t}function u(t,e,a){return e in t?Object.defineProperty(t,e,{value:a,enumerable:!0,configurable:!0,writable:!0}):t[e]=a,t}function d(t,e,a,n,r,s,i){try{var o=t[s](i),l=o.value}catch(t){return void a(t)}o.done?e(l):Promise.resolve(l).then(n,r)}var p=function(t,e,a,n){for(var r="?",s=Object.keys(a),i=0;i<s.length;i++){var o=s[i];e=e+r+encodeURIComponent(o)+"="+encodeURIComponent(a[o]),r="&"}t.get(e).then(function(t){n&&n(t.data)}).catch(function(t){console.log(t)})},f={components:{apexcharts:o.a},props:{title:String,start:String,end:String,column:String,pageUrl:{type:String,default:""},fastColor:{type:String,default:"#00C800"},averageColor:{type:String,default:"#FFFF00"},slowColor:{type:String,default:"#C80000"},maxValue:Number,siteId:{type:Number,default:0}},methods:{getSeriesData:function(){var t,e=(t=regeneratorRuntime.mark(function t(){var e,a,n,r=this;return regeneratorRuntime.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return e=s.a.create({baseURL:"/webperf/charts/dashboard-stats-average/",headers:{"X-Requested-With":"XMLHttpRequest"}}),a=this.column,0!==this.siteId&&(a+="/"+this.siteId),n={start:this.displayStart,end:this.displayEnd,pageUrl:this.pageUrl},t.next=6,p(e,a,n,function(t){if(void 0!==t.avg){var e=t.avg/1e3;e>r.displayMaxValue&&(r.displayMaxValue=e),e=100*e/r.displayMaxValue;var a=r.triBlend.colorFromPercentage(e);r.chartOptions=c({},r.chartOptions,{},{colors:[a],plotOptions:{radialBar:{dataLabels:{value:{color:a}}}}}),r.series=[e]}});case 6:case"end":return t.stop()}},t,this)}),function(){var e=this,a=arguments;return new Promise(function(n,r){var s=t.apply(e,a);function i(t){d(s,n,r,i,o,"next",t)}function o(t){d(s,n,r,i,o,"throw",t)}i(void 0)})});return function(){return e.apply(this,arguments)}}(),onChangeRange:function(t){this.displayStart=t.start,this.displayEnd=t.end,this.getSeriesData()}},created:function(){this.getSeriesData()},mounted:function(){var t=this;this.$events.$on("change-range",function(e){return t.onChangeRange(e)})},data:function(){var t=this;return{chartOptions:{chart:{id:"vuechart-dashboard-radial-bar",fontFamily:"inherit",toolbar:{show:!1}},states:{hover:{filter:{type:"none",value:0}}},colors:["#000000"],plotOptions:{radialBar:{startAngle:-135,endAngle:135,hollow:{size:"65%"},track:{background:"#f1f5f8",strokeWidth:"97%",margin:5,shadow:{enabled:!0,top:2,left:0,color:"#999",opacity:1,blur:2}},dataLabels:{name:{show:!1,fontSize:"16px",color:"#333",offsetY:100},value:{offsetY:10,fontSize:"40px",color:"#333",style:{cssClass:"apexcharts-datalabel-value"},formatter:function(e){return e=e*t.displayMaxValue/100,Number(e).toFixed(2)+"s"}}}}},labels:[this.title],title:{text:this.title,offsetY:18,align:"center",style:{fontSize:"16px",cssClass:"apexcharts-title-text"}},stroke:{width:1,lineCap:"round"}},series:[0],displayStart:this.start,displayEnd:this.end,displayMaxValue:this.maxValue,triBlend:new l.a(this.fastColor,this.averageColor,this.slowColor)}}},h=a(0),v=Object(h.a)(f,n,[],!1,null,null,null);v.options.__file="src/assetbundles/webperf/src/vue/charts/common/RadialBarChart.vue";e.a=v.exports},30:function(t,e,a){"use strict";var n=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"simple-bar-chart-wrapper px-5 py-3"},[a("div",{staticClass:"clearafter py-2"},[a("div",{staticClass:"simple-bar-chart-label text-base font-bold"},[t._v(t._s(t.title))]),t._v(" "),a("div",{staticClass:"simple-bar-chart-value text-base font-bold"},[t._v(t._s(t.statFormatter(t.series[0])))])]),t._v(" "),a("div",{staticClass:"py-2"},[a("div",{staticClass:"simple-bar-chart-track rounded-full bg-grey-lighter"},[a("div",{staticClass:"simple-bar-line h-3 rounded-full",style:{width:t.series[0]+"%",backgroundColor:t.barColor}})])])])};n._withStripped=!0;a(6),a(7),a(1),a(8),a(5),a(9);var r=a(2),s=a.n(r),i=a(4);function o(t,e,a,n,r,s,i){try{var o=t[s](i),l=o.value}catch(t){return void a(t)}o.done?e(l):Promise.resolve(l).then(n,r)}var l=function(t,e,a,n){for(var r="?",s=Object.keys(a),i=0;i<s.length;i++){var o=s[i];e=e+r+encodeURIComponent(o)+"="+encodeURIComponent(a[o]),r="&"}t.get(e).then(function(t){n&&n(t.data)}).catch(function(t){console.log(t)})},c={components:{},props:{title:String,start:String,end:String,column:String,pageUrl:{type:String,default:""},fastColor:{type:String,default:"#00C800"},averageColor:{type:String,default:"#FFFF00"},slowColor:{type:String,default:"#C80000"},maxValue:Number,siteId:{type:Number,default:0}},methods:{getSeriesData:function(){var t,e=(t=regeneratorRuntime.mark(function t(){var e,a,n,r=this;return regeneratorRuntime.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return e=s.a.create({baseURL:"/webperf/charts/dashboard-stats-average/",headers:{"X-Requested-With":"XMLHttpRequest"}}),a=this.column,0!==this.siteId&&(a+="/"+this.siteId),n={start:this.displayStart,end:this.displayEnd,pageUrl:this.pageUrl},t.next=6,l(e,a,n,function(t){if(void 0!==t.avg){var e=t.avg/1e3;e>r.displayMaxValue&&(r.displayMaxValue=e),e=100*e/r.displayMaxValue,r.barColor=r.triBlend.colorFromPercentage(e),r.series=[e]}});case 6:case"end":return t.stop()}},t,this)}),function(){var e=this,a=arguments;return new Promise(function(n,r){var s=t.apply(e,a);function i(t){o(s,n,r,i,l,"next",t)}function l(t){o(s,n,r,i,l,"throw",t)}i(void 0)})});return function(){return e.apply(this,arguments)}}(),onChangeRange:function(t){this.displayStart=t.start,this.displayEnd=t.end,this.getSeriesData()},statFormatter:function(t){return t=t*this.displayMaxValue/100,Number(t).toFixed(2)+"s"}},created:function(){this.getSeriesData()},mounted:function(){var t=this;this.$events.$on("change-range",function(e){return t.onChangeRange(e)})},data:function(){return{barColor:"#000",series:[0],displayStart:this.start,displayEnd:this.end,displayMaxValue:this.maxValue,triBlend:new i.a(this.fastColor,this.averageColor,this.slowColor)}}},u=a(0),d=Object(u.a)(c,n,[],!1,null,null,null);d.options.__file="src/assetbundles/webperf/src/vue/charts/common/SimpleBarChart.vue";e.a=d.exports},31:function(t,e,a){"use strict";var n=function(){var t=this.$createElement;return(this._self._c||t)("span",{staticClass:"cursor-default",attrs:{title:this.title}},[this._v(this._s(this.date))])};n._withStripped=!0;var r={name:"data-sample-date",props:{date:String,url:String,query:String},computed:{title:function(){var t="";return t+="Url: "+this.url,this.query&&(t+="\n\nQuery: "+this.query),t}}},s=a(0),i=Object(s.a)(r,n,[],!1,null,null,null);i.options.__file="src/assetbundles/webperf/src/vue/tables/common/DataSampleDate.vue";e.a=i.exports},4:function(t,e,a){"use strict";a.d(e,"a",function(){return r});a(22);function n(t,e){for(var a=0;a<e.length;a++){var n=e[a];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),Object.defineProperty(t,n.key,n)}}var r=function(){function t(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"#00C800",a=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"#FFFF00",n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:"#C80000";!function(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}(this,t),this.clr1=this.HexToRGB(e),this.clr2=this.HexToRGB(a),this.clr3=this.HexToRGB(n)}var e,a,r;return e=t,(a=[{key:"RGBToHex",value:function(t,e,a){var n;return n=(t<<16|e<<8|a).toString(16).toUpperCase(),new Array(7-n.length).join("0")+n}},{key:"HexToRGB",value:function(t){var e=/^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(t);return e?{r:parseInt(e[1],16),g:parseInt(e[2],16),b:parseInt(e[3],16)}:null}},{key:"colorFromPercentage",value:function(t){var e=this.clr1,a=this.clr2;t>=50&&(e=this.clr2,a=this.clr3,t-=50);var n=t/50,r=Math.round(e.r+n*(a.r-e.r)),s=Math.round(e.g+n*(a.g-e.g)),i=Math.round(e.b+n*(a.b-e.b));return"#"+this.RGBToHex(r,s,i)}}])&&n(e.prototype,a),r&&n(e,r),t}()},49:function(t,e,a){"use strict";var n=function(){var t=this.$createElement;return(this._self._c||t)("span",{staticClass:"cursor-default",class:this.className,attrs:{title:this.title}},[this._v(" "+this._s(this.device))])};n._withStripped=!0;var r={name:"data-sample-device",props:{device:String,mobile:Boolean},computed:{className:function(){var t="";return this.device&&void 0!==this.mobile&&(t=!0===this.mobile?"webperf-mobile-icon":"webperf-desktop-icon"),t},title:function(){var t="";return this.device&&void 0!==this.mobile&&(t=!0===this.mobile?"Mobile device":"Desktop device"),t}}},s=a(0),i=Object(s.a)(r,n,[],!1,null,null,null);i.options.__file="src/assetbundles/webperf/src/vue/tables/common/DataSampleDevice.vue";e.a=i.exports},50:function(t,e,a){"use strict";var n=function(){var t=this.$createElement;return(this._self._c||t)("apexcharts",{attrs:{width:"100%",height:"450px",type:"area",options:this.chartOptions,series:this.series}})};n._withStripped=!0;a(27),a(6),a(7),a(1),a(8),a(5),a(9);var r=a(2),s=a.n(r),i=a(10);function o(t){for(var e=1;e<arguments.length;e++)if(e%2){var a=null!=arguments[e]?arguments[e]:{},n=Object.keys(a);"function"==typeof Object.getOwnPropertySymbols&&(n=n.concat(Object.getOwnPropertySymbols(a).filter(function(t){return Object.getOwnPropertyDescriptor(a,t).enumerable}))),n.forEach(function(e){l(t,e,a[e])})}else Object.defineProperties(t,Object.getOwnPropertyDescriptors(arguments[e]));return t}function l(t,e,a){return e in t?Object.defineProperty(t,e,{value:a,enumerable:!0,configurable:!0,writable:!0}):t[e]=a,t}function c(t,e,a,n,r,s,i){try{var o=t[s](i),l=o.value}catch(t){return void a(t)}o.done?e(l):Promise.resolve(l).then(n,r)}var u=function(t){return t.map(function(t){return Math.max.apply(null,t)})},d=function(t,e,a,n){for(var r="?",s=Object.keys(a),i=0;i<s.length;i++){var o=s[i];e=e+r+encodeURIComponent(o)+"="+encodeURIComponent(a[o]),r="&"}t.get(e).then(function(t){n&&n(t.data)}).catch(function(t){console.log(t)})},p={components:{apexcharts:a.n(i).a},props:{title:String,start:String,end:String,pageUrl:{type:String,default:""},siteId:{type:Number,default:0}},methods:{getSeriesData:function(){var t,e=(t=regeneratorRuntime.mark(function t(){var e,a,n,r=this;return regeneratorRuntime.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return e=s.a.create({baseURL:"/webperf/charts/errors-area-chart/",headers:{"X-Requested-With":"XMLHttpRequest"}}),a="",0!==this.siteId&&(a+="/"+this.siteId),n={start:this.displayStart,end:this.displayEnd,pageUrl:this.pageUrl},t.next=6,d(e,a,n,function(t){if(void 0!==t[0]){var e=u([t[0].data])[0],a=u([t[1].data])[0],n=e>a?e:a;r.chartOptions=o({},r.chartOptions,{},{yaxis:{max:n,tickAmount:n>10?10:n,labels:{formatter:function(t){return Math.round(t)}}},labels:t[0].labels}),r.series=t}});case 6:case"end":return t.stop()}},t,this)}),function(){var e=this,a=arguments;return new Promise(function(n,r){var s=t.apply(e,a);function i(t){c(s,n,r,i,o,"next",t)}function o(t){c(s,n,r,i,o,"throw",t)}i(void 0)})});return function(){return e.apply(this,arguments)}}(),onChangeRange:function(t){this.displayStart=t.start,this.displayEnd=t.end,this.getSeriesData()}},created:function(){this.getSeriesData()},mounted:function(){var t=this;this.$events.$on("change-range",function(e){return t.onChangeRange(e)})},data:function(){return{chartOptions:{chart:{id:"vuechart-pages-detail",toolbar:{show:!1},sparkline:{enabled:!1},animations:{enabled:!1}},tooltip:{enabled:!0,inverseOrder:!0,x:{show:!1}},colors:["#1F9D55","#CC1F1A"],stroke:{curve:"smooth",width:3},fill:{type:"solid",opacity:.5,gradient:{enabled:!1}},legend:{formatter:void 0,offsetX:0,offsetY:-10},xaxis:{labels:{show:!1,minHeight:"20px"},crosshairs:{width:1}},yaxis:{min:0,max:0,seriesName:"Errors",tickAmount:1,labels:{formatter:function(t){return Math.round(t)}}},labels:[],title:{text:this.title,offsetX:0,style:{fontSize:"24px",cssClass:"apexcharts-yaxis-title"}}},series:[{name:"empty",data:[0]}],displayStart:this.start,displayEnd:this.end,displayMaxValue:this.maxValue}}},f=a(0),h=Object(f.a)(p,n,[],!1,null,null,null);h.options.__file="src/assetbundles/webperf/src/vue/charts/Errors/ErrorsDetailAreaChart.vue";e.a=h.exports}});
//# sourceMappingURL=errors-detail.js.map