<?php
require '../connection/database.php';
require '../model/reportIncome.php';

$db = new Database();
$conn=  $db->getConnection();
if (isset($_POST['years_Id'])) {
  $years_Id = $_POST['years_Id'];
}
if (isset($_POST['actionPage'])) {
  $actionPage = $_POST['actionPage'];
}
if (isset($_POST['area_Id'])) {
  $area_Id = $_POST['area_Id'];
}
if (isset($_POST['idRiverBasin'])) {
  $idRiverBasin = $_POST['idRiverBasin'];
}

if (isset($_POST['typeOfAgri_id'])) {
  $typeOfAgri_id = $_POST['typeOfAgri_id'];
}
$agriList = '';
if (isset($_POST['agriList'])) {
  $agriList = $_POST['agriList'];
}
if (isset($_POST['typeofStandardId'])) {
  $typeofStandardId = $_POST['typeofStandardId'];
}
if (isset($_POST['typeOfGradeId'])) {
  $typeOfGradeId = $_POST['typeOfGradeId'];
}
if (isset($_POST['speciesId'])) {
  $speciesId = $_POST['speciesId'];
}
if($actionPage == 'Nofind'){
    $sql = "
        SELECT psmk.TypeOfArgi_idTypeOfArgi, toa.nameTypeOfArgi
        FROM PersonMarket_TD psmk
        INNER JOIN TypeOfArgi_TD toa ON psmk.TypeOfArgi_idTypeOfArgi=toa.idTypeOfArgi
        WHERE psmk.YearID = '".$years_Id."'
        GROUP BY TypeOfArgi_idTypeOfArgi, nameTypeOfArgi
    ";
}else{
    if($agriList == ''){
      $sql = "
          SELECT psmk.TypeOfArgi_idTypeOfArgi, toa.nameTypeOfArgi
          FROM PersonMarket_TD psmk
          INNER JOIN TypeOfArgi_TD toa ON psmk.TypeOfArgi_idTypeOfArgi=toa.idTypeOfArgi";
          if($idRiverBasin != '0'){
            $sql .="
              LEFT JOIN (SELECT idArea
                FROM MainTarget 
                WHERE idRiverBasin = '".$idRiverBasin."') mtg ON psmk.Area_idArea IN (mtg.idArea) ";
          }
          $sql .=" WHERE psmk.YearID = '".$years_Id."'";
          if($area_Id != '0'){
            $sql .=" and psmk.Area_idArea = '".$area_Id."'";
          }
      $sql .="
          GROUP BY TypeOfArgi_idTypeOfArgi, nameTypeOfArgi
          ";
    }else{
      if(count($agriList) == '1'){
          $sql = "
          SELECT psmk.Agri_idAgri, 
          CASE 
          WHEN psmk.species_Id = '' THEN ag.nameArgi+' (เกรด:'+gr.codeGrade+')'
          WHEN psmk.species_Id IS NULL THEN ag.nameArgi +' (เกรด:'+gr.codeGrade+')'
          ELSE ag.nameArgi+' (พันธุ์:'+sa.species_name+') (เกรด:'+gr.codeGrade+')' END as nameOFArgi,
          psmk.Grade_codeGrade, psmk.species_Id 
          FROM PersonMarket_TD psmk
          INNER JOIN Agri_TD ag ON psmk.Agri_idAgri=ag.idAgri
          LEFT JOIN SpeciesArgi_TD sa ON ag.idAgri = sa.Agri_idAgri and psmk.species_Id = sa.species_Id
          INNER JOIN Grade gr ON psmk.Grade_codeGrade = gr.idGrade";
          if($idRiverBasin != '0'){
            $sql .="
            LEFT JOIN (SELECT idArea
                FROM MainTarget 
                WHERE idRiverBasin = '".$idRiverBasin."') mtg ON psmk.Area_idArea IN (mtg.idArea) ";
          }
          $imploded_arr = implode(',', $agriList);
          $sql .=" WHERE psmk.YearID = '".$years_Id."' and psmk.Agri_idAgri in (".$imploded_arr.")";
          if($area_Id != '0'){
              $sql .=" and psmk.Area_idArea = '".$area_Id."'";
          }
          if($speciesId != 'ALL'){
            $sql .=" and psmk.species_Id = '".$speciesId."'";
          }
          if($typeOfGradeId != 'ALL'){
              $sql .=" and psmk.Grade_codeGrade = '".$typeOfGradeId."'";
          }
          if($typeofStandardId != 'ALL'){
              $sql .=" and psmk.TypeOfStand_idTypeOfStand = '".$typeofStandardId."'";
          }
        $sql .="
          GROUP BY psmk.Agri_idAgri, nameArgi, speciesArgi, psmk.Grade_codeGrade, psmk.species_Id, sa.species_name, codeGrade
        ";
      }else{
        if($typeOfGradeId == 'ALL'){
          $sql = "
              SELECT psmk.Agri_idAgri, 
              CASE 
              WHEN ag.speciesArgi = '' THEN ag.nameArgi+' (เกรด:'+gr.codeGrade+')'
              WHEN ag.speciesArgi IS NULL THEN ag.nameArgi +' (เกรด:'+gr.codeGrade+')'
              ELSE ag.nameArgi+' (พันธุ์:'+ag.speciesArgi+') (เกรด:'+gr.codeGrade+')' END as nameOFArgi,
              psmk.Grade_codeGrade 
              FROM PersonMarket_TD psmk
              INNER JOIN Agri_TD ag ON psmk.Agri_idAgri=ag.idAgri
              INNER JOIN Grade gr ON psmk.Grade_codeGrade = gr.idGrade ";
              if($idRiverBasin != '0'){
                $sql .="
                LEFT JOIN (SELECT idArea
                    FROM MainTarget 
                    WHERE idRiverBasin = '".$idRiverBasin."') mtg ON psmk.Area_idArea IN (mtg.idArea) ";
              }
              $imploded_arr = implode(',', $agriList);
              $sql .=" WHERE psmk.YearID = '".$years_Id."' and psmk.Agri_idAgri in (".$imploded_arr.")";
              if($area_Id != '0'){
                $sql .=" and psmk.Area_idArea = '".$area_Id."'";
              }
              if($typeofStandardId != 'ALL'){
                $sql .=" and psmk.TypeOfStand_idTypeOfStand = '".$typeofStandardId."'";
              }
          $sql .="
              GROUP BY Agri_idAgri, nameArgi, speciesArgi, codeGrade, psmk.Grade_codeGrade
            ";
        }else{
          $sql = "
              SELECT psmk.Agri_idAgri, 
              CASE 
              WHEN ag.speciesArgi = '' THEN ag.nameArgi+' (มาตราฐาน:'+ts.nameTypeOfStand+')'
              WHEN ag.speciesArgi IS NULL THEN ag.nameArgi +' (มาตราฐาน:'+ts.nameTypeOfStand+')'
              ELSE ag.nameArgi+' (พันธุ์:'+ag.speciesArgi+') (มาตราฐาน:'+ts.nameTypeOfStand+')' END as nameOFArgi,
              psmk.TypeOfStand_idTypeOfStand ,psmk.Grade_codeGrade 
              FROM PersonMarket_TD psmk
              INNER JOIN Agri_TD ag ON psmk.Agri_idAgri=ag.idAgri
              INNER JOIN Grade gr ON psmk.Grade_codeGrade = gr.idGrade
              INNER JOIN TypeOfStand ts ON psmk.TypeOfStand_idTypeOfStand = ts.idTypeOfStand ";
              if($idRiverBasin != '0'){
                $sql .="
                LEFT JOIN (SELECT idArea
                    FROM MainTarget 
                    WHERE idRiverBasin = '".$idRiverBasin."') mtg ON psmk.Area_idArea IN (mtg.idArea) ";
              }
              $imploded_arr = implode(',', $agriList);
              $sql .=" WHERE psmk.YearID = '".$years_Id."' and psmk.Agri_idAgri in (".$imploded_arr.")";
              if($area_Id != '0'){
                  $sql .=" and psmk.Area_idArea = '".$area_Id."'";
              }
              if($typeOfGradeId != 'ALL'){
                  $sql .=" and psmk.Grade_codeGrade = '".$typeOfGradeId."'";
              }
              if($typeofStandardId != 'ALL'){
                  $sql .=" and psmk.TypeOfStand_idTypeOfStand = '".$typeofStandardId."'";
              }
          $sql .="
              GROUP BY Agri_idAgri, nameArgi, speciesArgi, nameTypeOfStand ,psmk.TypeOfStand_idTypeOfStand, psmk.Grade_codeGrade
            ";
        }
      }
    }
}
// echo $sql;
$stmt = sqlsrv_query( $conn, $sql);
    $data = array();
    if( !$stmt ) {
        die( print_r( sqlsrv_errors(), true));
    }
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
      if($agriList == ''){
          $row_array['nameTypeOfArgi'] = $row['nameTypeOfArgi'];
          $sql2 = "
              SELECT moy.Month_id, COALESCE(SUM(psmk.TotalValue),'0') AS totalIncome, moy.Month_Etc, moy.Month_seq
              FROM MonthOfYear moy
              LEFT JOIN ( SELECT TotalValue, MonthNo, Area_idArea
              FROM PersonMarket_TD pmk";
                if($idRiverBasin != '0'){
                  $sql2 .="
                    INNER JOIN (SELECT idArea
                      FROM MainTarget 
                      WHERE idRiverBasin = '".$idRiverBasin."') mtg ON pmk.Area_idArea IN (mtg.idArea) ";
                }
                if($area_Id != '0'){
                  $sql2 .=" and pmk.Area_idArea = '".$area_Id."'";
                }
                $sql2 .=" WHERE TypeOfArgi_idTypeOfArgi='".$row['TypeOfArgi_idTypeOfArgi']."' and YearID = '".$years_Id."') psmk ON moy.Month_id = psmk.MonthNo ";
                $sql2.= "GROUP BY Month_id, Month_Etc, Month_seq
                  ORDER BY Month_seq
          ";
          $stmt2 = sqlsrv_query( $conn, $sql2);
          $dataset = [];
          while( $row2 = sqlsrv_fetch_array( $stmt2, SQLSRV_FETCH_ASSOC) ) {
              // array_push($dataset, $row2['totalIncome']);
              $row_array[$row2['Month_id']] = $row2['totalIncome'];
          }
          // $row_array['dataset'] = $dataset;
          array_push($data, $row_array);
      }else{
          if(count($agriList) == '1'){
            $row_array['nameTypeOfArgi'] = $row['nameOFArgi'];
            $sql2 = "
            SELECT moy.Month_id, COALESCE(SUM(psmk.TotalValue),'0') AS totalIncome , moy.Month_Etc, moy.Month_seq
            FROM MonthOfYear moy
            LEFT JOIN ( SELECT pmk.TotalValue, pmk.MonthNo ,pmk.Area_idArea
            FROM PersonMarket_TD pmk ";
            if($idRiverBasin != '0'){
              $sql2 .="
                INNER JOIN (SELECT idArea
                  FROM MainTarget 
                  WHERE idRiverBasin = '".$idRiverBasin."') mtg ON pmk.Area_idArea IN (mtg.idArea) ";
            }
            if($area_Id != '0'){
              $sql2 .=" and pmk.Area_idArea = '".$area_Id."'";
            }
            $sql2 .=" WHERE Agri_idAgri='".$row['Agri_idAgri']."' and YearID = '".$years_Id."'";
            if($row['species_Id'] != null || $row['species_Id'] != ''){
              $sql2.=" and pmk.species_Id = '".$row['species_Id']."'";
            }
            if($typeOfGradeId == 'ALL'){
              $sql2.="and Grade_codeGrade ='".$row['Grade_codeGrade']."'";
            }else{
              $sql2.="and Grade_codeGrade ='".$row['Grade_codeGrade']."'";
              $sql2.="and TypeOfStand_idTypeOfStand ='".$row['TypeOfStand_idTypeOfStand']."'";
            }
            $sql2.=") psmk ON moy.Month_id = psmk.MonthNo ";
            $sql2.="GROUP BY Month_id, Month_Etc, Month_seq
                ORDER BY Month_seq
            ";
            $stmt2 = sqlsrv_query( $conn, $sql2);
            if( !$stmt2 ) {
              die( print_r( sqlsrv_errors(), true));
            }
            $dataset = [];
            while( $row2 = sqlsrv_fetch_array( $stmt2, SQLSRV_FETCH_ASSOC) ) {
                $row_array[$row2['Month_id']] = $row2['totalIncome'];
            }
            array_push($data, $row_array);
          }else{
            $row_array['nameTypeOfArgi'] = $row['nameOFArgi'];
            $sql2 = "
            SELECT moy.Month_id, COALESCE(SUM(psmk.TotalValue),'0') AS totalIncome , moy.Month_Etc, moy.Month_seq
            FROM MonthOfYear moy
            LEFT JOIN ( SELECT pmk.TotalValue, pmk.MonthNo ,pmk.Area_idArea
            FROM PersonMarket_TD pmk ";
            if($idRiverBasin != '0'){
              $sql2 .="
                INNER JOIN (SELECT idArea
                  FROM MainTarget 
                  WHERE idRiverBasin = '".$idRiverBasin."') mtg ON pmk.Area_idArea IN (mtg.idArea) ";
            }
            if($area_Id != '0'){
              $sql2 .=" and pmk.Area_idArea = '".$area_Id."'";
            }
            $sql2 .=" WHERE Agri_idAgri='".$row['Agri_idAgri']."' and YearID = '".$years_Id."' ";
            if($typeOfGradeId == 'ALL'){
              $sql2.="and Grade_codeGrade ='".$row['Grade_codeGrade']."'";
            }else{
              $sql2.="and Grade_codeGrade ='".$row['Grade_codeGrade']."'";
              $sql2.="and TypeOfStand_idTypeOfStand ='".$row['TypeOfStand_idTypeOfStand']."'";
            }
            $sql2.=") psmk ON moy.Month_id = psmk.MonthNo ";
            $sql2.="GROUP BY Month_id, Month_Etc, Month_seq
                ORDER BY Month_seq
            ";
            $stmt2 = sqlsrv_query( $conn, $sql2);
            if( !$stmt2 ) {
              die( print_r( sqlsrv_errors(), true));
            }
            $dataset = [];
            while( $row2 = sqlsrv_fetch_array( $stmt2, SQLSRV_FETCH_ASSOC) ) {
                $row_array[$row2['Month_id']] = $row2['totalIncome'];
            }
            array_push($data, $row_array);
          }
      }
    }
echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
?>