import{u as j,t as Y,d as y,o as r,c as a,a as t,b as n,e as S,f as w,g as f,F as b,r as g,h as A,i as v,w as F,n as N,j as P,k as R,l as z,m as J,p as T,q as U,s as x,v as q,x as C,y as G}from"./vendor-bljhhqXi.js";function O(s){return j(s,"YYYY-MM-DD HH:mm:ss").value}function k(s){return Y.parse(s)}function L(s){return s.display_name?k(s.display_name):s.username}const K={class:"badge bg-info ms-1"},Q=["src"],X=["innerHTML"],Z={class:"d-flex m-1 p-1"},ee={class:"flex-shrink-0"},te=["href"],ne=["src"],se={class:"flex-grow-1 ms-3"},oe=["href","innerHTML"],re={class:"text-muted"},ae=["innerHTML"],le=["innerHTML"],ce=["href"],ie=["src"],ue=["href"],de=y({__name:"TimelineReblog",props:{post:{}},setup(s){const l=s,o=l.post.reblog,e=l.post.reblog.account;return(c,_)=>(r(),a("div",null,[t("span",K,[t("img",{class:"rounded-circle toot-icon-small",src:c.post.account.avatar},null,8,Q),t("span",{innerHTML:n(L)(c.post.account)},null,8,X),S(" reblogged ")]),t("div",Z,[t("div",ee,[t("a",{href:n(e).url,target:"_blank",rel:"nofollow noopener",class:"text-decoration-none"},[t("img",{class:"rounded toot-icon",src:n(e).avatar},null,8,ne)],8,te)]),t("div",se,[t("h4",null,[t("a",{href:n(e).url,innerHTML:n(L)(n(e)),target:"_blank",rel:"nofollow noopener",class:"text-decoration-none"},null,8,oe),t("small",re," @"+w(n(e).acct),1)]),n(o).spoiler_text.length>0?(r(),a("button",{key:0,class:"btn btn-warning btn-sm",type:"button",innerHTML:n(k)(n(o).spoiler_text),onClick:_[0]||(_[0]=d=>{n(o).spoiler_text=""})},null,8,ae)):f("",!0),n(o).spoiler_text?f("",!0):(r(),a("div",{key:1,innerHTML:n(k)(n(o).content)},null,8,le)),n(o).media_attachments?(r(!0),a(b,{key:2},g(n(o).media_attachments,d=>(r(),a("div",null,[t("a",{href:d.url,target:"_blank",ref_for:!0,ref:"nofollow noopener",class:"text-decoration-none"},[t("img",{src:d.preview_url,class:"img-responsive img-thumbnail"},null,8,ie)],8,ce)]))),256)):f("",!0),t("div",null,[t("a",{href:n(o).url,target:"_blank",ref:"nofollow noopener",class:"text-decoration-none"},w(n(O)(n(o).created_at)),9,ue)])])])]))}}),_e={class:"d-flex p-1 m-1"},pe={class:"flex-shrink-0"},he=["href"],me=["src"],fe={class:"flex-grow-1 ms-3"},be=["href","innerHTML"],ge={class:"text-muted"},ve=["innerHTML"],ke=["innerHTML"],$e=["href"],we=["src"],ye=["href"],Te=y({__name:"TimelineStatus",props:{post:{}},setup(s){const o=s.post.account;return(e,c)=>(r(),a("div",_e,[t("div",pe,[t("a",{href:n(o).url,target:"_blank",rel:"nofollow noopener",class:"text-decoration-none"},[t("img",{class:"rounded toot-icon",src:n(o).avatar},null,8,me)],8,he)]),t("div",fe,[t("h4",null,[t("a",{href:n(o).url,innerHTML:n(L)(n(o)),target:"_blank",rel:"nofollow noopener",class:"text-decoration-none"},null,8,be),t("small",ge," @"+w(n(o).acct),1)]),e.post.spoiler_text.length>0?(r(),a("button",{key:0,class:"btn btn-warning btn-sm",type:"button",innerHTML:n(k)(e.post.spoiler_text),onClick:c[0]||(c[0]=_=>{e.post.spoiler_text=""})},null,8,ve)):f("",!0),e.post.spoiler_text?f("",!0):(r(),a("div",{key:1,innerHTML:n(k)(e.post.content)},null,8,ke)),e.post.media_attachments?(r(!0),a(b,{key:2},g(e.post.media_attachments,_=>(r(),a("div",null,[t("a",{href:_.url,target:"_blank",ref_for:!0,ref:"nofollow noopener",class:"text-decoration-none"},[t("img",{src:_.preview_url,class:"img-responsive img-thumbnail"},null,8,we)],8,$e)]))),256)):f("",!0),t("div",null,[t("a",{href:e.post.url,target:"_blank",ref:"nofollow noopener",class:"text-decoration-none"},w(n(O)(e.post.created_at)),9,ye)])])]))}}),Me=(s,l)=>{const o=s.__vccOpts||s;for(const[e,c]of l)o[e]=c;return o},xe={},Le={class:"card"},He={class:"card bg-white"};function Ce(s,l){return r(),a("div",Le,[t("div",He,[A(s.$slots,"default")])])}const Se=Me(xe,[["render",Ce]]),Fe={class:"btn-group pe-1",role:"group"},Ne=["onClick","innerHTML"],Oe=y({__name:"TypeSwitch",emits:["changed"],setup(s,{emit:l}){const o=l,e=v("public:local"),c={user:'<i class="fa fa-home" aria-hidden="true"></i> User',"public:local":'<i class="fa fa-users" aria-hidden="true"></i> Local',public:'<i class="fa fa-globe" aria-hidden="true"></i> Federated'};return F(()=>o("changed",e.value)),(_,d)=>(r(),a("div",Fe,[(r(),a(b,null,g(c,(h,i)=>t("button",{type:"button",class:N(["btn btn-secondary",{active:e.value===i}]),onClick:u=>e.value=i,innerHTML:h},null,10,Ne)),64))]))}}),De={class:"btn-group",role:"group"},Ee=["onClick","innerHTML"],Ie=y({__name:"MediaSwitch",emits:["changed"],setup(s,{emit:l}){const o=l,e=v("normal"),c={normal:'<i class="fa fa-file-image-o" aria-hidden="true"></i> Text and Media',only:'<i class="fa fa-picture-o" aria-hidden="true"></i> Media',except:'<i class="fa fa-commenting-o" aria-hidden="true"></i> Text'};return F(()=>o("changed",e.value)),(_,d)=>(r(),a("div",De,[(r(),a(b,null,g(c,(h,i)=>t("button",{type:"button",class:N(["btn btn-secondary",{active:e.value===i}]),onClick:u=>e.value=i,innerHTML:h},null,10,Ee)),64))]))}});function Ve(s,l,o,e){const c="/api/v1",d=v([]),h=v([]);let i=null;const u={user:"home","public:local":"public?local=true",public:"public"};P(()=>H()),R(e,()=>{V(),H()});function H(){const{onFetchResponse:m,onFetchError:$}=z(B(),{async beforeFetch({options:p}){return p.headers={...p.headers,Authorization:`Bearer ${o}`},{options:p}}});m(async p=>{d.value=await p.json(),E()}),$(p=>{console.error(p),h.value.push(p)})}function E(){const{close:m}=J(W(),{autoClose:!1,onMessage:($,p)=>{let M=JSON.parse(p.data);M.payload=JSON.parse(M.payload),I(M)},onConnected($){console.debug("WebSocket Open "+s+" "+T(e))},onDisconnected($,p){console.debug("WebSocket Close "+s)},onError($,p){console.debug("WebSocket Error "+s+" "+T(e))}});i=m}function I(m){switch(m.event){case"update":d.value.unshift(m.payload),d.value.splice(50);break;default:console.debug(m)}}function V(){i!==null&&i(),d.value=[]}function B(){return s+c+"/timelines/"+u[T(e)]+"?limit=20"}function W(){return l+c+"/streaming?access_token="+o+"&stream="+T(e)}return{posts:d,errors:h}}function Be(s,l){switch(l){case"only":return s.media_attachments.length>0;case"except":return s.media_attachments.length===0;default:return!0}}const We={class:"btn-toolbar mb-2",role:"toolbar","aria-label":"toolbar"},je={key:0,class:"alert alert-danger"},Ye=t("p",null,[t("strong",null,"Whoops!"),S(" Something went wrong!")],-1),Ae=t("hr",null,null,-1),Pe=y({__name:"UserTimeline",props:{domain:{},streaming:{},token:{}},setup(s){const l=s,o=v("public:local"),e=v("normal"),{posts:c,errors:_}=Ve(l.domain,l.streaming,l.token,o),d=U(()=>c.value.filter(h=>Be(h,e.value)));return(h,i)=>(r(),a("div",null,[t("div",We,[x(Oe,{onChanged:i[0]||(i[0]=u=>o.value=u)}),x(Ie,{onChanged:i[1]||(i[1]=u=>e.value=u)})]),n(_).length>0?(r(),a("div",je,[Ye,t("ul",null,[(r(!0),a(b,null,g(n(_),u=>(r(),a("li",null,w(u),1))),256))])])):f("",!0),x(Se,null,{default:q(()=>[(r(!0),a(b,null,g(d.value,u=>(r(),a("div",{key:u.id},[u.reblog?(r(),C(de,{key:0,post:u},null,8,["post"])):(r(),C(Te,{key:1,post:u},null,8,["post"])),Ae]))),128))]),_:1})]))}}),D=G({});D.component("tt-user-timeline",Pe);D.mount("#app");k(document.body);