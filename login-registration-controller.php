<?php
if ( !isset( $_SESSION ) ) {
  session_start();
}

spl_autoload_register( function ( $class ) {
  include_once( 'dtb.php' );

} );

$obj = new dtb_blog;


// This is used when the user logins in into the database. It goes on to check if the emial and password typed is validated correctly.
if ( isset( $_POST[ 'login-now' ] ) ) {
  unset( $_SESSION[ 'email' ] );
  $loginsuccessful = $obj->userIsLoggedIn();
}

//This is used when the user logs out of the database. It unsets all session variables.
if ( isset( $_POST[ 'logout' ] ) ) {
  unset( $_SESSION[ 'email' ] );
  $logoutsuccessful = $obj->userIsLoggedIn();
}


//This is used when the user
if (isset($_POST['loginregishomepage'])) {
	  unset( $_SESSION[ 'firstname' ] );
  unset( $_SESSION[ 'lastname' ] );
  unset( $_SESSION[ 'username' ] );
  unset( $_SESSION[ 'email' ] );
  unset( $_SESSION[ 'passwordmatch-error' ] );
  unset( $_SESSION[ 'duplicate-email' ] );
  unset( $_SESSION[ 'passwordsmall-error' ] );
  unset( $_SESSION[ 'input-error' ] );
  unset( $_SESSION[ 'passworderror' ] );
  unset( $_SESSION[ 'loginError' ] );
  header( "location:index.html" );
}



// This is used when the user is registering for the first time. There are some validation processes that take place in here
if ( isset( $_POST[ 'registration' ] ) ) {
  //	print("registration submission");
  //	exit();

  $_SESSION[ "firstname" ] = $_POST[ 'firstname' ];
  $_SESSION[ "lastname" ] = $_POST[ 'lastname' ];
  $_SESSION[ "email" ] = $_POST[ 'email' ];
  $password = $_POST[ 'password' ];
  $confirmpassword = $_POST[ 'confirmpassword' ];
  //	print($username.' '.$email.' '.$password.' '.$confirmpassword);
  //	print($password.' '.$confirmpassword);
  //	exit();


  if ( $password !== $confirmpassword ) {
    //		print("passwords don't match");
    //		exit();
    $_SESSION[ 'passworderror' ] = true;
    //    $_SESSION[ 'passwordmatch-error' ] = true;
    unset( $_SESSION[ 'passwordsmall-error' ] );
    //	  unset( $_SESSION[ "duplicate-email" ] );
    unset( $_SESSION[ 'emailerror' ] );
    header( "location:registration.php" );
  } else if ( strlen( $password ) < 8 ) {
    $_SESSION[ 'passwordsmall-error' ] = true;
    unset( $_SESSION[ 'passworderror' ] );
    unset( $_SESSION[ 'emailerror' ] );
    header( "location:registration.php" );
  } else {
    unset( $_SESSION[ 'passwordsmall-error' ] );
    //	  unset( $_SESSION[ 'passwordmatch-error' ] );
    unset( $_SESSION[ 'passworderror' ] );
  }


  if ( $obj->getemail( $_SESSION[ 'email' ] ) ) {
    //    $_SESSION[ 'duplicate-email' ] = true;
    //    unset( $_SESSION[ 'passwordmatch-error' ] );
    unset( $_SESSION[ 'passwordsmall-error' ] );
    unset( $_SESSION[ 'passworderror' ] );
    //	  unset( $_SESSION[ 'emailerror' ] );
    $_SESSION[ 'emailerror' ] = true;
  } else {
    unset( $_SESSION[ "emailerror" ] );
  }
  if ( isset( $_SESSION[ 'passworderror' ] ) ) {
    header( "location:registration.php" );
  } else if ( isset( $_SESSION[ 'passwordsmall-error' ] ) ) {
    header( "location:registration.php" );
  }
  else if ( isset( $_SESSION[ "emailerror" ] ) ) {
    header( "location:registration.php" );
  }


  // Putting the data into the database  after all validations has been approved
  else {
    $successregistration = $obj->insertuser( $_SESSION[ 'firstname' ], $_SESSION[ 'lastname' ],
      $_SESSION[ 'email' ], $password );
    if ( $successregistration = true ) {
      //			print($successregistration);
      //          print( "User registration success" );
      //          exit();
      $loginsuccessful = $obj->userIsLoggedIn();
		$_SESSION[ 'registersuccess' ] = true;
      header( "location:login.php" );
    }

    unset( $_SESSION[ 'passwordmatch-error' ] );
    unset( $_SESSION[ 'duplicate-email' ] );
    unset( $_SESSION[ 'passwordsmall-error' ] );
    unset( $_SESSION[ 'input-error' ] );
    unset( $_SESSION[ 'firstname' ] );
    unset( $_SESSION[ 'lastname' ] );
    unset( $_SESSION[ 'username' ] );
    unset( $_SESSION[ 'email' ] );

    exit();
  }
}


