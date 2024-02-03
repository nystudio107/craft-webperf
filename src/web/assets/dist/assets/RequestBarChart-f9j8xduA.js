import{n as r}from"./vue-apexcharts-KYvHKhev.js";const o={name:"RequestBarRecursive",props:{column:{type:String,default:""},color:{type:String,default:""},label:{type:String,default:""},value:{type:Number,default:0},parentValue:{type:Number,default:0},nodes:{type:Array,default:()=>[]}},methods:{statFormatter(a){return Number(a/1e3).toFixed(2)+"s"}}};var n=function(){var e=this,t=e._self._c;return t("div",{staticClass:"h-5",class:e.color,style:{width:e.value/e.parentValue*100+"%"},attrs:{title:e.label+" "+e.statFormatter(e.value)}},e._l(e.nodes,function(l){return t("request-bar-recursive",{key:l.column,attrs:{color:l.color,column:l.column,label:l.label,nodes:l.nodes,"parent-value":l.parentValue,value:l.value}})}),1)},s=[],u=r(o,n,s,!1,null,null,null,null);const c=u.exports,i=[{column:"pageLoad",color:"bg-blue-200",label:"Page Loaded"},{column:"domInteractive",color:"bg-blue-400",label:"DOM Interactive"},{column:"firstContentfulPaint",color:"bg-blue-500",label:"First Contentful Paint"},{column:"firstPaint",color:"bg-blue-700",label:"First Paint"},{column:"firstByte",color:"bg-orange-400",label:"First Byte"},{column:"connect",color:"bg-orange-500",label:"Connect"},{column:"dns",color:"bg-orange-700",label:"DNS Lookup"},{column:"craftTotalMs",color:"bg-red-400",label:"Craft Rendering"},{column:"craftTwigMs",color:"bg-red-500",label:"Twig Rendering"},{column:"craftDbMs",color:"bg-red-700",label:"Database Queries"}],d={name:"RequestBarChart",components:{"request-bar-recursive":c},props:{rowData:{type:Object,default:()=>({})}},data:function(){return{root:void 0}},mounted(){this.$events!==void 0&&this.$events.$on("refresh-table-components",a=>this.onTableRefresh(a))},created(){this.calculateNodes()},methods:{onTableRefresh:function(){this.calculateNodes()},statFormatter(a){return Number(a/1e3).toFixed(2)+"s"},calculateNodes:function(){this.root=void 0,i.forEach(a=>{let e={column:a.column,color:a.color,label:a.label,value:parseFloat(this.rowData[a.column])||null,parentValue:parseFloat(this.rowData.maxTotalPageLoad)||null,nodes:void 0};if(e.value)if(this.root){let t=this.root;for(;t;)!t.nodes||!t.value||e.value>t.value?(e.nodes=t.nodes,e.parentValue=t.parentValue||t.value,t.nodes=[e],t=e.nodes||void 0):t=t.nodes[0]||void 0}else this.root=e})}}};var f=function(){var e=this,t=e._self._c;return t("div",{staticClass:"flex flex-no-wrap"},[e.rowData.type==="both"?t("div",{staticClass:"flex-shrink",attrs:{title:"Combined Frontend & Craft Beacon"}},[t("div",{staticClass:"w-2 h-2 bg-blue-700 rounded-full mb-1"}),t("div",{staticClass:"w-2 h-2 bg-orange-700 rounded-full"})]):e._e(),e.rowData.type==="frontend"?t("div",{staticClass:"flex-shrink",attrs:{title:"Frontend Beacon only"}},[t("div",{staticClass:"w-2 h-2 bg-blue-700 rounded-full mb-1"}),t("div",{staticClass:"w-2 h-2 bg-transparent rounded-full"})]):e._e(),e.rowData.type==="craft"?t("div",{staticClass:"flex-shrink",attrs:{title:"Craft Beacon only"}},[t("div",{staticClass:"w-2 h-2 bg-transparent rounded-full mb-1"}),t("div",{staticClass:"w-2 h-2 bg-orange-700 rounded-full"})]):e._e(),t("div",{staticClass:"flex-grow"},[t("request-bar-recursive",{attrs:{color:e.root.color,column:e.root.column,label:e.root.label,nodes:e.root.nodes,"parent-value":e.root.parentValue,value:e.root.value}})],1),t("div",{staticClass:"flex-shrink"},[e._v(" "+e._s(e.statFormatter(e.root.value))+" ")])])},b=[],v=r(d,f,b,!1,null,null,null,null);const p=v.exports;export{p as R};
//# sourceMappingURL=RequestBarChart-f9j8xduA.js.map