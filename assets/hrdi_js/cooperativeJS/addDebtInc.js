(function ($) {
    var yearsStart = new Date().getFullYear()+540;
    var d = new Date();
    var year = d.getFullYear();
    var month = d.getMonth();
    var day = d.getDate();
    var c = new Date(year + 543, month, day);


    $('#debtIncomeAdd').on('show.bs.modal', function (e) {
        var debtAll= $("#editIncome #debt").val();

          $('#debtIncomeAdd .debtDateTmp').datepicker({
            format: "dd MM yyyy",
            language:  'th',
            changeMonth: false,
            changeYear: false,
            thaiyear: true,
            stepMonths: 0 ,
            todayBtn: true,
            todayHighlight: true
        }).datepicker("setDate",c);

          $("#debtIncomeAdd #all").val(debtAll);




    });


    $("#debtIncomeAdd  #addDebtBtn").on('click',function(){
        addDebtIncome();
      });

      $("#debtIncomeAdd").on('hidden.bs.modal',function(){
        clearDataAdd();
      });

      $('#debtIncomeAdd #transfer').click(function() {
        if ($(this).is(':checked')) {
             $('#debtIncomeAdd #attach').show();
        }else{
            $('#debtIncomeAdd #attach').hide();
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





function addDebtIncome(){

    var debtDate = jQuery("#debtIncomeAdd #debtDate").val();
    var doc_no =jQuery("#debtIncomeAdd #doc_no").val();
    var pay = parseFloat(jQuery("#debtIncomeAdd #amount").val());
    var income_id =jQuery("#editIncome #income_id").val();
    var create_by =jQuery("#idStaff").val();
    var all =parseFloat(jQuery("#all").val());
    var file ;
    var transfer="N";

    if(jQuery('#debtIncomeAdd #transfer').prop("checked")){
        file =  $('#debtIncomeAdd #fileToUpload').prop('files')[0];
        transfer="Y";
    }

    if(pay > all){
        alert('ยอดการชำระไม่ถูกต้องกรุณาตรวจสอบ');
        return false;
    }
    if (confirm('ยืนยันการชำระ')) {

    var formData= new FormData();
    formData.append('debtDate', dateToDB2(deltaDate(new Date(debtDate),0,0,-543).toLocaleDateString('en-US').substring(0, 10)));
    formData.append('doc_no',doc_no);
    formData.append('pay',pay);
    formData.append('income_id',income_id);
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
        url: "../handler/DebtIncomeHandler.php",
        dataType: "html",
        async: true,
        success: function(data) {
            loadDebtIncome(income_id);
        },complete:function(){
            calDebtIncome();
        }
      });
    }
}
function calDebtIncome(){
    var pay = jQuery("#debtIncomeAdd #amount").val();
    var income_id =jQuery("#editIncome #income_id").val();
    var update_by =jQuery("#idStaff").val();
    var formData= new FormData();

    formData.append('debt',pay);
    formData.append('update_by',update_by);
    formData.append('income_id',income_id);
    formData.append('action',"calDebt");

    $.ajax({
        type: "POST",
        cache: false,
        contentType: false,
        processData: false,
        dataType:'text',
        data:formData,
        url: "../handler/DebtIncomeHandler.php",
        dataType: "html",
        async: true,
        success: function(data) {
            $('#debtIncomeAdd').modal('toggle');
            $('#editIncome').modal('toggle');
        }
      });

}

    function clearDataAdd(){
         $('#debtIncomeAdd input[type="text"]').val('');
          $('#debtIncomeAdd input[type="number"]').val('');
          $("#debtIncomeAdd select").val('0').trigger('change');
          $("#debtIncomeAdd #transfer").attr('checked',false);
          $("#debtIncomeAdd #blah").attr('src', '');
    }


})(jQuery);




