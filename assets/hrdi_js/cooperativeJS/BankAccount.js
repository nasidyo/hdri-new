
var Table;
var sub_group_id;
(function ($) {
     sub_group_id =$("#sub_group_id").val();
     loadGroupName(sub_group_id);
     $("#home").on('click',function(){
        window.location.href ="personGroupManagement.php";
    });

     Table = $('#main #bankAccountTable').DataTable({
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
        dom: '<"top">r<tl><"bottom"ip><"clear">',
        pageLength: 10,
        processing: true,
        responsive: true,
        serverSide: true,
        ajax: {url:"../server_side/bankAccountSS.php?"+"sub_group_id="+sub_group_id,"type": "GET"},
        order: [[ 3, "desc" ]],
        columnDefs: [{
                        'targets': [3],
                        'width': 150,
                        'searchable': false,
                        'orderable': true,
                        'className': 'dt-header-center',
                        'render': function (data, type, full, meta){
                            return '<div style=" font-size: 20px; "  > <i class="fa fa-edit" style=" cursor: pointer;margin-right: 10px;" data-toggle="modal" data-target="#EditBankAccount" data-id="'+full[3]+'" id="edit"></i> </div>';

                        }
                    },
                    {
                        "targets": [0],
                        "visible": true,
                        "searchable": false
                    },
                    {
                        "targets": [1],
                        "visible": true,
                        "searchable": false

                    },
                    {
                        "targets": [2],
                        "visible": true,
                        "searchable": false

                    }
                ]

    });


    $("#AddBankAccount").on('show.bs.modal',function(){
        clearData("#AddBankAccount");
    });
    $("#AddBankAccount #addBtn").on('click',function(){
        saveData("#AddBankAccount")
    });

    $("#EditBankAccount").on('show.bs.modal',function(e){
        var id =$(e.relatedTarget).data('id');
        loadData(id);
    });
    $("#EditBankAccount #addBtn").on('click',function(){
        saveData("#EditBankAccount")
    });

    function loadGroupName(sub_group_id){
        var sub_group ;
        var areaName="";
        var formData= new FormData();
        formData.append('sub_group_id',sub_group_id);
        formData.append('action',"load");
         $.ajax({
            type: "POST",
            cache: false,
            contentType: false,
            processData: false,
            dataType:'text',
            data:formData,
            url: "../handler/subPersonGroupHandler.php",
            dataType: "html",
            async: true,
            success: function(data) {
                sub_group = JSON.parse(data);
                $.ajax({
                    url: "../util/loadInstituteInfo.php?institetu_id="+sub_group.institute_id,
                    type: "GET",
                    dataType: "html",
                    async: true,
                    success:function(data_sub_name){
                        areaName = JSON.parse(data_sub_name)[0].areaName;
                        $("#sub_group_name").text(areaName+" : "+sub_group.sub_group_name);

                        $("#sub_group_name_2").text(areaName+" : "+sub_group.sub_group_name);
                    }});
            }


          });
       }




})(jQuery);


function clearData(mode){
    jQuery(mode+" input").val('');
    jQuery(mode+" #status option[value='Y']").prop("selected",true)
}
function loadData(id){
    var formData= new FormData();
    formData.append('bank_account_id',id);
    formData.append('action','load');
    jQuery.ajax({
        type: "POST",
        cache: false,
        contentType: false,
        processData: false,
        dataType:'text',
        data:formData,
        url: "../handler/bankAccountHandler.php",
        dataType: "html",
        async: true,
        success: function(data) {
            var dataJ =JSON.parse(data);
            jQuery("#EditBankAccount #bank_account_id").val(dataJ.bank_account_id);
            jQuery("#EditBankAccount #bank_no").val(dataJ.bank_no);
            jQuery("#EditBankAccount #bank_name").val(dataJ.bank_name);
            jQuery("#EditBankAccount #status option[value='"+dataJ.status+"']").prop("selected",true)
        }
      });
}

function saveData(mode){
    var bank_account_id = jQuery(mode+" #bank_account_id").val();
    var bank_no = jQuery(mode+" #bank_no").val();
    var bank_name = jQuery(mode+" #bank_name").val();
    var status = jQuery(mode+" #status option:selected").val();

    var action ="";

    if(bank_no==""){
        alert("โปรดระบุเลขที่บัญชี");
        return false;
    }
    if(bank_name==""){
        alert("โปรดระบุชื่อธนาคาร");
        return false;
    }
    if(mode=="#AddBankAccount"){
        action ="add";
    }else{
        action ="update";
    }
    var formData= new FormData();
    formData.append('bank_account_id',bank_account_id);
    formData.append('bank_no',bank_no);
    formData.append('bank_name',bank_name);
    formData.append('status',status);
    formData.append('sub_group_id',sub_group_id);
    formData.append('action',action);
    jQuery.ajax({
        type: "POST",
        cache: false,
        contentType: false,
        processData: false,
        dataType:'text',
        data:formData,
        url: "../handler/bankAccountHandler.php",
        dataType: "html",
        async: true,
        success: function(data) {
         jQuery(mode).modal('toggle');
            Table.ajax.reload();
        }
      });





}
