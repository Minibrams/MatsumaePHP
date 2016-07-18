<?php
  require_once('config1.php');

  $con = mysql_connect($dh_name, $db_user, $db_pass) or die('Could not connect to database server.');
  mysql_select_db($db_name, $con) or die('Could not select database.');


  if (($_GET[FN]<>"") && ($_GET[EN]<>"") && ($_GET[EM]<>"")) {

	  $sql="INSERT INTO Person (Fornavn, Efternavn, Email) VALUES ('$_GET[FN]','$_GET[EN]','$_GET[EM]')";

	  if (!mysql_query($sql)) {
		 die('Error: ' . mysql_error());
	  }

	  echo "Data inserted";

   }

   mysql_close($con);
?>
