(function ($) {



    $('#addCustomerMarket').on('show.bs.modal', function (e) {
     $('#addCustomerMarket #idMarket').select2();
	 $('#addCustomerMarket #customer_id').select2();
	
	
	   $('#addCustomerMarket #idRiverBasin').change(function(){
        var idRiverBasin = $(this).val();
         $.ajax({
             url:"../util/AreaDependentWithRole.php",
             method:"POST",
             data:{idRiverBasin:idRiverBasin,"idArea":$("#AreaAll").val()},
             dataType:"text",
             success:function(data){
                 $('#addCustomerMarket #idArea').html(data);
             }
        	 });
    	 });

  	$('#addCustomerMarket #idMarket').change(function(){
        var Area_idArea = $('#addCustomerMarket #idArea option:selected').val();
        var idMarket =$("#addCustomerMarket #idMarket option:selected").val();
 			$('#addCustomerMarket #customer_id').html("");
			if(Area_idArea !=0 && idMarket!=0){	   
             $.ajax({
                url:"../util/loadCustomerNotRegister.php",
                method:"GET",
                data:{"idArea":Area_idArea,"idMarket":idMarket},
                dataType:"text",
                success:function(data){
                    $('#addCustomerMarket #customer_id').html(data);
                },complete:function(){
					$('#addCustomerMarket #customer_id').select2({ tags: true,
			             dropdownParent: $("#addCustomerMarket")
			           });
				}
            });
			}
         });


    });

    $("#addCustomerMarket #addCustomerMarketBtn").on("click",function(){
        addCustomerMarketSubmit();
      });



      $('#addCustomerMarket').on('hidden.bs.modal', function (e) {

          clearDataAdd();

      });


        $('#addCustomer #clear').on('click', function (e) {

          clearDataAdd();

      });

    function addCustomerMarketSubmit(){

    var idArea = jQuery("#addCustomerMarket #idArea option:selected").val();
    var customer_id = jQuery("#addCustomerMarket #customer_id").val();
    var idMarket = jQuery("#addCustomerMarket #idMarket").val();

		if(customer_id == null || customer_id == undefined){
				alert("กรุณาเลือกผู้รับซื้อ"        
				);
				return false;
		}
		   

    var formData= new FormData();
    formData.append('customer_id',customer_id);
    formData.append('idMarket',idMarket);
    formData.append('idArea',idArea);
    formData.append('action',"add");

    $.ajax({
        type: "POST",
        cache: false,
        contentType: false,
        processData: false,
        dataType:'text',
        data:formData,
        url: "../handler/customerMarketHandler.php",
        dataType: "html",
        async: true,
        success: function(data) {
            $('#addCustomerMarket').modal('toggle');
            Table.ajax.reload();
        }
      });
    }

    function clearDataAdd(){
       jQuery("#addCustomerMarket select").val(jQuery("#addCustomerMarket select option:first").val());
 		$('#addCustomerMarket #idArea').html("");
	 	$('#addCustomerMarket #customer_id').html("");

    }


})(jQuery);


