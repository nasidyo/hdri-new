(function ($) {

    var ctxAgri = document.getElementById("totalAgri-chart-canvas");
    var myChartAgri;

    var ctxMonthy = document.getElementById("monthy-chart-canvas");
    ctxMonthy.height = 500;
    var myChartMonthy;

    var ctxPersonA = document.getElementById("personTypeAgri-chart-canvas");
    var myChartPersonA;

    var ctxPersonS = document.getElementById("personTypeStand-chart-canvas");
    var myChartPersonS;

    // var nextMonthlineCtx = document.getElementById("nextMonthline-chart-canvas");
    // nextMonthlineCtx.height = 50;
    // var myChartNextMonthlineCtx;

    $('#excel_totalMarket').click(function(){
        exportTableToExcel("totalMarket", "มูลค่าการส่งมอบผลผลิตของพื้นที่");
    });

    var yearsId = $("#yearsId").val();
    var area_Id = $("#area_Id").val();
    initTotalDashBoard(yearsId, area_Id);
    loadTableTotalMarket(yearsId, area_Id);
    initSalePerson(yearsId, area_Id);
    initChartTotalAgri(yearsId , area_Id);
    initBarChartMonthy(yearsId, area_Id);

    initBarChartPersonA(yearsId, area_Id);
    initBarChartPersonS(yearsId, area_Id);
    // initlineChartNextMonth(area_Id);

    function initlineChartNextMonth(area_Id){
        var d = new Date();
        var month = d.getMonth()+1;
        var years = (d.getFullYear()+543);
        $.ajax({
            url:"../util/reportNextMonthPriceArea.php",
            method:"POST",
            data:{yearsId:years, area_Id:area_Id, month:month},
            dataType:"text",
            success:function(data){
                // console.log(data);
                report = JSON.parse(data);
                // console.log(report);
            },complete:function(){
                // console.log(labelPM);
                // console.log(volumnPM);
                var labelPM=[];
                var volumnPM=[];
                var colors=[];
                var sumPrice = 0;
                var xxx = 0;
                for(var i=report.length-1;i>=0;i--){
                    labelPM.push(report[i].Month_name);
                    // console.log(report[i].avgVolumn);
                    if(report[i].avgVolumn != null){
                        xxx++;
                    }
                    colors.push("red");
                    volumnPM.push(report[i].avgVolumn?report[i].avgVolumn:0);
                    sumPrice +=report[i].avgVolumn?report[i].avgVolumn:0;
                }
                priceNextMonth = (sumPrice/xxx);
                $.ajax({
                    url:"../util/loadMonthName.php",
                    method:"POST",
                    data:{monthId:month+1},
                    dataType:"text",
                    success:function(data){
                        // console.log(data);
                        labelPM.push(data);
                        volumnPM.push(priceNextMonth);
                        colors.push("orange");
                    },complete:function(){
                        // console.log(labelPM);
                        // console.log(volumnPM);
                        const data = volumnPM.map((value, index) => ( { x: index + 1, xL: labelPM[index], y: value, color: colors[index]} ));
                        // console.log(data);
                        myChartNextMonthlineCtx = new Chart( nextMonthlineCtx, {
                        type: "scatter",
                        plugins: [{
                            beforeDraw: chart => {
                            var ctx = chart.chart.ctx; 
                            var xAxis = chart.scales['x-axis-1'];
                            var yAxis = chart.scales['y-axis-1'];
                            chart.config.data.datasets[0].data.forEach((value, index) => {
                                if (index > 0) {
                                    var valueFrom = data[index - 1];
                                    var xFrom = xAxis.getPixelForValue(valueFrom.x);
                                    var yFrom = yAxis.getPixelForValue(valueFrom.y);
                                    var xTo = xAxis.getPixelForValue(value.x);
                                    var yTo = yAxis.getPixelForValue(value.y);
                                    ctx.save();
                                    ctx.strokeStyle = value.color;
                                    ctx.lineWidth = 2;
                                    ctx.beginPath();
                                    ctx.moveTo(xFrom, yFrom);
                                    ctx.lineTo(xTo, yTo);
                                    ctx.stroke();
                                    ctx.restore();
                                }
                            });      
                            }
                        }],
                        data: {
                            datasets: [{
                                label: "My Dataset",
                                data: data,
                                borderColor: "black"
                            }],
                            labels: labelPM,
                        },
                        options: {
                            animation: {
                            duration: 0
                            },
                            legend: {
                            display: false
                            },
                            tooltips: {
                                mode: 'index',
                                intersect: false,
                                callbacks: {
                                    label: function(t, d) {
                                    var xLabel = d.labels[t.index];
                                    return xLabel + ': ' + numberWithCommas(t.yLabel);
                                    }
                                }
                            },plugins: {
                                datalabels: {
                                  display: false
                                }
                              },
                            scales: {
                                xAxes: [{
                                    ticks: {
                                        stepSize: 1,
                                        userCallback: function(label, index, labels) {
                                            // console.log(label ,"|||",index,"||",labelPM)
                                            var xLable = labelPM[index];
                                            return xLable;
                                        }
                                    }
                                }],
                            }
                        }  
                        });
                        
                    }
                });
            }
        });
    }

    function initSalePerson(yearsId, area_Id) {
        $("#salePerson").html("");
        $.ajax({
            url:"../util/reportSalesPersonArea.php",
            method:"POST",
            data:{yearsId:yearsId, area_Id: area_Id},
            dataType:"text",
            success:function(data){
            //   console.log(data);
                $("#salePerson").html(data);
            }
        });
    }
    function initBarChartPersonS(yearsId, area_Id) {
        $.ajax({
            url:"../util/reportTotalPersonAreaS.php",
            method:"POST",
            data:{yearsId:yearsId, area_Id: area_Id},
            dataType:"text",
            success:function(data){
                // console.log(data);
                report = JSON.parse(data);
            },complete:function(){
                // console.log(report);
                var labelPM=[];
                var labelPMs =[];
                var volumnPM=[];
                var alltotalValue = 0;
                for(var i=0;i<report.length;i++){
                    if(report[i].TotalValue > 0){
                        labelPM.push(report[i].nameTypeOfArgi);
                        volumnPM.push(report[i].TotalValue);
                        alltotalValue +=report[i].TotalValue?report[i].TotalValue:0;
                    }
                }
                for(var x=0;x<labelPM.length;x++){
                    var calPer = (report[x].TotalValue*100) /alltotalValue.toFixed(2) ;
                    if(calPer >= 1){
                        var calPer = calPer.toFixed(0);
                    }else{
                        var calPer = calPer.toFixed(2);
                    }
                    labelPMs.push(labelPM[x] +' ('+calPer+'%)');
                }
                myChartPersonS = new Chart( ctxPersonS, {
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
                                    return xLabel + ': ' + numberWithCommas(Label)+'คน ('+calPer+'%)';
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
    function initBarChartPersonA(yearsId, area_Id) {
        $.ajax({
            url:"../util/reportTotalPersonAreaA.php",
            method:"POST",
            data:{yearsId:yearsId, area_Id: area_Id},
            dataType:"text",
            success:function(data){
                // console.log(data);
                report = JSON.parse(data);
            },complete:function(){
                // console.log(report);
                var labelPM=[];
                var labelPMs = [];
                var volumnPM=[];
                var alltotalValue = 0;
                var otherValue = 0;
                for(var i=0;i<report.length;i++){
                    if(report[i].TotalValue > 0){
                        if(labelPM.length < 5){
                            labelPM.push(report[i].nameTypeOfArgi);
                            volumnPM.push(report[i].TotalValue);
                        }else{
                            otherValue +=report[i].TotalValue?report[i].TotalValue:0;
                        }
                        alltotalValue +=report[i].TotalValue?report[i].TotalValue:0;
                    }
                }
                if(otherValue != 0){
                    labelPM.push("รวมอื่นๆ");
                    volumnPM.push(otherValue);
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
                myChartPersonA = new Chart( ctxPersonA, {
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
                                        } ]
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
                                    return xLabel + ': ' + numberWithCommas(Label)+'คน ('+calPer+'%)';
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

    function initBarChartMonthy(yearsId, area_Id) {
        $.ajax({
            url:"../util/reportTotalMonthyArea.php",
            method:"POST",
            data:{yearsId:yearsId, area_Id: area_Id},
            dataType:"text",
            success:function(data){
                report = JSON.parse(data);
                // console.log(report);
            },complete:function(){
                var label = [];
                var dataSet1 = [];
                var dataSet2 = [];
                var theader = '<th></th>';
                var rowPlan = "<td>เป้าหมาย</td>";
                var rowSale = "<td>ส่งมอบ</td>";
                for(var i=0;i<report.length;i++){
                    theader += "<th>"+report[i].Month_Etc+"</th>";
                    label.push(report[i].Month_Etc);
                    rowPlan += "<td style='text-align: right'>"+numberWithCommas(report[i].totalPlan?report[i].totalPlan:0)+"</td>";
                    rowSale += "<td style='text-align: right'>"+numberWithCommas(report[i].totalSale?report[i].totalSale:0)+"</td>";
                    dataSet1.push(parseInt(report[i].totalPlan?report[i].totalPlan:0));
                    dataSet2.push(parseInt(report[i].totalSale?report[i].totalSale:0));
                }
                $("#totalMonthy thead").html(theader);
                $("#totalMonthy tbody").html("<tr>"+rowPlan+"</tr><tr>"+rowSale+"</tr>");
                // console.log(theader);
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
                                        // console.log(dataSet1[context.dataIndex] ,"::::", dataSet2[context.dataIndex]);
                                        if(dataSet1[context.dataIndex] == 0 && dataSet1[context.dataIndex] == 0){
                                            var calPer = 0;
                                        }else {
                                            var calPer = ((dataSet2[context.dataIndex]*100) /dataSet1[context.dataIndex].toFixed(2))-100;
                                        }
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
                                        var calPer = ((dataSet2[context.dataIndex]*100) /dataSet1[context.dataIndex].toFixed(2))-100;
                                            // var calPer = (dataSet2[context.dataIndex] /dataSet1[context.dataIndex].toFixed(2))*100 ;
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
                        plugins: {
                            datalabels: {
                                anchor: 'end',
                                offset: 8,
                            }
                          },
                        tooltips: {
                          mode: 'index',
                          intersect: false,
                          callbacks: {
                              label: function(t, d) {
                                var xLabel = d.datasets[t.datasetIndex].label;
                                return xLabel + ': ' + numberWithCommas(t.yLabel);
                              }
                          }
                        }
                    }
                });
            }
        });
    }

    function initTotalDashBoard(yearsId, area_Id) {
        $("#borderDashboard").html("");
        $.ajax({
            url:"../util/totalDashBoardMarketArea.php",
            method:"POST",
            data:{yearsId:yearsId, area_Id: area_Id},
            dataType:"text",
            success:function(data){
                console.log(data);
                reportBtn = JSON.parse(data);
            },complete:function(data){
                var totalOnyersCheck = 0;
                var totalPassyersCheck = 0;
                for(var x=0; x<reportBtn.length; x++){
                    if(totalOnyersCheck == 0 && reportBtn[x].totalOnyers){
                        totalOnyersCheck = reportBtn[x].totalOnyers;
                    }
                    if(totalPassyersCheck == 0 && reportBtn[x].totalPassyers){
                        totalPassyersCheck = reportBtn[x].totalPassyers;
                    }
                }
                var loopcount = 0;
                if(totalPassyersCheck == 0){
                    passcalPerss = 100;
                }else{
                    var passcalPerss = ((totalOnyersCheck - totalPassyersCheck)/totalPassyersCheck)*100 ;
                    passcalPerss = passcalPerss.toFixed(0);
                }
                if(passcalPerss > 1){
                    passcalPerss = '<p><h5 style="color:green;text-align:right;right:35%;top: 45%;position: absolute;"> อัตราการเติบโต :  <i class="fas fa-arrow-up"></i>  '+passcalPerss+' %</h5></p>';
                }else if (passcalPerss == 0){
                    passcalPerss = '<p><h5 style="color:yellow;text-align:right;right:35%;top: 45%;position: absolute;"> >อัตราการเติบโต : <i class="fas fa-equals"></i>  '+passcalPerss+' %</h5></p>';
                }else{
                    passcalPerss = '<p><h5 style="color:red;text-align:right;right:35%;top: 45%;position: absolute;"> อัตราการเติบโต : <i class="fas fa-arrow-down"></i>  '+(passcalPerss)*-1+' %</h5></p>';
                }
                var data = '<div class="row">';
                data +='<div class="col-lg-3"><div class="small-box bg-info" style="height: 95%;"><div class="inner" style="height: 90%;">';
                data += '<p><h4>มูลค่าการซื้อขายรวม</h4></p>';
                data += '<p><h3>'+numberWithCommas(totalOnyersCheck)+' บาท</h3></p>';
                data += passcalPerss;
                data += '</div></div></div>';
                data +='<div class="col-lg-9">';
                data += '<div class="row">';
                for(var i=0; i<reportBtn.length; i++){  
                    var calPer = (reportBtn[i].totalValueNow*100) /totalOnyersCheck.toFixed(2) ;
                    if(calPer >= 1){
                        var calPer = calPer.toFixed(0);
                    }else{
                        var calPer = calPer.toFixed(2);
                    }
                    var passcalPer = 0;
                    var growPer = '';
                    if(reportBtn[i].totoalValuePass == 0){
                        if(reportBtn[i].totalValueNow == 0){
                            passcalPer = 0;
                        }else{
                            passcalPer = 100;
                        }
                    }else{
                        var passcalPer = ((reportBtn[i].totalValueNow - reportBtn[i].totoalValuePass)/reportBtn[i].totoalValuePass)*100 ;
                        console.log(passcalPer);
                        passcalPer = passcalPer.toFixed(0);
                    }
                    if(passcalPer > 1){
                        growPer = '<p>อัตราการเติบโต : <h5 style="color:green;text-align:right;right:30%;top: 74%;position: absolute;"><i class="fas fa-arrow-up"></i>  '+passcalPer+' %</h5></p>';
                    }else if (passcalPer == 0){
                        growPer = '<p>อัตราการเติบโต : <h5 style="color:yellow;text-align:right;right:30%;top: 74%;position: absolute;">'+passcalPer+' %</h5></p>';
                    }else{
                        growPer = '<p>อัตราการเติบโต : <h5 style="color:red;text-align:right;right:30%;top: 74%;position: absolute;"><i class="fas fa-arrow-down"></i>  '+(passcalPer)*-1+' %</h5></p>';
                    }

                    if(i == 0){
                        data += '<div class="col-lg-4 col-6">';
                        data += '<div class="small-box bg-info">';
                        data += '<div class="inner">';
                        data += '<p>'+reportBtn[i].nameMarket+'</p>'
                        data += '<h3>'+numberWithCommas(reportBtn[i].totalValueNow)+' บาท</h3>';
                        data += '<div class="mb-0">'
                        data += '<p>ส่วนแบ่งการตลาด : <h5 style="text-align:right;right:30%;top: 53%;position: absolute;">'+calPer+' %</h5></p>'
                        data += growPer;
                        data += '</div>';
                        data += '</div></div></div>';
                    }else{
                        if(i%3 == 0){
                            data += '</div><div class="row">';
                            data += '<div class="col-lg-4 col-6">';
                            data += '<div class="small-box bg-info">';
                            data += '<div class="inner">';
                            data += '<p>'+reportBtn[i].nameMarket+'</p>';
                            data += '<h3>'+numberWithCommas(reportBtn[i].totalValueNow)+' บาท</h3>';
                            data += '<p>ส่วนแบ่งการตลาด : <h5 style="text-align:right;right:30%;top: 53%;position: absolute;">'+calPer+' %</h5></p>';
                            data += growPer;
                            data += '</div></div></div>';
                        }else{
                            data += '<div class="col-lg-4 col-6">';
                            data += '<div class="small-box bg-info">';
                            data += '<div class="inner">';
                            data += '<p>'+reportBtn[i].nameMarket+'</p>';
                            data += '<h3>'+numberWithCommas(reportBtn[i].totalValueNow)+' บาท</h3>';
                            data += '<p>ส่วนแบ่งการตลาด : <h5 style="text-align:right;right:30%;top: 53%;position: absolute;">'+calPer+' %</h5></p>';
                            data += growPer;
                            data += '</div></div></div>';
                        }
                    }
                }
                data += '</div></div>'
                $("#borderDashboard").html(data);
            }
        });
    }

    function loadTableTotalMarket(yearsId, area_Id) {
        $("#totalMarket tbody").html("");
        $("#totalMarketTitle").html("");
        $.ajax({
            url:"../util/totalMarketReportArea.php",
            method:"POST",
            data:{yearsId:yearsId, area_Id: area_Id},
            dataType:"text",
            success:function(data){
                $("#totalMarket tbody").html("");
                $("#totalMarketTitle").html("มูลค่าการส่งมอบผลผลิตของพื้นที่ รายสาขาพืช ปีงบประมาณ พ.ศ. "+yearsId+" จำแนกตามช่องทางการตลาด");
                $("#totalMarket tbody").html(data);
            }
        });
    }

    function initChartTotalAgri(yearsId, area_Id) {
        $.ajax({
            url:"../util/reportTotalAgriArea.php",
            method:"POST",
            data:{yearsId:yearsId, area_Id: area_Id},
            dataType:"text",
            success:function(data){
                // console.log(data);
                report = JSON.parse(data);
            },complete:function(){
                // console.log(report);
                var labelPM=[];
                var labelPMs = [];
                var volumnPM=[];
                var alltotalValue = 0;
                var otherValue =0;
                for(var i=0;i<report.length;i++){
                    if(report[i].TotalValue > 0){
                        if(labelPM.length < 5){
                            labelPM.push(report[i].nameTypeOfArgi);
                            volumnPM.push(report[i].TotalValue);
                        }else{
                            otherValue += report[i].TotalValue?report[i].TotalValue:0;
                        }
                        alltotalValue +=report[i].TotalValue?report[i].TotalValue:0;
                    }
                    
                }
                if(otherValue != 0){
                    labelPM.push("รวมอื่นๆ");
                    volumnPM.push(otherValue);
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
                myChartAgri = new Chart( ctxAgri, {
                    type: 'pie',
                    data: {
                        labels:labelPMs,
                        datasets: [ {
                            data: volumnPM,
                            backgroundColor: [
                                "rgba(138, 223, 226, 1)",
                                "rgba(61, 81, 181, 1)",
                                "rgba(70, 153, 195, 1)",
                                "rgba(255, 214, 126, 1)",
                                "rgba(247, 156, 101, 1)",
                                "rgba(252, 132, 118, 1)",
                                "rgba(209, 91, 117, 1)",
                                "rgba(255, 255, 71, 1)",
                                "rgba(255, 99, 255, 1)",
                                "rgba(166, 0, 255, 1)",
                                "rgba(38, 142, 255, 1)"
                                            ],
                            hoverBackgroundColor: [
                                "rgba(138, 223, 226, 1)",
                                "rgba(61, 81, 181, 1)",
                                "rgba(70, 153, 195, 1)",
                                "rgba(255, 214, 126, 1)",
                                "rgba(247, 156, 101, 1)",
                                "rgba(252, 132, 118, 1)",
                                "rgba(209, 91, 117, 1)",
                                "rgba(255, 255, 71, 1)",
                                "rgba(255, 99, 255, 1)",
                                "rgba(166, 0, 255, 1)",
                                "rgba(38, 142, 255, 1)"
                                            ]
                                        } ]
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
                                    return xLabel + ': ' + numberWithCommas(Label)+'บาท ('+calPer+'%)';
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

