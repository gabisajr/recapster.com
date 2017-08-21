define(['jquery', 'post', 'bootstrap-star-rating'], function ($, post) {

  $.fn.extend({
    reviewPost: function (params) {
      params = params || {};

      if (this.length) post.mobileGo(this);

      return this.each(function () {
        var post = $(this)
          , id = post.data('id');


        post.find('.review-rating').rating(); //звездочки отзыва

        post

        //редактировать
          .on('click', '.edit-review', function (e) {
            e.preventDefault();
            require(['modal/edit-review'], function (edit) { edit(id) });
          })

          //удалить
          .on('click', '.delete-review', function (e) {
            e.preventDefault();
            post.closest('.post-list-col').remove();
            post.remove();
            $.post('/review/delete/' + id);
            params.afterDelete && params.afterDelete();
          })

          //пожаловаться
          .on('click', '.claim-review', function (e) {
            e.preventDefault();
            if ($('body').data('logged')) {
              require(['modal/complain'], function (open) { open('review', id) });
            } else {
              require(['modal/signin'], function (signin) { signin() });
            }
          });
      });
    }
  });

});