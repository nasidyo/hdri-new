
<div class="modal fade" id="createLogisticDialog" tabindex="-1" role="dialog" aria-labelledby="createLogisticModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createLogisticModalLabel">เพิ่มข้อมูล</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="#" method="post" id="createLogistic_form">
                    <input type="hidden" id="action" name="action" value="createLogistic"/>
                    <div class="row form-group">
                        <label for="inputext" class="col-sm-2 col-form-label">วิธีขนส่ง</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="Logistic" id="Logistic" placeholder="วิธีการขนส่ง">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">
                    ยกเลิก
                </button>
                <button type="button" id="createNewLogistic" name="createNewLogistic" class="btn btn-primary">บันทึก</button>
            </div>
        </div>
    </div>
</div>
