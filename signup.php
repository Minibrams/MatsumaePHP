<?php session_start(); ?>

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<title>Etilmelding Sign Up</title>

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





    // Then prepare ...

    $email=$_SESSION['username'];

    $UID=$_SESSION['UID'];
    
    $Tnavn=$_SESSION['Tid'];



    // setup database access

    require_once('config1.php');

    $mysqli = new mysqli($dh_name, $db_user, $db_pass, $db_name);

    if ($mysqli->connect_errono) {

       printf("Connect failed: %s\n", $mysqli->connect_error);

    }

    
       $sql='select Id, Valuta, Bank from Tournament where Navn like "'.$Tnavn.'"';        

        if ($result=$mysqli->query($sql)) {

            if($result->num_rows === 0) {

                include('redirect_member.html');

           } else {

                $row = $result->fetch_assoc();

                $TID=$row['Id'];

                $Tvaluta=$row['Valuta'];
                
               $Tbank=$row['Bank'];
          }
                   $result->close();
           }  
    

    // check if this form has already been submitted

    if (isset($_POST['RegisterButton'])){

        // We will probably need to do some content checking along the way. For now all we do is copy the contents of the form

        // fields to the database.

        

        $fornavn=$_POST['Firstname'];

        $efternavn=$_POST['Lastname'];

        $klub=$_POST['Club'];

        $V1V=$_POST['DropDownV1'];

        $V2V=$_POST['DropDownV2'];

        $V3V=$_POST['DropDownV3'];

        $category1=$_POST['Category1'];

        $category2=$_POST['Category2'];



        // Insert into Database

        $sql=sprintf('INSERT INTO SignUp (Fornavn, Efternavn, UserId, Klub, TurneringId, Kategori1, Kategori2, Valg1, Valg2, Valg3) 

        VALUES ("%s","%s",%d,"%s",%d,%d,%d,%d,%d,%d)', $fornavn, $efternavn, $UID, $klub, $TID, $category1, $category2, $V1V, $V2V, $V3V);

        

        if (!$result=$mysqli->query($sql)) {

    		 die('Error: ' . $mysqli->error);

    	 }



          $msg='Registration on file';

          $msg_color='green';    

    }

    

    

        // Check if this is to Send email

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

        



        // check if this is to delete a row in the participants table

        if (isset($_POST['DeleteButton'])){

            $ButtonId=$_POST['DeleteButton'];

            // Delete from Database

            $sql=sprintf('DELETE FROM SignUp WHERE Id=%s',$ButtonId);

            if (!$result=$mysqli->query($sql)) {

        		 die('Error: ' . $mysqli->error);

        	 }

        }
    
      

?>

    <form method="post" action="signup.php" id="ctl00">



    <section class="container">

     <div class="form-inline">



            </div>

           <section class="jumbotron" style="background-color: #363636;">

          <h2 class="text-center"><?php echo $Tnavn;?></h2>
          <h4 class="text-center">Fill out the form below to register a person as a participant for the <?php echo $Tnavn;?></h4>
          <p class="text-center">When you've registered as many people as you need, go to the bottom of the page to confirm the registrations.</p>

              

            <center>

            <div>
            <section class="boxedtext">
            <p style="font-size: 14px;">Enter your first name</p>

            <div class="form-group signup-form">

                <input name="Firstname" id="CPH1_TextBoxFirstname" type="text" class="form-control" placeholder="First Name" style="height:40px;width:200px;">

            </div>
            </section>
            
            <section class="boxedtext">

            <p style="font-size: 14px;" class="registration-info">Enter your last name</p>

            <div class="form-group" align="center">

                <input name="Lastname" id="CPH1_TextBoxLastname" type="text" class="form-control" placeholder="Last Name" style="height:40px;width:200px;">

            </div>
            </section>
            
            <section class="boxedtext">
            <p style="font-size: 14px;" class="registration-info">Enter the name of your club. <p style="color: grey; font-size: 14px">Example: Vejle Judo Klub</p></p>
            
             <div class="form-group">

                <input name="Club" id="TextBoxClub" type="text" class="form-control" placeholder="Club Name" style="height:40px;width:200px;">

            </div>
            </section>
            
            
            <section class="boxedtext">
            <p style="font-size: 14px;" class="registration-info">If you're entering as a contestant, you need to choose a primary weight category.</p>
            <p style="font-size: 14px" class="registration-info">You can choose the appropriate weight class from the dropdown below.</p>
            <p class="registration-info" style="color: #B4FFA1; font-size: 14px;">If you don't want to enter as a contestant, leave the field empty.</p>



                <div class="form-group" align="center">

                    <select name="Category1" id="DropDownFirstCategory" class="form-control" style="height:40px;width:200px;">

                    

                    <?php



                      // Load Categories from database 



                        $sql = "SELECT * FROM Choice WHERE Search LIKE 'K1'";

                        if ($result=$mysqli->query($sql)){
                           printf('<option value="0" price="0">Select</option>');
                           while ($row = $result->fetch_assoc()) {
                               if($row['TurneringId']===$TID){
                                   printf('<option value="%s" price="%s">%s</option>', $row['Id'], $row['Pris'],$row['Tekst']);
                               }
                           }



                        }

                        $result->close();  /* free up resources */

                        

                        // and make sure the selected value gets into the text field with a javascript action on the 

                        // select onChange event. Using straight JavaScript this time ... jQuery not necessary

                        //

                        ?>



                    </select>

                </div>
                </section>
                
                
                <section class="boxedtext">
                <p style="font-size: 14px;" class="registration-info">If you're entering as a contestant in another weight class than your primary, you can choose the appropriate weight class from the dropdown below.</p>
                <p class="registration-info" style="color: #B4FFA1; font-size: 14px;">If you don't want to enter as a contestant, leave the field empty.</p>    

                <div class="form-group">

                    <select name="Category2" id="DropDownSecondCategory" class="form-control" style="height:40px;width:200px;">

                    

                    <?php

                        $sql = "SELECT * FROM Choice WHERE Search LIKE 'K2'";

                        if ($result=$mysqli->query($sql)){
                           printf('<option value="0" price="0">Select</option>');
                           while ($row = $result->fetch_assoc()) {

                               if($row['TurneringId']===$TID){
                                   printf('<option value="%s" price="%s">%s</option>', $row['Id'], $row['Pris'],$row['Tekst']);
                               }

                           }

                        }

                        $result->close();  /* free up resources */

                        

                    ?>

                    </select>

                </div>
                </section>
 
                
                <section class="boxedtext">
                <p style="font-size: 14px;" class="registration-info">If you want to participate in the camp for the <?php echo $Tnavn;?>, choose the appropriate option in the dropdown below.</p>
                <p class="registration-info" style="color: #F4FFB0; font-size: 14px;">Important: This will add a cost to your total price.</p>

                <div class="form-group">

                <select name="DropDownV1" id="DropDownV1" class="form-control" style="height:40px;width:200px;">

                    <?php

                      // Load Categories from database 

                        $sql = "SELECT * FROM Choice WHERE Search LIKE 'V1'";

                        if ($result=$mysqli->query($sql)){
                           printf('<option value="0" price="0">Select</option>');
                           while ($row = $result->fetch_assoc()) {

                               if($row['TurneringId']===$TID){
                                   printf('<option value="%s" price="%s">%s</option>', $row['Id'], $row['Pris'],$row['Tekst']);
                               }

                           }

                        }

                        $result->close();  /* free up resources */                    

                    ?>                

                </select>

                

                </div>
                </section>
                
                

                <section class="boxedtext">
                <p style="font-size: 14px;" class="registration-info">If you want accomodation for the Matsumae Cup, choose the appropriate accomodation category below.</p>
				<p style="font-size: 14px" class="registration-info">You can find information about the accomodation categories by clicking <a href=#>here</a> or by navigating to the information page.</p>
                <p class="registration-info" style="color: #F4FFB0; font-size: 14px;">Important: This will add a cost to your total price.</p>    

                <div class="form-group">

                <select name="DropDownV2" id="DropDownV2" class="form-control" style="height:40px;width:200px;">

                <?php

                  // Load Categories from database 

                    $sql = "SELECT * FROM Choice WHERE Search LIKE 'V2'";

                    if ($result=$mysqli->query($sql)){

                       printf('<option value="0" price="0">Select</option>');
                       while ($row = $result->fetch_assoc()) {

                               if($row['TurneringId']===$TID){
                                   printf('<option value="%s" price="%s">%s</option>', $row['Id'], $row['Pris'],$row['Tekst']);
                               }

                       }

                    }

                    $result->close();  /* free up resources */                    

                ?>

                </select>

                </div>
                </section>
                


                <section class="boxedtext">
                <p style="font-size: 14px;" class="registration-info">If you want accomodation for the Matsumae Cup Camp, choose the appripriate accomodation category below.</p>
                <p style="font-size: 14px" class="registration-info">You can find information about the accomodation categories by clicking <a href=#>here</a> or by navigating to the information page.</p>
                <p class="registration-info" style="color: #F4FFB0; font-size: 14px;">Important: This will add a cost to your total price.</p>    

                <div class="form-group">

                    <select name="DropDownV3" id="DropDownV3" class="form-control" style="height:40px;width:200px;">

                    <?php

                      // Load Categories from database 

                        $sql = "SELECT * FROM Choice WHERE Search LIKE 'V3'";

                        if ($result=$mysqli->query($sql)){
                           printf('<option value="0" price="0">Select</option>');
                           while ($row = $result->fetch_assoc()) {

                               if($row['TurneringId']===$TID){
                                   printf('<option value="%s" price="%s">%s</option>', $row['Id'], $row['Pris'],$row['Tekst']);
                               }

                           }

                        }

                        $result->close();  /* free up resources */                    

                    ?>

                    </select>

                </div>
                </section>


                </div>
                
                <section class="boxedtext">
                <p class="lead registration-info">Register this person for the <?php echo $Tnavn;?>. </p>
                <p class"lead registration-info" style="color: #F4FFB0; font-size: 16px;">Important: The person will not be officially registered as a participant before the confirmation button at the button of this page has been pressed, and the confirmation email has been received by the user in charge of all registrations.</p>
                
                <p>

            

            <span id="TotalPrice" style="padding-top:40px; padding-bottom: 40px; color: lightblue;">Price for this registration: 0 <?= $Tvaluta ?></span>
			<input type="submit" name="RegisterButton" value="Register" id="CPH1_Button5" class="btn btn-success btn-lg"> 
            </p>

                

                </section>
                </center>

                

                <script>

                     

                //  This section will take care of dynamically calculating the price of the signup. Every time a dropdown box is changed 

                //  on the signup form, the calculate() function will be called. It will then go through each of the relevant boxes and 

                //  extract the price attribute of the selected item in that box, sum it up and finally update the total field.

                               

                    function calculate(){


                         var selected1 = $('#DropDownFirstCategory').find('option:selected');

                         var price1 = parseInt(selected1.attr('price'));


                         var selected2 = $('#DropDownSecondCategory').find('option:selected');

                         var price2 = parseInt(selected2.attr('price'));


                         var selected3 = $('#DropDownV2').find('option:selected');

                         var price3 = parseInt(selected3.attr('price'));



                         selected4 = $('#DropDownV3').find('option:selected');

                         var price4 = parseInt(selected4.attr('price'));



                         selected5 = $('#DropDownV1').find('option:selected');

                         var price5 = parseInt(selected5.attr('price'));



                         var total = price1+price2+price3+price4+price5;;;

                         $('#TotalPrice').html("That will be "+total+" <?= $Tvaluta ?>!"); 

                     }

                     $('#DropDownFirstCategory').change(function(){

                        calculate();

                    }); 

                    $('#DropDownSecondCategory').change(function(){

                        calculate();

                    });  

                    $('#DropDownV2').change(function(){

                        calculate();

                    });

                    $('#DropDownV3').change(function(){

                        calculate();

                    });

                    $('#DropDownV1').change(function(){

                        calculate();

                    });



                </script>



            </form>

        



              <br>

              <br>

              <div class="text-center">

                <div>

      	        <table class="table table-hover table-bordered" cellspacing="0" cellpadding="4" id="CPH1_GridView1" style="color:black;border-collapse:collapse;">

      		    <tbody>

      		    <tr style="color:White;background-color:#990000;font-weight:bold;">

      			  <th>&nbsp;</th><th><a href="#" style="color:White;">First Name</a></th><th><a href="#" style="color:White;">Last Name</a></th><th>Prim. Category</th><th>Sec. Category</th><th>Camp</th><th>Accommodation Cup</th><th>Accommodation Camp</th><th><a href="#" style="color:White;">Price</a></th>

      		    </tr>

      		    <?php

      		       // List all signups here...

      		       $GrandTotal=0;

      		       $sql='SELECT P.Id as Id, P.Fornavn as Fornavn, P.Efternavn as Efternavn, K1.Tekst as K1, K2.Tekst as K2, C.Tekst as V1, A.Tekst as V2,R.Tekst as V3, K1.Pris as K1p, K2.Pris as K2p, A.Pris as V1p, C.Pris as V2p, R.Pris as V3p FROM SignUp P LEFT OUTER join Choice C on P.Valg1=C.Id LEFT OUTER JOIN Choice A on P.Valg2=A.Id LEFT OUTER JOIN Choice R on P.Valg3=R.Id LEFT OUTER JOIN Choice K1 on P.Kategori1=K1.Id LEFT OUTER JOIN Choice K2 on P.Kategori2=K2.Id WHERE P.UserId= '.$UID.' AND P.TurneringId LIKE '.$TID;      		       

                   if ($result=$mysqli->query($sql)){

                       while ($row = $result->fetch_assoc()) {
				$price =$row['K1p']+$row['K2p']+$row['V1p']+$row['V2p']+$row['V3p'];
                           echo sprintf('<tr style="color:White;background-color:#363636;"> <td>

                               <Button type="submit" name="DeleteButton" value="%s" class="btn btn-danger">Delete</button></td> <td>%s</td> <td>%s</td> <td>%s</td> <td>%s</td> <td>%s</td> <td>%s</td> <td>%s</td> <td>%s</td> </tr>', $row['Id'], $row['Fornavn'], $row['Efternavn'],$row['K1'],$row['K2'],$row['V1'],$row['V2'],$row['V3'], $price);

                               $GrandTotal+=$price;

                       }

                    }

                    $result->close();  /* free up resources */                    

      		       

      		    ?>

      	        </tbody>

      	        </table>

      	        

      	        <h3 style="font-size: 14px">The total price for all registrations: <?= $GrandTotal ?> <?= $Tvaluta ?></h3>

      	        <div class="text-center">

                    <input type="submit" name="SendEmail" value="Confirm" id="SendEmail" class="btn btn-primary btn-lg">

                    <p style="font-size: 14px" class="lead">Confirm registrations and send confirmation email</p>

               </div>

               </div> 

            </div>

         

               

    </section>

    





</section>





<?php

    $result->close();  /* free up resources */

    include("footer.html");

?>