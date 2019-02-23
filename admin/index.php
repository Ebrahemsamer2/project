<?php 
$page_title = "Dashboard | ZBlog";
include "inc/init.php";
$dashboard = "active";
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-2">
            <?php include "inc/sidebar.php"; ?>
        </div>
        <div class="col-sm">
            <div class='dashboard'>
                <h4>DashBoard</h4>
                <div class='row'>
                    <div class='col-sm-12'>
                        <div class='counts'>
                            <div class="row">
                                <div class='col-sm text-center'>
                                    <span><span class='num'><?php echo get_posts_number(); ?> </span><br>Posts</span>
                                </div>
                                <div class='col-sm text-center'>
                                    <span><span class='num'><?php echo get_categories_number(); ?> </span><br>Categories</span>
                                </div>
                                <div class='col-sm text-center'>
                                    <span><span class='num'><?php echo get_comments_number(); ?> </span><br>Comments</span>
                                </div>
                                <div class='col-sm text-center'>
                                    <span><span class='num'><?php echo "2300"; ?> </span><br>Users</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='col-sm-5'>
                        <div class='new-links'>
                            <a href="post.php"><i class='fa fa-pencil'></i> Add New Post</a>
                            <a href="categories.php"><i class='fa fa-list'></i> Add New Category</a>
                            <a href="comment.php"><i class='fa fa-comments'></i> Add New Comment</a>
                            <a href="admin.php"><i class='fa fa-user-secret'></i> Add New Admin</a>
                        </div>
                    </div>
                    <div class='col-sm-6'>
                        <div class='recent-posts'>
                            <h5>Recent Posts</h5>
                            <?php foreach(get_posts(3) as $post): ?>
                            <a href="post.php?id=<?php echo $post['id']; ?>"><h6><?php echo $post['title']; ?></h6></a>
                            <?php endforeach; ?>
                        </div>
                        <div class='recent-cats'>
                            <h5>Recent Categories</h5>
                            <?php foreach(get_categories(3) as $category): ?>
                            <a href="categories.php?id=<?php echo $category['id']; ?>"><h6><?php echo $category['name']; ?></h6></a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div><?php include "inc/footer.php"; ?></div>
        </div>
    </div>
</div>

