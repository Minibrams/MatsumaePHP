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
    
    $TID=$_SESSION['Tid'];



    // setup database access

    require_once('config1.php');

    $mysqli = new mysqli($dh_name, $db_user, $db_pass, $db_name);

    if ($mysqli->connect_errono) {

       printf("Connect failed: %s\n", $mysqli->connect_error);

    }

    
       $sql='select Id, Valuta, Navn, Bank from Tournament where Id like "'.$TID.'"';        

        if ($result=$mysqli->query($sql)) {

            if($result->num_rows === 0) {

                include('redirect_member.html');

           } else {

                $row = $result->fetch_assoc();

                $TID=$row['Id'];

                $Tnavn=$row['Navn'];

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
          include('redirect_member.html');
    }

    if (isset($_POST['BackButton'])){
   
      include('redirect_member.html');
 
}

      

?>

    <form method="post" action="signup.php" id="ctl00">



    <section class="container">

     <div class="left">
          <button type="submit" name="BackButton" id="CPH1_ButtonSignup" class="btn btn-primary btn-lg">
          <img src="img/left-arrow.png">
          Back
          </button>

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

               

    </section>

    





</section>





<?php

    $result->close();  /* free up resources */

    include("footer.html");

?>