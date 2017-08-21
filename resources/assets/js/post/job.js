define(['jquery', 'i18n', 'modal/signin', 'modal/alert', 'post'], function ($, __, signin, alert, post) {

  $.fn.extend({
    jobPost: function () {

      if (this.length) post.mobileGo(this);

      return this.each(function () {
        var job = $(this)
          , id = job.data('id')
          , fave = job.find('input[name="fave"]')
          , faveCaption = job.find('.fave-caption');
        
        //Добавить в избранное
        fave.change(function () {
          $.post('/job/fave/' + id, function (res) {
            if (res.success) {
              fave.prop('checked', res.fave);
              faveCaption.text(res.fave ? __('Избранная вакансия') : __('Добавить в избранное'));
            } else {
              fave.prop('checked', false);
              res.code == 401 ? signin() : alert.error(__('Unknown error'));
            }
          });
        });


        //пожаловаться
        job.on('click', '.claim-job', function (e) {
          e.preventDefault();
          if ($('body').data('logged')) {
            require(['modal/complain'], function (open) { open('job', id) });
          } else {
            require(['modal/signin'], function (signin) { signin() });
          }
        });

      });

    }
  });


});