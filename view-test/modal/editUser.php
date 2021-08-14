<div class="modal fade" id="editUserDialog" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">แก้ไขข้อมูลผู้ใช้งานระบบ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" style="padding: 1.5rem;">
                <form class="form-horizontal" method="post" enctype="multipart/form-data" id="editUserForm" name="editUserForm">
                    <input type="hidden" class="form-control"name="staff_id_edit" id="staff_id_edit"  style="width: 100%;">
                    <div class="form-group row">
                        <label for="inputext" class="col-sm-2 col-form-label">คำนำหน้า</label>
                        <div class="col-sm-3">
                            <select class="form-control" name="user_Prefix_edit" id="user_Prefix_edit">
                                <?php echo loadPrefix($conn); ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputext" class="col-sm-2 col-form-label">ชื่อ</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control"name="user_FristName_edit" id="user_FristName_edit" style="width: 100%;">
                        </div>
                        <label for="inputext" class="col-sm-2 col-form-label">นามสกุล</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control"name="user_LastName_edit" id="user_LastName_edit"  style="width: 100%;">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputext" class="col-sm-2 col-form-label">ชื่อบัญชีผู้ใช้งาน</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control"name="user_name_edit" id="user_name_edit"  style="width: 100%;">
                        </div>
                    <!-- </div>
                    <div class="form-group row"> -->
                        <label for="inputext" class="col-sm-2 col-form-label">รหัสผ่านใหม่</label>
                        <div class="col-sm-3">
                            <input type="password" class="form-control"name="user_password_edit" id="user_password_edit"  style="width: 100%;">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputext" class="col-sm-2 col-form-label">อีเมล์</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control"name="user_email_edit" id="user_email_edit"  style="width: 100%;">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputext" class="col-sm-2 col-form-label">ระดับการเข้าใช้</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="user_typePermission_edit" id="user_typePermission_edit">
                                <?php echo loadAllOfPermission($conn); ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputext" class="col-sm-2 col-form-label">สถานะ</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="user_status_edit" id="user_status_edit">
                                <option value='Active'> ใช้งานอยู่</option>
                                <option value='Inactive'> ระงับการใช้งาน</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputext" class="col-sm-2 col-form-label">พื้นที่รับผิดชอบ</label>
                        <div class="col-sm-8">
                            <select class="user_targetAreaList-dropdown addfield" name="user_targetAreaList_edit" multiple="multiple" id="user_targetAreaList_edit" tabindex="1" size="5" style="width: 100%">
                                <?php echo loadAllAreaAndBasin($conn); ?>
                            </select>
                        </div>
                    </div>
                </from>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                <button type="button" class="btn btn-primary" id="editUserBtn">ตกลง</button>
            </div>
        </div>
    </div>
</div>
