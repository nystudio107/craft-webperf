import{n as s,d as l,_ as o}from"./vendor.6a8d211c.js";import{V as d,a as f,b as m,P as c}from"./PageResultCell.2fbd23df.js";import{T as u}from"./tri-color-blend.3ecffd12.js";import{R as g}from"./RequestBarChart.64ff66ea.js";import{S as p}from"./SampleSizeWarning.458ccd25.js";import{S as h}from"./SampleRangePicker.50e8bc5d.js";import{P as b}from"./PerformanceDetailAreaChart.81872007.js";import{R as v}from"./RecommendationsList.3878d655.js";import"./SamplePaneFooter.8a4aac23.js";var C=[{name:"__slot:page-listing-display",sortField:"url",title:"Page",titleClass:"center pageListingDisplay",dataClass:"center",width:"30%"},{name:"__slot:load-time-bar",sortField:"pageLoad",title:"Performance Timeline",titleClass:"center loadTimeBar",dataClass:"center",width:"20%"},{name:"craftDbCnt",sortField:"craftDbCnt",title:"Queries",titleClass:"text-right",dataClass:"text-right",callback:"countFormatter",width:"9%"},{name:"craftTwigCnt",sortField:"craftTwigCnt",title:"Templates",titleClass:"text-right",dataClass:"text-right",callback:"countFormatter",width:"9%"},{name:"craftOtherCnt",sortField:"craftOtherCnt",title:"Other",titleClass:"text-right",dataClass:"text-right",callback:"countFormatter",width:"9%"},{name:"craftTotalMemory",sortField:"craftTotalMemory",title:"Memory",titleClass:"text-right",dataClass:"text-right",callback:"memoryFormatter",width:"9%"},{name:"__slot:data-samples",sortField:"cnt",title:"Samples",titleClass:"text-center",dataClass:"text-center",callback:"countFormatter",width:"9%"},{name:"deleteLink",sortField:"deleteLink",title:"",titleClass:"text-center",dataClass:"text-center",callback:"deleteFormatter",width:"5%"},{name:"maxTotalPageLoad",visible:!1},{name:"domInteractive",visible:!1},{name:"firstContentfulPaint",visible:!1},{name:"firstPaint",visible:!1},{name:"firstByte",visible:!1},{name:"connect",visible:!1},{name:"dns",visible:!1}],w=function(){var e=this,r=e.$createElement,t=e._self._c||r;return t("div",{staticClass:"py-4"},[t("vuetable-filter-bar"),t("div",{staticClass:"vuetable-pagination clearafter"},[t("vuetable-pagination-info",{ref:"paginationInfoTop",attrs:{"info-template":"Displaying {from} to {to} of {total} pages"}}),t("vuetable-pagination",{ref:"paginationTop",on:{"vuetable-pagination:change-page":e.onChangePage}})],1),t("div",{staticClass:"overflow-x-auto overflow-y-hidden"},[t("vuetable",{ref:"vuetable",attrs:{"api-url":e.apiUrl,"append-params":e.moreParams,css:e.css,fields:e.fields,"per-page":20,"sort-order":e.sortOrder},on:{"vuetable:pagination-data":e.onPaginationData,"vuetable:row-clicked":e.onRowClicked,"vuetable:loaded":e.onLoaded},scopedSlots:e._u([{key:"page-listing-display",fn:function(a){return[t("page-result-cell",{attrs:{color:e.triBlend.colorFromPercentage(a.rowData.pageLoad/e.maxValue*100),title:a.rowData.title,url:a.rowData.url,width:e.computeWidth(a.rowData.pageLoad,e.maxValue)}})]}},{key:"load-time-bar",fn:function(a){return[t("request-bar-chart",{attrs:{"row-data":a.rowData}})]}},{key:"data-samples",fn:function(a){return[t("sample-size-warning",{attrs:{sample:a.rowData.cnt}}),e._v(" "+e._s(a.rowData.cnt)+" ")]}}])})],1),t("div",{staticClass:"vuetable-pagination clearafter"},[t("vuetable-pagination-info",{ref:"paginationInfo",attrs:{"info-template":"Displaying {from} to {to} of {total} pages"}}),t("vuetable-pagination",{ref:"pagination",on:{"vuetable-pagination:change-page":e.onChangePage}})],1)],1)},P=[];const F={components:{vuetable:l,"vuetable-pagination":d,"vuetable-pagination-info":f,"vuetable-filter-bar":m,"request-bar-chart":g,"page-result-cell":c,"sample-size-warning":p},props:{start:{type:String,default:""},end:{type:String,default:""},fastColor:{type:String,default:"#00C800"},averageColor:{type:String,default:"#FFFF00"},slowColor:{type:String,default:"#C80000"},maxValue:{type:Number,default:1e4},siteId:{type:Number,default:0},apiUrl:{type:String,default:""}},data:function(){return{moreParams:{siteId:this.siteId,start:this.start,end:this.end,filter:""},css:{tableClass:"data fullwidth webperf-pages-index",ascendingIcon:"menubtn webperf-menubtn-asc",descendingIcon:"menubtn webperf-menubtn-desc"},sortOrder:[{field:"__slot:load-time-bar",sortField:"pageLoad",direction:"desc"}],fields:C,triBlend:new u(this.fastColor,this.averageColor,this.slowColor)}},mounted(){this.$events.$on("filter-set",e=>this.onFilterSet(e)),this.$events.$on("filter-reset",()=>this.onFilterReset()),this.$events.$on("change-range",e=>this.onChangeRange(e))},methods:{onFilterSet(e){this.moreParams.filter=e,this.$events.fire("refresh-table",this.$refs.vuetable)},onFilterReset(){this.moreParams.filter="",this.$events.fire("refresh-table",this.$refs.vuetable)},onLoaded(){this.$events.fire("refresh-table-components",this.$refs.vuetable)},onPaginationData(e){this.$refs.paginationTop.setPaginationData(e),this.$refs.paginationInfoTop.setPaginationData(e),this.$refs.pagination.setPaginationData(e),this.$refs.paginationInfo.setPaginationData(e)},onChangePage(e){this.$refs.vuetable.changePage(e)},onRowClicked(e){e.detailPageUrl.length&&(window.location.href=e.detailPageUrl)},onChangeRange(e){this.moreParams.start=e.start,this.moreParams.end=e.end,this.$events.fire("refresh-table",this.$refs.vuetable)},computeWidth(e,r){let t=e/r*100;return t>100&&(t=100),t},statFormatter(e){return Number(e/1e3).toFixed(2)+"s"},countFormatter(e){return Number(e).toFixed(0)},memoryFormatter(e){return Number(e/(1024*1024)).toFixed(2)+" Mb"},deleteFormatter(e){return e===""?"":`
                <a class="delete icon" href="${e}" title="Delete"></a>
                `}}},n={};var _=s(F,w,P,!1,x,null,null,null);function x(e){for(let r in n)this[r]=n[r]}var y=function(){return _.exports}();const i=window.Vue;i.use(o);new i({el:"#cp-nav-content",components:{PerformanceIndexTable:y,SampleRangePicker:h,PerformanceDetailAreaChart:b,RecommendationsList:v},mounted(){this.$events.$on("refresh-table",e=>this.onTableRefresh(e))},methods:{onTableRefresh(e){i.nextTick(()=>e.refresh())}}});
//# sourceMappingURL=performance-index.d7fa815e.js.map