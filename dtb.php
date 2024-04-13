<?php
class dtb_blog {


  //     Credentials used to connect to the school server
//        private $host = "kelvinmensah.student.liston.school.nz";
//        private $user = "kelvinme_ITadmin";
//        private $dtb = "kelvinme_blog";
//        private $pass = "Liston2022";

  //Credentials used to connect to my local server on my laptop
  private $host = "localhost";
  private $user = "root";
  private $dtb = "kelvinme_blog";
  private $pass = "";

  private $conn;

	// This is used to connect to the database 
  public function __construct() {
    try {
      $this->conn = new PDO( "mysql:host=" . $this->host . ";dbname=" . $this->dtb, $this->user, $this->pass );
      //             print( "connected" );
      //             exit();
    } catch ( PDOException $e ) {
      print( 'Unable to connect to the database server.' );
      exit();
    }
  }

  //Checking data from a form and returning it in secure format
  public function testinput( $data ) {
    $data = htmlspecialchars( $data, ENT_QUOTES, 'UTF-8' );
    $data = trim( $data );
    $data = stripslashes( $data );
    return $data;
  }

  // This is used to insert a new blog into the database. 
  public function insertblogdata( $bgname, $bgdescript, $bgdate, $userid ) {
    //		print("Blog Name: ". $bgname . "</br>");
    //		print("Blog Description: ". $bgdescript ."</br>");
    //		print( "Date " . $bgdate . "</br>");
    //		print( $userid );
    //		exit();


    try {
      $sql = "INSERT INTO blog SET bgname=:bgname, bgdescript=:bgdescript, bgdate=:bgdate, userid=:userid";

      $q = $this->conn->prepare( $sql );

      $q->execute( array( 'bgname' => $bgname, 'bgdescript' => $bgdescript, 'bgdate' => $bgdate, 'userid' => $userid ) );

      return true;

    } catch ( PDOException $e ) {
      //            print( 'Unable to insert product data' );
      //            exit();
      return false;
    };


  }

  // This was used to get the blogdata without a userid. This was used previously without the login and registration pages made
  //	public function getblogdata() {
  //        try {
  //
  //            $sql = "SELECT blogid, bgname, bgdescript, bgdate FROM blog";
  //
  //            $q = $this->conn->prepare( $sql );
  //
  //            $q->execute();
  //
  //            while ( $r = $q->fetch( PDO::FETCH_ASSOC ) ) {
  //                $results[] = $r;
  ////				return $results;
  ////            	exit();
  //            }
  //            //            echo array_values($results);
  //            //            print_r( array_values($results) );
  //            //            print(count($results));
  //            //            exit();
  ////							print_r($results);
  ////							exit();
  //            if (!empty($results)) {
  //				return $results;
  //            	exit();
  //        	} 
  //			else return null;
  //			
  //		} catch ( PDOException $e ) {
  //                        print( 'Unable to get entry data' );
  //            //            exit();
  //            return false;
  ////            exit();
  //        } ;
  //    }


  // After login aspect has been finished, we will use this function to get the user assosciated with their projects. 
  // Will use a session variable which hold the userid and send this value to the function'
  public function getblogdata( $userid ) {
    try {

      $sql = "SELECT * FROM blog WHERE userid=:userid";

      $q = $this->conn->prepare( $sql );

      $q->execute( array( 'userid' => $userid ) );

      while ( $r = $q->fetch( PDO::FETCH_ASSOC ) ) {
        $results[] = $r;
        //				return $results;
        //            	exit();
      }
      //            echo array_values($results);
      //            print_r( array_values($results) );
      //            print(count($results));
      //            exit();
      //							print_r($results);
      //							exit();
      if ( !empty( $results ) ) {
        return $results;
        exit();
      } else return false;

    } catch ( PDOException $e ) {
      //            print( 'Unable to getproduct data' );
      //            exit();
      return false;
      exit();
    };
  }


