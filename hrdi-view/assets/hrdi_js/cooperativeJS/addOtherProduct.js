(function ($) {



    $('#addOther').on('show.bs.modal', function (e) {

        $("#addOther #idArea").select2(
                 { tags: true,
                  dropdownParent: $("#addProduct")
                }
        );
        $("#addOther #unit").select2(
                { tags: true,
                  dropdownParent: $("#addProduct")
                }
        );
          $("#addOther #institute_id").select2(
                { tags: true,
                  dropdownParent: $("#addProduct")
                }
        );
      $("#addOther #idArea").change(function(){
        $.ajax({
           url: "../util/InstituteDependent.php?idArea="+$(this).val(),
           type: "GET",
           dataType: "html",
           async: false,
           success:function(data){

             $("#addOther #institute_id").append(data).trigger('change');


           }
       });

      })



      $("#addOther #addProduct").on("click",function(){
        addOtherProduct();
      });

    });


      $('#addProduct').on('hidden.bs.modal', function (e) {

          clearDataAdd();

      });


        $('#addProduct #clear').on('click', function (e) {

          clearDataAdd();

      });

    function addOtherProduct(){

    var institute_id = jQuery("#addOther #institute_id").select2('val');
    var expense_detail =jQuery("#addOther #expense_detail").val();
    var status =jQuery("#addOther #status option:selected").val();
    var comment = jQuery("#addOther #comment").val();

    var formData= new FormData();
    formData.append('institute_id',institute_id);
    formData.append('expense_detail',expense_detail);
    formData.append('status',status);
     formData.append('comment',comment);
     formData.append('action',"add");

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
            $('#addOther').modal('toggle');
            Table.ajax.reload();
        }
      });
    }

    function clearDataAdd(){
         $('#addOther input[type="text"]').val('');
          $('#addOther input[type="number"]').val('');
          $("#addOther select").val('0').trigger('change');
    }


})(jQuery);


