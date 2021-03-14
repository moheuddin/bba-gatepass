<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(isset($_SESSION['alogin']) && strlen($_SESSION['alogin'])==0)
	{	
//header('location:index.php');
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Bangladesh Bridge Authority Gatepass System">
    <meta name="author" content="">

    <title>Bangladesh Bridge Authority Gete pass System</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel='stylesheet' href='//cdn.jsdelivr.net/npm/flatpickr@4/dist/flatpickr.min.css'>
    <link rel='stylesheet' href='//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
    <link rel='stylesheet' href='//unpkg.com/vue-snotify@latest/styles/material.css'>
    <link rel="stylesheet" href="assets/css/style.css">

    <style>
    [v-cloak] {
        display: none;
    }

    .table td.edit span:hover {
        cursor: pointer;
    }

    #header-menu {
      padding: 20px 0;
  }
  #header-menu nav li {
    border: 1px solid #ddd;
    padding: 0;
    margin: 0;
}
    #header-menu a {
        color: #777;
    }

    @media print {
        .noprint {
            display: none;
        }
    }

    @page {
        size: auto;
        margin: 20mm;
    }
    div#header-middle {
    text-align: center;
}
div#header-bottom {
    border-top: 2px solid #ddd;
    margin-top: 10px;
    padding-top: 5px;
}

/* Smartphones (landscape) ----------- */
@media only screen and (max-width : 768px) {
  #header-top {
        display: none;
    }  
    
}
    </style>

</head>

<body>

    <div id="header-menu" class="">
        <div id="header-top" class="row">
            <div class="container">
                <div class="col-lg-2 col-sm-2">
                    <div id="bba-logo">
                        <img src="assets/img/bd_logo.png" alt="BD Logo" />
                    </div>
                </div>
                <div id="header-middle" class="col-lg-8 col-sm-8">
                    <p>Government of the People's Republic of Bangladesh</p>
                    <h3>Bangladesh Bridge Authority</h3>
                </div>
                <div class="col-lg-2 col-sm-2">
                <img style="display:block;float:right" src="assets/img/bbalogo.jpg" alt="BBA Logo" />
                </div>
                <div class="col-lg-12">
                    <?php 
                        if (isset($_SESSION['alogin'])){
                        echo 'User : '.  $_SESSION['alogin'];  
                        echo ', Designation : '.  $_SESSION['userdesignation'];
                        }  
                    ?>
                </div>
            </div>
        </div>
        
        <div class="row">       
                <div class="container" id="header-bottom">
                        <div class="col-lg-6">
                            <h2 style="font-size:22px;">Bangladesh Bridge Authority Gatepass System</h2>  
                        </div>

                        <div class="col-lg-6">
                                    <nav>
                                    <ul>
                                        <?php 
                                            if(isset($_SESSION['alogin']) && $_SESSION['role']=='Pass Issuer'){
                                            echo '<li><a class="btn btn-outline-primary" href="gatepass.php">Gatepass</a></li>';
                                            }elseif(isset($_SESSION['alogin']) && $_SESSION['role']=='Pass Issuer'){
                                                echo '<li></li><a class="btn btn-outline-primary" href="reception.php">Check Pass</a></li>';
                                            }
                                            ?>
                                                        <?php 
                                            if(!isset($_SESSION)){	
                                            echo '<li><a class="btn btn-outline-primary" href="registr.php">Register</a></li>';
                                            } 
                                            ?>

                                                        <?php 
                                            if(isset($_SESSION['alogin']) &&  strlen($_SESSION['alogin'])>0){	
                                            
                                            echo '<li><a class="btn btn-outline-primary" href="login/profile.php">Profile</a></li>';
                                            }
                                            ?>
                                                        <?php 
                                            if(isset($_SESSION['alogin']) && strlen($_SESSION['alogin'])>0){	
                                                echo '<li><a class="btn btn-outline-primary" href="login/logout.php">Log Out</a></li>';
                                                }else{
                                                    echo '<li><a class="btn btn-outline-primary" href="login.php">Login</a></li>';  
                                                }
                                            ?>
                                            </ul>
                                    </nav>
                        </div>
              </div>
    </div>


