
(function ($) {
  var platform;
  $.ajax({
    url: "../util/dashboard/loadPlatform.php",
    method: "GET",
    dataType: "text",
    success: function (data) {
      platform = JSON.parse(data);
    }, complete: function () {
      var numberData = [];
      var label = [];
      for (var i = 0; i < platform.length; i++) {
        numberData.push(platform[i].id);
        label.push(platform[i].platform);
      }


      var ctx = document.getElementById("platform");
      ctx.height = 150;
      var myChart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: label,
          type: 'line',
          datasets: [{
            data: numberData,
            label: 'platform',
            backgroundColor: 'transparent',
            borderColor: 'rgba(255,255,255,.55)',
          },]
        },
        options: {
          maintainAspectRatio: false,
          legend: {
            display: false
          },
          responsive: true,
          scales: {
            xAxes: [{
              gridLines: {
                color: 'transparent',
                zeroLineColor: 'transparent'
              },
              ticks: {
                fontSize: 4,
                fontColor: 'transparent'
              }
            }],
            yAxes: [{
              display: false,
              ticks: {
                display: false,
              }
            }]
          },
          title: {
            display: false,
          },
          elements: {
            line: {
              borderWidth: 2
            },
            point: {
              radius: 4,
              hitRadius: 10,
              hoverRadius: 4
            }
          }
        }
      });

    }
  });



  var login;
  $.ajax({
    url: "../util/dashboard/loadLogin.php",
    method: "GET",
    dataType: "text",
    success: function (data) {
      login = JSON.parse(data);
    }, complete: function () {
      var numberData = [];
      var label = [];
      for (var i = 0; i < login.length; i++) {
        numberData.push(login[i].id);
        label.push(login[i].username);
      }


      var ctx = document.getElementById("username");
      ctx.height = 150;
      var myChart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: label,
          type: 'line',
          datasets: [{
            data: numberData,
            label: 'Username',
            backgroundColor: 'transparent',
            borderColor: 'rgba(255,255,255,.55)',
          },]
        },
        options: {
          maintainAspectRatio: false,
          legend: {
            display: false
          },
          responsive: true,
          scales: {
            xAxes: [{
              gridLines: {
                color: 'transparent',
                zeroLineColor: 'transparent'
              },
              ticks: {
                fontSize: 4,
                fontColor: 'transparent'
              }
            }],
            yAxes: [{
              display: false,
              ticks: {
                display: false,
              }
            }]
          },
          title: {
            display: false,
          },
          elements: {
            line: {
              borderWidth: 2
            },
            point: {
              radius: 4,
              hitRadius: 10,
              hoverRadius: 4
            }
          }
        }
      });

    }
  });

  var staff;
  $.ajax({
    url: "../util/dashboard/loadStaffINRB.php",
    method: "GET",
    dataType: "text",
    success: function (data) {
      staff = JSON.parse(data);
    }, complete: function () {
      var numberData = [];
      var label = [];
      for (var i = 0; i < staff.length; i++) {
        numberData.push(staff[i].staffNum);
        label.push(staff[i].nameRiverBasin);
      }


      var ctx = document.getElementById("staff");
      ctx.height = 150;
      var myChart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: label,
          type: 'line',
          datasets: [{
            data: numberData,
            label: 'จำนวน',
            backgroundColor: 'transparent',
            borderColor: 'rgba(255,255,255,.55)',
          },]
        },
        options: {
          maintainAspectRatio: false,
          legend: {
            display: false
          },
          responsive: true,
          scales: {
            xAxes: [{
              gridLines: {
                color: 'transparent',
                zeroLineColor: 'transparent'
              },
              ticks: {
                fontSize: 2,
                fontColor: 'transparent'
              }
            }],
            yAxes: [{
              display: false,
              ticks: {
                display: false,
              }
            }]
          },
          title: {
            display: false,
          },
          elements: {
            line: {
              borderWidth: 2
            },
            point: {
              radius: 4,
              hitRadius: 10,
              hoverRadius: 4
            }
          }
        }
      });

    }
  })


  $("#account_year").on('change', function () {
    var year = $(this).val();
    var pieChartIncome = [];
    var pieChartExpense = [];
    var pieChartIncomeDebt = [];
    var pieChartExpenseDebt = [];
    var result;



    $.ajax({
      url: "../util/dashboard/loadIncomeEx.php?year=" + year + "&name=กลุ่มวิสาหกิจชุมชน",
      method: "GET",
      dataType: "text",
      async: false,
      success: function (data) {
        result = JSON.parse(data);
      }, complete: function () {
        if (result.length != 0) {
          $("#inc1").text(toMoney(parseFloat(result[0].income)));
          $("#ex1").text(toMoney(parseFloat(result[0].expense)));
          $("#profit1").text(toMoney(parseFloat(result[0].income) - parseFloat(result[0].expense)));
          pieChartIncome.push(parseFloat(result[0].income));
          pieChartExpense.push(parseFloat(result[0].expense));
        } else {
          $("#inc1").text(0);
          $("#ex1").text(0);
          $("#profit1").text(0);
          pieChartIncome.push(0);
          pieChartExpense.push(0);
        }


      }
    })
    var result;
    $.ajax({
      url: "../util/dashboard/loadIncomeExDebt.php?year=" + year + "&name=กลุ่มวิสาหกิจชุมชน",
      method: "GET",
      dataType: "text",
      async: false,
      success: function (data) {
        result = JSON.parse(data);
      }, complete: function () {
        if (result.length != 0) {
          $("#incdebt1").text(toMoney(parseFloat(result[0].income_debt)));
          $("#exdebt1").text(toMoney(parseFloat(result[0].expense_debt)));

          pieChartIncomeDebt.push(parseFloat(result[0].income_debt));
          pieChartExpenseDebt.push(parseFloat(result[0].expense_debt));
        } else {
          $("#incdebt1").text(0);
          $("#exdebt1").text(0);
          pieChartIncomeDebt.push(0);
          pieChartExpenseDebt.push(0);

        }


      }
    })


    var result;
    $.ajax({
      url: "../util/dashboard/loadIncomeEx.php?year=" + year + "&name=กลุ่มพึ่งตนเอง",
      method: "GET",
      dataType: "text",
      async: false,
      success: function (data) {
        result = JSON.parse(data);
      }, complete: function () {
        if (result.length != 0) {
          $("#inc2").text(toMoney(parseFloat(result[0].income)));
          $("#ex2").text(toMoney(parseFloat(result[0].expense)));
          $("#profit2").text(toMoney(parseFloat(result[0].income) - parseFloat(result[0].expense)));
          pieChartIncome.push(parseFloat(result[0].income));
          pieChartExpense.push(parseFloat(result[0].expense));
        } else {
          $("#inc2").text(0);
          $("#ex2").text(0);
          $("#profit2").text(0);
          pieChartIncome.push(0);
          pieChartExpense.push(0);
        }

      }
    })
    var result;
    $.ajax({
      url: "../util/dashboard/loadIncomeExDebt.php?year=" + year + "&name=กลุ่มพึ่งตนเอง",
      method: "GET",
      dataType: "text",
      async: false,
      success: function (data) {
        result = JSON.parse(data);
      }, complete: function () {
        if (result.length != 0) {
          $("#incdebt2").text(toMoney(parseFloat(result[0].income_debt)));
          $("#exdebt2").text(toMoney(parseFloat(result[0].expense_debt)));
          pieChartIncomeDebt.push(parseFloat(result[0].income_debt));
          pieChartExpenseDebt.push(parseFloat(result[0].expense_debt));
        } else {
          $("#incdebt2").text(0);
          $("#exdebt2").text(0);
          pieChartIncomeDebt.push(0);
          pieChartExpenseDebt.push(0);


        }


      }
    })

    var result;
    $.ajax({
      url: "../util/dashboard/loadIncomeEx.php?year=" + year + "&name=กลุ่มเตรียมสหกรณ์",
      method: "GET",
      dataType: "text",
      async: false,
      success: function (data) {
        result = JSON.parse(data);
      }, complete: function () {
        if (result.length != 0) {
          $("#inc3").text(toMoney(parseFloat(result[0].income)));
          $("#ex3").text(toMoney(parseFloat(result[0].expense)));
          $("#profit3").text(toMoney(parseFloat(result[0].income) - parseFloat(result[0].expense)));
          pieChartIncome.push(parseFloat(result[0].income));
          pieChartExpense.push(parseFloat(result[0].expense));
        } else {
          $("#inc3").text(0);
          $("#ex3").text(0);
          $("#profit3").text(0);
          pieChartIncome.push(0);
          pieChartExpense.push(0);

        }

      }
    })
    var result;
    $.ajax({
      url: "../util/dashboard/loadIncomeExDebt.php?year=" + year + "&name=กลุ่มเตรียมสหกรณ์",
      method: "GET",
      dataType: "text",
      async: false,
      success: function (data) {
        result = JSON.parse(data);
      }, complete: function () {
        if (result.length != 0) {
          $("#incdebt3").text(toMoney(parseFloat(result[0].income_debt)));
          $("#exdebt3").text(toMoney(parseFloat(result[0].expense_debt)));
          pieChartIncomeDebt.push(parseFloat(result[0].income_debt));
          pieChartExpenseDebt.push(parseFloat(result[0].expense_debt));
        } else {
          $("#incdebt3").text(0);
          $("#exdebt3").text(0);
          pieChartIncomeDebt.push(0);
          pieChartExpenseDebt.push(0);

        }



      }
    })


    var result;
    $.ajax({
      url: "../util/dashboard/loadIncomeEx.php?year=" + year + "&name=กลุ่มสหกรณ์",
      method: "GET",
      dataType: "text",
      async: false,
      success: function (data) {
        result = JSON.parse(data);
      }, complete: function () {
        if (result.length != 0) {
          $("#inc4").text(toMoney(parseFloat(result[0].income)));
          $("#ex4").text(toMoney(parseFloat(result[0].expense)));
          $("#profit4").text(toMoney(parseFloat(result[0].income) - parseFloat(result[0].expense)));
          pieChartIncome.push(parseFloat(result[0].income));
          pieChartExpense.push(parseFloat(result[0].expense));
        } else {
          $("#inc4").text(0);
          $("#ex4").text(0);
          $("#profit4").text(0);
          pieChartIncome.push(0);
          pieChartExpense.push(0);
        }

      }
    })
    var result;
    $.ajax({
      url: "../util/dashboard/loadIncomeExDebt.php?year=" + year + "&name=กลุ่มสหกรณ์",
      method: "GET",
      dataType: "text",
      async: false,
      success: function (data) {
        result = JSON.parse(data);
      }, complete: function () {
        if (result.length != 0) {
          $("#incdebt4").text(toMoney(parseFloat(result[0].income_debt)));
          $("#exdebt4").text(toMoney(parseFloat(result[0].expense_debt)));
          pieChartIncomeDebt.push(parseFloat(result[0].income_debt));
          pieChartExpenseDebt.push(parseFloat(result[0].expense_debt));
        } else {
          $("#incdebt4").text(0);
          $("#exdebt4").text(0);
          pieChartIncomeDebt.push(0);
          pieChartExpenseDebt.push(0);
        }


      }
    });


    initpie1(pieChartIncome);
    initpie2(pieChartExpense);
    initpie3(pieChartIncomeDebt);
    initpie4(pieChartExpenseDebt);




  });
  $("#account_year").trigger('change');

  function initpie1(pieChartIncome) {


    var ctx = document.getElementById("pieChartIncome");
    ctx.height = 600;
    if (window.myChart1 != undefined)
      window.myChart1.destroy();
    window.myChart1 = new Chart(ctx, {});
    ctx.height = 600;

    myChart1 = new Chart(ctx, {
      type: 'pie',
      data: {
        datasets: [{
          data: pieChartIncome,
          backgroundColor: [
            "#9ad3bc",
            "#f3eac2",
            "#f5b461",
            "#ec524b"
          ],
          hoverBackgroundColor: [
            "#9ad3bc",
            "#f3eac2",
            "#f5b461",
            "#ec524b"
          ]

        }],
        labels: [
          "กลุ่มวิสาหกิจชุมชน",
          "กลุ่มพึ่งตนเอง",
          "กลุ่มเตรียมสหกรณ์",
          "กลุ่มสหกรณ์"
        ]
      },
      options: {
        responsive: true,
        tooltips: {
          callbacks: {
            label: function (tooltipItem, data) {
              var label = data.labels[tooltipItem.index];
              var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
              return label + ': ' + toMoney(value) + ' บาท';

            }
          }
        }
      }
    });
  }

  function initpie2(pieChartExpense) {

    var ctx = document.getElementById("pieChartExpense");
    ctx.height = 600;

    if (window.myChart2 != undefined)
      window.myChart2.destroy();
    window.myChart2 = new Chart(ctx, {});
    ctx.height = 600;

    myChart2 = new Chart(ctx, {
      type: 'pie',
      data: {
        datasets: [{
          data: pieChartExpense,
          backgroundColor: [
            "#9ad3bc",
            "#f3eac2",
            "#f5b461",
            "#ec524b"
          ],
          hoverBackgroundColor: [
            "#9ad3bc",
            "#f3eac2",
            "#f5b461",
            "#ec524b"
          ]

        }],
        labels: [
          "กลุ่มวิสาหกิจชุมชน",
          "กลุ่มพึ่งตนเอง",
          "กลุ่มเตรียมสหกรณ์",
          "กลุ่มสหกรณ์"
        ]
      },
      options: {
        responsive: true,
        tooltips: {
          callbacks: {
            label: function (tooltipItem, data) {
              var label = data.labels[tooltipItem.index];
              var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
              return label + ': ' + toMoney(value) + ' บาท';

            }
          }
        }
      }
    });
  }
  function initpie3(pieChartIncomeDebt) {

    var ctx = document.getElementById("pieChartIncomeDebt");
    ctx.height = 600;
    if (window.myChart3 != undefined)
      window.myChart3.destroy();
    window.myChart3 = new Chart(ctx, {});
    ctx.height = 600;

    myChart3 = new Chart(ctx, {
      type: 'pie',
      data: {
        datasets: [{
          data: pieChartIncomeDebt,
          backgroundColor: [
            "#9ad3bc",
            "#f3eac2",
            "#f5b461",
            "#ec524b"
          ],
          hoverBackgroundColor: [
            "#9ad3bc",
            "#f3eac2",
            "#f5b461",
            "#ec524b"
          ]

        }],
        labels: [
          "กลุ่มวิสาหกิจชุมชน",
          "กลุ่มพึ่งตนเอง",
          "กลุ่มเตรียมสหกรณ์",
          "กลุ่มสหกรณ์"
        ]
      },
      options: {
        responsive: true,
        tooltips: {
          callbacks: {
            label: function (tooltipItem, data) {
              var label = data.labels[tooltipItem.index];
              var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
              return label + ': ' + toMoney(value) + ' บาท';

            }
          }
        }
      }
    });
  }

  function initpie4(pieChartExpenseDebt) {

    var ctx = document.getElementById("pieChartExpenseDebt");
    ctx.height = 600;
    if (window.myChart4 != undefined)
      window.myChart4.destroy();
    window.myChart4 = new Chart(ctx, {});
    ctx.height = 600;

    myChart4 = new Chart(ctx, {
      type: 'pie',
      data: {
        datasets: [{
          data: pieChartExpenseDebt,
          backgroundColor: [
            "#9ad3bc",
            "#f3eac2",
            "#f5b461",
            "#ec524b"
          ],
          hoverBackgroundColor: [
            "#9ad3bc",
            "#f3eac2",
            "#f5b461",
            "#ec524b"
          ]

        }],
        labels: [
          "กลุ่มวิสาหกิจชุมชน",
          "กลุ่มพึ่งตนเอง",
          "กลุ่มเตรียมสหกรณ์",
          "กลุ่มสหกรณ์"
        ]
      },
      options: {
        responsive: true,
        tooltips: {
          callbacks: {
            label: function (tooltipItem, data) {
              var label = data.labels[tooltipItem.index];
              var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
              return label + ': ' + toMoney(value) + ' บาท';

            }
          }
        }
      }
    });
  }

  var ctxVolume = document.getElementById("pieChartVolume");
  var ctxValue = document.getElementById("pieChartValue");
  var myChartVolume;
  var myChartValue;
  var listColorChart = getListColor();
  $("#search").on('click', function () {
    var year_bugget = $("#year_bugget option:selected").val();
    var market = $("#market_tmp  option:selected").val();
    // var result1;
    // var result2;
    if (year_bugget == 0) {
      alert("กรุณาเลือกตัวเลือก");
      return false;
    }
    if (myChartVolume != undefined) {
      myChartVolume.destroy();
    }
    if (myChartValue != undefined) {
      myChartValue.destroy();
    }



    initChartPersonMarketByMK(year_bugget);

    $.ajax({
      url: "../util/dashboard/loadMarketValueNEW.php?year=" + year_bugget + "&idMarket=" + market,
      method: "GET",
      dataType: "text",
      async: false,
      success: function (data) {
        result = JSON.parse(data);
      }, complete: function () {
        var arr = Object.entries(result);
        var options = {
          type: 'line',
          data: {
            labels: ["ตุลาคม", "พฤศจิกายน", "ธันวาคม", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน"],
            datasets: []
          },
          options: {
            responsive: true,
            tooltips: {
              mode: 'index',
              titleFontSize: 12,
              titleFontFamily: 'Montserrat',
              bodyFontFamily: 'Montserrat',
              cornerRadius: 3,
              yAlign: "bottom",
              intersect: false,
              callbacks: {
                label: function (tooltipItem, data) {
                  var label = data.datasets[tooltipItem.datasetIndex].label;
                  var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                  return label + ': ' + toMoney(value) + ' บาท';

                }
              }
            },
            hover: {
              mode: 'average',
              intersect: true
            },
            scales: {
              xAxes: [{
                display: true,
                gridLines: {
                  display: false,
                  drawBorder: false
                },
                scaleLabel: {
                  display: true,
                  labelString: 'เดือน'
                }
              }],
              yAxes: [{
                display: true,
                gridLines: {
                  display: false,
                  drawBorder: false
                },
                scaleLabel: {
                  display: true,
                  labelString: 'ปริมาณ'
                }
              }]
            },
            title: {
              display: false,
              text: 'Normal Legend'
            }
          }
        }
        var ctx = document.getElementById("market-chart");
        ctx.height = 750;
        if (window.myChartmarket != undefined)
          window.myChartmarket.destroy();
        window.myChartmarket = new Chart(ctx, {});
        ctx.height = 750;
        myChartmarket = new Chart(ctx, options);
        arr.forEach((v, index) => {
          //  console.log(v);
          //     console.log(v[1].dataset);
          myChartmarket.data.datasets.push({
            data: v[1].dataset,
            label: v[1].nameTypeArgi,
            fill: false,
            borderColor: listColorChart[index],
            backgroundColor: listColorChart[index],
            borderWidth: "1",
          });
          myChartmarket.update()
        })
      }
    });
    // $.ajax({
    //     url:"../util/dashboard/loadMarketValue.php?year="+year_bugget+"&idMarket="+market,
    //     method:"GET",
    //     dataType:"text",
    //     async:false,
    //     success:function(data1){
    //         result1 =JSON.parse(data1);
    //     },complete:function(){
    //         $.ajax({
    //             url:"../util/dashboard/loadMarketValue2.php?year="+year_bugget+"&idMarket="+market,
    //             method:"GET",
    //             dataType:"text",
    //             async:false,
    //             success:function(data2){
    //                 result2 =JSON.parse(data2);
    //             },complete:function(){
    //                 var numberData=[];
    //                 var label=[];

    //                 var numberData2=[];
    //                 var label2=[];
    //                 for(var i=0;i<result1.length;i++){
    //                     numberData.push(result1[i].TotalAmount);
    //                     label.push(result1[i].monthName);
    //                 }

    //                 for(var i=0;i<result2.length;i++){
    //                     numberData2.push(result2[i].TotalAmount);
    //                     label2.push(result2[i].monthName);
    //                 }
    //                 var ctx = document.getElementById( "market-chart" );
    //                   ctx.height = 450;

    //                     if(window.myChartmarket != undefined)
    //                         window.myChartmarket.destroy();
    //                         window.myChartmarket = new Chart(ctx, {});

    //                         ctx.height =450;

    //                     myChartmarket = new Chart( ctx, {
    //                         type: 'line',
    //                         data: {
    //                             labels: label,
    //                             type: 'line',
    //                             defaultFontFamily: 'Montserrat',
    //                             datasets: [ {
    //                                 label: "มูลค่าการส่งมอบ",
    //                                 data:numberData,
    //                                 backgroundColor: 'transparent',
    //                                 borderColor: 'rgba(220,53,69,0.75)',
    //                                 borderWidth: 3,
    //                                 pointStyle: 'circle',
    //                                 pointRadius: 5,
    //                                 pointBorderColor: 'transparent',
    //                                 pointBackgroundColor: 'rgba(220,53,69,0.75)',
    //                                     }, {
    //                                         label: "มูลค่าประมาณการ",
    //                                         data: numberData2,
    //                                         backgroundColor: 'transparent',
    //                                         borderColor: 'rgba(40,167,69,0.75)',
    //                                         borderWidth: 3,
    //                                         pointStyle: 'circle',
    //                                         pointRadius: 5,
    //                                         pointBorderColor: 'transparent',
    //                                         pointBackgroundColor: 'rgba(40,167,69,0.75)',
    //                                             }]
    //                         },
    //                         options: {
    //                             responsive: true,

    //                             tooltips: {
    //                                 mode: 'index',
    //                                 titleFontSize: 12,
    //                                 titleFontColor: '#000',
    //                                 bodyFontColor: '#000',
    //                                 backgroundColor: '#fff',
    //                                 titleFontFamily: 'Montserrat',
    //                                 bodyFontFamily: 'Montserrat',
    //                                 cornerRadius: 3,
    //                                 intersect: false,
    //                             },
    //                             legend: {
    //                                 display: false,
    //                                 labels: {
    //                                     usePointStyle: true,
    //                                     fontFamily: 'Montserrat',
    //                                 },
    //                             },
    //                             scales: {
    //                                 xAxes: [ {
    //                                     display: true,
    //                                     gridLines: {
    //                                         display: false,
    //                                         drawBorder: false
    //                                     },
    //                                     scaleLabel: {
    //                                         display: false,
    //                                         labelString: 'Month'
    //                                     }
    //                                         } ],
    //                                 yAxes: [ {
    //                                     display: true,
    //                                     gridLines: {
    //                                         display: false,
    //                                         drawBorder: false
    //                                     },
    //                                     scaleLabel: {
    //                                         display: true,
    //                                         labelString: 'Value'
    //                                     }
    //                                         } ]
    //                             },
    //                             title: {
    //                                 display: false,
    //                                 text: 'Normal Legend'
    //                             }
    //                         }
    //                     } );

    //             }})



    //     }
    // })

  });
  $("#search").trigger('click');


  function initChartPersonMarketByMK(year_bugget) {


    $.ajax({
      url: "../util/ReportPMByMkN.php?year=" + year_bugget,
      method: "GET",
      dataType: "text",
      success: function (data) {
        report = JSON.parse(data);
      }, complete: function () {
        var labelPM = [];
        var volumnPM = [];
        var totalvaluePM = [];


        for (var i = 0; i < report.length; i++) {
          labelPM.push(report[i].nameMarket);
          volumnPM.push(report[i].Volumn);
          totalvaluePM.push(report[i].TotalValue);


        }


        myChartVolume = new Chart(ctxVolume, {
          type: 'pie',
          data: {
            labels: labelPM,
            datasets: [{
              data: volumnPM,
              backgroundColor: [
                "rgba(138, 223, 226, 1)",
                "rgba(85, 197, 209, 1)",
                "rgba(70, 153, 195, 1)",
                "rgba(255, 214, 126, 1)",
                "rgba(247, 156, 101, 1)",
                "rgba(252, 132, 118, 1)",
                "rgba(209, 91, 117, 1)"
              ],
              hoverBackgroundColor: [

                "rgba(138, 223, 226, 1)",
                "rgba(85, 197, 209, 1)",
                "rgba(70, 153, 195, 1)",
                "rgba(255, 214, 126, 1)",
                "rgba(247, 156, 101, 1)",
                "rgba(252, 132, 118, 1)",
                "rgba(209, 91, 117, 1)"
              ]

            }]

          },
          options: {
            responsive: true
            ,
            tooltips: {
              callbacks: {
                label: function (tooltipItem, data) {
                  var label = data.labels[tooltipItem.index];
                  var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                  return label + ': ' + toMoney(value) + ' บาท';

                }
              }
            }
          }
        });


        myChartValue = new Chart(ctxValue, {
          type: 'pie',
          data: {
            labels: labelPM,
            datasets: [{
              data: totalvaluePM,
              backgroundColor: [
                "rgba(138, 223, 226, 1)",
                "rgba(85, 197, 209, 1)",
                "rgba(70, 153, 195, 1)",
                "rgba(255, 214, 126, 1)",
                "rgba(247, 156, 101, 1)",
                "rgba(252, 132, 118, 1)",
                "rgba(209, 91, 117, 1)"
              ],
              hoverBackgroundColor: [

                "rgba(138, 223, 226, 1)",
                "rgba(85, 197, 209, 1)",
                "rgba(70, 153, 195, 1)",
                "rgba(255, 214, 126, 1)",
                "rgba(247, 156, 101, 1)",
                "rgba(252, 132, 118, 1)",
                "rgba(209, 91, 117, 1)"
              ]

            }]

          },
          options: {
            responsive: true
            ,
            tooltips: {
              callbacks: {
                label: function (tooltipItem, data) {
                  var label = data.labels[tooltipItem.index];
                  var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                  return label + ': ' + toMoney(value) + ' บาท';

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
    var listcolor = [];
    for (let i = 0; i < 12; i++) {
      listcolor.push(getRandomColor());
    }
    console.log(listcolor);
    return listcolor;
  }





})(jQuery);
