(function ($) {
    var spinner = $('#loader');
    var listDeliverProducts = [];
    var listCartDeliverProducts = [];
    var listimage = [];
    var dataId = 0;
    var yearsId = $('#yearsId').val();
    var monthId = $('#monthId').val();
    var area_Id = $('#area_Id').val();
    var idStaff = $('#idStaff').val();
    var yearsStart = 2563;
    var yearsEnd = 2563;
    var monthIdStart = 0;
    var monthIdEnd = 0;
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
    if(monthId == 1){
        monthIdStart = 13;
        yearsStart = (yearsStart-1);
        monthIdEnd = monthId;
    }else if (monthId == 12){
        monthIdStart = monthId;
        monthIdEnd = 0;
    }else{
        monthIdStart = monthId;
        monthIdEnd = monthId;
    }
    
    console.log(yearsStart, ";;", monthIdStart, ";;" ,monthId, ";;", monthIdEnd, ';;', yearsEnd);
    caltotalofprice();
    caltotalofLossValue();
    loadDeliverCart(yearsId, monthId, area_Id, idStaff);
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
    $('.farmer-dropdown').select2();
    $('#typeAgri_Id').select2();
    $('#agri_Id').select2();
    $('#market_Id').select2();
    $('#farmer_Id').change(function(){
        var person_Id = $(this).val();
        $.ajax({
            url:"../util/loadTypeOfAgriFromFarmer.php",
            method:"POST",
            data:{person_Id:person_Id, area_Id:area_Id},
            dataType:"text",
            success:function(data){
                $('#typeAgri_Id').html(data);
            }
        });
        loadLandDetail(person_Id);
     });

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
        loadGradeProduct(agri_Id, area_Id)
        loadProductStandard(agri_Id);
        loadSpeciesDW(agri_Id);
     });
    function loadSpeciesDW(agri_Id){
        $.ajax({
            url:"../util/loadSpeciesDW.php",
            method:"POST",
            data:{argi_id:agri_Id},
            dataType:"text",
            success:function(data){
                $('#speciesId').html(data);
            }
        });
    }

    var date = new Date();
    console.log(yearsStart);
    console.log(yearsEnd);
    console.log(monthIdStart-1);
    console.log(monthIdEnd);
    $('.dateNow').datepicker({
        format: "dd MM yyyy",
        language:  'th',
        changeMonth: false,
        changeYear: false,
        startDate: new Date(yearsStart,monthIdStart-1,1),
        endDate: new Date(yearsEnd, monthIdEnd, 0),
        thaiyear: true,
        stepMonths: 0
    });

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

    function loadLandDetail(person_Id){
        console.log(person_Id)
        $.ajax({
            url:"../util/loadLandDetail.php",
            method:"POST",
            data:{person_Id:person_Id},
            dataType:"text",
            success:function(data){
                $('#landDetail').html(data);
            }
        });
    }
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

    $('#deliverProduct_form').on('click', '#addDeliverProduct', function () {
        spinner.show();
        listCartDeliverProducts = [];
        var dataMap = $("#deliverProduct_form").serialize().split("&");
        console.log(listimage);
        var obj={};
        for(var key in dataMap) {
            obj[dataMap[key].split("=")[0]] = dataMap[key].split("=")[1];
        }
        obj.listimage = listimage;
        obj.person_Id = $('#farmer_Id').val();
        if(obj.person_Id == '0' || obj.typeAgri_Id == '0' || obj.agri_Id == '0' || obj.market_Id == '0' || obj.quality == '' || obj.price == '' || obj.dtp_input2 == ''){
            alert("กรุณากรอกข้อมูลให้ครบถ้วน");
            spinner.hide();
            return false;
        }
        console.log(obj);
        listCartDeliverProducts.push(obj);
        $.ajax({
            url:"../handler/deliverProductHandler.php",
            method:"POST",
            data:{dataValue:listCartDeliverProducts, area_Id:area_Id, action:"createTemp"},
            dataType:"text",
            success:function(data){
                obj.dataId = parseInt(data);
                listDeliverProducts.push(obj);
            }, complete: function(data) {
                spinner.hide();
                initTable(listDeliverProducts);
            }
        });
        resetfield(dataMap);
    } );

    function resetfield(data){
        var area_Id = $('#area_Id').val();
        var farmer_Id = $('#farmer_Id').val()
        // $('.reset').trigger("reset");
        var obj={};
        for(var key in data) {
            obj[data[key].split("=")[0]] = data[key].split("=")[1];
        }
        $("#quality").val('');
        $("#price").val('');
        $("#lossValue").val('');
        $("#totalQuality").val('');
        $("#totalPricre").val('');
        
        $('#market_Id').val(0).trigger('change');
        $('#gardProduct option[value="0"]').attr("selected",true);
        $('#landDetail option[value="0"]').attr("selected",true);
        $('#logistic_Id option[value="0"]').attr("selected",true);
        $('#standardProduct option[value="0"]').attr("selected",true);
        $('#imageTable').html('');
        $( ".dateNow" ).datepicker('setDate', null);
        $('.dateNow').datepicker({
            format: "dd MM yyyy",
            language:  'th',
            changeMonth: false,
            changeYear: false,
            startDate: new Date(yearsStart,monthIdStart-1,1),
            endDate: new Date(yearsEnd, monthIdEnd, 0),
            thaiyear: true,
            stepMonths: 0,
            setDate: null
        });
        $( ".dateAll" ).datepicker('setDate', null);

        $.ajax({
            url:"../util/loadTypeOfAgriFromFarmer.php",
            method:"POST",
            data:{person_Id:data[1], area_Id:area_Id},
            dataType:"text",
            success:function(data){
                $('#typeAgri_Id').html(data);
            },
            complete:function(){
                $('#typeAgri_Id option[value="'+obj['typeAgri_Id']+'"]').attr("selected",true);
                $.ajax({
                    url:"../util/loadAgriFromFarmer.php",
                    method:"POST",
                    data:{tpyeOfAgri_Id:obj['typeAgri_Id'], area_Id:area_Id, person_Id:farmer_Id},
                    dataType:"text",
                    success:function(data){
                        $('#agri_Id').html(data);
                    },
                    complete:function(){
                        $('#agri_Id option[value="'+obj['agri_Id']+'"]').attr("selected",true);
                    }
                });
            }
        });
    }

    function initTable(listDeliverProducts){
        $("#dashTable tbody").html("");
        var tableData="";
        console.log(listDeliverProducts);
        if(listDeliverProducts != "") {
            for(var i=0;i<listDeliverProducts.length;i++){
                console.log(listDeliverProducts[i])
                tableData +="<tr id="+listDeliverProducts[i].dataId+">";
                    tableData +='<td>'+listDeliverProducts[i].dtp_input2+'</td>';
                    tableData +='<td>'+
                        $.ajax({
                            type: "POST",
                            url: "../util/loadPersonName.php",
                            data: {personId:listDeliverProducts[i].person_Id},
                            async: false
                        }).responseText;+
                    '</td>';
                    tableData +='<td>'+loadAgriName(listDeliverProducts[i].agri_Id);+'</td>';
                    tableData +='<td>'+
                        $.ajax({
                            type: "POST",
                            url: "../util/loadStandard.php",
                            data: {market_Id:listDeliverProducts[i].standardProduct},
                            async: false
                        }).responseText;+
                    '</td>';
                    tableData +='<td>'+
                        $.ajax({
                            type: "POST",
                            url: "../util/loadGradeName.php",
                            data: {market_Id:listDeliverProducts[i].gardProduct},
                            async: false
                        }).responseText;+
                    '</td>';
                    tableData +='<td>'+listDeliverProducts[i].quality+'</td>';
                    // tableData +='<td>'+listDeliverProducts[i].lossValue+'</td>';
                    if(listDeliverProducts[i].lossValue != null && listDeliverProducts[i].lossValue != ''){
                        tableData +='<td>'+listDeliverProducts[i].lossValue+'</td>'
                    }else{
                        tableData +='<td>0</td>'
                    }
                    tableData +='<td>'+listDeliverProducts[i].totalQuality+'</td>';
                    tableData +='<td>'+listDeliverProducts[i].price+'</td>';
                    tableData +='<td>'+listDeliverProducts[i].totalPricre+'</td>';
                    tableData +='<td>'+
                        $.ajax({
                            type: "POST",
                            url: "../util/loadMarketName.php",
                            data: {market_Id:listDeliverProducts[i].market_Id},
                            async: false
                        }).responseText;+
                    '</td>';
                    tableData +='<td>'+
                        $.ajax({
                            type: "POST",
                            url: "../util/loadCustomerName.php",
                            data: {market_Id:listDeliverProducts[i].market_Id},
                            async: false
                        }).responseText;+
                    '</td>';
                    tableData +="<td>";
                    tableData +="<button type='button' class='btn btn-danger' id='deleteDeliver' name='deleteDeliver' style='margin-right: 10px;'><i class='fa fa-minus-square-o' data-toggle='tooltip' title='ลบข้อมูลส่งมอบผลผลิต'></i></button>";
                    tableData +="<button type='button' class='btn btn-danger' id='showDetail' name='showDetail' style='margin-right: 10px;'><i class='fa fa-eye' data-toggle='tooltip' title='ดูข้อมูล'></i></button>";
                    tableData +="</td>";
                tableData +='</tr>';
            }
            $("#dashTable tbody").html(tableData);
        }
    }
    $('#dashTable tbody').on('click', '#deleteDeliver', function () {
        var rowIndex = $(this).closest('tr').attr('id');
        console.log(rowIndex);
        spinner.show();
        $.ajax({
            url:"../handler/deliverProductHandler.php",
            method:"POST",
            data:{dataCartId:rowIndex, action:"DeleteItemInCartTemp"},
            dataType:"text",
            success:function(data){
            }, complete: function(data) {
                var indexList = listDeliverProducts.findIndex(item => item.dataId == rowIndex);
                listDeliverProducts.splice(indexList, 1);
                spinner.hide();
                initTable(listDeliverProducts);
            }
        });
        
    } );
    $('#dashTable tbody').on('click', '#showDetail', function () {
        var rowIndex = $(this).closest('tr').attr('id');
        console.log(rowIndex);
        $('#viewShowImageDetail').modal('show');
        console.log(listDeliverProducts);
        console.log(listDeliverProducts.findIndex(item => item.dataId == rowIndex));
        loadImageShowList(listDeliverProducts[listDeliverProducts.findIndex(item => item.dataId == rowIndex)]);
    } );
    function loadImageShowList(data){
        console.log(data);
        $('#viewShowImage_form #imageTable').html('');
        var listdata = data.listimage;
        var result = "";
        for (i = 0; i < listdata.length; i++) {
            console.log(listdata[i].parthImage);
            result+="<tr>";
            result+="<td><img src='"+listdata[i].parthImage+"' style=' height: 150px;float: left;'></td>";
            result+="</tr>";
        }
        $('#viewShowImage_form #imageTable').html(result);
    }

    function loadAgriName(agri_Id){
        console.log (agri_Id);
        return $.ajax({
            type: "POST",
            url: "../util/loadAgriName.php",
            data: {agri_Id:agri_Id},
            async: false
        }).responseText;
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
    function loadPersonFromAgriConn(area_Id, personId){
        $.ajax({
            url:"../util/loadPersonFromAgriConn.php",
            method:"POST",
            data:{area_Id:area_Id},
            dataType:"text",
            success:function(data){
                $('#farmer_Id').html();
                $('#farmer_Id').html(data);
                $('#farmer_Id').val(parseInt(personId)).trigger('change');
            }
        });
    }
    $( "#addDeliverPerson" ).click(function() {
        console.log(listDeliverProducts);
        if(listDeliverProducts == ''){
            alert("กรุณากรอกข้อมูลให้ครบถ้วน");
            return false;
        }
        spinner.show();
        var area_Id = $('#area_Id').val();
        var yearsId = $('#yearsId').val();
        var monthId = $('#monthId').val();
        var idStaff = $('#idStaff').val();
        $.ajax({
            url:"../handler/deliverProductHandler.php",
            method:"POST",
            data:{yearsId:yearsId, monthId:monthId, area_Id:area_Id, idStaff, action:"createItemInCart"},
            dataType:"text",
            success:function(data){
                window.location = "./deliverProductList.php?area_Id="+area_Id+"&yearsId="+yearsId+"&monthId="+monthId;
            }
        });
    });

    $( "#addNewPerson" ).click(function() {
        $('#createPersonDialog').modal('show');
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
    
    $("#createNewPerson" ).click(function() {
        var personListDeail = [];
        var data = $("#createPerson_form").serialize();
        var area_Id = $('#area_Id').val();
        var data = $("#createPerson_form").serialize().split("&");
        var obj={};
        for(var key in data) {
            obj[data[key].split("=")[0]] = data[key].split("=")[1];
        }
        personListDeail.push(obj);
        var personId;
        $.ajax({
            url:"../util/checkPerson.php",
            method:"POST",
            data:{area_Id:area_Id, firstName:obj.argname, lastName:obj.argsurname},
            dataType:"text",
            success:function(data){
                console.log(data);
                if(data == '1'){
                    alert("มีข้อมูลเกษตรกรอยู่ในระบบแล้ว !");
                    return false;
                }else{
                    $.ajax({
                        url:"../handler/deliverProductHandler.php",
                        method:"POST",
                        data:{data:personListDeail, action:"createPerson", area_Id:area_Id},
                        dataType:"text",
                        success:function(data){
                            $("#createPerson_form").trigger('reset');
                            $('#createPersonDialog').modal('hide');
                            personId = data;
                            loadPersonFromAgriConn(area_Id,personId);
                        }
                    });
                }
            }
        });
        
    });
    $("#createNewLogistic" ).click(function() {
        var Logistic = $('#Logistic').val();
        $.ajax({
            url:"../handler/deliverProductHandler.php",
            method:"POST",
            data:{action:"createLogistic", Logistic:Logistic},
            dataType:"text",
            success:function(data){
                $('#createLogisticDialog').modal('hide');
                logisticId = data;
                loadlogistic(logisticId);
            }
        });
    });
    function loadlogistic(logisticId){
        $.ajax({
            url:"../util/loadLogisticLists.php",
            method:"POST",
            dataType:"text",
            success:function(data){
                $('#logistic_Id').html();
                $('#logistic_Id').html(data);
                $('#logistic_Id').val(parseInt(logisticId)).trigger('change');
            }
        });
    }
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
    function initImageList(listimage){
        $("#imageTable tbody").html("");
        if(listimage != "") {
            var tableData="";
            for(var i=0;i<listimage.length;i++){
                tableData +="<tr id="+listimage[i].idimage+">";
                    tableData +='<td><img src='+listimage[i].parthImage+' style=" height: 150px;float: left;"></td>';
                    tableData +="<td><button type='button' class='btn btn-danger' id='deleteImage' name='deleteImage' style='margin-top: 50px'><i class='fa fa-minus-square-o' data-toggle='tooltip' title='ลบรูปนี้'></i></button></td>";
                tableData +='</tr>';
            }
            $("#imageTable tbody").html(tableData);
        }
    }
    $('#imageTable tbody').on('click', '#deleteImage', function () {
        var rowIndex = $(this).closest('tr').attr('id');
        var indexList = listimage.findIndex(item => item.idimage == rowIndex);
        listimage.splice(indexList, 1);
        initImageList(listimage);

    } );
    $( "#resetValueInpage" ).click(function() {
        x = confirm("คุณต้องการลบข้อมลูการส่งมอบที่ค้างไว้หรือไม่ !!");
        if(x == true){
            spinner.show();
            var area_Id = $('#area_Id').val();
            var yearsId = $('#yearsId').val();
            var monthId = $('#monthId').val();
            var idStaff = $('#idStaff').val();
            $.ajax({
                url:"../handler/deliverProductHandler.php",
                method:"POST",
                data:{yearsId:yearsId, monthId:monthId, area_Id:area_Id, idStaff:idStaff, action:"deleteAllItemInCart"},
                dataType:"text",
                success:function(data){
                    location.reload();
                }
            });
        }else{
            return false;
        }
    });
    function loadDeliverCart(yearsId, monthId, area_Id, idStaff) {
        spinner.show();
        listDeliverProducts = [];
        $.ajax({
            url:"../handler/deliverProductHandler.php",
            method:"POST",
            data:{yearsId:yearsId, monthId:monthId, area_Id:area_Id, idStaff:idStaff, action:"loadInfoDeliverCart"},
            dataType:"text",
            success:function(data){
                results = JSON.parse(data);
            },complete:function(){
                if(results != "") {
                    alert("คุณมีการส่งมอบที่ยังไม่ได้ยืนยัน !");
                    listDeliverProducts = results;
                    initTable(listDeliverProducts);
                }
                spinner.hide();
            }
        });
    }
})(jQuery);

