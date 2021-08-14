(function ($) {
    var Table= $('#plantHouse-table').DataTable();
    // initTable();
    $('#idRiverBasinSearch').select2();
    $('#idAreaSearch').select2();
    $('#idpersonSearch').select2();
    $('#idArea').select2();
    $('#person_id').select2();
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
                    loadPerson(idArea);
                }
            });
        }else{
            $('#idAreaSearch').html("<option value='0'>กรุณาเลือก</option>");
        }
    });
    $('#idAreaSearch').change(function(){
        var idArea = $(this).val();
        if(idArea != '0'){
            $.ajax({
                url:"../util/loadPersonFromArea.php",
                method:"POST",
                data:{idArea:idArea},
                dataType:"text",
                success:function(data){
                    console.log(data);
                    $("#idpersonSearch").html(data);
                }
            });
        }else{
            $("#idpersonSearch").html("<option value='0'>กรุณาเลือก</option>");
        }
    });

    function loadPerson(idArea){
        $.ajax({
            url:"../util/loadPersonFromArea.php",
            method:"POST",
            data:{idArea:idArea},
            dataType:"text",
            success:function(data2){
                console.log(data2);
                $("#idpersonSearch").html(data2);
            }
        });
    }

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

    $("#createLandtoFarmBtn").click(function(){
        $('#createLandDetailDialog').modal('show');
    });

    $("#createLandDetailBtn").click(function(){
        var idRiverBasin = jQuery("#createLandDetail_form #idRiverBasin option:selected").val();
        var idArea = jQuery("#createLandDetail_form #idArea option:selected").val();
        var person_id = jQuery("#createLandDetail_form #person_id option:selected").val();
        var land_number = jQuery("#createLandDetail_form #land_number").val();
        var axisx = jQuery("#createLandDetail_form #axis-x").val();
        var axisy = jQuery("#createLandDetail_form #axis-y").val();
        var axisz = jQuery("#createLandDetail_form #axis-z").val();
        var unit1 = jQuery("#createLandDetail_form #unit1").val();
        var unit2 = jQuery("#createLandDetail_form #unit2").val();
        var unit3 = jQuery("#createLandDetail_form #unit3").val();
        var unit4 = jQuery("#createLandDetail_form #unit4").val();

        var formData= new FormData();
        formData.append('idRiverBasin',idRiverBasin);
        formData.append('idArea',idArea);
        formData.append('land_number',land_number);
        formData.append('person_id',person_id);
        formData.append('axisx',axisx);
        formData.append('axisy',axisy);
        formData.append('axisz',axisz);
        formData.append('unit1',unit1);
        formData.append('unit2',unit2);
        formData.append('unit3',unit3);
        formData.append('unit4',unit4);
        formData.append('action',"addLandDetail");

        $.ajax({
            type: "POST",
            cache: false,
            contentType: false,
            processData: false,
            data:formData,
            dataType:'text',
            url: "../handler/landDetailHandler.php",
            dataType: "html",
            async: true,
            success: function(data) {
                $('#createLandDetailDialog').modal('hide');
                $("#createLandDetail_form").trigger('reset');
                Table = $('#landDetail-table').DataTable();
                if (Table.data().any() ) {
                    Table.ajax.reload();
                }
            }
        });
    });
    $('#editLandDetailModalBtn').click(function(){
        var land_detail_id = jQuery("#editLandDetail_form #land_detail_id").val();
        var idRiverBasin = jQuery("#editLandDetail_form #idRiverBasin option:selected").val();
        var idArea = jQuery("#editLandDetail_form #idArea option:selected").val();
        var person_id = jQuery("#editLandDetail_form #person_id option:selected").val();
        var land_number = jQuery("#editLandDetail_form #land_number").val();
        var axisx = jQuery("#editLandDetail_form #axis-x").val();
        var axisy = jQuery("#editLandDetail_form #axis-y").val();
        var axisz = jQuery("#editLandDetail_form #axis-z").val();
        var unit1 = jQuery("#editLandDetail_form #unit1").val();
        var unit2 = jQuery("#editLandDetail_form #unit2").val();
        var unit3 = jQuery("#editLandDetail_form #unit3").val();
        var unit4 = jQuery("#editLandDetail_form #unit4").val();

        var formData= new FormData();
        formData.append('land_detail_id',land_detail_id);
        formData.append('idRiverBasin',idRiverBasin);
        formData.append('idArea',idArea);
        formData.append('land_number',land_number);
        formData.append('person_id',person_id);
        formData.append('axisx',axisx);
        formData.append('axisy',axisy);
        formData.append('axisz',axisz);
        formData.append('unit1',unit1);
        formData.append('unit2',unit2);
        formData.append('unit3',unit3);
        formData.append('unit4',unit4);
        formData.append('action',"updateLandDetail");

        $.ajax({
            type: "POST",
            cache: false,
            contentType: false,
            processData: false,
            data:formData,
            dataType:'text',
            url: "../handler/landDetailHandler.php",
            dataType: "html",
            async: true,
            success: function(data) {
                $('#editLandDetailDialog').modal('hide');
                Table = $('#landDetail-table').DataTable();
                Table.ajax.reload();
            }
        });
    });
    

    $('#landDetail-table tbody').on('click', '#editLandDetailBtn', function () {
        var Table= $('#landDetail-table').DataTable();
        var data = Table.row( $(this).parents('tr') ).data();
        var landDetail_id = data[0];
        $('#editLandDetailDialog').modal('show');
        $.ajax({
            type: "POST",
            dataType:'text',
            data:{landDetail_id:landDetail_id, action:"loadLandDetail"},
            url: "../handler/landDetailHandler.php",
            dataType: "html",
            async: true,
            success: function(data) {
                console.log(data);
                mapData(JSON.parse(data));
            }
        });
    });
    function mapData(data){
        $("#editLandDetail_form #land_detail_id").val(data.idLand);
        $("#editLandDetail_form #idRiverBasin").val(data.idRiverBasin).trigger('change').attr('disabled', true);
        $.ajax({
            url:"../util/loadAreaDropdown.php",
            method:"POST",
            data:{idRiverBasin:data.idRiverBasin},
            dataType:"text",
            success:function(data2){
                console.log(data2);
                $('#editLandDetail_form #idArea').html(data2);
            },complete: function(data3){
                $('#editLandDetail_form #idArea').val(data.idArea).trigger('change').attr('disabled', true);
                $.ajax({
                    url:"../util/loadPersonFromArea.php",
                    method:"POST",
                    data:{idArea:data.idArea},
                    dataType:"text",
                    success:function(data4){
                        $("#editLandDetail_form #person_id").html(data4);
                    },complete: function(data5){
                        $('#editLandDetail_form #person_id').val(data.person_id).trigger('change').attr('disabled', true);
                    }
                });
            }
        });
        $("#editLandDetail_form #land_number").val(data.land_number);
        $("#editLandDetail_form #axis-x").val(data.axisX);
        $("#editLandDetail_form #axis-y").val(data.axisY);
        $("#editLandDetail_form #axis-z").val(data.axisZ);
        $("#editLandDetail_form #unit1").val(data.unit1);
        $("#editLandDetail_form #unit2").val(data.unit2);
        $("#editLandDetail_form #unit3").val(data.unit3);
        $("#editLandDetail_form #unit4").val(data.unit4);
    }
    $('#landDetail-table tbody').on('click', '#removeitem', function () {
        Table = $('#landDetail-table').DataTable();
        var data = Table.row( $(this).parents('tr') ).data();
        var landDetail_id = data[0];
        var formData = new FormData();
        formData.append("landDetail_id",landDetail_id);
        formData.append("action","deleteLandDetail");
        if (!confirm("ต้องการลบข้อมูล :"+landDetail_id)){
            return false;
        }else{
            $.ajax({
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data:formData,
                dataType:'text',
                url: "../handler/landDetailHandler.php",
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
        var idpersonSearch = $('#idpersonSearch option:selected').val();
        var staffPermis = $('#staffPermis').val();
        var areaAll = $('#AreaAll').val();
        Table.destroy();
        Table = $('#landDetail-table').DataTable( {
            "processing": true,
            "responsive": true,
            "serverSide": true,
            "ajax": "../server_side/landDetailList.php?idRiverBasin="+idRiverBasinSearch+"&idArea="+idAreaSearch+"&areaAll="+areaAll+"&staffPermis="+staffPermis+"&idpersonSearch="+idpersonSearch,
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
                          'title': 'ข้อมูลแปลงเกษตกร',
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
                      'title': 'ข้อมูลแปลงเกษตกร',
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
                      'title': 'ข้อมูลแปลงเกษตกร',
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
                      'title': 'ข้อมูลแปลงเกษตกร',
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
                    data = data+ '<i class=" fa fa-pencil-square-o" id="editLandDetailBtn" style=" cursor: pointer;margin-right: 10px; color: blue;"></i>';
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