var Table;
(function($) {


	// $("#criteria #status").select2();

	$('#criteria #idMarket').select2();
	$('#criteria #customer_id').select2();
	
	
	   $('#criteria #idRiverBasin').change(function(){
		var idRiverBasin = $(this).val();
		if($('#staffPermis').val() != 'admin'){
            var idArea = $('#AreaAll').val();
        }else{
            var idArea = '';
        }
        console.log(idArea);
        $.ajax({
            url:"../util/loadAreaDropdown.php",
            method:"POST",
            data:{idRiverBasin:idRiverBasin, idArea:idArea},
            dataType:"text",
            success:function(data){
                $('#criteria #idArea').html(data);
            }
		});
		// $.ajax({
		// 	url:"../util/AreaDependent.php",
		// 	method:"POST",
		// 	data:{idRiverBasin:idRiverBasin},
		// 	dataType:"text",
		// 	success:function(data){
		// 		$('#criteria #idArea').html(data);
		// 	}
		// });
     });

     

	var staffPermis = $('#staffPermis').val();
	var areaAll = $('#AreaAll').val();
	Table = $('#customerMarketTable').DataTable({
		lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
		processing: true,
		responsive: true,
		serverSide: true,
		"dom": "<'row'<'col-sm-6'Bl><'col-sm-6'f>>" +
		"<'row'<'col-sm-12'tr>>" +
		"<'row'<'col-sm-5'i><'col-sm-7'p>>",
            'buttons': [{
                'extend': 'collection',
                'className': 'exportButton',
                'text': 'Data Export',
                'buttons': [
                    { 'extend':'copy',
                    'action':newexportaction ,
                            'exportOptions': {
                              'modifier': {
                                'page': 'All',
                                'search': 'none'
                              },
                              'columns': [5,1,2,3,4]
                          },
						  'title': 'ข้อมูลตลาดผู้รับซื้อ',
                    },
      
                    { 'extend':'csv',
                    'action':newexportaction ,
                    'exportOptions': {
                      'modifier': {
                        'page': 'All',
                        'search': 'none'
                        },
                        'columns': [5,1,2,3,4]
                      },
					  'title': 'ข้อมูลตลาดผู้รับซื้อ',
                    },
      
                    { 'extend':'excel',
                    'action':newexportaction ,
                    'exportOptions': {
                      'modifier': {
                        'page': 'All',
                        'search': 'none'
                        },
                        'columns': [5,1,2,3,4]
                      },
					  'title': 'ข้อมูลตลาดผู้รับซื้อ',
                    },
                    { 'extend':'print',
                    'action':newexportaction ,
                    'exportOptions': {
                      'modifier': {
                        'page': 'ALL',
                        'search': 'none'
                        },
                        'columns': [5,1,2,3,4]
                      },
					  'title': 'ข้อมูลตลาดผู้รับซื้อ',
                    },
                  ]
              }],
		ajax: { url: "../server_side/customerMarketSS.php?idRiverBasin="+$("#criteria #idRiverBasin").val()+"&idArea="+$("#criteria #idArea").val()+"&idMarket="+$("#criteria #idMarket").val()+"&customer_id="+$("#criteria #customer_id").val()+"&staffPermis="+staffPermis+"&areaAll="+areaAll, "type": "GET" },
		order: [[5, "desc"]],
		columnDefs: [{
            'targets': [5],
            "visible": false,
        },{
			'targets': [6],
			'width': 70,
			'searchable': false,
			'orderable': true,
			'className': 'dt-header-center',
			'render': function(data, type, full, meta) {
				return '<div style=" font-size: 20px; "  ><i class="fa fa-edit" style=" cursor: pointer;margin-right: 10px; color: blue;" data-toggle="modal" data-target="#editCustomerMarket" data-id="' + full[5] + '" id="editCustomerBtn"></i>        <i class="fa fa-trash" style="cursor: pointer;color: red;" id="disableCustomerBtn"  data-id="' + full[5] + '"></i></div>';
			}
		},
		{
			'targets': [0],
			'className': 'dt-header-center',
			'searchable': false,
			'orderable': false
		}


		]
		, "drawCallback": function(settings) {
			var pageNumber = Table.page();
			var length = Table.page.len();
			var index = (pageNumber * length) + 1;
			Table.column(0, { search: 'applied', order: 'applied' }).nodes().each(function(cell, i) {
				cell.innerHTML = i + index;
			});
		}
	});

	Table.on('order.dt,search.dt', function() {
		var pageNumber = Table.page();
		var length = Table.page.len();
		var index =(pageNumber*length) + 1 ;
		Table.column(0, { search: 'applied', order: 'applied' }).nodes().each(function(cell, i) {
			cell.innerHTML = i + index;
		});
	}).draw();


	Table.on('page.dt', function() {
		var pageNumber = Table.page();
		var length = Table.page.len();
		var index = (pageNumber * length) + 1;
		Table.column(0, { page: 'applied' }).nodes().each(function(cell, i) {
			cell.innerHTML = i + index;
		});
	}).draw();
	
	
	$('#criteria #search_customer').on( 'click', function () {
	    search();
	});
	
	$('#customerMarketTable tbody').on( 'click','#disableCustomerBtn', function () {
	  var  id =$(this).data('id');
        delCustomer(id);
	});
	$('#criteria #clear_customer').on( 'click', function () {
	    clear();
	});
	
	





	function search() {
		var staffPermis = $('#staffPermis').val();
		var areaAll = $('#AreaAll').val();
		Table.destroy();
		Table = $('#customerMarketTable').DataTable({
		lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
		"dom": "<'row'<'col-sm-6'Bl><'col-sm-6'f>>" +
		"<'row'<'col-sm-12'tr>>" +
		"<'row'<'col-sm-5'i><'col-sm-7'p>>",
            'buttons': [{
                'extend': 'collection',
                'className': 'exportButton',
                'text': 'Data Export',
                'buttons': [
                    { 'extend':'copy',
                    'action':newexportaction ,
                            'exportOptions': {
                              'modifier': {
                                'page': 'All',
                                'search': 'none'
                              },
                              'columns': [5,1,2,3,4]
                          },
						  'title': 'ข้อมูลตลาดผู้รับซื้อ',
                    },
      
                    { 'extend':'csv',
                    'action':newexportaction ,
                    'exportOptions': {
                      'modifier': {
                        'page': 'All',
                        'search': 'none'
                        },
                        'columns': [5,1,2,3,4]
                      },
					  'title': 'ข้อมูลตลาดผู้รับซื้อ',
                    },
      
                    { 'extend':'excel',
                    'action':newexportaction ,
                    'exportOptions': {
                      'modifier': {
                        'page': 'All',
                        'search': 'none'
                        },
                        'columns': [5,1,2,3,4]
                      },
					  'title': 'ข้อมูลตลาดผู้รับซื้อ',
                    },
                    { 'extend':'print',
                    'action':newexportaction ,
                    'exportOptions': {
                      'modifier': {
                        'page': 'ALL',
                        'search': 'none'
                        },
                        'columns': [5,1,2,3,4]
                      },
					  'title': 'ข้อมูลตลาดผู้รับซื้อ',
                    },
                  ]
              }],
		pageLength: 10,
		processing: true,
		responsive: true,
		serverSide: true,
		ajax: { url: "../server_side/customerMarketSS.php?idRiverBasin="+$("#criteria #idRiverBasin").val()+"&idArea="+$("#criteria #idArea").val()+"&idMarket="+$("#criteria #idMarket").val()+"&customer_id="+$("#criteria #customer_id").val()+"&staffPermis="+staffPermis+"&areaAll="+areaAll,"type": "GET" },	
		order: [[5, "desc"]],
		columnDefs: [{
            'targets': [5],
            "visible": false,
        },{
			'targets': [6],
			'width': 70,
			'searchable': false,
			'orderable': true,
			'className': 'dt-header-center',
			'render': function(data, type, full, meta) {
				return '<div style=" font-size: 20px; "  ><i class="fa fa-edit" style=" cursor: pointer;margin-right: 10px; color: blue;" data-toggle="modal" data-target="#editCustomerMarket" data-id="' + full[5] + '" id="editCustomerBtn"></i>        <i class="fa fa-trash" style="cursor: pointer;color: red;" id="disableCustomerBtn"  data-id="' + full[5] + '"></i></div>';
			}
		},
		{
			'targets': [0],
			'className': 'dt-header-center',
			'searchable': false,
			'orderable': false
		}


		]
		, "drawCallback": function(settings) {
			var pageNumber = Table.page();
			var length = Table.page.len();
			var index = (pageNumber * length) + 1;
			Table.column(0, { search: 'applied', order: 'applied' }).nodes().each(function(cell, i) {
				cell.innerHTML = i + index;
			});
		}
	});

	}
	function clear() {
		jQuery("#criteria #idRiverBasin").val(jQuery("#criteria #idRiverBasin option:first").val()).trigger('change');
		jQuery("#criteria #idMarket").val(jQuery("#criteria #idMarket option:first").val()).trigger('change');
		jQuery("#criteria #customer_id").val(jQuery("#criteria #customer_id option:first").val()).trigger('change');
		search();
	}

	function delCustomer(id) {

		if (!confirm(" ต้องการลบข้อมูล ")) {
			return false;
		}

		var formData = new FormData();
		formData.append('customer_market_id', id);
		formData.append('action', "delete");

		jQuery.ajax({
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
				Table.ajax.reload();
			}
		});

	}

	function newexportaction(e, dt, button, config) {
		var self = this;
		var oldStart = dt.settings()[0]._iDisplayStart;
		dt.one('preXhr', function (e, s, data) {
			// Just this once, load all data from the server...
			data.start = 0;
			data.length = 2147483647;
			dt.one('preDraw', function (e, settings) {
				// Call the original action function
				if (button[0].className.indexOf('buttons-copy') >= 0) {
					$.fn.dataTable.ext.buttons.copyHtml5.action.call(self, e, dt, button, config);
				} else if (button[0].className.indexOf('buttons-excel') >= 0) {
					$.fn.dataTable.ext.buttons.excelHtml5.available(dt, config) ?
						$.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config) :
						$.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
				} else if (button[0].className.indexOf('buttons-csv') >= 0) {
					$.fn.dataTable.ext.buttons.csvHtml5.available(dt, config) ?
						$.fn.dataTable.ext.buttons.csvHtml5.action.call(self, e, dt, button, config) :
						$.fn.dataTable.ext.buttons.csvFlash.action.call(self, e, dt, button, config);
				} else if (button[0].className.indexOf('buttons-pdf') >= 0) {
					$.fn.dataTable.ext.buttons.pdfHtml5.available(dt, config) ?
						$.fn.dataTable.ext.buttons.pdfHtml5.action.call(self, e, dt, button, config) :
						$.fn.dataTable.ext.buttons.pdfFlash.action.call(self, e, dt, button, config);
				} else if (button[0].className.indexOf('buttons-print') >= 0) {
					$.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
				}
				dt.one('preXhr', function (e, s, data) {
					// DataTables thinks the first item displayed is index 0, but we're not drawing that.
					// Set the property to what it was before exporting.
					settings._iDisplayStart = oldStart;
					data.start = oldStart;
				});
				// Reload the grid with the original page. Otherwise, API functions like table.cell(this) don't work properly.
				setTimeout(dt.ajax.reload, 0);
				// Prevent rendering of the full data to the DOM
				return false;
			});
		});
		// Requery the server with the new one-time export settings
		dt.ajax.reload();
	};
})(jQuery);
