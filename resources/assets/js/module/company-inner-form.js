/**
 * фильтр по зарплатам (вакансиям) одной компании
 */
define(['jquery', 'getAbsoluteUrl'], function ($, getAbsoluteUrl) {

  var $form = $('form.company-inner-form');

  if (!$form.length) return;

  $form.submit(function (e) {
    e.preventDefault();

    var $form = $(this)
      , $p = $form.find('input[name="p"]'), p = $p.val()
      , $city = $form.find('select[name="city"]')
      , url = $form.attr('action');

    //get url pathname
    var a = document.createElement('a');
    a.href = url;
    url = a.pathname;

    //add position alias
    var $position_alias = $form.find('input[name="position_alias"]');
    var position_alias = $position_alias.val();
    var has_position = position_alias && $position_alias.data('for-title') === p;
    if (has_position) url += '/' + position_alias;

    //add city alias
    var city_alias = $city.val();
    if (city_alias) url += '/' + city_alias;

    if (!has_position && p) url += '?p=' + p;

    url += '#company-bottom';

    url = getAbsoluteUrl(url);

    window.location.href = url;

  });

});