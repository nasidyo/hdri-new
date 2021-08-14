(function ($) {
    var area_Id = $('#area_Id').val();
    var yearsId = $('#yearsId').val();
    var permssion = $('#permssion').val();
    var Table= $('#yearsOfPlan-Table').DataTable( {
        "processing": true,
        "responsive": true,
        "serverSide": true,
        "ajax": "../server_side/planProductDetail.php?idArea="+area_Id+"&yearsId="+yearsId,
        "autoWidth": false,
        'fixedColumns':   {
          'heightMatch': 'none'
        },
        'columnDefs': [{
               "targets": [0,6],
                "visible": false
        },{
          "targets": [1],
            'width': 230,
        },{
            'targets': [7],
            'width': 130,
            'searchable': false,
            'orderable': false,
            'className': 'dt-header-center',
            'render': function (data, type, row){
                if (row[6] == "2" || row[6] == "4" || permssion == "manager"){
                  data = '<div style=" font-size: 20px; "><center><i class="fa fa-file-text-o" style=" cursor: pointer;margin-right: 10px; color: green;" data-toggle="tooltip" title="เพิ่มวางแผน" name="sendProductPlan" id="sendProductPlan"></i></center></div>';
                }else{
                  data = '<div style=" font-size: 20px; "><center>';
                  data+= '<i class="fa fa-edit" style=" cursor: pointer;margin-right: 10px; color: blue;" data-toggle="tooltip" title="เพิ่มเป้าหมาย" name="addPlanProduct" id="addPlanProduct"></i>';
                  data+= '<i class="fa fa-file-text-o" style=" cursor: pointer;margin-right: 10px; color: green;" data-toggle="tooltip" title="ภาพรวมเป้าหมาย" name="sendProductPlan" id="sendProductPlan"></i>';
                  data+= '</center></div>';
                }
                return data;
            }
          }
        ],
          'order': [[0, 'desc']]
    } );
    $('#yearsOfPlan-Table tbody').on('click', '#sendProductPlan', function () {
      var data = Table.row( $(this).parents('tr') ).data();
      window.location = "./planProductListOfYears.php?yearsId="+data[0]+"&area_Id="+area_Id+"&action="+data[6];
    } );

    $('#yearsOfPlan-Table tbody').on('click', '#addPlanProduct', function () {
      var data = Table.row( $(this).parents('tr') ).data();
      window.location = encodeURI("./addProductPlanOfYears.php?yearsId="+data[0]+"&area_Id="+area_Id+"&action="+data[6]);
    });
})(jQuery);