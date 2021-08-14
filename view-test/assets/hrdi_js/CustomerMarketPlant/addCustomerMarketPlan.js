(function($) {



	$('#addCustomerMarketPlan').on('show.bs.modal', function(e) {


		$('#addCustomerMarketPlan #idRiverBasin').change(function() {
			var idRiverBasin = $(this).val();
			if (idRiverBasin == 0) {
				idRiverBasin = $("#RBAll").val();
			}
			$.ajax({
				url: "../util/AreaDependentWithRole.php",
				method: "POST",
				data: { idRiverBasin: idRiverBasin, "idArea": $("#AreaAll").val() },
				dataType: "text",
				success: function(data) {
					$('#addCustomerMarketPlan #idArea').html(data);
				}
			});
		});

		$('#addCustomerMarketPlan #idArea').change(function() {
			var idArea = $(this).val();

			$.ajax({
				url: "../util/loadCustomerInArea.php",
				method: "GET",
				data: { "idArea": idArea },
				dataType: "text",
				success: function(data) {
					$('#addCustomerMarketPlan #idCustomer').html(data);
					$('#addCustomerMarketPlan #idCustomer').select2(
						{
							tags: true,
							dropdownParent: $("#addCustomerMarketPlan")
						}
					);
				}, complete: function() {
					$.ajax({
						url: "../util/loadAgriInArea.php",
						method: "GET",
						data: { "idArea": idArea },
						dataType: "text",
						success: function(data) {
							$('#addCustomerMarketPlan #idAgri').html(data);
							$('#addCustomerMarketPlan #idAgri').select2(
								{
									tags: true,
									dropdownParent: $("#addCustomerMarketPlan")
								}
							);
						}
					});
				}
			});

		});


	});

	$("#addCustomerMarketPlan #addCustomerMarketPlanBtn").on("click", function() {
		addCustomerMarketPlanSubmit();
	});



	$('#addCustomerMarketPlan').on('hidden.bs.modal', function(e) {

		clearDataAdd();

	});


	$('#addCustomer #clear').on('click', function(e) {

		clearDataAdd();

	});

	function addCustomerMarketPlanSubmit() {

		var idArea = jQuery("#addCustomerMarketPlan  #idArea option:selected").val();
		var customer_id = jQuery("#addCustomerMarketPlan  #idCustomer").val();
		var plan_Year = jQuery("#addCustomerMarketPlan  #plan_Year").val();
        var idAgri = jQuery("#addCustomerMarketPlan  #idAgri").val();
        var agri_weekplan_amount = jQuery("#addCustomerMarketPlan  #agri_weekplan_amount").val();
        var unit_id = jQuery("#addCustomerMarketPlan  #idCountUnit").val();
        var agri_spect = jQuery("#addCustomerMarketPlan  #agri_spect").val();
        var idTypeOfStand = jQuery("#addCustomerMarketPlan  #idTypeOfStand").val();
        var idLogistic = jQuery("#addCustomerMarketPlan  #logistic_id").val();
        var Refund_period = jQuery("#addCustomerMarketPlan  #Refund_period").val();
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

		formData.append('action', "add");

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
				$('#addCustomerMarketPlan').modal('toggle');
				Table.ajax.reload();
			}
		});
	}

	function clearDataAdd() {
		jQuery("#addCustomerMarketPlan select").val(jQuery("#addCustomerMarketPlan select option:first").val());
        jQuery("#addCustomerMarketPlan #idArea").val(0).trigger('change');
        $('#addCustomerMarketPlan #customer_id').html("");
        $('#addCustomerMarketPlan input').val("");

	}


})(jQuery);


