(window.webpackJsonp=window.webpackJsonp||[]).push([[0],{0:function(t,e,o){o("bUC5"),t.exports=o("pyCd")},"4aFR":function(t,e,o){"use strict";o.r(e);var n=o("KHd+"),a=Object(n.a)({},function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"card"},[e("div",{staticClass:"card bg-white"},[this._t("default")],2)])},[],!1,null,null,null);e.default=a.exports},"9Wh1":function(t,e,o){window._=o("LvDl"),window.Popper=o("8L3F").default;try{window.$=window.jQuery=o("EVdn"),o("SYky")}catch(t){}window.axios=o("vDqi"),window.axios.defaults.headers.common["X-Requested-With"]="XMLHttpRequest";var n=document.head.querySelector('meta[name="csrf-token"]');n?window.axios.defaults.headers.common["X-CSRF-TOKEN"]=n.content:console.error("CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token")},"9ceI":function(t,e,o){"use strict";o.r(e);var n=o("Y5dI");function a(t){return(a="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t})(t)}var s={components:{BootstrapToggle:o.n(n).a},data:function(){return{message:"",errors:[],check:this.checked,options:{off:'<i class="fa fa-eye-slash" aria-hidden="true"></i> Hide',on:'<i class="fa fa-eye" aria-hidden="true"></i> Show',size:"small"}}},props:{status:String,checked:Boolean},watch:{check:function(t){t?this.show():this.hide()}},methods:{show:function(){var t=this;this.errors=[],axios.put("/api/status/show/"+this.status).then(function(e){t.message=e.data.message}).catch(function(e){console.log(e),"object"===a(e.response.data)?t.errors=_.flatten(_.toArray(e.response.data)):t.errors=["Something went wrong. Please try again."]})},hide:function(){var t=this;this.errors=[],axios.delete("/api/status/hide/"+this.status).then(function(e){t.message=e.data.message}).catch(function(e){console.log(e),"object"===a(e.response.data)?t.errors=_.flatten(_.toArray(e.response.data)):t.errors=["Something went wrong. Please try again."]})}}},r=o("KHd+"),i=Object(r.a)(s,function(){var t=this,e=t.$createElement,o=t._self._c||e;return o("div",[o("bootstrap-toggle",{attrs:{options:t.options},model:{value:t.check,callback:function(e){t.check=e},expression:"check"}}),t._v(" "),t.errors.length>0?o("div",{staticClass:"alert alert-danger"},[t._m(0),t._v(" "),o("ul",t._l(t.errors,function(e){return o("li",[t._v(t._s(e))])}),0)]):t._e()],1)},[function(){var t=this.$createElement,e=this._self._c||t;return e("p",[e("strong",[this._v("Whoops!")]),this._v(" Something went wrong!")])}],!1,null,null,null);e.default=i.exports},BhCJ:function(t,e,o){"use strict";o.r(e);var n=o("cPJV"),a=o.n(n),s=o("yNUO"),r=o.n(s),i=o("GeFS"),c={props:["post"],methods:{display_name:function(){return this.post.account.display_name.length>0?this.emoji(this.post.account.display_name):this.post.account.username},reblog_display_name:function(){return this.post.reblog.account.display_name?this.emoji(this.post.reblog.account.display_name):this.post.reblog.account.username},emoji:function(t){return i.a.toImage(t)},formatDate:function(t){return a()(r()(t),"YYYY-MM-DD HH:mm:ss")}}},l=o("KHd+"),u=Object(l.a)(c,function(){var t=this,e=t.$createElement,o=t._self._c||e;return o("div",[o("span",{staticClass:"badge badge-info ml-1"},[o("img",{staticClass:"rounded-circle toot-icon-small",attrs:{src:t.post.account.avatar}}),t._v(" "),o("span",{domProps:{innerHTML:t._s(t.display_name())}}),t._v(" reblogged\n    ")]),t._v(" "),o("div",{staticClass:"media m-1 p-1"},[o("a",{attrs:{href:t.post.reblog.account.url,target:"_blank",rel:"nofollow noopener"}},[o("img",{staticClass:"rounded toot-icon",attrs:{src:t.post.reblog.account.avatar}})]),t._v(" "),o("div",{staticClass:"media-body ml-3"},[o("h4",[o("a",{attrs:{href:t.post.reblog.account.url,target:"_blank",rel:"nofollow noopener"},domProps:{innerHTML:t._s(t.reblog_display_name())}}),t._v(" "),o("small",{staticClass:"text-muted"},[t._v("\n                    @"+t._s(t.post.reblog.account.acct)+"\n                ")])]),t._v(" "),t.post.reblog.spoiler_text.length>0?o("button",{staticClass:"btn btn-warning btn-sm",attrs:{type:"button"},domProps:{innerHTML:t._s(t.emoji(t.post.reblog.spoiler_text))},on:{click:function(e){t.post.reblog.spoiler_text=""}}}):t._e(),t._v(" "),t.post.reblog.spoiler_text?t._e():o("div",{domProps:{innerHTML:t._s(t.emoji(t.post.reblog.content))}}),t._v(" "),t._l(t.post.reblog.media_attachments,function(e){return t.post.reblog.media_attachments?o("div",[o("a",{ref:"nofollow noopener",refInFor:!0,attrs:{href:e.url,target:"_blank"}},[o("img",{staticClass:"img-responsive img-thumbnail",attrs:{src:e.preview_url}})])]):t._e()}),t._v(" "),o("div",[o("a",{ref:"nofollow noopener",attrs:{href:t.post.reblog.url,target:"_blank"}},[t._v("\n                    "+t._s(t.formatDate(t.post.reblog.created_at))+"\n                ")])])],2)])])},[],!1,null,null,null);e.default=u.exports},GeFS:function(t,e,o){"use strict";var n=o("vc+K"),a=o.n(n);e.a={toImage:function(t){return a.a.parse(t)}}},bUC5:function(t,e,o){"use strict";o.r(e);var n=o("gEcF"),a=o.n(n),s=o("vc+K"),r=o.n(s);o("9Wh1"),window.Vue=o("XuX8"),Vue.use(a.a),Vue.component("tt-status-toggle",o("9ceI").default),Vue.component("tt-user-timeline",o("ctaw").default),Vue.component("tt-timeline-status",o("gMjA").default),Vue.component("tt-timeline-reblog",o("BhCJ").default),Vue.component("tt-calendar",o("tzoz").default),Vue.component("tt-card",o("4aFR").default);var i=new Vue({el:"#app"});$(window).resize(function(){i.$emit("redrawChart")}),r.a.parse(document.body)},ctaw:function(t,e,o){"use strict";o.r(e);var n=o("cPJV"),a=o.n(n),s=o("yNUO"),r=o.n(s);function i(t){return(i="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t})(t)}var c={data:function(){return{api_version:"/api/v1",ws:null,types:{user:'<i class="fa fa-home" aria-hidden="true"></i> User',"public:local":'<i class="fa fa-users" aria-hidden="true"></i> Local',public:'<i class="fa fa-globe" aria-hidden="true"></i> Federated'},active_type:"public:local",timelines:{user:"home","public:local":"public?local=true",public:"public"},titles:{mention:"mentioned you",reblog:"boosted your status",favourite:"favourited your status",follow:"followed you"},media:{normal:'<i class="fa fa-file-image-o" aria-hidden="true"></i> Media Default',only:'<i class="fa fa-picture-o" aria-hidden="true"></i> Only',except:'<i class="fa fa-commenting-o" aria-hidden="true"></i> Except'},active_media:"normal",posts:[],count:0,max:50,errors:[]}},computed:{endpoint:function(){return this.domain+this.api_version},streaming_url:function(){return this.streaming+this.api_version}},props:["domain","streaming","token"],mounted:function(){this.get(this.active_type)},methods:{get:function(){var t=this,e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"public:local";this.steam_close(),this.active_type=e;var o=this.timelines[e];axios.get(this.endpoint+"/timelines/"+o+"?limit=20",{headers:{Authorization:"Bearer "+this.token}}).then(function(o){console.log(o),t.posts=o.data,t.stream(e)}).catch(function(e){console.log(e),"object"===i(e.response.data)?t.errors=_.flatten(_.toArray(e.response.data)):t.errors=["Something went wrong. Please try again."]})},stream:function(){var t=this,e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"public:local";this.steam_open(e,function(e){if("notification"===e.event){console.log(e);var n=_.isEmpty(e.payload.account.display_name)?e.payload.account.username:e.payload.account.display_name,a=t.notificationTitle(e.payload.type,n),s=_.isEmpty(e.payload.status.spoiler_text)?e.payload.status.content:e.payload.status.spoiler_text;if(s=$("<p>").html(s).text(),"Notification"in window){if("Audio"in window)new Audio(o("tqXN")).play();Notification.requestPermission().then(function(){new Notification(a,{body:s,icon:e.payload.account.avatar,tag:e.payload.id})})}}else"update"===e.event&&(t.posts.unshift(e.payload),t.posts.splice(t.max))})},steam_open:function(t,e){this.ws=new WebSocket(this.streaming_url+"/streaming?access_token="+this.token+"&stream="+t),this.ws.onmessage=function(o){console.log("Got Data from Stream "+t),(o=JSON.parse(o.data)).payload=JSON.parse(o.payload),e(o)},this.ws.onclose=function(e){console.log("WebSocket Close "+t)}},steam_close:function(){_.isNull(this.ws)||(this.ws.close(),this.posts=[])},media_check:function(t){return"only"===this.active_media?!_.isEmpty(t.media_attachments):"except"!==this.active_media||_.isEmpty(t.media_attachments)},notificationTitle:function(t,e){return e+" "+this.titles[t]},formatDate:function(t){return a()(r()(t),"YYYY-MM-DD HH:mm:ss")}}},l=o("KHd+"),u=Object(l.a)(c,function(){var t=this,e=t.$createElement,o=t._self._c||e;return o("div",[o("div",{staticClass:"btn-toolbar mb-2",attrs:{role:"toolbar","aria-label":"toolbar"}},[o("div",{staticClass:"btn-group pr-1",attrs:{role:"group"}},t._l(t.types,function(e,n){return o("button",{staticClass:"btn btn-secondary",class:{active:t.active_type===n},attrs:{type:"button"},domProps:{innerHTML:t._s(e)},on:{click:function(e){return t.get(n)}}})}),0),t._v(" "),o("div",{staticClass:"btn-group",attrs:{role:"group"}},t._l(t.media,function(e,n){return o("button",{staticClass:"btn btn-secondary",class:{active:t.active_media===n},attrs:{type:"button"},domProps:{innerHTML:t._s(e)},on:{click:function(e){t.active_media=n}}})}),0)]),t._v(" "),t.errors.length>0?o("div",{staticClass:"alert alert-danger"},[t._m(0),t._v(" "),o("ul",t._l(t.errors,function(e){return o("li",[t._v(t._s(e))])}),0)]):t._e(),t._v(" "),o("tt-card",t._l(t.posts,function(e){return t.media_check(e)?o("div",[e.reblog?o("tt-timeline-reblog",{attrs:{post:e}}):o("tt-timeline-status",{attrs:{post:e}}),t._v(" "),o("hr")],1):t._e()}),0)],1)},[function(){var t=this.$createElement,e=this._self._c||t;return e("p",[e("strong",[this._v("Whoops!")]),this._v(" Something went wrong!")])}],!1,null,null,null);e.default=u.exports},gMjA:function(t,e,o){"use strict";o.r(e);var n=o("cPJV"),a=o.n(n),s=o("yNUO"),r=o.n(s),i=o("GeFS"),c={props:["post"],methods:{display_name:function(){return this.post.account.display_name?this.emoji(this.post.account.display_name):this.post.account.username},emoji:function(t){return i.a.toImage(t)},formatDate:function(t){return a()(r()(t),"YYYY-MM-DD HH:mm:ss")}}},l=o("KHd+"),u=Object(l.a)(c,function(){var t=this,e=t.$createElement,o=t._self._c||e;return o("div",{staticClass:"media p-1 m-1"},[o("a",{attrs:{href:t.post.account.url,target:"_blank",rel:"nofollow noopener"}},[o("img",{staticClass:"rounded toot-icon",attrs:{src:t.post.account.avatar}})]),t._v(" "),o("div",{staticClass:"media-body ml-3"},[o("h4",[o("a",{attrs:{href:t.post.account.url,target:"_blank",rel:"nofollow noopener"},domProps:{innerHTML:t._s(t.display_name())}}),t._v(" "),o("small",{staticClass:"text-muted"},[t._v(" @"+t._s(t.post.account.acct)+" ")])]),t._v(" "),t.post.spoiler_text.length>0?o("button",{staticClass:"btn btn-warning btn-sm",attrs:{type:"button"},domProps:{innerHTML:t._s(t.emoji(t.post.spoiler_text))},on:{click:function(e){t.post.spoiler_text=""}}}):t._e(),t._v(" "),t.post.spoiler_text?t._e():o("div",{domProps:{innerHTML:t._s(t.emoji(t.post.content))}}),t._v(" "),t._l(t.post.media_attachments,function(e){return t.post.media_attachments?o("div",[o("a",{ref:"nofollow noopener",refInFor:!0,attrs:{href:e.url,target:"_blank"}},[o("img",{staticClass:"img-responsive img-thumbnail",attrs:{src:e.preview_url}})])]):t._e()}),t._v(" "),o("div",[o("a",{ref:"nofollow noopener",attrs:{href:t.post.url,target:"_blank"}},[t._v("\n                "+t._s(t.formatDate(t.post.created_at))+"\n            ")])])],2)])},[],!1,null,null,null);e.default=u.exports},pyCd:function(t,e){},tqXN:function(t,e,o){t.exports=o.p+"/sounds/d846c333835efd1d9891227d824f8584.mp3"},tzoz:function(t,e,o){"use strict";o.r(e);var n=o("yNUO"),a=o.n(n),s={data:function(){return{packages:["calendar"],columns:[{type:"date",id:"Date"},{type:"number",id:"Toots"}],rows:[],options:{title:"",calendar:{monthLabel:{fontName:"Nunito",color:"#636b6f"},monthOutlineColor:{stroke:"#3097D1",strokeOpacity:.8,strokeWidth:1},unusedMonthOutlineColor:{stroke:"#636b6f",strokeOpacity:.2,strokeWidth:1},dayOfWeekLabel:{color:"#636b6f",fontName:"Nunito",fontSize:12},focusedCellColor:{stroke:"#3097D1",strokeOpacity:1,strokeWidth:2},yearLabel:{fontName:"Nunito",fontSize:32,bold:!0,italic:!0}},noDataPattern:{color:"#eee",backgroundColor:"#fff"},colorAxis:{minValue:0,colors:["#fff","#3097D1"]}}}},props:["user","acct"],mounted:function(){this.get()},methods:{get:function(){var t=this,e="";_.isEmpty(this.acct)||(e="/"+this.acct),axios.get("/api/calendar/"+this.user+e).then(function(e){t.rows=_.map(e.data,function(t,e){return Array(a()(e),t)})}).catch(function(t){console.log(t)})}},created:function(){var t=this;this.$on("redrawChart",function(){for(idx in console.log("redrawChart"),t.$children)t.$children[idx].$emit("redrawChart")})}},r=o("KHd+"),i=Object(r.a)(s,function(){var t=this.$createElement,e=this._self._c||t;return e("tt-card",[this.rows.length>0?e("vue-chart",{attrs:{packages:this.packages,"chart-type":"Calendar",columns:this.columns,rows:this.rows,options:this.options}}):this._e()],1)},[],!1,null,null,null);e.default=i.exports}},[[0,1,2]]]);