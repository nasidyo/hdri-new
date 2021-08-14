(function ($) {



    $('#editOther').on('show.bs.modal', function (e) {

        var id =$(e.relatedTarget).data('id');
        loadEditOther(id);
        $("#editOther #idArea").select2(
                 { tags: true,
                  dropdownParent: $("#addProduct")
                }
        );
        $("#editOther #unit").select2(
                { tags: true,
                  dropdownParent: $("#addProduct")
                }
        );
          $("#editOther #institute_id").select2(
                { tags: true,
                  dropdownParent: $("#addProduct")
                }
        );
      $("#editOther #idArea").change(function(){
        $.ajax({
           url: "../util/InstituteDependent.php?idArea="+$(this).val(),
           type: "GET",
           dataType: "html",
           async: false,
           success:function(data){

             $("#editOther #institute_id").append(data).trigger('change');


           }
       });

      })



      $("#editOther #addProduct").on("click",function(){
        editOtherProduct();
      });

    });


      $('#addProduct').on('hidden.bs.modal', function (e) {

        clearDataEdit();

      });


        $('#addProduct #clear').on('click', function (e) {

            clearDataEdit();

      });

    function editOtherProduct(){

    var institute_id = jQuery("#editOther #institute_id").select2('val');
    var expense_detail =jQuery("#editOther #expense_detail").val();
    var status =jQuery("#editOther #status option:selected").val();
    var comment = jQuery("#editOther #comment").val();
    var expense_other_id =jQuery("#editOther #expense_other_id").val();

    var formData= new FormData();
    formData.append('institute_id',institute_id);
    formData.append('expense_other_id',expense_other_id);
    formData.append('expense_detail',expense_detail);
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
        url: "../handler/otherExpenseHandler.php",
        dataType: "html",
        async: true,
        success: function(data) {
            $('#editOther').modal('toggle');
            Table.ajax.reload();
        }
      });
    }

    function clearDataEdit(){
         $('#editOther input[type="text"]').val('');
          $('#editOther input[type="number"]').val('');
          $("#editOther select").val('0').trigger('change');
    }

    function loadEditOther(id){
        var formData = new FormData();
         formData.append("expense_other_id",id);
          formData.append("action","load");
          $.ajax({
            type: "POST",
            cache: false,
            contentType: false,
            processData: false,
            data:formData,
            dataType:'text',
            url: "../handler/otherExpenseHandler.php",
            dataType: "html",
            async: true,
            success: function(data) {
              mapData(data);
            }
          });
      }


      function mapData(data){
          var data =JSON.parse(data);
          $("#editOther #expense_detail").val(data.expense_detail);
            var insInfo = loadInsInfo(data.institute_id);
         $("#editOther #idRiverBasin").val(insInfo.RiverBasin_idRiverBasin).trigger("change");
          $("#editOther #idArea").val(insInfo.idArea).trigger("change");
          $("#editOther #institute_id").val(data.institute_id).trigger("change");

          $("#editOther #status").val(data.status).trigger("change");
          $("#editOther #comment").val(data.comment);
          $("#editOther #expense_other_id").val(data.expense_other_id);
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


