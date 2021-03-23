<?php require_once('header.php'); ?>

<section class="content-header">
  <h1>Dashboard</h1>
</section>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_blood_group");
$statement->execute();
$total_blood_group = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_donor WHERE status=1");
$statement->execute();
$total_approved_donor = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_donor WHERE status=0");
$statement->execute();
$total_pending_donor = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_news");
$statement->execute();
$total_news = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_agent WHERE agent_access=1");
$statement->execute();
$total_agent = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_subscriber");
$statement->execute();
$total_subscriber = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_pricing_plan");
$statement->execute();
$total_pricing_plan = $statement->rowCount();
?>

<section class="content">

  <div class="row">
    <div class="col-md-4 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-aqua"><i class="fa fa-hand-o-right"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Total Blood Groups</span>
          <span class="info-box-number"><?php echo $total_blood_group; ?></span>
        </div>
      </div>
    </div>
    <div class="col-md-4 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-aqua"><i class="fa fa-hand-o-right"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Total Approved Donors</span>
          <span class="info-box-number"><?php echo $total_approved_donor; ?></span>
        </div>
      </div>
    </div>
    <div class="col-md-4 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-red"><i class="fa fa-hand-o-right"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Total Pending Donors</span>
          <span class="info-box-number"><?php echo $total_pending_donor; ?></span>
        </div>
      </div>
    </div>
    <div class="col-md-4 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-green"><i class="fa fa-hand-o-right"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Total News</span>
          <span class="info-box-number"><?php echo $total_news; ?></span>
        </div>
      </div>
    </div>
    <div class="col-md-4 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-aqua"><i class="fa fa-hand-o-right"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Total Agents</span>
          <span class="info-box-number"><?php echo $total_agent; ?></span>
        </div>
      </div>
    </div>
    <div class="col-md-4 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-red"><i class="fa fa-hand-o-right"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Total Subscribers</span>
          <span class="info-box-number"><?php echo $total_subscriber; ?></span>
        </div>
      </div>
    </div>
    <div class="col-md-4 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-green"><i class="fa fa-hand-o-right"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Total Pricing Plans</span>
          <span class="info-box-number"><?php echo $total_pricing_plan; ?></span>
        </div>
      </div>
    </div>
  </div>

</section>

<?php require_once('footer.php'); ?>