define(["jquery","./parallax-cover.js","./aside.js","post/review"],function(e){e(".review-post").reviewPost();var i=e(".review-form");i.length&&require(["review-form","i18n"],function(e){e(i,{},function(){window.location.reload()})}),require(["swipe-tabs"])});