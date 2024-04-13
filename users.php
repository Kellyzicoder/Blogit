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


$_SESSION[ 'allusers' ] = $obj->getallusers();
$_SESSION[ 'userinfo' ] = $obj->getuserinfo( $_SESSION[ 'userid' ] );
$usertype = $_SESSION[ 'userinfo' ][ 0 ][ 'usertype' ];

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
</nav>
<div class="container1">
  <section class="left-navigations">
    <button class="composeblog btn">COMPOSE TOPIC</button>
    <a href="homepage.php" ><i class="fa-solid fa-bars" ></i> My Topics</a> <a href="draft.php"><i class="fa-solid fa-bookmark"></i>Drafts</a> <a href="publish.php"><i class="fa-solid fa-circle-check"></i>Published</a><a href="users.php" class="current <?php if ($usertype == 1 ) { echo ' nodisplay';} ?>"><i class="fa-solid fa-user-lock"></i>Users</a> </section>
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
            <input type="date" name="bgdate">
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
        <h1>Adminstration</h1>
      </div>
      <?php
      if ( $_SESSION[ 'allusers' ] == false ) {
        echo ' 
        <div class="displayprojectnames">
             <p>There are no users currently created</p>
         </div> ';
      } else if ( $_SESSION[ 'allusers' ] ) {
        //                								print_r( $_SESSION['allusers'] );
        //                 exit();

        //		  $_SESSION[ 'blogdata' ] = $obj->getblogdata( $_SESSION[ 'userid' ] );
        //		  $lol = $_SESSION[ 'entry' ] = $obj->getentrydata( $_SESSION[ 'blogid' ] );
        //		  print_r($lol);


        foreach ( $_SESSION[ 'allusers' ] as $result ) {
          //          			print_r($result[ 'blogid' ]);
          //			$lol = $_SESSION[ 'entry' ] = $obj->getentrydata( $_SESSION[ 'blogid' ] );
          //			print_r($lol);

          // This is operation to show if the user is an Admin or a normal user. This depends on their usertype
          if ( $result[ 'usertype' ] == 2 ) {
            $usertype = 'An Admin';
          } else {
            $usertype = 'A Normal User';
          }


          // This is used to check the time when the user last logged in
          $time = 'Unknown';
          if ( $result[ 'online' ] > 0 ) {
            $online = $result[ 'online' ];
            $time = $obj->gettime( date( "Y-m-d H:i:s", $online ) );
          }
          if ( $result[ 'userid' ] !== $_SESSION[ 'userid' ] ) {

            echo '<div>
		  
		  
			<div class="displayblogdetails">
			  <form  action="controlroom.php"  method="post">
				<input type="hidden" name="userid" value="' . $result[ 'userid' ] . '">
				<input type="text" class="inputname" name="firstname" value="' . $result[ 'firstname' ] . ' ' . $result[ 'lastname' ] . '" readonly>
				<input type="text" class="userdate" value="Signed Up: ' . date_format( new DateTime( $result[ 'userdate' ] ), "M j, Y" ) . '" readonly>		
				<input type="text" class="inputstatus" value="Active: ' . $time . '" readonly>	
				<input type="text" class="usertype" value="Description: ' . $usertype . '" readonly>
			  </form>
			  <form action="controlroom.php" method="post">
				<input type="hidden" name="userid" value="' . $result[ 'userid' ] . '">
				<input title="edit this user - this allows you to put the source in as a hover effect" type="image" src="images/edit.png" name="edituser" value="Edit">
			  </form>
			  <form action="controlroom.php" method="post">
				<input type="hidden" name="userid" value="' . $result[ 'userid' ] . '">
				<input title="delete this user - icon hapus PNG image with transparent background@toppng.com" type="image" src="images/delete-16.png" name="deleteuser" value="Delete">
			  </form>
			</div> 
			</div>';
            if ( isset( $_SESSION[ 'deleting-user' ] ) ) {
              //                                              print( "Yes deleting this user" );
              //                                              exit();

              if ( ( $_SESSION[ 'userid_otheruser' ] == $result[ "userid" ] ) ) {
                echo '
                                  <div class="deletingblog">
									  <div class="deletingblogcontent">
										  <div>
											  <form action="controlroom.php" method="post" autocomplete="off">
											  <input type="hidden" name="userid" value="' . $result[ 'userid' ] . '">
												<h3>Are you sure you want to delete this user?</h3>
												<div class="doublebuttons">
												<button class="btn4" id="submit" type="submit" name="confirm-delete-user">Confirm delete</button>
												<button class="btn" type="submit" name="canceldeleteuser">No, cancel</button>
												</div>
											   </form>
										   </div>
										</div>
                            		</div>';

              }
            }
            if ( isset( $_SESSION[ 'editing-users' ] ) ) {
              //                                                print( "Yes editing this user" );
              //                                                exit();


              if ( ( $_SESSION[ 'useridotheruser' ] == $result[ "userid" ] ) ) {

                if ( isset( $_SESSION[ 'duplicateemail' ] ) ) {
                  $_SESSION[ 'redborder' ] = ' active';
                } else {
                  $_SESSION[ 'redborder' ] = '';
                }
                echo '<div class="updateblogcontainer">
                        <div class="blog-heading">
							<h3>Editing User</h3>
						 </div>
							<form action="controlroom.php" class="blogupdate" method="post" autocomplete="off">
								<input type="hidden" name="userid" value="' . $result[ 'userid' ] . '">
								<div class="groupnamedate">
									<div>
										<label for="firstname">First name</label>
										<input type="text" name="firstname" value="' . $result[ 'firstname' ] . '" required>
										<label for="lastname">Last name</label>
										<input type="text" name="lastname" value="' . $result[ 'lastname' ] . '" required>
										<label for="email">Email</label>
										<input type="text" class="' . $_SESSION[ 'redborder' ] . '" name="email" value="' . $result[ 'email' ] . '" required>
									</div>
								</div>
													<fieldset class="status-type">
						<legend>User Type</legend>
							<span class="radio-item">
								<label for="1">A Normal User</label>
								<input type="radio" id="1" name="status" value="1" ' . ( $result[ 'usertype' ] == 1 ? 'checked=checked' : '' ) . '>
							</span>
							<span class="radio-item">
								<label for="2">An Admin</label>
								<input type="radio" id="2" name="status" value="2" ' . ( $result[ 'usertype' ] == 2 ? 'checked=checked' : '' ) . '>
								</span>
						</fieldset>
						<button class="btn" name="changepasswordotheruser" type="click">Click to change Password</button>
								<div class="doublebuttons">
									<button class="btn" type="submit" name="updateuser">Update User Info</button>
									<button class="btn" type="submit" name="cancelupdateuser">Cancel</button>
								</div>
							</form>
                  </div>'


                ;
              }


            }

            if ( isset( $_SESSION[ 'changepassword2' ] ) ) {

              if ( ( $_SESSION[ 'otheruserid' ] == $result[ "userid" ] ) ) {
                //	print('heree');
                //	exit();
                echo '
	<div class="bgmodalpassword">
    <div class="modalcontentpassword">
      <h3>Change Password</h3>
      <form action="controlroom.php" method="post">
	  <input type="hidden" name="userid" value="' . $result[ 'userid' ] . '">
	  
	  <div>
	  	<label for="newpassword">New Password</label>
        <input type="password" placeholder="Enter new password" class="password'.(isset($_SESSION['new'])? ' active':'').'" name="newpassword">
	</div>
	<div>
		<label for="confirmnewpassword">Confirm Password</label>
        <input type="password" placeholder="Confirm new password" class="password'.(isset($_SESSION['new'])? ' active':'').'" name="confirmnewpassword">
	</div>
	'. (isset($_SESSION['passwordmatch-error'])? '<div class="inputerror">Passwords do not match. Please try again</div>':'').'
	'. (isset($_SESSION['passwordsmall-error'])? '<div class="inputerror">Password must be more than 8 characters</div>':'').'
	'. (isset($_SESSION[ 'passwordnull' ])? '<div class="inputerror">Password field cannot be left empty</div>':'').'
	<br>
	
	
     <div class="doublebuttons">
		  <button class="btn" id="submit" type="submit" name="updatepassword">Update Password</button>
		  <button class="btn" type="submit" name="cancelchangepassword">Cancel</button>
     </div>
      </form>
    </div>
  </div>';
              }
            }
          }


        }
      }

      ?>
    </div>
  </section>
</div>
<script src="js/composeblog.js"></script> 
<script src="js/alertnotify.js"></script> 
</body>
</html>