  // This function is used to get the blog/topic name assosicated with a userid. This is used to display on the Home Page when the user logins in
  public function getblogname( $blogid ) {
    try {

      $sql = "SELECT bgname FROM blog WHERE blogid=:blogid";

      $q = $this->conn->prepare( $sql );

      $q->execute( array( 'blogid' => $blogid ) );

      while ( $r = $q->fetch( PDO::FETCH_ASSOC ) ) {
        $results[] = $r;
        //				return $results;
        //            	exit();
      }
      //            echo array_values($results);
      //            print_r( array_values($results) );
      //            print(count($results));
      //            exit();
      //							print_r($results);
      //							exit();
      if ( !empty( $results ) ) {
        return $results;
        exit();
      } else return false;

    } catch ( PDOException $e ) {
      //            print( 'Unable to getproduct data' );
      //            exit();
      return false;
      exit();
    };
  }

  // This function is used to get the entrydata associated with a blogid. SO when a use presses "view entries", the assosciated entries show.
  public function getentrydata( $blogid ) {
    //		print($blogid);
    //		exit();
    try {
      $sql = "SELECT * FROM entry INNER JOIN blog ON blog.blogid = entry.blogid WHERE entry.blogid=:blogid";

      $q = $this->conn->prepare( $sql );

      $q->execute( array( 'blogid' => $blogid ) );

      while ( $r = $q->fetch( PDO::FETCH_ASSOC ) ) {
        $results[] = $r;
      }
      //            echo array_values($results);
      //            print_r( array_values($results) );
      //exit();
      //                              print_r($results);
      //                              exit();
      if ( !empty( $results ) ) {
        return $results;
        exit();
      } else {
        return false;
      }
    } catch ( PDOException $e ) {
      print( 'Unable to get task data' );
      //			echo 'Unable to get task data';
      exit();
      //			return false;
    };
  }

  // This is used to get single informations for an entry. I used this to edit an entry associated with their entryid. This is used on the "editentry.php"
  public function getsingleentrydata( $entryid ) {
    try {
      $sql = "SELECT * FROM entry WHERE entry.entryid=:entryid";

      $q = $this->conn->prepare( $sql );

      $q->execute( array( 'entryid' => $entryid ) );

      while ( $r = $q->fetch( PDO::FETCH_ASSOC ) ) {
        $results[] = $r;
      }
      //            echo array_values($results);
      //            print_r( array_values($results) );
      //exit();
      //                        print_r($results);
      //                        exit();
      if ( !empty( $results ) ) {
        return $results;
        exit();
      } else {
        return null;
      }
    } catch ( PDOException $e ) {
      print( 'Unable to get task data' );
      //			echo 'Unable to get task data';
      exit();
      //			return false;
    };
  }


  // This function is used to get the email of a user. It is used for login, registration and account purposes. It checks if the email entered is a duplicate
  public function getemail( $email ) {
    try {
      $sql = "SELECT email FROM users WHERE email=:email";
      $q = $this->conn->prepare( $sql );
      $q->execute( array( 'email' => $email ) );

      while ( $r = $q->fetch( PDO::FETCH_ASSOC ) ) {
        $results[] = $r;
      }
      if ( !empty( $results ) ) {
        return true;
        exit();
      } else {
        return false;
        exit();
      }
    } catch ( PDOException $e ) {
      print( 'Error in trying to get this email address from the database' );
      exit();
    };
  }


  // This function is used to insert a new user when they are registering and all validations have been approved
  public function insertuser( $firstname, $lastname, $email, $password ) {
    try {

      $usertype = 1;
      $userdate = date( "Y-m-d" );


      //			print($firstname." ".$lastname." ".$username." ".$email." ".$password." ". $usertype." ".$userdate);
      //			exit();

      $password = password_hash( $password, PASSWORD_DEFAULT );

      $sql = "INSERT INTO users SET firstname=:firstname, lastname=:lastname, email=:email, password=:password, usertype=:usertype, userdate=:userdate";

      $q = $this->conn->prepare( $sql );

      $q->execute( array( 'firstname' => $firstname, 'lastname' => $lastname, 'email' => $email, 'password' => $password, 'usertype' => $usertype, 'userdate' => $userdate ) );

      return true;
      exit();
    } catch ( PDOException $e ) {
      print( 'Unable to insert new user data' );
      exit();
      return false;
    };


  }

