<div class="modal fade" id="addCustomerMarketPlan" tabindex="-1"
	role="dialog" aria-labelledby="addCustomerMarketPlan"
	style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addCustomer">เพิ่มการรับซื้อสินค้า</h5>
				<button type="button" class="close" data-dismiss="modal"
					aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body" style="padding: 1.5rem;">
				<from>
				<div class="form-group row">
					<label for="inputext" class="col-sm-2 col-form-label">ลุ่มน้ำ</label>
					<div class="col-sm-4">
						<select class="form-control" name="idRiverBasin" id="idRiverBasin">
							<?php echo loadRiverDependentInSS($conn, $_SESSION['RBAll']); ?>            
                          </select>
					</div>
				</div>
				<div class="form-group row">
					<label for="inputext" class="col-sm-2 col-form-label">พื้นที่</label>
					<div class="col-sm-10">
						<select class="form-control" name="idArea" id="idArea">
							<option value="0">กรุณาเลือก</option>
                            <?php
                                  echo loadAreaDependentInSS($conn, $_SESSION['RBAll'], $_SESSION['AreaAll']);
                            ?>
                        </select>
					</div>
				</div>

				<div class="form-group row">
					<label for="inputext" class="col-sm-2 col-form-label">ปีที่วางแผน</label>
					<div class="col-sm-4">
						<input type="text" id="plan_Year" name="plan_Year" value=""
							class="form-control" />
					</div>
					</div>
					<div class="form-group row">
					<label for="inputext" class="col-sm-2 col-form-label">ผู้รับซื้ิอ</label>
					<div class="col-sm-10">
						<select class="form-control" name="idCustomer" id="idCustomer">
							<option value="">กรุณาเลือก</option>
                                <?php
    
                                ?>
                            </select>
					</div>
				</div>



				<div class="form-group row">
					
					
					<label for="inputext" class="col-sm-2 col-form-label">ผลผลิต</label>
					<div class="col-sm-10">
						<select class="form-control" name="idAgri" id="idAgri">
							
						</select>
					</div>
				</div>


				<div class="form-group row">
					<label for="inputext" class="col-sm-2 col-form-label">จำนวนที่ต้องการต่อสัปดาห์</label>
					<div class="col-sm-4">
						<input type="text" id="agri_weekplan_amount"
							name="agri_weekplan_amount" value="" class="form-control" />
					</div>
					<label for="inputext" class="col-sm-2 col-form-label">สเปคสินค้าที่ต้องการ</label>
					<div class="col-sm-4">
						<input type="text" name="agri_spect" id="agri_spect" value=""
							class="form-control" />
					</div>
					
				</div>



				<div class="form-group row">
				<label for="inputext" class="col-sm-2 col-form-label">หน่วยนับ</label>
					<div class="col-sm-4">
						<select class="form-control" name="idCountUnit" id="idCountUnit">
							 <?php	
                                $sql2="select *  from CountUnit";
                                $stmt = sqlsrv_query( $conn, $sql2 );
        
                                while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                                  $id_pre=$row["idCountUnit"];
                                  $name_pre=$row["nameCountUnit"];
                                  echo "<option value='$id_pre'> $name_pre</option>";
                                }
                              ?>

						</select>
					</div>
					
					<label for="inputext" class="col-sm-2 col-form-label">มาตรฐาน</label>
					<div class="col-sm-4">
						<select class="form-control" name="idTypeOfStand"
							id="idTypeOfStand">
							 <?php	
                                $sql2="select *  from TypeOfStand";
                                $stmt = sqlsrv_query( $conn, $sql2 );
        
                                while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                                  $id_pre=$row["idTypeOfStand"];
                                  $name_pre=$row["nameTypeOfStand"];
                                  echo "<option value='$id_pre'> $name_pre</option>";
                                }
                              ?>

						</select>
					</div>
				</div>


				<div class="form-group row">
					<label for="inputext" class="col-sm-2 col-form-label">การขนส่ง</label>
					<div class="col-sm-4">
						<select class="form-control" name="logistic_id" id="logistic_id">
							 <?php	
                                $sql2="select *  from Logistic_TD";
                                $stmt = sqlsrv_query( $conn, $sql2 );
        
                                while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                                  $id_pre=$row["logistic_id"];
                                  $name_pre=$row["logistic_name"];
                                  echo "<option value='$id_pre'> $name_pre</option>";
                                }
                              ?>


						</select>
					</div>
					<label for="inputext" class="col-sm-2 col-form-label">ระยะเวลาคืนเงิน</label>
					<div class="col-sm-4">
						<input type="text" name="Refund_period" id="Refund_period"
							value="" class="form-control" />
					</div>
				</div>
				</from>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
				<button type="button" class="btn btn-primary"
					id="addCustomerMarketPlanBtn">ตกลง</button>
			</div>
		</div>
	</div>
</div>
