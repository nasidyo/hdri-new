var Table;
(function ($) {

    $("#criteria #idRiverBasin").select2();
    $("#criteria #idArea").select2();
    $("#criteria #institute_id").select2();
    $("#criteria #customer").select2();
    $("#criteria #product").select2();
    $("#criteria #customer_search").select2();
    $("#criteria #product_add").select2();
    $("#criteria #expense_other_id").select2();

 var   spinner = $("#loader");

    $(document).on({
       ajaxStart: function(){
           spinner.show();
       },
       ajaxStop: function(){
           spinner.hide();
       }
   });


    var defaultData =" <option value='0'>ทั้งหมด</option>";
    var yearsStart = new Date().getFullYear()+540;
    var d = new Date();
    var year = d.getFullYear();
    var month = d.getMonth();
    var day = d.getDate();
    var c = new Date(year + 543, month, day);


    $('.searchFromDateTmp').datepicker({
        format: "dd MM yyyy",
        language:  'th',
        changeMonth: false,
        changeYear: false,
        startDate: new Date(yearsStart,0,1),
        thaiyear: true,
        stepMonths: 0
    });


    $('.searchToDateTmp').datepicker({
        format: "dd MM yyyy",
        language:  'th',
        changeMonth: false,
        changeYear: false,
        startDate: new Date(yearsStart,0,1),
        thaiyear: true,
        stepMonths: 0
    });

      $('#main #criteria #idRiverBasin').change(function(){
        var idRiverBasin = $(this).val();
         $.ajax({
             url:"../util/AreaDependentWithRole.php",
             method:"POST",
             data:{idRiverBasin:idRiverBasin,idArea:$("#AreaAll").val()},
             dataType:"text",
             success:function(data){
                 $('#main #criteria #idArea').html(data);
             },complete:function(){
                $('#main #criteria #idArea').trigger('change');

             }
         });
     });



     $('#main #criteria #idArea').change(function(){
        var idArea = $(this).val();
         $.ajax({
             url:"../util/InstituteDependent.php",
             method:"GET",
             data:{idArea:idArea},
             dataType:"text",
             success:function(data){
                 $('#main #criteria #institute_id').html(data);
             },complete:function(){
                $('#main #criteria #institute_id').trigger('change');
             }
         });
     });

     $('#main #criteria #institute_id').change(function(){
        var institute_id = $(this).val();
         $.ajax({
             url:"../util/loadOrderByIns.php",
             method:"POST",
             data:{institute_id:institute_id},
             dataType:"text",
             success:function(data){
                 $('#main #criteria #product').html(data);
             }
         });
     });

     $('#main #criteria #institute_id').change(function(){
        var institute_id = $(this).val();
         $.ajax({
             url:"../util/loadSubGroupbyIns.php",
             method:"POST",
             data:{institute_id:institute_id},
             dataType:"text",
             success:function(data){
                 $('#main #criteria #sub_group_id').html(defaultData+data);
             },complete:function(){
                $('#main #criteria #sub_group_id').trigger('change');
             }
         });
     });

     $('#main #criteria #institute_id').change(function(){
        var institute_id = $(this).val();
         $.ajax({
             url:"../util/loadOtherExpenByIns.php?institute_id="+institute_id,
             method:"GET",
             dataType:"text",
             success:function(data){
                 $('#main #criteria #expense_other_id').html(defaultData+data);
             }
         });
     });

     $('#main #criteria #institute_id').change(function(){
        var institute_id = $(this).val();
         $.ajax({
             url:"../util/loadOtherIncomeByIns.php?institute_id="+institute_id,
             method:"GET",
             dataType:"text",
             success:function(data){
                 $('#main #criteria #income_other_id').html(defaultData+data);
             }
         });
     });





     $('#main #criteria #sub_group_id').change(function(){
        var sub_group_id = $(this).val();
         $.ajax({
             url:"../util/loadBusinessBySubGroup.php",
             method:"POST",
             data:{sub_group_id:sub_group_id},
             dataType:"text",
             success:function(data){
                 $('#main #criteria #business_group_id').html(defaultData+data);
             }
         });
     });
     $('#main #criteria #sub_group_id').change(function(){
        var sub_group_id = $(this).val();
         $.ajax({
             url:"../util/loadPersonFromSubGroup.php",
             method:"POST",
             data:{sub_group_id:sub_group_id},
             dataType:"text",
             success:function(data){
                 $('#main #criteria #customer_search').html(data);
             },complete:function(){
                $('#main #criteria #customer_search').select2();
             }
         });
     });


     $('#main #criteria #idRiverBasin').trigger('change');

     $("#main #search_cooperative").on('click',function(){
        search();
    })
    var idRiverBasin  = $("#idRiverBasin option:selected").val();
    var idArea =$("#idArea option:selected").val();
    var institute_id =$("#institute_id option:selected").val();
    var customer =$("#customer_search option:selected").val() ;
    var other_customer = $("#other_customer").val() ;
    var order_id =$("#product option:selected").val()  ;
    var expense_other_id =$("#expense_other_id option:selected").val() ;
    var income_other_id =$("#income_other_id option:selected").val() ;

    var doc_no = $("#doc_no").val() ;

    var type = $("#type option:selected").val();


    var fromDate="";
    var toDate="";
    if(jQuery("#main #searchFromDate").val()!=""){
       fromDate =  dateToFilter(deltaDate(new Date(jQuery("#main #searchFromDate").val()),0,0,0).toLocaleDateString('en-US').substring(0, 10));
    }

    if(jQuery("#main #searchToDate").val()!=""){
       toDate = dateToFilter(deltaDate(new Date(jQuery("#main #searchToDate").val()),0,0,0).toLocaleDateString('en-US').substring(0, 10));
    }

    var canceled =$("#canceled option:selected").val();

    var sub_group_id =jQuery("#sub_group_id option:selected").val();
    var business_group_id =jQuery("#business_group_id option:selected").val();

    var queryStr ="?idRiverBasin="+idRiverBasin+"&idArea="+idArea+"&institute_id="+institute_id;
        queryStr+="&customer="+customer+"&other_customer="+other_customer+"&order_id="+order_id;
        queryStr+="&expense_other_id="+expense_other_id+"&doc_no="+doc_no+"&fromDate="+fromDate;
        queryStr+="&toDate="+toDate+"&canceled="+canceled+"&income_other_id="+income_other_id;
        queryStr+="&sub_group_id="+sub_group_id+"&business_group_id="+business_group_id+'&type='+type;
        if($("#RECEIVE").prop("checked")){
            queryStr+="&tran_type[]=RECEIVE";
         }
         if($("#EXPENCE").prop("checked")){
            queryStr+="&tran_type[]=EXPENCE";
         }
         if($("#debt").prop("checked")){
            queryStr+="&debt=Y";
         }

    Table = $('#cooperativeTable').DataTable({
        lengthMenu: [[10, 25, 50, 1000], [10, 25, 50, 1000]],
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
        dom: '<"top">r<tl><"bottom"ip><"clear">',
        pageLength: 50,
        processing: true,
        responsive: true,
        serverSide: true,
        ajax: {url:"../server_side/cooperativeSS.php"+queryStr,"type": "GET"},
        order: [[ 0, "asc" ]],
        columnDefs: [
                    {
                        "targets": [2],
                        "visible": true,
                        "searchable": false,
                        "orderable":false
                    },
                    {
                        "targets": [3],
                        "visible": true,
                        "searchable": false,
                        "orderable":false

                    },
                    {
                        "targets": [4],
                        "visible": true,
                        "searchable": false,
                        "orderable":false
                    },
                    {
                        "targets": [5],
                        "visible": true,
                        "searchable": false,
                        "orderable":false

                    },
                    {
                        "targets": [6],
                        "visible": true,
                        "searchable": false,
                        "orderable":false
                    },
                    {
                        "targets": [8],
                        "visible": true,
                        "searchable": false,
                        "orderable":false

                    },
                    {
                        "targets": [9],
                        "visible": true,
                        "searchable": false,
                        "orderable":false
                    },
                    {
                        "targets": [10],
                        "visible": true,
                        "searchable": false,
                        "orderable":false

                    },
                    {
                        "targets": [11],
                        "visible": true,
                        "searchable": false,
                        "orderable":false
                    },
                    {
                        "targets": [12],
                        "visible": false,
                        "searchable": false,
                        "orderable":false
                    },
                    {
                        "targets": [13],
                        "visible": false,
                        "searchable": false,
                        "orderable":false

                    },
                    {
                        "targets": [14],
                        "visible": false,
                        "searchable": false,
                        "orderable":false

                    }

                ],
                "createdRow": function( row, data, dataIndex ) {

                    if(data[13]=="RECEIVE" && data[14] != "Y" && (data[8] == 0 || data[8] == null) && (data[9] == 0 || data[9] == null)){
                        $(row).addClass('green');
                    }else if(data[13]=="EXPENCE"  && data[14] != "Y" && (data[8] == 0 || data[8] == null) && (data[9] == 0 || data[9] == null)){
                        $(row).addClass('yellow');
                    }
                    if ( data[14] == "Y" ) {
                        $(row).addClass('dark');
                    }else if(data[8] != null && data[8] > 0 ){
                        $(row).addClass('red');
                    }
                    else if(data[9] != null && data[9] > 0 ){
                        $(row).addClass('red');
                    }
                } ,
                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(), data;
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };
                    total = api
                    .column( 7 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
                    debt_ex = api
                        .column( 8 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                        debt_inc = api
                        .column( 9 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                  all_discount = api
                    .column( 5 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    sum = api
                    .column( 6 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

               /*    $("#all_other").html(numberWithCommas(total) +' บาท');
                   $("#pay_all").html(numberWithCommas(sum) +' บาท');
                   $("#all_discount").html(numberWithCommas(all_discount) +' บาท');
                    $("#debt_ex").html(numberWithCommas(debt_ex) +' บาท');
                    $("#debt_inc").html(numberWithCommas(debt_inc) +' บาท');*/

                }

    });

    function search(){
        Table.destroy();
        var idRiverBasin  = $("#idRiverBasin option:selected").val();
        var idArea =$("#idArea option:selected").val();
        var institute_id =$("#institute_id option:selected").val();
        var customer =$("#customer_search option:selected").val() ;
        var other_customer = $("#other_customer").val() ;
        var order_id =$("#product option:selected").val()  ;
        var expense_other_id =$("#expense_other_id option:selected").val() ;
        var income_other_id =$("#income_other_id option:selected").val() ;

        var doc_no = $("#doc_no").val() ;
        var type = $("#type option:selected").val();

        var fromDate="";
        var toDate="";
        if(jQuery("#main #searchFromDate").val()!=""){
           fromDate =  dateToFilter(deltaDate(new Date(jQuery("#main #searchFromDate").val()),0,0,0).toLocaleDateString('en-US').substring(0, 10));
        }

        if(jQuery("#main #searchToDate").val()!=""){
           toDate = dateToFilter(deltaDate(new Date(jQuery("#main #searchToDate").val()),0,0,0).toLocaleDateString('en-US').substring(0, 10));
        }

        var canceled =$("#canceled option:selected").val();

        var sub_group_id =jQuery("#sub_group_id option:selected").val();
        var business_group_id =jQuery("#business_group_id option:selected").val();

        var queryStr ="?idRiverBasin="+idRiverBasin+"&idArea="+idArea+"&institute_id="+institute_id;
            queryStr+="&customer="+customer+"&other_customer="+other_customer+"&order_id="+order_id;
            queryStr+="&expense_other_id="+expense_other_id+"&doc_no="+doc_no+"&fromDate="+fromDate;
            queryStr+="&toDate="+toDate+"&canceled="+canceled+"&income_other_id="+income_other_id;
            queryStr+="&sub_group_id="+sub_group_id+"&business_group_id="+business_group_id+'&type='+type;
            if($("#RECEIVE").prop("checked")){
                queryStr+="&tran_type[]=RECEIVE";
             }
             if($("#EXPENCE").prop("checked")){
                queryStr+="&tran_type[]=EXPENCE";
             }
             if($("#debt").prop("checked")){
                queryStr+="&debt=Y";
             }

        Table = $('#cooperativeTable').DataTable({
            lengthMenu: [[10, 25, 50, 1000], [10, 25, 50, 1000]],
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
            dom: '<"top">r<tl><"bottom"ip><"clear">',
            pageLength: 50,
            processing: true,
            responsive: true,
            serverSide: true,
            ajax: {url:"../server_side/cooperativeSS.php"+queryStr,"type": "GET"},
            order: [[ 0, "asc" ]],
            columnDefs: [
                            {
                                "targets": [2],
                                "visible": true,
                                "searchable": false,
                                "orderable":false
                            },
                            {
                                "targets": [3],
                                "visible": true,
                                "searchable": false,
                                "orderable":false

                            },
                            {
                                "targets": [4],
                                "visible": true,
                                "searchable": false,
                                "orderable":false
                            },
                            {
                                "targets": [5],
                                "visible": true,
                                "searchable": false,
                                "orderable":false

                            },
                            {
                                "targets": [6],
                                "visible": true,
                                "searchable": false,
                                "orderable":false
                            },
                            {
                                "targets": [8],
                                "visible": true,
                                "searchable": false,
                                "orderable":false

                            },
                            {
                                "targets": [9],
                                "visible": true,
                                "searchable": false,
                                "orderable":false
                            },
                            {
                                "targets": [10],
                                "visible": true,
                                "searchable": false,
                                "orderable":false

                            },
                            {
                                "targets": [11],
                                "visible": true,
                                "searchable": false,
                                "orderable":false
                            },
                            {
                                "targets": [12],
                                "visible": false,
                                "searchable": false,
                                "orderable":false
                            },
                            {
                                "targets": [13],
                                "visible": false,
                                "searchable": false,
                                "orderable":false

                            },
                            {
                                "targets": [14],
                                "visible": false,
                                "searchable": false,
                                "orderable":false

                            }

                        ],
                        "createdRow": function( row, data, dataIndex ) {

                            if(data[13]=="RECEIVE" && data[14] != "Y" && (data[8] == 0 || data[8] == null) && (data[9] == 0 || data[9] == null)){
                                $(row).addClass('green');
                            }else if(data[13]=="EXPENCE"  && data[14] != "Y" && (data[8] == 0 || data[8] == null) && (data[9] == 0 || data[9] == null)){
                                $(row).addClass('yellow');
                            }
                            if ( data[14] == "Y" ) {
                                $(row).addClass('dark');
                            }else if(data[8] != null && data[8] > 0 ){
                                $(row).addClass('red');
                            }
                            else if(data[9] != null && data[9] > 0 ){
                                $(row).addClass('red');
                            }
                        },
                        "footerCallback": function ( row, data, start, end, display ) {
                            var api = this.api(), data;
                            var intVal = function ( i ) {
                                return typeof i === 'string' ?
                                    i.replace(/[\$,]/g, '')*1 :
                                    typeof i === 'number' ?
                                        i : 0;
                            };
                            total = api
                            .column( 7 )
                            .data()
                            .reduce( function (a, b) {
                                return intVal(a) + intVal(b);
                            }, 0 );
                            debt_ex = api
                                .column( 8 )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 );

                                debt_inc = api
                                .column( 9 )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 );
                        all_discount = api
                            .column( 5 )
                            .data()
                            .reduce( function (a, b) {
                                return intVal(a) + intVal(b);
                            }, 0 );

                            sum = api
                            .column( 6 )
                            .data()
                            .reduce( function (a, b) {
                                return intVal(a) + intVal(b);
                            }, 0 );

                      /*  $("#all_other").html(numberWithCommas(total) +' บาท');
                        $("#pay_all").html(numberWithCommas(sum) +' บาท');
                        $("#all_discount").html(numberWithCommas(all_discount) +' บาท');
                            $("#debt_ex").html(numberWithCommas(debt_ex) +' บาท');
                            $("#debt_inc").html(numberWithCommas(debt_inc) +' บาท');*/

                        }

            });

    }



})(jQuery);


function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}
