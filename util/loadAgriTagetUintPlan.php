<?php
    require '../connection/database.php';
    $db = new Database();
    $conn=  $db->getConnection();
    $sql2 = "
      SELECT tot.idTypeOfTarget, tot.nameTypeOfTarget
      FROM list_taget_agri_unit_plan ltaup, TypeOfTarget tot
      WHERE ltaup.taget_unit = tot.idTypeOfTarget 
      and ltaup.idAgri = '".$_POST["argi_id"]."'";
    $stmt = sqlsrv_query( $conn, $sql2 );
    $data = "<form class='form-horizontal' action='#' method='post' id='support_form'>
              <div class='row form-group'>
                  <label for='inputext' class='col-sm-2 col-form-label'>จำนวนเกษตรกรทั้งหมดที่ส่งเสริม :</label>
                  <div class='col-sm-4'>
                    <input id='1' name='1' placeholder='จำนวนที่ส่งเสริม' value='' onkeypress='return isNumberKey(this,event)' class='form-control' type='text'/>
                  </div>
              </div>
              <div class='row form-group'>
                  <label for='inputext' class='col-sm-2 col-form-label'>พื้นที่ (ไร่) :</label>
                  <div class='col-sm-4'>
                    <input id='2' name='2' placeholder='จำนวนที่ส่งเสริม' onkeypress='return isNumberKey(this,event)' value='' class='form-control' type='text'/>
                  </div>
              </div>
              <div class='row form-group'>
                  <label for='inputext' class='col-sm-2 col-form-label'>โรงเรือน :</label>
                  <div class='col-sm-4'>
                    <input id='3' name='3' placeholder='จำนวนที่ส่งเสริม' onkeypress='return isNumberKey(this,event)' value='' class='form-control' type='text'/>
                  </div>
              </div>
              <div class='row form-group'>
                  <label for='inputext' class='col-sm-2 col-form-label'>ต้น :</label>
                  <div class='col-sm-4'>
                    <input id='5' name='' placeholder='จำนวนที่ส่งเสริม' onkeypress='return isNumberKey(this,event)' value='' class='form-control' type='text'/>
                  </div>
              </div>
              <div class='row form-group'>
                  <label for='inputext' class='col-sm-2 col-form-label'>ตัว :</label>
                  <div class='col-sm-4'>
                    <input id='11' name='11' placeholder='จำนวนที่ส่งเสริม' onkeypress='return isNumberKey(this,event)' value='' class='form-control' type='text'/>
                  </div>
              </div>
              <div class='row form-group'>
                  <label for='inputext' class='col-sm-2 col-form-label'>ฟาร์ม :</label>
                  <div class='col-sm-4'>
                    <input id='12' name='12' placeholder='จำนวนที่ส่งเสริม' onkeypress='return isNumberKey(this,event)' value='' class='form-control' type='text'/>
                  </div>
              </div>";
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
      $id_pre=$row["idTypeOfTarget"];
      $name_pre=$row["nameTypeOfTarget"];
      if($id_pre != '1' and $id_pre != '2' and $id_pre != '3' and $id_pre != '5' and $id_pre != '11' and $id_pre != '12'){
        $data .= "<div class='row form-group'>
                    <label for='inputext' class='col-sm-2 col-form-label'>".$name_pre." :</label>
                    <div class='col-sm-4'>
                      <input id='".$id_pre."' name='".$id_pre."' placeholder='จำนวนที่ส่งเสริม' onkeypress='return isNumberKey(this,event)' value='' class='form-control' type='text'/>
                    </div>
                  </div>";
      }
    }
    $data .= "</form>";
    echo $data;

?>