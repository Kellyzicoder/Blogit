<?php
if ( !isset( $_SESSION ) ) {
  session_start();
}

spl_autoload_register( function ( $class ) {
  include_once( 'dtb.php' );
} );

$obj = new dtb_blog;

if ( !isset( $_SESSION[ 'loggedIn' ] ) ) {
  header( "location:controlroom.php" );
  exit();
};


$_SESSION[ 'blogdata' ] = $obj->getblogdata( $_SESSION[ 'userid' ] );
$username = $obj->getuserinfo( $_SESSION[ 'userid' ] );

//print($username);
//exit();

//print_r($_SESSION[ 'blogdata']);
//exit();

//if ( isset( $_SESSION[ 'blogname' ] ) ) {
//  print( $_SESSION[ 'blogname' ] );
//}
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Homepage | My Blog(s)</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="css/style.css">
<link rel="preconnect" href="https://fonts.googleapisa.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
</head>
</head>

<body>
<nav id="navbar">
  <div class="nav-logo">
    <h1>BLOG<span class="text-primary">it.</span></h1>
    </div>
  <div id="nav-menu"> <a href="homepage.php">Home</a><a href="community.php">Community</a> <a class="<?php if ( isset( $_SESSION[ 'loggedIn' ] ) ) {echo" nodisplay"; } ?>" href="login">Login</a> <a class="navsignup <?php if ( isset( $_SESSION[ 'loggedIn' ] ) ) {echo" nodisplay"; } ?>" href="#contact">Blogs</a>
    <?php
    if ( isset( $_SESSION[ 'loggedIn' ] ) ) {
      echo '<div class="LogInOut">';
		echo '<form action="login-registration-controller.php"  method="post">';
      echo '<div>';
      echo ' <input type="hidden" name="account" value="Account">';
      echo ' <input class="navloggedIn" type="submit" name="account" value="Account">';
      echo '</div>';
      echo '</form>';
//      echo '<a class="navloggedIn" href="account.php"><i class="fa-solid fa-user-lock"></i> Account</a>';
      echo '<form action="login-registration-controller.php" class="signoutform" method="post">';
      echo '<div>';
      echo ' <input type="hidden" name="action" value="logout">';
      echo ' <input class="btn" type="submit" name="logout" value="Logout">';
      echo '</div>';
      echo '</form>';
      echo '</div>';
      //		unset($_SESSION[ 'loggedIn' ]);
    };
    if ( isset( $_SESSION[ 'logoutSuccess' ] ) ) {
      echo '<div class="">Logged Out</div>';
      unset( $_SESSION[ 'logoutSuccess' ] );
    };
    ?>
  </div>
</nav><div class="container3">
    <div class="content-2">
	  
           <div class="updateentrycontainer ">
                        <div class="entry-heading">
							<a href="blogentry.php"><i class="fa-sharp fa-solid fa-arrow-left"></i></a>
							<h3>Creating New Entry</h3>
						 </div>
							<form action="controlroom.php" class="entryupdate" method="post" autocomplete="off">
								<div class="buttonnav">
<!--
									<button class="btn3" id="submit" onclick="myFunction2()" name="previewNEWentry">Preview <i class="fa fa-eye" aria-hidden="true"></i>
</button>
-->
									<button class="btn3" id="submit" type="submit" name="draftentry" value="2">Draft <i class="fa-sharp fa-solid fa-floppy-disk"></i></button>
									
<!--									<button class="btn" type="submit" name="cancelnewentry">Cancel</button>-->
									<button class="btn2" type="submit" name="publishnewentry">Publish</button>
								</div>
								
								<input type="hidden" name="blogid" >
								<input type="hidden" name="entryid">
								<div class="groupnamedate">
									<div>
										<label for="bgname">Entry name</label>
										<input type="text" name="entname" placeholder="School is inevitable" required>
									</div>
									<div>
										<label for="bgdate">Date of Creation:</label>
										<input type="date" name="entdate" required>
									</div>
								</div>
								
								<label for="enttext">Description</label>
								<textarea name="enttext" placeholder="This is how it was made from the begining to the trinity...." required></textarea>
								
								
								
								
							</form>
                  </div>
    </div>
</div>
<script src="js/composeblog.js"></script>
	
</body>
</html>