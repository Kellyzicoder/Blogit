<?php
if ( !isset( $_SESSION ) ) {
  session_start();
}

spl_autoload_register( function ( $class ) {
  include_once( 'dtb.php' );
} );

$obj = new dtb_blog;
//unset( $_POST[ 'registration' ] );

if ( !isset( $_SESSION[ 'loggedIn' ] ) ) {
  header( "location:controlroom.php" );
  exit();
};
// if it is set and equals to true
//if ( ( isset( $_SESSION[ 'loggedIn' ] ) )and( $_SESSION[ "loggedIn" ] ) ) {
//	header("location:homepage.php");
//	exit();
//}

?> 

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Change Password | BLOGit.</title>
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
    <h1>BLOG<span class="text-primary">it.</span></h1> </div>
  <div id="nav-menu">

<!--      <a href="landingpage.html">Home</a></li>-->
<!--      <a href="registration.php" class="btn">Signup Now</a></li>-->
 <form class="" action="login-registration-controller.php" method="post">
<input class="btn" type="submit" name="PersonalInfo" value="Personal Info">
  </form>
  </div>
</nav>
<div class="outer-container">
  <div class="container"> 
    <div class="form"> <i class="fa-solid fa-user"></i>
      <h2 class="text-primary">Change Password</h2>
      <form action="login-registration-controller.php" method="post">
        <input type="hidden" name="password" value="password" />


        <div class="input-field">
          <input type="password" placeholder="Enter current password" class="password <?php if(isset($_SESSION['new'])){echo ' active';}?>" name="currentpassword" required>
			<i class="uil uil-lock icon"></i> <i class="uil uil-eye-slash showHidePw"></i> </div>
		  <div class="input-field">
          <input type="password" placeholder="Enter new password" class="password <?php if(isset($_SESSION['new'])){echo ' active';}?>" name="newpassword" required>
			<i class="uil uil-lock icon"></i> <i class="uil uil-eye-slash showHidePw"></i> </div>
			<div class="input-field">
          <input type="password" placeholder="Confirm new password" class="password <?php if(isset($_SESSION['new'])){echo ' active';}?>" name="confirmnewpassword" required>
          <i class="uil uil-lock icon"></i> <i class="uil uil-eye-slash showHidePw"></i> </div>

		  <?php
//		  $_SESSION['inputerror'] = true;
		  if ( isset( $_SESSION[ 'passworderror' ] ) ) {
//			  $_SESSION['inputerror'] = true;
			unset($_SESSION['passwordsmall-error']);
//			  unset($_SESSION['duplicate-password']);
			 unset( $_SESSION[ 'passwordmatch-error' ] );
			 unset( $_SESSION[ 'oldpassword-error' ] );
          echo '<div class="inputerror">Current password does not match. Please try again</div>';
        }
 
		if ( isset( $_SESSION[ 'passwordmatch-error' ] ) ) {
//			$_SESSION['inputerror'] = true;
			unset($_SESSION['passwordsmall-error']);
			 unset( $_SESSION[ 'oldpassword-error' ] );
//			 unset( $_SESSION[ 'passworderror' ] );
			unset( $_SESSION[ 'duplicate-password' ] );
          echo '<div class="inputerror">Passwords do not match. Please try again</div>';
        }
		  
		  if ( isset( $_SESSION[ 'passwordsmall-error' ] ) ) {
//			  $_SESSION['inputerror'] = true;
//			 unset( $_SESSION[ 'duplicate-password' ] );
			 unset( $_SESSION[ 'passwordmatch-error' ] );
			 unset( $_SESSION[ 'oldpassword-error' ] );
			 unset( $_SESSION[ 'passworderror' ] );
          echo '<div class="inputerror">Password entered must be more than 8 characters</div>';
        }
//		  
//		  if ( isset( $_SESSION[ 'duplicate-password' ] ) ) {
//			unset( $_SESSION[ 'passwordsmall-error' ] );
//			 unset( $_SESSION[ 'passwordmatch-error' ] );
//			 unset( $_SESSION[ 'oldpassword-error' ] );
//			 unset( $_SESSION[ 'passworderror' ] );
//          echo '<div class="inputerror">Choose another Password</div>';
//        }
		  
		  
		  if ( isset( $_SESSION[ 'oldpassword-error' ] ) ) {
//			unset($_SESSION['duplicate-password']);
			  unset( $_SESSION[ 'passwordsmall-error' ] );
			 unset( $_SESSION[ 'passwordmatch-error' ] );
			 unset( $_SESSION[ 'passworderror' ] );
          echo '<div class="inputerror">You typed in an old password. Please try again</div>';
        }
		  
		  
        ?>
        <div class="input-field button">
          <input type="submit" name="updatepassword" value="Update Password">
        </div>
      </form>

    </div>
  </div>
</div>
<script src="js/login-registration.js"></script>
</body>
</html>