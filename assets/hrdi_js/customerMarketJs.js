(function ($) {
    var table = $("#customerMarketTable").DataTable();
    var idRiverBasinSearch = '0';
    var idAreaSearch = '0';
    initTable ();
    $( "#addNewMarket" ).click(function() {
        $('#createMarketDialog').modal('show');
    });
    $( "#addNewCustomer" ).click(function() {
        $('#createCustomerDialog').modal('show');
    });
    var personListDeail = [];
    $("#createNewMarket" ).click(function() {
        var data = $("#createMarket_form").serialize();
        var data = $("#createMarket_form").serialize().split("&");
        var obj={};
        for(var key in data) {
            obj[data[key].split("=")[0]] = data[key].split("=")[1];
        }
        personListDeail.push(obj);
        var personId;
        $.ajax({
            url:"../handler/deliverProductHandler.php",
            method:"POST",
            data:{data:personListDeail, action:"createMarket"},
            dataType:"text",
            success:function(data){
                console.log(data);
                $('#createMarketDialog').modal('hide');
                $('#idMarket option[value="'+data+'"]').attr("selected",true);
            }
        });
    });
    var personListDeail = [];
    $("#createNewCustomer" ).click(function() {
        var data = $("#createCustomer_form").serialize();
        var data = $("#createCustomer_form").serialize().split("&");
        var obj={};
        for(var key in data) {
            obj[data[key].split("=")[0]] = data[key].split("=")[1];
        }
        personListDeail.push(obj);
        var personId;
        $.ajax({
            url:"../handler/deliverProductHandler.php",
            method:"POST",
            data:{data:personListDeail, action:"createCustomer"},
            dataType:"text",
            success:function(data){
                console.log(data);
                $('#createCustomerDialog').modal('hide');
                $(".selectpicker").selectpicker("refresh");
            }
        });
    });
    $('#idRiverBasinSearch').change(function(){
        var idRiverBasin = $(this).val();
        loadAreaSearch(idRiverBasin);
    });
    function loadAreaSearch(idRiverBasin){
        $.ajax({
            url:"../util/loadAreaDropdown.php",
            method:"POST",
            data:{idRiverBasin:idRiverBasin},
            dataType:"text",
            success:function(data){
                $('#idAreaSearch').html(data);
            }
        });
    }
    $('#idRiverBasin').change(function(){
        var idRiverBasin = $(this).val();
        loadArea(idRiverBasin);
      });
    function loadArea(idRiverBasin){
        $.ajax({
            url:"../util/loadAreaDropdown.php",
            method:"POST",
            data:{idRiverBasin:idRiverBasin},
            dataType:"text",
            success:function(data){
                $('#idArea').html(data);
            }
        });
    }
    $('#customerMarketTable tbody').on('click', '#editCustomerMarket', function () {
        var data = table.row( $(this).parents('tr') ).data();
        console.log(data[0]);
        var customerMatketId = data[0];
        $.ajax({
            url: "../server_side/getCustomerMarket.php?customerMatketId="+customerMatketId,
            type: "GET",
            dataType: "json",
            success: function(data) {
                console.log(data.data[0]);
                mapDataEditCustomerMarket(data.data[0]);
            },complete: function(data){
                $('#test').html('');
                var btn = '<div class="row">';
                btn = btn+'<div class="col-md-3">';
                btn = btn+ '<button type="submit" name="EditCustomerMarket" class="btn btn-primary"><i class="menu-icon fa fa-edit"></i> แก้ไขข้อมูล</button>';
                btn = btn+ "<input type='hidden' name='idCustomerMarket' value="+customerMatketId+" />";
                btn = btn+ '</div>';
                btn = btn+ '</div>';
                $('#test').html(btn);
            }
        });
    });
    function mapDataEditCustomerMarket(data){
        $('#idRiverBasin option[value="'+data[2]+'"]').attr("selected",true);
        $('#idMarket option[value="'+data[3]+'"]').attr("selected",true);
        $('.selectpicker').selectpicker('val', data[4]);
        $(".selectpicker").selectpicker("refresh");
        $.ajax({
            url:"../util/loadAreaDropdown.php",
            method:"POST",
            data:{idRiverBasin:data[2]},
            dataType:"text",
            success:function(data){
                $('#idArea').html(data);
            },complete:function(){
                $('#idArea option[value="'+data[1]+'"]').attr("selected",true);
            }
        });
    }
    $( "#searchBtn" ).click(function() {
        idRiverBasinSearch = $('#idRiverBasinSearch').val();
        idAreaSearch = $('#idAreaSearch').val();
        console.log(idRiverBasinSearch,":::",idAreaSearch);
        initTable();
    });

    function initTable (){
        console.log(idRiverBasinSearch,":::",idAreaSearch);
        table.destroy();
        table = $('#customerMarketTable').DataTable( {
            "processing": true,
            "responsive": true,
            "serverSide": true,
            "ajax": "../server_side/listCustomerMarket.php?idRiverBasin="+idRiverBasinSearch+"&idArea="+idAreaSearch,
            "type": "GET",
            "autoWidth": false,
            'fixedColumns':   {
                'heightMatch': 'none'
            },
            'columnDefs': [{
                'targets': [0],
                "visible": false
            },{
                'targets': [4],
                'width': 100,
                'searchable': false,
                'orderable': false,
                'className': 'dt-header-center',
                'render': function (data, type, row){
                    data = '<div style=" font-size: 20px; "><center><i class=" fa fa-pencil-square-o" id="editCustomerMarket" style=" cursor: pointer;margin-right: 10px; color: blue;"></i>'
                    data = data+ '<i class="ti-trash" style=" cursor: pointer; margin-right: 10px; color: red;" id="removeitem" name="removeitem"></i></div></center>';
                    data = data+ '</center></div>';
                    return data;
                }
                }
            ],
            'order': [[0, 'asc']],
        });
    }
    $('#customerMarketTable tbody').on('click', '#removeitem', function () {
        var data = table.row( $(this).parents('tr') ).data();
        var customerMatketId = data[0];
        if (!confirm("ต้องการลบข้อมูลลำดับ :"+customerMatketId)){
            return false;
        }else{
            window.location = "./CustomerMarket.php?delete&idCustomerMarket="+customerMatketId;
        }
    });
    $('#clear_field').on('click',function(){
        $('#idRiverBasin option[value=0]').attr('selected','selected');
        $('#idArea option[value=0]').attr('selected','selected');
        $('#idMarket option[value=0]').attr('selected','selected');
        $(".selectpicker").val('default').selectpicker("refresh");
        $('#test').html('');
            var btn = '<div class="row">';
            btn = btn+'<div class="col-md-3">';
            btn = btn+ '<button type="submit" name="AddCustomerMarket" class="btn btn-primary"><i class="menu-icon fa fa-plus"></i> บันทึกข้อมูล</button>';
            btn = btn+ '</div>';
            btn = btn+ '</div>';
        $('#test').html(btn);
    });
    $('#clear_Search').on('click',function(){
        $('#idRiverBasinSearch option[value=0]').attr('selected','selected');
        $('#idAreaSearch option[value=0]').attr('selected','selected');
    });

})(jQuery);

