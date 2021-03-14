<?php
session_start();

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
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">

    <title>Bangladesh Bridge Authority Gete pass System</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
		<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/flatpickr@4/dist/flatpickr.min.css'>
		<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>

    <link rel="stylesheet" href="assets/css/style.css">
	
    <style>
        [v-cloak] { display: none; }
        .table td.edit { cursor: pointer; }
        .table td.edit:hover { text-decoration: underline; }
      #header-menu {
          background: red !important;
          color: #fff;
      }
      #header-menu a {
          color: #fff;
      }

		 @media print { 
               .noprint { 
                  display: none; 
               } 
            } 
			@page 
		{
        size:  auto;   /* auto is the initial value */
        margin: 20mm;
		}

    </style>

  </head>

  <body>

    <div id="header-menu" class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow">
      <h5 class="my-0 mr-md-auto font-weight-normal">
      <?php 
      if (isset($_SESSION['alogin'])){
      echo 'User : '.  $_SESSION['alogin'];  
      echo ', Designation : '.  $_SESSION['userdesignation'];
      }  
      ?>
      </h5>
      <nav class="my-2 my-md-0 mr-md-3">
        <?php 
         if(isset($_SESSION['alogin']) && $_SESSION['role']=='Pass Issuer'){
        echo '<a class="btn btn-outline-primary" href="gatepass.php">Gatepass</a>';
         }elseif(isset($_SESSION['alogin']) && $_SESSION['role']=='Pass Issuer'){
          echo '<a class="btn btn-outline-primary" href="reception.php">Check Pass</a>';
         }
        ?>
        <?php 
        if(!isset($_SESSION)){	
        echo '<a class="btn btn-outline-primary" href="login/registr.php">Register</a>';
        } 
        ?> 
        
        <?php 
        if(isset($_SESSION['alogin']) &&  strlen($_SESSION['alogin'])>0){	
         
        echo '<a class="btn btn-outline-primary" href="login/profile.php">Profile</a>';
        }
        ?>
      </nav>
        <?php 
        if(isset($_SESSION['alogin']) && strlen($_SESSION['alogin'])>0){	
            echo '<a class="btn btn-outline-primary" href="login/logout.php">Log Out</a>';
            }else{
              echo '<a class="btn btn-outline-primary" href="login">Login</a>';  
          }
      ?>
    </div>