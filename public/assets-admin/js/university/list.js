define(["jquery","i18n","/js/admin/entity-list.js"],function(t,e){t("#universities-list").entityList({removeUrl:"/admin/university/remove",sortable:!1,removeQuestion:e("Вы действительно хотите удалить учебное заведение :title с сайта",{":title":'<strong class="text-nowrap">&laquo;{title}&raquo;</strong>'})})});