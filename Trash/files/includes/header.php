<?php
session_start();
ob_start();
include("functions.php");

$res_count = getResCount();
$ticket_count = getTicketCount();
$bill_count = getBillCount();
$notice_count = getNoticeCount();
$app_count = getAppDownloadCount();
$get_state = getstates();

if($_POST['submit']!="")
{    
    $formData=$_POST;
	register($formData);
    header("Location:index.php");
	exit();
}
     
$basename = substr(strtolower(basename($_SERVER['PHP_SELF'])),0,strlen(basename($_SERVER['PHP_SELF']))-4);
?>
<header class="site-header">
	<div class="container">
		<div class="site-logo">
			<a href="index.php" class="default-logo"><img src="images/logo.png" alt="Logo" style="height:40px !important;"></a>
			<a href="index.php" class="default-retina-logo"><img src="images/logo%402x.png" alt="Logo"></a>
			<a href="index.php" class="sticky-logo"><img src="images/sticky-logo.png" alt="Logo" style="height:40px !important;"></a>
			<a href="index.php" class="sticky-retina-logo"><img src="images/sticky-logo%402x.png" alt="Logo"></a>
		</div>
		<a href="#" class="visible-sm visible-xs" id="menu-toggle"><i class="fa fa-bars"></i></a>
		<!-- <div class="header-info-col"><i class="fa fa-phone"></i> +91 124 410 8277</div> -->
		<ul class="sf-menu dd-menu pull-right" role="menu">
			<li><a href="index.php">Home</a></li>
			<li><a href="#">About</a>
				<ul>
					<li><a href="society-connect-company-profile.php"><i class="fa fa-building"></i> &nbsp;&nbsp;Company Profile</a></li>
					<li><a href="why-society-connect.php"><i class="fa fa-magic"></i> &nbsp;&nbsp;Why SocietyConnect</a></li>
					<li><a href="index.php#partners"><i class="fa fa-users"></i> &nbsp;Official Partners</a></li>
					<li><a href="career-society-connect.php"><i class="fa fa-briefcase"></i> &nbsp;&nbsp;Careers</a></li>
					<li><a href="testimonials-society-connect.php"><i class="fa fa-comment"></i> &nbsp;&nbsp;Testimonials</a></li>
				</ul>
			</li>
			<li><a href="index.php#features">Features</a>
				<ul>
					<li><a href="resident-management-system.php"><i class="fa fa-magic"></i> &nbsp;Resident Management System</a>
					<li><a href="accounts-billing.php"><i class="fa fa-magic"></i> &nbsp;&nbsp;Accounts & Billing Automation</a></li>
					<li><a href="http://www.gateguardian.in/gate-guardian-for-condominiums.php" target="_blank"><i class="fa fa-magic"></i> &nbsp;Gate Guardian</a>
					<li><a href="resident-mobile-app.php"><i class="fa fa-magic"></i> &nbsp;Resident Mobile APP</a>							
					<li><a href="society-talk-and-house-konnect.php"><i class="fa fa-magic"></i> &nbsp;SocietyTalk & House Konnect</a>						
					<li><a href="security-reliability.php"><i class="fa fa-magic"></i> &nbsp;Security and Reliability</a>							
				</ul>
			</li>                    
			<li><a href="#">Information</a>
				<ul>
					<li><a href="inf-apartment-housing-society-law.php"><i class="fa fa-institution"></i> &nbsp;Apartment/Housing Society Laws and Bye-Laws</a>
					<li><a href="inf-faq.php"><i class="fa fa-question-circle"></i> &nbsp;&nbsp;Frequently Asked Questions</a></li>
					<li><a href="inf-termsandconditions.php"><i class="fa fa-list-ul"></i> &nbsp;Terms and Conditions</a>
					<li><a href="inf-privacy-policy.php"><i class="fa fa-user-secret"></i> &nbsp;Privacy Policy</a>							
				</ul>
			</li>
			<li><a href="#">Downloads</a>
				<ul>
					<li><a href="https://play.google.com/store/apps/details?id=society.connect"><i class="fa fa-android"></i> &nbsp;Android Application</a>
					<li><a href="https://itunes.apple.com/in/app/societyconnect-in/id1137904589?mt=8"><i class="fa fa-apple"></i> &nbsp;Apple Application</a></li>							
				</ul>
			</li>
			<li><a href="plans-society-connect.php">Plans</a></li>
			<li><a href="http://blog.societyconnect.in/" target="_blank">Blog</a></li>
			<!--<li><a href="#">Contact</a>
				<ul>
				<li><a href="contact-society-connect.php">Contact Us</a></li>
				<li><a href="contact-society-connect.php#support">Request Support</a></li>
				</ul>
			</li>-->
		</ul>
	</div>
</header>
