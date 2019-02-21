<?php 

/*
    This file has all admin panel functions
*/

// Categories Functions
function get_categories($limit = "", $id = "") {
    include "connect.php";
    if($limit) {
        $sql = "SELECT * FROM categories ORDER BY datetime DESC LIMIT $limit ";
    }else if($id) {
        $sql = "SELECT * FROM categories WHERE id = ? ";
    } else {
        $sql = "SELECT * FROM categories ORDER BY datetime DESC";
    }
    try {
        if($id){
            $result = $con->prepare($sql);
            $result->bindValue(1, $id, PDO::PARAM_INT);
            $result->execute();
            return $result->fetch();
        }else {
            $result = $con->query($sql);
            return $result;
        }
    }catch(Exception $e) {
        echo "Error: ". $e->getMessage() . '\n';
        return array();
    }
}

function insert_category($datetime, $name, $author) {
    include "connect.php";
    $sql = "INSERT INTO categories (datetime, name, creater_name) VALUES (?, ?, ?)";
    try{
        $result = $con->prepare($sql);
        $result->bindValue(1, $datetime, PDO::PARAM_STR);
        $result->bindValue(2, $name, PDO::PARAM_STR);
        $result->bindValue(3, $author, PDO::PARAM_STR);

        return $result->execute();

    }catch(Exception $e) {
        echo "Error: ". $e->getMessage() . '\n';
        return false;
    }
}

function update_category($id, $name) {
    include "connect.php";
    $sql = "UPDATE categories SET name = ? WHERE id = ? ";

    try {
        $result = $con->prepare($sql);
        $result->bindValue(1,$name, PDO::PARAM_STR);
        $result->bindValue(2,$id, PDO::PARAM_INT);

        return $result->execute();
    }catch(Exception $e) {
        echo "Error: ".$e->getMessage();
        return false;
    }
}

// Posts Functions
function insert_post($datetime, $title, $content, $category, $tags, $excerpt,$author, $image) {
    $fields = array($datetime, $title, $content, $category, $tags, $excerpt,$author, $image);
    include "connect.php";
    $sql = "INSERT INTO posts (datetime, title, content,category, tags, excerpt,author, image) VALUES (?,?,?,?,?,?,?,?) ";
    try{
        $result = $con->prepare($sql);
        for($i=1; $i<=8; $i++){
            $result->bindValue($i, $fields[$i-1], PDO::PARAM_STR);
        }
        return $result->execute();
    }catch(Exception $e) {
        echo "Error: ". $e->getMessage() . '\n';
        return false;
    }
}

function get_posts($limit = "",$id = "") {
    include "connect.php";
    if($limit) {
        $sql = "SELECT * FROM posts ORDER BY datetime DESC LIMIT 3 ";
    }else if($id){
        $sql = "SELECT * FROM posts WHERE id = ? ";
        
    }else {
        $sql = "SELECT * FROM posts ORDER BY datetime DESC";
    }
    try {
        if($id) {
            $result = $con->prepare($sql);
            $result->bindValue(1,$id,PDO::PARAM_INT);
            $result->execute();
            return $result->fetch(PDO::FETCH_ASSOC) ;
        }else {
            $result = $con->query($sql);
            return $result;
        }
    }catch(Exception $e) {
        echo "Error: ". $e->getMessage() . '\n';
        return array();
    }
}

function update_post($title, $content, $category, $tags, $excerpt,$author, $image = "", $id) {
    $fields = array($title, $content, $category, $tags, $excerpt,$author);
    include "connect.php";
    $sql = "";
    if(empty($image)) {
        $sql = "UPDATE posts SET title = ?, content = ?, category = ?, tags = ?, excerpt = ?, author = ? WHERE id = ?";
    } else {
        $sql = "UPDATE posts SET title = ?, content = ?, category = ?, tags = ?, excerpt = ?, author = ?, image = ? WHERE id = ?";
    }
    
    try {
        $result = $con->prepare($sql);
        for($i=1; $i <= 6; $i++){
            $result->bindValue($i,$fields[$i - 1],PDO::PARAM_STR);
        }
        if($image) {
            $result->bindValue(7,$image,PDO::PARAM_STR);
            $result->bindValue(8,$id,PDO::PARAM_INT);
        }else {
            $result->bindValue(7,$id,PDO::PARAM_INT);
        }
        return $result->execute();
    }catch(Exception $e) {
        echo "Error: ".$e->getMessage() . '/n';
        return false;
    }
}


