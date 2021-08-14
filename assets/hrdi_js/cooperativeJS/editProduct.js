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
   autocomplete( document.getElementById("editProduct").getElementsByClassName("order_name")[0], plant);

    $("#editProduct #idArea").select2(
        { tags: true,
         dropdownParent: $("#editProduct")
       }
    );

    $("#editProduct #institute_id").select2(
        { tags: true,
          dropdownParent: $("#editProduct")
        }
    );
    $("#editProduct #idArea").change(function(){
        $.ajax({
           url: "../util/InstituteDependent.php?idArea="+$(this).val(),
           type: "GET",
           dataType: "html",
           async: false,
           success:function(data){
             $("#editProduct #institute_id").append(data).trigger('change');
           }
       });
      })

      $('#editProduct #institute_id').change(function(){
        var institute_id = $(this).val();
         $.ajax({
             url:"../util/loadSubGroupbyIns.php",
             method:"POST",
             data:{institute_id:institute_id},
             dataType:"text",
             success:function(data){
                 $('#editProduct #sub_group_id').html(data);
             }
         });
     });

      $("#editProduct #idArea").trigger("change");


      $("#editProduct #updateProduct").on("click",function(){
        editProduct();
      });

    $('#editProduct').on('show.bs.modal', function (e) {
      var id =$(e.relatedTarget).data('id');
        loadProduct(id);
    });


      $('#editProduct').on('hidden.bs.modal', function (e) {

          clearData();

      });


        $('#editProduct #clear').on('click', function (e) {

          clearData();

      });

    function editProduct(){

    var institute_id = jQuery("#editProduct #institute_id").select2('val');
    var order_name =jQuery("#editProduct #order_name").val().trim();
    var balance = jQuery("#editProduct #balance").val();
    var unit = jQuery("#editProduct #unit option:selected").val();
    var status =jQuery("#editProduct #status option:selected").val();
    var order_id = jQuery("#editProduct #order_id").val();
    var comment = jQuery("#editProduct #comment").val();

    var formData= new FormData();
    formData.append('institute_id',institute_id);
    formData.append('order_name',order_name);
    formData.append('balance',balance);
    formData.append('unit_id',unit);
    formData.append('status',status);
    formData.append('order_id',order_id);
    formData.append('comment',comment);

     formData.append('action',"update");

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
            $('#editProduct').modal('toggle');
            Table.ajax.reload();
        }
      });
    }

    function clearDataAdd(){
         $('#editProduct input[type="text"]').val('');
          $('#editProduct input[type="number"]').val('');
          $("#editProduct select").val('0').trigger('change');
    }

    function loadProduct(id){
      var formData = new FormData();
       formData.append("order_id",id);
        formData.append("action","load");
        $.ajax({
          type: "POST",
          cache: false,
          contentType: false,
          processData: false,
          data:formData,
          dataType:'text',
          url: "../handler/orderHandler.php",
          dataType: "html",
          async: true,
          success: function(data) {
            mapData(data);
          }
        });
    }


    function mapData(data){
        var data =JSON.parse(data);

         $("#editProduct #idArea").val(data.area_id).trigger("change");
         $("#editProduct #institute_id").val(data.institute_id).trigger("change");
         $("#editProduct #order_name").val(data.order_name);
          $("#editProduct #order_id").val(data.order_id);
         $("#editProduct #balance").val(data.balance);
         $("#editProduct #unit").val(data.unit_id).trigger("change");
         $("#editProduct #status").val(data.status).trigger("change");
          $("#editProduct #comment").val(data.comment);
          $("#editProduct #sub_group_id").val(data.sub_group_id);


    }
       function clearData(){
           $("#editProduct #idArea").val(0).trigger("change");
         $("#editProduct #institute_id").val(0).trigger("change");
         $("#editProduct #order_name").val("");
          $("#editProduct #order_id").val("");
         $("#editProduct #balance").val("");
         $("#editProduct #unit").val("").trigger("change");
         $("#editProduct #status").val('Y').trigger("change");
          $("#editProduct #comment").val("");
       }


})(jQuery);


