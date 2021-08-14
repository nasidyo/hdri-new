(function ($) {



    $('#addPlantHouse').on('show.bs.modal', function (e) {

        $("#addPlantHouse #idArea").select2(
                 { tags: true,
                  dropdownParent: $("#addPlantHouse")
                }
        );

        $("#addPlantHouse #idRiverBasin").select2(
            { tags: true,
             dropdownParent: $("#addPlantHouse")
           }
        );

        $("#addPlantHouse #person_name").select2(
            { tags: true,
             dropdownParent: $("#addPlantHouse")
           }
        );

        $('#addPlantHouse #idRiverBasin').change(function(){
            var idRiverBasin = $(this).val();
             $.ajax({
                 url:"../util/AreaDependent.php",
                 method:"POST",
                 data:{idRiverBasin:idRiverBasin},
                 dataType:"text",
                 success:function(data){
                     $('#addPlantHouse  #idArea').html(data);
                 }
             });
         });

        $('#addPlantHouse #idArea').change(function(){
            var idArea = $(this).val();
            $('#addPlantHouse #person_name').html('');
             $.ajax({
                 url:"../util/personByAreaHasLand.php",
                 method:"POST",
                 data:{idArea:idArea},
                 dataType:"text",
                 success:function(data){
                     $('#addPlantHouse #person_name').html(data);
                 },complete:function(){
                    $("#addPlantHouse #person_name").select2();
                 }
             });
         });
         $("#addPlantHouse #idArea").trigger('change');

         $('#addPlantHouse #person_name').change(function(){
            var person_id = $(this).val();
            $('#addPlantHouse #land_id').html('');
             $.ajax({
                 url:"../util/personOwnerLand.php",
                 method:"POST",
                 data:{person_id:person_id},
                 dataType:"text",
                 success:function(data){
                     $('#addPlantHouse #land_id').html(data);
                 },complete:function(){
                    $("#addPlantHouse #land_id").select2();
                 }
             });
         });
    });

    $("#addPlantHouse #addPlantHouseBtu").on("click",function(){
        addPlantHouseSubmit();
      });



      $('#addPlantHouse').on('hidden.bs.modal', function (e) {

          clearDataAdd();

      });


        $('#addPlantHouse #clear').on('click', function (e) {

          clearDataAdd();

      });

    function addPlantHouseSubmit(){

    var idArea = jQuery("#addPlantHouse #idArea").select2('val');
    var land_id =jQuery("#addPlantHouse #land_id").select2('val');
    var house_number = jQuery("#addPlantHouse #house_number").val();


    var formData= new FormData();
    formData.append('idArea',idArea);
    formData.append('idLand',land_id);
    formData.append('house_number',house_number);
    formData.append('action',"add");

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
            $('#addPlantHouse').modal('toggle');
            Table.ajax.reload();
        }
      });
    }

    function clearDataAdd(){
          $('#addPlantHouse input[type="text"]').val('');
          $('#addPlantHouse input[type="number"]').val('');
          $("#addPlantHouse #idArea").trigger('change');
          $("#addPlantHouse #land_id").val('0').trigger('change');

    }


})(jQuery);


