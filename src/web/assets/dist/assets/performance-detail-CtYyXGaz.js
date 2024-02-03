import{_ as s,S as l}from"./SampleRangePicker-5b3vMstm.js";import{P as n}from"./PerformanceDetailAreaChart-558NUFam.js";import{V as o,a as d,b as f,c as m,P as c}from"./PageResultCell-AhIe28gR.js";import{T as u}from"./tri-color-blend-_1jgRr79.js";import{R as p}from"./RequestBarChart-f9j8xduA.js";import{D as h}from"./DataSampleDate-UZX8PM_P.js";import{D as b}from"./DataSampleDevice-ct2sPtdn.js";import{n as g}from"./vue-apexcharts-KYvHKhev.js";import{R as v,S as C}from"./SimpleBarChart-zyGty4zU.js";import{S as w}from"./SamplePaneFooter-TQ6iosc3.js";import{R as F}from"./RecommendationsList-wd0-9UzE.js";const P=[{name:"__slot:sample-date",sortField:"dateCreated",title:"Sample Date",titleClass:"text-left",dataClass:"text-left",width:"14%"},{name:"__slot:load-time-bar",sortField:"pageLoad",title:"Performance Timeline",titleClass:"center loadTimeBar",dataClass:"center",width:"20%"},{name:"craftDbCnt",sortField:"craftDbCnt",title:"Queries",titleClass:"text-right",dataClass:"text-right",callback:"countFormatter",width:"6%"},{name:"craftTwigCnt",sortField:"craftTwigCnt",title:"Templates",titleClass:"text-right",dataClass:"text-right",callback:"countFormatter",width:"6%"},{name:"craftOtherCnt",sortField:"craftOtherCnt",title:"Other",titleClass:"text-right",dataClass:"text-right",callback:"countFormatter",width:"6%"},{name:"craftTotalMemory",sortField:"craftTotalMemory",title:"Memory",titleClass:"text-right",dataClass:"text-right",callback:"memoryFormatter",width:"8%"},{name:"__slot:sample-device",sortField:"device",title:"Device",titleClass:"text-left",dataClass:"text-left",width:"9%"},{name:"os",sortField:"os",title:"OS",titleClass:"text-left",dataClass:"text-left",width:"9%"},{name:"browser",sortField:"browser",title:"Browser",titleClass:"text-left",dataClass:"text-left",width:"9%"},{name:"countryCode",sortField:"countryCode",title:"Country",titleClass:"text-left",dataClass:"text-left",width:"6%"},{name:"deleteLink",sortField:"deleteLink",title:"",titleClass:"text-center",dataClass:"text-center",callback:"deleteFormatter",width:"3%"},{name:"maxTotalPageLoad",visible:!1},{name:"domInteractive",visible:!1},{name:"firstContentfulPaint",visible:!1},{name:"firstPaint",visible:!1},{name:"firstByte",visible:!1},{name:"connect",visible:!1},{name:"dns",visible:!1},{name:"mobile",visible:!1}],x={components:{vuetable:o,"vuetable-pagination":d,"vuetable-pagination-info":f,"vuetable-filter-bar":m,"request-bar-chart":p,"page-result-cell":c,"data-sample-date":h,"data-sample-device":b},props:{start:{type:String,default:""},end:{type:String,default:""},fastColor:{type:String,default:"#00C800"},averageColor:{type:String,default:"#FFFF00"},slowColor:{type:String,default:"#C80000"},maxValue:{type:Number,default:1e4},pageUrl:{type:String,default:""},siteId:{type:Number,default:0},apiUrl:{type:String,default:""}},data:function(){return{moreParams:{siteId:this.siteId,pageUrl:this.pageUrl,start:this.start,end:this.end,filter:""},css:{tableClass:"data fullwidth webperf-page-detail",ascendingIcon:"menubtn webperf-menubtn-asc",descendingIcon:"menubtn webperf-menubtn-desc"},sortOrder:[{field:"__slot:load-time-bar",sortField:"pageLoad",direction:"desc"}],fields:P,triBlend:new u(this.fastColor,this.averageColor,this.slowColor)}},mounted(){this.$events.$on("filter-set",e=>this.onFilterSet(e)),this.$events.$on("filter-reset",()=>this.onFilterReset()),this.$events.$on("change-range",e=>this.onChangeRange(e))},methods:{onFilterSet(e){this.moreParams.filter=e,this.$events.fire("refresh-table",this.$refs.vuetable)},onFilterReset(){this.moreParams.filter="",this.$events.fire("refresh-table",this.$refs.vuetable)},onLoaded(){this.$events.fire("refresh-table-components",this.$refs.vuetable)},onPaginationData(e){this.$refs.paginationTop.setPaginationData(e),this.$refs.paginationInfoTop.setPaginationData(e),this.$refs.pagination.setPaginationData(e),this.$refs.paginationInfo.setPaginationData(e)},onChangePage(e){this.$refs.vuetable.changePage(e)},onRowClicked(){console.log()},onChangeRange(e){this.moreParams.start=e.start,this.moreParams.end=e.end,this.$events.fire("refresh-table",this.$refs.vuetable)},statFormatter(e){return Number(e/1e3).toFixed(2)+"s"},countFormatter(e){return Number(e).toFixed(0)},memoryFormatter(e){return Number(e/(1024*1024)).toFixed(2)+" Mb"},dateFormatter(e){return e},deleteFormatter(e){return e===""?"":`
                <a class="delete icon" href="${e}" title="Delete"></a>
                `}}};var y=function(){var a=this,t=a._self._c;return t("div",{staticClass:"py-4"},[t("vuetable-filter-bar"),t("div",{staticClass:"vuetable-pagination clearafter"},[t("vuetable-pagination-info",{ref:"paginationInfoTop",attrs:{"info-template":"Displaying {from} to {to} of {total} data samples"}}),t("vuetable-pagination",{ref:"paginationTop",on:{"vuetable-pagination:change-page":a.onChangePage}})],1),t("div",{staticClass:"overflow-x-auto overflow-y-hidden"},[t("vuetable",{ref:"vuetable",attrs:{"api-url":a.apiUrl,"append-params":a.moreParams,css:a.css,fields:a.fields,"per-page":20,"sort-order":a.sortOrder},on:{"vuetable:pagination-data":a.onPaginationData,"vuetable:row-clicked":a.onRowClicked,"vuetable:loaded":a.onLoaded},scopedSlots:a._u([{key:"sample-date",fn:function(r){return[t("data-sample-date",{attrs:{date:r.rowData.dateCreated,query:r.rowData.query,url:r.rowData.url}})]}},{key:"sample-device",fn:function(r){return[t("data-sample-device",{attrs:{device:r.rowData.device,mobile:r.rowData.mobile}})]}},{key:"load-time-bar",fn:function(r){return[t("request-bar-chart",{attrs:{"row-data":r.rowData}})]}}])})],1),t("div",{staticClass:"vuetable-pagination clearafter"},[t("vuetable-pagination-info",{ref:"paginationInfo",attrs:{"info-template":"Displaying {from} to {to} of {total} data samples"}}),t("vuetable-pagination",{ref:"pagination",on:{"vuetable-pagination:change-page":a.onChangePage}})],1)],1)},D=[],_=g(x,y,D,!1,null,null,null,null);const T=_.exports,i=window.Vue;i.use(s);new i({el:"#cp-nav-content",components:{PerformanceDetailAreaChart:n,PerformanceDetailTable:T,RadialBarChart:v,SimpleBarChart:C,SampleRangePicker:l,SamplePaneFooter:w,RecommendationsList:F},mounted(){this.$events.$on("refresh-table",e=>this.onTableRefresh(e))},methods:{onTableRefresh(e){i.nextTick(()=>e.refresh())}}});
//# sourceMappingURL=performance-detail-CtYyXGaz.js.map
