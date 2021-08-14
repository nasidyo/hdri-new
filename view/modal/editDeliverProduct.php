
<div class="modal fade" id="editDeliverProductDetail" tabindex="0" role="dialog" aria-labelledby="deliverProductDetailModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deliverProductDetailModalLabel">แก้ไขข้อมูลการส่งมอบ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="#" method="post" id="deliverProduct_form">
                    <input type="hidden" id="action" name="action" value="update"/>
                    <input type="hidden" id="area_Id" name="area_Id" value="<?php echo $area_Id?>">
                    <input type="hidden" id="yearsId" name="yearsId" value="<?php echo $yearsId?>">
                    <input type="hidden" id="monthId" name="monthId" value="<?php echo $monthId?>">
                    <input type="hidden" id="idPersonMarket" name="idPersonMarket" value=""/>
                    <div class="row form-group">
                        <label for="inputext" class="col-sm-3 col-form-label">ชื่อเกษตรกร : <span style=" color: red; ">*</span> </label>
                        <div class="col-sm-4">
                        <input id="namePerson" name="namePerson"  value="" readonly class="form-control" type="text">
                        </div>
                    </div>
                    <input type="hidden" id="person_id" name="person_id" value=""/>
                    <div class="row form-group">
                        <label for="inputext" class="col-sm-3 col-form-label">วันที่ส่งมอบผลผลิต : <span style=" color: red; ">*</span> </label>
                        <div class="col-sm-4">
                            <input id="dateDeliver" name="dateDeliver" value="" readonly class="form-control" type="text">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="inputext" class="col-sm-3 col-form-label">พืชสาขา : <span style=" color: red; ">*</span> </label>
                        <div class="col-sm-4">
                            <select class="form-control"name="typeAgri_Id" id="typeAgri_Id">
                                <option value='0'>กรุณาเลือก</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">ชนิดพืช : <span style=" color: red; ">*</span> </label>
                        <div class="col-sm-4">
                            <select class="form-control"name="agri_Id" id="agri_Id">
                                <option value='0'>กรุณาเลือก</option>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="inputext" class="col-sm-3 col-form-label">ช่องทางการตลาด : <span style=" color: red; ">*</span> </label>
                        <div class="col-sm-4">
                            <select class="form-control"name="market_Id" id="market_Id">
                                <option value='0'>กรุณาเลือก</option>
                                <?php
                                    echo loadMarketList($conn, $area_Id);
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="inputext" class="col-sm-3 col-form-label">ปริมาณที่ส่งมอบ : <span style=" color: red; ">*</span> </label>
                        <div class="col-sm-4">
                            <input id="quality" name="quality" placeholder="จำนวนผลผลิตที่ส่งมอบ" onkeypress="return isNumberKey(this,event)" value="" class="form-control" type="text">
                        </div>
                        <label for="inputext" class="col-sm-2 col-form-label" id="unitCodeProduct" name="unitCodeProduct"></label>
                    </div>

                    <div class="row form-group">
                        <label for="inputext" class="col-lg-3 col-form-label">ปริมาณสูญเสีย</label>
                        <div class="col-sm-4">
                            <input id="lossValue" name="lossValue" onkeypress="return isNumberKey(this,event)" placeholder="ปริมาณสูญเสีย" value="" class="form-control" type="text">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="inputext" class="col-lg-3 col-form-label">ปริมาณสุทธิ</label>
                        <div class="col-sm-4">
                            <input id="totalQuality" name="totalQuality" onkeypress="return isNumberKey(this,event)" placeholder="ปริมาณสุทธิ" value="" readonly class="form-control" type="text">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="inputext" class="col-sm-3 col-form-label">ราคาต่อหน่วย : <span style=" color: red; ">*</span> </label>
                        <div class="col-sm-4">
                            <input id="price" name="price" placeholder="ราคาสินค้าต่อหน่วย" onkeypress="return isNumberKey(this,event)" value="" class="form-control" type="text">
                        </div>
                        <label for="inputext" class="col-sm-3 col-form-label">บาท</label>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">เกรดสินค้า :</label>
                        <div class="col-sm-4">
                            <select class="form-control"name="gardsProduct" id="gardsProduct">
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">มาตรฐาน :</label>
                        <div class="col-sm-4">
                            <select class="form-control"name="standardProduct" id="standardProduct">
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="inputext" class="col-sm-3 col-form-label">มูลค่ารวม :</label>
                        <div class="col-sm-4">
                            <input id="totalPricre" name="totalPricre" placeholder="ราคาสินค้าต่อหน่วย" value="" readonly class="form-control" type="text">
                        </div>
                        <label for="inputext" class="col-sm-3 col-form-label">บาท</label>
                    </div>
                    <div class="row">
                        <label for="inputext" class="col-lg-3 col-form-label">วันที่เพาะปลูก : <span style=" color: red; ">*</span> </label>
                        <div class="input-group date form_date dateAll col-lg-4" id="dateCultivate" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input3" data-link-format="dd-mm-yyyy">
                            <input class="form-control" size="14" type="text" value="" readonly>
                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                        </div>
                        <input type="hidden" id="dtp_input3" name="dtp_input3" value="" /><br/>
                        
                    </div>
                    <div class="row form-group">
                        <div class="col-lg-3 col-form-label"></div>
                        <label class="col-lg-6 col-form-label text-required ">(หากไม่ทราบหรือจำไม่ได้ ให้ระบุโดยการประมาณ)</label>
                    </div>
                    <div class="row">
                        <label for="inputext" class="col-lg-3 col-form-label">วันที่เก็บผลผลิต : <span style=" color: red; ">*</span> </label>
                        <div class="input-group date form_date dateAll col-lg-4" id="dateHarvest" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input4" data-link-format="dd-mm-yyyy">
                            <input class="form-control" size="14" type="text" value="" readonly>
                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                        </div>
                        <input type="hidden" id="dtp_input4" name="dtp_input4" value="" /><br/>
                        <!-- <label class="col-lg-4 col-form-label text-required ">(หากไม่ทราบหรือจำไม่ได้ ให้ระบุโดยการประมาณ)</label> -->
                    </div>
                    <div class="row form-group">
                        <div class="col-lg-3 col-form-label"></div>
                        <label class="col-lg-6 col-form-label text-required ">(หากไม่ทราบหรือจำไม่ได้ ให้ระบุโดยการประมาณ)</label>
                    </div>
                    <div class="row">
                        <label class="col-sm-3 col-form-label">แปลงที่ปลูก :</label>
                        <div class="col-sm-4">
                            <select class="form-control"name="landDetail" id="landDetail">
                                <option value='0'>กรุณาเลือก</option>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-lg-3 col-form-label"></div>
                        <label class="col-lg-6 col-form-label text-required ">(แหล่งข้อมูลมาจากการสำรวจที่ดินรายแปลง)</label>
                    </div>
                    <div class="row form-group">
                        <label for="inputext" class="col-sm-3 col-form-label">วิธีการขนส่ง :</label>
                        <div class="col-sm-4">
                            <select class="form-control"name="logistic_Id" id="logistic_Id">
                                <option value='0'>กรุณาเลือก</option>
                                <?php
                                    echo loadLogisticList($conn);
                                ?>
                            </select>
                        </div>
                        <!-- <div class="col-sm-1">
                            <a class="btn btn-primary btn-sm" href="javascript:void(0)" id="addNewLogistic" name="addNewLogistic" role="button"><i class="fa fa-plus"></i> เพิ่มวิธีการขนส่ง</a>
                        </div> -->
                    </div>
                    <div class="row form-group">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-2">
                            <a class="btn btn-primary btn-sm" href="javascript:void(0)" id="uploadImageOpen" name="uploadImageOpen" role="button"><i class="fa fa-plus"></i> อัพโหลดรูปภาพประกอบ</a>
                        </div>
                    </div>
                    <div class="row form-group">
                    <div class="col-sm-2"></div>
                        <div class="col-sm-6">
                                <table class="table" id="editImageTable" style="width:100%">
                                    <tbody>
                                    </tbody>
                                </table>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">
                    ยกเลิก
                </button>
                <button type="button" id="editDeliverProduct" name="editDeliverProduct" class="btn btn-primary">บันทึก</button>
            </div>
        </div>
    </div>
</div>
