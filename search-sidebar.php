<h3 class="top">Detailed Search</h3>

<form action="<?php echo BASE_URL; ?>check-get.php" method="get">

<div class="widget-item">
	<h3>Brand</h3>
	<select data-placeholder="Choose Brand" class="form-control brand" name="brand_id" onchange="this.form.submit()">
		<option>All Brands</option>
		<?php
		$statement = $pdo->prepare("SELECT * FROM tbl_brand ORDER BY brand_name ASC");
		$statement->execute();
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);
		foreach ($result as $row) {
			?>			
			<option value="<?php echo $row['brand_id']; ?>" <?php if(isset($_GET['brand_id']))  {if($_GET['brand_id']==$row['brand_id']) {echo 'selected';}} ?>><?php echo $row['brand_name']; ?></option>
			<?php
		}
		?>
	</select>
</div>

<div class="widget-item">
	<h3>Model</h3>
	<?php if(!isset($_GET['brand_id'])): ?>
	<select data-placeholder="Choose Model" class="form-control model" name="model_id" style="height: 38px;" onchange="this.form.submit()">
		<option value="">Choose Model</option>
	</select>
	<?php else: ?>
	<select data-placeholder="Choose Model" class="form-control chosen-select" name="model_id" onchange="this.form.submit()">
		<option>All Models</option>
		<?php
		$statement = $pdo->prepare("SELECT * FROM tbl_model WHERE brand_id=? ORDER BY model_name ASC");
		$statement->execute(array($_GET['brand_id']));
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);
		foreach ($result as $row) {
			?>			
			<option value="<?php echo $row['model_id']; ?>" <?php if(isset($_GET['model_id']))  {if($_GET['model_id']==$row['model_id']) {echo 'selected';}} ?>><?php echo $row['model_name']; ?></option>
			<?php
		}
		?>
	</select>
	<?php endif; ?>
</div>

<div class="widget-item">
	<h3>Condition</h3>
	<select data-placeholder="Choose Condition" class="form-control chosen-select" name="car_condition" onchange="this.form.submit()">
		<option>All Cars</option>
		<option value="New Car" <?php if(isset($_GET['car_condition']))  {if($_GET['car_condition']=='New Car') {echo 'selected';}} ?>>New Car</option>
		<option value="Old Car" <?php if(isset($_GET['car_condition']))  {if($_GET['car_condition']=='Old Car') {echo 'selected';}} ?>>Old Car</option>
	</select>
</div>

<div class="widget-item">
	<h3>Price Range</h3>
	<select data-placeholder="Choose Price Range (in USD)" class="form-control chosen-select" name="price_range" onchange="this.form.submit()">
		<option>All Prices</option>
		<option value="1" <?php if(isset($_GET['price_range']))  {if($_GET['price_range']=='1') {echo 'selected';}} ?>>1-4999</option>
		<option value="2" <?php if(isset($_GET['price_range']))  {if($_GET['price_range']=='2') {echo 'selected';}} ?>>5000-9999</option>
		<option value="3" <?php if(isset($_GET['price_range']))  {if($_GET['price_range']=='3') {echo 'selected';}} ?>>10000-14999</option>
		<option value="4" <?php if(isset($_GET['price_range']))  {if($_GET['price_range']=='4') {echo 'selected';}} ?>>15000-19999</option>
		<option value="5" <?php if(isset($_GET['price_range']))  {if($_GET['price_range']=='5') {echo 'selected';}} ?>>20000-24999</option>
		<option value="6" <?php if(isset($_GET['price_range']))  {if($_GET['price_range']=='6') {echo 'selected';}} ?>>25000-29999</option>
		<option value="7" <?php if(isset($_GET['price_range']))  {if($_GET['price_range']=='7') {echo 'selected';}} ?>>30000-50000</option>
		<option value="8" <?php if(isset($_GET['price_range']))  {if($_GET['price_range']=='8') {echo 'selected';}} ?>>50000+</option>
	</select>
</div>

<div class="widget-item">
	<h3>Car Category</h3>
	<select data-placeholder="Choose Category" class="form-control chosen-select" name="car_category_id" onchange="this.form.submit()">
		<option>All Categories</option>
		<?php
		$statement = $pdo->prepare("SELECT * FROM tbl_car_category ORDER BY car_category_name ASC");
		$statement->execute();
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);
		foreach ($result as $row) {
			?>			
			<option value="<?php echo $row['car_category_id']; ?>" <?php if(isset($_GET['car_category_id']))  {if($_GET['car_category_id']==$row['car_category_id']) {echo 'selected';}} ?>><?php echo $row['car_category_name']; ?></option>
			<?php
		}
		?>
	</select>
