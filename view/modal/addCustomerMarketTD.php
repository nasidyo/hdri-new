<div class="modal fade" id="addCustomerMarket" tabindex="-1" role="dialog" aria-labelledby="addCustomerMarket" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addCustomer">เพิ่มตลาดและพื้นที่   </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body" style=" padding: 1.5rem; ">
                                    <from>

                                       <div class="form-group row">
											<label for="inputext" class="col-sm-2 col-form-label">ลุ่มน้ำ</label>
											<div class="col-sm-4">
												<select class="form-control" name="idRiverBasin"
													id="idRiverBasin">
                                                    <!-- <option value="0">กรุณาเลือก</option> -->
                                                    <?php echo loadRiverDependentInSS($conn, $_SESSION['RBAll']); ?>
                                                    </select>

											</div>
										</div>

										<div class="form-group row">
											<label class="col-sm-2 col-form-label">พื้นที่</label>
											<div class="col-sm-8">
												<select class="form-control" name="idArea" id="idArea">
                                                
                                                </select>
											</div>
										</div>
										
										<div class="form-group row">
											<label class="col-sm-2 col-form-label">ช่องทางตลาด</label>
											<div class="col-sm-8">
												<select class="form-control" name="idMarket" id="idMarket" style="width: 100%;">
                                               <?php
                                                $sql2="select *  from Market_TD";
                                                echo "<option value=0 >กรุณาเลือก</option>";
                                                $stmt = sqlsrv_query( $conn, $sql2 );

                                                while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                                                $id_pre=$row["idMarket"];
                                                $name_pre=$row["nameMarket"];
                                                echo "<option value='$id_pre' > $name_pre</option>";
                                                }
                                            ?>
                                                </select>
											</div>
										</div>
										
										
										<div class="form-group row">
											<label class="col-sm-2 col-form-label">รายชื่อผู้รับซื้อ</label>
											<div class="col-sm-8">
												<select class="form-control" name="customer_id" id="customer_id" style="width: 100%;">
                                              
                                                </select>
											</div>
										</div>

                                    </from>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                                <button type="button" class="btn btn-primary" id="addCustomerMarketBtn">ตกลง</button>
                            </div>
                        </div>
                    </div>
                </div>
