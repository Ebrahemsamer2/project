<?php 

/*
    This file has all admin panel functions
*/

// Categories Functions
function get_categories() {
    include "connect.php";
    $sql = "SELECT * FROM categories";
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

