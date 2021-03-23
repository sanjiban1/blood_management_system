<?php require_once('header.php'); ?>

<?php
if(isset($_POST['form1'])) {
	$valid = 1;

	$path = $_FILES['photo_logo']['name'];
    $path_tmp = $_FILES['photo_logo']['tmp_name'];

    if($path == '') {
    	$valid = 0;
        $error_message .= 'You must have to select a photo<br>';
    } else {
        $ext = pathinfo( $path, PATHINFO_EXTENSION );
        $file_name = basename( $path, '.' . $ext );
        if( $ext!='jpg' && $ext!='png' && $ext!='jpeg' && $ext!='gif' ) {
            $valid = 0;
            $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
        }
    }

    if($valid == 1) {
    	// removing the existing photo
    	$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
    	$statement->execute();
    	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
    	foreach ($result as $row) {
    		$logo = $row['logo'];
    		unlink('../assets/uploads/'.$logo);
    	}

    	// updating the data
    	$final_name = 'logo'.'.'.$ext;
        move_uploaded_file( $path_tmp, '../assets/uploads/'.$final_name );

        // updating the database
		$statement = $pdo->prepare("UPDATE tbl_settings SET logo=? WHERE id=1");
		$statement->execute(array($final_name));

        $success_message = 'Logo is updated successfully.';
    	
    }
}

if(isset($_POST['form2'])) {
	$valid = 1;

	$path = $_FILES['photo_favicon']['name'];
    $path_tmp = $_FILES['photo_favicon']['tmp_name'];

    if($path == '') {
    	$valid = 0;
        $error_message .= 'You must have to select a photo<br>';
    } else {
        $ext = pathinfo( $path, PATHINFO_EXTENSION );
        $file_name = basename( $path, '.' . $ext );
        if( $ext!='jpg' && $ext!='png' && $ext!='jpeg' && $ext!='gif' ) {
            $valid = 0;
            $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
        }
    }

    if($valid == 1) {
    	// removing the existing photo
    	$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
    	$statement->execute();
    	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
    	foreach ($result as $row) {
    		$favicon = $row['favicon'];
    		unlink('../assets/uploads/'.$favicon);
    	}

    	// updating the data
    	$final_name = 'favicon'.'.'.$ext;
        move_uploaded_file( $path_tmp, '../assets/uploads/'.$final_name );

        // updating the database
		$statement = $pdo->prepare("UPDATE tbl_settings SET favicon=? WHERE id=1");
		$statement->execute(array($final_name));

        $success_message = 'Favicon is updated successfully.';
    	
    }
}

if(isset($_POST['form3'])) {
	
	// updating the database
	$statement = $pdo->prepare("UPDATE tbl_settings SET footer_about=?, footer_copyright=?, contact_address=?, contact_email=?, contact_phone=?, contact_fax=?, contact_map_iframe=? WHERE id=1");
	$statement->execute(array($_POST['footer_about'],$_POST['footer_copyright'],$_POST['contact_address'],$_POST['contact_email'],$_POST['contact_phone'],$_POST['contact_fax'],$_POST['contact_map_iframe']));

	$success_message = 'General content settings is updated successfully.';
    
}

if(isset($_POST['form4'])) {
	// updating the database
	$statement = $pdo->prepare("UPDATE tbl_settings SET receive_email=?, receive_email_subject=?,receive_email_thank_you_message=?, donor_email_subject=?,donor_email_thank_you_message=?,forget_password_message=? WHERE id=1");
	$statement->execute(array($_POST['receive_email'],$_POST['receive_email_subject'],$_POST['receive_email_thank_you_message'],$_POST['donor_email_subject'],$_POST['donor_email_thank_you_message'],$_POST['forget_password_message']));

	$success_message = 'Contact form settings information is updated successfully.';
}


if(isset($_POST['form5'])) {
	// updating the database
	$statement = $pdo->prepare("UPDATE tbl_settings SET total_recent_news_footer=?, total_popular_news_footer=?, total_recent_news_sidebar=?, total_popular_news_sidebar=?, total_recent_news_home_page=? WHERE id=1");
	$statement->execute(array($_POST['total_recent_news_footer'],$_POST['total_popular_news_footer'],$_POST['total_recent_news_sidebar'],$_POST['total_popular_news_sidebar'],$_POST['total_recent_news_home_page']));

	$success_message = 'Sidebar settings is updated successfully.';
}



if(isset($_POST['form6'])) {
	// updating the database
	$statement = $pdo->prepare("UPDATE tbl_settings SET meta_title_home=?, meta_keyword_home=?, meta_description_home=? WHERE id=1");
	$statement->execute(array($_POST['meta_title_home'],$_POST['meta_keyword_home'],$_POST['meta_description_home']));

	$success_message = 'Home Meta settings is updated successfully.';
}

