<?php 

/*
    This file has all admin panel functions
*/

function redirect($location) {
    header("Location: $location");
    exit;
}

// Categories Functions
function get_categories($limit = "") {
    include "connect.php";
    if($limit) {
        $sql = "SELECT * FROM categories ORDER BY datetime DESC LIMIT 3 ";
    }else {
        $sql = "SELECT * FROM categories ORDER BY datetime DESC";
    }
    try {
        $result = $con->query($sql);
        return $result;
    }catch(Exception $e) {
        echo "Error: ". $e->getMessage() . '\n';
        return array();
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
