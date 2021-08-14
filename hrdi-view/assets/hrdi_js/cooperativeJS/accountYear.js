var Table;
(function ($) {

    $('#criteria #idRiverBasin').change(function(){
        var idRiverBasin = $(this).val();
         $.ajax({
             url:"../util/AreaDependentWithRole.php",
             method:"POST",
             data:{idRiverBasin:idRiverBasin,idArea:$("#AreaAll").val()},
             dataType:"text",
             success:function(data){
                 $('#criteria #idArea').html(data);
             },complete:function(){
                $('#criteria #idArea').trigger("change");
             }
         });
     });



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
             url:"../util/loadSubGroupbyIns.php",
             method:"POST",
             data:{institute_id:institute_id},
             dataType:"text",
             success:function(data){
                 $('#criteria #sub_group_id').html(data);
             }
         });
     });

     $('#criteria #idRiverBasin').trigger('change');

/*
     var idRiverBasin =      $("#criteria #idRiverBasin").val();
     var idArea =    $("#criteria #idArea").val();
     var institute_id =     $("#criteria #institute_id").val();
     var  sub_group_id  =    $("#criteria #sub_group_id").val();
     var queryStr ="?idRiverBasin="+idRiverBasin+"&idArea="+idArea+"&institute_id="+institute_id;
       queryStr+="&sub_group_id="+sub_group_id;


    Table = $('#AccountYearTable').DataTable({
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
        dom: '<"top">r<tl><"bottom"ip><"clear">',
        pageLength: 10,
        processing: true,
        responsive: true,
        serverSide: true,
        ajax: {url:"../server_side/AccountYearSS.php"+queryStr,"type": "GET"},
        order: [[ 0, "desc" ]],
        columnDefs: [{
                        'targets': [7],
                        'width': 70,
                        'searchable': false,
                        'orderable': false,
                        'className': 'dt-header-center',
                        'render': function (data, type, full, meta){
                            return '<div style=" font-size: 20px; "  ><i class="fa fa-edit" style=" cursor: pointer;margin-right: 10px; color:blue;" data-toggle="modal" data-target="#EditAccountYear" data-id="'+full[7]+'" id="edit"></i><a href="/view/organizationManagement.php?account_year_id='+full[7]+'&sub_group_id='+full[8]+'"><i class="fa fa-sitemap" style=" cursor: pointer;margin-right: 10px;color:green"></i></a></div>';
                        }
                    } ,{
                        "targets": [8],
                        "visible": false,
                        "searchable": false
                    }

                ]
    });*/


    $("#criteria #search_person").on('click',function(){
        search();
    })

    $("#criteria #search_person").trigger('click');
    function search(){
        if(Table!=undefined){
            Table.destroy();
        }

        var idRiverBasin =      $("#criteria #idRiverBasin").val();
        var idArea =    $("#criteria #idArea").val();
        var institute_id =     $("#criteria #institute_id").val();
        var  sub_group_id  =    $("#criteria #sub_group_id").val();
        var queryStr ="?idRiverBasin="+idRiverBasin+"&idArea="+idArea+"&institute_id="+institute_id;
          queryStr+="&sub_group_id="+sub_group_id;
          Table = $('#AccountYearTable').DataTable({
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
            dom: '<"top">r<tl><"bottom"ip><"clear">',
            pageLength: 10,
            processing: true,
            responsive: true,
            serverSide: true,
            ajax: {url:"../server_side/AccountYearSS.php"+queryStr,"type": "GET"},
            order: [[ 0, "desc" ]],
            columnDefs: [{
                            'targets': [7],
                            'width': 70,
                            'searchable': false,
                            'orderable': false,
                            'className': 'dt-header-center',
                            'render': function (data, type, full, meta){
                                 return '<div style=" font-size: 20px; "  ><i class="fa fa-edit" style=" cursor: pointer;margin-right: 10px; color:blue;" data-toggle="modal" data-target="#EditAccountYear" data-id="'+full[7]+'" id="edit"></i><a href="/view/organizationManagement.php?account_year_id='+full[7]+'&sub_group_id='+full[8]+'"><i class="fa fa-sitemap" style=" cursor: pointer;margin-right: 10px;color:green"></i></a></div>';
                            }
                        }
                        ,{
                        "targets": [8],
                        "visible": false,
                        "searchable": false
                    }

                    ]
        });


    }






})(jQuery);
