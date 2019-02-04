<?php 
$page_title = "Admin Login | Zblog";
    include "inc/header.php";
    include "inc/functions.php";
    $email = "";
?>

    <?php
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        if(isset($_POST['login'])) {
            $email = filter_input(INPUT_POST, 'email' , FILTER_SANITIZE_EMAIL);
            

        }
    } 
    ?>

    <h4 class='login-title text-center'>Welcome to <span style="color:#e08b8b; font-size:40px;">Z</span>blog</h4>
    <div class='login'>
        <div class='form-header text-center'>
            Login to Admin Panel
        </div>
        <form action="login.php" method="POST">
            <div class='form-group'>
                <input class='form-control' value='<?php echo $email; ?>' type="email" name='email' placeholder="Email" required autocomplete='off'>
                <i class='fa fa-envelope'></i>
            </div>
            <div class='form-group'>
                <input class='form-control' type="password" name='password' placeholder="Password" required autocomplete='off'>
                <i class='fa fa-unlock-alt'></i>
            </div>
            <input type="submit" value="Login" name='login' class='btn btn-default'>
            <a href="">Forgot your password?</a>
        </form>
    </div>

<?php include "inc/footer.php"; ?>