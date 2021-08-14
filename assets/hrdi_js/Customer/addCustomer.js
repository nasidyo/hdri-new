(function ($) {



    $('#addCustomer').on('show.bs.modal', function (e) {
      /*  $("#addCustomer #status").select2(
            { tags: true,
             dropdownParent: $("#addCustomer")
           }
        );*/
    });

    $("#addCustomer #addCustomerBtn").on("click",function(){
        addCustomerSubmit();
      });



      $('#addCustomer').on('hidden.bs.modal', function (e) {

          clearDataAdd();

      });


        $('#addCustomer #clear').on('click', function (e) {

          clearDataAdd();

      });

    function addCustomerSubmit(){

    var status = jQuery("#addCustomer #status option:selected").val();
    var customer_name = jQuery("#addCustomer #customer_name").val();
    var address = jQuery("#addCustomer #address").val();
    var phone = jQuery("#addCustomer #phone").val();
    var comment = jQuery("#addCustomer #comment").val();

    var formData= new FormData();
    formData.append('name',customer_name);
    formData.append('status',status);
    formData.append('address',address);
    formData.append('phone',phone);
    formData.append('comment',comment);
    formData.append('action',"add");

    $.ajax({
        type: "POST",
        cache: false,
        contentType: false,
        processData: false,
        dataType:'text',
        data:formData,
        url: "../handler/customerHandler.php",
        dataType: "html",
        async: true,
        success: function(data) {
            $('#addCustomer').modal('toggle');
            Table.ajax.reload();
        }
      });
    }

    function clearDataAdd(){
          $('#addCustomer input[type="text"]').val('');
          $("#addCustomer #comment").val('')
          $("#addCustomer #status").val('1').trigger('change');

    }


})(jQuery);


