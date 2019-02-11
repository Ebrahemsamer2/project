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
            $password = $_POST['password'];
            $admin_found = is_admin($email);

            if($admin_found){
                if(! session_id()) {
                    session_start();
                }
                if(password_verify($password, $admin_found['password'])) {
                    $_SESSION['admin_username'] = $admin_found['username'];
                    $_SESSION['id'] = $admin_found['id'];
                    redirect("index.php");
                }else {
                    $_SESSION['error'] = "Wrong Password, If you're not remember it press <a href='' class='forgot-password'>forgot my password</a>";
                }
            }else {
                if(! session_id()) {
                    session_start();
                }
                $_SESSION['error'] = "You Email is Wrong, You can not Access Admin Panel";
            }
        }
    } 
    ?>
    <div class="login">
        <div class='login-form'>
        <?php 
            if(! session_id()){
                session_start();
            }
            if(isset($_SESSION['error'])) {
                echo "<div class='alert alert-default'>";
                echo $_SESSION['error'];
                echo "</div>";
            }
        ?>
            <h6>Hello Admin</h6>
            <form action="login.php" method="POST">
                <div class='form-group'>
                    <input class='form-control' value='<?php echo $email; ?>' type="email" name='email' placeholder="Email" required autocomplete='off'>
                    <i class='fa fa-envelope'></i>
                </div>
                <div class='form-group'>
                    <input class='form-control' type="password" name='password' placeholder="Password" required autocomplete='off'>
                    <i class='fa fa-unlock-alt'></i>
                </div>
                <input type="submit" value="Login" name='login' class='btn btn-default form-control'>
            </form>
        </div>
    </div>

<?php include "inc/footer.php"; ?>