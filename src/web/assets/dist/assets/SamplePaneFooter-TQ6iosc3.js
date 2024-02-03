import{n as i,A as r}from"./vue-apexcharts-KYvHKhev.js";const l=t=>({baseURL:t,headers:{"X-Requested-With":"XMLHttpRequest"}}),o=(t,e,a,n)=>{t.get(e,{params:a}).then(s=>{n&&n(s.data)}).catch(s=>{console.log(s)})},d={components:{},props:{start:{type:String,default:""},end:{type:String,default:""},column:{type:String,default:""},displayDevModeWarning:{type:Boolean,default:!1},pageUrl:{type:String,default:""},subject:{type:String,default:""},siteId:{type:Number,default:0},apiUrl:{type:String,default:""}},data:function(){return{samples:0,displayStart:this.start,displayEnd:this.end,displayMaxValue:this.maxValue}},created(){this.getSeriesData()},mounted(){this.$events.$on("change-range",t=>this.onChangeRange(t))},methods:{getSeriesData:async function(){const t=r.create(l(this.apiUrl));let e={column:this.column,start:this.displayStart,end:this.displayEnd,pageUrl:this.pageUrl,siteId:this.siteId};await o(t,"",e,a=>{a.cnt!==void 0&&(this.samples=a.cnt)})},onChangeRange(t){this.displayStart=t.start,this.displayEnd=t.end,this.getSeriesData()},formatNumber(t){return t.toString().replace(/\B(?=(\d{3})+(?!\d))/g,",")}}};var c=function(){var e=this,a=e._self._c;return a("div",{staticClass:"field"},[a("div",{staticClass:"heading"},[a("p",{staticClass:"instructions"},[e._v(" The "+e._s(e.subject)+" data is an "),a("em",[e._v("average")]),e._v(" of "),a("strong",[e._v(e._s(e.formatNumber(e.samples)))]),e._v(" data sample"),e.samples!==1?a("span",[e._v("s")]):e._e(),e._v(". ")])]),e.samples<100?a("p",{staticClass:"warning"},[e._v(" Webperf has collected less than "),a("strong",[e._v("100")]),e._v(" data samples. The sample size is not statistically significant, so above averaged results may not be meaningful. ")]):e._e(),e.displayDevModeWarning?a("p",{staticClass:"warning"},[e._v(" Craft performance will be slower than normal with "),a("code",[e._v("devMode")]),e._v(" enabled due to extensive logging and disabling of some caches. "),e._m(0)]):e._e()])},p=[function(){var t=this,e=t._self._c;return e("span",{staticClass:"field inline-block m-0"},[e("a",{staticClass:"notice go",attrs:{href:"https://craftcms.com/guides/what-dev-mode-does",target:"_blank"}},[t._v("Learn More")])])}],m=i(d,c,p,!1,null,null,null,null);const g=m.exports;export{g as S};
//# sourceMappingURL=SamplePaneFooter-TQ6iosc3.js.map