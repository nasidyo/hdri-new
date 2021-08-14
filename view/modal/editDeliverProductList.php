
<div class="modal fade" id="editDeliverProductFromList" tabindex="1" role="dialog" aria-labelledby="editDeliverProductFromListModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg"  role="document">
        <div class="modal-content" style="width: 1150px;">
            <div class="modal-header">
                <h5 class="modal-title" id="editDeliverProductFromListModalLabel">แก้ไขข้อมูลการส่งมอบ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="post" id="editDeliverProductFrom">
                    <input type="hidden" id="argi_Id" name="argi_Id" value="<?php echo $argi_Id?>">
                    <input type="hidden" id="market_Id" name="market_Id" value="<?php echo $market_Id?>">
                    <table id="showmodalList-table" name="showmodalList-table" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th><center>เลือกทั้งหมด <br/><input type="checkbox" class='checkall' id='checkallNB'></center></th>
                                <th><center>ว/ด/ป</center></th>
                                <th><center>รายชื่อเกษตรกร</center></th>
                                <th><center>พืชสาขา</center></th>
                                <th><center>ชนิดพืช</center></th>
                                <th><center>มาตราฐาน</center></th>
                                <th><center>เกรด</center></th>
                                <th style="width:10%"><center>ปริมาณ</center></th>
                                <th style="width:10%"><center>ราคาต่อหน่วย</center></th>
                                <th><center>มูลค่ารวม</center></th>
                                <th><center>ช่องทางตลาด</center></th>
                                <th><center>ผู้รับซื้อ</center></th>
                                <th style="width:13%"></th>
                                <th style="width:13%"></th>
                                <th style="width:13%" ></th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </from>
            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">
                    ยกเลิก
                </button>
                <button type="button" id="editDeliverProduct" name="editDeliverProduct" class="btn btn-primary">บันทึก</button>
            </div> -->
        </div>
    </div>
</div>
