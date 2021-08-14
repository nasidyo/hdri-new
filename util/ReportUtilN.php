<?php 
 require '../connection/database.php';

 $db = new Database();
 $conn=  $db->getConnection();
 $idRiverBasin =0;
    if (isset($_POST['idRiverBasin'])) {
        $idRiverBasin =$_POST['idRiverBasin'];
    }
    if (isset($_POST['area_Id'])) {
        $area_Id = $_POST['area_Id'];
    }
    if (isset($_POST['years_Id'])) {
        $years_Id = $_POST['years_Id'];
    }
    if (isset($_POST['typeOfAgri_id'])) {
        $typeOfAgri_id = $_POST['typeOfAgri_id'];
    }
    if (isset($_POST['month_id'])) {
        $month_id = $_POST['month_id'];
    }
    $agriList = '';
    if (isset($_POST['agriList'])) {
        $agriList = $_POST['agriList'];
    }
    if (isset($_POST['speciesId'])) {
        $speciesId = $_POST['speciesId'];
    }
    // if($years_Id == '0'){
    //     if($idRiverBasin != '0' && $month_id == '0' && $area_Id == '0' && $typeOfAgri_id == '0' && $agriList == ''){
            
    //         $sql = "SELECT idArea FROM Area WHERE target_area_type_id in (3,10 ,5) and RiverBasin_idRiverBasin =".$idRiverBasin;
    //         // $sql = "SELECT idArea  FROM MainTarget WHERE idRiverBasin ='".$idRiverBasin."'";
    //         $db = new Database();
    //         $conn =  $db->getConnection();
    //         $river = sqlsrv_prepare($conn, $sql );
    //         if( !$river ) {
    //             die( print_r( sqlsrv_errors(), true));
    //         }
    //         if( sqlsrv_execute( $river ) === false ) {
    //             die( print_r( sqlsrv_errors(), true));
    //         }
    //         $areaList = [];
    //         while( $row = sqlsrv_fetch_array( $river, SQLSRV_FETCH_ASSOC) ) {
    //             array_push($areaList, $row['idArea']);
    //         }
    //         // var_dump($areaList);
    //         $sql2 = "
    //             SELECT t1.YearID, t1.nameYear +' ['+ FORMAT(t1.dateStart, 'dd/MMMM/yyyy','th') +' - '+FORMAT(t1.dateStop, 'dd/MMMM/yyyy','th') +']' as displayName, t1.Volumn, t1.Value, t1.TotalValue, t2.Price, t2.Weight, t2.Total 
    //             FROM ( SELECT pm.YearID, a.nameYear, a.dateStart, a.dateStop, SUM(ISNULL( pm.Volumn,0)) as Volumn, 
    //                 SUM(ISNULL( pm.Value,0)) as Value, SUM(ISNULL( pm.TotalValue,0)) as TotalValue ";
    //         $sql2.= "FROM PersonMarket_TD as pm 
    //                 INNER JOIN YearTB as a ON pm.YearID = a.idYearTB
    //                 INNER JOIN MainTarget as b ON pm.Area_idArea = b.idArea 
    //                 WHERE a.idYearTB IS NOT NULL ";
    //         if($idRiverBasin != '0'){
    //             $imploded_arr = implode(',', $areaList);
    //             $sql2.= " and pm.Area_idArea in (".$imploded_arr.") " ;
    //         }
    //         $sql2.= "GROUP BY YearID, nameYear, dateStart, dateStop) t1, 
    //                 ( SELECT tp.YearTarget_YearID , SUM(ISNULL( tp.Price,0)) as Price, SUM(ISNULL(tp.Weight,0)) as Weight ,SUM(ISNULL(tp.Total,0)) as Total ";
    //         $sql2.= "FROM TargetPlan_TD as tp
    //                 INNER JOIN MainTarget as b ON tp.Area_idArea = b.idArea 
    //                 WHERE tp.YearTarget_YearID IS NOT NULL ";
            
    //         if($idRiverBasin != '0'){
    //             $imploded_arr = implode(',', $areaList);
    //             $sql2.= " and tp.Area_idArea in (".$imploded_arr.") " ;
    //         }
    //         $sql2.= "GROUP BY YearTarget_YearID) t2
    //             WHERE t1.YearID = t2.YearTarget_YearID
    //         ";
    //     }else{
    //         $sql2 = "
    //             SELECT t1.YearID, t1.nameYear +' ['+ FORMAT(t1.dateStart, 'dd/MMMM/yyyy','th') +' - '+FORMAT(t1.dateStop, 'dd/MMMM/yyyy','th') +']' as displayName, t1.Volumn, t1.Value, t1.TotalValue, t2.Price, t2.Weight, t2.Total 
    //             FROM ( SELECT pm.YearID, a.nameYear, a.dateStart, a.dateStop, SUM(ISNULL( pm.Volumn,0)) as Volumn, 
    //                 SUM(ISNULL( pm.Value,0)) as Value, SUM(ISNULL( pm.TotalValue,0)) as TotalValue ";
    //         $sql2.= "FROM PersonMarket_TD as pm 
    //                 INNER JOIN YearTB as a ON pm.YearID = a.idYearTB
    //                 INNER JOIN MainTarget as b ON pm.Area_idArea = b.idArea 
    //                 WHERE a.idYearTB IS NOT NULL ";
    //         if($month_id != '0'){
    //             $sql2.= " and pm.MonthNo = '".$month_id."' " ;
    //         }
    //         if($area_Id != '0'){
    //             $sql2.= " and pm.Area_idArea = '".$area_Id."' " ;
    //         }
    //         if($idRiverBasin != '0'){
    //             if($area_Id != '0'){
    //                 $sql2.= " and b.idRiverBasin = '".$idRiverBasin."' " ;
    //             }else{
    //                 $sql2.= "and pm.Area_idArea in (SELECT idArea FROM MainTarget WHERE idRiverBasin ='".$idRiverBasin."')";
    //             }
    //         }
    //         if($typeOfAgri_id != '0'){
    //             $sql2.= " and pm.TypeOfArgi_idTypeOfArgi = '".$typeOfAgri_id."' " ;
    //         }
    //         if($agriList != ''){
    //                 $imploded_arr = implode(',', $agriList);
    //                 $sql2 .=" and pm.Agri_idAgri in (".$imploded_arr.")";
    //             }
    //         $sql2.= "GROUP BY YearID, nameYear, dateStart, dateStop) t1, 
    //                 ( SELECT tp.YearTarget_YearID , SUM(ISNULL( tp.Price,0)) as Price, SUM(ISNULL(tp.Weight,0)) as Weight ,SUM(ISNULL(tp.Total,0)) as Total ";
    //         $sql2.= "FROM TargetPlan_TD as tp
    //                 INNER JOIN MainTarget as b ON tp.Area_idArea = b.idArea 
    //                 WHERE tp.YearTarget_YearID IS NOT NULL ";
    //         if($month_id != '0'){
    //             $sql2.= " and tp.month_id ='".$month_id."' " ;
    //         }
    //         if($area_Id != '0'){
    //             $sql2.= " and tp.Area_idArea = '".$area_Id."' " ;
    //         }
    //         if($idRiverBasin != '0'){
    //             $sql2.= " and b.idRiverBasin = '".$idRiverBasin."' " ;
    //         }
    //         if($typeOfAgri_id != '0'){
    //             $sql2.= " and tp.TypeOfArgi_idTypeOfArgi = '".$typeOfAgri_id."' " ;
    //         }
    //         if($agriList != ''){
    //             $imploded_arr = implode(',', $agriList);
    //             $sql2 .=" and tp.Agri_idAgri in (".$imploded_arr.")";
    //         }
    //         $sql2.= "GROUP BY YearTarget_YearID) t2
    //             WHERE t1.YearID = t2.YearTarget_YearID
    //         ";
    //     // echo $sql2;
    //     }
    // }else{
    //     if($typeOfAgri_id == '0'){
    //         $sql2 = "
    //         SELECT t1.nameTypeOfArgi as displayName, ISNULL(t1.Volumn,0), ISNULL(t1.Value,0), ISNULL(t1.TotalValue,0), ISNULL(t2.Price,0), ISNULL(t2.Weight,0), ISNULL(t2.Total,0) 
    //         FROM ( SELECT SUM(ISNULL( pm.Volumn,0)) as Volumn, pm.TypeOfArgi_idTypeOfArgi, ta.nameTypeOfArgi, 
    //             SUM(ISNULL( pm.Value,0)) as Value, SUM(ISNULL( pm.TotalValue,0)) as TotalValue ";
    //         $sql2.= "FROM PersonMarket_TD as pm 
    //                 INNER JOIN YearTB as a ON pm.YearID = a.idYearTB
    //                 INNER JOIN TypeOfArgi_TD as ta ON pm.TypeOfArgi_idTypeOfArgi = ta.idTypeOfArgi 
    //                 INNER JOIN MainTarget as b ON pm.Area_idArea = b.idArea 
    //                 WHERE a.idYearTB IS NOT NULL and pm.YearID='".$years_Id."'";
    //         if($month_id != '0'){
    //             $sql2.= " and pm.MonthNo = '".$month_id."' " ;
    //         }
    //         if($area_Id != '0'){
    //             $sql2.= " and pm.Area_idArea = '".$area_Id."' " ;
    //         }
    //         if($idRiverBasin != '0'){
    //             $sql2.= " and b.idRiverBasin = '".$idRiverBasin."' " ;
    //         }
    //         if($typeOfAgri_id != '0'){
    //             $sql2.= " and pm.TypeOfArgi_idTypeOfArgi = '".$typeOfAgri_id."' " ;
    //         }
    //         if($agriList != ''){
    //                 $imploded_arr = implode(',', $agriList);
    //                 $sql2 .=" and pm.Agri_idAgri in (".$imploded_arr.")";
    //             }
    //         $sql2.= "GROUP BY TypeOfArgi_idTypeOfArgi, nameTypeOfArgi) t1, 
    //                 ( SELECT SUM(ISNULL( tp.Price,0)) as Price, SUM(ISNULL(tp.Weight,0)) as Weight ,SUM(ISNULL(tp.Total,0)) as Total, tp.TypeOfArgi_idTypeOfArgi ";
    //         $sql2.= "FROM TargetPlan_TD as tp
    //                 INNER JOIN MainTarget as b ON tp.Area_idArea = b.idArea 
    //                 WHERE tp.YearTarget_YearID IS NOT NULL and tp.YearTarget_YearID='".$years_Id."'";
    //         if($month_id != '0'){
    //             $sql2.= " and tp.month_id ='".$month_id."' " ;
    //         }
    //         if($area_Id != '0'){
    //             $sql2.= " and tp.Area_idArea = '".$area_Id."' " ;
    //         }
    //         if($idRiverBasin != '0'){
    //             $sql2.= " and b.idRiverBasin = '".$idRiverBasin."' " ;
    //         }
    //         if($typeOfAgri_id != '0'){
    //             $sql2.= " and tp.TypeOfArgi_idTypeOfArgi = '".$typeOfAgri_id."' " ;
    //         }
    //         if($agriList != ''){
    //             $imploded_arr = implode(',', $agriList);
    //             $sql2 .=" and tp.Agri_idAgri in (".$imploded_arr.")";
    //         }
    //         $sql2.= "GROUP BY TypeOfArgi_idTypeOfArgi) t2
    //             WHERE t1.TypeOfArgi_idTypeOfArgi = t2.TypeOfArgi_idTypeOfArgi
    //         ";
    //     }else{
    //         if($agriList != '' && count($agriList) == '1'){
    //             $sql2 = "
    //             SELECT ISNULL(NULLIF(t1.nameArgi+'(พันธุ์: '+ t1.species_name+')', ''), t1.nameArgi) as displayName, t1.Volumn, t1.Value, t1.TotalValue, t2.Price, t2.Weight, t2.Total 
    //             FROM ( SELECT SUM(ISNULL( pm.Volumn,0)) as Volumn, pm.Agri_idAgri, ag.nameArgi, sa.species_Id, sa.species_name, 
    //                 SUM(ISNULL( pm.Value,0)) as Value, SUM(ISNULL( pm.TotalValue,0)) as TotalValue ";
    //             $sql2.= "FROM PersonMarket_TD as pm 
    //                     INNER JOIN YearTB as a ON pm.YearID = a.idYearTB
    //                     INNER JOIN Agri_TD as ag ON pm.Agri_idAgri = ag.idAgri 
    //                     LEFT JOIN SpeciesArgi_TD sa ON ag.idAgri = sa.Agri_idAgri and pm.species_Id = sa.species_Id
    //                     INNER JOIN MainTarget as b ON pm.Area_idArea = b.idArea 
    //                     WHERE a.idYearTB IS NOT NULL and pm.YearID='".$years_Id."'";
    //             if($month_id != '0'){
    //                 $sql2.= " and pm.MonthNo = '".$month_id."' " ;
    //             }
    //             if($area_Id != '0'){
    //                 $sql2.= " and pm.Area_idArea = '".$area_Id."' " ;
    //             }
    //             if($idRiverBasin != '0'){
    //                 $sql2.= " and b.idRiverBasin = '".$idRiverBasin."' " ;
    //             }
    //             if($typeOfAgri_id != '0'){
    //                 $sql2.= " and pm.TypeOfArgi_idTypeOfArgi = '".$typeOfAgri_id."' " ;
    //             }
    //             if($agriList != ''){
    //                 $imploded_arr = implode(',', $agriList);
    //                 $sql2 .=" and pm.Agri_idAgri in (".$imploded_arr.")";
    //             }
    //             if($speciesId != 'ALL'){
    //                 $sql2 .=" and pm.species_Id = '".$speciesId."'";
    //             }
    //             $sql2.= "GROUP BY pm.Agri_idAgri, nameArgi, species_name, sa.species_Id ) t1, 
    //                     ( SELECT SUM(ISNULL( tp.Price,0)) as Price, SUM(ISNULL(tp.Weight,0)) as Weight ,SUM(ISNULL(tp.Total,0)) as Total, tp.Agri_idAgri ";
    //             $sql2.= "FROM TargetPlan_TD as tp
    //                     INNER JOIN MainTarget as b ON tp.Area_idArea = b.idArea 
    //                     WHERE tp.YearTarget_YearID IS NOT NULL and tp.YearTarget_YearID='".$years_Id."'";
    //             if($month_id != '0'){
    //                 $sql2.= " and tp.month_id ='".$month_id."' " ;
    //             }
    //             if($area_Id != '0'){
    //                 $sql2.= " and tp.Area_idArea = '".$area_Id."' " ;
    //             }
    //             if($idRiverBasin != '0'){
    //                 $sql2.= " and b.idRiverBasin = '".$idRiverBasin."' " ;
    //             }
    //             if($typeOfAgri_id != '0'){
    //                 $sql2.= " and tp.TypeOfArgi_idTypeOfArgi = '".$typeOfAgri_id."' " ;
    //             }
    //             if($agriList != ''){
    //                 $imploded_arr = implode(',', $agriList);
    //                 $sql2 .=" and tp.Agri_idAgri in (".$imploded_arr.")";
    //             }
    //             $sql2.= "GROUP BY tp.Agri_idAgri) t2
    //                 WHERE t1.Agri_idAgri = t2.Agri_idAgri
    //             ";
    //             // echo $sql2;
    //         }else{
    //             $sql2 = "
    //             SELECT ISNULL(NULLIF(t1.nameArgi+'(พันธุ์ :'+ t1.speciesArgi+')', ''), t1.nameArgi) as displayName, ISNULL(t1.Volumn,0) as Volumn, ISNULL(t1.Value,0) as Value, ISNULL(t1.TotalValue,0) as TotalValue, ISNULL(t2.Price,0) as Price, ISNULL(t2.Weight,0) as Weight, ISNULL(t2.Total,0) as Total 
    //             FROM ( SELECT SUM(ISNULL( pm.Volumn,0)) as Volumn, pm.Agri_idAgri, ag.nameArgi, ag.speciesArgi,
    //                 SUM(ISNULL( pm.Value,0)) as Value, SUM(ISNULL( pm.TotalValue,0)) as TotalValue ";
    //             $sql2.= "FROM PersonMarket_TD as pm 
    //                     INNER JOIN YearTB as a ON pm.YearID = a.idYearTB
    //                     INNER JOIN Agri_TD as ag ON pm.Agri_idAgri = ag.idAgri 
    //                     LEFT JOIN SpeciesArgi_TD sa ON ag.idAgri = sa.Agri_idAgri and pm.species_Id = sa.species_Id
    //                     INNER JOIN MainTarget as b ON pm.Area_idArea = b.idArea 
    //                     WHERE a.idYearTB IS NOT NULL and pm.YearID='".$years_Id."'";
    //             if($month_id != '0'){
    //                 $sql2.= " and pm.MonthNo = '".$month_id."' " ;
    //             }
    //             if($area_Id != '0'){
    //                 $sql2.= " and pm.Area_idArea = '".$area_Id."' " ;
    //             }
    //             if($idRiverBasin != '0'){
    //                 $sql2.= " and b.idRiverBasin = '".$idRiverBasin."' " ;
    //             }
    //             if($typeOfAgri_id != '0'){
    //                 $sql2.= " and pm.TypeOfArgi_idTypeOfArgi = '".$typeOfAgri_id."' " ;
    //             }
    //             if($agriList != ''){
    //                     $imploded_arr = implode(',', $agriList);
    //                     $sql2 .=" and pm.Agri_idAgri in (".$imploded_arr.")";
    //                 }
    //             $sql2.= "GROUP BY pm.Agri_idAgri, nameArgi, speciesArgi) t1, 
    //                     ( SELECT SUM(ISNULL( tp.Price,0)) as Price, SUM(ISNULL(tp.Weight,0)) as Weight ,SUM(ISNULL(tp.Total,0)) as Total, tp.Agri_idAgri ";
    //             $sql2.= "FROM TargetPlan_TD as tp
    //                     INNER JOIN MainTarget as b ON tp.Area_idArea = b.idArea 
    //                     WHERE tp.YearTarget_YearID IS NOT NULL and tp.YearTarget_YearID='".$years_Id."'";
    //             if($month_id != '0'){
    //                 $sql2.= " and tp.month_id ='".$month_id."' " ;
    //             }
    //             if($area_Id != '0'){
    //                 $sql2.= " and tp.Area_idArea = '".$area_Id."' " ;
    //             }
    //             if($idRiverBasin != '0'){
    //                 $sql2.= " and b.idRiverBasin = '".$idRiverBasin."' " ;
    //             }
    //             if($typeOfAgri_id != '0'){
    //                 $sql2.= " and tp.TypeOfArgi_idTypeOfArgi = '".$typeOfAgri_id."' " ;
    //             }
    //             if($agriList != ''){
    //                 $imploded_arr = implode(',', $agriList);
    //                 $sql2 .=" and tp.Agri_idAgri in (".$imploded_arr.")";
    //             }
    //             $sql2.= "GROUP BY Agri_idAgri) t2
    //                 WHERE ((t1.Agri_idAgri = t2.Agri_idAgri) OR (ISNULL(t1.Agri_idAgri, t2.Agri_idAgri) IS NULL))
    //             ";
    //             echo $sql2;
    //         }
    //     }
    // }
    if($years_Id == '0'){
        if($idRiverBasin != '0' && $month_id == '0' && $area_Id == '0' && $typeOfAgri_id == '0' && $agriList == ''){
            
            $sql = "SELECT idArea FROM Area WHERE target_area_type_id in (3,10 ,5) and RiverBasin_idRiverBasin =".$idRiverBasin;
            // $sql = "SELECT idArea  FROM MainTarget WHERE idRiverBasin ='".$idRiverBasin."'";
            $db = new Database();
            $conn =  $db->getConnection();
            $river = sqlsrv_prepare($conn, $sql );
            if( !$river ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $river ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
            $areaList = [];
            while( $row = sqlsrv_fetch_array( $river, SQLSRV_FETCH_ASSOC) ) {
                array_push($areaList, $row['idArea']);
            }
            // var_dump($areaList);
            $sql2 = "
                SELECT t1.YearID, t1.nameYear +' ['+ FORMAT(t1.dateStart, 'dd/MMMM/yyyy','th') +' - '+FORMAT(t1.dateStop, 'dd/MMMM/yyyy','th') +']' as displayName, ISNULL(t1.Volumn,0) as Volumn, ISNULL(t1.Value,0) as Value, ISNULL(t1.TotalValue,0) as TotalValue, ISNULL(t2.Price,0) as Price, ISNULL(t2.Weight,0) as Weight, ISNULL(t2.Total,0) as Total
                FROM ( SELECT pm.YearID, a.nameYear, a.dateStart, a.dateStop, SUM(ISNULL( pm.Volumn,0)) as Volumn, 
                    SUM(ISNULL( pm.Value,0)) as Value, SUM(ISNULL( pm.TotalValue,0)) as TotalValue ";
            $sql2.= "FROM PersonMarket_TD as pm 
                    INNER JOIN YearTB as a ON pm.YearID = a.idYearTB
                    INNER JOIN MainTarget as b ON pm.Area_idArea = b.idArea 
                    WHERE a.idYearTB IS NOT NULL ";
            if($idRiverBasin != '0'){
                $imploded_arr = implode(',', $areaList);
                $sql2.= " and pm.Area_idArea in (".$imploded_arr.") " ;
            }
            $sql2.= "GROUP BY YearID, nameYear, dateStart, dateStop) t1 
                    LEFT JOIN ( SELECT tp.YearTarget_YearID , SUM(ISNULL( tp.Price,0)) as Price, SUM(ISNULL(tp.Weight,0)) as Weight ,SUM(ISNULL(tp.Total,0)) as Total ";
            $sql2.= "FROM TargetPlan_TD as tp
                    INNER JOIN MainTarget as b ON tp.Area_idArea = b.idArea 
                    WHERE tp.YearTarget_YearID IS NOT NULL ";
            
            if($idRiverBasin != '0'){
                $imploded_arr = implode(',', $areaList);
                $sql2.= " and tp.Area_idArea in (".$imploded_arr.") " ;
            }
            $sql2.= "GROUP BY YearTarget_YearID) t2 ON t1.YearID = t2.YearTarget_YearID";
            // $sql2.= "GROUP BY YearTarget_YearID) t2
            //     WHERE t1.YearID = t2.YearTarget_YearID
            // ";
        }else{
            $sql2 = "
                SELECT t1.YearID, t1.nameYear +' ['+ FORMAT(t1.dateStart, 'dd/MMMM/yyyy','th') +' - '+FORMAT(t1.dateStop, 'dd/MMMM/yyyy','th') +']' as displayName, ISNULL(t1.Volumn,0) as Volumn, ISNULL(t1.Value,0) as Value, ISNULL(t1.TotalValue,0) as TotalValue, ISNULL(t2.Price,0) as Price, ISNULL(t2.Weight,0) as Weight, ISNULL(t2.Total,0) as Total 
                FROM ( SELECT pm.YearID, a.nameYear, a.dateStart, a.dateStop, SUM(ISNULL( pm.Volumn,0)) as Volumn, 
                    SUM(ISNULL( pm.Value,0)) as Value, SUM(ISNULL( pm.TotalValue,0)) as TotalValue ";
            $sql2.= "FROM PersonMarket_TD as pm 
                    INNER JOIN YearTB as a ON pm.YearID = a.idYearTB
                    INNER JOIN MainTarget as b ON pm.Area_idArea = b.idArea 
                    WHERE a.idYearTB IS NOT NULL ";
            if($month_id != '0'){
                $sql2.= " and pm.MonthNo = '".$month_id."' " ;
            }
            if($area_Id != '0'){
                $sql2.= " and pm.Area_idArea = '".$area_Id."' " ;
            }
            if($idRiverBasin != '0'){
                if($area_Id != '0'){
                    $sql2.= " and b.idRiverBasin = '".$idRiverBasin."' " ;
                }else{
                    $sql2.= "and pm.Area_idArea in (SELECT idArea FROM MainTarget WHERE idRiverBasin ='".$idRiverBasin."')";
                }
            }
            if($typeOfAgri_id != '0'){
                $sql2.= " and pm.TypeOfArgi_idTypeOfArgi = '".$typeOfAgri_id."' " ;
            }
            if($agriList != ''){
                    $imploded_arr = implode(',', $agriList);
                    $sql2 .=" and pm.Agri_idAgri in (".$imploded_arr.")";
                }
            $sql2.= "GROUP BY YearID, nameYear, dateStart, dateStop) t1 
                    LEFT JOIN ( SELECT tp.YearTarget_YearID , SUM(ISNULL( tp.Price,0)) as Price, SUM(ISNULL(tp.Weight,0)) as Weight ,SUM(ISNULL(tp.Total,0)) as Total ";
            $sql2.= "FROM TargetPlan_TD as tp
                    INNER JOIN MainTarget as b ON tp.Area_idArea = b.idArea 
                    WHERE tp.YearTarget_YearID IS NOT NULL ";
            if($month_id != '0'){
                $sql2.= " and tp.month_id ='".$month_id."' " ;
            }
            if($area_Id != '0'){
                $sql2.= " and tp.Area_idArea = '".$area_Id."' " ;
            }
            if($idRiverBasin != '0'){
                $sql2.= " and b.idRiverBasin = '".$idRiverBasin."' " ;
            }
            if($typeOfAgri_id != '0'){
                $sql2.= " and tp.TypeOfArgi_idTypeOfArgi = '".$typeOfAgri_id."' " ;
            }
            if($agriList != ''){
                $imploded_arr = implode(',', $agriList);
                $sql2 .=" and tp.Agri_idAgri in (".$imploded_arr.")";
            }
            $sql2.= "GROUP BY YearTarget_YearID) t2 ON t1.YearID = t2.YearTarget_YearID";
            // $sql2.= "GROUP BY YearTarget_YearID) t2
            //     WHERE t1.YearID = t2.YearTarget_YearID
            // ";
        // echo $sql2;
        }
    }else{
        if($typeOfAgri_id == '0'){
            $sql2 = "
            SELECT t1.nameTypeOfArgi as displayName, ISNULL(t1.Value,0), ISNULL(t1.Volumn,0) as Volumn, ISNULL(t1.Value,0) as Value, ISNULL(t1.TotalValue,0) as TotalValue, ISNULL(t2.Price,0) as Price, ISNULL(t2.Weight,0) as Weight, ISNULL(t2.Total,0) as Total 
            FROM ( SELECT SUM(ISNULL( pm.Volumn,0)) as Volumn, pm.TypeOfArgi_idTypeOfArgi, ta.nameTypeOfArgi, 
                SUM(ISNULL( pm.Value,0)) as Value, SUM(ISNULL( pm.TotalValue,0)) as TotalValue ";
            $sql2.= "FROM PersonMarket_TD as pm 
                    INNER JOIN YearTB as a ON pm.YearID = a.idYearTB
                    INNER JOIN TypeOfArgi_TD as ta ON pm.TypeOfArgi_idTypeOfArgi = ta.idTypeOfArgi 
                    INNER JOIN MainTarget as b ON pm.Area_idArea = b.idArea 
                    WHERE a.idYearTB IS NOT NULL and pm.YearID='".$years_Id."'";
            if($month_id != '0'){
                $sql2.= " and pm.MonthNo = '".$month_id."' " ;
            }
            if($area_Id != '0'){
                $sql2.= " and pm.Area_idArea = '".$area_Id."' " ;
            }
            if($idRiverBasin != '0'){
                $sql2.= " and b.idRiverBasin = '".$idRiverBasin."' " ;
            }
            if($typeOfAgri_id != '0'){
                $sql2.= " and pm.TypeOfArgi_idTypeOfArgi = '".$typeOfAgri_id."' " ;
            }
            if($agriList != ''){
                    $imploded_arr = implode(',', $agriList);
                    $sql2 .=" and pm.Agri_idAgri in (".$imploded_arr.")";
                }
            $sql2.= "GROUP BY TypeOfArgi_idTypeOfArgi, nameTypeOfArgi) t1 
                    LEFT JOIN (SELECT SUM(ISNULL( tp.Price,0)) as Price, SUM(ISNULL(tp.Weight,0)) as Weight ,SUM(ISNULL(tp.Total,0)) as Total, tp.TypeOfArgi_idTypeOfArgi ";
            $sql2.= "FROM TargetPlan_TD as tp
                    INNER JOIN MainTarget as b ON tp.Area_idArea = b.idArea 
                    WHERE tp.YearTarget_YearID IS NOT NULL and tp.YearTarget_YearID='".$years_Id."'";
            if($month_id != '0'){
                $sql2.= " and tp.month_id ='".$month_id."' " ;
            }
            if($area_Id != '0'){
                $sql2.= " and tp.Area_idArea = '".$area_Id."' " ;
            }
            if($idRiverBasin != '0'){
                $sql2.= " and b.idRiverBasin = '".$idRiverBasin."' " ;
            }
            if($typeOfAgri_id != '0'){
                $sql2.= " and tp.TypeOfArgi_idTypeOfArgi = '".$typeOfAgri_id."' " ;
            }
            if($agriList != ''){
                $imploded_arr = implode(',', $agriList);
                $sql2 .=" and tp.Agri_idAgri in (".$imploded_arr.")";
            }
            $sql2.= "GROUP BY TypeOfArgi_idTypeOfArgi) t2 ON t1.TypeOfArgi_idTypeOfArgi = t2.TypeOfArgi_idTypeOfArgi";
            // $sql2.= "GROUP BY TypeOfArgi_idTypeOfArgi) t2
            //     WHERE t1.TypeOfArgi_idTypeOfArgi = t2.TypeOfArgi_idTypeOfArgi
            // ";
        }else{
            if($agriList != '' && count($agriList) == '1'){
                $sql2 = "
                SELECT ISNULL(NULLIF(t1.nameArgi+'(พันธุ์: '+ t1.species_name+')', ''), t1.nameArgi) as displayName, ISNULL(t1.Volumn,0) as Volumn, ISNULL(t1.Value,0) as Value, ISNULL(t1.TotalValue,0) as TotalValue, ISNULL(t2.Price,0) as Price, ISNULL(t2.Weight,0) as Weight, ISNULL(t2.Total,0) as Total 
                FROM ( SELECT SUM(ISNULL( pm.Volumn,0)) as Volumn, pm.Agri_idAgri, ag.nameArgi, sa.species_Id, sa.species_name, 
                    SUM(ISNULL( pm.Value,0)) as Value, SUM(ISNULL( pm.TotalValue,0)) as TotalValue ";
                $sql2.= "FROM PersonMarket_TD as pm 
                        INNER JOIN YearTB as a ON pm.YearID = a.idYearTB
                        INNER JOIN Agri_TD as ag ON pm.Agri_idAgri = ag.idAgri 
                        LEFT JOIN SpeciesArgi_TD sa ON ag.idAgri = sa.Agri_idAgri and pm.species_Id = sa.species_Id
                        INNER JOIN MainTarget as b ON pm.Area_idArea = b.idArea 
                        WHERE a.idYearTB IS NOT NULL and pm.YearID='".$years_Id."'";
                if($month_id != '0'){
                    $sql2.= " and pm.MonthNo = '".$month_id."' " ;
                }
                if($area_Id != '0'){
                    $sql2.= " and pm.Area_idArea = '".$area_Id."' " ;
                }
                if($idRiverBasin != '0'){
                    $sql2.= " and b.idRiverBasin = '".$idRiverBasin."' " ;
                }
                if($typeOfAgri_id != '0'){
                    $sql2.= " and pm.TypeOfArgi_idTypeOfArgi = '".$typeOfAgri_id."' " ;
                }
                if($agriList != ''){
                    $imploded_arr = implode(',', $agriList);
                    $sql2 .=" and pm.Agri_idAgri in (".$imploded_arr.")";
                }
                if($speciesId != 'ALL'){
                    $sql2 .=" and pm.species_Id = '".$speciesId."'";
                }
                $sql2.= "GROUP BY pm.Agri_idAgri, nameArgi, species_name, sa.species_Id ) t1

                    LEFT JOIN ( SELECT SUM(ISNULL( tp.Price,0)) as Price, SUM(ISNULL(tp.Weight,0)) as Weight ,SUM(ISNULL(tp.Total,0)) as Total, tp.Agri_idAgri ";
                $sql2.= "FROM TargetPlan_TD as tp
                        INNER JOIN MainTarget as b ON tp.Area_idArea = b.idArea 
                        WHERE tp.YearTarget_YearID IS NOT NULL and tp.YearTarget_YearID='".$years_Id."'";
                if($month_id != '0'){
                    $sql2.= " and tp.month_id ='".$month_id."' " ;
                }
                if($area_Id != '0'){
                    $sql2.= " and tp.Area_idArea = '".$area_Id."' " ;
                }
                if($idRiverBasin != '0'){
                    $sql2.= " and b.idRiverBasin = '".$idRiverBasin."' " ;
                }
                if($typeOfAgri_id != '0'){
                    $sql2.= " and tp.TypeOfArgi_idTypeOfArgi = '".$typeOfAgri_id."' " ;
                }
                if($agriList != ''){
                    $imploded_arr = implode(',', $agriList);
                    $sql2 .=" and tp.Agri_idAgri in (".$imploded_arr.")";
                }
                $sql2.=" GROUP BY tp.Agri_idAgri) t2 ON t1.Agri_idAgri = t2.Agri_idAgri";
                // $sql2.= "GROUP BY tp.Agri_idAgri) t2 
                //     WHERE t1.Agri_idAgri = t2.Agri_idAgri
                // ";
                // echo $sql2;
            }else{
                $sql2 = "
                SELECT ISNULL(NULLIF(t1.nameArgi+'(พันธุ์ :'+ t1.speciesArgi+')', ''), t1.nameArgi) as displayName, ISNULL(t1.Volumn,0) as Volumn, ISNULL(t1.Value,0) as Value, ISNULL(t1.TotalValue,0) as TotalValue, ISNULL(t2.Price,0) as Price, ISNULL(t2.Weight,0) as Weight, ISNULL(t2.Total,0) as Total 
                FROM ( SELECT SUM(ISNULL( pm.Volumn,0)) as Volumn, pm.Agri_idAgri, ag.nameArgi, ag.speciesArgi,
                    SUM(ISNULL( pm.Value,0)) as Value, SUM(ISNULL( pm.TotalValue,0)) as TotalValue ";
                $sql2.= "FROM PersonMarket_TD as pm 
                        INNER JOIN YearTB as a ON pm.YearID = a.idYearTB
                        INNER JOIN Agri_TD as ag ON pm.Agri_idAgri = ag.idAgri 
                        LEFT JOIN SpeciesArgi_TD sa ON ag.idAgri = sa.Agri_idAgri and pm.species_Id = sa.species_Id
                        INNER JOIN MainTarget as b ON pm.Area_idArea = b.idArea 
                        WHERE a.idYearTB IS NOT NULL and pm.YearID='".$years_Id."'";
                if($month_id != '0'){
                    $sql2.= " and pm.MonthNo = '".$month_id."' " ;
                }
                if($area_Id != '0'){
                    $sql2.= " and pm.Area_idArea = '".$area_Id."' " ;
                }
                if($idRiverBasin != '0'){
                    $sql2.= " and b.idRiverBasin = '".$idRiverBasin."' " ;
                }
                if($typeOfAgri_id != '0'){
                    $sql2.= " and pm.TypeOfArgi_idTypeOfArgi = '".$typeOfAgri_id."' " ;
                }
                if($agriList != ''){
                        $imploded_arr = implode(',', $agriList);
                        $sql2 .=" and pm.Agri_idAgri in (".$imploded_arr.")";
                    }
                $sql2.= "GROUP BY pm.Agri_idAgri, nameArgi, speciesArgi) t1

                LEFT JOIN ( SELECT SUM(ISNULL( tp.Price,0)) as Price, SUM(ISNULL(tp.Weight,0)) as Weight ,SUM(ISNULL(tp.Total,0)) as Total, tp.Agri_idAgri ";
                $sql2.= "FROM TargetPlan_TD as tp
                        INNER JOIN MainTarget as b ON tp.Area_idArea = b.idArea 
                        WHERE tp.YearTarget_YearID IS NOT NULL and tp.YearTarget_YearID='".$years_Id."'";
                if($month_id != '0'){
                    $sql2.= " and tp.month_id ='".$month_id."' " ;
                }
                if($area_Id != '0'){
                    $sql2.= " and tp.Area_idArea = '".$area_Id."' " ;
                }
                if($idRiverBasin != '0'){
                    $sql2.= " and b.idRiverBasin = '".$idRiverBasin."' " ;
                }
                if($typeOfAgri_id != '0'){
                    $sql2.= " and tp.TypeOfArgi_idTypeOfArgi = '".$typeOfAgri_id."' " ;
                }
                if($agriList != ''){
                    $imploded_arr = implode(',', $agriList);
                    $sql2 .=" and tp.Agri_idAgri in (".$imploded_arr.")";
                }
                $sql2.= "GROUP BY Agri_idAgri) t2 ON t1.Agri_idAgri = t2.Agri_idAgri";
                // $sql2.= "GROUP BY Agri_idAgri) t2
                //     WHERE ((t1.Agri_idAgri = t2.Agri_idAgri) OR (ISNULL(t1.Agri_idAgri, t2.Agri_idAgri) IS NULL))
                // ";
                // echo $sql2;
            }
        }
    }
    $return_arr = array();
    $db = new Database();
    $conn=  $db->getConnection();
    $stmt = sqlsrv_prepare($conn, $sql2 );
    if( !$stmt ) {
        die( print_r( sqlsrv_errors(), true));
    }
    if( sqlsrv_execute( $stmt ) === false ) {
        die( print_r( sqlsrv_errors(), true));
    }
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
        //$row_array['idRiverBasin'] = $row['idRiverBasin'];
        $row_array['displayName'] = $row['displayName'];
        $row_array['Volumn'] = $row['Volumn'];
        $row_array['Value'] = $row['Value'];
        $row_array['TotalValue'] = $row['TotalValue'];

        $row_array['Price'] = $row['Price'];
        $row_array['Weight'] = $row['Weight'];
        $row_array['Total'] = $row['Total'];
        array_push($return_arr, $row_array);

    }
    sqlsrv_close($conn);
    echo json_encode($return_arr);
?>