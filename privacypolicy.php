<?php
if ( !isset( $_SESSION ) ) {
  session_start();
}

//spl_autoload_register( function ( $class ) {
//  include_once( 'dtb.php' );
//} );
//
//$obj = new dtb_blog;
//
//if ( !isset( $_SESSION[ 'loggedIn' ] ) ) {
//  header( "location:controlroom.php" );
//  exit();
//};

  unset( $_SESSION[ 'passwordmatch-error' ] );
  unset( $_SESSION[ 'duplicate-email' ] );
  unset( $_SESSION[ 'passwordsmall-error' ] );
  unset( $_SESSION[ 'input-error' ] );
  unset( $_SESSION[ 'passworderror' ] );
  unset( $_SESSION[ 'loginError' ] );

?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Homepage | Blogit </title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="css/style.css">
<link rel="preconnect" href="https://fonts.googleapisa.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
</head>

<body>
<nav id="navbar">
  <div class="nav-logo">
    <h1>BLOG<span class="text-primary">it.</span></h1>
  </div>
  <div id="nav-menu"> <a href="index.html">Home</a> 
    <!--				<a href="#about">About</a>--> 
    <a href="community.php">Community</a> <a href="login.php" class="btn">Login</a> <a href="registration.php" class="btn">Signup</a> </div>
</nav>
<div class="container2">
  <section class="privacy">
    <h1 class="text-primary">Privacy Policy</h1>
    <br>
    <p>
    <h3>Privacy Policy for BlOGit.</h3>
    <p>At BlOGit., accessible from blog%205/index.html, one of our main priorities is the privacy of our visitors. This Privacy Policy document contains types of information that is collected and recorded by BlOGit. and how we use it. If you have additional questions or require more information about our Privacy Policy, do not hesitate to contact us.
      This Privacy Policy applies only to our online activities and is valid for visitors to our website with regards to the information that they shared and/or collect in BlOGit.. This policy is not applicable to any information collected offline or via channels other than this website. Our Privacy Policy was created with the help of the Free Privacy Policy Generator.</p>
    </p>
    <br>
    <h3>Consent</h3>
    <p>By using our website, you hereby consent to our Privacy Policy and agree to its terms. Information we collect, the personal information that you are asked to provide, and the reasons why you are asked to provide it, will be made clear to you at the point we ask you to provide your personal information. <br>
      <br>
      If you contact us directly, we may receive additional information about you such as your name, email address, the contents of the message and/or attachments you may send us, and any other information you may choose to provide. When you register for an Account, we may ask for your contact information, including items such as firstname and lastname, and email address. </p>
    <br>
    <h3>How we use your information</h3>
	<p>We use the information we collect in various ways, including to:</p>
    <ul>
      <li>Provide, operate, and maintain our website</li>
      <li>Improve, personalize, and expand our website</li>
      <li>Understand and analyze how you use our website</li>
      <li>Develop new products, services, features, and functionality</li>
      <li>Communicate with you, either directly or through one of our partners, including for customer service, to provide you with updates and other information relating to the website, and for marketing and promotional purposes</li>
      <li>Send you emails</li>
      <li>Find and prevent fraud</li>
      <li>Log Files</li>
    </ul>
    <br>
    <h3>BlOGit. follows a standard procedure of using log files.</h3>
    <p> These files log visitors when they visit websites. All hosting companies do this and a part of hosting services' analytics. The information collected by log files include internet protocol (IP) addresses, browser type, Internet Service Provider (ISP), date and time stamp, referring/exit pages, and possibly the number of clicks. These are not linked to any information that is personally identifiable. The purpose of the information is for analyzing trends, administering the site, tracking users' movement on the website, and gathering demographic information. </p>
    Third-party ad servers or ad networks uses technologies like cookies, JavaScript, or Web Beacons that are used in their respective advertisements and links that appear on BlOGit., which are sent directly to users' browser. They automatically receive your IP address when this occurs. These technologies are used to measure the effectiveness of their advertising campaigns and/or to personalize the advertising content that you see on websites that you visit. <br>
    Note that BlOGit. has no access to or control over these cookies that are used by third-party advertisers. <br>
    Third Party Privacy Policies
    BlOGit.'s Privacy Policy does not apply to other advertisers or websites. Thus, we are advising you to consult the respective Privacy Policies of these third-party ad servers for more detailed information. It may include their practices and instructions about how to opt-out of certain options.
    
    You can choose to disable cookies through your individual browser options. To know more detailed information about cookie management with specific web browsers, it can be found at the browsers' respective websites. <br>
    <br>
    <h3>CCPA Privacy Rights (Do Not Sell My Personal Information)</h3>
    <p>Under the CCPA, among other rights, California consumers have the right to:</p>
    <ul>
      <li>Request that a business that collects a consumer's personal data disclose the categories and specific pieces of personal data that a business has collected about consumers.</li>
      <li>Request that a business delete any personal data about the consumer that a business has collected.</li>
      <li>Request that a business that sells a consumer's personal data, not sell the consumer's personal data.</li>
      <li>If you make a request, we have one month to respond to you. If you would like to exercise any of these rights, please contact us.</li>
    </ul>
    <br>
    <h3>GDPR Data Protection Rights</h3>
    We would like to make sure you are fully aware of all of your data protection rights. Every user is entitled to the following:
    <ul>
      <li>The right to access – You have the right to request copies of your personal data. We may charge you a small fee for this service.</li>
      <li>The right to rectification – You have the right to request that we correct any information you believe is inaccurate. You also have the right to request that we complete the information you believe is incomplete.</li>
      <li>The right to erasure – You have the right to request that we erase your personal data, under certain conditions.</li>
      <li>The right to restrict processing – You have the right to request that we restrict the processing of your personal data, under certain conditions.</li>
      <li>The right to object to processing – You have the right to object to our processing of your personal data, under certain conditions.</li>
      <li>The right to data portability – You have the right to request that we transfer the data that we have collected to another organization, or directly to you, under certain conditions.</li>
      <li>If you make a request, we have one month to respond to you. If you would like to exercise any of these rights, please contact us.</li>
    </ul>
	<br>
    <h3>Children's Information</h3>
    <p>Another part of our priority is adding protection for children while using the internet. We encourage parents and guardians to observe, participate in, and/or monitor and guide their online activity. BlOGit. does not knowingly collect any Personal Identifiable Information from children under the age of 13. If you think that your child provided this kind of information on our website, we strongly encourage you to contact us immediately and we will do our best efforts to promptly remove such information from our records.<br>
    </p>
  </section>
</div>
	

<!-- Footer -->
<footer class="footer ">
  <div class="container">
    <p>Copyright; <script>document.write(new Date().getFullYear())</script> All Rights Reserved</p>
  </div>
</footer>
<script src="js/scroll.js"></script>
</body>
</html>