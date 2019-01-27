<?php 
$page_title = "New Post";
include "inc/init.php"; 
$posts = "active"; ?>

<?php 
    $title = "";
    $content = "";
    $tags = "";
    $excerpt = "";
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        if( isset($_POST['addpost'])) {

            $title = filter_input(INPUT_POST, 'title',FILTER_SANITIZE_STRING);
            $content = filter_input(INPUT_POST,'content',FILTER_SANITIZE_STRING);
            $category = filter_input(INPUT_POST,'category',FILTER_SANITIZE_STRING);
            $tags = filter_input(INPUT_POST,'tags',FILTER_SANITIZE_STRING);
            $excerpt = filter_input(INPUT_POST,'excerpt',FILTER_SANITIZE_STRING);
            $image = $_FILES['image'];

            $author = "Ebrahem"; // Temporary Author until creating admins
            date_default_timezone_set("Africa/Cairo");
            $datetime = date('M-d-Y h:m');
             
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

            //  No Errors: You're ready to go

            if(empty($error_msg)) {
                if(insert_post($title, $content, $category, $tags, $excerpt, $author, $image['name'])) {
                    if(! session_id()){
                        session_start();
                    }
                    if(! empty($image['name'])) {
                        $image_path = 'uploads/'.$image['name'];
                        move_uploaded_file($image['tmp_name'] , $image_path);
                    }
                    $_SESSION['success_msg'] = "Post has been added Successfully";
                    $title = "";
                    $content = "";
                    $tags = "";
                    $excerpt = "";
                }else {
                    $_SESSION['error_msg'] = "Unable to add Post";
                }
            }
        }
    }
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-2">
            <?php include "inc/sidebar.php"; ?>
        </div>
        <div class="col-sm">
            <div class='addnewpost'>
                <?php
                    if(isset($error_msg)){
                        if(count($error_msg) != 0){
                            foreach($error_msg as $msg) {
                                echo "<div class='alert alert-danger'>";
                                echo $msg;
                                echo "</div>";
                            }
                        }
                    }
                ?>
                 <h3>Add New Post</h3>
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
                 <form action="addnewpost.php" method="POST" enctype="multipart/form-data" >
                    <div class="form-group">
                        <input value="<?php echo $title; ?>" class="form-control" type="text" placeholder="Post Title" required autocomplete="off" name="title">
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" placeholder="Type Your Post" required autocomplete="off" name="content" cols="30" rows="10"><?php echo $content; ?></textarea>
                    </div>
                    <div class="form-group">
                        <select class='form-control' name="category">
                            <?php 
                                foreach(get_categories() as $category):
                                    echo "<option value='{$category['name']}' ";
                                    if($category['name'] === "Uncategorized"){
                                        echo "selected >";
                                    }else {
                                        echo ">";
                                    }
                                    echo $category['name'];
                                    echo "</option>";
                                endforeach;
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input value="<?php echo $excerpt; ?>" class="form-control" type="text" placeholder="Excerpt ( Optional )" autocomplete="off" name="excerpt">
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="text" placeholder="Tags ( Optional ) separate tags with ( , ) " autocomplete="off" name="tags" value="<?php echo $tags; ?>">
                    </div>
                    <div class="form-group">  
                        <input class="form-control" type="file" name="image">
                    </div>
                    <input value="Add Post" name="addpost" style="float: right" type="submit" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>
</div>

<?php include "inc/footer.php"; ?>