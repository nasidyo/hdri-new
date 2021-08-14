
(function ($) {
    var spinner = $('#loader');
    // select 2
    $('#idRiverBasin').select2();
    $('#areaId').select2();
    $('#typeOfAgri_id').select2();
    $('.agri-dropdown').select2();

    var ctx = document.getElementById( "barChartVolume" );
    var ctx2 = document.getElementById( "barChartAmount" );
    var myLineChart;
    var myLineChart2;
    var typeOfAgri_id = $('#typeOfAgri_id option:selected').val();
    var idRiverBasin = $("#idRiverBasin option:selected").val();
    var years_Id = $('#year option:selected').val();
    var area_Id = $("#areaId option:selected").val();
    var typeOfAgri_id = $('#typeOfAgri_id option:selected').val();
    var agriList = $('#agriList').val();
    var speciesId = $("#speciesId option:selected").val();
    var showUnit = $("#showUnit option:selected").val();
    if(myLineChart!=undefined){
        myLineChart.destroy();
    }
    if(myLineChart2!=undefined){
        myLineChart2.destroy();
    }
    initChartPersonMarket();

$("#idRiverBasin").on("change",function(){
    idRiverBasin = $(this).val();
    loadArea(idRiverBasin);
    years_Id = $('#year option:selected').val();
});

$("#typeOfAgri_id").on("change",function(){
    typeOfAgri_id = $('#typeOfAgri_id option:selected').val();
    if(typeOfAgri_id != '0'){
        $.ajax({
            url:"../util/loadAgriProduct.php",
            method:"POST",
            data:{tpyeOfAgri_Id:typeOfAgri_id, area_Id:area_Id},
            dataType:"text",
            success:function(data){
                $('#agriList').html(data);
            }
        });
    }
});
$('#agriList').change(function(){
    if($(this).val().length == '1'){
      console.log($(this).val()[0]);
      var agri_Id = $(this).val()[0];
      loadSpeciesDW(agri_Id);
    }else{
      $('#speciesId').html('');
      $('#speciesId').html("<option value='ALL'>ทั้งหมด</option>");
    }
    $.ajax({
      url:"../util/loadAllProductGradeJs.php",
      dataType:"text",
      success:function(data){
          $('#typeOfGradeId').html(data);
      }
    });
});

function loadSpeciesDW(agri_Id){
    $.ajax({
        url:"../util/loadSpeciesDW.php",
        method:"POST",
        data:{argi_id:agri_Id},
        dataType:"text",
        success:function(data){
            var listdata = "<option value='ALL'>ทั้งหมด</option>"+data;
            $('#speciesId').html(listdata);
        }
    });
}

function initChartPersonMarket(){
    $.ajax({
        url:"../util/ReportAgriList.php",
        data: {years_Id:years_Id, idRiverBasin:idRiverBasin, typeOfAgri_id:typeOfAgri_id, agriList:agriList, showUnit:showUnit, speciesId:speciesId},
        method:"POST",
        dataType:"text",
        success:function(data){
            console.log(data);
            report =JSON.parse(data);
        },complete:function(){
            spinner.hide();
            var labelPM=[];
            var totalVolumnPM=[];
            var totalvaluePM=[];

            var totalVolumnM=[];
            var totalvalueM=[];
            for(var i=0;i<report.length;i++){
                labelPM.push(report[i].target_name);
                totalvaluePM.push(report[i].totalsell);
                totalVolumnPM.push(report[i].totalplan);

                totalvalueM.push(report[i].totalQulitysell);
                totalVolumnM.push(report[i].totalQulityplan);
            }

            var ctx = $("#barChartValue");
            myLineChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labelPM,
                    datasets: [{
                        data: totalvaluePM,
                        label: "มูลค่ารวมส่งมอบ",
                        borderColor: "rgba(0,0,0,0.09)",
                        borderWidth: "0",
                        backgroundColor: "rgba(0, 123, 255, 0.5)",
                        fill: false,
                    }, {
                        data: totalVolumnPM,
                        label: "มูลค่ารวมเป้าหมาย",
                        borderColor: "rgba(0,0,0,0.09)",
                        borderWidth: "0",
                        backgroundColor: "#28a745",
                        fill: false
                    }]
                },
                options: {
                    title: {
                        display: true,
                        text: ''
                    },scales: {
                        xAxes: [
                          {
                          ticks: {
                                autoSkip: false,
                                maxRotation: 90,
                                minRotation: 45
                            }
                          }
                        ]
                },tooltips: {
                        callbacks: {
                            label: function(tooltipItem, data) {
                                var label = data.labels[tooltipItem.index];
                                var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                                return label + ': ' + toMoney(value)+ ' บาท';

                            }
                        }
                    }
                }
            });


            var ctx2 = $("#barChartAmount");
            myLineChart2 = new Chart(ctx2, {
                type: 'bar',
                data: {
                    labels: labelPM,
                    datasets: [{
                        data: totalvalueM,
                        label: "ปริมาณรวมส่งมอบ",
                        borderColor: "rgba(0,0,0,0.09)",
                        borderWidth: "0",
                        backgroundColor: "rgba(0, 255, 255, 0.5)",
                        fill: false,
                    }, {
                        data: totalVolumnM,
                        label: "ปริมาณรวมเป้าหมายผลผลิต",
                        borderColor: "rgba(0,0,0,0.09)",
                        borderWidth: "0",
                        backgroundColor: "rgba(150, 123, 255, 0.5)",
                        fill: false
                    }]
                },
                options: {
                    title: {
                        display: true,
                        text: ''
                    },scales: {
                        xAxes: [
                          {
                          ticks: {
                                autoSkip: false,
                                maxRotation: 90,
                                minRotation: 45
                            }
                          }
                        ]
                },tooltips: {
                        callbacks: {
                            label: function(tooltipItem, data) {
                                var label = data.labels[tooltipItem.index];
                                var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                                return label + ': ' + toMoney(value)+ ' หน่วย';

                            }
                        }
                    }
                }
            });
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

function loadArea(idRiverBasin){
    $.ajax({
        url:"../util/loadAreaDropdown.php",
        method:"POST",
        data:{idRiverBasin:idRiverBasin},
        dataType:"text",
        success:function(data){
            $('#areaId').html(data);
        }
    });
    }

$('#search_reportIncome').on('click', function () {
    spinner.show();
    typeOfAgri_id = $('#typeOfAgri_id option:selected').val();
    idRiverBasin = $("#idRiverBasin option:selected").val();
    years_Id = $('#year option:selected').val();
    area_Id = $("#areaId option:selected").val();
    typeOfAgri_id = $('#typeOfAgri_id option:selected').val();
    agriList = $('#agriList').val();
    month_id = $("#month_id option:selected").val();
    speciesId = $("#speciesId option:selected").val();
    showUnit = $("#showUnit option:selected").val();
    if(myLineChart!=undefined){
        myLineChart.destroy();
    }
    if(myLineChart2!=undefined){
        myLineChart2.destroy();
    }
    initChartPersonMarket();
});



})(jQuery);


