require(["/js/common.js"],function(){require(["jquery","BIT","SURVEY_TYPE"],function(e,n,i){function t(){a.find('input[name="active_employee"]:checked').val()==n.YES?(a.find(".job-ending-year").addClass("hidden"),a.find('select[name="last_year"]').val("").prop("required",!1)):(a.find(".job-ending-year").removeClass("hidden"),a.find('select[name="last_year"]').prop("required",!0))}var a=e("form#survey-start-form");a.find('input[name="survey_type"]').change(function(){var t=e(this).val();t==i.PHOTO||t==i.INTERVIEW?(a.find(".job-status").addClass("hidden"),a.find('input[name="active_employee"][value="'+n.YES+'"]').click()):a.find(".job-status").removeClass("hidden"),t==i.SALARY?(a.find(".position-fieldset").removeClass("hidden"),a.find(".company-fieldset").addClass("hidden"),a.find("label#job-status-label").text("Статус работы"),a.find('label[for="active-employee-yes"]').text("Текущая работа"),a.find('label[for="active-employee-no"]').text("Бывшая работа"),a.find("input.company.title").attr("required",!1),a.find("input.position.title").attr("required",!0).focus(),window.xhrLoadNewCompanyFields&&window.xhrLoadNewCompanyFields.abort(),a.find("#company-add-process-wrap").html("")):(a.find(".position-fieldset").addClass("hidden"),a.find(".company-fieldset").removeClass("hidden"),a.find("label#job-status-label").text("Статус работника"),a.find('label[for="active-employee-yes"]').text("Действующий"),a.find('label[for="active-employee-no"]').text("Бывшый"),a.find("input.position.title").attr("required",!1),a.find("input.company.title").attr("required",!0).focus())}),t(),a.find('input[name="active_employee"]').change(function(){t()}),a.find('input[name="company_title"]').keyup(function(){e(this).val()||a.find("#company-add-process-wrap").html("")}).change(function(){loadNewCompanyFields(this)}),a.submit(function(n){var t=e(this),a=t.find('input[name="survey_type"]:checked').val(),d=t.find('input[name="company"]').val()||t.find('input[type="radio"][name="company"]:checked').val()||null,o=t.find('input[name="want_create_company"]').is(":checked");a==i.SALARY||d||o||n.preventDefault()})})});