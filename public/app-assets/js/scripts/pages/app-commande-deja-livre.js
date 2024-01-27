/*=========================================================================================
    File Name: app-commande-deja-livre.js
    Description: Liste des commandes déjà livré par agent
    --------------------------------------------------------------------------------------
==========================================================================================*/
$(function () {
    ('use strict');

    var dtUserTable = $('.commande-deja-livre')

    $("#valide_form_agent").on("click", function() {
        // Récupérer les données du formulaire
        var formData = $("#form_agent").serialize();

        // Envoyer une requête Ajax au serveur
        $.ajax({
            url: "/get-commande-livre-agent", // Remplacez par l'URL de votre route de validation
            type: "POST", // ou "GET" selon votre route
            data: formData,

            success: function(response) {
                // Gérer la réponse du serveur ici
                console.log(response);
            },
            error: function(error) {
                // Gérer les erreurs ici
                console.log(error);
            }
        });
    });


    function initDataTable(date) {
        if ($.fn.DataTable.isDataTable('.commande-deja-livre')) {
            dtUserTable.DataTable().destroy();
        }
        if (dtUserTable.length) {
            dtUserTable.DataTable({
                columns: [
                    { data: 'selected', orderable: false, className: 'select-checkbox ' },
                    { data: 'id' },
                    {
                        data: 'lieu_livraison',
                        render: function(data, type, row) {
                            if (type === 'display') {
                                return data ? data : 'Recuperer';
                            }
                            return data;
                        }
                    },
                    { data: 'client.name' },
                    {
                        data: 'details',
                        render: function(data) {
                            console.log(data);
                            return data.map(detail => `- ${detail.produit.name}`).join('<br>');
                        }
                    },
                    {
                        data: 'details',
                        render: function(data) {
                                return data.map(detail => detail.quantity).join('<br>');
                            }
                    },
                    { data: 'total',
                    render: function(data, type, row) {
                            if (type === 'display') {
                                // Utilise toLocaleString() pour ajouter des séparateurs de milliers
                                return parseFloat(data).toLocaleString('fr-FR') + ' Ar';
                            }
                            return data;
                        }
                    },
                    {
                        data: 'status',
                        render: function(data, type, row) {
                            if (type === 'display') {
                                if (data == 1) {
                                    return '<span class="badge bg-warning">en attente</span>';
                                } else if(data == 2){
                                    return '<span class="badge bg-info">Assigner livreur</span>';
                                } else if(data == 3){
                                    return '<span class="badge bg-success">Livré</span>';
                                } else if(data == 4){
                                    return '<span class="badge bg-dark">Annuler</span>';
                                } else if(data == 5){
                                    return '<span class="badge bg-secondary">Reporter</span>';
                                }
                            }
                            return data;
                        }
                    },
                    {
                        data: 'payer',
                        render: function(data, type, row) {
                            if (type === 'display') {
                                if (data === 1) {
                                    return '<span class="badge bg-success">Payé</span>';
                                } else {
                                    return '<span class="badge bg-danger">Non Payé</span>';
                                }
                            }
                            return data;
                        }
                    },
                    { data: 'user.name' },
                    { data: 'client.name' },
                ],
                createdRow: function (row, data, dataIndex) {
                    var status = data.status;

                    // Déterminez si le statut nécessite la désactivation du select
                    var disableSelect = !(status == 1  || status == 5);

                    // Appliquez la désactivation au select de la première colonne
                    $('td:eq(0)', row).find('.row-checkbox').prop('disabled', disableSelect);

                    // Désactivez la case à cocher de l'entête si le statut ne permet pas la sélection
                    if (disableSelect) {
                        $('.select-checkbox', row).find('.row-checkbox').prop('disabled', true);
                    }
                },
                columnDefs: [
                    {
                        targets: 0,
                        title: '<input type="checkbox" id="selectAllCheckbox">',
                        orderable: false,
                        className: 'select-checkbox',
                        render: function (data, type, full, meta) {
                            // Inclure l'ID de la commande comme valeur de la case à cocher
                            return '<input type="checkbox" class="row-checkbox " value="' + full.id + '">';
                        },
                    },
                    {
                        targets: 1, // Colonne ID, vous pouvez ajuster en fonction de votre tableau
                        visible: false, // Masquer la colonne ID si nécessaire
                    },
                    {
                        targets: [10],
                        title: 'Actions',
                        orderable: false,
                        render: function (data, type, full) {
                            var userView = '/editCommande/' + full.id;
                            var userDelete = '/deleteCommande/' + full.id;
                            var userFactur = '/commande/facturation/' + full.id;

                            return (
                                '<div class="btn-group">' +
                                    '<a class="btn btn-sm dropdown-toggle hide-arrow" data-bs-toggle="dropdown">' +
                                    feather.icons['more-vertical'].toSvg({ class: 'font-small-4' }) +
                                    '</a>' +
                                    '<div class="dropdown-menu dropdown-menu-end">' +
                                        '<a href="' + userView + '" class="dropdown-item">' +
                                        feather.icons['file-text'].toSvg({ class: 'font-small-4 me-50' }) +
                                        'edit</a>' +
                                        '<a href="' + userDelete + '" class="dropdown-item delete-record">' +
                                        feather.icons['trash-2'].toSvg({ class: 'font-small-4 me-50' }) +
                                        'Delete</a>'+
                                        '<a href="' + userFactur + '" class="dropdown-item delete-record">' +
                                        feather.icons['trash-2'].toSvg({ class: 'font-small-4 me-50' }) +
                                        'Facturation</a>'+
                                    '</div>' +
                                '</div>'
                            );
                        }
                    },
                ],
                select: {
                    style: 'multi',
                    selector: 'td.row-checkbox',
                },
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
                        text: 'Add New commande',
                        className: 'add-new btn btn-primary',
                        action: function () {
                            window.location.href = '/addCommande';
                        },
                        init: function (api, node, config) {
                            $(node).removeClass('btn-secondary');
                        }
                    },

                ],
                responsive: {
                    details: {
                        display: $.fn.dataTable.Responsive.display.modal({
                            header: function (row) {
                                var data = row.data();
                                return 'Details of ' + data['full_name'];
                            }
                        }),
                        type: 'column',
                        renderer: function (api, rowIdx, columns) {
                            var data = $.map(columns, function (col, i) {
                                return col.columnIndex !== 6
                                    ? '<tr data-dt-row="' +
                                        col.rowIdx +
                                        '" data-dt-column="' +
                                        col.columnIndex +
                                        '">' +
                                        '<td>' +
                                        col.title +
                                        ':' +
                                        '</td> ' +
                                        '<td>' +
                                        col.data +
                                        '</td>' +
                                        '</tr>'
                                    : '';
                            }).join('');
                            return data ? $('<table class="table"/>').append('<tbody>' + data + '</tbody>') : false;
                        }
                    }
                },
                drawCallback: function () {
                // Réattachez les gestionnaires d'événements pour les cases à cocher après le rechargement
                $('#selectAllCheckbox').on('change', function() {
                    var isChecked = $(this).prop('checked');
                    $('.row-checkbox').prop('checked', isChecked);
                    updateExportButton();
                });

                $('.row-checkbox').on('change', function() {
                    updateExportButton();
                });
            }
            });
        }
    }

  });
