import{_ as k,S as F}from"./SampleRangePicker.f22425b8.js";import{c as M,g as $,n as g,a as R}from"./vue-apexcharts.159e071b.js";import{R as I,S as D}from"./SimpleBarChart.5ce065d9.js";import{T as E}from"./tri-color-blend.3ecffd12.js";import{S as H}from"./SampleSizeWarning.8f20eec9.js";import{S as A}from"./SamplePaneFooter.eadc9035.js";import{R as B}from"./RecommendationsList.281cf6fa.js";var x={exports:{}};(function(t,c){(function(a,s){t.exports=s()})(M,function(){return function(a){function s(r){if(h[r])return h[r].exports;var n=h[r]={i:r,l:!1,exports:{}};return a[r].call(n.exports,n,n.exports,s),n.l=!0,n.exports}var h={};return s.m=a,s.c=h,s.d=function(r,n,d){s.o(r,n)||Object.defineProperty(r,n,{configurable:!1,enumerable:!0,get:d})},s.n=function(r){var n=r&&r.__esModule?function(){return r.default}:function(){return r};return s.d(n,"a",n),n},s.o=function(r,n){return Object.prototype.hasOwnProperty.call(r,n)},s.p="",s(s.s=0)}([function(a,s,h){Object.defineProperty(s,"__esModule",{value:!0});var r=h(1);h.d(s,"Confetti",function(){return r.a}),s.default={install:function(n,d){this.installed||(this.installed=!0,n.prototype.$confetti=new r.a(d))}}},function(a,s,h){function r(e,i){if(!(e instanceof i))throw new TypeError("Cannot call a class as a function")}var n=h(2),d=function(){function e(i,l){for(var o=0;o<l.length;o++){var u=l[o];u.enumerable=u.enumerable||!1,u.configurable=!0,"value"in u&&(u.writable=!0),Object.defineProperty(i,u.key,u)}}return function(i,l,o){return l&&e(i.prototype,l),o&&e(i,o),i}}(),p=function(){function e(){r(this,e),this.initialize(),this.onResizeCallback=this.updateDimensions.bind(this)}return d(e,[{key:"initialize",value:function(){this.canvas=null,this.ctx=null,this.W=0,this.H=0,this.particles={},this.droppedCount=0,this.particlesPerFrame=1.5,this.wind=0,this.windSpeed=1,this.windSpeedMax=1,this.windChange=.01,this.windPosCoef=.002,this.maxParticlesPerFrame=2,this.animationId=null}},{key:"createParticles",value:function(){var i=arguments.length>0&&arguments[0]!==void 0?arguments[0]:{};this.particles=new n.a({ctx:this.ctx,W:this.W,H:this.H,wind:this.wind,windPosCoef:this.windPosCoef,windSpeedMax:this.windSpeedMax,count:0,shape:i.shape||"circle",colors:{opts:i.colors||["DodgerBlue","OliveDrab","Gold","pink","SlateBlue","lightblue","Violet","PaleGreen","SteelBlue","SandyBrown","Chocolate","Crimson"],idx:0,step:10,get color(){return this.opts[(this.idx++/this.step|0)%this.opts.length]}}})}},{key:"createContext",value:function(){this.canvas=document.createElement("canvas"),this.ctx=this.canvas.getContext("2d"),this.canvas.style.display="block",this.canvas.style.position="fixed",this.canvas.style.pointerEvents="none",this.canvas.style.top=0,this.canvas.style.width="100vw",this.canvas.style.height="100vh",this.canvas.id="confetti-canvas",document.querySelector("body").appendChild(this.canvas)}},{key:"start",value:function(i){this.ctx||this.createContext(),this.animationId&&cancelAnimationFrame(this.animationId),this.createParticles(i),this.updateDimensions(),this.particlesPerFrame=this.maxParticlesPerFrame,this.animationId=requestAnimationFrame(this.mainLoop.bind(this)),window.addEventListener("resize",this.onResizeCallback)}},{key:"stop",value:function(){this.particlesPerFrame=0,window.removeEventListener("resize",this.onResizeCallback)}},{key:"remove",value:function(){this.stop(),this.animationId&&cancelAnimationFrame(this.animationId),this.canvas&&document.body.removeChild(this.canvas),this.initialize()}},{key:"updateDimensions",value:function(){this.W===window.innerWidth&&this.H===window.innerHeight||(this.W=this.particles.opts.W=this.canvas.width=window.innerWidth,this.H=this.particles.opts.H=this.canvas.height=window.innerHeight)}},{key:"mainLoop",value:function(i){for(this.updateDimensions(),this.ctx.setTransform(1,0,0,1,0,0),this.ctx.clearRect(0,0,this.W,this.H),this.windSpeed=Math.sin(i/8e3)*this.windSpeedMax,this.wind=this.particles.opts.wind+=this.windChange;this.droppedCount<this.particlesPerFrame;)this.droppedCount+=1,this.particles.add();this.droppedCount-=this.particlesPerFrame,this.particles.update(),this.particles.draw(),this.particles.items.length&&(this.animationId=requestAnimationFrame(this.mainLoop.bind(this)))}}]),e}();s.a=p},function(a,s,h){function r(e,i){if(!(e instanceof i))throw new TypeError("Cannot call a class as a function")}var n=h(3),d=function(){function e(i,l){for(var o=0;o<l.length;o++){var u=l[o];u.enumerable=u.enumerable||!1,u.configurable=!0,"value"in u&&(u.writable=!0),Object.defineProperty(i,u.key,u)}}return function(i,l,o){return l&&e(i.prototype,l),o&&e(i,o),i}}(),p=function(){function e(i){r(this,e),this.items=[],this.pool=[],this.opts=i}return d(e,[{key:"update",value:function(){for(var i=0;i<this.items.length;i++)this.items[i].update()===!0&&this.pool.push(this.items.splice(i--,1)[0])}},{key:"draw",value:function(){for(var i=0;i<this.items.length;i++)this.items[i].draw()}},{key:"add",value:function(){this.pool.length>0?this.items.push(this.pool.pop().setup(this.opts)):this.items.push(new n.a().setup(this.opts))}}]),e}();s.a=p},function(a,s,h){function r(p,e){if(!(p instanceof e))throw new TypeError("Cannot call a class as a function")}var n=function(){function p(e,i){for(var l=0;l<i.length;l++){var o=i[l];o.enumerable=o.enumerable||!1,o.configurable=!0,"value"in o&&(o.writable=!0),Object.defineProperty(e,o.key,o)}}return function(e,i,l){return i&&p(e.prototype,i),l&&p(e,l),e}}(),d=function(){function p(){r(this,p)}return n(p,[{key:"setup",value:function(e){var i=e.ctx,l=e.W,o=e.H,u=e.colors,f=e.wind,m=e.windPosCoef,v=e.windSpeedMax,S=e.count,P=e.shape;return this.ctx=i,this.W=l,this.H=o,this.wind=f,this.shape=P,this.windPosCoef=m,this.windSpeedMax=v,this.x=this.rand(-35,l+35),this.y=this.rand(-30,-35),this.d=this.rand(150)+10,this.r=this.rand(10,30),this.color=u.color,this.tilt=this.randI(10),this.tiltAngleIncremental=(this.rand(.08)+.04)*(this.rand()<.5?-1:1),this.tiltAngle=0,this.angle=this.rand(2*Math.PI),this.count=S++,this}},{key:"randI",value:function(e){var i=arguments.length>1&&arguments[1]!==void 0?arguments[1]:e+(e=0);return Math.random()*(i-e)+e|0}},{key:"rand",value:function(){var e=arguments.length>0&&arguments[0]!==void 0?arguments[0]:1,i=arguments.length>1&&arguments[1]!==void 0?arguments[1]:e+(e=0);return Math.random()*(i-e)+e}},{key:"update",value:function(){return this.tiltAngle+=this.tiltAngleIncremental*(.2*Math.cos(this.wind+(this.d+this.x+this.y)*this.windPosCoef)+1),this.y+=(Math.cos(this.angle+this.d)+3+this.r/2)/2,this.x+=Math.sin(this.angle),this.x+=Math.cos(this.wind+(this.d+this.x+this.y)*this.windPosCoef)*this.windSpeedMax,this.y+=Math.sin(this.wind+(this.d+this.x+this.y)*this.windPosCoef)*this.windSpeedMax,this.tilt=15*Math.sin(this.tiltAngle-this.count/3),this.y>this.H}},{key:"drawCircle",value:function(){this.ctx.arc(0,0,this.r/2,0,2*Math.PI,!1),this.ctx.fill()}},{key:"drawRect",value:function(){this.ctx.fillRect(0,0,this.r,this.r/2)}},{key:"drawHeart",value:function(){var e=this,i=function(l,o,u,f,m,v){e.ctx.bezierCurveTo(l/e.r*2,o/e.r*2,u/e.r*2,f/e.r*2,m/e.r*2,v/e.r*2)};this.ctx.moveTo(37.5/this.r,20/this.r),i(75,37,70,25,50,25),i(20,25,20,62.5,20,62.5),i(20,80,40,102,75,120),i(110,102,130,80,130,62.5),i(130,62.5,130,25,100,25),i(85,25,75,37,75,40),this.ctx.fill()}},{key:"draw",value:function(){this.ctx.fillStyle=this.color,this.ctx.beginPath(),this.ctx.setTransform(Math.cos(this.tiltAngle),Math.sin(this.tiltAngle),0,1,this.x,this.y),this.shape==="circle"?this.drawCircle():this.shape==="rect"?this.drawRect():this.shape==="heart"&&this.drawHeart()}}]),p}();s.a=d}])})})(x);var W=$(x.exports),z=function(){var t=this,c=t.$createElement,a=t._self._c||c;return a("main")},L=[];const C=window.Vue;C.use(W);const T=C.extend({mounted:function(){this.$confetti.start({shape:"rect",colors:["DodgerBlue","OliveDrab","Gold","pink","SlateBlue","lightblue","Violet","PaleGreen","SteelBlue","SandyBrown","Chocolate","Crimson"]}),setTimeout(()=>{this.$confetti.stop()},5e3)},methods:{}}),y={};var V=g(T,z,L,!1,j,null,null,null);function j(t){for(let c in y)this[c]=y[c]}var O=function(){return V.exports}(),q=function(){var t=this,c=t.$createElement,a=t._self._c||c;return a("div",{on:{click:function(s){return t.redirectTo(t.detailPageUrl)}}},[a("div",{staticClass:"clearafter pb-1"},[a("div",{staticClass:"simple-bar-chart-label text-base font-normal truncate-label",staticStyle:{width:"90%"},attrs:{title:t.title}},[t.title?a("a",{staticStyle:{color:"rgb(26 13 171)"},attrs:{href:t.url,target:"_blank"},on:{click:function(s){s.stopPropagation()}}},[t._v(" "+t._s(t.title)+" ")]):a("span",{staticClass:"text-gray-300"},[a("em",[t._v("Craft backend route")])])]),a("div",{staticClass:"simple-bar-chart-value"},[a("sample-size-warning",{attrs:{sample:t.cnt}})],1)]),a("div",{staticClass:"clearafter pb-1"},[a("cite",{staticClass:"simple-bar-chart-label text-sm font-normal truncate-label",staticStyle:{width:"80%"},attrs:{title:t.url}},[a("a",{staticClass:"hover:no-underline",staticStyle:{color:"rgb(0 102 33)"},attrs:{href:t.url,target:"_blank"},on:{click:function(s){s.stopPropagation()}}},[t._v(" "+t._s(t.url)+" ")])]),a("div",{staticClass:"simple-bar-chart-value text-sm font-bold"},[t._v(" "+t._s(t.data)+" ")])]),a("div",{staticClass:"py-1"},[a("div",{staticClass:"file-list-chart-track rounded-full bg-gray-200"},[a("div",{staticClass:"simple-bar-line h-2 rounded-full",style:{width:t.width+"%",backgroundColor:t.color}})])])])},N=[];const U={name:"DashboardFileListCell",components:{SampleSizeWarning:H},props:{title:{type:String,default:""},url:{type:String,default:""},detailPageUrl:{type:String,default:""},data:{type:String,default:""},cnt:{type:Number,default:0},width:{type:Number,default:0},color:{type:String,default:""}},methods:{redirectTo(t){window.location.href=t}}},w={};var G=g(U,q,N,!1,X,null,null,null);function X(t){for(let c in w)this[c]=w[c]}var J=function(){return G.exports}(),K=function(){var t=this,c=t.$createElement,a=t._self._c||c;return a("section",{staticClass:"px-3 py-3"},[a("div",{staticClass:"text-left text-base font-bold px-2 pt-2"},[t._v(" Slowest pages ")]),t._l(t.series,function(s,h){return a("div",{key:h,staticClass:"file-list-wrapper p-2"},[a("dashboard-file-list-cell",{attrs:{cnt:s.cnt,color:s.barColor,data:t.statFormatter(s.data,s.maxValue),"detail-page-url":s.detailPageUrl,title:s.title,url:s.url,width:s.data}})],1)})],2)},Q=[];const Y=t=>({baseURL:t,headers:{"X-Requested-With":"XMLHttpRequest"}}),Z=(t,c,a,s)=>{t.get(c,{params:a}).then(h=>{s&&s(h.data)}).catch(h=>{console.log(h)})},tt={name:"DashboardFileList",components:{"dashboard-file-list-cell":J},props:{start:{type:String,default:""},end:{type:String,default:""},column:{type:String,default:""},fastColor:{type:String,default:"#00C800"},averageColor:{type:String,default:"#FFFF00"},slowColor:{type:String,default:"#C80000"},limit:{type:Number,default:3},maxValue:{type:Number,default:1e4},siteId:{type:Number,default:0},apiUrl:{type:String,default:""}},data:function(){return{series:[],displayStart:this.start,displayEnd:this.end,triBlend:new E(this.fastColor,this.averageColor,this.slowColor)}},created(){this.getSeriesData()},mounted(){this.$events.$on("change-range",t=>this.onChangeRange(t))},methods:{getSeriesData:async function(){const t=R.create(Y(this.apiUrl));let c={column:this.column,start:this.displayStart,end:this.displayEnd,siteId:this.siteId};await Z(t,"",c,a=>{a.forEach((s,h,r)=>{let n=s.avg/1e3,d=this.maxValue;n>d&&(d=n),n=n*100/d,r[h].data=n,r[h].maxValue=d,r[h].barColor=this.triBlend.colorFromPercentage(n)}),this.series=a})},onChangeRange(t){this.displayStart=t.start,this.displayEnd=t.end,this.getSeriesData()},statFormatter(t,c){return t=t*c/100,Number(t).toFixed(2)+"s"}}},b={};var et=g(tt,K,Q,!1,it,null,null,null);function it(t){for(let c in b)this[c]=b[c]}var st=function(){return et.exports}();const _=window.Vue;_.use(k);new _({el:"#cp-nav-content",components:{ConfettiParty:O,RadialBarChart:I,SimpleBarChart:D,DashboardFileList:st,SampleRangePicker:F,SamplePaneFooter:A,RecommendationsList:B}});
//# sourceMappingURL=dashboard.c5f98da7.js.map