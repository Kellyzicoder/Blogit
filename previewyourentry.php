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
}

$_SESSION[ 'blogdata' ] = $obj->getblogdata( $_SESSION[ 'userid' ] );
$username = $obj->getuserinfo( $_SESSION[ 'userid' ] );


//print_r($_SESSION[ 'blogdata' ]);
//exit();

 $_SESSION[ 'blog-entry-data' ] = $obj->getentrydata( $_SESSION[ 'blogid' ] );
//print_r( $_SESSION[ 'blog-entry-data' ]);
//exit();


?>


<!doctype html>
<html>
	
<head>
<meta charset="utf-8">
<title>Preview | Blogit.</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="css/style.css">
<link rel="preconnect" href="https://fonts.googleapisa.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
</head>
</head>

<body>
	
  <section class="publishedinfo">
    <div class="container4">
		<?php
		
        
	$username = $username[0]['firstname'] .' '. $username[0]['lastname'];

//		if (isset( $_SESSION[ 'blog-entry-data' ])) {
			
//		    print_r($_SESSION[ 'blog-entry-data' ]);
//			exit();
//			$entryid = $_SESSION[ 'blog-entry-data' ]['entryid'] ;
//			print($entryid);
//				exit();
				if (isset( $_SESSION['previewpublishentry'] )) {

					echo '
		<div class="name">
			<a href="publish.php"><i class="fa-sharp fa-solid fa-arrow-left"></i></a>
        <h1>Preview</h1>
      </div>';
//						if ($entryid == $_SESSION['entryid']) {											
			foreach( $_SESSION[ 'blog-entry-data' ] as $result1 ) {
//				print($result1['entryid'] . 'loll');
//				print($_SESSION['entryid'] . 'hereee');
//				exit();
				if ($result1['entryid'] == $_SESSION['entryid']) {	
            echo'
			<div class="displaypreviewdetails">
				<div class="publishedheader">
					<div class="topicname">
						<h3 class="blogname"> '  . $result1['bgname'] . '</h3>
						<i class="fa-solid fa-circle"></i>
						<h3 class="entryname">'. $result1['entname'] . '</h3>
					</div>

					<div class="authordate">
						<p class="authorname"> @'.$username.'</p>
						<p class="publisheddate">'.  $result1['entdate']. '</p>
					</div>
			  	</div>
				
				<div class="previewinfo">
				'. $result1['enttext'] .
				'</div>
			  </div>
				<div>';
//					exit();
		}
			}
			
		} else if (isset( $_SESSION['previewdraftentry'] )) {

					echo '
		<div class="name">
			<a href="draft.php"><i class="fa-sharp fa-solid fa-arrow-left"></i></a>
        <h1>Preview</h1>
      </div>';
//						if ($entryid == $_SESSION['entryid']) {											
			foreach( $_SESSION[ 'blog-entry-data' ] as $result1 ) {
//				print($result1['entryid'] . 'loll');
//				print($_SESSION['entryid'] . 'hereee');
//				exit();
				if ($result1['entryid'] == $_SESSION['entryid']) {	
            echo'
			<div class="displaypreviewdetails">
				<div class="publishedheader">
					<div class="topicname">
						<h3 class="blogname"> '  . $result1['bgname'] . '</h3>
						<i class="fa-solid fa-circle"></i>
						<h3 class="entryname">'. $result1['entname'] . '</h3>
					</div>

					<div class="authordate">
						<p class="authorname"> @'.$username.'</p>
						<p class="publisheddate">'.  $result1['entdate']. '</p>
					</div>
			  	</div>
				
				<div class="previewinfo">
				'. $result1['enttext'] .
				'</div>
			  </div>
				<div>';
//					exit();
		}
			}
			
		}else if (isset( $_SESSION['previewblogentry'] )) {

					echo '
		<div class="name">
			<a href="blogentry.php"><i class="fa-sharp fa-solid fa-arrow-left"></i></a>
        <h1>Preview</h1>
      </div>';
//						if ($entryid == $_SESSION['entryid']) {											
			foreach( $_SESSION[ 'blog-entry-data' ] as $result1 ) {
//				print($result1['entryid'] . 'loll');
//				print($_SESSION['entryid'] . 'hereee');
//				exit();
				if ($result1['entryid'] == $_SESSION['entryid']) {	
            echo'
			<div class="displaypreviewdetails">
				<div class="publishedheader">
					<div class="topicname">
						<h3 class="blogname"> '  . $result1['bgname'] . '</h3>
						<i class="fa-solid fa-circle"></i>
						<h3 class="entryname">'. $result1['entname'] . '</h3>
					</div>

					<div class="authordate">
						<p class="authorname"> @'.$username.'</p>
						<p class="publisheddate">'.  $result1['entdate']. '</p>
					</div>
			  	</div>
				
				<div class="previewinfo">
				'. $result1['enttext'] .
				'</div>
			  </div>
				<div>';
//					exit();
		}
			}
			
		} else if (isset( $_SESSION['previewentry'] )) {

//					 $_SESSION[ 'blog-entry-data' ] = $obj->getentrydata( $_SESSION[ 'blogid' ] );
					echo '
		<div class="name">
			<a href="editentry.php"><i class="fa-sharp fa-solid fa-arrow-left"></i></a>
        <h1>Preview</h1>
      </div>';
//						if ($entryid == $_SESSION['entryid']) {											
			foreach( $_SESSION[ 'blog-entry-data' ] as $result1 ) {
//				print($result1['entryid'] . 'loll');
//				print($_SESSION['entryid'] . 'hereee');
//				exit();
				if ($result1['entryid'] == $_SESSION['entryid']) {	
            echo'
			<div class="displaypreviewdetails">
				<div class="publishedheader">
					<div class="topicname">
						<h3 class="blogname"> '  . $result1['bgname'] . '</h3>
						<i class="fa-solid fa-circle"></i>
						<h3 class="entryname">'. $result1['entname'] . '</h3>
					</div>

					<div class="authordate">
						<p class="authorname"> @'.$username.'</p>
						<p class="publisheddate">'.  $result1['entdate']. '</p>
					</div>
			  	</div>
				
				<div class="previewinfo">
				'. $result1['enttext'] .
				'</div>
			  </div>
				<div>';
//					exit();
		}
			}
			
		}	
		else {
					header('location:homepage.php');
				}
//		}
	
        ?>
      </div>

  </section>

</div>
</body>
</html>