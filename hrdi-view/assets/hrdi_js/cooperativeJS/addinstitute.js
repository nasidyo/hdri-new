(function ($) {


     $('#addInstitute #idRiverBasin').change(function(){
        var idRiverBasin = $(this).val();
         $.ajax({
             url:"../util/AreaDependentWithRole.php",
             method:"POST",
             data:{idRiverBasin:idRiverBasin,idArea:$("#AreaAll").val()},
             dataType:"text",
             success:function(data){
                 $('#addInstitute  #idArea').html(data);
             }
         });
     });

     $('#addInstitute #idRiverBasin').trigger('change');
    $('#addInstitute #addInsituteBtn').on('click',function(){

        var name =$('#addInstitute [name="institute_name"] option:selected').val();
        var status =$('#addInstitute [name="status"] option:selected').val();
        var area =$('#addInstitute [name="idArea"] option:selected').val();
        var formData= new FormData();
        formData.append('institute_name',name);
        formData.append('area_id',area);
        formData.append('status',status);
        formData.append('action','add');
        $.ajax({
            type: "POST",
            cache: false,
            contentType: false,
            processData: false,
            dataType:'text',
            data:formData,
            url: "../handler/instituteHandler.php",
            dataType: "html",
            async: false,
            success: function(data) {
              result=data;
              $('#addInstitute').modal('toggle');
              Table.ajax.reload();
            }
          });
    });


})(jQuery);
