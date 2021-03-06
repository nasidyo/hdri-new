
(function ($) {
   /* var perfEntries = performance.getEntriesByType("navigation");

    if (perfEntries[0].type === "back_forward") {
        location.reload(true);
    }*/


    var ctxVolume = document.getElementById( "pieChartVolume" );
    var ctxValue = document.getElementById( "pieChartValue" );
    var myChartVolume;
    var myChartValue ;
    initChartPersonMarketByMK();

$("#idRiverBasin").on("change",function(){
    myChartVolume.destroy();
    myChartValue.destroy();
    initChartPersonMarketByMK();

    var idRiverBasin = $(this).val();
    $.ajax({
        url:"../util/AreaDependent.php",
        method:"POST",
        data:{idRiverBasin:idRiverBasin},
        dataType:"text",
        success:function(data){
            $('#area').html(data);
        }
    });

});

$("#area").on("change",function(){
    myChartVolume.destroy();
    myChartValue.destroy();
    initChartPersonMarketByMK();
});
$("#year").on("change",function(){
    myChartVolume.destroy();
    myChartValue.destroy();
    initChartPersonMarketByMK();
});




    function initChartPersonMarketByMK(){

        var report ;
        var idRiverBasin = $("#idRiverBasin").val();
        var area = $("#area").val();
        var year = $("#year").val();
        $.ajax({
            url:"../util/ReportPMByMk.php?idRiverBasin="+idRiverBasin+"&year="+year+"&area="+area,
            method:"GET",
            dataType:"text",
            success:function(data){
                report =JSON.parse(data);
            },complete:function(){
              var labelPM=[];
              var labelPMs=[];
              var labelPMe=[];
              var volumnPM=[];
              var totalvaluePM=[];

              var allvol=0;
              var allval=0;

                for(var i=0;i<report.length;i++){
                    labelPM.push(report[i].nameMarket);
                    volumnPM.push(report[i].Volumn);
                    totalvaluePM.push(report[i].TotalValue);
                    allvol +=report[i].Volumn?report[i].Volumn:0;
                    allval +=report[i].TotalValue?report[i].TotalValue:0;

                }
                for(var x=0;x<labelPM.length;x++){
                    var calPer = (report[x].Volumn*100) /allvol.toFixed(2) ;
                    if(calPer >= 1){
                        var calPer = calPer.toFixed(0);
                    }else{
                        var calPer = calPer.toFixed(2);
                    }
                    labelPMs.push(labelPM[x] +' ('+calPer+'%)');
                }
                for(var x=0;x<labelPM.length;x++){
                    var calPer = (report[x].TotalValue*100) /allval.toFixed(2) ;
                    if(calPer >= 1){
                        var calPer = calPer.toFixed(0);
                    }else{
                        var calPer = calPer.toFixed(2);
                    }
                    labelPMe.push(labelPM[x] +' ('+calPer+'%)');
                }

                myChartVolume = new Chart( ctxVolume, {
                    type: 'pie',
                    data: {
                        labels:labelPMs,
                        datasets: [ {
                            data: volumnPM,
                            backgroundColor: [
                                "rgba(138, 223, 226, 1)",
                                "rgba(85, 197, 209, 1)",
                                "rgba(70, 153, 195, 1)",
                                "rgba(255, 214, 126, 1)",
                                "rgba(247, 156, 101, 1)",
                                "rgba(252, 132, 118, 1)",
                                "rgba(209, 91, 117, 1)"
                                            ],
                            hoverBackgroundColor: [

                                "rgba(138, 223, 226, 1)",
                                "rgba(85, 197, 209, 1)",
                                "rgba(70, 153, 195, 1)",
                                "rgba(255, 214, 126, 1)",
                                "rgba(247, 156, 101, 1)",
                                "rgba(252, 132, 118, 1)",
                                "rgba(209, 91, 117, 1)"
                                            ]

                                        } ]

                    },
                    options: {
                        tooltips: {
                            callbacks: {
                                label: function(t, d) {
                                    var Label = d.datasets[0].data[t.index];
                                    var xLabel = d.labels[t.index];
                                    var calPer = (Label*100) /allvol.toFixed(2) ;
                                    if(calPer >= 1){
                                        var calPer = calPer.toFixed(0);
                                    }else{
                                        var calPer = calPer.toFixed(2);
                                    }
                                    return xLabel + ': ' + numberWithCommas(Label)+' ????????? ('+calPer+'%)';
                                }
                            }
                        },
                        plugins: {
                            datalabels: {
                              formatter: (value, ctx) => {
                                var calPer = (value*100) /allvol.toFixed(2) ;
                                if(calPer >= 1){
                                  var calPer = calPer.toFixed(0);
                                }else{
                                    var calPer = calPer.toFixed(2);
                                }
                                return  calPer+'%';
                              },
                              color: '#212529',
                            }
                          },
                        responsive: true
                    }
                }  );


                myChartValue = new Chart( ctxValue, {
                    type: 'pie',
                    data: {
                        labels:labelPMe,
                        datasets: [ {
                            data: totalvaluePM,
                            backgroundColor: [
                                                "rgba(138, 223, 226, 1)",
                                                "rgba(85, 197, 209, 1)",
                                                "rgba(70, 153, 195, 1)",
                                                "rgba(255, 214, 126, 1)",
                                                "rgba(247, 156, 101, 1)",
                                                "rgba(252, 132, 118, 1)",
                                                "rgba(209, 91, 117, 1)"
                                            ],
                            hoverBackgroundColor: [

                                                "rgba(138, 223, 226, 1)",
                                                "rgba(85, 197, 209, 1)",
                                                "rgba(70, 153, 195, 1)",
                                                "rgba(255, 214, 126, 1)",
                                                "rgba(247, 156, 101, 1)",
                                                "rgba(252, 132, 118, 1)",
                                                "rgba(209, 91, 117, 1)"
                                            ]

                                        } ]

                    },
                    options: {
                        tooltips: {
                            callbacks: {
                                label: function(t, d) {
                                    var Label = d.datasets[0].data[t.index];
                                    var xLabel = d.labels[t.index];
                                    var calPer = (Label*100) /allval.toFixed(2) ;
                                    if(calPer >= 1){
                                        var calPer = calPer.toFixed(0);
                                      }else{
                                          var calPer = calPer.toFixed(2);
                                      }
                                    return xLabel + ': ' + toMoney(Label)+'????????? ('+calPer+'%)';
                                }
                            }
                        },
                        plugins: {
                            datalabels: {
                              formatter: (value, ctx) => {
                                var calPer = (value*100) /allval.toFixed(2) ;
                                if(calPer >= 1){
                                  var calPer = calPer.toFixed(0);
                                }else{
                                    var calPer = calPer.toFixed(2);
                                }
                                return  calPer+'%';
                              },
                              color: '#212529',
                            }
                          },
                        responsive: true
                    }
                }  );


            }
        });
    }

    function numberWithCommas(x) {
        x = x.toFixed(0);
        var pattern = /(-?\d+)(\d{3})/;
        while (pattern.test(x))
            x = x.replace(pattern, "$1,$2");
        return x;
    }




})(jQuery);


