
<div class="modal fade" id="editTargetAgriPlanDialog" tabindex="-1" role="dialog" aria-labelledby="editTargetAgriPlanModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTargetAgriPlanModalLabel">แก้ไขข้อมูลส่งเสริมเป้าหมายการผลิต</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="#" method="post" id="editTargetAgriPlan_form">
                    <input type="hidden" class="form-control"name="unit_plan_id" id="unit_plan_id"  style="width: 100%;">
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
                        <label class="col-sm-2 col-form-label">ชนิดพืช</label>
                        <div class="col-sm-5">
                            <select class="form-control" name="agri_id" id="agri_id" style="width: 100%">
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">หน่วยนับ</label>
                        <div class="col-sm-5">
                            <select class="form-control" name="taget_unit_id" id="taget_unit_id" style="width: 100%">
                                <option value="0">กรุณาเลือก</option>
                                <?php echo loadAllTypeOfTragetPaln($conn) ?>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">
                    ยกเลิก
                </button>
                <button type="button" id="updateTargetAgriPlanBtn" name="updateTargetAgriPlanBtn" class="btn btn-primary">บันทึก</button>
            </div>
        </div>
    </div>
</div>
