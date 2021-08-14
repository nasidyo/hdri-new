(function ($) {
    var Table= $('#years-table').DataTable();
    initTable();

    $("#createYearsTarget").click(function(){
        $('#createYearTargetDialog').modal('show');
        $('#createyear_form').trigger("reset");
    });

    $('.form_date').datepicker({
        defaultDate: null,
        format: "dd MM yyyy",
        language:  'th',
        changeMonth: true,
        changeYear: true,
        thaiyear: true,
    });

    $("#createYearBtn").click(function(){
        var data = $("#createyear_form").serialize().split("&");
        var obj={};
        for(var key in data) {
            obj[data[key].split("=")[0]] = data[key].split("=")[1];
        }
        obj.action = "addYearTarget";
        console.log(obj);
        $.ajax({
            type: "POST",
            cache: false,
            contentType: false,
            processData: false,
            data:obj,
            dataType:'text',
            url: "../handler/yearTargetHandler.php",
            dataType: "html",
            async: true,
            success: function(data) {
                $('#createYearTargetDialog').modal('hide');
                Table = $('#years-table').DataTable();
                Table.ajax.reload();
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
    

    $('#years-table tbody').on('click', '#edityearDetailBtn', function () {
        var Table= $('#years-table').DataTable();
        var data = Table.row( $(this).parents('tr') ).data();
        var yearId = data[0];
        $('#editYearTargetDialog').modal('show');
        $.ajax({
            type: "POST",
            dataType:'text',
            data:{yearId:yearId, action:"loadYearDetail"},
            url: "../handler/yearTargetHandler.php",
            dataType: "html",
            async: true,
            success: function(data) {
                console.log(data);
                mapData(JSON.parse(data));
            }
        });
    });
    function mapData(data){
        console.log("22222",data);
        $("#idYearTB_edit").val(data.yearId);
        $("#yearName_edit").val(data.yearName);
        $('#dateStart').datepicker("setDate", new Date(data.startDate) );
        $('#dateEnd').datepicker("setDate", new Date(data.endDate) );
    }

    $('#editYearBtnModal').click(function(){
        var data = $("#edityear_form").serialize().split("&");
        var obj={};
        for(var key in data) {
            obj[data[key].split("=")[0]] = data[key].split("=")[1];
        }
        obj.action = "editYearTarget";
        console.log(obj);
        $.ajax({
            type: "POST",
            dataType:'text',
            data:obj,
            url: "../handler/yearTargetHandler.php",
            dataType: "html",
            async: true,
            success: function(data) {
                $('#editYearTargetDialog').modal('hide');
                Table= $('#years-table').DataTable();
                Table.ajax.reload();
            }
        });
    });

    function initTable (){
        Table.destroy();
        Table = $('#years-table').DataTable( {
            "processing": true,
            "responsive": true,
            "serverSide": true,
            "ajax": "../server_side/yeartarget.php",
            "type": "GET",
            "autoWidth": false,
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
                    data = '<div style=" font-size: 20px; "><center>';
                    data = data+ '<i class=" fa fa-pencil-square-o" id="edityearDetailBtn" style=" cursor: pointer;margin-right: 10px; color: blue;"></i>';
                    // data = data+ '<i class="ti-trash" style=" cursor: pointer; margin-right: 10px; color: red;" id="removeitem" name="removeitem"></i></div></center>';
                    data = data+ '</center></div>';
                    return data;
                }
                }
            ],
            'order': [[0, 'desc']]
        });
    }

})(jQuery);