(function($) {

	var id;

	$('#editCustomerMarket').on('show.bs.modal', function(e) {
		id = $(e.relatedTarget).data('id');

		$("#editCustomerMarket #customer_id").val(id);



		$('#editCustomerMarket #idRiverBasin').change(function() {
			var idRiverBasin = $(this).val();
			$.ajax({
				url: "../util/AreaDependentWithRole.php",
				method: "POST",
				async: true,
				data: { idRiverBasin: idRiverBasin, "idArea": $("#AreaAll").val() },
				dataType: "text",
				success: function(data) {
					$('#editCustomerMarket #idArea').html(data);
				}
			});
		});


		loadCustomerMarket(id);
	});



	$("#editCustomerMarket #editCustomerMarketBtn").on("click", function() {
		editCustomerMarketSubmit();
	});
	$('#editCustomerMarket').on('hidden.bs.modal', function(e) {
		clearDataAdd();

	});
	$('#editCustomerMarket #clear').on('click', function(e) {

		clearDataAdd();

	});

	function editCustomerMarketSubmit() {

		var idArea = jQuery("#editCustomerMarket #idArea option:selected").val();
		var customer_id = jQuery("#editCustomerMarket #customer_id").val();
		var idMarket = jQuery("#editCustomerMarket #idMarket").val();

		

		var formData = new FormData();
		formData.append('customer_id', customer_id);
		formData.append('idMarket', idMarket);
		formData.append('idArea', idArea);
		formData.append('customer_market_id', id);
		formData.append('action', "update");

		$.ajax({
			type: "POST",
			cache: false,
			contentType: false,
			processData: false,
			dataType: 'text',
			data: formData,
			url: "../handler/customerMarketHandler.php",
			dataType: "html",
			async: true,
			success: function(data) {
				$('#editCustomerMarket').modal('toggle');
				Table.ajax.reload();
			}
		});
	}


	function clearDataAdd() {
		jQuery("#editCustomerMarket select").val(jQuery("#editCustomerMarket select option:first").val());
		$('#editCustomerMarket #idArea').val("");
		$('#editCustomerMarket #customer_id').val("");


	}
	function loadCustomerMarket(id) {

		$('#editCustomerMarket #idRiverBasin').trigger('change');
		var formData = new FormData();
		formData.append("customer_market_id", id);
		formData.append("action", "load");
		$.ajax({
			type: "POST",
			cache: false,
			contentType: false,
			processData: false,
			data: formData,
			dataType: 'text',
			url: "../handler/customerMarketHandler.php",
			dataType: "html",
			async: true,
			success: function(data) {
				mapData(JSON.parse(data));
			}
		});
	}


	function mapData(data) {

		var idRiverBasin = data.idRiverBasin;
		$('#editCustomerMarket #idRiverBasin').val(idRiverBasin);
		$('#editCustomerMarket #idMarket').val(data.idMarket);
		$.ajax({
			url: "../util/AreaDependentWithRole.php",
			method: "POST",
			async: true,
			data: { idRiverBasin: idRiverBasin, "idArea": $("#AreaAll").val() },
			dataType: "text",
			success: function(data_area) {
				$('#editCustomerMarket #idArea').html(data_area);
				$("#editCustomerMarket #idArea").val(data.idArea).trigger('change');

			}
		});


		$("#editCustomerMarket #customer_id").val(data.idCustomer);



	}


})(jQuery);


