<?php 
$page_title = "New Comment";
include "inc/init.php"; 
$comments = "active"; ?>

<?php 
    $commenter_name = "";
    $commenter_email = "";
    $comment_comment = "";
    if(! session_id()) {
        session_start();
    }
    if(isset($_SESSION['admin_username'])) {
        $commenter_name = $_SESSION['admin_username'];
        $commenter_email = $_SESSION['admin_email'];
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        if( isset($_POST['addcomment'])) {

            $commenter_name = filter_input(INPUT_POST, 'name',FILTER_SANITIZE_STRING);
            $commenter_email = filter_input(INPUT_POST,'email',FILTER_SANITIZE_EMAIL);
            $comment_comment = filter_input(INPUT_POST,'comment',FILTER_SANITIZE_STRING);
            $post_id = filter_input(INPUT_POST,'post_id',FILTER_SANITIZE_NUMBER_INT);
            
            date_default_timezone_set("Africa/Cairo");
            $datetime =  date('M-d-Y h:m', time());
            
            // Check For Errors

            $error_msg = "";
            if(strlen($comment_comment) < 10 || strlen($comment_comment) > 500) {
                $error_msg = "Comment must be between 10 and 500 characters";
            }
            //  No Errors: You're ready to go

            if(empty($error_msg)) {
                if(insert_comment($datetime, $commenter_name, $commenter_email, $comment_comment, $post_id)) {
                    if(! session_id()){
                        session_start();
                    }
                    $_SESSION['success_msg'] = "Comment has been added Successfully";
                    $commenter_name = "";
                    $commenter_email = "";
                    $comment_comment = "";
                    redirect("comments.php");
                }else {
                    $_SESSION['error_msg'] = "Unable to add Comment";
                }
            }else {
                $_SESSION['error_msg'] = $error_msg;
            }
        }else {
            if( isset($_POST['updatecomment'])) {

                $id = filter_input(INPUT_POST, 'id',FILTER_SANITIZE_NUMBER_INT);

                $commenter_name = filter_input(INPUT_POST, 'name',FILTER_SANITIZE_STRING);
                $commenter_email = filter_input(INPUT_POST,'email',FILTER_SANITIZE_STRING);
                $comment_comment = filter_input(INPUT_POST,'comment',FILTER_SANITIZE_STRING);
                $post_id = filter_input(INPUT_POST,'post_id',FILTER_SANITIZE_NUMBER_INT);
                // Check For Errors

                $error_msg = "";
                if(strlen($comment_comment) < 10 || strlen($comment_comment) > 500) {
                    $error_msg = "Comment must be between 5 and 500 characters";
                }
                //  No Errors: You're ready to go

                if(empty($error_msg)) {

                    $updated = update_comment($comment_comment, $post_id,$id);
                    if($updated) {
                        if(! session_id()){
                            session_start();
                        }
                        
                        $_SESSION['success_msg'] = "Comment has been Updated Successfully";
                        $commenter_name = "";
                        $commenter_email = "";
                        $comment_comment = "";
                        redirect("comments.php");
                    }else {
                        $_SESSION['error_msg'] = "Unable to Update Comment";
                    }

                }

            }
        }
    }
    else if(isset( $_GET['id'])) {
        $id = filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
        $comment = get_comment($id);

        $commenter_name = $comment['commenter_name'];
        $commenter_email = $comment['commenter_email'];
        $comment_comment = $comment['comment'];
        $post_id = $comment['post_id'];
    }
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-2">
            <?php include "inc/sidebar.php"; ?>
        </div>
        <div class="col-sm">
            <div class='addnewpost'>
                <h4><?php if(isset( $_GET['id'])) { echo "Edit Comment"; } else { echo "Add New Comment";}?></h4>
                 <?php 
                        if(! session_id()){
                            session_start();
                        }
                        if(isset($_SESSION['error_msg']) && ! empty($_SESSION['error_msg'])) {
                            echo "<div class='alert alert-danger alert-dismissible fade show'>";
                            echo $_SESSION['error_msg'];
                            echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>';
                            echo "</div>";
                            $_SESSION['error_msg'] = "";
                        }else if(isset($_SESSION['success_msg']) && ! empty($_SESSION['success_msg'])) {
                            echo "<div class='alert alert-success alert-dismissible fade show'>";
                            echo $_SESSION['success_msg'];
                            echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>';
                            echo "</div>";
                            $_SESSION['success_msg'] = "";
                        }
                 ?>
                 <form action="comment.php" method="POST" enctype="multipart/form-data" >
                    <div class="form-group">
                        <input name="id" type="hidden" value='<?php echo $id; ?>'>
                        <input readonly value="<?php echo $commenter_name; ?>" class="form-control" type="text" placeholder="Name: " required autocomplete="off" name="name">
                        <p class="error name-error">Name must be between 5 and 30 characters</p>
                    </div>
                    <div class="form-group">
                        <input readonly value="<?php echo $commenter_email; ?>" class="form-control" type="email" placeholder="Email: " required autocomplete="off" name="email">
                        <p class="error email-error">Email must be between 10 and 100 characters</p>
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" placeholder="Type Your Comment" required autocomplete="off" name="comment" cols="30" rows="10"><?php echo $comment_comment; ?></textarea>
                        <p class="error comment-error">Comment must be between 20 and 500 characters</p>
                    </div>
                    <div class="form-group">
                        <select class='form-control' name="post_id">
                            <?php 
                                foreach(get_posts() as $post):
                                    echo "<option value='{$post['id']}' ";
                                    if(isset( $_GET['id'])) {
                                        if($post_id === $post['id']){
                                            echo "selected >";
                                        } else {
                                            echo ">";
                                        }
                                    } else {
                                        echo ">";
                                    }
                                    echo $post['title'];
                                    echo "</option>";
                                endforeach;
                            ?>
                        </select>
                    </div>
                    <?php if(isset( $_GET['id'])) {
                        echo '<input value="Update Comment" name="updatecomment" style="float: right" type="submit" class="btn btn-primary">' ;
                    }else { ?>
                    <input value="Add Comment" name="addcomment" style="float: right" type="submit" class="btn btn-primary">
                    <?php  } ?>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include "inc/footer.php"; ?>