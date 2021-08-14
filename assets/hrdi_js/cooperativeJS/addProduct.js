(function ($) {

    var plant = [];
 $.ajax({
    url: "../util/auto/autoAgri.php",
    type: "GET",
    dataType: "html",
    async: false,
    success:function(data){
        plant = JSON.parse(data);
    }
});

autocomplete( document.getElementById("addProduct").getElementsByClassName("order_name")[0], plant);


    $("#addProduct #idArea").select2(
        { tags: true,
         dropdownParent: $("#addProduct")
       }
        );

        $("#addProduct #institute_id").select2(
            { tags: true,
                dropdownParent: $("#addProduct")
            }
        );

        $('#addProduct #idRiverBasin').change(function(){
            var idRiverBasin = $(this).val();
             $.ajax({
                 url:"../util/AreaDependent.php",
                 method:"POST",
                 data:{idRiverBasin:idRiverBasin},
                 dataType:"text",
                 success:function(data){
                     $('#addProduct #idArea').html(data);
                 }
             });
         });
      $("#addProduct #idArea").change(function(){
        $("#addProduct #institute_id").html('');
        $.ajax({
           url: "../util/InstituteDependent.php?idArea="+$(this).val(),
           type: "GET",
           dataType: "html",
           async: false,
           success:function(data){

             $("#addProduct #institute_id").append(data).trigger('change');

           }
       });

      });

      $('#addProduct #institute_id').change(function(){
        var institute_id = $(this).val();
        $('#addProduct #sub_group_id').html('');
         $.ajax({
             url:"../util/loadSubGroupbyIns.php",
             method:"POST",
             data:{institute_id:institute_id},
             dataType:"text",
             success:function(data){
                 $('#addProduct #sub_group_id').html(data);
             }
         });
     });
      $("#addProduct #idArea").trigger("change");


      $("#addProduct #addProduct").on("click",function(){
        addProduct();
      });



      $('#addProduct').on('hidden.bs.modal', function (e) {

          clearDataAdd();

      });


        $('#addProduct #clear').on('click', function (e) {

          clearDataAdd();

      });

    function addProduct(){

    var institute_id = jQuery("#addProduct #institute_id option:selected").val();
    var order_name =jQuery("#addProduct #order_name").val().trim();
    var balance = jQuery("#addProduct #balance").val();
    var unit = jQuery("#addProduct #unit option:selected").val();
    var status =jQuery("#addProduct #status option:selected").val();
    var comment = jQuery("#addProduct #comment").val();
    var sub_group_id = jQuery("#addProduct #sub_group_id").val();
    var formData= new FormData();
    formData.append('institute_id',institute_id);
    formData.append('order_name',order_name);
    formData.append('balance',balance);
    formData.append('unit_id',unit);
    formData.append('status',status);
     formData.append('comment',comment);
     formData.append('sub_group_id',sub_group_id);
     formData.append('action',"add");

    $.ajax({
        type: "POST",
        cache: false,
        contentType: false,
        processData: false,
        dataType:'text',
        data:formData,
        url: "../handler/orderHandler.php",
        dataType: "html",
        async: true,
        success: function(data) {
            $('#addProduct').modal('toggle');
            Table.ajax.reload();
        }
      });
    }

    function clearDataAdd(){
         $('#addProduct input[type="text"]').val('');
          $('#addProduct input[type="number"]').val('');
          $("#addProduct select").val('0').trigger('change');
    }


})(jQuery);


