import{c8 as y,k as C,aA as M,aO as i,aP as w,y as t,aG as o,X as b,ba as _,_ as n,B as g,bc as B,Z as p,a5 as c,Y as r,F as D,c5 as L,c6 as S,c7 as A,ca as V,bi as H,ch as I,ci as z,cj as E,ck as P,cl as N,cm as R,cn as U,co as j,bM as q,cp as F,cr as G,cs as O,c2 as X,cv as Y,ct as Z,cq as J,bI as K,bU as Q,c4 as W,cu as ee}from"./Sidebar.js";const se=["src"],te=["href","target","data-testid"],ae={key:0},ne={class:"p-inputgroup flex-1"},oe={key:1,class:"flex align-items-center"},ie=n("i",{class:"pi pi-chevron-down text-sm mt-1 ml-1"},null,-1),ce={__name:"TopnavExtended",setup(k){const s=y(),d=C();M(async()=>{await s.getTopRightUserMenu()});const u=l=>{d.value.toggle(l)};return(l,v)=>{const h=i("Button"),f=i("InputText"),x=i("Avatar"),T=i("TieredMenu"),a=i("Menubar"),$=w("tooltip");return t(s).assets&&t(s).top_menu_items?(o(),b(a,{key:0,model:t(s).top_menu_items,class:"top-nav-fixed py-2 align-items-center"},{start:_(()=>[n("div",{class:g([{"w-225":!t(s).assets.is_logo_compressed_with_sidebar},"navbar-logo"])},[n("img",{src:t(s).assets.backend_logo_url,alt:"VaahCMS"},null,8,se)],2)]),item:_(({item:m})=>[B((o(),p("a",{href:m.url,target:m.target,"data-testid":"Topnav-"+m.icon.split("-")[1],class:"px-2"},[n("i",{class:g(["pi",m.icon])},null,2)],8,te)),[[$,m.tooltip,void 0,{bottom:!0}]])]),end:_(()=>[t(s).assets.is_impersonating?(o(),p("div",ae,[n("div",ne,[c(h,{size:"small",label:"Impersonating",outlined:""}),c(f,{class:"p-inputtext-sm",disabled:"",placeholder:t(s).assets.auth_user.name,value:t(s).assets.auth_user.name},null,8,["placeholder","value"]),c(h,{size:"small",onClick:v[0]||(v[0]=m=>t(s).impersonateLogout()),severity:"danger",label:"Leave"})])])):r("",!0),t(s).assets.auth_user&&!t(s).assets.is_impersonating?(o(),p("div",oe,[n("a",{onClick:u,"data-testid":"Topnav-Avatar",class:"cursor-pointer flex align-items-center"},[c(x,{image:t(s).assets.auth_user.avatar,class:"mr-2",shape:"circle"},null,8,["image"]),n("span",null,D(t(s).assets.auth_user.name),1),ie])])):r("",!0),t(s)&&t(s).top_right_user_menu?(o(),b(T,{key:2,model:t(s).top_right_user_menu,ref_key:"menu",ref:d,popup:!0},null,8,["model"])):r("",!0)]),_:1},8,["model"])):r("",!0)}}},re={id:"app-extend"},le={class:"p-toast-message-text"},pe=["innerHTML"],me=["innerHTML"],ue=["innerHTML"],_e={key:1,id:"topmenu-and-sidebar-container"},de={__name:"AppExtended",setup(k){const s=L(),d=S(),u=A();y(),u.setToast(s),u.setConfirm(d);const l=y();return M(async()=>{await l.checkLoggedIn(),await l.getAssets(),await l.getPermission()}),(v,h)=>{const f=i("ProgressBar"),x=i("Toast"),T=i("ConfirmDialog");return o(),p("div",re,[t(u).show_progress_bar?(o(),b(f,{key:0,style:{"z-index":"10000000",position:"fixed",top:"1px",width:"100%",left:"0px",height:"2px"},mode:"indeterminate"})):r("",!0),c(x,{class:"p-container-toasts",position:"top-center"},{message:_(a=>[n("div",le,[a.message.summary?(o(),p("span",{key:0,class:"p-toast-summary",innerHTML:a.message.summary},null,8,pe)):r("",!0),a.message.detail?(o(),p("div",{key:1,class:"p-toast-detail",innerHTML:a.message.detail},null,8,me)):r("",!0)])]),_:1}),c(T,{style:{width:"40vw"},class:"p-container-confirm-dialog text-red-200"},{message:_(a=>[n("i",{class:g([a.message.icon+" text-"+a.message.acceptClass+"-500","p-confirm-dialog-icon"])},null,2),n("span",{class:g(["text-"+a.message.acceptClass+"-500","p-confirm-dialog-message"]),innerHTML:a.message.message},null,10,ue)]),_:1}),t(l).is_logged_in?(o(),p("div",_e,[c(ce),c(V)])):r("",!0)])}}},e=H(de),ge=I();e.use(ge);e.use(z);e.use(E,{ripple:!0});e.use(P);e.use(N);e.use(R);e.directive("tooltip",U);e.directive("badge",j);e.directive("ripple",q);e.directive("styleclass",F);e.component("ConfirmDialog",G);e.component("Menu",O);e.component("ProgressBar",X);e.component("Toast",Y);e.component("Menubar",Z);e.component("Avatar",J);e.component("Button",K);e.component("InputText",Q);e.component("TieredMenu",W);e.component("PanelMenu",ee);e.mount("#themeVaahTwoExtend");
