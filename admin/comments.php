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
            <div class='comments'>
                <?php 
                if(! session_id()){
                    session_start();
                }
                if(isset($_SESSION['error_msg']) && ! empty($_SESSION['error_msg'])) {
                    echo "<div class='alert alert-danger'>";
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
                <div class="table-responsive">
                    <h4> Approved Comments </h4>
                    <table class="table table-striped table-hover table-dark">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Created_at</th>
                                <th scope="col">Name</th>
                                <th scope="col">Comment</th>
                                <th scope="col">Post Title</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 0;
                                  $hide = 0;
                            ?>
                            <?php foreach(get_comments(1) as $comment): 
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
                                <td><?php
                                echo $comment["datetime"];
                                ?></td>
                                <td><?php
                                echo $comment["commenter_name"];
                                ?></td>
                                <td><?php
                                if(strlen($comment['comment']) > 100) {
                                    echo substr($comment['comment'],0,100) . '...';
                                }else {
                                    echo $comment['comment']; 
                                }
                                ?></td>
                                <td>
                                    <?php
                                        echo get_posts("", $comment['post_id'])['title'];
                                    ?>
                                </td>
                                <td class='action-links'><a href='comment.php?id=<?php echo $comment["id"]; ?>' class='btn btn-info btn-sm'>Edit</a>
                                <form onsubmit="return confirm('Are You Sure?');" action="delete_approve_comment.php" method='POST'>
                                    <input type="hidden" value="<?php echo $comment["id"]; ?>" name="id">
                                    <input name='deletecomment' class='btn btn-danger btn-sm' type='submit' value="Delete" />
                                </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php if($hide > 10){ ?>
                        <a href="" class='show-more'>show more <i class='fa fa-angle-down'></i></a> 
                    <?php } ?>                       
                </div>
                <div class="unapproved-comments table-responsive">
                    <h4> Un-Approved Comments </h4>
                    <table class="table table-striped table-hover table-dark">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Created_at</th>
                                <th scope="col">Name</th>
                                <th scope="col">Comment</th>
                                <th scope="col">Post Title</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 0;
                                  $hide = 0;
                            ?>
                            <?php foreach(get_comments(0) as $comment): 
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
                                <td><?php
                                echo $comment["datetime"];
                                ?></td>
                                <td><?php
                                echo $comment["commenter_name"];
                                ?></td>
                                <td><?php
                                if(strlen($comment['comment']) > 100) {
                                    echo substr($comment['comment'],0,100) . '...';
                                }else {
                                    echo $comment['comment']; 
                                }
                                ?></td>
                                <td>
                                    <?php
                                        echo get_posts("", $comment['post_id'])['title'];
                                    ?>
                                </td>
                                <td class='action-links'><a href='comment.php?id=<?php echo $comment["id"]; ?>' class='btn btn-info btn-sm'>Edit</a>
                                <form onsubmit="return confirm('Are You Sure?');" action="delete_approve_comment.php" method='POST'>
                                    <input type="hidden" value="<?php echo $comment["id"]; ?>" name="id">
                                    <input name='deletecomment' class='btn btn-danger btn-sm' type='submit' value="Delete" />
                                    <input name='approvecomment' class='btn btn-success btn-sm' type='submit' value="Approve" />
                                </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <a style="float:right;margin-bottom:10px;" class="btn btn-primary" href="comment.php"><i class='fa fa-plus'></i> Add New Comment</a>
                    <?php if($hide > 10){ ?>
                        <a href="" class='show-more'>show more <i class='fa fa-angle-down'></i></a> 
                    <?php } ?>                       
                </div>
                
            </div>
        </div>
    </div>
</div>

<?php include "inc/footer.php"; ?>