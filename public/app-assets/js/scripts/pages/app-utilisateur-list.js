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
$('.edit').on('click',function(){
    var id = $(this).attr('data-id');
    var name = $(this).attr('data-name');
    var email = $(this).attr('data-email');
    var roleId = $(this).attr('data-role-id'); // Récupérer l'ID du rôle
    $('#name_u').val(name)
    $('#email_u').val(email)
    $('#id_u').val(id)

    // Parcourir les options du menu déroulant
    $('#role_u option').each(function() {
        // Comparer l'ID du rôle avec la valeur de l'attribut data-role-id de chaque option
        if ($(this).attr('data-role-id') == roleId) {
            // Définir cette option comme sélectionnée
            $(this).prop('selected', true);
        }
    });
})
  var dtUserTable = $('.user-utilisateur-table')
  // Users List datatable
  if (dtUserTable.length) {
    dtUserTable.DataTable({
        // ajax: {
        //     url: '/getUtilisateur', // Remplacez par l'URL de votre endpoint Laravel
        //     type: 'GET',
        //     dataSrc: ''
        // },
        // columns: [
        //     { data: 'id' },
        //     { data: 'name' },
        //     { data: 'email' },
        //     {
        //         data: 'roles',
        //         render: function(data, type, full) {
        //             return data.map(role => role.name).join(', ');
        //         }
        //     },
        //     { data: 'roles' },
        // ],
        // columnDefs: [
        //     {
        //         className: 'control',
        //         orderable: false,
        //         responsivePriority: 2,
        //         targets: 0,
        //         render: function (data, type, full, meta) {
        //             return '';
        //         }
        //     },
        //     {
        //         targets: [1, 2],
        //         responsivePriority: 3,
        //         render: function (data, type, full, meta) {
        //             console.log('teste');
        //             var columnName = dtUserTable.DataTable().settings().init().columns[meta.col].data;
        //             var columnData = full[columnName];
        //             return '<p>' + columnData + '</p>';
        //         }
        //     },

        //     {
        //         targets: 4,
        //         title: 'Actions',
        //         orderable: false,
        //         render: function (data, type, full) {
        //             var commandeView = '/profil/' + full.id; // Utilisez directement full.id
        //             var userView = '/profile/' + full.id; // Utilisez directement full.id
        //             var userDelete = '/deleteF/' + full.id; // Utilisez directement full.id
        //             return (
        //                 '<div class="btn-group">' +
        //                 '<a class="btn btn-sm dropdown-toggle hide-arrow" data-bs-toggle="dropdown">' +
        //                 feather.icons['more-vertical'].toSvg({ class: 'font-small-4' }) +
        //                 '</a>' +
        //                 '<div class="dropdown-menu dropdown-menu-end">' +
        //                 '<a href="' + userView + '" class="dropdown-item">' +
        //                 feather.icons['file-text'].toSvg({ class: 'font-small-4 me-50' }) +
        //                 'Operation</a>' +
        //                 '</div>'
        //             );
        //         }
        //     }
        // ],
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
                        exportOptions: { columns: [1,2] }
                    },
                    {
                        extend: 'csv',
                        text: feather.icons['file-text'].toSvg({ class: 'font-small-4 me-50' }) + 'Csv',
                        className: 'dropdown-item',
                        exportOptions: { columns: [1,2] }
                    },
                    {
                        extend: 'excel',
                        text: feather.icons['file'].toSvg({ class: 'font-small-4 me-50' }) + 'Excel',
                        className: 'dropdown-item',
                        exportOptions: { columns: [1,2] }
                    },
                    {
                        extend: 'pdf',
                        text: feather.icons['clipboard'].toSvg({ class: 'font-small-4 me-50' }) + 'Pdf',
                        className: 'dropdown-item',
                        exportOptions: { columns: [1,2] }
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
            {
                text: 'Add New User',
                className: 'add-new btn btn-primary',
                attr: {
                    'data-bs-toggle': 'modal',
                    'data-bs-target': '#modals-fournisseur-in'
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
