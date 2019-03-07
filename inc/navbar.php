<?php include "admin/inc/functions.php"; ?>
<?php foreach (get_settings() as $setting) {
  $logo = $setting['logo'];
  $tagline = $setting['tagline'];
  $sitename = $setting['name'];
} ?>

<div class="header">
  <div class="container-fluid">
    <form class="form-inline my-2 my-lg-0">
      <input name="search" class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button name="searching" class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>

      <!-- <img class="logo" width="60" height="60" src="admin/uploads/<?php // echo $logo; ?>"> -->
    <a class="logo" href="index.php"><span>ZB</span><span>log</span></a>
    <ul class="pages list-unstyled">
      <li><a href="home.php">Home</a></li>
      <li><a href="about.php">About us</a></li>
      <li><a href="contact.php">Contact</a></li>
      <li class="search"><a href=""><i class="fa fa-search"></i></a></li>
      <li class="sign-in"><a href="">Sign-in</a></li>
    </ul>
  </div>
  <p class="lead sitename"><?php echo $sitename; ?></p>
  <p class="lead tagline"><?php echo $tagline; ?></p>
</div>