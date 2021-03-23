<?php require_once('header.php'); ?>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
foreach ($result as $row) {
	$total_recent_news_home_page = $row['total_recent_news_home_page'];
	$search_title = $row['search_title'];
	$search_photo = $row['search_photo'];
	$testimonial_photo = $row['testimonial_photo'];
}
?>

	<!--Slider-Area Start-->
	<div class="slider-area">
		<div class="slider-item" style="background-image: url(<?php echo BASE_URL.'assets/uploads/'.$search_photo; ?>)">
			<div class="bg-3" style="opacity:0.6;"></div>
			<div class="container">
				<div class="row">
					<div class="slider-text">
						<h1><?php echo $search_title; ?></h1>
					</div>
					<div class="searchbox">
						
						<form action="<?php echo BASE_URL.URL_SEARCH; ?>" method="post">
						
							<div class="col-md-3 col-sm-6">
								<input autocomplete="off" type="text" name="country" class="form-control" placeholder="Country Name">
							</div>

							<div class="col-md-3 col-sm-6">
								<input autocomplete="off" type="text" name="city" class="form-control" placeholder="City Name">
							</div>

							<div class="col-md-3 col-sm-6">
								
								<select data-placeholder="Choose Blood Group" class="chosen-select form-control" name="blood_group_id">
									<?php
									$statement = $pdo->prepare("SELECT * FROM tbl_blood_group");
									$statement->execute();
									$result = $statement->fetchAll(PDO::FETCH_ASSOC);
									foreach ($result as $row) {
										?>
										<option></option>
										<option value="<?php echo $row['blood_group_id']; ?>"><?php echo $row['blood_group_name']; ?></option>
										<?php
									}
									?>
								</select>
							</div>
							
							<div class="col-md-3 col-sm-6">
								<input type="submit" value="Search Donor" name="form_search">
							</div>

						</form>

					</div>
				</div>
			</div>
		</div>
	</div>
	<!--Slider-Area End-->
	
	
	<div class="blood-gallery bg-gray">
		<div class="container">
			<div class="row">
				<div class="headline">
					<h2>Blood Groups</h2>
					<div class="headline-icon" style="background-image: url(<?php echo BASE_URL; ?>img/blood.png)"></div>
				</div>
				<?php
				$statement = $pdo->prepare("SELECT * FROM tbl_blood_group");
				$statement->execute();
				$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
				foreach ($result as $row) {
					?>
					<div class="col-md-3 col-sm-6 col-xs-12">
						<div class="blood-item">
							<a href="<?php echo BASE_URL.URL_BLOOD_GROUPWISE_RESULT.$row['blood_group_id']; ?>"><?php echo $row['blood_group_name']; ?></a>
						</div>
					</div>
					<?php
				}
				?>
			</div>
		</div>
	</div>


	<div class="donner-list-area">
		<div class="container">
			<div class="row">
				<div class="headline">
					<h2>Recent Donors</h2>
					<div class="headline-icon" style="background-image: url(<?php echo BASE_URL; ?>img/blood.png)"></div>
				</div>
				<div class="donner-gallery owl-carousel">


					<?php
					$count = 0;
					$statement = $pdo->prepare("SELECT * 
											FROM tbl_donor t1
											JOIN tbl_blood_group t2
											ON t1.blood_group_id = t2.blood_group_id
											WHERE t1.status=?
											ORDER BY t1.donor_id DESC");
					$statement->execute(array(1));
					$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
					foreach ($result as $row) {

						$agent_id = $row['agent_id'];

						// Check if this seller is active or inactive
						$statement1 = $pdo->prepare("SELECT * FROM tbl_agent WHERE agent_id=? AND agent_access=?");
						$statement1->execute(array($agent_id,1));
						$agent_status = $statement1->rowCount();
						if(!$agent_status) {continue;}

						$today = date('Y-m-d');

						$valid = 0;
						$statement1 = $pdo->prepare("SELECT * FROM tbl_payment WHERE agent_id=? AND payment_status=?");
						$statement1->execute(array($agent_id,'Completed'));
						$result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);							
						foreach ($result1 as $row1) {
							if(($today>=$row1['payment_date'])&&($today<=$row1['expire_date'])) {
								$valid = 1;
								break;
							}
						}
						if($valid == 1):
							$count++;
							if($count>20) {break;}
						?>
						<div class="donner-item">
							<div class="donner-list">
								<div class="donner-photo" style="background-image: url(<?php echo BASE_URL.'assets/uploads/donors/'.$row['photo']; ?>)"></div>
								<div class="donner-info">
									<h2><a href="<?php echo BASE_URL.URL_DONOR.$row['donor_id']; ?>"><?php echo $row['name']; ?></a></h2>
									<h4>Blood Group: <span><?php echo $row['blood_group_name']; ?></span> </h4>
									<div class="donner-social">
										<ul>
											<?php
											if($row['facebook']!='') {
												echo '<li><a href="'.$row['facebook'].'"><i class="fa fa-facebook"></i></a></li>';
											}
											if($row['twitter']!='') {
												echo '<li><a href="'.$row['twitter'].'"><i class="fa fa-twitter"></i></a></li>';
											}
											if($row['linkedin']!='') {
												echo '<li><a href="'.$row['linkedin'].'"><i class="fa fa-linkedin"></i></a></li>';
											}
											if($row['googleplus']!='') {
												echo '<li><a href="'.$row['googleplus'].'"><i class="fa fa-google-plus"></i></a></li>';
											}
											if($row['pinterest']!='') {
												echo '<li><a href="'.$row['pinterest'].'"><i class="fa fa-pinterest"></i></a></li>';
											}
											?>
										</ul>
									</div>
									<div class="donner-link">
										<a href="<?php echo BASE_URL.URL_DONOR.$row['donor_id']; ?>">Read more</a>
									</div>
								</div>
							</div>
						</div>
						<?php endif; ?>
						<?php
					}
					?>
				</div>
			</div>
		</div>
	</div>



	<div class="donner-list-area bg-gray">
		<div class="container">
			<div class="row">
				<div class="headline">
					<h2>Recent Agents</h2>
					<div class="headline-icon" style="background-image: url(<?php echo BASE_URL; ?>img/blood.png)"></div>
				</div>
				<div class="donner-gallery owl-carousel">


					<?php
					$count = 0;
					$statement = $pdo->prepare("SELECT * 
											FROM tbl_agent
											WHERE agent_access=?
											ORDER BY agent_id DESC");
					$statement->execute(array(1));
					$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
					foreach ($result as $row) {

						$agent_id = $row['agent_id'];

						$today = date('Y-m-d');

						$valid = 0;
						$statement1 = $pdo->prepare("SELECT * FROM tbl_payment WHERE agent_id=? AND payment_status=?");
						$statement1->execute(array($agent_id,'Completed'));
						$result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);							
						foreach ($result1 as $row1) {
							if(($today>=$row1['payment_date'])&&($today<=$row1['expire_date'])) {
								$valid = 1;
								break;
							}
						}
						if($valid == 1):
							$count++;
							if($count>20) {break;}
						?>
						<div class="donner-item">
							<div class="donner-list">
								<?php if($row['agent_photo']==''): ?>
									<div class="donner-photo" style="background-image: url(<?php echo BASE_URL; ?>assets/uploads/no-photo.jpg)"></div>
								<?php else: ?>
									<div class="donner-photo" style="background-image: url(<?php echo BASE_URL.'assets/uploads/agents/'.$row['agent_photo']; ?>)"></div>
								<?php endif; ?>
								<div class="donner-info">
									<h2><a href="<?php echo BASE_URL.URL_AGENT.$row['agent_id']; ?>"><?php echo $row['agent_name']; ?></a></h2>
									<h4>
										Designation: <?php echo $row['agent_designation']; ?><br>
										Organization: <?php echo $row['agent_organization']; ?>
									</h4>
									<div class="donner-social">
										<ul>
											<?php
											if($row['agent_facebook']!='') {
												echo '<li><a href="'.$row['agent_facebook'].'"><i class="fa fa-facebook"></i></a></li>';
											}
											if($row['agent_twitter']!='') {
												echo '<li><a href="'.$row['agent_twitter'].'"><i class="fa fa-twitter"></i></a></li>';
											}
											if($row['agent_linkedin']!='') {
												echo '<li><a href="'.$row['agent_linkedin'].'"><i class="fa fa-linkedin"></i></a></li>';
											}
											if($row['agent_googleplus']!='') {
												echo '<li><a href="'.$row['agent_googleplus'].'"><i class="fa fa-google-plus"></i></a></li>';
											}
											if($row['agent_pinterest']!='') {
												echo '<li><a href="'.$row['agent_pinterest'].'"><i class="fa fa-pinterest"></i></a></li>';
											}
											?>
										</ul>
									</div>
									<div class="donner-link">
										<a href="<?php echo BASE_URL.URL_AGENT.$row['agent_id']; ?>">Read more</a>
									</div>
								</div>
							</div>
						</div>
						<?php endif; ?>
						<?php
					}
					?>
				</div>
			</div>
		</div>
	</div>
	


	<!--Testimonial Area Start-->
	<div class="testimonial-area" style="background-image: url(<?php echo BASE_URL.'assets/uploads/'.$testimonial_photo; ?>)">
		<div class="bg-2" style="background-color: #333;"></div>
		<div class="container">
			<div class="row">
				<div class="headline headline-white">
					<h2>Happy Customers</h2>
					<div class="headline-icon" style="background-image: url(<?php echo BASE_URL; ?>img/blood-white.png)"></div>
				</div>
				<div class="testimonial-gallery owl-carousel">
					<?php
					$statement = $pdo->prepare("SELECT * FROM tbl_testimonial");
					$statement->execute();
					$result = $statement->fetchAll(PDO::FETCH_ASSOC);						
					foreach ($result as $row) {
						?>
						<div class="testimonial-item">
							<div class="testimonial-photo" style="background-image: url(<?php echo BASE_URL; ?>assets/uploads/<?php echo $row['photo']; ?>)"></div>
							<div class="testimonial-text">
								<h2><?php echo $row['name']; ?></h2>
								<h3><?php echo $row['designation'].'('.$row['company'].')'; ?></h3>
								<div class="testimonial-pra">
									<p>
										<?php echo $row['comment']; ?>
									</p>
								</div>
							</div>
						</div>
						<?php
					}
					?>
				</div>
			</div>
		</div>
	</div>
	<!--Testimonial Area End-->

	<!--Latest News Start-->
	<div class="latest-news">
		<div class="container">
			<div class="row">
				<div class="headline">
					<h2><span>Latest</span> News</h2>
					<div class="headline-icon" style="background-image: url(<?php echo BASE_URL; ?>img/blood.png)"></div>
				</div>
				<div class="latest-gallery owl-carousel">
					<?php
					$i=0;
					$statement = $pdo->prepare("SELECT
									   t1.news_title,
			                           t1.news_slug,
			                           t1.news_content,
			                           t1.news_date,
			                           t1.photo,
			                           t1.category_id,

			                           t2.category_id,
			                           t2.category_name,
			                           t2.category_slug
			                           FROM tbl_news t1
			                           JOIN tbl_category t2
			                           ON t1.category_id = t2.category_id 		                           
			                           ORDER BY t1.news_id DESC");
					$statement->execute();
					$result = $statement->fetchAll(PDO::FETCH_ASSOC);					
					foreach ($result as $row) {
						$i++;
						if($i>$total_recent_news_home_page) {break;}
						?>
						<div class="latest-item">
							<div class="latest-photo" style="background-image: url(<?php echo BASE_URL; ?>assets/uploads/<?php echo $row['photo']; ?>)"></div>
							<div class="latest-text">
								<h2><?php echo $row['news_title']; ?></h2>
								<ul>
									<li>Category: <a href="<?php echo BASE_URL.URL_CATEGORY.$row['category_slug']; ?>"><?php echo $row['category_name']; ?></a></li>
									<li>Date: <?php echo $row['news_date']; ?></li>
								</ul>
								<div class="latest-pra">
									<p>
										<?php echo substr($row['news_content'],0,120).' ...'; ?>
									</p>
									<a href="<?php echo BASE_URL.URL_NEWS.$row['news_slug']; ?>">Read more</a>
								</div>
							</div>
						</div>
						<?php
					}
					?>
				</div>
			</div>
		</div>
	</div>

<?php require_once('footer.php'); ?>	