import{n as i,a as n,A as l}from"./vue-apexcharts-KYvHKhev.js";const o=t=>t.map(function(e){return Math.max.apply(null,e)}),h=t=>({baseURL:t,headers:{"X-Requested-With":"XMLHttpRequest"}}),p=(t,e,a,s)=>{t.get(e,{params:a}).then(r=>{s&&s(r.data)}).catch(r=>{console.log(r)})},d={components:{apexcharts:n},props:{title:{type:String,default:""},start:{type:String,default:""},end:{type:String,default:""},pageUrl:{type:String,default:""},siteId:{type:Number,default:0},apiUrl:{type:String,default:""}},data:function(){return{chartOptions:{chart:{id:"vuechart-pages-detail",toolbar:{show:!1},sparkline:{enabled:!1},animations:{enabled:!1}},dataLabels:{enabled:!1},tooltip:{enabled:!0,inverseOrder:!0,x:{show:!1}},colors:["#CC1F1A","#E3342F","#EF5753","#DE751F","#F6993F","#FAAD63","#2779BD","#3490DC","#6CB2EB","#BCDEFA"],stroke:{curve:"smooth",width:3},fill:{type:"solid",opacity:.9,gradient:{enabled:!1}},legend:{formatter:void 0,offsetX:0,offsetY:-10},xaxis:{type:"category",labels:{show:!1,minHeight:"20px"},crosshairs:{width:1}},yaxis:{min:0,max:0,seriesName:"Time",labels:{formatter:t=>this.statFormatter(t)}},labels:[],title:{text:this.title,offsetX:0,style:{fontSize:"24px",cssClass:"apexcharts-yaxis-title"}}},series:[{name:"empty",data:[0]}],displayStart:this.start,displayEnd:this.end,displayMaxValue:this.maxValue}},created(){this.getSeriesData()},mounted(){this.$events.$on("change-range",t=>this.onChangeRange(t))},methods:{getSeriesData:async function(){const t=l.create(h(this.apiUrl));let e={start:this.displayStart,end:this.displayEnd,pageUrl:this.pageUrl,siteId:this.siteId};await p(t,"",e,a=>{if(a[0]!==void 0){let s=o([a[9].data])[0];s=Math.ceil(s/1e3)*1e3,this.chartOptions={...this.chartOptions,yaxis:{min:0,max:s,labels:{formatter:r=>this.statFormatter(r)}},xaxis:{categories:a[0].labels,type:"category",labels:{show:!1,minHeight:"20px"},crosshairs:{width:1}},labels:a[0].labels},this.series=a}})},onChangeRange(t){this.displayStart=t.start,this.displayEnd=t.end,this.getSeriesData()},statFormatter(t){return Number(t/1e3).toFixed(2)+"s"}}};var c=function(){var e=this,a=e._self._c;return a("apexcharts",{attrs:{options:e.chartOptions,series:e.series,height:"450px",type:"area",width:"100%"}})},f=[],u=i(d,c,f,!1,null,null,null,null);const g=u.exports;export{g as P};
//# sourceMappingURL=PerformanceDetailAreaChart-558NUFam.js.map
