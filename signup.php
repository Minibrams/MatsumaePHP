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

<?php

      include("menu.php");



    // First check if the user is logged in - if not redirect to the welcome page....



    if (empty($_SESSION['logged_in'])) {

        include('redirect_home.html');   

    }





    // Then prepare ...

    $email=$_SESSION['username'];

    $UID=$_SESSION['UID'];



    // setup database access

    require_once('config1.php');

    $mysqli = new mysqli($dh_name, $db_user, $db_pass, $db_name);

    if ($mysqli->connect_errono) {

       printf("Connect failed: %s\n", $mysqli->connect_error);

    }

    

    

    // check if this form has already been submitted

    if (isset($_POST['RegisterButton'])){

        // We will probably need to do some content checking along the way. For now all we do is copy the contents of the form

        // fields to the database.

        

        $fornavn=$_POST['Firstname'];

        $efternavn=$_POST['Lastname'];

        $klub=$_POST['Club'];

        $participate=$_POST['DropDownParticipate'];

        $cup=$_POST['DropDownCup'];

        $camp=$_POST['DropDownCamp'];

        $category1=$_POST['Category1'];

        $category2=$_POST['Category2'];



        // Insert into Database

        $sql=sprintf('INSERT INTO Person (Fornavn, Efternavn, Klub, Kategori_1, Kategori_2, Participate, Accom_Cup, Accom_Camp, Signup, Author) 

        VALUES ("%s","%s","%s",%d,%d,%d,%d,%d,True, %s)', $fornavn, $efternavn, $klub, $category1, $category2, $participate, $camp, $cup, $UID);

        

        if (!$result=$mysqli->query($sql)) {

    		 die('Error: ' . $mysqli->error);

    	 }



          $msg='Registration on file';

          $msg_color='green';    

    }

    

    

        // Check if this is to Send email

        if (isset($_POST['SendEmail'])){

            

            $to = $email;

            $subject = "Payment needed for confirmation of registrations for Matsumae Cup 2016";



            $message = "<h1>You have reserved bookings at Matsumae 2017</h1>";

            $message .= "<p>Please transfer the full amount of '.$GrandTotal.' DKr as soon as possible.</p>";

            $message .= "<p>If you want to double check your reservation details, please do not hesiate to visit us on judo.incipo.dk anytime. You need to log in with this email address in order to see and manage your reservations.</p>";

            $message .= "<p>Looking forward to seeing you soon.<br />Kind regards</p>";

            $message .= "<p>Klubben</p>";

            



            $header = "From:admin@judo.eller.noget.dk \r\n";

            $header .= "Cc:anders@brams.dk \r\n";

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

            $sql=sprintf('DELETE FROM Person WHERE Id=%s',$ButtonId);

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

          <h2 class="text-center">Matsumae Cup 2017</h2>

          <h4 class="text-center">Fill out the form below to register a person as a participant for the Matsumae Cup 2017</h4>
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



                        $sql = "SELECT * FROM Kategori";

                        if ($result=$mysqli->query($sql)){

                           while ($row = $result->fetch_assoc()) {

                               printf('<option value="%s">%s</option>', $row['Id'], $row['Navn']);

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
                <p style="font-size: 14px;" class="registration-info">If you're entering as a contestant in another weight class than your primary, you can</p>
                <p style="font-size: 14px" class="registration-info">choose the appropriate weight class from the dropdown below.</p>
                <p class="registration-info" style="color: #B4FFA1; font-size: 14px;">If you don't want to enter as a contestant, leave the field empty.</p>    

                <div class="form-group">

                    <select name="Category2" id="DropDownSecondCategory" class="form-control" style="height:40px;width:200px;">

                    

                    <?php

                        $sql = "SELECT * FROM Kategori";

                        if ($result=$mysqli->query($sql)){

                           while ($row = $result->fetch_assoc()) {

                               printf('<option value="%s">%s</option>', $row['Id'],$row['Navn']);

                           }

                        }

                        $result->close();  /* free up resources */

                        

                    ?>

                    </select>

                </div>
                </section>
 
                
                <section class="boxedtext">
                <p style="font-size: 14px;" class="registration-info">If you want to participate in the camp for the Matsumae Cup 2017, choose the appropriate option in the dropdown below.</p>
                <p class="registration-info" style="color: #F4FFB0; font-size: 14px;">Important: This will add a cost to your total price.</p>

                <div class="form-group">

                <select name="DropDownParticipate" id="DropDownParticipate" class="form-control" style="height:40px;width:200px;">

                    <?php

                      // Load Categories from database 

                        $sql = 'SELECT * FROM Participation';

                        if ($result=$mysqli->query($sql)){

                           while ($row = $result->fetch_assoc()) {

                               printf('<option value="%s" price="%s">%s</option>', $row['Id'], $row['Price'], $row['Label']);

                           }

                        }

                        $result->close();  /* free up resources */                    

                    ?>                

                </select>

                

                </div>
                </section>
                
                

                <section class="boxedtext">
                <p style="font-size: 14px;" class="registration-info">If you want accomodation for the Matsumae Cup, choose the appripriate accomodation category below.</p>
                <p style="font-size: 14px" class="registration-info">You can find information about the accomodation categories by clicking <a href=#>here</a></p>
                <p style="font-size: 14px" class="registration-info">or by navigating to the information page.</p>
                <p class="registration-info" style="color: #F4FFB0; font-size: 14px;">Important: This will add a cost to your total price.</p>    

                <div class="form-group">

                <select name="DropDownCup" id="DropDownCup" class="form-control" style="height:40px;width:200px;">

                <?php

                  // Load Categories from database 

                    $sql = 'SELECT * FROM Cup';

                    if ($result=$mysqli->query($sql)){

                       while ($row = $result->fetch_assoc()) {

                           printf('<option value="%s" price="%s">%s</option>', $row['Id'], $row['Price'],$row['Label']);

                       }

                    }

                    $result->close();  /* free up resources */                    

                ?>

                </select>

                </div>
                </section>
                


                <section class="boxedtext">
                <p style="font-size: 14px;" class="registration-info">If you want accomodation for the Matsumae Cup Camp, choose the appripriate accomodation category below.</p>
                <p style="font-size: 14px" class="registration-info">You can find information about the accomodation categories by clicking <a href=#>here</a></p>
                <p style="font-size: 14px" class="registration-info">or by navigating to the information page.</p>
                <p class="registration-info" style="color: #F4FFB0; font-size: 14px;">Important: This will add a cost to your total price.</p>    

                <div class="form-group">

                    <select name="DropDownCamp" id="DropDownCamp" class="form-control" style="height:40px;width:200px;">

                    <?php

                      // Load Categories from database 

                        $sql = 'SELECT * FROM Camp';

                        if ($result=$mysqli->query($sql)){

                           while ($row = $result->fetch_assoc()) {

                               printf('<option value="%s" price="%s">%s</option>', $row['Id'], $row['Price'],$row['Label']);

                           }

                        }

                        $result->close();  /* free up resources */                    

                    ?>

                    </select>

                </div>
                </section>


                </div>
                
                <section class="boxedtext">
                <p class="lead registration-info">Register this person for the Matsumae Cup 2017. </p>
                <p class"lead registration-info" style="color: #F4FFB0; font-size: 16px;">Important: The person will not be officially registered as a participant before the confirmation button</p>
                <p class"lead registration-info" style="color: #F4FFB0; font-size: 16px;">at the button of this page has been pressed, and the confirmation email has been received by the user</p>
                <p class"lead registration-info" style="color: #F4FFB0; font-size: 16px;">in charge of all registrations.</p>
                
                <p>

            

            <span id="TotalPrice" style="padding-top:40px; padding-bottom: 40px; color: lightblue;">Price for this registration: 0 DKK</span>

            </p>

                <input type="submit" name="RegisterButton" value="Register" id="CPH1_Button5" class="btn btn-success btn-lg"> 

                </section>
                </center>

                

                <script>

                     

                //  This section will take care of dynamically calculating the price of the signup. Every time a dropdown box is changed 

                //  on the signup form, the calculate() function will be called. It will then go through each of the relevant boxes and 

                //  extract the price attribute of the selected item in that box, sum it up and finally update the total field.

                               

                    function calculate(){

                         var selected = $('#DropDownCup').find('option:selected');

                         var price1 = parseInt(selected.attr('price'));



                         selected2 = $('#DropDownCamp').find('option:selected');

                         var price2 = parseInt(selected2.attr('price'));



                         selected3 = $('#DropDownParticipate').find('option:selected');

                         var price3 = parseInt(selected3.attr('price'));



                         var total = price1+price2+price3;

                         $('#TotalPrice').html("That will be "+total+" Kr!"); 

                     }

                     

                        

                    $('#DropDownCup').change(function(){

                        calculate();

                    });

                    $('#DropDownCamp').change(function(){

                        calculate();

                    });

                    $('#DropDownParticipate').change(function(){

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

      		       $sql='SELECT P.Id as Id, Fornavn, Efternavn, K1.Navn as K1, K2.Navn as K2, C.Label as Cup, A.Label as Camp,R.Label as Participate, A.Price+R.Price+C.Price as Price FROM Person P  LEFT OUTER join Cup C on P.Accom_Cup=C.Id LEFT OUTER JOIN Camp A on P.Accom_Camp=A.Id LEFT OUTER JOIN Participation R on P.Participate=R.Id LEFT OUTER JOIN Kategori K1 on P.Kategori_1=K1.Id LEFT OUTER JOIN Kategori K2 on P.Kategori_2=K2.Id WHERE Signup=1 and Author = '.$UID;      		       

                   if ($result=$mysqli->query($sql)){

                       while ($row = $result->fetch_assoc()) {

                           echo sprintf('<tr style="color:White;"> <td>

                               <Button type="submit" name="DeleteButton" value="%s" class="btn btn-danger">Delete</button></td> <td>%s</td> <td>%s</td> <td>%s</td> <td>%s</td> <td>%s</td> <td>%s</td> <td>%s</td> <td>%s</td> </tr>', $row['Id'], $row['Fornavn'], $row['Efternavn'],$row['K1'],$row['K2'],$row['Participate'],$row['Cup'],$row['Camp'], $row['Price']);

                               $GrandTotal+=$row['Price'];

                       }

                    }

                    $result->close();  /* free up resources */                    

      		       

      		    ?>

      	        </tbody>

      	        </table>

      	        

      	        <h3 style="font-size: 14px">The total price for all registrations: <?= $GrandTotal ?> DKK</h3>

      	        <div class="text-center">

                    <input type="submit" name="SendEmail" value="Confirm" id="ButtonSendEmail" class="btn btn-primary btn-lg">

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