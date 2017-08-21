require(['/js/common.js'], function () {

  require(['jquery', 'async', 'autosize'], function ($, async, autosize) {

    var $form = $('form#add-interview-form');

    //<editor-fold desc="Наведение на оценку лайком (общее впечатление и получил ли работу)">
    $form.find('.likes-control').each(function () {

      var control = $(this)
        , wrapper = control.closest('.likes-control-w')
        , title = wrapper.find('.likes-control-title')
        , input = control.find('input[type="radio"]');

      control.find('li.likes-control-item').mouseenter(function () {
        title.text($(this).find('label').data('title'))
      });

      control.mouseleave(function () {
        title.text(title.data('title') || '');
      });

      input.change(function () {
        var text = control.find('input[type="radio"]:checked')
          .closest('li.likes-control-item').find('label').data('title');
        title.text(text).data('title', text);
      });
    });
    //</editor-fold>

    //<editor-fold desc="Добавление вопросов">
    var $questions = $form.find('.interview-questions'), questionHtml;
    $form.find('button[name="add-question"]').click(function () {

      var number = $questions.find('.interview-question-fields:last-child').find('.number').data('number');
      if (!number) number = 0;
      number += 1;

      async.waterfall([

        //get html
        function (callback) {
          if (questionHtml) return callback(null, questionHtml);

          $.ajax({
            url: '/tmpl/partials/interview-question-fields',
            data: {number: number},
            success: function (html) {
              questionHtml = html;
              callback(null, questionHtml);
            }
          });
        },

        function (html, callback) {
          var $question = $(html);
          $question.find('.number').data('number', number).text('Вопрос ' + number);
          autosize($question.find('textarea.autosize'));
          callback(null, $question);
        }

      ], function (err, $question) {
        if (err) return window.alert(err);
        $questions.append($question);
        $question.find('textarea.questions-text').focus();
      });

    });
    //</editor-fold>

    //<editor-fold desc="Удаление вопросов">
    $questions.on('click', '.delete', function (e) {
      e.preventDefault();
      $(this).closest('.question').remove();
    });
    //</editor-fold>

    //<editor-fold desc="Выбора источника собеседования">
    $form.find('select[name="source"]').change(function () {
      var specifiable = $(this).find('option:selected').data('specifiable')
        , $source_specify = $form.find('input[name="source_specify"]');
      if (specifiable) {
        $source_specify.removeClass('hidden').focus();
      } else {
        $source_specify.addClass('hidden');
      }
    });
    //</editor-fold>

    //<editor-fold desc="Проделанные шаги - другое">
    $form.find('input#interview-step-other').change(function () {
      var $step_other = $form.find('input[name="step_other"]');
      if ($(this).is(':checked')) {
        $step_other.removeClass('hidden').focus()
      } else {
        $step_other.addClass('hidden')
      }
    });
    //</editor-fold>

  });

});