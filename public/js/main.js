define(["jquery","String"],function(e){requirejs(["header"]),e(document).ready(function(){}),function(){function n(){var n=e(this),a=n.siblings(".maxlength-counter"),t=n.attr("maxlength"),r=n.val().length;a.text(r+" из "+t+" символов")}e("textarea[maxlength]").wrap('<div class="maxlength-wrap"></div>').before('<span class="minor gray maxlength-counter"></span>').bind("updateCounter",n).each(n).keypress(n).keyup(n),requirejs(["autosize"],function(n){n(e("textarea.autosize"))})}(),e(".open-signup-modal").length&&requirejs(["modal/signup"]),e(".open-signin-modal").length&&requirejs(["modal/signin"]),requirejs(["modal/alert"])});