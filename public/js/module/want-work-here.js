define(["jquery","showSigninModal","i18n"],function(a,e,n){function t(a){a.addClass("active green accent-4").removeClass("grey lighten-4"),a.find("i").removeClass("fa-heart-o").addClass("fa-heart")}function s(a){a.removeClass("active green accent-4").addClass("grey lighten-4"),a.find("i").removeClass("fa-heart").addClass("fa-heart-o")}a(".btn-want-work-here").click(function(){var i=a(this);i.hasClass("active")?s(i):t(i),a.ajax({url:"/wantworkhere",type:"post",data:{id:a(this).data("id")},success:function(a){a.success?(a.has?t(i):s(i),a.caption&&a.has&&a.count>1?i.find(".caption").text(a.caption):i.find(".caption").text(n("Хочу тут работать"))):401==a.code?(e(),s(i)):console.log("Unknown error")}})})});