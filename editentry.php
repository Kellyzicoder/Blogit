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
//$username = $obj->getusername( $_SESSION[ 'userid' ] );

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
<title>Editing Blog | BLOGit</title>
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
  <div id="nav-menu"> <a href="community.php">Community</a> <a href="homepage.php">Home</a><a class="<?php if ( isset( $_SESSION[ 'loggedIn' ] ) ) {echo" nodisplay"; } ?>" href="login">Login</a> <a class="navsignup <?php if ( isset( $_SESSION[ 'loggedIn' ] ) ) {echo" nodisplay"; } ?>" href="#contact">Blogs</a>
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
//      echo '<div class="">Logged Out</div>';
      unset( $_SESSION[ 'logoutSuccess' ] );
    };
    ?>
  </div>
</nav>
<div class="container3"> 
  
  <!--
	  <div class="header">
	  	<a><i class="fa-solid fa-bars" ></i>Blogs</a>
		<a><i class="fa-solid fa-bars" ></i>Entrys</a>
	  </div>
-->
  
  <div class="content-2"> 
    <!--
      <div class="header">
        <h1>Entry <?php echo '<div class="blogname">' . $_SESSION[ 'blog-name-info' ][0]['bgname'] . '</div>' ?></h1>
      </div>
-->
    <?php
	
	// This is used to edit the Entries under the Blog tab
    if ( isset( $_SESSION[ 'editing-entry' ] ) ) {
      //                                                print( "Yes editing this entry" );
      //                                                exit();
//unset( $_SESSION[ 'editing-draftentry' ] );
//        unset( $_SESSION[ 'editing-publishentry' ] );
		
      $thisentrydata = $obj->getsingleentrydata( $_SESSION[ 'entryid' ] );
      //			  print_r($thisentrydata);
      //			  exit();
      //			  if ( ($_SESSION['entryid']) ) {
      foreach ( $thisentrydata as $result ) {
        
        echo '<div class="updateentrycontainer">
                        <div class="entry-heading">
						<a href="blogentry.php"><i class="fa-sharp fa-solid fa-arrow-left"></i></a>
							<h3>Editing Entry</h3>
						 </div>
						 
							<form action="controlroom.php" class="entryupdate" method="post" autocomplete="off">
								<div class="buttonnav">

									<button class="btn3" id="submit" type="submit" name="draftentry" >Draft <i class="fa-sharp fa-solid fa-floppy-disk"></i></button>
									
<button class="btn" id="submit" type="submit" name="updateentry">Update Entry</button>
									<button class="btn2" type="submit" name="publishnewentry">Publish</button>
									
								</div>
								
								<input type="hidden" name="blogid" value="' . $result[ 'blogid' ] . '">
								<input type="hidden" name="entryid" value="' . $result[ 'entryid' ] . '">
								<input type="hidden" name="statusid" value="' . $result[ 'statusid' ] . '">
								<div class="groupnamedate">
									<div>
										<label for="bgname">Topic Name</label>
										<input type="text" name="entname" value="' . $result[ 'entname' ] . '" required>
									</div>
									<div>
										<label for="bgdate">Date of Creation:</label>
										<input type="date" name="entdate" value="' . $result[ 'entdate' ] . '">
									</div>
								</div>
								
								<label for="enttext">Description</label>
								<textarea name="enttext">' . $result[ 'enttext' ] . '</textarea>
								
					
							</form>
                  </div>';
      }
    } // This is used to edit the Entries under the Draft tab

else if ( isset( $_SESSION[ 'editing-draftentry' ] ) ) {
//      unset( $_SESSION[ 'editing-entry' ] );
//      unset( $_SESSION[ 'editing-publishentry' ] );
      //                                                print( "Yes editing this draft entry" );
      //                                                exit();

      $thisentrydata = $obj->getsingleentrydata( $_SESSION[ 'entryid' ] );
      //			  print_r($thisentrydata);
      //			  exit();
      //			  if ( ($_SESSION['entryid']) ) {
      foreach ( $thisentrydata as $result ) {
        //		  print($result['statusid']);
        echo '<div class="updateentrycontainer">
                        <div class="entry-heading">
						<a href="draft.php"><i class="fa-sharp fa-solid fa-arrow-left"></i></a>
							<h3>Editing Entry</h3>
						 </div>
						 
							<form action="controlroom.php" class="entryupdate" method="post" autocomplete="off">
								<div class="buttonnav">
								
									
									<button class="btn" id="submit" type="submit" name="updatedraftentry">Update Draft</button>
									<button class="btn2" type="submit" name="publishentry">Publish</button>
									
								</div>
								
								<input type="hidden" name="blogid" value="' . $result[ 'blogid' ] . '">
								<input type="hidden" name="entryid" value="' . $result[ 'entryid' ] . '">
								<input type="hidden" name="statusid" value="' . $result[ 'statusid' ] . '">
								<div class="groupnamedate">
									<div>
										<label for="bgname">Topic Name</label>
										<input type="text" name="entname" value="' . $result[ 'entname' ] . '" required>
									</div>
									<div>
										<label for="bgdate">Date of Creation:</label>
										<input type="date" name="entdate" value="' . $result[ 'entdate' ] . '">
									</div>
								</div>
								
								<label for="enttext">Description</label>
								<textarea name="enttext">' . $result[ 'enttext' ] . '</textarea>
								
					
							</form>
                  </div>';
      }
    }
    // This is used to edit the Entries under the Published tab
    else if ( isset( $_SESSION[ 'editing-publishentry' ] ) ) {
//      unset( $_SESSION[ 'editing-entry' ] );
//      unset( $_SESSION[ 'editing-draftentry' ] );
//                                                      print( "Yes editing this Published entry" );
//                                                      exit();

      $thisentrydata = $obj->getsingleentrydata( $_SESSION[ 'entryid' ] );
      //			  print_r($thisentrydata);
      //			  exit();
      //			  if ( ($_SESSION['entryid']) ) {
      foreach ( $thisentrydata as $result ) {
        //		  print($result['statusid']);
        echo '<div class="updateentrycontainer">
                        <div class="entry-heading">
						<a href="publish.php"><i class="fa-sharp fa-solid fa-arrow-left"></i></a>
							<h3>Editing Entry</h3>
						 </div>
						 
							<form action="controlroom.php" class="entryupdate" method="post" autocomplete="off">
								<div class="buttonnav">
								
									<button class="btn" id="submit" type="submit" name="updatepublishentry">Update Entry</button>
									<button class="btn3" id="submit" type="submit" name="pdraftentry">Draft <i class="fa-sharp fa-solid fa-floppy-disk"></i></button>
									
									
									
								</div>
								
								<input type="hidden" name="blogid" value="' . $result[ 'blogid' ] . '">
								<input type="hidden" name="entryid" value="' . $result[ 'entryid' ] . '">
								<input type="hidden" name="statusid" value="' . $result[ 'statusid' ] . '">
								<div class="groupnamedate">
									<div>
										<label for="entname">Topic Name</label>
										<input type="text" name="entname" value="' . $result[ 'entname' ] . '" required>
									</div>
									<div>
										<label for="entdate">Date of Creation:</label>
										<input type="date" name="entdate" value="' . $result[ 'entdate' ] . '">
									</div>
								</div>
								
								<label for="enttext">Description</label>
								<textarea name="enttext">' . $result[ 'enttext' ] . '</textarea>
								
					
							</form>
                  </div>';
      }
    }


    ?>
  </div>
</div>
</body>
</html>