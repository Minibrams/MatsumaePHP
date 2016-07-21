<?php session_start(); ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head><title>Matsumae Cup 2017</title>

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
      require_once('config1.php');

      $mysqli = new mysqli($dh_name, $db_user, $db_pass, $db_name);
      if ($mysqli->connect_errono) {
          printf("Connect failed: %s\n", $mysqli->connect_error);
      }
    ?>

    <form method="post" action="AllSignups.aspx?tournament=Matsumae+Cup+2017" id="ctl00">
    <section class="container">
      <section class="jumbotron" style="background-color: #363636;">
          <h2 class="text-center"><span id="CPH1_LabelTournamentName">Matsumae Cup 2017</span></h2>
          <h4 class="text-center">
              <span id="CPH1_Label2">All signups for Matsumae Cup 2017</span>
          </h4>
          <div class="text-center">
              <center>
              <div>
                 <table class="table table-hover" cellspacing="0" cellpadding="4" style="color:#333333;border-collapse:collapse;">
                 <tbody>
                   <tr style="color:White;background-color:#990000;font-weight:bold;">
                      <th style="color:White;">Lastname</th><th style="color:White;">FirstName</th><th style="color:White;">Category</th><th style="color:White;">Club</th><th style="color:White;">Country</a></th>
                   </tr>
   
                    <?php
                    $sql='SELECT P.Id as Id, Fornavn, Efternavn, Klub, Landenavn, K1.Navn as K1, K2.Navn as K2 FROM Person P LEFT OUTER JOIN Land L ON P.Land = L.id LEFT OUTER JOIN Kategori K1 on P.Kategori_1=K1.Id LEFT OUTER JOIN Kategori K2 on P.Kategori_2=K2.Id WHERE Signup=1';      		       
    
                    if ($result=$mysqli->query($sql)){
                        if($result->num_rows>0) {

                            /* fetch associative array */
                            $i=1;
                            while ($row = $result->fetch_assoc()) {
                                $rowcolor = ($i % 2!=0?"#FFFBD6":"white");
                                printf('<tr style="color:#333333;background-color:%s;">', $rowcolor);
                                $kategori = $row['K1']."/".$row['K2'];
                                printf('<td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td>', $row['Efternavn'], $row['Fornavn'], $kategori, $row['Klub'], $row['Landenavn']);
                                printf('</tr>');
                                $i++;
                
                            }
                            echo '</tbody></table>';

                        } else {
                            printf('<p>No records found in table....</p>');
                        }
                    }
                     $result->close();  /* free up resources */
                    ?>  
              </div>
              </center>
          </div>
      </section>
    </section>
    </form>

<?php include('footer.html'); ?>