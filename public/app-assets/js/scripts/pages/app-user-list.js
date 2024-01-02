/*=========================================================================================
    File Name: app-user-list.js
    Description: User List page
    --------------------------------------------------------------------------------------
    Item Name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent

==========================================================================================*/
$(function () {
  $.ajax({
    type: "GET",
    url: "/getProduit",
    dataType: "json",
    success: function (response) {
        // console.log(response);
        user_list = response

    }
  });

  ('use strict');

  var dtUserTable = $('.user-list-table'),
    newUserSidebar = $('.new-user-modal'),
    select = $('.select2'),

    statusObj = {
      1: { title: 'Pending', class: 'badge-light-warning' },
      2: { title: 'Active', class: 'badge-light-success' },
      3: { title: 'Inactive', class: 'badge-light-secondary' }
    };

  var assetPath = '../../../app-assets/',
    userView = 'app-user-view-account.html';

  if ($('body').attr('data-framework') === 'laravel') {
    assetPath = $('body').attr('data-asset-path');
    userView = assetPath + 'app/user/view/account';
  }

  select.each(function () {
    var $this = $(this);
    $this.wrap('<div class="position-relative"></div>');
    $this.select2({
      // the following code is used to disable x-scrollbar when click in select input and
      // take 100% width in responsive also
      dropdownAutoWidth: true,
      width: '100%',
      dropdownParent: $this.parent()
    });
  });

  // Users List datatable
  if (dtUserTable.length) {
    dtUserTable.DataTable({
        ajax: {
            url: '/getProduit', // Remplacez par l'URL de votre endpoint Laravel
            type: 'GET',
            dataSrc: '',
            data: function (data) {
                // Ajoutez un paramètre 'with' pour inclure la relation avec la catégorie
                data.with = ['categorie'];
            }
        },
        columns: [
            { data: 'id' },
            { data: 'name' },
            { data: 'reference' },
            { data: 'unity' },

            { data: 'purchase_price' },
            { data: 'selling_price' },
            { data: 'categorie.name' },

        ],
        columnDefs: [
            {
                className: 'control',
                orderable: false,
                responsivePriority: 2,
                targets: 0,
                render: function (data, type, full, meta) {
                    return '';
                }
            },
            {
                targets: [1, 2, 3],
                responsivePriority: 5,
                render: function (data, type, full, meta) {
                    var columnName = dtUserTable.DataTable().settings().init().columns[meta.col].data;
                    var columnData = full[columnName];
                    return '<p>' + columnData + '</p>';
                }
            },
            {
                targets: [4, 5], // Les indices des colonnes 'purchase_price' et 'selling_price'
                render: function (data, type, full) {
                    // Vérifiez si le type de rendu est pour l'affichage ou pour la saisie (pour le tri, etc.)
                    if (type === 'display' || type === 'filter') {
                        // Utilisez parseFloat pour vous assurer que la valeur est traitée comme un nombre décimal
                        var price = parseFloat(data);
                        // Formatez le prix avec le symbole "Ar"
                        var formattedPrice =  price.toLocaleString('fr-FR') + " Ar" ;
                        return '<p>' + formattedPrice + '</p>';
                    }
                    // Pour d'autres types, retournez simplement la valeur
                    return data;
                }
            },
            {
                targets: 6,
                title: 'Categorie',
                orderable: false,
                render: function (data, type, full) {
                    if (full.hasOwnProperty('categorie') && full.categorie !== null) {
                        // Si oui, affichez la propriété spécifique de la catégorie que vous souhaitez montrer
                        return '<p>' + full.categorie.name + '</p>';
                    } else {
                        // Sinon, vous pouvez afficher un message ou laisser la cellule vide
                        return '<p>N/A</p>';
                    }
                }
            },
            {
                targets: 7,
                title: 'Actions',
                orderable: false,
                render: function (data, type, full) {
                    var userView = '/editP/' + full.id; // Utilisez directement full.id
                    var userDelete = '/deleteP/' + full.id; // Utilisez directement full.id
                    return (
                        '<div class="btn-group">' +
                        '<a class="btn btn-sm dropdown-toggle hide-arrow" data-bs-toggle="dropdown">' +
                        feather.icons['more-vertical'].toSvg({ class: 'font-small-4' }) +
                        '</a>' +
                        '<div class="dropdown-menu dropdown-menu-end">' +
                        '<a href="' + userView + '" class="dropdown-item">' +
                        feather.icons['file-text'].toSvg({ class: 'font-small-4 me-50' }) +
                        'edit</a>' +
                        '<a href="'+userDelete+'" class="dropdown-item delete-record">' +
                        feather.icons['trash-2'].toSvg({ class: 'font-small-4 me-50' }) +
                        'Delete</a></div>' +
                        '</div>'
                    );
                }
            }
        ],
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
                        className: 'dropdown-item',
                        exportOptions: { columns: [1, 2, 3, 4] }
                    },
                    {
                        extend: 'csv',
                        text: feather.icons['file-text'].toSvg({ class: 'font-small-4 me-50' }) + 'Csv',
                        className: 'dropdown-item',
                        exportOptions: { columns: [1, 2, 3, 4] }
                    },
                    {
                        extend: 'excel',
                        text: feather.icons['file'].toSvg({ class: 'font-small-4 me-50' }) + 'Excel',
                        className: 'dropdown-item',
                        exportOptions: { columns: [1, 2, 3, 4, 5, 6] }
                    },
                    {
                        extend: 'pdf',
                        text: feather.icons['clipboard'].toSvg({ class: 'font-small-4 me-50' }) + 'Pdf',
                        className: 'dropdown-item',
                        exportOptions: { columns: [1, 2, 3, 4] }
                    },
                    {
                        extend: 'copy',
                        text: feather.icons['copy'].toSvg({ class: 'font-small-4 me-50' }) + 'Copy',
                        className: 'dropdown-item',
                        exportOptions: { columns: [1, 2, 3, 4] }
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
            {
                text: 'Add New Produit',
                className: 'add-new btn btn-primary',
                attr: {
                    'data-bs-toggle': 'modal',
                    'data-bs-target': '#modals-slide-in'
                },
                init: function (api, node, config) {
                    $(node).removeClass('btn-secondary');
                }
            }
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
        initComplete: function () {
            var filterColumns = [2, 3, 5];

            filterColumns.forEach(function (index) {
                var column = this.api().columns(index);
                var label = $('<label class="form-label" for="UserFilter' + index + '">Filter</label>').appendTo('.user_filter_' + index);
                var select = $(
                    '<select id="UserFilter' + index + '" class="form-select text-capitalize mb-md-0 mb-2"><option value=""> Select </option></select>'
                )
                    .appendTo('.user_filter_' + index)
                    .on('change', function () {
                        var val = $.fn.dataTable.util.escapeRegex($(this).val());
                        column.search(val ? '^' + val + '$' : '', true, false).draw();
                    });

                column
                    .data()
                    .unique()
                    .sort()
                    .each(function (d, j) {
                        select.append('<option value="' + d + '" class="text-capitalize">' + d + '</option>');
                    });
            }, this);
        }
    });
}

  // Form Validation


  // Phone Number

});
