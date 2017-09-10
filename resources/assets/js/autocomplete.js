import $ from 'jquery';
import 'jquery-ui/ui/widgets/autocomplete';
import 'jquery-highlight';

$.fn.extend({
  autocompletePosition: function () {
    this.autocomplete({
      minLength: 1,
      source: function (request, response) {
        let positions = graphql('/graphql')(`query { positions (search: "${request.term}") {id, title} }`);
        positions().then(data => {
          let positions = data.positions.map(function (position) {
            position.label = position.title;
            delete position.title;
            return position;
          });
          return response(positions);
        });
      }
    });

    this.autocomplete("instance")._renderItem = function (ul, position) {
      let $li = $('<li><div>' + position.label + '</div></li>');
      $li.highlight(this.term);
      return $li.appendTo(ul);
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
      let li = $(item.html);
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
      let li = $(item.html);
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
      let li = $(item.html);
      li.find('.title').highlight(this.term);
      return li.appendTo(ul);
    };

    return this;
  }

});