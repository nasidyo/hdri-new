
(function ($) {
    var platform;
    $.ajax({
        url:"../util/dashboard/loadPlatform.php",
        method:"GET",
        dataType:"text",
        success:function(data){
            platform =JSON.parse(data);
        },complete:function(){
            var numberData=[];
            var label=[];
            for(var i=0;i<platform.length;i++){
                numberData.push(platform[i].id);
                label.push(platform[i].platform);
            }


           var ctx = document.getElementById( "platform" );
           ctx.height = 150;
           var myChart = new Chart( ctx, {
               type: 'line',
               data: {
                   labels:label,
                   type: 'line',
                   datasets: [ {
                       data: numberData,
                       label: 'platform',
                       backgroundColor: 'transparent',
                       borderColor: 'rgba(255,255,255,.55)',
                   }, ]
               },
               options: {
                   maintainAspectRatio: false,
                   legend: {
                       display: false
                   },
                   responsive: true,
                   scales: {
                       xAxes: [ {
                           gridLines: {
                               color: 'transparent',
                               zeroLineColor: 'transparent'
                           },
                           ticks: {
                               fontSize: 4,
                               fontColor: 'transparent'
                           }
                       } ],
                       yAxes: [ {
                           display:false,
                           ticks: {
                               display: false,
                           }
                       } ]
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
           } );

        }
    });



    var login;
    $.ajax({
        url:"../util/dashboard/loadLogin.php",
        method:"GET",
        dataType:"text",
        success:function(data){
            login =JSON.parse(data);
        },complete:function(){
            var numberData=[];
            var label=[];
            for(var i=0;i<login.length;i++){
                numberData.push(login[i].id);
                label.push(login[i].username);
            }


           var ctx = document.getElementById( "username" );
           ctx.height = 150;
           var myChart = new Chart( ctx, {
               type: 'line',
               data: {
                   labels:label,
                   type: 'line',
                   datasets: [ {
                       data: numberData,
                       label: 'Username',
                       backgroundColor: 'transparent',
                       borderColor: 'rgba(255,255,255,.55)',
                   }, ]
               },
               options: {
                   maintainAspectRatio: false,
                   legend: {
                       display: false
                   },
                   responsive: true,
                   scales: {
                       xAxes: [ {
                           gridLines: {
                               color: 'transparent',
                               zeroLineColor: 'transparent'
                           },
                           ticks: {
                               fontSize: 4,
                               fontColor: 'transparent'
                           }
                       } ],
                       yAxes: [ {
                           display:false,
                           ticks: {
                               display: false,
                           }
                       } ]
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
           } );

        }
    });

    var staff;
    $.ajax({
        url:"../util/dashboard/loadStaffINRB.php",
        method:"GET",
        dataType:"text",
        success:function(data){
            staff =JSON.parse(data);
        },complete:function(){
            var numberData=[];
            var label=[];
            for(var i=0;i<staff.length;i++){
                numberData.push(staff[i].staffNum);
                label.push(staff[i].nameRiverBasin);
            }


           var ctx = document.getElementById( "staff" );
           ctx.height = 150;
           var myChart = new Chart( ctx, {
               type: 'line',
               data: {
                   labels:label,
                   type: 'line',
                   datasets: [ {
                       data: numberData,
                       label: 'จำนวน',
                       backgroundColor: 'transparent',
                       borderColor: 'rgba(255,255,255,.55)',
                   }, ]
               },
               options: {
                   maintainAspectRatio: false,
                   legend: {
                       display: false
                   },
                   responsive: true,
                   scales: {
                       xAxes: [ {
                           gridLines: {
                               color: 'transparent',
                               zeroLineColor: 'transparent'
                           },
                           ticks: {
                               fontSize: 2,
                               fontColor: 'transparent'
                           }
                       } ],
                       yAxes: [ {
                           display:false,
                           ticks: {
                               display: false,
                           }
                       } ]
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
           } );

        }
    })

        var permssion = $("#permssion").val();
        var year_bugget = $("#year_bugget").val();
        var idArea = $('#idArea option:selected').val();
        var pieChartIncome=[];
        var pieChartExpense =[];
        var pieChartIncomeDebt =[];
        var pieChartExpenseDebt =[];
        loadIncomeEx1(permssion, year_bugget, idArea);
        loadIncomeExDebt1(permssion, year_bugget, idArea);
        loadIncomeEx2(permssion, year_bugget, idArea);
        loadIncomeExDebt2(permssion, year_bugget, idArea);
        loadIncomeEx3(permssion, year_bugget, idArea);
        loadIncomeExDebt3(permssion, year_bugget, idArea);
        loadIncomeEx4(permssion, year_bugget, idArea);
        loadIncomeExDebt4(permssion, year_bugget, idArea);

    function loadIncomeEx1(permssion, year_bugget, idArea){
        var url1 = "../util/dashboard/loadIncomeEx.php?year="+year_bugget+"&name=กลุ่มวิสาหกิจชุมชน";
        if(permssion == "staff"){
            var url1 = "../util/dashboard/loadIncomeEx.php?year="+year_bugget+"&name=กลุ่มวิสาหกิจชุมชน&area="+idArea;
        }
        var result;
        $.ajax({
            url: url1,
            method:"GET",
            dataType:"text",
            async:false,
            success:function(data){
                result =JSON.parse(data);
            },complete:function(){
                if(result.length!=0){
                    $("#inc1").text(toMoney(parseFloat(result[0].income)));
                    $("#ex1").text(toMoney(parseFloat(result[0].expense)));
                    $("#profit1").text(toMoney(parseFloat(result[0].income)-parseFloat(result[0].expense)));
                    pieChartIncome.push(parseFloat(result[0].income));
                    pieChartExpense.push(parseFloat(result[0].expense));
                }else{
                    $("#inc1").text(0);
                    $("#ex1").text(0);
                    $("#profit1").text(0);
                    pieChartIncome.push(0);
                    pieChartExpense.push(0);
                }


            }
        })
    };
    function loadIncomeExDebt1(permssion, year_bugget, idArea){
        var url2 = "../util/dashboard/loadIncomeExDebt.php?year="+year_bugget+"&name=กลุ่มวิสาหกิจชุมชน";
        if(permssion == "staff"){
            var url2 = "../util/dashboard/loadIncomeExDebt.php?year="+year_bugget+"&name=กลุ่มวิสาหกิจชุมชน&area="+idArea;
        }
        var result;
        $.ajax({
            url: url2,
            method:"GET",
            dataType:"text",
            async:false,
            success:function(data){
                result =JSON.parse(data);
            },complete:function(){
                if(result.length!=0){
                    $("#incdebt1").text(toMoney(parseFloat(result[0].income_debt)));
                    $("#exdebt1").text(toMoney(parseFloat(result[0].expense_debt)));

                    pieChartIncomeDebt.push(parseFloat(result[0].income_debt));
                    pieChartExpenseDebt.push(parseFloat(result[0].expense_debt));
                }else{
                    $("#incdebt1").text(0);
                    $("#exdebt1").text(0);
                    pieChartIncomeDebt.push(0);
                    pieChartExpenseDebt.push(0);
                }
            }
        })
    }

    function loadIncomeEx2(permssion, year_bugget, idArea){
        var url3 = "../util/dashboard/loadIncomeEx.php?year="+year_bugget+"&name=กลุ่มพึ่งตนเอง";
        if(permssion == "staff"){
            var url3 = "../util/dashboard/loadIncomeEx.php?year="+year_bugget+"&name=กลุ่มพึ่งตนเอง&area="+idArea;
        }
        var result;
        $.ajax({
            url: url3,
            method:"GET",
            dataType:"text",
            async:false,
            success:function(data){
                result =JSON.parse(data);
            },complete:function(){
                if(result.length!=0){
                    $("#inc2").text(toMoney(parseFloat(result[0].income)));
                    $("#ex2").text(toMoney(parseFloat(result[0].expense)));
                    $("#profit2").text(toMoney(parseFloat(result[0].income)-parseFloat(result[0].expense)));
                    pieChartIncome.push(parseFloat(result[0].income));
                    pieChartExpense.push(parseFloat(result[0].expense));
                }else{
                    $("#inc2").text(0);
                    $("#ex2").text(0);
                    $("#profit2").text(0);
                    pieChartIncome.push(0);
                    pieChartExpense.push(0);
                }

            }
        })
    }
    function loadIncomeExDebt2(permssion, year_bugget, idArea){
        var url4 = "../util/dashboard/loadIncomeExDebt.php?year="+year_bugget+"&name=กลุ่มพึ่งตนเอง";
        if(permssion == "staff"){
            var url4 = "../util/dashboard/loadIncomeExDebt.php?year="+year_bugget+"&name=กลุ่มพึ่งตนเอง&area="+idArea;
        }
        var result;
        $.ajax({
            url: url4,
            method:"GET",
            dataType:"text",
            async:false,
            success:function(data){
                result =JSON.parse(data);
            },complete:function(){
                if(result.length!=0){
                    $("#incdebt2").text(toMoney(parseFloat(result[0].income_debt)));
                    $("#exdebt2").text(toMoney(parseFloat(result[0].expense_debt)));
                    pieChartIncomeDebt.push(parseFloat(result[0].income_debt));
                    pieChartExpenseDebt.push(parseFloat(result[0].expense_debt));
                }else{
                    $("#incdebt2").text(0);
                    $("#exdebt2").text(0);
                    pieChartIncomeDebt.push(0);
                    pieChartExpenseDebt.push(0);
                }
            }
        })
    }
    function loadIncomeEx3(permssion, year_bugget, idArea){
        var url5 = "../util/dashboard/loadIncomeEx.php?year="+year_bugget+"&name=กลุ่มเตรียมสหกรณ์";
        if(permssion == "staff"){
            var url5 = "../util/dashboard/loadIncomeEx.php?year="+year_bugget+"&name=กลุ่มเตรียมสหกรณ์&area="+idArea;
        }
        var result;
        $.ajax({
            url: url5,
            method:"GET",
            dataType:"text",
            async:false,
            success:function(data){
                result =JSON.parse(data);
            },complete:function(){
                if(result.length!=0){
                    $("#inc3").text(toMoney(parseFloat(result[0].income)));
                    $("#ex3").text(toMoney(parseFloat(result[0].expense)));
                    $("#profit3").text(toMoney(parseFloat(result[0].income)-parseFloat(result[0].expense)));
                    pieChartIncome.push(parseFloat(result[0].income));
                    pieChartExpense.push(parseFloat(result[0].expense));
                }else{
                    $("#inc3").text(0);
                    $("#ex3").text(0);
                    $("#profit3").text(0);
                    pieChartIncome.push(0);
                    pieChartExpense.push(0);

                }

            }
        })
    }
    function loadIncomeExDebt3(permssion, year_bugget, idArea){
        var url6 = "../util/dashboard/loadIncomeExDebt.php?year="+year_bugget+"&name=กลุ่มเตรียมสหกรณ์";
        if(permssion == "staff"){
            var url6 = "../util/dashboard/loadIncomeExDebt.php?year="+year_bugget+"&name=กลุ่มเตรียมสหกรณ์&area="+idArea;
        }
        var result;
        $.ajax({
            url:url6,
            method:"GET",
            dataType:"text",
            async:false,
            success:function(data){
                result =JSON.parse(data);
            },complete:function(){
                if(result.length!=0){
                    $("#incdebt3").text(toMoney(parseFloat(result[0].income_debt)));
                    $("#exdebt3").text(toMoney(parseFloat(result[0].expense_debt)));
                    pieChartIncomeDebt.push(parseFloat(result[0].income_debt));
                    pieChartExpenseDebt.push(parseFloat(result[0].expense_debt));
                }else{
                    $("#incdebt3").text(0);
                    $("#exdebt3").text(0);
                    pieChartIncomeDebt.push(0);
                    pieChartExpenseDebt.push(0);``
                }
            }
        })
    }

    function loadIncomeEx4(permssion, year_bugget, idArea){
        var url7 = "../util/dashboard/loadIncomeEx.php?year="+year_bugget+"&name=กลุ่มสหกรณ์";
        if(permssion == "staff"){
            var url7 = "../util/dashboard/loadIncomeEx.php?year="+year_bugget+"&name=กลุ่มสหกรณ์&area="+idArea;
        }
        var result;
        $.ajax({
            url:url7,
            method:"GET",
            dataType:"text",
            async:false,
            success:function(data){
                result =JSON.parse(data);
            },complete:function(){
                if(result.length!=0){
                    $("#inc4").text(toMoney(parseFloat(result[0].income)));
                    $("#ex4").text(toMoney(parseFloat(result[0].expense)));
                    $("#profit4").text(toMoney(parseFloat(result[0].income)-parseFloat(result[0].expense)));
                    pieChartIncome.push(parseFloat(result[0].income));
                    pieChartExpense.push(parseFloat(result[0].expense));
                }else{
                    $("#inc4").text(0);
                    $("#ex4").text(0);
                    $("#profit4").text(0);
                    pieChartIncome.push(0);
                    pieChartExpense.push(0);
                }

            }
        })
    }
    function loadIncomeExDebt4(permssion, year_bugget, idArea){
        var url8 = "../util/dashboard/loadIncomeExDebt.php?year="+year_bugget+"&name=กลุ่มสหกรณ์";
        if(permssion == "staff"){
            var url8 = "../util/dashboard/loadIncomeExDebt.php?year="+year_bugget+"&name=กลุ่มสหกรณ์&area="+idArea;
        }
        var result;
        $.ajax({
            url: url8,
            method:"GET",
            dataType:"text",
            async:false,
            success:function(data){
                result =JSON.parse(data);
            },complete:function(){
                if(result.length!=0){
                    $("#incdebt4").text(toMoney(parseFloat(result[0].income_debt)));
                    $("#exdebt4").text(toMoney(parseFloat(result[0].expense_debt)));
                    pieChartIncomeDebt.push(parseFloat(result[0].income_debt));
                    pieChartExpenseDebt.push(parseFloat(result[0].expense_debt));
                }else{
                    $("#incdebt4").text(0);
                    $("#exdebt4").text(0);
                    pieChartIncomeDebt.push(0);
                    pieChartExpenseDebt.push(0);
                }
            }
        });
    }

    initpie1(pieChartIncome);
    initpie2(pieChartExpense);
    initpie3(pieChartIncomeDebt);
    initpie4(pieChartExpenseDebt);




    // });
    // $("#account_year").trigger('change');

    function initpie1(pieChartIncome){
        var ctx = document.getElementById( "pieChartIncome" );
        ctx.height = 600;
        // if(window.myChart1 != undefined)
        // window.myChart1.destroy();
        // window.myChart1 = new Chart(ctx, {});
        // ctx.height = 361;

           myChart1 = new Chart( ctx, {
            type: 'pie',
            data: {
                datasets: [ {
                    data: pieChartIncome ,
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

                                } ],
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
                     label: function(tooltipItem, data) {
                         var label = data.labels[tooltipItem.index];
                         var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                         return label + ': ' + toMoney(value) + ' บาท';

                     }
                 }
             }
            }
        } );
    }

    function initpie2(pieChartExpense){

        var ctx = document.getElementById( "pieChartExpense" );
        ctx.height = 600;

        // if(window.myChart2 != undefined)
        // window.myChart2.destroy();
        // window.myChart2 = new Chart(ctx, {});
        // ctx.height = 361;

         myChart2 = new Chart( ctx, {
            type: 'pie',
            data: {
                datasets: [ {
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

                                } ],
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
                     label: function(tooltipItem, data) {
                         var label = data.labels[tooltipItem.index];
                         var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                         return label + ': ' + toMoney(value) + ' บาท';

                     }
                 }
             }
            }
        } );
    }
    function initpie3(pieChartIncomeDebt){

        var ctx = document.getElementById( "pieChartIncomeDebt" );
        ctx.height = 600;
        // if(window.myChart3 != undefined)
        // window.myChart3.destroy();
        // window.myChart3 = new Chart(ctx, {});
        // ctx.height = 361;

         myChart3 = new Chart( ctx, {
            type: 'pie',
            data: {
                datasets: [ {
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

                                } ],
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
                     label: function(tooltipItem, data) {
                         var label = data.labels[tooltipItem.index];
                         var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                         return label + ': ' + toMoney(value) + ' บาท';

                     }
                 }
             }
            }
        } );
    }

    function initpie4(pieChartExpenseDebt){

        var ctx = document.getElementById( "pieChartExpenseDebt" );
        ctx.height = 600;
        // if(window.myChart4 != undefined)
        // window.myChart4.destroy();
        // window.myChart4 = new Chart(ctx, {});
        // ctx.height = 361;

         myChart4 = new Chart( ctx, {
            type: 'pie',
            data: {
                datasets: [ {
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

                                } ],
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
                     label: function(tooltipItem, data) {
                         var label = data.labels[tooltipItem.index];
                         var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                         return label + ': ' + toMoney(value) + ' บาท';

                     }
                 }
             }
            }
        } );
    }

    var ctxVolume = document.getElementById( "pieChartVolume" );
    var ctxValue = document.getElementById( "pieChartValue" );
    var myChartVolume;
    var myChartValue ;
    var listColorChart = getListColor();
    var year_bugget = $("#year_bugget").val();
    var permssion = $("#permssion").val();
    var idArea =$('#idArea option:selected').val();
    if(myChartVolume!=undefined){
        myChartVolume.destroy();
    }
    if(myChartValue!=undefined){
        myChartValue.destroy();
    }

    initChartPersonMarketByMK(year_bugget, permssion, idArea);


    function initChartPersonMarketByMK(year_bugget, permssion){
        var permssion = $("#permssion").val();
        var url = "../util/ReportPMByMkN.php?year="+year_bugget;
        if(permssion == "staff"){
            url = "../util/ReportPMByMkN.php?year="+year_bugget+"&area="+idArea;
        }
        $.ajax({
            url: url,
            method:"GET",
            dataType:"text",
            success:function(data){
                report =JSON.parse(data);
            },complete:function(){
              var labelPM=[];
              var volumnPM=[];
              var totalvaluePM=[];
              if(report.length > 1){
                $("#text-empty-pieChartValue").hide();
                $("#text-empty-pieChartVolume").hide();
                
              }else{
                $("#text-empty-pieChartValue").show();
                $("#text-empty-pieChartVolume").show();
              }
                for(var i=0;i<report.length;i++){
                    labelPM.push(report[i].nameMarket);
                    volumnPM.push(report[i].Volumn);
                    totalvaluePM.push(report[i].TotalValue);
                }
                myChartVolume = new Chart( ctxVolume, {
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

                                        } ]

                    },
                    options: {
                        responsive: true
                        ,
                        tooltips: {
                         callbacks: {
                             label: function(tooltipItem, data) {
                                 var label = data.labels[tooltipItem.index];
                                 var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                                 return label + ': ' + toMoney(value) + ' หน่วย';

                             }
                         }
                     }
                    }
                }  );


                myChartValue = new Chart( ctxValue, {
                    type: 'pie',
                    data: {
                        labels:labelPM,
                        datasets: [ {
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

                                        } ]

                    },
                    options: {
                        responsive: true
                        ,
                        tooltips: {
                         callbacks: {
                             label: function(tooltipItem, data) {
                                 var label = data.labels[tooltipItem.index];
                                 var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                                 return label + ': ' + toMoney(value) + ' บาท';

                             }
                         }
                     }
                    }
                }  );


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
      return listcolor;
    }
    var myLineChart1;
    var myLineChart2;
    var myLineChart3;
    var myLineChart4;

    initChartTotalOfYears(permssion, idArea);
    function initChartTotalOfYears(permssion, idArea){
        var permssion = $("#permssion").val();
        var url = "../util/dashboard/loadTotalOfYears.php";
        if(permssion == "staff"){
            url = "../util/dashboard/loadTotalOfYears.php?area="+idArea;
        }
        $.ajax({
            url:url,
            method:"GET",
            dataType:"text",
            success:function(data){
                report =JSON.parse(data);
            },complete:function(){
                var labelPM=[];
                var totalVolumnPM=[];
                var totalvaluePM=[];
                for(var i=0;i<report.length;i++){
                    labelPM.push(report[i].yearName);
                    totalvaluePM.push(report[i].totalsell);
                    totalVolumnPM.push(report[i].totalplan);
                }

                var ctx = $("#barCharTotalOfYears");
                myLineChart1 = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labelPM,
                        datasets: [{
                            data: totalvaluePM,
                            label: "มูลค่าส่งมอบ",
                            borderColor: "rgba(0,0,0,0.09)",
                            borderWidth: "0",
                            backgroundColor: "rgba(0, 123, 255, 0.5)",
                            fill: false,
                        }, {
                            data: totalVolumnPM,
                            label: "มูลค่าเป้าหมาย",
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
                        },
                        tooltips: {
                            callbacks: {
                                label: function(tooltipItem, data) {
                                    var label = data.labels[tooltipItem.index];
                                    var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                                    return label + ': ' + toMoney(value) +' บาท';
                                }
                            }
                        }
                    }
                });
            }
        });
    }

    initChartTotalOfType(year_bugget, permssion, idArea);
    function initChartTotalOfType(year_bugget, permssion, idArea){
        var permssion = $("#permssion").val();
        var url = "../util/dashboard/loadTotalOfYearsFromType.php?year="+year_bugget;
        if(permssion == "staff"){
            url = "../util/dashboard/loadTotalOfYearsFromType.php?year="+year_bugget+"&area="+idArea;
        }
        $.ajax({
            url: url,
            method:"GET",
            dataType:"text",
            success:function(data){
                report =JSON.parse(data);
            },complete:function(){
                var labelPM=[];
                var totalVolumnPM=[];
                var totalvaluePM=[];
                for(var i=0;i<report.length;i++){
                    labelPM.push(report[i].nameTypeOfArgi);
                    totalvaluePM.push(report[i].totalsell);
                    totalVolumnPM.push(report[i].totalplan);
                }
                var ctx = $("#barCharTotalOfType");
                myLineChart2 = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labelPM,
                        datasets: [{
                            data: totalvaluePM,
                            label: "มูลค่าส่งมอบ",
                            borderColor: "rgba(0,0,0,0.09)",
                            borderWidth: "0",
                            backgroundColor: "rgba(0, 123, 255, 0.5)",
                            fill: false,
                        }, {
                            data: totalVolumnPM,
                            label: "มูลค่าเป้าหมาย",
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
                        },
                        scales: {
                            xAxes: [
                              {
                              ticks: {
                                    autoSkip: false,
                                    maxRotation: 90,
                                    minRotation: 45
                                }
                              }
                            ]
                          },
                        tooltips: {
                            callbacks: {
                                label: function(tooltipItem, data) {
                                    var label = data.labels[tooltipItem.index];
                                    var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                                    return label + ': ' + toMoney(value)+' บาท';
   
                                }
                            }
                        }
                    }
                });
            }
        });
    }

    initChartTotalOfYearsQulity(permssion, idArea);
    function initChartTotalOfYearsQulity(permssion, idArea){
        var permssion = $("#permssion").val();
        var url = "../util/dashboard/loadTotalOfYearsQulity.php";
        if(permssion == "staff"){
            url = "../util/dashboard/loadTotalOfYearsQulity.php?area="+idArea;
        }
        $.ajax({
            url:url,
            method:"GET",
            dataType:"text",
            success:function(data){
                report =JSON.parse(data);
            },complete:function(){
                var labelPM=[];
                var totalVolumnPM=[];
                var totalvaluePM=[];
                for(var i=0;i<report.length;i++){
                    labelPM.push(report[i].yearName);
                    totalvaluePM.push(report[i].totalsell);
                    totalVolumnPM.push(report[i].totalplan);
                }

                var ctx = $("#barCharTotalOfYearsQulity");
                myLineChart3 = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labelPM,
                        datasets: [{
                            data: totalvaluePM,
                            label: "ปริมาณส่งมอบ",
                            borderColor: "rgba(0,0,0,0.09)",
                            borderWidth: "0",
                            backgroundColor: "rgba(0, 255, 255, 0.5)",
                            fill: false,
                        }, {
                            data: totalVolumnPM,
                            label: "ปริมาณเป้าหมาย",
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
                        },
                        tooltips: {
                            callbacks: {
                                label: function(tooltipItem, data) {
                                    var label = data.labels[tooltipItem.index];
                                    var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                                    return label + ': ' + toMoney(value) +' หน่วย';
                                }
                            }
                        }
                    }
                });
            }
        });
    }

    initChartTotalOfTypeQulity(year_bugget, permssion, idArea);
    function initChartTotalOfTypeQulity(year_bugget, permssion, idArea){
        var permssion = $("#permssion").val();
        var url = "../util/dashboard/loadTotalOfYearsFromTypeQulity.php?year="+year_bugget;
        if(permssion == "staff"){
            url = "../util/dashboard/loadTotalOfYearsFromTypeQulity.php?year="+year_bugget+"&area="+idArea;
        }
        $.ajax({
            url: url,
            method:"GET",
            dataType:"text",
            success:function(data){
                report =JSON.parse(data);
            },complete:function(){
                var labelPM=[];
                var totalVolumnPM=[];
                var totalvaluePM=[];
                for(var i=0;i<report.length;i++){
                    labelPM.push(report[i].nameTypeOfArgi);
                    totalvaluePM.push(report[i].totalsell);
                    totalVolumnPM.push(report[i].totalplan);
                }
                var ctx = $("#barCharTotalOfTypeQulity");
                myLineChart4 = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labelPM,
                        datasets: [{
                            data: totalvaluePM,
                            label: "ปริมาณส่งมอบ",
                            borderColor: "rgba(0,0,0,0.09)",
                            borderWidth: "0",
                            backgroundColor: "rgba(0, 255, 255, 0.5)",
                            fill: false,
                        }, {
                            data: totalVolumnPM,
                            label: "ปริมาณเป้าหมาย",
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
                        },
                        scales: {
                            xAxes: [
                              {
                              ticks: {
                                    autoSkip: false,
                                    maxRotation: 90,
                                    minRotation: 45
                                }
                              }
                            ]
                          },
                        tooltips: {
                            callbacks: {
                                label: function(tooltipItem, data) {
                                    var label = data.labels[tooltipItem.index];
                                    var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                                    return label + ': ' + toMoney(value) +' หน่วย';
   
                                }
                            }
                        }
                    }
                });
            }
        });
    }

    loadTotalIncome(permssion, idArea);
    function loadTotalIncome(permssion, idArea){
        var url = "../util/dashboard/loadTotalIncome.php";
        if(permssion == "staff"){
            url = "../util/dashboard/loadTotalIncome.php?area="+idArea;
        }
        $.ajax({
            url: url,
            method:"GET",
            dataType:"text",
            async:false,
            success:function(data){
                result =JSON.parse(data);
            },complete:function(){
                if(result[0].TotalValue > 0 || result[0].TotalValue != null){
                    $("#totalIncome").text( toMoney(parseFloat(result[0].TotalValue))+' บาท');
                }else{
                    $("#totalIncome").text(0 +' บาท');
                }
            }
        })

    };
    loadTotalIncomeInYear(year_bugget, permssion, idArea);
    function loadTotalIncomeInYear(year_bugget, permssion, idArea){
        var url = "../util/dashboard/loadTotalIncome.php?year="+year_bugget;
        if(permssion == "staff"){
            url = "../util/dashboard/loadTotalIncome.php?year="+year_bugget+"&area="+idArea;
        }
        $.ajax({
            url: url,
            method:"GET",
            dataType:"text",
            async:false,
            success:function(data){
                result =JSON.parse(data);
            },complete:function(){
                if(result[0].TotalValue > 0 || result[0].TotalValue != null){
                    $("#totalIncomeInyears").text(toMoney(parseFloat(result[0].TotalValue))+' บาท');
                }else{
                    $("#totalIncomeInyears").text(0+' บาท');
                }
            }
        })
    };

    $('#idArea').change(function(){
        var idArea = $(this).val();
        var year_bugget = $("#year_bugget").val();
        var permssion = $("#permssion").val();

        if(myChartVolume!=undefined){
            myChartVolume.destroy();
        }
        if(myChartValue!=undefined){
            myChartValue.destroy();
        }

        if(myLineChart1!=undefined){
            myLineChart1.destroy();
        }

        if(myLineChart2!=undefined){
            myLineChart2.destroy();
        }

        if(myLineChart3!=undefined){
            myLineChart3.destroy();
        }

        if(myLineChart4!=undefined){
            myLineChart4.destroy();
        }

        initChartTotalOfYears(permssion, idArea);
        initChartTotalOfType(year_bugget, permssion, idArea);
        initChartPersonMarketByMK(year_bugget, permssion, idArea);
        loadTotalIncome(permssion, idArea);
        loadTotalIncomeInYear(year_bugget, permssion, idArea);

        initChartTotalOfYearsQulity(permssion, idArea);
        initChartTotalOfTypeQulity(year_bugget, permssion, idArea);

        var pieChartIncome=[];
        var pieChartExpense =[];
        var pieChartIncomeDebt =[];
        var pieChartExpenseDebt =[];
        loadIncomeEx1(permssion, year_bugget, idArea);
        loadIncomeExDebt1(permssion, year_bugget, idArea);
        loadIncomeEx2(permssion, year_bugget, idArea);
        loadIncomeExDebt2(permssion, year_bugget, idArea);
        loadIncomeEx3(permssion, year_bugget, idArea);
        loadIncomeExDebt3(permssion, year_bugget, idArea);
        loadIncomeEx4(permssion, year_bugget, idArea);
        loadIncomeExDebt4(permssion, year_bugget, idArea);

        initpie1(pieChartIncome);
        initpie2(pieChartExpense);
        initpie3(pieChartIncomeDebt);
        initpie4(pieChartExpenseDebt);
    });

})(jQuery);
