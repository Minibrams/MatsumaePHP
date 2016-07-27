<?php session_start(); ?>

<html xmlns="http://www.w3.org/1999/xhtml">

<head><title>Etilmelding Show All</title>



<meta charset="utf-8">

<meta name="viewport" content="width=device-width, initial-scale=1">



<link href="css/bootstrap.min.css" rel="stylesheet">

<link href="css/bootstrap-theme.min.css" rel="stylesheet">

<link href="css/NyeStyles.css" rel="stylesheet"></head>



<script type="text/javascript" src="script/jquery-1.9.1.min.js"></script>

<script type="text/javascript" src="script/bootstrap.js"></script>



<body>

<?php

      include('menu.php');


      $TID=$_SESSION['Tid'];
      $Tnavn=$_SESSION['Tnavn'];


      require_once('config1.php');



      $mysqli = new mysqli($dh_name, $db_user, $db_pass, $db_name);

      if ($mysqli->connect_errono) {

          printf("Connect failed: %s\n", $mysqli->connect_error);

      }



if (isset($_POST['TurnamentButtonAll'])){
    $Tnavn = $_POST['TurnamentButtonAll'];
    
       $sql='select Id, Navn from Tournament where Navn like "'.$Tnavn.'"';        

        if ($result=$mysqli->query($sql)) {

            if($result->num_rows === 0) {

                include('redirect_home.html');

           } else {

                $row = $result->fetch_assoc();

                $TID=$row['Id'];

                $_SESSION['Tid']=$row['Id'];
                $Tnavn==$row['Navn'];
                $_SESSION['Tnavn']=$row['Navn'];
          }
                   $result->close();
           } 

}

    ?>



    <form method="post" action="showfighters.php" id="ctl00">

    <section class="container">

      <section class="jumbotron" style="background-color: #363636;">

          



           <table cellspacing="0" cellpadding="10" align="Left" rules="all" border="1" id="CPH1_ActiveTournamentsTable" style="border-collapse:collapse;" class="center">

		            <tbody align="center">

		                <tr>

			                <th scope="col">Active Tournaments</th>

		                </tr>

		                <tr>
                    <?php

                    $sql='SELECT Id, Navn FROM Tournament';   		       


                    if ($result=$mysqli->query($sql)){

                        if($result->num_rows>0) {

                            /* fetch associative array */

                            while ($row = $result->fetch_assoc()) {
                            ?>
                            <tr style="color:White;background-color:#363636;">
                        	<td><input type="submit" name="TurnamentButtonAll" value="<?php echo $row['Navn'];?>" id="CPH1_ActiveTournamentsTable_Button88_0" class="btn btn-success" style="font-size:Medium;"></td>

                           </tr>
                           <?php

                           }
                        }
                      $result->close();  /* free up resources */
                    }  

                    ?>
		                </tr>

	                </tbody>

	                </table>

<h2 class="text-center"><span id="CPH1_LabelTournamentName">All signups for: <?=$Tnavn?></span></h2>

          <div class="text-center">

              <center>

              

   

                    <?php




		$sql1='SELECT pp.Id as Id, pp.Fornavn as Fornavn, pp.Efternavn as Efternavn, pp.Klub as Klub, K11.Tekst as K1, LL.Navn as Land FROM SignUp pp LEFT OUTER JOIN UserInfo UU ON pp.UserId=UU.Id LEFT OUTER JOIN Land LL ON UU.Land = LL.Id LEFT OUTER JOIN Choice K11 ON pp.Kategori1=K11.Id WHERE pp.TurneringId ='.$TID.' UNION ALL SELECT p.Id as Id, p.Fornavn as Fornavn, p.Efternavn as Efternavn, p.Klub as Klub, K1.Tekst as K1, L.Navn as Land FROM SignUp p LEFT OUTER JOIN UserInfo U ON p.UserId=U.Id LEFT OUTER JOIN Land L ON U.Land = L.Id LEFT OUTER JOIN Choice K1 ON p.Kategori2=K1.Id WHERE p.TurneringId ='.$TID;
		
                if ($result1=$mysqli->query($sql1)){
		    if($result1->num_rows>0 && $result1->num_rows>0) {
?>

                 <table class="table table-hover" cellspacing="0" cellpadding="4" style="color:#333333;border-collapse:collapse;">

                 <tbody>

                   <tr style="color:White;background-color:#990000;font-weight:bold;">

                      <th style="color:White;">Firstname</th><th style="color:White;">Lastname</th><th style="color:White;">Category</th><th style="color:White;">Club</th><th style="color:White;">Country</a></th>

                   </tr>
<?php
                       /* fetch associative array */

                       $i=1;
		       while ($row1 = $result1->fetch_assoc()){
                                               if($row1['K1']){
                                                    $rowcolor = ($i % 2!=0?"#FFFBD6":"white");
                                                    printf('<tr style="color:#333333;background-color:%s;">', $rowcolor);
					            printf('<td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td>', $row1['Fornavn'], $row1['Efternavn'], $row1['K1'], $row1['Klub'], $row1['Land']);
                                	            printf('</tr>');
                                	            $i++; 
                                                }

				       }
				        echo '</tbody></table>';
                             } else {

                                printf('<p>Records not activated yet, please come back later....</p>');
                             }
                           //$result->close();  /* free up resources */
                        }

                    ?>  
              </center>

          </div>

      </section>

    </section>

    </form>



<?php include('footer.html'); ?>