<?php 
  function loadMonthInput($conn){
    $sql2 = "
      SELECT Month_id, Month_name
      FROM MonthOfYear
      ORDER BY Month_seq";
    $stmt = sqlsrv_query( $conn, $sql2 );
    $data = '';
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
        $data .="<div class='row form-group'>
                <div class='col-lg-1'></div>
                <div class='col-lg-1 col-form-label'>
                    <label for='plan-plant' class='form-control-label'>".$row['Month_name']."</label>
                </div>
                <div class='col-form-label'>
                    <label for='plan-plant' class='form-control-label'>ปริมาณ</label>
                </div>
                <div class='col-lg-1'>
                    <input id='".$row['Month_id']."_quantity' name='".$row['Month_id']."_quantity' value='' class='form-control number quantity' type='text'>
                </div>
                <div class='col-form-label'>
                    <label for='plan-plant' class='form-control-label'>ราคาต่อหน่วย</label>
                </div>
                <div class='col-lg-1'>
                    <input id='".$row['Month_id']."_pricePer' name='".$row['Month_id']."_pricePer' value='' class='form-control number pricePer' type='text'>
                </div>
                <div class='col-form-label'>
                    <label for='plan-plant' class='form-control-label'>รวม</label>
                </div>
                <div class='col-lg-1'>
                    <input id='".$row['Month_id']."_TotalPrice' name='".$row['Month_id']."_TotalPrice' value='' class='form-control totalPrice' type='text' readonly='readonly'>
                </div>
                <div class='col-lg-2 col-form-label'>
                    <label for='plan-plant' class='pr-1 form-control-label'>บาท</label>
                </div>
            </div>";
    }
    if ($data != ''){
        $data .="<div class='row form-group'>
                    <div class='col-lg-2'></div>
                    <div class='col-form-label'>
                        <label for='plan-plant' class='form-control-label'>ปริมาณรายปี</label>
                    </div>
                    <div class='col-lg-1'>
                        <input id='totalQuantity' name='totalQuantity' placeholder='0' value='' class='form-control' type='text' readonly='readonly'>
                    </div>
                    <div class='col-lg-1'></div>
                    <div class='col-form-label'>
                        <label for='plan-plant' class='form-control-label'>มูลค่ารายปี</label>
                    </div>
                    <div class='col-lg-1'>
                        <input id='totalPriceOfYears' name='totalPriceOfYears' placeholder='0' value='' class='form-control' type='text' readonly='readonly'>
                    </div>
                    <div class='col-lg-2 col-form-label'>
                        <label for='plan-plant' class='pr-1 form-control-label'>บาท</label>
                    </div>
                </div>";
    }
    echo $data;
  }
?>