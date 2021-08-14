(function ($) {

    var spinner = $('#loader');
    var area_Id = $('#area_Id').val();
    var yearsId = $('#yearsId').val();
    var monthId = $('#monthId').val();
    var permssion = $('#permssion').val();
    var listimage = null;
    var yearsId = $('#yearsId').val();
    var monthId = $('#monthId').val();
    var area_Id = $('#area_Id').val();
    var yearsStart = 2563;
    var yearsEnd = 2563;
    var monthIdStart = 0;
    var monthIdEnd = 0;
    if(monthId == 1){
        monthIdStart = 2;
        monthIdEnd = monthId;
    }else if (monthId == 12){
        monthIdStart = monthId;
        monthIdEnd = 0;
    }else{
        monthIdStart = monthId;
        monthIdEnd = monthId;
    }
    if(monthId >= 8){
        yearsStart = (yearsId-544);
        if(monthId == 12){
            yearsEnd = (yearsId-543);
        }else{
            yearsEnd = (yearsId-544);
        }
    }else{
        yearsStart = (yearsId-543);
        yearsEnd = yearsStart;
    }
    console.log(yearsStart, ";;", monthIdStart, ";;" ,monthId, ";;", monthIdEnd, ';;', yearsEnd);
    console.log(area_Id);
    console.log(yearsId);
    console.log(monthId);
    $('#typeOfAgri_id').select2();
    $('#agri').select2();
    $('#gardProduct').select2();
    initTable();
    datatableinit();
    function datatableinit() {
        var Table = $('#deliverProductList-Table').DataTable( {
            // "dom":'<"top"i>Brt<"bottom"lp><"clear">',
            "rowReorder": {
                "selector": 'td:nth-child(2)'
            },
            "responsive": true ,
            "dom": '<"topbuttons"B>frt<"bottombuttonsBX">ip',
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
                              'columns': [6,7,8,9,10,11,12,13,14,15,16]
                          },
                          'title': 'ข้อมูลการส่งมอบผลผลิต',
                    },
      
                    { 'extend':'csv',
                    'action':newexportaction ,
                    'exportOptions': {
                      'modifier': {
                        'page': 'All',
                        'search': 'none'
                        },
                        'columns': [6,7,8,9,10,11,12,13,14,15,16]
                      },
                      'title': 'ข้อมูลการส่งมอบผลผลิต',
                    },
      
                    { 'extend':'excel',
                    'action':newexportaction ,
                    'exportOptions': {
                      'modifier': {
                        'page': 'All',
                        'search': 'none'
                        },
                        'columns': [6,7,8,9,10,11,12,13,14,15,16]
                      },
                      'title': 'ข้อมูลการส่งมอบผลผลิต',
                    },
                    { 'extend':'print',
                    'action':newexportaction ,
                    'exportOptions': {
                      'modifier': {
                        'page': 'ALL',
                        'search': 'none'
                        },
                        'columns': [6,7,8,9,10,11,12,13,14,15,16]
                      },
                      'title': 'ข้อมูลการส่งมอบผลผลิต',
                    },
                  ]
              }],
            "processing": true,
            "serverSide": true,
            "ajax": "../server_side/deliverProductList.php?area_Id="+area_Id+"&yearsId="+yearsId+"&monthId="+monthId,
            "autoWidth": false,
            "createdRow": function( row, data, dataIndex){
                if( data[12] ==  '0.0' || data[14] ==  '0'){
                    $(row).addClass('redClass');
                }
                if(data[17] ==  '1'){
                    $(row).addClass('buleClass');
                }
            },
            'fixedColumns':   {
              'heightMatch': 'none'
            },
            'columnDefs': [{
                "targets": [0,1,2,3,4,17,18],
                "visible": false
            },{
                "targets": [2],
                'width': 30,
            },{
                "targets": [5],
                'width': 80,
                'searchable': false,
                'orderable': false,
                'render': function (data, type, row){
                    return "<center><input type='checkbox' class='delete_check' id='delcheck_"+row[0]+"' onclick='checkcheckbox();' value='"+row[0]+"'></center>";
                }
            }
            // ,{
            //     "targets": [11,12],
            //     'render': function (data){
            //         return toMoney(parseFloat(data));
            //     }
            // }
            ,{
                "targets": [12],
                'render': function (data,type,row){
                    if(permssion == "staff" || permssion == "admin"){
                        if($('#statusId').val() == "2" || $('#statusId').val() == "4"){
                            return toMoney(parseFloat(data));
                        }else{
                            return "<div style=' font-size: 20px; '><input id='"+row[0]+"_totalQuality' name='"+row[0]+"_totalQuality' value='"+parseFloat((data)).toFixed(2)+"' onkeypress='return isNumberKey(this,event)' class='form-control' type='text'></div>";
                        }
                    }else{
                        return toMoney(parseFloat(data));
                    }
                }
            },{
                "targets": [13],
                'render': function (data,type,row){
                    if(permssion == "staff" || permssion == "admin"){
                        if($('#statusId').val() == "2" || $('#statusId').val() == "4"){
                            return toMoney(parseFloat(data));
                        }else{
                            return "<div style=' font-size: 20px; '><input id='"+row[0]+"_priceProduct' name='"+row[0]+"_priceProduct' value='"+parseFloat((data)).toFixed(2)+"' onkeypress='return isNumberKey(this,event)' class='form-control' type='text'></div>";
                        }
                    }else{
                        return toMoney(parseFloat(data));
                    }
                }
            },{
                    "targets": [14],
                    'render': function (data){
                        return toMoney(parseFloat(data));
                    }
            },{
                'targets': [19],
                'width': 130,
                'searchable': false,
                'orderable': false,
                'className': 'dt-header-center',
                'render': function (data, type, row){
                    if(permssion == "staff" || permssion == "admin" || permssion == 'powerUserMarket'){
                        if($('#statusId').val() == "2" || $('#statusId').val() == "4"){
                            return '<div style=" font-size: 20px; "><center>'
                            +'<i class="fa fa-eye" style="cursor: pointer;margin-right: 10px; color: green;" id="viewDeliverBtn" name ="viewDeliverBtn"></i>'
                            +'</center></div>';
                        }else{
                            return '<div style=" font-size: 20px; "><center>'
                            +'<i class="fa fa-edit" style=" cursor: pointer;margin-right: 10px; color: blue;" name="edit_data" id="edit_data"></i>'
                            +'<i class="fa ti-trash" style="cursor: pointer;margin-right: 10px; color: red;" id="deleteDeliver"></i>'
                            // +'<i class="fa fa-eye" style="cursor: pointer;margin-right: 10px; color: green;" id="viewDeliverBtn" name ="viewDeliverBtn"></i>'
                            +'</center></div>';
                        }
                    // }else{
                    //     return '<div style=" font-size: 20px; "><center>'
                    //     +'<i class="fa fa-eye" style="cursor: pointer;margin-right: 10px; color: green;" id="viewDeliverBtn" name ="viewDeliverBtn"></i>'
                    //     +'</center></div>';
                    }
                    
                }
            }
            ]
        } );
    }
    // var Table = $('#deliverProductList-Table').DataTable();
    // if( $('#statusId').val() == "2" || $('#statusId').val() == "4" || permssion == 'manager' || permssion == 'powerUserMarket'){
    //     var table = $('#deliverProductList-Table').DataTable();
    //     // Hide two columns
    //     table.columns([16]).visible( false );
    // }
    $('#typeOfAgri_id').change(function(){
        Table = $('#deliverProductList-Table').DataTable();
        $("#support_form").remove();
        $("#support_card").hide();
        var tpyeOfAgri_Id = $(this).val();
        if(tpyeOfAgri_Id != '0'){
            $.ajax({
                url:"../util/loadAgriProduct.php",
                method:"POST",
                data:{tpyeOfAgri_Id:tpyeOfAgri_Id, area_Id:area_Id},
                dataType:"text",
                success:function(data){
                    $('#agri').html(data);
                    Table.columns( 1 ).search(tpyeOfAgri_Id, true, false).draw();
                }
            });
        }else{
            $('#agri').html("<option value='0'>กรุณาเลือก</option>");
            Table.columns().search("").draw();
        }
        initTable();
     });

     $('#agri').change(function(){
        Table = $('#deliverProductList-Table').DataTable();
        $("#support_form").remove();
        var argi_id = $(this).val();
        if(argi_id != '0'){
            $.ajax({
                url:"../util/loadAgriTagetUintPlan.php",
                method:"POST",
                data:{argi_id:argi_id},
                dataType:"text",
                success:function(data){
                    $('#support_part').append(data);
                    Table.columns( 2 ).search(argi_id, true, false).draw();
                }
            });
        }else{
            Table.columns(2).search("").draw();
        }
        $.ajax({
            url:"../util/loadSpeciesDW.php",
            method:"POST",
            data:{argi_id:argi_id},
            dataType:"text",
            success:function(data){
                var listdata = "<option value='ALL'>ทั้งหมด</option>"+data;
                $('#speciesId').html(listdata);
            }
        });
        $.ajax({
            url:"../util/loadProductGradeSerach.php",
            method:"POST",
            data:{agri_Id:argi_id, area_Id:area_Id},
            dataType:"text",
            success:function(data){
                $('#gardProduct').html(data);
            }
        });
        
        console.log(argi_id , 'ddddd   ', area_Id);
        initTable();
     });

    // select 2
    $('.month-dropdown').select2();
    $('.marketList-dropdown').select2();
    $('#farmer_Id').select2();
    $('#market_id').select2();

    $('#totalQuality').keyup(function(){
        caltotalofprice();
    });
    $('#pricePerProduct').keyup(function(){
        caltotalofprice();
    });

    $('#market_id').change(function(){
        var Table = $('#deliverProductList-Table').DataTable();
        console.log($(this).val());
        var market_id = $(this).val();
        if(market_id != '0'){
            Table.columns( 4 ).search(market_id, true, false).draw();
        }else{
            Table.columns(4).search("").draw();
        }
        initTable();
     });

    $('#farmer_Id').change(function(){
        var Table = $('#deliverProductList-Table').DataTable();
        console.log($(this).val());
        var farmer_Id = $(this).val();
        if(farmer_Id != '0'){
            Table.columns( 3 ).search(farmer_Id, true, false).draw();
        }else{
            Table.columns( 3 ).search("").draw();
        }
        initTable();
    });

    $('#gardProduct').change(function(){
        var Table = $('#deliverProductList-Table').DataTable();
        console.log($(this).val());
        var idTypeOfStand = $(this).val();
        if(idTypeOfStand.toString != "all"){
            Table.columns( 15 ).search(idTypeOfStand, true, false).draw();
        }else{
            Table.columns( 15 ).search("").draw();
        }
        initTable();
    });

    function caltotalofprice() {
        var first_number = $('#totalQuality').val();
        var second_number = $('#pricePerProduct').val(); 
        var result = parseFloat(first_number)*parseFloat(second_number);
        if(result >= 0){
                $('#totalpriceOfPlan').val(result);
            }else{
                $('#totalpriceOfPlan').val(0);
            }
    }
    $('#addNewBtn').on('click', function () {
        window.location = "./deliverProducts.php?area_Id="+area_Id+"&yearsId="+yearsId+"&monthId="+monthId;
    });
    $('#sendPlanProduct').on('click',function(){
        var area_Id = $('#area_Id').val();
        var yearsId = $('#yearsId').val();
        var monthId = $('#monthId').val();
        var x = confirm("ต้องการส่งมอบผลผลิตประจำเดือน ?");
        if(x){
            $.ajax({
                url:"../handler/deliverProductHandler.php",
                method:"POST",
                data:{area_Id:area_Id, yearsId:yearsId, monthId:monthId, action:"checkPrinceIsmissing"},
                dataType:"text",
                success:function(data){
                    if(parseInt(data) == '0') {
                        alert ('กรุณากรอกปริมาณและราคาให้ครบ (ช่องสีแดง)')
                    }else{
                        $.ajax({
                            url:"../handler/deliverProductHandler.php",
                            method:"POST",
                            data:{area_Id:area_Id, yearsId:yearsId, monthId:monthId, action:"updataStatus", statusId:"4"},
                            dataType:"text",
                            success:function(data){
                                window.location = "./deliverProductListOfYear.php?area_Id="+area_Id+"&yearsId="+yearsId;
                            }
                        });
                    }
                }
            });
        }
    });
    $('#confirmBtn').on('click',function(){
        var area_Id = $('#area_Id').val();
        var yearsId = $('#yearsId').val();
        var monthId = $('#monthId').val();
        var x = confirm("ยืนยันส่งมอบผลผลิตประจำเดือน ?");
        if(x){
            $.ajax({
                url:"../handler/deliverProductHandler.php",
                method:"POST",
                data:{area_Id:area_Id, yearsId:yearsId, monthId:monthId, action:"updataStatus", statusId:"4"},
                dataType:"text",
                success:function(data){
                    window.location = "./deliverProductListOfYear.php?area_Id="+area_Id+"&yearsId="+yearsId;
                }
            });
        }
    });
    $('#backToEditBtn').on('click',function(){
        var area_Id = $('#area_Id').val();
        var yearsId = $('#yearsId').val();
        var monthId = $('#monthId').val();
        var x = confirm("แจ้งแก้ไขการส่งมอบผลผลิต ?");
        if(x){
            $.ajax({
                url:"../handler/deliverProductHandler.php",
                method:"POST",
                data:{area_Id:area_Id, yearsId:yearsId, monthId:monthId, action:"updataStatus", statusId:"3"},
                dataType:"text",
                success:function(data){
                    window.location = "./deliverProductListOfYear.php?area_Id="+area_Id+"&yearsId="+yearsId;
                }
            });
        }
    });
    $('.form_date').datepicker({
        format: "dd MM yyyy",
        language:  'th',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        minView: 2,
        thaiyear: true
    });
    $('#deliverProductList-Table tbody').on('click', '#edit_data', function () {
        var Table = $('#deliverProductList-Table').DataTable();
        var data = Table.row( $(this).parents('tr') ).data();
        var idPersonMarket = data[0];
        $('#idPersonMarket').val(idPersonMarket);
        $('#editDeliverProductDetail').modal('show');
        $.ajax({
            url: "../server_side/loadDeliverProductDetail.php?idPersonMarket="+idPersonMarket,
            type: "GET",
            dataType: "json",
            success: function(data) {
                console.log(data.data[0]);
                mapDataPerson(data.data[0]);
            }
        });
    });
    $('#deliverProductList-Table tbody').on('click', '#deleteDeliver', function () {
        var Table = $('#deliverProductList-Table').DataTable();
        if (!confirm("ต้องการลบข้อมูลการส่งมอบนี้หรือไม่")){
            return false;
        }else{
            spinner.show();
            var data = Table.row( $(this).parents('tr') ).data();
            var idPersonMarket = data[0];
            $.ajax({
                url: "../handler/deliverProductHandler.php",
                type: "POST",
                dataType: "html",
                async: false,
                data:{idPersonMarket:idPersonMarket, action:"delete"},
                success:function(data){
                    initTable();
                    $('#deliverProductList-Table').DataTable().ajax.reload();
                    // window.location = "./deliverProductList.php?area_Id="+area_Id+"&yearsId="+yearsId+"&monthId="+monthId;
                },complete:function(){
                    spinner.hide();
                }
            });
        }
    });

    function mapDataPerson(data){
        $('#namePerson').val(data[0]);
        $('#person_id').val(data[1]);
        $('#market_Id option[value="'+data[9]+'"]').attr("selected",true);
        if(data[6] != null){
            $('#quality').val(parseFloat(data[6]));
        }else{
            $('#quality').val(0);
        }
        if(data[8] != null){
            $('#price').val(parseFloat(data[8]));
        }else{
            $('#price').val(0);
        }
        if(data[7] != null){
            $('#totalPricre').val(parseFloat(data[7]));
        }else{
            $('#totalPricre').val(0);
        }
        $('#dateDeliver').val(data[2]);
        if(data[12] == null){
            $('#lossValue').val(0);
            caltotalofLossValue();
        }else{
            $('#lossValue').val(parseFloat(data[12]));
            caltotalofLossValue();
        }
        var date = new Date();
        $('.dateAll').datepicker({
            format: "dd MM yyyy",
            language:  'th',
            // changeMonth: false,
            // changeYear: false,
            startDate: new Date(yearsStart,monthIdStart-1,1),
            // endDate: new Date(yearsEnd, monthIdEnd, 0),
            thaiyear: true,
            stepMonths: 0
        });
        console.log(data[15]);
        $('#dateCultivate').datepicker("setDate", new Date (data[15]));
        $('#dateHarvest').datepicker("setDate", new Date (data[16]));
        $.ajax({
            url:"../util/loadTypeOfAgriFromFarmer.php",
            method:"POST",
            data:{person_Id:data[1], area_Id:area_Id},
            dataType:"text",
            success:function(data){
                $('#typeAgri_Id').html(data);
            },
            complete:function(){
                $('#typeAgri_Id option[value="'+data[5]+'"]').attr("selected",true);
                $.ajax({
                    url:"../util/loadAgriFromFarmer.php",
                    method:"POST",
                    data:{tpyeOfAgri_Id:data[5], area_Id:area_Id, person_Id:data[1]},
                    dataType:"text",
                    success:function(data){
                        $('#agri_Id').html(data);
                    },
                    complete:function(){
                        $('#agri_Id option[value="'+data[4]+'"]').attr("selected",true);
                        $.ajax({
                            url:"../util/loadProductStandard.php",
                            method:"POST",
                            data:{agri_Id:data[4]},
                            dataType:"text",
                            success:function(data){
                                $('#standardProduct').html(data);
                            },complete:function(){
                                $('#standardProduct option[value="'+data[10]+'"]').attr("selected",true);
                            }
                        });
                        $.ajax({
                            url:"../util/loadProductGradeFromAgri.php",
                            method:"POST",
                            data:{agri_Id:data[4], area_Id:area_Id},
                            dataType:"text",
                            success:function(data){
                                $('#gardsProduct').html(data);
                            },complete:function(){
                                $('#gardsProduct option[value="'+data[3]+'"]').attr("selected",true);
                            }
                        });
                        $.ajax({
                            url:"../util/loadLandDetail.php",
                            method:"POST",
                            data:{person_Id:data[1]},
                            dataType:"text",
                            success:function(data){
                                $('#landDetail').html(data);
                            },complete: function (){
                                $('#gardsProduct option[value="'+data[11]+'"]').attr("selected",true);
                                $('#logistic_Id option[value="'+data[13]+'"]').attr("selected",true);
                            }
                        });
                    }
                });
                loadImageList(data[14]);
                getimagelist(data[14]);
            }
        });
    }
    function getimagelist(idPersonMarket){
        $.ajax({
            url:"../util/listImage.php",
            method:"POST",
            data:{idPersonMarket:idPersonMarket},
            dataType:"text",
            success:function(data){
                console.log(data);
                argi_group = JSON.parse(data);
                console.log(argi_group);
                var obj={};
                var listimage = [];
                // var obj={};
                // for(var key in data) {
                //     obj[data[key].split("=")[0]] = data[key].split("=")[1];
                // }
                // obj.listimage = listimage;
                // listDeliverProducts.push(obj);
                for(var key in argi_group) {
                    var obj={};
                    // console.log(argi_group[key].idImgTD);
                    obj['idimage'] = argi_group[key].idImgTD;
                    obj['parthImage'] = '../img/Activity/'+argi_group[key].ImgName;
                    listimage.push(obj)
                }
                console.log(listimage);
                //$('#unitCodeProduct').text(data);
            }
        });
    }
    caltotalofLossValue();
    caltotalofprice();
    var area_Id = $('#area_Id').val();

    $('#quality').keyup(function(){
        caltotalofLossValue();
        caltotalofprice();
    });
    $('#totalQuality').keyup(function(){
        caltotalofLossValue();
        caltotalofprice();
    });
    $('#lossValue').keyup(function(){
        caltotalofLossValue();
        caltotalofprice();
    });
    $('#price').keyup(function(){
        caltotalofLossValue();
        caltotalofprice();
    });

    function caltotalofprice() {
        var first_number = $('#totalQuality').val();
        var second_number = $('#price').val(); 
        var result = parseFloat(first_number)*parseFloat(second_number);
        if(result >= 0){
                $('#totalPricre').val(result);
            }else{
                $('#totalPricre').val(0);
            }
    }
    function caltotalofLossValue() {
        var first_number = $('#quality').val();
        var second_number = $('#lossValue').val();
        if(parseFloat(second_number) > parseFloat(first_number)){
            alert("ปริมาณสูญเสียไม่ควรมากกว่าปริมาณส่งมอบ")
            $('#lossValue').val(0);
            $('#totalQuality').val(first_number);
            return false
        }
        var result = parseFloat(first_number)-parseFloat(second_number);
        if(result >= 0){
            $('#totalQuality').val(result);
        }else{
            $('#totalQuality').val(first_number);
        }
    }
    $('#typeAgri_Id').change(function(){
        var typeAgri_Id = $(this).val();
        var person_Id = $('#farmer_Id').val();
        $.ajax({
            url:"../util/loadAgriFromFarmer.php",
            method:"POST",
            data:{tpyeOfAgri_Id:typeAgri_Id, area_Id:area_Id, person_Id:person_Id},
            dataType:"text",
            success:function(data){
                $('#agri_Id').html(data);
            }
        });
     });
    $('#agri_Id').change(function(){
        var agri_Id = $(this).val();
        loadUnitCodeOfProduct(agri_Id);
        loadGradeProduct(agri_Id, area_Id);
        loadProductStandard(agri_Id);
     });
    function loadUnitCodeOfProduct(agri_Id){
        $.ajax({
            url:"../util/loadUnitCodeOfProduct.php",
            method:"POST",
            data:{agri_Id:agri_Id},
            dataType:"text",
            success:function(data){
                $('#unitCodeProduct').text(data);
            }
        });
    }
    function loadGradeProduct(agri_Id, area_Id){
        $.ajax({
            url:"../util/loadProductGradeFromAgri.php",
            method:"POST",
            data:{agri_Id:agri_Id, area_Id:area_Id},
            dataType:"text",
            success:function(data){
                $('#gardProduct').html(data);
            }
        });
    }
    function loadProductStandard(agri_Id){
        $.ajax({
            url:"../util/loadProductStandard.php",
            method:"POST",
            data:{agri_Id:agri_Id},
            dataType:"text",
            success:function(data){
                $('#standardProduct').html(data);
            }
        });
    }
    function loadImageList(idPersonMarket){
        var idPersonMarket = idPersonMarket;
        $.ajax({
            url:"../util/listImageLogistic.php",
            method:"POST",
            data:{idPersonMarket:idPersonMarket},
            dataType:"text",
            success:function(data){
                $('#editImageTable tbody').html(data);
            }
        });
    }
    var listDeliverProducts = [];
    $("#editDeliverProduct" ).click(function() {
        spinner.show();
        listDeliverProducts = [];
        console.log(listimage);
        // var data222 =$("#editDeliverProductDetail :input").serialize().split("&");
        // console.log(data222);
        // var data = $("#deliverProduct_form").serialize();
        var area_Id = $('#area_Id').val();
        var yearsId = $('#yearsId').val();
        var monthId = $('#monthId').val();
        // var data = $("#deliverProduct_form").serialize().split("&");
        // console.log(data);
        var data =$("#editDeliverProductDetail :input").serialize().split("&");
        var obj={};
        for(var key in data) {
            obj[data[key].split("=")[0]] = data[key].split("=")[1];
        }
        obj.listimage = listimage;
        listDeliverProducts.push(obj);
        console.log(listDeliverProducts);
        if(obj.person_Id == '0' || obj.typeAgri_Id == '0' || obj.agri_Id == '0' || obj.market_Id == '0' || obj.quality == '' || obj.price == '' || obj.dtp_input3 == '' || obj.dtp_input4 == '' || obj.dtp_input2 == ''){
            alert("กรุณากรอกข้อมูลให้ครบถ้วน");
            spinner.hide();
            return false;
        }
        $.ajax({
            url:"../handler/deliverProductHandler.php",
            method:"POST",
            data:{data:listDeliverProducts, action:"update"},
            dataType:"text",
            success:function(data){
                $('#editDeliverProductDetail').modal('hide');
                spinner.hide();
                Table = $('#deliverProductList-Table').DataTable();
                Table.ajax.reload();
                //window.location = "./deliverProductList.php?area_Id="+area_Id+"&yearsId="+yearsId+"&monthId="+monthId;
            },complete:function(){
                initTable();
                //$('#showmodalList-table').DataTable().ajax.reload();
            }
        });
    });

    function initTable() {
        $("#dashTable tbody").html("");
        var area_Id = $('#area_Id').val();
        var yearsId = $('#yearsId').val();
        var monthId = $('#monthId').val();
        var typeOfAgri_id = $('#typeOfAgri_id option:selected').val();
        var agri = $('#agri option:selected').val();
        var farmer_Id = $('#farmer_Id option:selected').val();
        var market_id = $('#market_id option:selected').val();
        var gardProduct = $('#gardProduct option:selected').val();
        // if(gardProduct == 'all'){
            gardProduct = 0;
        // }
        console.log(market_id);
        console.log(gardProduct);
        $.ajax({
            url:"../util/summaryDeliverProduct.php",
            method:"POST",
            data:{area_Id:area_Id, years_Id:yearsId, monthId:monthId, typeOfAgri_id:typeOfAgri_id, agri:agri, farmer_Id:farmer_Id, 
            market_id:market_id, gardProduct:gardProduct},
            dataType:"text",
            success:function(data){
                $("#dashTable tbody").html(data);
            }
        });
    }
    $('#example-select-all').on('click', function(){
        $('#copyDeliverProduct_from input[type="checkbox"]').prop('checked', this.checked);
    });

    $("#copyDeliverProductBtn" ).click(function() {
        $.ajax({
            url:"../util/loadYearsOfDeliver.php",
            method:"POST",
            data:{area_Id:area_Id, thisMonth: monthId},
            dataType:"text",
            success:function(data){
                $('#copyDeliverProduct_from #yearsOfDeliver').html(data);
            }
        });
        $('#copyDeliverProduct').modal('show');
    });
    $('#deliverProductList-Table tbody').on('click', '#viewDeliverBtn', function () {
        var Table = $('#deliverProductList-Table').DataTable();
        var data = Table.row( $(this).parents('tr') ).data();
        var idPersonMarket = data[0];
        $('#idPersonMarket').val(idPersonMarket);
        $('#viewDeliverProductDetail').modal('show');
        console.log(idPersonMarket);
        $.ajax({
            url: "../server_side/loadDeliverProductDetailView.php?idPersonMarket="+idPersonMarket,
            type: "GET",
            dataType: "json",
            success: function(data) {
                console.log(data.data[0]);
                mapDataViewDeliver(data.data[0]);
            }
        });
    });

    function mapDataViewDeliver(data){
        console.log(data);
        $('#viewDeliverProduct_form #namePerson').val(data[0]);
        $('#viewDeliverProduct_form #person_id').val(data[1]);
        $('#viewDeliverProduct_form #market_Name').val(data[9]);
        $('#viewDeliverProduct_form #typeAgri_Name').val(data[5]);
        $('#viewDeliverProduct_form #agri_Name').val(data[4]);
        $('#viewDeliverProduct_form #standardProduct').val(data[10]);
        if(data[6] != null){
            $('#viewDeliverProduct_form #quality').val(parseFloat(data[6]));
        }else{
            $('#viewDeliverProduct_form#quality').val(0);
        }
        if(data[8] != null){
            $('#viewDeliverProduct_form #price').val(parseFloat(data[8]));
        }else{
            $('#viewDeliverProduct_form #price').val(0);
        }
        if(data[7] != null){
            $('#viewDeliverProduct_form #totalPricre').val(parseFloat(data[7]));
        }else{
            $('#viewDeliverProduct_form #totalPricre').val(0);
        }
        $('#viewDeliverProduct_form #dateDeliver').val(data[2]);
        $('#viewDeliverProduct_form #gardsProduct').val(data[14]);
        $('#viewDeliverProduct_form #deliver_Name').val(data[13]);
        loadImageShowList(data[15]);
        $('#viewDeliverProduct_form #dateCultivate').val(data[16]);
        $('#viewDeliverProduct_form #dateHarvest').val(data[17]);
    }

    function loadImageShowList(idPersonMarket){
        var idPersonMarket = idPersonMarket;
        $.ajax({
            url:"../util/listShowImageLogistic.php",
            method:"POST",
            data:{idPersonMarket:idPersonMarket},
            dataType:"text",
            success:function(data){
                $('#viewDeliverProduct_form #imageTable').html(data);
            }
        });
    }

    $('#copyDeliverProduct_from #yearsOfDeliver').change(function(){
        var yearsOfDeliver = $(this).val();
        if(yearsOfDeliver != '0'){
            $.ajax({
                url:"../util/loadMonthOfDeliver.php",
                method:"POST",
                data:{area_Id:area_Id, yearsOfDeliver:yearsOfDeliver, thisMonth: monthId},
                dataType:"text",
                success:function(data){
                    $('#copyDeliverProduct_from #monthsOfDeliver').html(data);
                }
            });
        }else{
            $('#copyDeliverProduct_from #monthsOfDeliver').html("<option value='0'>กรุณาเลือก</option>");
        }
     });
    $('#copyDeliverProduct_from #monthsOfDeliver').change(function(){
        var monthsOfDeliver = $(this).val();
        var yearsOfDeliver = $('#copyDeliverProduct_from #yearsOfDeliver option:selected').val();
        if(monthsOfDeliver != '0'){
            $.ajax({
                url:"../util/loadDeliverProductFromMonths.php",
                method:"POST",
                data:{area_Id:area_Id, yearsOfDeliver:yearsOfDeliver, monthsOfDeliver: monthsOfDeliver, thisMonth: monthId},
                dataType:"text",
                success:function(data){
                    $('#copyDeliverProduct_from #deliverProductList-Table tbody').html(data);
                }
            });
        }else{
            $('#copyDeliverProduct_from #monthsOfDeliver').html("<option value='0'>กรุณาเลือก</option>");
        }
    });
    $("#saveCopyDeliverProductBtn" ).click(function() {
        spinner.show();
        console.log($("input[id='deliverProduct']:checked"));
        var deliverList = [];
        $.each($("input[id='deliverProduct']:checked"), function(){
            deliverList.push($(this).val());
        });
        console.log(deliverList);
        var thisMonthId = monthId;
        var thisYearsId = yearsId;
        $.ajax({
            url:"../handler/deliverProductHandler.php",
            method:"POST",
            data:{area_Id:area_Id, deliverList:deliverList, thisMonthId: thisMonthId, thisYearsId: thisYearsId, action: 'cloneDeliver'},
            dataType:"text",
            success:function(data){
                $('#copyDeliverProduct').modal('hide');
                spinner.hide();
                // var Table = $('#deliverProductList-Table').DataTable();
                // Table.destroy();
                // datatableinit();
            },complete:function(){
                initTable();
                $('#deliverProductList-Table').DataTable().ajax.reload();
                jQuery('#checkall').prop('checked', false);
            }
        });
    });

    $( "#addNewLogistic" ).click(function() {
        $('#createLogisticDialog').modal('show');
    });

    $("#uploadImageOpen" ).click(function() {
        $('#uploadImageDialog').modal('show');
    });

    $('#uploadImage').click(function() {
        spinner.show();
        $('#nameoffiles').text("");
        $('.basic-img').attr("src","");
        $('#uploadImageDialog').modal('hide');
        var file = $('#uploadImageModal #files').prop('files')[0];
        var formData= new FormData();
        formData.append('fileToUpload',file);
        formData.append('action',"uploadImage");
        $.ajax({
            type: "POST",
            cache: false,
            contentType: false,
            processData: false,
            dataType:'text',
            data:formData,
            url: "../handler/deliverProductHandler.php",
            dataType: "html",
            async: false,
            success:function(data){
                var obj = {};
                console.log(data.split(","))
                var listdata = data.split(",");
                var idimage = parseInt(listdata[0]);
                var parthImage = listdata[1];
                obj["idimage"]= idimage.toString();
                obj["parthImage"]=parthImage;
                listimage.push(obj)
                console.log(listimage);
                initImageList(listimage);
                spinner.hide();
            }
        });
    });
    $("#files").change(function() {
        if (this.files && this.files[0]) {
            console.log(this.files[0].name);
            $('#nameoffiles').text(this.files[0].name);
            var reader = new FileReader();
            reader.onload = imageIsLoaded;
            reader.readAsDataURL(this.files[0]);
        }
    });
    function imageIsLoaded(e) {
        $('.basic-img').attr('src', e.target.result);
    };
    function initImageList(listimage) {
        $("#editImageTable tbody").html("");
        if(listimage != "") {
            var tableData="";
            for(var i=0;i<listimage.length;i++){
                tableData +="<tr id="+listimage[i].idimage+">";
                    tableData +='<td><img src='+listimage[i].parthImage+' style=" height: 150px;float: left;"></td>';
                    tableData +="<td><button type='button' class='btn btn-danger' id='deleteImageBtn' name='deleteImageBtn' style='margin-top: 50px'><i class='fa fa-minus-square-o' data-toggle='tooltip' title='ลบรูปนี้'></i></button></td>";
                tableData +='</tr>';
            }
            console.log(tableData);
            $("#editImageTable tbody").html(tableData);
        }
    }
    $('#editImageTable tbody').on('click', '#deleteImageBtn', function () {
        var rowIndex = $(this).closest('tr').attr('id');
        console.log(rowIndex);
        var indexList = listimage.findIndex(item => item.idimage === rowIndex);
        listimage.splice(indexList, 1);
        $.ajax({
            url:"../handler/deliverProductHandler.php",
            method:"POST",
            data:{idImgUpload:rowIndex, action: 'deleteImage'},
            dataType:"text",
            success:function(data){
                initImageList(listimage);
            }
        });
    } );
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
    function toMoney(n) {
        return n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
    }
    if(permssion == "staff" || permssion == "admin"){
        if($('#statusId').val() != "2" && $('#statusId').val() != "4"){
            $('.bottombuttonsBX').html("<div class='row form-group' style='float: right;'><div class='col col-sm-6' id='editBtn'><button type='button' class='btn btn-info' href='javascript:void(0)' id='editOnTableBtn' name='editOnTableBtn' ><i class='fa fa-edit'></i>&nbsp; แก้ไขทั้งหมด</button></div><div class='col col-sm-4'><button type='button' class='btn btn-danger' href='javascript:void(0)' id='deleteOnTableBtn' name='deleteOnTableBtn' ><i class='fa ti-trash'></i>&nbsp; ลบข้อมูลที่เลือก</button></div></div>");
        }else{
            table = $('#deliverProductList-Table').DataTable();
            table.columns([5]).visible( false);
            $('.bottombuttonsBX').html('');
        }
    }

    $('#editOnTableBtn').click( function() {
        spinner.show();
        Table = $('#deliverProductList-Table').DataTable();
        var data = Table.$('input').serialize().split('&');
        var obj={};
        var tempid = '';
        var listProductDeliver = [];
        for(var key in data) {
            if(tempid != data[key].split("_")[0]){
                if(tempid!= ''){
                    listProductDeliver.push(obj);
                    var obj={};
                    tempid = data[key].split("_")[0];
                }else{
                    tempid = data[key].split("_")[0];
                }
                obj.id = data[key].split("_")[0];
                obj[data[key].split("_")[1].split("=")[0]] = data[key].split("_")[1].split("=")[1];
            }else{
                obj[data[key].split("_")[1].split("=")[0]] = data[key].split("_")[1].split("=")[1];
            }
        }
        if(obj != ''){
            console.log(obj);
            listProductDeliver.push(obj);
        }
        console.log(listProductDeliver);
        $.ajax({
            url:"../handler/deliverProductHandler.php",
            method:"POST",
            data: {data: listProductDeliver, action: "updatelist"},
            dataType:"text",
            success:function(data){
                Table.ajax.reload();
                initTable();
            },complete:function(){
                spinner.hide();
            }
        });
    });
    $('#deleteOnTableBtn').click( function() {
        var Table = $('#deliverProductList-Table').DataTable();
        var deleteids_arr = [];
        $("input:checkbox[class=delete_check]:checked").each(function () {
            deleteids_arr.push($(this).val());
        });
        console.log(deleteids_arr);
        if(deleteids_arr.length > 0){
            var x = confirm("ต้องการลบข้อมูลที่เลือกทั้งหมดหรือไม่ ?");
            if(x){
            spinner.show();
                // var data = Table.row( $(this).parents('tr') ).data();
                // var idPersonMarket = data[0];
                // var area_Id = $('#area_Id').val();
                // var yearsId = $('#yearsId').val();
                // var monthId = $('#monthId').val();
                $.ajax({
                    url: "../handler/deliverProductHandler.php",
                    type: "POST",
                    dataType: "html",
                    async: false,
                    data:{idPersonMarkerList:deleteids_arr, action:"deleteList"},
                    success:function(data){
                        initTable();
                        $('#deliverProductList-Table').DataTable().ajax.reload();
                        // window.location = "./deliverProductList.php?area_Id="+area_Id+"&yearsId="+yearsId+"&monthId="+monthId;
                    },complete:function(){
                        spinner.hide();
                    }
                });
            }
        }else{
            alert('กรุณาเลือกอย่างน้อย 1 ข้อมูลที่ต้องการลบ');
        }
    } );

})(jQuery);
function a1_onclick ($argi_Id, $market_Id) {
    console.log($argi_Id ," :: ", $market_Id);
    
    jQuery("#editDeliverProductFromList").modal({ show: true, backdrop: true, keyboard: false });
    var Table = jQuery('#showmodalList-table').DataTable();
    Table.destroy();
    jQuery('#editDeliverProductFrom #argi_Id').val($argi_Id);
    jQuery('#editDeliverProductFrom #market_Id').val($market_Id);
    datatableinits();
}

