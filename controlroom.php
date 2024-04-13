<?php
if ( !isset( $_SESSION ) ) {
  session_start();
}

spl_autoload_register( function ( $class ) {
  include_once( 'dtb.php' );
} );


$obj = new dtb_blog;
//exit();


// This takes a user to the landing page, if the user is not logged in.
if ( $obj->userIsLoggedIn() == FALSE ) {
  header( "location:index.html" );
  exit();
}


// This function gets all the blogs that are assosciated with a particular user. 
if ( isset( $_POST[ 'blog-request' ] ) ) {
  //  	print("hereee");
  //  	exit();
  $_SESSION[ 'blogid' ] = $_POST[ 'blogid' ];
  $_SESSION[ 'blogname' ] = $_POST[ 'bgname' ];
  $_SESSION[ 'blog-entry-data' ] = $obj->getentrydata( $_SESSION[ 'blogid' ] );
  $_SESSION[ 'blog-name-info' ] = $obj->getblogname( $_SESSION[ 'blogid' ] );


  //  $_SESSION[ 'bgname' ] = $_SESSION[ 'blog-name-info' ][ 0 ][ 'bgname' ];
  header( "location:blogentry.php" );
  exit();
}


// When a user wants to create a new blog, this functions is used just to do that.
if ( isset( $_POST[ 'newblog' ] ) ) {
  //  print_r( $_POST );
  $bgname = $obj->testinput( $_POST[ 'bgname' ] );
  $bgdescript = $obj->testinput( $_POST[ 'bgdescript' ] );
  $bgdate = $obj->testinput( $_POST[ 'bgdate' ] );
  $userid = $_SESSION[ 'userid' ];

  //  print( $bgname . " " . $bgdescript . " " . $bgdate . " " . $userid );

  $results = $obj->insertblogdata( $bgname, $bgdescript, $bgdate, $userid );

  if ( $results ) {
    //    echo "The topic has been successfully saved";
    $_SESSION[ 'blogsuccess' ] = 'The topic has been successfully saved';
    header( "location:homepage.php" );
    //    exit();
  } else if ( !$results ) {;
    $_SESSION[ 'blogerror' ] = 'Error: The topic was not successfully added';
    //            header( "location:homepage.php" );
    exit();
  }

}


// This is used to edit an entry on the Blogentry.php. It is only used for those entries
if ( isset( $_POST[ 'edit_x' ] ) ) {
  //  print( "editing entry" );
  //  exit();

  $_SESSION[ 'editing-entry' ] = true;
  $_SESSION[ 'entryid' ] = $_POST[ 'entryid' ];
  unset( $_SESSION[ 'editing-draftentry' ] );
  unset( $_SESSION[ 'editing-publishentry' ] );


  header( "location:editentry.php" );
  exit();
}


// Editing the draft entries. This has a session which gets set to edit the draft entries only
if ( isset( $_POST[ 'editdraft_x' ] ) ) {
  //  print( "editing entry" );
  //  exit();

  $_SESSION[ 'editing-draftentry' ] = true;
  $_SESSION[ 'entryid' ] = $_POST[ 'entryid' ];
  unset( $_SESSION[ 'editing-publishentry' ] );
  unset( $_SESSION[ 'editing-entry' ] );

  //	print_r($_SESSION['entryid']);
  //	exit();

  header( "location:editentry.php" );
  exit();
}

// Editing the publish entries. This has a session which gets set to edit the publish entries only
if ( isset( $_POST[ 'editpublish_x' ] ) ) {
  //  print( "editing Published entry" );
  //  exit();

  $_SESSION[ 'editing-publishentry' ] = true;
  $_SESSION[ 'entryid' ] = $_POST[ 'entryid' ];
  unset( $_SESSION[ 'editing-draftentry' ] );
  unset( $_SESSION[ 'editing-entry' ] );
  //	$_SESSION['blogid'] = $_POST['blogid'];

  //	print_r($_SESSION['entryid']);
  //	exit();
  header( "location:editentry.php" );
  exit();
}


// All deletion of entry/blogs happen in this section

