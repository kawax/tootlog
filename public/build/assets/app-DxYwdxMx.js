import{l as F,a as R,f as z,p as J,t as P,o as n,c as o,b as t,u as c,d as T,e as v,g as d,F as m,r as f,h as U,i as y,j as X,k as G,m as I,w as K,n as M,q as H,s as Q}from"./vendor-BKh_N5hN.js";window._=F;window.axios=R;window.axios.defaults.headers.common["X-Requested-With"]="XMLHttpRequest";function S(e){return z(J(e),"yyyy-MM-dd HH:mm:ss")}function h(e){return P.parse(e)}function $(e){return e.display_name?h(e.display_name):e.username}const Y={class:"badge bg-info ms-1"},Z=["src"],ee=["innerHTML"],te={class:"d-flex m-1 p-1"},ne={class:"flex-shrink-0"},oe=["href"],se=["src"],le={class:"flex-grow-1 ms-3"},ae=["href","innerHTML"],re={class:"text-muted"},ie=["innerHTML"],ce=["innerHTML"],ue=["href"],de=["src"],me=["href"],fe={__name:"TimelineReblog",props:{post:Object},setup(e){return(u,a)=>(n(),o("div",null,[t("span",Y,[t("img",{class:"rounded-circle toot-icon-small",src:e.post.account.avatar},null,8,Z),t("span",{innerHTML:c($)(e.post.account)},null,8,ee),T(" reblogged ")]),t("div",te,[t("div",ne,[t("a",{href:e.post.reblog.account.url,target:"_blank",rel:"nofollow noopener",class:"text-decoration-none"},[t("img",{class:"rounded toot-icon",src:e.post.reblog.account.avatar},null,8,se)],8,oe)]),t("div",le,[t("h4",null,[t("a",{href:e.post.reblog.account.url,innerHTML:c($)(e.post.reblog.account),target:"_blank",rel:"nofollow noopener",class:"text-decoration-none"},null,8,ae),t("small",re," @"+v(e.post.reblog.account.acct),1)]),e.post.reblog.spoiler_text.length>0?(n(),o("button",{key:0,class:"btn btn-warning btn-sm",type:"button",innerHTML:c(h)(e.post.reblog.spoiler_text),onClick:a[0]||(a[0]=i=>{e.post.reblog.spoiler_text=""})},null,8,ie)):d("",!0),e.post.reblog.spoiler_text?d("",!0):(n(),o("div",{key:1,innerHTML:c(h)(e.post.reblog.content)},null,8,ce)),e.post.reblog.media_attachments?(n(!0),o(m,{key:2},f(e.post.reblog.media_attachments,i=>(n(),o("div",null,[t("a",{href:i.url,target:"_blank",ref_for:!0,ref:"nofollow noopener",class:"text-decoration-none"},[t("img",{src:i.preview_url,class:"img-responsive img-thumbnail"},null,8,de)],8,ue)]))),256)):d("",!0),t("div",null,[t("a",{href:e.post.reblog.url,target:"_blank",ref:"nofollow noopener",class:"text-decoration-none"},v(c(S)(e.post.reblog.created_at)),9,me)])])])]))}},he={class:"d-flex p-1 m-1"},_e={class:"flex-shrink-0"},ge=["href"],be=["src"],pe={class:"flex-grow-1 ms-3"},ve=["href","innerHTML"],xe={class:"text-muted"},ke=["innerHTML"],ye=["innerHTML"],$e=["href"],we=["src"],Me=["href"],He={__name:"TimelineStatus",props:{post:Object},setup(e){return(u,a)=>(n(),o("div",he,[t("div",_e,[t("a",{href:e.post.account.url,target:"_blank",rel:"nofollow noopener",class:"text-decoration-none"},[t("img",{class:"rounded toot-icon",src:e.post.account.avatar},null,8,be)],8,ge)]),t("div",pe,[t("h4",null,[t("a",{href:e.post.account.url,innerHTML:c($)(e.post.account),target:"_blank",rel:"nofollow noopener",class:"text-decoration-none"},null,8,ve),t("small",xe," @"+v(e.post.account.acct),1)]),e.post.spoiler_text.length>0?(n(),o("button",{key:0,class:"btn btn-warning btn-sm",type:"button",innerHTML:c(h)(e.post.spoiler_text),onClick:a[0]||(a[0]=i=>{e.post.spoiler_text=""})},null,8,ke)):d("",!0),e.post.spoiler_text?d("",!0):(n(),o("div",{key:1,innerHTML:c(h)(e.post.content)},null,8,ye)),e.post.media_attachments?(n(!0),o(m,{key:2},f(e.post.media_attachments,i=>(n(),o("div",null,[t("a",{href:i.url,target:"_blank",ref_for:!0,ref:"nofollow noopener",class:"text-decoration-none"},[t("img",{src:i.preview_url,class:"img-responsive img-thumbnail"},null,8,we)],8,$e)]))),256)):d("",!0),t("div",null,[t("a",{href:e.post.url,target:"_blank",ref:"nofollow noopener",class:"text-decoration-none"},v(c(S)(e.post.created_at)),9,Me)])])]))}},Le=(e,u)=>{const a=e.__vccOpts||e;for(const[i,g]of u)a[i]=g;return a},Te={},Se={class:"card"},Ce={class:"card bg-white"};function Ne(e,u){return n(),o("div",Se,[t("div",Ce,[U(e.$slots,"default")])])}const Oe=Le(Te,[["render",Ne]]),je={class:"btn-toolbar mb-2",role:"toolbar","aria-label":"toolbar"},Be={class:"btn-group pe-1",role:"group"},De=["onClick","innerHTML"],Ee={class:"btn-group",role:"group"},Ve=["onClick","innerHTML"],We={key:0,class:"alert alert-danger"},qe=t("p",null,[t("strong",null,"Whoops!"),T(" Something went wrong!")],-1),Ae=t("hr",null,null,-1),L="/api/v1",Fe=50,Re={__name:"UserTimeline",props:{domain:String,streaming:String,token:String},setup(e){const u=e;let a=null;const i={user:'<i class="fa fa-home" aria-hidden="true"></i> User',"public:local":'<i class="fa fa-users" aria-hidden="true"></i> Local',public:'<i class="fa fa-globe" aria-hidden="true"></i> Federated'},g=y("public:local"),N={user:"home","public:local":"public?local=true",public:"public"},O={normal:'<i class="fa fa-file-image-o" aria-hidden="true"></i> Media Default',only:'<i class="fa fa-picture-o" aria-hidden="true"></i> Only',except:'<i class="fa fa-commenting-o" aria-hidden="true"></i> Except'},x=y("normal"),b=y([]);let k=[];const j=X(()=>b.value.filter(l=>q(l)));G(()=>w(g.value));function B(){return u.domain+L}function D(){return u.streaming+L}function w(l="public:local"){W(),g.value=l,axios.get(B()+"/timelines/"+N[l]+"?limit=20",{headers:{Authorization:"Bearer "+u.token}}).then(r=>{b.value=r.data,E(l)}).catch(r=>{console.log(r),typeof r.response.data=="object"?k=_.flatten(_.toArray(r.response.data)):k=["Something went wrong. Please try again."]})}function E(l="public:local"){V(l,r=>{r.event==="notification"?console.log(r):r.event==="update"&&(b.value.unshift(r.payload),b.value.splice(Fe))})}function V(l,r){a=new WebSocket(D()+"/streaming?access_token="+u.token+"&stream="+l),a.onmessage=s=>{console.log("Got Data from Stream "+l),s=JSON.parse(s.data),s.payload=JSON.parse(s.payload),r(s)},a.onclose=s=>{console.log("WebSocket Close "+l)}}function W(){_.isNull(a)||(a.close(),b.value=[])}function q(l){return x.value==="only"?!_.isEmpty(l.media_attachments):x.value==="except"?_.isEmpty(l.media_attachments):!0}return(l,r)=>(n(),o("div",null,[t("div",je,[t("div",Be,[(n(),o(m,null,f(i,(s,p)=>t("button",{type:"button",class:M(["btn btn-secondary",{active:g.value===p}]),onClick:A=>{w(p)},innerHTML:s},null,10,De)),64))]),t("div",Ee,[(n(),o(m,null,f(O,(s,p)=>t("button",{type:"button",class:M(["btn btn-secondary",{active:x.value===p}]),onClick:A=>{x.value=p},innerHTML:s},null,10,Ve)),64))])]),c(k).length>0?(n(),o("div",We,[qe,t("ul",null,[(n(!0),o(m,null,f(c(k),s=>(n(),o("li",null,v(s),1))),256))])])):d("",!0),I(Oe,null,{default:K(()=>[(n(!0),o(m,null,f(j.value,s=>(n(),o("div",null,[s.reblog?(n(),H(fe,{key:0,post:s},null,8,["post"])):(n(),H(He,{key:1,post:s},null,8,["post"])),Ae]))),256))]),_:1})]))}},C=Q({});C.component("tt-user-timeline",Re);C.mount("#app");h(document.body);
