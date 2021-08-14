(function ($) {

var id;

    $('#editPlantHouse').on('show.bs.modal', function (e) {
        id =$(e.relatedTarget).data('id');

        $("#editPlantHouse #plant_house_id").val(id);
        $("#editPlantHouse #idArea").select2(
                 { tags: true,
                  dropdownParent: $("#editPlantHouse")
                }
        );

        $("#editPlantHouse #idRiverBasin").select2(
            { tags: true,
             dropdownParent: $("#editPlantHouse")
           }
        );

        $("#editPlantHouse #person_name").select2(
            { tags: true,
             dropdownParent: $("#editPlantHouse")
           }
        );
        $("#editPlantHouse #idRiverBasin").trigger('change');
         $("#editPlantHouse #idArea").trigger('change');

        $('#editPlantHouse #idRiverBasin').change(function(){
            var idRiverBasin = $(this).val();
             $.ajax({
                 url:"../util/AreaDependent.php",
                 method:"POST",
                 data:{idRiverBasin:idRiverBasin},
                 dataType:"text",
                 success:function(data){
                     $('#editPlantHouse  #idArea').html(data);
                 }
             });
         });

        $('#editPlantHouse #idArea').change(function(){
            var idArea = $(this).val();
            $('#editPlantHouse #person_name').html('');
             $.ajax({
                 url:"../util/personByAreaHasLand.php",
                 method:"POST",
                 data:{idArea:idArea},
                 dataType:"text",
                 success:function(data){
                     $('#editPlantHouse #person_name').html(data);
                 },complete:function(){
                    $("#editPlantHouse #person_name").select2();
                 }
             });
         });


         $('#editPlantHouse #person_name').change(function(){
            var person_id = $(this).val();
            $('#editPlantHouse #land_id').html('');
             $.ajax({
                 url:"../util/personOwnerLand.php",
                 method:"POST",
                 data:{person_id:person_id},
                 dataType:"text",
                 success:function(data){
                     $('#editPlantHouse #land_id').html(data);
                 },complete:function(){
                    $("#editPlantHouse #land_id").select2();
                 }
             });
         });

         loadPlantHouse(id);
    });



    $("#editPlantHouse #editPlantHouseBtu").on("click",function(){
        editPlantHouseSubmit();
      });



      $('#editPlantHouse').on('hidden.bs.modal', function (e) {

          clearDataAdd();

      });


        $('#editPlantHouse #clear').on('click', function (e) {

          clearDataAdd();

      });

    function editPlantHouseSubmit(){

    var plant_house_id = jQuery("#editPlantHouse #plant_house_id").val();
    var idArea = jQuery("#editPlantHouse #idArea").select2('val');
    var land_id =jQuery("#editPlantHouse #land_id").select2('val');
    var house_number = jQuery("#editPlantHouse #house_number").val();


    var formData= new FormData();
    formData.append('idArea',idArea);
    formData.append('idLand',land_id);
    formData.append('house_number',house_number);
    formData.append('plant_house_id',plant_house_id);
    formData.append('action',"update");

    $.ajax({
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
            $('#editPlantHouse').modal('toggle');
            Table.ajax.reload();
        }
      });
    }

    function clearDataAdd(){

         /* $("#editPlantHouse #idRiverBasin").val(0).trigger('change');
          $("#editPlantHouse #idArea").val(0).trigger('change');*/
          $("#editPlantHouse #person_name").val(0).trigger('change');
          $("#editPlantHouse #land_id").val(0).trigger('change');
          $("#editPlantHouse #house_number").val('');

    }
    function loadPlantHouse(id){
        var formData = new FormData();
         formData.append("plant_house_id",id);
         formData.append("action","load");
         $.ajax({
           type: "POST",
           cache: false,
           contentType: false,
           processData: false,
           data:formData,
           dataType:'text',
           url: "../handler/plantHouseHandler.php",
           dataType: "html",
           async: true,
           success: function(data) {
             mapData(JSON.parse(data));
           }
         });
    }


    function mapData(data){
        var idRiverBasin =data.idRiverBasin;
        $("#editPlantHouse #idRiverBasin").val(data.idRiverBasin);
        $.ajax({
            url:"../util/AreaDependent.php",
            method:"POST",
            data:{idRiverBasin:idRiverBasin},
            dataType:"text",
            success:function(data_area){
                $('#editPlantHouse  #idArea').html(data_area);
            },complete:function(){
                $("#editPlantHouse #idArea").val(data.Area_idArea);
            }
        });
        var idArea = data.Area_idArea;
        $('#editPlantHouse #person_name').html('');
         $.ajax({
             url:"../util/personByAreaHasLand.php",
             method:"POST",
             data:{idArea:idArea},
             dataType:"text",
             success:function(data_person){
                 $('#editPlantHouse #person_name').html(data_person);
             },complete:function(){
                $("#editPlantHouse #person_name").select2();
                $("#editPlantHouse #person_name").val(data.idPerson).trigger('change');
             }
         });

         var person_id = data.idPerson;
            $('#editPlantHouse #land_id').html('');
             $.ajax({
                 url:"../util/personOwnerLand.php",
                 method:"POST",
                 data:{person_id:person_id},
                 dataType:"text",
                 success:function(data_land){
                     $('#editPlantHouse #land_id').html(data_land);
                 },complete:function(){
                    $("#editPlantHouse #land_id").select2();

                 }
             });
        $("#editPlantHouse #house_number").val(data.houseNumber);
    }


})(jQuery);