if(isset($_POST['form6_1'])) {

    $valid = 1;

    if(empty($_POST['search_title'])) {
        $valid = 0;
        $error_message .= 'Search Title can not be empty<br>';
    }

    $path = $_FILES['search_photo']['name'];
    $path_tmp = $_FILES['search_photo']['tmp_name'];

    if($path != '') {
        $ext = pathinfo( $path, PATHINFO_EXTENSION );
        $file_name = basename( $path, '.' . $ext );
        if( $ext!='jpg' && $ext!='png' && $ext!='jpeg' && $ext!='gif' ) {
            $valid = 0;
            $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
        }
    }

    if($valid == 1) {


        if($path != '') {
            // removing the existing photo
            $statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);                           
            foreach ($result as $row) {
                $search_photo = $row['search_photo'];
                unlink('../assets/uploads/'.$search_photo);
            }

            // updating the data
            $final_name = 'search'.'.'.$ext;
            move_uploaded_file( $path_tmp, '../assets/uploads/'.$final_name );

            // updating the database
            $statement = $pdo->prepare("UPDATE tbl_settings SET search_title=?, search_photo=? WHERE id=1");
            $statement->execute(array($_POST['search_title'],$final_name));
        } else {
            // updating the database
            $statement = $pdo->prepare("UPDATE tbl_settings SET search_title=? WHERE id=1");
            $statement->execute(array($_POST['search_title']));
        }

        $success_message = 'Search Data is updated successfully.';
        
    }
}


if(isset($_POST['form6_2'])) {

    $valid = 1;

    $path = $_FILES['testimonial_photo']['name'];
    $path_tmp = $_FILES['testimonial_photo']['tmp_name'];

    if($path != '') {
        $ext = pathinfo( $path, PATHINFO_EXTENSION );
        $file_name = basename( $path, '.' . $ext );
        if( $ext!='jpg' && $ext!='png' && $ext!='jpeg' && $ext!='gif' ) {
            $valid = 0;
            $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
        }
    } else {
        $valid = 0;
        $error_message .= 'You must have to select a photo<br>';
    }

    if($valid == 1) {


        // removing the existing photo
        $statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);                           
        foreach ($result as $row) {
            $testimonial_photo = $row['testimonial_photo'];
            unlink('../assets/uploads/'.$testimonial_photo);
        }

        // updating the data
        $final_name = 'testimonial'.'.'.$ext;
        move_uploaded_file( $path_tmp, '../assets/uploads/'.$final_name );

        // updating the database
        $statement = $pdo->prepare("UPDATE tbl_settings SET testimonial_photo=? WHERE id=1");
        $statement->execute(array($final_name));
        

        $success_message = 'Testimonial Photo is updated successfully.';
        
    }
}

if(isset($_POST['form6_3'])) {

        // updating the database
        $statement = $pdo->prepare("UPDATE tbl_settings SET newsletter_text=? WHERE id=1");
        $statement->execute(array($_POST['newsletter_text']));
        
        $success_message = 'Newsletter Text is updated successfully.';
 
}

if(isset($_POST['form7_1'])) {
	$valid = 1;

	$path = $_FILES['photo']['name'];
    $path_tmp = $_FILES['photo']['tmp_name'];

    if($path == '') {
    	$valid = 0;
        $error_message .= 'You must have to select a photo<br>';
    } else {
        $ext = pathinfo( $path, PATHINFO_EXTENSION );
        $file_name = basename( $path, '.' . $ext );
        if( $ext!='jpg' && $ext!='png' && $ext!='jpeg' && $ext!='gif' ) {
            $valid = 0;
            $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
        }
    }

    if($valid == 1) {
    	// removing the existing photo
    	$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
    	$statement->execute();
    	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
    	foreach ($result as $row) {
    		$banner_login = $row['banner_login'];
    		unlink('../assets/uploads/'.$banner_login);
    	}

    	// updating the data
    	$final_name = 'banner_login'.'.'.$ext;
        move_uploaded_file( $path_tmp, '../assets/uploads/'.$final_name );

        // updating the database
		$statement = $pdo->prepare("UPDATE tbl_settings SET banner_login=? WHERE id=1");
		$statement->execute(array($final_name));

        $success_message = 'Login Page Banner is updated successfully.';
    	
    }
}

