<?php session_start(); ?>

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

  <title>Etilmelding</title>

  <meta charset="utf-8">

  <meta name="viewport" content="width=device-width, initial-scale=1">



  <script type="text/javascript" src="script/jquery-1.9.1.min.js"></script>

  <script type="text/javascript" src="script/bootstrap.js"></script>





  <link href="css/bootstrap.min.css" rel="stylesheet">

  <link href="css/bootstrap-theme.min.css" rel="stylesheet">

  <link href="css/NyeStyles.css" rel="stylesheet">

</head>

<body>



<?php include("menu.php"); ?>



    <div class="container-fluid hero">

        <!-- Carousel -->

        <div id="hero-carousel" class="carousel slide" data-ride="carousel">

            <!-- Indicators -->

            <ol class="carousel-indicators row">

                <li data-target="#hero-carousel" data-slide-to="0" class="col-sm-4 message-1">

                    <div class="caption">Log in</div>

                </li>

                <li data-target="#hero-carousel" data-slide-to="1" class="col-sm-4 message-2 active">

                    <div class="caption">Create a new user</div>

                </li>

                <li data-target="#hero-carousel" data-slide-to="2" class="col-sm-4 message-3">

                    <div class="caption">Information</div>

                </li>

            </ol>

            

            <!-- Wrapper for slides -->

            <div class="carousel-inner">

                <div class="item">

                    <!--<div class="carousel-card" style="background-image: url(MC-LOGO.png); background-size: cover;"></div>-->

                    <div class="carousel-caption">

                        <section class="col-lg-6 pull-left">

                            <h1><span id="CPH1_LabelTournamentName">Already got a user?</span></h1>

                                <span id="CPH1_LabelPageOneText">If you have already registered a user on this site, you can log in using the button below, or using the menu above.</p>
                                <p>After you've logged in, you can register yourself and others as participants to the Matsumae Cup.</p>

                            <p style="font-size:12px">If you haven't registered as a user yet, you can go to the <a href="register.php">registration page</a> using this link.</p>

                            <a href="login.php" class="btn btn-lg message-2 pull-left">Log in</a>

                        </section>             

                    </div>

                </div>



                <div class="item active">

                    <table id="CPH1_DataList1" cellspacing="0" class="col-lg-6 pull-right" style="border-collapse:collapse;">

						<tbody>
		
						<tr>
		
							<td>
		
								<img src="img/MC-LOGO.png" style=" background-size: cover" height="400" width="400">
		
							</td>
		
						</tr>
		
						</tbody>
		
						</table>

                    <!--<div class="carousel-card" style="background-image: url(MC-LOGO.png); background-size: cover;"></div>-->

                    <div class="carousel-caption">

                        <section class="col-lg-6 pull-left">

                            <h1><span id="CPH1_LabelTournamentName">Matsumae Cup 2017</span></h1>

                            <p class="lead">

                                This year, we are proud to announce the 15th annual judo cup, the Matsumae Cup 2017!</p>

                            <p>
                            	On this site, you will be able to register yourself and others as participants and contestants in the Matsumae Cup.</p>

                            <p>First, you will need to create a new user on the site. You can press the button below or use the menu above to go to the user registration form. </p>

                            <a href="register.php" class="btn btn-lg message-2 pull-left">Register as a user</a>

                        </section>     

                    </div>

                </div>



                <div class="item">

                    <div class="carousel-card"></div>



                    <div class="carousel-card" style="background-image: url(#); background-size: cover;"></div>



                    <div class="carousel-caption">

                        <section class="col-lg-6">

                        <h1><span id="CPH1_LabelTournamentNameInfo">Matsumae Cup 2017 Information</span></h1>

                        <p class="lead">

                            <span id="CPH1_LabelPageThreeSupHeader">Dates</span></p>

                        <p>

                            <span id="CPH1_LabelPageThreeTekst">Some more information</span></p>

                        </section>



                        <section class="col-lg-6">

                        <h1><span id="CPH1_LabelPageThreeEkstraHeader">More Information over here</span></h1>

                        <p class="lead"><span id="CPH1_LabelPageThreeEkstraSupHeader">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</span></p>

                        <p><span id="CPH1_LabelPageThreeEkstraTekst">Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</span></p>

                        </section>



                    </div>

                </div>

            </div>

        </div>

        

    </div>

    <!-- End Carousel -->



    <section class="container" id="bottomInfo">

        <section class="col-lg-4">

            <h3>Dates</h3>

            <p><span id="CPH1_LabelDatesTekst">Here we can add a lot more information about the website and the event. All this information is going to be cut off in and we'll add a button that links the user to the page containing all the information. Lorem ipsum dolor sit amet...</span></p>

        </section>



        <section class="col-lg-4">

            <h3>More content</h3>

            <p><span id="CPH1_LabelMoreContentTekst">Here we can add a lot more information about the website and the event. All this information is going to be cut off in and we'll add a button that links the user to the page containing all the information. Lorem ipsum dolor sit amet...</span></p>

        </section>



        <section class="col-lg-4">

            <h3>Contact information</h3>

            <p><span id="CPH1_LabelContactInfo">Here we can add a lot more information about the website and the event. All this information is going to be cut off in and we'll add a button that links the user to the page containing all the information. Lorem ipsum dolor sit amet...</span></p>

        </section>

    </section>



		<!-- Controls -->

		

    

</form>

<?php

  include("footer.html");

?>