<?php session_start(); ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Matsumae Cup 2017</title>

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
   
    $msg = '';
    if (isset($_POST['ctl00$CPH1$Button1']) && !empty($_POST['ctl00$User']) && !empty($_POST['ctl00$PW'])) {
        $email=$_POST['ctl00$User'];
        $password =md5($_POST['ctl00$PW']);
        
        // Get records from database - if any and use for checking password

        require_once('config1.php');
        $mysqli = new mysqli($dh_name, $db_user, $db_pass, $db_name);
        if ($mysqli->connect_errono) {
           printf("Connect failed: %s\n", $mysqli->connect_error);
        }

        $sql='select Id, Fornavn, Password from Person where Email like "'.$email.'"';        
        if ($result=$mysqli->query($sql)) {
            // This is if the email is not found...    
            if($result->num_rows === 0) {
                $msg='No such username on file';

           } else {
                // This is for match in terms of email, we just need to check the encrypted password and then enable the session keys...
                $row = $result->fetch_assoc();
                $password_DB=$row['Password'];
                $userID=$row['Id'];
                $name=$row['Fornavn'];
                
                 if ($password == $password_DB) {
                    
                   $_SESSION['logged_in'] = true;
                   $_SESSION['timeout'] = time();
                   $_SESSION['username'] = $email;
                   $_SESSION['UID']=$userID;
                   $_SESSION['greeting']=$name;
 
                   // Then we can re-direct to the welcome page
                   include('redirect_member.html');
                } else {
                    echo 'Password did not match';
                }
            }
        } 

    }
    
    // Otherwise we will handle the form fields like normal along with our special red error message $msg below
    
 ?>
 
    <form id="ctl00" action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method = "post">

    <section class="container">
      <section class="jumbotron" style="background-color: #363636;">
           <h4 class="text-center">Login below if you wish to change your registration(s)</h4>
              <center>
			<div class="main-login-form">
				<div class="login-group">
				    <h4 class = "form-signin-heading" style="color:red;"><?php echo $msg; ?></h4>
                
					<div class="form-group">
						Email
                        <input name="ctl00$User" id="CPH1_TextBox1" type="text" class="form-control" placeholder="Email" style="height:30px;width:200px;">
						<label for="clt100$PW" class="show">Password</label>
                        <input name="ctl00$PW" type="password" id="CPH1_TextBox2" class="form-control" placeholder="Password" style="height:30px;width:200px;">
                        <div>
                            <br>
                        </div>
					<input type="submit" name="ctl00$CPH1$Button1" value="Login" id="CPH1_Button1" class="btn btn-primary">
					</div>
				</div>
			</div>
                  <p style="font-size:12px">Don't have a user yet? Go to the <a href="register.php">registration page</a>.</p>
            </center>
      </section>
  </section>
  
</form>



<?php
  include("footer.html");
?>