if(isset($_POST['form7_2'])) {
	$valid = 1;

	$path = $_FILES['photo']['name'];
    $path_tmp = $_FILES['photo']['tmp_name'];

    if($path == '') {
    	$valid = 0;
        $error_message .= 'You must have to select a photo<br>';
    } else {
        $ext = pathinfo( $path, PATHINFO_EXTENSION );
        $file_name = basename( $path, '.' . $ext );
        if( $ext!='jpg' && $ext!='png' && $ext!='jpeg' && $ext!='gif' ) {
            $valid = 0;
            $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
        }
    }

    if($valid == 1) {
    	// removing the existing photo
    	$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
    	$statement->execute();
    	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
    	foreach ($result as $row) {
    		$banner_registration = $row['banner_registration'];
    		unlink('../assets/uploads/'.$banner_registration);
    	}

    	// updating the data
    	$final_name = 'banner_registration'.'.'.$ext;
        move_uploaded_file( $path_tmp, '../assets/uploads/'.$final_name );

        // updating the database
		$statement = $pdo->prepare("UPDATE tbl_settings SET banner_registration=? WHERE id=1");
		$statement->execute(array($final_name));

        $success_message = 'Registration Page Banner is updated successfully.';
    	
    }
}

if(isset($_POST['form7_3'])) {
	$valid = 1;

	$path = $_FILES['photo']['name'];
    $path_tmp = $_FILES['photo']['tmp_name'];

    if($path == '') {
    	$valid = 0;
        $error_message .= 'You must have to select a photo<br>';
    } else {
        $ext = pathinfo( $path, PATHINFO_EXTENSION );
        $file_name = basename( $path, '.' . $ext );
        if( $ext!='jpg' && $ext!='png' && $ext!='jpeg' && $ext!='gif' ) {
            $valid = 0;
            $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
        }
    }

    if($valid == 1) {
    	// removing the existing photo
    	$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
    	$statement->execute();
    	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
    	foreach ($result as $row) {
    		$banner_forget_password = $row['banner_forget_password'];
    		unlink('../assets/uploads/'.$banner_forget_password);
    	}

    	// updating the data
    	$final_name = 'banner_forget_password'.'.'.$ext;
        move_uploaded_file( $path_tmp, '../assets/uploads/'.$final_name );

        // updating the database
		$statement = $pdo->prepare("UPDATE tbl_settings SET banner_forget_password=? WHERE id=1");
		$statement->execute(array($final_name));

        $success_message = 'Forget Password Page Banner is updated successfully.';
    	
    }
}

if(isset($_POST['form7_4'])) {
	$valid = 1;

	$path = $_FILES['photo']['name'];
    $path_tmp = $_FILES['photo']['tmp_name'];

    if($path == '') {
    	$valid = 0;
        $error_message .= 'You must have to select a photo<br>';
    } else {
        $ext = pathinfo( $path, PATHINFO_EXTENSION );
        $file_name = basename( $path, '.' . $ext );
        if( $ext!='jpg' && $ext!='png' && $ext!='jpeg' && $ext!='gif' ) {
            $valid = 0;
            $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
        }
    }

    if($valid == 1) {
    	// removing the existing photo
    	$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
    	$statement->execute();
    	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
    	foreach ($result as $row) {
    		$banner_blog = $row['banner_blog'];
    		unlink('../assets/uploads/'.$banner_blog);
    	}

    	// updating the data
    	$final_name = 'banner_blog'.'.'.$ext;
        move_uploaded_file( $path_tmp, '../assets/uploads/'.$final_name );

        // updating the database
		$statement = $pdo->prepare("UPDATE tbl_settings SET banner_blog=? WHERE id=1");
		$statement->execute(array($final_name));

        $success_message = 'Blog Page Banner is updated successfully.';
    	
    }
}

if(isset($_POST['form7_5'])) {
    $valid = 1;

    $path = $_FILES['photo']['name'];
    $path_tmp = $_FILES['photo']['tmp_name'];

    if($path == '') {
        $valid = 0;
        $error_message .= 'You must have to select a photo<br>';
    } else {
        $ext = pathinfo( $path, PATHINFO_EXTENSION );
        $file_name = basename( $path, '.' . $ext );
        if( $ext!='jpg' && $ext!='png' && $ext!='jpeg' && $ext!='gif' ) {
            $valid = 0;
            $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
        }
    }

    if($valid == 1) {
        // removing the existing photo
        $statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);                           
        foreach ($result as $row) {
            $banner_donor = $row['banner_donor'];
            unlink('../assets/uploads/'.$banner_donor);
        }

        // updating the data
        $final_name = 'banner_donor'.'.'.$ext;
        move_uploaded_file( $path_tmp, '../assets/uploads/'.$final_name );

        // updating the database
        $statement = $pdo->prepare("UPDATE tbl_settings SET banner_donor=? WHERE id=1");
        $statement->execute(array($final_name));

        $success_message = 'Donor Page Banner is updated successfully.';
        
    }
}

