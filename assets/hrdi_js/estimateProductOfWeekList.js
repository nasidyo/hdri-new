(function ($) {
    var spinner = $('#loader');
    var permssion = $('#permssion').val();
    initTable();
    function initTable (){
        var monthId = $('#monthId').val();
        var idOutputValue = $('#idOutputValue').val();
        var Table = $('#estimateProductOfWeekList-Table').DataTable( {
            "language": {
                "emptyTable": "ยังไม่ได้กรอกข้อมูลแผนหรือแผนยังไม่ได้รับการอนุมัติ"
            },
            "dom": '<"topbuttons"B>frt<"bottombuttons">ip',
            'buttons': [],
            "processing": true,
            "responsive": true,
            "serverSide": true,
            "ajax": "../server_side/estimateProductDetailOfWeek.php?monthId="+monthId+"&idOutputValue="+idOutputValue,
            "autoWidth": false,
            'fixedColumns':   {
            'heightMatch': 'none'
            },
            'columnDefs': [{
                "targets": [2],
                "width": 125,
            },{
                'targets': [3],
                'width': 130,
                'searchable': false,
                'orderable': false,
                'className': 'dt-header-center',
                'render': function (data, type, row){
                    if(permssion == "staff" || permssion == "admin"){
                        return "<div style=' font-size: 20px; '><input id='"+row[2]+"_totalQuality' name='"+row[2]+"_totalQuality' value='"+parseFloat((data)).toFixed(2)+"' onkeypress='return isNumberKey(this,event)' class='form-control' type='text'></div>";
                    }else{
                        return toMoney(parseFloat(data));
                    }
                }
            },{
                'targets': [4],
                'width': 130,
                'searchable': false,
                'orderable': false,
                'className': 'dt-header-center',
                'render': function (data, type, row){
                    if(permssion == "staff" || permssion == "admin"){
                        return "<div style=' font-size: 20px; '><input id='"+row[2]+"_pricePerProduct' name='"+row[2]+"_pricePerProduct' value='"+parseFloat((data)).toFixed(2)+"' onkeypress='return isNumberKey(this,event)' class='form-control' type='text'></div>";
                    }else{
                        return toMoney(parseFloat(data));
                    }
                }
            },{
                'targets': [5],
                'width': 130,
                'render': function (data, type, full, meta){
                        return toMoney(parseFloat(data));
                }
            },{
                'targets': [6],
                "visible": false
            }
            ],
            "footerCallback": function ( row, data, start, end, display ) {
                var api = this.api(), data;
                // Remove the formatting to get integer data for summation
                var intVal = function ( i ) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '')*1 :
                        typeof i === 'number' ?
                            i : 0;
                };
                qualityTotal = api
                    .column( 3, { page: 'current'} )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
                // Update footer
                $( api.column( 3 ).footer() ).html(
                    toMoney(parseFloat(qualityTotal))
                );
                priceTotal = api
                    .column( 5, { page: 'current'} )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
                // Update footer
                $( api.column( 5 ).footer() ).html(
                    toMoney(parseFloat(priceTotal)) +" บาท"
                );
            },
            'order': [[2, 'asc']],
        } );
    }
    // $('#estimateProductOfWeekList-Table tbody').on('click', '#editEstimateProductOfWeekList', function () {
    //     var Table= $('#estimateProductOfWeekList-Table').DataTable();
    //     var data = Table.row( $(this).parents('tr') ).data();
    //     var dataInputUpdate = Table.row( $(this).parents('tr') ).nodes().to$().find('input').val();
    //     $.ajax({
    //         url:"../handler/estimateProductHandler.php",
    //         method:"POST",
    //         data: {idOutputValue: idOutputValue, dataInputUpdate: dataInputUpdate, action: "update", week: data[2], monthId: monthId},
    //         dataType:"text",
    //         success:function(data){
    //             initTable();
    //         }
    //     });
    // } );
    if(permssion == "staff" || permssion == "admin"){
        $('.bottombuttons').html("<div class='row form-group' style='float: right;'><div class='col col-sm-12' id='editBtn'><button type='button' class='btn btn-info' href='javascript:void(0)' id='editOnTableBtn' name='editOnTableBtn' ><i class='fa fa-edit'></i>&nbsp; แก้ไขทั้งหมด</button></div></div>");
    }
    function toMoney(n) {
        return n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
    }

    if(permssion == "staff" && permssion == "admin"){
        var table = $('#estimateProductOfWeekList-Table').DataTable();
        // Hide two columns
        table.columns([6]).visible( false );
    }
    $('#editOnTableBtn').click( function() {
        spinner.show();
        var monthId = $('#monthId').val();
        var idOutputValue = $('#idOutputValue').val();
        Table = $('#estimateProductOfWeekList-Table').DataTable();
        var data = Table.$('input').serialize().split('&');
        console.log(data);
        var obj={};
        var tempid = '';
        var listProductPlan = [];
        for(var key in data) {
            if(tempid != data[key].split("_")[0]){
                if(tempid!= ''){
                    listProductPlan.push(obj);
                    var obj={};
                    tempid = data[key].split("_")[0];
                }else{
                    tempid = data[key].split("_")[0];
                }
                obj.id = data[key].split("_")[0];
                obj[data[key].split("_")[1].split("=")[0]] = data[key].split("_")[1].split("=")[1];
            }else{
                obj[data[key].split("_")[1].split("=")[0]] = data[key].split("_")[1].split("=")[1];
            }
            obj.idOutputValue = idOutputValue;
            obj.monthId = monthId;
        }
        if(obj != ''){
            console.log(obj);
            listProductPlan.push(obj);
        }
        console.log(listProductPlan);
        $.ajax({
            url:"../handler/estimateProductHandler.php",
            method:"POST",
            data: {data: listProductPlan, action: "updatelist"},
            dataType:"text",
            success:function(data){
                Table.ajax.reload();
            },complete:function(){
                spinner.hide();
            }
        });
    });
})(jQuery);