  // This is used to get the stastusid from the status table. This is used to show "Draft" and "Published" on the entry pages such as draft tab, and published tab
  public function status( $statusid ) {
    try {

      $sql = "SELECT statustype FROM status WHERE statusid=:statusid";

      $q = $this->conn->prepare( $sql );

      $q->execute( array( 'statusid' => $statusid ) );

      while ( $r = $q->fetch( PDO::FETCH_ASSOC ) ) {
        $results[] = $r;
      }
      //      if ( $results = 'Published' ) {

      //			print_r($results);
      //			exit();
      return $results;
      exit();
      //      } else {
      //        return false;
      //        exit();
      //      }
    } catch ( PDOException $e ) {
      print( 'Error in trying to get this status from the database' );
      exit();
    };


  }

  /*This function is used to update the User's information as an ADMIN. It has only the firstname, lastname and email because when you check the form, it submits just that. */
  public function insertuser2( $userid, $firstname, $lastname, $email, $usertype ) {
    try {


      //            			print($userid." ". $firstname." ".$lastname."  ".$email);
      //            			exit();


      $sql = "UPDATE users SET firstname=:firstname, lastname=:lastname, email=:email, usertype=:usertype WHERE userid=:userid";

      $q = $this->conn->prepare( $sql );

      $q->execute( array( 'userid' => $userid, 'firstname' => $firstname, 'lastname' => $lastname, 'email' => $email,  'usertype' => $usertype ) );

      return true;
      exit();
    } catch ( PDOException $e ) {
      print( 'Unable to insert new user data' );
      exit();
      return false;
    };


  }
	
	
	/*This code is used to update the User's information in the Account Page. It has only the firstname, lastname and email because when you check the form, it submits just that. 
  The password is updated separately in another section of the form */
  public function insertuser3( $userid, $firstname, $lastname, $email  ) {
    try {


      //            			print($userid." ". $firstname." ".$lastname."  ".$email);
      //            			exit();


      $sql = "UPDATE users SET firstname=:firstname, lastname=:lastname, email=:email WHERE userid=:userid";

      $q = $this->conn->prepare( $sql );

      $q->execute( array( 'userid' => $userid, 'firstname' => $firstname, 'lastname' => $lastname, 'email' => $email ) );

      return true;
      exit();
    } catch ( PDOException $e ) {
      print( 'Unable to insert new user data' );
      exit();
      return false;
    };


  }


