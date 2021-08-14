
(function ($) {
    var id =0;
    $("#editIncome #idRiverBasin").select2();
    $("#editIncome #idArea").select2();
    $("#editIncome #institute_id").select2();
     $("#editIncome #customer").select2();
    $("#editIncome #product").select2();
    $("#editIncome #customer_search").select2();
    $("#editIncome #product_add").select2();
    $("#editIncome #canceled").select2();

        $("#editIncome input:radio[name='pay_type']").on('change', function (event) {
        if(this.value=='product'){
          $("#editIncome #product_div").show(300);
          $("#editIncome #other_div").hide(300);
        }else{
          $("#editIncome #product_div").hide(300);
          $("#editIncome #other_div").show(300);
        }
        $("#editIncome [name^='pay_type']:radio").attr('disabled',true);

    });


    $("#editIncome #amount").on("change",function(){
        $("#editIncome #otherPay").val(calOtherPay($(this).val(),$("#editIncome #price").val(),$("#editIncome #discount").val()));
    });
    $("#editIncome #price").on("change",function(){
        $("#editIncome #otherPay").val(calOtherPay($("#editIncome #amount").val(),$(this).val(),$("#editIncome #discount").val()));
    });

    $("#editIncome #discount").on("change",function(){
        $("#editIncome #otherPay").val(calOtherPay($("#editIncome #amount").val(),$("#editIncome #price").val(),$(this).val()));
    });

    $('#editIncome #editIncomeBtn').on('click',function(){
        updateIncome(id);
    });

    $("#editIncome #receive_amount").on("blur",function(){
        var otherPay = parseFloat($("#editIncome #otherPay").val());
        var receive_amount = parseFloat($(this).val());
        if(receive_amount >otherPay){
            alert("ระบุจำนวนไม่ถูกต้อง");
            return false;
        }
         var debt=   calDebt(otherPay,receive_amount);
         $("#editIncome #debt").val(debt);
    });

    $('#editIncome').on('show.bs.modal', function (e) {
         id =$(e.relatedTarget).data('id');
         $("#editIncome #income_id").val(id);
         loadIncome(id);
         loadDebtIncome(id);


    });

    $('#editIncome').on('hidden.bs.modal', function (e) {
        Table.ajax.reload();
        jQuery("#main #addIncome #customer").select2();
    });


    function loadIncome(id){
        $.ajax({
            url: "../handler/incomeHandler.php?income_id="+id,
            type: "POST",
            dataType: "html",
            async: true,
            data:{'income_id':id,'action':'load'},
            success:function(data){
                var incomeEdit =JSON.parse(data);
                mapIncome(incomeEdit);
            }
        });
    }
    function mapIncome(incomeEdit){
        var instituteInfo ;
        $.ajax({
            url: "../util/loadInstituteInfo.php?institetu_id="+incomeEdit.institute_id,
            type: "GET",
            dataType: "html",
            async: true,
            success:function(data){
                 instituteInfo =JSON.parse(data);
                 var $AreaOption = $("<option selected='selected'></option>").val(instituteInfo[0].idArea.toString()).text(instituteInfo[0].areaName.toString())
                 var $RiverOption = $("<option selected='selected'></option>").val(instituteInfo[0].RiverBasin_idRiverBasin.toString()).text(instituteInfo[0].nameRiverBasin.toString())
                 var $insOption = $("<option selected='selected'></option>").val(instituteInfo[0].INSTITUTE_ID.toString()).text(instituteInfo[0].INSTITUTE_NAME.toString())

                $("#editIncome #canceled").val(incomeEdit.canceled).trigger('change');

                $("#editIncome #addDebt").hide();
                if(incomeEdit.debt==0 || incomeEdit.debt==null || incomeEdit.canceled=="Y"){
                    $("#editIncome #addDebt").hide();
                }else{
                    $("#editIncome #addDebt").show();
                }


                if(incomeEdit.canceled=="Y"){
                    $("#editIncome #canceled").attr("disabled","disabled");
                    $("#editIncome #comment").attr("disabled","disabled");
                    $('#editIncome #editIncomeBtn').attr("disabled","disabled");
                }else{
                    $("#editIncome #canceled").removeAttr("disabled");
                    $("#editIncome #comment").removeAttr("disabled");
                    $('#editIncome #editIncomeBtn').removeAttr("disabled");
                }
                $("#editIncome #idRiverBasin").append($RiverOption).trigger('change');
                $("#editIncome #idArea").append($AreaOption).trigger('change');
                $("#editIncome #institute_id").append($insOption).trigger('change');



                var d =  new Date(incomeEdit.receive_date.date);
                var year = d.getFullYear();
                var month = d.getMonth();
                var day = d.getDate();
                var c = new Date(year + 543, month, day);
                  $('#editIncome .receiveDateTmp').datepicker({
                    format: "dd MM yyyy",
                    language:  'th',
                    changeMonth: false,
                    changeYear: false,
                    thaiyear: true,
                    stepMonths: 0
                }).datepicker("setDate", c);


                $("#editIncome #doc_no").val(incomeEdit.doc_no);
                $("#editIncome #receive_amount").val(incomeEdit.receive_amount);
                $("#editIncome #comment").val(incomeEdit.comment);

                var institute_id = incomeEdit.institute_id;
                     $.ajax({
                         url:"../util/loadSubGroupbyIns.php",
                         method:"POST",
                         data:{institute_id:institute_id},
                         dataType:"text",
                         success:function(data){
                             $('#editIncome #sub_group_id').html(data);
                         },complete:function(){
                            $('#editIncome #sub_group_id').val(incomeEdit.sub_group_id);
                            $('#editIncome #sub_group_id').trigger('change');
                         }
                     });


                 $('#editIncome #sub_group_id').change(function(){
                    var sub_group_id = $(this).val();
                     $.ajax({
                         url:"../util/loadBusinessBySubGroup.php",
                         method:"POST",
                         data:{sub_group_id:sub_group_id},
                         dataType:"text",
                         success:function(data_bus){
                             $('#editIncome #business_group_id').html(data_bus);
                         },complete:function(){
                            $('#editIncome #business_group_id').val(incomeEdit.business_group_id).trigger('change');;
                         }
                     });
                 });

                            if( incomeEdit.income_other_id ==0 ||  incomeEdit.income_other_id ==null){
                                $("input[name='pay_type']").filter('[value=product]').prop('checked', true).trigger('change');
                                $("#editIncome #product_div #discount").val(incomeEdit.discount);
                                $("#editIncome #product_div #amount").val(incomeEdit.amount);
                                $("#editIncome #product_div #price").val(incomeEdit.price);

                                var $OrderOption = $("<option selected='selected'></option>").val(incomeEdit.order_id.toString()).text(incomeEdit.order_name.toString())
                                $("#editIncome #product_div #product_add").append($OrderOption).trigger('change');

                                $("#editIncome #product_div #otherPay").val(calOtherPay(incomeEdit.price,incomeEdit.amount,incomeEdit.discount));
                                $("#editIncome #product_div #other_customer").attr("disabled","disabled");
                                $("#editIncome #product_div #product_add").attr("disabled","disabled");

                            }else{
                                $("input[name='pay_type']").filter('[value=other]').prop('checked', true).trigger('change');
                                 var $IncomeDetailOption = $("<option selected='selected'></option>").val(incomeEdit.income_other_id.toString()).text(incomeEdit.income_detail.toString())

                                $("#editIncome #income_other_id").append($IncomeDetailOption).trigger('change');
                                $("#editIncome #other_div #price").val(incomeEdit.price);
                                $("#editIncome #otherPay").val(incomeEdit.price);
                                $("#editIncome #other_customer").val(incomeEdit.other_customer);
                                $("#editIncome #customer").attr("disabled","disabled");
                                $("#editIncome #other_customer").attr("disabled","disabled");
                                $("#editIncome #income_other_id").attr("disabled","disabled");
                            }


                    var customer = getPersonById(incomeEdit.customer);
                    if(customer.trim().length >0){
                        var cusJson = JSON.parse(customer);
                        var $CustomerOption = $("<option selected='selected'></option>").val(cusJson.idPerson.toString()).text(cusJson.firstName.toString()+" "+cusJson.lastName.toString())
                        $("#editIncome #customer").append($CustomerOption).trigger('change');
                    }else{
                        $("#editIncome #other_customer").val(incomeEdit.other_customer);
                    }
                    $("#editIncome #other_customer").attr("disabled","disabled");
                    $("#editIncome #customer").attr("disabled","disabled");
                    $("#editIncome #receive_amount").attr("disabled","disabled");
                    $("#editIncome #debt").val(incomeEdit.debt);
                    $("#editIncome #debt").attr("disabled","disabled");

            }
        });

    }

    function getPersonById(id){
        var result;
        $.ajax({
            url:"../handler/personHandler.php",
            method:"POST",
            data:{'person_id':id ,'action':'load'},
            dataType:"text",
            async: false,
            success:function(data){
                result=data;
            }
        });
          return result;
    }

    function updateIncome(id){
     var update_by = $("#idStaff").val();
     var canceled = $("#editIncome #canceled option:selected").val();
     var comment = $("#editIncome #comment").val();
     var debt= $("#editIncome #debt").val();
     var receive_amount= $("#editIncome #receive_amount").val();

    var formData= new FormData();
    formData.append('income_id',id);
    formData.append('update_by',update_by);
    formData.append('canceled',canceled);
    formData.append('comment',comment);
    formData.append('debt',debt);
    formData.append('receive_amount',receive_amount);
    formData.append('action','update');
    $.ajax({
        type: "POST",
        cache: false,
        contentType: false,
        processData: false,
        dataType:'text',
        data:formData,
        url: "../handler/incomeHandler.php",
        dataType: "html",
        async: true,
        success: function(data) {
            $('#editIncome').modal('toggle');
            id=0;
            Table.ajax.reload();
        }
      });




    }



    $('#editIncome').on('hidden.bs.modal', function (e) {
        clearData();
        id =0;
    });




})(jQuery);

