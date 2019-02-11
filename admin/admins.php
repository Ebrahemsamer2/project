<?php 
$page_title = "Admins";
include "inc/init.php";
$admins = "active";

?>
<div class="container-fluid">
    <div class='row'>
        <div class='col-sm-2'>
            <?php include "inc/sidebar.php"; ?>
        </div>
        <div class='col-sm'>
            <div class='admins'>
                <?php 
                if(! session_id()){
                    session_start();
                }
                if(isset($_SESSION['error_msg']) && ! empty($_SESSION['error_msg'])) {
                    echo "<div class='alert alert-danger'>";
                    echo $_SESSION['error_msg'];
                    echo "</div>";
                    $_SESSION['error_msg'] = "";
                }else if(isset($_SESSION['success_msg']) && ! empty($_SESSION['success_msg'])) {
                    echo "<div class='alert alert-success'>";
                    echo $_SESSION['success_msg'];
                    echo "</div>";
                    $_SESSION['success_msg'] = "";
                }
                ?>
                <div class="table-responsive">
                    <h4> Admins </h4>
                    <table class="table table-striped table-hover table-dark">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Username</th>
                                <th scope="col">Email</th>
                                <th scope="col">Image</th>
                                <th scope="col">Role Type</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 0;
                                  $hide = 0;
                            ?>
                            <?php foreach(get_admins() as $admin): 
                                $no++; 
                                $hide++;
                            
                            echo "<tr ";
                            if($hide > 10) {
                                echo "class='hide'>";
                            }else {
                                echo ">";
                            }
                            ?>
                                <th scope="row"><?php echo $no; ?></th>
                                <td title='<?php echo $admin["username"]; ?>'><?php
                                if(strlen($admin['username']) > 30) {
                                    echo substr($admin['username'],0,30) . '...';
                                }else {
                                    echo $admin['username']; 
                                }
                                ?></td>
                                <td><?php
                                if(strlen($admin['email']) > 50) {
                                    echo substr($admin['email'],0,50) . '...';
                                }else {
                                    echo $admin['email']; 
                                }
                                ?></td>
                                <td>
                                    <img height='80' width='80' src="uploads/admins/<?php echo $admin['image']; ?>" alt="">
                                </td>
                                <td><?php echo $admin['role_type']; ?> </td>
                                <td class='action-links'><a href='admin.php?id=<?php echo $admin["id"]; ?>' class='btn btn-info btn-sm'>Edit</a>
                                <form onsubmit="return confirm('Are You Sure?');" action="deleteadmin.php" method='POST'>
                                    <input type="hidden" value="<?php echo $admin["id"]; ?>" name="id">
                                    <input name='deleteadmin' class='btn btn-danger btn-sm' type='submit' value="Delete" />
                                </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <a style="float:right;margin-bottom:10px;" class="btn btn-primary" href="admin.php"><i class='fa fa-plus'></i> Add New Admin</a>
                    <?php if($hide > 10){ ?>
                        <a href="" class='show-more'>show more <i class='fa fa-angle-down'></i></a> 
                    <?php } ?>                       
                </div>
            </div>
        </div>
    </div>
</div>


<?php include "inc/footer.php"; ?>