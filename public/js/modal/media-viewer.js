define(["jquery","getImgRealSize","keyCodes","jquery.easing","jquery.transform2d"],function(t,e,i){return new function(){function n(){var t=x.getBoundingClientRect(),e=m[0].getBoundingClientRect(),i=r(e),n=r(t),o=n.x-i.x+"px",s=n.y-i.y+"px",a=t.width/e.width,d=t.width/t.height;m.css({transform:"translateX("+o+") translateY("+s+") scale("+a+")",borderRadius:P.avatar?"50%":"0%",height:e.width/d}),v.show(),m.animate({transform:"translateX(0px) translateY(0px) scale(1)",borderRadius:"0%",height:h(0,!0).height},c,"easeOutSine")}function o(t){if(O.length&&(x=P.container.find('.bubble-image[data-index="'+u+'"]')[0]),!x||!f(x))return t&&t();var e=x.getBoundingClientRect(),i=m[0].getBoundingClientRect(),n=r(i),o=r(e),s=o.x-n.x+"px",a=o.y-n.y+"px",d=e.width/i.width,h=e.width/e.height;m.animate({transform:"translateX("+s+") translateY("+a+") scale("+d+")",borderRadius:P.avatar?"50%":"0%",height:i.width/h},c,"easeOutSine",t)}function s(t){switch(t.keyCode){case i.RIGHT:k.next();break;case i.LEFT:k.prev();break;case i.ESC:k.close()}}function a(){u>0?y.removeClass("disabled-btn"):y.addClass("disabled-btn"),u<O.length-1?C.removeClass("disabled-btn"):C.addClass("disabled-btn")}function d(t,i){v.attr("src",t),e(t,function(t){l=t.width,g=t.height,w=l/g,h(),i&&i()})}function h(t,e){var i=b.height(),n=b.width();if(i<n)var o=Math.min(i,g),s={height:o,width:o*w};else s={height:(o=Math.min(n,l))*w,width:o};if(e)return s;m.css(s)}function r(t){return{x:t.left+t.width/2,y:t.top+t.height/2}}function f(t){for(var e=t.offsetTop,i=t.offsetLeft,n=t.offsetWidth,o=t.offsetHeight;t.offsetParent;)e+=(t=t.offsetParent).offsetTop,i+=t.offsetLeft;return e<window.pageYOffset+window.innerHeight&&i<window.pageXOffset+window.innerWidth&&e+o>window.pageYOffset&&i+n>window.pageXOffset}var c,u,l,g,w,p,b,m,v,x,y,C,k=this,R=t("body"),O=[],P={};t.ajax({url:"/tmpl/modal/media-viewer",success:function(e){p=t(e),b=p.find(".media"),m=p.find(".wrapper"),v=p.find("img.media-viewer-img").hide(),y=p.find(".btn-media-prev").hide(),C=p.find(".btn-media-next").hide(),v.click(function(t){t.stopPropagation(),this.next()}.bind(this)),y.click(function(t){t.stopPropagation(),this.prev()}.bind(this)),C.click(function(t){t.stopPropagation(),this.next()}.bind(this)),p.click(function(){this.close()}.bind(this))}.bind(this)}),this.open=function(e){x=e,arguments.length<=2?(O=[],P=arguments[1]||{}):3===arguments.length&&(O=arguments[1]||[],P=arguments[2]||{}),R.css("overflow","hidden"),p.prependTo(R).stop().show();var i=null;O.length?(u=P.index||0,i=O[u].href):e.src&&(i=e.src),c=P.duration||300,d(i,function(){n()}.bind(this)),O.length?(y.show(),C.show(),a()):(y.hide(),C.hide()),t(document).on("keydown",s),t(window).on("resize",h)},this.close=function(){o(function(){p.fadeOut(300,function(){p.detach(),m.css("transform","none"),v.hide()}),R.css("overflow","auto")}.bind(this)),t(document).off("keydown",s),t(window).off("resize",h)},this.prev=function(){u>0&&(u--,this.goto())},this.next=function(){u<O.length-1&&(u++,this.goto())},this.goto=function(){d(O[u].href),a()}}});