function calOtherPay(price,amount,discount){
    var p =0;
    var a =0;
    var d=0;
    if(price!="" && price!=null){
        p = parseFloat(price);
    }
    if(amount!="" && amount!=null){
        a = parseFloat(amount);
    }
    if(discount!="" && discount!=null){
        d = parseFloat(discount);
    }
    return ((p*a)-d).toFixed(2);
}

function clearData(){
    jQuery("#editIncome select").val('0').trigger('change');
    jQuery("#editIncome #other_customer").val('');
}
function calDebt(all,receive_amount){
    var result=0;
    if(all !="" && receive_amount!=""){
        result = all-receive_amount;
    }
    return result;
}

function loadDebtIncome(id){
    jQuery.ajax({
        url: "../handler/DebtIncomeHandler.php?income_id="+id,
        type: "POST",
        dataType: "html",
        async: true,
        data:{'income_id':id,'action':'load'},
        success:function(data){
            var debtIncome =JSON.parse(data);
            displayDebt(debtIncome);
        }
    });
}


function displayDebt(debtIncome){
    var html ="";
    jQuery("#editIncome tbody").html('');
      if(debtIncome.length>0){

          for(var i=0;i<debtIncome.length;i++){
              html+="<tr>"
                  html+="<td>"+(i+1)+"</td>";
                  html+="<td>"+debtIncome[i].create_date+"</td>";
                  html+="<td>"+debtIncome[i].doc_no+"</td>";
                  html+="<td>"+debtIncome[i].pay+"</td>";
                  if(debtIncome[i].attach!=null){
                    html+="<td><p class='parent'>"+debtIncome[i].attach+"</p><img class='child' style=' display: none; ' src='../../../img/Attach/"+debtIncome[i].attach+"'></td>";
                  }else{
                    html+="<td></td>";
                  }

                  html+="<td  style='color:red' id='disableDebt'> <input type='hidden' id='debtAmount' value='"+debtIncome[i].pay+"'></input> <input type='hidden' id='debt_doc_no' value='"+debtIncome[i].doc_no+"'> <input type='hidden' id='debtId' value='"+debtIncome[i].debt_id+"'> <input type='hidden' id='attach' value='"+debtIncome[i].attach+"'><i class='fa fa-ban' id='removeDebt' data-id='"+debtIncome[i].debt_id+"'></i> </td>";
              html+="</tr>"
          }

          jQuery("#editIncome tbody").html(html);
      }else{
          jQuery("#editIncome tbody").html("<tr><td colspan='6' style='text-align: center;'>ไม่พบรายการ</td></tr>");
      }
      jQuery('#editIncome .parent').on('click',function (e) {
          if( jQuery(this).parent().find('.child').css('display')=='inline'){
            jQuery(this).parent().find('.child').css('display','none');
          }else{
            jQuery(this).parent().find('.child').css('display','inline');
          }

     });


      jQuery('#editIncome #removeDebt').on('click', function (e) {
        var debtAmount = jQuery(this).closest('tr').find('#debtAmount').val();
        var debt_doc_no = jQuery(this).closest('tr').find('#debt_doc_no').val();
        var attach = jQuery(this).closest('tr').find('#attach').val();
        if (confirm('ยืนยันการยกเลิกรายการ เลขที่:'+debt_doc_no+' จำนวน:'+debtAmount)) {
            var income_id=  jQuery('#income_id').val();
            var debtId=  jQuery(this).data('id');
            var user = jQuery("#staffId").val();
            jQuery.ajax({
                url: "../handler/DebtIncomeHandler.php",
                type: "POST",
                dataType: "html",
                async: true,
                data:{'income_id':income_id,'debtId':debtId,'debtAmount':debtAmount,'user':user,'attach':attach,'action':'cancelDebt'},
                success:function(data){
                    loadDebtIncome(income_id);

                },complete:function(){
                    jQuery('#editIncome').modal('toggle');
                }
            });
        }
      });

  }
  function updateIncomeDebt(amount){
     var debtAll= parseFloat($("#editIncome #debt").val());
     if(amount <=debtAll ){
          var result = debtAll-amount;
          $("#editIncome #debt").val(result).trigger('change');
     }
  }
