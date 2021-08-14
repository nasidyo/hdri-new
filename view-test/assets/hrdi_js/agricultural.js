(function ($) {
    var listSpecies = [];
    var datanumber = 0;
    var typeOfAgri_Id = $('#typeOfAgriSearch option:selected').val();
    var idTypeOfStand = $('#idTypeOfStandSearch option:selected').val();
    var Table= $('#tableAgricultural').DataTable();
    $('#contUnitId').select2();
    $('#newGradeList').select2();
    $('#editAgri_form #gradeList').select2();
    $("#speciesLis").hide();
    initTable();
    $( "#searchBtn" ).click(function() {
        typeOfAgriSearch = $('#typeOfAgriSearch option:selected').val();
        idTypeOfStandSearch = $('#idTypeOfStandSearch option:selected').val();
        initTable();
    });
    $( "#clearBtn" ).click(function() {
        $('#typeOfAgriSearch').val('0').trigger('change');
        $('#idTypeOfStandSearch').val('all').trigger('change');
        typeOfAgri_Id = $('#typeOfAgriSearch option:selected').val();
        idTypeOfStand = $('#idTypeOfStandSearch option:selected').val();
        initTable();
    });

    $('#typeOfAgri_Id').change(function(){
        var typeOfAgri_Id = $(this).val();
        $.ajax({
            url:"../util/loadCountUintFromTypeAgri.php",
            method:"POST",
            data:{typeOfAgri_Id:typeOfAgri_Id},
            dataType:"text",
            success:function(data){
                console.log(data);
                $("#contUnitId").html(data);
            }
        });
    });

    $('#tableAgricultural tbody').on('click', '#removeitem', function () {
        var spinner = $('#loader');
        spinner.show();
        Table = $('#tableAgricultural').DataTable();
        var data = Table.row( $(this).parents('tr') ).data();
        var idAgri = data[0];
        var formData = new FormData();
        formData.append("agri_id",idAgri);
        formData.append("action","delete");
        if (!confirm("ต้องการลบข้อมูลพืชรหัส : "+idAgri)){
            return false;
        }else{
            $.ajax({
                type: "POST",
                data:{idAgri:idAgri},
                dataType:'text',
                url: "../util/checkAgriDelete.php",
                success: function(data) {
                    if(data == 'Y'){
                        var conCheckDeep = confirm("พืชชนิดนี้มีการวางเป้าหมาย/ประมาณการหรือส่งมอบไว้แล้ว\nต้องการลบหรือไม่ ?");
                        if(conCheckDeep){
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
                                    spinner.hide();
                                }
                            });
                        }else{
                            spinner.hide();
                            return false;
                        }
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
                                spinner.hide();
                            }
                        });
                    }
                }
            });
        }
      });
    $('#tableAgricultural tbody').on('click', '#editAgri', function () {
        Table = $('#tableAgricultural').DataTable();
        var data = Table.row( $(this).parents('tr') ).data();
        var idAgri = data[0];
        $('#editAgriDialog').modal('show');
        var formData = new FormData();
        formData.append("agri_id",idAgri);
        formData.append("action","load");
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
                mapData(JSON.parse(data));
           }
        });
    });
    function mapData(data){
        $("#editAgri_form #typeOfAgri_Id").val(data.TypeOfArgi_idTypeOfArgi).trigger('change');
        $("#editAgri_form #agriName").val(data.nameArgi);
        $("#editAgri_form #speciesArgi").val(data.speciesArgi);
        $("#editAgri_form #idTypeOfStand").val(data.idTypeOfStand);
        $("#editAgri_form #agri_id").val(data.idAgri);
        console.log(data);
        $.ajax({
            url:"../util/loadCountUintFromTypeAgri.php",
            method:"POST",
            data:{typeOfAgri_Id:data.TypeOfArgi_idTypeOfArgi},
            dataType:"text",
            success:function(data2){
                console.log(data2);
                $("#editAgri_form #contUnitId").html(data2);
            },complete:function(data3){
                console.log(data.contUnitId);
                $("#editAgri_form #contUnitId").val(data.contUnitId).trigger('change');
            }
        });
        $.ajax({
            url:"../util/loadListSpecies.php",
            method:"POST",
            data:{agri_id:data.idAgri},
            dataType:"text",
            success:function(data4){
                console.log(data4);
                listSpeciesEdit = JSON.parse(data4);
                console.log(listSpeciesEdit);
                listSpecies = listSpeciesEdit;
                initTableSpeciesEdit(listSpecies);
            }
        });
        $.ajax({
            url:"../util/loadGradeOfAgriDropDown.php",
            method:"POST",
            data:{agri_id:data.idAgri},
            dataType:"text",
            success:function(data5){
                listGradeEdit = JSON.parse(data5);
                console.log(listGradeEdit);
                $("#editAgri_form #gradeList").val(listGradeEdit).trigger('change');
            }
        });
    }
    function initTableSpeciesEdit(listSpecies){
        $("#dashTable tbody").html("");
        var tableData="";
        if(listSpecies != "") {
            for(var i=0;i<listSpecies.length;i++){
                $("#speciesLis").show();
                console.log(listSpecies[i]);
                tableData +="<tr id="+listSpecies[i].datanumber+">";
                    tableData +='<td>'+listSpecies[i].speciesName+'</td>';
                    tableData +="<td> <button type='button' class='btn btn-danger' id='deleteSpeciesEdit' name='deleteSpeciesEdit' style='margin-right: 10px;'><i class='fa fa-minus-square-o' data-toggle='tooltip' title='ลบข้อมูลพันธุ์พืช'></i></button> </td>";
                tableData +="</tr>";
            }
            $("#dashTable tbody").html(tableData);
        }else{
            $("#speciesLis").hide();
        }
    }
    $('#dashTable tbody').on('click', '#deleteSpeciesEdit', function () {
        console.log($(this));
        var rowIndex = $(this).closest('tr').attr('id');
        console.log(rowIndex)
        var indexList = listSpecies.findIndex(item => item.datanumber == rowIndex);
        console.log(indexList)
        listSpecies.splice(indexList, 1);
        console.log(listSpecies);
        initTableSpeciesEdit(listSpecies);
        $.ajax({
            url:"../handler/agriHandler.php",
            method:"POST",
            data:{species_Id:rowIndex, action:"deleteSpecies"},
            dataType:"text",
            success:function(data4){
                console.log(data4);
            }
        });
    });
    function initTable (){
        typeOfAgri_Id = $('#typeOfAgriSearch option:selected').val();
        idTypeOfStand = $('#idTypeOfStandSearch option:selected').val();
        Table.destroy();
        Table = $('#tableAgricultural').DataTable( {
            "processing": true,
            "responsive": true,
            "serverSide": true,
            "ajax": "../server_side/agriculturalList.php?typeOfAgri_id="+typeOfAgri_Id+"&idTypeOfStand="+idTypeOfStand,
            "type": "GET",
            "autoWidth": false,
            'dom': "<'row'<'col-sm-6'Bl><'col-sm-5'f>>" +
                  "<'row'<'col-sm-12 scrolltable'tr>>" +
                  "<'row'<'bottombuttons col-sm-12'>><'row'<'col-sm-5'i><'col-sm-6'p>>",
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
                          'title': 'ข้อมูลพืชที่ได้รับการส่งเสริม',
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
                    'title': 'ข้อมูลพืชที่ได้รับการส่งเสริม',
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
                    'title': 'ข้อมูลพืชที่ได้รับการส่งเสริม',
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
                      'title': 'ข้อมูลพืชที่ได้รับการส่งเสริม',
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
                'className': 'dt-header-center',
                'render': function (data, type, row, meta){
                    var currentCell = $("#tableAgricultural").DataTable().cells({"row":meta.row, "column":meta.col}).nodes(0);
                    $.ajax({
                        url:"../util/loadGradeOfAgri.php",
                        method:"POST",
                        data:{agri_id:row[0]},
                        dataType:"text"
                    }).done(function (data) {
                        $(currentCell).text(data);
                    });
                    return null;

                }
            },{
                'targets': [6],
                'width': 100,
                'searchable': false,
                'orderable': false,
                'className': 'dt-header-center',
                'render': function (data, type, row){
                    data = '<div style=" font-size: 20px; "><center>';
                    data = data+ '<i class="fa fa-align-justify" style="cursor:pointer;margin-right: 15px; color:green;" id="viewSpecies" name="viewSpecies" data-toggle="tooltip" title="พันธุ​์พืช"></i>';
                    data = data+ '<i class=" fa fa-pencil-square-o" style="cursor:pointer;margin-right: 10px; color:blue;" id="editAgri" name="editAgri" data-toggle="tooltip" title="แก้ไขพืช"></i>';
                    data = data+ '<i class="ti-trash" style=" cursor: pointer; margin-right: 10px; color:red;" id="removeitem" name="removeitem"></i></div></center>';
                    data = data+ '</center></div>';
                    return data;
                }
                }
            ],
            'order': [[0, 'desc']]
        });
    }
    $( "#addAgriBtn" ).click(function() {
        listSpecies = [];
        datanumber = 0;
        $("#dashTable tbody").html("");
        $('#createAgriDialog').modal('show');

    });
    $("#createSpeciesBtn").click(function() {
        var typeOfAgri_Id = jQuery("#createAgri_form #typeOfAgri_Id option:selected").val();
        if(typeOfAgri_Id == 0){
            alert("กรุณากรอกข้อมูลให้ครบถ้วน");
            return false;
        }
        var agriName = jQuery("#createAgri_form #agriName").val();
        if(agriName == '' || agriName == null){
            alert("กรุณากรอกข้อมูลให้ครบถ้วน");
            return false;
        }
        var speciesArgi = jQuery("#createAgri_form #speciesArgi").val();
        if(speciesArgi == '' || speciesArgi == null){
            alert("กรุณากรอกพันธุ์พืช");
            return false;
        }
        var species = jQuery("#createAgri_form #speciesArgi").val();
        var obj={};
        obj.speciesName = species;
        obj.datanumber = datanumber;
        datanumber++;
        listSpecies.push(obj);
        console.log(listSpecies);

        $("#createAgri_form #speciesArgi").val('');
        $("#createAgri_form #typeOfAgri_Id").prop("disabled", true);
        $("#createAgri_form #idTypeOfStand").prop("disabled", true);
        $("#createAgri_form #contUnitId").prop("disabled", true);
        $("#createAgri_form #agriName").prop("disabled", true);

        initTableSpecies(listSpecies);
    });

    $("#editSpeciesBtn").click(function() {
        var typeOfAgri_Id = jQuery("#editAgri_form #typeOfAgri_Id option:selected").val();
        if(typeOfAgri_Id == 0){
            alert("กรุณากรอกข้อมูลให้ครบถ้วน");
            return false;
        }
        var agriName = jQuery("#editAgri_form #agriName").val();
        if(agriName == '' || agriName == null){
            alert("กรุณากรอกข้อมูลให้ครบถ้วน");
            return false;
        }
        var speciesArgi = jQuery("#editAgri_form #speciesArgi").val();
        if(speciesArgi == '' || speciesArgi == null){
            alert("กรุณากรอกข้อมูลให้ครบถ้วน");
            return false;
        }
        var species = jQuery("#editAgri_form #speciesArgi").val();
        var obj={};
        obj.speciesName = species;
        obj.datanumber = datanumber;
        datanumber++;
        listSpecies.push(obj);
        console.log(listSpecies);

        $("#editAgri_form #speciesArgi").val('');

        initTableSpecies(listSpecies);
    });

    function initTableSpecies(listSpecies){
        $("#dashTable tbody").html("");
        var tableData="";
        if(listSpecies != "") {
            for(var i=0;i<listSpecies.length;i++){
                $("#speciesLis").show();
                console.log(listSpecies[i]);
                tableData +="<tr id="+listSpecies[i].datanumber+">";
                    tableData +='<td>'+listSpecies[i].speciesName+'</td>';
                    tableData +="<td> <button type='button' class='btn btn-danger' id='deleteSpecies' name='deleteSpecies' style='margin-right: 10px;'><i class='fa fa-minus-square-o' data-toggle='tooltip' title='ลบข้อมูลพันธุ์พืช'></i></button> </td>";
                tableData +="</tr>";
            }
            $("#dashTable tbody").html(tableData);
        }else{
            $("#speciesLis").hide();
        }
    }
    $('#dashTable tbody').on('click', '#deleteSpecies', function () {
        console.log($(this));
        var rowIndex = $(this).closest('tr').attr('id');
        console.log(rowIndex)
        var indexList = listSpecies.findIndex(item => item.datanumber == rowIndex);
        console.log(indexList)
        listSpecies.splice(indexList, 1);
        console.log(listSpecies);
        initTableSpecies(listSpecies);
    } );
    $( "#createAgriBtn" ).click(function() {
        Table = $('#tableAgricultural').DataTable();
        var typeOfAgri_Id = jQuery("#createAgri_form #typeOfAgri_Id option:selected").val();
        var agriName = jQuery("#createAgri_form #agriName").val();
        var speciesArgi = jQuery("#createAgri_form #speciesArgi").val();
        var idTypeOfStand = jQuery("#createAgri_form #idTypeOfStand option:selected").val();
        var contUnitId = jQuery("#createAgri_form #contUnitId option:selected").val();
        var gradeList = $('#createAgri_form #newGradeList').val();
        if(gradeList == null || gradeList == undefined){
            gradeList = ['0'];
        }
        console.log(gradeList);
        if(contUnitId == '0' || contUnitId == null){
            alert('กรุณากรอกข้อมูลให้ครบถ้วน');
            return false;
        }
        $('#createAgriDialog').modal('hide');
        $.ajax({
            type: "POST",
            dataType:'text',
            data: {typeOfAgri_Id:typeOfAgri_Id, agriName:agriName, speciesArgi:speciesArgi, idTypeOfStand:idTypeOfStand, contUnitId:contUnitId, listSpecies:listSpecies, gradeList:gradeList, action:"addAgri"},
            url: "../handler/agriHandler.php",
            dataType: "html",
            async: true,
            success: function(data) {
                Table.ajax.reload();
                $("#createAgri_form").trigger("reset");
            },complete: function(){
                listSpecies = [];
            }
        });
    });

    $('#tableAgricultural tbody').on('click', '#viewSpecies', function () {
        $('#viewSpeciesDetail').modal('show');
        $("#speciesLis").hide();
        Table = $('#tableAgricultural').DataTable();
        var data = Table.row( $(this).parents('tr') ).data();
        var idAgri = data[0];
        $.ajax({
            url:"../util/loadListSpecies.php",
            method:"POST",
            data:{agri_id:idAgri},
            dataType:"text",
            success:function(data){
                console.log(data);
                listSpeciesview = JSON.parse(data);
            },complete: function(){
                $("#dashTable tbody").html("");
                var tableData="";
                if(listSpeciesview != "") {
                    for(var i=0;i<listSpeciesview.length;i++){
                        $("#speciesLis").show();
                        console.log(listSpeciesview[i]);
                        tableData +="<tr id="+listSpeciesview[i].datanumber+">";
                            tableData +='<td>'+listSpeciesview[i].speciesName+'</td>';
                        tableData +="</tr>";
                    }
                    $("#dashTable tbody").html(tableData);
                }
            }
        });
        
    });
    
    $( "#editAgriBtn" ).click(function() {
        Table = $('#tableAgricultural').DataTable();
        var typeOfAgri_Id = jQuery("#editAgri_form #typeOfAgri_Id option:selected").val();
        var agriName = jQuery("#editAgri_form #agriName").val();
        var speciesArgi = jQuery("#editAgri_form #speciesArgi").val();
        var idTypeOfStand = jQuery("#editAgri_form #idTypeOfStand option:selected").val();
        var contUnitId = jQuery("#editAgri_form #contUnitId option:selected").val();
        var agri_id = jQuery("#editAgri_form #agri_id").val();
        console.log(listSpecies);
        var formData= new FormData();
        formData.append('typeOfAgri_Id',typeOfAgri_Id);
        formData.append('agriName',agriName);
        formData.append('speciesArgi',speciesArgi);
        formData.append('idTypeOfStand',idTypeOfStand);
        formData.append('contUnitId',contUnitId);
        formData.append('agri_id',agri_id);
        formData.append('action',"update");
        var gradeList = $('#editAgri_form #gradeList').val();
        if(gradeList == null || gradeList == undefined){
            gradeList = ['0'];
        }
        if(contUnitId == '0' || contUnitId == null){
            alert('กรุณากรอกข้อมูลให้ครบถ้วน');
            return false;
        }
        console.log("gradeList:::",gradeList);
        $.ajax({
            type: "POST",
            dataType:'text',
            data:{typeOfAgri_Id:typeOfAgri_Id, agriName:agriName, speciesArgi:speciesArgi, idTypeOfStand:idTypeOfStand, contUnitId:contUnitId, agri_id:agri_id ,action:"update", listSpecies:listSpecies, gradeList:gradeList},
            url: "../handler/agriHandler.php",
            dataType: "html",
            async: true,
            success: function(data) {
                $('#editAgriDialog').modal('hide');
                Table.ajax.reload();
            }
        });
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