</div>

<div class="widget-item">
	<h3>Body Type</h3>
	<select data-placeholder="Choose Body Type" class="form-control chosen-select" name="body_type_id" onchange="this.form.submit()">
		<option>Not Specified</option>
		<?php
		$statement = $pdo->prepare("SELECT * FROM tbl_body_type ORDER BY body_type_name ASC");
		$statement->execute();
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);
		foreach ($result as $row) {
			?>			
			<option value="<?php echo $row['body_type_id']; ?>" <?php if(isset($_GET['body_type_id']))  {if($_GET['body_type_id']==$row['body_type_id']) {echo 'selected';}} ?>><?php echo $row['body_type_name']; ?></option>
			<?php
		}
		?>
	</select>
</div>

<div class="widget-item">
	<h3>Fuel Type</h3>
	<select data-placeholder="Choose Fuel Type" class="form-control chosen-select" name="fuel_type_id" onchange="this.form.submit()">
		<option>Not Specified</option>
		<?php
		$statement = $pdo->prepare("SELECT * FROM tbl_fuel_type ORDER BY fuel_type_name ASC");
		$statement->execute();
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);
		foreach ($result as $row) {
			?>
			<option value="<?php echo $row['fuel_type_id']; ?>" <?php if(isset($_GET['fuel_type_id']))  {if($_GET['fuel_type_id']==$row['fuel_type_id']) {echo 'selected';}} ?>><?php echo $row['fuel_type_name']; ?></option>
			<?php
		}
		?>
	</select>
</div>

<div class="widget-item">
	<h3>Transmission Type</h3>
	<select data-placeholder="Choose Transmission Type" class="form-control chosen-select" name="transmission_type_id" onchange="this.form.submit()">
		<option>Not Specified</option>
		<?php
		$statement = $pdo->prepare("SELECT * FROM tbl_transmission_type ORDER BY transmission_type_name ASC");
		$statement->execute();
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);
		foreach ($result as $row) {
			?>			
			<option value="<?php echo $row['transmission_type_id']; ?>" <?php if(isset($_GET['transmission_type_id']))  {if($_GET['transmission_type_id']==$row['transmission_type_id']) {echo 'selected';}} ?>><?php echo $row['transmission_type_name']; ?></option>
			<?php
		}
		?>
	</select>
</div>

<div class="widget-item">
	<h3>Make Year</h3>
	<select data-placeholder="Choose Year" class="form-control chosen-select" name="year" onchange="this.form.submit()">
		<option>Not Specified</option>
		<?php
		$current_year = date('Y');
		for($i=$current_year;$i>=1900;$i--):
		?>
		<option value="<?php echo $i; ?>" <?php if(isset($_GET['year']))  {if($_GET['year']==$i) {echo 'selected';}} ?>><?php echo $i; ?></option>
		<?php endfor; ?>
	</select>
</div>

<div class="widget-item">
	<h3>Mileage per Liter</h3>
	<input autocomplete="off" type="text" name="mileage_start" style="width: 80px;" placeholder="From" value="<?php if(isset($_GET['mileage_start'])) { echo $_GET['mileage_start'];} ?>"> - 
	<input autocomplete="off" type="text" name="mileage_end" style="width: 80px;" placeholder="To" value="<?php if(isset($_GET['mileage_end'])) { echo $_GET['mileage_end'];} ?>">
</div>

<div class="widget-item">
	<h3>Country</h3>
	<input autocomplete="off" type="text" name="country" value="<?php if(isset($_GET['country'])) { echo $_GET['country'];} ?>">
</div>

<div class="widget-item">
	<h3>State</h3>
	<input autocomplete="off" type="text" name="state" value="<?php if(isset($_GET['state'])) { echo $_GET['state'];} ?>">
</div>

<div class="widget-item">
	<h3>City</h3>
	<input autocomplete="off" type="text" name="city" value="<?php if(isset($_GET['city'])) { echo $_GET['city'];} ?>">
</div>

<div class="result-button">
	<input type="submit" value="Search" name="form_sidebar">
</div>

</form>