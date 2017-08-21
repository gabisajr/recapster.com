define(['jquery', 'powerTip'], function ($) {

  return function (el) {

    el.each(function () {
      var _this = $(this)
        , data = $(this).data()
        , placement = data['powertipPlacement']
        , mouseon = _this.data('powertipMouseon');


      var params = {smartPlacement: true, intentPollInterval: 0, closeDelay: 0, fadeInTime: 0, fadeOutTime: 0};
      if (placement) params.placement = placement;
      if (mouseon) params.mouseOnToPopup = true;

      _this.powerTip(params);
    });

    //todo remove
    // $('.tooltip-confirmed-company-big').powerTip({placement: 'se-alt', smartPlacement: true, mouseOnToPopup: true});
    // $('.tooltip-anonymous-protection').powerTip({placement: 'nw'});
  };

});