  // This is used when a user is logging. It checks for validations
  public function userIsLoggedIn() {
    //		unset($_SESSION[ 'loggedIn' ]); 
    // This part is for logining in 
    if ( isset( $_POST[ 'action' ] )and $_POST[ 'action' ] == 'login' ) {

      unset( $_SESSION[ 'email' ] );
      unset( $_SESSION[ 'password' ] );
      $email = $_POST[ 'email' ];
      $password = $_POST[ 'password' ];
      $results = $this->getcurrentpassword( $email );
      //			print_r($results);
      //			exit();
      $hash = $results[ 0 ][ 'password' ];
      //			print( $hash );
      //			exit();

      if ( password_verify( $password, $hash ) ) {
        if ( !isset( $_SESSION ) ) {
          session_start();
        }
        $_SESSION[ 'loggedIn' ] = true;
        $_SESSION[ 'email' ] = $email;
        $_SESSION[ 'password' ] = $hash;
        $userid = $this->getuserid( 'users' );
        $_SESSION[ 'userid' ] = $userid;
        $this->setonline( $_SESSION[ 'userid' ] );

        //				print($userid);
        //				exit();
        //		  print("here again");
        //        				exit();
        unset( $_SESSION[ 'loginError' ] );
        unset( $_SESSION[ 'logoutSuccess' ] );
        unset( $_SESSION[ 'passworderror' ] );
        unset( $_SESSION[ 'emailerror' ] );
        //        header( "location:homepage.php" );
        //        header( "location:registration_success.php" );
        header( "location:homepage.php" );
        //				
        //        return true;
      } else {
        if ( !isset( $_SESSION ) ) {
          session_start();
        }
        unset( $_SESSION[ 'loggedIn' ] );
        unset( $_SESSION[ 'email' ] );
        unset( $_SESSION[ 'password' ] );
        unset( $_SESSION[ 'userid' ] );

        $_SESSION[ 'passworderror' ] = true;


        $_SESSION[ 'loginError' ] = true;
        header( "location:login.php" );
      }
    }

    // This part is for loging out 
    if ( isset( $_POST[ 'action' ] )and $_POST[ 'action' ] == 'logout' ) {

      if ( !isset( $_SESSION ) ) {
        session_start();
      }
      unset( $_SESSION[ 'loggedIn' ] );
      unset( $_SESSION[ 'email' ] );
      unset( $_SESSION[ 'password' ] );
      unset( $_SESSION[ 'userid' ] );
      unset( $_SESSION[ 'loginSuccess' ] );
      unset( $_SESSION[ 'loginError' ] );
      unset( $_SESSION[ 'editing-users' ] );
      unset( $_SESSION[ 'editing-blog' ] );
      unset( $_SESSION[ 'blogid' ] );
      unset( $_SESSION[ 'bgname' ] );
      unset( $_SESSION[ 'blog-entry-data' ] );
      unset( $_SESSION[ 'entryid' ] );
      unset( $_SESSION[ 'input-error' ] );
      unset( $_SESSION[ 'emailerror' ] );
      unset( $_SESSION[ 'passworderror' ] );
      unset( $_SESSION[ 'passwordsmall-error' ] );
      unset( $_SESSION[ 'passwordmatch-error' ] );
      unset( $_SESSION[ 'oldpassword-error' ] );
      unset( $_SESSION[ 'oldpassword-error' ] );
      unset( $_SESSION[ 'duplicate-email' ] );
      unset( $_SESSION[ 'duplicate-password' ] );


      $_SESSION[ 'logoutSuccess' ] = true;
      header( 'location:index.html' );
      exit();
    }

    // If they are already logged in 
    if ( isset( $_SESSION[ 'loggedIn' ] ) ) {
      return true;
    }
  }

  // This gets the current password associated with a email a user typed in. It works to validate the inputs 
  public function getcurrentpassword( $email ) {
    //		print($email);
    //		exit();
    $sql = "SELECT password FROM users WHERE email = '$email'";
    $q = $this->conn->query( $sql )or die( "failed query in getting current password" );

    while ( $r = $q->fetch( PDO::FETCH_ASSOC ) ) {
      $results[] = $r;
    }
    if ( empty( $results ) ) {
      return false;
      exit();
    } else {
      return $results;
      exit();
    }
  }

  // This gets the users information when they are logging in
  public function getuserid( $table ) {
    try {
      $sql = "SELECT userid FROM $table WHERE email =:email AND password =:password";
      $s = $this->conn->prepare( $sql );
      $s->execute( ( array( 'email' => $_SESSION[ 'email' ], 'password' => $_SESSION[ 'password' ] ) ) );

      while ( $r = $s->fetch( PDO::FETCH_ASSOC ) ) {
        $results[] = $r;
      }
      $userid = $results[ 0 ][ 'userid' ];
      //			print_r($userid);
      //			exit();

      return $userid;
      exit();

    } catch ( PDOException $e ) {
      //			$GLOBALS[ 'loginError' ] = "Could not find this user's id";
      ////			 print( 'Error in trying to get this email address from the database');
      //			 include 'login.php';
      //			 exit();
    }
  }