function datatableinits() {
    var permssion = jQuery('#permssion').val();
    var argi_Id = jQuery('#editDeliverProductFrom #argi_Id').val();
    var market_Id = jQuery('#editDeliverProductFrom #market_Id').val();
    var area_Id = jQuery('#area_Id').val();
    var yearsId = jQuery('#yearsId').val();
    var monthId = jQuery('#monthId').val();
    console.log(permssion);
    var Table = jQuery('#showmodalList-table').DataTable( {
        "dom": '<"topbuttons"B>frt<"bottombuttons">ip',
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
                          'columns': [6,7,8,9,10,11,12,13,14,15,16]
                      },
                      'title': 'ข้อมูลการส่งมอบผลผลิต',
                },
  
                { 'extend':'csv',
                'action':newexportaction ,
                'exportOptions': {
                  'modifier': {
                    'page': 'All',
                    'search': 'none'
                    },
                    'columns': [6,7,8,9,10,11,12,13,14,15,16]
                  },
                  'title': 'ข้อมูลการส่งมอบผลผลิต',
                },
  
                { 'extend':'excel',
                'action':newexportaction ,
                'exportOptions': {
                  'modifier': {
                    'page': 'All',
                    'search': 'none'
                    },
                    'columns': [6,7,8,9,10,11,12,13,14,15,16]
                  },
                  'title': 'ข้อมูลการส่งมอบผลผลิต',
                },
                { 'extend':'print',
                'action':newexportaction ,
                'exportOptions': {
                  'modifier': {
                    'page': 'ALL',
                    'search': 'none'
                    },
                    'columns': [6,7,8,9,10,11,12,13,14,15,16]
                  },
                  'title': 'ข้อมูลการส่งมอบผลผลิต',
                },
              ]
          }],
        "processing": true,
        "responsive": true,
        "serverSide": true,
        "ajax": "../server_side/loadDeliverProductList.php?area_Id="+area_Id+"&yearsId="+yearsId+"&monthId="+monthId+"&argi_Id="+argi_Id+"&market_Id="+market_Id,
        "autoWidth": false,
        "createdRow": function( row, data, dataIndex){
            if( data[12] ==  '0.0' || data[14] ==  '0'){
                $(row).addClass('redClass');
            }
            if(data[17] ==  '1'){
                $(row).addClass('buleClass');
            }
        },
        'fixedColumns': {
          'heightMatch': 'none'
        },
        'columnDefs': [{
            "targets": [0,1,2,3,4,17,18],
            "visible": false
        },{
            "targets": [5],
            'searchable': false,
            'orderable': false,
            'render': function (data, type, row){
                return "<center><input type='checkbox' class='delete_checkNB' id='delcheck_"+row[0]+"' onclick='checkcheckboxNB();' value='"+row[0]+"'></center>";
            }
        },{
            "targets": [2],
            'width': 30,
        },{
            "targets": [12],
            'width': 130,
            'render': function (data,type,row){
                if(permssion == "staff" || permssion == "admin"){
                    if(jQuery('#statusId').val() == "2" || jQuery('#statusId').val() == "4"){
                        return toMoney(parseFloat(data));
                    }else{
                        return "<div style=' font-size: 20px; '><input id='"+row[0]+"_totalQuality' name='"+row[0]+"_totalQuality' value='"+parseFloat((data)).toFixed(2)+"' onkeypress='return isNumberKey(this,event)' class='form-control' type='text'></div>";
                    }
                }else{
                    return toMoney(parseFloat(data));
                }
            }
        },{
            "targets": [13],
            'width': 130,
            'render': function (data,type,row){
                if(permssion == "staff" || permssion == "admin"){
                    if(jQuery('#statusId').val() == "2" || jQuery('#statusId').val() == "4"){
                        return toMoney(parseFloat(data));
                    }else{
                        return "<div style=' font-size: 20px; '><input id='"+row[0]+"_priceProduct' name='"+row[0]+"_priceProduct' value='"+parseFloat((data)).toFixed(2)+"' onkeypress='return isNumberKey(this,event)' class='form-control' type='text'></div>";
                    }
                }else{
                    return toMoney(parseFloat(data));
                }
            }
        },{
            "targets": [14],
            'render': function (data){
                return toMoney(parseFloat(data));
            }
        }
        ,{
            'targets': [19],
            'width': 200,
            'searchable': false,
            'orderable': false,
            'className': 'dt-header-center',
            'render': function (data, type, row){
                if(permssion == "staff" || permssion == "admin" || permssion == 'powerUserMarket'){
                    if(jQuery('#statusId').val() == "2" || jQuery('#statusId').val() == "4"){
                        return '<div style=" font-size: 20px; "><center>'
                        +'<i class="fa fa-eye" style="cursor: pointer;margin-right: 10px; color: green;" id="viewDeliverBtn" name ="viewDeliverBtn"></i>'
                        +'</center></div>';
                    }else{
                        return '<div style=" font-size: 20px; "><center>'
                        +'<i class="fa fa-edit" style=" cursor: pointer;margin-right: 10px; color: blue;" name="edit_data" id="edit_data"></i>'
                        +'<i class="fa ti-trash" style="cursor: pointer;margin-right: 10px; color: red;" id="deleteDeliverBtn"></i>'
                        // +'<i class="fa fa-eye" style="cursor: pointer;margin-right: 10px; color: green;" id="viewDeliverBtn" name ="viewDeliverBtn"></i>'
                        +'</center></div>';
                    }
                }
                
            }
        }
        ]
    } );
    if(permssion == "staff" || permssion == "admin"){
        if(jQuery('#statusId').val() != "2" && jQuery('#statusId').val() != "4"){
            jQuery('.bottombuttons').html("<div class='row form-group' style='float: right;'><div class='col col-sm-6' id='editBtn'><button type='button' class='btn btn-info'  onclick='return editOnTableBtnOnPopUp();' id='editOnTableBtn' name='editOnTableBtn' ><i class='fa fa-edit'></i>&nbsp; แก้ไขทั้งหมด</button></div><div class='col col-sm-4' id='deleteBtn'><button type='button' class='btn btn-danger' onclick='return deleteOnTableBtnOnPopUp();' id='deleteOnBuBtn' name='deleteOnBuBtn' ><i class='fa ti-trash'></i>&nbsp; ลบข้อมูลที่เลือก</button></div></div>");
        }else{
            table = jQuery('#showmodalList-table').DataTable();
            table.columns([5]).visible( false);
            jQuery('.bottombuttons').html('');
        }
    }
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
                jQuery.fn.dataTable.ext.buttons.copyHtml5.action.call(self, e, dt, button, config);
            } else if (button[0].className.indexOf('buttons-excel') >= 0) {
                jQuery.fn.dataTable.ext.buttons.excelHtml5.available(dt, config) ?
                jQuery.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config) :
                jQuery.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
            } else if (button[0].className.indexOf('buttons-csv') >= 0) {
                jQuery.fn.dataTable.ext.buttons.csvHtml5.available(dt, config) ?
                jQuery.fn.dataTable.ext.buttons.csvHtml5.action.call(self, e, dt, button, config) :
                    jQuery.fn.dataTable.ext.buttons.csvFlash.action.call(self, e, dt, button, config);
            } else if (button[0].className.indexOf('buttons-pdf') >= 0) {
                jQuery.fn.dataTable.ext.buttons.pdfHtml5.available(dt, config) ?
                jQuery.fn.dataTable.ext.buttons.pdfHtml5.action.call(self, e, dt, button, config) :
                jQuery.fn.dataTable.ext.buttons.pdfFlash.action.call(self, e, dt, button, config);
            } else if (button[0].className.indexOf('buttons-print') >= 0) {
                jQuery.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
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

function editOnTableBtnOnPopUp(){
    var spinner = jQuery('#loader');
    spinner.show();
    Table = jQuery('#showmodalList-table').DataTable();
    var data = Table.$('input').serialize().split('&');
    var obj={};
    var tempid = '';
    var listProductDeliver = [];
    for(var key in data) {
        if(tempid != data[key].split("_")[0]){
            if(tempid!= ''){
                listProductDeliver.push(obj);
                var obj={};
                tempid = data[key].split("_")[0];
            }else{
                tempid = data[key].split("_")[0];
            }
            obj.id = data[key].split("_")[0];
            obj[data[key].split("_")[1].split("=")[0]] = data[key].split("_")[1].split("=")[1];
        }else{
            obj[data[key].split("_")[1].split("=")[0]] = data[key].split("_")[1].split("=")[1];
        }
    }
    if(obj != ''){
        console.log(obj);
        listProductDeliver.push(obj);
    }
    console.log(listProductDeliver);
    jQuery.ajax({
        url:"../handler/deliverProductHandler.php",
        method:"POST",
        data: {data: listProductDeliver, action: "updatelist"},
        dataType:"text",
        success:function(data){
            Table.ajax.reload();
        },complete:function(){
            initTableList();
            jQuery('#deliverProductList-Table').DataTable().ajax.reload();
            spinner.hide();
        }
    });
}

function initTableList() {
    jQuery("#dashTable tbody").html("");
    var area_Id = jQuery('#area_Id').val();
    var yearsId = jQuery('#yearsId').val();
    var monthId = jQuery('#monthId').val();
    var typeOfAgri_id = jQuery('#typeOfAgri_id option:selected').val();
    var agri = jQuery('#agri option:selected').val();
    var farmer_Id = jQuery('#farmer_Id option:selected').val();
    var market_id = jQuery('#market_id option:selected').val();
    var gardProduct = jQuery('#gardProduct option:selected').val();
    if(gardProduct == 'all'){
        gardProduct = 0;
    }
    console.log(market_id);
    console.log(gardProduct);
    jQuery.ajax({
        url:"../util/summaryDeliverProduct.php",
        method:"POST",
        data:{area_Id:area_Id, years_Id:yearsId, monthId:monthId, typeOfAgri_id:typeOfAgri_id, agri:agri, farmer_Id:farmer_Id, 
        market_id:market_id, gardProduct:gardProduct},
        dataType:"text",
        success:function(data){
            jQuery("#dashTable tbody").html(data);
        }
    });
}

jQuery('#showmodalList-table').on('click', '#deleteDeliverBtn', function () {
    if (!confirm("ต้องการลบข้อมูลการส่งมอบนี้หรือไม่")){
        return false;
    }
    var Table = jQuery('#showmodalList-table').DataTable();
    var data = Table.row(jQuery(this).parents('tr') ).data();
    jQuery.ajax({
        url: "../handler/deliverProductHandler.php",
        method:"POST",
        data:{'idPersonMarket':data[0],'action':'delete'},
        dataType:"html",
        success:function(data){
            Table.ajax.reload();
            jQuery('#deliverProductList-Table').DataTable().ajax.reload();
            initTableList();
        }
    });
} );

jQuery('#showmodalList-table tbody').on('click', '#edit_data', function () {
    var Table = jQuery('#showmodalList-table').DataTable();
    var data = Table.row( jQuery(this).parents('tr') ).data();
    var idPersonMarket = data[0];
    jQuery('#idPersonMarket').val(idPersonMarket);
    jQuery('#editDeliverProductDetail').modal('show');
    jQuery.ajax({
        url: "../server_side/loadDeliverProductDetail.php?idPersonMarket="+idPersonMarket,
        type: "GET",
        dataType: "json",
        success: function(data) {
            console.log(data.data[0]);
            mapDataPersons(data.data[0]);
        }
    });
});
jQuery('#showmodalList-table tbody').on('click', '#viewDeliverBtn', function () {
    var Table = jQuery('#showmodalList-table').DataTable();
    var data = Table.row( jQuery(this).parents('tr') ).data();
    var idPersonMarket = data[0];
    jQuery('#idPersonMarket').val(idPersonMarket);
    jQuery('#viewDeliverProductDetail').modal('show');
    console.log(idPersonMarket);
    jQuery.ajax({
        url: "../server_side/loadDeliverProductDetailView.php?idPersonMarket="+idPersonMarket,
        type: "GET",
        dataType: "json",
        success: function(data) {
            console.log(data.data[0]);
            mapDataViewDeliver(data.data[0]);
        }
    });
});

function mapDataPersons(dataMap){
    jQuery('#namePerson').val(dataMap[0]);
    jQuery('#person_id').val(dataMap[1]);
    jQuery('#market_Id option[value="'+dataMap[9]+'"]').attr("selected",true);
    if(dataMap[6] != null){
        jQuery('#quality').val(parseFloat(dataMap[6]));
    }else{
        jQuery('#quality').val(0);
    }
    if(dataMap[8] != null){
        jQuery('#price').val(parseFloat(dataMap[8]));
    }else{
        jQuery('#price').val(0);
    }
    if(dataMap[7] != null){
        jQuery('#totalPricre').val(parseFloat(dataMap[7]));
    }else{
        jQuery('#totalPricre').val(0);
    }
    jQuery('#dateDeliver').val(dataMap[2]);
    if(dataMap[12] == null){
        jQuery('#lossValue').val(0);
        caltotalofLossValue();
    }else{
        jQuery('#lossValue').val(parseFloat(dataMap[12]));
        caltotalofLossValue();
    }
    console.log(dataMap[15]);
    jQuery('#dateCultivate').datepicker("setDate", dataMap[15] );
    jQuery('#dateHarvest').datepicker("setDate", dataMap[16]);
    jQuery.ajax({
        url:"../util/loadTypeOfAgriFromFarmer.php",
        method:"POST",
        processData: false,
        data:{person_Id:dataMap[1], area_Id:area_Id},
        dataType:"text",
        success:function(data){
            jQuery('#typeAgri_Id').html(data);
        },
        complete:function(){
            jQuery('#typeAgri_Id option[value="'+dataMap[5]+'"]').attr("selected",true);
            console.log("tpyeOfAgri_Id ::::", dataMap[5]);
            jQuery.ajax({
                url:"../util/loadAgriFromFarmer.php",
                method:"POST",
                // processData: false,
                data:{tpyeOfAgri_Id:dataMap[5]},
                dataType:"text",
                success:function(data){
                    jQuery('#agri_Id').html(data);
                },
                complete:function(){
                    jQuery('#agri_Id option[value="'+dataMap[4]+'"]').attr("selected",true);
                    jQuery.ajax({
                        url:"../util/loadProductStandard.php",
                        method:"POST",
                        processData: false,
                        data:{agri_Id:dataMap[4]},
                        dataType:"text",
                        success:function(data){
                            jQuery('#standardProduct').html(data);
                        },complete:function(){
                            jQuery('#standardProduct option[value="'+dataMap[10]+'"]').attr("selected",true);
                        }
                    });
                    jQuery.ajax({
                        url:"../util/loadProductGradeFromAgri.php",
                        method:"POST",
                        processData: false,
                        data:{agri_Id:dataMap[4], area_Id:area_Id},
                        dataType:"text",
                        success:function(data){
                            jQuery('#gardsProduct').html(data);
                        },complete:function(){
                            jQuery('#gardsProduct option[value="'+dataMap[3]+'"]').attr("selected",true);
                        }
                    });
                    jQuery.ajax({
                        url:"../util/loadLandDetail.php",
                        method:"POST",
                        processData: false,
                        data:{person_Id:dataMap[1]},
                        dataType:"text",
                        success:function(data){
                            jQuery('#landDetail').html(data);
                        },complete: function (){
                            jQuery('#gardsProduct option[value="'+dataMap[11]+'"]').attr("selected",true);
                            jQuery('#logistic_Id option[value="'+dataMap[13]+'"]').attr("selected",true);
                        }
                    });
                }
            });
            loadImageList(dataMap[14]);
            getimagelist(dataMap[14]);
        }
    });
}
function caltotalofLossValue() {
    var first_number = jQuery('#quality').val();
    var second_number = jQuery('#lossValue').val();
    if(parseFloat(second_number) > parseFloat(first_number)){
        alert("ปริมาณสูญเสียไม่ควรมากกว่าปริมาณส่งมอบ")
        jQuery('#lossValue').val(0);
        jQuery('#totalQuality').val(first_number);
        return false
    }
    var result = parseFloat(first_number)-parseFloat(second_number);
    if(result >= 0){
        jQuery('#totalQuality').val(result);
    }else{
        jQuery('#totalQuality').val(first_number);
    }
}
function loadImageList(idPersonMarket){
    var idPersonMarket = idPersonMarket;
    console.log(idPersonMarket);
    jQuery.ajax({
        url:"../util/listImageLogistic.php",
        method:"POST",
        // processData: false,
        data:{idPersonMarket:idPersonMarket},
        dataType:"text",
        success:function(data){
            jQuery('#editImageTable tbody').html(data);
        }
    });
}
function getimagelist(idPersonMarket){
    var idPersonMarket = idPersonMarket;
    console.log(idPersonMarket);
    jQuery.ajax({
        url:"../util/listImage.php",
        method:"POST",
        // processData: false,
        data:{idPersonMarket:idPersonMarket},
        dataType:"text",
        success:function(data){
            argi_group = JSON.parse(data);
            var obj={};
            var listimage = [];
            for(var key in argi_group) {
                var obj={};
                obj['idimage'] = argi_group[key].idImgTD;
                obj['parthImage'] = '../img/Activity/'+argi_group[key].ImgName;
                listimage.push(obj)
            }
        }
    });
}
function mapDataViewDeliver(data){
    console.log(data);
    jQuery('#viewDeliverProduct_form #namePerson').val(data[0]);
    jQuery('#viewDeliverProduct_form #person_id').val(data[1]);
    jQuery('#viewDeliverProduct_form #market_Name').val(data[9]);
    jQuery('#viewDeliverProduct_form #typeAgri_Name').val(data[5]);
    jQuery('#viewDeliverProduct_form #agri_Name').val(data[4]);
    jQuery('#viewDeliverProduct_form #standardProduct').val(data[10]);
    if(data[6] != null){
        jQuery('#viewDeliverProduct_form #quality').val(parseFloat(data[6]));
    }else{
        jQuery('#viewDeliverProduct_form#quality').val(0);
    }
    if(data[8] != null){
        jQuery('#viewDeliverProduct_form #price').val(parseFloat(data[8]));
    }else{
        jQuery('#viewDeliverProduct_form #price').val(0);
    }
    if(data[7] != null){
        jQuery('#viewDeliverProduct_form #totalPricre').val(parseFloat(data[7]));
    }else{
        jQuery('#viewDeliverProduct_form #totalPricre').val(0);
    }
    jQuery('#viewDeliverProduct_form #dateDeliver').val(data[2]);
    jQuery('#viewDeliverProduct_form #gardsProduct').val(data[14]);
    jQuery('#viewDeliverProduct_form #deliver_Name').val(data[13]);
    loadImageShowList(data[15]);
}

function loadImageShowList(idPersonMarket){
    var idPersonMarket = idPersonMarket;
    jQuery.ajax({
        url:"../util/listShowImageLogistic.php",
        method:"POST",
        data:{idPersonMarket:idPersonMarket},
        dataType:"text",
        success:function(data){
            jQuery('#viewDeliverProduct_form #imageTable').html(data);
        }
    });
}
jQuery('#checkallNB').click(function(){
    if(jQuery(this).is(':checked')){
        jQuery('.delete_checkNB').prop('checked', true);
    }else{
        jQuery('.delete_checkNB').prop('checked', false);
    }
});
jQuery('#checkall').click(function(){
    if(jQuery(this).is(':checked')){
        jQuery('.delete_check').prop('checked', true);
    }else{
        jQuery('.delete_check').prop('checked', false);
    }
});
function checkcheckbox(){
    // Total checkboxes
    var length = jQuery('.delete_check').length;

    // Total checked checkboxes
    var totalchecked = 0;
    jQuery('.delete_check').each(function(){
       if(jQuery(this).is(':checked')){
          totalchecked+=1;
       }
    });
    console.log (totalchecked);
    // Checked unchecked checkbox
    if(totalchecked == length){
        jQuery("#checkall").prop('checked', true);
    }else{
        jQuery('#checkall').prop('checked', false);
    }
}

function checkcheckboxNB(){
    // Total checkboxes
    var length = jQuery('.delete_checkNB').length;

    // Total checked checkboxes
    var totalchecked = 0;
    jQuery('.delete_checkNB').each(function(){
        if(jQuery(this).is(':checked')){
            totalchecked+=1;
        }
    });
    console.log (totalchecked);
    // Checked unchecked checkbox
    if(totalchecked == length){
        jQuery("#checkallNB").prop('checked', true);
    }else{
        jQuery('#checkallNB').prop('checked', false);
    }
}

function deleteOnTableBtnOnPopUp (){
    var spinner = jQuery('#loader');
    var deleteids_arr = [];
    jQuery("input:checkbox[class=delete_checkNB]:checked").each(function () {
        deleteids_arr.push(jQuery(this).val());
    });
    console.log(deleteids_arr);
    if(deleteids_arr.length > 0){
        var x = confirm("ต้องการลบข้อมูลที่เลือกทั้งหมดหรือไม่ ?");
        if(x){
            spinner.show();
            jQuery.ajax({
                url: "../handler/deliverProductHandler.php",
                type: "POST",
                dataType: "html",
                async: false,
                data:{idPersonMarkerList:deleteids_arr, action:"deleteList"},
                success:function(data){
                    jQuery('#showmodalList-table').DataTable().ajax.reload();
                    initTableList();
                    jQuery('#deliverProductList-Table').DataTable().ajax.reload();
                },complete:function(){
                    jQuery('#checkallNB').prop('checked', false);
                    spinner.hide();
                }
            });
        }
    }else{
        alert('กรุณาเลือกอย่างน้อย 1 ข้อมูลที่ต้องการลบ');
    }
};

