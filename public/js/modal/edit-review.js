define(["jquery","modal","fancybox"],function(e,o){return function(n){e.fancybox.open({type:"ajax",padding:0,tpl:{closeBtn:o.close},helpers:{overlay:{locked:!1}},href:"/review/form/"+n,minWidth:500,openEffect:"none",closeEffect:"none",scrolling:"visible",afterShow:function(){require(["review-form"],function(o){o(e(".review-form"),{autofocus:!0},function(){window.location.reload()}),setTimeout(function(){e.fancybox.update()},100)})}})}});