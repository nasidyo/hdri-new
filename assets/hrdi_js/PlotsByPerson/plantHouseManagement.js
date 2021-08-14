var Table;
(function ($) {


    $("#criteria #idRiverBasin").select2();
    $("#criteria #idArea").select2();

    $('#criteria #search_plant_house').on('click',function(){
        search();
    });
    $('#criteria #clear_plant_house').on('click',function(){
        clear();
    });

    $('#').on('click',function(){
        alert();
    });

    $('#plantHouseTable tbody').on( 'click', '#deleditPlantHouseBtn', function () {
        var  id =$(this).data('id');
        delPlantHouse(id);
     });




    $('#criteria #idArea').change(function(){
        var idArea = $(this).val();
        $('#criteria #person_name').html('');
         $.ajax({
             url:"../util/personByAreaHasLand.php",
             method:"POST",
             data:{idArea:idArea},
             dataType:"text",
             success:function(data){
                 $('#criteria #person_name').html(data);
             },complete:function(){
                $("#criteria #person_name").select2();
             }
         });
     });
     $("#criteria #idArea").trigger('change');
     $("#criteria #person_name").select2();

    Table = $('#plantHouseTable').DataTable({
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
        dom: '<"top">r<tl><"bottom"ip><"clear">',
        pageLength: 10,
        processing: true,
        responsive: true,
        serverSide: true,
        ajax: {url:"../server_side/plantHouseSS.php?idRiverBasin="+$("#idRiverBasin").val()+"&idArea="+$("#idArea").val()+"&name="+$("institute_name").val(),"type": "GET"},
        order: [[ 0, "desc" ]],
        columnDefs: [{
                        'targets': [5],
                        'width': 70,
                        'searchable': false,
                        'orderable': false,
                        'className': 'dt-header-center',
                        'render': function (data, type, full, meta){
                            return '<div style=" font-size: 20px; "  ><i class="fa fa-edit" style=" cursor: pointer;margin-right: 10px;" data-toggle="modal" data-target="#editPlantHouse" data-id="'+full[0]+'" id="editPlantHouseBtn"></i>        <i class="fa fa-times" style="cursor: pointer;color: red;" id="deleditPlantHouseBtn"  data-id="'+full[0]+'"></i></div>';
                        }
                    },
                    {
                        "targets": [0],
                        "visible": true,
                        "searchable": false
                    }

                ]
    });


    function search(){
        Table.destroy();
        Table = $('#plantHouseTable').DataTable({
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
            dom: '<"top">r<tl><"bottom"ip><"clear">',
            pageLength: 10,
            processing: true,
            responsive: true,
            serverSide: true,
            ajax: {url:"../server_side/plantHouseSS.php?idRiverBasin="+$("#criteria #idRiverBasin").val()+"&idArea="+$("#criteria #idArea").val()+"&person_id="+$("#criteria #person_name").select2('val'),"type": "GET"},
            order: [[ 0, "desc" ]],
            columnDefs: [{
                            'targets': [5],
                            'width': 70,
                            'searchable': false,
                            'orderable': false,
                            'className': 'dt-header-center',
                            'render': function (data, type, full, meta){
                                return '<div style=" font-size: 20px; "  ><i class="fa fa-edit" style=" cursor: pointer;margin-right: 10px;" data-toggle="modal" data-target="#editPlantHouse" data-id="'+full[0]+'" id="editPlantHouseBtn"></i>        <i class="fa fa-times" style="cursor: pointer;color: red;" id="deleditPlantHouseBtn"  data-id="'+full[0]+'"></i></div>';
                            }
                        },
                        {
                            "targets": [0],
                            "visible": true,
                            "searchable": false
                        }

                    ]
        });
        $("#criteria #person_name").select2();

    }
    function clear(){
        jQuery("#criteria #person_name").val('0').trigger('change');
        jQuery("#criteria #idArea").val('0').trigger('change');
        jQuery("#criteria #idRiverBasin").val('0').trigger('change');
        search();
    }

function delPlantHouse(id){

    if (!confirm(" ต้องการลบข้อมูล ")){
       return false;
     }

    var formData= new FormData();
    formData.append('plant_house_id',id);
    formData.append('action',"delete");

    jQuery.ajax({
        type: "POST",
        cache: false,
        contentType: false,
        processData: false,
        dataType:'text',
        data:formData,
        url: "../handler/plantHouseHandler.php",
        dataType: "html",
        async: true,
        success: function(data) {
            Table.ajax.reload();
        }
      });

}


})(jQuery);
