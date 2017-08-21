define(['jquery'], function ($) {

  $.fn.circleDiagram = function () {

    var canvas = $(this).find('canvas')[0]
      , lineWidth = canvas.dataset.lineWidth || 1
      , context = canvas.getContext('2d')
      , x = canvas.width / 2
      , y = canvas.height / 2
      , radius = canvas.width / 2 - Math.ceil(lineWidth / 2)
      , quart = Math.PI / 2
      , circ = Math.PI * 2;

    context.lineWidth = lineWidth;

    //рисуем фоновый круг
    context.strokeStyle = canvas.dataset['backColor'] || '#ffffff';
    context.beginPath();
    context.arc(x, y, radius, -quart, circ - quart, false);
    context.stroke();

    //дуга-наполнитель
    context.strokeStyle = canvas.dataset.stroke || '#000000';
    var percent = canvas.dataset['percent'] || 1;
    if (percent < 1) percent = 1;
    var current = percent / 100;
    context.beginPath();
    context.arc(x, y, radius, -quart, (circ * current) - quart, false);
    context.stroke();

  };

});