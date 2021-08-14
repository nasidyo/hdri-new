(function ($) {
    var Table= $('#datatableRegister').DataTable();
    initTable();
    $('#search #idRiverBasinSearch').change(function(){
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
                $('#search #idAreaSearch').html(data);
            }
        });
    }
    $('#idTypeOfArgiSearch').change(function(){
        var typeOfAgriId = $(this).val();
        console.log(typeOfAgriId)
        $.ajax({
            url:"../util/loadAgriFromType.php",
            method:"POST",
            data:{typeOfAgriId:typeOfAgriId},
            dataType:"text",
            success:function(data){
                $('#idAgriSearch').html(data);
            }
        });
    });

    $('#idRiverBasin').change(function(){
        var idRiverBasin = $(this).val();
        loadArea(idRiverBasin);
    });
    $('#idArea').change(function(){
        var idArea = $(this).val();
        loadPerson(idArea);
    });
    // idPerson
    function loadPerson(idArea){
        $.ajax({
            url:"../util/loadPersonFromArea.php",
            method:"POST",
            data:{idArea:idArea},
            dataType:"text",
            success:function(data){
                console.log(data);
                $('.selectpicker').append(data);
                $(".selectpicker").selectpicker("refresh");
            }
        });
    }
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


    $('#datatableRegister tbody').on('click', '#editRegisterAgri', function () {
        var data = Table.row( $(this).parents('tr') ).data();
        var registerId = data[0];
        console.log(registerId);
        $.ajax({
            url: "../server_side/editRegisterAgri.php?registerId="+registerId,
            type: "GET",
            dataType: "json",
            success: function(data) {
                console.log(data.data[0]);
                mapDataEditRegisterAgri(data.data[0]);
            },complete: function(data){
                $('#test').html('');
                var btn = '<div class="row">';
                btn = btn+'<div class="col-md-3">';
                btn = btn+ '<button type="submit" name="EditRegisterAgri_TD" class="btn btn-primary"><i class="menu-icon fa fa-edit"></i> Update</button>';
                btn = btn+ "<input type='hidden' name='regisAgri_id' value="+$regisAgri_id+" />";
                btn = btn+ '</div>';
                btn = btn+ '</div>';
                $('#test').html(btn);
            }
        });
    });
    function mapDataEditRegisterAgri(data){
        $('#idRiverBasin option[value="'+data[2]+'"]').attr("selected",true);
        $('#idTypeOfArgi option[value="'+data[3]+'"]').attr("selected",true);
        $('#register_year').val(data[4]);
        $.ajax({
            url:"../util/loadAreaDropdown.php",
            method:"POST",
            data:{idRiverBasin:data[2]},
            dataType:"text",
            success:function(data){
                $('#idArea').html(data);
            },complete:function(){
                $('#idArea option[value="'+data[1]+'"]').attr("selected",true);
                $.ajax({
                    url:"../util/loadAgriFromType.php",
                    method:"POST",
                    data:{typeOfAgriId:data[3]},
                    dataType:"text",
                    success:function(data){
                        $('#idAgri').html(data);
                    },complete:function(){
                        $('#idAgri option[value="'+data[6]+'"]').attr("selected",true);
                    }
                });
                $.ajax({
                    url:"../util/loadPersonFromArea.php",
                    method:"POST",
                    data:{idArea:data[1]},
                    dataType:"text",
                    success:function(data){
                        $('.selectpicker').append(data);
                        $(".selectpicker").selectpicker("refresh");
                    },complete:function(){
                        $('.selectpicker').selectpicker('val', data[5]);
                        $(".selectpicker").selectpicker("refresh");
                    }
                });
            }
        });
    }
    var idRiverBasin = 'null';
    var idArea = 'null';
    var idTypeOfArgiSearch = 'null';
    var idAgriSearch = 'null';

    $( "#searchBtn" ).click(function() {
        idRiverBasin = $('#search #idRiverBasinSearch').val();
        idArea = $('#search #idAreaSearch').val();
        idTypeOfArgiSearch = $('#idTypeOfArgiSearch').val();
        idAgriSearch = $('#idAgriSearch').val();
        console.log(idRiverBasin,":::",idArea,":::",idTypeOfArgiSearch,":::",idAgriSearch);
        initTable();
    });

    $('#datatableRegister tbody').on('click', '#removeitem', function () {
        var data = Table.row( $(this).parents('tr') ).data();
        var idAgri = data[0];
        if (!confirm("ต้องการลบข้อมูลรหัส :"+idAgri)){
            return false;
        }else{
            window.location = "./RegisterAgri_TD.php?delete&idAgri="+idAgri;
        }
    });
    function initTable (){
        console.log(idRiverBasin,":::",idArea,":::",idTypeOfArgiSearch,":::",idAgriSearch);
        Table.destroy();
        Table = $('#datatableRegister').DataTable( {
            "processing": true,
            "responsive": true,
            "serverSide": true,
            "ajax": "../server_side/listRegisterAgri.php?idRiverBasin="+idRiverBasin+"&idArea="+idArea+"&idTypeOfArgiSearch="+idTypeOfArgiSearch+"&idAgriSearch="+idAgriSearch,
            "type": "GET",
            "autoWidth": false,
            'fixedColumns':   {
                'heightMatch': 'none'
            },
            'columnDefs': [{
                "targets": [1],
                'width': 250,
                },{
                    "targets": [1],
                    'width': 100,
                },{
                'targets': [5],
                'width': 100,
                'searchable': false,
                'orderable': false,
                'className': 'dt-header-center',
                'render': function (data, type, row){
                    data = '<div style=" font-size: 20px; "><center><i class=" fa fa-pencil-square-o" id="editRegisterAgri" style=" cursor: pointer;margin-right: 10px;"></i>'
                    data = data+ '<i class="ti-trash" style=" cursor: pointer; margin-right: 10px;" id="removeitem" name="removeitem"></i></div></center>';
                    data = data+ '</center></div>';
                    return data;
                }
                }
            ],
            'order': [[0, 'desc']]
        });
    }


})(jQuery);