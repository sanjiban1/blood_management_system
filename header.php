<?php
ob_start();
session_start();
include("admin/config.php");
include("admin/functions.php");
$error_message = '';
$success_message = '';
$error_message1 = '';
$success_message1 = '';
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=?");
$statement->execute(array(1));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
foreach ($result as $row) {
	$mod_rewrite = $row['mod_rewrite'];
}
if($mod_rewrite == 'Off') {
	define("URL_CATEGORY", "category.php?slug=");
	define("URL_PAGE", "page.php?slug=");
	define("URL_NEWS", "news.php?slug=");
	define("URL_SERVICE", "service.php?slug=");
	define("URL_TEAM", "team-member.php?slug=");
	define("URL_DONOR", "donor.php?id=");
	define("URL_DONOR_EDIT", "donor-edit.php?id=");
	define("URL_DONOR_DELETE", "donor-delete.php?id=");
	define("URL_AGENT", "agent.php?id=");
	define("URL_BLOOD_GROUPWISE_RESULT", "blood-groupwise-result.php?id=");
	define("URL_SEARCH", "search.php");
	define("URL_LOGIN", "login.php");
	define("URL_LOGOUT", "logout.php");
	define("URL_REGISTRATION", "registration.php");
	define("URL_FORGET_PASSWORD", "forget-password.php");
	define("URL_DASHBOARD", "dashboard.php");
	define("URL_PAYMENT", "payment.php");
	define("URL_DONOR_ADD", "donor-add.php");
	define("URL_DONOR_VIEW", "donor-view.php");
	define("URL_PROFILE_EDIT", "profile-edit.php");
	define("URL_PROFILE_PHOTO_EDIT", "profile-photo-edit.php");
} else {
	define("URL_CATEGORY", "category/");
	define("URL_PAGE", "page/");
	define("URL_NEWS", "news/");
	define("URL_SERVICE", "service/");
	define("URL_TEAM", "team-member/");
	define("URL_DONOR", "donor/");
	define("URL_DONOR_EDIT", "donor-edit/");
	define("URL_DONOR_DELETE", "donor-delete/");
	define("URL_AGENT", "agent/");
	define("URL_BLOOD_GROUPWISE_RESULT", "blood-groupwise-result/");
	define("URL_SEARCH", "search");
	define("URL_LOGIN", "login");
	define("URL_LOGOUT", "logout");
	define("URL_REGISTRATION", "registration");
	define("URL_FORGET_PASSWORD", "forget-password");
	define("URL_DASHBOARD", "dashboard");
	define("URL_PAYMENT", "payment");
	define("URL_DONOR_ADD", "donor-add");
	define("URL_DONOR_VIEW", "donor-view");
	define("URL_PROFILE_EDIT", "profile-edit");
	define("URL_PROFILE_PHOTO_EDIT", "profile-photo-edit");
}
// Getting the basic data for the website from database
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row)
{
	$logo = $row['logo'];
	$favicon = $row['favicon'];
	$contact_email = $row['contact_email'];
	$contact_phone = $row['contact_phone'];
}
?>
<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
	<!-- Meta Tags -->
	<meta name="viewport" content="width=device-width,initial-scale=1.0" />
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />

	<?php
	
	// Getting the current page URL
	$cur_page = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);

	if($cur_page == 'news.php')
	{
		$statement = $pdo->prepare("SELECT * FROM tbl_news WHERE news_slug=?");
		$statement->execute(array($_REQUEST['slug']));
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
		foreach ($result as $row) 
		{
		    $og_photo = $row['photo'];
		    $og_title = $row['news_title'];
		    $og_slug = $row['news_slug'];
			$og_description = substr(strip_tags($row['news_content']),0,200).'...';
			echo '<meta name="description" content="'.$row['meta_description'].'">';
			echo '<meta name="keywords" content="'.$row['meta_keyword'].'">';
			echo '<title>'.$row['meta_title'].'</title>';
		}
	}

	if($cur_page == 'page.php')
	{
		$statement = $pdo->prepare("SELECT * FROM tbl_page WHERE page_slug=?");
		$statement->execute(array($_REQUEST['slug']));
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
		foreach ($result as $row) 
		{
			echo '<meta name="description" content="'.$row['meta_description'].'">';
			echo '<meta name="keywords" content="'.$row['meta_keyword'].'">';
			echo '<title>'.$row['meta_title'].'</title>';
		}
	}

	if($cur_page == 'category.php')
	{
		$statement = $pdo->prepare("SELECT * FROM tbl_category WHERE category_slug=?");
		$statement->execute(array($_REQUEST['slug']));
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
		foreach ($result as $row)
		{
			echo '<meta name="description" content="'.$row['meta_description'].'">';
			echo '<meta name="keywords" content="'.$row['meta_keyword'].'">';
			echo '<title>'.$row['meta_title'].'</title>';
		}
	}

	if($cur_page == 'index.php')
	{
		$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
		$statement->execute();
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
		foreach ($result as $row) 
		{
			echo '<meta name="description" content="'.$row['meta_description_home'].'">';
			echo '<meta name="keywords" content="'.$row['meta_keyword_home'].'">';
			echo '<title>'.$row['meta_title_home'].'</title>';
		}
	}
	?>

	<!-- Favicon -->
	<link href="<?php echo BASE_URL; ?>assets/uploads/<?php echo $favicon; ?>" rel="shortcut icon" type="image/png">

	<!-- Stylesheets -->
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>css/jquery-ui.css">
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>css/lightbox.min.css">
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>css/owl.carousel.min.css">
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>css/normalize.css">
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>css/slicknav.min.css">
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>css/style.css">
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>css/responsive.css">
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>css/chosen.css">
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>css/datatable.min.css">


	<?php if($cur_page == 'news.php'): ?>
		<meta property="og:title" content="<?php echo $og_title; ?>">
		<meta property="og:type" content="website">
		<meta property="og:url" content="<?php echo BASE_URL.URL_NEWS.$og_slug; ?>">
		<meta property="og:description" content="<?php echo $og_description; ?>">
		<meta property="og:image" content="<?php echo BASE_URL; ?>assets/uploads/<?php echo $og_photo; ?>">
	<?php endif; ?>

	<script type="text/javascript" src="//platform-api.sharethis.com/js/sharethis.js#property=5993ef01e2587a001253a261&product=inline-share-buttons"></script>

