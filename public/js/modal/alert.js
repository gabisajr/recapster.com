define(["jquery"],function(e){function n(e){(e=e||{}).level&&s.attr("class","alert alert-"+e.level),e.message&&s.text(e.message),s.show();var n=e.closeDelay||r;setTimeout(function(){s.addClass("-hide"),setTimeout(function(){s.hide().removeClass("-hide")},300)},n)}var s=e("#alert-message"),r=2e3;return e(document).ready(function(){s.data("show")&&n()}),{success:function(e){return n({level:"success",message:e})},error:function(e){return n({level:"error",message:e})},warning:function(e){return n({level:"warning",message:e})},info:function(e){return n({level:"info",message:e})}}});