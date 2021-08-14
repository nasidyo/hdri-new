(function ($) {



    $('#addExpenseOther').on('show.bs.modal', function (e) {

        $("#addExpenseOther #idArea").select2(
                 { tags: true,
                  dropdownParent: $("#addExpenseOther")
                }
        );
        $("#addExpenseOther #unit").select2(
                { tags: true,
                  dropdownParent: $("#addExpenseOther")
                }
        );
          $("#addExpenseOther #institute_id").select2(
                { tags: true,
                  dropdownParent: $("#addExpenseOther")
                }
        );

    });
        $('#addExpenseOther #idRiverBasin').change(function(){
            var idRiverBasin = $(this).val();
             $.ajax({
                 url:"../util/AreaDependentWithRole.php",
                 method:"POST",
                 data:{idRiverBasin:idRiverBasin,"idArea":$("#AreaAll").val()},
                 dataType:"text",
                 success:function(data){
                     $('#addExpenseOther #idArea').html(data);
                 },complete:function(){
                    $('#addExpenseOther #idArea').trigger('change');
                 }
                 });
             });
      $("#addExpenseOther #idArea").change(function(){
        $("#addExpenseOther #institute_id").html('');
        $.ajax({
           url: "../util/InstituteDependent.php?idArea="+$(this).val(),
           type: "GET",
           dataType: "html",
           async: false,
           success:function(data){
             $("#addExpenseOther #institute_id").append(data);
           },complete:function(){
            $("#addExpenseOther #institute_id").trigger('change');
           }
       });

      })

      $('#addExpenseOther #idRiverBasin').trigger('change');


    $("#addExpenseOther #addProduct").on("click",function(){
        addExpenseOtherProduct();
      });


      $('#addProduct').on('hidden.bs.modal', function (e) {

          clearDataAdd();

      });


        $('#addProduct #clear').on('click', function (e) {

          clearDataAdd();

      });

    function addExpenseOtherProduct(){

    var institute_id = jQuery("#addExpenseOther #institute_id").select2('val');
    var expense_detail =jQuery("#addExpenseOther #expense_detail").val();
    var status =jQuery("#addExpenseOther #status option:selected").val();
    var comment = jQuery("#addExpenseOther #comment").val();
    if(institute_id=="" || institute_id == undefined){
        alert('กรุณาเลือก สถาบันเกษตรกร');
        return false;
    }

    if(expense_detail=="" || expense_detail == undefined){
        alert('กรุณาระบุชื่อ');
        return false;
    }

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
            $('#addExpenseOther').modal('toggle');
            Table.ajax.reload();
        }
      });
    }

    function clearDataAdd(){
         $('#addExpenseOther input[type="text"]').val('');
          $('#addExpenseOther input[type="number"]').val('');
          $("#addExpenseOther select").val('0').trigger('change');
    }


})(jQuery);


