var header;
(function ($) {



    var ctxM = document.getElementById( "barChartM" );
    var myChartM;
    var ctxG = document.getElementById( "barChartG" );
    var myChartG;
    initChartM();
    initTableM();

    initChartG();
    initTableG();


    $('#idRiverBasin').on('change',function(){

        myChartM.destroy();
        myChartG.destroy();
        $("#dashTableM thead").html("");
        $("#dashTableM tbody").html("");

        $("#dashTableG thead").html("");
        $("#dashTableG tbody").html("");
        var id=this.value;
        if(id==0){
            initChartM();
            initTableM();
            initChartG();
            initTableG();
        }else{
          initChartByRiverM(this.value);
          initTableByRiverM(this.value);
          initChartByRiverG(this.value);
          initTableByRiverG(this.value);
        }

    })


    function initChartM(){

        //    ctx.height = 200;
        var riverBasin ;
        $.ajax({
            url:"../util/loadRiverBasinM.php",
            method:"GET",
            dataType:"text",
            success:function(data){
                riverBasin =JSON.parse(data);
            },complete:function(){
              var label=[];
              var all=[];
              var member=[];
                for(var i=0;i<riverBasin.length;i++){
                    label.push(riverBasin[i].nameRiverBasin);
                    all.push(riverBasin[i].all_member);
                    member.push(riverBasin[i].member);
                }

                 myChartM = new Chart( ctxM, {
                    type: 'horizontalBar',
                    data: {
                        labels: label,
                        datasets: [
                            {
                                label: "เกษตรกรจากที่ดินรายแปลง",
                                data: all,
                                borderColor: "rgba(0, 123, 255, 0.9)",
                                borderWidth: "0",
                                backgroundColor: "rgba(0, 123, 255, 0.5)"
                                        },
                            {
                                label: "เกษตรกรที่ได้รับการส่งเสริม",
                                data:member,
                                borderColor: "rgba(0,0,0,0.09)",
                                borderWidth: "0",
                                backgroundColor: "#28a745"
                                        }
                                    ]
                    },
                    options: {
                        scales: {
                            yAxes: [ {
                                ticks: {
                                    beginAtZero: true
                                }
                                            } ]
                        }
                    }
                } );
            }
        });
    }

    function initChartG(){

        //    ctx.height = 200;
        var riverBasin ;
        $.ajax({
            url:"../util/loadRiverBasinG.php",
            method:"GET",
            dataType:"text",
            success:function(data){
                riverBasin =JSON.parse(data);
            },complete:function(){
              var label=[];
              var all=[];
              var member=[];
                for(var i=0;i<riverBasin.length;i++){
                    label.push(riverBasin[i].nameRiverBasin);
                    all.push(riverBasin[i].all_member);
                    member.push(riverBasin[i].member);
                }

                 myChartG = new Chart( ctxG, {
                    type: 'horizontalBar',
                    data: {
                        labels: label,
                        datasets: [
                            {
                                label: "เกษตรกรจากที่ดินรายแปลง",
                                data: all,
                                borderColor: "rgba(0, 123, 255, 0.9)",
                                borderWidth: "0",
                                backgroundColor: "rgba(0, 123, 255, 0.5)"
                                        },
                            {
                                label: "เกษตรกรที่เป็นสมาชิก",
                                data:member,
                                borderColor: "rgba(0,0,0,0.09)",
                                borderWidth: "0",
                                backgroundColor: "#28a745"
                                        }
                                    ]
                    },
                    options: {
                        scales: {
                            yAxes: [ {
                                ticks: {
                                    beginAtZero: true
                                }
                                            } ]
                        }
                    }
                } );
            }
        });
    }


    function initChartByRiverM(idRiverBasin){
        var area ;
        $.ajax({
            url:"../util/loadAreaM.php?idRiverBasin="+idRiverBasin,
            method:"GET",
            dataType:"text",
            success:function(data){
                area =JSON.parse(data);
            },complete:function(){
              var label=[];
              var all=[];
              var member=[];
                for(var i=0;i<area.length;i++){
                    label.push(area[i].areaName);
                    all.push(area[i].all_member);
                    member.push(area[i].member);
                }

                 myChartM = new Chart( ctxM, {
                    type: 'horizontalBar',
                    data: {
                        labels: label,
                        datasets: [
                            {
                                label: "เกษตรกรจากที่ดินรายแปลง",
                                data: all,
                                borderColor: "rgba(0, 123, 255, 0.9)",
                                borderWidth: "0",
                                backgroundColor: "rgba(0, 123, 255, 0.5)"
                                        },
                            {
                                label: "เกษตรกรที่ได้รับการส่งเสริม",
                                data:member,
                                borderColor: "rgba(0,0,0,0.09)",
                                borderWidth: "0",
                                backgroundColor: "#28a745"
                                        }
                                    ]
                    },
                    options: {
                        scales: {
                            yAxes: [ {
                                ticks: {
                                    beginAtZero: true
                                }
                                            } ]
                        }
                    }
                } );
            }
        });
    }

    function initChartByRiverG(idRiverBasin){
        var area ;
        $.ajax({
            url:"../util/loadAreaG.php?idRiverBasin="+idRiverBasin,
            method:"GET",
            dataType:"text",
            success:function(data){
                area =JSON.parse(data);
            },complete:function(){
              var label=[];
              var all=[];
              var member=[];
                for(var i=0;i<area.length;i++){
                    label.push(area[i].areaName);
                    all.push(area[i].all_member);
                    member.push(area[i].member);
                }

                 myChartG = new Chart( ctxG, {
                    type: 'horizontalBar',
                    data: {
                        labels: label,
                        datasets: [
                            {
                                label: "เกษตรกรจากที่ดินรายแปลง",
                                data: all,
                                borderColor: "rgba(0, 123, 255, 0.9)",
                                borderWidth: "0",
                                backgroundColor: "rgba(0, 123, 255, 0.5)"
                                        },
                            {
                                label: "เกษตรกรที่เป็นสมาชิกกลุ่ม",
                                data:member,
                                borderColor: "rgba(0,0,0,0.09)",
                                borderWidth: "0",
                                backgroundColor: "#28a745"
                                        }
                                    ]
                    },
                    options: {
                        scales: {
                            yAxes: [ {
                                ticks: {
                                    beginAtZero: true
                                }
                                            } ]
                        }
                    }
                } );
            }
        });
    }


    function initTableM(){

        //    ctx.height = 200;
        var riverBasin ;
        var tableData="";
        $.ajax({
            url:"../util/loadRiverBasinM.php",
            method:"GET",
            dataType:"text",
            success:function(data){
                riverBasin =JSON.parse(data);
            },complete:function(){
                for(var i=0;i<riverBasin.length;i++){

                    tableData +='<tr>';
                        tableData +='<td> '+riverBasin[i].nameRiverBasin+'</td>';
                        tableData +='<td> '+riverBasin[i].all_member+'</td>';
                        tableData +='<td>'+riverBasin[i].member+'</td>';
                        if(riverBasin[i].member!=0){
                            tableData +='<td><div class="progress-bar bg-success" role="progressbar" style="width:'+((riverBasin[i].member*100)/riverBasin[i].all_member).toFixed(2)+'% ; color: black;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">'+((riverBasin[i].member*100)/riverBasin[i].all_member).toFixed(2)+'%</div></td>';
                        }else{
                            tableData +='<td>0%</td>';
                        }


	                tableData +='/<tr>';

                }
                    header +=' <th scope="col">พื้นที่ลุ่มน้ำ</th>';
                    header +=' <th scope="col">เกษตรกรจากที่ดินรายแปลง</th>';
                    header +=' <th scope="col">เกษตรกรที่ได้รับการส่งเสริม</th>';
                    header +=' <th scope="col">ร้อยละ</th>';
                    header +=' </tr>';
                $("#dashTableM thead").html(header);
                $("#dashTableM tbody").html(tableData);
            }
        });
    }

    function initTableG(){

        //    ctx.height = 200;
        var riverBasin ;
        var tableData="";
        $.ajax({
            url:"../util/loadRiverBasinG.php",
            method:"GET",
            dataType:"text",
            success:function(data){
                riverBasin =JSON.parse(data);
            },complete:function(){
                for(var i=0;i<riverBasin.length;i++){

                    tableData +='<tr>';
                        tableData +='<td>'+riverBasin[i].nameRiverBasin+'</td>';
                        tableData +='<td>'+riverBasin[i].all_member+'</td>';
                        tableData +='<td>'+riverBasin[i].member+'</td>';
                        if(riverBasin[i].member!=0){
                            tableData +='<td><div class="progress-bar bg-success" role="progressbar" style="width:'+((riverBasin[i].member*100)/riverBasin[i].all_member).toFixed(2)+'% ; color: black;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">'+((riverBasin[i].member*100)/riverBasin[i].all_member).toFixed(2)+'%</div></td>';
                        }else{
                            tableData +='<td>0%</td>';
                        }


	                tableData +='/<tr>';

                }
                    header +=' <th scope="col">พื้นที่ลุ่มน้ำ</th>';
                    header +=' <th scope="col">เกษตรกรจากที่ดินรายแปลง</th>';
                    header +=' <th scope="col">เกษตรกรที่เป็นสมาชิกกลุ่ม</th>';
                    header +=' <th scope="col">ร้อยละ</th>';
                    header +=' </tr>';
                $("#dashTableG thead").html(header);
                $("#dashTableG tbody").html(tableData);
            }
        });
    }


    function initTableByRiverM(idRiverBasin){
        $("#dashTableM thead").html("");
        $("#dashTableM tbody").html("");
        var tableData="";
        var area ;
        $.ajax({
            url:"../util/loadAreaM.php?idRiverBasin="+idRiverBasin,
            method:"GET",
            dataType:"text",
            success:function(data){
                area =JSON.parse(data);
            },complete:function(){
              var label=[];
              var all=[];
              var member=[];
                for(var i=0;i<area.length;i++){
                    tableData +='<tr>';
                    tableData +='<td>'+area[i].areaName+'</td>';
                    tableData +='<td>'+area[i].all_member+'</td>';
                    tableData +='<td>'+area[i].member+'</td>';
                    if(area[i].member!=0){
                        tableData +='<td><div class="progress-bar bg-success" role="progressbar" style="width:'+((area[i].member*100)/area[i].all_member).toFixed(2)+'% ; color: black;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">'+((area[i].member*100)/area[i].all_member).toFixed(2)+'%</div></td>';
                    }else{
                        tableData +='<td>0%</td>';
                    }


                tableData +='/<tr>';

                }
                header +=' <th scope="col">พื้นที่เป้าหมาย</th>';
                    header +=' <th scope="col">เกษตรกรจากที่ดินรายแปลง</th>';
                    header +=' <th scope="col">เกษตรกรที่ได้รับการส่งเสริม</th>';
                    header +=' <th scope="col">ร้อยละ</th>';
                    header +=' </tr>';
                $("#dashTableM thead").html(header);
                $("#dashTableM tbody").html(tableData);

            }
        });
    }

    function initTableByRiverG(idRiverBasin){
        $("#dashTableG thead").html("");
        $("#dashTableG tbody").html("");
        var tableData="";
        var area ;
        $.ajax({
            url:"../util/loadAreaG.php?idRiverBasin="+idRiverBasin,
            method:"GET",
            dataType:"text",
            success:function(data){
                area =JSON.parse(data);
            },complete:function(){
              var label=[];
              var all=[];
              var member=[];
                for(var i=0;i<area.length;i++){
                    tableData +='<tr>';
                    tableData +='<td>'+area[i].areaName+'</td>';
                    tableData +='<td>'+area[i].all_member+'</td>';
                    tableData +='<td>'+area[i].member+'</td>';
                    if(area[i].member!=0){
                        tableData +='<td><div class="progress-bar bg-success" role="progressbar" style="width:'+((area[i].member*100)/area[i].all_member).toFixed(2)+'% ; color: black;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">'+((area[i].member*100)/area[i].all_member).toFixed(2)+'%</div></td>';
                    }else{
                        tableData +='<td>0%</td>';
                    }


                tableData +='/<tr>';

                }
                header +=' <th scope="col">พื้นที่เป้าหมาย</th>';
                    header +=' <th scope="col">เกษตรกรจากที่ดินรายแปลง</th>';
                    header +=' <th scope="col">เกษตรกรที่เป็นสมาชิก</th>';
                    header +=' <th scope="col">ร้อยละ</th>';
                    header +=' </tr>';
                $("#dashTableG thead").html(header);
                $("#dashTableG tbody").html(tableData);

            }
        });
    }










})(jQuery);


