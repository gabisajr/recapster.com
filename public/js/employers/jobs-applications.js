require(["/js/common.js"],function(){require(["jquery","modal/job-application"],function(a,n){var t=a("table#tbl-candidates");t.find(".open").click(function(i){i.preventDefault();var o=a(this).closest(".application-data").data();n(o,t)}),a(document).ready(function(){var a=t.data("auto-open");a&&t.find('.application-data[data-id="'+a+'"]').find(".open").click()})})});