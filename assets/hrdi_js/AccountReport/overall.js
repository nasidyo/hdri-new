var spinner;
(function ($) {


    spinner = $("#loader");

    $("#acc_btn").on('click',function(){

        spinner.show();
        $("#year_display").html("");
        var year = $("#account_year").val();

        $("#year_display").html(year);
        var old_year =$("input:radio[name='old_year']:checked").val();
        var ins_taget = $("#institute option:selected").val();
        var ins=[];
        var ins_name=[];
        var month_name=[];
        var  dataDisplay =[];
        var money_ex=[];
        var money_inc=[];
        var ex_debt=[];
        var income_debt=[];
        if(ins_taget!="" && year!="" && old_year ==""){
            $.ajax({
                url:"../util/dashboard/loadAccByIns1Y.php?year="+year+"&ins_taget="+ins_taget,
                method:"GET",
                dataType:"text",
                success:function(data){


                    var itemArr = JSON.parse(data);

                    if(itemArr.length==0){
                        return false;
                    }
                    for(var result of itemArr){
                        ins.push(result.INSTITUTE_NAME);

                        month_name.push(result.Month_TH);
                        if(result.TRAN_TYPE=="EXPENCE"){
                            ex_debt.push(result.EX_DEBT);
                            money_ex.push(result.MONEY);
                        }else if(result.TRAN_TYPE=="RECEIVE"){
                            income_debt.push(result.INC_DEBT);
                            money_inc.push(result.MONEY);
                        }

                    }

                    var month_TH =month_name.filter(onlyUnique);
                    var  income = {
                        x: month_TH,
                        y: money_inc,
                        name: 'รายรับ ',
                        type: 'bar',
                        marker: {
                            color: '#28a745'
                          }
                      };
                      var  expense = {
                        x: month_TH,
                        y: money_ex,
                        name: 'รายจ่าย ',
                        type: 'bar',
                        marker: {
                            color: '#dc3545'
                          }
                      };

                      var  ex_debt_T = {
                        x: month_TH,
                        y: ex_debt,
                        name: 'เจ้าหนี้ ',
                        type: 'bar',
                        marker: {
                            color: '#17a2b8'
                          }
                      };

                      var  income_debt_T = {
                        x: month_TH,
                        y: income_debt,
                        name: 'ลูกหนี้การค้า ',
                        type: 'bar',
                        marker: {
                            color: '#ffc107'
                          }

                      };

                      dataDisplay.push(income);
                      dataDisplay.push(expense);
                      dataDisplay.push(income_debt_T);
                      dataDisplay.push(ex_debt_T);

                },complete:function(){

                      var layout = {barmode: 'group'};

                      var config = {responsive: true}
                      Plotly.newPlot('overall', dataDisplay,layout ,config);
                      spinner.hide();
                }
            });
        } else if(ins_taget!=""  && old_year !="" ){

            $.ajax({
                url:"../util/dashboard/loadAccByIns1Y.php?year="+year+"&old_year="+old_year+"&ins_taget="+ins_taget,
                method:"GET",
                dataType:"text",
                success:function(data){

                    var itemArr = JSON.parse(data);
                    for(var result of itemArr){
                        ins.push(result.INSTITUTE_NAME+" "+result.year);


                        if(result.TRAN_TYPE=="EXPENCE"){
                            ex_debt.push(result.EX_DEBT);
                            money_ex.push(result.MONEY);
                        }else if(result.TRAN_TYPE=="RECEIVE"){
                            income_debt.push(result.INC_DEBT);
                            money_inc.push(result.MONEY);
                        }

                    }

                    var ins_name =ins.filter(onlyUnique);
                    var  income = {
                        x: ins_name,
                        y: money_inc,
                        name: 'รายรับ ',
                        type: 'bar',
                        marker: {
                            color: '#28a745'
                          }
                      };
                      var  expense = {
                        x: ins_name,
                        y: money_ex,
                        name: 'รายจ่าย ',
                        type: 'bar',
                        marker: {
                            color: '#dc3545'
                          }
                      };

                      var  ex_debt_T = {
                        x: ins_name,
                        y: ex_debt,
                        name: 'เจ้าหนี้ ',
                        type: 'bar',
                        marker: {
                            color: '#17a2b8'
                          }
                      };

                      var  income_debt_T = {
                        x: ins_name,
                        y: income_debt,
                        name: 'ลูกหนี้การค้า ',
                        type: 'bar',
                        marker: {
                            color: '#ffc107'
                          }

                      };

                      dataDisplay.push(income);
                      dataDisplay.push(expense);
                      dataDisplay.push(income_debt_T);
                      dataDisplay.push(ex_debt_T);

                },complete:function(){

                      var layout = {barmode: 'group'};

                      var config = {responsive: true}
                      Plotly.newPlot('overall', dataDisplay,layout ,config);
                      spinner.hide();
                }
            });


        }else {
            $.ajax({
                url:"../util/dashboard/loadAccByIns1Y.php?year="+year+"&old_year="+old_year+"&ins_taget="+ins_taget,
                method:"GET",
                dataType:"text",
                success:function(data){

                    var itemArr = JSON.parse(data);
                    for(var result of itemArr){
                        ins.push(result.INSTITUTE_NAME+" "+result.year);


                        if(result.TRAN_TYPE=="EXPENCE"){
                            ex_debt.push(result.EX_DEBT);
                            money_ex.push(result.MONEY);
                        }else if(result.TRAN_TYPE=="RECEIVE"){
                            income_debt.push(result.INC_DEBT);
                            money_inc.push(result.MONEY);
                        }

                    }

                    var ins_name =ins.filter(onlyUnique);
                    var  income = {
                        x: ins_name,
                        y: money_inc,
                        name: 'รายรับ ',
                        type: 'bar',
                        marker: {
                            color: '#28a745'
                          }
                      };
                      var  expense = {
                        x: ins_name,
                        y: money_ex,
                        name: 'รายจ่าย ',
                        type: 'bar',
                        marker: {
                            color: '#dc3545'
                          }
                      };

                      var  ex_debt_T = {
                        x: ins_name,
                        y: ex_debt,
                        name: 'เจ้าหนี้ ',
                        type: 'bar',
                        marker: {
                            color: '#17a2b8'
                          }
                      };

                      var  income_debt_T = {
                        x: ins_name,
                        y: income_debt,
                        name: 'ลูกหนี้การค้า ',
                        type: 'bar',
                        marker: {
                            color: '#ffc107'
                          }

                      };

                      dataDisplay.push(income);
                      dataDisplay.push(expense);
                      dataDisplay.push(income_debt_T);
                      dataDisplay.push(ex_debt_T);

                },complete:function(){

                      var layout = {barmode: 'group'};

                      var config = {responsive: true}
                      Plotly.newPlot('overall', dataDisplay,layout ,config);
                      spinner.hide();
                }
            });
        }


    });
    $("#account_year").trigger('change');

















})(jQuery);

function onlyUnique(value, index, self) {
    return self.indexOf(value) === index;
  }
