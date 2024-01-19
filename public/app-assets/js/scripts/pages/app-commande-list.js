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

  var dtUserTable = $('.user-commande-table')
  // Users List datatable
  var btn = $('.add-card');
  var card = $('.nex-prod');
  btn.on('click',function(){
    card.append(
        '<div class="row contenue_produit_cmd">\
            <hr>\
            <div class="col-md-6 mb-1">\
                <label class="form-label" for="basic-icon-default-fullname">Nom du produit</label>\
                <input type="text" value="" class="form-control dt-full-name name_produit" autocomplete="off" id="name_produit" placeholder="ex : Coca cola" name="name_produit[]" required/>\
                <input type="hidden" id="id_produit" class="id_produit" name="id_produit[]">\
                <div class="contenue">\
                    <div class="produit_suggerer"></div>\
                </div>\
            </div>\
            <div class="col-md-6 mb-1">\
                <label class="form-label" for="basic-icon-default-fullname">Reference</label>\
                <input type="tel" value="" class="form-control dt-full-name reference_produit" name="reference[]" id="basic-icon-default-fullname" placeholder="ex : CO-PM-01 " required/>\
            </div>\
            <div class="col-md-6 mb-1">\
                <label class="form-label" for="basic-icon-default-fullname">Prix</label>\
                <input type="text" value="" class="form-control dt-full-name prix_vente" name="prix_vente[]" id="basic-icon-default-fullname" placeholder="ex : 12 000 Ar "  required/>\
            </div>\
            <div class="col-md-4 mb-1">\
                <label class="form-label" for="basic-icon-default-fullname">Quatité</label>\
                <input type="number" value="" class="form-control dt-full-name" name="quantite[]" id="basic-icon-default-fullname" placeholder="quantity"  required/>\
            </div>\
            <div class="col-md-2 mt-2">\
                <button class="btn btn-danger remove-card">Del</button>\
            </div>\
        </div>'
    );
  });



    $('#phone').on('input',function(){
        var cle = $(this).val();
        if(cle.length >= 3)
        {
            $.ajax({
                type: "GET",
                url: "/getClient",
                data: {cle : cle},
                dataType: "json",
                success: function (response) {
                    // console.log(response)
                    var suggestions = $('#client_suggerer');
                    suggestions.empty();
                    $.each(response, function(index, client) {
                        var id      = client.id;
                        var nom     = client.name;
                        var nom_fb  = client.fb_name;
                        var phone   = client.phone;
                        var adresse = client.adress;
                        var remarque = client.remarque;
                        var suggestionItemClient = $('<div class="suggestion-item-client"></div>')
                            .addClass('suggestion-item-client')
                            .text(phone).attr('data-nom-client', nom)
                            .attr('data-nom-fb-client', nom_fb)
                            .attr('data-phone-client', phone)
                            .attr('data-adresse-client', adresse)
                            .attr('data-remarque-client', remarque)
                            .attr('data-client-id',id);
                        suggestions.append(suggestionItemClient);
                    });
                }
            });
        } else {
            $('#client_suggerer').empty();
        }
    })
    $('.recap').hide();
    $('#remarque_client').hide();
    $(document).on('click', '.suggestion-item-client', function() {
        var id      = $(this).attr('data-client-id');
        $.ajax({
            type: "GET",
            url: "/getCommandeClient",
            data: {
                id : id
            },
            dataType: "json",
            success: function (response) {
                if (response.length > 0) {
                    // Afficher le tableau s'il y a des commandes
                    $('.recap').show();

                    // Sélectionner la table
                    var table = $('.recapCommande');

                    // Effacer le contenu de la table
                    table.find('tbody').empty();

                    // Parcourir les données de la réponse
                    $.each(response, function(index, commande) {
                        // Ajouter une nouvelle ligne à la table
                        var row = $('<tr>');
                        var produits = '';
                        $.each(commande.details, function(index, detail) {
                            produits += detail.produit.name + '<br>';
                        });
                        var quantite = '';
                        $.each(commande.details, function(index, detail) {
                            quantite += detail.quantity + '<br>';
                        });
                        row.append($('<td>').html(produits));
                        row.append($('<td>').html(quantite));
                        row.append($('<td>').text(commande.total + ' Ar'));
                        if (commande.status == 1) {
                            row.append($('<td>').text('en attente'));
                        } else {
                            // Ajouter la colonne avec le statut normal si le statut n'est pas égal à 1
                            row.append($('<td>').text('assigner au livreur'));
                        }
                        row.append($('<td>').text(commande.user.name));
                        row.append($('<td>').html(`<a class='btn btn-sm btn-secondary' href='/editCommande/${commande.id}'>Edit</a>`));
                        table.append(row);
                    });
                } else {
                    // Masquer le tableau s'il n'y a pas de commandes
                    $('.recap').hide();
                }
            }
        });
        var name    = $(this).attr('data-nom-client');
        var fb_name = $(this).attr('data-nom-fb-client');
        var adress  = $(this).attr('data-adresse-client');
        var phone   = $(this).attr('data-phone-client');
        var remarque =  $(this).attr('data-remarque-client');
        if(remarque != null){
            $('#remarque_client').show();
            $('#remarque_client').html('<i class="fa-solid fa-triangle-exclamation"></i> ' + remarque);


        }
        $('#client_id').val(id);
        $('#phone').val(phone);
        $('#adress').val(adress);
        $('#lieu_livraison').val(adress);
        $('#fb_name').val(fb_name);
        $('#name').val(name);
        $('#client_suggerer').empty();
    })

    $(document).on('input', '.name_produit', function () {
        var cle = $(this).val();
        var produitSuggerer = $(this).siblings('.contenue').find('.produit_suggerer');

        if (cle.length >= 1) {
            $.ajax({
                type: "GET",
                url: "/getProduitCom",
                data: { cle: cle },
                dataType: "json",
                success: function (response) {
                    produitSuggerer.empty();
                    $.each(response, function (index, produit) {
                        var produit_id = produit.id;
                        var prix_vente = produit.selling_price;
                        var reference_produit = produit.reference;
                        var nom_produit = produit.name;
                        var suggestionItem = $('<div class="suggestion-item"></div>').addClass('suggestion-item').text(nom_produit + ' | ' + reference_produit).attr('data-produit-id', produit_id).attr('data-reference-produit', reference_produit).attr('data-prix-vente', prix_vente).attr('data-nom-produit', nom_produit);
                        produitSuggerer.append(suggestionItem);
                    });
                }
            });
        } else {
            produitSuggerer.empty();
        }
    });

    //calcule des prix
    function calculerSommeTotale() {
        var sommeTotale = 0;

        // Parcourir toutes les lignes existantes
        $('.contenue_produit_cmd').each(function () {
            var quantite = parseInt($(this).find('input[name="quantite[]"]').val()) || 0;
            var prixVente = parseFloat($(this).find('input[name="prix_vente[]"]').val().replace(/\s+/g, '').replace('Ar', '')) || 0;
            sommeTotale += quantite * prixVente;
        });

        // Ajouter les frais de livraison
        var fraisLivraison = parseInt($('input[name="frais_livraison"]').val()) || 0;
        sommeTotale += fraisLivraison;

        // Formater la somme totale avec le format souhaité
        var formattedSommeTotale = sommeTotale.toLocaleString('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        formattedSommeTotale = formattedSommeTotale.endsWith('.00') ? formattedSommeTotale.slice(0, -3) : formattedSommeTotale;


        // Mettre à jour l'affichage de la somme totale avec formatage et ajout d'Ar
        $('.somme_totale').text(formattedSommeTotale + ' Ar');


        $('#somme').val(sommeTotale)
        // console.log(sommeTotale);

    }

    $('input[name="frais_livraison"]').on('input', function() {
        // Appelez la fonction calculerSommeTotale lorsque la valeur change
        calculerSommeTotale();
    });

    // Ajoutez un gestionnaire d'événements pour le changement de quantité pour les lignes existantes
    $(document).on('input', '.contenue_produit_cmd input[name="quantite[]"], .contenue_produit_cmd input[name="prix_vente[]"]', function () {
        calculerSommeTotale();
    });




    $(document).on('click', '.suggestion-item', function() {
        var parentContenueProduitCmd = $(this).closest('.contenue_produit_cmd');

        // Récupérer les champs à l'intérieur de l'élément parent
        var recherche_produit_Input = parentContenueProduitCmd.find('.name_produit');
        var reference_produit_Input = parentContenueProduitCmd.find('.reference_produit');
        var prix_vente_Input = parentContenueProduitCmd.find('.prix_vente');
        var id_produit = parentContenueProduitCmd.find('.id_produit');

        // Récupérer le data à partir de l'élément cliqué
        var produit_id = $(this).data('produit-id');
        var prix_vente = $(this).data('prix-vente');
        var reference_produit = $(this).data('reference-produit');
        var nom_produit = $(this).data('nom-produit');

        // Mettre à jour les champs
        recherche_produit_Input.val(nom_produit);
        reference_produit_Input.val(reference_produit);
        prix_vente_Input.val(prix_vente);
        id_produit.val(produit_id);

        // Vider les suggestions après avoir complété les champs
        $('.produit_suggerer').empty();

    });



    // Gérez le clic sur le bouton de suppression pour les éléments .nex-prod
    $('.nex-prod').on('click', '.remove-card', function () {
        $(this).closest('.row').remove();
        calculerSommeTotale();
    });

    // Gérez le clic sur le bouton de suppression pour le premier champ d'entrée
    $('.row:not(.nex-prod) .remove-card').on('click', function () {
        $(this).closest('.row').remove();
        calculerSommeTotale();
    });





    function initDataTable(date) {
        if ($.fn.DataTable.isDataTable('.user-commande-table')) {
            dtUserTable.DataTable().destroy();
        }
        if (dtUserTable.length) {
            dtUserTable.DataTable({
                ajax: {
                    url: '/getCommandes',
                    type: 'GET',
                    data: { date: date }, // Ajoutez la date comme paramètre
                    dataSrc: '',
                    error: function (xhr, error, thrown) {
                        console.log('Ajax error:', error);
                        console.log('Thrown error:', thrown);
                        alert('Une erreur est survenue lors du chargement des données. Veuillez consulter la console pour plus d\'informations.');
                    }
                },
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
                    // {
                    //     data: 'details',
                    //     render: function(data) {
                    //         return data.map(detail => `- ${detail.produit.selling_price} Ar`).join('<br>');
                    //     }
                    // },
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



    var savedDate = localStorage.getItem('selectedDate');

    // Mettez à jour l'input de date si une date est sauvegardée
    if (savedDate) {
        $('#customDateInput').val(savedDate);
        initDataTable(savedDate); // Initialisez le DataTable avec la date sauvegardée
    }

    // Écoutez les changements sur l'input de date
    $('#customDateInput').on('change', function () {
        // Récupérez la date sélectionnée
        var selectedDate = $(this).val();

        // Sauvegardez la date dans le stockage local
        localStorage.setItem('selectedDate', selectedDate);

        // Réinitialisez le DataTable avec la nouvelle date
        initDataTable(selectedDate);
    });


    $('#adress').on('input',function(){
        $('#lieu_livraison').val($(this).val());
    });
$('#exportButton').hide();
$('#livrer').hide();
function updateExportButton() {
    var selectedCheckboxes = $('.row-checkbox:checked');
    if (selectedCheckboxes.length > 0) {
        // Affichez le bouton Export lorsque des cases sont sélectionnées
        $('#exportButton').show();
    } else {
        // Masquez le bouton Export lorsque aucune case n'est sélectionnée
        $('#exportButton').hide();
    }
}

$('.a_livrer').on('change',function(){
    // alert($(this).val())
    var valeur = $(this).val()

    if(valeur == 1){
        $('#frais_livraison').val(3000);
        calculerSommeTotale()
        $('#livrer').show();
        // $('#lieu_livraison').prop('required', true);
        $('#frais_livraison').prop('required', true);
    }else{
        $('#frais_livraison').val(0);
        calculerSommeTotale()
        $('#livrer').hide();
        // $('#lieu_livraison').prop('required', false);
        $('#frais_livraison').prop('required', false);
    }
})



function getSelectedIds() {
    var selectedIds = [];

    // Itérer sur les cases cochées
    $('.row-checkbox:checked').each(function() {
        // Récupérer la valeur de l'attribut "value" de chaque case cochée (c'est l'ID)
        var id = $(this).val();
        // Ajouter l'ID à la liste
        selectedIds.push(id);
    });
    var livreur = $('#livreur').val()
    if(livreur == 'null'){
        alert('veuillez selectioner un livreur')
    }else{
        $.ajax({
            type: "GET",
            url: "/livreur_commande",
            data: {
                commande : selectedIds,
                livreur_id : livreur
            },
            dataType: "json",
            success: function (response) {
                location.reload();
            }
        });
    }

}

$('#exportButton .livraison').on('click',function(){
     getSelectedIds();
})





  // Form Validation


  // Phone Number

});
