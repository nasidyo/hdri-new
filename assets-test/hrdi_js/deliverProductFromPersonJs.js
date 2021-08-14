(function ($) {
    var spinner = $('#loader');
    caltotalofprice();
    caltotalofLossValue();
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
    $('#areaId').select2();
    $('#farmer_Id').select2();
    $('#typeAgri_Id').select2();
    $('#agri_Id').select2();
    $('#market_Id').select2();
    var yearsId = $('#yearsId').val();
    var monthId = $('#monthId').val();
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
    $('.dateAll').datepicker({
        format: "dd MM yyyy",
        language:  'th',
        thaiyear: true,
        stepMonths: 0
    });
    $('#areaId').change(function(){
        var area_Id = $(this).val();
        $.ajax({
            url:"../util/loadPersonFromAgriConn.php",
            method:"POST",
            data:{area_Id:area_Id},
            dataType:"text",
            success:function(data){
                $('#farmer_Id').html(data);
            }
        });
        $.ajax({
            url:"../util/loadMarketJsList.php",
            method:"POST",
            data:{area_Id:area_Id},
            dataType:"text",
            success:function(data){
                $('#market_Id').html(data);
            }
        });
    });
    $('#farmer_Id').change(function(){
        var farmer_Id = $(this).val();
        var area_Id = $('#areaId option:selected').val();
        $.ajax({
            url:"../util/loadTypeOfAgriFromFarmer.php",
            method:"POST",
            data:{person_Id:farmer_Id, area_Id:area_Id},
            dataType:"text",
            success:function(data){
                $('#typeAgri_Id').html(data);
            },complete: function(){
                loadLandDetail(farmer_Id);
            }
        });
    });
    $('#typeAgri_Id').change(function(){
        var typeAgri_Id = $(this).val();
        var area_Id = $('#areaId option:selected').val();
        var personId = $('#farmer_Id option:selected').val();
        $.ajax({
            url:"../util/loadAgriFromFarmer.php",
            method:"POST",
            data:{tpyeOfAgri_Id:typeAgri_Id, area_Id:area_Id, person_Id:personId},
            dataType:"text",
            success:function(data){
                $('#agri_Id').html(data);
            }
        });
    });

    $('#agri_Id').change(function(){
        var agri_Id = $(this).val();
        var area_Id = $('#areaId option:selected').val();
        loadUnitCodeOfProduct(agri_Id);
        loadGradeProduct(agri_Id, area_Id);
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
        var result = parseInt(first_number)*parseInt(second_number);
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

    $(":file").change(function() {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = imageIsLoaded;
            reader.readAsDataURL(this.files[0]);
        }
    });
  function imageIsLoaded(e) {
    $('.basic-img').attr('src', e.target.result);
  };

    $( "#addDeliverPerson" ).click(function() {
        spinner.show();
        var file = $('#file').prop('files')[0];
        var areaId = $('#areaId option:selected').val();
        var farmer_Id = $('#farmer_Id option:selected').val();
        var yearsId = $('#yearsId').val();
        var monthId = $('#monthId').val();
        var typeAgri_Id = $('#typeAgri_Id option:selected').val();
        var agri_Id = $('#agri_Id option:selected').val();
        var market_Id = $('#market_Id option:selected').val();
        var totalQuality = $('#totalQuality').val();
        var lossValue = $('#lossValue').val();
        var price = $('#price').val();
        var totalPricre = $('#totalPricre').val();
        var gardProduct = $('#gardProduct option:selected').val();
        var standardProduct = $('#standardProduct option:selected').val();
        var landDetail = $('#landDetail option:selected').val();
        var logistic_Id = $('#logistic_Id option:selected').val();
        var speciesId = $('#speciesId option:selected').val();
        var file = $('#file').prop('files')[0];
        var img =$('.basic-img').attr('src');
        var dtp_input3 = $('#dtp_input3').val();
        var dtp_input4 = $('#dtp_input4').val();
        console.log(dtp_input3);
        console.log(dtp_input4);
        var formData= new FormData();
        formData.append('fileToUpload',file);
        formData.append('areaId',areaId);
        formData.append('farmer_Id',farmer_Id);
        formData.append('yearsId',yearsId);
        formData.append('monthId',monthId);
        formData.append('typeAgri_Id',typeAgri_Id);
        formData.append('agri_Id',agri_Id);
        formData.append('market_Id',market_Id);
        formData.append('totalQuality',totalQuality);
        formData.append('lossValue',lossValue);
        formData.append('price',price);
        formData.append('totalPricre',totalPricre);
        formData.append('gardProduct',gardProduct);
        formData.append('standardProduct',standardProduct);
        formData.append('landDetail',landDetail);
        formData.append('logistic_Id',logistic_Id);
        formData.append('speciesId',speciesId);
        formData.append('dtp_input3',dtp_input3);
        formData.append('dtp_input4',dtp_input4);
        if(img!="" && img !="../images/noPic.jpg"){
            formData.append('image',img);
        }
        formData.append('action',"deliverProductMB");
        if(farmer_Id == '0' || typeAgri_Id == '0' || agri_Id == '0' || market_Id == '0' || totalQuality == '' || price == ''){
            alert("กรุณากรอกข้อมูลให้ครบถ้วน");
            spinner.hide();
            return false;
        }
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
            success: function(data) {
                result=data;
            },complete:function(){
                spinner.hide();
                var yearsId = $('#yearsId').val();
                var monthId = $('#monthId').val();
                alert("เพิ่มการส่งมอบแล้ว");
                $("input").val('');
                $('.basic-img').attr('src','');
                $('#framer_form').trigger("reset");
                $('#deliverProduct_form').trigger("reset");
                $('#areaId option:selected').val('0').trigger('change');
                $('#farmer_Id option:selected').val('0').trigger('change');
                $('#typeAgri_Id option:selected').val('0').trigger('change');
                $('#agri_Id option:selected').val('0').trigger('change');
                $('#market_Id option:selected').val('0').trigger('change');
                $('#yearsId').val(yearsId);
                $('#monthId').val(monthId);
            }
        });

    });
})(jQuery);
