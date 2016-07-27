<?php session_start(); ?>

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<title>Etilmelding Member</title>



<meta charset="utf-8">

<meta name="viewport" content="width=device-width, initial-scale=1">



<link href="css/bootstrap.min.css" rel="stylesheet">

<link href="css/bootstrap-theme.min.css" rel="stylesheet">

<link href="css/NyeStyles.css" rel="stylesheet">



<script type="text/javascript" src="script/jquery-1.9.1.min.js"></script>

<script type="text/javascript" src="script/bootstrap.js"></script>



</head>

<body>        

<?php



include("menu.php");



// First check if the user is logged in - if not redirect to the welcome page....

if (empty($_SESSION['logged_in'])) {

    include('redirect_home.html');   

}





// Then prepare profile fields by fetching contact details from the database

require_once('config1.php');

$email=$_SESSION['username'];

$name=$_SESSION['greeting'];

$TID=$_SESSION['Tid'];

$Tdate=$_SESSION['SidsteTilmelding'];

$Tnavn=$_SESSION['Tnavn'];





$mysqli = new mysqli($dh_name, $db_user, $db_pass, $db_name);

if ($mysqli->connect_errono) {

   printf("Connect failed: %s\n", $mysqli->connect_error);

}



// To get the telephone prefix from the Land table, I have joined the two tables below 

$sql='SELECT Id, Fornavn, Efternavn, Telefon, PassWord FROM UserInfo WHERE Email LIKE "'.$email.'"';   

if ($result=$mysqli->query($sql)) {

    // This is for match in terms of email, we just need to check the encrypted password and then enable the session keys...

    $row = $result->fetch_assoc();

    $UID=$row['Id'];

    $fornavn_DB=$row['Fornavn'];

    $efternavn_DB=$row['Efternavn'];

    $telefon=$row['Telefon'];

    $password_DB=$row['PassWord'];

}

// check if this is to delete a row in the participants table

if (isset($_POST['DeleteButton'])){

  $ButtonId=$_POST['DeleteButton'];

  // Delete from Database

  $sql=sprintf('DELETE FROM SignUp WHERE Id=%s',$ButtonId);

  if (!$result=$mysqli->query($sql)) {

      die('Error: ' . $mysqli->error);

  }
}



// Check the different buttons that could have been pressed to get here



$msg = '';

$msg_color='#333333';

if (isset($_POST['TurnamentButton11'])){
    $Tnavn = $_POST['TurnamentButton11'];
    // Matsumae turnament clicked - redirect to participants page...
       $sql='select Id, Navn, Valuta, Bank, SidsteTilmelding from Tournament where Navn like "'.$Tnavn.'"';        

        if ($result=$mysqli->query($sql)) {

            if($result->num_rows === 0) {

                include('redirect_member.html');

           } else {

                $row = $result->fetch_assoc();

                $TID=$row['Id'];

                $_SESSION['Tid']=$row['Id'];

                $Tnavn=$row['Navn'];

                $_SESSION['Tnavn']=$row['Navn'];
                
               $Tvaluta=$row['Valuta'];
                
               $Tbank=$row['Bank'];

               $Tdate=$row['SidsteTilmelding'];

               $_SESSION['SidsteTilmelding']=$row['SidsteTilmelding'];
          }
                   $result->close();
           }  
          

}

if (isset($_POST['SignupButton'])){
   
      include('redirect_signup.html');
 
}




if (isset($_POST['PasswordButton'])){



    // Change Password



    $new_password=md5($_POST['NewPW']);

    if ($password_DB == md5($_POST['OldPW'])){

        $sql='UPDATE  UserInfo SET  PassWord =  "'.$new_password.'" WHERE Email like "'.$email.'"';

        if (!$result=$mysqli->query($sql)) {

	    die('Error: ' . $mysqli->error);

	}

          $msg='Password updated';

          $msg_color='green';
      }
      else{
          $msg='Old Password Is Incorrect';

          $msg_color='red';
      }
}





