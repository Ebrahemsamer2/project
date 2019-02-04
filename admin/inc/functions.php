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
function insert_post($title, $content, $category, $tags, $excerpt,$author, $image) {
    include "connect.php";
    $sql = "INSERT INTO posts (title, content,category, tags, excerpt,author, image) VALUES (?,?,?,?,?,?,?) ";
    try{
        $result = $con->prepare($sql);
        $result->bindValue(1, $title, PDO::PARAM_STR);
        $result->bindValue(2, $content, PDO::PARAM_STR);
        $result->bindValue(3, $category, PDO::PARAM_STR);
        $result->bindValue(4, $tags, PDO::PARAM_STR);
        $result->bindValue(5, $excerpt, PDO::PARAM_STR);
        $result->bindValue(6, $author, PDO::PARAM_STR);
        $result->bindValue(7, $image, PDO::PARAM_STR);

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
    include "connect.php";
    $sql = "";
    if(empty($image)) {
        $sql = "UPDATE posts SET title = ?, content = ?, category = ?, tags = ?, excerpt = ?, author = ? WHERE id = ?";
    } else {
        $sql = "UPDATE posts SET title = ?, content = ?, category = ?, tags = ?, excerpt = ?, author = ?, image = ? WHERE id = ?";
    }
    
    try {
        $result = $con->prepare($sql);
        $result->bindValue(1,$title,PDO::PARAM_STR);
        $result->bindValue(2,$content,PDO::PARAM_STR);
        $result->bindValue(3,$category,PDO::PARAM_STR);
        $result->bindValue(4,$tags,PDO::PARAM_STR);
        $result->bindValue(5,$excerpt,PDO::PARAM_STR);
        $result->bindValue(6,$author,PDO::PARAM_STR);
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