(function ($) {
    var spinner = $('#loader');
    var permssion = $('#permssion').val();
    var Table = $('#basinTable').DataTable();
    var idRiverBasin = '';
    var idStatus = '';
    initTable();
    function initTable(){
        idRiverBasin = $('#idRiverBasin option:selected').val();
        idStatus = $('#idStatus option:selected').val();
        yearsId = $('#yearsOfPlan option:selected').val();
        spinner.show();
        Table.destroy();
        Table = $('#basinTable').DataTable( {
            'iDisplayLength': 100,
            "processing": true,
            "responsive": true,
            "serverSide": true,
            "ajax": "../server_side/findBasin.php?idRiverBasin="+idRiverBasin+"&idStatus="+idStatus+"&yearsId="+yearsId,
            "type": "GET",
            "autoWidth": false,
            'fixedColumns':   {
              'heightMatch': 'none'
            },
            'columnDefs': [{
              "targets": [0,4],
              "visible": false
              },{
                'targets': [5],
                'width': 100,
                'searchable': false,
                'orderable': false,
                'className': 'dt-header-center',
                'render': function (data, type, row){
                    data = '<div style=" font-size: 20px; ">'
                    if(permssion == 'staff'|| permssion == 'admin' || permssion == 'manager' || permssion == 'powerUserMarket'){
                      if (row[4] == 1 || row[4] == 3){
                        data = data+'<center><i class="fa fa-list-alt" id="sendPlanOfyears" style=" color: blue;" data-toggle="tooltip" title="เป้าหมายรายได้และผลผลิต"></i></center>'
                        //data = data+'<center><i class="fa fa-calendar" id="sendPlanOfyears" style=" pointer;margin-right: 10px; color: blue;" data-toggle="tooltip" title="เป้าหมายรายได้และผลผลิต"></i>'
                      }else if (row[4] == 2){
                            data = data+'<center><i class="fa fa-eye" id="sendPlanOfyears" style=" pointer;margin-right: 10px; color: blue;" data-toggle="tooltip" title="เป้าหมายรายได้และผลผลิต"></i>'
                      }else if (row[4] == 4){
                          data = data+'<center><i class="fa fa-eye" id="sendPlanOfyears" style=" cursor: pointer;margin-right: 10px; color: blue;" data-toggle="tooltip" title="เป้าหมายรายได้และผลผลิต"></i>'
                          +'<i class="fa fa-calendar" style="cursor: pointer;margin-right: 10px; color: green;" data-toggle="tooltip" title="ประมาณการผลผลิต" id="estimateProduct" name="estimateProduct"></i>'
                          +'<i class="fa fa-truck" style="cursor: pointer; color: red;" data-toggle="tooltip" title="ส่งมอบผลผลิต" id="deliverProducts" name="deliverProducts"></i></div></center>';
                      }
                      // data = data +'<i class="fa fa-edit" style="cursor: pointer;margin-right: 10px; color: green;" data-toggle="tooltip" title="ประมาณการผลผลิต" id="estimateProduct" name="estimateProduct"></i>'
                      //   +'<i class="fa fa-truck" style="cursor: pointer; color: red;" data-toggle="tooltip" title="ส่งมอบผลผลิต" id="deliverProducts" name="deliverProducts"></i></div></center>';
                      // data = data+'</div>';


                    // }else if (permssion == 'powerUserMarket') {
                    //   data = data +'<center>'
                    //       +'<i class="fa fa-eye" id="sendPlanOfyears" style=" cursor: pointer;margin-right: 10px; color: blue;" data-toggle="tooltip" title="เป้าหมายรายได้และผลผลิต"></i>'
                    //     if(row[4] == 4){
                    //       data = data+'<i class="fa fa-calendar" style="cursor: pointer;margin-right: 10px; color: green;" data-toggle="tooltip" title="ประมาณการผลผลิต" id="estimateProduct" name="estimateProduct"></i>'
                    //       +'<i class="fa fa-truck" style="cursor: pointer; color: red;" data-toggle="tooltip" title="ส่งมอบผลผลิต" id="deliverProducts" name="deliverProducts"></i>'
                    //     }
                    //   +'</div></center>';
                    }
                    return data
                }
              }
            ],
              'order': [[1, 'desc']]
        });
        spinner.hide();
    };
  
    $("#idRiverBasin").change(function(){
        initTable();
    });
    $("#idStatus").change(function(){
        initTable();
    });
    $("#yearsOfPlan").change(function(){
      initTable();
  });
  $('#basinTable tbody').on('click', '#sendPlanOfyears', function () {
    var data = Table.row( $(this).parents('tr') ).data();
    var area_Id = data[0];
      $.ajax({
        url: "../handler/targetPlanHandler.php?area_Id="+area_Id,
        type: "POST",
        dataType: "html",
        async: false,
        data:{'area_Id':area_Id,'action':'checkplan'},
        success:function(data){
          window.location = "./yearsListOfPlan.php?area_Id="+area_Id+"&yearsId="+yearsId;
        }
    });
  });
  $('#basinTable tbody').on('click', '#estimateProduct', function () {
    var data = Table.row( $(this).parents('tr') ).data();
    window.location = "./estimateProductLists.php?area_Id="+data[0]+"&yearsId="+yearsId;
  });
  $('#basinTable tbody').on('click', '#deliverProducts', function () {
    spinner.show();
    var data = Table.row( $(this).parents('tr') ).data();
    var area_Id = data[0];
      $.ajax({
        url:"../handler/targetPlanHandler.php",
        method:"POST",
        data:{area_Id:data[0], action:"pastUpdateFunction"},
        dataType:"text",
        success:function(data){
            window.location = "./deliverProductListOfYear.php?area_Id="+area_Id+"&yearsId="+yearsId;
        }
    });
    // window.location = "./deliverProductListOfYear.php?area_Id="+data[0];
  });

})(jQuery);

