if (!window.reportNewF){
    // creating an empty global object
    var reportNewF = {};
}
(function ($) {
    var yearsId = $("#yearsId").val();
    var basinId = $("#basinId").val();
    var areaId = $("#areaId").val();
    document.getElementById("waitSelect").style.display = "none";
    loadTableTotalMarket(yearsId, basinId, areaId);
    loadBtnBasin();

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
        initChartTotalSale(yearsId, basinId, areaId);
        initBarChartAgriMarket(yearsId, basinId, areaId);
        initBarChartMonthy(yearsId, basinId, areaId);
        initChartMarketTotal(yearsId, basinId, areaId);
        initChartPlanAndSale(yearsId, basinId, areaId);
        loadTableBATotalMarket(yearsId, basinId);
    });
    
    function loadBtnBasin() {
        $.ajax({
            url:"../util/loadBtnBasin.php",
            method:"POST",
            dataType:"text",
            success:function(data){
                $('#sectionBtnSelecte').html(data);
            }
        });
    }

    // initChartTotalAgri(yearsId);
    function loadTableTotalMarket(yearsId, basinId, areaId) {
        $("#totalMarket tbody").html("");
        $("#totalMarket thead").html("");
        $("#totalMarketTitle").html("");
        $.ajax({
            url:"../util/totalMarketReportF.php",
            method:"POST",
            data:{yearsId:yearsId, basinId:basinId, areaId: areaId},
            dataType:"text",
            success:function(data){
                report = JSON.parse(data);
                console.log(report[0].test);
                $("#totalMarketTitle").html("มูลค่าการส่งมอบผลผลิตของสถาบัน รายสาขาพืช ปีงบประมาณ พ.ศ. "+yearsId+" จำแนกตามช่องทางการตลาด");
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
    loadTableBATotalMarket(yearsId, basinId);
    function loadTableBATotalMarket(yearsId, basinId) {
        $("#totalBasinMarket tbody").html("");
        $.ajax({
            url:"../util/totalBasinMarketReport.php",
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
            url:"../util/loadPlanAndSaleF.php",
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
                            data: totalvaluePM,
                            label: "ส่งมอบ",
                            borderColor: "rgba(0,0,0,0.09)",
                            borderWidth: "0",
                            backgroundColor: "rgba(0, 123, 255, 0.5)",
                            fill: false,
                        }, {
                            data: totalVolumnPM,
                            label: "เป้าหมาย",
                            borderColor: "rgba(0,0,0,0.09)",
                            borderWidth: "0",
                            backgroundColor: "#28a745",
                            fill: false
                        }]
                    },options: {
                        tooltips: {
                            displayColors: true,
                            callbacks:{
                                label: function(t, d) {
                                var xLabel = d.datasets[t.datasetIndex].label;
                                return xLabel + ': ' + toMoney(t.yLabel);
                                }
                            },
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
            $("#cardHeaderMarketChart").html("สัดส่วนมูลค่าช่องทางการตลาดเปรียบเทียบรายลุ่มน้ำ โดยคิดเป็นร้อยละ");
        }else{
            $("#cardHeaderMarketChart").html("สัดส่วนมูลค่าช่องทางการตลาดเปรียบเทียบรายพื้นที่ โดยคิดเป็นร้อยละ");
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
            url:"../util/reportTotalMarketPieF.php",
            method:"POST",
            data:{yearsId:yearsId, basinId:basinId, areaId: areaId},
            dataType:"text",
            success:function(data){
                report = JSON.parse(data);
                // console.log(report);
            },complete:function(){
                console.log(report);
                if(basinId == '0'){
                    $("#cardHeaderMarketPie").html("สัดส่วนช่องทางการจำหน่ายของทุกลุ่มน้ำ");
                }else{
                    $("#cardHeaderMarketPie").html("สัดส่วนช่องทางการจำหน่ายของลุ่มน้ำ ["+report[0].display+"]");
                }
                var labelPM=[];
                var volumnPM=[];
                var alltotalValue = 0;
                var coloR = [];
                for(var i=0;i<report.length;i++){
                    labelPM.push(report[i].name);
                    volumnPM.push(report[i].totalValue);
                    alltotalValue +=report[i].totalValue?report[i].totalValue:0;
                    coloR.push(dynamicColors());
                }

                myChartMarketTotal = new Chart( ctxMarketTotal, {
                    type: 'pie',
                    data: {
                        labels:labelPM,
                        datasets: [ {
                            data: volumnPM,
                            backgroundColor : coloR,
                        }]
                    },
                    options: {
                        tooltips: {
                            callbacks: {
                                label: function(t, d) {
                                    var Label = d.datasets[0].data[t.index];
                                    var xLabel = d.labels[t.index];
                                    var calPer = (Label*100) /alltotalValue.toFixed(2) ;
                                    return xLabel + ': ' + toMoney(Label)+' ('+calPer.toFixed(2)+'%)';
                                }
                            }
                        },
                        responsive: true
                    }
                }  );
            }
        });
    }

    function initBarChartMonthy(yearsId, basinId, areaId) {
        $("#totalMonthy tbody").html("");
        $("#totalMonthy thead").html("");
        $.ajax({
            url:"../util/reportTotalMonthyF.php",
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
            url:"../util/reportTotalMonthyFB.php",
            method:"POST",
            data:{yearsId:yearsId, basinId:basinId, areaId: areaId},
            dataType:"text",
            success:function(data){
                report = JSON.parse(data);
                console.log(report);
            },complete:function(){
                if(basinId !='0'){
                    $("#headerMonthyFB").html("เปรียบเทียบรายได้การจำหน่ายผลผลิตของลุ่มน้ำจำแนกรายเดือน ["+report[0].name+"]");
                }else{
                    $("#headerMonthyFB").html("เปรียบเทียบรายได้การจำหน่ายผลผลิตของทุกลุ่มน้ำจำแนกรายเดือน");
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
                    rowPlan += "<td style='text-align: right'>"+toMoney(report[i].totalPlan?report[i].totalPlan:0)+"</td>";
                    rowSale += "<td style='text-align: right'>"+toMoney(report[i].totalSale?report[i].totalSale:0)+"</td>";
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
                                label: "รายได้เป้าหมาย"
                            },
                            {
                                fill: false,
                                borderColor: "blue",
                                data: dataSet2,
                                label: "รายได้ผลผลิต"
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
                                return xLabel + ': ' + toMoney(t.yLabel);
                                }
                            }
                        }
                    }
                });
            }
        });
    }

    function initChartTotalSale(yearsId, basinId, areaId) {
        if(basinId == '0'){
            $("#cardHeaderPieChart").html("สัดส่วนมูลค่าจำหน่ายพืชของแต่ละลุ่มน้ำ");
        }else{
            $("#cardHeaderPieChart").html("สัดส่วนมูลค่าจำหน่ายพืชของแต่ละพื้นที่ในลุ่มน้ำ");
        }
        $.ajax({
            url:"../util/reportTotalSale.php",
            method:"POST",
            data:{yearsId:yearsId, basinId:basinId, areaId: areaId},
            dataType:"text",
            success:function(data){
                report = JSON.parse(data);
                // console.log(report);
            },complete:function(){
                // console.log(report);
                var labelPM=[];
                var volumnPM=[];
                var alltotalValue = 0;
                var coloR = [];
                for(var i=0;i<report.length;i++){
                    labelPM.push(report[i].name);
                    volumnPM.push(report[i].totalValue);
                    alltotalValue +=report[i].totalValue?report[i].totalValue:0;
                    coloR.push(dynamicColors());
                }

                myChartTotalSale = new Chart( ctxTotalSale, {
                    type: 'pie',
                    data: {
                        labels:labelPM,
                        datasets: [ {
                            data: volumnPM,
                            backgroundColor : coloR,
                        }]
                    },
                    options: {
                        tooltips: {
                            callbacks: {
                                label: function(t, d) {
                                    var Label = d.datasets[0].data[t.index];
                                    var xLabel = d.labels[t.index];
                                    var calPer = (Label*100) /alltotalValue.toFixed(2) ;
                                    return xLabel + ': ' + toMoney(Label)+' ('+calPer.toFixed(2)+'%)';
                                }
                            }
                        },
                        responsive: true
                    }
                }  );
            }
        });
    }

    function initBarChartAgriMarket(yearsId, basinId, areaId) {
        if(basinId == '0'){
            $("#cardHeaderMarketChart").html("เปรียบเทียบช่องทางการตลาดของแต่ละลุ่มน้ำ");
        }else{
            $("#cardHeaderMarketChart").html("สัดส่วนมูลค่าช่องทางการตลาดเปรียบเทียบรายพื้นที่");
        }
        $.ajax({
            url:"../util/reportAgriMarketF.php",
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
        yearsId = $("#yearsId").val();
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

            loadTableTotalMarket(yearsId, basinId, areaId);
            initChartTotalSale(yearsId, basinId, areaId);
            initBarChartAgriMarket(yearsId, basinId, areaId);
            initBarChartMonthy(yearsId, basinId, areaId);
            initChartMarketTotal(yearsId, basinId, areaId);
        }
    }
    function toMoney(n) {
        return n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
    }

    function dynamicColors() {
        var r = Math.floor(Math.random() * 255);
        var g = Math.floor(Math.random() * 255);
        var b = Math.floor(Math.random() * 255);
        return "rgb(" + r + "," + g + "," + b + ")";
    };

})(jQuery);