define(["jquery"],function(t){t(document).on("click",".twitter-popup",function(e){e.preventDefault();var i=(t(window).width()-575)/2,n=(t(window).height()-253)/2,o=this.href,w="status=1,width=575,height=253,top="+n+",left="+i;window.open(o,"twitter",w)})});