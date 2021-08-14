(function ($) {



    $('#addIncomeOther').on('show.bs.modal', function (e) {

        $("#addIncomeOther #idArea").select2(
                 { tags: true,
                  dropdownParent: $("#addIncomeOther")
                }
        );
        $("#addIncomeOther #unit").select2(
                { tags: true,
                  dropdownParent: $("#addIncomeOther")
                }
        );
          $("#addIncomeOther #institute_id").select2(
                { tags: true,
                  dropdownParent: $("#addIncomeOther")
                }
        );
    });
        $('#addIncomeOther #idRiverBasin').change(function(){
            var idRiverBasin = $(this).val();
             $.ajax({
                 url:"../util/AreaDependentWithRole.php",
                 method:"POST",
                 data:{idRiverBasin:idRiverBasin,"idArea":$("#AreaAll").val()},
                 dataType:"text",
                 success:function(data){
                     $('#addIncomeOther #idArea').html(data);
                 },complete:function(){
                    $('#addIncomeOther #idArea').trigger('change');
                 }
                 });
             });
      $("#addIncomeOther #idArea").change(function(){
        $("#addIncomeOther #institute_id").html('');
        $.ajax({
           url: "../util/InstituteDependent.php?idArea="+$(this).val(),
           type: "GET",
           dataType: "html",
           async: false,
           success:function(data){
             $("#addIncomeOther #institute_id").append(data).trigger('change');
           },complete:function(){
            $("#addIncomeOther #institute_id").trigger('change');
           }
       });

      })

      $('#addIncomeOther #idRiverBasin').trigger('change');

    $("#addIncomeOther #addProduct").on("click",function(){
        addIncomeOtherProduct();
      });


      $('#addIncomeProduct').on('hidden.bs.modal', function (e) {

          clearDataAdd();

      });


        $('#addIncomeOther #addProduct #clear').on('click', function (e) {

          clearDataAdd();

      });

    function addIncomeOtherProduct(){

    var institute_id = jQuery("#addIncomeOther #institute_id").select2('val');
    var income_detail =jQuery("#addIncomeOther #income_detail").val();
    var status =jQuery("#addIncomeOther #status option:selected").val();
    var comment = jQuery("#addIncomeOther #comment").val();

    if(institute_id=="" || institute_id == undefined){
        alert('กรุณาเลือก สถาบันเกษตรกร');
        return false;
    }

    if(income_detail=="" || income_detail == undefined){
        alert('กรุณาระบุชื่อ');
        return false;
    }


    var formData= new FormData();
    formData.append('institute_id',institute_id);
    formData.append('income_detail',income_detail);
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
        url: "../handler/otherIncomeHandler.php",
        dataType: "html",
        async: true,
        success: function(data) {
            $('#addIncomeOther').modal('toggle');
            Table.ajax.reload();
        }
      });
    }

    function clearDataAdd(){
         $('#addIncomeOther input[type="text"]').val('');
          $('#addIncomeOther input[type="number"]').val('');
          $("#addIncomeOther select").val('0').trigger('change');
    }


})(jQuery);


