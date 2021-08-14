(function ($) {


    var yearsStart = new Date().getFullYear()+523;
    var d = new Date();
    var year = d.getFullYear();
    var month = d.getMonth();
    var day = d.getDate();
    var c = new Date(year + 543, month, day);
    var e = new Date(year + 544, month, day);

    $('.account_year_startTmp').datepicker({
        format: "dd MM yyyy",
        language:  'th',
        changeMonth: false,
        changeYear: true,
        startDate: new Date(yearsStart,0,1),
        thaiyear: true,
        stepMonths: 0 ,
        todayBtn: true,
        todayHighlight: true
    }).datepicker("setDate",c);


    $('.account_year_endTmp').datepicker({
        format: "dd MM yyyy",
        language:  'th',
        changeMonth: false,
        changeYear: false,
        startDate: new Date(yearsStart+1,0,1),
        thaiyear: true,
        stepMonths: 0,
        todayBtn: true,
        todayHighlight: true
    }).datepicker("setDate",e);



    $("#AddAccountYear #idArea").select2(
        { tags: true,
         dropdownParent: $("#AddAccountYear")
       }
        );



        $('#AddAccountYear #addBtn').on('click', function (e) {
            addData();
        });


      $('#AddAccountYear').on('hidden.bs.modal', function (e) {
         clearDataAdd();
          $("#AddAccountYear #idArea").unbind('change');
      });

      $('#AddAccountYear').on('show.bs.modal', function (e) {

        $("#AddAccountYear #idArea").trigger('change');
    });

        $('#AddAccountYear #clear').on('click', function (e) {

          clearDataAdd();

      });

      $('#AddAccountYear #idRiverBasin').change(function(){
        var idRiverBasin = $(this).val();
         $.ajax({
             url:"../util/AreaDependentWithRole.php",
             method:"POST",
             data:{idRiverBasin:idRiverBasin,idArea:$("#AreaAll").val()},
             dataType:"text",
             success:function(data){
                 $('#AddAccountYear #idArea').html(data);
             }
         });
     });

     $('#AddAccountYear #idArea').change(function(){
        var idArea = $(this).val();
         $.ajax({
             url:"../util/personByArea.php",
             method:"POST",
             data:{idArea:idArea},
             dataType:"text",
             success:function(data){
                 $('#AddAccountYear #customer').html(data);
             }
         });
     });

     $('#AddAccountYear #idArea').change(function(){
        var idArea = $(this).val();
         $.ajax({
             url:"../util/InstituteDependent.php",
             method:"GET",
             data:{idArea:idArea},
             dataType:"text",
             success:function(data){
                 $('#AddAccountYear #institute_id').html(data);
             },complete:function(){
                $('#AddAccountYear #institute_id').trigger('change');
             }
         });
     });


     $('#AddAccountYear #institute_id').change(function(){
        var institute_id = $(this).val();
         $.ajax({
             url:"../util/loadSubGroupbyIns.php",
             method:"POST",
             data:{institute_id:institute_id},
             dataType:"text",
             success:function(data){
                 $('#AddAccountYear #sub_group_id').html(data);
             },complete:function(){
                $('#AddAccountYear #sub_group_id').trigger('click');
             }
         });
     });

     $('#AddAccountYear #sub_group_id').on('click',function(){
          var sub_group_id=  jQuery("#AddAccountYear #sub_group_id").val();
          if(sub_group_id==0){
            return false;
          }
          $.ajax({
             url:"../util/loadRefYear.php",
             method:"GET",
             data:{sub_group_id:sub_group_id},
             dataType:"text",
             success:function(data){
                 var dataJ= JSON.parse(data)[0];
                 if(dataJ!=undefined && dataJ !=""){
                    $('#AddAccountYear #year_ref').text(dataJ.year_text);
                    $('#AddAccountYear #current_bugget').val(dataJ.current_bugget);
                     $('#AddAccountYear #bank_bugget').val(dataJ.bank_bugget);
                      $('#AddAccountYear #stocks_amount').val(dataJ.stocks_amount);
                       $('#AddAccountYear #stocks_price').val(dataJ.stocks_price);
                 }

             }
         });
     });



    function addData(){
        var sub_group_id=  jQuery("#AddAccountYear #sub_group_id").val();
        var year_text =  jQuery("#AddAccountYear #year_text").val();
        var account_year_start=  "";
        if(jQuery("#AddAccountYear #account_year_start").val()!=""){
            account_year_start = dateToDB2(deltaDate(new Date(jQuery("#AddAccountYear #account_year_start").val()),0,0,-543).toLocaleDateString('en-US'));
        }
        var account_year_end="";
        if(jQuery("#AddAccountYear #account_year_end").val()!=""){
            account_year_end = dateToDB2(deltaDate(new Date(jQuery("#AddAccountYear #account_year_end").val()),0,0,-543).toLocaleDateString('en-US'));
        }
        var current_bugget=  jQuery("#AddAccountYear #current_bugget").val();
        var bank_bugget=  jQuery("#AddAccountYear #bank_bugget").val();
        var stocks_amount =   jQuery("#AddAccountYear #stocks_amount").val();
        var stocks_price=  jQuery("#AddAccountYear #stocks_price").val();
        var status=  jQuery("#AddAccountYear #status option:selected").val();
        if( sub_group_id == "" || year_text=="" || account_year_start=="" || account_year_end=="" || current_bugget=="" || stocks_amount=="" || stocks_price==""){
            alert('กรุณาตราจสอบข้อมูลให้ครบถ้วน');
            return false;
        }



    var formData= new FormData();
        formData.append('sub_group_id',sub_group_id);
        formData.append('year_text',year_text);
        formData.append('account_year_start',account_year_start);
        formData.append('account_year_end',account_year_end);
        formData.append('current_bugget',current_bugget);
        formData.append('bank_bugget',bank_bugget);
        formData.append('stocks_amount',stocks_amount);
        formData.append('stocks_price',stocks_price);
        formData.append('status',status);
        formData.append('action',"add");

    $.ajax({
        type: "POST",
        cache: false,
        contentType: false,
        processData: false,
        dataType:'text',
        data:formData,
        url: "../handler/accountYearHandler.php",
        dataType: "html",
        async: true,
        success: function(data) {
            $('#AddAccountYear').modal('toggle');
            Table.ajax.reload();
        }
      });
    }

    function clearDataAdd(){
         $('#AddAccountYear input[type="text"]').val('');
          $('#AddAccountYear input[type="number"]').val('');

            $('#AddAccountYear #year_ref').text('');

    }


})(jQuery);


