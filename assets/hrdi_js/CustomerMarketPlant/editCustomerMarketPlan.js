(function($) {

	var id;

	$('#editCustomerMarketPlan').on('show.bs.modal', function(e) {
		id = $(e.relatedTarget).data('id');

		$("#editCustomerMarketPlan #customer_marketplan_id").val(id);
		loadCustomerMarketPlan(id);
	});



	$("#editCustomerMarketPlan #updateCustomerMarketPlanBtn").on("click", function() {
		editCustomerMarketPlanSubmit();
	});
	$('#editCustomerMarketPlan').on('hidden.bs.modal', function(e) {
		clearDataAdd();

	});
	$('#editCustomerMarketPlan #clear').on('click', function(e) {

		clearDataAdd();

	});

	function editCustomerMarketPlanSubmit() {

		var idArea = jQuery("#editCustomerMarketPlan  #idArea option:selected").val();
		var customer_id = jQuery("#editCustomerMarketPlan  #idCustomer").val();
		var plan_Year = jQuery("#editCustomerMarketPlan  #plan_Year").val();
        var idAgri = jQuery("#editCustomerMarketPlan  #idAgri").val();
        var agri_weekplan_amount = jQuery("#editCustomerMarketPlan  #agri_weekplan_amount").val();
        var unit_id = jQuery("#editCustomerMarketPlan  #idCountUnit").val();
        var agri_spect = jQuery("#editCustomerMarketPlan  #agri_spect").val();
        var idTypeOfStand = jQuery("#editCustomerMarketPlan  #idTypeOfStand").val();
        var idLogistic = jQuery("#editCustomerMarketPlan  #logistic_id").val();
        var Refund_period = jQuery("#editCustomerMarketPlan  #Refund_period").val();


        var formData = new FormData();
		formData.append('customer_id', customer_id);
		formData.append('idArea', idArea);
        formData.append('plan_Year', plan_Year);
        formData.append('idAgri', idAgri);
        formData.append('agri_weekplan_amount', agri_weekplan_amount);

        formData.append('unit_id', unit_id);
        formData.append('agri_spect', agri_spect);
        formData.append('idTypeOfStand', idTypeOfStand);
        formData.append('idLogistic', idLogistic);
        formData.append('Refund_period', Refund_period);
		formData.append('customer_marketplan_id', id);
		formData.append('action', "update");

		$.ajax({
			type: "POST",
			cache: false,
			contentType: false,
			processData: false,
			dataType: 'text',
			data: formData,
			url: "../handler/customerMarketPlanHandler.php",
			dataType: "html",
			async: true,
			success: function(data) {
				$('#editCustomerMarketPlan').modal('toggle');
				Table.ajax.reload();
			}
		});
	}


	function clearDataAdd() {
		jQuery("#editCustomerMarketPlan select").val(jQuery("#editCustomerMarketPlan select option:first").val());
		$('#editCustomerMarketPlan #idArea').val("");
		$('#editCustomerMarketPlan #customer_id').val("");


	}
	function loadCustomerMarketPlan(id) {

		$('#editCustomerMarketPlan #idRiverBasin').trigger('change');
		var formData = new FormData();
		formData.append("CustomerMaketplan", id);
		formData.append("action", "load");
		$.ajax({
			type: "POST",
			cache: false,
			contentType: false,
			processData: false,
			data: formData,
			dataType: 'text',
			url: "../handler/customerMarketPlanHandler.php",
			dataType: "html",
			async: true,
			success: function(data) {
				mapData(JSON.parse(data));
			}
		});
	}
	function mapData(data) {
		var idRiverBasin = data.idRiverBasin;
		$('#editCustomerMarketPlan #idRiverBasin').val(idRiverBasin);
		$.ajax({
			url: "../util/AreaDependentWithRole.php",
			method: "POST",
			async: true,
			data: { idRiverBasin: idRiverBasin, "idArea": $("#AreaAll").val() },
			dataType: "text",
			success: function(data_area) {
				$('#editCustomerMarketPlan #idArea').html(data_area);
				$("#editCustomerMarketPlan #idArea").val(data.idArea).trigger('change');
			}
        });
			$.ajax({
				url: "../util/loadCustomerInArea.php",
				method: "GET",
				data: { "idArea": data.idArea },
				dataType: "text",
				success: function(data1) {
					$('#editCustomerMarketPlan #idCustomer').html(data1);
					$('#editCustomerMarketPlan #idCustomer').select2(
						{
							tags: true,
							dropdownParent: $("#editCustomerMarketPlan")
						}
					);
				}, complete: function() {
                    $("#editCustomerMarketPlan #idCustomer").val(data.idCustomer).trigger('change');
				}
            });
            $.ajax({
                url: "../util/loadAgriInArea.php",
                method: "GET",
                data: { "idArea": data.idArea },
                dataType: "text",
                success: function(data2) {
                    $('#editCustomerMarketPlan #idAgri').html(data2);
                    $('#editCustomerMarketPlan #idAgri').select2(
                        {
                            tags: true,
                            dropdownParent: $("#editCustomerMarketPlan")
                        }
                    );
                },complete:function(){
                    $("#editCustomerMarketPlan #idAgri").val(data.idAgri).trigger('change');
                }
            });
            $("#editCustomerMarketPlan #plan_Year").val(data.plan_Year);
            $("#editCustomerMarketPlan #agri_weekplan_amount").val(data.agri_weekplan_amount);
            $("#editCustomerMarketPlan #agri_spect").val(data.agri_spect);
            $("#editCustomerMarketPlan #idCountUnit").val(data.unit_id);
            $("#editCustomerMarketPlan #idTypeOfStand").val(data.idTypeOfStand);
            $("#editCustomerMarketPlan #logistic_id").val(data.idLogistic);
            $("#editCustomerMarketPlan #Refund_period").val(data.Refund_period);
	}


})(jQuery);


