!function(e){e.Jcrop=function(t,n){function o(e){return e+"px"}function r(e){return R.baseClass+"-"+e}function a(){return e.fx.step.hasOwnProperty("backgroundColor")}function i(t){var n=e(t).offset();return[n.left,n.top]}function s(e){return[e.pageX-J[0],e.pageY-J[1]]}function c(t){"object"!=typeof t&&(t={}),R=e.extend(R,t),e.each(["onChange","onSelect","onRelease","onDblClick"],function(e,t){"function"!=typeof R[t]&&(R[t]=function(){})})}function u(e,t){if(J=i(W),pe.setCursor("move"===e?e:e+"-resize"),"move"===e)return pe.activateHandlers(l(t),b);var n=le.getFixed(),o=h(e),r=le.getCorner(h(o));le.setPressed(le.getCorner(o)),le.setCurrent(r),pe.activateHandlers(d(e,n),b)}function d(e,t){return function(n){if(R.aspectRatio)switch(e){case"e":n[1]=t.y+1;break;case"w":n[1]=t.y+1;break;case"n":n[0]=t.x+1;break;case"s":n[0]=t.x+1}else switch(e){case"e":n[1]=t.y2;break;case"w":n[1]=t.y2;break;case"n":n[0]=t.x2;break;case"s":n[0]=t.x2}le.setCurrent(n),fe.update()}}function l(e){var t=e;return ge.watchKeys(),function(e){le.moveOffset([e[0]-t[0],e[1]-t[1]]),t=e,fe.update()}}function h(e){switch(e){case"n":return"sw";case"s":return"nw";case"e":return"nw";case"w":return"ne";case"ne":return"sw";case"nw":return"se";case"se":return"nw";case"sw":return"ne"}}function f(e){return function(t){return R.disabled?!1:"move"!==e||R.allowMove?(J=i(W),oe=!0,u(e,s(t)),t.stopPropagation(),t.preventDefault(),!1):!1}}function p(e,t,n){var o=e.width(),r=e.height();o>t&&t>0&&(o=t,r=t/e.width()*e.height()),r>n&&n>0&&(r=n,o=n/e.height()*e.width()),te=e.width()/o,ne=e.height()/r,e.width(o).height(r)}function g(e){return{x:e.x*te,y:e.y*ne,x2:e.x2*te,y2:e.y2*ne,w:e.w*te,h:e.h*ne}}function b(e){var t=le.getFixed();t.w>R.minSelect[0]&&t.h>R.minSelect[1]?(fe.enableHandles(),fe.done()):fe.release(),pe.setCursor(R.allowSelect?"crosshair":"default")}function w(e){if(R.disabled)return!1;if(!R.allowSelect)return!1;oe=!0,J=i(W),fe.disableHandles(),pe.setCursor("crosshair");var t=s(e);return le.setPressed(t),fe.update(),pe.activateHandlers(v,b),ge.watchKeys(),e.stopPropagation(),e.preventDefault(),!1}function v(e){le.setCurrent(e),fe.update()}function m(){var t=e("<div></div>").addClass(r("tracker"));return e.browser.msie&&t.css({opacity:0,backgroundColor:"white"}),t}function C(e){L.removeClass().addClass(r("holder")).addClass(e)}function S(e,t){function n(){window.setTimeout(v,l)}var o=e[0]/te,r=e[1]/ne,a=e[2]/te,i=e[3]/ne;if(!re){var s=le.flipCoords(o,r,a,i),c=le.getFixed(),u=[c.x,c.y,c.x2,c.y2],d=u,l=R.animationDelay,h=s[0]-u[0],f=s[1]-u[1],p=s[2]-u[2],g=s[3]-u[3],b=0,w=R.swingSpeed;x=d[0],y=d[1],a=d[2],i=d[3],fe.animMode(!0);var v=function(){return function(){b+=(100-b)/w,d[0]=x+b/100*h,d[1]=y+b/100*f,d[2]=a+b/100*p,d[3]=i+b/100*g,b>=99.8&&(b=100),100>b?(z(d),n()):(fe.done(),"function"==typeof t&&t.call(be))}}();n()}}function k(e){z([e[0]/te,e[1]/ne,e[2]/te,e[3]/ne]),R.onSelect.call(be,g(le.getFixed())),fe.enableHandles()}function z(e){le.setPressed([e[0],e[1]]),le.setCurrent([e[2],e[3]]),fe.update()}function O(){return g(le.getFixed())}function F(){return le.getFixed()}function j(e){c(e),P()}function H(){R.disabled=!0,fe.disableHandles(),fe.setCursor("default"),pe.setCursor("default")}function D(){R.disabled=!1,P()}function M(){fe.done(),pe.activateHandlers(null,null)}function T(){L.remove(),Y.show(),e(t).removeData("Jcrop")}function I(e,t){fe.release(),H();var n=new Image;n.onload=function(){var o=n.width,r=n.height,a=R.boxWidth,i=R.boxHeight;W.width(o).height(r),W.attr("src",e),N.attr("src",e),p(W,a,i),q=W.width(),G=W.height(),N.width(q).height(G),se.width(q+2*ie).height(G+2*ie),L.width(q).height(G),he.resize(q,G),D(),"function"==typeof t&&t.call(be)},n.src=e}function B(e,t,n){var o=t||R.bgColor;R.bgFade&&a()&&R.fadeTime&&!n?e.animate({backgroundColor:o},{queue:!1,duration:R.fadeTime}):e.css("backgroundColor",o)}function P(e){R.allowResize?e?fe.enableOnly():fe.enableHandles():fe.disableHandles(),pe.setCursor(R.allowSelect?"crosshair":"default"),fe.setCursor(R.allowMove?"move":"default"),R.hasOwnProperty("trueSize")&&(te=R.trueSize[0]/q,ne=R.trueSize[1]/G),R.hasOwnProperty("setSelect")&&(k(R.setSelect),fe.done(),delete R.setSelect),he.refresh(),R.bgColor!=ce&&(B(R.shade?he.getShades():L,R.shade?R.shadeColor||R.bgColor:R.bgColor),ce=R.bgColor),ue!=R.bgOpacity&&(ue=R.bgOpacity,R.shade?he.refresh():fe.setBgOpacity(ue)),Z=R.maxSize[0]||0,$=R.maxSize[1]||0,_=R.minSize[0]||0,ee=R.minSize[1]||0,R.hasOwnProperty("outerImage")&&(W.attr("src",R.outerImage),delete R.outerImage),fe.refresh()}var J,R=e.extend({},e.Jcrop.defaults),A=!1;e.browser.msie&&"6"===e.browser.version.split(".")[0]&&(A=!0),"object"!=typeof t&&(t=e(t)[0]),"object"!=typeof n&&(n={}),c(n);var E={border:"none",visibility:"visible",margin:0,padding:0,position:"absolute",top:0,left:0},Y=e(t),X=!0;if("IMG"==t.tagName){if(0!=Y[0].width&&0!=Y[0].height)Y.width(Y[0].width),Y.height(Y[0].height);else{var K=new Image;K.src=Y[0].src,Y.width(K.width),Y.height(K.height)}var W=Y.clone().removeAttr("id").css(E).show();W.width(Y.width()),W.height(Y.height()),Y.after(W).hide()}else W=Y.css(E).show(),X=!1,null===R.shade&&(R.shade=!0);p(W,R.boxWidth,R.boxHeight);var q=W.width(),G=W.height(),L=e("<div />").width(q).height(G).addClass(r("holder")).css({position:"relative",backgroundColor:R.bgColor}).insertAfter(Y).append(W);R.addClass&&L.addClass(R.addClass);var N=e("<div />"),V=e("<div />").width("100%").height("100%").css({zIndex:310,position:"absolute",overflow:"hidden"}),Q=e("<div />").width("100%").height("100%").css("zIndex",320),U=e("<div />").css({position:"absolute",zIndex:600}).dblclick(function(){var e=le.getFixed();R.onDblClick.call(be,e)}).insertBefore(W).append(V,Q);X&&(N=e("<img />").attr("src",W.attr("src")).css(E).width(q).height(G),V.append(N)),A&&U.css({overflowY:"hidden"});var Z,$,_,ee,te,ne,oe,re,ae,ie=R.boundary,se=m().width(q+2*ie).height(G+2*ie).css({position:"absolute",top:o(-ie),left:o(-ie),zIndex:290}).mousedown(w),ce=R.bgColor,ue=R.bgOpacity;J=i(W);var de=function(){function e(){var e,t={},n=["touchstart","touchmove","touchend"],o=document.createElement("div");try{for(e=0;e<n.length;e++){var r=n[e];r="on"+r;var a=r in o;a||(o.setAttribute(r,"return;"),a="function"==typeof o[r]),t[n[e]]=a}return t.touchstart&&t.touchend&&t.touchmove}catch(i){return!1}}function t(){return R.touchSupport===!0||R.touchSupport===!1?R.touchSupport:e()}return{createDragger:function(e){return function(t){return t.pageX=t.originalEvent.changedTouches[0].pageX,t.pageY=t.originalEvent.changedTouches[0].pageY,R.disabled?!1:"move"!==e||R.allowMove?(oe=!0,u(e,s(t)),t.stopPropagation(),t.preventDefault(),!1):!1}},newSelection:function(e){return e.pageX=e.originalEvent.changedTouches[0].pageX,e.pageY=e.originalEvent.changedTouches[0].pageY,w(e)},isSupported:e,support:t()}}(),le=function(){function e(e){e=i(e),p=h=e[0],g=f=e[1]}function t(e){e=i(e),d=e[0]-p,l=e[1]-g,p=e[0],g=e[1]}function n(){return[d,l]}function o(e){var t=e[0],n=e[1];0>h+t&&(t-=t+h),0>f+n&&(n-=n+f),g+n>G&&(n+=G-(g+n)),p+t>q&&(t+=q-(p+t)),h+=t,p+=t,f+=n,g+=n}function r(e){var t=a();switch(e){case"ne":return[t.x2,t.y];case"nw":return[t.x,t.y];case"se":return[t.x2,t.y2];case"sw":return[t.x,t.y2]}}function a(){if(!R.aspectRatio)return c();var e,t,n,o,r=R.aspectRatio,a=R.minSize[0]/te,i=R.maxSize[0]/te,d=R.maxSize[1]/ne,l=p-h,b=g-f,w=Math.abs(l),v=Math.abs(b),y=w/v;return 0===i&&(i=10*q),0===d&&(d=10*G),r>y?(t=g,n=v*r,e=0>l?h-n:n+h,0>e?(e=0,o=Math.abs((e-h)/r),t=0>b?f-o:o+f):e>q&&(e=q,o=Math.abs((e-h)/r),t=0>b?f-o:o+f)):(e=p,o=w/r,t=0>b?f-o:f+o,0>t?(t=0,n=Math.abs((t-f)*r),e=0>l?h-n:n+h):t>G&&(t=G,n=Math.abs(t-f)*r,e=0>l?h-n:n+h)),e>h?(a>e-h?e=h+a:e-h>i&&(e=h+i),t=t>f?f+(e-h)/r:f-(e-h)/r):h>e&&(a>h-e?e=h-a:h-e>i&&(e=h-i),t=t>f?f+(h-e)/r:f-(h-e)/r),0>e?(h-=e,e=0):e>q&&(h-=e-q,e=q),0>t?(f-=t,t=0):t>G&&(f-=t-G,t=G),u(s(h,f,e,t))}function i(e){return e[0]<0&&(e[0]=0),e[1]<0&&(e[1]=0),e[0]>q&&(e[0]=q),e[1]>G&&(e[1]=G),[e[0],e[1]]}function s(e,t,n,o){var r=e,a=n,i=t,s=o;return e>n&&(r=n,a=e),t>o&&(i=o,s=t),[r,i,a,s]}function c(){var e,t=p-h,n=g-f;return Z&&Math.abs(t)>Z&&(p=t>0?h+Z:h-Z),$&&Math.abs(n)>$&&(g=n>0?f+$:f-$),ee/ne&&Math.abs(n)<ee/ne&&(g=n>0?f+ee/ne:f-ee/ne),_/te&&Math.abs(t)<_/te&&(p=t>0?h+_/te:h-_/te),0>h&&(p-=h,h-=h),0>f&&(g-=f,f-=f),0>p&&(h-=p,p-=p),0>g&&(f-=g,g-=g),p>q&&(e=p-q,h-=e,p-=e),g>G&&(e=g-G,f-=e,g-=e),h>q&&(e=h-G,g-=e,f-=e),f>G&&(e=f-G,g-=e,f-=e),u(s(h,f,p,g))}function u(e){return{x:e[0],y:e[1],x2:e[2],y2:e[3],w:e[2]-e[0],h:e[3]-e[1]}}var d,l,h=0,f=0,p=0,g=0;return{flipCoords:s,setPressed:e,setCurrent:t,getOffset:n,moveOffset:o,getCorner:r,getFixed:a}}(),he=function(){function t(e,t){p.left.css({height:o(t)}),p.right.css({height:o(t)})}function n(){return r(le.getFixed())}function r(e){p.top.css({left:o(e.x),width:o(e.w),height:o(e.y)}),p.bottom.css({top:o(e.y2),left:o(e.x),width:o(e.w),height:o(G-e.y2)}),p.right.css({left:o(e.x2),width:o(q-e.x2)}),p.left.css({width:o(e.x)})}function a(){return e("<div />").css({position:"absolute",backgroundColor:R.shadeColor||R.bgColor}).appendTo(f)}function i(){h||(h=!0,f.insertBefore(W),n(),fe.setBgOpacity(1,0,1),N.hide(),s(R.shadeColor||R.bgColor,1),fe.isAwake()?u(R.bgOpacity,1):u(1,1))}function s(e,t){B(l(),e,t)}function c(){h&&(f.remove(),N.show(),h=!1,fe.isAwake()?fe.setBgOpacity(R.bgOpacity,1,1):(fe.setBgOpacity(1,1,1),fe.disableHandles()),B(L,0,1))}function u(e,t){h&&(R.bgFade&&!t?f.animate({opacity:1-e},{queue:!1,duration:R.fadeTime}):f.css({opacity:1-e}))}function d(){R.shade?i():c(),fe.isAwake()&&u(R.bgOpacity)}function l(){return f.children()}var h=!1,f=e("<div />").css({position:"absolute",zIndex:240,opacity:0}),p={top:a(),left:a().height(G),right:a().height(G),bottom:a()};return{update:n,updateRaw:r,getShades:l,setBgColor:s,enable:i,disable:c,resize:t,refresh:d,opacity:u}}(),fe=function(){function t(t){var n=e("<div />").css({position:"absolute",opacity:R.borderOpacity}).addClass(r(t));return V.append(n),n}function n(t,n){var o=e("<div />").mousedown(f(t)).css({cursor:t+"-resize",position:"absolute",zIndex:n}).addClass("ord-"+t);return de.support&&o.bind("touchstart.jcrop",de.createDragger(t)),Q.append(o),o}function a(e){var t=R.handleSize;return n(e,F++).css({opacity:R.handleOpacity}).width(t).height(t).addClass(r("handle"))}function i(e){return n(e,F++).addClass("jcrop-dragbar")}function s(e){var t;for(t=0;t<e.length;t++)D[e[t]]=i(e[t])}function c(e){var n,o;for(o=0;o<e.length;o++){switch(e[o]){case"n":n="hline";break;case"s":n="hline bottom";break;case"e":n="vline right";break;case"w":n="vline"}j[e[o]]=t(n)}}function u(e){var t;for(t=0;t<e.length;t++)H[e[t]]=a(e[t])}function d(e,t){R.shade||N.css({top:o(-t),left:o(-e)}),U.css({top:o(t),left:o(e)})}function l(e,t){U.width(e).height(t)}function h(){var e=le.getFixed();le.setPressed([e.x,e.y]),le.setCurrent([e.x2,e.y2]),p()}function p(e){return O?b(e):void 0}function b(e){var t=le.getFixed();l(t.w,t.h),d(t.x,t.y),R.shade&&he.updateRaw(t),O||v(),e?R.onSelect.call(be,g(t)):R.onChange.call(be,g(t))}function w(e,t,n){(O||t)&&(R.bgFade&&!n?W.animate({opacity:e},{queue:!1,duration:R.fadeTime}):W.css("opacity",e))}function v(){U.show(),R.shade?he.opacity(ue):w(ue,!0),O=!0}function y(){S(),U.hide(),R.shade?he.opacity(1):w(1),O=!1,R.onRelease.call(be)}function x(){M&&Q.show()}function C(){return M=!0,R.allowResize?(Q.show(),!0):void 0}function S(){M=!1,Q.hide()}function k(e){re===e?S():C()}function z(){k(!1),h()}var O,F=370,j={},H={},D={},M=!1;R.dragEdges&&e.isArray(R.createDragbars)&&s(R.createDragbars),e.isArray(R.createHandles)&&u(R.createHandles),R.drawBorders&&e.isArray(R.createBorders)&&c(R.createBorders),e(document).bind("touchstart.jcrop-ios",function(t){e(t.currentTarget).hasClass("jcrop-tracker")&&t.stopPropagation()});var T=m().mousedown(f("move")).css({cursor:"move",position:"absolute",zIndex:360});return de.support&&T.bind("touchstart.jcrop",de.createDragger("move")),V.append(T),S(),{updateVisible:p,update:b,release:y,refresh:h,isAwake:function(){return O},setCursor:function(e){T.css("cursor",e)},enableHandles:C,enableOnly:function(){M=!0},showHandles:x,disableHandles:S,animMode:k,setBgOpacity:w,done:z}}(),pe=function(){function t(){se.css({zIndex:450}),de.support&&e(document).bind("touchmove.jcrop",i).bind("touchend.jcrop",c),h&&e(document).bind("mousemove.jcrop",o).bind("mouseup.jcrop",r)}function n(){se.css({zIndex:290}),e(document).unbind(".jcrop")}function o(e){return d(s(e)),!1}function r(e){return e.preventDefault(),e.stopPropagation(),oe&&(oe=!1,l(s(e)),fe.isAwake()&&R.onSelect.call(be,g(le.getFixed())),n(),d=function(){},l=function(){}),!1}function a(e,n){return oe=!0,d=e,l=n,t(),!1}function i(e){return e.pageX=e.originalEvent.changedTouches[0].pageX,e.pageY=e.originalEvent.changedTouches[0].pageY,o(e)}function c(e){return e.pageX=e.originalEvent.changedTouches[0].pageX,e.pageY=e.originalEvent.changedTouches[0].pageY,r(e)}function u(e){se.css("cursor",e)}var d=function(){},l=function(){},h=R.trackDocument;return h||se.mousemove(o).mouseup(r).mouseout(r),W.before(se),{activateHandlers:a,setCursor:u}}(),ge=function(){function t(){R.keySupport&&(a.show(),a.focus())}function n(e){a.hide()}function o(e,t,n){R.allowMove&&(le.moveOffset([t,n]),fe.updateVisible(!0)),e.preventDefault(),e.stopPropagation()}function r(e){if(e.ctrlKey||e.metaKey)return!0;ae=e.shiftKey?!0:!1;var t=ae?10:1;switch(e.keyCode){case 37:o(e,-t,0);break;case 39:o(e,t,0);break;case 38:o(e,0,-t);break;case 40:o(e,0,t);break;case 27:R.allowSelect&&fe.release();break;case 9:return!0}return!1}var a=e('<input type="radio" />').css({position:"fixed",left:"-120px",width:"12px"}),i=e("<div />").css({position:"absolute",overflow:"hidden"}).append(a);return R.keySupport&&(a.keydown(r).blur(n),A||!R.fixedSupport?(a.css({position:"absolute",left:"-20px"}),i.append(a).insertBefore(W)):a.insertBefore(W)),{watchKeys:t}}();de.support&&se.bind("touchstart.jcrop",de.newSelection),Q.hide(),P(!0);var be={setImage:I,animateTo:S,setSelect:k,setOptions:j,tellSelect:O,tellScaled:F,setClass:C,disable:H,enable:D,cancel:M,release:fe.release,destroy:T,focus:ge.watchKeys,getBounds:function(){return[q*te,G*ne]},getWidgetSize:function(){return[q,G]},getScaleFactor:function(){return[te,ne]},getOptions:function(){return R},ui:{holder:L,selection:U}};return e.browser.msie&&L.bind("selectstart",function(){return!1}),Y.data("Jcrop",be),be},e.fn.Jcrop=function(t,n){var o;return this.each(function(){if(e(this).data("Jcrop")){if("api"===t)return e(this).data("Jcrop");e(this).data("Jcrop").setOptions(t)}else"IMG"==this.tagName?e.Jcrop.Loader(this,function(){e(this).css({display:"block",visibility:"hidden"}),o=e.Jcrop(this,t),e.isFunction(n)&&n.call(o)}):(e(this).css({display:"block",visibility:"hidden"}),o=e.Jcrop(this,t),e.isFunction(n)&&n.call(o))}),this},e.Jcrop.Loader=function(t,n,o){function r(){i.complete?(a.unbind(".jcloader"),e.isFunction(n)&&n.call(i)):window.setTimeout(r,50)}var a=e(t),i=a[0];a.bind("load.jcloader",r).bind("error.jcloader",function(t){a.unbind(".jcloader"),e.isFunction(o)&&o.call(i)}),i.complete&&e.isFunction(n)&&(a.unbind(".jcloader"),n.call(i))},e.Jcrop.defaults={allowSelect:!0,allowMove:!0,allowResize:!0,trackDocument:!0,baseClass:"jcrop",addClass:null,bgColor:"black",bgOpacity:.6,bgFade:!1,borderOpacity:.4,handleOpacity:.5,handleSize:7,aspectRatio:0,keySupport:!0,createHandles:["n","s","e","w","nw","ne","se","sw"],createDragbars:["n","s","e","w"],createBorders:["n","s","e","w"],drawBorders:!0,dragEdges:!0,fixedSupport:!0,touchSupport:null,shade:null,boxWidth:0,boxHeight:0,boundary:2,fadeTime:400,animationDelay:20,swingSpeed:3,minSelect:[0,0],maxSize:[0,0],minSize:[0,0],onChange:function(){},onSelect:function(){},onDblClick:function(){},onRelease:function(){}}}(jQuery);