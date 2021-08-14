(function ($) {
    var spinner = $('#loader');
    $('#examplePlan_card').hide();
    caltotalofprice();
    var area_Id = $('#area_Id').val();
    var years_Id = $('#yearsId').val();
    var actionValue = $('#actionValue').val();
    var permssion = $('#permssion').val();
    defaultcheck();
    var listPlanProducts = [];
    initTable();
    initTableYearsList();
    var Table = $('#yearOfPlanList-Table').DataTable();
    $('.number').keypress(validateNumber);
    $('.number').keyup(caltotalPlanOfPrice);
    function caltotalPlanOfPrice() {
        var idInputFirst = this.id;
        var id = idInputFirst.split("_");
        console.log(id[1]);
        if(id[1] == "quantity"){
            var idInputSec = id[0]+"_pricePer";
        }else{
            var idInputSec = id[0]+"_quantity";
        }
        console.log(idInputSec," :: ",idInputFirst);
        var firstInput = $('#'+idInputFirst).val();
        var seInput = $('#'+idInputSec).val();
        var result = parseInt(firstInput)*parseInt(seInput);
        if(result >= 0){
            $('#'+id[0]+'_TotalPrice').val(result);
        }else{
            $('#'+id[0]+'_TotalPrice').val(0);
        }
        console.log(firstInput," :: ",seInput);
        console.log(result);
        var totalprice = 0;
        var totalquality = 0;
        $('.quantity').each(function(){
            var $this = $(this);
            if($this.val() != ''){
                totalquality = totalquality+parseInt($this.val());
            }
        });
        $('.totalPrice').each(function(){
            var $this = $(this);
            if($this.val() != ''){
                totalprice = totalprice+parseInt($this.val());
            }
        });
        $('#totalQuantity').val(totalquality);
        $('#totalPriceOfYears').val(totalprice);
    }
    function validateNumber(event) {
        var key = window.event ? event.keyCode : event.which;
        if (event.keyCode === 8 || event.keyCode === 46) {
            return true;
        } else if ( key < 48 || key > 57 ) {
            return false;
        } else {
            return true;
        }
    };
    function initTableYearsList (){
        var Table = $('#yearOfPlanList-Table').DataTable( {
            pageLength: 10,
            'dom': "<'row'<'col-sm-6'Bl><'col-sm-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'bottombuttonsTB col-sm-12'>><'row'<'col-sm-5'i><'col-sm-7'p>>",
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
                            // 'columns': [4,17,15,18,19,5,6,9,20,21,12,7,8]
                            'columns': [5,18,16,19,20,6,7,10,11,12,13,8,9,21,22,23,24,25,26]
                          },
                          'title': 'ข้อมูลเป้าหมายรายได้และผลผลิต',
                    },
                    { 'extend':'excel',
                    'action':newexportaction ,
                    'exportOptions': {
                      'modifier': {
                        'page': 'All',
                        'search': 'none'
                        },
                        'columns': [5,18,16,19,20,6,7,10,11,12,13,8,9,21,22,23,24,25,26]
                        // 'columns': [4,17,15,18,19,5,6,9,20,21,12,7,8]
                      },
                      'title': 'ข้อมูลเป้าหมายรายได้และผลผลิต',
                    },
                    { 'extend':'print',
                    'action':newexportaction ,
                    'exportOptions': {
                      'modifier': {
                        'page': 'ALL',
                        'search': 'none'
                        },
                        'columns': [5,18,16,19,20,6,7,10,11,12,13,8,9,21,22,23,24,25,26]
                        // 'columns': [4,17,15,18,19,5,6,9,20,21,12,7,8]
                      },
                      'title': 'ข้อมูลเป้าหมายรายได้และผลผลิต',
                    },
                  ]
              }],
            "processing": true,
            "responsive": true,
            "serverSide": true,
            "ajax": "../server_side/targetPlanDetail.php?yearsId="+years_Id+"&area_Id="+area_Id,
            "autoWidth": false,
            'fixedColumns':{
            'heightMatch': 'none'
            },
            'columnDefs': [{
                "targets": [0,1,2,3,14,15,16,17,18,19,20,21,22,23,24,25,26],
                    // "targets": [0,1,2,3,13,14,15,16,17,18,19],
                    "visible": false
            },{
                "targets": [4],
                'width': 80,
                'searchable': false,
                'orderable': false,
                'render': function (data, type, row){
                    return "<center><input type='checkbox' class='delete_check' id='delcheck_"+row[0]+"' onclick='checkcheckbox();' value='"+row[0]+"'></center>";
                }
            },{
                "targets": [8,9],
                'width': 120,
            },{
                'targets': [11],
                'width': 100,
                'searchable': false,
                'orderable': false,
                'className': 'dt-header-center',
                'render': function (data, type, row){
                    if(actionValue == "2" || actionValue == "4" || permssion == "manager"){
                        return toMoney(parseFloat(data));
                    }else{
                        return "<div style=' font-size: 20px; '><input id='"+row[0]+"_totalQuality' name='"+row[0]+"_totalQuality' value='"+parseFloat((data)).toFixed(2)+"' onkeypress='isNumberKey(this,event)' class='form-control' type='text'></div>";
                    }
                }
            },{
                'targets': [12],
                'width': 100,
                'searchable': false,
                'orderable': false,
                'className': 'dt-header-center',
                'render': function (data, type, row){
                    if(actionValue == "2" || actionValue == "4" || permssion == "manager"){
                        return toMoney(parseFloat(data));
                    }else{
                        return "<div style=' font-size: 20px; '><input id='"+row[0]+"_productPrice' name='"+row[0]+"_productPrice' value='"+parseFloat((data)).toFixed(2)+"' onkeypress='isNumberKey(this,event)' class='form-control' type='text'></div>";
                    }
                }
            },{
                'targets': [13],
                'width': 100,
                'searchable': false,
                'orderable': false,
                'className': 'dt-header-center',
                'render': function (data, type, row){
                    return toMoney(parseFloat(data));
                }
            },{
                'targets': [27],
                // 'targets': [20],
                "visible": false,
                'render': function (data, type, row){
                    return toMoney(parseFloat(row[10]));
                }
            },{
                'targets': [28],
                // 'targets': [21],
                "visible": false,
                'render': function (data, type, row){
                    return toMoney(parseFloat(row[11]));
                }
            },{
                "targets": [18],
                'render' : function (data,type,row){
                    if(parseInt(row[3]) > '9'){
                        return parseInt(data-1);
                    }else{
                        return data;
                    }
                }
            },{
                'targets': [29],
                // 'targets': [22],
                'width': 110,
                'searchable': false,
                'orderable': false,
                'className': 'dt-header-center',
                'render': function (data, type, full, meta){
                    if( actionValue == "2" || actionValue == "4" || permssion == "manager"){
                        data = '<div style=" font-size: 20px; "><center>'
                        +'<i class="fa fa-align-justify" style=" cursor: pointer;margin-right: 20px; color: blue;" data-toggle="tooltip" title="ข้อมูลการส่งเสริมพืช" name="editTargetPromote" id="editTargetPromote"></i>'
                        // +'<i class="fa ti-trash" style="cursor: pointer;margin-right: 10px; color: red;" id="deleteProductPlan"></i>'
                        +'</center></div>';
                        return data
                    }else{
                        data = '<div style=" font-size: 20px; "><center>'
                        +'<i class="fa fa-align-justify" style=" cursor: pointer;margin-right: 20px; color: blue;" data-toggle="tooltip" title="ข้อมูลการส่งเสริมพืช" name="editTargetPromote" id="editTargetPromote"></i>'
                        +'<i class="fa ti-trash" style="cursor: pointer;margin-right: 10px; color: red;" id="deleteProductPlan"></i>'
                        +'</center></div>';
                        return data
                    }
                    
                }
            }
            ],
            'order': [[1, 'asc'], [ 2, 'asc' ],  [ 14, 'asc' ]],
        } );
    }
    $('.bottombuttonsTB').html("<div class='row form-group' style='float: right;'><div class='col col-sm-5' id='editBtn'><button type='button' class='btn btn-info' href='javascript:void(0)' id='editOnTableBtn' name='editOnTableBtn' ><i class='fa fa-edit'></i>&nbsp; แก้ไขทั้งหมด</button></div><div class='col col-sm-4' id='deleteBtn'><button type='button' class='btn btn-danger' href='javascript:void(0)' id='deleteOnTableBtn' name='deleteOnTableBtn' ><i class='fa ti-trash'></i>&nbsp; ลบข้อมูลที่เลือก</button></div></div>");
    if( actionValue == "2" || actionValue == "4" || permssion == "manager"){
        var table = $('#yearOfPlanList-Table').DataTable();
        table.columns([22]).visible( false);
        table.columns([4]).visible( false);
        $('.bottombuttonsTB').html('');
    }
    $('#yearOfPlanList-Table tbody').on('click', '#editTargetPromote', function () {
        var area_Id = $('#area_Id').val();
        var years_Id = $('#yearsId').val();
        var Table = $('#yearOfPlanList-Table').DataTable();
        var data = Table.row( $(this).parents('tr') ).data();
        // var data = $('#data').val();
        $('#editTargetPromo').modal('show');
        $("#Promo_targetPlanId").val(data[0]);
        $("#Promo_argi_id").val(data[2]);
        $("#Promo_area_Id").val(area_Id);
        $("#Promo_yearsId").val(years_Id);
        console.log($('#updateTargetPromo'));
        $('#editTargetPromo #updateTargetPromo').html('');
        //load infomation list taget uint of plan
        $.ajax({
            url:"../handler/targetPlanHandler.php",
            method:"POST",
            data: {tragetPlan_Id: data[0], action: "loadPlanUint"},
            dataType:"text",
            success:function(datalist){
                console.log(datalist);
                report =JSON.parse(datalist);
                console.log(report);
                //put value infomation list taget uint of plan
                $.ajax({
                    url:"../util/loadAgriTagetUintPlanNew.php",
                    method:"POST",
                    data:{argi_id:data[2]},
                    dataType:"text",
                    success:function(data){
                        $('#editTargetPromo #updateTargetPromo').append(data);
                    },complete:function(){
                        for(var i=0;i<report.length;i++){
                            var value = report[i].uintPlan.split("-");
                            $("#editTargetPromo #updateTargetPromo #"+value[0]).val(value[1]);
                        }
                    }
                });
            }
        });
    } );

    $('#updateTargetPromoModal').on('click',function(){
        console.log('2222222');
        var targetPlanId = $('#Promo_targetPlanId').val();
        var listdata = $("#updateTargetPromo :input").serialize().split("&");
        spinner.show();
        $.ajax({
            url:"../handler/targetPlanHandler.php",
            method:"POST",
            data:{listdata:listdata, targetPlanId:targetPlanId, action:"updateTargetPromo"},
            dataType:"text",
            success:function(data){
                $('#editTargetPromo').modal('hide');
            },complete:function (){
                spinner.hide();
            }
        });
    });

    $('#yearOfPlanList-Table tbody').on('click', '#deleteProductPlan', function () {
        var x = confirm("ต้องการลบข้อมูลหรือไม่ ?");
        if(x){
            var Table = $('#yearOfPlanList-Table').DataTable();
            var data = Table.row( $(this).parents('tr') ).data();
            $.ajax({
                url:"../handler/targetPlanHandler.php",
                method:"POST",
                data: {traget_Id: data[0], action: "delete"},
                dataType:"text",
                success:function(data){
                    Table.ajax.reload();
                    initTable();
                }
            });
        }
    } );

    $('#typeOfAgri_id').change(function(){
        $("#support_form").remove();
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
                },complete:function(){
                    var argi_id = $('#agri').val();
                    $.ajax({
                        url:"../util/loadAgriTagetUintPlan.php",
                        method:"POST",
                        data:{argi_id:argi_id},
                        dataType:"text",
                        success:function(data){
                            $('#support_parts').append(data);
                        }
                    });
                }
            });
        }else{
            Table.columns().search("").draw();
        }
     });

     $('#agri').change(function(){
        $("#support_form").remove();
        var argi_id = $(this).val();
        loadUnitCodeOfProduct(argi_id);
        loadProductStandard(argi_id);
        if(argi_id != '0'){
            $.ajax({
                url:"../util/loadAgriTagetUintPlan.php",
                method:"POST",
                data:{argi_id:argi_id},
                dataType:"text",
                success:function(data){
                    $('#support_parts').append(data);
                    Table.columns( 2 ).search(argi_id, true, false).draw();
                    console.log(argi_id);
                    $.ajax({
                        url:"../util/loadSpeciesDW.php",
                        method:"POST",
                        data:{argi_id:argi_id},
                        dataType:"text",
                        success:function(data){
                            $('#speciesId').html(data);
                        }
                    });
                }
            });
        }else{
            Table.columns(2).search("").draw();
        }
     });

     $('#typeOfAgri_idSearch').change(function(){
        var Table = $('#yearOfPlanList-Table').DataTable();
        var tpyeOfAgri_Id = $(this).val();
        if(tpyeOfAgri_Id != '0'){
            $.ajax({
                url:"../util/loadAgriProduct.php",
                method:"POST",
                data:{tpyeOfAgri_Id:tpyeOfAgri_Id, area_Id:area_Id},
                dataType:"text",
                success:function(data){
                    $('#agriSearch').html(data);
                    Table.columns( 1 ).search(tpyeOfAgri_Id, true, false).draw();
                }
            });
        }else{
            Table.columns(1).search("").draw();
        }
     });

     $('#agriSearch').change(function(){
        var Table = $('#yearOfPlanList-Table').DataTable();
        var argi_id = $(this).val();
        if(argi_id != '0'){
            Table.columns( 2 ).search(argi_id, true, false).draw();
        }else{
            Table.columns(2).search("").draw();
        }
     });

    $('#month_id').change(function(){
        var Table = $('#yearOfPlanList-Table').DataTable();
        var month = $(this).val();
        var monthtext = $('#month_id option:selected').text();
        console.log(monthtext);
        if(month != 0){
            Table.columns(4).search(monthtext, true, false).draw();
        }else{
            Table.columns(4).search("").draw();
        }
    });
    $('#marketSearch').change(function(){
        var Table = $('#yearOfPlanList-Table').DataTable();
        var marketTypeId = $(this).val();
        if(marketTypeId != 0){
            Table.columns(13).search(marketTypeId, true, false).draw();
        }else{
            Table.columns(13).search("").draw();
        }
    });
    

    $('#marketTypeList').change(function(){
        var marketTypleId = $(this).val();
        $('#marketList').html('');
        if(marketTypleId != '0'){
            $.ajax({
                url:"../util/loadMarketListWithType.php",
                method:"POST",
                data:{marketTypleId:marketTypleId, area_Id:area_Id},
                dataType:"text",
                success:function(data){
                    $('#marketList').html(data);
                }
            });
        }
     });

    function refreshTable (){
        var Table = $('#yearOfPlanList-Table').DataTable();
        var typeOfAgri_idSearch = $('#typeOfAgri_idSearch option:selected').val();
        if(typeOfAgri_idSearch != '0'){
            Table.columns( 1 ).search(typeOfAgri_idSearch, true, false).draw();
        }
        var agriSearch = $('#agriSearch option:selected').val();
        console.log(typeOfAgri_idSearch);
        console.log(agriSearch);
        if(agriSearch != '0'){
            Table.columns( 2 ).search(agriSearch, true, false).draw();
        }
        var month_idSearch = $('#month_id option:selected').val();
        if(month_idSearch != '0'){
            Table.columns( 3 ).search(month_idSearch, true, false).draw();
        }
        var marketSearch = $('#marketSearch option:selected').val();
        if(marketSearch != '0'){
            Table.columns( 13 ).search(marketSearch, true, false).draw();
        }
    }

    // select 2
    $('#typeOfAgri_id').select2();
    $('#agri').select2();
    $('.month-dropdown').select2();
    $('#typeOfAgri_idSearch').select2();
    $('#agriSearch').select2();
    $('#month_id').select2();
    $('#marketSearch').select2();
    $('.marketList-dropdown').select2({
        placeholder: "พิมพ์เพื่อค้นหา",
        allowClear: true
    });

    $('#totalQuality').keyup(function(){
        caltotalofprice();
    });
    $('#pricePerProduct').keyup(function(){
        caltotalofprice();
    });

    function initTable() {
        $("#dashTable tbody").html("");
        var area_Id = $('#area_Id').val();
        var years_Id = $('#yearsId').val();
        var summaryMonth_id = $('#summaryMonth_id').val();
        var summaryTypeOfAgri_Id = $('#summaryTypeOfAgri_Id').val();
        var summaryAgri_Id = $('#summaryAgri_Id').val();
        $.ajax({
            url:"../util/summaryProductPlan.php",
            method:"POST",
            data:{area_Id:area_Id, years_Id:years_Id, summaryMonth_id:summaryMonth_id, summaryTypeOfAgri_Id: summaryTypeOfAgri_Id, summaryAgri_Id: summaryAgri_Id},
            dataType:"text",
            success:function(data){
                $("#dashTable tbody").html(data);
            }
        });
    }

    function caltotalofprice() {
        var first_number = $('#totalQuality').val();
        var second_number = $('#pricePerProduct').val(); 
        var result = parseInt(first_number)*parseInt(second_number);
        if(result >= 0){
                $('#totalpriceOfPlan').val(result);
            }else{
                $('#totalpriceOfPlan').val(0);
            }
    }
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

    $('#addNewBtn').on('click',function(){
        var area_Id = $('#area_Id').val();
        var years_Id = $('#yearsId').val();
        var actionValue = $('#actionValue').val();
        window.location = encodeURI("./addProductPlanOfYears.php?yearsId="+years_Id+"&area_Id="+area_Id+"&action="+actionValue);
    });
    $('#sendPlanProduct').on('click',function(){
        var area_Id = $('#area_Id').val();
        var years_Id = $('#yearsId').val();
        var x = confirm("ต้องการส่งมอบแผน ?");
        if(x){
            spinner.show();
            $.ajax({
                url:"../handler/targetPlanHandler.php",
                method:"POST",
                data:{area_Id:area_Id, years_Id:years_Id, action:"sendPlanOfYears"},
                dataType:"text",
                success:function(data){
                    window.location = "./yearsListOfPlan.php?area_Id="+area_Id+"&yearsId="+years_Id;
                }
            });
        }
    });

    $('#confirmBtn').on('click',function(){
        var area_Id = $('#area_Id').val();
        var years_Id = $('#yearsId').val();
        var x = confirm("ยืนยันการอนุมัติแผน ?");
        if(x){
            spinner.show();
            $.ajax({
                url:"../handler/targetPlanHandler.php",
                method:"POST",
                data:{area_Id:area_Id, years_Id:years_Id, statusTypeId: "4", action:"updateStatusPlanOfYears"},
                dataType:"text",
                success:function(data){
                    window.location = "./yearsListOfPlan.php?area_Id="+area_Id+"&yearsId="+years_Id;
                }
            });
        }
    });

    $('#backToEditBtn').on('click',function(){ 
        var area_Id = $('#area_Id').val();
        var years_Id = $('#yearsId').val();
        var x = confirm("ยืนยันแจ้งแก้ไขแผน ?");
        if(x){
            spinner.show();
            $.ajax({
                url:"../handler/targetPlanHandler.php",
                method:"POST",
                data:{area_Id:area_Id, years_Id:years_Id, statusTypeId: "3", action:"updateStatusPlanOfYears"},
                dataType:"text",
                success:function(data){
                    window.location = "./yearsListOfPlan.php?area_Id="+area_Id+"&yearsId="+years_Id;
                }
            });
        }
    });

    // select all month of years
    $("#selectAllMonth").click(function(){
        checkMonthLit();
    });
    function checkMonthLit(){
        if($("#selectAllMonth").is(':checked') ){ //select all
            $("#monthList").find('option').prop("selected",true);
            $("#monthList").trigger('change');
          } else { //deselect all
            $("#monthList").find('option').prop("selected",false);
            $("#monthList").trigger('change');
          }
    }
    function defaultcheck(){
        $('#selectAllMonth').attr('checked', true);
        $("#monthList").find('option').prop("selected",true);
        $("#monthList").trigger('change');
    }

    $('#summaryMonth_id').change(function(){
        initTable();
    });

    $('#addPlanProductBtn').on('click',function(){
        var spinner = $('#loader');
        spinner.show();
        var area_Id = $('#area_Id').val();
        var years_Id = $('#yearsId').val();
        var typeOfAgri_id = $('#typeOfAgri_id').val();
        var agriId = $('#agri').val();
        // var standardProduct = $('#standardProduct').val();
        // var totalQuality = $('#totalQuality').val();
        // var pricePerProduct = $('#pricePerProduct').val();
        // var totalpriceOfPlan = $('#totalpriceOfPlan').val();
        var speciesId = $('#speciesId option:selected').val();
        // var monthList = $('#monthList').val();
        var marketList = $('#marketList').val();
        // console.log(monthList);
        console.log(marketList);

        if(typeOfAgri_id == '0' || agriId == '0' || marketList == '' || marketList == null){
            alert("กรุณากรอกข้อมูลให้ครบถ้วน");
            spinner.hide();
            return false;
        }
        $('.totalPrice').each(function(){
            var idInputFirst = this.id;
            var id = idInputFirst.split("_");
            if ($(this).val() == 0 && ($('#'+id[0]+'_quantity').val() != 0 || $('#'+id[0]+'_quantity').val()!= 0)){
                alert("กรุณากรอกข้อมูลให้ครบถ้วน")
            }
        });
        disablefield();
        var marketsize = marketList.length;
        var tmpAgriId = '';
        var tmpmarketId = '';
        var tmpNameAgri= '';
        var tmpMarketName = '';
        var tmpCustomerName = '';
        var dataId = '0';
        var dataQuantity = $('.quantity').serialize().split('&');
        var dataPricePer = $('.pricePer').serialize().split('&');
        var dataTotalPrice = $('.totalPrice').serialize().split('&');
        var obj={};
        var tempid = '';
        for(var key in dataTotalPrice) {
            if(dataTotalPrice[key].split("_")[1].split("=")[1] != '' || dataTotalPrice[key].split("_")[1].split("=")[1] != 0){
                for(var i=0;i<marketList.length;i++){
                    totalQuality = dataQuantity[key].split("_")[1].split("=")[1];
                    var sumOfMarkerQuality = parseFloat((totalQuality/marketsize)).toFixed(2);
                    if(tmpAgriId == '' || tmpAgriId != agriId){
                        tmpAgriId = agriId;
                        tmpNameAgri = $.ajax({
                            type: "POST",
                            url: "../util/loadAgriName.php",
                            data: {agri_Id:tmpAgriId},
                            async: false
                        }).responseText;
                    }
                    if(tmpmarketId == '' || tmpmarketId != marketList[i]){
                        tmpmarketId = marketList[i];
                        tmpMarketName = $.ajax({
                                    type: "POST",
                                    url: "../util/loadMarketName.php",
                                    data: {market_Id:tmpmarketId},
                                    async: false
                                }).responseText;
                        tmpCustomerName = $.ajax({
                                    type: "POST",
                                    url: "../util/loadCustomerName.php",
                                    data: {market_Id:tmpmarketId},
                                    async: false
                                }).responseText;
                    }
                    obj.dataId = dataId.toString();
                    obj.area_Id = area_Id;
                    obj.years_Id = years_Id;
                    obj.typeOfAgri_id = typeOfAgri_id;
                    obj.agriId = agriId;
                    obj.speciesId = speciesId;
                    obj.nameAgri = tmpNameAgri
                    obj.marketId = marketList[i];
                    obj.marketName = tmpMarketName;
                    obj.customerName = tmpCustomerName;
                    obj.monthId = dataQuantity[key].split("_")[0];
                    obj.pricePerProduct = dataPricePer[key].split("_")[1].split("=")[1];
                    obj.totalPrice = parseFloat((sumOfMarkerQuality*dataPricePer[key].split("_")[1].split("=")[1])).toFixed(2);
                    obj.quality = sumOfMarkerQuality;
                    listPlanProducts.push(obj);
                    var obj={};
                    dataId++
                }
            }
        }
        console.log(listPlanProducts);
        initTablePlanProduct(listPlanProducts);
        document.getElementById("addPlanProductBtn").style.visibility = "hidden";
        spinner.hide();
    });

    function initTablePlanProduct(listPlanProducts) {
        $('#examplePlan_card').show(50);
        $("#examplePlan-Table tbody").html("");
        var tableData="";
        classColor = 'evenTable'
        if(listPlanProducts != "") {
            var tmpmarketIds = '';
            var totalQuality = 0;
            var totalPrice = 0;
            for(var i=0;i<listPlanProducts.length;i++){
                totalQuality = totalQuality + parseFloat(listPlanProducts[i].quality);
                totalPrice = totalPrice + parseFloat(listPlanProducts[i].totalPrice);
                if(tmpmarketIds == '' || tmpmarketIds != listPlanProducts[i].marketId){
                    tmpmarketIds = listPlanProducts[i].marketId;
                    if(classColor == 'evenTable'){
                        classColor = 'colorTable';
                    }else{
                        classColor = 'evenTable';
                    }
                }
                tableData +="<tr id='"+listPlanProducts[i].dataId+"' class="+classColor+">";
                    tableData +='<td>'+listPlanProducts[i].nameAgri+'</td>';
                    tableData +='<td>'+loadMonthName(listPlanProducts[i].monthId);+'</td>';
                    // tableData +='<td>'+listPlanProducts[i].standardProductName+'</td>';
                    tableData +='<td>'+listPlanProducts[i].marketName+'</td>';
                    tableData +='<td>'+listPlanProducts[i].customerName+'</td>';
                    tableData +='<td class="qualityTD" ><input id="quality" name="quality" value="'+listPlanProducts[i].quality+'" class="form-control" type="text"></td>';
                    tableData +='<td><input id="pricePerProduct" name="pricePerProduct" value="'+listPlanProducts[i].pricePerProduct+'" class="form-control" type="text"></td>';
                    tableData +='<td>'+toMoney(parseFloat(listPlanProducts[i].totalPrice))+'</td>';
                    tableData +="<td>";
                    // tableData +="<i class='fa fa-save' id='updatePlanProduct' name='updatePlanProduct' style='margin-right: 10px; color: blue; font-size: 20px;' data-toggle='tooltip' title='บันทึก'></i>";
                    tableData +="<i class='fa ti-trash' id='deletePlanProduct' name='deletePlanProduct' style='margin-right: 10px; color: red; font-size: 20px;' data-toggle='tooltip' title='ลบข้อมูลประมาณการ'></i>";
                    tableData +="</td>";
                tableData +="</tr>"
            }
            tableData +="<tr style='background: beige;'>"
                tableData +='<td colspan="3"></td>';
                tableData +='<td>ปริมาณรวม :</td>';
                tableData +='<td>'+toMoney(parseFloat(totalQuality))+'</td>';
                tableData +='<td>มูลค่ารวม :</td>';
                tableData +='<td>'+toMoney(parseFloat(totalPrice))+'</td>';
                tableData +='<td>บาท</td>';
            tableData +="</tr>"
        }
        console.log(tableData);
        $("#examplePlan-Table tbody").html(tableData);
    }
    $('#examplePlan-Table tbody').on('click', '#deletePlanProduct', function () {
        var x = confirm("ต้องการลบข้อมูลหรือไม่ ?");
        if(x){
            var spinner = $('#loader');
            spinner.show();
            var rowIndex = $(this).closest('tr').attr('id');
            var indexList = listPlanProducts.findIndex(item => item.dataId === rowIndex);
            listPlanProducts.splice(indexList, 1);
            initTablePlanProduct(listPlanProducts);
            spinner.hide();
        }
    } );
    $('#examplePlan-Table tbody').on('click', '#updatePlanProduct', function () {
        var spinner = $('#loader');
        spinner.show();
        var rowIndex = $(this).closest('tr').attr('id');
        var indexList = listPlanProducts.findIndex(item => item.dataId === rowIndex);
        var row = $(this).closest("tr").find("input");
        var quality = row[0].value;
        var pricePerProduct = row[1].value;
        var sumtotal = parseFloat((quality*pricePerProduct)).toFixed(2);
        listPlanProducts[indexList].quality = quality;
        listPlanProducts[indexList].pricePerProduct = pricePerProduct;
        listPlanProducts[indexList].totalPrice = sumtotal;
        initTablePlanProduct(listPlanProducts);
        spinner.hide();
    } );
    function disablefield(){
        $('.addfield').attr('disabled', true);
    }
    function loadMonthName(monthId){
        return $.ajax({
            type: "POST",
            url: "../util/loadMonthName.php",
            data: {monthId:monthId},
            async: false
        }).responseText;
    }

    $( "#addPlanListProductBtn" ).click(function() {
        spinner.show();
        var supportdata = $("#support_form").serialize().split("&");
        var area_Id = $('#area_Id').val();
        var years_Id = $('#yearsId').val();
        var actionValue = $('#actionValue').val();
        $.ajax({
            url:"../handler/targetPlanHandler.php",
            method:"POST",
            data:{dataList:listPlanProducts, supportdatalist:supportdata, action:"add"},
            dataType:"text",
            success:function(data){
                window.location = encodeURI("./planProductListOfYears.php?yearsId="+years_Id+"&area_Id="+area_Id+"&action="+actionValue);
            }
        });
    });
    function toMoney(n) {
        return n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
    }

    $('#summaryTypeOfAgri_Id').select2();
    $('#summaryAgri_Id').select2();
    $('#summaryTypeOfAgri_Id').change(function(){
        var summaryTypeOfAgri_Id = $(this).val();
        if(summaryTypeOfAgri_Id != '0'){
            $.ajax({
                url:"../util/loadAgriProduct.php",
                method:"POST",
                data:{tpyeOfAgri_Id:summaryTypeOfAgri_Id, area_Id:area_Id},
                dataType:"text",
                success:function(data){
                    $('#summaryAgri_Id').html(data);
                    initTable();
                }
            });
        }else{
            initTable();
        }
     });
     $('#summaryAgri_Id').change(function(){
        initTable();
     });
    $( "#resetValueInpage" ).click(function() {
        location.reload();
    });
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
    $('#editOnTableBtn').click( function() {
        spinner.show();
        Table = $('#yearOfPlanList-Table').DataTable();
        var data = Table.$('input').serialize().split('&');
        var obj={};
        var tempid = '';
        var listProductPlan = [];
        for(var key in data) {
            if(tempid != data[key].split("_")[0]){
                if(tempid!= ''){
                    listProductPlan.push(obj);
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
            listProductPlan.push(obj);
        }
        console.log(listProductPlan);
        $.ajax({
            url:"../handler/targetPlanHandler.php",
            method:"POST",
            data: {data: listProductPlan, action: "updatelist"},
            dataType:"text",
            success:function(data){
                Table.ajax.reload();
            },complete:function(){
                initTable();
                spinner.hide();
            }
        });
    });
    $('#deleteOnTableBtn').click( function() {
        var deleteids_arr = [];
        $("input:checkbox[class=delete_check]:checked").each(function () {
            deleteids_arr.push($(this).val());
        });
        console.log(deleteids_arr);
        if(deleteids_arr.length > 0){
            var x = confirm("ต้องการลบข้อมูลที่เลือกทั้งหมดหรือไม่ ?");
            if(x){
            spinner.show();
                $.ajax({
                    url:"../handler/targetPlanHandler.php",
                    method:"POST",
                    data: {traget_Id: deleteids_arr, action: "deleteCheckB"},
                    dataType:"text",
                    success:function(data){
                        // $('#planProductList-table').DataTable().ajax.reload();
                        initTable();
                        $('#yearOfPlanList-Table').DataTable().ajax.reload();
                    },complete:function(){
                        jQuery('#checkall').prop('checked', false);
                        spinner.hide();
                    }
                });
            }
        }else{
            alert('กรุณาเลือกอย่างน้อย 1 ข้อมูลที่ต้องการลบ');
        }
    } );

    $('#editallIntableBtn').click( function() {
        $("#examplePlan-Table tbody tr").each(function(){
            var rowIndex = $(this).closest('tr').attr('id');
            var indexList = listPlanProducts.findIndex(item => item.dataId === rowIndex);
            if(indexList != '-1'){
                var row = $(this).closest("tr").find("input");
                var quality = row[0].value;
                var pricePerProduct = row[1].value;
                if(quality != listPlanProducts[indexList].quality || pricePerProduct != listPlanProducts[indexList].pricePerProduct){
                    var sumtotal = parseFloat((quality*pricePerProduct)).toFixed(2);
                    listPlanProducts[indexList].quality = quality;
                    listPlanProducts[indexList].pricePerProduct = pricePerProduct;
                    listPlanProducts[indexList].totalPrice = sumtotal;
                }
            }
        });
        initTablePlanProduct(listPlanProducts);
    });

    $('#planProductList-table').on('click', '#deleteProductPlan', function () {
        var x = confirm("ต้องการลบข้อมูลหรือไม่ ?");
        if(x){
            spinner.show();
            var tablelist = $('#planProductList-table').DataTable();
            var data = tablelist.row( $(this).parents('tr') ).data();
            $.ajax({
                url:"../handler/targetPlanHandler.php",
                method:"POST",
                data: {traget_Id: data[0], action: "delete"},
                dataType:"text",
                success:function(data){
                    tablelist.ajax.reload();
                    initTable();
                    $('#yearOfPlanList-Table').DataTable().ajax.reload();
                },complete:function(){
                    spinner.hide();
                }
            });
        }
    } );

    $('#planProductList-table tbody').on('click', '#editTargetPromote', function () {
        var area_Id = $('#area_Id').val();
        var years_Id = $('#yearsId').val();
        var Table = $('#planProductList-table').DataTable();
        var data = Table.row( $(this).parents('tr') ).data();
        $('#editTargetPromo').modal('show');
        $("#Promo_targetPlanId").val(data[0]);
        $("#Promo_argi_id").val(data[2]);
        $("#Promo_area_Id").val(area_Id);
        $("#Promo_yearsId").val(years_Id);
        $('#editTargetPromo #updateTargetPromo').html('');
        //load infomation list taget uint of plan
        $.ajax({
            url:"../handler/targetPlanHandler.php",
            method:"POST",
            data: {tragetPlan_Id: data[0], action: "loadPlanUint"},
            dataType:"text",
            success:function(datalist){
                console.log(datalist);
                report =JSON.parse(datalist);
                console.log(report);
                //put value infomation list taget uint of plan
                $.ajax({
                    url:"../util/loadAgriTagetUintPlanNew.php",
                    method:"POST",
                    data:{argi_id:data[2]},
                    dataType:"text",
                    success:function(data){
                        $('#editTargetPromo #updateTargetPromo').append(data);
                    },complete:function(){
                        for(var i=0;i<report.length;i++){
                            var value = report[i].uintPlan.split("-");
                            console.log(value);
                            $("#editTargetPromo #updateTargetPromo #"+value[0]).val(value[1]);
                        }
                    }
                });
            }
        });
    } );

    // $('#updateTargetPromoModal').on('click',function(){
    //     console.log('2222222');
    //     var targetPlanId = $('#Promo_targetPlanId').val();
    //     var listdata = $("#updateTargetPromo").serialize().split("&");
    //     console.log(targetPlanId);
    //     $.ajax({
    //         url:"../handler/targetPlanHandler.php",
    //         method:"POST",
    //         data:{listdata:listdata, targetPlanId:targetPlanId, action:"updateTargetPromo"},
    //         dataType:"text",
    //         success:function(data){
    //             $('#editTargetPromo').modal('hide');
    //         }
    //     });
    // });

    

})(jQuery);

