
<div class="modal fade" id="editPlanProductFromList" tabindex="-1" role="dialog" aria-labelledby="editPlanProductFromListModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg"  role="document">
        <div class="modal-content" style="width: 1100px;">
            <div class="modal-header">
                <h5 class="modal-title" id="editPlanProductFromListModalLabel">แก้ไขข้อมูลการส่งมอบ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="post" id="editPlanProductFrom">
                    <input type="hidden" id="argi_Id" name="argi_Id" value="<?php echo $argi_Id?>">
                    <input type="hidden" id="market_Id" name="market_Id" value="<?php echo $market_Id?>">
                    <table id="planProductList-table" name="planProductList-table" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th><center>เลือกทั้งหมด <br/><input type="checkbox" class='checkallNB' id='checkallNB'></center></th>
                                <th><center>เดือน</center></th>
                                <th><center>สาขาพืช</center></th>
                                <th><center>ชนิดพืช</center></th>
                                <th><center>ช่องทางตลาด</center></th>
                                <th><center>ผู้รับซื้อ</center></th>
                                <th><center>หน่วย<</center></th> <!-- 10 -->
                                <th><center>ปริมาณ</center></th>
                                <th><center>ราคาต่อหน่วย</center></th>
                                <th><center>มูลค่ารวม</center></th>
                                <th></th>
                                <th></th>
                                <th>ลุ่มน้ำ</th>
                                <th>พื้นที่เป้าหมาย</th>
                                <th>ปี พ.ศ</th>
                                <th>โครงการ</th>
                                <th>พื้นที่</th>
                                <th>จำนวน</th>
                                <th>พื้นที่ (ไร่)</th>
                                <th>โรงเรือน </th>
                                <th>ต้น</th>
                                <th>ตัว</th>
                                <th>ฟาร์ม</th>
                                <th>ปริมาณ</th>
                                <th>ราคาต่อหน่วย</th>
                                <th></th>
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
