var Table;

var account_year_id ;

var wb ;
var wbout;
function s2ab(s) {
                var buf = new ArrayBuffer(s.length);
                var view = new Uint8Array(buf);
                for (var i=0; i<s.length; i++) view[i] = s.charCodeAt(i) & 0xFF;
                return buf;
}
(function ($) {




    $('#criteria #idRiverBasin').change(function(){
        var idRiverBasin = $(this).val();
         $.ajax({
             url:"../util/AreaDependentWithRole.php",
             method:"POST",
             data:{idRiverBasin:idRiverBasin,idArea:$("#AreaAll").val()},
             dataType:"text",
             success:function(data){
                 $('#criteria #idArea').html(data);
             },complete:function(){
                $('#criteria #idArea').trigger("change");
             }
         });
     });

     $('#criteria #idRiverBasin').trigger('change');

     $('#criteria #idArea').change(function(){
        var idArea = $(this).val();
         $.ajax({
             url:"../util/InstituteDependent.php",
             method:"GET",
             data:{idArea:idArea},
             dataType:"text",
             success:function(data){
                 $('#criteria #institute_id').html(data);
             },complete:function(){
                $('#criteria #institute_id').trigger('change');
             }
         });
     });
     $('#criteria #institute_id').change(function(){
        var institute_id = $(this).val();
         $.ajax({
             url:"../util/loadSubGroupbyIns.php",
             method:"POST",
             data:{institute_id:institute_id},
             dataType:"text",
             success:function(data){
                 $('#criteria #sub_group_id').html(data);
             },complete:function(){
                $('#criteria #sub_group_id').trigger('change');
             }
         });
     });

     $('#criteria #sub_group_id').change(function(){
        var sub_group_id = $(this).val();
        if(sub_group_id==undefined || sub_group_id==null){
            $('#criteria #account_year_id').html("");
            return false;
        }
         $.ajax({
             url:"../util/account/loadAccountYear.php",
             method:"GET",
             data:{sub_group_id:sub_group_id},
             dataType:"text",
             success:function(data){
                 $('#criteria #account_year_id').html(data);
             },complete:function(){
                $('#criteria #account_year_id').trigger('change');
             }
         });
     });

     $('#criteria #idArea').trigger("change");
     $("#export").on('click',function(){

        var Area =jQuery("#idArea option:selected").text();
        var institute =jQuery("#institute option:selected").text();
        var sub_group = jQuery("#sub_group_id option:selected").text();
        var year = jQuery("#account_year_id option:selected").text();
        var name = Area+" "+institute+" "+sub_group+" ปี "+year;


        wb = XLSX.utils.book_new();

        var ws1 = XLSX.utils.table_to_sheet(document.getElementById('AccountTable'),{raw:true});
        var ws2 = XLSX.utils.table_to_sheet(document.getElementById('MoneyTable'),{raw:true});
        var ws3 = XLSX.utils.table_to_sheet(document.getElementById('otherIncomeDetailTable'),{raw:true});
        var ws4 = XLSX.utils.table_to_sheet(document.getElementById('otherExpenseDetailTable'),{raw:true});

        ws2.B5["s"]={ alignment: { wrapText: true, vertical: 'center', horizontal: 'center' } }

        wb.SheetNames.push("งบแสดงฐานะการเงิน");
        wb.SheetNames.push("งบกำไรขาดทุน");



        wb.Sheets["งบแสดงฐานะการเงิน"] =ws1;
        wb.Sheets["งบกำไรขาดทุน"] =ws2;


        var tables = $("#detail table");
        for(var i = 0; i < tables.length; ++i) {
            var ws = XLSX.utils.table_to_sheet(tables[i]);
            var tableName ="รายละเอียดกำไรขาดทุน"+(i+1);
            wb.SheetNames.push(tableName);
            wb.Sheets[tableName] =ws;
          }

          var incOtherPerBG = $("#incOtherPerBG table");
          for(var i = 0; i < incOtherPerBG.length; ++i) {
            var ws = XLSX.utils.table_to_sheet(incOtherPerBG[i]);
            var tableName ="รายได้อื่น"+(i+1);
            wb.SheetNames.push(tableName);
            wb.Sheets[tableName] =ws;
          }

          var exOtherPerBG = $("#exOtherPerBG table");
          for(var i = 0; i < exOtherPerBG.length; ++i) {
            var ws = XLSX.utils.table_to_sheet(exOtherPerBG[i]);
            var tableName ="รายจ่าย"+(i+1);
            wb.SheetNames.push(tableName);
            wb.Sheets[tableName] =ws;
          }

          wb.SheetNames.push("รายละเอียดรายได้อื่น");
          wb.SheetNames.push("รายละเอียดรายจ่ายดำเนินการ");
          wb.Sheets["รายละเอียดรายได้อื่น"] =ws3;
          wb.Sheets["รายละเอียดรายจ่ายดำเนินการ"] =ws4;


         wbout= XLSX.write(wb, {bookType:'xlsx', bookSST:true, type: 'binary',});
    //    exportTableToExcel('report',name);
            saveAs(new Blob([s2ab(wbout)],{type:"application/octet-stream"}), name+'.xlsx');
        window.location.reload();
     });


     $("#search").on('click',function(){
         spinner = $("#loader");

         spinner.show(function(){
            jQuery("#report").load(location.href + " #report",function(){
                 initData();
            });

         });



    })

    function initData(){
        account_year_id = $("#criteria #account_year_id option:selected").val();
        if(account_year_id==undefined || account_year_id=="0"){
            alert('กรุณาเลือกปีบัญชี');
            spinner.hide();
            return false;

        }



         $.ajax({
             url:"../util/account/loadAll.php",
             method:"GET",
             async:false,
             data:{account_year_id:account_year_id},
             dataType:"text",
             success:function(data){
                var item = JSON.parse(data)[0];
                $("#money").text(item.MONEY);
                $("#inc_debt").text(item.inc_debt);
                $("#ex_debt").text(item.ex_debt);
                $("#stocksValue").text(item.stocksValue);
                $("#savingValue").text(item.saving);

                var other_net =  (item.MONEY==null?0:removeComma(item.MONEY)) + (item.stocksValue==null?0:removeComma(item.stocksValue))+(item.inc_debt==null?0:removeComma(item.inc_debt))- (item.ex_debt==null?0:removeComma(item.ex_debt));
                $("#other_net").text(toMoney(other_net));

             }
         });


         var overAll =0;
         $.ajax({
            url:"../util/account/loadIncomExpense.php",
            method:"GET",
            async:false,
            data:{account_year_id:account_year_id},
            dataType:"text",

            success:function(data){
               var item = JSON.parse(data)[0];
               if(item.income_all!=null){
                overAll = removeComma(item.income_all);
               }

               $("#income_all").text(item.income_all);
               $("#expense_all").text(item.expense_all);
               var allPer =0 ;
               var exPer = 0;
               if(overAll!=0){
                    allPer =  (removeComma(item.income_all)*100)/overAll;
                    exPer =  (removeComma(item.expense_all)*100)/overAll;
               }



               $("#allPer").text(allPer.toFixed(2)+" %");
               $("#exPer").text(exPer.toFixed(2)+" %");

               var diff = overAll - removeComma(item.expense_all);
               var diffPer = (diff*100)/removeComma(item.income_all);


               $("#diff").text(toMoney(diff));
               $("#diffPer").text(diffPer.toFixed(2)+" %");


               var expense_othPer =(removeComma(item.expense_oth?item.expense_oth:"0")*100)/removeComma(item.income_all);

               $("#expense_oth").text(item.expense_oth);
               $("#expense_othPer").text(expense_othPer.toFixed(2)+" %");




            }
        });

        var business_group_id_arr = [];
        var business_group_name_arr = [];
        $("#incomePerbg").html('');
        $("#incomePer").html('');
        $("#incomeOther").html('');
        $("#incomeOtherP").html('');
        $("#incomePerGB").html('');
        var business_group_name ="";
        var num=1;
        $.ajax({
            url:"../util/account/loadBgBySubGroup.php",
            method:"GET",
            data:{account_year_id:account_year_id},
            dataType:"text",
            async:false,
            success:function(data){
             var dataArr = JSON.parse(data);
             for ( var item in dataArr ){
                  var business_group_id =dataArr[item].business_group_id;
                  business_group_id_arr.push(business_group_id);
                  business_group_name = dataArr[item].business_group_name;
                  business_group_name_arr.push(business_group_name);
                  $("#bg_name1").append(" ("+business_group_name+num+") <br>");
                  $("#bg_name2").append(" ("+business_group_name+num+") <br>");
                  $("#bg_name3").append(" ("+business_group_name+num+") <br>");
                  $("#bg_name4").append(" ("+business_group_name+num+") <br>");
                  $("#bg_name5").append(" ("+business_group_name+num+") <br>");
                  num+=1;
              }
            },complete:function(){
                var tableHtml ="";
                var tableHtmlBG ="";
                var tableHtmlBGinc ="";
                var count=1;
                for ( var item in business_group_id_arr ){

                    $.ajax({
                        url:"../util/account/loadIncomPerBG.php",
                        method:"GET",
                        data:{business_group_id:business_group_id_arr[item]},
                        dataType:"text",
                        async:false,
                        success:function(data){
                         var dataArr = JSON.parse(data)[0];

                         $("#incomePer").append(dataArr.income+"<br>");
                         $("#incomeOther").append(dataArr.incomeOther+"<br>");
                         $("#incomeOtherP").append(((removeComma(dataArr.incomeOther)*100)/overAll).toFixed(2)+"% <br>");

                         $("#incomePerGB").append(((removeComma(dataArr.income)*100)/overAll).toFixed(2)+" % <br>");

                        }

                    });

                    $.ajax({
                        url:"../util/account/loadExpensePerBG.php",
                        method:"GET",
                        data:{business_group_id:business_group_id_arr[item]},
                        dataType:"text",
                        async:false,
                        success:function(data){
                         var dataArr = JSON.parse(data)[0];

                         $("#expense").append(dataArr.expense+"<br>");
                         $("#expenseOther").append(dataArr.expenseOther+"<br>");
                         $("#expenseOtherP").append(((removeComma(dataArr.expenseOther)*100)/overAll).toFixed(2) +"% <br>");

                         $("#exPerGB").append(((removeComma(dataArr.expense)*100)/overAll).toFixed(2)+" % <br>");
                        }

                    });



                    $.ajax({
                        url:"../util/account/loadOtherPerBG.php",
                        method:"GET",
                        data:{business_group_id:business_group_id_arr[item]},
                        dataType:"text",
                        async:false,
                        success:function(data){
                            var dataArr = JSON.parse(data);

                            tableHtmlBG    +='<div class="card">';
                            tableHtmlBG        +='<div class="card-header">';
                            tableHtmlBG            +='<div class="row justify-content-between">';
                            tableHtmlBG                +='<div class="col-md-8 "> <strong class="card-title">รายจ่ายอื่น'+dataArr[0].business_group_name+' '+count+'*</strong>        </div>';
                            tableHtmlBG            +='</div>';
                            tableHtmlBG        +='</div>';
                            tableHtmlBG        +='<div class="card-body">';
                            tableHtmlBG            +='<table id="otherIncomeDetailTable" class="table table-bordered dataTable no-footer" style="text-align: center; border-left-width: 0px; width: 1115px;" role="grid" aria-describedby="otherIncomeDetailTable_info">';
                            tableHtmlBG                +='<thead>';
                            tableHtmlBG                +='<tr style=" border-left-width: thick; " role="row">';
                            tableHtmlBG                    +='<th style="vertical-align: middle; width: 76px;" class="sorting_desc" tabindex="0" aria-controls="otherIncomeDetailTable" rowspan="1" colspan="1" aria-sort="descending" aria-label=" activate to sort column ascending">รายการ</th>';
                            tableHtmlBG                    +='<th style="vertical-align: middle; width: 186px;" class="sorting" tabindex="0" aria-controls="otherIncomeDetailTable" rowspan="1" colspan="1" aria-label="activate to sort column ascending">บาท</th>';
                            tableHtmlBG                    +='<th style="vertical-align: middle; width: 186px;" class="sorting" tabindex="0" aria-controls="otherIncomeDetailTable" rowspan="1" colspan="1" aria-label="activate to sort column ascending">%</th>';
                            tableHtmlBG                +='</tr>';
                            tableHtmlBG                +='</thead>';
                            tableHtmlBG                +='<tbody>';
                            var exTmp=0;
                            for(var i in dataArr ){
                               if(dataArr[i].type=="ex"){
                                exTmp +=removeComma(dataArr[i].amount);
                               }
                           }

                            for(var i in dataArr){
                                if(dataArr[i].type=="ex"){
                                    tableHtmlBG                +='<tr role="row">';
                                    tableHtmlBG                    +='<td style="text-align: end;">'+dataArr[i].name+'</td>';
                                    tableHtmlBG                    +='<td class="numItem" t="s">'+dataArr[i].amount+'</td>';
                                    tableHtmlBG                    +='<td class="numItem" t="s">'+((dataArr[i].amount==null?0:removeComma(dataArr[i].amount)*100)/(exTmp==0?1:exTmp)).toFixed(2)+'%</td>';
                                    tableHtmlBG                +='</tr>';

                                }
                            }

                            tableHtmlBG                +='</tbody>';
                            tableHtmlBG            +='</table>';
                            tableHtmlBG        +='</div>';
                            tableHtmlBG    +='</div>';
                            jQuery("#exOtherPerBG").html(tableHtmlBG);



                            tableHtmlBGinc    +='<div class="card">';
                            tableHtmlBGinc        +='<div class="card-header">';
                            tableHtmlBGinc            +='<div class="row justify-content-between">';
                            tableHtmlBGinc                +='<div class="col-md-8 "> <strong class="card-title">รายได้อื่น'+dataArr[0].business_group_name+' '+count+'*</strong>        </div>';
                            tableHtmlBGinc            +='</div>';
                            tableHtmlBGinc        +='</div>';
                            tableHtmlBGinc        +='<div class="card-body">';
                            tableHtmlBGinc            +='<table id="otherIncomeDetailTable" class="table table-bordered dataTable no-footer" style="text-align: center; border-left-width: 0px; width: 1115px;" role="grid" aria-describedby="otherIncomeDetailTable_info">';
                            tableHtmlBGinc                +='<thead>';
                            tableHtmlBGinc                +='<tr style=" border-left-width: thick; " role="row">';
                            tableHtmlBGinc                    +='<th style="vertical-align: middle; width: 76px;" class="sorting_desc" tabindex="0" aria-controls="otherIncomeDetailTable" rowspan="1" colspan="1" aria-sort="descending" aria-label=" activate to sort column ascending">รายการ</th>';
                            tableHtmlBGinc                    +='<th style="vertical-align: middle; width: 186px;" class="sorting" tabindex="0" aria-controls="otherIncomeDetailTable" rowspan="1" colspan="1" aria-label="activate to sort column ascending">บาท</th>';
                            tableHtmlBGinc                    +='<th style="vertical-align: middle; width: 186px;" class="sorting" tabindex="0" aria-controls="otherIncomeDetailTable" rowspan="1" colspan="1" aria-label="activate to sort column ascending">%</th>';
                            tableHtmlBGinc                +='</tr>';
                            tableHtmlBGinc                +='</thead>';
                            tableHtmlBGinc                +='<tbody>';
                            var incTmp=0;
                            for(var i in dataArr ){
                               if(dataArr[i].type=="inc"){
                                incTmp +=removeComma(dataArr[i].amount);
                               }
                           }

                            for(var i in dataArr){
                                if(dataArr[i].type=="inc"){
                                    tableHtmlBGinc                +='<tr role="row">';
                                    tableHtmlBGinc                    +='<td style="text-align: end;">'+dataArr[i].name+'</td>';
                                    tableHtmlBGinc                    +='<td class="numItem" t="s">'+dataArr[i].amount+'</td>';
                                    tableHtmlBGinc                    +='<td class="numItem" t="s">'+((dataArr[i].amount==null?0:removeComma(dataArr[i].amount)*100)/(incTmp==0?1:incTmp)).toFixed(2)+'%</td>';
                                    tableHtmlBGinc                +='</tr>';

                                }
                            }

                            tableHtmlBGinc                +='</tbody>';
                            tableHtmlBGinc            +='</table>';
                            tableHtmlBGinc        +='</div>';
                            tableHtmlBGinc    +='</div>';

                            jQuery("#incOtherPerBG").html(tableHtmlBGinc);
                        }

                    })

                    $.ajax({
                        url:"../util/account/loadIncomDetailPerBG.php",
                        method:"GET",
                        data:{business_group_id:business_group_id_arr[item]},
                        dataType:"text",
                        async:false,
                        success:function(data){
                         var dataArr = JSON.parse(data);


                            tableHtml +='<div class="card"> ';
                            tableHtml +='<div class="card-header"> ';
                            tableHtml +='    <div class="row justify-content-between"> ';
                            tableHtml +='        <div class="col-md-8 "> ';
                            tableHtml +='            <strong class="card-title">รายละเอียดงบกำไร (ขาดทุน) '+dataArr[0].business_group_name+" "+count+"*"+'</strong> ';
                            tableHtml +='        </div> ';
                            tableHtml +='    </div> ';
                            tableHtml +='</div> ';
                            tableHtml +=' <div class="card-body"> ';

                            tableHtml +='        <table id="MoneyDetailTable" class="table table-bordered dataTable no-footer" style="text-align: center; border-left-width: 0px; width: 1115px;" role="grid" aria-describedby="MoneyDetailTable_info"> ';
                            tableHtml +='            <thead> ';
                            tableHtml +='                <tr style=" border-left-width: thick; " role="row"> ';
                            tableHtml +='                <th style="vertical-align: middle; width: 76px;" class="sorting_desc" tabindex="0" aria-controls="MoneyDetailTable" rowspan="1" colspan="1" aria-sort="descending" aria-label=" activate to sort column ascending">รายการ</th> ';
                            tableHtml +='                <th style="vertical-align: middle; width: 186px;" class="sorting" tabindex="0" aria-controls="MoneyDetailTable" rowspan="1" colspan="1" aria-label="activate to sort column ascending">บาท</th> ';
                            tableHtml +='                <th style="vertical-align: middle; width: 186px;" class="sorting" tabindex="0" aria-controls="MoneyDetailTable" rowspan="1" colspan="1" aria-label="activate to sort column ascending">%</th> ';

                            tableHtml +='            </thead> ';


                            tableHtml +='         <tbody> ';
                            tableHtml +='             <tr role="row"> ';
                            tableHtml +='                <td style="font-weight: 900;text-align: end;">ขาย/บริการ</td> ';
                            tableHtml +='                <td></td> ';
                            tableHtml +='                <td></td> ';
                            tableHtml +='            </tr> ';
                            var other=0;
                            var otherPer=0;
                            for(var i in dataArr){
                                if(dataArr[i].type=="inc"){
                                    otherPer+=removeComma(dataArr[i].income);
                                }

                            }

                            for(var i in dataArr){
                                if(dataArr[i].type=="inc"){
                                    tableHtml +='             <tr role="row"> ';
                                    tableHtml +='                <td style="font-weight: 900;text-align: end;">'+dataArr[i].ORDER_NAME+'</td> ';
                                    tableHtml +='                <td  class="numItem" t="s"> '+ toMoney(parseFloat(dataArr[i].income))+'</td> ';
                                    tableHtml +='                <td class="numItem" t="s" >'+((removeComma(dataArr[i].income)*100)/otherPer).toFixed(2)+'% </td> ';
                                    tableHtml +='            </tr> ';
                                    other+= removeComma(dataArr[i].income);
                                }
                            }

                            tableHtml +='            <tr role="row"  > ';
                            tableHtml +='                <td style="font-weight: 900;text-align: end;">รวม</td> ';
                            tableHtml +='                <td class="numItem" t="s">'+toMoney(other)+'</td> ';
                            tableHtml +='                <td class="numItem" t="s"> 100 %</td> ';
                            tableHtml +='            </tr> ';
                            tableHtml +='            <tr role="row"  style="text-align: start;" > ';
                            tableHtml +='                <td >ต้นทุน</td> ';
                            otherEx =0;
                            otherExPer =0;
                            for(var i in dataArr){
                                if(dataArr[i].type=="ex"){
                                    otherExPer+= removeComma(dataArr[i].income);
                                }
                            }

                            for(var i in dataArr){
                                if(dataArr[i].type=="ex"){
                                    otherEx+= removeComma(dataArr[i].income);
                                }
                            }
                            tableHtml +='                <td class="numItem" t="s">'+toMoney(otherEx)+'</td> ';
                            tableHtml +='                <td class="numItem" t="s">'+((otherEx*100)/other).toFixed(2)+'% </td> ';
                            tableHtml +='            </tr> ';
                            tableHtml +='            <tr role="row" style="text-align: start;"> ';
                            tableHtml +='                <td >กำไรขั้นต้น</td> ';
                            tableHtml +='                <td class="numItem" t="s">'+toMoney((other-otherEx))+'</td> ';
                            tableHtml +='                <td class="numItem" t="s">'+(((other-otherEx)*100)/other).toFixed(2)+'% </td> ';
                            tableHtml +='            </tr> ';

                            var data_exAll =0;
                            $.ajax({
                                url:"../util/account/loadExDetailPerBG.php",
                                method:"GET",
                                data:{business_group_id:business_group_id_arr[item]},
                                dataType:"text",
                                async:false,
                                success:function(data_ex){
                                 var dataArr = JSON.parse(data_ex);
                                 for(var i in dataArr){
                                    data_exAll += parseFloat(dataArr[i].exOther);
                                 }

                                }
                            });

                            tableHtml +='            <tr role="row" style="text-align: start;"> ';
                            tableHtml +='                <td >ค่าใช้จ่ายในการดำเนินงาน</td> ';
                            tableHtml +='                <td class="numItem" t="s"> '+toMoney(data_exAll)+'</td> ';
                            tableHtml +='                <td class="numItem" t="s">'+((data_exAll*100)/other).toFixed(2)+'% </td> ';
                            tableHtml +='            </tr> ';
                            var data_debtAll =0;
                            $.ajax({
                                url:"../util/account/loadIncomeDebtPerBG.php",
                                method:"GET",
                                data:{business_group_id:business_group_id_arr[item]},
                                dataType:"text",
                                async:false,
                                success:function(data_ex){
                                 var dataArr = JSON.parse(data_ex);
                                 for(var i in dataArr){
                                    data_debtAll += parseFloat(dataArr[i].debt);
                                 }

                                }
                            });



                            tableHtml +='            <tr role="row" style="font-weight: 900;text-align: end;"> ';
                            tableHtml +='                <td >ลูกหนี้การค้า</td> ';
                            tableHtml +='                <td class="numItem" t="s"> '+toMoney(data_debtAll)+'</td>  ';
                            tableHtml +='                <td class="numItem" t="s">'+((data_debtAll*100)/other).toFixed(2)+'% </td> ';
                            tableHtml +='             </tr> ';
                            tableHtml +='            <tr role="row" style="font-weight: 900;text-align: end;"> ';
                            tableHtml +='                <td >กำไรสุทธิ</td> ';
                            tableHtml +='                <td class="numItem" t="s"> '+toMoney( (other-otherEx)-(data_exAll + data_debtAll) )+'</td>  ';
                            tableHtml +='                <td  class="numItem" t="s">'+(( ((other-otherEx)-(data_exAll + data_debtAll))*100)/other).toFixed(2)+'% </td> ';
                            tableHtml +='             </tr> ';
                            tableHtml +='        </tbody> ';
                            tableHtml +='   </table> ';
                            tableHtml +='</div> ';
                            tableHtml +='</div> ';

                            jQuery("#detail").html(tableHtml);

                        }

                    });



                    count +=1;





                }
                var expenseData = jQuery("#expense").html().trim().split('<br>');
                var incomeData = jQuery("#incomePer").html().trim().split('<br>');
                var expenseOtherData = jQuery("#expenseOther").html().trim().split('<br>');
                var incomeOther = jQuery("#incomeOther").html().trim().split('<br>');
                var result=0;


                for(var i =0;i<expenseData.length-1;i++){
                    var cal = removeComma(incomeData[i])   -  removeComma(expenseData[i]);

                    result += (cal+ removeComma(incomeOther[i]) )- removeComma(expenseOtherData[i]) ;
                    jQuery("#diffPerGB").append(cal+"<br>") ;
                    jQuery("#diff_am").append(toMoney(cal)+"<br>") ;
                    jQuery("#diff_amP").append( ((cal*100)/overAll).toFixed(2)  +"% <br>") ;


                }
                jQuery("#result").text( toMoney(result)) ;
                jQuery("#resultP").text( ((result*100)/overAll).toFixed(2) +"%") ;
                spinner.hide();

            }
        });


    var htmlIncOther="";
    var htmlExOther="";
        $.ajax({
            url:"../util/account/loadOtherAll.php",
            method:"GET",
            data:{account_year_id:account_year_id},
            dataType:"text",
            async:false,
            success:function(data){
             var dataArr = JSON.parse(data);
             htmlIncOther +='<div class="card">';
             htmlIncOther +='<div class="card-header">';
             htmlIncOther +='    <div class="row justify-content-between">';
             htmlIncOther +='        <div class="col-md-8 ">';
             htmlIncOther +='             <strong class="card-title">รายละเอียดรายได้อื่น</strong>';
             htmlIncOther +='        </div>';
             htmlIncOther +='     </div>';
             htmlIncOther +=' </div>';
             htmlIncOther +='<div class="card-body">';
             htmlIncOther +='        <table id="otherIncomeDetailTable" class="table table-bordered dataTable no-footer" style="text-align: center; border-left-width: 0px; width: 1115px;" role="grid" aria-describedby="otherIncomeDetailTable_info">';
             htmlIncOther +='            <thead>';
             htmlIncOther +='                <tr style=" border-left-width: thick; " role="row">';
             htmlIncOther +='                <th style="vertical-align: middle; width: 76px;" class="sorting_desc" tabindex="0" aria-controls="otherIncomeDetailTable" rowspan="1" colspan="1" aria-sort="descending" aria-label=" activate to sort column ascending">รายการ</th>';
             htmlIncOther +='                <th style="vertical-align: middle; width: 186px;" class="sorting" tabindex="0" aria-controls="otherIncomeDetailTable" rowspan="1" colspan="1" aria-label="activate to sort column ascending">บาท</th>';
             htmlIncOther +='                <th style="vertical-align: middle; width: 186px;" class="sorting" tabindex="0" aria-controls="otherIncomeDetailTable" rowspan="1" colspan="1" aria-label="activate to sort column ascending">%</th>';
             htmlIncOther +='            </thead>';
             htmlIncOther +='        <tbody>';
            var incTmp=0;
             for(var i in dataArr ){
                if(dataArr[i].type=="inc"){
                    incTmp +=removeComma(dataArr[i].amount);
                }
            }
                    for(var i in dataArr ){
                        if(dataArr[i].type=="inc"){
                            htmlIncOther +='             <tr role="row" >';
                            htmlIncOther +='                 <td style="text-align: end;">'+dataArr[i].name+'</td>';
                            htmlIncOther +='                 <td class="numItem" t="s">'+dataArr[i].amount+'</td>';
                            htmlIncOther +='                 <td class="numItem" t="s">'+((dataArr[i].amount==null?0:removeComma(dataArr[i].amount)*100)/(incTmp==0?1:incTmp)).toFixed(2)+' %</td>';
                            htmlIncOther +='             </tr>';

                        }
                    }

             htmlIncOther +='            <tr role="row" >';
             htmlIncOther +='                <td style="font-weight: 900;text-align: end;">รวม</td>';
             htmlIncOther +='               <td class="numItem" t="s">'+toMoney(incTmp)+'</td>';
             htmlIncOther +='               <td class="numItem" t="s">'+((incTmp*100)/incTmp).toFixed(2)+' %</td>';
             htmlIncOther +='             </tr>';

             htmlIncOther +='        </tbody>';
             htmlIncOther +='    </table>';
             htmlIncOther +=' </div>';
             htmlIncOther +='</div> ';
             jQuery("#incOther").html(htmlIncOther);


             var exTmp=0;
             for(var i in dataArr ){
                if(dataArr[i].type=="ex"){
                    exTmp +=removeComma(dataArr[i].amount);
                }
            }


             htmlExOther+=' <div class="card"> ';
             htmlExOther+='                   <div class="card-header"> ';
             htmlExOther+='                        <div class="row justify-content-between"> ';
             htmlExOther+='                           <div class="col-md-8 "> ';
             htmlExOther+='                               <strong class="card-title">รายละเอียดรายจ่ายในการดำเนินการ</strong> ';
             htmlExOther+='                           </div> ';
             htmlExOther+='                       </div> ';
             htmlExOther+='                   </div> ';
             htmlExOther+='                   <div class="card-body"> ';

             htmlExOther+='                           <table id="otherExpenseDetailTable" class="table table-bordered dataTable no-footer" style="text-align: center; border-left-width: 0px; width: 1115px;" role="grid" aria-describedby="otherExpenseDetailTable_info"> ';
             htmlExOther+='                                <thead> ';
             htmlExOther+='                                   <tr style=" border-left-width: thick; " role="row"> ';
             htmlExOther+='                                   <th style="vertical-align: middle; width: 76px;" class="sorting_desc" tabindex="0" aria-controls="otherExpenseDetailTable" rowspan="1" colspan="1" aria-sort="descending" aria-label=" activate to sort column ascending">รายการ</th> ';
             htmlExOther+='                                   <th style="vertical-align: middle; width: 186px;" class="sorting" tabindex="0" aria-controls="otherExpenseDetailTable" rowspan="1" colspan="1" aria-label="activate to sort column ascending">บาท</th> ';
             htmlExOther+='                                   <th style="vertical-align: middle; width: 186px;" class="sorting" tabindex="0" aria-controls="otherExpenseDetailTable" rowspan="1" colspan="1" aria-label="activate to sort column ascending">%</th> ';

             htmlExOther+='                                </thead> ';


             htmlExOther+='                            <tbody> ';

             for(var i in dataArr ){
                if(dataArr[i].type=="ex"){
                    htmlExOther+='                              <tr role="row"  > ';
                    htmlExOther+='                                    <td style="text-align: end;" >'+dataArr[i].name+'</td> ';
                    htmlExOther+='                                    <td class="numItem" t="s">'+dataArr[i].amount+'</td> ';
                    htmlExOther+='                                    <td class="numItem" t="s">'+(( removeComma(dataArr[i].amount)*100)/exTmp).toFixed(2)+' %</td> ';
                    htmlExOther+='                               </tr> ';


                }
            }


             htmlExOther+='                                <tr role="row" > ';
             htmlExOther+='                                    <td  style="text-align: end;"  >รวม</td> ';
             htmlExOther+='                                    <td class="numItem" t="s">'+toMoney(exTmp)+'</td> ';
             htmlExOther+='                                   <td class="numItem" t="s">'+((exTmp*100)/exTmp).toFixed(2)+' %</td> ';
             htmlExOther+='                               </tr> ';


             htmlExOther+='                           </tbody> ';
             htmlExOther+='                       </table> ';
             htmlExOther+='                   </div> ';
             htmlExOther+='               </div> ';


             jQuery("#exOther").html(htmlExOther);
            }



        });
    }




    function exportTableToExcel(tableID, filename = ''){
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
