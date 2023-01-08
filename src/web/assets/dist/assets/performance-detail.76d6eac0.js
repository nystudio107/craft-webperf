import{_ as l,S as n}from"./SampleRangePicker.f22425b8.js";import{P as o}from"./PerformanceDetailAreaChart.1ff5b0b1.js";import{V as d,a as f,b as m,c,P as u}from"./PageResultCell.457d2b6b.js";import{T as p}from"./tri-color-blend.3ecffd12.js";import{R as h}from"./RequestBarChart.15bfe72e.js";import{D as b}from"./DataSampleDate.eaf2d70c.js";import{D as g}from"./DataSampleDevice.912c20f4.js";import{n as v}from"./vue-apexcharts.159e071b.js";import{R as C,S as w}from"./SimpleBarChart.5ce065d9.js";import{S as F}from"./SamplePaneFooter.eadc9035.js";import{R as x}from"./RecommendationsList.281cf6fa.js";var P=[{name:"__slot:sample-date",sortField:"dateCreated",title:"Sample Date",titleClass:"text-left",dataClass:"text-left",width:"14%"},{name:"__slot:load-time-bar",sortField:"pageLoad",title:"Performance Timeline",titleClass:"center loadTimeBar",dataClass:"center",width:"20%"},{name:"craftDbCnt",sortField:"craftDbCnt",title:"Queries",titleClass:"text-right",dataClass:"text-right",callback:"countFormatter",width:"6%"},{name:"craftTwigCnt",sortField:"craftTwigCnt",title:"Templates",titleClass:"text-right",dataClass:"text-right",callback:"countFormatter",width:"6%"},{name:"craftOtherCnt",sortField:"craftOtherCnt",title:"Other",titleClass:"text-right",dataClass:"text-right",callback:"countFormatter",width:"6%"},{name:"craftTotalMemory",sortField:"craftTotalMemory",title:"Memory",titleClass:"text-right",dataClass:"text-right",callback:"memoryFormatter",width:"8%"},{name:"__slot:sample-device",sortField:"device",title:"Device",titleClass:"text-left",dataClass:"text-left",width:"9%"},{name:"os",sortField:"os",title:"OS",titleClass:"text-left",dataClass:"text-left",width:"9%"},{name:"browser",sortField:"browser",title:"Browser",titleClass:"text-left",dataClass:"text-left",width:"9%"},{name:"countryCode",sortField:"countryCode",title:"Country",titleClass:"text-left",dataClass:"text-left",width:"6%"},{name:"deleteLink",sortField:"deleteLink",title:"",titleClass:"text-center",dataClass:"text-center",callback:"deleteFormatter",width:"3%"},{name:"maxTotalPageLoad",visible:!1},{name:"domInteractive",visible:!1},{name:"firstContentfulPaint",visible:!1},{name:"firstPaint",visible:!1},{name:"firstByte",visible:!1},{name:"connect",visible:!1},{name:"dns",visible:!1},{name:"mobile",visible:!1}],y=function(){var e=this,r=e.$createElement,t=e._self._c||r;return t("div",{staticClass:"py-4"},[t("vuetable-filter-bar"),t("div",{staticClass:"vuetable-pagination clearafter"},[t("vuetable-pagination-info",{ref:"paginationInfoTop",attrs:{"info-template":"Displaying {from} to {to} of {total} data samples"}}),t("vuetable-pagination",{ref:"paginationTop",on:{"vuetable-pagination:change-page":e.onChangePage}})],1),t("div",{staticClass:"overflow-x-auto overflow-y-hidden"},[t("vuetable",{ref:"vuetable",attrs:{"api-url":e.apiUrl,"append-params":e.moreParams,css:e.css,fields:e.fields,"per-page":20,"sort-order":e.sortOrder},on:{"vuetable:pagination-data":e.onPaginationData,"vuetable:row-clicked":e.onRowClicked,"vuetable:loaded":e.onLoaded},scopedSlots:e._u([{key:"sample-date",fn:function(a){return[t("data-sample-date",{attrs:{date:a.rowData.dateCreated,query:a.rowData.query,url:a.rowData.url}})]}},{key:"sample-device",fn:function(a){return[t("data-sample-device",{attrs:{device:a.rowData.device,mobile:a.rowData.mobile}})]}},{key:"load-time-bar",fn:function(a){return[t("request-bar-chart",{attrs:{"row-data":a.rowData}})]}}])})],1),t("div",{staticClass:"vuetable-pagination clearafter"},[t("vuetable-pagination-info",{ref:"paginationInfo",attrs:{"info-template":"Displaying {from} to {to} of {total} data samples"}}),t("vuetable-pagination",{ref:"pagination",on:{"vuetable-pagination:change-page":e.onChangePage}})],1)],1)},_=[];const D={components:{vuetable:d,"vuetable-pagination":f,"vuetable-pagination-info":m,"vuetable-filter-bar":c,"request-bar-chart":h,"page-result-cell":u,"data-sample-date":b,"data-sample-device":g},props:{start:{type:String,default:""},end:{type:String,default:""},fastColor:{type:String,default:"#00C800"},averageColor:{type:String,default:"#FFFF00"},slowColor:{type:String,default:"#C80000"},maxValue:{type:Number,default:1e4},pageUrl:{type:String,default:""},siteId:{type:Number,default:0},apiUrl:{type:String,default:""}},data:function(){return{moreParams:{siteId:this.siteId,pageUrl:this.pageUrl,start:this.start,end:this.end,filter:""},css:{tableClass:"data fullwidth webperf-page-detail",ascendingIcon:"menubtn webperf-menubtn-asc",descendingIcon:"menubtn webperf-menubtn-desc"},sortOrder:[{field:"__slot:load-time-bar",sortField:"pageLoad",direction:"desc"}],fields:P,triBlend:new p(this.fastColor,this.averageColor,this.slowColor)}},mounted(){this.$events.$on("filter-set",e=>this.onFilterSet(e)),this.$events.$on("filter-reset",()=>this.onFilterReset()),this.$events.$on("change-range",e=>this.onChangeRange(e))},methods:{onFilterSet(e){this.moreParams.filter=e,this.$events.fire("refresh-table",this.$refs.vuetable)},onFilterReset(){this.moreParams.filter="",this.$events.fire("refresh-table",this.$refs.vuetable)},onLoaded(){this.$events.fire("refresh-table-components",this.$refs.vuetable)},onPaginationData(e){this.$refs.paginationTop.setPaginationData(e),this.$refs.paginationInfoTop.setPaginationData(e),this.$refs.pagination.setPaginationData(e),this.$refs.paginationInfo.setPaginationData(e)},onChangePage(e){this.$refs.vuetable.changePage(e)},onRowClicked(){console.log()},onChangeRange(e){this.moreParams.start=e.start,this.moreParams.end=e.end,this.$events.fire("refresh-table",this.$refs.vuetable)},statFormatter(e){return Number(e/1e3).toFixed(2)+"s"},countFormatter(e){return Number(e).toFixed(0)},memoryFormatter(e){return Number(e/(1024*1024)).toFixed(2)+" Mb"},dateFormatter(e){return e},deleteFormatter(e){return e===""?"":`
                <a class="delete icon" href="${e}" title="Delete"></a>
                `}}},s={};var $=v(D,y,_,!1,T,null,null,null);function T(e){for(let r in s)this[r]=s[r]}var S=function(){return $.exports}();const i=window.Vue;i.use(l);new i({el:"#cp-nav-content",components:{PerformanceDetailAreaChart:o,PerformanceDetailTable:S,RadialBarChart:C,SimpleBarChart:w,SampleRangePicker:n,SamplePaneFooter:F,RecommendationsList:x},mounted(){this.$events.$on("refresh-table",e=>this.onTableRefresh(e))},methods:{onTableRefresh(e){i.nextTick(()=>e.refresh())}}});
//# sourceMappingURL=performance-detail.76d6eac0.js.map