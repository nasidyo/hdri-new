var incomeTmp =[];
var Table;
(function ($) {

    $("#main #idRiverBasin").select2();
    $("#main #idArea").select2();
    $("#main #institute_id").select2();
    $("#main #customer").select2();
    $("#main #product").select2();
    $("#main #customer_search").select2();
    $("#main #product_add").select2();


    Table = $('#main #subPersonGroupTable').DataTable({
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
        dom: '<"top">r<tl><"bottom"ip><"clear">',
        pageLength: 10,
        processing: true,
        responsive: true,
        serverSide: true,
        ajax: {url:"../server_side/subPersonGroupSS.php?idRiverBasin="+ $('#main #criteria #idRiverBasin option:selected').val()+"&idArea="+$('#main #criteria #idArea option:selected').val(),"type": "GET"},
        order: [[ 0, "desc" ]],
        columnDefs: [{
                        'targets': [5],
                        'width': 120,
                        'searchable': false,
                        'orderable': false,
                        'className': 'dt-header-center',
                        'render': function (data, type, full, meta){
                            var tagName ="PersonGroup_"+full[3];
                            var tagNamebusiness = "businessGroup_"+full[3];

                            return '<div style=" font-size: 20px; "  ><i class="fa fa-edit" style=" cursor: pointer;margin-right: 10px;" data-toggle="modal" data-target="#editPersonGroup" data-id="'+full[3]+'" id="editSubPersonGroup"></i><i class="fa fa-users" style=" cursor: pointer;margin-right: 10px; color:green;"  data-id="'+full[3]+'" id="'+tagName+'"></i><i class="fa fa-plus" style=" cursor: pointer;margin-right: 10px; color:blue;" data-id="'+full[3]+'"  id="'+tagNamebusiness+'")"></i></div>';
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
                    },
                    {
                        "targets": [3],
                        "visible": false,
                        "searchable": false
                    },
                    {
                        "targets": [4],
                        "visible": false,
                        "searchable": false
                    }
                ],
                "drawCallback": function( settings ) {

                    for(var i=0;i<settings.aoData.length;i++){
                        var tagName = "#PersonGroup_"+settings.aoData[i]._aData[3];
                        var tagNamebusiness = "#businessGroup_"+settings.aoData[i]._aData[3];


                        var idArea =settings.aoData[i]._aData[4];
                        var institute_id =settings.aoData[i]._aData[5];

                        $('#subPersonGroupTable tbody').on( 'click', tagName , function () {
                            var  id =$(this).data('id');
                            var url ='personGroupMapping.php?institute_id='+institute_id+'&idArea='+idArea+'&sub_group_id='+id+'';
                            window.location.href =url;
                         });
                         $('#subPersonGroupTable tbody').on( 'click',tagNamebusiness , function () {
                            var  id =$(this).data('id');
                            var url ='businessGroup.php?sub_group_id='+id;
                            window.location.href =url;
                         });



                    }


                }



    });



    $('#main #criteria #idRiverBasin').change(function(){
        var idRiverBasin = $(this).val();
         $.ajax({
             url:"../util/AreaDependentWithRole.php",
             method:"POST",
             data:{idRiverBasin:idRiverBasin,idArea:$("#AreaAll").val()},
             dataType:"text",
             success:function(data){
                 $('#main #criteria #idArea').html(data);
             }
         });
     });

     $('#main #criteria #idArea').change(function(){
        var idArea = $(this).val();
         $.ajax({
             url:"../util/personByArea.php",
             method:"POST",
             data:{idArea:idArea},
             dataType:"text",
             success:function(data){
                 $('#main #criteria #customer').html(data);
             }
         });
     });

     $('#main #criteria #institute_id').change(function(){
        var institute_id = $(this).val();
         $.ajax({
             url:"../util/loadOrderByIns.php",
             method:"POST",
             data:{institute_id:institute_id},
             dataType:"text",
             success:function(data){
                 $('#main #criteria #product').html(data);
             }
         });
     });

     $('#main #criteria #idRiverBasin').trigger('change');

     $('#subPersonGroupTable tbody').on( 'click', '#delSubPersonGroup', function () {
        var  id =$(this).data('id');
        delSubGroup(id);
     });

     $('#search_sub_group').on( 'click', function () {
        search();
     });



    $('#main .close').click(function(){
        $('#main #newsHeading').parent().slideUp();
      })
    function search(){
        Table.destroy();
        var id =$("#criteria #institute_id option:selected").val()==null?0:parseInt($("#criteria #institute_id option:selected").val());
        var idArea =$("#criteria #idArea option:selected").val()==null?0:parseInt($("#criteria #idArea option:selected").val());
        var idRiverBasin =$("#criteria #idRiverBasin option:selected").val()==null?0:parseInt($("#criteria #idRiverBasin option:selected").val());
        var queryStr ="?1=1";
        if(id>0){
            queryStr+="&id="+id;
        }
        if(idArea>0){
            queryStr+="&idArea="+idArea;
        }
        if(idRiverBasin>0){
            queryStr+="&idRiverBasin="+idRiverBasin;
        }
        Table = $('#main #subPersonGroupTable').DataTable({
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
            dom: '<"top">r<tl><"bottom"ip><"clear">',
            pageLength: 10,
            processing: true,
            responsive: true,
            serverSide: true,
            ajax: {url:"../server_side/subPersonGroupSS.php"+queryStr,"type": "GET"},
            order: [[ 0, "desc" ]],
            columnDefs: [{
                'targets': [5],
                'width': 120,
                'searchable': false,
                'orderable': false,
                'className': 'dt-header-center',
                'render': function (data, type, full, meta){
                    var tagName ="PersonGroup_"+full[3];
                    var tagNamebusiness = "businessGroup_"+full[3];

                    return '<div style=" font-size: 20px; "  ><i class="fa fa-edit" style=" cursor: pointer;margin-right: 10px;" data-toggle="modal" data-target="#editPersonGroup" data-id="'+full[3]+'" id="editSubPersonGroup"></i><i class="fa fa-users" style=" cursor: pointer;margin-right: 10px; color:green;"  data-id="'+full[3]+'" id="'+tagName+'"></i><i class="fa fa-plus" style=" cursor: pointer;margin-right: 10px; color:blue;" data-id="'+full[3]+'"  id="'+tagNamebusiness+'")"></i></div>';
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
            },
            {
                "targets": [3],
                "visible": false,
                "searchable": false
            },
            {
                "targets": [4],
                "visible": false,
                "searchable": false
            }
        ],
        "drawCallback": function( settings ) {

            for(var i=0;i<settings.aoData.length;i++){
                var tagName = "#PersonGroup_"+settings.aoData[i]._aData[3];
                var tagNamebusiness = "#businessGroup_"+settings.aoData[i]._aData[3];


                var idArea =settings.aoData[i]._aData[4];
                var institute_id =settings.aoData[i]._aData[5];

                $('#subPersonGroupTable tbody').on( 'click', tagName , function () {
                    var  id =$(this).data('id');
                    var url ='personGroupMapping.php?institute_id='+institute_id+'&idArea='+idArea+'&sub_group_id='+id+'';
                    window.location.href =url;
                 });
                 $('#subPersonGroupTable tbody').on( 'click',tagNamebusiness , function () {
                    var  id =$(this).data('id');
                    var url ='businessGroup.php?sub_group_id='+id;
                    window.location.href =url;
                 });

            }


        }



});



    }



})(jQuery);

function delSubGroup(id){

    if (!confirm(" ต้องการลบข้อมูล ")){
       return false;
     }

    var formData= new FormData();
    formData.append('sub_group_id',id);
    formData.append('action',"delete");

    jQuery.ajax({
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
            Table.ajax.reload();
        }
      });

}



function clearInput(){
   jQuery("#main #product_div #amount").val('');
   jQuery("#main #product_div #price").val('');
   jQuery("#main #product_add").select2('val',"0");
   jQuery("#main #discount").val('');
   jQuery("#main #debt").val('');


}

function dateToDB(date){
    var d ;
    var oldDate =[];
    if(date != ""){
        oldDate = date.split('-');
        d = new Date(oldDate[2],oldDate[1],oldDate[0]);
    }
    return d.getFullYear()+'-'+d.getMonth()+'-'+d.getDate();
}

function dateToFilter(date){
    if(date==""){
        return "";
    }
    var d ;
    var oldDate =[];
    if(date != ""){
        oldDate = date.split('-');
        d = new Date(oldDate[2],oldDate[1],oldDate[0]);
    }
    return d.getDate()+'/'+d.getMonth()+'/'+d.getFullYear();
}
function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}
