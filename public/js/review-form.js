define(["jquery","caretEnd","autosize","i18n","fancybox","mark-widget","autocomplete"],function(t,i,e,n){return function(a,o,d){if(a.length){o=o||{};var s=a.find(".mark-widget").markWidget(),u=a.find(":input#text"),r=a.find(":input#position"),c=a.find(":input#city"),f=a.find(".btn-submit");e(u),u.focus(i),r.focus(i),o.autofocus&&u.focus(),a.find(".show-additional").click(function(){var i=t(this).find(".caret");a.find(".additional-fields").toggle().is(":visible")?(r.focus(),i.addClass("caret-up")):i.removeClass("caret-up"),t.fancybox.update()}),r.autocompletePosition().autocomplete("widget").addClass("sm"),c.autocompleteCity().autocomplete("widget").addClass("sm"),a.submit(function(i){i.preventDefault(),t.ajax({url:a.attr("action"),type:a.attr("method"),data:a.serialize(),beforeSend:function(){f.prop("disabled",!0)},complete:function(){f.prop("disabled",!1)},success:function(i){if(i.success)return t.fancybox.close(),u.val(""),d(i.review);t.each(i.errors,function(t){"rating"==t?s.addClass("mark-widget-error").find(".mark-widget-caption").addClass("shake"):a.find(':input[name="'+t+'"]').focus()})}})}),window.onbeforeunload=function(t){if(u.is(":visible")&&u.val().trim()){t=t||window.event;var i=n("Вы уверены?");return t&&(t.returnValue=i),i}}}}});