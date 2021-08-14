
var Table;
var sub_group_id;
(function ($) {
     sub_group_id =$("#sub_group_id").val();
     loadGroupName(sub_group_id);
     $("#home").on('click',function(){
        window.location.href ="personGroupManagement.php";
    });

     Table = $('#main #businessGroupTable').DataTable({
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
        dom: '<"top">r<tl><"bottom"ip><"clear">',
        pageLength: 10,
        processing: true,
        responsive: true,
        serverSide: true,
        ajax: {url:"../server_side/BusinessGroupSS.php?"+"sub_group_id="+sub_group_id,"type": "GET"},
        order: [[ 0, "desc" ]],
        columnDefs: [{
                        'targets': [3],
                        'width': 150,
                        'searchable': false,
                        'orderable': true,
                        'className': 'dt-header-center',
                        'render': function (data, type, full, meta){
                            return '<div style=" font-size: 20px; "  > <i class="fa fa-edit" style=" cursor: pointer;margin-right: 10px;" data-toggle="modal" data-target="#EditBusiness" data-id="'+full[3]+'" id="edit"></i> </div>';

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
                        "visible": false,
                        "searchable": false

                    }
                ]

    });


    $("#AddBusiness").on('show.bs.modal',function(){
        clearData("#AddBusiness");
    });
    $("#AddBusiness #addBtn").on('click',function(){
        saveData("#AddBusiness")
    });

    $("#EditBusiness").on('show.bs.modal',function(e){
        var id =$(e.relatedTarget).data('id');
        loadData(id);
    });
    $("#EditBusiness #addBtn").on('click',function(){
        saveData("#EditBusiness")
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
    formData.append('business_group_id',id);
    formData.append('action','load');
    jQuery.ajax({
        type: "POST",
        cache: false,
        contentType: false,
        processData: false,
        dataType:'text',
        data:formData,
        url: "../handler/businessGroupHandler.php",
        dataType: "html",
        async: true,
        success: function(data) {
            var dataJ =JSON.parse(data);
            jQuery("#EditBusiness #business_group_id").val(dataJ.business_group_id);
            jQuery("#EditBusiness #business_group_name").val(dataJ.business_group_name);
            jQuery("#EditBusiness #status option[value='"+dataJ.status+"']").prop("selected",true)
        }
      });
}

function saveData(mode){
    var business_group_id = jQuery(mode+" #business_group_id").val();
    var business_group_name = jQuery(mode+" #business_group_name").val();
    var status = jQuery(mode+" #status option:selected").val();

    var action ="";

    if(business_group_name==""){
        alert("โปรดระบุชื่อธุรกิจกลุ่ม");
        return false;
    }
    if(mode=="#AddBusiness"){
        action ="add";
    }else{
        action ="update";
    }
    var formData= new FormData();
    formData.append('business_group_id',business_group_id);
    formData.append('business_group_name',business_group_name);
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
        url: "../handler/businessGroupHandler.php",
        dataType: "html",
        async: true,
        success: function(data) {
         jQuery(mode).modal('toggle');
            Table.ajax.reload();
        }
      });





}
