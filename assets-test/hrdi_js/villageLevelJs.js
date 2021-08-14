(function ($) {
    var Table= $('#villageLevel-table').DataTable();
    $('#idRiverBasinSearch').select2();
    $('#idAreaSearch').select2();
    $('#village_id').select2();
    initTable();
    $('#idRiverBasinSearch').change(function(){
        var idRiverBasin = $(this).val();
        if($('#staffPermis').val() != 'admin'){
            var idArea = $('#AreaAll').val();
        }else{
             var idArea = '';
        }
        console.log(idArea);
        if(idRiverBasin != '0'){
            $.ajax({
                url:"../util/loadAreaDropdown.php",
                method:"POST",
                data:{idRiverBasin:idRiverBasin, idArea:idArea},
                dataType:"text",
                success:function(data){
                    $('#idAreaSearch').html(data);
                },complete: function(data){
                    var idArea = jQuery("#idAreaSearch option:selected").val();
                    $("#village_id").html("<option value='0'>กรุณาเลือก</option>");
                }
            });
        }else{
            $('#idAreaSearch').html("<option value='0'>กรุณาเลือก</option>");
        }
    });
    $('#idAreaSearch').change(function(){
        var idRiverBasinSearch = jQuery("#idRiverBasinSearch option:selected").val();
        var idArea = $(this).val();
        if(idArea != '0'){
            $.ajax({
                url:"../util/loadGroupVillage.php",
                method:"GET",
                data:{"idRiverBasin":idRiverBasinSearch,"idArea":idArea},
                dataType:"text",
                success:function(data){
                    $('#village_id').html(data);
                }
            });
        }else{
            $("#village_id").html("<option value='0'>กรุณาเลือก</option>");
        }
    });
    $( "#searchBtn" ).click(function() {
        initTable();
    });
    $('#createVillageLevelBtn').click(function(){
        $('#createVillageLevelDialog').modal('show');
    });
    $('#idRiverBasin').select2();
    $('#idArea').select2();
    $('#villageIdlist').select2();
    $('#idRiverBasin').change(function(){
        var idRiverBasin = $(this).val();
        if($('#staffPermis').val() != 'admin'){
            var idArea = $('#AreaAll').val();
        }else{
             var idArea = '';
        }
        console.log(idArea);
        if(idRiverBasin != '0'){
            $.ajax({
                url:"../util/loadAreaDropdown.php",
                method:"POST",
                data:{idRiverBasin:idRiverBasin, idArea:idArea},
                dataType:"text",
                success:function(data){
                    $('#idArea').html(data);
                },complete: function(data){
                    var idArea = jQuery("#idArea option:selected").val();
                }
            });
        }else{
            $('#idArea').html("<option value='0'>กรุณาเลือก</option>");
        }
    });
    $('#idArea').change(function(){
        var idRiverBasin = jQuery("#idRiverBasin option:selected").val();
        var idArea = $(this).val();
        if(idArea != '0'){
            $.ajax({
                url:"../util/loadGroupVillage.php",
                method:"GET",
                data:{"idRiverBasin":idRiverBasin,"idArea":idArea},
                dataType:"text",
                success:function(data){
                    $('#villageIdlist').html(data);
                }
            });
        }
    });

    $('#createVillageModalBtn').click(function(){
        var idArea = jQuery("#createVillageLevel_form #idArea option:selected").val();
        var levelNew = jQuery("#createVillageLevel_form #levelNew option:selected").val();
        var villageIdlist = $("#createVillageLevel_form #villageIdlist").val();
        console.log(villageIdlist);
        $('#createVillageLevelDialog').modal('hide');
        Table = $('#villageLevel-table').DataTable();
        $.ajax({
            type: "POST",
            dataType:'text',
            data:{idArea:idArea, levelNew:levelNew, villageIdlist:villageIdlist, action:"addVillageLevel"},
            url: "../handler/villageLevelHandler.php",
            dataType: "html",
            async: true,
            success: function(data) {
                Table.ajax.reload();
            }
        });
    });

    $('#villageLevel-table tbody').on('click', '#editVillageBtn', function () {
        Table = $('#villageLevel-table').DataTable();
        var data = Table.row( $(this).parents('tr') ).data();
        var list_vill_level_id = data[0];
        $('#editVillageLevelDialog').modal('show');
        var formData = new FormData();
        formData.append("list_vill_level_id",list_vill_level_id);
        formData.append("action","loadvillageDetail");
        $.ajax({
           type: "POST",
           cache: false,
           contentType: false,
           processData: false,
           data:formData,
           dataType:'text',
           url: "../handler/villageLevelHandler.php",
           dataType: "html",
           async: true,
           success: function(data) {
                console.log(data);
                mapData(JSON.parse(data));
           }
        });
    });
    function mapData(data){
        $('#editVillageLevel_form #list_vill_level_id').val(data.list_vill_level_id);
        $("#editVillageLevel_form #idRiverBasin").val(data.idRiverBasin).trigger('change').attr('disabled', true);
        $("#editVillageLevel_form #levelNew").val(data.level).trigger('change');
        if($('#staffPermis').val() != 'admin'){
            var idArea = $('#AreaAll').val();
         }else{
             var idArea = '';
         }
        $.ajax({
            url:"../util/loadAreaDropdown.php",
            method:"POST",
            data:{idRiverBasin:data.idRiverBasin, idArea:idArea},
            dataType:"text",
            success:function(data2){
                console.log(data2);
                $('#editVillageLevel_form #idArea').html(data2);
            },complete:function(data2){
                $("#editVillageLevel_form #idArea").val(data.idArea).trigger('change').attr('disabled', true);
                $.ajax({
                    url:"../util/loadGroupVillage.php",
                    method:"GET",
                    data:{"idRiverBasin":data.idRiverBasin,"idArea":data.idArea},
                    dataType:"text",
                    success:function(data4){
                        $('#editVillageLevel_form #villageId').html(data4);
                    },complete:function(data5){
                        $("#editVillageLevel_form #villageId").val(data.idGroupVillage).trigger('change').attr('disabled', true);
                    }
                });
            }
        });
    }

    $('#editVillageModalBtn').click(function(){
        var list_vill_level_id = jQuery("#editVillageLevel_form #list_vill_level_id").val();
        var levelVillage = $("#editVillageLevel_form #levelNew").val();
        $('#editVillageLevelDialog').modal('hide');
        Table = $('#villageLevel-table').DataTable();
        var formData = new FormData();
        formData.append("list_vill_level_id",list_vill_level_id);
        formData.append("levelVillage",levelVillage);
        formData.append("action","updatevillageDetail");
        $.ajax({
            type: "POST",
            cache: false,
            contentType: false,
            processData: false,
            data:formData,
            dataType:'text',
            url: "../handler/villageLevelHandler.php",
            dataType: "html",
            async: true,
            success: function(data) {
                console.log(data);
                Table.ajax.reload();
            }
         });
    });

    $('#villageLevel-table tbody').on('click', '#removeitem', function () {
        Table = $('#villageLevel-table').DataTable();
        var data = Table.row( $(this).parents('tr') ).data();
        var list_vill_level_id = data[0];
        var formData = new FormData();
        formData.append("list_vill_level_id",list_vill_level_id);
        formData.append("action","delevillageDetail");
        if (!confirm("ต้องการลบข้อมูล :"+list_vill_level_id)){
            return false;
        }else{
            $.ajax({
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data:formData,
                dataType:'text',
                url: "../handler/villageLevelHandler.php",
                dataType: "html",
                async: true,
                success: function(data) {
                    Table.ajax.reload();
                }
             });
        }
    });

    function initTable (){
        var idRiverBasinSearch = $('#idRiverBasinSearch option:selected').val();
        var idAreaSearch = $('#idAreaSearch option:selected').val();
        var village_id = $('#village_id option:selected').val();
        var level = $('#level option:selected').val();
        var staffPermis = $('#staffPermis').val();
        var areaAll = $('#AreaAll').val();
        Table.destroy();
        Table = $('#villageLevel-table').DataTable( {
            "processing": true,
            "responsive": true,
            "serverSide": true,
            "ajax": "../server_side/villageLvealList.php?idRiverBasin="+idRiverBasinSearch+"&idArea="+idAreaSearch+"&areaAll="+areaAll+"&staffPermis="+staffPermis+"&village_id="+village_id+"&level="+level,
            "type": "GET",
            "autoWidth": false,
            'dom': "<'row'<'col-sm-6'Bl><'col-sm-5'f>>" +
                  "<'row'<'col-sm-11 scrolltable'tr>>" +
                  "<'row'<'bottombuttons col-sm-11'>><'row'<'col-sm-5'i><'col-sm-6'p>>",
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
                              'columns': [0,1,2,3,4]
                          },
                          'title': 'ข้อมูลมาตราฐานของหมู่บ้าน',
                    },
      
                    { 'extend':'csv',
                    'action':newexportaction ,
                    'exportOptions': {
                      'modifier': {
                        'page': 'All',
                        'search': 'none'
                        },
                        'columns': [0,1,2,3,4]
                      },
                      'title': 'ข้อมูลมาตราฐานของหมู่บ้าน',
                    },
      
                    { 'extend':'excel',
                    'action':newexportaction ,
                    'exportOptions': {
                      'modifier': {
                        'page': 'All',
                        'search': 'none'
                        },
                        'columns': [0,1,2,3,4]
                      },
                      'title': 'ข้อมูลมาตราฐานของหมู่บ้าน',
                    },
                    { 'extend':'print',
                    'action':newexportaction ,
                    'exportOptions': {
                      'modifier': {
                        'page': 'ALL',
                        'search': 'none'
                        },
                        'columns': [0,1,2,3,4]
                      },
                      'title': 'ข้อมูลมาตราฐานของหมู่บ้าน',
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
                'targets': [5],
                'width': 100,
                'searchable': false,
                'orderable': false,
                'className': 'dt-header-center',
                'render': function (data, type, row){
                    data = '<div style=" font-size: 20px; "><center>';
                    data = data+ '<i class=" fa fa-pencil-square-o" id="editVillageBtn" style=" cursor: pointer;margin-right: 10px; color: blue;"></i>';
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