(self.webpackChunk=self.webpackChunk||[]).push([[773],{36:(t,e,n)=>{"use strict";var o=n(166),i={class:"btn-toolbar mb-2",role:"toolbar","aria-label":"toolbar"},a={class:"btn-group pr-1",role:"group"},s={class:"btn-group",role:"group"},r={key:0,class:"alert alert-danger"},l=(0,o.Wm)("p",null,[(0,o.Wm)("strong",null,"Whoops!"),(0,o.Uk)(" Something went wrong!")],-1),c=(0,o.Wm)("hr",null,null,-1);var u=n(790),m=n(855),p={class:"badge badge-info ml-1"},d=(0,o.Uk)(" reblogged "),f={class:"media m-1 p-1"},g={class:"media-body ml-3"},h={class:"text-muted"};var y=n(623);const b=function(t){return y.Z.parse(t)},w={props:{post:Object},methods:{display_name:function(){return this.post.account.display_name.length>0?this.emoji(this.post.account.display_name):this.post.account.username},reblog_display_name:function(){return this.post.reblog.account.display_name?this.emoji(this.post.reblog.account.display_name):this.post.reblog.account.username},emoji:function(t){return b(t)},formatDate:function(t){return(0,u.Z)((0,m.Z)(t),"yyyy-MM-dd HH:mm:ss")}},render:function(t,e,n,i,a,s){return(0,o.wg)(),(0,o.j4)("div",null,[(0,o.Wm)("span",p,[(0,o.Wm)("img",{class:"rounded-circle toot-icon-small",src:n.post.account.avatar},null,8,["src"]),(0,o.Wm)("span",{innerHTML:s.display_name()},null,8,["innerHTML"]),d]),(0,o.Wm)("div",f,[(0,o.Wm)("a",{href:n.post.reblog.account.url,target:"_blank",rel:"nofollow noopener"},[(0,o.Wm)("img",{class:"rounded toot-icon",src:n.post.reblog.account.avatar},null,8,["src"])],8,["href"]),(0,o.Wm)("div",g,[(0,o.Wm)("h4",null,[(0,o.Wm)("a",{href:n.post.reblog.account.url,innerHTML:s.reblog_display_name(),target:"_blank",rel:"nofollow noopener"},null,8,["href","innerHTML"]),(0,o.Wm)("small",h," @"+(0,o.zw)(n.post.reblog.account.acct),1)]),n.post.reblog.spoiler_text.length>0?((0,o.wg)(),(0,o.j4)("button",{key:0,class:"btn btn-warning btn-sm",type:"button",innerHTML:s.emoji(n.post.reblog.spoiler_text),onClick:e[1]||(e[1]=function(t){n.post.reblog.spoiler_text=""})},null,8,["innerHTML"])):(0,o.ry)("",!0),n.post.reblog.spoiler_text?(0,o.ry)("",!0):((0,o.wg)(),(0,o.j4)("div",{key:1,innerHTML:s.emoji(n.post.reblog.content)},null,8,["innerHTML"])),n.post.reblog.media_attachments?((0,o.wg)(!0),(0,o.j4)(o.HY,{key:2},(0,o.Ko)(n.post.reblog.media_attachments,(function(t){return(0,o.wg)(),(0,o.j4)("div",null,[(0,o.Wm)("a",{href:t.url,target:"_blank",ref:"nofollow noopener"},[(0,o.Wm)("img",{src:t.preview_url,class:"img-responsive img-thumbnail"},null,8,["src"])],8,["href"])])})),256)):(0,o.ry)("",!0),(0,o.Wm)("div",null,[(0,o.Wm)("a",{href:n.post.reblog.url,target:"_blank",ref:"nofollow noopener"},(0,o.zw)(s.formatDate(n.post.reblog.created_at)),9,["href"])])])])])}};var v={class:"media p-1 m-1"},W={class:"media-body ml-3"},k={class:"text-muted"};const j={props:{post:Object},methods:{display_name:function(){return this.post.account.display_name?this.emoji(this.post.account.display_name):this.post.account.username},emoji:function(t){return b(t)},formatDate:function(t){return(0,u.Z)((0,m.Z)(t),"yyyy-MM-dd HH:mm:ss")}},render:function(t,e,n,i,a,s){return(0,o.wg)(),(0,o.j4)("div",v,[(0,o.Wm)("a",{href:n.post.account.url,target:"_blank",rel:"nofollow noopener"},[(0,o.Wm)("img",{class:"rounded toot-icon",src:n.post.account.avatar},null,8,["src"])],8,["href"]),(0,o.Wm)("div",W,[(0,o.Wm)("h4",null,[(0,o.Wm)("a",{href:n.post.account.url,innerHTML:s.display_name(),target:"_blank",rel:"nofollow noopener"},null,8,["href","innerHTML"]),(0,o.Wm)("small",k," @"+(0,o.zw)(n.post.account.acct),1)]),n.post.spoiler_text.length>0?((0,o.wg)(),(0,o.j4)("button",{key:0,class:"btn btn-warning btn-sm",type:"button",innerHTML:s.emoji(n.post.spoiler_text),onClick:e[1]||(e[1]=function(t){n.post.spoiler_text=""})},null,8,["innerHTML"])):(0,o.ry)("",!0),n.post.spoiler_text?(0,o.ry)("",!0):((0,o.wg)(),(0,o.j4)("div",{key:1,innerHTML:s.emoji(n.post.content)},null,8,["innerHTML"])),n.post.media_attachments?((0,o.wg)(!0),(0,o.j4)(o.HY,{key:2},(0,o.Ko)(n.post.media_attachments,(function(t){return(0,o.wg)(),(0,o.j4)("div",null,[(0,o.Wm)("a",{href:t.url,target:"_blank",ref:"nofollow noopener"},[(0,o.Wm)("img",{src:t.preview_url,class:"img-responsive img-thumbnail"},null,8,["src"])],8,["href"])])})),256)):(0,o.ry)("",!0),(0,o.Wm)("div",null,[(0,o.Wm)("a",{href:n.post.url,target:"_blank",ref:"nofollow noopener"},(0,o.zw)(s.formatDate(n.post.created_at)),9,["href"])])])])}};var H={class:"card"},M={class:"card bg-white"};const T={render:function(t,e){return(0,o.wg)(),(0,o.j4)("div",H,[(0,o.Wm)("div",M,[(0,o.WI)(t.$slots,"default")])])}};function x(t){return(x="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t})(t)}const L={components:{TimelineReblog:w,TimelineStatus:j,Card:T},data:function(){return{api_version:"/api/v1",ws:null,types:{user:'<i class="fa fa-home" aria-hidden="true"></i> User',"public:local":'<i class="fa fa-users" aria-hidden="true"></i> Local',public:'<i class="fa fa-globe" aria-hidden="true"></i> Federated'},active_type:"public:local",timelines:{user:"home","public:local":"public?local=true",public:"public"},titles:{mention:"mentioned you",reblog:"boosted your status",favourite:"favourited your status",follow:"followed you"},media:{normal:'<i class="fa fa-file-image-o" aria-hidden="true"></i> Media Default',only:'<i class="fa fa-picture-o" aria-hidden="true"></i> Only',except:'<i class="fa fa-commenting-o" aria-hidden="true"></i> Except'},active_media:"normal",posts:[],count:0,max:50,errors:[]}},computed:{endpoint:function(){return this.domain+this.api_version},streaming_url:function(){return this.streaming+this.api_version},activePosts:function(){var t=this;return this.posts.filter((function(e){return t.media_check(e)}))}},props:{domain:String,streaming:String,token:String},mounted:function(){this.get(this.active_type)},methods:{get:function(){var t=this,e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"public:local";this.steam_close(),this.active_type=e;var n=this.timelines[e];axios.get(this.endpoint+"/timelines/"+n+"?limit=20",{headers:{Authorization:"Bearer "+this.token}}).then((function(n){console.log(n),t.posts=n.data,t.stream(e)})).catch((function(e){console.log(e),"object"===x(e.response.data)?t.errors=_.flatten(_.toArray(e.response.data)):t.errors=["Something went wrong. Please try again."]}))},stream:function(){var t=this,e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"public:local";this.steam_open(e,(function(e){if("notification"===e.event){console.log(e);var o=_.isEmpty(e.payload.account.display_name)?e.payload.account.username:e.payload.account.display_name,i=t.notificationTitle(e.payload.type,o),a=_.isEmpty(e.payload.status.spoiler_text)?e.payload.status.content:e.payload.status.spoiler_text;if(a=$("<p>").html(a).text(),"Notification"in window){if("Audio"in window)new Audio(n(979)).play();Notification.requestPermission().then((function(){new Notification(i,{body:a,icon:e.payload.account.avatar,tag:e.payload.id})}))}}else"update"===e.event&&(t.posts.unshift(e.payload),t.posts.splice(t.max))}))},steam_open:function(t,e){this.ws=new WebSocket(this.streaming_url+"/streaming?access_token="+this.token+"&stream="+t),this.ws.onmessage=function(n){console.log("Got Data from Stream "+t),(n=JSON.parse(n.data)).payload=JSON.parse(n.payload),e(n)},this.ws.onclose=function(e){console.log("WebSocket Close "+t)}},steam_close:function(){_.isNull(this.ws)||(this.ws.close(),this.posts=[])},media_check:function(t){return"only"===this.active_media?(console.log(t),!_.isEmpty(t.media_attachments)):"except"!==this.active_media||_.isEmpty(t.media_attachments)},notificationTitle:function(t,e){return e+" "+this.titles[t]},formatDate:function(t){return(0,u.Z)((0,m.Z)(t),"yyyy-MM-dd HH:mm:ss")}},render:function(t,e,n,u,m,p){var d=(0,o.up)("TimelineReblog"),f=(0,o.up)("TimelineStatus"),g=(0,o.up)("Card");return(0,o.wg)(),(0,o.j4)("div",null,[(0,o.Wm)("div",i,[(0,o.Wm)("div",a,[((0,o.wg)(!0),(0,o.j4)(o.HY,null,(0,o.Ko)(m.types,(function(t,e){return(0,o.wg)(),(0,o.j4)("button",{type:"button",class:["btn btn-secondary",{active:m.active_type===e}],onClick:function(t){p.get(e)},innerHTML:t},null,10,["onClick","innerHTML"])})),256))]),(0,o.Wm)("div",s,[((0,o.wg)(!0),(0,o.j4)(o.HY,null,(0,o.Ko)(m.media,(function(t,e){return(0,o.wg)(),(0,o.j4)("button",{type:"button",class:["btn btn-secondary",{active:m.active_media===e}],onClick:function(t){m.active_media=e},innerHTML:t},null,10,["onClick","innerHTML"])})),256))])]),m.errors.length>0?((0,o.wg)(),(0,o.j4)("div",r,[l,(0,o.Wm)("ul",null,[((0,o.wg)(!0),(0,o.j4)(o.HY,null,(0,o.Ko)(m.errors,(function(t){return(0,o.wg)(),(0,o.j4)("li",null,(0,o.zw)(t),1)})),256))])])):(0,o.ry)("",!0),(0,o.Wm)(g,null,{default:(0,o.w5)((function(){return[((0,o.wg)(!0),(0,o.j4)(o.HY,null,(0,o.Ko)(p.activePosts,(function(t){return(0,o.wg)(),(0,o.j4)("div",null,[t.reblog?((0,o.wg)(),(0,o.j4)(d,{key:0,post:t},null,8,["post"])):((0,o.wg)(),(0,o.j4)(f,{key:1,post:t},null,8,["post"])),c])})),256))]})),_:1})])}},S=L;n(333),(0,o.ri)({components:{"tt-user-timeline":S}}).mount("#app"),y.Z.parse(document.body)},333:(t,e,n)=>{window._=n(486),window.Popper=n(981).default;try{window.$=window.jQuery=n(755),n(734)}catch(t){}window.axios=n(669),window.axios.defaults.headers.common["X-Requested-With"]="XMLHttpRequest"},979:(t,e,n)=>{"use strict";n.r(e),n.d(e,{default:()=>o});const o=n.p+"/sounds/5c498f9b48042b84f71806fb41e4a140.mp3"},731:()=>{}},t=>{"use strict";var e=e=>t(t.s=e);t.O(0,[170,898],(()=>(e(36),e(731))));t.O()}]);