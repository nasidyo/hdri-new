var Table;
(function ($) {

        Table = $('#orderTable').DataTable({
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
        dom: '<"top">r<tl><"bottom"ip><"clear">',
        pageLength: 10,
        processing: true,
        responsive: true,
        serverSide: true,
        ajax: {url:"../server_side/orderSS.php?idRiverBasin="+$("#idRiverBasin").val()+"&idArea="+$("#idArea").val(),"type": "GET"},
        order: [[ 0, "desc" ]],
        columnDefs: [{
                        'targets': [5],
                        'width': 70,
                        'searchable': false,
                        'orderable': false,
                        'className': 'dt-header-center',
                        'render': function (data, type, full, meta){
                            return '<div style=" font-size: 20px; "  ><i class="fa fa-edit" style=" cursor: pointer;margin-right: 10px;" data-toggle="modal" data-target="#editProduct" data-id="'+full[5]+'" id="edit"></i>     <!--   <i class="fa fa-times" style="cursor: pointer;color: red;" id="delproductBtn"><input type="hidden" value="'+full[5]+'"></i> --></div>';
                        }
                    }

                ]
    });
    $('#criteria #idRiverBasin').change(function(){
        var idRiverBasin = $(this).val();
         $.ajax({
             url:"../util/AreaDependentWithRole.php",
             method:"POST",
             data:{idRiverBasin:idRiverBasin ,idArea:$("#AreaAll").val()},
             dataType:"text",
             success:function(data){
                 $('#criteria #idArea').html(data);
             },complete:function(){
                $('#criteria #idArea').trigger('change');
             }
         });
     });

     $('#criteria #idRiverBasin').trigger('change');

     $('#criteria #idArea').change(function(){
        var idArea = $(this).val();
         $.ajax({
             url:"../util/InstituteDependent.php",
             method:"GET",
             data:{idArea:idArea},
             dataType:"text",
             success:function(data){
                 $('#criteria #institute_id').html(data);
             },complete:function(){
                $('#criteria #institute_id').trigger('change');
             }
         });
     });

        $('#criteria #institute_id').change(function(){
        var institute_id = $(this).val();
         $.ajax({
             url:"../util/loadOrderByInsAll.php",
             method:"POST",
             data:{institute_id:institute_id},
             dataType:"text",
             success:function(data){
                 $('#criteria #product').html(data);
             }
         });
     });
     $('#criteria #institute_id').change(function(){
        var institute_id = $(this).val();
         $.ajax({
             url:"../util/loadSubGroupbyIns.php",
             method:"POST",
             data:{institute_id:institute_id},
             dataType:"text",
             success:function(data){
                 $('#criteria #sub_group_id').html(data);
             },complete:function(){
                $('#criteria #search_order').trigger('click');
             }
         });
     });




      $('#criteria #search_order').on('click',function(){
             Table.destroy();
      var idRiverBasin =      $("#criteria #idRiverBasin").val();
      var idArea =    $("#criteria #idArea").val();
      var institute_id =     $("#criteria #institute_id").val();
      var  product  =    $("#criteria #product").val();
      var  filter =    $("#criteria #filter").val();
      var  params =    parseInt($("#criteria #params").val()==""?"0":$("#criteria #params").val())
      var  status =    $("#criteria #status").val()
      var sub_group_id = $("#criteria #sub_group_id").val();
      var queryStr ="?idRiverBasin="+idRiverBasin+"&idArea="+idArea+"&institute_id="+institute_id;
        queryStr+="&order_id="+product;
        queryStr+="&filter="+filter+"&params="+params+"&status="+status+"&sub_group_id="+sub_group_id;

        Table = $('#orderTable').DataTable({
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
        dom: '<"top">r<tl><"bottom"ip><"clear">',
        pageLength: 10,
        processing: true,
        responsive: true,
        serverSide: true,
        ajax: {url:"../server_side/orderSS.php"+queryStr,"type": "GET"},
        order: [[ 0, "desc" ]],
        columnDefs: [{
                        'targets': [5],
                        'width': 70,
                        'searchable': false,
                        'orderable': false,
                        'className': 'dt-header-center',
                        'render': function (data, type, full, meta){
                            return '<div style=" font-size: 20px; "  ><i class="fa fa-edit" style=" cursor: pointer;margin-right: 10px;" data-toggle="modal" data-target="#editProduct" data-id="'+full[5]+'" id="edit"></i>     <!--   <i class="fa fa-times" style="cursor: pointer;color: red;" id="delproductBtn"><input type="hidden" value="'+full[5]+'"></i> --></div>';
                        }
                    }

                ]
    });



     });


    $('#orderTable tbody').on( 'click', '#delproductBtn', function () {
        var name =$(this).closest("tr").find('td:eq(0)').text();
        var order_id =$(this).closest("tr").find('td:eq(5)').find('input').val();
        if (!confirm("ต้องการลบข้อมูล :"+name)){
           return false;
         }
        $.ajax({
           url: "../handler/orderHandler.php?order_id="+order_id,
           type: "POST",
           dataType: "html",
           async: false,
           data:{'order_id':order_id,'action':'delete'},
           success:function(data){
              Table.ajax.reload().draw();
              $('input:checkbox').removeAttr('checked');
           }
       });
    } );



})(jQuery);
