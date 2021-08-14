(function ($) {
    var Table= $('#datalistTargetAgriUnit').DataTable();
    initTable();
    
    $('#typeOfAgriSearch').change(function(){
        var typeOfAgriId = $(this).val();
        console.log(typeOfAgriId)
        $.ajax({
            url:"../util/loadAgriFromType.php",
            method:"POST",
            data:{typeOfAgriId:typeOfAgriId},
            dataType:"text",
            success:function(data){
                $('#idAgriSearch').html(data);
            }
        });
    });
    $('#typeOfAgriSearch').select2();
    $('#idAgriSearch').select2();
    $('#agriList').select2();
    $('#unit_plan_List').select2();
    
    $('#typeOfAgri').change(function(){
        var typeOfAgriId = $(this).val();
        if(typeOfAgriId != '0'){
            $.ajax({
                url:"../util/loadAgriFromType.php",
                method:"POST",
                data:{typeOfAgriId:typeOfAgriId},
                dataType:"text",
                success:function(data){
                    $('#agriList').html(data);
                }
            });
        }
    });
    $( "#searchBtn" ).click(function() {
        initTable();
    });
    $( "#addAgriPlanBtn" ).click(function() {
        $('#createTargetAgriPlanDialog').modal('show');
    });
    $('#createTargetAgriPlanBtn').click(function(){
        $('#createTargetAgriPlanDialog').modal('hide');
        Table = $('#datalistTargetAgriUnit').DataTable();
        var typeOfAgri = jQuery("#createTargetAgri_form #typeOfAgri option:selected").val();
        var agriList = $('#agriList').val();
        var unit_plan_List = $('#unit_plan_List').val();
        console.log(agriList);
        console.log(unit_plan_List);
        $.ajax({
            type: "POST",
            dataType:'text',
            data:{typeOfAgri:typeOfAgri, agriList:agriList, unit_plan_List:unit_plan_List, action:"addAgriPlan"},
            url: "../handler/agriHandler.php",
            dataType: "html",
            async: true,
            success: function(data) {
                Table.ajax.reload();
            }
        });
    });
    $('#datalistTargetAgriUnit tbody').on('click','#editListTargetAgriUnit', function () {
        var data = Table.row( $(this).parents('tr') ).data();
        var unit_plan_id = data[0];
        $('#editTargetAgriPlanDialog').modal('show');
        $.ajax({
            type: "POST",
            dataType:'text',
            data:{unit_plan_id:unit_plan_id, action:"loadTargetPlan"},
            url: "../handler/agriHandler.php",
            dataType: "html",
            async: true,
            success: function(data) {
                // Table.ajax.reload();
                console.log(data);
                mapData(JSON.parse(data));
            }
        });
    });

    function mapData(data){
        $("#editTargetAgriPlan_form #typeOfAgri").val(data.TypeOfArgi_idTypeOfArgi).trigger('change');
        $.ajax({
            url:"../util/loadAgriFromType.php",
            method:"POST",
            data:{typeOfAgriId:data.TypeOfArgi_idTypeOfArgi},
            dataType:"text",
            success:function(data3){
                $('#agri_id').html(data3);
            },complete: function (data3){
                $("#editTargetAgriPlan_form #agri_id").val(data.idAgri).trigger('change');
            }
        });
        $("#editTargetAgriPlan_form #taget_unit_id").val(data.taget_unit).trigger('change');
        $("#editTargetAgriPlan_form #unit_plan_id").val(data.unit_plan_id);
    }

    $('#updateTargetAgriPlanBtn').click(function(){
        $('#editTargetAgriPlanDialog').modal('hide');
        Table = $('#datalistTargetAgriUnit').DataTable();
        var taget_unit_id = jQuery("#editTargetAgriPlan_form #taget_unit_id option:selected").val();
        var unit_plan_id = jQuery("#editTargetAgriPlan_form #unit_plan_id").val();

        var formData= new FormData();
        formData.append('taget_unit_id',taget_unit_id);
        formData.append('unit_plan_id',unit_plan_id);
        formData.append('action',"updateTargetAgriPlan");

        $.ajax({
            type: "POST",
            cache: false,
            contentType: false,
            processData: false,
            dataType:'text',
            data:formData,
            url: "../handler/agriHandler.php",
            dataType: "html",
            async: true,
            success: function(data) {
                $('#editTargetAgriPlanDialog').modal('hide');
                Table.ajax.reload();
            }
        });
    });

    $('#datalistTargetAgriUnit tbody').on('click', '#removeitem', function () {
        Table = $('#datalistTargetAgriUnit').DataTable();
        var data = Table.row( $(this).parents('tr') ).data();
        var unit_plan_id = data[0];
        var formData = new FormData();
        formData.append("unit_plan_id",unit_plan_id);
        formData.append("action","deleteTargetAgri");
        if (!confirm("ต้องการลบข้อมูล :"+unit_plan_id)){
            return false;
        }else{
            $.ajax({
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data:formData,
                dataType:'text',
                url: "../handler/agriHandler.php",
                dataType: "html",
                async: true,
                success: function(data) {
                    Table.ajax.reload();
                }
             });
        }
    });

    function initTable (){
        idTypeOfArgiSearch = jQuery("#typeOfAgriSearch option:selected").val();
        idAgriSearch = $('#idAgriSearch option:selected').val();
        console.log(idTypeOfArgiSearch,":::",idAgriSearch);
        Table.destroy();
        Table = $('#datalistTargetAgriUnit').DataTable( {
            "processing": true,
            "responsive": true,
            "serverSide": true,
            "ajax": "../server_side/listTargetAgriUnitPlan.php?idTypeOfArgiSearch="+idTypeOfArgiSearch+"&idAgriSearch="+idAgriSearch,
            "type": "GET",
            "autoWidth": false,
            // "dom":'<"top"i>Brt<"bottom"lp><"clear">',
            'dom': "<'row'<'col-sm-6'Bl><'col-sm-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'bottombuttons col-sm-12'>><'row'<'col-sm-5'i><'col-sm-7'p>>",
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
                          'title': 'ข้อมูลส่งเสริมเป้าหมายการผลิต',
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
                      'title': 'ข้อมูลส่งเสริมเป้าหมายการผลิต',
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
                      'title': 'ข้อมูลส่งเสริมเป้าหมายการผลิต',
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
                      'title': 'ข้อมูลส่งเสริมเป้าหมายการผลิต',
                    },
                  ]
              }],
            'fixedColumns':   {
                'heightMatch': 'none'
            },
            'columnDefs': [{
                'targets': [0],
                "visible": false
            },{
                'targets': [4],
                'width': 100,
                'searchable': false,
                'orderable': false,
                'className': 'dt-header-center',
                'render': function (data, type, row){
                    data = '<div style=" font-size: 20px; "><center><i class=" fa fa-pencil-square-o" id="editListTargetAgriUnit" style=" cursor: pointer;margin-right: 10px; color: blue;"></i>'
                    data = data+ '<i class="ti-trash" style=" cursor: pointer; margin-right: 10px; color: red;" id="removeitem" name="removeitem"></i></div></center>';
                    data = data+ '</center></div>';
                    return data;
                }
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