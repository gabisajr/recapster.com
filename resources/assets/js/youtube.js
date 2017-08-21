define(['jquery'], function ($) {

  function youtubeParser(url) {
    var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??(t=[0-9]+&)?v?=?([^#&\?]*).*/;
    var match = url.match(regExp);
    if (match && match[8].length == 11) {
      return match[8];
    }
    return null;
  }

  function youtubeVideoInfo(youtubeID, callback) {
    $.ajax({
      url: 'http://query.yahooapis.com/v1/public/yql',
      jsonp: "callback",
      dataType: 'jsonp',
      data: {
        q: "select * from json where url ='http://www.youtube.com/oembed?url=http://www.youtube.com/watch?v=" + youtubeID + "&format=json'",
        format: 'json'
      },
      success: function (response) {
        if (!response.error && response.query.count) {
          var info = response.query['results'].json
            , width = parseInt(info.width)
            , height = parseInt(info.height);

          info.thumbnail_url = 'http://img.youtube.com/vi/' + youtubeID + '/maxresdefault.jpg';
          info.aspectRatio = width / height;
          callback && callback(info);
        }
      }
    });
  }

  return {
    parser: youtubeParser,
    info: youtubeVideoInfo
  }

});