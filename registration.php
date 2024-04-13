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
<div class="outer-container height">
  <div class="container"> 
    <!--		Registration Form-->
    <div class="form"> <i class="fa-solid fa-user"></i>
      <h2 class="text-primary">Registration</h2>
      <form action="login-registration-controller.php" method="post" autocomplete="off">
        <div class="input-field">
          <input type="text" placeholder="Enter your first name" name="firstname" value="<?php
			if(isset($_SESSION['firstname']))
				 echo htmlentities($_SESSION['firstname'])?>" required>
          <i class="uil uil-user icon"></i> </div>
        <div class="input-field">
          <input type="text" placeholder="Enter your last name" name="lastname" value="<?php
			if(isset($_SESSION['lastname']))
				 echo htmlentities($_SESSION['lastname'])?>" required>
          <i class="uil uil-user icon"></i> </div>
        <div class="input-field">
          <input type="email" class="<?php if(isset($_SESSION['emailerror'])) {echo 'active';} ?>" placeholder="Enter your email" name="email" value="<?php
			if(isset($_SESSION['email']))
				 echo htmlentities($_SESSION['email'])?>" required>
          <i class="uil uil-envelope icon"></i> </div>
        <div class="input-field">
          <input type="password" class="password<?php if(isset($_SESSION['passworderror'])){echo ' active';}else if(isset($_SESSION['passwordsmall-error'])){echo ' active';} ?>" placeholder="Create a password" name="password" required>
          <i class="uil uil-lock icon"></i> <i class="uil uil-eye-slash showHidePw"></i></div>
        <div class="input-field">
          <input type="password" class="password<?php if(isset($_SESSION['passworderror'])){echo ' active';}else if(isset($_SESSION['passwordsmall-error'])){echo ' active';}?>" name="confirmpassword" placeholder="Confirm a password" required>
          <i class="uil uil-lock icon"></i> <i class="uil uil-eye-slash showHidePw"></i> </div>
        <?php
        if(isset($_SESSION['passworderror'])) {
          echo '<div class="inputerror">Passwords do not match. Please try again</div>';
        }

        if ( isset( $_SESSION[ 'passwordsmall-error' ] ) ) {
          echo '<div class="inputerror">Password must be more than 8 characters</div>';
        }


        if(isset($_SESSION['emailerror'])) {
          echo '<div class="inputerror">Email is already used. Please try again.</div>';
        }


        ?>
        <div class="input-field button">
          <input type="submit" name="registration" value="Signup">
        </div>
      </form>
    </div>
  </div>
    <a class="login-now-1" href="privacypolicy.php">Click to view our Privacy Policy</a>
</div>
<script src="js/login-registration.js"></script>
</body>
</html>