function a1_onclick ($argi_Id, $market_Id) {
    console.log($argi_Id ," :: ", $market_Id);
    
    jQuery("#editPlanProductFromList").modal({ show: true, backdrop: true, keyboard: true });
    var Table = jQuery('#planProductList-table').DataTable();
    Table.destroy();
    jQuery('#editPlanProductFrom #argi_Id').val($argi_Id);
    jQuery('#editPlanProductFrom #market_Id').val($market_Id);
    initTableList ($argi_Id, $market_Id);
    jQuery('#checkallNB').prop('checked', false);
}

function initTableList ($argi_Id, $market_Id){
    var area_Id = jQuery('#area_Id').val();
    var years_Id = jQuery('#yearsId').val();
    var actionValue = jQuery('#actionValue').val();
    var permssion = jQuery('#permssion').val();
    var Table = jQuery('#planProductList-table').DataTable( {
        pageLength: 10,
        'dom': "<'row'<'col-sm-6'Bl><'col-sm-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'bottombuttons col-sm-12'>><'row'<'col-sm-5'i><'col-sm-7'p>>",
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
                    // 'columns': [4,17,15,18,19,5,6,9,20,21,12,7,8]
                    'columns': [5,18,16,19,20,6,7,10,11,12,13,8,9,21,22,23,24,25,26]
                    },
                    'title': 'ข้อมูลเป้าหมายรายได้และผลผลิต',

            },
            { 'extend':'excel',
            'action':newexportaction ,
            'exportOptions': {
                'modifier': {
                'page': 'All',
                'search': 'none'
                },
                'columns': [5,18,16,19,20,6,7,10,11,12,13,8,9,21,22,23,24,25,26]
                // 'columns': [4,17,15,18,19,5,6,9,20,21,12,7,8]
                },
                'title': 'ข้อมูลเป้าหมายรายได้และผลผลิต',
            },
            { 'extend':'print',
            'action':newexportaction ,
            'exportOptions': {
                'modifier': {
                'page': 'ALL',
                'search': 'none'
                },
                'columns': [5,18,16,19,20,6,7,10,11,12,13,8,9,21,22,23,24,25,26]
                // 'columns': [4,17,15,18,19,5,6,9,20,21,12,7,8]
                },
                'title': 'ข้อมูลเป้าหมายรายได้และผลผลิต',
            },
            ]
        }],
        "processing": true,
        "responsive": true,
        "serverSide": true,
        "ajax": "../server_side/targetPlanDetailList.php?yearsId="+years_Id+"&area_Id="+area_Id+"&argi_Id="+$argi_Id+"&market_Id="+$market_Id,
        "autoWidth": false,
        'fixedColumns':{
        'heightMatch': 'none'
        },
        'columnDefs': [{
            "targets": [0,1,2,3,14,15,16,17,18,19,20,21,22,23,24,25,26],
                "visible": false
        },{
            "targets": [4],
            'searchable': false,
            'orderable': false,
            'render': function (data, type, row){
                return "<center><input type='checkbox' class='delete_checkNB' id='delcheck_"+row[0]+"' onclick='checkcheckboxNB();' value='"+row[0]+"'></center>";
            }
        },{
            "targets": [8,9],
            'width': 120,
        },{
            'targets': [11],
            'width': 100,
            'searchable': false,
            'orderable': false,
            'className': 'dt-header-center',
            'render': function (data, type, row){
                if(actionValue == "2" || actionValue == "4" || permssion == "manager"){
                    return toMoney(parseFloat(data));
                }else{
                    return "<div style=' font-size: 20px; '><input id='"+row[0]+"_totalQuality' name='"+row[0]+"_totalQuality' value='"+parseFloat((data)).toFixed(2)+"' onkeypress='isNumberKey(this,event)' class='form-control' type='text'></div>";
                }
            }
        },{
            'targets': [12],
            'width': 100,
            'searchable': false,
            'orderable': false,
            'className': 'dt-header-center',
            'render': function (data, type, row){
                if(actionValue == "2" || actionValue == "4" || permssion == "manager"){
                    return toMoney(parseFloat(data));
                }else{
                    return "<div style=' font-size: 20px; '><input id='"+row[0]+"_productPrice' name='"+row[0]+"_productPrice' value='"+parseFloat((data)).toFixed(2)+"' onkeypress='isNumberKey(this,event)' class='form-control' type='text'></div>";
                }
            }
        },{
            'targets': [13],
            'width': 100,
            'searchable': false,
            'orderable': false,
            'className': 'dt-header-center',
            'render': function (data, type, row){
                return toMoney(parseFloat(data));
            }
        },{
            'targets': [27],
            // 'targets': [20],
            "visible": false,
            'render': function (data, type, row){
                return toMoney(parseFloat(row[10]));
            }
        },{
            'targets': [28],
            // 'targets': [21],
            "visible": false,
            'render': function (data, type, row){
                return toMoney(parseFloat(row[11]));
            }
        },{
            "targets": [18],
            'render' : function (data,type,row){
                if(parseInt(row[3]) > '9'){
                    return parseInt(data-1);
                }else{
                    return data;
                }
            }
        },{
            'targets': [29],
            // 'targets': [22],
            'width': 100,
            'searchable': false,
            'orderable': false,
            'className': 'dt-header-center',
            'render': function (data, type, full, meta){
                if( actionValue == "2" || actionValue == "4" || permssion == "manager"){
                    data = '<div style=" font-size: 20px; "><center>'
                        +'<i class="fa fa-align-justify" style=" cursor: pointer;margin-right: 20px; color: blue;" data-toggle="tooltip" title="ข้อมูลการส่งเสริมพืช" name="editTargetPromote" id="editTargetPromote"></i>'
                        +'</center></div>';
                    return data
                }else{
                    data = '<div style=" font-size: 20px; "><center>'
                        +'<i class="fa fa-align-justify" style=" cursor: pointer;margin-right: 20px; color: blue;" data-toggle="tooltip" title="ข้อมูลการส่งเสริมพืช" name="editTargetPromote" id="editTargetPromote"></i>'
                        +'<i class="fa ti-trash" style="cursor: pointer;margin-right: 10px; color: red;" id="deleteProductPlanNB"></i>'
                        +'</center></div>';
                    return data
                }
            }
        }
        ],
        'order': [[1, 'asc'], [ 2, 'asc' ],  [ 14, 'asc' ]],
    } );
    jQuery('.bottombuttons').html("<div class='row form-group' style='float: right;'><div class='col col-sm-6' id='editBtn'><button type='button' class='btn btn-info' onclick='return editOnTableBtnOnPopUp();' id='editOnTableBtn' name='editOnTableBtn' ><i class='fa fa-edit'></i>&nbsp; แก้ไขทั้งหมด</button></div><div class='col col-sm-4' id='deleteBtn'><button type='button' class='btn btn-danger' onclick='return deleteOnTableBtnOnPopUp();' id='deleteOnBuBtn' name='deleteOnBuBtn' ><i class='fa ti-trash'></i>&nbsp; ลบข้อมูลที่เลือก</button></div></div>");
    if( actionValue == "2" || actionValue == "4" || permssion == "manager"){
        var table = jQuery('#planProductList-table').DataTable();
        table.columns([22]).visible( false);
        table.columns([4]).visible( false);
        jQuery('.bottombuttons').html('');
    }
    jQuery('#checkallNB').prop('checked', false);
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
    console.log(222);
    spinner.show();
    var Table = jQuery('#planProductList-table').DataTable();
    var data = Table.$('input').serialize().split('&');
    var argi_Id = jQuery('#editPlanProductFrom #argi_Id').val();
    var market_Id = jQuery('#editPlanProductFrom #market_Id').val();
    var obj={};
    var tempid = '';
    var listProductPlan = [];
    for(var key in data) {
        if(tempid != data[key].split("_")[0]){
            if(tempid!= ''){
                listProductPlan.push(obj);
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
        listProductPlan.push(obj);
    }
    console.log(listProductPlan);
    jQuery.ajax({
        url:"../handler/targetPlanHandler.php",
        method:"POST",
        data: {data: listProductPlan, action: "updatelist"},
        dataType:"text",
        success:function(data){
            Table.ajax.reload();
        },complete:function(){
            //initTableList(argi_Id, market_Id);
            jQuery('#yearOfPlanList-Table').DataTable().ajax.reload();
            initTable();
            spinner.hide();
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
    console.log(totalchecked);
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

function initTable() {
    jQuery("#dashTable tbody").html("");
    var area_Id = jQuery('#area_Id').val();
    var years_Id = jQuery('#yearsId').val();
    var summaryMonth_id = jQuery('#summaryMonth_id').val();
    var summaryTypeOfAgri_Id = jQuery('#summaryTypeOfAgri_Id').val();
    var summaryAgri_Id = jQuery('#summaryAgri_Id').val();
    jQuery.ajax({
        url:"../util/summaryProductPlan.php",
        method:"POST",
        data:{area_Id:area_Id, years_Id:years_Id, summaryMonth_id:summaryMonth_id, summaryTypeOfAgri_Id: summaryTypeOfAgri_Id, summaryAgri_Id: summaryAgri_Id},
        dataType:"text",
        success:function(data){
            jQuery("#dashTable tbody").html(data);
        }
    });
}

jQuery('#planProductList-table').on('click', '#deleteProductPlanNB', function () {
    var y = confirm("ต้องการลบข้อมูลหรือไม่ ?");
    if(y){
        var Table = jQuery('#planProductList-table').DataTable();
        var data = Table.row( jQuery(this).parents('tr') ).data();
        console.log(data);
        jQuery.ajax({
            url:"../handler/targetPlanHandler.php",
            method:"POST",
            data: {traget_Id: data[0], action: "delete"},
            dataType:"text",
            success:function(data){
                Table.ajax.reload();
                jQuery('#yearOfPlanList-Table').DataTable().ajax.reload();
                initTable();
            }
        });
    }
} );

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
                url:"../handler/targetPlanHandler.php",
                method:"POST",
                data: {traget_Id: deleteids_arr, action: "deleteCheckB"},
                dataType:"text",
                success:function(data){
                    jQuery('#planProductList-table').DataTable().ajax.reload();
                    initTable();
                    jQuery('#yearOfPlanList-Table').DataTable().ajax.reload();
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