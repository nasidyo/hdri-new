(function ($) {
    $('#user_targetAreaList').select2();
    $('#user_targetAreaList_edit').select2();
    initTable();
    initTableUserAd();
    function initTable (){
        var typeOfPermission = $('#typeOfPermission').val();
        var Table = $('#tableUserPermissionList').DataTable();
        Table.destroy();
        Table = $('#tableUserPermissionList').DataTable( {
          "processing": true,
          "responsive": true,
          "serverSide": true,
          "ajax": "../server_side/listUserPermissions.php?typeOfPermission="+typeOfPermission,
          "autoWidth": false,
          'fixedColumns':   {
            'heightMatch': 'none'
          },
          'columnDefs': [
            {
                "targets": [0],
                  "visible": false
          },{
              'targets': [5],
              'width': 100,
              'searchable': false,
              'orderable': false,
              'className': 'dt-header-center',
              'render': function (data, type, row){
                  data = '<div style=" font-size: 20px; "><center><i class=" fa fa-pencil-square-o" id="editUser" style=" cursor: pointer;margin-right: 20px; color: blue;"></i>'
                  data = data+ '<i class="ti-trash" style=" cursor: pointer; margin-right: 10px; color: red;" id="removeitem" name="removeitem"></i></div></center>';
                  data = data+ '</center></div>';
                  return data;
              }
          }
          ],
            'order': [[0, 'asc']]
        });
    }
    $('#typeOfPermission').change(function(){
        initTable();
    });
    $( "#addNewUserBtn" ).click(function() {
        $('#addNewUser').modal('show');
    });
    $( "#lookupUser" ).click(function() {
        $('#lookupUserFromAD').modal('show');
    });

    function initTableUserAd (){
      var Table = $('#lookupUser-table').DataTable();
      Table.destroy();
      Table = $('#lookupUser-table').DataTable( {
        "processing": true,
        "responsive": true,
        "serverSide": true,
        "ajax": "../server_side/listUserFromAD.php",
        "autoWidth": false,
        'fixedColumns':   {
          'heightMatch': 'none'
        },
        'columnDefs': [
            {
                "targets": [0],
                  "visible": false
          },{
            'targets': [3],
            'width': 100,
            'searchable': false,
            'orderable': false,
            'className': 'dt-header-center',
            'render': function (data, type, row){
                data = '<div style=" font-size: 20px; "><center>';
                data = data+ '<button type="button" class="btn btn-primary " id="selectId"><i class="menu-icon fa fa-plus"></i> เลือก</button>'
                data = data+ '</center></div>';
                return data;
            }
        }
        ],
          'order': [[0, 'asc']]
      });
    }
    
    $('#tableUserPermissionList tbody').on('click', '#editUser', function () {
        $('#editUserDialog').modal('show');
        Table = $('#tableUserPermissionList').DataTable();
        var data = Table.row( $(this).parents('tr') ).data();
        var emp_id = data[0];
        console.log(emp_id);
        var formData = new FormData();
        formData.append("emp_id",emp_id);
        formData.append("action","load_User");
        $.ajax({
            type: "POST",
            cache: false,
            contentType: false,
            processData: false,
            data:formData,
            dataType:'text',
            url: "../handler/userHandler.php",
            dataType: "html",
            async: true,
            success: function(data) {
                  console.log(data);
                  mapEditData(JSON.parse(data));
            }
        });
    });

    function mapEditData(data){
      $("#staff_id_edit").val(data.staff_Id);
      $("#user_Prefix_edit").val(data.Prefix_idPrefix).trigger('change');
      $("#user_FristName_edit").val(data.staffFirstname);
      $("#user_LastName_edit").val(data.staffLastname);
      $("#user_name_edit").val(data.staffUsername);
      $("#user_email_edit").val(data.staffEmail);
      $("#user_status_edit").val(data.staffStatus).trigger('change');
      $("#user_typePermission_edit").val(data.staffPermis).trigger('change');
      $("#user_targetAreaList_edit").val(data.area_Id).trigger('change');
    }
    $('#lookupUser-table tbody').on('click', '#selectId', function () {
        Table = $('#lookupUser-table').DataTable();
        var data = Table.row( $(this).parents('tr') ).data();
        var emp_id = data[0];
        $('#lookupUserFromAD').modal('hide');
        var formData = new FormData();
        formData.append("emp_id",emp_id);
        formData.append("action","load_AD");
        $.ajax({
           type: "POST",
           cache: false,
           contentType: false,
           processData: false,
           data:formData,
           dataType:'text',
           url: "../handler/userHandler.php",
           dataType: "html",
           async: true,
           success: function(data) {
                console.log(data);
                mapData(JSON.parse(data));
           }
        });
    });

    function mapData(data){
        $("#addNewUserForm #user_Prefix").val(data.Prefix_idPrefix).trigger('change');
        $("#addNewUserForm #user_FristName").val(data.staffFirstname);
        $("#addNewUserForm #user_LastName").val(data.staffLastname);
        $("#addNewUserForm #user_name").val(data.staffUsername);
        $("#addNewUserForm #user_email").val(data.staffEmail);
    }

    $( "#createNewUserBtn" ).click(function() {
        var userListDeail = [];
        var Table = $('#tableUserPermissionList').DataTable();
        var data = $("#addNewUserForm").serialize().split("&");
        console.log(data);
        var obj={};
        for(var key in data) {
            obj[data[key].split("=")[0]] = data[key].split("=")[1];
        }
        var user_targetAreaList = $('#addNewUserForm #user_targetAreaList').val();
        obj.user_targetAreaList = user_targetAreaList;
        console.log(obj);
        userListDeail.push(obj);
        if($('#addNewUserForm #user_targetAreaList').val() == null || $('#addNewUserForm #user_typePermission').val() == 0 || $('#addNewUserForm #user_FristName').val() == '' || $('#addNewUserForm #user_LastName').val() == '' || $('#addNewUserForm #user_name').val() == ''){
            alert('กรุณากรอกข้อมูลให้ครบ')
        }else{
          $('#addNewUser').modal('hide');
          $('#addNewUserForm').trigger("reset");
        //   $("#user_targetAreaList").find('option').prop("selected",false);
          $('#user_targetAreaList').val(null).trigger('change');
          $.ajax({
              type: "POST",
              data:{data:userListDeail, action:"createUser"},
              dataType:'text',
              url: "../handler/userHandler.php",
              dataType: "html",
              async: true,
              success: function(data) {
                  Table.ajax.reload();
              }
          });
        }
  });
    $("#editUserBtn").click(function() {
        $('#editUserDialog').modal('hide');
        var formData = new FormData();
        formData.append("emp_id",$('#staff_id_edit').val());
        formData.append("user_Prefix",$('#user_Prefix_edit').val());
        formData.append("user_FristName",$('#user_FristName_edit').val());
        formData.append("user_LastName",$('#user_LastName_edit').val());
        formData.append("user_name",$('#user_name_edit').val());

        formData.append("user_password",$('#user_password_edit').val());
        formData.append("user_email",$('#user_email_edit').val());
        formData.append("user_typePermission",$('#user_typePermission_edit').val());
        formData.append("user_status",$('#user_status_edit').val());
        formData.append("user_targetAreaList",$('#user_targetAreaList_edit').val());
        formData.append("action","editUser");
        console.log(formData);
        $.ajax({
            type: "POST",
            cache: false,
            contentType: false,
            processData: false,
            data:formData,
            dataType:'text',
            url: "../handler/userHandler.php",
            dataType: "html",
            async: true,
            success: function(data) {
                Table.ajax.reload();
            }
        });
    });

    $('#tableUserPermissionList tbody').on('click', '#removeitem', function () {
      Table = $('#tableUserPermissionList').DataTable();
      var data = Table.row( $(this).parents('tr') ).data();
      var emp_id = data[0];
      console.log(emp_id);
      var formData = new FormData();
      formData.append("emp_id",emp_id);
      formData.append("action","deleteUser");
      if (!confirm("ต้องการลบข้อมูล :"+emp_id)){
          return false;
      }else{
          $.ajax({
              type: "POST",
              cache: false,
              contentType: false,
              processData: false,
              data:formData,
              dataType:'text',
              url: "../handler/userHandler.php",
              dataType: "html",
              async: true,
              success: function(data) {
                  Table.ajax.reload();
              }
          });
      }
  });

    // select all month of years
      $("#selectAllTarget").click(function(){
        checkTargetLit();
    });
    function checkTargetLit(){
        if($("#selectAllTarget").is(':checked') ){ //select all
            $('#user_targetAreaList').find('option').each(function(){
                console.log($(this).val());
                if($(this).val() != '0'){
                    $(this).prop("selected",true);
                }
            });
            // $("#user_targetAreaList").find('option').prop("selected",true);
            $("#user_targetAreaList").trigger('change');
          } else { //deselect all
            $("#user_targetAreaList").find('option').prop("selected",false);
            $("#user_targetAreaList").trigger('change');
          }
    }

})(jQuery);