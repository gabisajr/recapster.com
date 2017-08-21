define(['jquery'], function ($) {

  var list = $('.share-list')
    , item = list.find('.share-list-item')
    , vk = item.filter('.vk')
    , facebook = item.filter('.facebook')
    , twitter = item.filter('.twitter')
    , print = item.filter('.print');

  if (!list.is(':visible')) return;

  var data = list.data();
  data.title = data.title = document.title;
  data.url = data.url || document.location.href;
  data.image = data.image || $('link[rel="image_src"]').attr('href');
  data.description = data.description || $('meta[name="description"]').attr('content');

  //ВКонтакте
  (function () {
    if (!vk.length) return;
    require(['VK_share'], function (VK) {
      vk.replaceWith($(VK.Share.button({
        url: data.url,
        title: data.title,
        description: data.description,
        image: data.image,
        noparse: true
      }, {
        type: 'custom',
        text: vk.text()
      })).attr('class', vk.attr('class')));
    });
  })();


  //Facebook
  (function () {
    if (!facebook.length) return;
    require(['facebook'], function (FB) {
      facebook.click(function (e) {
        e.preventDefault();
        FB.ui({method: 'share', href: data.url}, function (response) { });
      });
    });
  })();

  //Twitter
  (function () {
    if (!twitter.length) return;
    require(['social/twitter-popup']);
  })();

  //Print
  (function () {
    if (!print.length) return;
    print.click(function (e) {
      e.preventDefault();
      window.print();
    });
  })();

});