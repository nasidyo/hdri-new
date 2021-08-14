(function ($) {
    var spinner = $('#loader');
    var ctxM = document.getElementById( "barChartM" );
    var myChartM;
    var area_Id = $('#area_Id').val();
    var years_Id = $('#yearsOfPlan option:selected').val();
    var actionPage = $('#actionPage').val();
    initChartM(years_Id);

    // select 2
    $('#typeOfAgri_id').select2();
    $('#agri').select2();
    $('#farmer_Id').select2();

    $("#yearsOfPlan").change(function(){
        actionPage = $('#actionPage').val();
        if(actionPage == 'show'){
            years_Id = $(this).val();
            spinner.show();
            myChartM.destroy();
            initChartM(years_Id);
            spinner.hide();
        }else{
            spinner.show();
            myChartM.destroy();
            initChartBySearch();
            spinner.hide();
        }
     });

    function initChartM(years_Id){
        //    ctx.height = 200;
        var riverBasin ;
        $.ajax({
            url:"../util/reportIncomePerson.php",
            data: {yearsId:years_Id, area_Id:area_Id, actionPage:actionPage},
            method:"POST",
            dataType:"text",
            success:function(data){
                riverBasin =JSON.parse(data);
            },complete:function(){
                console.log(riverBasin);
              var label=[];
              var all=[];
                for(var i=0;i<riverBasin.length;i++){
                    label.push(riverBasin[i].fullName);
                    all.push(riverBasin[i].totalIncomePerson);
                }
                console.log(label);
                console.log(all);
                 myChartM = new Chart( ctxM, {
                    type: 'horizontalBar',
                    data: {
                        labels: label,
                        datasets: [
                            {
                                label: "รายได้ทั้งหมดของเกษตรกร",
                                data: all,
                                borderColor: "rgba(0, 123, 255, 0.9)",
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
                                    return xLabel + ': ' + toMoney(t.xLabel) +' บาท'
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
                                }
                            } ]
                        }
                    }
                } );
            }
        });
    }
    $('#typeOfAgri_id').change(function(){
        var tpyeOfAgri_Id = $(this).val();
        $.ajax({
            url:"../util/loadAgriProduct.php",
            method:"POST",
            data:{tpyeOfAgri_Id:tpyeOfAgri_Id, area_Id:area_Id},
            dataType:"text",
            success:function(data){
                $('#agri').html(data);
            }
        });
     });
    $('#search_reportIncome').on('click', function () {
        spinner.show();
        myChartM.destroy();
        $('#actionPage').val("search");
        initChartBySearch();
        spinner.hide();
    });

    function initChartBySearch(){
        years_Id = $('#yearsOfPlan option:selected').val();
        var typeOfAgri_id = $('#typeOfAgri_id').val();
        var agri = $('#agri').val();
        var month_id = $('#month_id').val();
        var farmer_Id = $('#farmer_Id').val();
        $.ajax({
            url:"../util/reportIncomePerson.php",
            data: {yearsId:years_Id, area_Id:area_Id, actionPage: "search", farmer_Id:farmer_Id, month_id:month_id,
            agri:agri, typeOfAgri_id:typeOfAgri_id},
            method:"POST",
            dataType:"text",
            success:function(data){
                riverBasin =JSON.parse(data);
            },
            complete:function(){
                if(farmer_Id != '0'){
                    var label=[];
                    var all=[];
                    for(var i=0;i<riverBasin.length;i++){
                        label.push("["+riverBasin[i].nameTypeOfArgi+"]"+riverBasin[i].nameArgi);
                        all.push(riverBasin[i].totalIncomePerson);
                    }
                    console.log(label);
                    console.log(all);
                    myChartM = new Chart( ctxM, {
                        type: 'horizontalBar',
                        data: {
                            labels: label,
                            datasets: [
                                {
                                    label: "รายได้ทั้งหมดของเกษตรกร (บาท)",
                                    data: all,
                                    borderColor: "rgba(0, 123, 255, 0.9)",
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
                                        return xLabel + ': ' + toMoney(t.xLabel) +' บาท'
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
                                    }
                                } ]
                            }
                        }
                    } );
                }else{
                    var label=[];
                    var all=[];
                    for(var i=0;i<riverBasin.length;i++){
                        label.push(riverBasin[i].fullName);
                        all.push(riverBasin[i].totalIncomePerson);
                    }
                    console.log(label);
                    console.log(all);
                    myChartM = new Chart( ctxM, {
                        type: 'horizontalBar',
                        data: {
                            labels: label,
                            datasets: [
                                {
                                    label: "รายได้ทั้งหมดของเกษตรกร (บาท)",
                                    data: all,
                                    borderColor: "rgba(0, 123, 255, 0.9)",
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
                                        return xLabel + ': ' + toMoney(t.xLabel) +' บาท'
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
                                    }
                                } ]
                            }
                        }
                    } );
                }
            }
        });
    }
})(jQuery);

