import{l as q,a as A,f as F,p as R,t as z,d as x,o as s,c as a,b as e,u as t,e as C,g as w,h as g,F as v,r as k,i as J,j as b,n as N,k as P,m as U,q as H,w as X,s as T,v as G}from"./vendor-DDyrPHZS.js";window._=q;window.axios=A;window.axios.defaults.headers.common["X-Requested-With"]="XMLHttpRequest";function B(l){return F(R(l),"yyyy-MM-dd HH:mm:ss")}function y(l){return z.parse(l)}function L(l){return l.display_name?y(l.display_name):l.username}const I={class:"badge bg-info ms-1"},K=["src"],Q=["innerHTML"],Y={class:"d-flex m-1 p-1"},Z={class:"flex-shrink-0"},ee=["href"],te=["src"],ne={class:"flex-grow-1 ms-3"},oe=["href","innerHTML"],se={class:"text-muted"},ae=["innerHTML"],le=["innerHTML"],re=["href"],ie=["src"],ce=["href"],ue=x({__name:"TimelineReblog",props:{post:{}},setup(l){const i=l,o=i.post.reblog,n=i.post.reblog.account;return(r,c)=>(s(),a("div",null,[e("span",I,[e("img",{class:"rounded-circle toot-icon-small",src:r.post.account.avatar},null,8,K),e("span",{innerHTML:t(L)(r.post.account)},null,8,Q),C(" reblogged ")]),e("div",Y,[e("div",Z,[e("a",{href:t(n).url,target:"_blank",rel:"nofollow noopener",class:"text-decoration-none"},[e("img",{class:"rounded toot-icon",src:t(n).avatar},null,8,te)],8,ee)]),e("div",ne,[e("h4",null,[e("a",{href:t(n).url,innerHTML:t(L)(t(n)),target:"_blank",rel:"nofollow noopener",class:"text-decoration-none"},null,8,oe),e("small",se," @"+w(t(n).acct),1)]),t(o).spoiler_text.length>0?(s(),a("button",{key:0,class:"btn btn-warning btn-sm",type:"button",innerHTML:t(y)(t(o).spoiler_text),onClick:c[0]||(c[0]=m=>{t(o).spoiler_text=""})},null,8,ae)):g("",!0),t(o).spoiler_text?g("",!0):(s(),a("div",{key:1,innerHTML:t(y)(t(o).content)},null,8,le)),t(o).media_attachments?(s(!0),a(v,{key:2},k(t(o).media_attachments,m=>(s(),a("div",null,[e("a",{href:m.url,target:"_blank",ref_for:!0,ref:"nofollow noopener",class:"text-decoration-none"},[e("img",{src:m.preview_url,class:"img-responsive img-thumbnail"},null,8,ie)],8,re)]))),256)):g("",!0),e("div",null,[e("a",{href:t(o).url,target:"_blank",ref:"nofollow noopener",class:"text-decoration-none"},w(t(B)(t(o).created_at)),9,ce)])])])]))}}),de={class:"d-flex p-1 m-1"},_e={class:"flex-shrink-0"},pe=["href"],me=["src"],he={class:"flex-grow-1 ms-3"},fe=["href","innerHTML"],ge={class:"text-muted"},be=["innerHTML"],ve=["innerHTML"],ke=["href"],ye=["src"],$e=["href"],we=x({__name:"TimelineStatus",props:{post:{}},setup(l){const o=l.post.account;return(n,r)=>(s(),a("div",de,[e("div",_e,[e("a",{href:t(o).url,target:"_blank",rel:"nofollow noopener",class:"text-decoration-none"},[e("img",{class:"rounded toot-icon",src:t(o).avatar},null,8,me)],8,pe)]),e("div",he,[e("h4",null,[e("a",{href:t(o).url,innerHTML:t(L)(t(o)),target:"_blank",rel:"nofollow noopener",class:"text-decoration-none"},null,8,fe),e("small",ge," @"+w(t(o).acct),1)]),n.post.spoiler_text.length>0?(s(),a("button",{key:0,class:"btn btn-warning btn-sm",type:"button",innerHTML:t(y)(n.post.spoiler_text),onClick:r[0]||(r[0]=c=>{n.post.spoiler_text=""})},null,8,be)):g("",!0),n.post.spoiler_text?g("",!0):(s(),a("div",{key:1,innerHTML:t(y)(n.post.content)},null,8,ve)),n.post.media_attachments?(s(!0),a(v,{key:2},k(n.post.media_attachments,c=>(s(),a("div",null,[e("a",{href:c.url,target:"_blank",ref_for:!0,ref:"nofollow noopener",class:"text-decoration-none"},[e("img",{src:c.preview_url,class:"img-responsive img-thumbnail"},null,8,ye)],8,ke)]))),256)):g("",!0),e("div",null,[e("a",{href:n.post.url,target:"_blank",ref:"nofollow noopener",class:"text-decoration-none"},w(t(B)(n.post.created_at)),9,$e)])])]))}}),xe=(l,i)=>{const o=l.__vccOpts||l;for(const[n,r]of i)o[n]=r;return o},Me={},He={class:"card"},Le={class:"card bg-white"};function Te(l,i){return s(),a("div",He,[e("div",Le,[J(l.$slots,"default")])])}const Se=xe(Me,[["render",Te]]),Ce={class:"btn-group pe-1",role:"group"},Ne=["onClick","innerHTML"],Be=x({__name:"TypeSwitch",emits:["changed"],setup(l,{emit:i}){const o=i,n=b("public:local"),r={user:'<i class="fa fa-home" aria-hidden="true"></i> User',"public:local":'<i class="fa fa-users" aria-hidden="true"></i> Local',public:'<i class="fa fa-globe" aria-hidden="true"></i> Federated'};function c(m){n.value=m,o("changed",m)}return(m,f)=>(s(),a("div",Ce,[(s(),a(v,null,k(r,($,h)=>e("button",{type:"button",class:N(["btn btn-secondary",{active:n.value===h}]),onClick:M=>c(h),innerHTML:$},null,10,Ne)),64))]))}}),Oe={class:"btn-group",role:"group"},je=["onClick","innerHTML"],De=x({__name:"MediaSwitch",emits:["changed"],setup(l,{emit:i}){const o=i,n=b("normal"),r={normal:'<i class="fa fa-file-image-o" aria-hidden="true"></i> Media Default',only:'<i class="fa fa-picture-o" aria-hidden="true"></i> Only',except:'<i class="fa fa-commenting-o" aria-hidden="true"></i> Except'};function c(m){n.value=m,o("changed",m)}return(m,f)=>(s(),a("div",Oe,[(s(),a(v,null,k(r,($,h)=>e("button",{type:"button",class:N(["btn btn-secondary",{active:n.value===h}]),onClick:M=>c(h),innerHTML:$},null,10,je)),64))]))}}),Ee={class:"btn-toolbar mb-2",role:"toolbar","aria-label":"toolbar"},Ve={key:0,class:"alert alert-danger"},We=e("p",null,[e("strong",null,"Whoops!"),C(" Something went wrong!")],-1),qe=e("hr",null,null,-1),S="/api/v1",Ae=50,Fe={__name:"UserTimeline",props:{domain:String,streaming:String,token:String},setup(l){const i=l,o=b("public:local"),n=b("normal"),r=b([]),c=b([]),m={user:"home","public:local":"public?local=true",public:"public"};let f=null;const $=P(()=>r.value.filter(u=>E(u)));U(()=>h());function h(u="public:local"){D(),o.value=u,axios.get(V()+"/timelines/"+m[u]+"?limit=20",{headers:{Authorization:"Bearer "+i.token}}).then(d=>{r.value=d.data,M(u)}).catch(d=>{console.log(d),typeof d.response.data=="object"?c.value=_.flatten(_.toArray(d.response.data)):c.value=["Something went wrong. Please try again."]})}function M(u="public:local"){j(u,d=>{d.event==="notification"?console.log(d):d.event==="update"&&(r.value.unshift(d.payload),r.value.splice(Ae))})}function j(u,d){f=new WebSocket(W()+"/streaming?access_token="+i.token+"&stream="+u),f.onmessage=p=>{console.log("Got Data from Stream "+u),p=JSON.parse(p.data),p.payload=JSON.parse(p.payload),d(p)},f.onclose=p=>{console.log("WebSocket Close "+u)}}function D(){_.isNull(f)||(f.close(),r.value=[])}function E(u){return n.value==="only"?!_.isEmpty(u.media_attachments):n.value==="except"?_.isEmpty(u.media_attachments):!0}function V(){return i.domain+S}function W(){return i.streaming+S}return(u,d)=>(s(),a("div",null,[e("div",Ee,[H(Be,{onChanged:h}),H(De,{onChanged:d[0]||(d[0]=p=>n.value=p)})]),c.value.length>0?(s(),a("div",Ve,[We,e("ul",null,[(s(!0),a(v,null,k(c.value,p=>(s(),a("li",null,w(p),1))),256))])])):g("",!0),H(Se,null,{default:X(()=>[(s(!0),a(v,null,k($.value,p=>(s(),a("div",{key:p.id},[p.reblog?(s(),T(ue,{key:0,post:p},null,8,["post"])):(s(),T(we,{key:1,post:p},null,8,["post"])),qe]))),128))]),_:1})]))}},O=G({});O.component("tt-user-timeline",Fe);O.mount("#app");y(document.body);
