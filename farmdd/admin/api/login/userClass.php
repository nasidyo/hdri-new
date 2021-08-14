<?php
    class User {
        public function check_login($username, $password) {
            session_start();
            $server = "ad01.hrdi.or.th"; //AD Server
            $user = $username."@hrdi.or.th";
            $ad = ldap_connect($server);

            if(!$ad) {
                $_SESSION['msg'] = "ไม่สามารถ Connect Active Dirctory ได้ กรุณาตรวจสอบ Username และ Password จากผู้ดูแลระบบ Sever ของสถาบันอีกครั้ง";
                return false;
            } else {
                $b = @ldap_bind($ad,$user,$password);
                if(!$b) {
                    $_SESSION['msg'] = "ไม่สามารถ Connect Active Dirctory ได้ กรุณาตรวจสอบ Username และ Password จากผู้ดูแลระบบ Sever ของสถาบันอีกครั้ง";
                    return false;
                } else {
                    //login completed.
                    // session_start();
                    $_SESSION['login'] = true;
                    $_SESSION['uid'] = $username;
                    return true;
                }
            }
        }

        public function loginLogTD($username) {
            $time = date('Y-m-d H:i:s');
            $db = new Database();
            $conn=  $db->getConnection();
            $sql = "INSERT INTO LoginLogTD (username, loginDate) VALUES (?, ?)";
            $stmt = sqlsrv_prepare($conn, $sql, array($username, $time));
            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
            sqlsrv_close($conn);
        }

        public function check_login_withoutAD($username, $password) { //Check login with out AD server
            session_start();
            $db = new Database();
            $conn = $db->getConnection();
            $sql = "( SELECT *
                    FROM
                      Staff
                    WHERE
                        staffUsername = '".$username."'
                        AND staffPassword = '".$password."'
                        AND staffStatus = 'Active' AND staffPermis  IN ('admin', 'powerUserMarket')
                    )";

            $stmt = sqlsrv_query($conn, $sql);
            if(sqlsrv_fetch( $stmt )) {
                // session_start();
                $_SESSION['login'] = true;
                $_SESSION['uid'] = $username;
                return true;
            } else {
                $_SESSION['msg'] = "ไม่สามารถเข้าระบบได้ กรุณาตรวจสอบ Username และ Password จากผู้ดูแลระบบ Sever ของสถาบันอีกครั้ง 22";
                return false;
            }
        }

        public function get_session() { //get seesion detaill
            return $_SESSION['login'];
        }

        public function user_logout() {
            $_SESSION['login'] = FALSE;
            session_destroy();
        }

        public function checkCurrentUrl() {
            $current = self::getCurrentUrl();
            if($_SESSION['currentUrl'] != $current){
                $_SESSION['currentUrl'] = $current;
                self::saveLogUrl($current);
            }
        }

        public function saveLogUrl($url){
            self::getUserLogin_Info();
            $currentDateTime = date('Y-m-d H:i:s');
            $userid = $_SESSION['idStaff'];
            $sql = "INSERT INTO logAccessURL_TD ( url, idStaff, time_log) VALUES ( ?, ?, getDate()) ";
            $db = new Database();
            $conn=  $db->getConnection();
            $stmt = sqlsrv_prepare($conn, $sql, array($url, $userid));
            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
            sqlsrv_close($conn);
        }

        public function getCurrentUrl(){
            if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
                $url = "https://";
            } else{
                $url = "http://";
            }
            // Append the host(domain name, ip) to the URL.
             $url.= $_SERVER['HTTP_HOST'];
             // Append the requested resource location to the URL.
             $url.= $_SERVER['REQUEST_URI'];
             $currentSubString = explode('?',$url);
             return $currentSubString[0];
        }

        public function getUserLogin_Info() { //get user info
            $db = new Database();
            $conn = $db->getConnection();
            $sql = "( SELECT *
                    FROM
                        Staff
                    WHERE
                        staffUsername = '".$_SESSION['uid']."'
                    )";
            $stmt = sqlsrv_query($conn, $sql);
            if(sqlsrv_fetch( $stmt )) {
                // session_start();
                $_SESSION['login'] = true;
                $_SESSION['idStaff'] = sqlsrv_get_field( $stmt, 0);
                $_SESSION['fullName'] = sqlsrv_get_field( $stmt, 2)." ".sqlsrv_get_field( $stmt, 3);
                $_SESSION['idarea'] = sqlsrv_get_field( $stmt, 8);
                $_SESSION['staffPermis'] = sqlsrv_get_field( $stmt, 9);
                $_SESSION['idRiverBasin'] = sqlsrv_get_field( $stmt, 11);
                return true;
            } else {
                $_SESSION['msg'] = "ไม่สามารถเรียกข้อมูลได้กรุณาติดต่่อผู้ดูแลระบบ Sever ของสถาบันอีกครั้ง";
                return false;
            }
        }

        public function getUserArea() { //get user area
            $db = new Database();
            $conn = $db->getConnection();
            $sql = " SELECT DISTINCT
                        sa.Area_idArea
                    FROM
                        Staff st,
                        StaffArea sa ,
                        Area a
                    WHERE
                        st.idStaff = sa.Staff_idStaff
                    AND sa.Area_idArea = a.idArea
                    AND sa.Staff_idStaff  = '".$_SESSION['idStaff']."'";
            $stmt = sqlsrv_query($conn, $sql);
            $array = array();
            while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                array_push($array,"'".$row['Area_idArea']."'");
            }
            if(count($array) >0){
                $_SESSION['AreaAll'] = implode(",", $array);
            }

             sqlsrv_close($conn);

        }

        public function getUserRB() { //get user area
            $db = new Database();
            $conn = $db->getConnection();
            $AreaAll = $_SESSION['AreaAll'];
            $sql = "    SELECT DISTINCT
                        rb.idRiverBasin
                    FROM
                        RiverBasin rb ,
                        Area a
                    WHERE
                        a.RiverBasin_idRiverBasin = rb.idRiverBasin
                    AND a.idArea IN ( ".$_SESSION['AreaAll']." ) ";
            $stmt = sqlsrv_query($conn, $sql);
            $array = array();
            while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                array_push($array,$row['idRiverBasin']);
            }
            if(count($array)>0){
                $_SESSION['RBAll'] = implode(",", $array);
            }
            sqlsrv_close($conn);

        }
        public function saveLogLogin($username, $logSeq){
            $_SESSION['currentUrl'] = '';
            $client  = @$_SERVER['HTTP_CLIENT_IP'];
            $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
            $remote  = $_SERVER['REMOTE_ADDR'];
        
            if(filter_var($client, FILTER_VALIDATE_IP))
            {
                $ip = $client;
            }
            elseif(filter_var($forward, FILTER_VALIDATE_IP))
            {
                $ip = $forward;
            }
            else
            {
                $ip = $remote;
            }
            $currentDateTime = date('Y-m-d H:i:s');
            $user_os = self::getOS();
            $user_browser = self::getBrowser();

            $sql = "INSERT INTO LogAccess_TD ( log_idlogin, username, time_login, ipAddress, platform) VALUES ( ?, ?, getDate(), ? ,?) ";
            $db = new Database();
            $conn=  $db->getConnection();
            $stmt = sqlsrv_prepare($conn, $sql, array($logSeq, $username, $ip, $user_os));
            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
            sqlsrv_close($conn);
        }

        public function getOS() { 
            $user_agent = $_SERVER['HTTP_USER_AGENT'];
            $os_platform  = "Unknown OS Platform";
            $os_array     = array(
                                '/windows nt 10/i'      =>  'Windows 10',
                                '/windows nt 6.3/i'     =>  'Windows 8.1',
                                '/windows nt 6.2/i'     =>  'Windows 8',
                                '/windows nt 6.1/i'     =>  'Windows 7',
                                '/windows nt 6.0/i'     =>  'Windows Vista',
                                '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                                '/windows nt 5.1/i'     =>  'Windows XP',
                                '/windows xp/i'         =>  'Windows XP',
                                '/windows nt 5.0/i'     =>  'Windows 2000',
                                '/windows me/i'         =>  'Windows ME',
                                '/win98/i'              =>  'Windows 98',
                                '/win95/i'              =>  'Windows 95',
                                '/win16/i'              =>  'Windows 3.11',
                                '/macintosh|mac os x/i' =>  'Mac OS X',
                                '/mac_powerpc/i'        =>  'Mac OS 9',
                                '/linux/i'              =>  'Linux',
                                '/ubuntu/i'             =>  'Ubuntu',
                                '/iphone/i'             =>  'iPhone',
                                '/ipod/i'               =>  'iPod',
                                '/ipad/i'               =>  'iPad',
                                '/android/i'            =>  'Android',
                                '/blackberry/i'         =>  'BlackBerry',
                                '/webos/i'              =>  'Mobile'
                            );
            foreach ($os_array as $regex => $value)
                if (preg_match($regex, $user_agent))
                    $os_platform = $value;

            return $os_platform;
        }

        public function getBrowser() {

            $user_agent = $_SERVER['HTTP_USER_AGENT'];

            $browser        = "Unknown Browser";

            $browser_array = array(
                                    '/msie/i'      => 'Internet Explorer',
                                    '/firefox/i'   => 'Firefox',
                                    '/safari/i'    => 'Safari',
                                    '/chrome/i'    => 'Chrome',
                                    '/edge/i'      => 'Edge',
                                    '/opera/i'     => 'Opera',
                                    '/netscape/i'  => 'Netscape',
                                    '/maxthon/i'   => 'Maxthon',
                                    '/konqueror/i' => 'Konqueror',
                                    '/mobile/i'    => 'Handheld Browser'
                            );

            foreach ($browser_array as $regex => $value)
                if (preg_match($regex, $user_agent))
                    $browser = $value;

            return $browser;
        }

    }
?>