  // This is ued to get the users information. I used this to display the firstname and lastname of a user
  public function getuserinfo( $userid ) {
    try {
      $sql = "SELECT * FROM users WHERE userid=:userid";
      //      $sql = "SELECT firstname, lastname FROM users=:userid";
      $s = $this->conn->prepare( $sql );
      $s->execute( ( array( 'userid' => $userid ) ) );

      while ( $r = $s->fetch( PDO::FETCH_ASSOC ) ) {
        $results[] = $r;
        //		  print($results);
        //		  exit();
      }
      //            			print_r($results);
      //            			exit();

      return $results;
      exit();

    } catch ( PDOException $e ) {
      $GLOBALS[ 'loginError' ] = "Could not find this user's id";
      print( 'Error in trying to get this email address from the database' );
      //			 include 'login.php';
      exit();
    }
  }


  // This is used to get all the user informations. It is used for the adminstration Page
  public function getallusers() {
    try {
      $sql = "SELECT * FROM users";
      //      $sql = "SELECT firstname, lastname FROM users=:userid";
      $s = $this->conn->prepare( $sql );
      $s->execute();

      while ( $r = $s->fetch( PDO::FETCH_ASSOC ) ) {
        $results[] = $r;
      }
      //      $username = $results[ 0 ][ 'firstname' ] . " " . $results[ 0 ][ 'lastname' ] ;
      //      			print_r($username);
      //      			exit();

      //      return $username;

      //		print_r($results);
      //        		  exit();
      return $results;
      exit();

    } catch ( PDOException $e ) {
      //			$GLOBALS[ 'loginError' ] = "Could not find this user's id";
      ////			 print( 'Error in trying to get this email address from the database');
      //			 include 'login.php';
      //			 exit();
    }
  }


  // This is used to update the blog after it has been edited
  public function editblogdata( $blogid, $bgname, $bgdescript, $bgdate, $userid ) {
    //		print("hereeee");
    //		entryid {}
    try {
      $sql = "UPDATE blog SET bgname=:bgname, bgdescript=:bgdescript, bgdate=:bgdate, userid=:userid WHERE blogid=:blogid";

      $q = $this->conn->prepare( $sql );
      //print( $blogid ." " . $bgname . " " . $bgdescript . " " . $bgdate . " " . $userid);
      $q->execute( array( 'blogid' => $blogid, 'bgname' => $bgname, 'bgdescript' => $bgdescript, 'bgdate' => $bgdate, 'userid' => $userid ) );


      return true;
      exit();


    } catch ( PDOException $e ) {
      print( 'Unable to update blog data' );
      exit();
      return false;
    };


  }

  // This is used to delete a blog using the blogid
  public function deleteblogdata( $blogid ) {
    try {
      $sql = "DELETE FROM blog WHERE blogid=:blogid";

      $q = $this->conn->prepare( $sql );

      $q->execute( array( 'blogid' => $blogid ) );

      $sql1 = "DELETE FROM entry WHERE blogid=:blogid";

      $r = $this->conn->prepare( $sql1 );

      $r->execute( array( 'blogid' => $blogid ) );

      return true;
    } catch ( PDOException $e ) {
      //				print('Unable to delete project data');
      //				exit();
      return false;
    }
  }

  // This is used to delete an entry using the entryid
  public function deleteentry( $entryid ) {
    try {
      $sql = "DELETE FROM entry WHERE entryid=:entryid";

      $q = $this->conn->prepare( $sql );

      $q->execute( array( 'entryid' => $entryid ) );

      return true;
    } catch ( PDOException $e ) {
      // print('Unable to delete task data');
      // exit();
      return false;
    }
  }


