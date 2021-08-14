(function ($) {



    $('#editExpenseOther').on('show.bs.modal', function (e) {

        var id =$(e.relatedTarget).data('id');
        loadEditOther(id);
        $("#editExpenseOther #idArea").select2(
                 { tags: true,
                  dropdownParent: $("#addProduct")
                }
        );
        $("#editExpenseOther #unit").select2(
                { tags: true,
                  dropdownParent: $("#addProduct")
                }
        );
          $("#editExpenseOther #institute_id").select2(
                { tags: true,
                  dropdownParent: $("#addProduct")
                }
        );
      $("#editExpenseOther #idArea").change(function(){
        $.ajax({
           url: "../util/InstituteDependent.php?idArea="+$(this).val(),
           type: "GET",
           dataType: "html",
           async: false,
           success:function(data){

             $("#editExpenseOther #institute_id").append(data).trigger('change');


           }
       });

      })



      $("#editExpenseOther #addProduct").on("click",function(){
        editExpenseOtherProduct();
      });

    });


      $('#addProduct').on('hidden.bs.modal', function (e) {

        clearDataEdit();

      });


        $('#addProduct #clear').on('click', function (e) {

            clearDataEdit();

      });

    function editExpenseOtherProduct(){

    var institute_id = jQuery("#editExpenseOther #institute_id").select2('val');
    var expense_detail =jQuery("#editExpenseOther #expense_detail").val();
    var status =jQuery("#editExpenseOther #status option:selected").val();
    var comment = jQuery("#editExpenseOther #comment").val();
    var expense_other_id =jQuery("#editExpenseOther #expense_other_id").val();

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
            $('#editExpenseOther').modal('toggle');
            Table.ajax.reload();
        }
      });
    }

    function clearDataEdit(){
         $('#editExpenseOther input[type="text"]').val('');
          $('#editExpenseOther input[type="number"]').val('');
          $("#editExpenseOther select").val('0').trigger('change');
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
          $("#editExpenseOther #expense_detail").val(data.expense_detail);
            var insInfo = loadInsInfo(data.institute_id);
         $("#editExpenseOther #idRiverBasin").val(insInfo.RiverBasin_idRiverBasin).trigger("change");
          $("#editExpenseOther #idArea").val(insInfo.idArea).trigger("change");
          $("#editExpenseOther #institute_id").val(data.institute_id).trigger("change");

          $("#editExpenseOther #status").val(data.status).trigger("change");
          $("#editExpenseOther #comment").val(data.comment);
          $("#editExpenseOther #expense_other_id").val(data.expense_other_id);
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


