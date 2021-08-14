if (!window.reportNewT){
    // creating an empty global object
    var reportNewT = {};
}
(function ($) {
    var yearsId = $("#yearsId").val();
    var typeAgri = $("#typeAgri").val();
    loadTableTotalMarket(yearsId, typeAgri);
    initChartTotalMarket(yearsId, typeAgri);
    initBarChartMonthy(yearsId, typeAgri);
    loadBtnAgritype();
    // jQuery('#argi_0').addClass('active');
    var ctxTotalSale = document.getElementById("totalSale-chart-canvas");
    var myChartTotalSale;

    var ctxMarket = document.getElementById("market-chart-canvas");
    var myChartMarket;

    var ctxAgri = document.getElementById("totalAgri-chart-canvas");
    var myChartAgri;

    var ctxMonthy = document.getElementById("monthy-chart-canvas");
    ctxMonthy.height = 500;
    var myChartMonthy;

    $('#excel_totalMarket').click(function(){
        exportTableToExcel("totalMarket", "มูลค่าการจำหน่ายของโครงการขยายผลโครงการหลวง");
    });

    $('#yearsOfPlan').change(function(){
        var yearsId = $("#yearsOfPlan").val();
        if(myChartTotalSale != undefined)
        myChartTotalSale.destroy();

        if(myChartMarket != undefined)
        myChartMarket.destroy();

        if(myChartAgri != undefined)
        myChartAgri.destroy();

        if(myChartMonthy != undefined)
        myChartMonthy.destroy();
        initChartTotalAgri(yearsId, typeAgri);
        loadTableTotalMarket(yearsId, typeAgri);
        initChartTotalMarket(yearsId, typeAgri);
        initBarChartMonthy(yearsId, typeAgri);
    });

    function loadBtnAgritype() {
        $.ajax({
            url:"../util/loadBtnTypeOAgri.php",
            method:"POST",
            dataType:"text",
            success:function(data){
                $('#sectionBtnSelecte').html(data);
            }
        });
    }

    function initBarChartMonthy(yearsId, typeAgri) {
        $.ajax({
            url:"../util/reportTotalMonthyT.php",
            method:"POST",
            data:{yearsId:yearsId, typeAgri:typeAgri},
            dataType:"text",
            success:function(data){
                report = JSON.parse(data);
                console.log(report);
            },complete:function(){
                if(typeAgri != '0'){
                    $("#titleMonthyChart").html("เปรียบเทียบรายได้การจำหน่ายผลผลิตของสถาบันจำแนกรายเดือนของของสาขา ["+report[0].nameTypeOfArgi+"]");
                    // ctxAgri.height = 300;
                }else{
                    $("#titleMonthyChart").html("เปรียบเทียบรายได้การจำหน่ายผลผลิตของสถาบันจำแนกรายเดือนของทุกสาขา");
                }
                $("#totalMonthy thead").html('');
                $("#totalMonthy tbody").html('');
                var label = [];
                var dataSet1 = [];
                var dataSet2 = [];
                var theader = '<th></th>';
                var rowPlan = "<td>รายได้เป้าหมาย</td>";
                var rowSale = "<td>รายได้ผลผลิต</td>";
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
                                return xLabel + ': ' + numberWithCommas(t.yLabel);
                              }
                          }
                        }
                        ,scales: {
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
                        }
                    }
                });
            }
        });
    }

    initChartTotalAgri(yearsId, typeAgri);
    function loadTableTotalMarket(yearsId, typeAgri) {
        $("#totalMarket tbody").html("");
        $.ajax({
            url:"../util/totalMarketReportT.php",
            method:"POST",
            data:{yearsId:yearsId, typeAgri:typeAgri},
            dataType:"text",
            success:function(data){
                $("#totalMarket tbody").html(data);
            }
        });
    }
    function initChartTotalAgri(yearsId, typeAgri) {
        $.ajax({
            url:"../util/reportTotalAgriT.php",
            method:"POST",
            data:{yearsId:yearsId, typeAgri:typeAgri},
            dataType:"text",
            success:function(data){
                report = JSON.parse(data);
            },complete:function(){
                console.log(report[0].nameDisplay);
                if(typeAgri != '0'){
                    $("#titleTotalAgriChart").html("สัดส่วนค่ารายได้สาขาที่สำคัญของสาขา ["+report[0].nameDisplay+"]");
                    console.log(report.length);
                    if(report.length > 60){
                        ctxAgri.height = 300;
                    }else if (report.length > 50){
                        ctxAgri.height = 100;
                    }else{
                        ctxAgri.height = 200;
                    }
                    
                }else{
                    $("#titleTotalAgriChart").html("สัดส่วนค่ารายได้สาขาที่สำคัญแยกเป็นสาขา");
                }
                var labelPM=[];
                var volumnPM=[];
                var alltotalValue = 0;
                var coloR = [];
                for(var i=0;i<report.length;i++){
                    labelPM.push(report[i].nameTypeOfArgi);
                    volumnPM.push(report[i].TotalValue);
                    alltotalValue +=report[i].TotalValue?report[i].TotalValue:0;
                    coloR.push(dynamicColors());
                }
                myChartAgri = new Chart( ctxAgri, {
                    type: 'pie',
                    data: {
                        labels:labelPM,
                        datasets: [ {
                            data: volumnPM,
                            backgroundColor: coloR,
                            hoverBackgroundColor: coloR
                                        } ]
                    },
                    options: {
                        tooltips: {
                            callbacks: {
                                label: function(t, d) {
                                    var Label = d.datasets[0].data[t.index];
                                    var xLabel = d.labels[t.index];
                                    var calPer = (Label*100) /alltotalValue.toFixed(2) ;
                                    return xLabel + ': ' + numberWithCommas(Label)+' ('+calPer.toFixed(0)+'%)';
                                }
                            }
                        },
                        responsive: true
                    }
                }  );
            }
        });
    }
    function initChartTotalMarket(yearsId, typeAgri) {
        $.ajax({
            url:"../util/reportTotalMarketT.php",
            method:"POST",
            data:{yearsId:yearsId, typeAgri:typeAgri},
            dataType:"text",
            success:function(data){
                report = JSON.parse(data);
            },complete:function(){
                var labelPM=[];
                var volumnPM=[];
                var alltotalValue = 0;
                var coloR = [];
                if(typeAgri != '0'){
                    $("#titleMarketChart").html("สัดส่วนช่องทางการตลาดของสาขา ["+report[0].nameDisplay+"]");
                }else{
                    $("#titleMarketChart").html("สัดส่วนช่องทางการตลาด");
                }
                for(var i=0;i<report.length;i++){
                    labelPM.push(report[i].nameMarket);
                    volumnPM.push(report[i].TotalValue);
                    alltotalValue +=report[i].TotalValue?report[i].TotalValue:0;
                    coloR.push(dynamicColors());
                }
                console.log(volumnPM);
                myChartMarket = new Chart( ctxMarket, {
                    type: 'pie',
                    data: {
                        labels:labelPM,
                        datasets: [ {
                            data: volumnPM,
                            backgroundColor: coloR,
                            hoverBackgroundColor: coloR
                                        } ]
                    },
                    options: {
                        tooltips: {
                            callbacks: {
                                label: function(t, d) {
                                    var Label = d.datasets[0].data[t.index];
                                    var xLabel = d.labels[t.index];
                                    var calPer = (Label*100) /alltotalValue.toFixed(2) ;
                                    return xLabel + ': ' + numberWithCommas(Label)+' ('+calPer.toFixed(0)+'%)';
                                }
                            }
                        },
                        responsive: true
                    }
                }  );
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
                                    return xLabel + ': ' + numberWithCommas(Label)+' ('+calPer.toFixed(0)+'%)';
                                }
                            }
                        },
                        responsive: true,
                        legend: { position: 'bottom' },
                    }
                }  );
            }
        });
    }

    function initBarChartAgriMarket(yearsId, basinId, areaId) {
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
    function aaaa() {
        alert("aaaa");
    }
    function dynamicColors() {
        var r = Math.floor(Math.random() * 255);
        var g = Math.floor(Math.random() * 255);
        var b = Math.floor(Math.random() * 255);
        return "rgba(" + r + "," + g + "," + b + ",1)";
    };

    reportNewT.a1_onclick = function($id){ 
        console.log($id);
        // yearsId = $("#yearsId").val();
        yearsId = $("#yearsOfPlan").val();
        typeAgri = $("#typeAgri").val();
        $('.agris').removeClass('active');
        jQuery('#argi_'+$id).addClass('active');
        if(typeAgri != $id) {
            $("#typeAgri").val($id);
            typeAgri = $id
            if(myChartTotalSale != undefined)
            myChartTotalSale.destroy();

            if(myChartMarket != undefined)
            myChartMarket.destroy();

            if(myChartAgri != undefined)
            myChartAgri.destroy();

            if(myChartMonthy != undefined)
            myChartMonthy.destroy();
            initChartTotalAgri(yearsId, typeAgri);
            loadTableTotalMarket(yearsId, typeAgri);
            initChartTotalMarket(yearsId, typeAgri);
            initBarChartMonthy(yearsId, typeAgri);
        }
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

