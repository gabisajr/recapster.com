define(["jquery","modal/media-viewer","./parallax-cover.js","fast-image-upload","./aside.js","post/review"],function(e,i){!function(n){if(n.length){var t=JSON.parse(n.find(".gallery-json").html());n.find(".bubble-image").click(function(){i.open(this,t,{index:e(this).data("index"),container:n})})}}(e(".profile-images")),function(){function i(){n.hide(),t.show(),t.find(":input#text").focus()}var n=e(".last-review"),t=e(".review-form");e(".review-post").reviewPost({afterDelete:i}),t.length&&require(["review-form","i18n"],function(r,a){r(t,{},function(r){r=e(r).reviewPost({afterDelete:i}),t.hide(),n.find(".review-post").remove(),n.removeClass("hidden").show().find(".panel-header-title").text(a("Ваш отзыв")),r.hide().appendTo(n).fadeIn()})})}(),require(["swipe-tabs"])});