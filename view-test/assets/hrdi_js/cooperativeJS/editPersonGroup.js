(function ($) {
    var id =0;

    $("#editPersonGroup #idArea").select2(
        { tags: true,
         dropdownParent: $("#editPersonGroup")
       }
);


 $("#editPersonGroup #institute_id").select2(
       { tags: true,
         dropdownParent: $("#editPersonGroup")
       },
);


$('#editPersonGroup #editPersonGroupBtn').on('click', function (e) {
    editPerosonGroup();
});

    $('#editPersonGroup').on('show.bs.modal', function (e) {
        id =$(e.relatedTarget).data('id');
        $("#editPersonGroup #sub_group_id").val(id);
        loadPerosonGroup(id);




    });


      $('#editPersonGroup').on('hidden.bs.modal', function (e) {

          clearDataAdd();

      });

        $('#editPersonGroup #clear').on('click', function (e) {

          clearDataAdd();

      });



    function editPerosonGroup(){

    var institute_id = jQuery("#editPersonGroup #institute_id").select2('val');
    var sub_group_name =jQuery("#editPersonGroup #person_group_name").val();
    var status =jQuery("#editPersonGroup #status option:selected").val();
    var sub_group_id =jQuery("#editPersonGroup #sub_group_id").val();
    var formData= new FormData();
    if(sub_group_name==""){
        alert("กรุณาระบุชื่อกลุ่ม");
        return false;
    }
    formData.append('institute_id',institute_id);
    formData.append('sub_group_name',sub_group_name);
    formData.append('sub_group_id',sub_group_id);
    formData.append('status',status);

     formData.append('action',"update");

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
            $('#editPersonGroup').modal('toggle');
            Table.ajax.reload();
        }
      });
    }

    function  loadPerosonGroup(id){
        var formData= new FormData();
        formData.append('sub_group_id',id);
        formData.append('action',"load");

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
                dataMap(JSON.parse(data));
            }
          });
        }

        function dataMap(data){
            var instituteInfo ;
            jQuery("#editPersonGroup #idRiverBasin").select2().empty();
            jQuery("#editPersonGroup #idArea").select2().empty();
            jQuery("#editPersonGroup #institute_id").select2().empty();
            jQuery.ajax({
                url: "../util/loadInstituteInfo.php?institetu_id="+data.institute_id,
                type: "GET",
                dataType: "html",
                async: true,
                success:function(data){
                    instituteInfo =JSON.parse(data);
                    var $AreaOption = $("<option selected='selected'></option>").val(instituteInfo[0].idArea.toString()).text(instituteInfo[0].areaName.toString())
                    var $RiverOption = $("<option selected='selected'></option>").val(instituteInfo[0].RiverBasin_idRiverBasin.toString()).text(instituteInfo[0].nameRiverBasin.toString())
                    var $insOption = $("<option selected='selected'></option>").val(instituteInfo[0].INSTITUTE_ID.toString()).text(instituteInfo[0].INSTITUTE_NAME.toString())
                    jQuery("#editPersonGroup #idRiverBasin").append($RiverOption).trigger('change');
                    jQuery("#editPersonGroup #idArea").append($AreaOption).trigger('change');
                    jQuery("#editPersonGroup #institute_id").append($insOption).trigger('change');
                }

            });
            jQuery("#editPersonGroup #person_group_name").val(data.sub_group_name);
            jQuery("#editPersonGroup #status").val(data.status);
        }

    function clearDataAdd(){
         $('#editPersonGroup input[type="text"]').val('');
          $('#editPersonGroup input[type="number"]').val('');
          $("#editPersonGroup #institute_id").append('').trigger('change');
    }


})(jQuery);


