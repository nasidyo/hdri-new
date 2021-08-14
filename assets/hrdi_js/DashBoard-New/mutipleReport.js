if (!window.reportNewF){
    // creating an empty global object
    var reportNewF = {};
}
// if (!window.btnReport2){
//     // creating an empty global object
//     var btnReport2 = {};
// }
// if (!window.btnReport3){
//     // creating an empty global object
//     var btnReport3 = {};
// }
(function ($) {
    var spinner = $('#loader');
    var reportChart = document.getElementById("compare-price-canvas");
    var myreportChart;

    $(document).on({
        ajaxStart: function(){
            spinner.show();
        },
        ajaxStop: function(){
            spinner.hide();
        }
    });

    $('#excel_totalMarket').click(function(){
        exportTableToExcel("totalMonthyFB", "ข้อมูลรายงาน");
    });

    $('#areaList').select2();
    $('#agriList').select2();
    $('#marketList').select2();

    reloadReport();

    $('#search_reportIncome').on('click', function () {
        reloadReport();
    });

    reportNewF.a1_onclick = function($id){ 
        $('.report1').removeClass('active');
        jQuery('#axes1Y_'+$id).addClass('active');
        reloadReport();
    };
    reportNewF.a2_onclick = function($id){ 
        $('.report2').removeClass('active');
        jQuery('#axes2Y_'+$id).addClass('active');
        reloadReport();
    };
    reportNewF.a3_onclick = function($id){ 
        $('.report3').removeClass('active');
        jQuery('#axesX_'+$id).addClass('active');
        reloadReport();
    };

    function reloadReport (){
        if(myreportChart != undefined)
            myreportChart.destroy();

        var axisY1 = document.getElementsByClassName('report1 active')[0].id;
        var axisY2 = document.getElementsByClassName('report2 active')[0].id;
        var axisX3= document.getElementsByClassName('report3 active')[0].id;
        var years = $('#yearsOfPlan option:selected' ).val();
        var areaList = $('#areaList').val();
        var agriList = $('#agriList').val();
        var marketList = $('#marketList').val();
        var axisYL = axisY1.split("_")[1];
        var axisYR = axisY2.split("_")[1];
        var axisX = axisX3.split("_")[1];
        console.log("axisYL::",axisYL, "axisYR::",axisYR, "axisX::",axisX);
        $.ajax({
            url:"../util/loadReportAllInOne.php",
            method:"POST",
            data:{axisYL:axisYL, axisYR:axisYR, axisX:axisX, years:years, areaList:areaList, agriList:agriList, marketList:marketList},
            dataType:"text",
            success:function(data){
                console.log(data);
                report = JSON.parse(data);
            },complete:function(){
                label = [];
                value1 = [];
                value2 = [];
                var text1 = document.getElementById(axisY1).textContent;
                var text2 = document.getElementById(axisY2).textContent;
                var text3 = document.getElementById(axisX3).textContent;
                var theader = '<th></th>';
                var rowPlan = "<td>"+text1+"</td>";
                var rowSale = "<td>"+text2+"</td>";
                var totalPlan = 0;
                var totalsale = 0;
                for(var i=0;i<report.length;i++){
                    console.log(report[i].value1?report[i].value1:0);
                    totalPlan += report[i].value1?report[i].value1:0;
                    totalsale += report[i].value2?report[i].value2:0;
                    console.log("4444",totalPlan);
                    theader += "<th >"+report[i].Label+"</th>";
                    rowPlan += "<td style='text-align: right'>"+numberWithCommas(report[i].value1?report[i].value1:0)+"</td>";
                    rowSale += "<td style='text-align: right'>"+numberWithCommas(report[i].value2?report[i].value2:0)+"</td>";
                    label.push(report[i].Label);
                    value1.push(report[i].value1);
                    value2.push(report[i].value2);
                }
                $("#totalMonthyFB thead").html('');
                $("#totalMonthyFB tbody").html('');
                console.log(totalPlan);
                console.log(totalsale);
                if(totalPlan != 0 && totalsale != 0){
                    theader += "<th style='background-color: cornsilk;'>รวม</th>";
                    rowPlan += "<td style='text-align: right; background-color: cornsilk;'>"+numberWithCommas(totalPlan)+"</td>";
                    rowSale += "<td style='text-align: right; background-color: cornsilk;'>"+numberWithCommas(totalsale)+"</td>";
                }
                $("#totalMonthyFB thead").html(theader);
                $("#totalMonthyFB tbody").html("<tr>"+rowPlan+"</tr><tr>"+rowSale+"</tr>");
                maxValue = Math.max.apply(null, value2);
                myreportChart = new Chart( reportChart, {
                    
                    data: {
                        labels : label,
                        datasets: [{
                                type: "line",
                                yAxisID : "id1",
                                fill: false,
                                borderColor: "orange",
                                data: value1,
                                label: text1,
                            },{
                                type: "bar",
                                fill: false,
                                yAxisID : "id2",
                                backgroundColor: "#caf270",
                                data: value2,
                                label: text2,
                          }
                        ]
                    },
                    options: {
                        tooltips: {
                            mode: 'index',
                            intersect: false,
                            callbacks: {
                                label: function(t, d) {
                                    var xLabel = d.datasets[t.datasetIndex].label;
                                    return xLabel + ' : ' + numberWithCommas(t.yLabel);
                                }
                            }
                        },
                        scales: {
                            xAxes: [{
                              display: true,
                                scaleLabel: {
                                    display: true,
                                    labelString: text3
                                },
                                ticks: {
                                    autoSkip: false,
                                    maxRotation: 90,
                                    minRotation: 45
                                }
                            }],
                            yAxes: [{
                                id:"id1",
                                stacked: true,
                                name: text1,
                                type: 'linear',
                                position: 'left',
                                scaleLabel: {
                                    display: true,
                                    labelString: text1
                                },ticks: {
                                    beginAtZero:true,
                                    callback: function(value, index, values) {
                                      return numberWithCommas(value);
                                    }
                                }
                            },{
                                id:"id2",
                                stacked: true,
                                name: text2,
                                type: 'linear',
                                position: 'right',
                                grid: {
                                    drawOnChartArea: false, // only want the grid lines for one axis to show up
                                },
                                scaleLabel: {
                                    display: true,
                                    labelString: text2
                                },
                                ticks: {
                                    beginAtZero:true,
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