</head>

<body>

<?php
// Getting Facebook comment code from the database
$statement = $pdo->prepare("SELECT * FROM tbl_comment WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
foreach ($result as $row) 
{
	echo $row['code_body'];
}
?>

	<!--Preloader Start-->
	<div id="preloader">
		<div id="status" style="background-image: url(<?php echo BASE_URL; ?>img/preloader/preloader.gif)"></div>
	</div>
	<!--Preloader End-->

	<!--Top-Header Start-->
	<div class="top-header">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-sm-6 col-xs-12">
					<div class="top-header-left">
						<p><i class="fa fa-phone"></i> <?php echo $contact_phone; ?></p>
						<p><i class="fa fa-envelope-o"></i> <?php echo $contact_email; ?></p>
					</div>
				</div>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<div class="top-header-right">
						
						<?php if(!isset($_SESSION['agent'])): ?>
							<a href="<?php echo BASE_URL.URL_LOGIN; ?>"><i class="fa fa-sign-in"></i>Agent LogIn</a>
						<?php else: ?>
							Logged in as: <?php echo $_SESSION['agent']['agent_name']; ?>
							|
							<a href="<?php echo BASE_URL.URL_DASHBOARD; ?>">Dashboard</a>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!--Menu Start-->
	<div class="menu-area">
		<div class="container">
			<div class="row">
				<div class="col-md-4 col-sm-12 col-xs-12">
					<div class="logo">
						<a href="<?php echo BASE_URL; ?>"><img src="<?php echo BASE_URL; ?>assets/uploads/<?php echo $logo; ?>" alt=""></a>
					</div>
				</div>
				<div class="col-md-8 col-sm-9">
					<div class="menu">
						<ul id="nav" class="main-menu">
							
							<?php
								// Showing the menu dynamically from the database
								$statement = $pdo->prepare("SELECT * FROM tbl_menu ORDER BY menu_order ASC");
								$statement->execute();
								$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
								foreach ($result as $row) 
								{
									echo '<li>';
									if($row['menu_parent']==0)
									{
										if($row['menu_type']=='Category')
										{
											echo '
											<a href="'.BASE_URL.URL_CATEGORY.$row['category_or_page_slug'].'">
												<span class="menu-title">
													'.$row['menu_name'].'
												</span>
											</a>
											';
										}
										if($row['menu_type']=='Page')
										{
											echo '
											<a href="'.BASE_URL.URL_PAGE.$row['category_or_page_slug'].'">
												<span class="menu-title">
													'.$row['menu_name'].'
												</span>
											</a>
											';
										}
										if($row['menu_type']=='Other')
										{
											echo '<a href="'.$row['menu_url'].'">';
											echo '
												<span class="menu-title">
													'.$row['menu_name'].'
												</span>
												';
											echo '</a>';
										}
									}

									$statement1 = $pdo->prepare("SELECT * FROM tbl_menu WHERE menu_parent=?");
									$statement1->execute(array($row['menu_id']));
									$total = $statement1->rowCount();
									if($total)
									{
										echo '<ul>';
										$result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);							
										foreach ($result1 as $row1) 
										{
											echo '<li>';
											if($row1['menu_type']=='Category')
											{
												echo '<a href="'.BASE_URL.URL_CATEGORY.$row1['category_or_page_slug'].'">';
											}
											if($row1['menu_type']=='Page')
											{
												echo '<a href="'.BASE_URL.URL_PAGE.$row1['category_or_page_slug'].'">';
											}
											if($row1['menu_type']=='Other')
											{
												echo '<a href="'.$row1['menu_url'].'">';
											}											
											echo $row1['menu_name'];
											echo '</a>';
											echo '</li>';
										}
										echo '</ul>';
									}
									echo '</li>';
								}
							?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>