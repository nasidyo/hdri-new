/*
 * Author: Abdullah A Almsaeed
 * Date: 4 Jan 2014
 * Description:
 *      This is a demo file used only for the main dashboard (index.html)
 **/

(function ($) {
  var yearsId = $("#yearsId").val();
  console.log(1111);
  "use strict";

  // Make the dashboard widgets sortable Using jquery UI
  $(".connectedSortable").sortable({
    placeholder: "sort-highlight",
    connectWith: ".connectedSortable",
    handle: ".card-header, .nav-tabs",
    forcePlaceholderSize: true,
    zIndex: 999999,
  });
  $(".connectedSortable .card-header, .connectedSortable .nav-tabs-custom").css(
    "cursor",
    "move"
  );

  // jQuery UI sortable for the todo list
  $(".todo-list").sortable({
    placeholder: "sort-highlight",
    handle: ".handle",
    forcePlaceholderSize: true,
    zIndex: 999999,
  });

  // bootstrap WYSIHTML5 - text editor
  $(".textarea").summernote();


  // jvectormap data
  var visitorsData = {
    US: 398, //USA
    SA: 400, //Saudi Arabia
    CA: 1000, //Canada
    DE: 500, //Germany
    FR: 760, //France
    CN: 300, //China
    AU: 700, //Australia
    BR: 600, //Brazil
    IN: 800, //India
    GB: 320, //Great Britain
    RU: 3000, //Russia
  };

  // The Calender
  // $("#calendar").datetimepicker({
  //   format: "L",
  //   inline: true,
  // });

  // SLIMSCROLL FOR CHAT WIDGET
  // $("#chat-box").overlayScrollbars({
  //   height: "250px",
  // });

  $('#yearsOfPlan').change(function(){
    var yearsId = $("#yearsOfPlan").val();
    // console.log(yearsId);
    if(myChartSalesChartCanvas!=undefined){
      myChartSalesChartCanvas.destroy();
    }
    if(myChartPieChartCanvas!=undefined){
        myChartPieChartCanvas.destroy();
    }
    if(myChartmonthProductCanvas!=undefined){
        myChartmonthProductCanvas.destroy();
    }
    if(myChartComparePriceCanvas!=undefined){
        myChartComparePriceCanvas.destroy();
    }
    if(myChartComparePriceCanvas2!=undefined){
        myChartComparePriceCanvas2.destroy();
    }
    if(myChartCompareBarCanvas!=undefined){
        myChartCompareBarCanvas.destroy();
    }
    initTotalDashBoard();
    initSalesThisMonthChart();
    initPieStandChart();
    initSalePerson();
    initComparePrice();
    initCompareBar();
    initmonthProductChart();
    initSaleAera();
});

  initTotalDashBoard();
  initSalesThisMonthChart();
  initPieStandChart();
  initSalePerson();
  initComparePrice();
  initCompareBar();
  initmonthProductChart();
  initSaleAera();
  function initTotalDashBoard() {
      var yearsId = $("#yearsOfPlan").val();
      $("#borderDashboard").html("");
      $.ajax({
          url:"../util/totalDashBoardMarket.php",
          method:"POST",
          data:{yearsId:yearsId},
          dataType:"text",
          success:function(data){
            console.log(data);
            reportBtn = JSON.parse(data);
          },complete:function(){
              var loopcount = 0;
              if(reportBtn[0].totalPassyers == 0){
                passcalPerss = 100;
              }else{
                var passcalPerss = ((reportBtn[0].totalOnyers - reportBtn[0].totalPassyers)/reportBtn[0].totalPassyers)*100 ;
                passcalPerss = passcalPerss.toFixed(0);
              }
              
              if(passcalPerss > 1){
                passcalPerss = '<p><h4 style="color:green;text-align:right;top: 45%;position: absolute;"> อัตราการเติบโต :  <i class="fas fa-arrow-up"></i>  '+passcalPerss+' %</h4></p>';
              }else if (passcalPerss == 0){
                passcalPerss = '<p><h4 style="color:yellow;text-align:right;top: 45%;position: absolute;"> >อัตราการเติบโต : <i class="fas fa-equals"></i>  '+passcalPerss+' %</h4></p>';
              }else{
                passcalPerss = '<p><h4 style="color:red;text-align:right;top: 45%;position: absolute;"> อัตราการเติบโต : <i class="fas fa-arrow-down"></i>  '+(passcalPerss)*-1+' %</h4></p>';
              }
              var data = '<div class="row">';
              data +='<div class="col-lg-3"><div class="small-box bg-info" style="height: 95%;"><div class="inner" style="height: 90%;">';
              data += '<p><h4>มูลค่าการซื้อขายรวม</h4></p>';
              data += '<p><h3>'+numberWithCommas(reportBtn[0].totalOnyers)+' บาท</h3></p>';
              data += passcalPerss;
              // data += '<p>อัตราการเติบโต : <h5 style="text-align:right;right:40%;top: 53%;position: absolute;">'+passcalPerss.toFixed(0)+' %</h5></p>';
              data += '</div></div></div>';
              data +='<div class="col-lg-9">';
              data += '<div class="row">';
              for(var i=0; i<reportBtn.length; i++){  
                  var calPer = (reportBtn[i].totalValueNow*100) /reportBtn[i].totalOnyers.toFixed(2) ;
                  if(calPer >= 1){
                      var calPer = calPer.toFixed(0);
                  }else{
                      var calPer = calPer.toFixed(2);
                  }
                  var passcalPer = 0;
                  var growPer = '';
                  if(reportBtn[i].totoalValuePass == 0){
                      passcalPer = 100;
                  }else{
                      var passcalPer = ((reportBtn[i].totalValueNow - reportBtn[i].totoalValuePass)/reportBtn[i].totoalValuePass)*100 ;
                      console.log(passcalPer);
                      passcalPer = passcalPer.toFixed(0);
                  }
                  if(passcalPer > 1){
                    growPer = '<p>อัตราการเติบโต : <h5 style="color:green;text-align:right;right:30%;top: 74%;position: absolute;"><i class="fas fa-arrow-up"></i>  '+passcalPer+' %</h5></p>';
                  }else if (passcalPer == 0){
                    growPer = '<p>อัตราการเติบโต : <h5 style="color:yellow;text-align:right;right:30%;top: 74%;position: absolute;"><i class="fas fa-equals"></i>  '+passcalPer+' %</h5></p>';
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
    function initSaleAera() {
        var yearsId = $("#yearsOfPlan").val();
        // $("#salePerson").html("");
        $.ajax({
            url:"../util/reportSalesArea.php",
            method:"POST",
            data:{yearsId:yearsId},
            dataType:"text",
            success:function(data){
              console.log(data);
              $("#topAreaSale tbody").html("");
              $("#topAreaSale tbody").html(data);
            }
        });
    }

    function initSalePerson() {
        var yearsId = $("#yearsOfPlan").val();
        $("#salePerson").html("");
        $.ajax({
            url:"../util/reportSalesPerson.php",
            method:"POST",
            data:{yearsId:yearsId},
            dataType:"text",
            success:function(data){
              // console.log(data);
                $("#salePerson").html(data);
            }
        });
    }

  /* Chart.js Charts */
  // Sales chart
  var salesChartCanvas = document
    .getElementById("revenue-chart-canvas")
    .getContext("2d");
  var myChartSalesChartCanvas;
  //$('#revenue-chart').get(0).getContext('2d');

  function initSalesThisMonthChart (){
      var d = new Date();
      var month = d.getMonth() + 1;
      // var yearsId = d.getFullYear() + 543;
      var yearsId = $("#yearsOfPlan").val();
      $.ajax({
          url:"../util/reportSaleThisMonthy.php",
          method:"POST",
          data:{yearsId:yearsId, month: month},
          dataType:"text",
          success:function(data){
              report = JSON.parse(data);
              // console.log(report);
          },complete:function (){
              var labelPM=[];
              var volumnPM=[];
              var alltotalValue = 0;
              for(var i=0;i<report.length;i++){
                  labelPM.push(report[i].nameTypeOfArgi);
                  volumnPM.push(report[i].volumt);
              }
              myChartSalesChartCanvas = new Chart( salesChartCanvas, {
                  type: "line",
                  data: {
                      labels : labelPM,
                      datasets: [
                          {
                              fill: false,
                              borderColor: "red",
                              data: volumnPM,
                              label: "ผลผลิต"
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
                              return xLabel + ': ' + numberWithCommas(t.yLabel)+ " หน่วย";
                            }
                        }
                      },
                      plugins: {
                        datalabels: {
                          display: false
                        }
                      }
                  }
              });
          }
      });
  }

  // Donut Chart
  var pieChartCanvas = $("#sales-chart-canvas").get(0).getContext("2d");
  pieChartCanvas.height = 300;
  var myChartPieChartCanvas;
  function initPieStandChart (){
      var d = new Date();
      var month = d.getMonth() + 1;
      // var yearsId = d.getFullYear() + 543;
      var yearsId = $("#yearsOfPlan").val();
      $.ajax({
          url:"../util/reportStandardSales.php",
          method:"POST",
          data:{yearsId:yearsId, month: month},
          dataType:"text",
          success:function(data){
              report = JSON.parse(data);
              // console.log(report);
          },complete:function (){
              var labelPM=[];
              var volumnPM=[];
              var labelPMs =[];
              var alltotalValue = 0;
              for(var i=0;i<report.length;i++){
                  labelPM.push(report[i].nameTypeOfStand);
                  volumnPM.push(report[i].volumt);
                  alltotalValue +=report[i].volumt?report[i].volumt:0;
              }
              for(var x=0;x<labelPM.length;x++){
                console.log(labelPM[x]);
                console.log(report[x].volumt);
                var calPer = (report[x].volumt*100) /alltotalValue.toFixed(2) ;
                if(calPer >= 1){
                    var calPer = calPer.toFixed(0);
                }else{
                    var calPer = calPer.toFixed(2);
                }
                labelPMs.push(labelPM[x] +' ('+calPer+'%)');
              }
              myChartPieChartCanvas = new Chart( pieChartCanvas, {
                type: 'doughnut',
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
                        enabled: true,
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
                                return xLabel + ' (ตัน) : ' + numberWithCommas(Label)+' ('+calPer+'%)';
                            }
                        }
                    },
                    plugins: {
                      datalabels: {
                        formatter: (value, ctx) => {
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
                    responsive: true
                }
              });
          }
      });
  }
  // Custom Chart
  var monthProductCanvas = document.getElementById("month-product-canvas");
  monthProductCanvas.height = 100;
  var myChartmonthProductCanvas;
    function initmonthProductChart(){
        var listColorChart = getListColor();
        var d = new Date();
        // var yearsId = d.getFullYear() + 543;
        var yearsId = $("#yearsOfPlan").val();
        $.ajax({
            url:"../util/reportMonthProductChart.php",
            method:"POST",
            data:{yearsId:yearsId},
            dataType:"text",
            success:function(data){
                report = JSON.parse(data);
                // console.log(report);
            },complete:function (){
              var arr = Object.entries(report)
                // console.log(arr);
                var options = {
                  type: 'line',
                  data: {
                      labels: ["ตุลาคม", "พฤศจิกายน", "ธันวาคม", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน"],
                      datasets: []
                  },
                  options: {
                    responsive: true,
                    title: {
                      display: true,
                      text: 'กราฟแสดงมูลค่าการส่งมอบผลผลิต'
                    },plugins: {
                      datalabels: {
                        display: false
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
                    },
                    hover: {
                      mode: 'nearest',
                      intersect: true
                    },
                    scales: {
                      xAxes: [{
                        display: true,
                        scaleLabel: {
                          display: true,
                          labelString: 'เดือน'
                        }
                      }],
                      yAxes: [{
                        display: true,
                        scaleLabel: {
                          display: true,
                          labelString: 'มูลค่า'
                        },ticks: {
                          callback: function(value, index, values) {
                            return numberWithCommas(value);
                          }
                        }
                      }]
                    }
                  }
                }
                myChartmonthProductCanvas = new Chart( monthProductCanvas, options);
              arr.forEach((v,index) => {
                //var color = getRandomColor();
                  setTimeout(() => {
                    myChartmonthProductCanvas.data.datasets.push({
                          data: v[1].dataset,
                          label: v[1].nameTypeOfArgi,
                          fill: false,
                          borderColor: listColorChart[index],
                          backgroundColor:listColorChart[index],
                          borderWidth: "2",
                      });
                      myChartmonthProductCanvas.update()
                  }, parseInt(v[0]))
              })
            }
        });
    }

  // var monthProductData = {
  //   labels: ["ม.ค.", "ก.พ.", "มี.ค.", "เม.ษ.", "พ.ค.", "มิ.ย.", "ก.ค."],
  //   datasets: [
  //     {
  //       label: "ผลผลิตพืซผัก",
  //       data: [190000, 120000, 150000, 180000, 60000, 80000, 60000],
  //       lineTension: 0,
  //       fill: false,
  //       borderColor: "orange",
  //       backgroundColor: "transparent",
  //       borderDash: [5, 5],
  //       pointBorderColor: "orange",
  //       pointBackgroundColor: "rgba(255,150,0,0.5)",
  //       pointRadius: 5,
  //       pointHoverRadius: 10,
  //       pointHitRadius: 30,
  //       pointBorderWidth: 2,
  //       pointStyle: "rectRounded",
  //     },
  //   ],
  // };

  // var monthProductOptions = {
  //   maintainAspectRatio: false,
  //   responsive: true,
  //   legend: {
  //     display: true,
  //     position: "top",
  //     labels: {
  //       boxWidth: 80,
  //       fontColor: "black",
  //     },
  //   },
  // };

  // var monthProductCompare = new Chart(monthProductCanvas, {
  //   type: "line",
  //   data: monthProductData,
  //   options: monthProductOptions,
  // });

  // Compare Price Chart
  var comparePriceCanvas = document.getElementById("compare-price-canvas");
  var myChartComparePriceCanvas;
  var comparePriceCanvas2 = document.getElementById("compare-price-canvas2");
  var myChartComparePriceCanvas2;
  function initComparePrice (){
      var d = new Date();
      var month = d.getMonth() + 1;
      // var yearsId = d.getFullYear() + 543;
      var yearsId = $("#yearsOfPlan").val();
      $.ajax({
          url:"../util/reportComparePriceOfYears.php",
          method:"POST",
          data:{yearsId:yearsId, month: month},
          dataType:"text",
          success:function(data){
              report = JSON.parse(data);
              // console.log(report);
          },complete:function (){
              var labelPM=[];
              var totalSale=[];
              var totalVSale=[];
              var totalPlan=[];
              var totalVPlan=[];
              $("#totalValueOfYears").html("");
              $("#totalVolmnOfYears").html("");
              var thader = '<thead><tr><th></th>';
              var tbody1 = '<tbody><tr>';
              var tbody2 = '<tbody><tr>';
              for(var i=0;i<report.length;i++){
                  thader += '<th> พ.ศ. '+report[i].YearID+'</th>';
                  labelPM.push(report[i].YearID);
                  totalSale.push(report[i].totalsale);
                  totalVSale.push(report[i].totalVSale);
                  totalPlan.push(report[i].totalpaln);
                  totalVPlan.push(report[i].totalVplan);
              }
              thader +='<th>การเติบโต</th></tr></thead>'
              td1 = '<td>มูลค่าส่งมอบ</td>'
              td2 = '<td>มูลค่าเป้าหมาย</td>'
              td5 = '<td>เปลี่ยนแปลง</td>'

              td3 = '<td>ปริมาณส่งมอบ</td>'
              td4 = '<td>ปริมาณเป้าหมาย</td>'
              td6 = '<td>เปลี่ยนแปลง</td>'
              var passcalPer1 = 0;
              var passcalPer2 = 0;
              var passcalPer1 = ((totalSale[totalSale.length-1]- totalSale[totalSale.length-2])/totalSale[totalSale.length-2])*100 ;
              var passcalPer3 = ((totalVSale[totalVSale.length-1]- totalVSale[totalVSale.length-2])/totalVSale[totalVSale.length-2])*100 ;

              var passcalPer2 = ((totalPlan[totalPlan.length-1]- totalPlan[totalPlan.length-2])/totalPlan[totalPlan.length-2])*100 ;
              var passcalPer4 = ((totalVPlan[totalVPlan.length-1]- totalVPlan[totalVPlan.length-2])/totalVPlan[totalVPlan.length-2])*100 ;
              for(var x=0; x<totalSale.length; x++){
                td1 += '<td>'+numberWithCommas(totalSale[x])+'</td>'
                td2 += '<td>'+numberWithCommas(totalPlan[x])+'</td>'

                td5 += '<td>'+checkPercent(numberWithCommas(((totalSale[x]/totalPlan[x])*100)-100))+'</td>'

                td3 += '<td>'+numberWithCommas(totalVSale[x])+'</td>'
                td4 += '<td>'+numberWithCommas(totalVPlan[x])+'</td>'

                td6 += '<td>'+checkPercent(numberWithCommas(((totalVSale[x]/totalVPlan[x])*100)-100))+'</td>'

              }
              var tbody1 = td2+'<td>'+checkPercent(numberWithCommas(passcalPer2))+'</td></tr><tr>'+td1+'<td>'+checkPercent(numberWithCommas(passcalPer1))+'</td></tr><tr>'+td5+'<td></td></tr></tbody>';
              var tbody2 = td4+'<td>'+checkPercent(numberWithCommas(passcalPer4))+'</td></tr><tr>'+td3+'<td>'+checkPercent(numberWithCommas(passcalPer3))+'</td></tr><tr>'+td6+'<td></td></tr></tbody>';
              $("#totalValueOfYears").html(thader+tbody1);
              $("#totalVolmnOfYears").html(thader+tbody2);
              myChartComparePriceCanvas = new Chart( comparePriceCanvas, {
                type: "line",
                data: {
                    labels : labelPM,
                    datasets: [
                        {
                          fill: false,
                          borderColor: "orange",
                          data: totalPlan,
                          label: "มูลค่าเป้าหมาย"
                      },{
                        fill: false,
                        borderColor: "red",
                        data: totalSale,
                        label: "มูลค่าส่งมอบ"
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
                      display: false
                    }
                  }
                }
            });

            myChartComparePriceCanvas2 = new Chart( comparePriceCanvas2, {
              type: "line",
              data: {
                  labels : labelPM,
                  datasets: [
                      {
                        fill: false,
                        borderColor: "orange",
                        data: totalVPlan,
                        label: "ปริมาณเป้าหมาย"
                    },{
                      fill: false,
                      borderColor: "red",
                      data: totalVSale,
                      label: "ปริมาณส่งมอบ"
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
                          return xLabel + ' : ' + numberWithCommas(t.yLabel) +" หน่วย";
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
                      display: false
                    }
                  }
              }
          });
          }
      });
  }
  var compareBarCanvas = document.getElementById("compare-bar-canvas");
  var myChartCompareBarCanvas;
  function initCompareBar(){
    var d = new Date();
      var month = d.getMonth() + 1;
      var yearsId = $("#yearsOfPlan").val();
      $.ajax({
          url:"../util/reportCompareBar.php",
          method:"POST",
          data:{yearsId:yearsId, month: month},
          dataType:"text",
          success:function(data){
            console.log(data);
            report = JSON.parse(data);
          },complete:function (){
            var labels = [];
            var dataset = [];
            var dataPassSet = [];
            var data = report[0].data ;
            for(var i=0;i<data.length;i++){
              labels.push(data[i].nameMarket);
              dataset.push(data[i].TotalValue);
              dataPassSet.push(data[i].TotalValuePass);
            }
            thader ='<thead><tr><th></th>'+report[0].header+'</tr></thead><tbody><tr><td>มูลค่าเป้าหมาย</td>'+report[0].row1+'</tr><tr><td>มูลค่าส่งมอบ</td>'+report[0].row2+'</tr></tbody>'
            $("#tableBarChart").html('');
            $("#tableBarChart").html(thader);
            myChartCompareBarCanvas = new Chart( compareBarCanvas, {
              type: "horizontalBar",
              data: {
                  labels : labels,
                  datasets: [
                      {
                          backgroundColor: [
                            "rgba(138, 223, 226, 1)",
                            "rgba(85, 197, 209, 1)",
                            "rgba(70, 153, 195, 1)",
                            "rgba(255, 214, 126, 1)",
                            "rgba(247, 156, 101, 1)",
                            "rgba(252, 132, 118, 1)",
                                    ],
                          data: dataset,
                          label: "มูลค่า"
                      }
                  ]
              },options: {
                  // responsive: true,
                  // maintainAspectRatio: false,
                  tooltips: {
                    mode: 'index',
                    intersect: false,
                    callbacks: {
                        label: function(t, d) {
                          var xLabel = d.datasets[t.datasetIndex].label;
                                    return xLabel + ': ' + numberWithCommas(t.xLabel) +' บาท'
                          // var xLabel = d.datasets[t.datasetIndex].label;
                          // return xLabel + '(ตัน) : ' + numberWithCommas(t.yLabel);
                        }
                    }
                  },scales: {
                      xAxes: [{
                        display: true,
                        scaleLabel: {
                          display: true,
                          labelString: 'มูลค่า'
                        },ticks: {
                          callback: function(value, index, values) {
                            return numberWithCommas(value);
                          }
                        }
                      }]
                  },
                  plugins: {
                    datalabels: {
                      align: 'end',
                      formatter: (value, context) => {
                        if(dataPassSet[context.dataIndex] <= 0){
                            var calPer = 100
                        }else{
                            var calPer = ((value-dataPassSet[context.dataIndex])/dataPassSet[context.dataIndex])*100 ;
                        }
                        if(calPer >= 1){
                          var calPer = calPer.toFixed(0);
                        }else{
                            var calPer = calPer.toFixed(2);
                        }
                        return  numberWithCommas(value) +' บาท \n'+calPer+'%';
                      },
                      font: {
                        family: 'Arial',
                        size: '14',
                        weight: 'bold',
                      },
                      color: function(context) {
                        var calPer = ((dataset[context.dataIndex]-dataPassSet[context.dataIndex])/dataPassSet[context.dataIndex])*100 ;
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
              }
            });
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
    // console.log (x);
    if(x > 1){
      x = '<p style="color:green;"><i class="fas fa-arrow-up"></i>  '+x+' %</p>';
    }else if (x == 0){
      growPer = '<p style="color:yellow;"><i class="fas fa-equals"></i>  '+x+' %</p>';
    }else{
      x = '<p style="color:red;"><i class="fas fa-arrow-down"></i>  '+(x)*-1+' %</p>';
    }
    return x;
  }
})(jQuery);
