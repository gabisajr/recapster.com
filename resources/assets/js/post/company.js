define(['jquery', 'post'], function ($, post) {
  $.fn.extend({
    companyPost: function () {

      if (this.length) post.mobileGo(this);

      return this;
    }
  });
});