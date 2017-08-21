define(['facebook_sdk'], function (FB) {
  var appId = document.querySelector('meta[property="fb:app_id"]').content;
  window.fbAsyncInit = function () {
    FB.init({appId: appId, xfbml: true, version: 'v2.5' });
  };
  return FB;
});