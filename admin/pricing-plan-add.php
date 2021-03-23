<?php require_once('header.php'); ?>

<?php
if(isset($_POST['form1'])) {
	$valid = 1;

    if(empty($_POST['pricing_plan_name'])) {
        $valid = 0;
        $error_message .= "Pricing Plan Name can not be empty<br>";
    } else {
    	// Duplicate Category checking
    	$statement = $pdo->prepare("SELECT * FROM tbl_pricing_plan WHERE pricing_plan_name=?");
    	$statement->execute(array($_POST['pricing_plan_name']));
    	$total = $statement->rowCount();
    	if($total) {
    		$valid = 0;
        	$error_message .= "Pricing Plan Name already exists<br>";
    	}
    }
    if(empty($_POST['pricing_plan_price'])) {
        $valid = 0;
        $error_message .= "Pricing Plan Price can not be empty<br>";
    } else {
    	if(!is_numeric($_POST['pricing_plan_price'])) {
    		$valid = 0;
        	$error_message .= "Pricing Plan Price must be numeric<br>";
    	}
    }
    if(empty($_POST['pricing_plan_day'])) {
        $valid = 0;
        $error_message .= "Pricing Plan Active Days can not be empty<br>";
    } else {
    	if(!is_numeric($_POST['pricing_plan_day'])) {
    		$valid = 0;
        	$error_message .= "Pricing Plan Active Days must be numeric<br>";
    	}
    }
    if(empty($_POST['pricing_plan_item_allow'])) {
        $valid = 0;
        $error_message .= "Pricing Plan Allowed Items can not be empty<br>";
    } else {
    	if(!is_numeric($_POST['pricing_plan_item_allow'])) {
    		$valid = 0;
        	$error_message .= "Pricing Plan Allowed Items must be numeric<br>";
    	}
    }


    if($valid == 1) {

		// saving into the database
		$statement = $pdo->prepare("INSERT INTO tbl_pricing_plan (pricing_plan_name,pricing_plan_price,pricing_plan_day,pricing_plan_item_allow,pricing_plan_description) VALUES (?,?,?,?,?)");
		$statement->execute(array($_POST['pricing_plan_name'],$_POST['pricing_plan_price'],$_POST['pricing_plan_day'],$_POST['pricing_plan_item_allow'],$_POST['pricing_plan_description']));

    	$success_message = 'Pricing Plan is added successfully.';
    }
}
?>

<section class="content-header">
	<div class="content-header-left">
		<h1>Add Pricing Plan</h1>
	</div>
	<div class="content-header-right">
		<a href="pricing-plan.php" class="btn btn-primary btn-sm">View All</a>
	</div>
</section>


<section class="content">

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

			<form class="form-horizontal" action="" method="post">

				<div class="box box-info">
					<div class="box-body">
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Plan Name <span>*</span></label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="pricing_plan_name">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Plan Price <span>*</span></label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="pricing_plan_price">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Plan Active Days <span>*</span></label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="pricing_plan_day">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Plan Item Allowed <span>*</span></label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="pricing_plan_item_allow">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Plan Description </label>
							<div class="col-sm-9">
								<textarea name="pricing_plan_description" class="form-control" cols="30" rows="10" style="height: 150px;" id="editor1"></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label"></label>
							<div class="col-sm-6">
								<button type="submit" class="btn btn-success pull-left" name="form1">Submit</button>
							</div>
						</div>
					</div>
				</div>

			</form>


		</div>
	</div>

</section>

<?php require_once('footer.php'); ?>