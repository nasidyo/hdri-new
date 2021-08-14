
<div class="modal fade" id="editVillageLevelDialog" role="dialog" aria-labelledby="editVillageLevelModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editVillageLevelModalLabel">แก้ไขข้อมูลพื้นที่เกษตกรใหม่</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="#" method="post" id="editVillageLevel_form">
                <input type="hidden" class="form-control"name="list_vill_level_id" id="list_vill_level_id">
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
                        <label for="inputext" class="col-sm-3 col-form-label">หมู่บ้าน</label>
                        <div class="col-sm-6">
                            <select class="form-control"name="villageId" id="villageId" style="width: 100%;">
                                <option value="0">กรุณาเลือก</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputext" class="col-sm-3 col-form-label">ระดับการส่งเสริม</label>
                        <div class="col-sm-6">
                            <select class="form-control" name="levelNew" id="levelNew">
                                <option value="">กรุณาเลือก</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                                <option value="E">E</option>
                                <option value="F">F</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">
                    ยกเลิก
                </button>
                <button type="button" id="editVillageModalBtn" name="editVillageModalBtn" class="btn btn-primary">บันทึก</button>
            </div>
        </div>
    </div>
</div>