if (isset($_POST['ProfileButton'])){



    // Change Profile

    $sql=sprintf('UPDATE  UserInfo SET  Fornavn =  "%s", Efternavn="%s", Email="%s", Telefon="%s" WHERE Email like "%s"', $_POST['FirstName'], $_POST['LastName'], $_POST['Email'], $_POST['Phone'], $email);

     if (!$result=$mysqli->query($sql)) {

 		 die('Error: ' . $mysqli->error);

 	  }

    $fornavn_DB=$_POST['FirstName'];

    $efternavn_DB=$_POST['LastName'];

    $telefon=$_POST['Phone'];

    $email=$_POST['Email'];

       $msg='Profile updated';

       $msg_color='green';    



}

        if (isset($_POST['SendEmail'])){



            $to = $email;

            $subject = "Payment needed for confirmation of registrations for $Tnavn";



            $message = "<h1>We have reserved your bookings for $Tnavn</h1>";

            $message .= "<p>Please transfer the full amount of '.$GrandTotal.' as soon as possible.</p>";

            $message .= "<p> $Tbank</p>";

            $message .= "<p>If you want to double check your reservation details, please do not hesiate to visit us on www.etilmelding.com/login.php anytime. You need to log in with this email address in order to see and manage your reservations.</p>";

            $message .= "<p>Looking forward to seeing you soon.<br />Kind regards</p>";

            $message .= "<p>Klubben</p>";

            



            $header = "From:etilmelding@etilmelding.com \r\n";

            $header .= "CC: \r\n";

            $header .= "MIME-Version: 1.0\r\n";

            $header .= "Content-type: text/html\r\n";



            $retval = mail ($to,$subject,$message,$header);



            if( $retval == true ) {

               echo "Message sent successfully...";

            }else {

               echo "Message could not be sent...";

            }

        }



?>



