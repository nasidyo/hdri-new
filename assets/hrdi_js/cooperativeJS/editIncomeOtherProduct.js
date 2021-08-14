(function ($) {



    $('#editIncomeOther').on('show.bs.modal', function (e) {

        var id =$(e.relatedTarget).data('id');
        loadEditOther(id);
        $("#editIncomeOther #idArea").select2(
                 { tags: true,
                  dropdownParent: $("#addProduct")
                }
        );
        $("#editIncomeOther #unit").select2(
                { tags: true,
                  dropdownParent: $("#addProduct")
                }
        );
          $("#editIncomeOther #institute_id").select2(
                { tags: true,
                  dropdownParent: $("#addProduct")
                }
        );
      $("#editIncomeOther #idArea").change(function(){
        $.ajax({
           url: "../util/InstituteDependent.php?idArea="+$(this).val(),
           type: "GET",
           dataType: "html",
           async: false,
           success:function(data){

             $("#editIncomeOther #institute_id").append(data).trigger('change');


           }
       });

      })



      $("#editIncomeOther #addProduct").on("click",function(){
        editIncomeOtherProduct();
      });

    });


      $('#addProduct').on('hidden.bs.modal', function (e) {

        clearDataEdit();

      });


        $('#addProduct #clear').on('click', function (e) {

            clearDataEdit();

      });

    function editIncomeOtherProduct(){

    var institute_id = jQuery("#editIncomeOther #institute_id").select2('val');
    var income_detail =jQuery("#editIncomeOther #income_detail").val();
    var status =jQuery("#editIncomeOther #status option:selected").val();
    var comment = jQuery("#editIncomeOther #comment").val();
    var income_other_id =jQuery("#editIncomeOther #income_other_id").val();

    var formData= new FormData();
    formData.append('institute_id',institute_id);
    formData.append('income_other_id',income_other_id);
    formData.append('income_detail',income_detail);
    formData.append('status',status);
     formData.append('comment',comment);
     formData.append('action',"update");

    $.ajax({
        type: "POST",
        cache: false,
        contentType: false,
        processData: false,
        dataType:'text',
        data:formData,
        url: "../handler/otherIncomeHandler.php",
        dataType: "html",
        async: true,
        success: function(data) {
            $('#editIncomeOther').modal('toggle');
            Table.ajax.reload();
        }
      });
    }

    function clearDataEdit(){
         $('#editIncomeOther input[type="text"]').val('');
          $('#editIncomeOther input[type="number"]').val('');
          $("#editIncomeOther select").val('0').trigger('change');
    }

    function loadEditOther(id){
        var formData = new FormData();
         formData.append("income_other_id",id);
          formData.append("action","load");
          $.ajax({
            type: "POST",
            cache: false,
            contentType: false,
            processData: false,
            data:formData,
            dataType:'text',
            url: "../handler/otherIncomeHandler.php",
            dataType: "html",
            async: true,
            success: function(data) {
              mapData(data);
            }
          });
      }


      function mapData(data){
          var data =JSON.parse(data);
          $("#editIncomeOther #income_detail").val(data.income_detail);
            var insInfo = loadInsInfo(data.institute_id);
         $("#editIncomeOther #idRiverBasin").val(insInfo.RiverBasin_idRiverBasin).trigger("change");
          $("#editIncomeOther #idArea").val(insInfo.idArea).trigger("change");
          $("#editIncomeOther #institute_id").val(data.institute_id).trigger("change");

          $("#editIncomeOther #status").val(data.status).trigger("change");
          $("#editIncomeOther #comment").val(data.comment);
          $("#editIncomeOther #income_other_id").val(data.income_other_id);
      }

      function loadInsInfo(id){
        var result;
          $.ajax({
            type: "GET",
            cache: false,
            contentType: false,
            processData: false,
            dataType:'text',
            url: "../util/loadInstituteInfo.php?institetu_id="+id,
            dataType: "html",
            async: false,
            success: function(data) {
                result = JSON.parse(data)[0];
            }
          });

          return result;
      }


})(jQuery);


