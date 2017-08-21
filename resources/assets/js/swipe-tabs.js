define(['jquery', 'browser'], function ($, browser) {

  var tabs = $(".profile-tabs")
    , tabsInner = tabs.find(".profile-tabs-inner")
    , item = tabs.find('.profile-tabs-item');

  item.hover(function () {
    $(this).addClass('hover');
  }, function () {
    $(this).removeClass('hover');
  });

  //swipe tabs
  if (browser.mobile) require(['jquery-touchSwipe'], function () {

    var speed = 500, currDistance = 0;

    tabsInner.swipe({
      threshold: 0,
      swipeStatus: function (event, phase, direction, distance, duration, fingers, fingerData, currentDirection) {

        if (phase == 'start') {
          //save current position
          currDistance = Math.abs(parseInt(tabsInner.css('transform').split(',')[4]) || 0);
        } else if (phase == "move" && (direction == "left" || direction == "right")) {
          duration = 0;
          if (direction == "left") {
            scrollTabs(currDistance + distance, duration);
          } else if (direction == "right") {
            scrollTabs(currDistance - distance, duration);
          }

        } else if (phase == "cancel") {
          scrollTabs(0, speed);
          // tabsInner.data("stopclick", false);
        } else if (phase == "end") {

          var innerWidth = tabsInner.outerWidth();
          var tabsWidth = tabs.width();
          var offsetLeft = tabsInner.offset().left;
          var minOffsetLeft = tabsWidth - innerWidth;

          if (innerWidth <= tabsWidth) {
            scrollTabs(0, speed);
          } else if ((direction == "right") && (offsetLeft > 0)) {
            scrollTabs(0, speed);
          } else if ((direction == "left") && (offsetLeft < minOffsetLeft)) {
            scrollTabs(-minOffsetLeft, speed);
          }

        }

      }
    });

    function scrollTabs(distance, duration) {
      tabsInner.css("transition-duration", (duration / 1000).toFixed(1) + "s");

      //inverse the number we set in the css
      var value = (distance < 0 ? "" : "-") + Math.abs(distance).toString();
      tabsInner.css("transform", "translate(" + value + "px,0)");
    }

    $(window).resize(function () {

      var tabsWidth = tabs.width()
        , innerWidth = tabsInner.outerWidth();

      if (innerWidth > tabsWidth) {
        tabsInner.swipe("enable");
        scrollToItem(item.filter('.active'));
      } else {
        tabsInner.swipe("disable");
        scrollTabs(0, 0);
      }

    }).trigger('resize');

    function scrollToItem(item) {

      var tabsWidth = tabs.width()
        , innerWidth = tabsInner.outerWidth()
        , minOffsetLeft = Math.abs(tabsWidth - innerWidth);


      var distance = item.offset().left - tabsWidth / 2 + item.outerWidth() / 2;

      //корректировка на отступ с права
      if (distance > minOffsetLeft) {
        distance = minOffsetLeft;
      }

      //корректировка на оступ слева
      else if (distance < 0) {
        distance = 0;
      }

      scrollTabs(distance, 0);
    }

  });

});