//Cofrming deletion of an entry in the Entries page - not the draft/publsih page but when you press view entries on the Blog tab.
//The entries that appear under the blog. This is the function to delete
if ( isset( $_POST[ 'delete_x' ] ) ) {
  //  	print("Deleting entry");
  //  	exit();

  $_SESSION[ 'deleting-entry' ] = true;
  //  $_SESSION[ 'entryid' ] = $_POST[ $result['entryid']];
  $_SESSION[ 'entryid' ] = $_POST[ 'entryid' ];
  header( "location:blogentry.php" );
  exit();
}
// Confirming deletion of an entry under the Publish tab
if ( isset( $_POST[ 'deletepublish_x' ] ) ) {
  //    	print("Deleting Publish entry");
  //    	exit();

  $_SESSION[ 'deleting-entry' ] = true;
  $_SESSION[ 'entryid' ] = $_POST[ 'entryid' ];
  $_SESSION[ 'blogid' ] = $_POST[ 'blogid' ];
  //	print($_SESSION[ 'entryid' ]);
  //	exit();
  header( "location:publish.php" );
  exit();
}

// Deleting an entry under the Publish tab
if ( isset( $_POST[ 'deletepublishentry' ] ) ) {
  //   print("Delete Publish entry");
  //	exit();
  $blogid = $_POST[ 'blogid' ];
  $entryid = $_POST[ 'entryid' ];
  $result = $obj->deleteentry( $entryid );
  if ( $result = true ) {
    $_SESSION[ 'blogsuccess' ] = 'The published entry was deleted successfully';
  } else {
    $_SESSION[ 'blogerror' ] = 'Error: published entry was not deleted successfully';
  }
  unset( $_SESSION[ 'deleting-entry' ] );
  $_SESSION[ 'entryid' ] = $_POST[ 'taskid' ];
  $_SESSION[ 'blog-entry-data' ] = $obj->getentrydata( $_SESSION[ 'blogid' ] );
  header( "location:publish.php" );
  exit();
}

// Confirming deletion of an entry under the draft tab
if ( isset( $_POST[ 'deletedraft_x' ] ) ) {
  //    	print("Deleting entry");
  //    	exit();

  $_SESSION[ 'deleting-entry' ] = true;
  $_SESSION[ 'entryid' ] = $_POST[ 'entryid' ];
  $_SESSION[ 'blogid' ] = $_POST[ 'blogid' ];
  //	print($_SESSION[ 'entryid' ]);
  //	exit();
  header( "location:draft.php" );
  exit();
}


// Deleting an entry under the draft tab
if ( isset( $_POST[ 'ddeleteentry' ] ) ) {
  //   print("Deleting entry");
  //	exit();
  $blogid = $_POST[ 'blogid' ];
  $entryid = $_POST[ 'entryid' ];
  $result = $obj->deleteentry( $entryid );
  if ( $result = true ) {
    $_SESSION[ 'blogsuccess' ] = 'The draft entry was deleted successfully';
  } else {
    $_SESSION[ 'blogerror' ] = 'Error: The draft entry was not deleted successfully';
  }
  unset( $_SESSION[ 'editing-entry' ] );
  unset( $_SESSION[ 'deleting-entry' ] );
  $_SESSION[ 'entryid' ] = $_POST[ 'taskid' ];
  $_SESSION[ 'blog-entry-data' ] = $obj->getentrydata( $_SESSION[ 'blogid' ] );
  // print($statusvalue)
  // exit();
  header( "location:draft.php" );
  exit();
}


//Deleting an entry in the Entries page - not the draft/publsih page but when you press view entries on the Blog tab.
//The entries that appear under the blog. This is the code to delete

if ( isset( $_POST[ 'deleteentry' ] ) ) {
  //   print("Deleting entry");
  //	exit();
  $blogid = $_POST[ 'blogid' ];
  $entryid = $_POST[ 'entryid' ];
  $result = $obj->deleteentry( $entryid );
  if ( $result = true ) {
    $_SESSION[ 'blogsuccess' ] = 'The entry was deleted successfully';
  } else {
    $_SESSION[ 'blogerror' ] = 'Error: The entry was not deleted successfully';
  }
  unset( $_SESSION[ 'editing-entry' ] );
  unset( $_SESSION[ 'deleting-entry' ] );
  $_SESSION[ 'entryid' ] = $_POST[ 'taskid' ];
  $_SESSION[ 'blog-entry-data' ] = $obj->getentrydata( $_SESSION[ 'blogid' ] );
  header( "location:blogentry.php" );
  exit();
}


// This is used to confirm deletion of a blog. 
if ( isset( $_POST[ 'deleteblog_x' ] ) ) {
  //	print("Deleting blog");
  //	exit();
  unset( $_SESSION[ 'editing-entry' ] );
  unset( $_SESSION[ 'blog-entry-data' ] );
  unset( $_SESSION[ 'entryid' ] );
  $_SESSION[ 'deleting-blog' ] = true;
  $_SESSION[ 'blogid' ] = $_POST[ 'blogid' ];
  header( "location:homepage.php" );
  exit();
}

