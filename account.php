<?php
if ( !isset( $_SESSION ) ) {
  session_start();
}

spl_autoload_register( function ( $class ) {
  include_once( 'dtb.php' );
} );

$obj = new dtb_blog;
//unset( $_POST[ 'registration' ] );

// if it is set and equals to true
if ( !isset( $_SESSION[ 'loggedIn' ] ) ) {
  header( "location:controlroom.php" );
  exit();
};

$_SESSION[ 'userinfo' ] = $obj->getuserinfo( $_SESSION[ 'userid' ] );
//print_r($_SESSION['userinfo']);
//exit();

$firstname = $_SESSION[ 'userinfo' ][ 0 ][ 'firstname' ];
$lastname = $_SESSION[ 'userinfo' ][ 0 ][ 'lastname' ];
$email = $_SESSION[ 'userinfo' ][ 0 ][ 'email' ];


?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Personal Information | BLOGit.</title>
<link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
<link rel="preconnect" href="https://fonts.googleapisa.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="css/style.css">
</head>

<body>

<!--	<div class="center">--> 

<!--	</div>-->

<nav id="navbar">
  <div class="nav-logo">
    <h1>BLOG<span class="text-primary">it.</span></h1>
  </div>
  <div id="nav-menu"> 
    
    <!--      <a href="homepage.php">Home Page</a></li>--> 
    <!--      <a href="registration.php" class="btn">Signup Now</a></li>-->
    <form action="login-registration-controller.php" method="post">
      <input class="btn5" type="submit" name="accountbacktohomepage" value="Home">
    </form>
  </div>
</nav>
<div class="outer-container">
  <div class="center">
    <?php
    if ( isset( $_SESSION[ 'usersuccess' ] ) ) {

      echo '
	  <div class="topentsuccess autovanish">
	  	<p> ' . $_SESSION[ 'usersuccess' ] . '</p>
	  </div>';
    }

    unset( $_SESSION[ 'usersuccess' ] );
    if ( isset( $_SESSION[ 'usererror' ] ) ) {

      echo '
	  <div class="topenterror autovanish">
	  	<p>' . $_SESSION[ 'usererror' ] . '</p>
	  </div>';
    }
    unset( $_SESSION[ 'usererror' ] );
    ?>
  </div>
	
	
  <div class="container"> 
    <!--		Account Form--> 
    <!--	  <a href="blogentry.php"><i class="fa-sharp fa-solid fa-arrow-left"></i></a>-->
    <div class="form signup"> <i class="fa-solid fa-user"></i>
      <h2 class="text-primary">Personal Info</h2>
      <form action="login-registration-controller.php" method="post" autocomplete="off">
        <div class="input-field">
          <input type="text" placeholder="Enter your first name" name="firstname" class="" value="<?php echo htmlentities($firstname)?>" required>
          <i class="uil uil-user icon"></i> </div>
        <div class="input-field">
          <input type="text" placeholder="Enter your last name" name="lastname" class="" value="<?php echo htmlentities($lastname)?>" required>
          <i class="uil uil-user icon"></i> </div>
        <div class="input-field">
          <input type="email" class="<?php if(isset($_SESSION['emailerror'])) {echo ' active';} ?>" placeholder="Enter your email" name="email" value="<?php
			if(isset($_SESSION['email']))
				 echo htmlentities($_SESSION['email'])?>" required>
          <i class="uil uil-envelope icon"></i> </div>
        <?php
        if ( isset( $_SESSION[ 'emailerror' ] ) ) {
          echo '<div class="inputerror">Email is already used. Please try again.</div>';
        };
        //        unset( $_SESSION[ 'passwordmatcherror' ] );
        ?>
        <div class="input-field button">
          <input class="password" type="submit" name="changepassword" value="Click to change Password">
        </div>
        <div class="input-field button">
          <input type="submit" name="updateinfo" value="Update Info">
        </div>
      </form>
    </div>
  </div>
</div>
<script src="js/login-registration.js"></script> 
<script src="js/alertnotify.js"></script>
</body>
</html>