define(['jquery', 'getImgRealSize', 'keyCodes', 'jquery.easing', 'jquery.transform2d'], function ($, getImgRealSize, keyCodes) {

  function MediaViewer() {

    var mediaViewer = this;
    var body = $('body');


    var zoomTime, index, realWidth, realHeight, aspectRatio;

    //dom elements
    var viewer, media, wrapper, viewerImg, fromElement, prev, next;

    var gallery = [], params = {};

    //init
    $.ajax({
      url: '/tmpl/modal/media-viewer',
      success: function (html) {

        viewer = $(html);
        media = viewer.find('.media');
        wrapper = viewer.find('.wrapper');
        viewerImg = viewer.find('img.media-viewer-img').hide();
        prev = viewer.find('.btn-media-prev').hide();
        next = viewer.find('.btn-media-next').hide();

        viewerImg.click(function (e) {
          e.stopPropagation();
          this.next();
        }.bind(this));

        prev.click(function (e) {
          e.stopPropagation();
          this.prev();
        }.bind(this));

        next.click(function (e) {
          e.stopPropagation();
          this.next();
        }.bind(this));

        viewer.click(function () {
          this.close();
        }.bind(this));

      }.bind(this)
    });

    this.open = function (from) {
      fromElement = from;

      if (arguments.length <= 2) {
        gallery = [];
        params = arguments[1] || {};
      } else if (arguments.length == 3) {
        gallery = arguments[1] || [];
        params = arguments[2] || {};
      }


      body.css('overflow', 'hidden');
      viewer.prependTo(body).stop().show();

      var src = null;
      if (gallery.length) {
        index = params.index || 0;
        src = gallery[index].href;
      } else if (from.src) {
        src = from.src;
      }

      zoomTime = params.duration || 300;

      loadImg(src, function () {
        zoomIn();
      }.bind(this));

      //load arrows
      if (gallery.length) {
        prev.show();
        next.show();
        checkArrow();
      } else {
        prev.hide();
        next.hide();
      }

      $(document).on('keydown', keydown);
      $(window).on('resize', resize);
    };

    this.close = function () {
      zoomOut(function () {

        viewer.fadeOut(300, function () {
          viewer.detach();
          wrapper.css('transform', 'none');
          viewerImg.hide();
        });

        body.css('overflow', 'auto');

      }.bind(this));


      $(document).off('keydown', keydown);
      $(window).off('resize', resize);
    };

    this.prev = function () {
      if (index > 0) {
        index--;
        this.goto();
      }
    };

    this.next = function () {
      if (index < gallery.length - 1) {
        index++;
        this.goto();
      }
    };

    this.goto = function () {
      loadImg(gallery[index].href);
      checkArrow();
    };


    function zoomIn() {

      var rectStart = fromElement.getBoundingClientRect()
        , rectEnd = wrapper[0].getBoundingClientRect()
        , centerEnd = getRectCenter(rectEnd)
        , centerStart = getRectCenter(rectStart)
        , translateX = (centerStart.x - centerEnd.x) + 'px'
        , translateY = (centerStart.y - centerEnd.y) + 'px'
        , scale = rectStart.width / rectEnd.width
        , startAspectRatio = rectStart.width / rectStart.height;

      wrapper.css({
        transform: 'translateX(' + translateX + ') translateY(' + translateY + ') scale(' + scale + ')',
        borderRadius: params.avatar ? '50%' : '0%',
        height: rectEnd.width / startAspectRatio
      });

      viewerImg.show();

      wrapper.animate({
        transform: 'translateX(0px) translateY(0px) scale(1)',
        borderRadius: '0%',
        height: resize(null, true).height
      }, zoomTime, 'easeOutSine');
    }

    function zoomOut(callback) {

      if (gallery.length) {
        fromElement = params.container.find('.bubble-image[data-index="' + index + '"]')[0];
      }

      if (!fromElement || !elementInViewport(fromElement)) return callback && callback();

      var rectStart = fromElement.getBoundingClientRect()
        , rectEnd = wrapper[0].getBoundingClientRect()
        , centerEnd = getRectCenter(rectEnd)
        , centerStart = getRectCenter(rectStart)
        , translateX = (centerStart.x - centerEnd.x) + 'px'
        , translateY = (centerStart.y - centerEnd.y) + 'px'
        , scale = rectStart.width / rectEnd.width
        , startAspectRatio = rectStart.width / rectStart.height;

      wrapper.animate({
        transform: 'translateX(' + translateX + ') translateY(' + translateY + ') scale(' + scale + ')',
        borderRadius: params.avatar ? '50%' : '0%',
        height: rectEnd.width / startAspectRatio
      }, zoomTime, 'easeOutSine', callback);
    }

    function keydown(e) {
      switch (e.keyCode) {
        case keyCodes.RIGHT:
          mediaViewer.next();
          break;
        case keyCodes.LEFT:
          mediaViewer.prev();
          break;
        case keyCodes.ESC:
          mediaViewer.close();
          break;
      }
    }

    function checkArrow() {
      if (index > 0) {
        prev.removeClass('disabled-btn');
      } else {
        prev.addClass('disabled-btn');
      }

      if (index < gallery.length - 1) {
        next.removeClass('disabled-btn');
      } else {
        next.addClass('disabled-btn');
      }
    }

    function loadImg(src, callback) {
      viewerImg.attr('src', src);
      getImgRealSize(src, function (size) {
        realWidth = size.width;
        realHeight = size.height;
        aspectRatio = realWidth / realHeight;
        resize();
        callback && callback();
      });
    }

    function resize(e, calc) {

      var mediaHeight = media.height();
      var mediaWidth = media.width();

      if (mediaHeight < mediaWidth) {
        var base = Math.min(mediaHeight, realHeight);
        var css = {
          height: base,
          width: base * aspectRatio
        };
      } else {
        base = Math.min(mediaWidth, realWidth);
        css = {
          height: base * aspectRatio,
          width: base
        };
      }

      if (calc) return css;
      wrapper.css(css);
    }

    function getRectCenter(rect) {
      return {
        x: rect.left + rect.width / 2,
        y: rect.top + rect.height / 2
      }
    }

    function elementInViewport(el) {
      var top = el.offsetTop;
      var left = el.offsetLeft;
      var width = el.offsetWidth;
      var height = el.offsetHeight;

      while(el.offsetParent) {
        el = el.offsetParent;
        top += el.offsetTop;
        left += el.offsetLeft;
      }

      return (
        top < (window.pageYOffset + window.innerHeight) &&
        left < (window.pageXOffset + window.innerWidth) &&
        (top + height) > window.pageYOffset &&
        (left + width) > window.pageXOffset
      );
    }

  }

  return new MediaViewer();

});