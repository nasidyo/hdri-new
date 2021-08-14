
(function ($) {
    var yearsId = $("#yearsId").val();
    loadTableTotalMarket(yearsId);

    var ctxAgri = document.getElementById("totalAgri-chart-canvas");
    var myChartAgri;

    var ctxMarket = document.getElementById("market-chart-canvas");
    var myChartMarket;

    var ctxAgriMarket = document.getElementById("agriAndMarket-chart-canvas").getContext('2d');
    var myChartAgriMarket;

    var ctxMonthy = document.getElementById("monthy-chart-canvas");
    ctxMonthy.height = 500;
    var myChartMonthy;
    $(".export").click(function() {
		var export_type = $(this).data('export-type');
        console.log(export_type);
        $('#totalMarket').tableExport({
			type : export_type,			
			escape : 'false',
			ignoreColumn: []
		});		
    });
    $('#excel_totalMarket').click(function(){
            var excel_data = $('#totalMarket').html();  
            var data_excel = excel_data.replace(/(\r\n|\n|\r)/gm," ");
            var url = "../util/excel/expotExcel.php";
            exportTableToExcel("totalMarket", "มูลค่าการส่งมอบผลผลิตของสถาบัน");
   });

    $('#yearsOfPlan').change(function(){
        var yearsId = $("#yearsOfPlan").val();
        console.log(yearsId);
        if(myChartAgri!=undefined){
            myChartAgri.destroy();
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
        loadTableTotalMarket(yearsId);
        initChartTotalAgri(yearsId);
        initChartTotalMarket(yearsId);
        initBarChartAgriMarket(yearsId);
        initBarChartMonthy(yearsId);
    });

    function loadTableTotalMarket(yearsId) {
        $("#totalMarket tbody").html("");
        $("#totalMarketTitle").html("");
        $.ajax({
            url:"../util/totalMarketReport.php",
            method:"POST",
            data:{yearsId:yearsId},
            dataType:"text",
            success:function(data){
                $("#totalMarket tbody").html("");
                $("#totalMarketTitle").html("มูลค่าการส่งมอบผลผลิตของสถาบัน รายสาขาพืช ปีงบประมาณ พ.ศ. "+yearsId+" จำแนกตามช่องทางการตลาด");
                $("#totalMarket tbody").html(data);
            }
        });
    }
    initChartTotalAgri(yearsId);
    initChartTotalMarket(yearsId);
    initBarChartAgriMarket(yearsId);
    initBarChartMonthy(yearsId);
    function initBarChartMonthy(yearsId) {
        $.ajax({
            url:"../util/reportTotalMonthy.php",
            method:"POST",
            data:{yearsId:yearsId},
            dataType:"text",
            success:function(data){
                report = JSON.parse(data);
                console.log(report);
            },complete:function(){
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
                    }
                });
            }
        });
    }
    function initBarChartAgriMarket(yearsId) {
        $.ajax({
            url:"../util/reportAgriMarket.php",
            method:"POST",
            data:{yearsId:yearsId},
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
                    label.push(report[i].idTypeOfArgi);
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
                        legend: { position: 'bottom' },
                      }
                });
            }
        });
    }

    function initChartTotalMarket(yearsId) {
        $.ajax({
            url:"../util/reportTotalMarket.php",
            method:"POST",
            data:{yearsId:yearsId},
            dataType:"text",
            success:function(data){
                report = JSON.parse(data);
            },complete:function(){
                console.log(report);
                var labelPM=[];
                var volumnPM=[];
                var alltotalValue = 0;
                for(var i=0;i<report.length;i++){
                    labelPM.push(report[i].nameMarket);
                    volumnPM.push(report[i].TotalValue);
                    alltotalValue +=report[i].TotalValue?report[i].TotalValue:0;
                }
                myChartMarket = new Chart( ctxMarket, {
                    type: 'pie',
                    data: {
                        labels:labelPM,
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

    function initChartTotalAgri(yearsId) {
        $.ajax({
            url:"../util/reportTotalAgri.php",
            method:"POST",
            data:{yearsId:yearsId},
            dataType:"text",
            success:function(data){
                report = JSON.parse(data);
            },complete:function(){
                console.log(report);
                var labelPM=[];
                var volumnPM=[];
                var alltotalValue = 0;
                for(var i=0;i<report.length;i++){
                    labelPM.push(report[i].nameTypeOfArgi);
                    volumnPM.push(report[i].TotalValue);
                    alltotalValue +=report[i].TotalValue?report[i].TotalValue:0;
                }
                myChartAgri = new Chart( ctxAgri, {
                    type: 'pie',
                    data: {
                        labels:labelPM,
                        datasets: [ {
                            data: volumnPM,
                            backgroundColor: [
                                "rgba(138, 223, 226, 1)",
                                "rgba(85, 197, 209, 1)",
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
                                "rgba(85, 197, 209, 1)",
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
