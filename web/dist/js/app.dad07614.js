(function(){"use strict";var e={7830:function(e,t,n){var a=n(4870),o=n(9242),s=n(65),r=n(7387),l=n.n(r),i=n(2483),c=n(7139),u=n(3396);const d={key:0,class:(0,c.C_)(["card","text-dark","p-0"])},m={class:"card-header"},p={class:(0,c.C_)(["card-title","text-center"])},b={class:"mb-2"},v=["value"],h={class:"mb-2"},f=["value"],g={class:"mb-2"},w={class:(0,c.C_)(["my-2","text-center"])},_={class:"card-body"},C={class:"table"},y=(0,u._)("thead",null,[(0,u._)("tr",null,[(0,u._)("th",null,"Цифр. код"),(0,u._)("th",null,"Букв. код"),(0,u._)("th",null,"Единиц"),(0,u._)("th",null,"Валюта"),(0,u._)("th",null,"Курс")])],-1);function k(e,t,n,a,o,s){const r=(0,u.up)("SelectComponent"),l=(0,u.up)("InputComponent"),i=(0,u.up)("ModalComponent"),k=(0,u.up)("FlexComponent"),$=(0,u.up)("SpinnerComponent");return(0,u.wg)(),(0,u.j4)(k,{classes:["justify-content-center","align-items-center","min-vh-100","bg-secondary","p-3"]},{default:(0,u.w5)((()=>[s.currencies?((0,u.wg)(),(0,u.iD)("div",d,[(0,u._)("div",m,[(0,u._)("h3",p,(0,c.zw)(s.header),1),(0,u.Wm)(k,{classes:"justify-content-center"},{default:(0,u.w5)((()=>[(0,u.Wm)(i,{ref:"ModalSettings",onSave:s.settings,buttonClasses:"btn-dark",title:"Настройки",header:"Настройки"},{button:(0,u.w5)((()=>[(0,u.Uk)(" Настройки ")])),window:(0,u.w5)((()=>[(0,u._)("form",null,[(0,u._)("div",b,[(0,u.Wm)(r,{modelValue:o.dataLoads,"onUpdate:modelValue":t[0]||(t[0]=e=>o.dataLoads=e),name:"loads[]",label:"Загружаемые валюты",multiple:""},{default:(0,u.w5)((()=>[((0,u.wg)(!0),(0,u.iD)(u.HY,null,(0,u.Ko)(s.originals,(e=>((0,u.wg)(),(0,u.iD)("option",{key:e.num_code,value:e.num_code},(0,c.zw)(e.char_code)+" | "+(0,c.zw)(e.name),9,v)))),128))])),_:1},8,["modelValue"])]),(0,u._)("div",h,[(0,u.Wm)(r,{modelValue:o.dataVisibles,"onUpdate:modelValue":t[1]||(t[1]=e=>o.dataVisibles=e),name:"visible[]",label:"Отображаемые валюты",multiple:""},{default:(0,u.w5)((()=>[((0,u.wg)(!0),(0,u.iD)(u.HY,null,(0,u.Ko)(s.visibles,(e=>((0,u.wg)(),(0,u.iD)("option",{key:e.num_code,value:e.num_code},(0,c.zw)(e.char_code)+" | "+(0,c.zw)(e.name),9,f)))),128))])),_:1},8,["modelValue"])]),(0,u._)("div",g,[(0,u.Wm)(l,{modelValue:o.dataInterval,"onUpdate:modelValue":t[2]||(t[2]=e=>o.dataInterval=e),name:"interval",type:"number",label:"Интервал обновления данных в секундах"},null,8,["modelValue"])])])])),_:1},8,["onSave"])])),_:1}),(0,u._)("p",w,"Интервал обновления данных в секундах: "+(0,c.zw)(s.interval),1)]),(0,u._)("div",_,[(0,u._)("table",C,[y,(0,u._)("tbody",null,[((0,u.wg)(!0),(0,u.iD)(u.HY,null,(0,u.Ko)(s.currencies,(e=>((0,u.wg)(),(0,u.iD)("tr",{key:e.num_code},[(0,u._)("td",null,(0,c.zw)(e.num_code),1),(0,u._)("td",null,(0,c.zw)(e.char_code),1),(0,u._)("td",null,(0,c.zw)(e.nominal),1),(0,u._)("td",null,(0,c.zw)(e.name),1),(0,u._)("td",{class:(0,c.C_)([1===e.changes?"currency-up":"",-1===e.changes?"currency-down":""])},(0,c.zw)(e.value),3)])))),128))])])])])):((0,u.wg)(),(0,u.j4)($,{key:1,classes:"text-light"}))])),_:1})}var $={name:"WelcomeComponent",computed:{header(){return this.$store.state.header},currencies(){return this.$store.state.currencies},originals(){return this.$store.state.originals},visibles(){return this.$store.state.visibles},interval(){return this.$store.state.interval},token(){return this.$store.state.token}},data(){return{dataLoads:[],dataVisibles:[],dataInterval:null}},methods:{async settings(){this.$refs.ModalSettings.close();let e=await l().ajax({url:"/settings",method:"POST",data:{_token:this.token,loads:JSON.stringify(this.dataLoads),visibles:JSON.stringify(this.dataVisibles),interval:this.dataInterval},headers:{"X-CSRF-TOKEN":this.token}});this.$store.commit("currencies",e.currencies),this.$store.commit("visibles",e.visibles),this.$store.commit("interval",e.interval)}},beforeMount(){this.$store.dispatch("currencies")}},S=n(89);const Z=(0,S.Z)($,[["render",k]]);var W=Z,V=n(878),j=n(8829),x=n(2575),M=new WeakMap,O=new WeakMap,D=new WeakMap,I=new WeakMap,z=new WeakMap;class H{constructor(e,t){if((0,V.Z)(this,M,{writable:!0,value:void 0}),(0,V.Z)(this,O,{writable:!0,value:void 0}),(0,V.Z)(this,D,{writable:!0,value:void 0}),(0,V.Z)(this,I,{writable:!0,value:void 0}),(0,V.Z)(this,z,{writable:!0,value:void 0}),"string"!=typeof e)throw new Error("path должен быть типом String");(0,x.Z)(this,M,e.startsWith("/")?e:"/".concat(e)),(0,x.Z)(this,O,t)}static new(e="",t){return new H(e,t)}name(e){return"string"==typeof e&&(0,x.Z)(this,D,e),this}children(e=[]){return(0,x.Z)(this,I,e),this}beforeEnter(e){return(0,x.Z)(this,z,e),this}get(){return{path:(0,j.Z)(this,M),name:(0,j.Z)(this,D),component:(0,j.Z)(this,O),children:(0,j.Z)(this,I),beforeEnter:(0,j.Z)(this,z)}}}var P=H,T=[P["new"]("",W).name("welcome").get()],E=T;const q=(0,i.p7)({history:(0,i.PO)(),routes:E});var F=q,Y=n(680),U={install(e){e.config.globalProperties.$cookie=Y.Z}},B={install(e){e.config.globalProperties.$jquery=l()}},K=n(2166),G={install(e){e.config.globalProperties.$bootstrap=K}};function L(e,t,n,a,o,s){const r=(0,u.up)("router-view");return(0,u.wg)(),(0,u.j4)(r)}var N={name:"App"};const Q=(0,S.Z)(N,[["render",L]]);var R=Q;function J(e,t,n,a,o,s){return(0,u.wg)(),(0,u.iD)("div",{class:(0,c.C_)(["d-flex",n.classes])},[(0,u.WI)(e.$slots,"default")],2)}var X={name:"FlexComponent",props:["classes"]};const A=(0,S.Z)(X,[["render",J]]);var ee=A;function te(e,t,n,a,o,s){const r=(0,u.up)("ButtonComponent"),l=(0,u.up)("WindowComponent");return(0,u.wg)(),(0,u.iD)(u.HY,null,[(0,u.Wm)(r,(0,u.dG)({target:o.id,title:n.title,classes:n.buttonClasses},e.$attrs),{default:(0,u.w5)((()=>[(0,u.WI)(e.$slots,"button")])),_:3},16,["target","title","classes"]),(0,u.Wm)(l,{onSave:t[0]||(t[0]=t=>e.$emit("save")),onClose:s.close,id:o.id,title:n.header,classes:n.windowClasses},{default:(0,u.w5)((()=>[(0,u.WI)(e.$slots,"window")])),_:3},8,["onClose","id","title","classes"])],64)}const ne=["data-bs-target"];function ae(e,t,n,a,o,s){return(0,u.wg)(),(0,u.iD)("button",{onClick:t[0]||(t[0]=t=>e.$emit("show")),type:"button",class:(0,c.C_)(["btn",n.classes]),"data-bs-toggle":"modal","data-bs-target":"#"+n.target},[(0,u.WI)(e.$slots,"default")],10,ne)}var oe={name:"ButtonComponent",props:["classes","target"]};const se=(0,S.Z)(oe,[["render",ae]]);var re=se;const le=["aria-labelledby"],ie={class:"modal-dialog modal-dialog-centered"},ce={class:(0,c.C_)(["modal-content","bg-light","border-light","text-dark"]),style:{"border-radius":"15px"}},ue={class:"modal-header border-secondary border-bottom-0"},de=["id"],me={class:"modal-body"},pe={class:"modal-footer border-top-0"};function be(e,t,n,a,o,s){const r=(0,u.up)("QuitComponent"),l=(0,u.up)("CloseComponent"),i=(0,u.up)("SaveComponent");return(0,u.wg)(),(0,u.iD)("section",{class:(0,c.C_)(["modal","fade",n.classes]),tabindex:"-1","aria-labelledby":o.id,"aria-hidden":"true"},[(0,u._)("div",ie,[(0,u._)("div",ce,[(0,u._)("div",ue,[(0,u._)("h4",{class:"modal-title mb-0",id:o.id},(0,c.zw)(n.title),9,de),(0,u.Wm)(r,{onClose:t[0]||(t[0]=t=>e.$emit("close"))})]),(0,u._)("div",me,[(0,u.WI)(e.$slots,"default")]),(0,u._)("div",pe,[(0,u.Wm)(l,{onClose:t[1]||(t[1]=t=>e.$emit("close"))}),(0,u.Wm)(i,{onSave:t[2]||(t[2]=t=>e.$emit("save"))})])])])],10,le)}function ve(e,t,n,a,o,s){return(0,u.wg)(),(0,u.iD)("button",{onClick:t[0]||(t[0]=t=>e.$emit("close")),type:"button",class:(0,c.C_)(["btn-close",n.classes]),"aria-label":"Закрыть"},null,2)}var he={name:"QuitComponent",props:["classes"],computed:{theme(){return this.$store.state.theme}}};const fe=(0,S.Z)(he,[["render",ve]]);var ge=fe;function we(e,t,n,a,o,s){return(0,u.wg)(),(0,u.iD)("button",{onClick:t[0]||(t[0]=t=>e.$emit("close")),type:"button",class:(0,c.C_)(["btn","btn-secondary",n.classes]),"aria-label":"Закрыть"}," Закрыть ",2)}var _e={name:"CloseComponent",props:["classes"]};const Ce=(0,S.Z)(_e,[["render",we]]);var ye=Ce;function ke(e,t,n,a,o,s){return(0,u.wg)(),(0,u.iD)("button",{onClick:t[0]||(t[0]=t=>e.$emit("save")),type:"button",class:(0,c.C_)(["btn","btn-primary",n.classes])}," Сохранить ",2)}var $e={name:"SaveComponent",props:["classes"]};const Se=(0,S.Z)($e,[["render",ke]]);var Ze=Se;const We=["A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z",1,2,3,4,5,6,7,8,9,0];function Ve(e="id_",t=60){for(var n=e,a=0;a<t;a++)n+=We[je(0,We.length-1)];return n}function je(e=0,t=100){return Math.floor(Math.random()*(t-e))+e}var xe={name:"WindowComponent",components:{QuitComponent:ge,CloseComponent:ye,SaveComponent:Ze},props:{classes:String,title:String},data(){return{id:Ve()}}};const Me=(0,S.Z)(xe,[["render",be]]);var Oe=Me,De={name:"ModalComponent",components:{ButtonComponent:re,WindowComponent:Oe},props:["title","header","buttonClasses","windowClasses"],data(){return{id:Ve()}},methods:{show(){this.$bootstrap.Modal.getInstance(document.getElementById(this.id)).show()},close(){this.$bootstrap.Modal.getInstance(document.getElementById(this.id)).hide()}}};const Ie=(0,S.Z)(De,[["render",te]]);var ze=Ie;const He=(0,u._)("span",{class:"visually-hidden"},"Загрузка...",-1),Pe=[He];function Te(e,t,n,a,o,s){const r=(0,u.up)("FlexComponent");return(0,u.wg)(),(0,u.j4)(r,{classes:"justify-content-center"},{default:(0,u.w5)((()=>[(0,u._)("div",(0,u.dG)({class:["spinner-border",n.classes],role:"status"},e.$attrs),Pe,16)])),_:1})}var Ee={name:"SinnerComponent",props:["classes"]};const qe=(0,S.Z)(Ee,[["render",Te]]);var Fe=qe;const Ye=["for"],Ue=["id","aria-label"];function Be(e,t,n,a,s,r){return(0,u.wg)(),(0,u.iD)(u.HY,null,[n.label?((0,u.wg)(),(0,u.iD)("label",{key:0,for:s.id,class:"form-label"},(0,c.zw)(n.label),9,Ye)):(0,u.kq)("",!0),(0,u.wy)((0,u._)("select",(0,u.dG)({"onUpdate:modelValue":t[0]||(t[0]=e=>s.selected=e),onChange:t[1]||(t[1]=t=>e.$emit("update:modelValue",s.selected)),id:n.label,class:["form-select",n.classes],"aria-label":n.label},e.$attrs),[(0,u.WI)(e.$slots,"default")],16,Ue),[[o.bM,s.selected]])],64)}var Ke={name:"SelectComponent",props:["classes","label","modelValue"],data(){return{id:Ve(),selected:this.modelValue}},emits:["update:modelValue"]};const Ge=(0,S.Z)(Ke,[["render",Be]]);var Le=Ge;const Ne=["for"],Qe=["id","aria-describedby"],Re=["id"];function Je(e,t,n,a,s,r){return(0,u.wg)(),(0,u.iD)(u.HY,null,[n.label?((0,u.wg)(),(0,u.iD)("label",{key:0,for:s.id,class:"form-label"},(0,c.zw)(n.label),9,Ne)):(0,u.kq)("",!0),(0,u.wy)((0,u._)("input",(0,u.dG)({"onUpdate:modelValue":t[0]||(t[0]=e=>r.value=e),class:["form-control","form-control-lg","bg-light","text-dark","border-dark",n.classes],id:s.id,"aria-describedby":s.aria},e.$attrs),null,16,Qe),[[o.YZ,r.value]]),n.small?((0,u.wg)(),(0,u.iD)("small",{key:1,id:s.aria,class:"form-text text-muted"},(0,c.zw)(n.small),9,Re)):(0,u.kq)("",!0)],64)}var Xe={name:"InputComponent",data(){return{id:Ve(),aria:Ve()}},props:["label","small","classes","modelValue"],emits:["update:modelValue"],computed:{value:{get(){return this.modelValue},set(e){this.$emit("update:modelValue",e)}}}};const Ae=(0,S.Z)(Xe,[["render",Je]]);var et=Ae;const tt=(0,s.MT)({state(){return{header:null,currencies:null,originals:null,visibles:null,interval:null,token:l()('meta[name="csrf-token"]').attr("content")}},mutations:{header(e,t){e.header=(0,a.iH)(t)},currencies(e,t){e.currencies=t?(0,a.qj)(t):(0,a.iH)(t)},originals(e,t){e.originals=t?(0,a.qj)(t):(0,a.iH)(t)},visibles(e,t){e.visibles=t?(0,a.qj)(t):(0,a.iH)(t)},interval(e,t){e.interval=(0,a.iH)(t)},token(e,t){e.token=(0,a.iH)(t),l()('meta[name="csrf-token"]').attr("content",t)}},actions:{async currencies(e){let t=await l().ajax({url:"/",method:"POST",data:{_token:e.state.token},headers:{"X-CSRF-TOKEN":e.state.token}});e.commit("header",t.header),e.commit("currencies",t.currencies),e.commit("originals",t.originals),e.commit("visibles",t.visibles),e.commit("interval",t.interval)}}}),nt=(0,o.ri)(R);nt.config.unwrapInjectedRef=!0,nt.use(tt),nt.use(F),nt.use(U),nt.use(B),nt.use(G),nt.component("FlexComponent",ee),nt.component("ModalComponent",ze),nt.component("SpinnerComponent",Fe),nt.component("SelectComponent",Le),nt.component("InputComponent",et),nt.mount("#app")}},t={};function n(a){var o=t[a];if(void 0!==o)return o.exports;var s=t[a]={exports:{}};return e[a].call(s.exports,s,s.exports,n),s.exports}n.m=e,function(){var e=[];n.O=function(t,a,o,s){if(!a){var r=1/0;for(u=0;u<e.length;u++){a=e[u][0],o=e[u][1],s=e[u][2];for(var l=!0,i=0;i<a.length;i++)(!1&s||r>=s)&&Object.keys(n.O).every((function(e){return n.O[e](a[i])}))?a.splice(i--,1):(l=!1,s<r&&(r=s));if(l){e.splice(u--,1);var c=o();void 0!==c&&(t=c)}}return t}s=s||0;for(var u=e.length;u>0&&e[u-1][2]>s;u--)e[u]=e[u-1];e[u]=[a,o,s]}}(),function(){n.n=function(e){var t=e&&e.__esModule?function(){return e["default"]}:function(){return e};return n.d(t,{a:t}),t}}(),function(){n.d=function(e,t){for(var a in t)n.o(t,a)&&!n.o(e,a)&&Object.defineProperty(e,a,{enumerable:!0,get:t[a]})}}(),function(){n.g=function(){if("object"===typeof globalThis)return globalThis;try{return this||new Function("return this")()}catch(e){if("object"===typeof window)return window}}()}(),function(){n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)}}(),function(){n.r=function(e){"undefined"!==typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})}}(),function(){var e={143:0};n.O.j=function(t){return 0===e[t]};var t=function(t,a){var o,s,r=a[0],l=a[1],i=a[2],c=0;if(r.some((function(t){return 0!==e[t]}))){for(o in l)n.o(l,o)&&(n.m[o]=l[o]);if(i)var u=i(n)}for(t&&t(a);c<r.length;c++)s=r[c],n.o(e,s)&&e[s]&&e[s][0](),e[s]=0;return n.O(u)},a=self["webpackChunk"]=self["webpackChunk"]||[];a.forEach(t.bind(null,0)),a.push=t.bind(null,a.push.bind(a))}();var a=n.O(void 0,[998],(function(){return n(7830)}));a=n.O(a)})();
//# sourceMappingURL=app.dad07614.js.map