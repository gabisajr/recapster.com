define(["jquery","powerTip"],function(e){return function(t){t.each(function(){var t=e(this),n=e(this).data().powertipPlacement,a=t.data("powertipMouseon"),o={smartPlacement:!0,intentPollInterval:0,closeDelay:0,fadeInTime:0,fadeOutTime:0};n&&(o.placement=n),a&&(o.mouseOnToPopup=!0),t.powerTip(o)})}});