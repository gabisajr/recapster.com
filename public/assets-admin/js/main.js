define(["jquery","ckfinder","ckeditor","i18n","alert-message","confirm-modal","autocomplete","notify"],function(e,t,i,n){e.notify.defaults({position:"top center"}),e.ajaxSetup({headers:{"X-CSRF-TOKEN":window.app.csrfToken}}),t.setupCKEditor(null,"/ckfinder/"),e("textarea[data-ckeditor]").each(function(){var t=e(this).attr("id");i.replace(t,{extraPlugins:"justify"})}),e("figure.image-upload-preview .delete").click(function(){var t=e(this).closest("figure"),i=t.data("path");e.post("/admin/image/remove",{path:i}),t.fadeOut(function(){t.remove()})}),e("#header-search-form").find('input[name="q"]').autocompleteCompany({use_link:!0,admin_link:!0}),e(":input.autocomplete-company").autocompleteCompany(),e(":input.autocomplete-user").autocompleteUser(),e("form.delete-entity-form").submit(function(t,i){var o=e(this);i||(t.preventDefault(),window.confirmModal(n("Подтвердите удаление"),function(){o.trigger("submit",!0)}))}),function(){var t=e(".select2");t.length&&requirejs(["select2"],function(){t.select2()})}()});