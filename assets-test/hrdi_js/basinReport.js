(function ($) {
    var spinner = $('#loader');
    var Table= $('#basinTable').DataTable( {
        "processing": true,
        "responsive": true,
        "serverSide": true,
        "ajax": "../server_side/findBasinReport.php",
        "autoWidth": false,
        'fixedColumns':   {
          'heightMatch': 'none'
        },
        'columnDefs': [{
            "targets": [0],
            "visible": false
        },{
          'targets': [2],
          'searchable': true,
          'orderable': false,
          'className': 'dt-header-center',
          'render': function (data, type, row){
              data = '<a href="./reportPersonIncome.php?area_Id='+row[0]+'">'+data+'</a>'
              return data;
          }
        }
        ],
          'order': [[1, 'desc']]
    } );

    $("#idRiverBasin").change(function(){
      var idRiverBasin = $(this).val();
      spinner.show();
      console.log(idRiverBasin);
      Table.destroy();
      Table = $('#basinTable').DataTable( {
          "processing": true,
          "responsive": true,
          "serverSide": true,
          "ajax": "../server_side/findBasinReport.php?idRiverBasin="+idRiverBasin,
          "type": "GET",
          "autoWidth": false,
          'fixedColumns':   {
            'heightMatch': 'none'
          },
          'columnDefs': [{
            "targets": [0],
            "visible": false
        },{
          'targets': [2],
          'searchable': true,
          'orderable': false,
          'className': 'dt-header-center',
          'render': function (data, type, row){
              data = '<a href="./reportPersonIncome.php?area_Id='+row[0]+'">'+data+'</a>'
              return data;
          }
        }
        ],
          'order': [[1, 'desc']]
      });
      spinner.hide();
   });

})(jQuery);

