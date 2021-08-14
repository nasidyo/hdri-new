
(function ($) {
    var spinner = $('#loader');
  /*  var perfEntries = performance.getEntriesByType("navigation");

    if (perfEntries[0].type === "back_forward") {
        location.reload(true);
    }*/

    // select 2
    $('#idRiverBasin').select2();
    $('#areaId').select2();
    $('#typeOfAgri_id').select2();
    $('.agri-dropdown').select2();

    var ctxVolume = document.getElementById( "barChartVolume" );
    var ctxValue = document.getElementById( "barChartValue" );
    var myChartVolume = null;
    var myChartValue = null;
    var typeOfAgri_id = $('#typeOfAgri_id option:selected').val();
    var idRiverBasin = $('#idRiverBasin option:selected').val();
    var years_Id = $('#year option:selected').val();
    var area_Id = $('#areaId option:selected').val();
    var month_id = $('#month_id option:selected').val();
    var agriList;
    // initChartPersonMarket();

$("#idRiverBasin").on("change",function(){
    // myChartVolume.destroy();
    // myChartValue.destroy();
    idRiverBasin = $(this).val();
    loadArea(idRiverBasin);
    years_Id = $('#year option:selected').val();
    // typeOfAgri_id = $('#typeOfAgri_id option:selected').val();
    // var area_Id = $('#areaId option:selected').val();
    // initChartPersonMarket();
});

// $("#year").on("change",function(){
//     myChartVolume.destroy();
//     myChartValue.destroy();
//     years_Id = $('#year option:selected').val();
//     typeOfAgri_id = $('#typeOfAgri_id option:selected').val();
//     area_Id = $('#areaId option:selected').val();
//     initChartPersonMarket();
// });

$("#typeOfAgri_id").on("change",function(){
    // myChartVolume.destroy();
    // myChartValue.destroy();
    // years_Id = $('#year option:selected').val();
    // idRiverBasin = $('#idRiverBasin option:selected').val();
    typeOfAgri_id = $('#typeOfAgri_id option:selected').val();
    // area_Id = $('#areaId option:selected').val();
    // initChartPersonMarket();

    if(typeOfAgri_id != '0'){
        $.ajax({
            url:"../util/loadAgriProduct.php",
            method:"POST",
            data:{tpyeOfAgri_Id:typeOfAgri_id, area_Id:area_Id},
            dataType:"text",
            success:function(data){
                $('#agriList').html(data);
            }
        });
    }
});
$('#agriList').change(function(){
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

// $("#areaId").on("change",function(){
//     myChartVolume.destroy();
//     myChartValue.destroy();
//     years_Id = $('#year option:selected').val();
//     idRiverBasin = $('#idRiverBasin option:selected').val();
//     typeOfAgri_id = $('#typeOfAgri_id option:selected').val();
//     area_Id = $('#areaId option:selected').val();
//     initChartPersonMarket();
// });

    function initChartPersonMarket(){
        var report ;
        console.log(years_Id);
        console.log(idRiverBasin);
        console.log(area_Id);
        console.log(typeOfAgri_id);
        $.ajax({
            url:"../util/ReportUtilN.php",
            data: {years_Id:years_Id, idRiverBasin:idRiverBasin, area_Id:area_Id, typeOfAgri_id:typeOfAgri_id, agriList:agriList, month_id:month_id, speciesId:speciesId},
            method:"POST",
            dataType:"text",
            success:function(data){
                console.log(data);
                report =JSON.parse(data);
            },complete:function(){
              spinner.hide();
              var labelPM=[];
              var volumnPM=[];
              var totalvaluePM=[];
              var volumnP =[];
              var totalvalueP=[];
              var labelP=[];
                for(var i=0;i<report.length;i++){
                    labelPM.push(report[i].displayName+ " : "+calPercent(report[i].Weight,report[i].Volumn)+" %" );
                    volumnPM.push(report[i].Volumn.toFixed(2));
                    totalvaluePM.push(report[i].TotalValue.toFixed(2));

                    labelP.push(report[i].displayName+ " : "+calPercent(report[i].Total,report[i].TotalValue)+" %" );
                    volumnP.push(report[i].Weight.toFixed(2));
                    totalvalueP.push(report[i].Total.toFixed(2));

                }
                myChartVolume = new Chart( ctxVolume, {
                    type: 'horizontalBar',
                    data: {
                        labels:labelPM,
                        datasets: [
                            {
                                label: "ปริมาณเป้าหมายผลผลิตรวม",
                                data:volumnP,
                                borderColor: "rgba(0,0,0,0.09)",
                                borderWidth: "0",
                                backgroundColor: "rgba(150, 123, 255, 0.5)"
                            },{
                                label: "ปริมาณส่งมอบรวม",
                                data:volumnPM,
                                borderColor: "rgba(0,0,0,0.09)",
                                borderWidth: "0",
                                backgroundColor: "rgba(0, 255, 255, 0.5)"
                            }
                                    ]
                    },
                    options: {
                        tooltips: {
                            callbacks: {
                                label: function(t, d) {
                                    var xLabel = d.datasets[t.datasetIndex].label;
                                    return xLabel + ': ' + toMoney(t.xLabel) 
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

                myChartValue = new Chart( ctxValue, {
                    type: 'horizontalBar',
                    data: {
                        labels:labelP,
                        datasets: [
                            
                            {
                                label: "มูลค่าเป้าหมายรายได้รวม",
                                data:totalvalueP,
                                borderColor: "rgba(0,0,0,0.09)",
                                borderWidth: "0",
                                backgroundColor: "#28a745"
                            },{
                                label: "มูลค่าส่งมอบรวม",
                                data:totalvaluePM,
                                borderColor: "rgba(0,0,0,0.09)",
                                borderWidth: "0",
                                backgroundColor: "rgba(0, 123, 255, 0.5)"
                            }
                                    ]
                    },
                    options: {
                        tooltips: {
                            callbacks: {
                                label: function(t, d) {
                                    var xLabel = d.datasets[t.datasetIndex].label;
                                    return xLabel + ': ' + toMoney(t.xLabel) 
                                }
                            }
                        },
                        scales: {
                            xAxes: [{
                                display: true,
                                scaleLabel: {
                                  display: true,
                                },ticks: {
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
            }
        });
    }
    function calPercent(all, amount){
        var percent =0 ;
        if(all != 0 && all!=undefined){
            percent =   (amount * 100) / all;
        }
        return percent.toFixed(2);
    }

    function moneyFormat(num){
        var options = {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
          };
            var formatted = Number(num).toLocaleString('en', options);
          return formatted;

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
        idRiverBasin = $("#idRiverBasin option:selected").val();
        years_Id = $('#year option:selected').val();
        area_Id = $("#areaId option:selected").val();
        typeOfAgri_id = $('#typeOfAgri_id option:selected').val();
        agriList = $('#agriList').val();
        month_id = $("#month_id option:selected").val();
        speciesId = $("#speciesId option:selected").val();
        // if (typeOfAgri_id != '0' && !Array.isArray(agriList)) {
        //     spinner.hide();
        //     alert("เลือกชนิดอย่างน้อย1ชนิด");
        //     return false;
        // }
        if(myChartVolume!=null){
            myChartVolume.destroy();
        }
        if(myChartValue!=null){
            myChartValue.destroy();
        }
        // myChartVolume.destroy();
        // myChartValue.destroy();
        initChartPersonMarket();
      });



})(jQuery);


