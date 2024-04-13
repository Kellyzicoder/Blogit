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
$_SESSION['userinfo'] = $obj->getuserinfo( $_SESSION[ 'userid' ] );
$usertype = $_SESSION['userinfo'][ 0 ][ 'usertype' ];
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
<title>Entries | Blogit.</title>
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
</nav><div class="container1">
  <section class="left-navigations">
    <button class="composeblog btn">COMPOSE TOPIC</button>
    <a href="homepage.php" class="current"><i class="fa-solid fa-bars" ></i> My Topics</a> <a href="draft.php"><i class="fa-solid fa-bookmark"></i> Drafts</a> <a href="publish.php"><i class="fa-solid fa-circle-check"></i> Published</a> <a href="users.php" class="<?php if ($usertype == 1 ) { echo ' nodisplay';} ?>"><i class="fa-solid fa-user-lock"></i> Users</a></section>
  <div class="bg-modal no-modal">
    <div class="modal-content">
      <h3>Compose Topic</h3>
      <form action="controlroom.php" class="addblog" method="post">
        <div class="groupnamedate">
          <div>
            <label for="">Topic Name</label>
            <input type="text" name="bgname" placeholder="Houses in New Zealand" required>
          </div>
          <div>
            <label for="">Date</label>
            <input type="date" name="bgdate" required>
          </div>
        </div>
        <label for="">Description</label>
        <textarea type="text" name="bgdescript"></textarea>
        <div class="doublebuttons">
          <button class="btn" id="submit" type="submit" name="newblog">Create Topic</button>
          <button class="cancelnewblog btn4" id="submit" type="submit" name="cancelnewblog">Cancel</button>
        </div>
      </form>
    </div>
  </div>
  <section class="main-content"> 
	  <?php 
	if(isset($_SESSION[ 'blogsuccess'])) {
		
	echo '
	  <div class="topentsuccess autovanish">
	  	<p> '. $_SESSION[ 'blogsuccess'] .'</p>
	  </div>';
}	unset($_SESSION['blogsuccess']);
	  if(isset($_SESSION[ 'blogerror'])) {
		
	echo '
	  <div class="topenterror autovanish">
	  	<p>'. $_SESSION[ 'blogerror'] .'</p>
	  </div>';
} unset($_SESSION['blogerror']);

	  
	  
	  ?>

    <div class="content">
      <div class="name">
        <h1>Entry <?php echo '<div class="blogname2">' . $_SESSION[ 'blog-name-info' ][0]['bgname'] . '</div>' ?></h1>
      </div>
      <?php
		if ( isset($_SESSION['blog-entry-data']) && ($_SESSION['blog-entry-data'])) {
			


			foreach ( $_SESSION[ 'blog-entry-data' ] as $result1 ) {
//				$_SESSION['entryid'] = $result1[ 'entryid' ];
//          			print_r($result1[ 'entryid' ]);
//				exit();
				
//				if ( $result1['statusid'] == 1 ) {
          echo '<div>
			<div class="displayentrydetails">
			  <form action="controlroom.php"  method="post">
				<input type="hidden" name="entryid" value="' . $result1[ 'entryid' ] . '">
				<input class="entname"  value="' . $result1[ 'entname' ] . '">
				<input class="enttext" value="' . $result1[ 'enttext' ] . '">
				<input class="entdate" value="'. date_format( new DateTime( $result1[ 'entdate' ] ), "M j, Y" ) . '">
			  </form>
			  <form action="controlroom.php" method="post">
				<input type="hidden" name="entryid" value="' . $result1[ 'entryid' ] . '">
				<input title="edit this blog - this allows you to put the source in as a hover effect" type="image" src="images/edit.png" name="edit" class="editentry" value="Edit">
			  </form>
			  <form action="controlroom.php" method="post">
				<input type="hidden" name="blogid" value="' . $result1[ 'blogid' ] . '">
				<input type="hidden" name="entryid" value="' . $result1[ 'entryid' ] . '">
				<input title="delete this blog - icon hapus PNG image with transparent background@toppng.com" type="image" src="images/delete-16.png" name="delete" value="Delete">
			  </form>
			  <form action="controlroom.php" method="post">
			  	<input type="hidden" name="blogid" value="' . $result1[ 'blogid' ] . '">
				<input type="hidden" name="entryid" value="' . $result1['entryid'] . '">
				<input class="btn" id="submit" name="previewblogentry" type="submit" value="Preview">
			  </form>
			</div> 
			</div>';
			
			
          if ( isset( $_SESSION[ 'deleting-entry' ] ) ) {
            //                                              print( "Yes deleting this blog" );
            //                                              exit();

            if ( ( $_SESSION[ 'entryid' ] == $result1[ "entryid" ] ) ) {
              echo '
                                  <div class="deletingblog">
									  <div class="deletingblogcontent">
										  <div>
											  <form action="controlroom.php" method="post" autocomplete="off">
												<input type="hidden" name="blogid" value="' . $_SESSION[ 'blogid' ] . ' ">
												<input type="hidden" name="entryid" value="' . $_SESSION[ 'entryid' ] . ' ">
												<h3>Are you sure you want to delete this entry?</h3>
												<div class="doublebuttons">
												<button class="btn" id="submit" type="submit" name="deleteentry">Confirm delete</button>
												<button class="btn4" type="submit" name="canceldeleteentry">No, cancel</button>
												</div>
											   </form>
										   </div>
										</div>
                            		</div>';

            }
          }
          }
				
        }
			
			
			if ( isset( $_SESSION['blog-entry-data'] ) && ( !$_SESSION['blog-entry-data'] ) ) {
        echo ' 
		<div class="noblogentry">
        <div>
             <p>There are no entries currently created</p>
         </div> 
		 </div>';
			
      }

			
			
      ?>
		
	<div id="add-entry">
		<a href="newentry.php" ><span class="btn" >+ Add Entry</span></a>
		</div>
    </div>
  </section>
</div>
<script src="js/composeblog.js"></script>
	<script src="js/alertnotify.js"></script>
</body>
</html>