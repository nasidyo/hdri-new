
(function ($) {
  /*  var perfEntries = performance.getEntriesByType("navigation");

    if (perfEntries[0].type === "back_forward") {
        location.reload(true);
    }*/


    var ctxVolume = document.getElementById( "barChartVolume" );
    var ctxValue = document.getElementById( "barChartValue" );
    var myChartVolumes;
    var myChartValues ;
    initChartPersonMarketByRiver();

$("#idRiverBasin").on("change",function(){
    myChartValues.destroy();
    myChartVolumes.destroy();
    if(this.value!=0){
        initChartPersonMarketByArea();
    }else{
        initChartPersonMarketByRiver();
    }
});

$("#year").on("change",function(){
    myChartValues.destroy();
    myChartVolumes.destroy();
    if(this.value!=0){
        initChartPersonMarketByArea();
    }else{
        initChartPersonMarketByRiver();
    }
});

    function initChartPersonMarketByRiver(){

        var report ;
        var idRiverBasin = $("#idRiverBasin").val();
        var year = $("#year").val();
        $.ajax({
            url:"../util/ReportUtil.php?idRiverBasin="+idRiverBasin+"&year="+year,
            method:"GET",
            dataType:"text",
            success:function(data){
                report =JSON.parse(data);
            },complete:function(){
              var labelPM=[];
              var volumnPM=[];
              var totalvaluePM=[];
              var volumnP =[];
              var totalvalueP=[];
              var labelP=[];
                for(var i=0;i<report.length;i++){
                  /*  labelPM.push(report[i].nameRiverBasin);
                    volumnPM.push(report[i].Volumn);
                    totalvaluePM.push(report[i].TotalValue);

                    volumnP.push(report[i].Weight);
                    totalvalueP.push(report[i].Total);*/


                    labelPM.push(report[i].nameRiverBasin+ " : "+calPercent(report[i].Weight,report[i].Volumn)+" %" );
                    volumnPM.push(report[i].Volumn.toFixed(2));
                    totalvaluePM.push(report[i].TotalValue.toFixed(2));

                    labelP.push(report[i].nameRiverBasin+ " : "+calPercent(report[i].Total,report[i].TotalValue)+" %" );
                    volumnP.push(report[i].Weight.toFixed(2));
                    totalvalueP.push(report[i].Total.toFixed(2));

                }

                myChartVolumes = new Chart( ctxVolume, {
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
                            },
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
                                    callback: function(value, index, values) {
                                      return toMoney(value);
                                    }
                                  }
                              }],
                            yAxes: [ {
                                ticks: {
                                    beginAtZero: true
                                }
                                  } ]
                        }
                    }
                } );

                myChartValues = new Chart( ctxValue, {
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
                            },
                            {
                                label: "มูลค่าส่งมอบรวม",
                                data:totalvaluePM,
                                borderColor: "rgba(0,0,0,0.09)",
                                borderWidth: "0",
                                backgroundColor: "rgba(0, 123, 255, 0.5)"
                            },
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
                                    callback: function(value, index, values) {
                                      return toMoney(value);
                                    }
                                  }
                              }],
                            yAxes: [ {
                                ticks: {
                                    beginAtZero: true
                                }
                                  } ]
                        }
                    }
                } );
            }
        });
    }



    function initChartPersonMarketByArea(){

        var report ;
        var idRiverBasin = $("#idRiverBasin").val();
        var year = $("#year").val();
        $.ajax({
            url:"../util/ReportUtilByArea.php?idRiverBasin="+idRiverBasin+"&year="+year,
            method:"GET",
            dataType:"text",
            success:function(data){
                report =JSON.parse(data);
            },complete:function(){
              var labelPM=[];
              var labelP=[];
              var volumnPM=[];
              var totalvaluePM=[];
              var volumnP =[];
              var totalvalueP=[];
                for(var i=0;i<report.length;i++){
                    labelPM.push(report[i].areaName+ " : "+calPercent(report[i].Weight,report[i].Volumn)+" %" );
                    volumnPM.push(report[i].Volumn.toFixed(2));
                    totalvaluePM.push(report[i].TotalValue.toFixed(2));

                    labelP.push(report[i].areaName+ " : "+calPercent(report[i].Total,report[i].TotalValue)+" %" );
                    volumnP.push(report[i].Weight.toFixed(2));
                    totalvalueP.push(report[i].Total.toFixed(2));
                }

                myChartVolumes = new Chart( ctxVolume, {
                    type: 'horizontalBar',
                    data: {
                        labels:labelPM,
                        datasets: [


                            {
                                label: "ปริมาณส่งมอบรวม",
                                data:volumnPM,
                                borderColor: "rgba(0,0,0,0.09)",
                                borderWidth: "0",
                                backgroundColor: "rgba(0, 255, 255, 0.5)"
                            }, {
                                label: "ปริมาณเป้าหมายผลผลิตรวม",
                                data:volumnP,
                                borderColor: "rgba(0,0,0,0.09)",
                                borderWidth: "0",
                                backgroundColor: "rgba(150, 123, 255, 0.5)"
                            },
                                    ]
                    },
                    options: {
                        scales: {
                            xAxes: [{
                                display: true,
                                scaleLabel: {
                                  display: true,
                                },
                                ticks: {
                                    callback: function(value, index, values) {
                                      return toMoney(value);
                                    }
                                  }
                              }],
                            yAxes: [ {
                                ticks: {
                                    beginAtZero: true
                                }
                                  } ]
                        }
                    }
                } );

                myChartValues = new Chart( ctxValue, {
                    type: 'horizontalBar',
                    data: {
                        labels:labelP,
                        datasets: [

                            {
                                label: "มูลค่าส่งมอบรวม",
                                data:totalvaluePM,
                                borderColor: "rgba(0,0,0,0.09)",
                                borderWidth: "0",
                                backgroundColor: "rgba(0, 123, 255, 0.5)"
                            },
                            {
                                label: "มูลค่าเป้าหมายรายได้รวม",
                                data:totalvalueP,
                                borderColor: "rgba(0,0,0,0.09)",
                                borderWidth: "0",
                                backgroundColor: "#28a745"
                            }
                                    ]
                    },
                    options: {
                        scales: {
                            xAxes: [{
                                display: true,
                                scaleLabel: {
                                  display: true,
                                },
                                ticks: {
                                    callback: function(value, index, values) {
                                      return toMoney(value);
                                    }
                                  }
                              }],
                            yAxes: [ {
                                ticks: {
                                    beginAtZero: true
                                }
                                  } ]
                        },

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



})(jQuery);