// This is used to delete a blog. 
if ( isset( $_POST[ 'confirm-delete-blog' ] ) ) {
  //	print("deleting entry");

  $_SESSION[ 'blogid' ] = $_POST[ 'blogid' ];
  $obj->deleteblogdata( $_SESSION[ 'blogid' ] );
  $_SESSION[ 'blogsuccess' ] = 'The topic was successfully deleted';
  unset( $_SESSION[ 'deleting-blog' ] );
  unset( $_SESSION[ 'blog-entry-data' ] );
  header( "location:homepage.php" );
  exit();
}


// This is for the modal deletion of a blog. If a user doesn't want to delete a blog, they can exit the modal of the deletion blog.
if ( isset( $_POST[ 'canceldeleteblog' ] ) ) {
  unset( $_SESSION[ 'deleting-blog' ] );
  header( "location:homepage.php" );
  exit();
}

// This is for updating a blog. If a user doesn't want to update a blog, they can exit out of the form
if ( isset( $_POST[ 'cancelupdateblog' ] ) ) {
  unset( $_SESSION[ 'editing-blog' ] );
  header( "location:homepage.php" );
  exit();
}


//This is to exit out of the modal to delete an entry, that are under the Blog Tab.
if ( isset( $_POST[ 'canceldeleteentry' ] ) ) {
  unset( $_SESSION[ 'deleting-entry' ] );
  header( "location:blogentry.php" );
  exit();
}

//This is to exit out of the modal to delete an entry, that are under the Draft Tab.
if ( isset( $_POST[ 'dcanceldeleteentry' ] ) ) {
  unset( $_SESSION[ 'deleting-entry' ] );
  header( "location:draft.php" );
  exit();
}

//This is to exit out of the modal to delete an entry, that are under the Publish Tab.
if ( isset( $_POST[ 'pcanceldeleteentry' ] ) ) {
  unset( $_SESSION[ 'deleting-entry' ] );
  header( "location:publish.php" );
  exit();
}

//This is to exit out of the form to edit an entry, that are under the Blog Tab.
//if ( isset( $_POST[ 'cancelupdateentry' ] ) ) {
//  unset( $_SESSION[ 'editing-entry' ] );
//  header( "location:blogentry.php" );
//  exit();
//}


// This is used to update an entry - not the draft/publsih page but when you press view entries on the Blog tab.
//The entries that appear under the blog. This is the function to update an entry
if ( isset( $_POST[ 'updateentry' ] ) ) {
  //  	print("Updating Entrys" .$statusid);
  //        print_r( $_POST );
  $blogid = $obj->testinput( $_POST[ 'blogid' ] );
  $entryid = $obj->testinput( $_POST[ 'entryid' ] );
  $entname = $obj->testinput( $_POST[ 'entname' ] );
  $enttext = $obj->testinput( $_POST[ 'enttext' ] );
  $entdate = $obj->testinput( $_POST[ 'entdate' ] );
  $statusid = $_POST[ 'statusid' ];

  //  	print($blogid .'  '. $entryid .'  '. $entname .'  '. $enttext .'  '. $entdate .'  '. $statusid );
  //	exit();
  $entryupdateresults = $obj->updateentrydata( $entryid, $entname, $enttext, $blogid, $entdate, $statusid );

  if ( $entryupdateresults == true ) {
    $_SESSION[ 'blogsuccess' ] = 'The entry was successfully updated';

  } else if ( $entryupdateresults == false ) {
    $_SESSION[ 'blogerror' ] = 'Error: The new entry was not successfully updated';
    //    header( "location:blogentry.php" );
    //    exit();
  }
  $_SESSION[ 'blog-entry-data' ] = $obj->getentrydata( $_SESSION[ 'blogid' ] );
  header( "location:blogentry.php" );
  exit();
}


