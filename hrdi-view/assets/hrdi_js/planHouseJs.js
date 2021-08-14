(function ($) {
    var Table= $('#plantHouse-table').DataTable();
    initTable();
    $('#idRiverBasinSearch').select2();
    $('#idAreaSearch').select2();
    $('#idArea').select2();
    $('#person_id').select2();idArea
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
                }
            });
        }else{
            $('#idAreaSearch').html("<option value='0'>กรุณาเลือก</option>");
        }
    });

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
                }
            });
        }else{
            $('#idArea').html("<option value='0'>กรุณาเลือก</option>");
            $("#person_id").html("<option value='0'>กรุณาเลือก</option>");
        }
    });
    $('#idArea').change(function(){
        var idArea = $(this).val();
        if(idArea != '0'){
            loadPerson(idArea);
        }else{
            $("#person_id").html("<option value='0'>กรุณาเลือก</option>");
        }
    });

    function loadPerson(idArea){
        $.ajax({
            url:"../util/loadPersonFromArea.php",
            method:"POST",
            data:{idArea:idArea},
            dataType:"text",
            success:function(data){
                console.log(data);
                $("#person_id").html(data);
            }
        });
    }
    $('#person_id').change(function(){
        var person_id = $(this).val();
        if(person_id != '0'){
            loadLandDetail(person_id);
        }else{
            $("#landDetail").html("<option value='0'>กรุณาเลือก</option>");
        }
    });

    function loadLandDetail(person_Id){
        console.log(person_Id)
        $.ajax({
            url:"../util/loadLandDetail.php",
            method:"POST",
            data:{person_Id:person_Id},
            dataType:"text",
            success:function(data){
                $('#landDetail').html(data);
            }
        });
    }

    $( "#searchBtn" ).click(function() {
        initTable();
    });

    $("#addPlantHouseBtnfrom").click(function(){
        $('#addPlantHouse').modal('show');
    });
    $('#plantHouse-table tbody').on('click', '#editPlantHouseBtn', function () {
        var Table= $('#plantHouse-table').DataTable();
        var data = Table.row( $(this).parents('tr') ).data();
        var planHouseId = data[0];
        $('#editPlantHouse').modal('show');
        $.ajax({
            type: "POST",
            dataType:'text',
            data:{planHouseId:planHouseId, action:"loadPlanHouse"},
            url: "../handler/PlantHouseHandler.php",
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
        $("#plant_house_id").val(data.plantHouse_Id);
        $("#idRiverBasin_edit").val(data.idRiverBasin).trigger('change').attr('disabled', true);
        $("#house_number_edit").val(data.houseNumber);
        $.ajax({
            url:"../util/loadAreaDropdown.php",
            method:"POST",
            data:{idRiverBasin:data.idRiverBasin},
            dataType:"text",
            success:function(data2){
                console.log(data2);
                $('#idArea_edit').html(data2);
            },complete: function(data3){
                $('#idArea_edit').val(data.Area_idArea).trigger('change').attr('disabled', true);
                $.ajax({
                    url:"../util/loadPersonFromArea.php",
                    method:"POST",
                    data:{idArea:data.Area_idArea},
                    dataType:"text",
                    success:function(data4){
                        $("#person_name_edit").html(data4);
                    },complete: function(data5){
                        $('#person_name_edit').val(data.idPerson).trigger('change').attr('disabled', true);
                        $.ajax({
                            url:"../util/loadLandDetail.php",
                            method:"POST",
                            data:{person_Id:data.idPerson},
                            dataType:"text",
                            success:function(data6){
                                $('#land_id_edit').html(data6);
                                $('#land_id_edit').val(data.idLand).trigger('change');
                            }
                        });
                    }
                });
            }
        });
    }
    $('#createPlantHouseBtn').click(function(){
        Table = $('#plantHouse-table').DataTable();

        var idRiverBasin = jQuery("#createPlantHouse_form #idRiverBasin option:selected").val();
        var idArea = jQuery("#createPlantHouse_form #idArea option:selected").val();
        var person_id = jQuery("#createPlantHouse_form #person_id option:selected").val();
        var landDetail = jQuery("#createPlantHouse_form #landDetail option:selected").val();
        var house_number = jQuery("#createPlantHouse_form #house_number").val();

        if(idRiverBasin == '0' || idArea == '0' || person_id == '0' ||landDetail == '0' || house_number ==null){
            alert("กรุณากรอกข้อมูลให้ครบ" 
            );
            return false;
        }
        $('#addPlantHouse').modal('hide');
        var formData= new FormData();
        formData.append('idRiverBasin',idRiverBasin);
        formData.append('idArea',idArea);
        formData.append('landDetail',landDetail);
        formData.append('person_id',person_id);
        formData.append('house_number',house_number);
        formData.append('action',"addPlantHouse");

        $.ajax({
            type: "POST",
            cache: false,
            contentType: false,
            processData: false,
            data:formData,
            dataType:'text',
            url: "../handler/PlantHouseHandler.php",
            dataType: "html",
            async: true,
            success: function(data) {
                Table.ajax.reload();
            }
        });
    });

    $('#editPlantHouseBtnM').click(function(){
        var house_number_edit = $('#house_number_edit').val();
        var plant_house_id = jQuery("#plant_house_id").val();
        var land_id_edit = jQuery("#land_id_edit option:selected").val();
        if(land_id_edit == '0' || house_number_edit ==null){
            alert("กรุณากรอกข้อมูลให้ครบ" 
            );
            return false;
        }
        $('#addPlantHouse').modal('hide');
        var formData= new FormData();
        formData.append('house_number_edit',house_number_edit);
        formData.append('plant_house_id',plant_house_id);
        formData.append('land_id_edit',land_id_edit);
        formData.append('action',"editPlantHouse");
        $.ajax({
            type: "POST",
            cache: false,
            contentType: false,
            processData: false,
            data:formData,
            dataType:'text',
            url: "../handler/PlantHouseHandler.php",
            dataType: "html",
            async: true,
            success: function(data) {
                Table.ajax.reload();
            }
        });
    });
    $('#plantHouse-table tbody').on('click', '#removeitem', function () {
        Table = $('#plantHouse-table').DataTable();
        var data = Table.row( $(this).parents('tr') ).data();
        var plant_house_id = data[0];
        var formData = new FormData();
        formData.append("plant_house_id",plant_house_id);
        formData.append("action","deletePlantHouse");
        if (!confirm("ต้องการลบข้อมูล :"+plant_house_id)){
            return false;
        }else{
            $.ajax({
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data:formData,
                dataType:'text',
                url: "../handler/PlantHouseHandler.php",
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
        var staffPermis = $('#staffPermis').val();
        var areaAll = $('#AreaAll').val();
        Table.destroy();
        Table = $('#plantHouse-table').DataTable( {
            "processing": true,
            "responsive": true,
            "serverSide": true,
            "ajax": "../server_side/listPlanhouse.php?idRiverBasin="+idRiverBasinSearch+"&idArea="+idAreaSearch+"&areaAll="+areaAll+"&staffPermis="+staffPermis,
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
                              'columns': [0,1,2,3,4,5]
                          },
                          'title': 'ข้อมูลโรงเรือน',
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
                      'title': 'ข้อมูลโรงเรือน',
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
                      'title': 'ข้อมูลโรงเรือน',
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
                      'title': 'ข้อมูลโรงเรือน',
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
                    data = data+ '<i class=" fa fa-pencil-square-o" id="editPlantHouseBtn" style=" cursor: pointer;margin-right: 10px; color: blue;"></i>';
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