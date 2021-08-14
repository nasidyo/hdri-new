<?php session_start() ?>
<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<header>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>ระบบการบริหารจัดการข้อมูลเกษตรกร</title>
    <meta name="description" content="ระบบการบริหารจัดการข้อมูลเกษตรกร">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="apple-icon.png">
    <link rel="shortcut icon" href="favicon.ico">

    <link rel="stylesheet" href="../vendors/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../vendors/themify-icons/css/themify-icons.css">
    <link rel="stylesheet" href="../vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="../vendors/selectFX/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="../vendors/jqvmap/dist/jqvmap.min.css">


    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/hrdi.css">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
</header>

<body>
	<div class="content mt-3">
    <div class="col-lg-3"></div>
    <div class="col-lg-6" style="margin-top: 10%;">
  		<div class="card">
              <div class="card-header">
                  <strong class="login-title">Login</strong>
              </div>
              <div class="card-body">
                <!-- Credit Card -->
                <div id="pay-invoice">
                    <div class="card-body">
                        <div class="card-title">

                          <center><img class="logo-lage" src="../img/hrdi-logo-full.png" alt="Logo"></center>&nbsp;
                        	<h3 class="text-center">HRDI Login</h3>

                        </div>
                        <hr>
                        <form action="./modal/login.php" method="post" novalidate="novalidate">
                            <?php 
                                if(isset($_SESSION['msg'])) { ?>
                                    <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                        <?php echo $_SESSION['msg']; ?>
                                    </div>
                                    
                                <?php
                                    session_destroy();
                                }
                            ?>
                            
                            <div class="row form-group">
                                <label for="hf-username" class="control-label mb-1">User name</label>
                                <input id="emailusername" name="emailusername" placeholder="Enter Username..." class="form-control" type="text">
                            </div>
                            <div class="row form-group has-success">
                                <label for="hf-password" class="control-label mb-1">Password</label>
                                <input id="password" name="password" placeholder="Enter Password..." class="form-control" type="password">
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label for="hf-AD" class="control-label mb-1">Active Directery</label>
                                </div>
                                <div class="col col-md-2">
                                    <div class="checkbox">
                                        <input type="checkbox" id="usr-Ad" name="usr-Ad" value="AD" class="form-check-input" checked>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group">
                                <!-- <input class="btn btn-info btn-lg btn-block" type="submit" name="login" value="Login" /> -->
                                <button  id="loginButton" class="btn btn-info btn-lg btn-block" type="submit">เข้าสู่ระบบ </button>
                            </div>
                        </form>
                    </div>
                </div>

              </div>
          </div>
    </div>
	</div>
</body>