//This is used to update the draft entries if the user decides not to publish it, but to save it as draft and edit/publish the entry later.
if ( isset( $_POST[ 'updatedraftentry' ] ) ) {
  print( "Updating Daft Entrys" );
  print_r( $_POST );
  $blogid = $obj->testinput( $_POST[ 'blogid' ] );
  $entryid = $obj->testinput( $_POST[ 'entryid' ] );
  $entname = $obj->testinput( $_POST[ 'entname' ] );
  $enttext = $obj->testinput( $_POST[ 'enttext' ] );
  $entdate = $obj->testinput( $_POST[ 'entdate' ] );
  $statusid = $_POST[ 'statusid' ];

  //  	print($blogid .'  '. $entryid .'  '. $entname .'  '. $enttext .'  '. $entdate .'  '. $statusid );
  //	exit();
  $entryupdateresults = $obj->updateentrydata( $entryid, $entname, $enttext, $blogid, $entdate, $statusid );


  if ( $entryupdateresults == true ) {

    $_SESSION[ 'blogsuccess' ] = 'The entry was successfully updated';
    //        print( $_SESSION[ 'entry-create-success' ] );
    //        exit();


  } else if ( $entryupdateresults == false ) {
    $_SESSION[ 'blogerror' ] = 'Error: The new entry was not successfully updated';
  }
  $_SESSION[ 'blog-entry-data' ] = $obj->getentrydata( $_SESSION[ 'blogid' ] );
  header( "location:draft.php" );
  exit();

}

//This is used to update the published entries if the user decides not to publish it, but to save it as draft and edit and publish for later
if ( isset( $_POST[ 'updatepublishentry' ] ) ) {
  //  	print("Updating Publish Entrys");
  //	exit();
  $blogid = $obj->testinput( $_POST[ 'blogid' ] );
  $entryid = $obj->testinput( $_POST[ 'entryid' ] );
  $entname = $obj->testinput( $_POST[ 'entname' ] );
  $enttext = $obj->testinput( $_POST[ 'enttext' ] );
  $entdate = $obj->testinput( $_POST[ 'entdate' ] );
  $statusid = $_POST[ 'statusid' ];

  //  	print($blogid .'  '. $entryid .'  '. $entname .'  '. $enttext .'  '. $entdate .'  '. $statusid );
  //	exit();
  $entryupdateresults = $obj->updateentrydata( $entryid, $entname, $enttext, $blogid, $entdate, $statusid );

  if ( $entryupdateresults == true ) {

    $_SESSION[ 'blogsuccess' ] = 'The entry was successfully updated';

  } else if ( $entryupdateresults == false ) {
    $_SESSION[ 'blogerror' ] = 'Error: The new entry was not successfully updateddee';
    //        print( $_SESSION[ 'entry-create-fail' ] );
    //     	  exit();

  }
  $_SESSION[ 'blog-entry-data' ] = $obj->getentrydata( $_SESSION[ 'blogid' ] );
  header( "location:publish.php" );
  exit();

}

// This is responbile for opening up a form to edit the blog
if ( isset( $_POST[ 'editblog_x' ] ) ) {
  //	print("hereeeee");
  //	exit();
  $_SESSION[ 'blogid' ] = $_POST[ 'blogid' ];
  $_SESSION[ 'editing-blog' ] = true;
  header( "location:homepage.php" );
  exit();
}


// This is used to update the blog when the form is submitted.
if ( isset( $_POST[ 'updateblog' ] ) ) {
  $blogid = $obj->testinput( $_POST[ 'blogid' ] );
  $bgname = $obj->testinput( $_POST[ 'bgname' ] );
  $bgdescript = $obj->testinput( $_POST[ 'bgdescript' ] );
  $bgdate = $obj->testinput( $_POST[ 'bgdate' ] );
  $userid = $obj->testinput( $_SESSION[ 'userid' ] );


  //	print( $blogid ." " . $bgname . " " . $bgdescript . " " . $bgdate . " " . $userid);

  $results = $obj->editblogdata( $blogid, $bgname, $bgdescript, $bgdate, $userid );

  if ( $results ) {

    $_SESSION[ 'blogupdate ' ] = true;
    unset( $_SESSION[ 'editing-blog' ] );
    $_SESSION[ 'blogsuccess' ] = "The topic has been successfully saved";
    header( "location:homepage.php" );
    exit();
  } else if ( !$results ) {
    $_SESSION[ 'blogerror' ] = "Error: The topic was not successfully added.";
    //        header( "location:index1.php" );
    exit();
  }
}


// This is used to save an entry as draft. It hard codes the status number 2 into the database.
if ( isset( $_POST[ 'draftentry' ] ) ) {
  //	print("Saving to draft");
  //	exit();

  $entname = $obj->testinput( $_POST[ 'entname' ] );
  $entdate = $obj->testinput( $_POST[ 'entdate' ] );
  $enttext = $obj->testinput( $_POST[ 'enttext' ] );
  $blogid = $_SESSION[ 'blogid' ];
  $statusid = 2;

  //  	print_r($entname ." ". $enttext ." ". $blogid ." ". $statusid ." ". $entdate);
  //exit();
  $entryresults = $obj->insertentrydata( $entname, $enttext, $blogid, $statusid, $entdate );

  if ( $entryresults ) {
    //        echo "The task has been successfully saved";
    //    header( "location:index1.php" );
    $_SESSION[ 'blogsuccess' ] = "The entry has been successfully saved as draft";

  } else if ( !$entryresults ) {
    $_SESSION[ 'blogerror' ] = "Error: The entry was not successfully saved as draftttt";
    //    exit();
  }

  header( "location:draft.php" );
  exit();

}

