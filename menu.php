    <nav class="navbar navbar-inverse navbar-static-top">

		<nav class="container">



                <a class="navbar-brand" href="index.php">E-Tilmelding</a>



                <nav class="collapse navbar-collapse navHeaderCollapse">

                    <ul class="nav navbar-nav navbar-right">

                        <li><a href="index.php">Home</a></li>

                        <li><a href="register.php">Create a new user</a></li>

                        <li><a href="showfighters.php">See All Contestants</a></li>

                        

                        <?php

                        if (! empty($_SESSION['logged_in'])) {

                            echo '<li><a href="member.php">Intranet</a></li>';

                            echo '<li class="active"><a href="logoff.php">Log out</a></li>';

                        } else {

                            echo '<li class="active"><a href="login.php">Log in</a></li>';

                        }

                        ?>

                    </ul>

                </nav>

                <button class="navbar-toggle" data-toggle="collapse" data-target=".navHeaderCollapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

		</nav>

	</nav>