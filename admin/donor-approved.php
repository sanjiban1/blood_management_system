<?php require_once('header.php'); ?>

<section class="content-header">
    <div class="content-header-left">
        <h1>View All Approved Donors</h1>
    </div>
    <div class="content-header-right">
        <a href="donor-pending.php" class="btn btn-primary btn-sm">Pending Donors</a>
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
                    <th>Serial</th>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Profession</th>
                    <th>Age</th>
                    <th>Blood Group</th>
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


                                            WHERE t1.status=1");
                $statement->execute();
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
                                <a href="" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#myModalDetail<?php echo $i; ?>">Details</a>
                                <a href="#" class="btn btn-danger btn-xs" data-href="donor-delete.php?id=<?php echo $row['donor_id']; ?>" data-toggle="modal" data-target="#confirm-delete">Delete</a>


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
  
</section>


<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Delete Confirmation</h4>
            </div>
            <div class="modal-body">
                Are you sure want to delete this item?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok">Delete</a>
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>