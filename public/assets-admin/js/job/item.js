define(["jquery","autosize","caretEnd","select2","autocomplete","tagEditor"],function(e,t,a){var n=e("form#job-form"),s=n.find(':input[name="apply_type"]'),i=n.find(".form-group.contacts"),o=n.find(".form-group.external_url"),c=i.find(':input[name="contacts"]'),r=o.find(':input[name="external_url"]');c.focus(a),r.focus(a),t(c),s.change(function(){switch(e(this).val()){case"contacts":i.removeClass("hidden"),o.addClass("hidden"),t.update(c),c.focus();break;case"external":o.removeClass("hidden"),i.addClass("hidden"),r.focus();break;default:o.addClass("hidden"),i.addClass("hidden")}}),n.find("#job-company").select2({ajax:{url:"/company/search",cache:!0,processResults:function(e){return{results:e.items}}},minimumInputLength:1}),n.find("#job-position").select2({ajax:{url:"/position/search",cache:!0,processResults:function(e){return e=e.map(function(e){return e.text=e.title,delete e.title,e}),{results:e}}},minimumInputLength:3}),n.find("textarea#tags").tagEditor(),n.find("textarea#cities").tagEditor({maxTags:5,forceLowercase:!1,autocomplete:{source:function(t,a){e.ajax({type:"POST",dataType:"json",url:"/autocomplete/city",data:{filter:t.term},success:a})}}})});