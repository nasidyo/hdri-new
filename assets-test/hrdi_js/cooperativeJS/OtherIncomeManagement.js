var incomeTmp =[];
var Table;
(function ($) {

    $('#criteria #idRiverBasin').change(function(){
        var idRiverBasin = $(this).val();
         $.ajax({
             url:"../util/AreaDependentWithRole.php",
             method:"POST",
             data:{idRiverBasin:idRiverBasin,"idArea":$("#AreaAll").val()},
             dataType:"text",
             success:function(data){
                 $('#criteria #idArea').html(data);
             },complete:function(){
                $('#criteria #idArea').trigger('change');
             }
        	 });
         });

         $("#criteria #idArea").change(function(){
            $("#criteria #institute_id").html('');
            $.ajax({
               url: "../util/InstituteDependent.php?idArea="+$(this).val(),
               type: "GET",
               dataType: "html",
               async: true,
               success:function(data){

                 $("#criteria #institute_id").append(data);


               },complete:function(){
                $("#criteria #institute_id").trigger('change');
                $("#criteria #search_other").trigger('click');
               }
           });

          })


   /*       var queryStr="?1=1";
          var idRiverBasin = $("#criteria #idRiverBasin option:selected").val();
          var idArea =$("#criteria #idArea option:selected").val();
          var institute_id =$("#criteria #institute_id option:selected").val();
          var status = $("#criteria #perduct option:selected").val();
          var income_detail = $("#criteria #income_detail").val();
          if(idRiverBasin!=null){
              queryStr+="&idRiverBasin="+idRiverBasin;
          }
          if(idArea!=null){
              queryStr+="&idArea="+idArea;
          }
          if(institute_id!=null){
              queryStr+="&institute_id="+institute_id;
          }else{
            queryStr+="&institute_id=0";
         }
          if(status!=null){
              queryStr+="&status="+status;
          }
          if(income_detail!=null){
              queryStr+="&income_detail="+income_detail;
          }
    Table = $('#main #OtherIncomeTable').DataTable({
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        dom: '<"top">r<tl><"bottom"ip><"clear">',
        pageLength: 10,
        processing: true,
        responsive: true,
        serverSide: true,
        async: true,
        ajax: {url:"../server_side/OtherIncomeSS.php"+queryStr,"type": "GET"},
        order: [[ 0, "desc" ]],
        columnDefs: [{
                        'targets': [3],
                        'width': 40,
                        'searchable': false,
                        'orderable': false,
                        'className': 'dt-header-center',
                        'render': function (data, type, full, meta){
                            return '<div style=" font-size: 20px; "  ><i class="fa fa-edit" style=" cursor: pointer;margin-right: 10px;" data-toggle="modal" data-target="#editIncomeOther" data-id="'+data+'" id="editIncomeOther"></i> </div>';
                        }
                    },
                    {
                        "targets": [0],
                        "visible": true,
                        "searchable": false
                    }

                ]
    });*/

    $('#criteria #idRiverBasin').trigger('change');
    $("#criteria #search_other").on('click',function(){
        if(Table!= undefined){
            Table.destroy();
        }

        var queryStr="?1=1";
        var idRiverBasin = $("#criteria #idRiverBasin option:selected").val();
        var idArea =$("#criteria #idArea option:selected").val();
        var institute_id =$("#criteria #institute_id option:selected").val();
        var status = $("#criteria #perduct option:selected").val();
        var income_detail = $("#criteria #income_detail").val();
        if(idRiverBasin!=null){
            queryStr+="&idRiverBasin="+idRiverBasin;
        }
        if(idArea!=null){
            queryStr+="&idArea="+idArea;
        }
        if(institute_id!=null){
            queryStr+="&institute_id="+institute_id;
        }
        if(status!=null){
            queryStr+="&status="+status;
        }
        if(income_detail!=null){
            queryStr+="&income_detail="+income_detail;
        }
        Table = $('#main #OtherIncomeTable').DataTable({
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            dom: '<"top">r<tl><"bottom"ip><"clear">',
            pageLength: 10,
            processing: true,
            responsive: true,
            serverSide: true,
            ajax: {url:"../server_side/OtherIncomeSS.php"+queryStr,"type": "GET"},
            order: [[ 0, "desc" ]],
            columnDefs: [{
                            'targets': [3],
                            'width': 40,
                            'searchable': false,
                            'orderable': false,
                            'className': 'dt-header-center',
                            'render': function (data, type, full, meta){
                                return '<div style=" font-size: 20px; "  ><i class="fa fa-edit" style=" cursor: pointer;margin-right: 10px;" data-toggle="modal" data-target="#editIncomeOther" data-id="'+data+'" id="editIncomeOther"></i> </div>';
                            }
                        },
                        {
                            "targets": [0],
                            "visible": true,
                            "searchable": false
                        }

                    ]
        });
    });


})(jQuery);

