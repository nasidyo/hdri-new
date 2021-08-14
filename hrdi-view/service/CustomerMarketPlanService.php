<?php
require_once '../connection/database.php';
require_once '../model/CustomerMarketPlanM.php';

class CustomerMarketPlanService
{

    public function addCustomerMarketPlan($CustomerMarketPlanM)
    {
        $sql = " INSERT";
        $sql .= " INTO CustomerMaketPlan_TD ( idCustomerMaketplan, Customer_idCustomer, Area_idArea, plan_Year, Agri_idAgri, agri_weekplan_amount, unit_id, agri_spect, TypeOfStand_idTypeOfStand, Logistic_idLogistic, Refund_period, conn_status_id, update_date ) ";
        $sql .= "  VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, getDate() ) ";

        $db = new Database();
        $conn = $db->getConnection();
        $stmt = sqlsrv_prepare($conn, $sql, array(
            $CustomerMarketPlanM->getIdCustomerMaketplan(),
            $CustomerMarketPlanM->getIdCustomer(),
            $CustomerMarketPlanM->getIdArea(),
            $CustomerMarketPlanM->getPlanYear(),
            $CustomerMarketPlanM->getIdAgri(),
            $CustomerMarketPlanM->getAgriWeekplanAmount(),
            $CustomerMarketPlanM->getUnitId(),
            $CustomerMarketPlanM->getAgriSpect(),
            $CustomerMarketPlanM->getIdTypeOfStand(),
            $CustomerMarketPlanM->getIdLogistic(),
            $CustomerMarketPlanM->getRefundPeriod(),
            $CustomerMarketPlanM->getConnStatusId()
        ));
        if (! $stmt) {
            die(print_r(sqlsrv_errors(), true));
        }
        if (sqlsrv_execute($stmt) === false) {
            die(print_r(sqlsrv_errors(), true));
        }
        sqlsrv_close($conn);
    }

    public function updateCustomerMarketPlan($CustomerMarketPlanM)
    {
        $sql = " UPDATE ";
        $sql .= "   CustomerMaketPlan_TD ";
        $sql .= "   SET ";
        $sql .= "       Customer_idCustomer = ?, ";
        $sql .= "       Area_idArea = ?, ";
        $sql .= "       plan_Year = ?, ";
        $sql .= "       Agri_idAgri = ?, ";
        $sql .= "       agri_weekplan_amount = ?, ";
        $sql .= "       unit_id = ?, ";
        $sql .= "       agri_spect = ?, ";
        $sql .= "       TypeOfStand_idTypeOfStand = ?, ";
        $sql .= "       Logistic_idLogistic = ?, ";
        $sql .= "       Refund_period = ?, ";
        $sql .= "       conn_status_id = ? ";
        $sql .= "   WHERE  idCustomerMaketplan =?   ";

        $db = new Database();
        $conn = $db->getConnection();
        $params = array(
            $CustomerMarketPlanM->getIdCustomer(),
            $CustomerMarketPlanM->getIdArea(),
            $CustomerMarketPlanM->getPlanYear(),
            $CustomerMarketPlanM->getIdAgri(),
            $CustomerMarketPlanM->getAgriWeekplanAmount(),
            $CustomerMarketPlanM->getUnitId(),
            $CustomerMarketPlanM->getAgriSpect(),
            $CustomerMarketPlanM->getIdTypeOfStand(),
            $CustomerMarketPlanM->getIdLogistic(),
            $CustomerMarketPlanM->getRefundPeriod(),
            $CustomerMarketPlanM->getConnStatusId(),
            $CustomerMarketPlanM->getIdCustomerMaketplan()
        );
        $stmt = sqlsrv_prepare($conn, $sql, $params);
        if (! $stmt) {
            die(print_r(sqlsrv_errors(), true));
        }
        if (sqlsrv_execute($stmt) === false) {
            die(print_r(sqlsrv_errors(), true));
        }
        sqlsrv_close($conn);
    }

    public function loadCustomerMarketPlan($Id)
    {
        $sql = "  SELECT      ";

        $sql .= " cm.idCustomerMaketplan,  ";
        $sql .= " cm.Customer_idCustomer,  ";
        $sql .= " cm.Area_idArea,  ";
        $sql .= "  cm.plan_Year,  ";
        $sql .= "  cm.Agri_idAgri,  ";
        $sql .= "  cm.agri_weekplan_amount,  ";
        $sql .= "  cm.unit_id,  ";
        $sql .= "  cm.agri_spect,  ";
        $sql .= "  cm.TypeOfStand_idTypeOfStand,  ";
        $sql .= "  cm.Logistic_idLogistic,  ";
        $sql .= "  cm.Refund_period,  ";
        $sql .= " cm.conn_status_id,  ";
        $sql .= "  cm.update_date ,   a.RiverBasin_idRiverBasin ";
        $sql .= "  FROM  ";
        $sql .= "     CustomerMaketPlan_TD cm,  ";
        $sql .= "   Area a  ";
        $sql .= " WHERE  ";
        $sql .= "    cm.Area_idArea = a.idArea  ";
        $sql .= " and   idCustomerMaketplan = ?  ";


        $db = new Database();
        $conn = $db->getConnection();
        $stmt = sqlsrv_prepare($conn, $sql, array(
            $Id
        ));

        if (! $stmt) {
            die(print_r(sqlsrv_errors(), true));
        }
        if (sqlsrv_execute($stmt) === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        $CustomerMarketPlanM = new CustomerMarketPlanM();

        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $CustomerMarketPlanM->setIdCustomer($row["Customer_idCustomer"]);
            $CustomerMarketPlanM->setIdArea($row["Area_idArea"]);
            $CustomerMarketPlanM->setPlanYear($row["plan_Year"]);
            $CustomerMarketPlanM->setIdAgri($row["Agri_idAgri"]);
            $CustomerMarketPlanM->setAgriWeekplanAmount($row["agri_weekplan_amount"]);
            $CustomerMarketPlanM->setUnitId($row["unit_id"]);
            $CustomerMarketPlanM->setAgriSpect($row["agri_spect"]);
            $CustomerMarketPlanM->setIdTypeOfStand($row["TypeOfStand_idTypeOfStand"]);
            $CustomerMarketPlanM->setIdLogistic($row["Logistic_idLogistic"]);
            $CustomerMarketPlanM->setRefundPeriod($row["Refund_period"]);
            $CustomerMarketPlanM->setConnStatusId($row["conn_status_id"]);
            $CustomerMarketPlanM->setIdCustomerMaketplan($row["idCustomerMaketplan"]);
            $CustomerMarketPlanM->setIdRiverBasin($row["RiverBasin_idRiverBasin"]);

        }
        echo json_encode($CustomerMarketPlanM, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        sqlsrv_close($conn);
    }

    public function delCustomerMarketPlan($id)
    {
        $sql = " DELETE FROM CustomerMaketPlan_TD  WHERE idCustomerMaketplan = ? ";

        $db = new Database();
        $conn = $db->getConnection();
        $stmt = sqlsrv_prepare($conn, $sql, array(
            $id
        ));

        if (! $stmt) {
            die(print_r(sqlsrv_errors(), true));
        }
        if (sqlsrv_execute($stmt) === false) {
            die(print_r(sqlsrv_errors(), true));
        }
    }
}

?>
