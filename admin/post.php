<?php 
$page_title = "New Post";
include "inc/init.php"; 
$posts = "active"; ?>

<?php 
    $title = "";
    $content = "";
    $tags = "";
    $excerpt = "";
    $id = "";
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
                    redirect("posts.php");
                }else {
                    $_SESSION['error_msg'] = "Unable to add Post";
                }
            }
        }else {
            if( isset($_POST['updatepost'])) {

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
                        $title = "";
                        $content = "";
                        $tags = "";
                        $excerpt = "";
                        $id = "";
                        redirect("posts.php");
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
                <h3><?php if(isset( $_GET['id'])) { echo "Edit Post"; } else { echo "Add New Post";}?></h3>
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
                 <form action="post.php" method="POST" enctype="multipart/form-data" >
                    <div class="form-group">
                        <input name="id" type="hidden" value='<?php echo $id; ?>'>
                        <input value="<?php echo $title; ?>" class="form-control" type="text" placeholder="Post Title" required autocomplete="off" name="title">
                        <p class="error title-error">Title must be between 30 and 200 characters</p>
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" placeholder="Type Your Post" required autocomplete="off" name="content" cols="30" rows="10"><?php echo $content; ?></textarea>
                        <p class="error content-error">Content must be between 200 and 10000 characters</p>
                    </div>
                    <div class="form-group">
                        <select class='form-control' name="category">
                            <?php 
                                foreach(get_categories() as $category):
                                    echo "<option value='{$category['name']}' ";
                                    if(isset( $_GET['id'])) {
                                        if($post['category'] === $category['name']){
                                            echo "selected >";
                                        } else {
                                            echo ">";
                                        }
                                    } else {
                                        if($category['name'] === "Uncategorized"){
                                            echo "selected >";
                                        }else {
                                            echo ">";
                                        }
                                    }
                                    echo $category['name'];
                                    echo "</option>";
                                endforeach;
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input value="<?php echo $excerpt; ?>" class="form-control" type="text" placeholder="Excerpt ( Optional )" autocomplete="off" name="excerpt">
                        <p class="error excerpt-error">Excerpt must be between 100 and 500 characters</p>
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="text" placeholder="Tags ( Optional ) separate tags with ( , ) " autocomplete="off" name="tags" value="<?php echo $tags; ?>">
                    </div>
                    <?php 
                    if(isset( $_GET['id'])) {
                        if(! empty($post['image'])) { ?>
                        <div class='post-img' style="margin-bottom: 10px;">
                            <label for="img">Post Image: </label>
                            <img width="100" src="uploads/<?php echo $post['image']; ?>" alt="post thumbnail">
                        </div>
                    <?php   }
                    }
                    ?>
                    <div class="form-group">  
                        <input class="form-control" type="file" name="image">
                    </div>
                    <?php if(isset( $_GET['id'])) {
                        echo '<input value="Update Post" name="updatepost" style="float: right" type="submit" class="btn btn-primary">' ;
                    }else { ?>
                    <input value="Add Post" name="addpost" style="float: right" type="submit" class="btn btn-primary">
                    <?php  } ?>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include "inc/footer.php"; ?>