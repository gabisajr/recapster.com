define(["jquery"],function(e){e(document).ready(function(){function o(){var o=e(window).scrollTop();o>n?o<r?t.removeClass("bottom").addClass("fixed"):t.removeClass("fixed").addClass("bottom"):t.removeClass("fixed")}var t=e(".side-nav"),s=t.outerHeight(),d=e("#aside").outerHeight(),i=e(".page-content"),a=i.outerHeight(),n=i.offset().top-14,r=a+i.offset().top-s-42-14;s==d||s>=d-42-14||(o(),e(window).scroll(o))})});