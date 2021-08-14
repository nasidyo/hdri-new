var incomeTmp =[];
var Table;
(function ($) {

    $("#main #idRiverBasin").select2();
    $("#main #idArea").select2();
    $("#main #institute_id").select2();
    $("#main #addIncome #customer").select2();
    $("#main #product").select2();
    $("#main #customer_search").select2();
    $("#main #product_add").select2();
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

    $('#income .receiveDateTmp').datepicker({
        format: "dd MM yyyy",
        language:  'th',
        changeMonth: false,
        changeYear: false,
        thaiyear: true,
        stepMonths: 0 ,
        todayBtn: true,
        todayHighlight: true
    }).datepicker("setDate",c);




    Table = $('#main #incomeTable').DataTable({
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
        ajax: {url:"../server_side/incomeSS.php?idRiverBasin="+$("#main #idRiverBasin").val()+"&idArea="+$("#main #idArea").val()+"&market_id="+$("#main #criteria #market_id option:selected").val()+"&canceled="+$("#main #criteria #canceled option:selected").val(),"type": "GET"},
        order: [[ 12, "desc" ]],
        columnDefs: [{
                        'targets': [11],
                        'width': 40,
                        'searchable': false,
                        'orderable': false,
                        'className': 'dt-header-center',
                        'render': function (data, type, full, meta){
                            return '<div style=" font-size: 20px; "  ><i class="fa fa-edit" style=" cursor: pointer;margin-right: 10px;" data-toggle="modal" data-target="#editIncome" data-id="'+full[12]+'" id="editIncome"></i> </div>';
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

                    }
                    else{
                        if(data[8]!="" && data[8] >0){
                            $(row).addClass('red');
                        }else{
                            $(row).addClass('green');
                        }


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

                    all = api
                    .column( 5 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
                    all_discount = api
                    .column( 6 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
                    total = api
                    .column( 7 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );



                    debt = api
                    .column( 8 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    $("#all_other").html(numberWithCommas(all) +' บาท');
                    $("#all_discount").html(numberWithCommas(all_discount) +' บาท');
                    $("#pay_all").html(numberWithCommas(total) +' บาท');
                    $("#debtOther").html(numberWithCommas(debt) +' บาท');

                }
    });


    $("#main #addIncomeBt").on('click',function(){
        addIncomeDB();
    })
    $("#main #search_income").on('click',function(){
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
             }
         });
     });

     $('#main #addIncome #idRiverBasin').change(function(){
        var idRiverBasin = $(this).val();
         $.ajax({
             url:"../util/AreaDependentWithRole.php",
             method:"POST",
             data:{idRiverBasin:idRiverBasin,idArea:$("#AreaAll").val()},
             dataType:"text",
             success:function(data){
                 $('#main #addIncome #idArea').html(data);
             },complete:function(){
                $('#main #addIncome #idArea').trigger('change');

             }
         });
     });

     $('#main #addIncome #idRiverBasin').trigger('change');


     $('#main #addIncome #idArea').change(function(){
        var idArea = $(this).val();
         $.ajax({
             url:"../util/InstituteDependent.php",
             method:"GET",
             data:{idArea:idArea},
             dataType:"text",
             success:function(data){
                 $('#main #addIncome #institute_id').html(data);
             },complete:function(){
                $('#main #addIncome #institute_id').trigger('change');
             }
         });
     });

     $('#main #addIncome #institute_id').change(function(){
        var institute_id = $(this).val();
         $.ajax({
             url:"../util/loadSubGroupbyIns.php",
             method:"POST",
             data:{institute_id:institute_id},
             dataType:"text",
             success:function(data){
                 $('#main #addIncome #sub_group_id').html(data);
             },complete:function(){
                $('#main #addIncome #sub_group_id').trigger('change');
             }
         });
     });

     $('#main #addIncome #sub_group_id').change(function(){
        var sub_group_id = $(this).val();
         $.ajax({
             url:"../util/loadBusinessBySubGroup.php",
             method:"POST",
             data:{sub_group_id:sub_group_id},
             dataType:"text",
             success:function(data){
                 $('#main #addIncome #business_group_id').html(defaultData+data);
             }
         });
     });

     $('#main #addIncome #sub_group_id').change(function(){
        var sub_group_id = $(this).val();
         $.ajax({
             url:"../util/loadPersonFromSubGroup.php",
             method:"POST",
             data:{sub_group_id:sub_group_id},
             dataType:"text",
             success:function(data){
                 $('#main #addIncome #customer').html(data);
             },complete:function(){
                $('#main #addIncome #customer').select2();
             }
         });
     });



     $('#main #addIncome #institute_id').change(function(){
        var institute_id = $(this).val();
         $.ajax({
             url:"../util/loadOrderByIns.php",
             method:"POST",
             data:{institute_id:institute_id},
             dataType:"text",
             success:function(data){
                 $('#main #addIncome #product_add').html(data);
             }
         });
     });

     $('#main #addIncome #product_add').change(function(){
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

     $('#main #addIncome #institute_id').change(function(){
        var institute_id = $(this).val();
         $.ajax({
             url:"../util/loadOtherIncomeByIns.php?institute_id="+institute_id,
             method:"GET",
             dataType:"text",
             success:function(data){
                 $('#main #addIncome #income_other_id').html(data);
             }
         });
     });



      $('#addIncomeOther').on('hide.bs.modal', function (e) {
        $('#main #addIncome #institute_id').trigger('change');

      });

      $("#main input:radio[name='pay_type']").on('change', function (event) {
        if(this.value=='product'){
          $("#main #product_div").show(300);
          $("#main #other_div").hide(300);
        }else{
          $("#main #product_div").hide(300);
          $("#main #other_div").show(300);
        }
});



      $("#main input[name='receiveDate']").datepicker("setDate", new Date());



     /* $("#main #receive_amount").on("blur",function(){
        var otherPay =  parseFloat(jQuery("#main #otherPay").val()==""?0:jQuery("#main #otherPay").val()) ;
        var receive_amount = parseFloat(jQuery("#main #receive_amount").val()==""?0:jQuery("#main #receive_amount").val());
       // var debt = parseFloat(jQuery("#main #debt").val()==""?0:jQuery("#main #debt").val()) ;
        var result=0;
        if(otherPay > receive_amount ){
            result = otherPay - receive_amount;
        }
        if(receive_amount >= otherPay){
            jQuery("#main #receive_amount").val(0);
        }else{
            $("#main #debt").val(result.toFixed(2));
            jQuery("#main #receive_amount").val(receive_amount.toFixed(2));
        }



    });

    $("#main #debt").on("blur",function(){
        var otherPay =  parseFloat(jQuery("#main #otherPay").val()==""?0:jQuery("#main #otherPay").val()) ;
       // var expense_amount = parseFloat(jQuery("#main #expense_amount").val()==""?0:jQuery("#main #expense_amount").val());
        var debt = parseFloat(jQuery("#main #debt").val()==""?0:jQuery("#main #debt").val()) ;
        var result=0;
        if(otherPay > debt ){
            result = otherPay - debt;
        }
        if(debt>=otherPay){
            jQuery("#main #debt").val(0);
        }else{
            $("#main #receive_amount").val(result.toFixed(2));
            jQuery("#main #debt").val(debt.toFixed(2));
        }


    });*/

    $("#main #debt").on("keyup",function(){
        var otherPay =  parseFloat(jQuery("#main #otherPay").val()==""?0:jQuery("#main #otherPay").val()) ;

         var debt = parseFloat(jQuery("#main #debt").val()==""?0:jQuery("#main #debt").val()) ;
         var result=0;
         if(otherPay >= debt ){
             result = otherPay - debt;
             jQuery("#main #receive_amount").val(result.toFixed(2));
         }else{

                 jQuery("#main #debt").val(0);
                 jQuery("#main #receive_amount").val(0);

         }
    })
    $("#main #receive_amount").on("keyup",function(){
        var otherPay =  parseFloat(jQuery("#main #otherPay").val()==""?0:jQuery("#main #otherPay").val()) ;
        var receive_amount = parseFloat(jQuery("#main #receive_amount").val()==""?0:jQuery("#main #receive_amount").val());

         var result=0;
         if(otherPay >= receive_amount ){
             result = otherPay - receive_amount;
             jQuery("#main #debt").val(result.toFixed(2));
         }else{

                 jQuery("#main #debt").val(0);
                 jQuery("#main #receive_amount").val(0);

         }
    })



    $('#main .close').click(function(){
        $('#main #newsHeading').parent().slideUp();
      })




    $("#main #addIncomeTmp").on('click',function(){
        addIncomeTmp();

    });


    function addIncomeTmp(){
        var institute_id = $("#main #addIncome #institute_id option:selected").val();
        var order_id = $("#main #addIncome #product_add option:selected").val();
        var order_name = $("#main #addIncome #product_add option:selected").text();
        var customer = $("#main #addIncome #customer option:selected").val();
        var other_customer = $("#main #addIncome #other_customer").val();
        var pay_type = $("#main input[name='pay_type']:checked").val();
        var amount=0;
        var price=0;
        var income_other_id=0;
        var income_other_name="";
        var idStaff = $("#idStaff").val();
        var discount = 0;
        var doc_no = $("#main #addIncome #doc_no").val();
        var market_id =$("#main #addIncome #market_id").val();
        var balance = $("#main #addIncome #balance").text();
        var receiveDate="";

        var sub_group_id = $("#main #addIncome #sub_group_id option:selected").val();
        var business_group_id = $("#main #addIncome #business_group_id option:selected").val();

        if(jQuery("#main #receiveDate").val()!=""){
            receiveDate =  deltaDate(new Date(jQuery("#main #receiveDate").val()),0,0,-543).toLocaleDateString('en-US').substring(0, 10);
         }
        if(pay_type =="product"){
            amount = $("#main #product_div #amount").val();
            price = $("#main #product_div #price").val()?$("#main #product_div #price").val():0;
            discount = parseFloat($("#main #addIncome #discount").val()?$("#main #addIncome #discount").val():0);
            if(balance==0 || balance == undefined){
                alert('สินค้าในคลังหมด');
                return false;
            }

            if(balance!=0 && parseInt(amount) > parseInt(balance) ){
                alert('จำนวนสินค้าไม่ถูกต้อง');
                return false;
            }


        }else{
            income_other_id = $("#main #other_div #income_other_id option:selected").val();
            income_other_name = $("#main #other_div #income_other_id option:selected").text();
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
            json["price"]=parseFloat(price).toFixed(2) ;
            json["order_name"]=order_name;
            json["receive_by"]=parseInt(idStaff);
            json["create_by"]=parseInt(idStaff);
            json["receive_date"] = receiveDate;
            json["discount"] = discount;
            json["doc_no"] = doc_no;
            json["market_id"] = market_id;
            json["income_other_id"]=parseInt(income_other_id);
            json["income_other_name"]=income_other_name;
            json["pay_type"]=pay_type;

            json["sub_group_id"]=sub_group_id;
            json["business_group_id"]=business_group_id;




           incomeTmp.push(json);
            displayOrder();
            clearInput();

    }
    function addIncomeDB(){

        if(validatePay()){
            var receive_amount = parseFloat($("#main #addIncome #receive_amount").val());
            for ( var i in incomeTmp ) {
                var form_data = new FormData();
                for ( var key in incomeTmp[i] ) {
                    form_data.append(key, incomeTmp[i][key]);
                }
                var result =0;
                if( incomeTmp[i]["income_other_id"]==0){
                    result = (incomeTmp[i]['price'] * incomeTmp[i]['amount']) - incomeTmp[i]['discount'];
                }else{
                    result = incomeTmp[i]['price']  - incomeTmp[i]['discount'];
                }

                    if(receive_amount>=result){
                        form_data.append('receive_amount',result);
                        receive_amount =receive_amount-result;
                    }else{
                        form_data.append('receive_amount',receive_amount);
                        form_data.append('debt',result-receive_amount);
                        receive_amount=0;
                    }
                form_data.append('action','add');
                form_data.append('canceled',"N");



               $.ajax({
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType:'text',
                    data:form_data,
                    url: "../handler/incomeHandler.php",
                    dataType: "html",
                    success: function(data) {
                        if(data.trim()!=""){
                            alert(data);
                        }
                      removeItem(form_data.get("tmp_id"));
                      $("#main #receive_amount").val('');
                    },complete:function(){
                        incomeTmp =[];
                        displayOrder();
                        clearInput();
                        Table.ajax.reload();
                    }
                  });
                }

        }

    }

    function search(){
        if(Table!=undefined){
            Table.destroy();
        }

        var debt="N";
        var fromDate="";
        var toDate="";
        if($("#main #criteria #debt_search").prop("checked")){
            debt ="Y";
         }
         if(jQuery("#main #searchFromDate").val()!=""){
            fromDate =  dateToDB(deltaDate(new Date(jQuery("#main #searchFromDate").val()),0,0,-543).toLocaleDateString('en-US').substring(0, 10));
         }

         if(jQuery("#main #searchToDate").val()!=""){
            toDate =  dateToDB(deltaDate(new Date(jQuery("#main #searchToDate").val()),0,0,-543).toLocaleDateString('en-US').substring(0, 10));
         }

         var sub_group_id =jQuery("#main #criteria #sub_group_id option:selected").val();
         var business_group_id =jQuery("#main #criteria #business_group_id option:selected").val();


        Table = $('#main #incomeTable').DataTable({
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
            ajax: {url:"../server_side/incomeSS.php?idRiverBasin="+$("#main #criteria #idRiverBasin").val()+"&idArea="+$("#main #criteria #idArea").val()+"&id="+$("#main #criteria #institute_id").val()+'&customer='+$("#main #criteria #customer_search option:selected").val()+"&other_customer="+$("#main #criteria #other_customer").val()+"&order_id="+$("#main #criteria #product option:selected").val()+"&income_other_id="+$("#main #criteria #income_other_id option:selected").val()+"&doc_no="+$("#main #criteria #doc_no").val()+"&fromDate="+fromDate+"&toDate="+toDate+"&canceled="+$("#main #criteria #canceled option:selected").val()+"&market_id="+$("#main #criteria #market_id option:selected").val()+"&debt="+debt+"&business_group_id="+business_group_id+"&sub_group_id="+sub_group_id,"type": "GET"},
            order: [[ 12, "desc" ]],
            columnDefs: [{
                            'targets': [11],
                            'width': 40,
                            'searchable': false,
                            'orderable': false,
                            'className': 'dt-header-center',
                            'render': function (data, type, full, meta){
                                return '<div style=" font-size: 20px; "  ><i class="fa fa-edit" style=" cursor: pointer;margin-right: 10px;" data-toggle="modal" data-target="#editIncome" data-id="'+full[12]+'" id="editIncome"></i> </div>';
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

                        }
                        else{
                            if(data[8]!="" && data[8] >0){
                                $(row).addClass('red');
                            }else{
                                $(row).addClass('green');
                            }


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

                        all = api
                        .column( 5 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                        all_discount = api
                        .column( 6 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                        total = api
                        .column( 7 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );



                        debt = api
                        .column( 8 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                        $("#all_other").html(numberWithCommas(all) +' บาท');
                        $("#all_discount").html(numberWithCommas(all_discount) +' บาท');
                        $("#pay_all").html(numberWithCommas(total) +' บาท');
                        $("#debtOther").html(numberWithCommas(debt) +' บาท');

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


function removeItem(tmp_id){
    console.log(tmp_id);
    for(var i=0;i<incomeTmp.length;i++){
        if(incomeTmp[i].tmp_id == tmp_id){
             incomeTmp.splice(i, 1) ;
             jQuery("#main button[name='"+tmp_id+"']").parents("#main #cardItem").html('');
             displayOrder();
        }
    }
}


function displayOrder(){
    var html="";
    var id="";
    if(incomeTmp!=null){
        for(var i=0;i<incomeTmp.length;i++){

                id = incomeTmp[i].tmp_id;
                if(incomeTmp[i].pay_type == "product"){
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
                    html+='                        <div class="stat-digit">'+incomeTmp[i].order_name +'</div>';
                    html+='                        <div class="">จำนวน '+incomeTmp[i].amount+' หน่วย</div>';
                    html+='                        <div class="">ราคา '+incomeTmp[i].price+' บาท</div>';
                    html+='                        <div class="">รวม '+(incomeTmp[i].amount*incomeTmp[i].price) +' บาท</div>';
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
                    html+='                        <div class="stat-digit">'+incomeTmp[i].income_other_name +'</div>';
                    html+='                        <div class="">ราคา '+incomeTmp[i].price+' บาท</div>';
                    html+='                        <div class="">รวม '+(incomeTmp[i].price) +'บาท</div>';
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
    for(var i=0;i<incomeTmp.length;i++){

        if(incomeTmp[i].pay_type=="product"){
            other += incomeTmp[i].amount*incomeTmp[i].price;
        }else{
            other +=parseInt(incomeTmp[i].price);
        }
        if(!isNaN(incomeTmp[i].discount)){
            dis = incomeTmp[i].discount;
        }
        other = (other-dis);

    }
    jQuery("#main #otherPay").val(other.toFixed(2));
}

function validatePay(){
  var otherPay =  jQuery("#main #otherPay").val();
  var receive_amount =jQuery("#main #addIncome #receive_amount").val();
  var debt = jQuery("#main #addIncome #debt").val();


  var receive_amountInt=0;
  var debtInt=0;
  if(receive_amount != undefined && receive_amount!=""){
    receive_amountInt = parseFloat(receive_amount);
  }
  if(debt != undefined && debt!=""){
    debtInt = parseFloat(debt);
  }

  if( otherPay != (receive_amountInt+debtInt)){
        alert("จำนวนเงินไม่ถูกต้อง");
    return false;
  }
  return true;

}

function clearInput(){
   jQuery("#main #product_div #amount").val('');
   jQuery("#main #product_div #price").val('');
   jQuery("#main #product_add").select2('val',"0");
   jQuery("#main #discount").val('');
   jQuery("#main #debt").val('');


}



function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}