  //  public function deleteuser( $userid ) {
  //    try {
  //      $sql = "DELETE FROM users WHERE userid=:userid";
  //
  //      $q = $this->conn->prepare( $sql );
  //
  //      $q->execute( array( 'userid' => $userid ) );
  //
  //      return true;
  //    } catch ( PDOException $e ) {
  //      // print('Unable to delete user data');
  //      // exit();
  //      return false;
  //    }
  //  }

  // This is used to insert a new entry into the database.
  public function insertentrydata( $entname, $enttext, $blogid, $statusid, $entdate ) {

	 
//	  print('heree');
//	  exit();
    try {
      $sql = "INSERT INTO entry SET entname=:entname, enttext=:enttext, blogid=:blogid, statusid=:statusid, entdate=:entdate";

      $q = $this->conn->prepare( $sql );

      $q->execute( array( 'entname' => $entname, 'enttext' => $enttext, 'blogid' => $blogid, 'statusid' => $statusid, 'entdate' => $entdate ) );

      return true;

    } catch ( PDOException $e ) {
      //            print( 'Unable to insert product data' );
      //            exit();
      return false;
    };


  }

  // This gets the entries that have a statusid of 2. It is used for the draft page
  public function getdraftdata( $userid ) {
    //		print($blogid);
    //		exit();

    $statusid = 2;

    try {
      $sql = "SELECT * FROM users INNER JOIN blog ON users.userid = blog.userid INNER JOIN entry ON blog.blogid = entry.blogid WHERE statusid=:statusid";

      $q = $this->conn->prepare( $sql );

      $q->execute( array( 'statusid' => $statusid ) );

      while ( $r = $q->fetch( PDO::FETCH_ASSOC ) ) {
        $results[] = $r;
        //		  print_r($results);
        //		  exit();
      }

      //		$foruser = ($results['userid'] == $userid );
      //		print_r($foruser);
      //		exit();


      if ( !empty( $results ) ) {
        //		  print_r($results);
        //		  exit();
        return $results;
        exit();

      } else {
        return false;
      }
    } catch ( PDOException $e ) {
      print( 'Unable to get task data' );
      //			echo 'Unable to get task data';
      exit();
      //			return false;
    };
  }

  // This is used to insert a new entry as published 
  public function insertpublishdata( $entname, $enttext, $blogid, $statusid, $entdate ) {

    try {
      $sql = "INSERT INTO entry SET entname=:entname, enttext=:enttext, blogid=:blogid, statusid=:statusid, entdate=:entdate";

      $q = $this->conn->prepare( $sql );

      $q->execute( array( 'entname' => $entname, 'enttext' => $enttext, 'blogid' => $blogid, 'statusid' => $statusid, 'entdate' => $entdate ) );

      return true;

    } catch ( PDOException $e ) {
      //            print( 'Unable to insert product data' );
      //            exit();
      return false;
    };


  }

  // This gets the entries that have a statusid of 1. It is used for the published page
  public function getpublishdata() {
    //		print($blogid);
    //		exit();

    $statusid = 1;

    try {
      //      $sql = "SELECT * FROM entry WHERE statusid=:statusid";
      $sql = "SELECT * FROM users INNER JOIN blog ON users.userid = blog.userid INNER JOIN entry ON blog.blogid = entry.blogid WHERE statusid=:statusid";

      $q = $this->conn->prepare( $sql );

      $q->execute( array( 'statusid' => $statusid ) );

      while ( $r = $q->fetch( PDO::FETCH_ASSOC ) ) {
        $results[] = $r;
        //		  print_r($results);
        //		  exit();
      }


      //		  	  $array = $results;
      //		  
      //		  foreach ( $results as $result1 => $result1['userid'][1]  ) {
      //			  if ($result1['userid'] == $_SESSION['userid']) {
      //			  print_r($array);
      //				  exit();
      //		  }
      //		  }

      if ( !empty( $results ) ) {
        return $results;
        exit();
      } else {
        return false;
      }
    } catch ( PDOException $e ) {
      print( 'Unable to get task data' );
      //			echo 'Unable to get task data';
      exit();
      //			return false;
    };
  }

