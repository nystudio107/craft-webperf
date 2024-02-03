import{_ as n,S as s}from"./SampleRangePicker-5b3vMstm.js";import{V as l,a as o,b as d,c as f,P as m}from"./PageResultCell-AhIe28gR.js";import{T as c}from"./tri-color-blend-_1jgRr79.js";import{R as u}from"./RequestBarChart-f9j8xduA.js";import{S as g}from"./SampleSizeWarning-si7ANii3.js";import{n as p}from"./vue-apexcharts-KYvHKhev.js";import{P as h}from"./PerformanceDetailAreaChart-558NUFam.js";import{R as b}from"./RecommendationsList-wd0-9UzE.js";import"./SamplePaneFooter-TQ6iosc3.js";const v=[{name:"__slot:page-listing-display",sortField:"url",title:"Page",titleClass:"center pageListingDisplay",dataClass:"center",width:"30%"},{name:"__slot:load-time-bar",sortField:"pageLoad",title:"Performance Timeline",titleClass:"center loadTimeBar",dataClass:"center",width:"20%"},{name:"craftDbCnt",sortField:"craftDbCnt",title:"Queries",titleClass:"text-right",dataClass:"text-right",callback:"countFormatter",width:"9%"},{name:"craftTwigCnt",sortField:"craftTwigCnt",title:"Templates",titleClass:"text-right",dataClass:"text-right",callback:"countFormatter",width:"9%"},{name:"craftOtherCnt",sortField:"craftOtherCnt",title:"Other",titleClass:"text-right",dataClass:"text-right",callback:"countFormatter",width:"9%"},{name:"craftTotalMemory",sortField:"craftTotalMemory",title:"Memory",titleClass:"text-right",dataClass:"text-right",callback:"memoryFormatter",width:"9%"},{name:"__slot:data-samples",sortField:"cnt",title:"Samples",titleClass:"text-center",dataClass:"text-center",callback:"countFormatter",width:"9%"},{name:"deleteLink",sortField:"deleteLink",title:"",titleClass:"text-center",dataClass:"text-center",callback:"deleteFormatter",width:"5%"},{name:"maxTotalPageLoad",visible:!1},{name:"domInteractive",visible:!1},{name:"firstContentfulPaint",visible:!1},{name:"firstPaint",visible:!1},{name:"firstByte",visible:!1},{name:"connect",visible:!1},{name:"dns",visible:!1}],C={components:{vuetable:l,"vuetable-pagination":o,"vuetable-pagination-info":d,"vuetable-filter-bar":f,"request-bar-chart":u,"page-result-cell":m,"sample-size-warning":g},props:{start:{type:String,default:""},end:{type:String,default:""},fastColor:{type:String,default:"#00C800"},averageColor:{type:String,default:"#FFFF00"},slowColor:{type:String,default:"#C80000"},maxValue:{type:Number,default:1e4},siteId:{type:Number,default:0},apiUrl:{type:String,default:""}},data:function(){return{moreParams:{siteId:this.siteId,start:this.start,end:this.end,filter:""},css:{tableClass:"data fullwidth webperf-pages-index",ascendingIcon:"menubtn webperf-menubtn-asc",descendingIcon:"menubtn webperf-menubtn-desc"},sortOrder:[{field:"__slot:load-time-bar",sortField:"pageLoad",direction:"desc"}],fields:v,triBlend:new c(this.fastColor,this.averageColor,this.slowColor)}},mounted(){this.$events.$on("filter-set",e=>this.onFilterSet(e)),this.$events.$on("filter-reset",()=>this.onFilterReset()),this.$events.$on("change-range",e=>this.onChangeRange(e))},methods:{onFilterSet(e){this.moreParams.filter=e,this.$events.fire("refresh-table",this.$refs.vuetable)},onFilterReset(){this.moreParams.filter="",this.$events.fire("refresh-table",this.$refs.vuetable)},onLoaded(){this.$events.fire("refresh-table-components",this.$refs.vuetable)},onPaginationData(e){this.$refs.paginationTop.setPaginationData(e),this.$refs.paginationInfoTop.setPaginationData(e),this.$refs.pagination.setPaginationData(e),this.$refs.paginationInfo.setPaginationData(e)},onChangePage(e){this.$refs.vuetable.changePage(e)},onRowClicked(e){e.detailPageUrl.length&&(window.location.href=e.detailPageUrl)},onChangeRange(e){this.moreParams.start=e.start,this.moreParams.end=e.end,this.$events.fire("refresh-table",this.$refs.vuetable)},computeWidth(e,t){let a=e/t*100;return a>100&&(a=100),a},statFormatter(e){return Number(e/1e3).toFixed(2)+"s"},countFormatter(e){return Number(e).toFixed(0)},memoryFormatter(e){return Number(e/(1024*1024)).toFixed(2)+" Mb"},deleteFormatter(e){return e===""?"":`
                <a class="delete icon" href="${e}" title="Delete"></a>
                `}}};var w=function(){var t=this,a=t._self._c;return a("div",{staticClass:"py-4"},[a("vuetable-filter-bar"),a("div",{staticClass:"vuetable-pagination clearafter"},[a("vuetable-pagination-info",{ref:"paginationInfoTop",attrs:{"info-template":"Displaying {from} to {to} of {total} pages"}}),a("vuetable-pagination",{ref:"paginationTop",on:{"vuetable-pagination:change-page":t.onChangePage}})],1),a("div",{staticClass:"overflow-x-auto overflow-y-hidden"},[a("vuetable",{ref:"vuetable",attrs:{"api-url":t.apiUrl,"append-params":t.moreParams,css:t.css,fields:t.fields,"per-page":20,"sort-order":t.sortOrder},on:{"vuetable:pagination-data":t.onPaginationData,"vuetable:row-clicked":t.onRowClicked,"vuetable:loaded":t.onLoaded},scopedSlots:t._u([{key:"page-listing-display",fn:function(r){return[a("page-result-cell",{attrs:{color:t.triBlend.colorFromPercentage(r.rowData.pageLoad/t.maxValue*100),title:r.rowData.title,url:r.rowData.url,width:t.computeWidth(r.rowData.pageLoad,t.maxValue)}})]}},{key:"load-time-bar",fn:function(r){return[a("request-bar-chart",{attrs:{"row-data":r.rowData}})]}},{key:"data-samples",fn:function(r){return[a("sample-size-warning",{attrs:{sample:r.rowData.cnt}}),t._v(" "+t._s(r.rowData.cnt)+" ")]}}])})],1),a("div",{staticClass:"vuetable-pagination clearafter"},[a("vuetable-pagination-info",{ref:"paginationInfo",attrs:{"info-template":"Displaying {from} to {to} of {total} pages"}}),a("vuetable-pagination",{ref:"pagination",on:{"vuetable-pagination:change-page":t.onChangePage}})],1)],1)},F=[],P=p(C,w,F,!1,null,null,null,null);const _=P.exports,i=window.Vue;i.use(n);new i({el:"#cp-nav-content",components:{PerformanceIndexTable:_,SampleRangePicker:s,PerformanceDetailAreaChart:h,RecommendationsList:b},mounted(){this.$events.$on("refresh-table",e=>this.onTableRefresh(e))},methods:{onTableRefresh(e){i.nextTick(()=>e.refresh())}}});
//# sourceMappingURL=performance-index-LQx55-1r.js.map
