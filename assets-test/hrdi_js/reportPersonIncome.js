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
              var tbody = '';
                for(var i=0;i<riverBasin.length;i++){
                    label.push(riverBasin[i].fullName);
                    all.push(riverBasin[i].totalIncomePerson);
                    tbody +="<tr><td>"+riverBasin[i].fullName+"</td><td>"+toMoney(riverBasin[i].totalIncomePerson)+" บาท</td></tr>";
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
                $("#dashTableM thead").html("");
                $("#dashTableM thead").html("<th>ชื่อ-นามสกุล</th><th>รายได้รวม</th>");
                $("#dashTableM tbody").html("");
                $("#dashTableM tbody").html(tbody);
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
        var incomeStart = $('#incomeStart').val();
        var incomeEnd = $('#incomeEnd').val();
        if(incomeStart !=''){
            if(incomeEnd != ''){
                if(incomeEnd < incomeStart){
                    alert("ช่องรายได้ระหว่าง ค่าเริ่มต้นไม่สามารถมากกว่าค่าสิ้นสุด");
                    return false;
                }
            }else{
                incomeEnd = 0;
            }
        }else{
            incomeStart = 0;
            if(incomeEnd == ''){
                incomeEnd = 0;
            }
        }
        years_Id = $('#yearsOfPlan option:selected').val();
        var typeOfAgri_id = $('#typeOfAgri_id').val();
        var agri = $('#agri').val();
        var month_id = $('#month_id').val();
        var farmer_Id = $('#farmer_Id').val();
        var showUnit = $("#showUnit option:selected").val();
        $.ajax({
            url:"../util/reportIncomePerson.php",
            data: {yearsId:years_Id, area_Id:area_Id, actionPage: "search", farmer_Id:farmer_Id, month_id:month_id,
            agri:agri, typeOfAgri_id:typeOfAgri_id,showUnit: showUnit, incomeStart:incomeStart, incomeEnd:incomeEnd},
            method:"POST",
            dataType:"text",
            success:function(data){
                riverBasin =JSON.parse(data);
            },
            complete:function(){
                if(farmer_Id != '0'){
                    var label=[];
                    var all=[];
                    var tbody = '';
                    for(var i=0;i<riverBasin.length;i++){
                        label.push("["+riverBasin[i].nameTypeOfArgi+"]"+riverBasin[i].nameArgi);
                        all.push(riverBasin[i].totalIncomePerson);
                        tbody +="<tr><td>["+riverBasin[i].nameTypeOfArgi+"]"+riverBasin[i].nameArgi+"</td><td>"+toMoney(riverBasin[i].totalIncomePerson)+" บาท</td></tr>";
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
                    $("#dashTableM thead").html("");
                    $("#dashTableM thead").html("<th>รายชื่อพืช</th><th>รายได้รวม</th>");
                    $("#dashTableM tbody").html("");
                    $("#dashTableM tbody").html(tbody);
                }else{
                    var label=[];
                    var all=[];
                    var tbody = '';
                    for(var i=0;i<riverBasin.length;i++){
                        label.push(riverBasin[i].fullName);
                        all.push(riverBasin[i].totalIncomePerson);
                        tbody +="<tr><td>"+riverBasin[i].fullName+"</td><td>"+toMoney(riverBasin[i].totalIncomePerson)+" บาท</td></tr>";
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
                    $("#dashTableM thead").html("");
                    $("#dashTableM thead").html("<th>ชื่อ-นามสกุล</th><th>รายได้รวม</th>");
                    $("#dashTableM tbody").html("");
                    $("#dashTableM tbody").html(tbody);
                }
            }
        });
    }
    $('#excel_totalMonthy').click(function(){
        exportTableToExcel("dashTableM", "สรุปรายได้เกษตกร");
    });

    function toMoney(n) {
        return n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
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

