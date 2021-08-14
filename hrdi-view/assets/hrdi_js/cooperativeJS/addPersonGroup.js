(function ($) {



    $("#addPersonGroup #idArea").select2(
        { tags: true,
         dropdownParent: $("#addPersonGroup")
       }
        );


        $("#addPersonGroup #institute_id").select2(
            { tags: true,
                dropdownParent: $("#addPersonGroup")
            },
        );


        $('#addPersonGroup #addPersonGroup').on('click', function (e) {
        addPerosonGroup();
        });


      $('#addPersonGroup').on('hidden.bs.modal', function (e) {

          clearDataAdd();

          $("#addPersonGroup #idArea").unbind('change');
          $('#addPersonGroup #idRiverBasin').unbind('change');

      });

      $('#addPersonGroup').on('show.bs.modal', function (e) {
        $('#addPersonGroup #idRiverBasin').trigger('change');
        $("#addPersonGroup #idArea").trigger('change');

    });




        $('#addPersonGroup #clear').on('click', function (e) {

          clearDataAdd();

      });

      $('#addPersonGroup #idRiverBasin').change(function(){
        var idRiverBasin = $(this).val();
         $.ajax({
             url:"../util/AreaDependentWithRole.php",
             method:"POST",
             data:{idRiverBasin:idRiverBasin,idArea:$("#AreaAll").val()},
             dataType:"text",
             success:function(data){
                 $('#addPersonGroup #idArea').html(data);
             }
         });
     });
  $("#addPersonGroup #idArea").change(function(){
    $("#addPersonGroup #institute_id").html('');
    $.ajax({
       url: "../util/InstituteDependent.php?idArea="+$(this).val(),
       type: "GET",
       dataType: "html",
       async: false,
       success:function(data){

         $("#addPersonGroup #institute_id").append(data).trigger('change');

       }
   });

  });


  $('#addPersonGroup #institute_id').change(function(){
    var institute_id = $(this).val();
     $.ajax({
         url:"../util/loadSubGroupbyIns.php",
         method:"POST",
         data:{institute_id:institute_id},
         dataType:"text",
         success:function(data){
             $('#addPersonGroup #sub_group_id').html(data);
         }
     });
 });

    function addPerosonGroup(){

    var institute_id = jQuery("#addPersonGroup #institute_id option:selected").val();
    var sub_group_name =jQuery("#addPersonGroup #person_group_name").val();
    var formData= new FormData();

    if(sub_group_name==""){
        alert("กรุณาระบุชื่อกลุ่ม");
        return false;
    }
    formData.append('institute_id',institute_id);
    formData.append('sub_group_name',sub_group_name);
    formData.append('status',"Y");

     formData.append('action',"add");

    $.ajax({
        type: "POST",
        cache: false,
        contentType: false,
        processData: false,
        dataType:'text',
        data:formData,
        url: "../handler/subPersonGroupHandler.php",
        dataType: "html",
        async: true,
        success: function(data) {
            $('#addPersonGroup').modal('toggle');
            Table.ajax.reload();
        }
      });
    }

    function clearDataAdd(){
         $('#addPersonGroup input[type="text"]').val('');
          $('#addPersonGroup input[type="number"]').val('');
          $("#addPersonGroup #institute_id").append('').trigger('change');
    }


})(jQuery);


