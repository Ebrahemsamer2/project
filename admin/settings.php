<?php 
$page_title = "Site Settings | ZBlog";
include "inc/init.php";
$settings = "active"; ?>

<?php foreach(get_settings() as $setting):
    $name = $setting['name'];
    $tagline = $setting['tagline'];
    $logo = $setting['logo'];
    $home_posts_number = $setting['home_posts_number'];
    $posts_order = $setting['posts_order'];
    $related_posts_number = $setting['related_posts_number'];
    $recent_posts_number = $setting['recent_posts_number'];
endforeach; ?>


<?php 

    if($_SERVER['REQUEST_METHOD'] === 'POST') {

        if(isset($_POST['save-general'])) {

            $name = filter_input(INPUT_POST,'name',FILTER_SANITIZE_STRING);
            $tagline = filter_input(INPUT_POST,'tagline',FILTER_SANITIZE_STRING);
            $logo_image = $_FILES['logo'];

            $logo_name = $logo_image['name'];
            $logo_tmp_name = $logo_image['tmp_name'];
            $logo_size = $logo_image['size'];

            $error_msg = "";
            if(strlen($name) < 3 || strlen($name) > 15) {
                $error_msg = "$name must between 3, 15 characters";
            }else if(strlen($tagline) < 10 || strlen($tagline) > 100) {
                $error_msg = "$tagline must between 10, 100 characters";
            }else {

                if(! empty($logo_name)) {

                    $allowed_extensions = array('jpg', 'png', 'jpeg');
                    $my_extension = strtolower(explode('.', $logo_name)[1]);
                    if(! in_array($my_extension,$allowed_extensions)) {
                        $error_msg = "$my_extension is not allawed extension, only (jpg, png, jpeg) are Allawed";
                    }else if($logo_size > 2000000) {
                        $error_msg = "$tagline must between 10, 100 characters";
                    }
                }
            }
            
            if(empty($error_msg)) {
                $updated = "";
                if(empty($logo_name)) {
                    $updated = update_general_settings($name, $tagline);
                }else {
                    $updated = update_general_settings($name, $tagline, $logo_name);
                }
                if(! session_id()) {
                    session_start();
                }
                if($updated) {
                    if(! empty($logo_name)) {
                        $new_path = "uploads/".$logo_name;
                        move_uploaded_file($logo_tmp_name,$new_path);
                    }
                    $_SESSION['success'] = "Settings are Changed";

                }else {
                    $_SESSION['error'] = "Unable to update settings";
                }

            }else {
                $_SESSION['error'] = $error_msg;
            }
        }else if(isset($_POST['save-posts'])) {

            $home_posts_number = filter_input(INPUT_POST,'hpn',FILTER_SANITIZE_NUMBER_INT);
            $order = filter_input(INPUT_POST,'order',FILTER_SANITIZE_STRING);
            $related_posts_number = filter_input(INPUT_POST,'related',FILTER_SANITIZE_NUMBER_INT);
            $recent_posts_number = filter_input(INPUT_POST,'recent',FILTER_SANITIZE_NUMBER_INT);

            $error_msg = "";
            if( $home_posts_number < 2 || $home_posts_number > 20 ) {
                $error_msg = "Number of Posts at home page can not be less than 2 and more than 20 post";
            }else if($recent_posts_number < 2 || $recent_posts_number > 10) {
                $error_msg = "Recent Posts can not be less than 2 and more than 10 posts";
            }else if($related_posts_number < 1 || $related_posts_number > 4) {
                $error_msg = "Related Posts can not be less than 1 and more than 4 posts";
            }

            if(empty($error_msg)) {
                if(! session_id()){
                    session_start();
                }
                if(update_posts_settings($home_posts_number, $order, $related_posts_number, $recent_posts_number)) {
                    $_SESSION['success'] = "Settings Are Changed";
                }else {
                    $_SESSION['error'] = "Settings Are Changed";
                }
            }else {
                $_SESSION['error'] = $error_msg;
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
            <div class='settings'>
                <div class='general-setting'>
                    <h4>General Settings</h4>
                    <form action="settings.php" method='POST' enctype="multipart/form-data" >
                    
                        <div class='form-group'>
                            <div class='row'>
                                <div class='col-sm-2'>
                                    <label for="site-name">Site Name: </label>
                                </div>
                                <div class='col-sm-6'>
                                    <input name='name' value="<?php echo $name; ?>" class='form-control' id='site-name' placeholder='Site Name' type="text">
                                </div>
                            </div>
                        </div>
                        <div class='form-group'>
                            <div class='row'>
                                <div class='col-sm-2'>
                                    <label for="site-tagline">Site Tagline: </label>
                                </div>
                                <div class='col-sm-6'>
                                    <input name='tagline' value="<?php echo $tagline; ?>" class='form-control' id='site-name' placeholder='Site Tagline' type="text">
                                </div>
                            </div>
                        </div>
                        <div class='form-group'>
                            <div class='row'>
                                <div class='col-sm-2'>
                                    <label>Site Logo: </label>
                                </div>
                                <div class='col-sm-6'>
                                    <img class='site-logo' width='200' height='200' src="uploads/<?php echo $logo; ?>" alt="">
                                    <input class='form-control' name='logo' type="file">
                                    <input style='float:right;' type="submit" name='save-general' value='Save Changes' class='btn btn-info' >
                                </div>
                            </div>
                        </div>
                    </form>
                <div>

                <div class='posts-setting'>
                    <hr>
                    <h4>Posts Settings</h4>
                    <form action="settings.php" method='POST'>
                        <div class='form-group'>
                            <div class='row'>
                                <div class='col-sm-2'>
                                    <label for="posts-number">Home Posts Number :</label>
                                </div>
                                <div class='col-sm-6'>
                                    <input name='hpn' value="<?php echo $home_posts_number; ?>" placeholder='Posts Number in Home Page' min='2' max='20' class='form-control' id='posts-number' type="number">
                                </div>
                            </div>
                        </div>
                        <div class='form-group'>
                            <div class='row'>
                                <div class='col-sm-2'>
                                    <label for="posts-order">Posts Order :</label>
                                </div>
                                <div class='col-sm-6'>
                                <select class='form-control' name="order">
                                    <?php if($posts_order === 'newest') {
                                        echo "<option selected value='newest'>";
                                        echo "Newest";
                                        echo "</option>";
                                        echo "<option value='oldest'>";
                                        echo "Oldest";
                                        echo "</option>";
                                    } else {
                                        echo "<option value='newest'>";
                                        echo "Newest";
                                        echo "</option>";
                                        echo "<option selected value='oldest'>";
                                        echo "Oldest";
                                        echo "</option>";
                                    }?>
                                </select>
                                </div>
                            </div>
                        </div>
                        <div class='form-group'>
                            <div class='row'>
                                <div class='col-sm-2'>
                                    <label for="related-posts-number">Related Posts Number :</label>
                                </div>
                                <div class='col-sm-6'>
                                    <input name='related' value="<?php echo $related_posts_number ?>" placeholder='Related Posts Number' min='2' max='5' class='form-control' id='related-posts-number' type="number">
                                </div>
                            </div>
                        </div>
                        <div class='form-group'>
                            <div class='row'>
                                <div class='col-sm-2'>
                                    <label for="recent-posts-number">Recent Posts Number :</label>
                                </div>
                                <div class='col-sm-6'>
                                    <input name='recent' value="<?php echo $recent_posts_number; ?>" placeholder='Recent Posts Number' min='2' max='10' class='form-control' id='recent-posts-number' type="number">
                                    <input style='float:right;' type="submit" name='save-posts' value='Save Changes' class='btn btn-info' >
                                </div>
                            </div>
                        </div>
                    </form>
                <div>
            </div>
        </div>
   </div>
</div>

<?php include "inc/footer.php"; ?>