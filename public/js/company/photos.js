define(["jquery","modal/media-viewer","./aside.js","./parallax-cover.js","search","fast-image-upload"],function(e,a){!function(i){if(i.length){var t=i.data("target"),n=JSON.parse(e("script#"+t).html());e(".btn-load-more");i.on("click",".bubble-image",function(t){t.preventDefault(),a.open(this,n,{index:e(this).data("index"),container:i})})}}(e(".search-results")),require(["swipe-tabs"])});