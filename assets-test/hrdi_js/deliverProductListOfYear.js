(function ($) {
    var area_Id = $('#area_Id').val();
    var permssion = $('#permssion').val();
    var years_Id = $('#years_Id').val();
    var Table = $('#deliverProductOfyear-Table').DataTable({
        "language": {
          "emptyTable": "ยังไม่ได้กรอกข้อมูลแผนหรือแผนยังไม่ได้รับการอนุมัติ"
        },
        "pageLength": 20,
        "processing": true,
        "responsive": true,
        "serverSide": true,
        "ajax": "../server_side/deliverProductListOfYear.php?area_Id="+area_Id+"&yearsId="+years_Id,
        "autoWidth": false,
        'fixedColumns':   {
          'heightMatch': 'none'
        },
        'columnDefs': [{
          "targets": [0,1,7],
          "visible": false
        },{
          'targets': [8],
          'width': 50,
          'searchable': false,
          'orderable': false,
          'className': 'dt-header-center',
          'render': function (data, type, row){
            if(permssion == "staff" || permssion == "admin"){
              if(row[7] == 2 || row[7] == 4){
                return '<div style=" font-size: 20px; "><center><i class="fa fa-eye" style=" cursor: pointer;margin-right: 10px; color: blue;" data-toggle="tooltip" title="ส่งมอบผลผลิต" name="deliverProductOfMonth" id="deliverProductOfMonth"></i></center></div>';
              }else{
                return '<div style=" font-size: 20px; "><center><i class="fa fa-edit" style=" cursor: pointer;margin-right: 10px; color: blue;" data-toggle="tooltip" title="ส่งมอบผลผลิต" name="deliverProductOfMonth" id="deliverProductOfMonth"></i></center></div>';
              }
            }else{
                return '<div style=" font-size: 20px; "><center><i class="fa fa-eye" style=" cursor: pointer;margin-right: 10px; color: blue;" data-toggle="tooltip" title="ส่งมอบผลผลิต" name="deliverProductOfMonth" id="deliverProductOfMonth"></i></center></div>';
            }
          }
        }],
    } );
    $("#yearsOfPlan").change(function(){
        years_Id = $(this).val();
        Table.destroy();
        Table = $('#deliverProductOfyear-Table').DataTable( {
            "language": {
              "emptyTable": "ยังไม่ได้กรอกข้อมูลแผนหรือแผนยังไม่ได้รับการอนุมัติ"
            },
            "pageLength": 20,
            "processing": true,
            "responsive": true,
            "serverSide": true,
            "ajax": "../server_side/deliverProductListOfYear.php?area_Id="+area_Id+"&yearsId="+years_Id,
            "autoWidth": false,
            'fixedColumns':   {
              'heightMatch': 'none'
            },
            'columnDefs': [{
              "targets": [0,1,7],
              "visible": false
            },{
              'targets': [8],
              'width': 50,
              'searchable': false,
              'orderable': false,
              'className': 'dt-header-center',
              'render': function (data, type, row){
                if(permssion == "staff" || permssion == "admin"){
                  if(row[7] == 2 || row[7] == 4){
                    return '<div style=" font-size: 20px; "><center><i class="fa fa-eye" style=" cursor: pointer;margin-right: 10px; color: blue;" data-toggle="tooltip" title="ส่งมอบผลผลิต" name="deliverProductOfMonth" id="deliverProductOfMonth"></i></center></div>';
                  }else{
                    return '<div style=" font-size: 20px; "><center><i class="fa fa-edit" style=" cursor: pointer;margin-right: 10px; color: blue;" data-toggle="tooltip" title="ส่งมอบผลผลิต" name="deliverProductOfMonth" id="deliverProductOfMonth"></i></center></div>';
                  }
                }else{
                    return '<div style=" font-size: 20px; "><center><i class="fa fa-eye" style=" cursor: pointer;margin-right: 10px; color: blue;" data-toggle="tooltip" title="ส่งมอบผลผลิต" name="deliverProductOfMonth" id="deliverProductOfMonth"></i></center></div>';
                }
              }
            }],
        });
    });
    $('#deliverProductOfyear-Table tbody').on('click', '#deliverProductOfMonth', function () {
      var data = Table.row( $(this).parents('tr') ).data();
      area_Id = $('#area_Id').val();
      years_Id = $('#years_Id').val();
      window.location = "./deliverProductList.php?yearsId="+years_Id+"&monthId="+data[1]+"&area_Id="+area_Id;
  } );
})(jQuery);