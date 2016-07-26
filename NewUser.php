<?php
  require_once('config1.php');

  $fornavn=$_POST['Firstname'];
  $efternavn=$_POST['Lastname'];
  $email=$_POST['Email'];
  $password =md5($_POST['PassWord1']);
  if ($_POST['ctl00$CPH1$TextBoxPhone'] <>"") $telefon=$_POST['ctl00$CPH1$TextBoxPhone']; else $telefon="Unknown"; 
  if ($_POST['Country'] <>"") $land=$_POST['Country']; else $land="1"; 

  // Get Country ID from DB lookup on prefix as passed from registration form
  $mysqli = new mysqli($dh_name, $db_user, $db_pass, $db_name);
  if ($mysqli->connect_errono) {
     printf("Connect failed: %s\n", $mysqli->connect_error);
  }
  $sql='select * from Land where Id like "'.$land.'"';
  
  if ($result=$mysqli->query($sql)) {
     $row = $result->fetch_assoc();
     $land_id=$row['Id'];
  }


  if (($fornavn<>"") && ($efternavn<>"") && ($email<>"")) {
	  $sql="INSERT INTO UserInfo (Fornavn, Efternavn, Email, PassWord, Telefon, Land) VALUES ('$fornavn', '$efternavn', '$email', '$password', '$telefon', '$land_id')";
      if (!$result=$mysqli->query($sql)) {
		 die('Error: ' . $mysqli->error);
		 $mysqli->close();
	  }

      // New member now in DB

   }

   $mysqli->close();                 // free up resources 

   // Then redirecting To Home Page below
   include('redirect_home.html');     
 
  ?>
