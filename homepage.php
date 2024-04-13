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
$_SESSION[ 'userinfo' ] = $obj->getuserinfo( $_SESSION[ 'userid' ] );
$usertype = $_SESSION[ 'userinfo' ][ 0 ][ 'usertype' ];
//print($_SESSION[ 'userid' ]);
//exit();


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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer">
<link rel="stylesheet" href="css/style.css">
<link rel="preconnect" href="https://fonts.googleapisa.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
</head>
</head>

<body>
<!--	<button>Show Alert</button>-->
<?php
//	if (isset($_SESSION['blogsucess'])) {
//		echo'
//<div class="alert show">
//         <span class="fas fa-exclamation-circle"></span>
//         <span class="msg">Blog Successfully updated</span>
//         <div class="close-btn">
//            <span class="fas fa-times"></span>
//         </div>
//	
//	</div>';
//		
//		
//		
//	} unset($_SESSION['blogsuccess'])
//	
//      
?>
<nav id="navbar">
  <div class="nav-logo">
    <h1>BLOG<span class="text-primary">it.</span></h1>
  </div>
  <div id="nav-menu"> <a href="community.php">Community</a> <a class="<?php if ( isset( $_SESSION[ 'loggedIn' ] ) ) {echo" nodisplay"; } ?>" href="login">Login</a> <a class="navsignup <?php if ( isset( $_SESSION[ 'loggedIn' ] ) ) {echo" nodisplay"; } ?>" href="#contact">Blogs</a>
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
<div class="container1">
  <section class="left-navigations">
    <button class="composeblog btn">COMPOSE TOPIC</button>
    <a href="homepage.php" class="current"><i class="fa-solid fa-bars" ></i> My Topics</a> <a href="draft.php"><i class="fa-solid fa-bookmark"></i> Drafts</a> <a href="publish.php"><i class="fa-solid fa-circle-check"></i> Published</a><a href="users.php" class="<?php if ($usertype == 1 ) { echo ' nodisplay';} ?>"><i class="fa-solid fa-user-lock"></i> Users</a> </section>
  <div class="bg-modal no-modal">
    <div class="modal-content">
      <h3>Compose Topic</h3>
      <form action="controlroom.php" class="addblog" method="post">
        <div class="groupnamedate">
          <div>
            <label for="bgname">Topic Name</label>
            <input type="text" name="bgname" placeholder="Houses in New Zealand" required>
          </div>
          <div>
            <label for="bgdate">Date</label>
            <input type="date" name="bgdate" required>
          </div>
        </div>
        <label for="bgdescript">Description</label>
        <textarea type="text" name="bgdescript"></textarea>
        <div class="doublebuttons">
          <button class="btn" id="submit" type="submit" name="newblog">Create Topic</button>
          <button class="cancelnewblog btn" id="submit" type="submit" name="cancelnewblog">Cancel</button>
        </div>
      </form>
    </div>
  </div>
  <section class="main-content">
    <?php
    if ( isset( $_SESSION[ 'blogsuccess' ] ) ) {

      echo '
	  <div class="topentsuccess autovanish">
	  	<p> ' . $_SESSION[ 'blogsuccess' ] . '</p>
	  </div>';
    }
    unset( $_SESSION[ 'blogsuccess' ] );
    if ( isset( $_SESSION[ 'blogerror' ] ) ) {

      echo '
	  <div class="topenterror autovanish">
	  	<p>' . $_SESSION[ 'blogerror' ] . '</p>
	  </div>';
    }
    unset( $_SESSION[ 'blogerror' ] );
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
    <div class="content">
      <div class="name">
        <h1>Welcome,
          <?php
          $username = $_SESSION[ 'userinfo' ][ 0 ][ 'firstname' ] . " " . $_SESSION[ 'userinfo' ][ 0 ][ 'lastname' ];
          echo $username;
          ?>
        </h1>
      </div>
      <?php
      if ( $_SESSION[ 'blogdata' ] == false ) {
        echo ' 
		<div class="noblogentry">
        <div>
             <p>There are no topics currently created</p>
         </div> 
		 </div>';
      } else if ( isset( $_SESSION[ 'blogdata' ] ) ) {
        //        								print_r( $_SESSION[ 'blogdata'] );
        //         exit();
        foreach ( $_SESSION[ 'blogdata' ] as $result ) {
          //			print_r($result[ 'blogid' ]);
          echo '<div>
			<div class="displayblogdetails">
			  <form  action="controlroom.php"  method="post">
				<input type="hidden" name="blogid" value="' . $result[ 'blogid' ] . '">
				<input type="text" class="inputname" value="' . $result[ 'bgname' ] . '" readonly>
				<input type="text" class="inputdescript"  value="' . $result[ 'bgdescript' ] . '" readonly>
				<input type="text" class="inputdate" value="' . date_format( new DateTime( $result[ 'bgdate' ] ), "M j, Y" ) . '" readonly>
			  </form>
			  <form action="controlroom.php" method="post">
				<input type="hidden" name="blogid" value="' . $result[ 'blogid' ] . '">
				<input title="edit this blog - this allows you to put the source in as a hover effect" type="image" src="images/edit.png" name="editblog" class="editblog" value="Edit">
			  </form>
			  <form action="controlroom.php" method="post">
				<input type="hidden" name="blogid" value="' . $result[ 'blogid' ] . '">
				<input title="delete this blog - icon hapus PNG image with transparent background@toppng.com" type="image" src="images/delete-16.png" name="deleteblog" value="Delete">
			  </form>
			  <form action="controlroom.php" method="post">
				<input type="hidden" name="blogid" value="' . $result[ 'blogid' ] . '">
				<input type="submit" name="blog-request" class="btn" value="View Entries">
			  </form>
			</div> ';
          if ( isset( $_SESSION[ 'deleting-blog' ] ) ) {
            //                                              print( "Yes deleting this blog" );
            //                                              exit();

            if ( ( $_SESSION[ 'blogid' ] == $result[ "blogid" ] ) ) {
              echo '
                                  <div class="deletingblog">
									  <div class="deletingblogcontent">
										  <div>
											  <form action="controlroom.php" method="post" autocomplete="off">
												<input type="hidden" name="blogid" value="' . $_SESSION[ 'blogid' ] . ' ">
												<h3>Are you sure you want to delete this topic?</h3>
												<div class="doublebuttons">
												<button class="btn4" id="submit" type="submit" name="confirm-delete-blog">Confirm delete</button>
												<button class="btn" type="submit" name="canceldeleteblog">No, cancel</button>
												</div>
											   </form>
										   </div>
										</div>
                            		</div>';

            }
          }
          if ( isset( $_SESSION[ 'editing-blog' ] ) ) {
            //                                    print( "Yes editing this blog" );
            //                                    exit();

            if ( ( $_SESSION[ 'blogid' ] == $result[ "blogid" ] ) ) {
              echo '<div class="updateblogcontainer">
                        <div class="blog-heading">
							<h3>Editing Topic</h3>
						 </div>
							<form action="controlroom.php" class="blogupdate" method="post" autocomplete="off">
								<input type="hidden" name="blogid" value="' . $result[ 'blogid' ] . '">
								<div class="groupnamedate">
									<div>
										<label for="bgname">Topic name</label>
										<input type="text" name="bgname" value="' . $result[ 'bgname' ] . '" required>
									</div>
									<div>
										<label for="bgdate">Date of Creation:</label>
										<input type="date" name="bgdate" value="' . $result[ 'bgdate' ] . '">
									</div>
								</div>
								
								<label for="bgdescript">Description</label>
								<textarea name="bgdescript">' . $result[ 'bgdescript' ] . '</textarea>
								
								<div class="doublebuttons">
									<button class="btn" id="submit" type="submit" name="updateblog">Update Topic</button>
									<button class="btn" type="submit" name="cancelupdateblog">Cancel</button>
								</div>
							</form>
                  </div>';
            }
          }
        }
      }
      //      		}
      //      	  }

      ?>
    </div>
  </section>
</div>
<script src="js/alertnotify.js"></script>
<script src="js/composeblog.js"></script>
</body>
</html>