require(["/js/common.js"],function(){require(["jquery","applyAutocomplete"],function(e,t){var n=e("form#signup-employers-form");n.length&&(n.on("click","#complete-company-profile",function(n){n.preventDefault();var o=e(this).closest("form").find('input[name="company_title"]').removeClass("error").val();e.get("/tmpl/partials/company-add-process",function(n){var i=e(n),a=o.rus_about();i.find("#tell-more-about-caption").text("Расскажите нам больше "+a+" "+o),e("#company-add-process-wrap").hide().html(i.html()).fadeIn(function(){e(this).find('input[name="new_company[site]"]').focus()}),t()}),e(this).closest(".text-error").remove()}),n.find("input.company.title").keyup(function(){e(this).val()||n.find("#company-add-process-wrap").html("")}).change(function(){loadNewCompanyFields(this)}))})});