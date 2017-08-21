define(['jquery'], function ($) {

  $.fn.sectorDiagram = function () {

    var data = [];
    $(this).find('.legend-item').each(function () {
      var $item = $(this);
      data.push({
        color: $item.data('color'),
        percent: $item.data('percent')
      });
    });

    var canvas = $(this).find('canvas')[0];
    var lineWidth = canvas.dataset.lineWidth || 1;
    var context = canvas.getContext('2d');
    var x = canvas.width / 2;
    var y = canvas.height / 2;
    var radius = canvas.width / 2 - Math.ceil(lineWidth / 2);
    var quart = Math.PI / 2;
    var circ = Math.PI * 2;

    context.lineWidth = lineWidth;

    //рисуем сектора
    var current = 0;
    var end = 0;
    for (var i = 0, item; item = data[i]; ++i) {
      context.strokeStyle = item.color;
      current += item.percent / 100;
      context.beginPath();
      var start = end;
      end = circ * current;
      context.arc(x, y, radius, start - quart, end - quart, false);
      context.stroke();
    }
  };

});