// This is used to publish a new entry to the publish tab. It hard codes the status number 1 into the database.
if ( isset( $_POST[ 'publishnewentry' ] ) ) {
  //	print("Publishing Entry");
  //	exit();

  $entname = $obj->testinput( $_POST[ 'entname' ] );
  $entdate = $obj->testinput( $_POST[ 'entdate' ] );
  $enttext = $obj->testinput( $_POST[ 'enttext' ] );
  $blogid = $_SESSION[ 'blogid' ];
  $statusid = 1;
  //	

  //	print_r($entname ." ". $enttext ." ". $blogid ." ". $statusid ." ". $entdate);
  //	exit();

  $entryresults = $obj->insertpublishdata( $entname, $enttext, $blogid, $statusid, $entdate );

  if ( $entryresults ) {
    $_SESSION[ 'blogsuccess' ] = "The new entry has been successfully published";
  } else if ( !$entryresults ) {
    $_SESSION[ 'blogerror' ] = "Error: The new entry was not successfully published";
  }
  //Commet them out to see how it works
  $_SESSION[ 'blog-entry-data' ] = $obj->getentrydata( $_SESSION[ 'blogid' ] );

  header( "location:publish.php" );
  exit();
}


// This is used to publish an entry, that was previously saved as a draft. It hard codes the statusid to 1
if ( isset( $_POST[ 'publishentry' ] ) ) {
  //	print("Publishing Entry");
  //	exit();

  $entname = $obj->testinput( $_POST[ 'entname' ] );
  $entdate = $obj->testinput( $_POST[ 'entdate' ] );
  $enttext = $obj->testinput( $_POST[ 'enttext' ] );
  $blogid = $_SESSION[ 'blogid' ];
  $entryid = $_POST[ 'entryid' ];
  $statusid = 1;
  //	

  //  print_r( $entryid . " " . $entname . " " . $enttext . " " . $blogid . " " . $statusid . " " . $entdate );
  //  exit();

  $entryresults = $obj->updatepublishdata( $entryid, $entname, $enttext, $blogid, $statusid, $entdate );
  //	$entryresults = $obj->updatepublishdata( $statusid, $entryid);

  if ( $entryresults ) {
    $_SESSION[ 'blogsuccess' ] = "The entry has been successfully published";
  } else if ( !$entryresults ) {
    $_SESSION[ 'blogerror' ] = "Error: The entry was not successfully published";
  }
  //Commet them out to see how it works
  $_SESSION[ 'blog-entry-data' ] = $obj->getentrydata( $_SESSION[ 'blogid' ] );


  header( "location:publish.php" );
  exit();

}


// This is used to draft an entry, that was previously saved as a published entry. It hard codes the statusid to 2
if ( isset( $_POST[ 'pdraftentry' ] ) ) {
  //	print("Publishing Entry");
  //	exit();

  $entname = $obj->testinput( $_POST[ 'entname' ] );
  $entdate = $obj->testinput( $_POST[ 'entdate' ] );
  $enttext = $obj->testinput( $_POST[ 'enttext' ] );
  $blogid = $_POST[ 'blogid' ];
  $entryid = $_POST[ 'entryid' ];
  $statusid = 2;
  //	

  //	print_r($entryid ." ". $entname ." ". $enttext ." ". $blogid ." ". $statusid ." ". $entdate);
  //	exit();

  $entryresults = $obj->updatepublishdata( $entryid, $entname, $enttext, $blogid, $statusid, $entdate );
  //	$entryresults = $obj->updatepublishdata( $statusid, $entryid);

  if ( $entryresults ) {
    $_SESSION[ 'blogsuccess' ] = "The entry has been successfully saved as draft";
  } else if ( !$entryresults ) {
    $_SESSION[ 'blogerror' ] = "Error: The entry was not successfully saved save as draft";
  }
  $_SESSION[ 'blog-entry-data' ] = $obj->getentrydata( $_SESSION[ 'blogid' ] );


  header( "location:draft.php" );
  exit();

}