if(isset($_POST['form7_5_1'])) {
    $valid = 1;

    $path = $_FILES['photo']['name'];
    $path_tmp = $_FILES['photo']['tmp_name'];

    if($path == '') {
        $valid = 0;
        $error_message .= 'You must have to select a photo<br>';
    } else {
        $ext = pathinfo( $path, PATHINFO_EXTENSION );
        $file_name = basename( $path, '.' . $ext );
        if( $ext!='jpg' && $ext!='png' && $ext!='jpeg' && $ext!='gif' ) {
            $valid = 0;
            $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
        }
    }

    if($valid == 1) {
        // removing the existing photo
        $statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);                           
        foreach ($result as $row) {
            $banner_agent = $row['banner_agent'];
            unlink('../assets/uploads/'.$banner_agent);
        }

        // updating the data
        $final_name = 'banner_agent'.'.'.$ext;
        move_uploaded_file( $path_tmp, '../assets/uploads/'.$final_name );

        // updating the database
        $statement = $pdo->prepare("UPDATE tbl_settings SET banner_agent=? WHERE id=1");
        $statement->execute(array($final_name));

        $success_message = 'Agent Page Banner is updated successfully.';
        
    }
}


if(isset($_POST['form7_6'])) {
    $valid = 1;

    $path = $_FILES['photo']['name'];
    $path_tmp = $_FILES['photo']['tmp_name'];

    if($path == '') {
        $valid = 0;
        $error_message .= 'You must have to select a photo<br>';
    } else {
        $ext = pathinfo( $path, PATHINFO_EXTENSION );
        $file_name = basename( $path, '.' . $ext );
        if( $ext!='jpg' && $ext!='png' && $ext!='jpeg' && $ext!='gif' ) {
            $valid = 0;
            $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
        }
    }

    if($valid == 1) {
        // removing the existing photo
        $statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);                           
        foreach ($result as $row) {
            $banner_search = $row['banner_search'];
            unlink('../assets/uploads/'.$banner_search);
        }

        // updating the data
        $final_name = 'banner_search'.'.'.$ext;
        move_uploaded_file( $path_tmp, '../assets/uploads/'.$final_name );

        // updating the database
        $statement = $pdo->prepare("UPDATE tbl_settings SET banner_search=? WHERE id=1");
        $statement->execute(array($final_name));

        $success_message = 'Search Page Banner is updated successfully.';
        
    }
}

if(isset($_POST['form8'])) {
	// updating the database
	$statement = $pdo->prepare("UPDATE tbl_settings SET mod_rewrite=? WHERE id=1");
	$statement->execute(array($_POST['mod_rewrite']));

	$success_message = 'Mod Rewrite settings is updated successfully.';
}
if(isset($_POST['form9'])) {
	// updating the database
	$statement = $pdo->prepare("UPDATE tbl_settings SET paypal_email=? WHERE id=1");
	$statement->execute(array($_POST['paypal_email']));

	$success_message = 'PayPal email is updated successfully.';
}
?>

<section class="content-header">
	<div class="content-header-left">
		<h1>Settings</h1>
	</div>
</section>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
foreach ($result as $row) {
	$logo                            = $row['logo'];
	$favicon                         = $row['favicon'];
	$footer_about                    = $row['footer_about'];
	$footer_copyright                = $row['footer_copyright'];
	$contact_address                 = $row['contact_address'];
	$contact_email                   = $row['contact_email'];
	$contact_phone                   = $row['contact_phone'];
	$contact_fax                     = $row['contact_fax'];
	$contact_map_iframe              = $row['contact_map_iframe'];
	$receive_email                   = $row['receive_email'];
	$receive_email_subject           = $row['receive_email_subject'];
	$receive_email_thank_you_message = $row['receive_email_thank_you_message'];
	$donor_email_subject            = $row['donor_email_subject'];
	$donor_email_thank_you_message  = $row['donor_email_thank_you_message'];
	$forget_password_message         = $row['forget_password_message'];
	$total_recent_news_footer        = $row['total_recent_news_footer'];
	$total_popular_news_footer       = $row['total_popular_news_footer'];
	$total_recent_news_sidebar       = $row['total_recent_news_sidebar'];
	$total_popular_news_sidebar      = $row['total_popular_news_sidebar'];
	$total_recent_news_home_page     = $row['total_recent_news_home_page'];
	$meta_title_home                 = $row['meta_title_home'];
	$meta_keyword_home               = $row['meta_keyword_home'];
	$meta_description_home           = $row['meta_description_home'];
	$banner_login                    = $row['banner_login'];
	$banner_registration             = $row['banner_registration'];
	$banner_forget_password          = $row['banner_forget_password'];
	$banner_blog                     = $row['banner_blog'];
    $banner_donor                    = $row['banner_donor'];
    $banner_agent                    = $row['banner_agent'];
    $banner_search                   = $row['banner_search'];
    $search_title                    = $row['search_title'];
    $search_photo                    = $row['search_photo'];
    $testimonial_photo               = $row['testimonial_photo'];
    $newsletter_text                 = $row['newsletter_text'];
	$mod_rewrite                     = $row['mod_rewrite'];
	$paypal_email                    = $row['paypal_email'];
}
?>