/* Admin Functions */
function get_admins($id = "") {
    include "connect.php";
    if($id) {
        $sql = "SELECT * FROM admins WHERE id = ? ";
    } else {
        $sql = "SELECT * FROM admins ORDER BY datetime DESC";
    }
    try {
        if($id){
            $result = $con->prepare($sql);
            $result->bindValue(1, $id, PDO::PARAM_INT);
            $result->execute();
            return $result->fetch(PDO::FETCH_ASSOC);
        }else {
            $result = $con->query($sql);
            return $result;
        }
    }catch(Exception $e) {
        echo "Error: ". $e->getMessage() . '\n';
        return array();
    }
}
function insert_admin($datetime, $username, $email, $password, $role_type, $image, $created_by) {
    $fields = array($datetime, $username, $email, $password, $role_type, $image, $created_by);
    include "connect.php";
    $sql = "INSERT INTO admins (datetime, username, email, password, role_type, image, created_by) VALUES (?, ?, ?, ?, ?, ?, ?)";
    try {
        $result = $con->prepare($sql);
        for($i=1; $i<=7; $i++){
            $result->bindValue($i, $fields[$i-1], PDO::PARAM_STR);
        }
        return $result->execute();
    }catch(Exception $e) {
        echo "Error: ".$e->getMessage();
        return false;
    }
}

function is_admin($email) {
    include "connect.php";
    $sql = "SELECT id, email, username, password FROM admins WHERE email = ? ";

    try{
        $result = $con->prepare($sql);
        $result->bindValue(1, $email,PDO::PARAM_STR);
        $result->execute();
        return $result->fetch(PDO::FETCH_ASSOC);
    }catch(Exception $e) {
        echo "Error: ".$e->getMessage();
        return false;
    }
}

/* Comment Functions */ 
function insert_comment($datetime, $commenter_name, $commenter_email, $comment, $post_id) {
    $fields = array($datetime, $commenter_name, $commenter_email, $comment);
    include "connect.php";
    $sql = "INSERT INTO comments (datetime, commenter_name, commenter_email, comment, post_id) VALUES (?, ?, ?, ?, ?)";
    try {
        $result = $con->prepare($sql);
        for($i=1; $i<=4; $i++){
            $result->bindValue($i, $fields[$i-1], PDO::PARAM_STR);
        }
        $result->bindValue(5, $post_id,PDO::PARAM_INT);
        return $result->execute();
    }catch(Exception $e) {
        echo "Error: ".$e->getMessage();
        return false;
    }
}

function update_comment($comment, $post_id,$id) {
    include "connect.php";
    $sql = "UPDATE comments SET comment = ?, post_id = ? WHERE id = ? ";

    try {
        $result = $con->prepare($sql);
        $result->bindValue(1,$comment, PDO::PARAM_STR);
        $result->bindValue(2,$post_id, PDO::PARAM_INT);
        $result->bindValue(3,$id, PDO::PARAM_INT);

        return $result->execute();
    }catch(Exception $e) {
        echo "Error: ".$e->getMessage();
        return false;
    }
}

// get comment by id
function get_comment($id) {
    include "connect.php";
    $sql = "SELECT comments.*, posts.id, posts.title FROM comments INNER JOIN posts ON comments.post_id = posts.id";
    try {
        $result = $con->prepare($sql);
        $result->execute();
        return $result->fetch(PDO::FETCH_ASSOC);
    }catch(Exception $e) {
        echo "Error: ". $e->getMessage();
        return "";
    }
}


