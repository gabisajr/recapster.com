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
        let companies = graphql('/graphql')(`query { companies (search: "${request.term}") {id, title} }`);
        companies().then(data => {
          let companies = data.companies.map(function (company) {
            company.label = company.title;
            delete company.title;
            return company;
          });
          return response(companies);
        });
      }
    });

    this.autocomplete("instance")._renderItem = function (ul, company) {
      let $li = $('<li><div>' + company.label + '</div></li>');
      $li.highlight(this.term);
      return $li.appendTo(ul);

      //todo autocomplete companies with logo
      // let li = $(company.html);
      // li.find('.title').highlight(this.term);
      // return li.appendTo(ul);
    };

    return this;
  },

  autocompleteCity: function () {
    this.autocomplete({
      minLength: 2,
      source: function (request, response) {
        let cities = graphql('/graphql')(`query { cities (search: "${request.term}") {id, title} }`);
        cities().then(data => {
          let cities = data.cities.map(function (city) {
            city.label = city.title;
            delete city.title;
            return city;
          });
          return response(cities);
        });
      }
    });

    this.autocomplete("instance")._renderItem = function (ul, city) {
      let $li = $('<li><div>' + city.label + '</div></li>');
      $li.highlight(this.term);
      return $li.appendTo(ul);

      //todo autocomplete cities with placemark
      // let li = $(city.html);
      // li.find('.city-title').highlight(this.term);
      // return li.appendTo(ul);
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