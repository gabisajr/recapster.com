define(["jquery","i18n","/js/admin/entity-list.js"],function(t,e){t("#types-list").entityList({removeUrl:"/admin/AdditionalPaymentsType/remove",sortUrl:"/admin/AdditionalPaymentsType/sort",removeQuestion:e("Вы действительно хотите удалить вид выплат :title с сайта",{":title":'<strong class="text-nowrap">&laquo;{title}&raquo;</strong>'})})});