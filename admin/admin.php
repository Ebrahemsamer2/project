<?php 
$page_title = "New Admin";
include "inc/init.php"; 
$admins = "active"; ?>

<?php 
    $username = "";
    $email = "";
    $id = "";
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        if( isset($_POST['addadmin'])) {

            $username = filter_input(INPUT_POST, 'username',FILTER_SANITIZE_STRING);
            $email = filter_input(INPUT_POST,'email',FILTER_SANITIZE_EMAIL);
            $role_type = filter_input(INPUT_POST,'role_type',FILTER_SANITIZE_STRING);
            $image = $_FILES['image'];

            $password = password_hash("11111111", PASSWORD_DEFAULT);

            $created_by = "Ebrahem"; // Temporary Author until creating admins
            date_default_timezone_set("Africa/Cairo");
            $datetime = date('M-d-Y h:m');
             
            // Check For Errors

            $error_msg = "";
            if(strlen($username) < 10 || strlen($username) > 50) {
                $error_msg = "Admin username must be between 10 and 50 characters";
            } else if(strlen($email) < 10 || strlen($email) > 100) {
                $error_msg = "Admin email must be between 10 and 100 characters";
            }else {
                if(! empty($image['name'])) {
                    $allowed_extensions = array('jpg' , 'png' , 'jpeg');
                    $myextension = strtolower(explode('.',$image['name'])[1]);
                    if(! in_array($myextension, $allowed_extensions)){
                        $error_msg = "Sorry, Supported extensions are (PNG, JPG, JPEG)";
                    } else if($image['size'] > 1000000) {
                        $error_msg = "Image is too large";
                    }
                }
            }

            //  No Errors: You're ready to go

            if(empty($error_msg)) {
                if(insert_admin($datetime, $username, $email, $password, $role_type, $image['name'], $created_by)) {

                    // send email with default password ( 11111111 )

                    /* if(password_verify("11111111",$password)) {
                        $send_password = "11111111";
                        $content = "You're just Added To Zblog as Admin, Congrats Your default password to login with is 
                        $send_password , Do not forget to change it to stronger one";
                        $subject = "Getting Default Password";
                        $header = "From: ZBlog Administration";

                        mail("ebrahemsamer2@gmail.com", $subject, $content, $header);
                    } */ // until uploading to a real server
                    if(! session_id()){
                        session_start();
                    }
                    if(! empty($image['name'])) {
                        $image_path = 'uploads/admins/'.$image['name'];
                        move_uploaded_file($image['tmp_name'] , $image_path);
                    }
                    $_SESSION['success_msg'] = "Admin has been added Successfully";
                    redirect("admins.php");
                }else {
                    $_SESSION['error_msg'] = "Unable to add admin";
                    redirect("admins.php");
                }
            }
        }else {
            if( isset($_POST['updateadmin'])) {

                $id = filter_input(INPUT_POST, 'id',FILTER_SANITIZE_NUMBER_INT);

                $title = filter_input(INPUT_POST, 'title',FILTER_SANITIZE_STRING);
                $content = filter_input(INPUT_POST,'content',FILTER_SANITIZE_STRING);
                $category = filter_input(INPUT_POST,'category',FILTER_SANITIZE_STRING);
                $tags = filter_input(INPUT_POST,'tags',FILTER_SANITIZE_STRING);
                $excerpt = filter_input(INPUT_POST,'excerpt',FILTER_SANITIZE_STRING);
                $image = $_FILES['image'];
                $author = "Ebrahem"; // Temporary Author until creating admins

                // Check For Errors

                $error_msg = array();
                if(strlen($title) < 10 || strlen($title) > 200) {
                    $error_msg[] = "Post Title must be between 10 and 200 characters";
                } else if(strlen($content) < 200 || strlen($content) > 10000) {
                    $error_msg[] = "Post Content must be between 200 and 10000 characters";
                }else {
                    if(! empty($image['name'])) {
                        $allowed_extensions = array('jpg' , 'png' , 'jpeg');
                        $myextension = strtolower(explode('.',$image['name'])[1]);
                        if(! in_array($myextension, $allowed_extensions)){
                            $error_msg[] = "Sorry, Supported extensions are (PNG, JPG, JPEG)";
                        } else if($image['size'] > 1000000) {
                            $error_msg[] = "Image is too large";
                        }
                    }
                }

                if(empty($error_msg)) {
                    $updated = "";
                    if(! empty($image)) {
                        $updated = update_post($title, $content, $category, $tags, $excerpt, $author, $image['name'],$id);
                    }else {
                        $updated = update_post($title, $content, $category, $tags, $excerpt, $author,$id);
                    }
                    if($updated) {
                        if(! session_id()){
                            session_start();
                        }
                        if(! empty($image['name'])) {
                            $image_path = 'uploads/'.$image['name'];
                            move_uploaded_file($image['tmp_name'] , $image_path);
                        }
                        $_SESSION['success_msg'] = "Post has been Updated Successfully";
                        $username = "";
                        $email = "";
                        redirect("admins.php");
                    }else {
                        $_SESSION['error_msg'] = "Unable to Update Post";
                    }

                }

            }
        }
    }
    else if(isset( $_GET['id'])) {
        $id = filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
        $post = get_posts("",$id);

        $title = $post['title'];
        $content = $post['content'];
        $tags = $post['tags'];
        $excerpt = $post['excerpt'];
    }
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-2">
            <?php include "inc/sidebar.php"; ?>
        </div>
        <div class="col-sm">
            <div class='admin'>
                <?php
                    if(isset($error_msg)){
                        echo "<div class='alert alert-danger'>";
                        echo $error_msg;
                        echo "</div>";
                    }
                ?>
                <h3><?php if(isset( $_GET['id'])) { echo "Edit Admin"; } else { echo "Add New Admin";}?></h3>
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
                 <form action="admin.php" method="POST" enctype="multipart/form-data" >
                    <div class="form-group">
                        <input name="id" type="hidden" value='<?php echo $id; ?>'>
                        <input value="<?php echo $username; ?>" class="form-control" type="text" placeholder="Username" required autocomplete="off" name="username">
                        <p class="error username-error">Username must be between 10 and 50 characters</p>
                    </div>
                    <div class="form-group">
                        <input value="<?php echo $email; ?>" class="form-control" type="email" placeholder="Email" autocomplete="off" name="email">
                        <p class="error email-error">Email must be between 10 and 100 characters</p>
                    </div>
                    <div class="form-group">
                        <select class='form-control' name="role_type">
                            <option value="Admin">Admin</option>
                            <option value="Subscriber">Subscriber</option>
                        </select>
                    </div>
                    <?php 
                    if(isset( $_GET['id'])) {
                        if(! empty($post['image'])) { ?>
                        <div class='post-img' style="margin-bottom: 10px;">
                            <label for="img">Admin Image: </label>
                            <img width="100" src="uploads/admins/<?php echo $admin['image']; ?>" alt="Admin Photo">
                        </div>
                    <?php   }
                    }
                    ?>
                    <div class="form-group">  
                        <input class="form-control" type="file" name="image">
                    </div>
                    <?php if(isset( $_GET['id'])) {
                        echo '<input value="Update Admin" name="updateadmin" style="float: right" type="submit" class="btn btn-primary">' ;
                    }else { ?>
                    <input value="Add Admin" name="addadmin" style="float: right" type="submit" class="btn btn-primary">
                    <?php  } ?>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include "inc/footer.php"; ?>