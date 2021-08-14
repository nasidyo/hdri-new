/*
 * Author: Abdullah A Almsaeed
 * Date: 4 Jan 2014
 * Description:
 *      This is a demo file used only for the main dashboard (index.html)
 **/

(function ($) {
    spinner = $("#loader");
    $(document).on({
        ajaxStart: function(){
            spinner.show();
        },
        ajaxStop: function(){
            spinner.hide();
        }
    });
    
    var yearsId = $('#yearsOfPlan option:selected').val();
    console.log(1111);
    "use strict";
    var datatTable1C;
    var datatTable1Q;

    var datatTable2C;
    var datatTable2Q;

    var datatTable3C;
    var datatTable3Q;

    var datatTable4C;
    var datatTable4Q;

    var ctxMonthyC = $("#monthy-chart-canvasC");
    ctxMonthyC.height = 500;
    var myChartMonthyC;

    var ctxMonthyQ = $('#monthy-chart-canvasQ');
    ctxMonthyQ.height = 500;
    var myChartMonthyQ;

    initTableProject();
    initTableBasin();
    initTableTypeOfAgri();
    initTableMarket();
    initBarChartMonthy();
    initBarChartMonthyQ();
    initPersonDeliver();

    $('a[href="#nav-cost"]').on('shown.bs.tab', function(){
        if(myChartMonthyC!=undefined){
            myChartMonthyC.destroy();
        }
        initBarChartMonthy();
    });
    $('a[href="#nav-quantity"]').on('shown.bs.tab', function(){
        if(myChartMonthyQ!=undefined){
            myChartMonthyQ.destroy();
        }
        initBarChartMonthyQ();
    });

    $('#yearsOfPlan').change(function(){
        datatTable1C = $('#projectCost').DataTable().destroy();
        datatTable1Q = $('#projectQuantity').DataTable().destroy();
        datatTable2C = $('#basinCost').DataTable().destroy();
        datatTable2Q = $('#basinQuantity').DataTable().destroy();
        
        datatTable3C = $('#typeAgriCost').DataTable().destroy();
        datatTable3Q = $('#typeAgriQuantity').DataTable().destroy();

        datatTable4C = $('#marketTypeCost').DataTable().destroy();
        datatTable4Q = $('#typeMarketTypeQuantity').DataTable().destroy();

        if(myChartMonthyC!=undefined){
            myChartMonthyC.destroy();
        }
        if(myChartMonthyQ!=undefined){
            myChartMonthyQ.destroy();
        }
        initTableProject();
        initTableBasin();
        initTableTypeOfAgri();
        initTableMarket();
        initBarChartMonthy();
        initBarChartMonthyQ();
        initPersonDeliver();
    });

    function initPersonDeliver (){
        yearsId = $('#yearsOfPlan option:selected').val();
        $.ajax({
            url:"../util/new-report/loadPersonDeliver.php",
            method:"POST",
            data:{yearsId:yearsId},
            dataType:"text",
            success:function(data){
                report = JSON.parse(data);
                console.log(report);
                $('#totalPersonDeliver').html(numberWithCommas(report[0].contOfPerson)+' คน');
            },complete:function(){
                $.ajax({
                    url:"../util/new-report/loadAllPerson.php",
                    method:"POST",
                    data:{yearsId:yearsId},
                    dataType:"text",
                    success:function(data){
                        report = JSON.parse(data);
                        console.log(report);
                        $('#totalPerson').html(numberWithCommas(report[0].contOfPerson)+' คน');
                    }
                });
            }
        });
        
    }

    
    function initBarChartMonthy() {
        yearsId = $('#yearsOfPlan option:selected').val();
        $.ajax({
            url:"../util/new-report/reportTotalMonthy.php",
            method:"POST",
            data:{yearsId:yearsId},
            dataType:"text",
            success:function(data){
                report = JSON.parse(data);
            },complete:function(){
                var label = [];
                var dataSet1 = [];
                var dataSet2 = [];
                // var theader = '<th></th>';
                // var rowPlan = "<td>เป้าหมาย</td>";
                // var rowSale = "<td>ส่งมอบ</td>";
                data1 = 0;
                data2 = 0;
                for(var i=0;i<report.length;i++){
                    // theader += "<th>"+report[i].Month_Etc+"</th>";
                    label.push(report[i].Month_Etc);
                    // rowPlan += "<td style='text-align: right'>"+numberWithCommas(report[i].totalPlan?report[i].totalPlan:0)+"</td>";
                    // rowSale += "<td style='text-align: right'>"+numberWithCommas(report[i].totalSale?report[i].totalSale:0)+"</td>";
                    data1 =data1+parseInt(report[i].TotalValue?report[i].TotalValue:0);
                    data2 =data2+parseInt(report[i].TotalVolumn?report[i].TotalVolumn:0);
                    // dataSet1.push(parseInt(report[i].TotalValue?report[i].TotalValue:0));
                    // dataSet2.push(parseInt(report[i].TotalValue?report[i].TotalValue:0));
                    dataSet1.push(data1);
                    dataSet2.push(data2);
                }
                // $("#totalMonthy thead").html(theader);
                // $("#totalMonthy tbody").html("<tr>"+rowPlan+"</tr><tr>"+rowSale+"</tr>");
                myChartMonthyC = new Chart( ctxMonthyC, {
                    type: "line",
                    data: {
                        labels : label,
                        datasets: [
                            {
                                fill: false,
                                borderColor: "red",
                                data: dataSet1,
                                label: "มูลค่าสะสม",
                                datalabels: {
                                    display: false
                                }
                            },
                        ]
                    },options: {
                        responsive: true,
                        plugins: {
                            datalabels: {
                                anchor: 'end',
                                offset: 8,
                            }
                        },
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
                        }
                    }
                });
            }
        });
    }


    function initBarChartMonthyQ() {
        yearsId = $('#yearsOfPlan option:selected').val();
        $.ajax({
            url:"../util/new-report/reportTotalMonthy.php",
            method:"POST",
            data:{yearsId:yearsId},
            dataType:"text",
            success:function(data){
                report = JSON.parse(data);
            },complete:function(){
                var label = [];
                var dataSet2 = [];
                data1 = 0;
                data2 = 0;
                for(var i=0;i<report.length;i++){
                    label.push(report[i].Month_Etc);
                    data2 = data2+parseInt(report[i].TotalVolumn?report[i].TotalVolumn:0);
                    dataSet2.push(data2);
                }
                myChartMonthyQ = new Chart( ctxMonthyQ, {
                    type: "line",
                    data: {
                        labels : label,
                        datasets: [
                            {
                                fill: false,
                                borderColor: "red",
                                data: dataSet2,
                                label: "ปริมาณสะสม",
                                datalabels: {
                                    display: false
                                }
                            },
                        ]
                    },options: {
                        responsive: true,
                        plugins: {
                            datalabels: {
                                anchor: 'end',
                                offset: 8,
                            }
                        },
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
                        }
                    }
                });
            }
        });
    }

    function initTableMarket() {
        yearsId = $('#yearsOfPlan option:selected').val();
        $.ajax({
            url:"../util/new-report/loadMarketSum.php",
            data: {yearsId:yearsId},
            method:"POST",
            dataType:"text",
            success:function(data){
                riverBasin =JSON.parse(data);
            },complete: function(data){
                datatTable4C = $('#marketTypeCost').DataTable({
                    "responsive": true, "lengthChange": false, "autoWidth": false,
                    "buttons": [
                        {
                            extend: 'excelHtml5',
                            title: 'ภาพรวมมูลค่ารายประเภทตลาด'
                        },
                        {
                            extend: 'print',
                            title: 'ภาพรวมมูลค่ารายประเภทตลาด'
                        }
                    ],
                    "pageLength": 5,
                    "fixedHeader": true,
                    "data" : riverBasin,
                    "columns" : [
                        {"data": ['nameValue'] ,"width": "70%"},
                        { "data": ['cost'],
                        "render": function (data, type, row) {
                            $datavlue = numberWithCommas(parseFloat(data.toFixed(2)));
                            return $datavlue;
                        },"width": "30%"},
                    ],
                    "order": [[ 1, "desc" ]],
                }).buttons().container().appendTo('#marketTypeCost_wrapper .col-md-6:eq(0)');
                datatTable4Q = $('#typeMarketTypeQuantity').DataTable({
                    "responsive": true, "lengthChange": false, "autoWidth": false,
                    "buttons": [
                        {
                            extend: 'excelHtml5',
                            title: 'ภาพรวมปริมาณรายประเภทตลาด'
                        },
                        {
                            extend: 'print',
                            title: 'ภาพรวมปริมาณรายประเภทตลาด'
                        }
                    ],
                    "pageLength": 5,
                    "fixedHeader": true,
                    "data" : riverBasin,
                    "columns" : [
                        {"data": ['nameValue'] ,"width": "70%"},
                        { "data": ['quantity'],
                        "render": function (data, type, row) {
                            $datavlue = numberWithCommas(parseFloat(data.toFixed(2)));
                            return $datavlue;
                        },"width": "30%"},
                    ],
                    "order": [[ 1, "desc" ]],
                }).buttons().container().appendTo('#typeMarketTypeQuantity_wrapper .col-md-6:eq(0)')
            }
        });
    }
    function initTableTypeOfAgri() {
        yearsId = $('#yearsOfPlan option:selected').val();
        $.ajax({
            url:"../util/new-report/loadTypeAgriSum.php",
            data: {yearsId:yearsId},
            method:"POST",
            dataType:"text",
            success:function(data){
                riverBasin =JSON.parse(data);
            },complete: function(data){
                datatTable3C = $('#typeAgriCost').DataTable({
                    "responsive": true, "lengthChange": false, "autoWidth": false,
                    "buttons": [
                        {
                            extend: 'excelHtml5',
                            title: 'ภาพรวมมูลค่ารายสาขา'
                        },
                        {
                            extend: 'print',
                            title: 'ภาพรวมมูลค่ารายสาขา'
                        }
                    ],
                    "pageLength": 5,
                    "fixedHeader": true,
                    "data" : riverBasin,
                    "columns" : [
                        {"data": ['nameValue'] ,"width": "70%"},
                        { "data": ['cost'],
                        "render": function (data, type, row) {
                            $datavlue = numberWithCommas(parseFloat(data.toFixed(2)));
                            return $datavlue;
                        },"width": "30%"},
                    ],
                    "order": [[ 1, "desc" ]],
                }).buttons().container().appendTo('#typeAgriCost_wrapper .col-md-6:eq(0)');
                datatTable3Q = $('#typeAgriQuantity').DataTable({
                    "responsive": true, "lengthChange": false, "autoWidth": false,
                    "buttons": [
                        {
                            extend: 'excelHtml5',
                            title: 'ภาพรวมปริมาณรายสาขา'
                        },
                        {
                            extend: 'print',
                            title: 'ภาพรวมปริมาณรายสาขา'
                        }
                    ],
                    "pageLength": 5,
                    "fixedHeader": true,
                    "data" : riverBasin,
                    "columns" : [
                        {"data": ['nameValue'] ,"width": "70%"},
                        { "data": ['quantity'],
                        "render": function (data, type, row) {
                            $datavlue = numberWithCommas(parseFloat(data.toFixed(2)));
                            return $datavlue;
                        },"width": "30%"},
                    ],
                    "order": [[ 1, "desc" ]],
                }).buttons().container().appendTo('#typeAgriQuantity_wrapper .col-md-6:eq(0)')
            }
        });
    }

    function initTableProject() {
        yearsId = $('#yearsOfPlan option:selected').val();
        $.ajax({
            url:"../util/new-report/loadProjectSum.php",
            data: {yearsId:yearsId},
            method:"POST",
            dataType:"text",
            success:function(data){
                riverBasin =JSON.parse(data);
            },complete: function(data){
                datatTable1C = $('#projectCost').DataTable({
                    "responsive": true, "lengthChange": false, "autoWidth": false,
                    "buttons": [
                        {
                            extend: 'excelHtml5',
                            title: 'ภาพรวมโครงการมูลค่า'
                        },
                        {
                            extend: 'print',
                            title: 'ภาพรวมโครงการมูลค่า'
                        }
                    ],
                    "pageLength": 5,
                    "fixedHeader": true,
                    "data" : riverBasin,
                    "columns" : [
                        {"data": ['projectName'] ,"width": "70%"},
                        { "data": ['cost'],
                        "render": function (data, type, row) {
                            $datavlue = numberWithCommas(parseFloat(data.toFixed(2)));
                            return $datavlue;
                        },"width": "30%"},
                    ],
                    "order": [[ 1, "desc" ]],
                }).buttons().container().appendTo('#projectCost_wrapper .col-md-6:eq(0)');
                datatTable1Q = $('#projectQuantity').DataTable({
                    "responsive": true, "lengthChange": false, "autoWidth": false,
                    "buttons": [
                        {
                            extend: 'excelHtml5',
                            title: 'ภาพรวมโครงการปริมาณ'
                        },
                        {
                            extend: 'print',
                            title: 'ภาพรวมโครงการปริมาณ'
                        }
                    ],
                    "pageLength": 5,
                    "fixedHeader": true,
                    "data" : riverBasin,
                    "columns" : [
                        {"data": ['projectName'] ,"width": "70%"},
                        { "data": ['quantity'],
                        "render": function (data, type, row) {
                            $datavlue = numberWithCommas(parseFloat(data.toFixed(2)));
                            return $datavlue;
                        },"width": "30%"},
                    ],
                    "order": [[ 1, "desc" ]],
                }).buttons().container().appendTo('#projectQuantity_wrapper .col-md-6:eq(0)')
            }
        });
    }

    function initTableBasin() {
        yearsId = $('#yearsOfPlan option:selected').val();
        $.ajax({
            url:"../util/new-report/loadBasinSum.php",
            data: {yearsId:yearsId},
            method:"POST",
            dataType:"text",
            success:function(data){
                riverBasin =JSON.parse(data);
            },complete: function(data){
                datatTable2C = $('#basinCost').DataTable({
                    "responsive": true, "lengthChange": false, "autoWidth": false,
                    "buttons": [
                        {
                            extend: 'excelHtml5',
                            title: 'ภาพรวมลุ่มน้ำมูลค่า'
                        },
                        {
                            extend: 'print',
                            title: 'ภาพรวมลุ่มน้ำมูลค่า'
                        }
                    ],
                    "pageLength": 5,
                    "fixedHeader": true,
                    "data" : riverBasin,
                    "columns" : [
                        {"data": ['projectName'] ,"width": "70%"},
                        { "data": ['cost'],
                        "render": function (data, type, row) {
                            $datavlue = numberWithCommas(parseFloat(data.toFixed(2)));
                            return $datavlue;
                        },"width": "30%"},
                    ],
                    "order": [[ 1, "desc" ]],
                }).buttons().container().appendTo('#basinCost_wrapper .col-md-6:eq(0)');
                datatTable2Q = $('#basinQuantity').DataTable({
                    "responsive": true, "lengthChange": false, "autoWidth": false,
                    "buttons": [
                        {
                            extend: 'excelHtml5',
                            title: 'ภาพรวมลุ่มน้ำปริมาณ'
                        },
                        {
                            extend: 'print',
                            title: 'ภาพรวมลุ่มน้ำปริมาณ'
                        }
                    ],
                    "pageLength": 5,
                    "fixedHeader": true,
                    "data" : riverBasin,
                    "columns" : [
                        {"data": ['projectName'] ,"width": "70%"},
                        { "data": ['quantity'],
                        "render": function (data, type, row) {
                            $datavlue = numberWithCommas(parseFloat(data.toFixed(2)));
                            return $datavlue;
                        },"width": "30%"},
                    ],
                    "order": [[ 1, "desc" ]],
                }).buttons().container().appendTo('#basinQuantity_wrapper .col-md-6:eq(0)')
            }
        });
    }

    function getRandomColor() {
        var letters = '0123456789ABCDEF';
        var color = '#';
        for (var i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }
    function getListColor() {
        var listcolor =[];
        for (let i = 0; i < 12; i++){
            listcolor.push(getRandomColor());
        }
        // console.log(listcolor);
        return listcolor;
    }
    function toMoney(n) {
        return n.toFixed(2).replace(/(-?\d+)(\d{3})/, "$1,");
    }
    function numberWithCommas(x) {
        x = x.toFixed(0);
        var pattern = /(-?\d+)(\d{3})/;
        while (pattern.test(x))
            x = x.replace(pattern, "$1,$2");
        return x;
    }
    function checkPercent (x){
        if(x > 1){
            x = '<p style="color:green;"><i class="fas fa-arrow-up"></i>  '+x+' %</p>';
        }else if (x == 0){
            growPer = '<p style="color:yellow;"><i class="fas fa-equals"></i>  '+x+' %</p>';
        }else{
            x = '<p style="color:red;"><i class="fas fa-arrow-down"></i>  '+(x)*-1+' %</p>';
        }
        return x;
    }

    function newexportaction(e, dt, button, config) {
        var self = this;
        var oldStart = dt.settings()[0]._iDisplayStart;
        dt.one('preXhr', function (e, s, data) {
            // Just this once, load all data from the server...
            data.start = 0;
            data.length = 2147483647;
            dt.one('preDraw', function (e, settings) {
                // Call the original action function
                if (button[0].className.indexOf('buttons-copy') >= 0) {
                    $.fn.dataTable.ext.buttons.copyHtml5.action.call(self, e, dt, button, config);
                } else if (button[0].className.indexOf('buttons-excel') >= 0) {
                    $.fn.dataTable.ext.buttons.excelHtml5.available(dt, config) ?
                        $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config) :
                        $.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
                } else if (button[0].className.indexOf('buttons-csv') >= 0) {
                    $.fn.dataTable.ext.buttons.csvHtml5.available(dt, config) ?
                        $.fn.dataTable.ext.buttons.csvHtml5.action.call(self, e, dt, button, config) :
                        $.fn.dataTable.ext.buttons.csvFlash.action.call(self, e, dt, button, config);
                } else if (button[0].className.indexOf('buttons-pdf') >= 0) {
                    $.fn.dataTable.ext.buttons.pdfHtml5.available(dt, config) ?
                        $.fn.dataTable.ext.buttons.pdfHtml5.action.call(self, e, dt, button, config) :
                        $.fn.dataTable.ext.buttons.pdfFlash.action.call(self, e, dt, button, config);
                } else if (button[0].className.indexOf('buttons-print') >= 0) {
                    $.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
                }
                dt.one('preXhr', function (e, s, data) {
                    // DataTables thinks the first item displayed is index 0, but we're not drawing that.
                    // Set the property to what it was before exporting.
                    settings._iDisplayStart = oldStart;
                    data.start = oldStart;
                });
                // Reload the grid with the original page. Otherwise, API functions like table.cell(this) don't work properly.
                setTimeout(dt.ajax.reload, 0);
                // Prevent rendering of the full data to the DOM
                return false;
            });
        });
        // Requery the server with the new one-time export settings
        dt.ajax.reload();
    }
})(jQuery);