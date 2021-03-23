<?php
include 'admin/config.php';
if($_POST['id'])
{
	$id=$_POST['id'];

	$statement = $pdo->prepare("SELECT * FROM tbl_model WHERE brand_id=?");
	$statement->execute(array($id));
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);
	?><option value="">--Select Model--</option><?php						
	foreach ($result as $row) {
		?>
        <option value="<?php echo $row['model_id']; ?>"><?php echo $row['model_name']; ?></option>
        <?php
	}
}