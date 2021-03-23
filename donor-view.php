<?php require_once('header.php'); ?>

<?php
// Check if the agent is logged in or not
if(!isset($_SESSION['agent'])) {
	header('location: '.BASE_URL.URL_LOGOUT);
	exit;
} else {
	// If agent is logged in, but admin make him inactive, then force logout this user.
	$statement = $pdo->prepare("SELECT * FROM tbl_agent WHERE agent_id=? AND agent_access=?");
	$statement->execute(array($_SESSION['agent']['agent_id'],0));
	$total = $statement->rowCount();
	if($total) {
		header('location: '.BASE_URL.URL_LOGOUT);
		exit;
	}
}
?>

<div class="dashboard-area bg-area">
	<div class="container">
		<div class="row">
			<div class="col-md-3 col-sm-12">
				<div class="option-board">
					<?php require_once('dashboard-menu.php'); ?>
				</div>
			</div>
			<div class="col-md-9 col-sm-12">
				<div class="detail-dashboard">

					<h1>View All Donors</h1>

					<table id="example" class="display" width="100%" cellspacing="0">
						<thead>
							<tr>
								<th>Serial</th>
								<th>Photo</th>
								<th>Name</th>
								<th>Profession</th>
								<th>Age</th>
								<th>Blood Group</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$i = 0;
							$statement = $pdo->prepare("SELECT
														
														t1.donor_id,
														t1.name,
														t1.description,
														t1.profession,
														t1.education,
														t1.gender,
														t1.date_of_birth,
														t1.religion_id,
														t1.blood_group_id,
														t1.email,
														t1.phone,
														t1.website,
														t1.address,
														t1.city,
														t1.country,
														t1.state,
														t1.zip_code,
														t1.map,
														t1.photo,
														t1.facebook,
														t1.twitter,
														t1.linkedin,
														t1.googleplus,
														t1.pinterest,
														t1.agent_id,
														t1.status,

														t2.religion_id,
														t2.religion_name,

														t3.blood_group_id,
														t3.blood_group_name


														FROM tbl_donor t1

														JOIN tbl_religion t2
														ON t1.religion_id = t2.religion_id

														JOIN tbl_blood_group t3
														ON t1.blood_group_id = t3.blood_group_id


														WHERE t1.agent_id=?");
							$statement->execute(array($_SESSION['agent']['agent_id']));
							$result = $statement->fetchAll(PDO::FETCH_ASSOC);			
							foreach ($result as $row) {
								$i++;
								?>
									<tr>
										<td><?php echo $i; ?></td>
										<td><img src="<?php echo BASE_URL; ?>assets/uploads/donors/<?php echo $row['photo']; ?>" alt="donor" style="width:150px;"></td>
										<td><?php echo $row['name']; ?></td>
										<td><?php echo $row['profession']; ?></td>
										<td>
											<?php
										    	$diff = (date('Y') - date('Y',strtotime($row['date_of_birth'])));
										    	echo $diff;
										    ?>
										</td>
										<td><?php echo $row['blood_group_name']; ?></td>
										<td>
											<?php if($row['status'] == 0): ?>
											Pending
											<?php else: ?>
											Active
											<?php endif; ?>
										</td>
										<td>
											<a href="" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#myModalDetail<?php echo $i; ?>" style="width:100%;margin-bottom:3px;">Details</a><br>
											<a href="<?php echo BASE_URL.URL_DONOR_EDIT.$row['donor_id']; ?>" class="btn btn-warning btn-xs" style="width:100%;margin-bottom:3px;">Edit</a><br>
											<a onclick="return confirmDelete();" href="<?php echo BASE_URL.URL_DONOR_DELETE.$row['donor_id']; ?>" class="btn btn-danger btn-xs" style="width:100%;margin-bottom:3px;">Delete</a>
		

		<!-- Modal Start -->
		<div class="modal fade" id="myModalDetail<?php echo $i; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		    <div class="modal-dialog">
		        <div class="modal-content">
		            <div class="modal-header">
		                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		                <h4 class="modal-title" id="myModalLabel">
		                  Detail Information
		                </h4>
		            </div>
		            <div class="modal-body">
		                <div class="rTable">
		                	<div class="rTableRow">
								<div class="rTableHead">Photo</div>
								<div class="rTableCell">
									<img src="<?php echo BASE_URL; ?>assets/uploads/donors/<?php echo $row['photo']; ?>" alt="" style="width:150px;">
								</div>
							</div>				
							<div class="rTableRow">
								<div class="rTableHead">Name</div>
								<div class="rTableCell"><?php echo $row['name']; ?></div>
							</div>
							<div class="rTableRow">
								<div class="rTableHead">Profession</div>
								<div class="rTableCell"><?php echo $row['profession']; ?></div>
							</div>
							<div class="rTableRow">
								<div class="rTableHead">Education</div>
								<div class="rTableCell"><?php echo $row['education']; ?></div>
							</div>
							<div class="rTableRow">
								<div class="rTableHead">Gender</div>
								<div class="rTableCell"><?php echo $row['gender']; ?></div>
							</div>
							<div class="rTableRow">
								<div class="rTableHead">Date Of Birth</div>
								<div class="rTableCell"><?php echo $row['date_of_birth']; ?></div>
							</div>
							<div class="rTableRow">
								<div class="rTableHead">Religion</div>
								<div class="rTableCell"><?php echo $row['religion_name']; ?></div>
							</div>
							<div class="rTableRow">
								<div class="rTableHead">Blood Group</div>
								<div class="rTableCell"><?php echo $row['blood_group_name']; ?></div>
							</div>
							<div class="rTableRow">
								<div class="rTableHead">Email</div>
								<div class="rTableCell"><?php echo $row['email']; ?></div>
							</div>
							<div class="rTableRow">
								<div class="rTableHead">Phone</div>
								<div class="rTableCell"><?php echo $row['phone']; ?></div>
							</div>
							<div class="rTableRow">
								<div class="rTableHead">Website</div>
								<div class="rTableCell"><?php echo $row['website']; ?></div>
							</div>
							<div class="rTableRow">
								<div class="rTableHead">Address</div>
								<div class="rTableCell"><?php echo $row['address']; ?></div>
							</div>
							<div class="rTableRow">
								<div class="rTableHead">Country</div>
								<div class="rTableCell"><?php echo $row['country']; ?></div>
							</div>
							<div class="rTableRow">
								<div class="rTableHead">State</div>
								<div class="rTableCell"><?php echo $row['state']; ?></div>
							</div>
							<div class="rTableRow">
								<div class="rTableHead">City</div>
								<div class="rTableCell"><?php echo $row['city']; ?></div>
							</div>
							<div class="rTableRow">
								<div class="rTableHead">Zip Code</div>
								<div class="rTableCell"><?php echo $row['zip_code']; ?></div>
							</div>
							<div class="rTableRow">
								<div class="rTableHead">Map</div>
								<div class="rTableCell"><?php echo $row['map']; ?></div>
							</div>
							<div class="rTableRow">
								<div class="rTableHead">Facebook</div>
								<div class="rTableCell"><?php echo $row['facebook']; ?></div>
							</div>
							<div class="rTableRow">
								<div class="rTableHead">Twitter</div>
								<div class="rTableCell"><?php echo $row['twitter']; ?></div>
							</div>
							<div class="rTableRow">
								<div class="rTableHead">LinkedIn</div>
								<div class="rTableCell"><?php echo $row['linkedin']; ?></div>
							</div>
							<div class="rTableRow">
								<div class="rTableHead">Google Plus</div>
								<div class="rTableCell"><?php echo $row['googleplus']; ?></div>
							</div>
							<div class="rTableRow">
								<div class="rTableHead">Pinterest</div>
								<div class="rTableCell"><?php echo $row['pinterest']; ?></div>
							</div>
							<div class="rTableRow">
								<div class="rTableHead">Description</div>
								<div class="rTableCell"><?php echo nl2br($row['description']); ?></div>
							</div>
							
						</div>
		            </div>
		        </div>                                    
		    </div>                                
		</div>
		<!-- Modal End -->


										</td>
									</tr>
								<?php
							}
							?>
							
							
						</tbody>
					</table>

				</div>
			</div>
		</div>
	</div>
</div>

<?php require_once('footer.php'); ?>