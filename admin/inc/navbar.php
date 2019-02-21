<?php foreach(get_settings() as $se): 
  $logo = $se['logo'];
  $tagline = $se['tagline'];
endforeach;?>
<nav class="navbar navbar-expand-lg navbar-light bg-dark fixed-top">
<div class="container-fluid">
    <a class="navbar-brand dropdown-toggle" href="#" id="brandDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img class='site-logo' width='45' height='45' src="uploads/<?php echo $logo; ?>" alt=""></a>
    <span class='tagline'><?php echo $tagline; ?></span>
    <div class="dropdown-menu brandmenu" aria-labelledby="brandDropdown">
            <a target="_blank" class="dropdown-item" href="../">View Site</a>
    </div>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
          <?php if(! session_id()) {
              session_start();
            }
            if(isset($_SESSION['admin_username'])) { ?>
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <?php echo $_SESSION['admin_username']; ?>  
              </a>
            <?php } ?>

          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="profile.php">Profile</a>
            <a class="dropdown-item" href="settings.php">Settings</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="logout.php">Logout</a>
          </div>
        </li>
      </ul>
    </div>
  </div>    
</nav>