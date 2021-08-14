
<div class="modal fade" id="createTargetAgriPlanDialog" tabindex="-1" role="dialog" aria-labelledby="createTargetAgriPlanModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createTargetAgriPlanModalLabel">เพิ่มข้อมูลส่งเสริมเป้าหมายการผลิต</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="#" method="post" id="createTargetAgriPlan_form">
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
                            <select class="agriList-dropdown addfield" name="agriList" multiple="multiple" id="agriList" tabindex="1" size="5" style="width: 100%">
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">หน่วยนับ</label>
                        <div class="col-sm-5">
                            <select class="unit_plan_List-dropdown addfield" name="unit_plan_List" multiple="multiple" id="unit_plan_List" tabindex="1" size="5" style="width: 100%">
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
                <button type="button" id="createTargetAgriPlanBtn" name="createTargetAgriPlanBtn" class="btn btn-primary">บันทึก</button>
            </div>
        </div>
    </div>
</div>
