
<div class="modal fade" id="copyDeliverProduct" tabindex="-1" role="dialog" aria-labelledby="copyDeliverProductModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="copyDeliverProductModalLabel">คัดลอกการส่งมอบผลผลิต</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="#" method="post" id="copyDeliverProduct_from">
                    <div class="form-group row">
                        <label for="inputext" class="col-sm-2 col-form-label">ปีงบประมาณ :</label>
                        <div class="col-sm-6">
                            <select class="form-control"name="yearsOfDeliver" id="yearsOfDeliver">
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputext" class="col-sm-2 col-form-label">เดือน :</label>
                        <div class="col-sm-6">
                            <select class="form-control"name="monthsOfDeliver" id="monthsOfDeliver">
                                <option value='0'>กรุณาเลือก</option>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group"></div>
                    <div class="row form-group">
                        <div class="col-sm-12" style="height: 500px; overflow-y: auto;" >
                            <table id="deliverProductList-Table" name="deliverProductList-Table" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" name="select_all" value="1" id="example-select-all" ></th>
                                        <th>รายชื่อเกษตรกร</th>
                                        <th>พืชสาขา</th>
                                        <th>ชนิดพืช</th>
                                        <th>มาตราฐาน</th>
                                        <th>เกรด</th>
                                        <th>ช่องทางตลาด</th>
                                        <th>ผู้รับซื้อ</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">
                    ยกเลิก
                </button>
                <button type="button" id="saveCopyDeliverProductBtn" name="saveCopyDeliverProductBtn" class="btn btn-primary">คัดลอกการส่งมอบ</button>
            </div>
        </div>
    </div>
</div>
