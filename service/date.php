<?php

Class DateService {
    function getWeeks($month, $year){
        $date = new DateTime($year.'-'.$month.'-01');
        $date->modify('last day of this month');
        $date2 = $date->format('Y-m-d');
        list($y, $m, $d) = explode('-', date('Y-m-d', strtotime($date2)));
        $w = 1;
        for ($i = 1; $i <= $d; ++$i)
            if ($i > 1 && date('w', strtotime("$y-$m-$i")) == 0)
                ++$w;
        return $w;
    }
    function getmonthOfYears($statDate, $endDate){
        $listMonth = [];
        $i = date("Ym", strtotime($statDate));
        while($i <= date("Ym", strtotime($endDate))){
            $monthValue = substr($i, 4, 2);
            $yearValue = substr($i, 0, 4)+ 543;
            $data = array('monthValue' => $monthValue, 'yearValue' => $yearValue);
            array_push($listMonth,$data);
            if(substr($i, 4, 2) == "12")
                $i = (date("Y", strtotime($i."01")) + 1)."01";
            else
                $i++;
        }
        return $listMonth;
    }
}
?>