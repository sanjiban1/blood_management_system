	<?php
		$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
		$statement->execute();
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
		foreach ($result as $row) 
		{
			$footer_about                = $row['footer_about'];
			$footer_copyright            = $row['footer_copyright'];
			$contact_address             = $row['contact_address'];
			$contact_email               = $row['contact_email'];
			$contact_phone               = $row['contact_phone'];
			$contact_fax                 = $row['contact_fax'];
			$total_recent_news_footer    = $row['total_recent_news_footer'];
			$total_popular_news_footer   = $row['total_popular_news_footer'];
			$total_recent_news_sidebar   = $row['total_recent_news_sidebar'];
			$total_popular_news_sidebar  = $row['total_popular_news_sidebar'];
			$total_recent_news_home_page = $row['total_recent_news_home_page'];
			$newsletter_text = $row['newsletter_text'];
		}
	?>

	<!--Newsletters Start-->
	<div class="newsletter-area">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="newsletter-headline">
						<h2>Newsletter</h2>
						<?php if($newsletter_text!=''): ?>
						<p>
							<?php echo nl2br($newsletter_text); ?>
						</p>
						<?php endif; ?>
					</div>
					<div class="newsletter-submit">
						<?php
			if(isset($_POST['form_subscribe']))
			{

				if(empty($_POST['email_subscribe'])) 
			    {
			        $valid = 0;
			        $error_message1 .= 'Email address can not be empty';
			    }
			    else
			    {
			    	if (filter_var($_POST['email_subscribe'], FILTER_VALIDATE_EMAIL) === false)
				    {
				        $valid = 0;
				        $error_message1 .= 'Email address must be valid';
				    }
				    else
				    {
				    	$statement = $pdo->prepare("SELECT * FROM tbl_subscriber WHERE subs_email=?");
				    	$statement->execute(array($_POST['email_subscribe']));
				    	$total = $statement->rowCount();							
				    	if($total)
				    	{
				    		$valid = 0;
				        	$error_message1 .= 'Email address already exists';
				    	}
				    	else
				    	{
				    		// Sending email to the requested subscriber for email confirmation
				    		// Getting activation key to send via email. also it will be saved to database until user click on the activation link.
				    		$key = md5(uniqid(rand(), true));

				    		// Getting current date
				    		$current_date = date('Y-m-d');

				    		// Getting current date and time
				    		$current_date_time = date('Y-m-d H:i:s');

				    		// Inserting data into the database
				    		$statement = $pdo->prepare("INSERT INTO tbl_subscriber (subs_email,subs_date,subs_date_time,subs_hash,subs_active) VALUES (?,?,?,?,?)");
				    		$statement->execute(array($_POST['email_subscribe'],$current_date,$current_date_time,$key,0));

				    		// Sending Confirmation Email
				    		$to = $_POST['email_subscribe'];
							$subject = 'Subscriber Email Confirmation';
							
							// Getting the url of the verification link
							$verification_url = BASE_URL.'verify.php?email='.$to.'&key='.$key;

							$message = '
Thanks for your interest to subscribe our newsletter!<br><br>
Please click this link to confirm your subscription:
					'.$verification_url.'<br><br>
This link will be active only for 24 hours.
					';

							$headers = 'From: ' . $contact_email . "\r\n" .
								   'Reply-To: ' . $contact_email . "\r\n" .
								   'X-Mailer: PHP/' . phpversion() . "\r\n" . 
								   "MIME-Version: 1.0\r\n" . 
								   "Content-Type: text/html; charset=ISO-8859-1\r\n";

							// Sending the email
							mail($to, $subject, $message, $headers);

							$success_message1 = 'Please check your email and confirm your subscription.';
				    	}
				    }
			    }
			}
			if($error_message1 != '') {
				echo "<script>alert('".$error_message1."')</script>";
			}
			if($success_message1 != '') {
				echo "<script>alert('".$success_message1."')</script>";
			}
			?>
						<form action="" method="post">
							<input type="text" placeholder="Enter Your Email" name="email_subscribe">
							<input type="submit" value="Submit" name="form_subscribe">
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--Newsletters End-->

	<!--Footer-Area Start-->
	<div class="footer-area">
		<div class="container">
			<div class="row">
				<div class="col-md-3 col-sm-3">
					<div class="footer-item footer-service">
						<h2>Latest News</h2>
						<ul class="fmain">
							<?php
							$i=0;
							$statement = $pdo->prepare("SELECT * FROM tbl_news ORDER BY news_id DESC");
							$statement->execute();
							$result = $statement->fetchAll(PDO::FETCH_ASSOC);		
							foreach ($result as $row) {
								$i++;
								if($i>$total_recent_news_footer) {break;}
								?>
								<li><a href="<?php echo BASE_URL.URL_NEWS.$row['news_slug']; ?>"><?php echo $row['news_title']; ?></a></li>
								<?php
							}
							?>
						</ul>
					</div>
				</div>
				<div class="col-md-3 col-sm-3">
					<div class="footer-item footer-service">
						<h2>Popular News</h2>
						<ul class="fmain">
							<?php
							$i=0;
							$statement = $pdo->prepare("SELECT * FROM tbl_news ORDER BY total_view DESC");
							$statement->execute();
							$result = $statement->fetchAll(PDO::FETCH_ASSOC);		
							foreach ($result as $row) {
								$i++;
								if($i>$total_popular_news_footer) {break;}
								?>
								<li><a href="<?php echo BASE_URL.URL_NEWS.$row['news_slug']; ?>"><?php echo $row['news_title']; ?></a></li>
								<?php
							}
							?>
						</ul>
					</div>
				</div>
				<div class="col-md-3 col-sm-3">
					<div class="footer-item footer-service">
						<h2>Contact</h2>
						<ul>
							<li>Address: <?php echo $contact_address; ?></li>
							<li>Email: <?php echo $contact_email; ?></li>
							<li>Phone: <?php echo $contact_phone; ?></li>
							<li>Fax: <?php echo $contact_fax; ?></li>
						</ul>
					</div>
				</div>
				<div class="col-md-3 col-sm-3">
					<div class="footer-item footer-service">
						<h2>Social Media</h2>
						<div class="footer-social-link">
							<ul>
								<?php
								// Getting and showing all the social media icon URL from the database
								$statement = $pdo->prepare("SELECT * FROM tbl_social");
								$statement->execute();
								$result = $statement->fetchAll(PDO::FETCH_ASSOC);			
								foreach ($result as $row) 
								{
									if($row['social_url']!='')
									{
										echo '<li><a href="'.$row['social_url'].'"><i class="'.$row['social_icon'].'"></i></a></li>';
									}
								}
								?>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="copyright">
					<p><?php echo $footer_copyright; ?></p>
				</div>
			</div>
		</div>
	</div>

	<!--Footer-Area End-->


	<!--Scroll-Top-->
	<div class="scroll-top">
		<div class="scroll"></div>
	</div>
	<!--Scroll-Top-->


	<?php
		// Load More button working
		// Finding out the total number of load more buttons to show in a page
		global $count_child;
		$cur_page = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
		if($cur_page == 'search.php')
		{
			if($count_child>6)
			{
				$rest = $total_res-6;
				if($rest%2==0)
				{
					$final = $rest/2;
				}
				else
				{
					$rest = $rest+1;
					$final = $rest/2;
				}
			}
			else
			{
				$final = 0;
			}
		}
	?>


	<!--Js-->
	<script src="<?php echo BASE_URL; ?>js/jquery-2.2.4.min.js"></script>
	<script src="<?php echo BASE_URL; ?>js/jquery-ui.js"></script>
	<script src="<?php echo BASE_URL; ?>js/bootstrap.min.js"></script>
	<script src="<?php echo BASE_URL; ?>js/chosen.jquery.js"></script>
	<script src="<?php echo BASE_URL; ?>js/docsupport/init.js"></script>
	<script src="<?php echo BASE_URL; ?>js/lightbox.min.js"></script>
	<script src="<?php echo BASE_URL; ?>js/jquery.dataTables.min.js"></script>
	<script src="<?php echo BASE_URL; ?>js/owl.carousel.min.js"></script>
	<script src="<?php echo BASE_URL; ?>js/jquery.slicknav.min.js"></script>
	<script src="<?php echo BASE_URL; ?>js/jquery.filterizr.min.js"></script>
	<script src="<?php echo BASE_URL; ?>js/jquery.collapse.js"></script>
	<script src="<?php echo BASE_URL; ?>js/custom.js"></script>

	<script>
		function confirmDelete()
		{
		    return confirm("Do you sure want to delete this data?");
		}

	</script>


	<?php if($cur_page == 'search.php'): ?>
	<script>
		// Load More jquery checking for search page
		jQuery(document).ready(function() {
	        if(!count) {
				var count = 0;
			}
		    $(".load").on( 'click', function(e) {
				$(".child:hidden").slice(0, 2).slideDown();
				var dmCnt = $(".child").length;
				count++;
				if (count == <?php echo $final; ?>) {
					$('.load-more').hide();
				}
		    });
			$(".child").slice(0, 6).slideDown();
	    });
	</script>
	<?php endif; ?>

</body>

</html>