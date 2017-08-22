define(['jquery', 'jquery-ui', 'highlight'], function ($) {

  $.fn.extend({
    autocompletePosition: function () {
      this.autocomplete({
        minLength: 1,
        source: function (request, response) {
          $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '/autocomplete/positions',
            data: {filter: request.term},
            success: response
          });
        }
      });

      this.autocomplete("instance")._renderItem = function (ul, position) {
        return $('<li class="small">').append(position.label).highlight(this.term).appendTo(ul);
      };

      return this;
    },

    autocompleteCompany: function (params) {
      params = params || {};
      this.autocomplete({
        minLength: 2,
        source: function (request, response) {
          $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '/autocomplete/company',
            data: {filter: request.term, use_link: params.use_link, admin_link: params.admin_link},
            success: response
          });
        }
      });

      this.autocomplete("instance")._renderItem = function (ul, item) {
        var li = $(item.html);
        li.find('.title').highlight(this.term);
        return li.appendTo(ul);
      };

      return this;
    },

    autocompleteCity: function () {
      this.autocomplete({
        minLength: 2,
        source: function (request, response) {
          $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '/autocomplete/city',
            data: {filter: request.term},
            success: response
          });
        }
      });

      this.autocomplete("instance")._renderItem = function (ul, item) {
        var li = $(item.html);
        li.find('.city-title').highlight(this.term);
        return li.appendTo(ul);
      };

      return this;
    },

    autocompleteUser: function (params) {
      params = params || {};
      this.autocomplete({
        minLength: 2,
        source: function (request, response) {
          $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '/autocomplete/user',
            data: {filter: request.term, use_link: params.use_link, admin_link: params.admin_link},
            success: response
          });
        }
      });

      this.autocomplete("instance")._renderItem = function (ul, item) {
        var li = $(item.html);
        li.find('.title').highlight(this.term);
        return li.appendTo(ul);
      };

      return this;
    }

  });

});