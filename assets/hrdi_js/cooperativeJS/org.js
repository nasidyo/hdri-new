
var Table;
var account_year_id;
var sub_group_id;
(function ($) {
    account_year_id =$("#account_year_id").val();
    sub_group_id =$("#sub_group_id").val();
     loadGroupName(account_year_id);
     $("#home").on('click',function(){
        window.location.href ="AccountYearManagement.php";
    });

    $.ajax({
        url:"../util/loadPersonFromSubGroup.php",
        method:"POST",
        data:{sub_group_id:sub_group_id},
        dataType:"text",
        success:function(data){
            $('#AddOrg #person_id').html(data);
        }
    });

     Table = $('#main #orgTable').DataTable({
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
        dom: '<"top">r<tl><"bottom"ip><"clear">',
        pageLength: 10,
        processing: true,
        responsive: true,
        serverSide: true,
        ajax: {url:"../server_side/orgSS.php?"+"account_year_id="+account_year_id+"&sub_group_id="+sub_group_id,"type": "GET"},
        order: [[ 2, "desc" ]],
        columnDefs: [{
                        'targets': [2],
                        'width': 50,
                        'searchable': false,
                        'orderable': true,
                        'className': 'dt-header-center',
                        'render': function (data, type, full, meta){
                            return '<div style=" font-size: 20px; "  > <i class="fa fa-edit" style=" cursor: pointer;margin-right: 10px;" data-toggle="modal" data-target="#EditOrg" data-id="'+full[2]+'" id="edit"></i> </div>';

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


    $("#AddOrg").on('show.bs.modal',function(){
        clearData("#AddOrg");
    });
    $("#AddOrg #addBtn").on('click',function(){
        saveData("#AddOrg")
    });

    $("#EditOrg").on('show.bs.modal',function(e){
        var id =$(e.relatedTarget).data('id');
        loadData(id);
    });
    $("#EditOrg #addBtn").on('click',function(){
        saveData("#EditOrg")
    });

    function loadGroupName(account_year_id){
                $.ajax({
                    url: "../util/loadNameByaccountYear.php?institetu_id="+account_year_id,
                    type: "GET",
                    dataType: "html",
                    async: true,
                    success:function(data_sub_name){
                      var  areaName = JSON.parse(data_sub_name)[0].areaName;
                      var INSTITUTE_NAME=JSON.parse(data_sub_name)[0].INSTITUTE_NAME;
                      var sub_group_name=JSON.parse(data_sub_name)[0].sub_group_name;
                      var year_text=JSON.parse(data_sub_name)[0].year_text;
                    var str ='โครงสร้างองค์กรพื้นที่'+areaName+' สถาบันเกษตรกร '+INSTITUTE_NAME+' กลุ่ม '+sub_group_name+' ประจำปี:'+year_text;
                        $("#sub_group_name").text(str);
                        $("#sub_group_name_2").text(str);
                    }});

       }




})(jQuery);


function clearData(mode){
    jQuery(mode+" input").val('');
    jQuery(mode+" #status option[value='Y']").prop("selected",true)
}
function loadData(id){
    var formData= new FormData();
    formData.append('org_map_id',id);
    formData.append('action','load');
    var person_id=0;
    jQuery.ajax({
        type: "POST",
        cache: false,
        contentType: false,
        processData: false,
        dataType:'text',
        data:formData,
        url: "../handler/orgHandler.php",
        dataType: "html",
        async: true,
        success: function(data) {
            var dataJ =JSON.parse(data);
            jQuery("#EditOrg #org_map_id").val(dataJ.org_map_id);
            jQuery("#EditOrg #org_id option[value='"+dataJ.org_id+"']").prop("selected",true)
            person_id = dataJ.person_id;
            jQuery.ajax({
                url:"../util/loadPersonFromSubGroup.php",
                method:"POST",
                data:{sub_group_id:sub_group_id},
                dataType:"text",
                success:function(data){
                    jQuery('#EditOrg #person_id').html(data);
                },complete:function(){
                    jQuery("#EditOrg #person_id option[value='"+person_id+"']").prop("selected",true);
                }
            });
        }
      });
}

function saveData(mode){


    var org_map_id = jQuery(mode+" #org_map_id").val();
    var org_id = jQuery(mode+" #org_id option:selected").val();
    var person_id = jQuery(mode+" #person_id option:selected").val();

    var action ="";

    if(org_id==""){
        alert("โปรดระบุตำแหน่ง");
        return false;
    }
    if(person_id==""){
        alert("โปรดระบุชื่อ");
        return false;
    }
    if(mode=="#AddOrg"){
        action ="add";
    }else{
        action ="update";
    }
    var formData= new FormData();
    formData.append('account_year_id',account_year_id);
    formData.append('org_map_id',org_map_id);
    formData.append('org_id',org_id);
    formData.append('person_id',person_id);
    formData.append('action',action);
    jQuery.ajax({
        type: "POST",
        cache: false,
        contentType: false,
        processData: false,
        dataType:'text',
        data:formData,
        url: "../handler/orgHandler.php",
        dataType: "html",
        async: true,
        success: function(data) {
         jQuery(mode).modal('toggle');
            Table.ajax.reload();
        }
      });





}
