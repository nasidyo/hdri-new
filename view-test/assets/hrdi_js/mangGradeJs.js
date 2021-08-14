(function ($) {
    initTable();
    function initTable (){
        var Table = $('#tableGradeList').DataTable();
        Table.destroy();
        Table = $('#tableGradeList').DataTable( {
          "processing": true,
          "responsive": true,
          "serverSide": true,
          "ajax": "../server_side/listGradeProducts.php",
          "autoWidth": false,
          'fixedColumns':   {
            'heightMatch': 'none'
          },
          'columnDefs': [
            {
                "targets": [0],
                  "visible": false
            },{
                'targets': [2],
                'width': 100,
                'searchable': false,
                'orderable': false,
                'className': 'dt-header-center',
                'render': function (data, type, row){
                    data = '<div style=" font-size: 20px; "><center><i class=" fa fa-pencil-square-o" id="editGrade" style=" cursor: pointer;margin-right: 20px; color: blue;"></i>'
                      data = data+ '<i class="ti-trash" style=" cursor: pointer; margin-right: 10px; color: red;" id="removeitem" name="removeitem"></i></div></center>';
                    data = data+ '</center></div>';
                    return data;
                }
             }
          ],
            'order': [[0, 'asc']]
        });
    }
    
    $('#tableGradeList tbody').on('click', '#removeitem', function () {
        Table = $('#tableGradeList').DataTable();
        var data = Table.row( $(this).parents('tr') ).data();
        var gradeId = data[0];
        if (!confirm("ต้องการลบข้อมูลเกรดรหัส : "+gradeId)){
            return false;
        }else{
            $.ajax({
                type: "POST",
                data:{gradeId: gradeId},
                dataType:'text',
                url: "../util/checkDeleteGrade.php",
                dataType: "html",
                async: true,
                success: function(data) {
                    if(data == 'Y'){
                        var conCheckDeep = confirm("เกรดนี้ได้มีการส่งมอบแล้ว\nต้องการลบหรือไม่ ?");
                        if(conCheckDeep){
                            $.ajax({
                                type: "POST",
                                data:{gradeId:gradeId, action:"removeItem"},
                                dataType:'text',
                                url: "../handler/gradeHandler.php",
                                dataType: "html",
                                async: true,
                                success: function(data) {
                                    $('#tableGradeList').DataTable().ajax.reload();
                                }
                            });
                        }else{
                            return false;
                        }
                    }else{
                        $.ajax({
                            type: "POST",
                            data:{gradeId:gradeId, action:"removeItem"},
                            dataType:'text',
                            url: "../handler/gradeHandler.php",
                            dataType: "html",
                            async: true,
                            success: function(data) {
                                $('#tableGradeList').DataTable().ajax.reload();
                            }
                        });
                    }
                }
            });
        }
    });
    $('#tableGradeList tbody').on('click', '#editGrade', function () {
        $('#editGrade').modal('show');
        Table = $('#tableGradeList').DataTable();
        var data = Table.row( $(this).parents('tr') ).data();
        var gradeId = data[0];
        console.log(gradeId);
        $.ajax({
            type: "POST",
            data:{gradeId:gradeId, action:"loadGrade"},
            dataType:'text',
            url: "../handler/gradeHandler.php",
            dataType: "html",
            async: true,
            success: function(data) {
                var resulte = JSON.parse(data)
                console.log(resulte);
                console.log(resulte.CodeGrade);
                $('#editGrade #gradeName').val(resulte.CodeGrade);
                $('#editGrade #grade_Id').val(resulte.IdGrade);
            }
        });
    });

    $( "#addNewGradeBtn" ).click(function() {
        $('#addNewGrade').modal('show');
        $('#addNewGradeForm #gradeName').val('');
    });

    $( "#createNewGradeBtn" ).click(function() {
        var gradeName = $('#addNewGradeForm #gradeName').val();
        if(gradeName == ''){
            alert('กรุณากรอกข้อมูลให้ครบ');
        }
        $.ajax({
            type: "POST",
            data:{gradeName: gradeName},
            dataType:'text',
            url: "../util/checkGrade.php",
            dataType: "html",
            async: true,
            success: function(data) {
                if(data == '1'){
                    alert ("มีเกรดนี้อยู่ในระบบอยู่แล้ว !");
                    return false;
                }else{
                    $.ajax({
                        type: "POST",
                        data:{gradeName:gradeName, action:"createGrade"},
                        dataType:'text',
                        url: "../handler/gradeHandler.php",
                        dataType: "html",
                        async: true,
                        success: function(data) {
                            $('#tableGradeList').DataTable().ajax.reload();
                        }
                    });
                }
            }
        });
    });
    
    $( "#editGradeBtn" ).click(function() {
        var gradeName = $('#editGrade #gradeName').val();
        var gradeId = $('#editGrade #grade_Id').val();
        if(gradeName == ''){
            alert('กรุณากรอกข้อมูลให้ครบ');
        }
        $.ajax({
            type: "POST",
            data:{gradeName: gradeName},
            dataType:'text',
            url: "../util/checkGrade.php",
            dataType: "html",
            async: true,
            success: function(data) {
                if(data == '1'){
                    alert ("มีเกรดนี้อยู่ในระบบอยู่แล้ว !");
                    return false;
                }else{
                    $.ajax({
                        type: "POST",
                        data:{gradeName:gradeName, gradeId:gradeId ,action:"editGrade"},
                        dataType:'text',
                        url: "../handler/gradeHandler.php",
                        dataType: "html",
                        async: true,
                        success: function(data) {
                            $('#tableGradeList').DataTable().ajax.reload();
                            $('#editGrade').modal('hide');
                        }
                    });
                }
            }
        });
    });


})(jQuery);