  // This gets the entries that have a statusid of 1. It is used for the community page
  public function getpublishdata2() {
    //		print($blogid);
    //		exit();

    $statusid = 1;

    try {
      $sql = "SELECT * FROM users INNER JOIN blog ON users.userid = blog.userid INNER JOIN entry ON blog.blogid = entry.blogid WHERE statusid=:statusid";

      $q = $this->conn->prepare( $sql );

      $q->execute( array( 'statusid' => $statusid ) );

      while ( $r = $q->fetch( PDO::FETCH_ASSOC ) ) {
        $results[] = $r;

      }

      //		  $array = $results;
      //		  
      ////		  foreach ( $array as $result1 => $result1['userid'][$_SESSION['userid']]  ) {
      //			  if ($results['userid'] == $_SESSION['userid']) {
      //			  print_r($results);
      ////				  exit();
      //		  }
      //		  }


      //  		print_r($results);
      //  		  exit();

      if ( !empty( $results ) ) {
        return $results;
        exit();
      } else {
        return false;
      }
    } catch ( PDOException $e ) {
      print( 'Unable to get task data' );
      //			echo 'Unable to get entry data';
      exit();
      //			return false;
    };
  }

  // This is used to update an entry. It is used when the user changes a draft entry to a publish entry, by updating the statusid
  public function updateentrydata( $entryid, $entname, $enttext, $blogid, $entdate, $statusid ) {

    try {
      $sql = "UPDATE entry SET entname=:entname, enttext=:enttext, blogid=:blogid, entdate=:entdate, statusid=:statusid WHERE entryid=:entryid ";


      $q = $this->conn->prepare( $sql );


      $q->execute( array( 'entryid' => $entryid, 'entname' => $entname, 'enttext' => $enttext, 'blogid' => $blogid, 'statusid' => $statusid, 'entdate' => $entdate ) );


      //			print($blogid .'  '. $entryid .'  '. $entname .'  '. $enttext .'  '. $entdate .'  '. $statusid );
      //	exit();

      return true;

    } catch ( PDOException $e ) {
      //            print( 'Unable to insert entry data' );
      //            exit();
      return false;
    };


  }

  //This is used to update a users password when they chnage thier account info
  public function insertnewpassword( $userid, $newpasswordhash ) {
    try {


      //      			print($userid." ".$newpasswordhash);
      //			exit();

      $sql = "UPDATE users SET password=:password WHERE userid=:userid;";

      $q = $this->conn->prepare( $sql );

      $q->execute( array( 'userid' => $userid, 'password' => $newpasswordhash ) );

      return true;
      exit();
    } catch ( PDOException $e ) {
      print( 'Unable to insert new user data' );
      exit();
      return false;
    };


  }

  // This is used to update an entry. It is used when the user changes a draft entry to a publish entry, by updating the statusid
  public function updatepublishdata( $entryid, $entname, $enttext, $blogid, $statusid, $entdate ) {
    try {


//              			print($entryid. " ". $entname. " ". $enttext . " ". $blogid . " ". $statusid . " ". $entdate );
//              			exit();

      $sql = "UPDATE entry SET entname=:entname, enttext=:enttext, blogid=:blogid, statusid=:statusid, entdate=:entdate  WHERE entryid=:entryid";

      $q = $this->conn->prepare( $sql );

      $q->execute( array( 'entryid' => $entryid, 'entname' => $entname, 'enttext' => $enttext, 'blogid' => $blogid, 'statusid' => $statusid, 'entdate' => $entdate ) );

      return true;
      exit();
    } catch ( PDOException $e ) {
      print( 'Unable to insert data' );
      exit();
      return false;
    };
  }

