define("showMessageModal",["jquery","tplModalClose","fancybox"],function(e,d){function a(e,d){e&&(d?o.find(".modal-header").show().find(".modal-title").text(d):o.find(".modal-header").hide(),o.find(".message").html(e),l.click())}var o=e(".modal#message-modal"),l=e(".open-message-modal").fancybox({padding:0,fitToView:!1,closeBtn:!0,helpers:{overlay:{locked:!1}},tpl:{closeBtn:d}});return e(document).ready(function(){var e=o.find(".modal-header .modal-title").text(),d=o.find(".message").html();d&&a(d,e)}),a});