// This is used to switched between the "Login page and Registration page"
if ( isset( $_POST[ 'login' ] ) ) {
  unset( $_SESSION[ 'firstname' ] );
  unset( $_SESSION[ 'lastname' ] );
  unset( $_SESSION[ 'username' ] );
  unset( $_SESSION[ 'email' ] );
  unset( $_SESSION[ 'passwordmatch-error' ] );
  unset( $_SESSION[ 'duplicate-email' ] );
  unset( $_SESSION[ 'passwordsmall-error' ] );
  unset( $_SESSION[ 'input-error' ] );
  unset( $_SESSION[ 'passworderror' ] );
  unset( $_SESSION[ 'loginError' ] );
  header( "location:login.php" );
}

//This is used to switched between the "Login page and Registration page"
if ( isset( $_POST[ 'signupnow' ] ) ) {
//  unset( $_SESSION[ 'email' ] );
  unset( $_SESSION[ 'passwordmatch-error' ] );
  unset( $_SESSION[ 'duplicate-email' ] );
  unset( $_SESSION[ 'passwordsmall-error' ] );
  unset( $_SESSION[ 'input-error' ] );
  unset( $_SESSION[ 'passworderror' ] );
  unset( $_SESSION[ 'loginError' ] );

  header( "location:registration.php" );
}

// THis is used to direct the user into the account Page where they are cna edit their account
if ( isset( $_POST[ 'account' ] ) ) {
  header( "location:account.php" );
}


/* To get into the page where you can edit your own account details */
if ( isset( $_POST[ 'account' ] ) ) {
  header( "location:account.php" );
}

/* To get into the page where you can edit your own password */
if ( isset( $_POST[ 'changepassword' ] ) ) {
	  unset( $_SESSION[ 'emailerror' ] );
//	  unset( $_SESSION[ 'input-error' ] );
	  unset( $_SESSION[ 'new' ] );
  header( "location:password.php" );
}


if ( isset( $_POST[ 'accountbacktohomepage' ] ) ) {
        unset( $_SESSION[ 'passwordmatch-error' ] );
  unset( $_SESSION[ 'emailerror' ] );
  //      unset( $_SESSION[ 'duplicate-password' ] );
  unset( $_SESSION[ 'passwordsmall-error' ] );
  unset( $_SESSION[ 'oldpassword-error' ] );
  unset( $_SESSION[ 'input-error' ] );
  unset( $_SESSION[ 'passworderror' ] );
	

	header('location:homepage.php');

}

// This is used to switch bewteen the Account Page and the Password Page

if (isset($_POST['PersonalInfo'])) {
	   unset( $_SESSION[ 'passwordmatch-error' ] );
  unset( $_SESSION[ 'emailerror' ] );
  //      unset( $_SESSION[ 'duplicate-password' ] );
  unset( $_SESSION[ 'passwordsmall-error' ] );
  unset( $_SESSION[ 'oldpassword-error' ] );
//  unset( $_SESSION[ 'inputerror' ] );
  unset( $_SESSION[ 'new' ] );
//  unset( $_SESSION[ 'input-error' ] );
  unset( $_SESSION[ 'passworderror' ] );
	
	header('location:account.php');
}



