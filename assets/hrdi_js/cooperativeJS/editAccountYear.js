(function ($) {


    var yearsStart = new Date().getFullYear()+543;
    var d = new Date();
    var year = d.getFullYear();
    var month = d.getMonth();
    var day = d.getDate();
    var c = new Date(year + 543, month, day);


    $('.account_year_startTmp').datepicker({
        format: "dd MM yyyy",
        language:  'th',
        changeMonth: false,
        changeYear: false,
        startDate: new Date(yearsStart,0,1),
        thaiyear: true,
        stepMonths: 0
    });


    $('.account_year_endTmp').datepicker({
        format: "dd MM yyyy",
        language:  'th',
        changeMonth: false,
        changeYear: false,
        startDate: new Date(yearsStart+1,0,1),
        thaiyear: true,
        stepMonths: 0
    });


    $('#EditAccountYear').on('show.bs.modal', function (e) {
        var id =$(e.relatedTarget).data('id');
        $("#EditAccountYear #account_year_id").val(id);
         loadAccountYear(id);

    });

    $("#EditAccountYear #idArea").select2(
        { tags: true,
         dropdownParent: $("#EditAccountYear")
       }
        );



        $('#EditAccountYear #editBtn').on('click', function (e) {
            editData();
        });


      $('#EditAccountYear').on('hidden.bs.modal', function (e) {
          clearDataAdd();
      });

        $('#EditAccountYear #clear').on('click', function (e) {

          clearDataAdd();

      });

      $('#EditAccountYear #idRiverBasin').change(function(){
        var idRiverBasin = $(this).val();
         $.ajax({
             url:"../util/AreaDependent.php",
             method:"POST",
             data:{idRiverBasin:idRiverBasin},
             dataType:"text",
             success:function(data){
                 $('#EditAccountYear #idArea').html(data);
             }
         });
     });

     $('#EditAccountYear #idArea').change(function(){
        var idArea = $(this).val();
         $.ajax({
             url:"../util/personByArea.php",
             method:"POST",
             data:{idArea:idArea},
             dataType:"text",
             success:function(data){
                 $('#EditAccountYear #customer').html(data);
             }
         });
     });

     $('#EditAccountYear #idArea').change(function(){
        var idArea = $(this).val();
         $.ajax({
             url:"../util/InstituteDependent.php",
             method:"GET",
             data:{idArea:idArea},
             dataType:"text",
             success:function(data){
                 $('#EditAccountYear #institute_id').html(data);
             },complete:function(){
                $('#EditAccountYear #institute_id').trigger('change');
             }
         });
     });


     $('#EditAccountYear #institute_id').change(function(){
        var institute_id = $(this).val();
         $.ajax({
             url:"../util/loadSubGroupbyIns.php",
             method:"POST",
             data:{institute_id:institute_id},
             dataType:"text",
             success:function(data){
                 $('#EditAccountYear #sub_group_id').html(data);
             },complete:function(){
                $('#EditAccountYear #sub_group_id').trigger('change');
             }
         });
     });


    function editData(){
        var sub_group_id=  jQuery("#EditAccountYear #sub_group_id").val();
        var year_text =  jQuery("#EditAccountYear #year_text").val();
        var account_year_start=  "";


        var account_year_id  =  jQuery("#EditAccountYear #account_year_id").val();
        if(jQuery("#EditAccountYear #account_year_start").val()!=""){
            account_year_start = dateToDB2(deltaDate(new Date(jQuery("#EditAccountYear #account_year_start").val()),0,0,-543).toLocaleDateString('en-US'));
        }
        var account_year_end="";
        if(jQuery("#EditAccountYear #account_year_end").val()!=""){
            account_year_end = dateToDB2(deltaDate(new Date(jQuery("#EditAccountYear #account_year_end").val()),0,0,-543).toLocaleDateString('en-US'));
        }
        var current_bugget=  jQuery("#EditAccountYear #current_bugget").val();
        var bank_bugget=  jQuery("#EditAccountYear #bank_bugget").val();
        var stocks_amount =   jQuery("#EditAccountYear #stocks_amount").val();
        var stocks_price=  jQuery("#EditAccountYear #stocks_price").val();
        var status=  jQuery("#EditAccountYear #status option:selected").val();

    var formData= new FormData();

        formData.append('account_year_id',account_year_id);
        formData.append('sub_group_id',sub_group_id);
        formData.append('year_text',year_text);
        formData.append('account_year_start',account_year_start);
        formData.append('account_year_end',account_year_end);
        formData.append('current_bugget',current_bugget);
        formData.append('bank_bugget',bank_bugget);
        formData.append('stocks_amount',stocks_amount);
        formData.append('stocks_price',stocks_price);
        formData.append('status',status);
        formData.append('action',"update");

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
            $('#EditAccountYear').modal('toggle');
            Table.ajax.reload();
        }
      });
    }

    function clearDataAdd(){
         $('#EditAccountYear input[type="text"]').val('');
          $('#EditAccountYear input[type="number"]').val('');
          $("#EditAccountYear #institute_id").append('').trigger('change');
    }

    function loadAccountYear(id){
        $.ajax({
            url: "../handler/accountYearHandler.php",
            type: "POST",
            dataType: "html",
            async: true,
            data:{'account_year_id':id,'action':'load'},
            success:function(data){
                var result = JSON.parse(data);
                mapData(result);
            }
        });
    }

    function mapData(result){

        $.ajax({
            url: "../util/loadInsBySubGroupId.php?sub_group_id="+result.sub_group_id,
            type: "GET",
            dataType: "html",
            async: true,
            success:function(data_detail){
                var dataDetail = JSON.parse(data_detail);
                jQuery("#EditAccountYear #idRiverBasin").val(dataDetail[0].RiverBasin_idRiverBasin);
                jQuery("#EditAccountYear #idArea").val(dataDetail[0].idArea).trigger("change");
                jQuery("#EditAccountYear #institute_id").val(dataDetail[0].institute_id).trigger("change");
                jQuery("#EditAccountYear #sub_group_id").val(dataDetail[0].sub_group_id).trigger("change");

            }
        });
        jQuery("#EditAccountYear #year_text").val(result.year_text);
        jQuery("#EditAccountYear #current_bugget").val(result.current_bugget);
        jQuery("#EditAccountYear #bank_bugget").val(result.bank_bugget);
        jQuery("#EditAccountYear #stocks_amount").val(result.stocks_amount);
        jQuery("#EditAccountYear #stocks_price").val(result.stocks_price);
        jQuery("#EditAccountYear #status").val(result.status).trigger('change');

        var d1 =  new Date(result.account_year_start.date);
        var year1 = d1.getFullYear();
        var month1 = d1.getMonth();
        var day1 = d1.getDate();
        var c1 = new Date(year1 + 543, month1, day1);
          $('#EditAccountYear .account_year_startTmp').datepicker({
            format: "dd MM yyyy",
            language:  'th',
            changeMonth: false,
            changeYear: false,
            thaiyear: true,
            stepMonths: 0
        }).datepicker("setDate", c1);

        var d2 =  new Date(result.account_year_end.date);
        var year2 = d2.getFullYear();
        var month2 = d2.getMonth();
        var day2 = d2.getDate();
        var c2 = new Date(year2 + 543, month2, day2);
          $('#EditAccountYear .account_year_endTmp').datepicker({
            format: "dd MM yyyy",
            language:  'th',
            changeMonth: false,
            changeYear: false,
            thaiyear: true,
            stepMonths: 0
        }).datepicker("setDate",c2);
    }


})(jQuery);


