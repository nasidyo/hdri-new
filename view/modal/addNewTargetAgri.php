
<div class="modal fade" id="createTargetAgriDialog" tabindex="-1" role="dialog" aria-labelledby="createTargetAgriModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createTargetAgriModalLabel">เพิ่มข้อมูลพืชใหม่</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="#" method="post" id="createTargetAgri_form">
                    <div class="form-group row">
                        <label for="inputext" class="col-sm-2 col-form-label">ลุ่มน้ำ</label>
                        <div class="col-sm-5">
                            <select class="form-control" name="idRiverBasin" id="idRiverBasin">
                                <!-- <option value="0">กรุณาเลือก</option> -->
                                <?php 
                                    if($_SESSION['staffPermis'] == 'admin'){
                                        echo loadAllBasin($conn);
                                    }else{
                                        echo loadRiverDependentInSS($conn, $_SESSION['RBAll']);
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputext" class="col-sm-2 col-form-label">พื้นที่</label>
                        <div class="col-sm-5">
                            <select class="form-control" name="idArea" id="idArea">
                                <option value="0">กรุณาเลือก</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">สาขาพืช</label>
                        <div class="col-sm-5">
                            <select class="form-control" name="typeOfAgri" id="typeOfAgri" style="width: 100%">
                                <!-- <option value="0">กรุณาเลือก</option> -->
                                <?php echo loadAllTypeOfAgri($conn); ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">สาขาพืช</label>
                        <div class="col-sm-5">
                            <!-- <select class="form-control" name="Agri_Id" id="Agri_Id">
                                <option value="0">กรุณาเลือก</option>
                            </select> -->
                            <select class="agriList-dropdown addfield" name="agriList" multiple="multiple" id="agriList" tabindex="1" size="5" style="width: 100%">
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">เกรด</label>
                        <div class="col-sm-5">
                            <select class="gradeList-dropdown addfield" name="gradeList" multiple="multiple" id="gradeList" tabindex="1" size="5" style="width: 100%">
                                <option value="0">กรุณาเลือก</option>
                                <?php echo loadAllGradeProduct($conn); ?>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">
                    ยกเลิก
                </button>
                <button type="button" id="createTargetAgriBtn" name="createTargetAgriBtn" class="btn btn-primary">บันทึก</button>
            </div>
        </div>
    </div>
</div>
