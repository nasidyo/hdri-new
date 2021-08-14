(function ($) {
    var spinner = $('#loader');
    var ctxM = document.getElementById("barChartValue");
    ctxM.height = 100;
    var years_Id = $('#yearsOfPlan option:selected').val();
    var myChartM;
    var typeOfAgri_id;
    var agriList;
    var actionPage = 'Nofind';
    var listColorChart = getListColor();
    $('#idRiverBasin').select2();
    $('#areaId').select2();
    $('#typeOfAgri_id').select2();
    $('.agri-dropdown').select2();
    $('#typeOfGradeId').select2();

    initChartM();
  
    $('#yearsOfPlan').change(function(){
      myChartM.destroy();
      initChartM();
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
    // $('#typeOfGradeId').change(function(){
    //     $.ajax({
    //         url:"../util/loadProductStandardAllJs.php",
    //         dataType:"text",
    //         success:function(data){
    //             $('#typeofStandardId').html(data);
    //         }
    //     });
    // });
    function initChartM(){
      var years_Id = $('#yearsOfPlan option:selected').val();
      var idRiverBasin = $('#idRiverBasin option:selected').val();
      var area_Id = $('#areaId option:selected').val();
      var typeofStandardId = $('#typeofStandardId option:selected').val();
      var typeOfGradeId = $('#typeOfGradeId option:selected').val();
      var speciesId = $('#speciesId option:selected').val();
      var riverBasin ;
      $.ajax({
          url:"../util/farmerReport.php",
          data: {years_Id:years_Id, actionPage:actionPage, idRiverBasin:idRiverBasin, area_Id:area_Id, typeOfAgri_id:typeOfAgri_id, agriList:agriList, typeofStandardId:typeofStandardId,typeOfGradeId:typeOfGradeId,speciesId:speciesId },
          method:"POST",
          dataType:"text",
          success:function(data){
              riverBasin =JSON.parse(data);
          },complete:function(){

                var labelPM = [];
                var totalvaluePM = [];
                console.log(riverBasin);
                var listdata  = riverBasin[0];
                console.log(listdata);
                for(var i=0;i<listdata.datalable.length;i++){
                    console.log(listdata.datalable[i]);
                    labelPM.push(listdata.datalable[i]);
                    totalvaluePM.push(listdata.dataset[i]?listdata.dataset[i]:0);
                }
                console.log(labelPM);
                console.log(totalvaluePM);
                myChartM = new Chart( ctxM, {
                  type: 'horizontalBar',
                  data: {
                      labels:labelPM,
                      datasets: [
                          {
                              label: "จำนวนเกษตกรส่งมอบผลผลิต",
                              data:totalvaluePM,
                              borderColor: "rgba(0,0,0,0.09)",
                              borderWidth: "0",
                              backgroundColor: "rgba(150, 123, 255, 0.5)"
                          }
                                  ]
                  },
                  options: {
                      tooltips: {
                          callbacks: {
                              label: function(t, d) {
                                  var xLabel = d.datasets[t.datasetIndex].label;
                                  return xLabel + ': ' + toMoney(t.xLabel) +' ราย'
                              }
                          }
                      },
                      scales: {
                          xAxes: [{
                              display: true,
                              scaleLabel: {
                                display: true,
                              },
                              ticks: {
                                  beginAtZero: true,
                                  callback: function(value, index, values) {
                                    return toMoney(value);
                                  }
                                }
                            }],
                          yAxes: [ {
                              ticks: {
                                  beginAtZero: true
                              },
                              display: true,
                              scaleLabel: {
                                display: true,
                              }
                                } ]
                      }
                  }
              } );


                // myChartM = new Chart( ctxM, {
                //     type: 'horizontalBar',
                //     data: {
                //         labels: labelPM,
                //         datasets: [{
                //             data: totalvaluePM,
                //             label: "ส่งมอบ",
                //             borderColor: "rgba(0,0,0,0.09)",
                //             borderWidth: "0",
                //             backgroundColor: "rgba(0, 123, 255, 0.5)",
                //             fill: false,
                //         }]
                //     },options: {
                //         tooltips: {
                //             displayColors: true,
                //             callbacks:{
                //                 label: function(t, d) {
                //                 var xLabel = d.datasets[t.datasetIndex].label;
                //                 return xLabel + ': ' + toMoney(t.yLabel);
                //                 }
                //             },
                //         },
                //         scales: {
                //             xAxes: [{
                //             stacked: true,
                //             gridLines: {
                //                 display: false,
                //             },
                //             ticks: {
                //                 autoSkip: false,
                //                 maxRotation: 90,
                //                 minRotation: 90
                //             }
                //             }],
                //             yAxes: [{
                //             stacked: true,
                //             ticks: {
                //                 beginAtZero: true,
                //             },
                //             type: 'linear',
                //             }]
                //         },
                //         responsive: true,
                //         maintainAspectRatio: false,
                //         legend: { position: 'top' },
                //         }
                // });
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
      actionPage = 'search';
      initChartM();
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

