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
$('#selectAll').change(function () {
    $('.select-commande').prop('checked', $(this).prop('checked'));
});

// Gestion de la sélection/désélection individuelle des cases à cocher
$('.select-commande').change(function () {
    if ($('.select-commande:checked').length === $('.select-commande').length) {
        $('#selectAll').prop('checked', true);
    } else {
        $('#selectAll').prop('checked', false);
    }
});
$('#filter_date').on('change',function(){
    var livreur = $('#livreur_id').val()
    var date = $(this).val();
    var nouvelleURL = "/voirCommande/" + livreur + "/" + date;
    window.location.href = nouvelleURL;
})
$('#annule').on('click', function () {
    var checkedCheckboxes = $('.select-commande:checked');

    if (checkedCheckboxes.length > 0) {
        var checkedIds = checkedCheckboxes.map(function () {
            return $(this).data('id');
        }).get();
        var remarque = $('#remarque_livre').val();
        $.ajax({
            type: "GET",
            url: "/changeStatusAnnuler",
            data: {
                id : checkedIds,
                remarque : remarque
            },
            dataType: "json",
            success: function (response) {
                location.reload();
            }
        });
    } else {
        alert("Veuillez sélectionner au moins une commande.");
    }
});
$('#reporter').on('click', function () {
    var checkedCheckboxes = $('.select-commande:checked');

    if (checkedCheckboxes.length > 0) {
        var checkedIds = checkedCheckboxes.map(function () {
            return $(this).data('id');
        }).get();
        var remarque = $('#remarque_livre').val();
        var date = $('#date_report').val();
        var heure = $('#heure_report').val();
        $.ajax({
            type: "GET",
            url: "/changeStatusReporter",
            data: {
                id : checkedIds,
                remarque : remarque,
                date : date,
                heure : heure
            },
            dataType: "json",
            success: function (response) {
                location.reload();
            }
        });
    } else {
        alert("Veuillez sélectionner au moins une commande.");
    }
});
$('#changementLiv').on('click', function () {
    var checkedCheckboxes = $('.select-commande:checked');

    if (checkedCheckboxes.length > 0) {
        var checkedIds = checkedCheckboxes.map(function () {
            return $(this).data('id');
        }).get();
        var livreur = $('#liv_id').val();
        $.ajax({
            type: "GET",
            url: "/changeStatusLivreur",
            data: {
                id : checkedIds,
                livreur : livreur
            },
            dataType: "json",
            success: function (response) {
                location.reload();
            }
        });
    } else {
        alert("Veuillez sélectionner au moins une commande.");
    }
});
$('#livree').on('click', function () {
    var checkedCheckboxes = $('.select-commande:checked');

    if (checkedCheckboxes.length > 0) {
        var checkedIds = checkedCheckboxes.map(function () {
            return $(this).data('id');
        }).get();
        var remarque = $('#remarque_livre').val();
        $.ajax({
            type: "GET",
            url: "/changeStatusLivre",
            data: {
                id : checkedIds,
                remarque : remarque
            },
            dataType: "json",
            success: function (response) {
                location.reload();
            }
        });
    } else {
        alert("Veuillez sélectionner au moins une commande.");
    }
});
var dtUserTable = $('.user-cmd-table')
if (dtUserTable.length) {
    var date = $('#filter_date').val();
    var livreur = $('#livreur_id').val();

    dtUserTable.DataTable({
        order: [[1, 'desc']],
        dom:
            '<"d-flex justify-content-between align-items-center header-actions mx-2 row mt-75"' +
            '<"col-sm-12 col-lg-4 d-flex justify-content-center justify-content-lg-start" l>' +
            '<"col-sm-12 col-lg-8 ps-xl-75 ps-0"<"dt-action-buttons d-flex align-items-center justify-content-center justify-content-lg-end flex-lg-nowrap flex-wrap"<"me-1"f>B>>' +
            '>t' +
            '<"d-flex justify-content-between mx-2 row mb-1"' +
            '<"col-sm-12 col-md-6"i>' +
            '<"col-sm-12 col-md-6"p>' +
            '>',
        language: {
            sLengthMenu: 'Afficher _MENU_',
            search: 'Rechercher',
            searchPlaceholder: 'Rechercher..',
            paginate: {
                previous: '&nbsp;',
                next: '&nbsp;'
            }
        },
        buttons: [
            {
                extend: 'collection',
                className: 'btn btn-outline-secondary dropdown-toggle me-2',
                text: feather.icons['external-link'].toSvg({ class: 'font-small-4 me-50' }) + 'Export',
                buttons: [
                    {
                        extend: 'print',
                        text: feather.icons['printer'].toSvg({ class: 'font-small-4 me-50' }) + 'Print',
                        title: 'Liste livraisons',
                        exportOptions: { columns: [1,3,4,5] }
                    },
                    {
                        extend: 'csv',
                        text: feather.icons['file-text'].toSvg({ class: 'font-small-4 me-50' }) + 'Csv',
                        className: 'dropdown-item',
                        title: 'Liste livraisons',
                        exportOptions: { columns: [1,2,4,6] }
                    },
                    {
                        extend: 'excel',
                        text: feather.icons['file'].toSvg({ class: 'font-small-4 me-50' }) + 'Excel',
                        className: 'dropdown-item',
                        title: 'Liste livraisons',
                        exportOptions: { columns: [1,2,4,5,6,7] }
                    },
                    {
                        extend: 'pdf',
                        text: feather.icons['clipboard'].toSvg({ class: 'font-small-4 me-50' }) + 'Pdf',
                        className: 'dropdown-item',
                        action: function (e, dt, button, config) {
                            // Redirigez l'utilisateur vers votre lien lors du clic sur le bouton PDF
                            window.location.href = '/genererPDF/'+ livreur + '/' + date; // Remplacez 'votre_lien' par le lien souhaité
                        }
                    },
                    {
                        extend: 'copy',
                        text: feather.icons['copy'].toSvg({ class: 'font-small-4 me-50' }) + 'Copy',
                        className: 'dropdown-item',
                        exportOptions: { columns: [1,2] }
                    }

                ],
                init: function (api, node, config) {
                    $(node).removeClass('btn-secondary');
                    $(node).parent().removeClass('btn-group');
                    setTimeout(function () {
                        $(node).closest('.dt-buttons').removeClass('btn-group').addClass('d-inline-flex mt-50');
                    }, 50);
                }
            },
        ],
    });

}

});