<form method="post" action="member.php" id="ctl00">

        <section class="container">    

            <section class="jumbotron" style="background-color: #363636;">



                <section class="container" style="text-align: center">

                    <h2 style="padding-bottom:20px"><?=$Tnavn?>, welcome to the Userpage on ETilmelding.com! </h2>

                        <section class="col-lg-4">

                            <p style="font-size: 14px; color:#F4FFB0">

                                Below, you can find an overview of all the tournaments currently available to you.

                            </p>

	                <table cellspacing="0" cellpadding="10" align="Center" rules="all" border="1" id="CPH1_ActiveTournamentsTable" style="border-collapse:collapse;" class="center">

		            <tbody align="center">

		                <tr>

			                <th scope="col">Active Tournaments</th>

		                </tr>

		                <tr>
                    <?php

                    $sql='SELECT Navn, SidsteTilmelding FROM Tournament WHERE 1';   		       


                    if ($result=$mysqli->query($sql)){

                        if($result->num_rows>0) {

                            /* fetch associative array */

                            while ($row = $result->fetch_assoc()) {
                            ?>

                            <tr>
                        	<td><input type="submit" name="TurnamentButton11" value="<?php echo $row['Navn'];?>" id="CPH1_ActiveTournamentsTable_Button7_0" class="btn btn-success" style="font-size:Large;"></td>

                           </tr>
                           <?php
                           }
                        }
                    }  

                    ?>
		                </tr>

	                </tbody>

	                </table>
                        </section>

                        <section class="col-lg-4" style="border-radius:5px; background-color:#404040;">

                            <p style="font-size: 14px; color:#B4FFA1">

                                By pressing the tournament name, you will be taken to the signup form for the given tournament, where you will be prompted to enter all needed information.

                            </p>
                            <div class="form-inline">

                            <button type="submit" name="SignupButton" id="CPH1_ButtonSignup" class="form-control">
                            <img src="img/Add.png">
                            Add new
                            </button>
                            <button type="submit" name="InfoButton" Info" id="CPH1_ButtonInfo" class="form-control">
                            <img src="img/Info.png">
                            <?=$Tnavn?> Info
                            </button>
                            </div>
                        </section>

                        <section class="col-lg-4">

                            <p style="font-size: 14px; color:#7ADFEB">

                                If you need to change your contact information or your password, these options can be found at the bottom of this page.

                            </p>
       
                    

                <br>



                <div class="form-group">

                    <input id="CPH1_CheckBox1" type="checkbox" name="ctl00$CPH1$CheckBox1" value=0 ><label for="CPH1_CheckBox1">Change password</label>

                    <div class="PasswordSection">

                        <h4 style="color:<?=$msg_color?>"><?=$msg?>
                        <input name="OldPW" type="password" id="CPH1_TextBoxNew" class="form-control" placeholder="Old Password">

                        <input name="NewPW" type="password" id="CPH1_TextBoxNew1" class="form-control" placeholder="New Password">

                        <input name="NewPW2" type="password" id="CPH1_TextBoxNew2" class="form-control" placeholder="Repeat New Password">

                        <input type="submit" name="PasswordButton" value="Update Password" id="CPH1_ButtonPass" class="form-control">

                    </div>

                </div>

                

                <script>

                

                    // This time I am using jQuery to hide/show the sections for changing the password. The fields will only be shown if the 

                    // checkbox is marked. To make this work, I have created a special division with the class "PasswordSection" around everything above.



                    $('.PasswordSection').hide();

                    $('#CPH1_CheckBox1').click(function(){

                        if ($(this).is(':checked')) {

                            $('.PasswordSection').show();

                        } else

                            $('.PasswordSection').hide();

                    });





                    // Check the second password character by character as typed...

                    $('#CPH1_TextBoxNew2').keyup(function() {

                        if($(this).val() != $('#CPH1_TextBoxNew1').val().substr(0,$(this).val().length)) {

                            alert('confirm password not match');

                        } 

                    });

                

                </script>

                

                <div class="form-group">

                    <input id="CPH1_CheckBox2" type="checkbox" name="ctl00$CPH1$CheckBox2" value=0><label for="CPH1_CheckBox2">Change Contact Info</label>

                    <div class="ProfileSection">

                        <h4 style="color:<?=$msg_color?>"><?=$msg?>

                    

                       <input name="FirstName" type="text" id="CPH1_TextBoxFirst" class="form-control" value="<?=$fornavn_DB?>">

                       <input name="LastName" type="text" id="CPH1_TextBoxLast" class="form-control" value="<?=$efternavn_DB?>">

                       <input name="Email" type="email" id="CPH1_TextBoxEmail" class="form-control" value="<?=$email?>">

                       <input name="Phone" type="tel" id="CPH1_TextBoxPhone" class="form-control" value="<?=$telefon?>">

                       <input type="submit" name="ProfileButton" value="Update Profile" id="CPH1_ButtonSub" class="form-control">

                    </div>

                </div>

                

                <script>

                

                // This is the same function as for password fields above... 

                

                $('.ProfileSection').hide();

                $('#CPH1_CheckBox2').click(function(){

                    if ($(this).is(':checked'))

                        $('.ProfileSection').show();

                    else

                        $('.ProfileSection').hide();

                    

                })

                

                </script>
                        </section>

                </section>

                <div style="padding-bottom:50px">

                    <!-- This is here for spacing purposes --> 

                </div>

                

