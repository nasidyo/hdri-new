(function ($) {
    var Table= $('#listTargetAgri-table').DataTable();
    initTable();
    $('#typeOfAgriSearch').select2();
    $('#idAgriSearch').select2();
    $('#idRiverBasinSearch').change(function(){
        var idRiverBasin = $(this).val();
        if($('#staffPermis').val() != 'admin'){
            var idArea = $('#AreaAll').val();
         }else{
             var idArea = '';
         }
         console.log(idArea);
         $.ajax({
             url:"../util/loadAreaDropdown.php",
             method:"POST",
             data:{idRiverBasin:idRiverBasin, idArea:idArea},
             dataType:"text",
             success:function(data){
                 $('#idAreaSearch').html(data);
             },complete:function(data){
                loadTypeOfAgri();
             }
         });
    });
    function loadTypeOfAgri(){
        idAreaDropdown = $('#idAreaSearch option:selected').val();
        $.ajax({
            url:"../util/loadTypeOfAgriFromArea.php",
            method:"POST",
            data:{idArea:idAreaDropdown},
            dataType:"text",
            success:function(data){
                $('#typeOfAgriSearch').html(data);
            }
        });
    }
    $('#idAreaSearch').change(function(){
        loadTypeOfAgri();
    });

    $('#typeOfAgriSearch').change(function(){
        var typeOfAgriId = $(this).val();
        var idAreaDropdown = $('#idAreaSearch option:selected').val();
        console.log(typeOfAgriId)
        $.ajax({
            url:"../util/loadAgriProduct.php",
            method:"POST",
            data:{tpyeOfAgri_Id:typeOfAgriId, area_Id:idAreaDropdown},
            dataType:"text",
            success:function(data){
                $('#idAgriSearch').html(data);
            }
        });
    });

    $( "#searchBtn" ).click(function() {
        initTable();
    });

    $( "#clearBtn" ).click(function() {
        $('#idRiverBasinSearch').val('0').trigger('change');
        $('#idAreaSearch').val('0').trigger('change');
        $('#typeOfAgriSearch').val('all').trigger('change');
        $('#idAgriSearch').val('0').trigger('change');
        initTable();
    });

    function initTable (){
        var idRiverBasinSearch = $('#idRiverBasinSearch option:selected').val();
        var idAreaSearch = $('#idAreaSearch option:selected').val();
        var typeOfAgriSearch = $('#typeOfAgriSearch option:selected').val();
        var idAgriSearch = $('#idAgriSearch option:selected').val();
        var staffPermis = $('#staffPermis').val();
        var areaAll = $('#AreaAll').val();
        Table.destroy();
        Table = $('#listTargetAgri-table').DataTable( {
            "processing": true,
            "responsive": true,
            "serverSide": true,
            "ajax": "../server_side/listTragetAgri.php?idRiverBasin="+idRiverBasinSearch+"&idArea="+idAreaSearch+"&idTypeOfArgiSearch="+typeOfAgriSearch+"&idAgriSearch="+idAgriSearch+"&areaAll="+areaAll+"&staffPermis="+staffPermis,
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
                              'columns': [0,1,2,3,4,5]
                          },
      
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
                'targets': [6],
                'width': 100,
                'searchable': false,
                'orderable': false,
                'className': 'dt-header-center',
                'render': function (data, type, row){
                    data = '<div style=" font-size: 20px; "><center>';
                    data = data+ '<i class=" fa fa-pencil-square-o" id="editListTargetAgri" style=" cursor: pointer;margin-right: 10px; color: blue;"></i>';
                    data = data+ '<i class="ti-trash" style=" cursor: pointer; margin-right: 10px; color: red;" id="removeitem" name="removeitem"></i></div></center>';
                    data = data+ '</center></div>';
                    return data;
                }
                }
            ],
            'order': [[0, 'desc']]
        });
    }
    $( "#addTargetAgriBtn" ).click(function() {
        $('#createTargetAgriDialog').modal('show');
        $('#createTargetAgri_form').trigger("reset");
        $("#createTargetAgri_form #typeOfAgri").val('0').trigger('change');
    });
    $('#typeOfAgri').select2();
    $('#agriList').select2();
    $('#gradeList').select2();

    $('#idRiverBasin').change(function(){
        var idRiverBasin = $(this).val();
        if($('#staffPermis').val() != 'admin'){
            var idArea = $('#AreaAll').val();
        }else{
            var idArea = '';
        }
        console.log(idArea);
        $.ajax({
            url:"../util/loadAreaDropdown.php",
            method:"POST",
            data:{idRiverBasin:idRiverBasin, idArea:idArea},
            dataType:"text",
            success:function(data){
                $('#idArea').html(data);
            }
        });
    });
    $('#typeOfAgri').change(function(){
        var typeOfAgri = $(this).val();
        $.ajax({
            url:"../util/loadAgriFromType.php",
            method:"POST",
            data:{typeOfAgriId:typeOfAgri},
            dataType:"text",
            success:function(data){
                $('#agriList').html(data);
            }
        });
    });
    $('#createTargetAgriBtn').click(function(){
        
        Table = $('#listTargetAgri-table').DataTable();
        var idArea = jQuery("#createTargetAgri_form #idArea option:selected").val();
        var typeOfAgri = jQuery("#createTargetAgri_form #typeOfAgri option:selected").val();
        var agriList = $('#agriList').val();
        var gradeList = $('#gradeList').val();
        if(idArea == 0 || idArea =='' || typeOfAgri == 0){
            alert("กรุณากรอกข้อมูลให้ครบถ้วน");
            return false;
        }
        if(gradeList == null){
            gradeList = ['0'];
        }
        $('#createTargetAgriDialog').modal('hide');
        $.ajax({
            type: "POST",
            dataType:'text',
            data:{idArea:idArea, typeOfAgri:typeOfAgri, agriList:agriList, gradeList:gradeList, action:"addTargetAgri"},
            url: "../handler/agriHandler.php",
            dataType: "html",
            async: true,
            success: function(data) {
                Table.ajax.reload();
            }
        });
    });

    $('#listTargetAgri-table tbody').on('click', '#editListTargetAgri', function () {
        Table = $('#listTargetAgri-table').DataTable();
        var data = Table.row( $(this).parents('tr') ).data();
        var list_target_agri_id = data[0];
        $('#editTargetAgriDialog').modal('show');
        var formData = new FormData();
        formData.append("list_target_agri_id",list_target_agri_id);
        formData.append("action","loadTarget");
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
                console.log(data);
                mapData(JSON.parse(data));
           }
        });
    });
    function mapData(data){
        $("#editTargetAgri_form #idRiverBasin").val(data.basin_Id).trigger('change');
        if($('#staffPermis').val() != 'admin'){
            var idArea = $('#AreaAll').val();
         }else{
             var idArea = '';
         }
         console.log(idArea);
         console.log(data)
        $.ajax({
            url:"../util/loadAreaDropdown.php",
            method:"POST",
            data:{idRiverBasin:data.basin_Id, idArea:idArea},
            dataType:"text",
            success:function(data2){
                console.log(data2);
                $('#editTargetAgri_form #idArea').html(data2);
            },complete:function(data2){
                console.log(data.idArea);
                $("#editTargetAgri_form #idArea").val(data.idArea).trigger('change');
            }
        });
        $("#editTargetAgri_form #typeOfAgri").val(data.TypeOfArgi_idTypeOfArgi).trigger('change');
        $.ajax({
            url:"../util/loadAgriFromType.php",
            method:"POST",
            data:{typeOfAgriId:data.TypeOfArgi_idTypeOfArgi},
            dataType:"text",
            success:function(data3){
                $('#agri_id').html(data3);
            },complete: function (data3){
                $("#editTargetAgri_form #agri_id").val(data.idAgri).trigger('change');
            }
        });
        $("#editTargetAgri_form #gradeId").val(data.grade_Id).trigger('change');
        $("#editTargetAgri_form #list_taget_agri_Id").val(data.list_taget_agri_Id);
    }
    $('#editTargetAgriBtn').click(function(){
        $('#editTargetAgriDialog').modal('hide');
        Table = $('#listTargetAgri-table').DataTable();
        var idRiverBasin = jQuery("#editTargetAgri_form #idRiverBasin option:selected").val();
        var idArea = jQuery("#editTargetAgri_form #idArea option:selected").val();
        var typeOfAgri = jQuery("#editTargetAgri_form #typeOfAgri option:selected").val();
        var agri_id = jQuery("#editTargetAgri_form #agri_id option:selected").val();
        var gradeId = jQuery("#editTargetAgri_form #gradeId option:selected").val();
        var list_taget_agri_Id = jQuery("#editTargetAgri_form #list_taget_agri_Id").val();

        var formData= new FormData();
        formData.append('idRiverBasin',idRiverBasin);
        formData.append('idArea',idArea);
        formData.append('typeOfAgri',typeOfAgri);
        formData.append('agri_id',agri_id);
        formData.append('gradeId',gradeId);
        formData.append('list_taget_agri_Id',list_taget_agri_Id);
        formData.append('action',"updateTargetAgri");

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
                $('#editTargetAgriDialog').modal('hide');
                Table.ajax.reload();
            }
        });
    });
    $('#listTargetAgri-table tbody').on('click', '#removeitem', function () {
        Table = $('#listTargetAgri-table').DataTable();
        var data = Table.row( $(this).parents('tr') ).data();
        var list_target_agri_id = data[0];
        var formData = new FormData();
        formData.append("list_target_agri_id",list_target_agri_id);
        formData.append("action","deleteTargetAgri");
        if (!confirm("ต้องการลบข้อมูล :"+list_target_agri_id)){
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