define(['jquery', 'i18n', 'fancytree'], function ($, __) {

  //дерево категорий
  var $treeData = $('#post-categories-tree-data');
  if (!$treeData.length) return;

  var treeData = JSON.parse($treeData.text().trim());
  var $treeTable = $('#post-categories-tree');

  $treeTable.fancytree({
    source: treeData,
    extensions: ["table"],
    table: {
      indentation: 20,
      nodeColumnIdx: 0
    },
    renderColumns: function (event, data) {
      var node = data.node
        , $tdList = $(node.tr).find(">td");


      if (node.folder) {

        //категория
        var catId = node.data.id;

        //количество постов
        node.data.posts_count = node.data.posts_count || 0;
        if (node.data.posts_count) {
          $tdList.eq(1).html('<small><samp>' + node.data.posts_count + ' posts</samp></small>');
        }

        $tdList.eq(4).html('<a class="text-muted" href="/admin/post/category/' + catId + '"><i class="fa fa-fw fa-gear"></i></a>' +
          '<button type="button" style="margin:0 20px" class="btn btn-xs btn-default" name="remove" title="' + __('Удалить') + '">' +
          '<i class="fa fa-trash"></i></button>' +
          '<small>' +
          '<a href="/admin/post/item?category=' + catId + '" style="margin-right:20px;">' + __('Добавить пост') + '</a>' +
          '<a href="/admin/post/category?parent=' + catId + '" style="margin-right:20px;">' + __('Добавить подкатегорию') + '</a>' +
          '<a href="/admin/post/list?category=' + catId + '">' + __('Список постов') + '</a>' +
          '</small>');
      } else {

        //helped count
        var helpful_value = node.data['helpful_value'] || 0;
        if (helpful_value != 0) {
          var symbol = helpful_value > 0 ? '+' : '';
          var $helpful = $('<small><strong><samp>' + symbol + helpful_value + '</samp></strong></small>');
          $helpful.addClass(helpful_value < 0 ? 'text-danger' : 'text-success');
          $tdList.eq(2).append($helpful);
        }


        //дата изменения
        $tdList.eq(3).html('<small><samp>' + node.data['updated'] + '</samp></small>');

        //пост
        $tdList.eq(4).html('<a href="/admin/post/item/' + node.data.id + '" class="text-muted"><i class="fa fa-fw fa-pencil"></i></a>' +
          '<button type="button" style="margin:0 20px" class="btn btn-xs btn-default" name="remove" title="' + __('Удалить') + '">' +
          '<i class="fa fa-trash"></i></button>' +
          '<small><a href="' + node.data.url + '" target="_blank">' + __('Открыть на сайте') + '</a></small>');

      }


    }
  });

  $treeTable.delegate('button[name=remove]', 'click', function (e) {

    e.stopPropagation();  // prevent fancytree activate for this row

    var node = $.ui.fancytree.getNode(e)
      , $btn = $(e.target)
      , title = node.title;


    if (node.folder) {

      //удаление категории
      var removeQuestion = __('Вы действительно хотите удалить категорию :title с сайта? При удалении категории также будут удалены все вложенные подкатегории и посты', {
        ':title': '<strong>' + title + '</strong>'
      });
      window.confirmModal(removeQuestion, function () {
        $.ajax({
          url: '/admin/post/remove_category',
          type: 'post',
          data: {id: node.data.id},
          beforeSend: function () {
            $btn.prop('disabled', true);
          },
          success: function () {
            window.alertMessage(__('Категория удалена'), 'success');

            //remove node childs and node
            while (node.hasChildren()) {
              node.getFirstChild().remove();
            }
            node.remove();
          },
          error: function (jqXHR) {
            var message = jqXHR.status == 404 ? 'Error 404: URL not found' : jqXHR.responseText;
            window.alertMessage(message, 'error');
          }
        });
      });

    } else {

      //удаление поста
      removeQuestion = __('Вы действительно хотите удалить пост :title с сайта?', {
        ':title': '<strong>' + title + '</strong>'
      });
      window.confirmModal(removeQuestion, function () {
        $.ajax({
          url: '/admin/post/remove',
          type: 'post',
          data: {id: node.data.id},
          beforeSend: function () {
            $btn.prop('disabled', true);
          },
          success: function () {
            window.alertMessage(__('Пост удален'), 'success');
            node.remove();
          },
          error: function (jqXHR) {
            var message = jqXHR.status == 404 ? 'Error 404: URL not found' : jqXHR.responseText;
            window.alertMessage(message, 'error');
          }
        });
      });
    }

  });

});