// This is use to preview the information when editing an entry. 
//This is because the user will prefer to come back on the previous page when they click pn the back arrow. 
// They will not prefer to go back to the homepage or another page. 
if ( isset( $_POST[ 'previewentry' ] ) ) {
  //	print('Previewing Entry');
  //	exit();


  $_SESSION[ 'entname' ] = $_POST[ 'entname' ];
  $_SESSION[ 'entdate' ] = $_POST[ 'entdate' ];
  $_SESSION[ 'enttext' ] = $_POST[ 'enttext' ];
  $_SESSION[ 'blogid' ] = $_POST[ 'blogid' ];
  $statusid = $_POST[ 'statusid' ];

  header( "location:editentry.php" );
  //	header("http://localhost/blog/previewyourentry.php");

}


//  This is use to preview the information when on the Blogentry. 
// This is because the user will prefer to come back on the previous page when they click pn the back arrow. 
// They will not prefer to go back to the homepage or another page. 
if ( isset( $_POST[ 'previewblogentry' ] ) ) {
  //	print('Previewing Entry');
  //	exit();


  $_SESSION[ 'previewblogentry' ] = true;
  $_SESSION[ 'entryid' ] = $_POST[ 'entryid' ];
  $_SESSION[ 'blogid' ] = $_POST[ 'blogid' ];
  unset( $_SESSION[ 'previewpublishentry' ] );
  unset( $_SESSION[ 'previewdraftentry' ] );
  unset( $_SESSION[ 'previewNEWentry' ] );
  unset( $_SESSION[ 'previewentry' ] );
  header( "location:previewyourentry.php" );

}


//  This is use to preview the information when on the Publish Page. 
// This is because the user will prefer to come back on the previous page when they click pn the back arrow.
// They will not prefer to go back to the homepage or another page. 
if ( isset( $_POST[ 'previewpublish' ] ) ) {
  //	print('Previewing Publish');
  //	exit();


  $_SESSION[ 'previewpublishentry' ] = true;
  $_SESSION[ 'blogid' ] = $_POST[ 'blogid' ];
  $_SESSION[ 'entryid' ] = $_POST[ 'entryid' ];
  unset( $_SESSION[ 'previewblogentry' ] );
  unset( $_SESSION[ 'previewdraftentry' ] );
  unset( $_SESSION[ 'previewNEWentry' ] );
  unset( $_SESSION[ 'previewentry' ] );

  header( "location:previewyourentry.php" );
}


//  This is use to preview the information when on the Draft Page. 
//This is because the user will prefer to come back on the previous page when they click pn the back arrow. 
// They will not prefer to go back to the homepage or another page. 
if ( isset( $_POST[ 'preivewdraft' ] ) ) {
  //	print('Previewing Draft');
  //	exit();


  $_SESSION[ 'previewdraftentry' ] = true;
  $_SESSION[ 'blogid' ] = $_POST[ 'blogid' ];
  $_SESSION[ 'entryid' ] = $_POST[ 'entryid' ];
  unset( $_SESSION[ 'previewblogentry' ] );
  unset( $_SESSION[ 'previewpublishentry' ] );
  unset( $_SESSION[ 'previewNEWentry' ] );
  unset( $_SESSION[ 'previewentry' ] );

  header( "location:previewyourentry.php" );
}


//  This is use to preview the information when on the Editing entry. 
//This is because the user will prefer to come back on the previous page when they click pn the back arrow. 
//They will not prefer to go back to the homepage or another page. 
if ( isset( $_POST[ 'previewentry' ] ) ) {
  //	print('Previewing New Entry');
  //	exit();


  $_SESSION[ 'previewentry' ] = true;
  $_SESSION[ 'entryid' ] = $_POST[ 'entryid' ];
  $_SESSION[ 'blogid' ] = $_POST[ 'blogid' ];


  //		$_SESSION['previewentry'] = true;
  //	$_SESSION ['entname'] = $_POST['entname'];
  //	$_SESSION ['entdate'] = $_POST['entdate'];
  //	$_SESSION ['enttext'] = $_POST['enttext'];
  //	$_SESSION[ 'blogid'] =	$_POST['blogid'];

  unset( $_SESSION[ 'previewblogentry' ] );
  unset( $_SESSION[ 'previewpublishentry' ] );
  unset( $_SESSION[ 'previewdraftentry' ] );
  unset( $_SESSION[ 'previewNEWentry' ] );
  header( "location:previewyourentry.php" );

}


