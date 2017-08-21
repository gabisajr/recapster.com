define(['jquery', 'jquery.ui.widget'], function ($) {

  var body = $('body');

  $.widget("custom.mobileView", {

    // default options
    options: {
      beforeOpen: null,
      afterOpen: null,
      beforeClose: null,
      afterClose: null
    },

    _create: function () {
      this.element.appendTo(body);

      this.cancel = this.element.find('.cancel');
      this._on(this.cancel, {click: "close"});
    },

    open: function () {
      this._trigger("beforeOpen");

      body.css({overflow: 'hidden', position: 'fixed'});
      this.element.show();

      this._trigger("afterOpen");
    },

    close: function () {
      this._trigger("beforeClose");

      this.element.hide();
      body.css({overflow: 'auto', position: 'static'});

      this._trigger("afterClose");
    }

  });


  $('.mobile-view').mobileView();

});