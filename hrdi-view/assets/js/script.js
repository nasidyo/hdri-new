$.noConflict();

jQuery(document).ready(function($) {

	"use strict";

	[].slice.call( document.querySelectorAll( 'select.cs-select' ) ).forEach( function(el) {
		new SelectFx(el);
	} );

    // $('.selectpicker').selectpicker;
    $('.selectpicker').change(function () {
        var selectedItem = $('.selectpicker').val();
        $(this).closest('.col-sm-4').find('#multiselectvalues').val( selectedItem );
    });


	$('#menuToggle').on('click', function(event) {
        $('body').toggleClass('open');
        jQuery(".activeMenu").removeClass('activeMenu');
	});

	$('.search-trigger').on('click', function(event) {
		event.preventDefault();
		event.stopPropagation();
		$('.search-trigger').parent('.header-left').addClass('open');
	});

	$('.search-close').on('click', function(event) {
		event.preventDefault();
		event.stopPropagation();
		$('.search-trigger').parent('.header-left').removeClass('open');
	});

	// $('.user-area> a').on('click', function(event) {
	// 	event.preventDefault();
	// 	event.stopPropagation();
	// 	$('.user-menu').parent().removeClass('open');
	// 	$('.user-menu').parent().toggleClass('open');
	// });

	// Year
	$("input[name='register_year'], input[name='nameYear'], input[name='plan_Year']").datepicker({
        format: "yyyy",
		viewMode: "years",
		minViewMode: "years",
	});

	// Start
	$("input[name='dateStart'], input[name='update_date']").datepicker({
        format: "yyyy-mm-dd 00:00:00.000000",
        language: "th",
        orientation: "auto left",
        autoclose: true
	});

	// End
	$("input[name='dateStop']").datepicker({
        format: "yyyy-mm-dd 23:59:59.000000",
        language: "th",
        orientation: "auto left",
        autoclose: true
    });

	// Ajax
	// CustomerMarket
	// $('#CustomerMarket #idArea').on('change', function() {
	// 	var idArea = $(this).val();
	// 	$.ajax({
	// 		method: "POST",
	// 		url: "../classes/Ajax.php",
	// 		data: {
	// 			action: 'selectMarketByArea',
	// 			idArea: idArea
	// 		}
	// 	})
	// 	.done(function( data ) {
	// 		$('select#idMarket').html( data );
	// 	});
	// });

	// $('#CustomerMarket #idMarket').on('change', function() {
	// 	var idMarket = $(this).val();
	// 	$.ajax({
	// 		method: "POST",
	// 		url: "../classes/Ajax.php",
	// 		data: {
	// 			action: 'selectCustomerByMarket',
	// 			idMarket: idMarket
	// 		}
	// 	})
	// 	.done(function( data ) {
	// 		$('select#idCustomer').html( data );
	// 		$('.selectpicker').selectpicker();
	// 	});
	// });

	// Person By Area
	$('#Organization_TD #idArea, #RegisterAgri_TD #idArea, #CustomerMaketPlan_TD #idArea, #CustomerMarket #idArea').on('change', function() {
		var idArea = $(this).val();
		$.ajax({
			method: "POST",
			url: "../classes/Ajax.php",
			data: {
				action: 'selectPersonByArea',
				idArea: idArea
			}
		})
		.done(function( data ) {
			$('select#idPerson').html( data );
		});
	});

	// ListVillageLevel_TD
	$('#ListVillageLevel_TD #idArea').on('change', function() {
		var idArea = $(this).val();
		$.ajax({
			method: "POST",
			url: "../classes/Ajax.php",
			data: {
				action: 'selectGroupVillageByArea',
				idArea: idArea
			}
		})
		.done(function( data ) {
			console.log( data );
			$('select#idGroupVillage').html( data );
		});
	});

	// Agri by Type
	$('#idTypeOfArgi').on('change', function() {
		var idTypeOfArgi = $(this).val();
		$.ajax({
			method: "POST",
			url: "../classes/Ajax.php",
			data: {
				action: 'selectAgriByType',
				idTypeOfArgi: idTypeOfArgi
			}
		})
		.done(function( data ) {
			$('select#idAgri').html( data );
		});
	});

	// Datatables
	// $('.datatables').DataTable();
	var table = $('.datatables').DataTable();
	var data = table.order( [ 0, 'desc' ] ).draw();
});
