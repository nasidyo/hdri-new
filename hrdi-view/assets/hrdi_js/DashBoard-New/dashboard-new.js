/*
 * Author: Abdullah A Almsaeed
 * Date: 4 Jan 2014
 * Description:
 *      This is a demo file used only for the main dashboard (index.html)
 **/

(function ($) {
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

  initTotalDashBoard();
  initSalesThisMonthChart();
  initPieStandChart();
  initSalePerson();
  initComparePrice();
  initCompareBar();
  initmonthProductChart();
  function initTotalDashBoard() {
      var d = new Date();
      var yearsId = d.getFullYear() + 543;
      $("#borderDashboard").html("");
      $.ajax({
          url:"../util/totalDashBoardMarket.php",
          method:"POST",
          data:{yearsId:yearsId},
          dataType:"text",
          success:function(data){
              $("#borderDashboard").html(data);
          }
      });
  }

    function initSalePerson() {
        var d = new Date();
        var yearsId = d.getFullYear() + 543;
        $("#salePerson").html("");
        $.ajax({
            url:"../util/reportSalesPerson.php",
            method:"POST",
            data:{yearsId:yearsId},
            dataType:"text",
            success:function(data){
              console.log(data);
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
      var yearsId = d.getFullYear() + 543;
      console.log(month," :: ",yearsId);
      $.ajax({
          url:"../util/reportSaleThisMonthy.php",
          method:"POST",
          data:{yearsId:yearsId, month: month},
          dataType:"text",
          success:function(data){
              report = JSON.parse(data);
              console.log(report);
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
                              label: "?????????????????? (?????????)"
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

  // Donut Chart
  var pieChartCanvas = $("#sales-chart-canvas").get(0).getContext("2d");
  pieChartCanvas.height = 300;
  var myChartPieChartCanvas;
  function initPieStandChart (){
      var d = new Date();
      var month = d.getMonth() + 1;
      var yearsId = d.getFullYear() + 543;
      $.ajax({
          url:"../util/reportStandardSales.php",
          method:"POST",
          data:{yearsId:yearsId, month: month},
          dataType:"text",
          success:function(data){
              report = JSON.parse(data);
              console.log(report);
          },complete:function (){
              var labelPM=[];
              var volumnPM=[];
              var alltotalValue = 0;
              for(var i=0;i<report.length;i++){
                  labelPM.push(report[i].nameTypeOfStand);
                  volumnPM.push(report[i].volumt);
                  alltotalValue +=report[i].volumt?report[i].volumt:0;
              }
              myChartPieChartCanvas = new Chart( pieChartCanvas, {
                type: 'doughnut',
                data: {
                    labels:labelPM,
                    datasets: [ {
                        data: volumnPM,
                        backgroundColor: [
                            "rgba(138, 223, 226, 1)",
                            "rgba(85, 197, 209, 1)",,
                            "rgba(247, 156, 101, 1)",
                                        ],
                        hoverBackgroundColor: [
                            "rgba(138, 223, 226, 1)",
                            "rgba(85, 197, 209, 1)",
                            "rgba(247, 156, 101, 1)",
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
                                return xLabel + ' (?????????) : ' + toMoney(Label)+' ('+calPer.toFixed(2)+'%)';
                            }
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
        var yearsId = d.getFullYear() + 543;
        $.ajax({
            url:"../util/reportMonthProductChart.php",
            method:"POST",
            data:{yearsId:yearsId},
            dataType:"text",
            success:function(data){
                report = JSON.parse(data);
                console.log(report);
            },complete:function (){
              var arr = Object.entries(report)
                console.log(arr);
                var options = {
                  type: 'line',
                  data: {
                      labels: ["??????????????????", "???????????????????????????", "?????????????????????", "??????????????????", "??????????????????????????????", "??????????????????", "??????????????????", "?????????????????????", "????????????????????????", "?????????????????????", "?????????????????????", "?????????????????????"],
                      datasets: []
                  },
                  options: {
                    responsive: true,
                    title: {
                      display: true,
                      text: '???????????????????????????????????????????????????????????????????????????????????????'
                    },
                    tooltips: {
                      mode: 'index',
                      intersect: false,
                      callbacks: {
                          label: function(t, d) {
                            var xLabel = d.datasets[t.datasetIndex].label;
                            return xLabel + ': ' + toMoney(t.yLabel);
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
                          labelString: '???????????????'
                        }
                      }],
                      yAxes: [{
                        display: true,
                        scaleLabel: {
                          display: true,
                          labelString: '??????????????????'
                        },ticks: {
                          callback: function(value, index, values) {
                            return toMoney(value);
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
  //   labels: ["???.???.", "???.???.", "??????.???.", "??????.???.", "???.???.", "??????.???.", "???.???."],
  //   datasets: [
  //     {
  //       label: "????????????????????????????????????",
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
      var yearsId = d.getFullYear() + 543;
      $.ajax({
          url:"../util/reportComparePriceOfYears.php",
          method:"POST",
          data:{yearsId:yearsId, month: month},
          dataType:"text",
          success:function(data){
              report = JSON.parse(data);
              console.log(report);
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
                  thader += '<th> ???.???. '+report[i].YearID+'</th>';
                  labelPM.push(report[i].YearID);
                  totalSale.push(report[i].totalsale);
                  totalVSale.push(report[i].totalVSale);
                  totalPlan.push(report[i].totalpaln);
                  totalVPlan.push(report[i].totalVplan);
              }
              thader +='</tr></thead>'
              td1 = '<td>????????????????????????????????????</td>'
              td2 = '<td>??????????????????????????????????????????</td>'

              td3 = '<td>???????????????????????????????????? (?????????)</td>'
              td4 = '<td>?????????????????????????????????????????? (?????????)</td>'
              for(var x=0; x<totalSale.length; x++){
                td1 += '<td>'+toMoney(totalSale[x])+'</td>'
                td2 += '<td>'+toMoney(totalPlan[x])+'</td>'

                td3 += '<td>'+toMoney(totalVSale[x])+'</td>'
                td4 += '<td>'+toMoney(totalVPlan[x])+'</td>'
              }
              var tbody1 = td1+'</tr><tr>'+td2+'</tr></tbody>';
              var tbody2 = td3+'</tr><tr>'+td4+'</tr></tbody>';
              $("#totalValueOfYears").html(thader+tbody1);
              $("#totalVolmnOfYears").html(thader+tbody2);
              myChartComparePriceCanvas = new Chart( comparePriceCanvas, {
                type: "line",
                data: {
                    labels : labelPM,
                    datasets: [
                        {
                            fill: false,
                            borderColor: "red",
                            data: totalSale,
                            label: "????????????????????????????????????"
                        },
                        {
                          fill: false,
                          borderColor: "orange",
                          data: totalPlan,
                          label: "??????????????????????????????????????????"
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

            myChartComparePriceCanvas2 = new Chart( comparePriceCanvas2, {
              type: "line",
              data: {
                  labels : labelPM,
                  datasets: [
                      {
                          fill: false,
                          borderColor: "red",
                          data: totalVSale,
                          label: "????????????????????????????????????"
                      },
                      {
                        fill: false,
                        borderColor: "orange",
                        data: totalVPlan,
                        label: "??????????????????????????????????????????"
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
                          return xLabel + '(?????????) : ' + toMoney(t.yLabel);
                        }
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
      var yearsId = d.getFullYear() + 543;
      $.ajax({
          url:"../util/reportCompareBar.php",
          method:"POST",
          data:{yearsId:yearsId, month: month},
          dataType:"text",
          success:function(data){
              report = JSON.parse(data);
              console.log(report);
          },complete:function (){
            var labels = [];
            var dataset = [];
            var data = report[0].data ;
            for(var i=0;i<data.length;i++){
              labels.push(data[i].nameMarket);
              dataset.push(data[i].TotalValue);
            }
            thader ='<thead><tr><th></th>'+report[0].header+'</tr></thead><tbody><tr><td>??????????????????????????????????????????</td>'+report[0].row1+'</tr><tr><td>????????????????????????????????????</td>'+report[0].row2+'</tr></tbody>'
            $("#tableBarChart").html('');
            $("#tableBarChart").html(thader);
            myChartCompareBarCanvas = new Chart( compareBarCanvas, {
              type: "horizontalBar",
              data: {
                  labels : labels,
                  datasets: [
                      {
                          backgroundColor: [
                                      "#3e95cd",
                                      "#8e5ea2",
                                      "#3cba9f",
                                      "#e8c3b9",
                                      "#c45850",
                                    ],
                          data: dataset,
                          label: "??????????????????"
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
                                    return xLabel + ': ' + toMoney(t.xLabel) +' ?????????'
                          // var xLabel = d.datasets[t.datasetIndex].label;
                          // return xLabel + '(?????????) : ' + toMoney(t.yLabel);
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
      console.log(listcolor);
      return listcolor;
  }
  function toMoney(n) {
      return n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
}
})(jQuery);