  // Function is responsible for deleting a user and its associated data. It deletes the particular user, delete the blogs in the entry and deletes the blog related to the user.
  public function deleteuserdata( $userid ) {
    try {


      $sql = "DELETE FROM users WHERE userid=:userid";

      $q = $this->conn->prepare( $sql );

      $q->execute( array( 'userid' => $userid ) );


      $sql1 = "DELETE entry, blog FROM entry INNER JOIN blog ON blog.blogid = entry.blogid WHERE userid=:userid";

      $r = $this->conn->prepare( $sql1 );

      $r->execute( array( 'userid' => $userid ) );

      $sql2 = "DELETE FROM blog WHERE userid=:userid";

      $q = $this->conn->prepare( $sql2 );

      $q->execute( array( 'userid' => $userid ) );


      return true;
    } catch ( PDOException $e ) {
      //				print('Unable to delete information');
      //				exit();
      return false;
    }


  }


	// This function gets the time the user logs in and saved it into the database. This will be used later after they log out
  function setonline( $userid ) {

    $online = time();
    $sql = "UPDATE users SET online=:online WHERE userid=:userid";

    $q = $this->conn->prepare( $sql );

    $q->execute( array( 'userid' => $userid, 'online' => $online ) );

    return true;
    exit();


  }




	
	// This function is used to display the last time a user logged. It gets the time since 1970 and subracts from the current time today so see how long a user has been inactive.
  public function gettime( $pasttime, $today = 0, $differenceFormat = '%y' ) {

    $today = date( "Y-m-d H:i:s" );
    $datetime1 = date_create( $pasttime );
    $datetime2 = date_create( $today );

    $interval = date_diff( $datetime1, $datetime2 );
    $answerY = $interval->format( $differenceFormat );

    $differenceFormat = '%m';
    $answerM = $interval->format( $differenceFormat );

    $differenceFormat = '%d';
    $answer = $interval->format( $differenceFormat );

    $differenceFormat = '%h';
    $answer2 = $interval->format( $differenceFormat );

    //check for how much time passed

    if ( $answerY >= 1 ) { //one year has passed

      $answerY = date( " F jS, Y ", strtotime( $pasttime ) ); // . " at " . date("h:i:s a", strtotime($pasttime));
      return $answerY;

    } else if ( $answerM >= 1 ) { //one month has passed

      $answerM = date( " F jS, Y ", strtotime( $pasttime ) ); // . " at " . date("h:i:s a", strtotime($pasttime));
      return $answerM;

    } else if ( $answer > 2 ) { //more than 2 days

      $answer = date( " F jS, Y ", strtotime( $pasttime ) ); // . " at " . date("h:i:s a", strtotime($pasttime));
      return $answer;

    } else if ( $answer == 2 ) { // 2 days

      return $answer . " d, " . $answer2 . " hr ago"; // at " . date("h:i:s a", strtotime($pasttime));

    } else if ( $answer == 1 ) { // 1 day ago

      return "1 d, " . date( "h:i a", strtotime( $pasttime ) );

    } else { // less than a day

      $differenceFormat = '%h';
      $answer = $interval->format( $differenceFormat );

      $differenceFormat = '%i';
      $answer2 = $interval->format( $differenceFormat );

      if ( ( $answer < 24 ) && ( $answer > 1 ) ) {

        return $answer . " hr, " . $answer2 . " min ago";

      } else if ( $answer == 1 ) {

        return "An hour ago";

      } else { //less than an hour

        $differenceFormat = '%i';
        $answer = $interval->format( $differenceFormat );

        if ( ( $answer < 60 ) && ( $answer > 1 ) ) {

          return $answer . " minutes ago";

        } else if ( $answer == 1 ) {

          return "A minute ago";

        } else {

          $differenceFormat = '%s';
          $answer = $interval->format( $differenceFormat );

          if ( ( $answer < 60 ) && ( $answer > 10 ) ) {

            return $answer . " seconds ago";

          } else if ( $answer < 10 ) {

            return "few seconds ago";

          }

        }

      }


    }


  }


}


//}
?>