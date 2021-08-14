
<div class="modal fade" id="editLandDetailDialog" tabindex="-1" role="dialog" aria-labelledby="editLandDetailModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editLandDetailModalLabel">แก้ไขข้อมูลพื้นที่เกษตกรใหม่</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="#" method="post" id="editLandDetail_form">
                    <input type="hidden" id="land_detail_id">
                    <div class="form-group row">
                        <label for="inputext" class="col-sm-3 col-form-label">พื้นที่ลุ่มน้ำ</label>
                        <div class="col-sm-6">
                            <select class="form-control"name="idRiverBasin" id="idRiverBasin"  style="width: 100%;">
                            <?php
                                echo loadRiverDependentBySS($conn,$_SESSION['idRiverBasin']);
                            ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">พื้นที่</label>
                        <div class="col-sm-6">
                            <select class="form-control"name="idArea" id="idArea" style="width: 100%;">
                                <?php
                                        echo loadAreaDependentBySS($conn,$_SESSION['idRiverBasin'],$_SESSION['idarea']);
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputext" class="col-sm-3 col-form-label">เกษตรกร</label>
                        <div class="col-sm-6">
                            <select class="form-control"name="person_id" id="person_id" style="width: 100%;">
                                <option value='0'>กรุณาเลือก</option>
                            </select>
                            <!-- <input type="text" class="form-control" name="land_number" id="land_number"> -->
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputext" class="col-sm-3 col-form-label">หมายเลขแปลง</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="land_number" id="land_number">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputext" class="col-sm-3 col-form-label">พิกัดแปลงปลูก</label>
                    </div>
                    <hr/>
                    <div class="form-group row">
                        <div class="col-sm-2"></div>
                        <label for="inputext" class="col-sm-1 col-form-label">X</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" name="axis-x" id="axis-x">
                        </div>
                        <label for="inputext" class="col-sm-1 col-form-label">Y</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" name="axis-y" id="axis-y">
                        </div>
                        <label for="inputext" class="col-sm-1 col-form-label">Z</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" name="axis-z" id="axis-z">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputext" class="col-sm-3 col-form-label">ขนาดพื้นที่</label>
                    </div>
                    <hr/>
                    <div class="form-group row">
                        <div class="col-sm-1"></div>
                        <label for="inputext" class="col-sm-2 col-form-label">จำนวนไร่</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" name="unit1" id="unit1">
                        </div>
                        <label for="inputext" class="col-sm-2 col-form-label">จำนวนงาน</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" name="unit2" id="unit2">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-1"></div>
                        <label for="inputext" class="col-sm-2 col-form-label">จำนวนตารางวา</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" name="unit3" id="unit3">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">
                    ยกเลิก
                </button>
                <button type="button" id="editLandDetailModalBtn" name="editLandDetailModalBtn" class="btn btn-primary">บันทึก</button>
            </div>
        </div>
    </div>
</div>
