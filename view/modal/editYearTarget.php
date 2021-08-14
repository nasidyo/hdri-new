
<div class="modal fade" id="editYearTargetDialog" tabindex="-1" role="dialog" aria-labelledby="editYearTargetModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editYearTargetModalLabel">แก้ไขข้อมูลปีงบประมาณ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="#" method="post" id="edityear_form">
                    <input type="hidden" class="form-control" name="idYearTB_edit" id="idYearTB_edit"  style="width: 100%;">
                    <div class="row form-group">
                        <label for="inputext" class="col-sm-3 col-form-label">ปีงบประมาณ</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="yearName_edit" id="yearName_edit" placeholder="ปีงบประมาณที่">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="inputext" class="col-sm-3 col-form-label">วันเริ่มต้นปีงบประมาณ :</label>
                        <div class="input-group date form_date col-md-4" id="dateStart" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input_start_edit" data-link-format="dd-mm-yyyy">
                            <input class="form-control" size="14" type="text" value="" readonly>
                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                        </div>
                        <input type="hidden" id="dtp_input_start_edit" name="dtp_input_start_edit" value="" /><br/>
                    </div>
                    <div class="row form-group">
                        <label for="inputext" class="col-sm-3 col-form-label">วันสิ้นสุดปีงบประมาณ :</label>
                        <div class="input-group date form_date col-md-4" id="dateEnd" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input_end_edit" data-link-format="dd-mm-yyyy">
                            <input class="form-control" size="14" type="text" value="" readonly>
                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                        </div>
                        <input type="hidden" id="dtp_input_end_edit" name="dtp_input_end_edit" value="" /><br/>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">
                    ยกเลิก
                </button>
                <button type="button" id="editYearBtnModal" name="editYearBtnModal" class="btn btn-primary">บันทึก</button>
            </div>
        </div>
    </div>
</div>
