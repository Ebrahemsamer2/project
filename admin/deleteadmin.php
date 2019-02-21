<?php
    include "inc/functions.php";
    
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        if(isset($_POST['deleteadmin'])) {
            $id = filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT);
            if(! session_id()){
                session_start();
            }
            if(delete('admins',$id)) {
                $_SESSION['success_msg'] = "Admin has been Deleted";
                redirect("admins.php");
            }else {
                $_SESSION['error_msg'] = "Unable to Delete Admin";
                redirect("admins.php");  
            }
        }
    }
?>