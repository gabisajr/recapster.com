define(["jquery","jquery-ui","highlight"],function(t){t.fn.extend({autocompletePosition:function(){return this.autocomplete({minLength:1,source:function(e,n){t.ajax({type:"POST",dataType:"json",url:"/autocomplete/position",data:{filter:e.term},success:n})}}),this.autocomplete("instance")._renderItem=function(e,n){return t('<li class="small">').append(n.label).highlight(this.term).appendTo(e)},this},autocompleteCompany:function(e){return e=e||{},this.autocomplete({minLength:2,source:function(n,i){t.ajax({type:"POST",dataType:"json",url:"/autocomplete/company",data:{filter:n.term,use_link:e.use_link,admin_link:e.admin_link},success:i})}}),this.autocomplete("instance")._renderItem=function(e,n){var i=t(n.html);return i.find(".title").highlight(this.term),i.appendTo(e)},this},autocompleteCity:function(){return this.autocomplete({minLength:2,source:function(e,n){t.ajax({type:"POST",dataType:"json",url:"/autocomplete/city",data:{filter:e.term},success:n})}}),this.autocomplete("instance")._renderItem=function(e,n){var i=t(n.html);return i.find(".city-title").highlight(this.term),i.appendTo(e)},this},autocompleteUser:function(e){return e=e||{},this.autocomplete({minLength:2,source:function(n,i){t.ajax({type:"POST",dataType:"json",url:"/autocomplete/user",data:{filter:n.term,use_link:e.use_link,admin_link:e.admin_link},success:i})}}),this.autocomplete("instance")._renderItem=function(e,n){var i=t(n.html);return i.find(".title").highlight(this.term),i.appendTo(e)},this}})});