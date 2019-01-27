<?php 
$page_title = "Dashboard";
include "inc/init.php";
$dashboard = "active";

?>


<div class="container-fluid">
    <div class="row">
        <div class="col-sm-2">
            <?php include "inc/sidebar.php"; ?>
        </div>
        <div class="col-sm">
            <div class='main-area'>

                <div class='row'>
                    <div class="col-sm-6">
                        <div class="table-responsive">
                            <h4>Recent Posts <span>( <span style="color:#1da9b7;">33</span> Post )</span></h4>
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
                                    <?php $no = 0; ?>
                                    <?php foreach(get_posts(3) as $post): $no++; ?>
                                    <tr>
                                        <th scope="row"><?php echo $no; ?></th>
                                        <td><?php
                                        if(strlen($post['title']) > 50) {
                                            echo substr($post['title'],0,50);
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
                            
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="table-responsive">
                            <h4>Recent Categories <span>( <span style="color:#1da9b7;">44</span> Category )</span></h4>
                            <table class="table table-striped table-hover table-dark">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Creater Name</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 0; ?>
                                    <?php foreach(get_categories(3) as $category): ?>
                                    <tr>
                                        <?php $no++; ?>
                                        <th scope="row"><?php echo $no; ?></th>
                                        <td><?php echo $category['name']; ?></td>
                                        <td><?php echo $category['creater_name']; ?></td>
                                        <td>Edit / Delete</td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class='row'>
                    <div class="col-sm-6">
                    <div class="table-responsive">
                            <h4>Recent Categories <span>( <span style="color:#1da9b7;">44</span> Category )</span></h4>
                            <table class="table table-striped table-hover table-dark">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Creater Name</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 0; ?>
                                    <?php foreach(get_categories(3) as $category): ?>
                                    <tr>
                                        <?php $no++; ?>
                                        <th scope="row"><?php echo $no; ?></th>
                                        <td><?php echo $category['name']; ?></td>
                                        <td><?php echo $category['creater_name']; ?></td>
                                        <td>Edit / Delete</td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-sm-6">
                    <div class="table-responsive">
                            <h4>Recent Categories <span>( <span style="color:#1da9b7;">44</span> Category )</span></h4>
                            <table class="table table-striped table-hover table-dark">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Creater Name</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 0; ?>
                                    <?php foreach(get_categories(3) as $category): ?>
                                    <tr>
                                        <?php $no++; ?>
                                        <th scope="row"><?php echo $no; ?></th>
                                        <td><?php echo $category['name']; ?></td>
                                        <td><?php echo $category['creater_name']; ?></td>
                                        <td>Edit / Delete</td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>

<?php include "inc/footer.php"; ?>