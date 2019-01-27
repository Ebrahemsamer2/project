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
                <div class="table-responsive">
                    <h4> Posts </h4>
                    <table class="table table-striped table-hover table-dark">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Title</th>
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
                                if(strlen($post['title']) > 40) {
                                    echo substr($post['title'],0,40) . '...';
                                }else {
                                    echo $post['title']; 
                                }
                                    ?></td>
                                <td><?php echo $post['author']; ?></td>
                                <td>Edit / Delete</td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <a style="float:right;margin-bottom:10px;" class="btn btn-primary" href="addnewpost.php"><i class='fa fa-plus'></i> Add New Post</a>
                    <a href="" class='show-more'>show more <i class='fa fa-angle-down'></i></a>                        
                </div>
            </div>
        </div>
    </div>
</div>


<?php include "inc/footer.php"; ?>