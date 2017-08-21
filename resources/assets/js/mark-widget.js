define(['jquery'], function ($) {

  $.fn.extend({
    markWidget: function () {

      this.find('.mark-widget-marks .mark')
        .hover(function () {

          var $mark = $(this)
            , $widget = $mark.closest('.mark-widget')
            , $caption = $widget.find('.mark-widget-caption');

          $widget
            .find('.mark-widget-marks .mark')
            .removeClass('hover active')
            .slice(0, $mark.index() + 1)
            .addClass('hover');

          //показываем надпись
          $caption.text($mark.data('caption'));

        })
        .click(function () {
          var $mark = $(this)
            , $widget = $mark.closest('.mark-widget')
            , index = $mark.index();

          $widget.find('.mark-widget-marks .mark')
            .removeClass('active curr-active')
            .slice(0, index + 1)
            .addClass('active curr-active');

          $widget.find('.mark-widget-input').val($mark.data('rate'));
          $widget.removeClass('mark-widget-error');
        });

      this.find('.mark-widget-marks').mouseleave(function () {
        var $widget = $(this).closest('.mark-widget')
          , $caption = $widget.find('.mark-widget-caption');

        $widget
          .find('.mark-widget-marks .mark')
          .removeClass('hover')
          .filter('.curr-active')
          .addClass('active');

        var $currActive = $widget.find('.mark-widget-marks .mark.curr-active');
        if ($currActive.length) {
          $caption.text($currActive.eq(-1).data('caption'));
        } else {
          $caption.text($caption.data('start-caption') || '');
        }

      });

      return this;
    }
  });
});