<section class="content" style="min-height:auto;margin-bottom: -30px;">
	<div class="row">
		<div class="col-md-12">
			<?php if($error_message): ?>
			<div class="callout callout-danger">
			
			<p>
			<?php echo $error_message; ?>
			</p>
			</div>
			<?php endif; ?>

			<?php if($success_message): ?>
			<div class="callout callout-success">
			
			<p><?php echo $success_message; ?></p>
			</div>
			<?php endif; ?>
		</div>
	</div>
</section>

<section class="content">

	<div class="row">
		<div class="col-md-12">
							
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#tab_1" data-toggle="tab">Logo</a></li>
						<li><a href="#tab_2" data-toggle="tab">Favicon</a></li>
						<li><a href="#tab_3" data-toggle="tab">Footer & Contact</a></li>
						<li><a href="#tab_4" data-toggle="tab">Email</a></li>
						<li><a href="#tab_5" data-toggle="tab">News</a></li>
						<li><a href="#tab_6" data-toggle="tab">Home Page</a></li>
						<li><a href="#tab_7" data-toggle="tab">Banner</a></li>
						<li><a href="#tab_8" data-toggle="tab">Mod Rewrite</a></li>
						<li><a href="#tab_9" data-toggle="tab">PayPal Email</a></li>
					</ul>
					<div class="tab-content">
          				<div class="tab-pane active" id="tab_1">


          					<form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
          					<div class="box box-info">
								<div class="box-body">
									<div class="form-group">
							            <label for="" class="col-sm-2 control-label">Existing Photo</label>
							            <div class="col-sm-6" style="padding-top:6px;">
							                <img src="../assets/uploads/<?php echo $logo; ?>" class="existing-photo" style="height:80px;">
							            </div>
							        </div>
									<div class="form-group">
							            <label for="" class="col-sm-2 control-label">New Photo</label>
							            <div class="col-sm-6" style="padding-top:6px;">
							                <input type="file" name="photo_logo">
							            </div>
							        </div>
							        <div class="form-group">
										<label for="" class="col-sm-2 control-label"></label>
										<div class="col-sm-6">
											<button type="submit" class="btn btn-success pull-left" name="form1">Update Logo</button>
										</div>
									</div>
								</div>
							</div>
							</form>

							


          				</div>
          				<div class="tab-pane" id="tab_2">

          					<form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
							<div class="box box-info">
								<div class="box-body">
									<div class="form-group">
							            <label for="" class="col-sm-2 control-label">Existing Photo</label>
							            <div class="col-sm-6" style="padding-top:6px;">
							                <img src="../assets/uploads/<?php echo $favicon; ?>" class="existing-photo" style="height:40px;">
							            </div>
							        </div>
									<div class="form-group">
							            <label for="" class="col-sm-2 control-label">New Photo</label>
							            <div class="col-sm-6" style="padding-top:6px;">
							                <input type="file" name="photo_favicon">
							            </div>
							        </div>
							        <div class="form-group">
										<label for="" class="col-sm-2 control-label"></label>
										<div class="col-sm-6">
											<button type="submit" class="btn btn-success pull-left" name="form2">Update Favicon</button>
										</div>
									</div>
								</div>
							</div>
							</form>


          				</div>
          				<div class="tab-pane" id="tab_3">

							<form class="form-horizontal" action="" method="post">
							<div class="box box-info">
								<div class="box-body">
									<div class="form-group">
										<label for="" class="col-sm-2 control-label">Footer - About Us </label>
										<div class="col-sm-9">
											<textarea class="form-control" name="footer_about" id="editor1"><?php echo $footer_about; ?></textarea>
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-2 control-label">Footer - Copyright </label>
										<div class="col-sm-9">
											<input class="form-control" type="text" name="footer_copyright" value="<?php echo $footer_copyright; ?>">
										</div>
									</div>								
									<div class="form-group">
										<label for="" class="col-sm-2 control-label">Contact Address </label>
										<div class="col-sm-6">
											<textarea class="form-control" name="contact_address" style="height:140px;"><?php echo $contact_address; ?></textarea>
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-2 control-label">Contact Email </label>
										<div class="col-sm-6">
											<input type="text" class="form-control" name="contact_email" value="<?php echo $contact_email; ?>">
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-2 control-label">Contact Phone Number </label>
										<div class="col-sm-6">
											<input type="text" class="form-control" name="contact_phone" value="<?php echo $contact_phone; ?>">
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-2 control-label">Contact Fax Number </label>
										<div class="col-sm-6">
											<input type="text" class="form-control" name="contact_fax" value="<?php echo $contact_fax; ?>">
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-2 control-label">Contact Map iFrame </label>
										<div class="col-sm-9">
											<textarea class="form-control" name="contact_map_iframe" style="height:200px;"><?php echo $contact_map_iframe; ?></textarea>
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-2 control-label"></label>
										<div class="col-sm-6">
											<button type="submit" class="btn btn-success pull-left" name="form3">Update</button>
										</div>
									</div>
								</div>
							</div>
							</form>


          				</div>

          				<div class="tab-pane" id="tab_4">

          					<form class="form-horizontal" action="" method="post">
							<div class="box box-info">
								<div class="box-body">
									<div class="form-group">
										<label for="" class="col-sm-3 control-label">Contact Email Address</label>
										<div class="col-sm-4">
											<input type="text" class="form-control" name="receive_email" value="<?php echo $receive_email; ?>">
										</div>
									</div>									
									<div class="form-group">
										<label for="" class="col-sm-3 control-label">Contact Email Subject</label>
										<div class="col-sm-8">
											<input type="text" class="form-control" name="receive_email_subject" value="<?php echo $receive_email_subject; ?>">
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-3 control-label">Contact Email Thank you message</label>
										<div class="col-sm-8">
											<textarea class="form-control" name="receive_email_thank_you_message"><?php echo $receive_email_thank_you_message; ?></textarea>
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-3 control-label">Donor Email Subject</label>
										<div class="col-sm-8">
											<input type="text" class="form-control" name="donor_email_subject" value="<?php echo $donor_email_subject; ?>">
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-3 control-label">Donor Email Thank you message</label>
										<div class="col-sm-8">
											<textarea class="form-control" name="donor_email_thank_you_message"><?php echo $donor_email_thank_you_message; ?></textarea>
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-3 control-label">Forget password Message</label>
										<div class="col-sm-8">
											<textarea class="form-control" name="forget_password_message"><?php echo $forget_password_message; ?></textarea>
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-3 control-label"></label>
										<div class="col-sm-5">
											<button type="submit" class="btn btn-success pull-left" name="form4">Update</button>
										</div>
									</div>
								</div>
							</div>
							</form>


          				</div>

          				<div class="tab-pane" id="tab_5">

          					<form class="form-horizontal" action="" method="post">
							<div class="box box-info">
								<div class="box-body">
									<div class="form-group">
										<label for="" class="col-sm-4 control-label">Footer (How many recent news?)<span>*</span></label>
										<div class="col-sm-2">
											<input type="text" class="form-control" name="total_recent_news_footer" value="<?php echo $total_recent_news_footer; ?>">
										</div>
									</div>		
									<div class="form-group">
										<label for="" class="col-sm-4 control-label">Footer (How many popular news?)<span>*</span></label>
										<div class="col-sm-2">
											<input type="text" class="form-control" name="total_popular_news_footer" value="<?php echo $total_popular_news_footer; ?>">
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-4 control-label">Sidebar (How many recent news?)<span>*</span></label>
										<div class="col-sm-2">
											<input type="text" class="form-control" name="total_recent_news_sidebar" value="<?php echo $total_recent_news_sidebar; ?>">
										</div>
									</div>		
									<div class="form-group">
										<label for="" class="col-sm-4 control-label">Sidebar (How many popular news?)<span>*</span></label>
										<div class="col-sm-2">
											<input type="text" class="form-control" name="total_popular_news_sidebar" value="<?php echo $total_popular_news_sidebar; ?>">
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-4 control-label">Home Page (How many recent news?)<span>*</span></label>
										<div class="col-sm-2">
											<input type="text" class="form-control" name="total_recent_news_home_page" value="<?php echo $total_recent_news_home_page; ?>">
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-4 control-label"></label>
										<div class="col-sm-6">
											<button type="submit" class="btn btn-success pull-left" name="form5">Update</button>
										</div>
									</div>
								</div>
							</div>
							</form>


          				</div>




          				<div class="tab-pane" id="tab_6">
                            
                            <h3>Meta Section</h3>
          					<form class="form-horizontal" action="" method="post">
							<div class="box box-info">
								<div class="box-body">
									<div class="form-group">
										<label for="" class="col-sm-2 control-label">Meta Title </label>
										<div class="col-sm-9">
											<input type="text" name="meta_title_home" class="form-control" value="<?php echo $meta_title_home ?>">
										</div>
									</div>		
									<div class="form-group">
										<label for="" class="col-sm-2 control-label">Meta Keyword </label>
										<div class="col-sm-9">
											<textarea class="form-control" name="meta_keyword_home" style="height:100px;"><?php echo $meta_keyword_home ?></textarea>
										</div>
									</div>	
									<div class="form-group">
										<label for="" class="col-sm-2 control-label">Meta Description </label>
										<div class="col-sm-9">
											<textarea class="form-control" name="meta_description_home" style="height:200px;"><?php echo $meta_description_home ?></textarea>
										</div>
									</div>	
									<div class="form-group">
										<label for="" class="col-sm-2 control-label"></label>
										<div class="col-sm-6">
											<button type="submit" class="btn btn-success pull-left" name="form6">Update</button>
										</div>
									</div>
								</div>
							</div>
							</form>
                            
                            <h3>Search Section</h3>
                            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                            <div class="box box-info">
                                <div class="box-body">
                                          
                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label">Search Section Title<span>*</span></label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="search_title" value="<?php echo $search_title; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label">Existing Search Photo</label>
                                        <div class="col-sm-6" style="padding-top:6px;">
                                            <img src="../assets/uploads/<?php echo $search_photo; ?>" class="existing-photo" style="height:80px;">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label">New Search Photo</label>
                                        <div class="col-sm-6" style="padding-top:6px;">
                                            <input type="file" name="search_photo">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label"></label>
                                        <div class="col-sm-6">
                                            <button type="submit" class="btn btn-success pull-left" name="form6_1">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </form>


                            <h3>Testimonial Section</h3>
                            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                            <div class="box box-info">
                                <div class="box-body">                                          
                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label">Existing Testimonial Background</label>
                                        <div class="col-sm-6" style="padding-top:6px;">
                                            <img src="../assets/uploads/<?php echo $testimonial_photo; ?>" class="existing-photo" style="height:80px;">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label">New Testimonial Background</label>
                                        <div class="col-sm-6" style="padding-top:6px;">
                                            <input type="file" name="testimonial_photo">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label"></label>
                                        <div class="col-sm-6">
                                            <button type="submit" class="btn btn-success pull-left" name="form6_2">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </form>


                            <h3>Newsletter Section</h3>
                            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                            <div class="box box-info">
                                <div class="box-body">                                          
                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label">Newsletter Text</label>
                                        <div class="col-sm-8">
                                            <textarea name="newsletter_text" class="form-control" cols="30" rows="10" style="height: 120px;"><?php echo $newsletter_text; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label"></label>
                                        <div class="col-sm-6">
                                            <button type="submit" class="btn btn-success pull-left" name="form6_3">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </form>


          				</div>



          				<div class="tab-pane" id="tab_7">

          					<table class="table table-bordered">
          						<tr>
          							<form action="" method="post" enctype="multipart/form-data">
          							<td style="width:50%">
          								<h4>Existing Login Page Banner</h4>
          								<p>
          									<img src="<?php echo BASE_URL.'assets/uploads/'.$banner_login; ?>" alt="" style="width: 100%;height:auto;">	
          								</p>          								
          							</td>
          							<td style="width:50%">
          								<h4>Change Login Page Banner</h4>
          								Select Photo<input type="file" name="photo">
          								<input type="submit" class="btn btn-primary btn-xs" value="Change" style="margin-top:10px;" name="form7_1">
          							</td>
          							</form>
          						</tr>
          						<tr>
          							<form action="" method="post" enctype="multipart/form-data">
          							<td style="width:50%">
          								<h4>Existing Registration Page Banner</h4>
          								<p>
          									<img src="<?php echo BASE_URL.'assets/uploads/'.$banner_registration; ?>" alt="" style="width: 100%;height:auto;">	
          								</p>          								
          							</td>
          							<td style="width:50%">
          								<h4>Change Registration Page Banner</h4>
          								Select Photo<input type="file" name="photo">
          								<input type="submit" class="btn btn-primary btn-xs" value="Change" style="margin-top:10px;" name="form7_2">
          							</td>
          							</form>
          						</tr>
          						<tr>
          							<form action="" method="post" enctype="multipart/form-data">
          							<td style="width:50%">
          								<h4>Existing Forget Password Page Banner</h4>
          								<p>
          									<img src="<?php echo BASE_URL.'assets/uploads/'.$banner_forget_password; ?>" alt="" style="width: 100%;height:auto;">	
          								</p>          								
          							</td>
          							<td style="width:50%">
          								<h4>Change Forget Password Page Banner</h4>
          								Select Photo<input type="file" name="photo">
          								<input type="submit" class="btn btn-primary btn-xs" value="Change" style="margin-top:10px;" name="form7_3">
          							</td>
          							</form>
          						</tr>
          						<tr>
          							<form action="" method="post" enctype="multipart/form-data">
          							<td style="width:50%">
          								<h4>Existing Blog Page Banner</h4>
          								<p>
          									<img src="<?php echo BASE_URL.'assets/uploads/'.$banner_blog; ?>" alt="" style="width: 100%;height:auto;">	
          								</p>          								
          							</td>
          							<td style="width:50%">
          								<h4>Change Blog Page Banner</h4>
          								Select Photo<input type="file" name="photo">
          								<input type="submit" class="btn btn-primary btn-xs" value="Change" style="margin-top:10px;" name="form7_4">
          							</td>
          							</form>
          						</tr>
                                <tr>
                                    <form action="" method="post" enctype="multipart/form-data">
                                    <td style="width:50%">
                                        <h4>Existing Donor Page Banner</h4>
                                        <p>
                                            <img src="<?php echo BASE_URL.'assets/uploads/'.$banner_donor; ?>" alt="" style="width: 100%;height:auto;">  
                                        </p>                                        
                                    </td>
                                    <td style="width:50%">
                                        <h4>Change Donor Page Banner</h4>
                                        Select Photo<input type="file" name="photo">
                                        <input type="submit" class="btn btn-primary btn-xs" value="Change" style="margin-top:10px;" name="form7_5">
                                    </td>
                                    </form>
                                </tr>
                                <tr>
                                    <form action="" method="post" enctype="multipart/form-data">
                                    <td style="width:50%">
                                        <h4>Existing Agent Page Banner</h4>
                                        <p>
                                            <img src="<?php echo BASE_URL.'assets/uploads/'.$banner_agent; ?>" alt="" style="width: 100%;height:auto;">  
                                        </p>                                        
                                    </td>
                                    <td style="width:50%">
                                        <h4>Change Agent Page Banner</h4>
                                        Select Photo<input type="file" name="photo">
                                        <input type="submit" class="btn btn-primary btn-xs" value="Change" style="margin-top:10px;" name="form7_5_1">
                                    </td>
                                    </form>
                                </tr>
                                <tr>
                                    <form action="" method="post" enctype="multipart/form-data">
                                    <td style="width:50%">
                                        <h4>Existing Search Page Banner</h4>
                                        <p>
                                            <img src="<?php echo BASE_URL.'assets/uploads/'.$banner_search; ?>" alt="" style="width: 100%;height:auto;">  
                                        </p>                                        
                                    </td>
                                    <td style="width:50%">
                                        <h4>Change Search Page Banner</h4>
                                        Select Photo<input type="file" name="photo">
                                        <input type="submit" class="btn btn-primary btn-xs" value="Change" style="margin-top:10px;" name="form7_6">
                                    </td>
                                    </form>
                                </tr>
          					</table>

          				</div>



          				<div class="tab-pane" id="tab_8">
          					<form class="form-horizontal" action="" method="post">
								<div class="box box-info">
									<div class="box-body">
										<div class="form-group">
											<label for="" class="col-sm-2 control-label">Mode Rewrite </label>
											<div class="col-sm-4">
												<select name="mod_rewrite" class="form-control" style="width:auto;">
													<option value="Off" <?php if($mod_rewrite == 'Off'){echo 'selected';} ?>>Off</option>
													<option value="On" <?php if($mod_rewrite == 'On'){echo 'selected';} ?>>On</option>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label for="" class="col-sm-2 control-label"></label>
											<div class="col-sm-6">
												<button type="submit" class="btn btn-success pull-left" name="form8">Update</button>
											</div>
										</div>
									</div>
								</div>
							</form>
          				</div>




          				<div class="tab-pane" id="tab_9">
          					<form class="form-horizontal" action="" method="post">
								<div class="box box-info">
									<div class="box-body">
										<div class="form-group">
											<label for="" class="col-sm-2 control-label">PayPal Business Email </label>
											<div class="col-sm-9">
												<input type="text" name="paypal_email" class="form-control" value="<?php echo $paypal_email; ?>">
											</div>
										</div>
										<div class="form-group">
											<label for="" class="col-sm-2 control-label"></label>
											<div class="col-sm-6">
												<button type="submit" class="btn btn-success pull-left" name="form9">Update</button>
											</div>
										</div>
									</div>
								</div>
							</form>
          				</div>






          			</div>
				</div>

				

			</form>
		</div>
	</div>

</section>

<?php require_once('footer.php'); ?>