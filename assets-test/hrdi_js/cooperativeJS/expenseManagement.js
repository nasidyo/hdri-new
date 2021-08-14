var expenseTmp =[];
var expenseTmpX=[];
var Table;
(function ($) {

    $("#main #idRiverBasin").select2();
    $("#main #idArea").select2();
    $("#main #institute_id").select2();
    $("#main #addExpense #customer").select2();
    $("#main #product").select2();
    $("#main #customer_search").select2();
    $("#main #product_add").select2();
    $("#main #expense_other_id").select2();
    $("#criteria #canceled option[value='N']").prop('selected',true);

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

    $('#addExpense .expenseDateTmp').datepicker({
        format: "dd MM yyyy",
        language:  'th',
        changeMonth: false,
        changeYear: false,
        thaiyear: true,
        stepMonths: 0 ,
        todayBtn: true,
        todayHighlight: true
    }).datepicker("setDate",c);

    Table = $('#main #expenseTable').DataTable({
        lengthMenu: [[10, 25, 50, 1000], [10, 25, 50, 1000]],
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
        dom: '<"top"i>Brt<"bottom"lp><"clear">',
        buttons: [
            { 'extend':'copy',
            'action':newexportaction ,
                    'exportOptions': {
                      'modifier': {
                        'page': 'All',
                        'search': 'none'
                      },
                      'columns': [  0,1,2,3,4,5,6,7,8,9,10]
                  },

            },

            { 'extend':'csv',
            'action':newexportaction ,
            'exportOptions': {
              'modifier': {
                'page': 'All',
                'search': 'none'
                },
                'columns': [   0,1,2,3,4,5,6,7,8,9,10 ]
              },
            },

            { 'extend':'excel',
            'action':newexportaction ,
            'exportOptions': {
              'modifier': {
                'page': 'All',
                'search': 'none'
                },
                'columns': [   0,1,2,3,4,5,6,7,8,9,10 ]
              },
            },
            { 'extend':'print',
            'action':newexportaction ,
            'exportOptions': {
              'modifier': {
                'page': 'ALL',
                'search': 'none'
                },
                'columns': [   0,1,2,3,4,5,6,7,8,9,10 ]
              },
            },
          ],
        pageLength: 10,
        processing: true,
        responsive: true,
        serverSide: true,
        ajax: {url:"../server_side/expenseSS.php?idRiverBasin="+$("#main #idRiverBasin").val()+"&idArea="+$("#main #idArea").val()+"&canceled="+$("#main #criteria #canceled option:selected").val(),"type": "GET"},
        order: [[ 0, "desc" ]],
        columnDefs: [{
                        'targets': [11],
                        'width': 40,
                        'searchable': false,
                        'orderable': false,
                        'className': 'dt-header-center',
                        'render': function (data, type, full, meta){
                            return '<div style=" font-size: 20px; "  ><i class="fa fa-edit" style=" cursor: pointer;margin-right: 10px;" data-toggle="modal" data-target="#editExpense" data-id="'+full[12]+'" id="editExpense"></i> </div>';
                        }
                    },
                    {
                        "targets": [0],
                        "visible": true,
                        "searchable": false
                    },
                    {
                        "targets": [10],
                        "visible": false,
                        "searchable": false

                    },
                    {
                        "targets": [12],
                        "visible": false,
                        "searchable": false
                    }

                ],
                "createdRow": function( row, data, dataIndex ) {
                    if ( data[11] == "Y" ) {
                        $(row).addClass('dark');
                    }else{
                        if(data[8]!="" && data[8] > 0){
                            $(row).addClass('red');
                        }else{
                            $(row).addClass('yellow');
                        }

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
                    debt = api
                    .column(8)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    all = api
                    .column(5)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    all_discount = api
                    .column(6)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );


                    $("#all_other").html(numberWithCommas(all) +' บาท');
                    $("#pay_all").html(numberWithCommas(total) +' บาท');
                    $("#all_discount").html(numberWithCommas(all_discount) +' บาท');
                    $("#debtOther").html(numberWithCommas(debt) +' บาท');


                }
    });


    $("#main #addExpenseBt").on('click',function(){
        addExpenseDB();
    })
    $("#main #search_expense").on('click',function(){
        search();
    })



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

     $('#main #criteria #idRiverBasin').trigger('change');

     $('#main #criteria #idArea').change(function(){
        var idArea = $(this).val();
         $.ajax({
             url:"../util/InstituteDependent.php",
             method:"GET",
             data:{idArea:idArea},
             dataType:"text",
             success:function(data){
                 $('#main #criteria #institute_id').html(defaultData+data);

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
                 $('#main #criteria #product').html(defaultData+data);
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
                 $('#main #criteria #customer_search').html(defaultData+data);
             }
         });
     });




     $('#main #addExpense #idRiverBasin').change(function(){
        var idRiverBasin = $(this).val();
         $.ajax({
             url:"../util/AreaDependentWithRole.php",
             method:"POST",
             data:{idRiverBasin:idRiverBasin,idArea:$("#AreaAll").val()},
             dataType:"text",
             success:function(data){
                 $('#main #addExpense #idArea').html(data);
             },complete:function(){
                $('#main #addExpense #idArea').trigger('change');

             }
         });
     });

     $('#main #addExpense #idRiverBasin').trigger('change');



     $('#main #addExpense #idArea').change(function(){
        var idArea = $(this).val();
         $.ajax({
             url:"../util/InstituteDependent.php",
             method:"GET",
             data:{idArea:idArea},
             dataType:"text",
             success:function(data){
                 $('#main #addExpense #institute_id').html(data);
             },complete:function(){
                $('#main #addExpense #institute_id').trigger('change');
             }
         });
     });

     $('#main #addExpense #institute_id').change(function(){
        var institute_id = $(this).val();
         $.ajax({
             url:"../util/loadOrderByIns.php",
             method:"POST",
             data:{institute_id:institute_id},
             dataType:"text",
             success:function(data){
                 $('#main #addExpense #product').html(data);
             }
         });
     });




     $('#main #addExpense #institute_id').change(function(){
        var institute_id = $(this).val();
         $.ajax({
             url:"../util/loadOrderByIns.php",
             method:"POST",
             data:{institute_id:institute_id},
             dataType:"text",
             success:function(data){
                 $('#main #addExpense #product_add').html(data);
             }
         });
     });

     $('#main #addExpense #institute_id').change(function(){
        var institute_id = $(this).val();
         $.ajax({
             url:"../util/loadSubGroupbyIns.php",
             method:"POST",
             data:{institute_id:institute_id},
             dataType:"text",
             success:function(data){
                 $('#main #addExpense #sub_group_id').html(data);
             },complete:function(){
                $('#main #addExpense #sub_group_id').trigger('change');
             }
         });
     });

     $('#main #addExpense #sub_group_id').change(function(){
        var sub_group_id = $(this).val();
         $.ajax({
             url:"../util/loadBusinessBySubGroup.php",
             method:"POST",
             data:{sub_group_id:sub_group_id},
             dataType:"text",
             success:function(data){
                 $('#main #addExpense #business_group_id').html(defaultData+data);
             }
         });
     });

     $('#main #addExpense #sub_group_id').change(function(){
        var sub_group_id = $(this).val();
         $.ajax({
             url:"../util/loadPersonFromSubGroup.php",
             method:"POST",
             data:{sub_group_id:sub_group_id},
             dataType:"text",
             success:function(data){
                 $('#main #addExpense #customer').html(data);
             },complete:function(){
                $('#main #addExpense #customer').select2();
             }
         });
     });


     $('#main #addExpense #product_add').change(function(){
        var orderId = $(this).val();
         $.ajax({
             url:"../util/loadOrderDetail.php?order_id="+orderId,
             method:"GET",
             dataType:"text",
             success:function(data){
                var item=  JSON.parse(data) ;
                 $('#main #product_div #balance').html(item.balance);
             }
         });
     });




    $("#main input[name='searchFromDate']").datepicker({
        format: "dd-mm-yyyy",
        language: "th",
        orientation: "auto left",
        autoclose: true,
        isBuddhist: true
      });


      $("#main input[name='searchToDate']").datepicker({
        format: "dd-mm-yyyy",
        language: "th",
        orientation: "auto left",
        autoclose: true,
        isBuddhist: true
      });



      $("#main input[name='expenseDate']").datepicker("setDate", new Date());

      $('#main #addExpense #institute_id').change(function(){
        var institute_id = $(this).val();
         $.ajax({
             url:"../util/loadOtherExpenByIns.php?institute_id="+institute_id,
             method:"GET",
             dataType:"text",
             success:function(data){
                 $('#main #addExpense #expense_other_id').html(data);
             }
         });
     });



      $('#addExpenseOther').on('hide.bs.modal', function (e) {
        $('#main #addExpense #institute_id').trigger('change');

      });



    $('#main .close').click(function(){
        $('#main #newsHeading').parent().slideUp();
      })


      $("#main input:radio[name='pay_type']").on('change', function (event) {
            if(this.value=='product'){
              $("#main #product_div").show(300);
              $("#main #other_div").hide(300);
            }else{
              $("#main #product_div").hide(300);
              $("#main #other_div").show(300);
            }
    });

    $("#main #addExpenseTmp").on('click',function(){
        addExpenseTmp();

    });


    function addExpenseTmp(){
        var institute_id = $("#main #addExpense #institute_id option:selected").val();
        var order_id = $("#main #addExpense #product_add option:selected").val();
        var order_name = $("#main #addExpense #product_add option:selected").text();
        var customer = $("#main #addExpense #customer option:selected").val();
        var other_customer = $("#main #addExpense #other_customer").val();
        var pay_type = $("#main input[name='pay_type']:checked").val();
        var amount=0;
        var price=0;
        var expense_other_id=0;
        var expense_other_name="";
        var idStaff = $("#idStaff").val();
        var discount = 0;
        var expenseDate="";
        var sub_group_id = $("#main #addExpense #sub_group_id option:selected").val();
        var business_group_id = $("#main #addExpense #business_group_id option:selected").val();

        var doc_no = $("#main #addExpense #doc_no").val()
            if(pay_type =="product"){
                amount = $("#main #product_div #amount").val();
                price = parseFloat($("#main #product_div #price").val()?$("#main #product_div #price").val():0);
                discount = parseFloat($("#main #addExpense #discount").val()?$("#main #addExpense #discount").val():0);
            }else{
                expense_other_id = $("#main #other_div #expense_other_id option:selected").val();
                expense_other_name = $("#main #other_div #expense_other_id option:selected").text();
                  price = $("#main #other_div #price").val();
            }

            if(price==0 || price == undefined){
                alert('กรุณาระบุราคา');
                return false;
            }
            if(customer ==0 && other_customer==""){
                alert('กรุณาระบุลูกค้า');
                return false;
            }

            var json = {};

            json["tmp_id"]=Math.random();
            json["institute_id"]=parseInt(institute_id);
            if(order_id ==undefined){
                order_id =0;
            }
            json["order_id"]=parseInt(order_id);
            json["customer"]=parseInt(customer);
            json["other_customer"]=other_customer;
            json["amount"]=parseInt(amount);
            json["price"]=parseFloat(price);
            json["expense_other_id"]=expense_other_id;
            json["expense_other_name"]=expense_other_name;
            json["pay_type"]=pay_type;
            json["order_name"]=order_name;
            json["expense_by"]=parseInt(idStaff);
            json["create_by"]=parseInt(idStaff);

            json["sub_group_id"]=sub_group_id;
            json["business_group_id"]=business_group_id;

            if(jQuery("#main #expenseDate").val()!=""){
                expenseDate = dateToDB2(deltaDate(new Date(jQuery("#main #expenseDate").val()),0,0,-543).toLocaleDateString('en-US').substring(0, 10));
             }
            json["expense_date"] = expenseDate;
            json["discount"] = discount;
            json["doc_no"] = doc_no;


            expenseTmp.push(json);
            expenseTmpX.push(json);
            displayOrder();
            clearInput();

    }
    function addExpenseDB(){

        if(validatePay()){
            var expense_amount =$("#main #addExpense #expense_amount").val();
            for ( var i in expenseTmpX ) {
                console.log('i :'+i);
                console.log('expenseTmp :'+expenseTmpX.length);
                var form_data = new FormData();
                for ( var key in expenseTmpX[i] ) {
                    form_data.append(key, expenseTmpX[i][key]);
                    if(key=="pay_type" && expenseTmpX[i][key]=="product"){
                        var result = (expenseTmpX[i]['price'] * expenseTmpX[i]['amount']) - expenseTmpX[i]['discount'];
                        if(expense_amount>=result){
                            form_data.append('expense_amount',result);
                            expense_amount =expense_amount-result;
                        }else{
                            form_data.append('expense_amount',expense_amount);
                            form_data.append('debt',result-expense_amount);
                            expense_amount=0;
                        }
                    }
                    if(key=="pay_type" && expenseTmpX[i][key]=="other"){
                        var result = expenseTmpX[i]['price'] ;
                        if(expense_amount>=result){
                            form_data.append('expense_amount',result);
                            expense_amount =expense_amount-result;
                        }else{
                            form_data.append('expense_amount',expense_amount);
                            form_data.append('debt',result-expense_amount);
                            expense_amount=0;
                        }

                    }
                }
                form_data.append('canceled',"N");
                form_data.append('exp',jQuery("#addExpense #expense_amount").val());
                form_data.append('action','add');

                $.ajax({
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType:'text',
                    data:form_data,
                    url: "../handler/expenseHandler.php",
                    dataType: "html",
                    async: false,
                    success: function(data) {
                        if(data.trim()!=""){
                            alert(data);
                        }
                      removeItem(form_data.get("tmp_id"));
                      $("#main #expense_amount").val('');
                    },complete:function(){

                        displayOrder();
                        clearInput();
                        Table.ajax.reload();
                    }
                  });
            }
            expenseTmpX =[];
            expenseTmp=[];
        }

    }

    function search(){
        Table.destroy();
        var debt="N";
        if($("#main #criteria #debt_search").prop("checked")){
            debt ="Y";
         }
         var fromDate="";
         var toDate="";
         if(jQuery("#main #searchFromDate").val()!=""){
            fromDate =  dateToFilter(deltaDate(new Date(jQuery("#main #searchFromDate").val()),0,0,0).toLocaleDateString('en-US').substring(0, 10));
         }

         if(jQuery("#main #searchToDate").val()!=""){
            toDate = dateToFilter(deltaDate(new Date(jQuery("#main #searchToDate").val()),0,0,0).toLocaleDateString('en-US').substring(0, 10));
         }
         var sub_group_id =jQuery("#main #criteria #sub_group_id option:selected").val();
         var business_group_id =jQuery("#main #criteria #business_group_id option:selected").val();

        Table = $('#main #expenseTable').DataTable({
            lengthMenu: [[10, 25, 50, 1000], [10, 25, 50, 1000]],
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
             dom: '<"top"i>Brt<"bottom"lp><"clear">',
             buttons: [
            { 'extend':'copy',
            'action':newexportaction ,
                    'exportOptions': {
                      'modifier': {
                        'page': 'All',
                        'search': 'none'
                      },
                      'columns': [  0,1,2,3,4,5,6,7,8,9,10]
                  },

            },

            { 'extend':'csv',
            'action':newexportaction ,
            'exportOptions': {
              'modifier': {
                'page': 'All',
                'search': 'none'
                },
                'columns': [   0,1,2,3,4,5,6,7,8,9,10 ]
              },
            },

            { 'extend':'excel',
            'action':newexportaction ,
            'exportOptions': {
              'modifier': {
                'page': 'All',
                'search': 'none'
                },
                'columns': [   0,1,2,3,4,5,6,7,8,9,10 ]
              },
            },
            { 'extend':'print',
            'action':newexportaction ,
            'exportOptions': {
              'modifier': {
                'page': 'ALL',
                'search': 'none'
                },
                'columns': [   0,1,2,3,4,5,6,7,8,9,10 ]
              },
            },
          ],
            pageLength: 10,
            processing: true,
            responsive: true,
            serverSide: true,
            ajax: {url:"../server_side/expenseSS.php?idRiverBasin="+$("#main #criteria #idRiverBasin").val()+"&idArea="+$("#main #criteria #idArea").val()+"&id="+$("#main #criteria #institute_id").val()+'&customer='+$("#main #criteria #customer_search option:selected").val()+"&other_customer="+$("#main #criteria #other_customer").val()+"&order_id="+$("#main #criteria #product option:selected").val()+"&expense_other_id="+$("#main #criteria #expense_other_id option:selected").val()+"&doc_no="+$("#main #criteria #doc_no").val()+"&fromDate="+fromDate+"&toDate="+toDate+"&canceled="+$("#main #criteria #canceled option:selected").val()+"&debt="+debt+"&business_group_id="+business_group_id+"&sub_group_id="+sub_group_id,"type": "GET"},
            order: [[ 0, "desc" ]],
            columnDefs: [{
                        'targets': [11],
                        'width': 40,
                        'searchable': false,
                        'orderable': false,
                        'className': 'dt-header-center',
                        'render': function (data, type, full, meta){
                            return '<div style=" font-size: 20px; "  ><i class="fa fa-edit" style=" cursor: pointer;margin-right: 10px;" data-toggle="modal" data-target="#editExpense" data-id="'+full[12]+'" id="editExpense"></i> </div>';
                        }
                    },
                    {
                        "targets": [0],
                        "visible": true,
                        "searchable": false
                    },
                    {
                        "targets": [10],
                        "visible": false,
                        "searchable": false

                    },
                    {
                        "targets": [12],
                        "visible": false,
                        "searchable": false
                    }

                ],
                "createdRow": function( row, data, dataIndex ) {
                    if ( data[11] == "Y" ) {
                        $(row).addClass('dark');
                    }else{
                        if(data[8]!="" && data[8] > 0){
                            $(row).addClass('red');
                        }else{
                            $(row).addClass('yellow');
                        }

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
                    debt = api
                    .column(8)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    all = api
                    .column(5)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    all_discount = api
                    .column(6)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );


                    $("#all_other").html(numberWithCommas(all) +' บาท');
                    $("#pay_all").html(numberWithCommas(total) +' บาท');
                    $("#all_discount").html(numberWithCommas(all_discount) +' บาท');
                    $("#debtOther").html(numberWithCommas(debt) +' บาท');

                }
        });



    }

  /*  $("#main #expense_amount").on("blur",function(){
        var otherPay =  parseFloat(jQuery("#main #otherPay").val()==""?0:jQuery("#main #otherPay").val()) ;
        var expense_amount = parseFloat(jQuery("#main #expense_amount").val()==""?0:jQuery("#main #expense_amount").val());
       // var debt = parseFloat(jQuery("#main #debt").val()==""?0:jQuery("#main #debt").val()) ;
        var result=0;
        if(otherPay > expense_amount ){
            result = otherPay - expense_amount;
            jQuery("#main #expense_amount").val(result.toFixed(2));
        }else{
            if(expense_amount >= otherPay){
                jQuery("#main #expense_amount").val(0);
            }else{
                $("#main #debt").val(result.toFixed(2));
                jQuery("#main #expense_amount").val(expense_amount.toFixed(2));
            }
        }



    });

    $("#main #debt").on("blur",function(){
        var otherPay =  parseFloat(jQuery("#main #otherPay").val()==""?0:jQuery("#main #otherPay").val()) ;
       // var expense_amount = parseFloat(jQuery("#main #expense_amount").val()==""?0:jQuery("#main #expense_amount").val());
        var debt = parseFloat(jQuery("#main #debt").val()==""?0:jQuery("#main #debt").val()) ;
        var result=0;
        if(otherPay > debt ){
            result = otherPay - debt;
            jQuery("#main #expense_amount").val(result.toFixed(2));
        }else{
            if(debt>=otherPay){
                jQuery("#main #debt").val(0);
            }else{
                $("#main #expense_amount").val(result.toFixed(2));
                jQuery("#main #debt").val(debt.toFixed(2));
            }
        }



    });*/

    $("#main #debt").on("keyup",function(){
        var otherPay =  parseFloat(jQuery("#main #otherPay").val()==""?0:jQuery("#main #otherPay").val()) ;
        // var expense_amount = parseFloat(jQuery("#main #expense_amount").val()==""?0:jQuery("#main #expense_amount").val());
         var debt = parseFloat(jQuery("#main #debt").val()==""?0:jQuery("#main #debt").val()) ;
         var result=0;
         if(otherPay >= debt ){
             result = otherPay - debt;
             jQuery("#main #expense_amount").val(result.toFixed(2));
         }else{

                 jQuery("#main #debt").val(0);
                 jQuery("#main #expense_amount").val(0);

         }
    })
    $("#main #expense_amount").on("keyup",function(){
        var otherPay =  parseFloat(jQuery("#main #otherPay").val()==""?0:jQuery("#main #otherPay").val()) ;
         var expense_amount = parseFloat(jQuery("#main #expense_amount").val()==""?0:jQuery("#main #expense_amount").val());

         var result=0;
         if(otherPay >= expense_amount ){
             result = otherPay - expense_amount;
             jQuery("#main #debt").val(result.toFixed(2));
         }else{

                 jQuery("#main #debt").val(0);
                 jQuery("#main #expense_amount").val(0);

         }
    })



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


function removeItem(tmp_id){
    console.log(tmp_id);
    for(var i=0;i<expenseTmp.length;i++){
        if(expenseTmp[i].tmp_id == tmp_id){
             expenseTmp.splice(i, 1) ;
             jQuery("#main button[name='"+tmp_id+"']").parents("#main #cardItem").html('');
             displayOrder();
        }
    }
}

function displayOrder(){
    var html="";
    var id="";
    if(expenseTmp!=null){
        for(var i=0;i<expenseTmp.length;i++){

            id = expenseTmp[i].tmp_id;

            if(expenseTmp[i].pay_type == "product"){
                html+='  <div class="col-sm-4" id="cardItem">';
                html+='        <div class="card">';
                html+='        <div class="card-header-td">';
                html+='            <button type="button" class="close" aria-label="Close" id= "removeItem_'+id+'" value='+id+' name='+id+' onClick="removeItem('+id+');">  ';
                html+='                        <span aria-hidden="true" style=" color: red;margin-right: 5px; ">&times;</span>';
                html+='                    </button>';
                html+='            </div>';
                html+='            <div class="card-body">';
                html+='                <div class="stat-widget-one" style=" text-align: center; font-size: x-large; " >';
                html+='                    <div class="stat-content dib">';
                html+='                        <div class="stat-digit">'+expenseTmp[i].order_name +'</div>';
                html+='                        <div class="">จำนวน '+expenseTmp[i].amount+' หน่วย</div>';
                html+='                        <div class="">ราคา '+expenseTmp[i].price+' บาท</div>';
                html+='                        <div class="">รวม '+(expenseTmp[i].amount*expenseTmp[i].price) +' บาท</div>';
                html+='                    </div>';
                html+='                </div>';
                html+='            </div>';
                html+='        </div>';
                html+='    </div> ';
            }else{
                html+='  <div class="col-sm-4" id="cardItem">';
                html+='        <div class="card">';
                html+='        <div class="card-header-td">';
                html+='            <button type="button" class="close" aria-label="Close" id= "removeItem_'+id+'" value='+id+' name='+id+' onClick="removeItem('+id+');">  ';
                html+='                        <span aria-hidden="true" style=" color: red;margin-right: 5px; ">&times;</span>';
                html+='                    </button>';
                html+='            </div>';
                html+='            <div class="card-body">';
                html+='                <div class="stat-widget-one" style=" text-align: center; font-size: x-large; " >';
                html+='                    <div class="stat-content dib">';
                html+='                        <div class="stat-digit">'+expenseTmp[i].expense_other_name +'</div>';
                html+='                        <div class="">ราคา '+expenseTmp[i].price+' บาท</div>';
                html+='                        <div class="">รวม '+expenseTmp[i].price +' บาท</div>';
                html+='                    </div>';
                html+='                </div>';
                html+='            </div>';
                html+='        </div>';
                html+='    </div> ';

            }


        }
        jQuery("#main #displayItem").html(html);
        calOther();

    }
}

function calOther(){
    var other =0;
    var dis=0;
    for(var i=0;i<expenseTmp.length;i++){
        if(expenseTmp[i].pay_type=="product"){
            other += expenseTmp[i].amount*expenseTmp[i].price;
        }else{
            other +=parseFloat(expenseTmp[i].price);
        }
        if(!isNaN(expenseTmp[i].discount)){
            dis = expenseTmp[i].discount;
        }
        other = (other-dis);

    }
    jQuery("#main #otherPay").val(other.toFixed(2));
}

function validatePay(){
  var otherPay =  jQuery("#main #otherPay").val();
  var expense_amount =jQuery("#main #expense_amount").val();
  var debt = jQuery("#main #debt").val();


  var expense_amountInt=0;
  var debtInt=0;
  if(expense_amount != undefined && expense_amount!=""){
    expense_amountInt = parseFloat(expense_amount);
  }
  if(debt != undefined && debt!=""){
    debtInt = parseFloat(debt);
  }

  if( otherPay != (expense_amountInt+debtInt)){
        alert("จำนวนเงินไม่ถูกต้อง");
    return false;
  }
  return true;

}


function clearInput(){
   jQuery("#main #product_div #amount").val('');
   jQuery("#main #product_div #price").val('');
   jQuery("#main #other_div #price").val('');
   jQuery("#main #product_add").select2('val',"0");
   jQuery("#main #expense_other_id").select2('val',"0");
   jQuery("#main #discount").val('');
   jQuery("#main #addExpense #debt").val('');
   jQuery("#criteria #canceled option[value='N']").prop('selected',true);

}





function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}


