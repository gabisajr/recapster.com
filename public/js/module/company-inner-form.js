define(["jquery","getAbsoluteUrl"],function(t,n){var a=t("form.company-inner-form");a.length&&a.submit(function(a){a.preventDefault();var e=t(this),i=e.find('input[name="p"]').val(),o=e.find('select[name="city"]'),r=e.attr("action"),f=document.createElement("a");f.href=r,r=f.pathname;var l=e.find('input[name="position_alias"]'),m=l.val(),c=m&&l.data("for-title")===i;c&&(r+="/"+m);var p=o.val();p&&(r+="/"+p),!c&&i&&(r+="?p="+i),r=n(r+="#company-bottom"),window.location.href=r})});