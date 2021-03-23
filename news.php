<?php require_once('header.php'); ?>

<?php
// Preventing the direct access of this page.
if(!isset($_REQUEST['slug']))
{
	header('location: '.BASE_URL);
	exit;
}

// Getting the news detailed data from the news id
$statement = $pdo->prepare("SELECT
							t1.news_title,
							t1.news_slug,
							t1.news_content,
							t1.news_date,
							t1.publisher,
							t1.photo,
							t1.category_id,
							
							t2.category_id,
							t2.category_name,
							t2.category_slug

                           	FROM tbl_news t1
                           	JOIN tbl_category t2
                           	ON t1.category_id = t2.category_id
                           	WHERE t1.news_slug=?");
$statement->execute(array($_REQUEST['slug']));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
foreach ($result as $row) {
	$news_title    = $row['news_title'];
	$news_content  = $row['news_content'];
	$news_date     = $row['news_date'];
	$publisher     = $row['publisher'];
	$photo         = $row['photo'];
	$category_id   = $row['category_id'];
	$category_slug = $row['category_slug'];
	$category_name = $row['category_name'];
}

// Update data for view count for this news page
// Getting current view count
$statement = $pdo->prepare("SELECT * FROM tbl_news WHERE news_slug=?");
$statement->execute(array($_REQUEST['slug']));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
foreach ($result as $row) 
{
	$current_total_view = $row['total_view'];
}
$updated_total_view = $current_total_view+1;

// Updating database for view count
$statement = $pdo->prepare("UPDATE tbl_news SET total_view=? WHERE news_slug=?");
$statement->execute(array($updated_total_view,$_REQUEST['slug']));
?>

<!--Banner Start-->
<div class="banner-slider" style="background: none;">
	<div class="bg"></div>
	<div class="bannder-table">
		<div class="banner-text">
			<h1><?php echo $news_title; ?></h1>
		</div>
	</div>
</div>
<!--Banner End-->

<!--Single Blog Start-->
<div class="single-blog bg-area">
	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<div class="single-blog-item">
					<div class="single-blog-photo">
						<img src="<?php echo BASE_URL; ?>assets/uploads/<?php echo $photo ?>" alt="<?php echo $news_title; ?>">
					</div>
					<div class="single-blog-text">
						<h2><?php echo $news_title; ?></h2>
						<ul>
							<li>Category: <a href="<?php echo BASE_URL.URL_CATEGORY.$category_slug; ?>"><?php echo $category_name; ?></a></li>
							<li>Date: <?php echo $news_date; ?></li>
						</ul>
						<div class="single-blog-pra">
							<p>
								<?php echo $news_content; ?>
							</p>
						</div>
						<h3>Share This</h3>
						<div class="sharethis-inline-share-buttons"></div>
					</div>

					<h3>Comments</h3>
					<?php
					// Getting the full url of the current page
					$final_url = BASE_URL.URL_NEWS.$_REQUEST['slug'];
					?>
					<!-- Facebook Comment Main Code (got from facebook website) -->
					<div class="fb-comments" data-href="<?php echo $final_url; ?>" data-numposts="5"></div>
						
				</div>
			</div>
			<div class="col-md-4">
				<div class="single-sidebar">
					<?php
					$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
					$statement->execute();
					$result = $statement->fetchAll(PDO::FETCH_ASSOC);
					foreach ($result as $row) {
						$total_recent_news_sidebar = $row['total_recent_news_sidebar'];
						$total_popular_news_sidebar = $row['total_popular_news_sidebar'];
					}
					?>
					<div class="single-widget categories">
						<h3>Categories</h3>
						<ul>
							<?php
							$statement = $pdo->prepare("SELECT * FROM tbl_category ORDER BY category_name ASC");
							$statement->execute();
							$result = $statement->fetchAll(PDO::FETCH_ASSOC);
							foreach ($result as $row) {
								?>
								<li><a href="<?php echo BASE_URL.URL_CATEGORY.$row['category_slug']; ?>"><?php echo $row['category_name']; ?></a></li>
								<?php
							}
							?>
						</ul>
					</div>

					<div class="single-widget categories">
						<h3>Recent Posts</h3>
						<ul>
							<?php
							$i=0;
							$statement = $pdo->prepare("SELECT * FROM tbl_news ORDER BY news_id DESC");
							$statement->execute();
							$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
							foreach ($result as $row) {
								$i++;
								if($i>$total_recent_news_sidebar) {break;}
								?>
								<li><a href="<?php echo BASE_URL.URL_NEWS.$row['news_slug']; ?>"><?php echo $row['news_title']; ?></a></li>
								<?php
							}
							?>
						</ul>
					</div>

					<div class="single-widget categories">
						<h3>Popular Posts</h3>
						<ul>
							<?php
							$i=0;
							$statement = $pdo->prepare("SELECT * FROM tbl_news ORDER BY total_view DESC");
							$statement->execute();
							$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
							foreach ($result as $row) {
								$i++;
								if($i>$total_popular_news_sidebar) {break;}
								?>
								<li><a href="<?php echo BASE_URL.URL_NEWS.$row['news_slug']; ?>"><?php echo $row['news_title']; ?></a></li>
								<?php
							}
							?>
						</ul>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>

<?php require_once('footer.php'); ?>