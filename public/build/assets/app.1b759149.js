import{l as C,a as N,t as x,f as y,p as v,o as n,c as i,b as o,d as f,e as u,F as m,r as h,g as M,h as D,i as O,w as E,j as b,n as w,k,m as A}from"./vendor.574fb234.js";window._=C;window.axios=N;window.axios.defaults.headers.common["X-Requested-With"]="XMLHttpRequest";const T={toImage(t){return x.parse(t)}},g=(t,s)=>{const e=t.__vccOpts||t;for(const[d,a]of s)e[d]=a;return e},B={props:{post:Object},methods:{display_name(){return this.post.account.display_name.length>0?this.emoji(this.post.account.display_name):this.post.account.username},reblog_display_name(){return this.post.reblog.account.display_name?this.emoji(this.post.reblog.account.display_name):this.post.reblog.account.username},emoji(t){return T.toImage(t)},formatDate(t){return y(v(t),"yyyy-MM-dd HH:mm:ss")}}},R={class:"badge bg-info ms-1"},q=["src"],I=["innerHTML"],P=M(" reblogged "),V={class:"d-flex m-1 p-1"},W={class:"flex-shrink-0"},F=["href"],z=["src"],J={class:"flex-grow-1 ms-3"},U=["href","innerHTML"],X={class:"text-muted"},G=["innerHTML"],K=["innerHTML"],Q=["href"],Y=["src"],Z=["href"];function ee(t,s,e,d,a,l){return n(),i("div",null,[o("span",R,[o("img",{class:"rounded-circle toot-icon-small",src:e.post.account.avatar},null,8,q),o("span",{innerHTML:l.display_name()},null,8,I),P]),o("div",V,[o("div",W,[o("a",{href:e.post.reblog.account.url,target:"_blank",rel:"nofollow noopener"},[o("img",{class:"rounded toot-icon",src:e.post.reblog.account.avatar},null,8,z)],8,F)]),o("div",J,[o("h4",null,[o("a",{href:e.post.reblog.account.url,innerHTML:l.reblog_display_name(),target:"_blank",rel:"nofollow noopener"},null,8,U),o("small",X," @"+f(e.post.reblog.account.acct),1)]),e.post.reblog.spoiler_text.length>0?(n(),i("button",{key:0,class:"btn btn-warning btn-sm",type:"button",innerHTML:l.emoji(e.post.reblog.spoiler_text),onClick:s[0]||(s[0]=r=>{e.post.reblog.spoiler_text=""})},null,8,G)):u("",!0),e.post.reblog.spoiler_text?u("",!0):(n(),i("div",{key:1,innerHTML:l.emoji(e.post.reblog.content)},null,8,K)),e.post.reblog.media_attachments?(n(!0),i(m,{key:2},h(e.post.reblog.media_attachments,r=>(n(),i("div",null,[o("a",{href:r.url,target:"_blank",ref_for:!0,ref:"nofollow noopener"},[o("img",{src:r.preview_url,class:"img-responsive img-thumbnail"},null,8,Y)],8,Q)]))),256)):u("",!0),o("div",null,[o("a",{href:e.post.reblog.url,target:"_blank",ref:"nofollow noopener"},f(l.formatDate(e.post.reblog.created_at)),9,Z)])])])])}const te=g(B,[["render",ee]]),oe={props:{post:Object},methods:{display_name(){return this.post.account.display_name?this.emoji(this.post.account.display_name):this.post.account.username},emoji(t){return T.toImage(t)},formatDate(t){return y(v(t),"yyyy-MM-dd HH:mm:ss")}}},se={class:"d-flex p-1 m-1"},ne={class:"flex-shrink-0"},ie=["href"],ae=["src"],le={class:"flex-grow-1 ms-3"},re=["href","innerHTML"],ce={class:"text-muted"},ue=["innerHTML"],de=["innerHTML"],_e=["href"],me=["src"],he=["href"];function pe(t,s,e,d,a,l){return n(),i("div",se,[o("div",ne,[o("a",{href:e.post.account.url,target:"_blank",rel:"nofollow noopener"},[o("img",{class:"rounded toot-icon",src:e.post.account.avatar},null,8,ae)],8,ie)]),o("div",le,[o("h4",null,[o("a",{href:e.post.account.url,innerHTML:l.display_name(),target:"_blank",rel:"nofollow noopener"},null,8,re),o("small",ce," @"+f(e.post.account.acct),1)]),e.post.spoiler_text.length>0?(n(),i("button",{key:0,class:"btn btn-warning btn-sm",type:"button",innerHTML:l.emoji(e.post.spoiler_text),onClick:s[0]||(s[0]=r=>{e.post.spoiler_text=""})},null,8,ue)):u("",!0),e.post.spoiler_text?u("",!0):(n(),i("div",{key:1,innerHTML:l.emoji(e.post.content)},null,8,de)),e.post.media_attachments?(n(!0),i(m,{key:2},h(e.post.media_attachments,r=>(n(),i("div",null,[o("a",{href:r.url,target:"_blank",ref_for:!0,ref:"nofollow noopener"},[o("img",{src:r.preview_url,class:"img-responsive img-thumbnail"},null,8,me)],8,_e)]))),256)):u("",!0),o("div",null,[o("a",{href:e.post.url,target:"_blank",ref:"nofollow noopener"},f(l.formatDate(e.post.created_at)),9,he)])])])}const fe=g(oe,[["render",pe]]),ge={},be={class:"card"},ye={class:"card bg-white"};function ve(t,s){return n(),i("div",be,[o("div",ye,[D(t.$slots,"default")])])}const we=g(ge,[["render",ve]]),ke={components:{TimelineReblog:te,TimelineStatus:fe,Card:we},data(){return{api_version:"/api/v1",ws:null,types:{user:'<i class="fa fa-home" aria-hidden="true"></i> User',"public:local":'<i class="fa fa-users" aria-hidden="true"></i> Local',public:'<i class="fa fa-globe" aria-hidden="true"></i> Federated'},active_type:"public:local",timelines:{user:"home","public:local":"public?local=true",public:"public"},titles:{mention:"mentioned you",reblog:"boosted your status",favourite:"favourited your status",follow:"followed you"},media:{normal:'<i class="fa fa-file-image-o" aria-hidden="true"></i> Media Default',only:'<i class="fa fa-picture-o" aria-hidden="true"></i> Only',except:'<i class="fa fa-commenting-o" aria-hidden="true"></i> Except'},active_media:"normal",posts:[],count:0,max:50,errors:[]}},computed:{endpoint(){return this.domain+this.api_version},streaming_url(){return this.streaming+this.api_version},activePosts(){return this.posts.filter(t=>this.media_check(t))}},props:{domain:String,streaming:String,token:String},mounted(){this.get(this.active_type)},methods:{get(t="public:local"){this.steam_close(),this.active_type=t;const s=this.timelines[t];axios.get(this.endpoint+"/timelines/"+s+"?limit=20",{headers:{Authorization:"Bearer "+this.token}}).then(e=>{console.log(e),this.posts=e.data,this.stream(t)}).catch(e=>{console.log(e),typeof e.response.data=="object"?this.errors=_.flatten(_.toArray(e.response.data)):this.errors=["Something went wrong. Please try again."]})},stream(t="public:local"){this.steam_open(t,s=>{if(s.event==="notification"){console.log(s);let e=_.isEmpty(s.payload.account.display_name)?s.payload.account.username:s.payload.account.display_name,d=this.notificationTitle(s.payload.type,e),a=_.isEmpty(s.payload.status.spoiler_text)?s.payload.status.content:s.payload.status.spoiler_text;a=$("<p>").html(a).text(),"Notification"in window&&("Audio"in window&&new Audio(require("../../sounds/boop2.mp3")).play(),Notification.requestPermission().then(()=>{new Notification(d,{body:a,icon:s.payload.account.avatar,tag:s.payload.id})}))}else s.event==="update"&&(this.posts.unshift(s.payload),this.posts.splice(this.max))})},steam_open(t,s){this.ws=new WebSocket(this.streaming_url+"/streaming?access_token="+this.token+"&stream="+t),this.ws.onmessage=e=>{console.log("Got Data from Stream "+t),e=JSON.parse(e.data),e.payload=JSON.parse(e.payload),s(e)},this.ws.onclose=e=>{console.log("WebSocket Close "+t)}},steam_close(){_.isNull(this.ws)||(this.ws.close(),this.posts=[])},media_check(t){return this.active_media==="only"?(console.log(t),!_.isEmpty(t.media_attachments)):this.active_media==="except"?_.isEmpty(t.media_attachments):!0},notificationTitle(t,s){return s+" "+this.titles[t]},formatDate(t){return y(v(t),"yyyy-MM-dd HH:mm:ss")}}},xe={class:"btn-toolbar mb-2",role:"toolbar","aria-label":"toolbar"},Me={class:"btn-group pe-1",role:"group"},Te=["onClick","innerHTML"],He={class:"btn-group",role:"group"},Le=["onClick","innerHTML"],Se={key:0,class:"alert alert-danger"},je=o("p",null,[o("strong",null,"Whoops!"),M(" Something went wrong!")],-1),Ce=o("hr",null,null,-1);function Ne(t,s,e,d,a,l){const r=b("TimelineReblog"),L=b("TimelineStatus"),S=b("Card");return n(),i("div",null,[o("div",xe,[o("div",Me,[(n(!0),i(m,null,h(a.types,(c,p)=>(n(),i("button",{type:"button",class:w(["btn btn-secondary",{active:a.active_type===p}]),onClick:j=>{l.get(p)},innerHTML:c},null,10,Te))),256))]),o("div",He,[(n(!0),i(m,null,h(a.media,(c,p)=>(n(),i("button",{type:"button",class:w(["btn btn-secondary",{active:a.active_media===p}]),onClick:j=>{a.active_media=p},innerHTML:c},null,10,Le))),256))])]),a.errors.length>0?(n(),i("div",Se,[je,o("ul",null,[(n(!0),i(m,null,h(a.errors,c=>(n(),i("li",null,f(c),1))),256))])])):u("",!0),O(S,null,{default:E(()=>[(n(!0),i(m,null,h(l.activePosts,c=>(n(),i("div",null,[c.reblog?(n(),k(r,{key:0,post:c},null,8,["post"])):(n(),k(L,{key:1,post:c},null,8,["post"])),Ce]))),256))]),_:1})])}const De=g(ke,[["render",Ne]]),H=A({});H.component("tt-user-timeline",De);H.mount("#app");x.parse(document.body);