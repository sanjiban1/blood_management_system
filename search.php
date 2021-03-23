<?php require_once('header.php'); ?>

<?php
	$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
	$statement->execute();
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
	foreach ($result as $row) 
	{
		$banner_search = $row['banner_search'];
	}
?>

<?php
// Stopping direct access of the search
if( $_SERVER['REQUEST_METHOD'] !== 'POST' ) {
	header('location: '.BASE_URL);
	exit;
}
?>

<div class="banner-slider" style="background-image: url(<?php echo BASE_URL.'assets/uploads/'.$banner_search; ?>)">
	<div class="bg"></div>
	<div class="bannder-table">
		<div class="banner-text">
			<h1>Search Result</h1>
		</div>
	</div>
</div>



<div class="slider-area">
	<div class="slider-item" style="background:#333;padding: 20px 0;">
		<div class="container">
			<div class="row">
				<div class="searchbox" style="margin-top:0;">
					
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

<div class="donner-page-area">
	<div class="container">
		<div class="row">
			
			<div class="col-md-12">
				<?php
				// Getting the finel SQL query
				$blood_group_id = $_POST['blood_group_id'];

				if($blood_group_id!='') {
					$statement = $pdo->prepare("SELECT * FROM tbl_blood_group WHERE blood_group_id=?");
					$statement->execute(array($_POST['blood_group_id']));
					$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
					foreach ($result as $row) {
						$blood_group_name = $row['blood_group_name'];
					}
				}

				if( $_POST['country']=='' && $_POST['city']=='' && $blood_group_id=='' ) {
					header('location: '.BASE_URL);
				}

				if( $_POST['country']=='' && $_POST['city']=='' && $blood_group_id!='' ) {
					$final_sql = "SELECT * FROM tbl_donor WHERE blood_group_id=".$blood_group_id;
					$searched_by = 'Blood Group: '.$blood_group_name;
				}

				if( $_POST['country']=='' && $_POST['city']!='' && $blood_group_id=='' ) {
					$final_sql = "SELECT * FROM tbl_donor WHERE city LIKE '%".$_POST['city']."%'";
					$searched_by = 'City: '.$_POST['city'];
				}

				if( $_POST['country']=='' && $_POST['city']!='' && $blood_group_id!='' ) {
					$final_sql = "SELECT * FROM tbl_donor WHERE city LIKE '%".$_POST['city']."%' AND blood_group_id=".$blood_group_id;
					$searched_by = 'City: '.$_POST['city'].', Blood Group: '.$blood_group_name;
				}

				if( $_POST['country']!='' && $_POST['city']=='' && $blood_group_id=='' ) {
					$final_sql = "SELECT * FROM tbl_donor WHERE country LIKE '%".$_POST['country']."%'";
					$searched_by = 'Country: '.$_POST['country'];
				}

				if( $_POST['country']!='' && $_POST['city']=='' && $blood_group_id!='' ) {
					$final_sql = "SELECT * FROM tbl_donor WHERE country LIKE '%".$_POST['country']."%' AND blood_group_id=".$blood_group_id;
					$searched_by = 'Country: '.$_POST['country'].', Blood Group: '.$blood_group_name;
				}

				if( $_POST['country']!='' && $_POST['city']!='' && $blood_group_id=='' ) {
					$final_sql = "SELECT * FROM tbl_donor WHERE country LIKE '%".$_POST['country']."%' AND city LIKE '%".$_POST['city']."%'";
					$searched_by = 'Country: '.$_POST['country'].', City: '.$_POST['city'];
				}

				if( $_POST['country']!='' && $_POST['city']!='' && $blood_group_id!='' ) {
					$final_sql = "SELECT * FROM tbl_donor WHERE country LIKE '%".$_POST['country']."%' AND city LIKE '%".$_POST['city']."%' AND blood_group_id=".$blood_group_id;
					$searched_by = 'Country: '.$_POST['country'].', City: '.$_POST['city'].', Blood Group: '.$blood_group_name;
				}

				$statement = $pdo->prepare($final_sql);
				$statement->execute();
				$total_res = $statement->rowCount();
				$result = $statement->fetchAll(PDO::FETCH_ASSOC);

				echo '<h3>All Results for &rarr; '.$searched_by.'</h3>';
				?>
			</div>

			<?php						
				
			if($total_res==''):
				echo '<div class="error" style="font-size:24px;margin-top:20px;">Sorry! No Donor is Found.</div>';
			else:
				$count_child=0;
				?>					
				<div class="parent"><?php
				foreach ($result as $row) {
					$count_child++;

					$statement1 = $pdo->prepare("SELECT * FROM tbl_blood_group WHERE blood_group_id=?");
					$statement1->execute(array($row['blood_group_id']));
					$result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);							
					foreach ($result1 as $row1) {
						$blood_group_name = $row1['blood_group_name'];
					}

					?>
					<div class="col-md-3 col-sm-4 col-xs-12 blood-list">
						<div class="donner-item">
							<div class="donner-list">
								<div class="donner-photo" style="background-image: url(<?php echo BASE_URL.'assets/uploads/donors/'.$row['photo']; ?>)"></div>
								<div class="donner-info">
									<h2><a href="<?php echo BASE_URL.URL_DONOR.$row['donor_id']; ?>"><?php echo $row['name']; ?></a></h2>
									<h4>Blood Group: <span><?php echo $blood_group_name; ?></span> </h4>
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
					</div>
					<?php
				}
				?>
				</div>

				<!-- Load More button -->
				<?php if($count_child>6): ?>
				<div class="load-more">
					<a class="load">Load More</a>
				</div>
				<?php endif; ?>
									
				<?php
			endif;									
			?>	
			

			
		</div>
	</div>
</div>

<?php require_once('footer.php'); ?>