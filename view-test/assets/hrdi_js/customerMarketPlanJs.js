(function ($) {
    var table = $("#customerMakerPlan-Table").DataTable();
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
    $('#idArea').change(function(){
        var idArea = $(this).val();
        $.ajax({
            url:"../util/loadMarketJsList.php",
            method:"POST",
            data:{area_Id:idArea},
            dataType:"text",
            success:function(data){
                $('#idCustomer').html(data);
            }
        });
    });

    $('#idTypeOfArgi').change(function(){
        var typeOfAgriId = $(this).val();
        if(typeOfAgriId != '0'){
            $.ajax({
                url:"../util/loadAgriFromType.php",
                method:"POST",
                data:{typeOfAgriId:typeOfAgriId},
                dataType:"text",
                success:function(data){
                    $('#idAgri').html(data);
                }
            });
        }
    });

    $('#customerMakerPlan-Table tbody').on('click', '#editCustomerMarketPlan', function () {
        var data = table.row( $(this).parents('tr') ).data();
        console.log(data[0]);
        var customerMatketPlanId = data[0];
        $.ajax({
            url: "../server_side/getCustomerMarketPlan.php?customerMatketPlanId="+customerMatketPlanId,
            type: "GET",
            dataType: "json",
            success: function(data) {
                console.log(data.data[0]);
                mapDataEditCustomerMarketPlan(data.data[0]);
            },complete: function(data){
                $('#test').html('');
                var btn ='<div class="col-md-3">';
                btn = btn+ '<button type="submit" name="EditCustomerMaketPlan_TD" class="btn btn-primary"><i class="menu-icon fa fa-edit"></i> แก้ไขข้อมูล</button>';
                btn = btn+ "<input type='hidden' name='idCustomerMaketplan' value="+customerMatketPlanId+" />";
                btn = btn+ '</div>';
                btn = btn+'<div class="col-md-3">';
                btn = btn+ '<a href="CustomerMaketPlan_TD.php" class="btn btn-primary">ยกเลิก</a>';
                btn = btn+ '</div>';
                $('#test').html(btn);
            }
        });
    });
    function mapDataEditCustomerMarketPlan(data){
        $('#idRiverBasin option[value="'+data[1]+'"]').attr("selected",true);
        $('#plan_Year').val(data[4]);
        $.ajax({
            url:"../util/loadAreaDropdown.php",
            method:"POST",
            data:{idRiverBasin:data[1]},
            dataType:"text",
            success:function(data){
                $('#idArea').html(data);
            },complete:function(){
                $('#idArea option[value="'+data[2]+'"]').attr("selected",true);
                $.ajax({
                    url:"../util/loadMarketJsList.php",
                    method:"POST",
                    data:{area_Id:data[2]},
                    dataType:"text",
                    success:function(data){
                        $('#idCustomer').html(data);
                    },complete:function(){
                        $('#idCustomer option[value="'+data[3]+'"]').attr("selected",true);
                    }
                });
            }
        });
        $('#idTypeOfArgi option[value="'+data[6]+'"]').attr("selected",true);
        $.ajax({
            url:"../util/loadAgriFromType.php",
            method:"POST",
            data:{typeOfAgriId:data[6]},
            dataType:"text",
            success:function(data){
                $('#idAgri').html(data);
            },complete:function(){
                $('#idAgri option[value="'+data[5]+'"]').attr("selected",true);
            }
        });
        $('#agri_weekplan_amount').val(data[7]);
        $('#idCountUnit option[value="'+data[8]+'"]').attr("selected",true);
        $('#agri_spect').val(data[9]);
        $('#idTypeOfStand option[value="'+data[10]+'"]').attr("selected",true);
        $('#logistic_id option[value="'+data[11]+'"]').attr("selected",true);
        $('#Refund_period').val(data[12]);
        $('#conn_status_id option[value="'+data[13]+'"]').attr("selected",true);
        $('#update_date').val(data[14]);
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
        table = $('#customerMakerPlan-Table').DataTable( {
            "processing": true,
            "responsive": true,
            "serverSide": true,
            "ajax": "../server_side/listCustomerMarketPlan.php?idRiverBasin="+idRiverBasinSearch+"&idArea="+idAreaSearch,
            "type": "GET",
            "autoWidth": false,
            'fixedColumns':   {
                'heightMatch': 'none'
            },
            'columnDefs': [{
                    "targets": [2],
                    'width': 150,
                },{
                'targets': [8],
                'width': 100,
                'searchable': false,
                'orderable': false,
                'className': 'dt-header-center',
                'render': function (data, type, row){
                    data = '<div style=" font-size: 20px; "><center><i class=" fa fa-pencil-square-o" id="editCustomerMarketPlan" style=" cursor: pointer;margin-right: 10px; color:blue;">'
                    data = data+ '<i class="ti-trash" style=" cursor: pointer; margin-right: 10px; color:red; " id="removeitem" name="removeitem"></i></div></center>';
                    data = data+ '</center></div>';
                    return data;
                }
            }],
            'order': [[0, 'desc']]
        });
    }
    $('#customerMakerPlan-Table tbody').on('click', '#removeitem', function () {
        var data = table.row( $(this).parents('tr') ).data();
        var customerMatketPlanId = data[0];
        if (!confirm("ต้องการลบข้อมูลลำดับ :"+customerMatketPlanId)){
            return false;
        }else{
            window.location = "./CustomerMaketPlan_TD.php?delete&idCustomerMaketplan="+customerMatketPlanId;
        }
    });

})(jQuery);

