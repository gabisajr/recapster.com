define(["jquery"],function(e){e.fn.extend({imagePost:function(){return this.each(function(){var t,i=e(this),n=i.data("id"),c=i.find(".images");!function(){var t=c.find(".fancy"),i=[];t.each(function(){i.push({href:"/image/modal/"+e(this).data("id")})}),i.length&&require(["modal/image"],function(n){t.click(function(t){t.preventDefault(),n(i,{index:e(this).data("index")})})})}(),i.on("click",".edit-activity",function(a){a.preventDefault();var o=i.find(".post-desc");e.ajax({url:"/activity/editForm/"+n,success:function(n){n=e(n),t=n.find("textarea"),o.hide(),n.insertBefore(c),require(["caretEnd","autosize"],function(e,i){t.focus(e).focus(),i(t)}),n.submit(function(t){t.preventDefault(),e.ajax({url:n.attr("action"),method:n.attr("method"),data:n.serialize(),success:function(t){i.replaceWith(e(t).imagePost())}})}).find(".cancel").click(function(e){e.preventDefault(),n.remove(),o.show()}),require(["keyCodes"],function(e){t.keydown(function(t){t.keyCode==e.ESC&&n.find(".cancel").click()})})}})}).on("click",".delete-activity",function(t){t.preventDefault(),i.closest(".post-list-col").remove(),i.remove(),e.post("/activity/delete/"+n)}).on("click",".complain-activity",function(t){t.preventDefault(),e("body").data("logged")?require(["modal/complain"],function(e){e("image_activity",n)}):require(["modal/signin"],function(e){e()})})})}})});