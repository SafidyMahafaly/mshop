/*=========================================================================================
    File Name: app-client-list.js
    Description: client List page
    --------------------------------------------------------------------------------------
    Item Name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent

==========================================================================================*/
$(function () {
    ('use strict');

    var dataTableClient = $('.client-list-table')
    // Users List datatable
    if (dataTableClient.length) {
      dataTableClient.DataTable({
          ajax: {
              url: '/getAllClient', // Remplacez par l'URL de votre endpoint Laravel
              type: 'GET',
              dataSrc: ''
          },
          columns: [
              { data: 'name' },
              { data: 'fb_name' },
              { data: 'phone' },
              { data: 'adress' },
          ],
          columnDefs: [
            //   {
            //       className: 'control',
            //       orderable: false,
            //       responsivePriority: 2,
            //       targets: 0,
            //       render: function (data, type, full, meta) {
            //           return '';
            //       }
            //   },
              {
                  targets: [0, 2],
                  responsivePriority: 3,
                  render: function (data, type, full, meta) {
                      console.log('teste');
                      var columnName = dataTableClient.DataTable().settings().init().columns[meta.col].data;
                      var columnData = full[columnName];
                      return '<p>' + columnData + '</p>';
                  }
              },

              {
                  targets: 4,
                  title: 'Actions',
                  orderable: false,
                  render: function (data, type, full) {
                      var editClient = '/client/edit/' + full.id;
                      var destroyClient = '/destroyClient/' + full.id;
                      return (
                            '<div class="btn-group">' +
                                '<a class="btn btn-sm dropdown-toggle hide-arrow" data-bs-toggle="dropdown">' +
                                    feather.icons['more-vertical'].toSvg({ class: 'font-small-4' }) +
                                '</a>' +
                                '<div class="dropdown-menu dropdown-menu-end">' +
                                    '<a href="' + editClient + '" class="dropdown-item">' +
                                        feather.icons['file-text'].toSvg({ class: 'font-small-4 me-50' }) +
                                    'edit</a>' +
                                '</div>' +
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
                  text: 'Add New Client',
                  className: 'add-new btn btn-primary',
                  attr: {
                      'data-bs-toggle': 'modal',
                      'data-bs-target': '#modals-client-in'
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