<?php                
//Start Tilmeldinger
?>
<div class="text-center">
   <h2 style="padding-bottom:20px">Here are your SignUps for '<?=$Tnavn?>' </h2>
                <div>

      		    <?php

      		       // List all signups here...

      		       $GrandTotal=0;

      		       $sql='SELECT P.Id as Id, P.Fornavn as Fornavn, P.Efternavn as Efternavn, K1.Tekst as K1, K2.Tekst as K2, C.Tekst as V1, A.Tekst as V2,R.Tekst as V3, K1.Pris as K1p, K2.Pris as K2p, A.Pris as V1p, C.Pris as V2p, R.Pris as V3p FROM SignUp P LEFT OUTER join Choice C on P.Valg1=C.Id LEFT OUTER JOIN Choice A on P.Valg2=A.Id LEFT OUTER JOIN Choice R on P.Valg3=R.Id LEFT OUTER JOIN Choice K1 on P.Kategori1=K1.Id LEFT OUTER JOIN Choice K2 on P.Kategori2=K2.Id WHERE P.UserId= '.$UID.' AND P.TurneringId LIKE '.$TID;      		       

                   if ($result=$mysqli->query($sql)){
                    if($result->num_rows > 0) {                     
                                      
                if($Tdate <= date("Y-m-d H:i:s")){
                               
                    ?>
      	            <table class="table table-hover table-bordered" cellspacing="0" cellpadding="4" id="CPH1_GridView11" style="color:black;border-collapse:collapse;">

      		    <tbody>

      		    <tr style="color:White;background-color:#990000;font-weight:bold;">
      			  <th><a href="#" style="color:White;">First Name</a></th><th><a href="#" style="color:White;">Last Name</a></th><th>Prim. Category</th><th>Sec. Category</th><th>Camp</th><th>Accommodation Cup</th><th>Accommodation Camp</th><th><a href="#" style="color:White;">Price</a></th>

      		    </tr>
                    <?php
      		    while ($row = $result->fetch_assoc()) {
			$price =$row['K1p']+$row['K2p']+$row['V1p']+$row['V2p']+$row['V3p'];

                        echo sprintf('<tr style="color:White;background-color:#363636;">
 <td>%s</td> <td>%s</td> <td>%s</td> <td>%s</td> <td>%s</td> <td>%s</td> <td>%s</td> <td>%s</td> </tr>', $row['Fornavn'], $row['Efternavn'],$row['K1'],$row['K2'],$row['V1'],$row['V2'],$row['V3'], $price);
                    }
                }else{
                      ?>
                      <table class="table table-hover table-bordered" cellspacing="0" cellpadding="4" id="CPH1_GridView11" style="color:black;border-collapse:collapse;">

                      <tbody>

                      <tr style="color:White;background-color:#990000;font-weight:bold;">
                      <th>&nbsp;</th><th><a href="#" style="color:White;">First Name</a></th><th><a href="#" style="color:White;">Last Name</a></th><th>Prim. Category</th><th>Sec. Category</th><th>Camp</th><th>Accommodation Cup</th><th>Accommodation Camp</th><th><a href="#" style="color:White;">Price</a></th>

                      </tr>
                      <?php
      		      while ($row = $result->fetch_assoc()) {
			$price =$row['K1p']+$row['K2p']+$row['V1p']+$row['V2p']+$row['V3p'];   

                        echo sprintf('<tr style="color:White;background-color:#363636;"> <td>
                        <input type="image" src="img/delete.jpg" name="DeleteButton" value="%s"></></td> <td>%s</td> <td>%s</td> <td>%s</td> <td>%s</td> <td>%s</td> <td>%s</td> <td>%s</td> <td>%s</td> </tr>', $row['Id'], $row['Fornavn'], $row['Efternavn'],$row['K1'],$row['K2'],$row['V1'],$row['V2'],$row['V3'], $price);
                     }
                 }
                 $GrandTotal+=$price;

                 ?>
      	        </tbody>

      	        </table>
      	        <h3 style="font-size: 14px">The total price for all registrations: <?= $GrandTotal ?> <?= $Tvaluta ?></h3>

      	        <div class="text-center">

                    <input type="submit" name="SendEmail" value="Confirm" id="SendEmail" class="btn btn-primary btn-lg">

                    <p style="font-size: 14px" class="lead">Confirm registrations and send confirmation email</p>

               </div>
<?php
                     }
                     else{
                         printf('<p>No records found....</p>');
                     }
                    }

                    //$result->close();  /* free up resources */                    

      		       

      		    ?>



               </div> 

            </div>
<?php
//Slut Tilmeldinger
?>
            </section>             <!-- End Jumbotron section--> 

        </section>

</form>



<?php

  include("footer.html");

?>