// This code is used to change the password of a user when they are editing their own account. THis includes encrypting the hash and others.
if ( isset( $_POST[ 'updatepassword' ] ) ) {
  //	print("Updating password");
  //	exit();

  $currentpassword = $obj->testinput( $_POST[ "currentpassword" ] );
  $newpassword = $obj->testinput( $_POST[ "newpassword" ] );
  $confirmnewpassword = $obj->testinput( $_POST[ "confirmnewpassword" ] );

  //	print_r($currentpassword ." ". $newpassword ." ". $confirmnewpassword);
  //	exit();

  $userresults = $obj->getuserinfo( $_SESSION[ 'userid' ] );
  $hash = $userresults[ 0 ][ 'password' ];
  //	print($hash);
  //	print('     ');

  $newpasswordhash = password_hash( $newpassword, PASSWORD_DEFAULT );


  if ( password_verify( $currentpassword, $hash ) ) {
    unset( $_SESSION[ 'passworderror' ] );
    unset($_SESSION['inputerror']);
//	  continue;
	  
  } else {
    $_SESSION[ 'passworderror' ] = true;
//    $_SESSION['inputerror'] = true;
    $_SESSION['new'] = true;
  }
	
  if ( $newpassword != $confirmnewpassword ) {
    //		print("passwords don't match");
    //		exit();
    $_SESSION[ 'passwordmatch-error' ] = true;
    $_SESSION['new'] = true;
	  
	  
    header( "location:password.php" );
  } else {
    //        print( "passwords match" );
    //        exit();
    unset( $_SESSION[ 'passwordmatch-error' ] );
//    unset( $_SESSION[ 'inputerror' ] );
  }

  if ( strlen( $newpassword ) < 8 ) {
    $_SESSION[ 'passwordsmall-error' ] = true;
    $_SESSION['new'] = true;
    header( "location:password.php" );
  } else {
    unset( $_SESSION[ 'passwordsmall-error' ] );
//    unset( $_SESSION['inputerror'] );
  }


  if ( password_verify( $newpassword, $hash ) ) {
//	  print('Password is old');
//	  exit();
    $_SESSION[ 'oldpassword-error' ] = true;
//    $_SESSION['inputerror'] = true;
	  $_SESSION['new'] = true;
    header( "location:password.php" );

  } else {
    unset( $_SESSION[ "oldpassword-error" ] );
    unset( $_SESSION['inputerror'] );
  }
	
	
	  if ( isset( $_SESSION[ 'passworderror' ] ) ) {
    header( "location:password.php" );
		  exit();
  } else if ( isset( $_SESSION[ 'oldpassword-error' ] ) ) {
    header( "location:password.php" );
		  exit();
  } else if ( isset( $_SESSION[ 'passwordsmall-error' ] ) ) {
    header( "location:password.php" );
//		  exit();
  }
  else if ( isset( $_SESSION[ "passwordmatch-error" ] ) ) {
    header( "location:password.php" );
//	  exit();
  }

  else  {
        $successupdate = $obj->insertnewpassword( $_SESSION[ 'userid' ], $newpasswordhash );
        if ( $successupdate ) {
			$_SESSION['usersuccess'] = 'Your password has been changed successfully';
//                  print( "User update password success" );
//          		  exit();
          header( "location:account.php" );
        } else {
			$_SESSION['usererror'] = 'Error: Your password was not able to get updated';
		}

        unset( $_SESSION[ 'passwordmatch-error' ] );
        unset( $_SESSION[ 'duplicate-email' ] );
//        unset( $_SESSION[ 'duplicate-password' ] );
        unset( $_SESSION[ 'passwordsmall-error' ] );
        unset( $_SESSION[ 'oldpassword-error' ] );
        unset( $_SESSION[ 'new' ] );
//        unset( $_SESSION[ 'inputerror' ] );
        unset( $_SESSION[ 'passworderror' ] );
	  

      }
    }




// This is used to get the information of the user when they update their own information on the account page.
if ( isset( $_POST[ 'updateinfo' ] ) ) {
  //print('hereee');
  //	exit();

  $_SESSION[ "firstname" ] = $_POST[ 'firstname' ];
  $_SESSION[ "lastname" ] = $_POST[ 'lastname' ];
  $_SESSION[ "email" ] = $_POST[ 'email' ];

//  $emailresult = $obj->getemail( $_SESSION[ "email" ] );


  if ( $obj->getemail( $_SESSION[ 'email' ] )) {
    $_SESSION[ 'emailerror' ] = true;
    $_SESSION[ 'input-error' ] = true;
    header( "location:account.php" );
  } else {
    unset( $_SESSION[ "emailerror" ] );
    unset( $_SESSION[ 'input-error' ] );
  }

	if ( isset( $_SESSION[ "emailerror" ] ) ) {
      header( "location:account.php" );
    }

  else {
    $successupdate = $obj->insertuser3( $_SESSION[ 'userid' ], $_SESSION[ 'firstname' ], $_SESSION[ 'lastname' ],
      $_SESSION[ 'email' ] );
    if ( $successupdate ) {
		
		$_SESSION['usersuccess'] = 'Your personal information was succesfully changed';
//            print( "User registration success" );
//            exit();
      header( "location:homepage.php" );
    } else {
		$_SESSION['usererror'] = 'Error: Your personal information was unable to get updated';
		header( "location:homepage.php" );
	}

    unset( $_SESSION[ 'duplicate-email' ] );
    unset( $_SESSION[ 'input-error' ] );
    unset( $_SESSION[ 'firstname' ] );
    unset( $_SESSION[ 'lastname' ] );


    exit();
  }
}
?>