(function ($) {
    var yearsStart = new Date().getFullYear()+540;
    var d = new Date();
    var year = d.getFullYear();
    var month = d.getMonth();
    var day = d.getDate();
    var c = new Date(year + 543, month, day);
    $('#debtExpenseAdd').on('show.bs.modal', function (e) {
        var debtAll= $("#editExpense #debt").val();

        $('#debtExpenseAdd .debtDateTmp').datepicker({
            format: "dd MM yyyy",
            language:  'th',
            changeMonth: false,
            changeYear: false,
            thaiyear: true,
            stepMonths: 0 ,
            todayBtn: true,
            todayHighlight: true
        }).datepicker("setDate",c);

          $("#debtExpenseAdd #all").val(debtAll);
          $("#debtExpenseAdd #debtDate").datepicker("setDate", new Date());




    });
    $("#debtExpenseAdd  #addDebtBtn").on('click',function(){
        addDebtExpense();
      });

      $('#debtExpenseAdd #transfer').click(function() {
        if ($(this).is(':checked')) {
             $('#debtExpenseAdd #attach').show();
        }else{
            $('#debtExpenseAdd #attach').hide();
        }
      });

      function readURL(input) {
        if (input.files && input.files[0]) {
          var reader = new FileReader();

          reader.onload = function(e) {
            $('#blah').attr('src', e.target.result);
          }

          reader.readAsDataURL(input.files[0]); // convert to base64 string
        }
      }

      $("#fileToUpload").change(function() {
        readURL(this);
      });



function addDebtExpense(){

    var debtDate = jQuery("#debtExpenseAdd #debtDate").val();
    var doc_no =jQuery("#debtExpenseAdd #doc_no").val();
    var pay = parseFloat(jQuery("#debtExpenseAdd #amount").val());
    var expense_id =jQuery("#editExpense #expense_id").val();
    var create_by =jQuery("#idStaff").val();
    var all =parseFloat(jQuery("#all").val());
    var file ;
    var transfer="N";
    if(jQuery('#debtExpenseAdd #transfer').prop("checked")){
        file =  $('#debtExpenseAdd #fileToUpload').prop('files')[0];
        transfer="Y";
    }

    if(pay > all){
        alert('ยอดการชำระไม่ถูกต้องกรุณาตรวจสอบ');
        return false;
    }
    if (confirm('ยืนยันการชำระ')) {

    var formData= new FormData();
   // formData.append('debtDate', dateToDB(debtDate));
   formData.append('debtDate', dateToDB2(deltaDate(new Date(debtDate),0,0,0).toLocaleDateString('en-US').substring(0, 10)));
    formData.append('doc_no',doc_no);
    formData.append('pay',pay);
    formData.append('expense_id',expense_id);
    formData.append('create_by',create_by);
    formData.append('file',file);
    formData.append('transfer',transfer);
    formData.append('action',"add");



    $.ajax({
        type: "POST",
        cache: false,
        contentType: false,
        processData: false,
        dataType:'text',
        data:formData,
        url: "../handler/DebtExpenseHandler.php",
        dataType: "html",
        async: true,
        success: function(data) {
            loadDebtExpense(expense_id);
        },complete:function(){
            calDebtExpense();
        }
      });
    }
}
function calDebtExpense(){
    var pay = jQuery("#debtExpenseAdd #amount").val();
    var expense_id =jQuery("#editExpense #expense_id").val();
    var update_by =jQuery("#idStaff").val();
    var formData= new FormData();

    formData.append('debt',pay);
    formData.append('update_by',update_by);
    formData.append('expense_id',expense_id);
    formData.append('action',"calDebt");

    $.ajax({
        type: "POST",
        cache: false,
        contentType: false,
        processData: false,
        dataType:'text',
        data:formData,
        url: "../handler/DebtExpenseHandler.php",
        dataType: "html",
        async: true,
        success: function(data) {
            $('#debtExpenseAdd').modal('toggle');
            $('#editExpense').modal('toggle');
        }
      });

}

    function clearDataAdd(){
         $('#debtExpenseAdd input[type="text"]').val('');
          $('#debtExpenseAdd input[type="number"]').val('');
          $("#debtExpenseAdd select").val('0').trigger('change');
          $("#debtExpenseAdd #transfer").attr('checked',false);
          $("#debtExpenseAdd #blah").attr('src', '');
    }


})(jQuery);