//This is  to exit out of the modal to update a user, that are under the users Tab.
if ( isset( $_POST[ 'cancelupdateuser' ] ) ) {
  unset( $_SESSION[ 'editing-users' ] );
  //  unset( $_SESSION[ 'changepassword_other' ] );
  header( "location:users.php" );
  exit();
}

//This is to open the form that is used to edit a user
if ( isset( $_POST[ 'edituser_x' ] ) ) {
  //  print('Editing User');
  //	exit();

  $_SESSION[ 'useridotheruser' ] = $_POST[ 'userid' ];
  $_SESSION[ 'editing-users' ] = true;
  header( "location:users.php" );
}


// This is used to update a user in the users tab. It validates the informations that is been sent
if ( isset( $_POST[ 'updateuser' ] ) ) {

  //print("Updating user");
  //	exit();
  $_SESSION[ "firstname" ] = $_POST[ 'firstname' ];
  $_SESSION[ "lastname" ] = $_POST[ 'lastname' ];
  $_SESSION[ "email_otheruser" ] = $_POST[ 'email' ];
  $_SESSION[ "otheruser" ] = $_POST[ 'userid' ];
  $usertype = $_POST[ 'status' ];

  //	print_r($_SESSION[ 'usertype' ]);
  //	exit();
  $emailresult = $obj->getemail( $_SESSION[ "email_otheruser" ] );


  if ( $obj->getemail( $_SESSION[ "email_otheruser" ] ) ) {
    $_SESSION[ 'duplicateemail' ] = true;
    $_SESSION[ 'usererror' ] = 'Error: User was not updated. Make sure email is not a duplicate';
    //    $_SESSION[ 'input-error' ] = true;
    header( "location:users.php" );
  } else {
    unset( $_SESSION[ "duplicate-email" ] );
    unset( $_SESSION[ 'usertype' ] );
    //    unset( $_SESSION[ 'input-error' ] );
    $successupdate = $obj->insertuser2( $_SESSION[ "otheruser" ], $_SESSION[ 'firstname' ], $_SESSION[ 'lastname' ],
      $_SESSION[ "email_otheruser" ], $usertype );
    if ( $successupdate ) {

      $_SESSION[ 'usersuccess' ] = "User update was a success";
      //            exit();
      unset( $_SESSION[ 'editing-users' ] );
      header( "location:users.php" );
    } else {
      $_SESSION[ 'usererror' ] = "Error: User update was not a success";
      header( "location:users.php" );
    }
  }

  //      unset( $_SESSION[ 'passwordmatch-error' ] );
  unset( $_SESSION[ 'duplicateemail' ] );
  //      unset( $_SESSION[ 'passwordsmall-error' ] );
  unset( $_SESSION[ 'input-error' ] );
  unset( $_SESSION[ 'firstname' ] );
  unset( $_SESSION[ 'lastname' ] );
  //      unset( $_SESSION[ 'username' ] );
  //    unset( $_SESSION[ 'email' ] );

  exit();
}

//}

// This is used to confirm of the deletion of a user under the users tab 
if ( isset( $_POST[ 'deleteuser_x' ] ) ) {
  //  print('Deleting User');
  //	exit();

  unset( $_SESSION[ 'editing-users' ] );
  $_SESSION[ 'userid_otheruser' ] = $_POST[ 'userid' ];
  //  unset( $_SESSION[ 'blog-entry-data' ] );
  //  unset( $_SESSION[ 'entryid' ] );
  $_SESSION[ 'deleting-user' ] = true;
  //  $_SESSION[ 'userid' ];
  header( "location:users.php" );
  exit();

}

// This is used to exit out of the modal which shows the options of deleting a user
if ( isset( $_POST[ 'canceldeleteuser' ] ) ) {
  unset( $_SESSION[ 'deleting-user' ] );
  header( "location:users.php" );
  exit();
}


// This is used to delete a user fromt he Administration Page
if ( isset( $_POST[ 'confirm-delete-user' ] ) ) {
  //	print("deleting user");
  //	exit();

  $userid_other = $_POST[ 'userid' ];
  $obj->deleteuserdata( $userid_other );

  if ( $obj->deleteuserdata( $userid_other ) ) {
    $_SESSION[ 'usersuccess' ] = 'The user was deleted successfully';

  } else {
    $_SESSION[ 'usererror' ] = 'The user was not deleted';
  }
  unset( $_SESSION[ 'deleting-user' ] );
  unset( $_SESSION[ 'editing-users' ] );
  $_SESSION[ 'userinfo' ] = $obj->getuserinfo( $_SESSION[ 'userid' ] );
  $_SESSION[ 'allusers' ] = $obj->getallusers();
  header( "location:users.php" );
  exit();
}


