(function ($) {

var id;

    $('#editCustomer').on('show.bs.modal', function (e) {
        id =$(e.relatedTarget).data('id');

        $("#editCustomer #customer_id").val(id);
        /*$("#editCustomer #status").select2(
                 { tags: true,
                  dropdownParent: $("#editCustomer")
                }
        );*/
         loadCustomer(id);
    });



    $("#editCustomer #editCustomerBtn").on("click",function(){
        editCustomerSubmit();
      });
      $('#editCustomer').on('hidden.bs.modal', function (e) {
          clearDataAdd();

      });
        $('#editCustomer #clear').on('click', function (e) {

          clearDataAdd();

      });

    function editCustomerSubmit(){

        var status = jQuery("#editCustomer #status option:selected").val();
        var customer_name = jQuery("#editCustomer #customer_name").val();
        var address = jQuery("#editCustomer #address").val();
        var phone = jQuery("#editCustomer #phone").val();
        var comment = jQuery("#editCustomer #comment").val();
        var customer_id = jQuery("#editCustomer #customer_id").val();

        var formData= new FormData();
        formData.append('name',customer_name);
        formData.append('status',status);
        formData.append('address',address);
        formData.append('phone',phone);
        formData.append('comment',comment);
        formData.append('customer_id',customer_id);
        formData.append('action',"update");
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
            $('#editCustomer').modal('toggle');
            Table.ajax.reload();
        }
      });
    }

    function clearDataAdd(){
        $('#editCustomer input[type="text"]').val('');
        $("#editCustomer #comment").val('')
        $("#editCustomer #status").val('1').trigger('change');

    }
    function loadCustomer(id){
        var formData = new FormData();
         formData.append("customer_id",id);
         formData.append("action","load");
         $.ajax({
           type: "POST",
           cache: false,
           contentType: false,
           processData: false,
           data:formData,
           dataType:'text',
           url: "../handler/customerHandler.php",
           dataType: "html",
           async: true,
           success: function(data) {
             mapData(JSON.parse(data));
           }
         });
    }


    function mapData(data){

            $("#editCustomer #status").val(data.status).trigger('change');
            $("#editCustomer #customer_name").val(data.name);
            $("#editCustomer #address").val(data.address);
            $("#editCustomer #phone").val(data.phone);
            $("#editCustomer #comment").val(data.comment);
            $("#editCustomer #customer_id").val(data.customer_id);

    }


})(jQuery);


