
var Table;
(function ($) {
    var sub_group_id =$("#sub_group_id").val();
    loadGroupName(sub_group_id);
    $("#home").on('click',function(){
        window.location.href ="personGroupManagement.php";
    });
    Table = $('#main #PersonTable').DataTable({
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
        dom: '<"top">r<tl><"bottom"ip><"clear">',
        pageLength: 10,
        processing: true,
        responsive: true,
        serverSide: true,
        ajax: {url:"../server_side/PersonGroupSS.php?idArea="+$("#idArea").val()+"&sub_group_id="+sub_group_id,"type": "GET"},
        order: [[ 2, "desc" ]],
        columnDefs: [{
            'targets': [5],
            'width': 150,
            'searchable': false,
            'orderable': true,
            'className': 'dt-header-center',
            'render': function (data, type, full, meta){
                var tagName ="status_"+full[5];
                var status =full[4];
                if(status=='Y'){
                    return '<div style=" font-size:14px; "><label class="switch"><input type="checkbox" checked><div class="slider round '+tagName+'"  data-id="'+full[5]+'"></div></label> </div>';
                }else{
                    return '<div style=" font-size:14px; "><label class="switch"><input type="checkbox"><div class="slider round '+tagName+'"  data-id="'+full[5]+'"></div></label> </div>';
                }

            }
        },
        {
            'targets': [6],
            'width': 50,
            'searchable': false,
            'orderable': false,
            'className': 'dt-header-center',
            'render': function (data, type, full, meta){
                    return '<div><a href="/view-test/Agriculturaladd.php?idPerson='+full[6]+'"><i class="fa fa-eye" style=" cursor: pointer;margin-right: 10px;"></i> </a> </div>';
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
            "targets": [4],
            "visible": false,
            "searchable": false

        }
    ]

});


$('#PersonTable tbody').on( 'click', '.slider', function (e) {
    if (confirm(' ยืนยันการเปลี่ยนสถานะ')) {
        var person_id =$(this).data('id');
        if(jQuery('.status_'+person_id).closest('.switch').find("[type='checkbox']").is(':checked')){
            deleteMapping(person_id);
            jQuery('.status_'+person_id).closest('.switch').find("[type='checkbox']").removeAttr('checked').trigger('change');
        }else{
            saveMapping(person_id);
            $('.status_'+person_id).closest('.switch').find("[type='checkbox']").attr('checked','checked').trigger('change');
        }
      } else {
        return false;
      }
});

    $("#criteria").on('click',"#search_person",function(){
        search();
    });

    $("#criteria").on('click',"#clear_person",function(){

        $("#criteria #person_group_name").val('');
        $("#criteria #status").val('N');
        search();
    });
    function search(){
        Table.destroy();
        var name = $("#criteria #person_group_name").val();
        var isGroup = $("#criteria #status").val();
        var idArea = $("#idArea").val();
        var sub_group_id =$("#sub_group_id").val();

        var queryStr ="?1=1";
            if(idArea!=null){
                queryStr +="&idArea="+idArea;
            }
            if(name!=null){
                queryStr +="&name="+name;
            }
            if(isGroup!=null){
                queryStr +="&isGroup="+isGroup;
            }
            if(sub_group_id!=null){
                queryStr +="&sub_group_id="+sub_group_id;
            }


        Table = $('#main #PersonTable').DataTable({
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
            dom: '<"top">r<tl><"bottom"ip><"clear">',
            pageLength: 10,
            processing: true,
            responsive: true,
            serverSide: true,
            ajax: {url:"../server_side/PersonGroupSS.php"+queryStr,"type": "GET"},
            order: [[ 2, "desc" ]],
            columnDefs: [{
                'targets': [4],
                'width': 150,
                'searchable': false,
                'orderable': true,
                'className': 'dt-header-center',
                'render': function (data, type, full, meta){
                    var tagName ="status_"+full[4];
                    var status =full[3];
                    if(status=='Y'){
                        return '<div style=" font-size:14px; "><label class="switch"><input type="checkbox" checked><div class="slider round '+tagName+'"  data-id="'+full[4]+'"></div></label> </div>';
                    }else{
                        return '<div style=" font-size:14px; "><label class="switch"><input type="checkbox"><div class="slider round '+tagName+'"  data-id="'+full[4]+'"></div></label> </div>';
                    }

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
                "targets": [3],
                "visible": false,
                "searchable": false

            }
        ]

    });

    }


    function saveMapping(id){
            var institute_id =$("#institute_id").val();
            var sub_group_id =$("#sub_group_id").val();
            var formData= new FormData();
            formData.append('institute_id',institute_id);
            formData.append('sub_group_id',sub_group_id);
            formData.append('person_id',id);

            formData.append('action',"add");

            $.ajax({
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                dataType:'text',
                data:formData,
                url: "../handler/personGroupHandler.php",
                dataType: "html",
                async: false,
                success: function(data) {
                    Table.ajax.reload();
                }
                });

    }

    function deleteMapping(id){
        var institute_id =$("#institute_id").val();
        var sub_group_id =$("#sub_group_id").val();
        var formData= new FormData();
        formData.append('institute_id',institute_id);
        formData.append('sub_group_id',sub_group_id);
        formData.append('person_id',id);

        formData.append('action',"delete");

        $.ajax({
            type: "POST",
            cache: false,
            contentType: false,
            processData: false,
            dataType:'text',
            data:formData,
            url: "../handler/personGroupHandler.php",
            dataType: "html",
            async: false,
            success: function(data) {
                Table.ajax.reload();

            }
            });

}

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
                success:function(data){
                    areaName = JSON.parse(data)[0].areaName;
                    $("#sub_group_name").text(areaName+" : "+sub_group.sub_group_name);

                    $("#sub_group_name_2").text(areaName+" : "+sub_group.sub_group_name);
                }});
        }


      });
   }


})(jQuery);