/* To get into the page where an admin can chnage the password of the user in case the user forgets their password> */
if ( isset( $_POST[ 'changepasswordotheruser' ] ) ) {
  //	print('hereee');
  //	exit();
  $_SESSION[ 'otheruserid' ] = $_POST[ 'userid' ];
  $_SESSION[ 'changepassword2' ] = true;
  header( "location:users.php" );
}

/* If the admin decides not to change the user's password. They cancel it and unset any error variables and other variables.*/
if ( isset( $_POST[ 'cancelchangepassword' ] ) ) {
  //	print('hereee');
  //	exit();
  unset( $_SESSION[ 'changepassword2' ] );
  unset( $_SESSION[ 'new' ] );
  unset( $_SESSION[ 'passwordnull' ] );
  unset( $_SESSION[ 'passwordmatch-error' ] );
  unset( $_SESSION[ 'passwordsmall-error' ] );
  header( "location:users.php" );
}


// This code is used to change the password of a user from the admin page. This includes encrypting the hash and updating the user input.
if ( isset( $_POST[ 'updatepassword' ] ) ) {
  //	print("Updating password");
  //	exit();

  $otheruserid = $_POST[ "userid" ];
  $newpassword = $obj->testinput( $_POST[ "newpassword" ] );
  $confirmnewpassword = $obj->testinput( $_POST[ "confirmnewpassword" ] );

  //	print_r( $newpassword ." ". $confirmnewpassword);
  //	exit();


  $newpasswordhash = password_hash( $newpassword, PASSWORD_DEFAULT );

  if ( $newpassword != $confirmnewpassword ) {
    //		print("passwords don't match");
    //		exit();
    unset( $_SESSION[ 'passwordsmall-error' ] );
    unset( $_SESSION[ 'passwordnull' ] );
    $_SESSION[ 'new' ] = true;
    $_SESSION[ 'passwordmatch-error' ] = true;
    header( "location:users.php" );
  } else {
    //        print( "passwords match" );
    //        exit();
    unset( $_SESSION[ 'passwordmatch-error' ] );
    unset( $_SESSION[ 'new' ] );
  }

  if ( strlen( $newpassword ) < 8 ) {
    unset( $_SESSION[ 'passwordmatch-error' ] );
    unset( $_SESSION[ 'passwordnull' ] );
    $_SESSION[ 'passwordsmall-error' ] = true;
    $_SESSION[ 'new' ] = true;
    header( "location:users.php" );
  } else {
    unset( $_SESSION[ 'passwordsmall-error' ] );
    unset( $_SESSION[ 'new' ] );
  }

  if ( empty( $newpassword ) ) {
    unset( $_SESSION[ 'passwordmatch-error' ] );
    unset( $_SESSION[ 'passwordsmall-error' ] );
    $_SESSION[ 'new' ] = true;
    $_SESSION[ 'passwordnull' ] = true;
    header( "location:users.php" );
  } else if ( empty( $confirmnewpassword ) ) {
    unset( $_SESSION[ 'passwordmatch-error' ] );
    unset( $_SESSION[ 'passwordsmall-error' ] );
    $_SESSION[ 'new' ] = true;
    $_SESSION[ 'passwordnull' ] = true;
    header( "location:users.php" );
  } else if ( isset( $_SESSION[ 'passwordsmall-error' ] ) ) {
    header( "location:users.php" );
    //		  exit();
  } else if ( isset( $_SESSION[ "passwordmatch-error" ] ) ) {
    header( "location:users.php" );
    //	  exit();
  } else if ( isset( $_SESSION[ "new" ] ) ) {
    header( "location:users.php" );
    //	  exit();
  } else {
    $successupdate = $obj->insertnewpassword( $otheruserid, $newpasswordhash );
    if ( $successupdate ) {
      $_SESSION[ 'usersuccess' ] = 'The password of the user has been changed successfully';
      //                  print( "User update password success" );
      //          		  exit();
      //          header( "location:users.php" );
    } else {
      $_SESSION[ 'usererror' ] = 'Error: The password of the user failed to updated';
    }

    unset( $_SESSION[ 'changepassword2' ] );
    unset( $_SESSION[ 'passwordmatch-error' ] );
    unset( $_SESSION[ 'passwordsmall-error' ] );
    unset( $_SESSION[ 'new' ] );
    header( "location:users.php" );


  }
}


?>