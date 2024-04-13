<?php
if ( !isset( $_SESSION ) ) {
  session_start();
}

spl_autoload_register( function ( $class ) {
  include_once( 'dtb.php' );
} );

$obj = new dtb_blog;
unset( $_POST[ 'login' ] );

// if it is set and equals to true
if ( ( isset( $_SESSION[ 'loggedIn' ] ) )and( $_SESSION[ "loggedIn" ] ) ) {
	header("location:index.html");
	exit();
}

//if(isset($_SESSION[ 'input-error' ])) {
//	print("here");
//}




?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Login Registration</title>
<link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
<link rel="preconnect" href="https://fonts.googleapisa.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="css/style.css">
</head>

<body>
<nav id="navbar">
  <div class="nav-logo">
    <h1>BLOG<span class="text-primary">it.</span></h1>
    </div>
  <div id="nav-menu">
	  
	  <form action="login-registration-controller.php" method="post">
    <input class="btn5" type="submit" name="loginregishomepage" value="Home">
  </form>
	  <form action="login-registration-controller.php" method="post">
    <input class="btn" type="submit" name="login" value="Login Now">
	  </form>
		  	  
        </div>
</nav>
<div class="outer-container">
  <div class="verify"> 
	  
   <p>A verification email has been sent to your <br>email to verify your identity. <br><br></p>
	  
</div>
	</div>
<script src="js/login-registration.js"></script>
</body>
</html>