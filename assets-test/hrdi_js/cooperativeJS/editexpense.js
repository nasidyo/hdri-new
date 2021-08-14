(function ($) {


  var id =0;

    $("#editExpense #idRiverBasin").select2();
    $("#editExpense #idArea").select2();
    $("#editExpense #institute_id").select2();
    $("#editExpense #customer").select2();
    $("#editExpense #product").select2();
    $("#editExpense #customer_search").select2();
    $("#editExpense #product_add").select2();
    $("#editExpense #expense_other_id").select2();
    $("#editExpense #canceled").select2();

    $("#editExpense input:radio[name='pay_type']").on('change', function (event) {
        if(this.value=='product'){
          $("#editExpense #product_div").show(300);
          $("#editExpense #other_div").hide(300);
        }else{
          $("#editExpense #product_div").hide(300);
          $("#editExpense #other_div").show(300);
        }
        $("#editExpense [name^='pay_type']:radio").attr('disabled',true);

    });
        $("#editExpense #amount").on("change",function(){
            $("#editExpense #otherPay").val(calOtherPay($(this).val(),$("#editExpense #price").val(),$("#editExpense #discount").val()));
        });
        $("#editExpense #price").on("change",function(){
            $("#editExpense #otherPay").val(calOtherPay($("#editExpense #amount").val(),$(this).val(),$("#editExpense #discount").val()));
        });

        $("#editExpense #discount").on("change",function(){
            $("#editExpense #otherPay").val(calOtherPay($("#editExpense #amount").val(),$("#editExpense #price").val(),$(this).val()));
        });



        $("#editExpense #expense_amount").on("blur",function(){
            var otherPay = parseFloat($("#editExpense #otherPay").val());
            var expense_amount = parseFloat($(this).val());
            if(expense_amount >otherPay){
                alert("ระบุจำนวนไม่ถูกต้อง");
                return false;
            }
             var debt=   calDebt(otherPay,expense_amount);
             $("#editExpense #debt").val(debt);
        });
        $('#editExpense #editExpenseBtn').on('click',function(){
            updateExpense(id);
        });



    $('#editExpense').on('show.bs.modal', function (e) {
        var id =$(e.relatedTarget).data('id');
        $("#editExpense #expense_id").val(id);
         loadExpense(id);
         loadDebtExpense(id);
    });
    $('#editExpense').on('hidden.bs.modal', function (e) {
        Table.ajax.reload();
        $("#main #addExpense #customer").select2();
    });

    function loadExpense(id){
        $.ajax({
            url: "../handler/expenseHandler.php?expense_id="+id,
            type: "POST",
            dataType: "html",
            async: true,
            data:{'expense_id':id,'action':'load'},
            success:function(data){
                var expenseEdit =JSON.parse(data);
                mapExpense(expenseEdit);
            }
        });
    }
    function mapExpense(expenseEdit){
        var instituteInfo ;
        $.ajax({
            url: "../util/loadInstituteInfo.php?institetu_id="+expenseEdit.institute_id,
            type: "GET",
            dataType: "html",
            async: true,
            success:function(data){
                 instituteInfo =JSON.parse(data);
                 var $AreaOption = $("<option selected='selected'></option>").val(instituteInfo[0].idArea.toString()).text(instituteInfo[0].areaName.toString())
                 var $RiverOption = $("<option selected='selected'></option>").val(instituteInfo[0].RiverBasin_idRiverBasin.toString()).text(instituteInfo[0].nameRiverBasin.toString())
                 var $insOption = $("<option selected='selected'></option>").val(instituteInfo[0].INSTITUTE_ID.toString()).text(instituteInfo[0].INSTITUTE_NAME.toString())

                $("#editExpense #canceled").val(expenseEdit.canceled).trigger('change');

                $("#editExpense #addDebt").hide();
                if(expenseEdit.debt==0 || expenseEdit.debt==null || expenseEdit.canceled=="Y"){
                    $("#editExpense #addDebt").hide();
                }else{
                    $("#editExpense #addDebt").show();
                }


                if(expenseEdit.canceled=="Y"){
                    $("#editExpense #canceled").attr("disabled","disabled");
                    $("#editExpense #comment").attr("disabled","disabled");
                    $('#editExpense #editExpenseBtn').attr("disabled","disabled");
                }else{
                    $("#editExpense #canceled").removeAttr("disabled");
                    $("#editExpense #comment").removeAttr("disabled");
                    $('#editExpense #editExpenseBtn').removeAttr("disabled");
                }
                $("#editExpense #idRiverBasin").append($RiverOption).trigger('change');
                $("#editExpense #idArea").append($AreaOption).trigger('change');
                $("#editExpense #institute_id").append($insOption).trigger('change');

                var d =  new Date(expenseEdit.expense_date.date);
                var year = d.getFullYear();
                var month = d.getMonth();
                var day = d.getDate();
                var c = new Date(year + 543, month, day);
                  $('#editExpense .expenseDateTmp').datepicker({
                    format: "dd MM yyyy",
                    language:  'th',
                    changeMonth: false,
                    changeYear: false,
                    thaiyear: true,
                    stepMonths: 0
                }).datepicker("setDate", c);

                $("#editExpense #doc_no").val(expenseEdit.doc_no);
                $("#editExpense #expense_amount").val(expenseEdit.expense_amount);
                $("#editExpense #comment").val(expenseEdit.comment);

                if( expenseEdit.expense_other_id ==0 ||  expenseEdit.expense_other_id ==null){
                    // order_id
                    $("input[name='pay_type']").filter('[value=product]').prop('checked', true).trigger('change');
                    $("#editExpense #product_div #discount").val(expenseEdit.discount);
                    $("#editExpense #product_div #amount").val(expenseEdit.amount);
                    $("#editExpense #product_div #price").val(expenseEdit.price);

                    var $OrderOption = $("<option selected='selected'></option>").val(expenseEdit.order_id.toString()).text(expenseEdit.order_name.toString())
                    $("#editExpense #product").append($OrderOption).trigger('change');
                    $("#editExpense #otherPay").val(calOtherPay(expenseEdit.price,expenseEdit.amount,expenseEdit.discount));

                    $("#editExpense #other_customer").attr("disabled","disabled");
                    $("#editExpense #product").attr("disabled","disabled");

                    var customer = getPersonById(expenseEdit.customer);
                    if(customer!=null && customer!=0 ){
                        var cusJson = JSON.parse(customer);
                        var $CustomerOption = $("<option selected='selected'></option>").val(cusJson.idPerson.toString()).text(cusJson.firstName.toString()+" "+cusJson.lastName.toString())
                        $("#editExpense #customer").append($CustomerOption).trigger('change');
                    }
                    $("#editExpense #customer").attr("disabled","disabled");

                }else{
                    //expense_other_id
                    $("input[name='pay_type']").filter('[value=other]').prop('checked', true).trigger('change');
                    var $ExpenseDetailOption = $("<option selected='selected'></option>").val(expenseEdit.expense_other_id.toString()).text(expenseEdit.expense_detail.toString())
                    $("#editExpense #expense_other_id").append($ExpenseDetailOption).trigger('change');
                    $("#editExpense #other_div #price").val(expenseEdit.price);
                    $("#editExpense #otherPay").val(expenseEdit.price);
                    $("#editExpense #other_customer").val(expenseEdit.other_customer);
                    $("#editExpense #customer").attr("disabled","disabled");
                    $("#editExpense #other_customer").attr("disabled","disabled");
                    $("#editExpense #expense_other_id").attr("disabled","disabled");

                }
                    var institute_id = expenseEdit.institute_id;
                     $.ajax({
                         url:"../util/loadSubGroupbyIns.php",
                         method:"POST",
                         data:{institute_id:institute_id},
                         dataType:"text",
                         success:function(data){
                             $('#editExpense #sub_group_id').html(data);
                         },complete:function(){
                            $('#editExpense #sub_group_id').val(expenseEdit.sub_group_id);
                            $('#editExpense #sub_group_id').trigger('change');
                         }
                     });


                 $('#editExpense #sub_group_id').change(function(){
                    var sub_group_id = $(this).val();
                     $.ajax({
                         url:"../util/loadBusinessBySubGroup.php",
                         method:"POST",
                         data:{sub_group_id:sub_group_id},
                         dataType:"text",
                         success:function(data_bus){
                             $('#editExpense #business_group_id').html(data_bus);
                         },complete:function(){
                            $('#editExpense #business_group_id').val(expenseEdit.business_group_id);
                         }
                     });
                 });



                $("#editExpense #debt").val(expenseEdit.debt);
                $("#editExpense #expense_amount").attr("disabled","disabled");
                $("#editExpense #debt").attr("disabled","disabled");
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





    $('#editExpense').on('hidden.bs.modal', function (e) {
        clearData();
    });





function updateExpense(id){
    var update_by = jQuery("#idStaff").val();
    var canceled = jQuery("#editExpense #canceled option:selected").val();
    var comment = jQuery("#editExpense #comment").val();
    var debt= jQuery("#editExpense #debt").val();
    var expense_amount= jQuery("#editExpense #expense_amount").val();
    var expense_id= jQuery("#editExpense #expense_id").val();
    var sub_group_id= jQuery("#editExpense #sub_group_id option:selected").val();

   var formData= new FormData();
   formData.append('expense_id',expense_id);
   formData.append('update_by',update_by);
   formData.append('canceled',canceled);
   formData.append('comment',comment);
   formData.append('sub_group_id',sub_group_id);


   formData.append('debt',debt);
   formData.append('expense_amount',expense_amount);
   formData.append('action','update');
   jQuery.ajax({
       type: "POST",
       cache: false,
       contentType: false,
       processData: false,
       dataType:'text',
       data:formData,
       url: "../handler/expenseHandler.php",
       dataType: "html",
       async: true,
       success: function(data) {
        jQuery('#editExpense').modal('toggle');
           Table.ajax.reload();
       }
     });

   }




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
    jQuery("#editExpense select").val('0').trigger('change');
    jQuery("#editExpense input:not([name='pay_type'])").val('');
    jQuery("#editExpense [name^='pay_type']:radio").attr('disabled',false);
}
function calDebt(all,receive_amount){
    var result=0;
    if(all !="" && receive_amount!=""){
        result = all-receive_amount;
    }
    return result;
}

function loadDebtExpense(id){
    jQuery.ajax({
        url: "../handler/DebtExpenseHandler.php?expense_id="+id,
        type: "POST",
        dataType: "html",
        async: true,
        data:{'expense_id':id,'action':'load'},
        success:function(data){
            var debtExpense =JSON.parse(data);
            displayDebt(debtExpense);
        }
    });
}
function displayDebt(debtExpense){
  var html ="";
  jQuery("#editExpense tbody").html('');
    if(debtExpense.length>0){

        for(var i=0;i<debtExpense.length;i++){
            html+="<tr>"
                html+="<td>"+(i+1)+"</td>";
                html+="<td>"+debtExpense[i].create_date+"</td>";
                html+="<td>"+debtExpense[i].doc_no+"</td>";
                html+="<td>"+debtExpense[i].pay+"</td>";
                if(debtExpense[i].attach!=null){
                    html+="<td><p class='parent'>"+debtExpense[i].attach+"</p><img class='child' style=' display: none; ' src='../../../img/Attach/"+debtExpense[i].attach+"'></td>";
                  }else{
                    html+="<td></td>";
                  }
                html+="<td  style='color:red' id='disableDebt'> <input type='hidden' id='debtAmount' value='"+debtExpense[i].pay+"'></input> <input type='hidden' id='debt_doc_no' value='"+debtExpense[i].doc_no+"'>   <input type='hidden' id='debtId' value='"+debtExpense[i].debt_id+"'>  <input type='hidden' id='attach' value='"+debtExpense[i].attach+"'> </input> <i class='fa fa-ban'id='removeDebt' data-id='"+debtExpense[i].debt_id+"'></i></td>";
            html+="</tr>"
        }

        jQuery("#editExpense tbody").html(html);
    }else{
        jQuery("#editExpense tbody").html("<tr><td colspan='6' style='text-align: center;'>ไม่พบรายการ</td></tr>");
    }

    jQuery('#editExpense .parent').on('click',function (e) {
        if( jQuery(this).parent().find('.child').css('display')=='inline'){
          jQuery(this).parent().find('.child').css('display','none');
        }else{
          jQuery(this).parent().find('.child').css('display','inline');
        }

   });


    jQuery('#editExpense #removeDebt').on('click', function (e) {
        var debtAmount = jQuery(this).closest('tr').find('#debtAmount').val();
        var debt_doc_no = jQuery(this).closest('tr').find('#debt_doc_no').val();
        var attach = jQuery(this).closest('tr').find('#attach').val();
        if (confirm('ยืนยันการยกเลิกรายการ เลขที่:'+debt_doc_no+' จำนวน:'+debtAmount)) {
            var expense_id=  jQuery('#expense_id').val();
            var debtId=  jQuery(this).data('id');
            var user = jQuery("#staffId").val();
            jQuery.ajax({
                url: "../handler/DebtExpenseHandler.php",
                type: "POST",
                dataType: "html",
                async: true,
                data:{'expense_id':expense_id,'debtId':debtId,'debtAmount':debtAmount,'user':user,'attach':attach,'action':'cancelDebt'},
                success:function(data){
                    console.log(data);
                    loadDebtExpense(expense_id);

                },complete:function(){
                    jQuery('#editExpense').modal('toggle');
                }
            });
        }
      });

}
function updateExpenseDebt(amount){
   var debtAll= parseFloat($("#editExpense #debt").val());
   if(amount <=debtAll ){
        var result = debtAll-amount;
        $("#editExpense #debt").val(result).trigger('change');
   }
}
