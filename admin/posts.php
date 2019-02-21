<?php 
$page_title = "Posts";
include "inc/init.php";
$posts = "active";

?>
<div class="container-fluid">
    <div class='row'>
        <div class='col-sm-2'>
            <?php include "inc/sidebar.php"; ?>
        </div>
        <div class='col-sm'>
            <div class='posts'>
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
                    <h4> Posts </h4>
                    <table class="table table-striped table-hover table-dark">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Title</th>
                                <th scope="col">Content</th>
                                <th scope="col">Image</th>
                                <th scope="col">Comments</th>
                                <th scope="col">Author</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 0;
                                  $hide = 0;
                            ?>
                            <?php foreach(get_posts() as $post): 
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
                                <td title='<?php echo $post["title"]; ?>'><?php
                                if(strlen($post['title']) > 30) {
                                    echo substr($post['title'],0,30) . '...';
                                }else {
                                    echo $post['title']; 
                                }
                                ?></td>
                                <td><?php
                                if(strlen($post['content']) > 100) {
                                    echo substr($post['content'],0,100) . '...';
                                }else {
                                    echo $post['content']; 
                                }
                                ?></td>
                                <td>
                                    <img width='100' src="uploads/posts/<?php echo $post['image']; ?>" alt="">
                                </td>
                                <td>
                                    <?php if(get_post_comments(1, $post['id'])) { ?>
                                        <span class='badge badge-success'><?php echo get_post_comments(1, $post['id']); ?> </span> 
                                    <?php } ?>

                                    <?php if(get_post_comments(0, $post['id'])) { ?>
                                        <span style='float: right;' class='badge badge-warning'><?php echo get_post_comments(0, $post['id']); ?> </span> 
                                    <?php } ?>
                                </td>
                                <td><?php echo $post['author']; ?></td>
                                <td class='action-links'><a href='post.php?id=<?php echo $post["id"]; ?>' class='btn btn-info btn-sm'>Edit</a>
                                <form onsubmit="return confirm('Are You Sure?');" action="deletepost.php" method='POST'>
                                    <input type="hidden" value="<?php echo $post["id"]; ?>" name="id">
                                    <input name='deletepost' class='btn btn-danger btn-sm' type='submit' value="Delete" />
                                </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <a style="float:right;margin-bottom:10px;" class="btn btn-primary" href="post.php"><i class='fa fa-plus'></i> Add New Post</a>
                    <a href="" class='show-more'>show more <i class='fa fa-angle-down'></i></a>                        
                </div>
            </div>
        </div>
    </div>
</div>


<?php include "inc/footer.php"; ?>