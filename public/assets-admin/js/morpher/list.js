define(["jquery","i18n","/js/admin/entity-list.js","highlight"],function(e,t){var i=e("#morphers-list");i.entityList({removeUrl:"/admin/morpher/remove",sortable:!1,removeQuestion:t("Вы действительно хотите удалить морфему :title из словаря",{":title":'<strong class="text-nowrap">&laquo;{title}&raquo;</strong>'})});var r=e("#search-morphers-form").find('input[name="qp"]').val();r&&i.find(".search-cell").highlight(r)});