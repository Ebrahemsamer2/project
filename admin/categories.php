<?php 
$page_title = "Dashboard";
include "inc/init.php"; 
$categories = "active"; ?>

<?php 
$name = "";
    if($_SERVER['REQUEST_METHOD'] === 'POST' ) {
        if(isset($_POST['addcategory'])) {
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            $author = "Ebrahem"; // Temporary Author until creating admins
            date_default_timezone_set("Africa/Cairo");
            $datetime = date('M-d-Y h:m');

            $error_msg = "";
            if(strlen($name) < 4 || strlen($name) > 30) {
                $error_msg = "Category Name should be between 4 and 30 Characters";
            }

            if(empty($error_msg)) {
                if(! session_id()){
                    session_start();
                }
                if(insert_category($datetime, $name, $author)) {
                    $_SESSION['success_msg'] = "Category has been Added Successfully";
                    redirect("categories.php");
                }else {
                    $_SESSION['error_msg'] = "Unable to Add Category";
                    redirect("categories.php");
                }
            }
        }else if(isset($_POST['deletecategory'])) {
            $id = filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT);
            if(! session_id()){
                session_start();
            }
            if(delete('categories',$id)) {
                $_SESSION['success_msg'] = "Category has been Deleted";
                redirect("categories.php");
            }else {
                $_SESSION['error_msg'] = "Unable to Delete Category, Try Again";
                redirect("categories.php");  
            }
        }else {
            if(isset($_POST['updatecategory'])) {
                    $id = filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT);
                    $name = filter_input(INPUT_POST,'name',FILTER_SANITIZE_STRING);
                    $error_msg = "";
                    if(strlen($name) < 4 || strlen($name) > 30) {
                        $error_msg = "Category Name should be between 4 and 30 Characters";
                    }

                    if(empty($error_msg)) {
                        if(! session_id()){
                            session_start();
                        }
                        if(update_category($id,$name)) {
                            $_SESSION['success_msg'] = "Category has been Updated Successfully";
                            $name = "";
                        }else {
                            $_SESSION['error_msg'] = "Unable to Update Category";
                        }
                    }
            }
        }
    }else {
        if( isset($_GET['id']) ) {
            $id = filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
            $category = get_categories("",$id);
            $name = $category['name'];
        }
    }
?>



<div class="container-fluid">
    <div class="row">
        <div class="col-sm-2">
            <?php include "inc/sidebar.php"; ?>
        </div>
        <div class="col-sm">
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
            <div class='categories'>
                <h3>Categories</h3>
                <?php 
                    if(! empty($error_msg)){
                        echo "<div class='alert alert-danger'>";
                        echo $error_msg;
                        echo "</div>";
                    }
                ?>
                <form action="categories.php" method="POST">
                    <div class='form-group'>
                        <input type="hidden" value="<?php echo $id; ?>" name='id' >
                        <input value="<?php echo $name; ?>" type="text" name="name" placeholder='Category Name' class='form-control' required autocomplete='off'>
                        <p class='error name-error'>Category Name must be between 5 and 50 characters</p>
                    </div>
                    <?php 
                        if(isset($_GET['id'])){                        
                            echo "<input style='float:right;' type='submit' class='btn btn-primary' value='Update Category' name='updatecategory'>";           
                        }else {
                    ?>
                    <input style="float:right;" type="submit" class='btn btn-primary' value='Add Category' name='addcategory'>
                        <?php } ?>
                </form>
                <div class='table-responsive'>
                    <table class="table table-striped table-hover table-dark">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Created at</th>
                                    <th scope="col">Category Name</th>
                                    <th scope="col">Creater</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 0;
                                    $hide = 0;
                                ?>
                                <?php foreach(get_categories() as $category): 
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
                                    <td><?php echo $category['datetime']; ?></td>
                                    <td title='<?php echo $category["name"]; ?>'><?php
                                    if(strlen($category['name']) > 30) {
                                        echo substr($category['name'],0,30) . '...';
                                    }else {
                                        echo $category['name']; 
                                    }
                                    ?></td>
                                    <td><?php echo $category['creater_name']; ?></td>
                                    <td class='action-links'><a href='categories.php?id=<?php echo $category["id"]; ?>' class='btn btn-info btn-sm'>Edit</a>
                                    <form onsubmit="return confirm('Are You Sure?');" action="categories.php" method='POST'>
                                        <input type="hidden" value="<?php echo $category["id"]; ?>" name="id">
                                        <input name='deletecategory' class='btn btn-danger btn-sm' type='submit' value="Delete" />
                                    </form>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
            </div>
        </div>
    </div>
</div>

<?php include "inc/footer.php"; ?>