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
    updateExportButton();

});

// Gestion de la sélection/désélection individuelle des cases à cocher
$('.select-commande').change(function () {
    updateExportButton();
    if ($('.select-commande:checked').length === $('.select-commande').length) {
        $('#selectAll').prop('checked', true);
    } else {
        $('#selectAll').prop('checked', false);
    }
});

$('#exportButton').hide();


function updateExportButton() {
    var selectedCheckboxes = $('.select-commande:checked');
    if (selectedCheckboxes.length > 0) {
        // Affichez le bouton Export lorsque des cases sont sélectionnées
        $('#exportButton').show();
    } else {
        // Masquez le bouton Export lorsque aucune case n'est sélectionnée
        $('#exportButton').hide();
    }
}




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
        var mode = $('#mode_payement').val();
        if(mode){
            var checkedIds = checkedCheckboxes.map(function () {
                return $(this).data('id');
            }).get();
            var remarque = $('#remarque_livre').val();
            var mode = $('#mode_payement').val();
            // alert(mode)
            $.ajax({
                type: "GET",
                url: "/changeStatusLivre",
                data: {
                    id : checkedIds,
                    remarque : remarque,
                    mode : mode
                },
                dataType: "json",
                success: function (response) {
                    location.reload();
                }
            });
        }else{
            alert("Veuillez sélectionner le mode de payement.");
        }

    } else {
        alert("Veuillez sélectionner au moins une commande.");
    }
});
var dtUserTable = $('.user-cmd-table')
if (dtUserTable.length) {
    var date = $('#filter_date').val();
    var livreur = $('#name_liv').val();
    var compteur = $('#compteur').val();
    dtUserTable.DataTable({
        order: [[1, 'desc']],
        paging: false,
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
        ordering: false,
        buttons: [
            {
                extend: 'collection',
                className: 'btn btn-outline-secondary dropdown-toggle me-2',
                text: feather.icons['external-link'].toSvg({ class: 'font-small-4 me-50' }) + 'Export',
                buttons: [
                    {
                        extend: 'excel',
                        text: feather.icons['file'].toSvg({ class: 'font-small-4 me-50' }) + 'Excel',
                        className: 'dropdown-item',
                        title: ' Liste livraisons - Date : ' + date + ' - Livreur : ' + livreur + ' - Nbr : ' + compteur,
                        exportOptions: { columns: [1,2,3,5,6] }
                    },

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


function getSelectedIds() {
    var selectedIds = [];
    $('.select-commande:checked').each(function() {
        var id = $(this).attr('data-id');
        selectedIds.push(id);
    });
    var livreur = $('#livreur_id').val();
    var pdfUrl = '/genererPDF?commande=' + selectedIds.join(',') + '&livreur_id=' + livreur;
    window.location.href = pdfUrl;

}

$('#exportButton .pdf').on('click',function(){
    // alert('test')
     getSelectedIds();
})




});
