require(['/js/common.js'], function () {

  require(['modal/job-apply']);

  require(['jquery', 'diagram/circle'], function ($) {
    $('.circle-diagram').each(function () {
      $(this).circleDiagram();
    });
  });

  require(['jquery', 'diagram/sector'], function ($) {
    $('.sector-diagram').each(function () {
      $(this).sectorDiagram();
    });
  });

});