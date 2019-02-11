<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF8" />
        <title><?php echo $page_title; ?></title>
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="resources/css/bootstrap.min.css">
        <!-- Font Awesome CSS -->
        <link rel="stylesheet" href="resources/css/font-awesome.min.css">
        <!-- GoogleFont CSS -->
        <link href="https://fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet">
        <!-- My Own style -->
        <link rel="stylesheet" href="resources/css/style.css">
    </head>
<body <?php if($page_title === "Admin Login | Zblog") echo "class='login-style' "; ?> >