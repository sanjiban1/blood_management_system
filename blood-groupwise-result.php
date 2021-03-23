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
if( !isset($_REQUEST['id']) ) {
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


<div class="donner-page-area">
	<div class="container">
		<div class="row">
			
			<div class="col-md-12">
				<?php
				// Getting the finel SQL query
				$statement = $pdo->prepare("SELECT * FROM tbl_blood_group WHERE blood_group_id=?");
				$statement->execute(array($_REQUEST['id']));
				$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
				foreach ($result as $row) {
					$blood_group_name = $row['blood_group_name'];
				}
				
				$final_sql = "SELECT * FROM tbl_donor WHERE blood_group_id=?";
				$searched_by = 'Blood Group: '.$blood_group_name;
				$statement = $pdo->prepare($final_sql);
				$statement->execute(array($_REQUEST['id']));
				$total_res = $statement->rowCount();
				$result = $statement->fetchAll(PDO::FETCH_ASSOC);

				echo '<h3>All Results for &rarr; '.$searched_by.'</h3>';
				?>
			</div>

			<?php						
				
			if($total_res==''):
				echo '<div class="error" style="font-size:20px;margin-top:20px;padding:0 15px;">Sorry! No Donor is Found.</div>';
			else:
				$count_child=0;
				?>					
				<div class="parent"><?php
				foreach ($result as $row) {
					$count_child++;

					?>
					<div class="col-md-3 col-sm-4 col-xs-12 blood-list">
						<div class="donner-item">
							<div class="donner-list">
								<div class="donner-photo" style="background-image: url(<?php echo BASE_URL.'assets/uploads/donors/'.$row['photo']; ?>)"></div>
								<div class="donner-info">
									<h2><a href="<?php echo BASE_URL.URL_DONOR.$row['donor_id']; ?>"><?php echo $row['name']; ?></a></h2>
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