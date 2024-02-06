/*=========================================================================================
    File Name: app-user-list.js
    Description: User List page
    --------------------------------------------------------------------------------------
    Item Name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent

==========================================================================================*/
$(function () {
('use strict');







var dtUserTable = $('.commande-deja-livre')
if (dtUserTable.length) {

    dtUserTable.DataTable({
        order: [[1, 'desc']],
        language: {
            sLengthMenu: 'Afficher _MENU_',
            search: 'Rechercher',
            searchPlaceholder: 'Rechercher..',
            paginate: {
                previous: '&nbsp;',
                next: '&nbsp;'
            }
        },

    });

}







});
