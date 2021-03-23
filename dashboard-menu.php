<?php
$cur_page = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
?>
<ul>

	<li class="<?php if($cur_page == 'dashboard.php'){echo 'active';} ?>"><a href="<?php echo BASE_URL.URL_DASHBOARD; ?>"><span><i class="fa fa-arrow-circle-o-right "></i></span>Dashboard</a></li>

	<li class="<?php if($cur_page == 'donor-add.php'){echo 'active';} ?>"><a href="<?php echo BASE_URL.URL_DONOR_ADD; ?>"><span><i class="fa fa-arrow-circle-o-right "></i></span>Add Donor</a></li>

	<li class="<?php if( ($cur_page == 'donor-view.php') || ($cur_page == 'donor-edit.php') ){echo 'active';} ?>"><a href="<?php echo BASE_URL.URL_DONOR_VIEW; ?>"><span><i class="fa fa-arrow-circle-o-right "></i></span>View Donors</a></li>

	<li class="<?php if($cur_page == 'profile-edit.php'){echo 'active';} ?>"><a href="<?php echo BASE_URL.URL_PROFILE_EDIT; ?>"><span><i class="fa fa-arrow-circle-o-right "></i></span>Update Profile Info</a></li>

	<li class="<?php if($cur_page == 'profile-photo-edit.php'){echo 'active';} ?>"><a href="<?php echo BASE_URL.URL_PROFILE_PHOTO_EDIT; ?>"><span><i class="fa fa-arrow-circle-o-right "></i></span>Update Profile Photo</a></li>

	<li class="<?php if($cur_page == 'payment.php'){echo 'active';} ?>"><a href="<?php echo BASE_URL.URL_PAYMENT; ?>"><span><i class="fa fa-arrow-circle-o-right "></i></span>Make Payment</a></li>

	<li><a href="<?php echo BASE_URL.URL_LOGOUT; ?>"><span><i class="fa fa-arrow-circle-o-right "></i></span>Logout</a></li>

</ul>