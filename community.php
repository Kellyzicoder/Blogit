<?php
if ( !isset( $_SESSION ) ) {
  session_start();
}

spl_autoload_register( function ( $class ) {
  include_once( 'dtb.php' );
} );

$obj = new dtb_blog;


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
  <div id="nav-menu"><a href="homepage.php">Home</a><a class="btn<?php if ( isset( $_SESSION[ 'loggedIn' ] ) ) {echo" nodisplay"; } ?>" href="login.php">Login Now</a><a class="btn<?php if ( isset( $_SESSION[ 'loggedIn' ] ) ) {echo" nodisplay"; } ?>" href="registration.php">Signup Now</a> <a class="navsignup <?php if ( isset( $_SESSION[ 'loggedIn' ] ) ) {echo" nodisplay"; } ?>" href="#contact"></a> 
    <?php
    if ( isset( $_SESSION[ 'loggedIn' ] ) ) {
      echo '<div class="LogInOut">';
		echo '<form action="login-registration-controller.php"  method="post">';
      echo '<div>';
      echo ' <input type="hidden" name="account" value="Account">';
      echo ' <input class="navloggedIn" type="submit" name="account" value="Account">';
      echo '</div>';
      echo '</form>';
//      echo '<a class="navloggedIn" href="account.php"><i class="fa-solid fa-user-lock"></i> Account</a>'
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
//      echo '<div class="">Logged Out</div>';
      unset( $_SESSION[ 'logoutSuccess' ] );
    };
    ?>
	  
<!--
	      <form action="login-registration-controller.php" method="post">
      <input class="btn" type="submit" name="signupnow" value="Signup Now">
    </form>
-->
	  
  </div>
</nav>
	<div class="container3">
<!--
    <div class="searchcontent">
      <form action="controller.php" class="searchform" class="addproject" method="post">
      <input type="search" placeholder="What are you looking for?">
      <button type="submit" class="search-button"><i class="fa-solid fa-magnifying-glass"></i></button>
      </form>
    </div>
  </section>
-->
  <section class="publishedinfo">
    <div class="container2">
        <?php

        $_SESSION[ 'publishentrydata' ] = $obj->getpublishdata2();
		if ( isset($_SESSION[ 'publishentrydata' ]) && ($_SESSION[ 'publishentrydata' ])) {
		  
        //print_r($publisheddata);

          foreach ( $_SESSION[ 'publishentrydata' ] as $result1 ) {
            //          			print_r($result[ 'blogid' ]);
            echo'
			<div class="displaypublishdetails">
				<div class="publishedheader">
					<div class="topicname">
						<h3 class="blogname"> ' . $result1[ 'bgname' ] . '</h3>
						<i class="fa-solid fa-circle"></i>
						<h3 class="entryname">'. $result1[ 'entname' ] . '</h3>
					</div>

					<div class="authordate">
						<p class="authorname"> @'. $result1[ 'firstname' ]. ' '. $result1[ 'lastname' ].'</p>
						<p class="publisheddate">'. $result1[ 'entdate' ]. '</p>
					</div>
			  	</div>
				
				<div class="publishedinfo">
				'. $result1[ 'enttext' ] .'
				
				</div>
			  </div>';

          }
        }
		
//		if ( isset( $_SESSION[ 'publishentrydata' ] ) && ( !$_SESSION[ 'publishentrydata' ] ) ) {
		if ( isset( $_SESSION[ 'publishentrydata' ] ) && ( !$_SESSION[ 'publishentrydata' ] ) ) {
        echo ' 
		<div class="noblogentry">
        <div>
             <p>There are no entries currently published</p>
         </div> 
		 </div>';
			
      }
        ?>
		
      </div>
	  </section>
    </div>
  
<!--</div>-->
<?php

?>
</div>
</body>
</html>