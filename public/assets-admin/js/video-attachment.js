define(["jquery","youtube"],function(e,n){e.fn.videoAttachment=function(){var i=e(this),t=i.parent(".form-group"),o=i.closest("form"),a=t.find("#preview-container"),d=e('<input name="video[title]" type="hidden" />').appendTo(o),l=e('<input name="video[vendor]" type="hidden" />').appendTo(o),r=e('<input name="video[vendor_id]" type="hidden" />').appendTo(o),u=e('<input name="video[thumbnail]" type="hidden">').appendTo(o);i.on("paste",function(){setTimeout(function(){var e=i.val(),t=n.parser(e);if(t){r.val(t);var o="http://www.youtube.com/embed/"+t+"?&autohide=1&showinfo=0&iv_load_policy=3&rel=0";a.html('<iframe src="'+o+'" width="560" height="315" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>'),n.info(t,function(e){d.val(e.title),l.val("youtube"),u.val(e.thumbnail_url)})}},100)})}});