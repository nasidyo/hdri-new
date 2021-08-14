(function ($) {
    var spinner = $('#loader');
    var ctxM = document.getElementById("barChartM");
    var ctxQ = document.getElementById("barChartQ");
    var years_Id = $('#yearsOfPlan option:selected').val();
    var myChartM;
    var myChartQ;
    var myTableM;
    var myTableQ;
    var typeOfAgri_id;
    var agriList;
    // var idRiverBasin;
    // var area_Id;
    var actionPage = 'Nofind';
    var listColorChart = getListColor();
    // select 2
    $('#idRiverBasin').select2();
    $('#areaId').select2();
    $('#typeOfAgri_id').select2();
    $('.agri-dropdown').select2();
    $('#typeOfGradeId').select2();

    initChartM();
    initTableM();
    initChartQ();
    initTableQ();
  
    $('#yearsOfPlan').change(function(){
      // var table = $('#dashTableM').DataTable();
      myTableQ.destroy();
      // var table2 = $('#dashTableQ').DataTable();
      myTableM.destroy();
      myChartM.destroy();
      myChartQ.destroy();
      initChartM();
      initTableM();
      initChartQ();
      initTableQ();
      $($.fn.dataTable.tables(true)).DataTable()
         .columns.adjust();
    });

    $('#idRiverBasin').change(function(){
      var idRiverBasin = $(this).val();
      loadArea(idRiverBasin);
    });
    $('#typeOfAgri_id').change(function(){
      var tpyeOfAgri_Id = $(this).val();
      var area_Id = $('#areaId option:selected').val();
      if(tpyeOfAgri_Id != '0'){
          $.ajax({
              url:"../util/loadAgriFromType.php",
              method:"POST",
              data:{typeOfAgriId:tpyeOfAgri_Id},
              dataType:"text",
              success:function(data){
                  $('#agriList').html(data);
              }
          });
      }
    });
    $('#agriList').change(function(){
        console.log($(this).val().length);
        if($(this).val().length == '1'){
          console.log($(this).val()[0]);
          var agri_Id = $(this).val()[0];
          loadSpeciesDW(agri_Id);
        }else{
          $('#speciesId').html('');
          $('#speciesId').html("<option value='ALL'>ทั้งหมด</option>");
        }
        $.ajax({
          url:"../util/loadAllProductGradeJs.php",
          dataType:"text",
          success:function(data){
              $('#typeOfGradeId').html(data);
          }
        });
    });

    function loadSpeciesDW(agri_Id){
        $.ajax({
            url:"../util/loadSpeciesDW.php",
            method:"POST",
            data:{argi_id:agri_Id},
            dataType:"text",
            success:function(data){
                var listdata = "<option value='ALL'>ทั้งหมด</option>"+data;
                $('#speciesId').html(listdata);
            }
        });
    }
    $('#typeOfGradeId').change(function(){
        $.ajax({
            url:"../util/loadProductStandardAllJs.php",
            dataType:"text",
            success:function(data){
                $('#typeofStandardId').html(data);
            }
        });
    });
    function initChartM(){
      var years_Id = $('#yearsOfPlan option:selected').val();
      var idRiverBasin = $('#idRiverBasin option:selected').val();
      var area_Id = $('#areaId option:selected').val();
      var typeofStandardId = $('#typeofStandardId option:selected').val();
      var typeOfGradeId = $('#typeOfGradeId option:selected').val();
      var speciesId = $('#speciesId option:selected').val();
      var riverBasin ;
      $.ajax({
          url:"../util/incomeReport.php",
          data: {years_Id:years_Id, actionPage:actionPage, idRiverBasin:idRiverBasin, area_Id:area_Id, typeOfAgri_id:typeOfAgri_id, agriList:agriList, typeofStandardId:typeofStandardId,typeOfGradeId:typeOfGradeId,speciesId:speciesId },
          method:"POST",
          dataType:"text",
          success:function(data){
              // console.log(data);
          riverBasin =JSON.parse(data);
          },complete:function(){
                var arr = Object.entries(riverBasin)
                console.log(arr);
                var options = {
                  type: 'line',
                  data: {
                      labels: ["ตุลาคม", "พฤศจิกายน", "ธันวาคม", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน"],
                      datasets: []
                  },
                  options: {
                    responsive: true,
                    title: {
                      display: true,
                      text: 'กราฟแสดงมูลค่าการส่งมอบผลผลิต'
                    },
                    tooltips: {
                      mode: 'index',
                      intersect: false,
                      callbacks: {
                          label: function(t, d) {
                            var xLabel = d.datasets[t.datasetIndex].label;
                            return xLabel + ': ' + toMoney(t.yLabel);
                          }
                      }
                    },
                    hover: {
                      mode: 'nearest',
                      intersect: true
                    },
                    scales: {
                      xAxes: [{
                        display: true,
                        scaleLabel: {
                          display: true,
                          labelString: 'เดือน'
                        }
                      }],
                      yAxes: [{
                        display: true,
                        scaleLabel: {
                          display: true,
                          labelString: 'มูลค่า'
                        },ticks: {
                          callback: function(value, index, values) {
                            return toMoney(value);
                          }
                        }
                      }]
                    }
                  }
                }
              myChartM = new Chart( ctxM, options);
              arr.forEach((v,index) => {
                //var color = getRandomColor();
                  setTimeout(() => {
                    myChartM.data.datasets.push({
                          data: v[1].dataset,
                          label: v[1].nameTypeOfArgi,
                          fill: false,
                          borderColor: listColorChart[index],
                          backgroundColor:listColorChart[index],
                          borderWidth: "2",
                      });
                      myChartM.update()
                  }, parseInt(v[0]))
              })
          }
      });
    }
    function initTableM() {
      var years_Id = $('#yearsOfPlan option:selected').val();
      var idRiverBasin = $('#idRiverBasin option:selected').val();
      var area_Id = $('#areaId option:selected').val();
      var typeofStandardId = $('#typeofStandardId option:selected').val();
      var typeOfGradeId = $('#typeOfGradeId option:selected').val();
      var speciesId = $('#speciesId option:selected').val();
      console.log(years_Id);
        $.ajax({
            url:"../util/incomeReportJson.php",
            data: {years_Id:years_Id, actionPage:actionPage, idRiverBasin:idRiverBasin, area_Id:area_Id, typeOfAgri_id:typeOfAgri_id, agriList:agriList, typeofStandardId:typeofStandardId,typeOfGradeId:typeOfGradeId, speciesId:speciesId },
            method:"POST",
            dataType:"text",
            success:function(data){
              riverBasin =JSON.parse(data);
            },complete: function(data){
              myTableM = $('#dashTableM').DataTable({
                'dom': "<'row'<'col-sm-6'Bl><'col-sm-5'f>>" +
                  "<'row'<'col-sm-11 scrolltable'tr>>" +
                  "<'row'<'bottombuttons col-sm-11'>><'row'<'col-sm-5'i><'col-sm-6'p>>",
                'buttons': [{
                  'extend': 'collection',
                  'className': 'exportButton',
                  'text': 'Data Export',
                  'buttons': [
                      { 'extend':'copy'},
                      { 'extend':'csv'},
                      { 'extend':'excel'},
                      { 'extend':'print'}
                    ]
                }],
              "scrollX": true,
              "sScrollX": "100%",
              "sScrollXInner": "110%",
              fixedHeader: true,
              "data" : riverBasin,
              "columns" : [
                  { "title" : "พืชสาขา", "data": ['nameTypeOfArgi'] ,"width": "15%"},
                  { "title" : "ต.ค.", "data": ['10'],
                  "render": function (data, type, row) {
                    $datavlue = toMoney(parseFloat(data.toFixed(2)));
                    return $datavlue;
                  },"width": "6%"},
                  { "title" : "พ.ย." , "data": ['11'],"render": function (data, type, row) {
                    $datavlue = toMoney(parseFloat(data.toFixed(2)));
                    return $datavlue;
                  },"width": "6%"},
                  { "title" : "ธ.ค." , "data": ['12'],"render": function (data, type, row) {
                    $datavlue = toMoney(parseFloat(data.toFixed(2)));
                    return $datavlue;
                  },"width": "6%"},
                  { "title" : "ม.ค." , "data": ['1'],"render": function (data, type, row) {
                    $datavlue = toMoney(parseFloat(data.toFixed(2)));
                    return $datavlue;
                  },"width": "6%"},
                  { "title" : "ก.พ." , "data": ['2'],"render": function (data, type, row) {
                    $datavlue = toMoney(parseFloat(data.toFixed(2)));
                    return $datavlue;
                  },"width": "6%"},
                  { "title" : "มี.ค." , "data": ['3'],"render": function (data, type, row) {
                    $datavlue = toMoney(parseFloat(data.toFixed(2)));
                    return $datavlue;
                  },"width": "6%"},
                  { "title" : "เม.ย.", "data": ['4'],"render": function (data, type, row) {
                    $datavlue = toMoney(parseFloat(data.toFixed(2)));
                    return $datavlue;
                  },"width": "6%"},
                  { "title" : "พ.ค." , "data": ['5'],"render": function (data, type, row) {
                    $datavlue = toMoney(parseFloat(data.toFixed(2)));
                    return $datavlue;
                  },"width": "6%"},
                  { "title" : "มิ.ย." , "data": ['6'],"render": function (data, type, row) {
                    $datavlue = toMoney(parseFloat(data.toFixed(2)));
                    return $datavlue;
                  },"width": "6%"},
                  { "title" : "ก.ค.", "data": ['7'],"render": function (data, type, row) {
                    $datavlue = toMoney(parseFloat(data.toFixed(2)));
                    return $datavlue;
                  },"width": "6%"},
                  { "title" : "ส.ค.", "data": ['8'],"render": function (data, type, row) {
                    $datavlue = toMoney(parseFloat(data.toFixed(2)));
                    return $datavlue;
                  },"width": "6%"},
                  { "title" : "ก.ย.", "data": ['9'],"render": function (data, type, row) {
                    $datavlue = toMoney(parseFloat(data.toFixed(2)));
                    return $datavlue;
                  },"width": "6%"},
                  { "title" : "ผลรวมมูลค่า", "data": '',"width": "6%"},
                ],
                'columnDefs': [
                {
                  "targets": [13],
                  'render': function (data, type, row){
                      $summarytotal = toMoney(parseFloat(row[1])+parseFloat(row[2])+parseFloat(row[3])+parseFloat(row[4])+parseFloat(row[5])+parseFloat(row[6])+parseFloat(row[7])+parseFloat(row[8])+parseFloat(row[9])+parseFloat(row[10])+parseFloat(row[11])+parseFloat(row[12]));
                      return $summarytotal;
                  }
                }],
              });
            }
        });
    }

    function initChartQ(){
      var years_Id = $('#yearsOfPlan option:selected').val();
      console.log(years_Id);
      var idRiverBasin = $('#idRiverBasin option:selected').val();
      var area_Id = $('#areaId option:selected').val();
      var typeofStandardId = $('#typeofStandardId option:selected').val();
      var typeOfGradeId = $('#typeOfGradeId option:selected').val();
      var speciesId = $('#speciesId option:selected').val();
      console.log(years_Id);
        var riverBasin ;
        $.ajax({
            url:"../util/incomeReportQuality.php",
            data: {years_Id:years_Id, actionPage:actionPage, idRiverBasin:idRiverBasin, area_Id:area_Id, typeOfAgri_id:typeOfAgri_id, agriList:agriList, typeofStandardId:typeofStandardId,typeOfGradeId:typeOfGradeId, speciesId:speciesId},
            method:"POST",
            dataType:"text",
            success:function(data){
                riverBasin =JSON.parse(data);
            },complete:function(){
                  var arr = Object.entries(riverBasin)
                  console.log(arr);
                  var options = {
                    type: 'line',
                    data: {
                        labels: ["ตุลาคม", "พฤศจิกายน", "ธันวาคม", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน"],
                        datasets: []
                    },
                    options: {
                      responsive: true,
                      title: {
                        display: true,
                        text: 'กราฟแสดงปริมาณการส่งมอบผลผลิต'
                      },
                      tooltips: {
                        mode: 'index',
                        intersect: false,
                        callbacks: {
                            label: function(t, d) {
                                var xLabel = d.datasets[t.datasetIndex].label;
                                return xLabel + ': ' + toMoney(t.yLabel);
                            }
                        }
                      },
                      hover: {
                        mode: 'nearest',
                        intersect: true
                      },
                      scales: {
                        xAxes: [{
                          display: true,
                          scaleLabel: {
                            display: true,
                            labelString: 'เดือน'
                          }
                        }],
                        yAxes: [{
                          display: true,
                          scaleLabel: {
                            display: true,
                            labelString: 'ปริมาณ'
                          },
                          ticks: {
                            callback: function(value, index, values) {
                              return toMoney(value);
                            }
                          }
                        }]
                      }
                    }
                  }
                myChartQ = new Chart( ctxQ, options);
                arr.forEach((v,index) => {
                  //var color = getRandomColor();
                    setTimeout(() => {
                      myChartQ.data.datasets.push({
                            data: v[1].dataset,
                            label: v[1].nameTypeOfArgi,
                            fill: false,
                            borderColor: listColorChart[index],
                            backgroundColor:listColorChart[index],
                            borderWidth: "2",
                        });
                        myChartQ.update()
                    }, parseInt(v[0]))
                })
            }
        });
    }

    function initTableQ() {
      var years_Id = $('#yearsOfPlan option:selected').val();
      var idRiverBasin = $('#idRiverBasin option:selected').val();
      var area_Id = $('#areaId option:selected').val();
      var typeofStandardId = $('#typeofStandardId option:selected').val();
      var typeOfGradeId = $('#typeOfGradeId option:selected').val();
      var speciesId = $('#speciesId option:selected').val();
      console.log(years_Id);
      $.ajax({
          url:"../util/incomeReportQualityJson.php",
          data: {years_Id:years_Id, actionPage:actionPage, idRiverBasin:idRiverBasin, area_Id:area_Id, typeOfAgri_id:typeOfAgri_id, agriList:agriList, typeofStandardId:typeofStandardId,typeOfGradeId:typeOfGradeId, speciesId:speciesId},
          method:"POST",
          dataType:"text",
          success:function(data){
            riverBasin = JSON.parse(data);
          },complete: function(){
          myTableQ = $('#dashTableQ').DataTable({
                'dom': "<'row'<'col-sm-6'Bl><'col-sm-5'f>>" +
                  "<'row'<'col-sm-11 scrolltable'tr>>" +
                  "<'row'<'bottombuttons col-sm-11'>><'row'<'col-sm-5'i><'col-sm-6'p>>",
                'buttons': [{
                  'extend': 'collection',
                  'className': 'exportButton',
                  'text': 'Data Export',
                  'buttons': [
                      { 'extend':'copy'},
                      { 'extend':'csv'},
                      { 'extend':'excel'},
                      { 'extend':'print'}
                    ]
                }],
                "scrollX": true,
                "sScrollX": "100%",
                "sScrollXInner": "110%",
                fixedHeader: true,
              "data" : riverBasin,
              "columns" : [
                  { "title" : "พืช", "data": ['nameTypeOfArgi'] ,"width": "15%"},
                  { "title" : "ต.ค.", "data": ['10'],
                  "render": function (data, type, row) {
                    $datavlue = toMoney(parseFloat(data.toFixed(2)));
                    return $datavlue;
                  },"width": "6%"},
                  { "title" : "พ.ย." , "data": ['11'],"render": function (data, type, row) {
                    $datavlue = toMoney(parseFloat(data.toFixed(2)));
                    return $datavlue;
                  },"width": "6%"},
                  { "title" : "ธ.ค." , "data": ['12'],"render": function (data, type, row) {
                    $datavlue = toMoney(parseFloat(data.toFixed(2)));
                    return $datavlue;
                  },"width": "6%"},
                  { "title" : "ม.ค." , "data": ['1'],"render": function (data, type, row) {
                    $datavlue = toMoney(parseFloat(data.toFixed(2)));
                    return $datavlue;
                  },"width": "6%"},
                  { "title" : "ก.พ." , "data": ['2'],"render": function (data, type, row) {
                    $datavlue = toMoney(parseFloat(data.toFixed(2)));
                    return $datavlue;
                  },"width": "6%"},
                  { "title" : "มี.ค." , "data": ['3'],"render": function (data, type, row) {
                    $datavlue = toMoney(parseFloat(data.toFixed(2)));
                    return $datavlue;
                  },"width": "6%"},
                  { "title" : "เม.ย.", "data": ['4'],"render": function (data, type, row) {
                    $datavlue = toMoney(parseFloat(data.toFixed(2)));
                    return $datavlue;
                  },"width": "6%"},
                  { "title" : "พ.ค." , "data": ['5'],"render": function (data, type, row) {
                    $datavlue = toMoney(parseFloat(data.toFixed(2)));
                    return $datavlue;
                  },"width": "6%"},
                  { "title" : "มิ.ย." , "data": ['6'],"render": function (data, type, row) {
                    $datavlue = toMoney(parseFloat(data.toFixed(2)));
                    return $datavlue;
                  },"width": "6%"},
                  { "title" : "ก.ค.", "data": ['7'],"render": function (data, type, row) {
                    $datavlue = toMoney(parseFloat(data.toFixed(2)));
                    return $datavlue;
                  },"width": "6%"},
                  { "title" : "ส.ค.", "data": ['8'],"render": function (data, type, row) {
                    $datavlue = toMoney(parseFloat(data.toFixed(2)));
                    return $datavlue;
                  },"width": "6%"},
                  { "title" : "ก.ย.", "data": ['9'],"render": function (data, type, row) {
                    $datavlue = toMoney(parseFloat(data.toFixed(2)));
                    return $datavlue;
                  },"width": "6%"},
                  { "title" : "ผลรวมปริมาณ", "data": '',"width": "6%"},
                ],
                'columnDefs': [
                {
                  "targets": [13],
                  'render': function (data, type, row){
                      $summarytotal = toMoney(parseFloat(row[1])+parseFloat(row[2])+parseFloat(row[3])+parseFloat(row[4])+parseFloat(row[5])+parseFloat(row[6])+parseFloat(row[7])+parseFloat(row[8])+parseFloat(row[9])+parseFloat(row[10])+parseFloat(row[11])+parseFloat(row[12]));
                      return $summarytotal;
                  }
                }],
              });
          }
      });
  }

    function getRandomColor() {
        var letters = '0123456789ABCDEF';
        var color = '#';
        for (var i = 0; i < 6; i++) {
          color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }
    function getListColor() {
      var listcolor =[];
      for (let i = 0; i < 12; i++){
        listcolor.push(getRandomColor());
      }
      console.log(listcolor);
      return listcolor;
    }
    function loadArea(idRiverBasin){
      $.ajax({
          url:"../util/loadAreaDropdown.php",
          method:"POST",
          data:{idRiverBasin:idRiverBasin},
          dataType:"text",
          success:function(data){
              $('#areaId').html(data);
          }
      });
    }
    $('#search_reportIncome').on('click', function () {
      spinner.show();
      typeOfAgri_id = $('#typeOfAgri_id option:selected').val();
      agriList = $('#agriList').val();
      if (typeOfAgri_id != '0' && !Array.isArray(agriList)) {
          spinner.hide();
          alert("เลือกชนิดอย่างน้อย1ชนิด");
          return false;
      }
      myChartM.destroy();
      myChartQ.destroy();
      myTableM.destroy();
      myTableQ.destroy();
      actionPage = 'search';
      initChartM();
      initTableM();
      initChartQ();
      initTableQ();
      spinner.hide();
      $($.fn.dataTable.tables(true)).DataTable()
         .columns.adjust();
    });

    function newexportaction(e, dt, button, config) {
      var self = this;
      var oldStart = dt.settings()[0]._iDisplayStart;
      dt.one('preXhr', function (e, s, data) {
          // Just this once, load all data from the server...
          data.start = 0;
          data.length = 2147483647;
          dt.one('preDraw', function (e, settings) {
              // Call the original action function
              if (button[0].className.indexOf('buttons-copy') >= 0) {
                  $.fn.dataTable.ext.buttons.copyHtml5.action.call(self, e, dt, button, config);
              } else if (button[0].className.indexOf('buttons-excel') >= 0) {
                  $.fn.dataTable.ext.buttons.excelHtml5.available(dt, config) ?
                      $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config) :
                      $.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
              } else if (button[0].className.indexOf('buttons-csv') >= 0) {
                  $.fn.dataTable.ext.buttons.csvHtml5.available(dt, config) ?
                      $.fn.dataTable.ext.buttons.csvHtml5.action.call(self, e, dt, button, config) :
                      $.fn.dataTable.ext.buttons.csvFlash.action.call(self, e, dt, button, config);
              } else if (button[0].className.indexOf('buttons-pdf') >= 0) {
                  $.fn.dataTable.ext.buttons.pdfHtml5.available(dt, config) ?
                      $.fn.dataTable.ext.buttons.pdfHtml5.action.call(self, e, dt, button, config) :
                      $.fn.dataTable.ext.buttons.pdfFlash.action.call(self, e, dt, button, config);
              } else if (button[0].className.indexOf('buttons-print') >= 0) {
                  $.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
              }
              dt.one('preXhr', function (e, s, data) {
                  // DataTables thinks the first item displayed is index 0, but we're not drawing that.
                  // Set the property to what it was before exporting.
                  settings._iDisplayStart = oldStart;
                  data.start = oldStart;
              });
              // Reload the grid with the original page. Otherwise, API functions like table.cell(this) don't work properly.
              setTimeout(dt.ajax.reload, 0);
              // Prevent rendering of the full data to the DOM
              return false;
          });
      });
      // Requery the server with the new one-time export settings
      dt.ajax.reload();
    };
    function toMoney(n) {
      return n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
    }
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
         .columns.adjust();
   });
    

})(jQuery);

