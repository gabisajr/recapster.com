define(["jquery","autosize","i18n"],function(t,e,n){t(document).on("focus","form.add-review-comment-form textarea.comment",function(){var n=t(this);n.attr("rows",2),e.update(n),n.closest("form").find(".buttons").removeClass("hidden")}).on("click","form.add-review-comment-form :input.btn-cancel",function(){var n=t(this).closest("form");n.find(".buttons").addClass("hidden");var o=n.find("textarea.comment").val("").attr("rows",1);e.update(o)}).on("submit","form.add-review-comment-form",function(e){e.preventDefault();var n=t(this);n.find("textarea.comment").val()&&(n.find(':input[type="submit"]').prop("disabled",!0).find(".preloader").removeClass("hidden"),t.post(n.attr("action"),n.serialize(),function(t){t.success&&n.replaceWith(t.comment)}))}).on("click",".employer-comment .edit-comment",function(o){o.preventDefault();var m=t(this).closest(".employer-comment"),i=t(this).data();t.post("/tmpl/form/add-employer-comment",i,function(o){var a=t(o),r=a.attr("action","/"+i.type+"/editComment/"+i.id).find("textarea.comment").val(m.find(".comment-text").text().trim());e(r),a.find(':input[type="submit"]>span').text(n("Сохранить")),m.replaceWith(a),r.focus()})}).on("click",".employer-comment .delete-comment",function(n){n.preventDefault();var o=t(this).closest(".employer-comment"),m=t.extend({},t(this).data(),{});t.post("/"+m.type+"/deleteComment/"+m.id,function(n){if(n.success){var m=t(n.form),i=m.find("textarea.comment");e(i),o.replaceWith(m)}})})});