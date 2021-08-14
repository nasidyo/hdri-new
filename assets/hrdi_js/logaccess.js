(function ($) {
    var Table= $('#logaccess-table').DataTable();
    initTableAccess();
    function initTableAccess (){
        Table.destroy();
        Table = $('#logaccess-table').DataTable( {
            "processing": true,
            "responsive": true,
            "serverSide": true,
            "ajax": "../server_side/logAccessList.php",
            "type": "GET",
            "autoWidth": false,
            dom: "<'row'<'col-sm-6'Bl><'col-sm-6'f>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            'buttons': [{
                'extend': 'collection',
                'className': 'exportButton',
                'text': 'Data Export',
                'buttons': [
                    { 'extend':'copy',
                    'action':newexportaction ,
                            'exportOptions': {
                              'modifier': {
                                'page': 'All',
                                'search': 'none'
                              },
                              'columns': [0,1,2,3,4,5]
                          },
                          'title': 'ข้อมูลการเข้าใข้งานระบบ',
                    },
      
                    { 'extend':'csv',
                    'action':newexportaction ,
                    'exportOptions': {
                      'modifier': {
                        'page': 'All',
                        'search': 'none'
                        },
                        'columns': [0,1,2,3,4,5]
                      },
                      'title': 'ข้อมูลการเข้าใข้งานระบบ',
                    },
      
                    { 'extend':'excel',
                    'action':newexportaction ,
                    'exportOptions': {
                      'modifier': {
                        'page': 'All',
                        'search': 'none'
                        },
                        'columns': [0,1,2,3,4,5]
                      },
                      'title': 'ข้อมูลการเข้าใข้งานระบบ',
                    },
                    { 'extend':'print',
                    'action':newexportaction ,
                    'exportOptions': {
                      'modifier': {
                        'page': 'ALL',
                        'search': 'none'
                        },
                        'columns': [0,1,2,3,4,5]
                      },
                      'title': 'ข้อมูลการเข้าใข้งานระบบ',
                    },
                  ]
              }],
            'fixedColumns':   {
                'heightMatch': 'none'
            },
            'columnDefs': [{
                'targets': [0,6,7],
                "visible": false
            },{
                'targets': [8],
                'width': 100,
                'searchable': false,
                'orderable': false,
                'className': 'dt-header-center',
                'render': function (data, type, row){
                    data = '<div style=" font-size: 20px; "><center>';
                    data = data+ '<i class=" fa fa-eye" id="viewUserAccessUrl" name="viewUserAccessUrl" style=" cursor: pointer;margin-right: 10px; color: green;"></i>';
                    data = data+ '</center></div>';
                    return data;
                }
                }
            ],
            'order': [[0, 'desc']]
        });
    }
    $('#logaccess-table tbody').on('click','#viewUserAccessUrl', function () {
        var data = Table.row( $(this).parents('tr') ).data();
        var idStaff = data[6];
        $('#showActivityUserModal').modal('show');
        initTableUserActivity(idStaff);
    } );

    $('#departmentId').change(function(){
        var departmentId = $(this).val();
        if(departmentId != 'all'){
            Table.columns( 7 ).search(departmentId, true, false).draw();
        }else{
            Table.columns().search("").draw();
        }
    } );

    function initTableUserActivity (idStaff){
        var idStaffvale = idStaff;
        var Table= $('#activityUser-table').DataTable();
        Table.destroy();
        $('#activityUser-table').DataTable( {
            "processing": true,
            "responsive": true,
            "serverSide": true,
            "ajax": "../server_side/logAccessActivityList.php?idStaff="+idStaffvale,
            "type": "GET",
            "autoWidth": false,
            dom: "<'row'<'col-sm-6'Bl><'col-sm-6'f>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            'buttons': [{
                'extend': 'collection',
                'className': 'exportButton',
                'text': 'Data Export',
                'buttons': [
                    { 'extend':'copy',
                    'action':newexportaction ,
                            'exportOptions': {
                              'modifier': {
                                'page': 'All',
                                'search': 'none'
                              },
                              'columns': [0,1,2,3]
                          },
      
                    },
      
                    { 'extend':'csv',
                    'action':newexportaction ,
                    'exportOptions': {
                      'modifier': {
                        'page': 'All',
                        'search': 'none'
                        },
                        'columns': [0,1,2,3]
                      },
                    },
      
                    { 'extend':'excel',
                    'action':newexportaction ,
                    'exportOptions': {
                      'modifier': {
                        'page': 'All',
                        'search': 'none'
                        },
                        'columns': [0,1,2,3]
                      },
                    },
                    { 'extend':'print',
                    'action':newexportaction ,
                    'exportOptions': {
                      'modifier': {
                        'page': 'ALL',
                        'search': 'none'
                        },
                        'columns': [0,1,2,3]
                      },
                    },
                  ]
              }],
            'fixedColumns':   {
                'heightMatch': 'none'
            },
            'columnDefs': [{
                'targets': [0],
                "visible": false
            }
            ],
            'order': [[0, 'desc']]
        });
    }

    function newexportaction(e, dt, button, config) {
        var self = this;
        var oldStart = dt.settings()[0]._iDisplayStart;
        dt.one('preXhr', function (e, s, data) {
            // Just this once, load all data from the server...
            data.start = 0;
            data.length = 2147483647;
            dt.one('preDraw', function (e, settings) {
                // Call the original action function
                if (button[0].className.indexOf('buttons-copy') >= 0) {
                    $.fn.dataTable.ext.buttons.copyHtml5.action.call(self, e, dt, button, config);
                } else if (button[0].className.indexOf('buttons-excel') >= 0) {
                    $.fn.dataTable.ext.buttons.excelHtml5.available(dt, config) ?
                        $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config) :
                        $.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
                } else if (button[0].className.indexOf('buttons-csv') >= 0) {
                    $.fn.dataTable.ext.buttons.csvHtml5.available(dt, config) ?
                        $.fn.dataTable.ext.buttons.csvHtml5.action.call(self, e, dt, button, config) :
                        $.fn.dataTable.ext.buttons.csvFlash.action.call(self, e, dt, button, config);
                } else if (button[0].className.indexOf('buttons-pdf') >= 0) {
                    $.fn.dataTable.ext.buttons.pdfHtml5.available(dt, config) ?
                        $.fn.dataTable.ext.buttons.pdfHtml5.action.call(self, e, dt, button, config) :
                        $.fn.dataTable.ext.buttons.pdfFlash.action.call(self, e, dt, button, config);
                } else if (button[0].className.indexOf('buttons-print') >= 0) {
                    $.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
                }
                dt.one('preXhr', function (e, s, data) {
                    // DataTables thinks the first item displayed is index 0, but we're not drawing that.
                    // Set the property to what it was before exporting.
                    settings._iDisplayStart = oldStart;
                    data.start = oldStart;
                });
                // Reload the grid with the original page. Otherwise, API functions like table.cell(this) don't work properly.
                setTimeout(dt.ajax.reload, 0);
                // Prevent rendering of the full data to the DOM
                return false;
            });
        });
        // Requery the server with the new one-time export settings
        dt.ajax.reload();
    };


})(jQuery);