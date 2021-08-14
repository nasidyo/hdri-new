if (!window.reportNewF){
    // creating an empty global object
    var reportNewF = {};
}
(function ($) {
    var yearsId = $('#yearsOfPlan option:selected').val();
    var basinId = $("#basinId").val();
    var areaId = $("#areaId").val();
    document.getElementById("waitSelect").style.display = "none";
    loadTableTotalMarket(yearsId, basinId, areaId);
    loadBtnBasin(yearsId);

    var ctxTotalSale = document.getElementById("totalSale-chart-canvas");
    var myChartTotalSale;

    var ctxMarket = document.getElementById("market-chart-canvas");
    var myChartMarket;

    var ctxAgriMarket = document.getElementById("agriAndMarket-chart-canvas").getContext('2d');
    var myChartAgriMarket;

    var planAndSale = document.getElementById("planAndSale-chart-canvas").getContext('2d');
    var myChartplanAndSale;

    // var ctxAgriAndBasin = document.getElementById("agriAndBasin-chart-canvas").getContext('2d');
    // var myChartAgriAndBasin;

    var ctxMarketTotal = document.getElementById("pieMarketTotal-chart-canvas").getContext('2d');
    var myChartMarketTotal;

    var ctxMonthy = document.getElementById("monthyFB-chart-canvas");
    ctxMonthy.height = 500;
    var myChartMonthy;

    $('#excel_totalMarket').click(function(){
        exportTableToExcel("totalMarket", "มูลค่าส่งมอบผลผลิตของโครงการ");
    });

    $('#excel_totalMonthy').click(function(){
        exportTableToExcel("totalMonthy", "มูลค่าส่งมอบผลผลิตของโครงการ จำแนกรายเดือน");
    });

    $('#excel_totalBasinMarket').click(function(){
        exportTableToExcel("totalBasinMarket", "ปริมาณและมูลค่าส่งมอบผลผลิตของโครงการ");
    });

    $('#yearsOfPlan').change(function(){
        var yearsId = $("#yearsOfPlan").val();
        console.log(yearsId);
        if(myChartTotalSale!=undefined){
            myChartTotalSale.destroy();
        }
        if(myChartMarket!=undefined){
            myChartMarket.destroy();
        }
        if(myChartMonthy!=undefined){
            myChartMonthy.destroy();
        }
        if(myChartAgriMarket!=undefined){
            myChartAgriMarket.destroy();
        }
        if(myChartplanAndSale!=undefined){
            myChartplanAndSale.destroy();
        }
        if(myChartMarketTotal!=undefined){
            myChartMarketTotal.destroy();
        }
        loadTableTotalMarket(yearsId, basinId, areaId);
        loadBtnBasin(yearsId);
        loadTableTotalMarket(yearsId, basinId, areaId);
        initChartTotalSale(yearsId, basinId, areaId);
        initBarChartAgriMarket(yearsId, basinId, areaId);
        initBarChartMonthy(yearsId, basinId, areaId);
        initChartMarketTotal(yearsId, basinId, areaId);
        initChartPlanAndSale(yearsId, basinId, areaId);
        loadTableBATotalMarket(yearsId, basinId);
    });
    
    function loadBtnBasin(yearsId) {
        $('#sectionBtnSelecte').html("");
        $.ajax({
            url:"../util/loadBtnProject.php",
            data:{yearsId:yearsId},
            method:"POST",
            dataType:"text",
            success:function(data){
                console.log(data);
                reportBtn = JSON.parse(data);
                console.log(reportBtn);
            },complete:function(data){
                var loopcount = 0;
                    if(reportBtn[0].totalPassyers == 0 || reportBtn[0].totalPassyers == null){
                        passcalPerss = 100;
                    }else{
                        var passcalPerss = ((reportBtn[0].totalOnyers - reportBtn[0].totalPassyers)/reportBtn[0].totalPassyers)*100 ;
                        passcalPerss = passcalPerss.toFixed(0);
                    }
                  console.log(passcalPerss);
                  if(passcalPerss > 1){
                    passcalPerss = '<p><h4 style="color:green;text-align:right;right:40%;top: 60%;position: absolute;"> อัตราการเติบโต :  <i class="fas fa-arrow-up"></i>  '+passcalPerss+' %</h4></p>';
                  }else if (passcalPerss == 0){
                    passcalPerss = '<p><h5 style="color:yellow;text-align:right;right:40%;top: 60%;position: absolute;">อัตราการเติบโต : <i class="fas fa-equals"></i>  '+passcalPerss+' %</h4></p>';
                  }else{
                    passcalPerss = '<p><h4 style="color:red;text-align:right;right:40%;top: 60%;position: absolute;"> อัตราการเติบโต : <i class="fas fa-arrow-down"></i>  '+(passcalPerss)*-1+' %</h4></p>';
                  }
                  var data = '<div class="row">';
                  data += '<div class="col-lg-6 col-6">';
                  data += '<div class="small-box bg-info" style="height: 92%;">';
                  data += '<div class="inner">';
                  data += '<p>มูลค่าการซื้อขายรวม</p>';
                  data += '<h3>'+numberWithCommas(reportBtn[0].totalOnyers)+' บาท</h3>';
                  data += '<div class="mb-0">';
                  data += passcalPerss;
                  data += '</div></div>';
                  data += '<a href="javascript:reportNewF.a1_onclick(0);" id="basin_0" class="small-box-footer basins" style="top: 33.2%;">More info <i class="fas fa-arrow-circle-right"></i></a></div></div>';
                  for(var i=0; i<reportBtn.length; i++){  
                      var calPer = (reportBtn[i].totalValueNow*100) /reportBtn[i].totalOnyers.toFixed(2) ;
                      if(calPer >= 1){
                          var calPer = calPer.toFixed(0);
                      }else{
                          var calPer = calPer.toFixed(2);
                      }
                      var passcalPer = 0;
                      var growPer = '';
                      if(reportBtn[i].totoalValuePass == 0 || reportBtn[i].totoalValuePass == null){
                          passcalPer = 100;
                      }else{
                          var passcalPer = ((reportBtn[i].totalValueNow - reportBtn[i].totoalValuePass)/reportBtn[i].totoalValuePass)*100 ;
                          console.log(passcalPer);
                          passcalPer = passcalPer.toFixed(0);
                      }
                      if(passcalPer > 1){
                        growPer = '<p>อัตราการเติบโต : <h5 style="color:green;text-align:right;right:30%;top: 64%;position: absolute;"><i class="fas fa-arrow-up"></i>  '+passcalPer+' %</h5></p>';
                      }else if (passcalPer == 0){
                        growPer = '<p>อัตราการเติบโต : <h5 style="color:yellow;text-align:right;right:30%;top: 64%;position: absolute;"><i class="fas fa-equals"></i>  '+passcalPer+' %</h5></p>';
                      }else{
                        growPer = '<p>อัตราการเติบโต : <h5 style="color:red;text-align:right;right:30%;top: 64%;position: absolute;"><i class="fas fa-arrow-down"></i>  '+(passcalPer)*-1+' %</h5></p>';
                      }
    
                      if(i == 0){
                          data += '<div class="col-lg-6 col-6">';
                          data += '<div class="small-box bg-info">';
                          data += '<div class="inner">';
                          data += '<p>'+reportBtn[i].areaType+'</p>'
                          data += '<h3>'+numberWithCommas(reportBtn[i].totalValueNow)+' บาท</h3>';
                          data += '<div class="mb-0">'
                          data += '<p>ส่วนแบ่งการตลาด : <h5 style="text-align:right;right:30%;top: 46%;position: absolute;">'+calPer+' %</h5></p>'
                          data += growPer;
                          data += '</div>';
                          data += '</div>';
                          data += '<a href="javascript:reportNewF.a1_onclick('+reportBtn[i].target_area_type_id+');" id="basin_'+reportBtn[i].target_area_type_id+'" class="small-box-footer basins">More info <i class="fas fa-arrow-circle-right"></i></a></div></div>';
                      }else{
                          if(i%5 == 0){
                              data += '</div><div class="row">';
                              data += '<div class="col-lg-6 col-6">';
                              data += '<div class="small-box bg-info">';
                              data += '<div class="inner">';
                              data += '<p>'+reportBtn[i].areaType+'</p>';
                              data += '<h3>'+numberWithCommas(reportBtn[i].totalValueNow)+' บาท</h3>';
                              data += '<p>ส่วนแบ่งการตลาด : <h5 style="text-align:right;right:30%;top: 46%;position: absolute;">'+calPer+' %</h5></p>';
                              data += growPer;
                              data += '</div></div>';
                              data += '<a href="javascript:reportNewF.a1_onclick('+reportBtn[i].target_area_type_id+');" id="basin_'+reportBtn[i].target_area_type_id+'" class="small-box-footer basins">More info <i class="fas fa-arrow-circle-right"></i></a></div></div>';
                          }else{
                              data += '<div class="col-lg-6 col-6">';
                              data += '<div class="small-box bg-info">';
                              data += '<div class="inner">';
                              data += '<p>'+reportBtn[i].areaType+'</p>';
                              data += '<h3>'+numberWithCommas(reportBtn[i].totalValueNow)+' บาท</h3>';
                              data += '<p>ส่วนแบ่งการตลาด : <h5 style="text-align:right;right:30%;top: 46%;position: absolute;">'+calPer+' %</h5></p>';
                              data += growPer;
                              data += '</div>';
                              data += '<a href="javascript:reportNewF.a1_onclick('+reportBtn[i].target_area_type_id+');" id="basin_'+reportBtn[i].target_area_type_id+'" class="small-box-footer basins">More info <i class="fas fa-arrow-circle-right"></i></a></div></div>';
                          }
                      }
                  }
                  data += '</div></div>'
                  $("#sectionBtnSelecte").html(data);
            }
        });
    }

    // initChartTotalAgri(yearsId);
    function loadTableTotalMarket(yearsId, basinId, areaId) {
        $("#totalMarket tbody").html("");
        $("#totalMarket thead").html("");
        $.ajax({
            url:"../util/totalMarketReportFP.php",
            method:"POST",
            data:{yearsId:yearsId, basinId:basinId, areaId: areaId},
            dataType:"text",
            success:function(data){
                report = JSON.parse(data);
                console.log(report[0].test);
                $("#totalMarket thead").html(report[0].thaedRow);
                $("#totalMarket tbody").html(report[0].row);
            }
        });
    }
    initChartTotalSale(yearsId, basinId, areaId);
    initBarChartAgriMarket(yearsId, basinId, areaId);
    initBarChartMonthy(yearsId, basinId, areaId);
    initChartMarketTotal(yearsId, basinId, areaId);
    initChartPlanAndSale(yearsId, basinId, areaId);
    // initBarChartAgrBasin(yearsId, basinId, areaId);
    loadTableBATotalMarket(yearsId, basinId);
    function loadTableBATotalMarket(yearsId, basinId) {
        $("#totalBasinMarket tbody").html("");
        $.ajax({
            url:"../util/totalBasinMarketReportP.php",
            method:"POST",
            data:{yearsId:yearsId, basinId: basinId},
            dataType:"text",
            success:function(data){
                $("#totalBasinMarket tbody").html(data);
            }
        });
    }

    function initChartPlanAndSale (yearsId, basinId, areaId){
        $.ajax({
            url:"../util/loadPlanAndSaleFP.php",
            method:"POST",
            data:{yearsId:yearsId, basinId:basinId, areaId: areaId},
            dataType:"text",
            success:function(data){
                report = JSON.parse(data);
                console.log(report);
            },complete:function(){
                var labelPM = [];
                var totalvaluePM = [];
                var totalVolumnPM = [];
                for(var i=0;i<report.length;i++){
                    labelPM.push(report[i].name);
                    totalvaluePM.push(report[i].totalSale?report[i].totalSale:0);
                    totalVolumnPM.push(report[i].totalPlan?report[i].totalPlan:0);
                }
                myChartplanAndSale = new Chart( planAndSale, {
                    type: 'bar',
                    data: {
                        labels: labelPM,
                        datasets: [{
                            type: 'line',
                            data: totalvaluePM,
                            label: "ส่งมอบ",
                            borderColor: "orange",
                            borderWidth: "0",
                            backgroundColor: "orange",
                            fill: false,
                            datalabels: {
                                align: 'top',
                                useHTML: true,
                                enabled: true,
                                formatter: (value, context) => {
                                    var zero = 0
                                    var calPer = ((totalvaluePM[context.dataIndex]*100) /totalVolumnPM[context.dataIndex].toFixed(2))-100
                                    if(calPer >= 1){
                                        var calPer = calPer.toFixed(0);
                                    }else{
                                        var calPer = calPer.toFixed(2);
                                    }
                                    if(calPer > 1){
                                        return '+'+calPer+' %';
                                        // return '<i class="fas fa-arrow-up"></i>  '+calPer+' %';
                                    }else if(calPer == 0){
                                        return calPer+' %';
                                        // return '<i class="fas fa-equals"></i>  '+calPer+' %'
                                    }else{
                                        return calPer+' %';
                                        // return '<i class="fas fa-arrow-down"></i>  '+(calPer)*-1+' %';
                                    }
                                },
                                font: {
                                    family: 'Arial',
                                    size: '14',
                                    weight: 'bold',
                                },
                                color: function(context) {
                                    var calPer = ((totalvaluePM[context.dataIndex]*100) /totalVolumnPM[context.dataIndex].toFixed(2))-100
                                    if(calPer > 1){
                                        return 'green';
                                    }else if(calPer == 0){
                                        return 'yellow';
                                    }else{
                                        return 'red';
                                    }
                                }
                            }
                        },{
                            data: totalVolumnPM,
                            label: "เป้าหมาย",
                            borderColor: "#caf270",
                            borderWidth: "0",
                            backgroundColor: "#caf270",
                            fill: false,
                            datalabels: {
                                display: false
                            }
                        }]
                    },options: {
                        tooltips: {
                            displayColors: true,
                            callbacks:{
                                label: function(t, d) {
                                var xLabel = d.datasets[t.datasetIndex].label;
                                return xLabel + ': ' + numberWithCommas(t.yLabel);
                                }
                            },
                        },
                        plugins: {
                            datalabels: {
                                anchor: 'end',
                                offset: 8,
                            }
                          },
                        scales: {
                            xAxes: [{
                            stacked: true,
                            gridLines: {
                                display: false,
                            },
                            ticks: {
                                autoSkip: false,
                                maxRotation: 90,
                                minRotation: 90
                            }
                            }],
                            yAxes: [{
                            stacked: true,
                            ticks: {
                                beginAtZero: true,
                                        callback: function(value, index, values) {
                                          return numberWithCommas(value);
                                        }
                            },
                            type: 'linear',
                            }]
                        },
                        responsive: true,
                        maintainAspectRatio: false,
                        legend: { position: 'top' },
                        }
                });
            }
        });
    }

    function initBarChartAgrBasin (yearsId, basinId, areaId) {
        if(basinId == '0'){
            $("#cardHeaderMarketChart").html("สัดส่วนร้อยละมูลค่าส่งมอบผลผลิตของโครงการ  ");
        }else{
            $("#cardHeaderMarketChart").html("สัดส่วนร้อยละมูลค่าส่งมอบผลผลิตของพื้นที่ จำแนกตามช่องทางการตลาด");
        }
        $.ajax({
            url:"../util/reportAgriMarketF.php",
            method:"POST",
            data:{yearsId:yearsId, basinId:basinId, areaId: areaId},
            dataType:"text",
            success:function(data){
                report = JSON.parse(data);
                console.log(report);
            },complete:function(){
                var label = [];
                var dataSet1 = [];
                var dataSet2 = [];
                var dataSet3 = [];
                var dataSet4 = [];
                var dataSet5 = [];
                var dataSet6 = [];
                for(var i=0;i<report.length;i++){
                    label.push(report[i].name);
                    dataSet1.push(report[i].data2?report[i].data2:0);
                    dataSet2.push(report[i].data3?report[i].data3:0);
                    dataSet3.push(report[i].data4?report[i].data4:0);
                    dataSet4.push(report[i].data5?report[i].data5:0);
                    dataSet5.push(report[i].data6?report[i].data6:0);
                    dataSet6.push(report[i].data7?report[i].data7:0);
                }
                myChartAgriAndBasin = new Chart( ctxAgriAndBasin, {
                    type: 'bar',
                    data: {
                        labels : label,
                        datasets: [{
                            label: 'ตลาดข้อตกลง',
                            backgroundColor: "#caf270",
                            data: dataSet1,
                        },{
                            label: 'ตลาดโครงการหลวง',
                            backgroundColor: "#45c490",
                            data: dataSet2,
                        }, {
                            label: 'ตลาดอุทยานหลวงฯ',
                            backgroundColor: "#008d93",
                            data: dataSet3,
                        }, {
                            label: 'บริโภค',
                            backgroundColor: "#2e5468",
                            data: dataSet4,
                        },{
                            label: 'ตลาดท้องถิ่น',
                            backgroundColor: "#FF7F50",
                            data: dataSet5,
                        },{
                            label: 'ตลาดออนไลน์',
                            backgroundColor: "#6495ED",
                            data: dataSet6,
                        }],
                    },options: {
                        tooltips: {
                            displayColors: true,
                            callbacks:{
                            mode: 'x',
                            },
                        },
                        plugins: {
                            datalabels: {
                              display: false
                            }
                          },
                        scales: {
                            xAxes: [{
                            stacked: true,
                            gridLines: {
                                display: false,
                            },
                            ticks: {
                                autoSkip: false,
                                maxRotation: 25,
                                minRotation: 25
                            }
                            }],
                            yAxes: [{
                            stacked: true,
                            ticks: {
                                beginAtZero: true,
                                callback: function(value, index, values) {
                                    return numberWithCommas(value);
                                }
                            },
                            type: 'linear',
                            }]
                        },
                        responsive: true,
                        maintainAspectRatio: false,
                        legend: { position: 'top' },
                        }
                });
            }
        });
    }

    function initChartMarketTotal(yearsId, basinId, areaId) {
        $.ajax({
            url:"../util/reportTotalMarketPieFP.php",
            method:"POST",
            data:{yearsId:yearsId, basinId:basinId, areaId: areaId},
            dataType:"text",
            success:function(data){
                report = JSON.parse(data);
                // console.log(report);
            },complete:function(){
                console.log(report);
                if(basinId == '0'){
                    $("#cardHeaderMarketPie").html("สัดส่วนร้อยละมูลค่าส่งมอบผลผลิตของโครงการ จำแนกรายสาขาพืช");
                }else{
                    $("#cardHeaderMarketPie").html("สัดส่วนร้อยละมูลค่าส่งมอบผลผลิตของโครงการ  ["+report[0].display+"] จำแนกรายสาขาพืช");
                }
                var labelPM=[];
                var volumnPM=[];
                var labelPMs = [];
                var alltotalValue = 0;
                var coloR = [];
                var otherValue = 0;
                for(var i=0;i<report.length;i++){
                    if(report[i].totalValue > 0){
                        if(i< 5){
                            labelPM.push(report[i].name);
                            volumnPM.push(report[i].totalValue);
                            coloR.push(dynamicColors());
                        }else{
                            otherValue += report[i].totalValue?report[i].totalValue:0;
                        }
                        // labelPM.push(report[i].name);
                        // volumnPM.push(report[i].totalValue);
                        // coloR.push(dynamicColors());
                        alltotalValue +=report[i].totalValue?report[i].totalValue:0;
                        
                    }
                }
                if(otherValue != 0){
                    labelPM.push("รวมอื่นๆ");
                    volumnPM.push(otherValue);
                    coloR.push(dynamicColors());
                }
                // for(var i=0;i<report.length;i++){
                //     if(report[i].totalValue > 0){
                //         labelPM.push(report[i].name);
                //         volumnPM.push(report[i].totalValue);
                //         alltotalValue +=report[i].totalValue?report[i].totalValue:0;
                //         coloR.push(dynamicColors());
                //     }
                // }
                for(var x=0;x<labelPM.length;x++){
                    var calPer = (volumnPM[x]*100) /alltotalValue.toFixed(2) ;
                    if(calPer >= 1){
                        var calPer = calPer.toFixed(0);
                    }else{
                        var calPer = calPer.toFixed(2);
                    }
                    labelPMs.push(labelPM[x] +' ('+calPer+'%)');
                }

                myChartMarketTotal = new Chart( ctxMarketTotal, {
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
                                            ],
                            hoverBackgroundColor: [
                                "rgba(138, 223, 226, 1)",
                                "rgba(85, 197, 209, 1)",
                                "rgba(70, 153, 195, 1)",
                                "rgba(255, 214, 126, 1)",
                                "rgba(247, 156, 101, 1)",
                                "rgba(252, 132, 118, 1)",
                            ]
                        }]
                    },
                    options: {
                        tooltips: {
                            callbacks: {
                                label: function(t, d) {
                                    var Label = d.datasets[0].data[t.index];
                                    var xLabel = d.labels[t.index];
                                    var calPer = (Label*100) /alltotalValue.toFixed(2) ;
                                    if(calPer >= 1){
                                        var calPer = calPer.toFixed(0);
                                    }else{
                                        var calPer = calPer.toFixed(2);
                                    }
                                    return xLabel + ': ' + numberWithCommas(Label)+' ('+calPer+'%)';
                                }
                            }
                        },
                        responsive: true
                        ,plugins: {
                            datalabels: {
                              formatter: (value, ctx) => {
                                var zero = 0
                                var calPer = (value*100) /alltotalValue.toFixed(2) ;
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
                    }
                }  );
            }
        });
    }

    function initBarChartMonthy(yearsId, basinId, areaId) {
        $("#totalMonthy tbody").html("");
        $("#totalMonthy thead").html("");
        $.ajax({
            url:"../util/reportTotalMonthyFP.php",
            method:"POST",
            data:{yearsId:yearsId, basinId:basinId, areaId: areaId},
            dataType:"text",
            success:function(data){
                report = JSON.parse(data);
                console.log(report);
                $("#totalMonthy thead").html(report[0].thaedRow);
                $("#totalMonthy tbody").html(report[0].row);
            }
        });
        document.getElementById("waitSelect").style.display = "block";
        $.ajax({
            url:"../util/reportTotalMonthyFBP.php",
            method:"POST",
            data:{yearsId:yearsId, basinId:basinId, areaId: areaId},
            dataType:"text",
            success:function(data){
                report = JSON.parse(data);
                console.log(report);
            },complete:function(){
                if(basinId !='0'){
                    $("#headerMonthyFB").html("มูลค่าเป้าหมายและส่งมอบผลผลิตของโครงการ  ["+report[0].name+"] จำแนกรายเดือน");
                }else{
                    $("#headerMonthyFB").html("มูลค่าเป้าหมายและส่งมอบผลผลิตของโครงการ จำแนกรายเดือน");
                }
                var label = [];
                var dataSet1 = [];
                var dataSet2 = [];
                var theader = '<th></th>';
                var rowPlan = "<td>เป้าหมาย</td>";
                var rowSale = "<td>ผลผลิต</td>";
                for(var i=0;i<report.length;i++){
                    theader += "<th>"+report[i].Month_Etc+"</th>";
                    label.push(report[i].Month_Etc);
                    rowPlan += "<td style='text-align: right'>"+numberWithCommas(report[i].totalPlan?report[i].totalPlan:0)+"</td>";
                    rowSale += "<td style='text-align: right'>"+numberWithCommas(report[i].totalSale?report[i].totalSale:0)+"</td>";
                    dataSet1.push(parseInt(report[i].totalPlan?report[i].totalPlan:0));
                    dataSet2.push(parseInt(report[i].totalSale?report[i].totalSale:0));
                }
                $("#totalMonthyFB thead").html(theader);
                $("#totalMonthyFB tbody").html("<tr>"+rowPlan+"</tr><tr>"+rowSale+"</tr>");
                console.log(theader);
                myChartMonthy = new Chart( ctxMonthy, {
                    type: "line",
                    data: {
                        labels : label,
                        datasets: [
                            {
                                fill: false,
                                borderColor: "red",
                                data: dataSet1,
                                label: "เป้าหมาย",
                                datalabels: {
                                    display: false
                                }
                            },
                            {
                                fill: false,
                                borderColor: "blue",
                                data: dataSet2,
                                label: "ส่งมอบ",
                                datalabels: {
                                    align: 'top',
                                    useHTML: true,
                                    enabled: true,
                                    formatter: (value, context) => {
                                        var zero = 0
                                        var calPer = ((dataSet2[context.dataIndex]*100) /dataSet1[context.dataIndex].toFixed(2))-100
                                        if(calPer >= 1){
                                            var calPer = calPer.toFixed(0);
                                        }else{
                                            var calPer = calPer.toFixed(2);
                                        }
                                        if(calPer > 1){
                                            return '+'+calPer+' %';
                                            // return '<i class="fas fa-arrow-up"></i>  '+calPer+' %';
                                        }else if(calPer == 0){
                                            return calPer+' %';
                                            // return '<i class="fas fa-equals"></i>  '+calPer+' %'
                                        }else{
                                            return calPer+' %';
                                            // return '<i class="fas fa-arrow-down"></i>  '+(calPer)*-1+' %';
                                        }
                                    },
                                    font: {
                                        family: 'Arial',
                                        size: '14',
                                        weight: 'bold',
                                    },
                                    color: function(context) {
                                        var calPer = ((dataSet2[context.dataIndex]*100) /dataSet1[context.dataIndex].toFixed(2))-100
                                        if(calPer > 1){
                                            return 'green';
                                        }else if(calPer == 0){
                                            return 'yellow';
                                        }else{
                                            return 'red';
                                        }
                                    }
                                }
                            }
                        ]
                    },options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        tooltips: {
                            mode: 'index',
                            intersect: false,
                            callbacks: {
                                label: function(t, d) {
                                var xLabel = d.datasets[t.datasetIndex].label;
                                return xLabel + ': ' + numberWithCommas(t.yLabel);
                                }
                            }
                        },scales: {
                            yAxes: [{
                              display: true,
                              scaleLabel: {
                                display: true,
                              },ticks: {
                                callback: function(value, index, values) {
                                  return numberWithCommas(value);
                                }
                              }
                            }]
                        },plugins: {
                            datalabels: {
                                anchor: 'end',
                                offset: 8,
                            }
                        },
                    }
                });
            }
        });
    }

    function initChartTotalSale(yearsId, basinId, areaId) {
        if(basinId == '0'){
            $("#cardHeaderPieChart").html("สัดส่วนร้อยละมูลค่าส่งมอบผลผลิตของโครงการ");
        }else{
            $("#cardHeaderPieChart").html("สัดส่วนร้อยละมูลค่าส่งมอบผลผลิตของแต่ละพื้นที่ในโครงการ");
        }
        $.ajax({
            url:"../util/reportTotalSaleP.php",
            method:"POST",
            data:{yearsId:yearsId, basinId:basinId, areaId: areaId},
            dataType:"text",
            success:function(data){
                report = JSON.parse(data);
                // console.log(report);
            },complete:function(){
                // console.log(report);
                var labelPM=[];
                var labelPMs = [];
                var volumnPM=[];
                var alltotalValue = 0;
                var coloR = [];
                var otherValue = 0;
                for(var i=0;i<report.length;i++){
                    if(report[i].totalValue > 0){
                        if(i< 5){
                            labelPM.push(report[i].name);
                            volumnPM.push(report[i].totalValue);
                            coloR.push(dynamicColors());
                        }else{
                            otherValue += report[i].totalValue?report[i].totalValue:0;
                        }
                        // labelPM.push(report[i].name);
                        // volumnPM.push(report[i].totalValue);
                        // coloR.push(dynamicColors());
                        alltotalValue +=report[i].totalValue?report[i].totalValue:0;
                        
                    }
                }
                if(otherValue != 0){
                    labelPM.push("รวมอื่นๆ");
                    volumnPM.push(otherValue);
                    coloR.push(dynamicColors());
                }
                for(var x=0;x<labelPM.length;x++){
                    var calPer = (volumnPM[x]*100) /alltotalValue.toFixed(2) ;
                    if(calPer >= 1){
                        var calPer = calPer.toFixed(0);
                    }else{
                        var calPer = calPer.toFixed(2);
                    }
                    labelPMs.push(labelPM[x] +' ('+calPer+'%)');
                }

                myChartTotalSale = new Chart( ctxTotalSale, {
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
                                            ],
                            hoverBackgroundColor: [
                                "rgba(138, 223, 226, 1)",
                                "rgba(85, 197, 209, 1)",
                                "rgba(70, 153, 195, 1)",
                                "rgba(255, 214, 126, 1)",
                                "rgba(247, 156, 101, 1)",
                                "rgba(252, 132, 118, 1)",
                            ]
                        }]
                    },
                    options: {
                        tooltips: {
                            callbacks: {
                                label: function(t, d) {
                                    var Label = d.datasets[0].data[t.index];
                                    var xLabel = d.labels[t.index];
                                    var calPer = (Label*100) /alltotalValue.toFixed(2) ;
                                    if(calPer >= 1){
                                        var calPer = calPer.toFixed(0);
                                    }else{
                                        var calPer = calPer.toFixed(2);
                                    }
                                    return xLabel + ': ' + numberWithCommas(Label)+' ('+calPer+'%)';
                                }
                            }
                        },
                        responsive: true
                        ,plugins: {
                            datalabels: {
                              formatter: (value, ctx) => {
                                var zero = 0
                                var calPer = (value*100) /alltotalValue.toFixed(2) ;
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
                    }
                }  );
            }
        });
    }

    function initBarChartAgriMarket(yearsId, basinId, areaId) {
        if(basinId == '0'){
            $("#cardHeaderMarketChart").html("มูลค่าส่งมอบผลผลิตของโครงการ จำแนกตามช่องทางการตลาด");
        }else{
            $("#cardHeaderMarketChart").html("สัดส่วนมูลค่าส่งมอบผลผลิตของพื้นที่ จำแนกตามช่องทางการตลาด");
        }
        $.ajax({
            url:"../util/reportAgriMarketFP.php",
            method:"POST",
            data:{yearsId:yearsId, basinId:basinId, areaId: areaId},
            dataType:"text",
            success:function(data){
                console.log(data);
                report = JSON.parse(data);
                console.log(report);
            },complete:function(){
                var label = [];
                var dataSet1 = [];
                var dataSet2 = [];
                var dataSet3 = [];
                var dataSet4 = [];
                var dataSet5 = [];
                var dataSet6 = [];
                for(var i=0;i<report.length;i++){
                    label.push(report[i].name);
                    dataSet1.push(report[i].data2?report[i].data2:0);
                    dataSet2.push(report[i].data3?report[i].data3:0);
                    dataSet3.push(report[i].data4?report[i].data4:0);
                    dataSet4.push(report[i].data5?report[i].data5:0);
                    dataSet5.push(report[i].data6?report[i].data6:0);
                    dataSet6.push(report[i].data7?report[i].data7:0);
                }
                myChartAgriMarket = new Chart( ctxAgriMarket, {
                    type: 'bar',
                    data: {
                        labels : label,
                        datasets: [{
                            label: 'ตลาดข้อตกลง',
                            backgroundColor: "rgba(138, 223, 226, 1)",
                            data: dataSet1,
                        },{
                            label: 'ตลาดโครงการหลวง',
                            backgroundColor: "rgba(85, 197, 209, 1)",
                            data: dataSet2,
                        }, {
                            label: 'ตลาดอุทยานหลวงฯ',
                            backgroundColor: "rgba(70, 153, 195, 1)",
                            data: dataSet3,
                        }, {
                            label: 'บริโภค',
                            backgroundColor: "rgba(255, 214, 126, 1)",
                            data: dataSet4,
                        },{
                            label: 'ตลาดท้องถิ่น',
                            backgroundColor: "rgba(247, 156, 101, 1)",
                            data: dataSet5,
                        },{
                            label: 'ตลาดออนไลน์',
                            backgroundColor: "rgba(252, 132, 118, 1)",
                            data: dataSet6,
                        }],
                    },options: {
                        tooltips: {
                            displayColors: true,
                            callbacks:{
                            mode: 'x',
                            },
                        },plugins: {
                            datalabels: {
                              display: false
                            }
                          },
                        scales: {
                            xAxes: [{
                            stacked: true,
                            gridLines: {
                                display: false,
                            },
                            ticks: {
                                autoSkip: false,
                                maxRotation: 25,
                                minRotation: 25
                            }
                            }],
                            yAxes: [{
                            stacked: true,
                            ticks: {
                                beginAtZero: true,
                                callback: function(value, index, values) {
                                    return numberWithCommas(value);
                                }
                            },
                            type: 'linear',
                            }]
                        },
                        responsive: true,
                        maintainAspectRatio: false,
                        legend: { position: 'top' },
                        }
                });
            }
        });
    }
    reportNewF.a1_onclick = function($id){ 
        console.log($id);
        yearsId = $("#yearsOfPlan").val();
        basinId = $("#basinId").val();
        areaId = $("#areaId").val();
        $('.basins').removeClass('active');
        jQuery('#basin_'+$id).addClass('active');
        if(basinId != $id) {
            $("#basinId").val($id);
            basinId = $id
            if(myChartTotalSale != undefined)
            myChartTotalSale.destroy();

            if(myChartMarket != undefined)
            myChartMarket.destroy();

            if(myChartAgriMarket != undefined)
            myChartAgriMarket.destroy();

            if(myChartMonthy != undefined)
            myChartMonthy.destroy();

            if(myChartMarketTotal != undefined)
            myChartMarketTotal.destroy();

            if(myChartplanAndSale != undefined)
            myChartplanAndSale.destroy();

            loadTableBATotalMarket(yearsId, basinId);
            loadTableTotalMarket(yearsId, basinId, areaId);
            initChartTotalSale(yearsId, basinId, areaId);
            initBarChartAgriMarket(yearsId, basinId, areaId);
            initBarChartMonthy(yearsId, basinId, areaId);
            initChartMarketTotal(yearsId, basinId, areaId);
            initChartPlanAndSale(yearsId, basinId, areaId);
        }
    }
    function toMoney(n) {
        return n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
    }
    function numberWithCommas(x) {
        x = x.toFixed(0);
        var pattern = /(-?\d+)(\d{3})/;
        while (pattern.test(x))
            x = x.replace(pattern, "$1,$2");
        return x;
    }

    function dynamicColors() {
        var r = Math.floor(Math.random() * 255);
        var g = Math.floor(Math.random() * 255);
        var b = Math.floor(Math.random() * 255);
        return "rgb(" + r + "," + g + "," + b + ")";
    };

    function exportTableToExcel(tableID, filename){
        var downloadLink;
        var dataType = 'application/vnd.ms-excel';
        var tableSelect = document.getElementById(tableID);
        var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
    
        // Specify file name
        filename = filename?filename+'.xls':'excel_data.xls';
    
        // Create download link element
        downloadLink = document.createElement("a");
    
        document.body.appendChild(downloadLink);
    
        if(navigator.msSaveOrOpenBlob){
            var blob = new Blob(['\ufeff', tableHTML], {
                type: dataType
            });
            navigator.msSaveOrOpenBlob( blob, filename);
        }else{
            // Create a link to the file
            downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
    
            // Setting the file name
            downloadLink.download = filename;
    
            //triggering the function
            downloadLink.click();
        }
    }

})(jQuery);