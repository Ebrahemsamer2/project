<?php
    include "inc/functions.php";
    
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        if(isset($_POST['deletecomment'])) {
            $id = filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT);
            if(! session_id()){
                session_start();
            }
            if(delete('comments',$id)) {
                $_SESSION['success_msg'] = "Comment has been Deleted";
                redirect("comments.php");
            }else {
                $_SESSION['error_msg'] = "Unable to Delete Comment";
                redirect("comments.php");  
            }
        }else {
            if(isset($_POST['approvecomment'])) {
                $id = filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT);
                if(! session_id()){
                    session_start();
                }
                if(approve($id)) {
                    $_SESSION['success_msg'] = "Comment has been Approved";
                    redirect("comments.php");
                }else {
                    $_SESSION['error_msg'] = "Unable to Approve Comment";
                    redirect("comments.php");  
                }
            }
        }
    }
?>