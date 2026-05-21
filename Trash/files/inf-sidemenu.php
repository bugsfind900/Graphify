<?php 
$basename = substr(strtolower(basename($_SERVER['PHP_SELF'])),0,strlen(basename($_SERVER['PHP_SELF']))-4);
?>
<div class="col-md-4 sidebar-block">
	<div class="widget sidebar-widget widget_links">
		<h3 class="widgettitle">Information</h3>
		<ul>
			<li <?php if ($basename == 'inf-apartment-housing-society-law') echo 'class="active"'; ?>><a href="inf-apartment-housing-society-law.php">Laws and By-Laws</a></li>
			<li <?php if ($basename == 'inf-faq') echo 'class="active"'; ?>><a href="inf-faq.php">Frequently Asked Questions</a></li>
			<li <?php if ($basename == 'inf-termsandconditions') echo 'class="active"'; ?>><a href="inf-termsandconditions.php">Terms and Conditions</a></li>
			<li <?php if ($basename == 'inf-privacy-policy') echo 'class="active"'; ?>><a href="inf-privacy-policy.php">Privacy Policy</a></li>
			<li <?php if ($basename == 'inf-help') echo 'class="active"'; ?>><a href="inf-help.php">Help</a></li>
		</ul>
	</div>
</div>