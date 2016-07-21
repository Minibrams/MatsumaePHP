<?php session_start(); ?>

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<title>Matsumae Cup 2017</title>

<meta charset="utf-8">

<meta name="viewport" content="width=device-width, initial-scale=1">



<link href="css/bootstrap.min.css" rel="stylesheet">

<link href="css/bootstrap-theme.min.css" rel="stylesheet">

<link href="css/NyeStyles.css" rel="stylesheet">





<script type="text/javascript" src="script/jquery-1.9.1.min.js"></script>

<script type="text/javascript" src="script/bootstrap.js"></script>

</head>

<body>

<?php include("menu.php"); ?>

 

    <form method="post" action="NewUser.php?tournament=Matsumae+Cup+2017" id="ctl00">





    <section class="container">

                <div class="text-right">

        <div class="form-inline">

            </div>

            </div>

      <section class="jumbotron" style="background-color: #363636;">

         <div class="text-center">

          <h2></h2>

         <h2>&nbsp;</h2>

         </div> 

          <h2 class="text-center"><b><span id="CPH1_LabelTournamentName">Matsumae Cup 2017</span></b></h2>

          <h4 class="text-center">Haven't yet created a user on the site?</h4>

          <h4 class="text-center">Create a user using the form below. <br>After this has been completed, you can register yourself and others as participants and contestants for the Matsumae Cup.</h4>

          <p class="text-center" style="font-size: 14px"><i>If you are already registered as a user, go to the <a href="login.php">login page</a></i>.</p>

          <div class="text-center">

<div class="text-center">

	<div class="login-form-1">

            <div class="login-form-main-message"></div>

            <div class="main-login-form">

                <div class="login-group">

                    <center>

                    <div class="form-group">

                        <input name="Firstname" autocomplete="on" id="CPH1_TextBoxFirstname" type="text" class="form-control" style="height:30px;width:200px;" placeholder="First Name">

                    </div>

                        <div class="form-group">

                        <input name="Lastname" autocomplete="on" id="CPH1_TextBoxLastname" type="text" class="form-control" style="height:30px;width:200px;" placeholder="Last Name">

                    </div>

                    <div class="form-group">

                        <input name="Email" type="email" autocomplete="on" id="CPH1_TextBoxEmail" class="form-control" style="height:30px;width:200px;" placeholder="E-mail">

                    </div>

                    <div class="form-group">

                        <input name="PassWord1" type="password" autocomplete="on" id="CPH1_TextBoxPassWord1" class="form-control" style="height:30px;width:200px;" placeholder="Type Password">

                    </div>

                    <div class="form-group">

                        <input name="PassWord2" type="password" autocomplete="on" id="CPH1_TextBoxPassWord2" class="form-control" style="height:30px;width:200px;" placeholder="Retype Password">

                    </div>

                    <div class="form-group">

                    

                        <select name="Country" onchange="javascript:document.getElementById('CPH1_TextBoxCountryCode').value=this.value;" id="CPH1_DropDownListCountry" class="form-control"  data-toggle="dropdown" style="height:30px;width:200px;">

                          <option selected="selected" value="">Country</option>



                      <?php



                      /* Load Countries and Telephone prefixes from database and make sure the selected value gets into the text field with a javascript action on the 

                      select onChange event. Using straight JavaScript this time ... jQuery not necessary

                      */



                        require_once('config1.php');



                        $mysqli = new mysqli($dh_name, $db_user, $db_pass, $db_name);

                        if ($mysqli->connect_errono) {

                           printf("Connect failed: %s\n", $mysqli->connect_error);

                        }



                        $sql = "SELECT * FROM Land";

                        if ($result=$mysqli->query($sql)){

                           while ($row = $result->fetch_assoc()) {

                               printf('<option value="%s">%s</option>', $row['Prefix'], $row['Landenavn']);

                               printf('</tr>');  // WHY DO I HAVE THAT HERE? :-O

                           }



                        }



                        $result->close();  /* free up resources */

                        ?>

	

                        </select>

                    </div>

                    <div class="form-group">

                        <input name="ctl00$CPH1$TextBoxCountryCode" type="search" id="CPH1_TextBoxCountryCode" class="form-control" placeholder="Country Code" style="height:30px;width:200px;">

                    </div>

                    <div class="form-group">

                        <input name="ctl00$CPH1$TextBoxPhone" type="tel" id="CPH1_TextBoxPhone" class="form-control" placeholder="Phone Number" style="height:30px;width:200px;">

                    </div>

                    </center>

                </div>

            </div>

        </div>     

        <input type="submit" name="ctl00$CPH1$Button2" value="Register" id="CPH1_Button2" class="btn btn-success btn-lg" data-toggle="modal" href="#submitted">  

        <br>

        </div>

              </div>

      </section>

  </section>

  

</form>



<?php

  include("footer.html");

?>