// get all comments, get approved comments, gets unapproved comments
function get_comments($approve = "") {
    include "connect.php";
    $sql = "";
    if($approve !== 0 && $approve !== 1) {
        $sql = "SELECT * FROM comments";
    }else {
        $sql = "SELECT * FROM comments WHERE approve = $approve";
    }
    try {
        if($approve == 0 || $approve == 1) {
            $result = $con->prepare($sql);
            $result->execute();
            return $result->fetchAll(PDO::FETCH_ASSOC);
        }else {
            $result = $con->query($sql);
            return $result;
        }
    }catch(Exception $e) {
        echo "Error: ". $e->getMessage() . '\n';
        return array();
    }
}

// get number of post comments using post id
function get_post_comments($approve, $id = "") {
    include "connect.php";
    if(! empty($id)){
        $sql = "SELECT * FROM comments WHERE approve = $approve AND post_id = ?";
    }else {
        $sql = "SELECT * FROM comments WHERE approve = $approve";
    }
    try{
            $result = $con->prepare($sql);
            if(! empty($id)){
                $result->bindValue(1,$id, PDO::PARAM_INT);
            }
            $result->execute();
            return $result->rowCount();
    }catch(Exception $e) {
        echo "Error: ". $e->getMessage();
        return false;
    }
}



// approve unapproved comment
function approve($id) {
    include "connect.php";
    $sql = "UPDATE comments SET approve = 1 WHERE id = ? ";
    try {
        $result = $con->prepare($sql);
        $result->bindValue(1,$id, PDO::PARAM_INT);
        return $result->execute();
    }catch(Exception $e) {
        echo "Error: ".$e->getMessage();
        return false;
    }
}


/* Settings Functions */ 

function get_settings() {
    include "connect.php";
    $sql = "SELECT * FROM settings";
    try {
        $result = $con->query($sql);
        return $result;
    }catch(Exception $e) {
        echo "Error: ". $e->getMessage();
        return array();
    }
}
function update_general_settings($name, $tagline, $image = "") {
    include "connect.php";
    if(empty($image)) {
        $sql = "UPDATE settings SET name = ?, tagline = ? ";
    }else {
        $sql = "UPDATE settings SET name = ?, tagline = ?, logo = ? ";
    }

    try {
        $result = $con->prepare($sql);
        $result->bindValue(1,$name, PDO::PARAM_STR);
        $result->bindValue(2,$tagline, PDO::PARAM_STR);
        if(! empty($image)) {
            $result->bindValue(3,$image, PDO::PARAM_STR);
        }
        return $result->execute();
    }catch(Exception $e) {
        echo "Error: ".$e->getMessage();
        return false;
    }
}

function update_posts_settings($hpn, $order, $related, $recent) {
    include "connect.php";
    $sql = "UPDATE settings SET home_posts_number = ?, posts_order = ?, related_posts_number = ?, recent_posts_number = ? ";
    try {
        $result = $con->prepare($sql);
        $result->bindValue(1,$hpn, PDO::PARAM_INT);
        $result->bindValue(2,$order, PDO::PARAM_STR);
        $result->bindValue(3,$related, PDO::PARAM_INT); 
        $result->bindValue(4,$recent, PDO::PARAM_INT);
        
        return $result->execute();
    }catch(Exception $e) {
        echo "Error: ".$e->getMessage();
        return false;
    }

}
/* Global Functions */

function redirect($location) {
    header("Location: $location");
    exit;
}

function delete($table, $id) {
    include "connect.php";
    $sql = "DELETE FROM $table WHERE id = ?";
    try{
        $result = $con->prepare($sql);
        $result->bindValue(1,$id,PDO::PARAM_INT);
        return $result->execute();
    }catch(Exception $e) {
        echo "Error: ".$e->getMessage();
        return false;
    }
}
