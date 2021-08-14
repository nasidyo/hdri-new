(function ($) {
    var area_Id = $('#area_Id').val();
    var years_Id = $('#years_Id').val();
    var Table= $('#estimateProductList-Table').DataTable();
    Table.destroy();
    initDataTable();
    initTable();
    
    function initDataTable() {
        var years_Id = $('#years_Id').val();
        var typeOfAgri_Id = $('#typeOfAgri_Id option:selected').val();
        var agri_Id = $('#agri_Id option:selected').val();
        var month_id = $('#month_id option:selected').val();
        var market_id = $('#market_id option:selected').val();
        console.log('years_Id', years_Id ,":typeOfAgri_Id ", typeOfAgri_Id ,": agri_Id", agri_Id ,":month_id", month_id);
        Table = $('#estimateProductList-Table').DataTable( {
            "language": {
                "emptyTable": "ยังไม่ได้กรอกข้อมูลแผนหรือแผนยังไม่ได้รับการอนุมัติ"
            },
            "processing": true,
            "responsive": true,
            "serverSide": true,
            "ajax": "../server_side/estimateProductDetail.php?yearsId="+years_Id+"&area_Id="+area_Id+"&typeOfAgri_Id="+typeOfAgri_Id+"&agri_Id="+agri_Id+"&month_id="+month_id+"&market_id="+market_id,
            "autoWidth": false,
            'fixedColumns':   {
              'heightMatch': 'none'
            },
            'columnDefs': [{
                "targets": [0,1,2],
                    "visible": false
            },{
                "targets": [5,6],
                'width': 120,
            },{
                "targets": [8,9],
                "createdCell": function(td){
                    $(td).addClass('textorangen');
                },
                'render': function (data){
                    return toMoney(parseFloat(data));
                }
            },{
                "targets": [10,11],
                "createdCell": function(td){
                    $(td).addClass('textblue');
                },
                'render': function (data){
                    return toMoney(parseFloat(data));
                }
            },{
                "targets": [12],
                'width': 50,
                'orderable': false,
                'render': function (data, type, row){
                    var firstvalue = row[8];
                    var lastvalue = row[10];
                    if(firstvalue == 0) {
                        data = '-';
                    }else{
                        data = parseFloat(parseFloat(lastvalue)*100/parseFloat(firstvalue)).toFixed(2) +'%'
                    }
                    return data;
                },
                "createdCell": function(td){
                    $(td).addClass('textviolet');
                },
            },{
                "targets": [13],
                'width': 50,
                'orderable': false,
                'render': function (data, type, row){
                    var firstvalue = row[9];
                    var lastvalue = row[11];
                    if(firstvalue == 0) {
                        data = '-';
                    }else{
                        data = parseFloat(parseFloat(lastvalue)*100/parseFloat(firstvalue)).toFixed(2) +'%'
                    }
                    return data;
                },
                "createdCell": function(td){
                    $(td).addClass('textviolet');
                },
            },{
                'targets': [14],
                'width': 50,
                'searchable': false,
                'orderable': false,
                'className': 'dt-header-center',
                'render': function (data, type, full, meta){
                    return '<div style=" font-size: 20px; "><center><i class="fa fa-edit" style=" cursor: pointer;margin-right: 10px; color: blue;" data-toggle="tooltip" title="แก้ไขเป้าหมายรายเดือน" name="estimateProductOfWeekList" id="estimateProductOfWeekList"></i></center></div>';
                }
              }
            ],
              'order': [[0, 'desc']]
        } );
    }
    $("#typeOfAgri_Id").select2();
    $("#agri_Id").select2();
    $("#month_id").select2();
    $("#market_id").select2();

    $("#yearsOfPlan").change(function(){
        var Table= $('#estimateProductList-Table').DataTable();
        Table.destroy();
        initDataTable();
        initTable();
    });
    $("#typeOfAgri_Id").change(function(){
        var tpyeOfAgri_Id = $(this).val();
        var area_Id = $('#area_Id').val();
        if(tpyeOfAgri_Id != '0'){
            $.ajax({
                url:"../util/loadAgriProduct.php",
                method:"POST",
                data:{tpyeOfAgri_Id:tpyeOfAgri_Id, area_Id:area_Id},
                dataType:"text",
                success:function(data){
                    $('#agri_Id').html(data);
                },complete:function(data){
                    var Table= $('#estimateProductList-Table').DataTable();
                    Table.destroy();
                    initDataTable();
                    initTable();
                }
            });
        }else{
            var Table= $('#estimateProductList-Table').DataTable();
            Table.destroy();
            initDataTable();
            initTable();
        }
        
    });
    $("#agri_Id").change(function(){
        var Table= $('#estimateProductList-Table').DataTable();
        Table.destroy();
        initDataTable();
        initTable();
    });
    $("#month_id").change(function(){
        var Table= $('#estimateProductList-Table').DataTable();
        Table.destroy();
        initDataTable();
        initTable();
    });
    $("#market_id").change(function(){
        var Table= $('#estimateProductList-Table').DataTable();
        Table.destroy();
        initDataTable();
        initTable();
    });
    $('#estimateProductList-Table tbody').on('click', '#estimateProductOfWeekList', function () {
        var data = Table.row( $(this).parents('tr') ).data();
        window.location = "./estimanteProductOfWeek.php?yearsId="+data[2]+"&idOutputValue="+data[0]+"&monthId="+data[1]+"&area_Id="+area_Id;
    } );
    function toMoney(n) {
        return n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
    }
    function initTable() {
        $("#summaryEstimateProduct tbody").html("");
        var years_Id = $('#years_Id').val();
        var typeOfAgri_Id = $('#typeOfAgri_Id option:selected').val();
        var agri_Id = $('#agri_Id option:selected').val();
        var month_id = $('#month_id option:selected').val();
        var market_id = $('#market_id option:selected').val();
        var area_Id = $('#area_Id').val();
        console.log('years_Id', years_Id ,":typeOfAgri_Id ", typeOfAgri_Id ,": agri_Id", agri_Id ,":month_id", month_id);
        $.ajax({
            url:"../util/summaryEstimateProduct.php",
            method:"POST",
            data:{area_Id:area_Id, years_Id:years_Id, typeOfAgri_Id:typeOfAgri_Id, agri_Id:agri_Id, month_id:month_id, 
                market_id:market_id},
            dataType:"text",
            success:function(data){
                $("#summaryEstimateProduct tbody").html(data);
            }
        });
    }

})(jQuery);

