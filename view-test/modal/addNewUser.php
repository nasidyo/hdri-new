<div class="modal fade" id="addNewUser" tabindex="-1" role="dialog" aria-labelledby="addFarmerModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addFarmerModalLabel">เพิ่มข้อมูลผู้ใช้งานระบบ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" style=" padding: 1.5rem; ">
                <form class="form-horizontal" method="post" enctype="multipart/form-data" id="addNewUserForm">
                    <div class="form-group row">
                        <label for="inputext" class="col-sm-2 col-form-label">คำนำหน้า</label>
                        <div class="col-sm-3">
                            <select class="form-control" name="user_Prefix" id="user_Prefix">
                                <?php echo loadPrefix($conn); ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputext" class="col-sm-2 col-form-label">ชื่อ</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control"name="user_FristName" id="user_FristName"  style="width: 100%;">
                        </div>
                        <label for="inputext" class="col-sm-2 col-form-label">นามสกุล</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control"name="user_LastName" id="user_LastName"  style="width: 100%;">
                        </div>
                        <div class="col-sm-1">
                            <button type="button" class="btn btn-primary" id="lookupUser"><i class="fa fa-search"></i>  ค้นหา</button>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputext" class="col-sm-2 col-form-label">ชื่อบัญชีผู้ใช้งาน</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control"name="user_name" id="user_name"  style="width: 100%;">
                        </div>
                    <!-- </div>
                    <div class="form-group row"> -->
                        <label for="inputext" class="col-sm-2 col-form-label">รหัสผ่าน</label>
                        <div class="col-sm-3">
                            <input type="password" class="form-control"name="user_password" id="user_password"  style="width: 100%;">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputext" class="col-sm-2 col-form-label">อีเมล์</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control"name="user_email" id="user_email"  style="width: 100%;">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputext" class="col-sm-2 col-form-label">ระดับการเข้าใช้</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="user_typePermission" id="user_typePermission">
                                <?php echo loadAllOfPermission($conn); ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputext" class="col-sm-2 col-form-label">สถานะ</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="user_status" id="user_status">
                                <option value='Active'> ใช้งานอยู่</option>
                                <option value='Inactive'> ระงับการใช้งาน</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputext" class="col-sm-2 col-form-label">พื้นที่รับผิดชอบ</label>
                        <div class="col-sm-6">
                            <select class="user_targetAreaList-dropdown addfield" name="user_targetAreaList" multiple="multiple" id="user_targetAreaList" tabindex="1" size="5" style="width: 100%">
                                <?php echo loadAllAreaAndBasin($conn); ?>
                            </select>
                        </div>
                        <div class="col col-lg-4 col-form-label">
                            <input type="checkbox" id="selectAllTarget" class="addfield">
                            <label for="plan-plant" class="pr-1 form-control-label">เลือกทุกพื้นที่ </label>
                        </div>
                    </div>
                </from>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                <button type="button" class="btn btn-primary" id="createNewUserBtn">ตกลง</button>
            </div>
        </div>
    </div>
</div>
