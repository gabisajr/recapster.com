define(["jquery"],function(a){a(".tabs").each(function(){var t=a(this),e=t.data("tabs"),i=t.siblings("#"+e);t.find(".tab").click(function(e){e.preventDefault();var s=a(this),n=s.data("target");s.hasClass("active")||(t.find(".tab.active").removeClass("active"),s.addClass("active"),i.find(".tab-content.active").hide().removeClass("active"),i.find(".tab-content").filter("#"+n).show().addClass("active"),s.trigger("tab_active"))})})});