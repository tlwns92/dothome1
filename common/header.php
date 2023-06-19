<?php

session_set_cookie_params(0);
session_start();

$email = '';

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $user_id = $_SESSION['user_id'];
    $login_time = $_SESSION['login_time'];
    $session_timeout = $_SESSION['session_timeout'];
    $islogin = TRUE;
    // echo "Welcome, " . $_SESSION['email'];
}else{
  $islogin = FALSE;
}
?>

<script>
  function selectCategory(link) {
    var links = document.querySelectorAll('#menu li');
    for (var i = 0; i < links.length; i++) {
      links[i].classList.remove('current_page_item');
    }
    var current_link = document.querySelector(`#menu a[href="${window.location.pathname}"]`).parentNode;
    current_link.classList.add('current_page_item');
  }
</script>

<div id="wrapper">
  <div id="header-wrapper">
    <div id="header">
      <div id="logo">
        <a href="index.php"><img class="main_logo" src="./images/img_logo.png" alt=""></a>
      </div>
    </div><!-- end #header -->
  </div><!-- end #header-wrapper -->
  <div id="menu">
    <ul>
      <!-- <li class="<?php echo ($_GET['category'] === 'index.php' || $_GET['category'] === 'home' || empty($_GET['category'])) ? 'current_page_item' : ''; ?>"><a href="index.php" onclick="selectCategory('index.php')">Home</a></li> -->
      <!-- <li class="<?php echo ($_GET['category'] === './page/home' || $_GET['category'] === 'index' ) ? 'current_page_item' : ''; ?>"><a href="index.php?category=page/home">Home</a></li> -->
      <li class="<?php echo (isset($_GET['category']) && ($_GET['category'] === 'page/home.php' || $_GET['category'] === '') ? 'current_page_item' : (!isset($_GET['category']) ? 'current_page_item' : '')); ?>"><a href="index.php" onclick="selectCategory('index.php')">Home</a></li>
      <li class="<?php echo (isset($_GET['category']) && ($_GET['category'] === 'page/cardi')) ? 'current_page_item' : ''; ?>"><a href="index.php?category=page/cardi">Cardiovascular Border Analysis Demo</a></li>
      <li class="<?php echo (isset($_GET['category']) && ($_GET['category'] === 'page/about')) ? 'current_page_item' : ''; ?>"><a href="index.php?category=page/about">About US</a></li>
      <li class="<?php echo (isset($_GET['category']) && ($_GET['category'] === 'page/study')) ? 'current_page_item' : ''; ?>"><a href="index.php?category=page/study">Study Protocols</a></li>
      <li class="<?php echo (isset($_GET['category']) && ($_GET['category'] === 'page/public')) ? 'current_page_item' : ''; ?>"><a href="index.php?category=page/public">Publications</a></li>
      <li class="<?php echo (isset($_GET['category']) && ($_GET['category'] === 'page/present')) ? 'current_page_item' : ''; ?>"><a href="index.php?category=page/present">Presentations</a></li>
      
    </ul>
  </div><!-- end #menu -->
  </div><!-- end #wrapper -->