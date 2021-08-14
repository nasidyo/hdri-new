if (!window.reportNewT){
    // creating an empty global object
    var reportNewT = {};
}
(function ($) {
    var yearsId = $("#yearsId").val();
    var typeAgri = $("#typeAgri").val();
    var agriId = $("#agriId").val();
    var marketSaleCtx = document.getElementById("marketSale-chart-canvas").getContext('2d');
    var myChartMarketSaleCtx;

    var saleperMarketCtx = document.getElementById("salePerMarket-chart-canvas");
    saleperMarketCtx.height = 300;
    var myChartSaleperMarketCtx;

    var nextMonthlineCtx = document.getElementById("nextMonthline-chart-canvas");
    nextMonthlineCtx.height = 50;
    var myChartNextMonthlineCtx;
    
    initlineChartNextMonth();
    initTableMarketSales ();
    initlineChartSalesPerMarket();
    function initlineChartNextMonth(){
        var d = new Date();
        var month = d.getMonth()+1;
        var years = (d.getFullYear()+543);
        $.ajax({
            url:"../util/reportNextMonthPrice.php",
            method:"POST",
            data:{yearsId:years, agriId:agriId, month:month},
            dataType:"text",
            success:function(data){
                report = JSON.parse(data);
                console.log(report);
            },complete:function(){
                console.log(labelPM);
                console.log(volumnPM);
                var labelPM=[];
                var volumnPM=[];
                var colors=[];
                var sumPrice = 0;
                var xxx = 0;
                for(var i=report.length-1;i>=0;i--){
                    labelPM.push(report[i].Month_name);
                    console.log(report[i].avgVolumn);
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
                        console.log(data);
                        labelPM.push(data);
                        volumnPM.push(priceNextMonth);
                        colors.push("orange");
                    },complete:function(){
                        console.log(labelPM);
                        console.log(volumnPM);
                        const data = volumnPM.map((value, index) => ( { x: index + 1, xL: labelPM[index], y: value, color: colors[index]} ));
                        console.log(data);
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
                            },
                            scales: {
                                xAxes: [{
                                    ticks: {
                                        stepSize: 1,
                                        userCallback: function(label, index, labels) {
                                            console.log(label ,"|||",index,"||",labelPM)
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
    function initTableMarketSales (){
        $("#table-MarketSale tbody").html('');
        $.ajax({
            url:"../util/reportTableAgriSaleMarket.php",
            method:"POST",
            data:{yearsId:yearsId, agriId:agriId},
            dataType:"text",
            success:function(data){
                report = JSON.parse(data);
                $("#table-MarketSale tbody").html(report[0].dataTable);
            },complete:function(){
                var labelPM=[];
                var volumnPM=[];
                var alltotalValue = 0;
                var coloR = [];
                var dataset = report[0].dataset;
                for(var i=0;i<dataset.length;i++){
                    console.log(dataset[i]);
                    labelPM.push(dataset[i].nameMarket);
                    volumnPM.push(dataset[i].totalprice);
                    alltotalValue +=dataset[i].totalprice?dataset[i].totalprice:0;
                    coloR.push(dynamicColors());
                }
                myChartMarketSaleCtx = new Chart( marketSaleCtx, {
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
                        responsive: true
                    }
                }  );
            }
        });
    }
    function initlineChartSalesPerMarket(){
        $.ajax({
            url:"../util/reportAgriSalePerMarket.php",
            method:"POST",
            data:{yearsId:yearsId, agriId:agriId},
            dataType:"text",
            success:function(data){
                report = JSON.parse(data);
                console.log(report);
            },complete:function (){
                var label=[];
                var volumnPM=[];
                for(var i=0;i<report.length;i++){
                    console.log(report[i]);
                    label.push(report[i].nameMarket);
                    volumnPM.push(report[i].totalprice);
                    // coloR.push(dynamicColors());
                }
                myChartSaleperMarketCtx = new Chart( saleperMarketCtx, {
                    type: "line",
                    data: {
                        labels : label,
                        datasets: [
                            {
                                fill: false,
                                borderColor: "red",
                                data: volumnPM,
                                label: "บาท/กิโลกรัม"
                            },
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
    function numberWithCommas(x) {
        x = x.toFixed(0);
        var pattern = /(-?\d+)(\d{3})/;
        while (pattern.test(x))
            x = x.replace(pattern, "$1,$2");
        return x;
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

