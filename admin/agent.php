<?php require_once('header.php'); ?>

<?php
if(isset($_POST['form1'])) {
	$statement = $pdo->prepare("UPDATE tbl_agent SET agent_access=? WHERE agent_id=?");
	$statement->execute(array(0,$_POST['agent_id']));
}
if(isset($_POST['form2'])) {
	$statement = $pdo->prepare("UPDATE tbl_agent SET agent_access=? WHERE agent_id=?");
	$statement->execute(array(1,$_POST['agent_id']));
}
?>

<section class="content-header">
	<div class="content-header-left">
		<h1>View All Agents</h1>
	</div>
</section>

<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-info">
				<div class="box-body table-responsive">
					<table id="example1" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th width="50">SL</th>
								<th>Photo</th>
								<th>Name</th>
								<th>Designation & Organization</th>
								<th>Email & Phone</th>
								<th>City</th>
								<th>Country</th>
								<th>Status</th>
								<th width="150">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$i=0;
							$statement = $pdo->prepare("SELECT * FROM tbl_agent");
							$statement->execute();
							$result = $statement->fetchAll(PDO::FETCH_ASSOC);
							foreach ($result as $row) {
								$i++;
								?>
								<tr>
									<td style="width:70px;"><?php echo $i; ?></td>
									<td style="width:100px;"><img src="../assets/uploads/agents/<?php echo $row['agent_photo']; ?>" alt="" style="width:100px;"></td>
									<td><?php echo $row['agent_name']; ?></td>
									<td>
                                        <b>Designation:</b> <?php echo $row['agent_designation']; ?><br>
                                        <b>Organization:</b> <?php echo $row['agent_organization']; ?>
                                    </td>
									<td>
                                        <b>Email:</b> <?php echo $row['agent_email']; ?><br>
                                        <b>Phone:</b> <?php echo $row['agent_phone']; ?>
                                    </td>
									<td><?php echo $row['agent_city']; ?></td>
									<td><?php echo $row['agent_country']; ?></td>
									<td>
										<?php
											if($row['agent_access'] == '1') {
												echo 'Active';
											} else {
												echo 'Inactive';
											}
										?>
									</td>
									<td style="width:100px;">
										<a href="" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#myModalDetail<?php echo $i; ?>" style="width:100%;margin-bottom:4px;">Details</a>
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
                                <div class="rTableHead">Featured Photo</div>
                                <div class="rTableCell">
                                    <img src="<?php echo BASE_URL; ?>assets/uploads/agents/<?php echo $row['agent_photo']; ?>" alt="" style="width:150px;">
                                </div>
                            </div>              
                                                
                            
                            <div class="rTableRow">
                                <div class="rTableHead">Name</div>
                                <div class="rTableCell">
                                    <?php echo $row['agent_name']; ?>
                                </div>
                            </div>                            

                            <div class="rTableRow">
                                <div class="rTableHead">Designation</div>
                                <div class="rTableCell">
                                    <?php echo $row['agent_designation']; ?>
                                </div>
                            </div>

                            <div class="rTableRow">
                                <div class="rTableHead">Organization</div>
                                <div class="rTableCell">
                                    <?php echo $row['agent_organization']; ?>
                                </div>
                            </div>

                            <div class="rTableRow">
                                <div class="rTableHead">Description</div>
                                <div class="rTableCell">
                                	<?php if(!empty($row['agent_description'])): ?>
                                    	<?php echo nl2br($row['agent_description']); ?>
                                	<?php else: ?>
										<?php echo '---'; ?>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="rTableRow">
                                <div class="rTableHead">Email</div>
                                <div class="rTableCell">
                                    <?php echo $row['agent_email']; ?>
                                </div>
                            </div>

                            <div class="rTableRow">
                                <div class="rTableHead">Phone</div>
                                <div class="rTableCell">
                                    <?php echo $row['agent_phone']; ?>
                                </div>
                            </div>

                            <div class="rTableRow">
                                <div class="rTableHead">Website</div>
                                <div class="rTableCell">
                                	<?php if(!empty($row['agent_website'])): ?>
                                    	<?php echo $row['agent_website']; ?>
                                	<?php else: ?>
										<?php echo '---'; ?>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="rTableRow">
                                <div class="rTableHead">Address</div>
                                <div class="rTableCell">
                                    <?php echo nl2br($row['agent_address']); ?>
                                </div>
                            </div>

                            <div class="rTableRow">
                                <div class="rTableHead">City</div>
                                <div class="rTableCell">
                                    <?php echo $row['agent_city']; ?>
                                </div>
                            </div>

                            <div class="rTableRow">
                                <div class="rTableHead">State</div>
                                <div class="rTableCell">
                                    <?php echo $row['agent_state']; ?>
                                </div>
                            </div> 

                            <div class="rTableRow">
                                <div class="rTableHead">Country</div>
                                <div class="rTableCell">
                                    <?php echo $row['agent_country']; ?>
                                </div>
                            </div>                            

                            <div class="rTableRow">
                                <div class="rTableHead">Zip Code</div>
                                <div class="rTableCell">
                                    <?php echo $row['agent_zip_code']; ?>
                                </div>
                            </div>

                            <div class="rTableRow">
                                <div class="rTableHead">Map</div>
                                <div class="rTableCell">
                                	<?php if(!empty($row['agent_map'])): ?>
                                    	<?php echo $row['agent_map']; ?>
                                	<?php else: ?>
										<?php echo '---'; ?>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="rTableRow">
                                <div class="rTableHead">Facebook</div>
                                <div class="rTableCell">
                                	<?php if(!empty($row['agent_facebook'])): ?>
                                    	<?php echo $row['agent_facebook']; ?>
                                	<?php else: ?>
										<?php echo '---'; ?>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="rTableRow">
                                <div class="rTableHead">Twitter</div>
                                <div class="rTableCell">
                                	<?php if(!empty($row['agent_twitter'])): ?>
                                    	<?php echo $row['agent_twitter']; ?>
                                	<?php else: ?>
										<?php echo '---'; ?>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="rTableRow">
                                <div class="rTableHead">Linkedin</div>
                                <div class="rTableCell">
                                	<?php if(!empty($row['agent_linkedin'])): ?>
                                    	<?php echo $row['agent_linkedin']; ?>
                                	<?php else: ?>
										<?php echo '---'; ?>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="rTableRow">
                                <div class="rTableHead">Google Plus</div>
                                <div class="rTableCell">
                                	<?php if(!empty($row['agent_googleplus'])): ?>
                                    	<?php echo $row['agent_googleplus']; ?>
                                	<?php else: ?>
										<?php echo '---'; ?>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="rTableRow">
                                <div class="rTableHead">Pinterest</div>
                                <div class="rTableCell">
                                	<?php if(!empty($row['agent_pinterest'])): ?>
                                    	<?php echo $row['agent_pinterest']; ?>
                                	<?php else: ?>
										<?php echo '---'; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>                                    
            </div>                                
        </div>
        <!-- Modal End -->
										<form action="" method="post">
											<input type="hidden" name="agent_id" value="<?php echo $row['agent_id']; ?>">
											<?php if($row['agent_access']=='1'): ?>
												<input onclick="return confirmInactive();" type="submit" value="Make Inactive" class="btn btn-danger btn-xs" name="form1" style="width:100%;">
											<?php else: ?>
												<input onclick="return confirmActive();" type="submit" value="Make Active" class="btn btn-success btn-xs" name="form2" style="width:100%;">
											<?php endif; ?>
										</form>
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
</section>

<?php require_once('footer.php'); ?>