require(["jquery","modal","fancybox"],function(e,o){e(document).ready(function(){e.fancybox.open({type:"ajax",href:"/tmpl/modal/welcome",padding:0,fitToView:!0,helpers:{overlay:{locked:!1}},tpl:{closeBtn:o.close}})})});