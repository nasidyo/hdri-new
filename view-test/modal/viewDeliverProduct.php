
<div class="modal fade" id="viewDeliverProductDetail" tabindex="-1" role="dialog" aria-labelledby="viewDeliverProductDetailModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewDeliverProductDetailModalLabel">ข้อมูลการส่งมอบ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="#" method="post" id="viewDeliverProduct_form">
                    <input type="hidden" id="action" name="action" value="update"/>
                    <input type="hidden" id="area_Id" name="area_Id" value="<?php echo $area_Id?>">
                    <input type="hidden" id="yearsId" name="yearsId" value="<?php echo $yearsId?>">
                    <input type="hidden" id="monthId" name="monthId" value="<?php echo $monthId?>">
                    <input type="hidden" id="idPersonMarket" name="idPersonMarket" value=""/>
                    <div class="row form-group">
                        <label for="inputext" class="col-sm-3 col-form-label">ชื่อเกษตรกร :</label>
                        <div class="col-sm-4">
                            <input id="namePerson" name="namePerson"  value="" readonly class="form-control" type="text">
                        </div>
                    </div>
                    <input type="hidden" id="person_id" name="person_id" value=""/>
                    <div class="row form-group">
                        <label for="inputext" class="col-sm-3 col-form-label">วันที่ส่งมอบผลผลิต :</label>
                        <div class="col-sm-4">
                            <input id="dateDeliver" name="dateDeliver" value="" readonly class="form-control" type="text">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="inputext" class="col-sm-3 col-form-label">พืชสาขา :</label>
                        <div class="col-sm-4">
                            <input id="typeAgri_Name" name="typeAgri_Name"  value="" readonly class="form-control" type="text">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">ชนิดพืช :</label>
                        <div class="col-sm-4">
                            <input id="agri_Name" name="agri_Name"  value="" readonly class="form-control" type="text">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="inputext" class="col-sm-3 col-form-label">ช่องทางการตลาด :</label>
                        <div class="col-sm-6">
                            <input id="market_Name" name="market_Name"  value="" readonly class="form-control" type="text">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="inputext" class="col-sm-3 col-form-label">ปริมาณที่ส่งมอบ :</label>
                        <div class="col-sm-4">
                            <input id="quality" name="quality" value="" class="form-control" readonly type="text">
                        </div>
                        <label for="inputext" class="col-sm-3 col-form-label" id="unitCodeProduct" name="unitCodeProduct"></label>
                    </div>
                    <div class="row form-group">
                        <label for="inputext" class="col-sm-3 col-form-label">ราคาต่อหน่วย :</label>
                        <div class="col-sm-4">
                            <input id="price" name="price" value="" readonly class="form-control" type="text">
                        </div>
                        <label for="inputext" class="col-sm-3 col-form-label">บาท</label>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">เกรดสินค้า :</label>
                        <div class="col-sm-4">
                            <input id="gardsProduct" name="gardsProduct" value="" readonly class="form-control" type="text">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">มาตรฐาน :</label>
                        <div class="col-sm-4">
                            <input id="standardProduct" name="standardProduct" value="" readonly class="form-control" type="text">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="inputext" class="col-sm-3 col-form-label">มูลค่ารวม :</label>
                        <div class="col-sm-4">
                            <input id="totalPricre" name="totalPricre" placeholder="ราคาสินค้าต่อหน่วย" value="" readonly class="form-control" type="text">
                        </div>
                        <label for="inputext" class="col-sm-3 col-form-label">บาท</label>
                    </div>
                    <div class="row form-group">
                        <label for="inputext" class="col-sm-3 col-form-label">วันที่เพาะปลูก :</label>
                        <div class="col-sm-4">
                            <input id="dateCultivate" name="dateCultivate" value="" readonly class="form-control" type="text">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="inputext" class="col-sm-3 col-form-label">วันที่เก็บผลผลิต :</label>
                        <div class="col-sm-4">
                            <input id="dateHarvest" name="dateHarvest" value="" readonly class="form-control" type="text">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="inputext" class="col-sm-3 col-form-label">วิธีขนส่ง :</label>
                        <div class="col-sm-4">
                            <input id="deliver_Name" name="deliver_Name" value="" readonly class="form-control" type="text">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="inputext" class="col-sm-3 col-form-label">ภาพประกอบ :</label>
                        <div class="col-sm-6">
                            <table class="table" id="imageTable">
                                <tbody>
                                
                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
