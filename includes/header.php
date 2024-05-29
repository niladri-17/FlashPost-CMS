<?php
// ob_start();
?>
<?php session_start(); ?>
<?php require "config/db.php"; ?>
<?php require "config/functions.php"; ?>
<?php

if (isset($_SESSION['user-id'])) {
  $user_id = filter_var($_SESSION['user-id'], FILTER_SANITIZE_NUMBER_INT);
  $query = "SELECT * FROM users WHERE user_id = '$user_id'";
  $result = mysqli_query($connection, $query);
  $user = mysqli_fetch_assoc($result);
  $user_name = $user['user_name'];
  $user_username = $user['user_username'];
  if (isset($user['user_image'])) {
    $user_image = ROOT_URL . "images/" . $user['user_image'];
  } else {
    $user_image = ROOT_URL . "images/user-profile-image.png";
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>FlashPost</title>

  <!-- Favicon -->
  <link rel="icon" type="image/png" sizes="32x32" href="/cms/assets/images/favicon.png" />
  <!-- Remix icons -->
  <link href="<?= ROOT_URL ?>fonts/remixicon.css" rel="stylesheet" />
  <!-- mini.min.js styles -->
  <link href="<?= ROOT_URL ?>css/mini.min.css" rel="stylesheet" />
  <!-- Custom styles -->
  <link href="<?= ROOT_URL ?>css/index.css" rel="stylesheet" />

</head>

<body>
  <!-- Header -->
  <header class="header" id="header">
    <nav class="navbar container">
      <a href="<?= ROOT_URL ?>">
        <h2 class="logo">FlashPost</h2>
      </a>

      <div class="menu" id="menu">
        <ul class="list">
          <li class="list-item">
            <a href="<?= ROOT_URL ?>" class="list-link current">Home</a>
          </li>
          <!-- <li class="list-item"> -->
          <!-- <span class="btn list-link category">Categories <i class="ri-arrow-down-s-line"></i></span> -->
          <!-- Category dropdown -->
          <!-- <ul class="category-dropdown">
              <li><a href="blog.php?search=travel" class="list-link">Travel</a></li>
              <li><a href="blog.php?search=food" class="list-link">Food</a></li>
              <li><a href="blog.php?search=technology" class="list-link">Technology</a></li>
              <li><a href="blog.php?search=health" class="list-link">Health</a></li>
              <li><a href="blog.php?search=nature" class="list-link">Nature</a></li>
              <li><a href="blog.php?search=fitness" class="list-link">Fitness</a></li>
            </ul> -->
          <!-- </li> -->
          <li class="list-item">
            <a href="#" class="list-link">About Us</a>
          </li>
          <li class="list-item">
            <a href="#" class="list-link">Contact</a>
          </li>

          <?php if (isset($_SESSION['user-id'])) : ?>
            <hr class="screen-lg-hidden" style="width: 100%;">
            <li class="list-item screen-lg-hidden">
              <div class="registration-sm">
                <a href="<?= ROOT_URL . 'admin/' ?>" class="list-link">Dashboard</a>
                <a href="<?= ROOT_URL ?>logout.php" class="list-link">Logout</a>
              </div>
            </li>
          <?php else : ?>
            <li class="list-item screen-lg-hidden">
              <div class="main-nav registration-sm">
                <a href="#0" class="list-link cd-signin">Sign in</a>
                <a href="#0" class="list-link cd-signup">Sign up</a>
              </div>
            </li>
          <?php endif ?>

        </ul>
      </div>

      <div class="list list-right">

        <!-- search -->
        <form id="search">
          <div class="search-input-container">
            <input name="search" id="search-input" type="search" required>
          </div>
          <button id="search-btn" class="btn" type="submit">
            <i class="ri-search-line"></i>
          </button>
        </form>

        <button class="btn place-items-center" id="theme-toggle-btn">
          <i class="ri-sun-line sun-icon"></i>
          <i class="ri-moon-line moon-icon"></i>
        </button>

        <button class="btn place-items-center screen-lg-hidden menu-toggle-icon" id="menu-toggle-icon">

          <?php if (isset($_SESSION['user-id'])) : ?>
            <img <?php if (isset($_SESSION['user-id'])) echo "value=" . $_SESSION['user-id'] ?> class="user-profile-avatar" src="<?= $user_image ?>" alt="Profile photo">
          <?php else : ?>
            <i class="ri-menu-3-line open-menu-icon"></i>
            <i class="ri-close-line close-menu-icon"></i>
          <?php endif ?>

        </button>

        <?php if (isset($_SESSION['user-id'])) : ?>
          <img id="lg-avatar" class="btn user-profile-avatar screen-sm-hidden" src="<?= $user_image ?>" alt="Profile photo">
          <div class="menu-2 screen-sm-hidden" id="menu-2">
            <ul class="list">
              <li class="list-item avatar-dropdown">
                <a href="<?= ROOT_URL . 'admin/' ?>" class="list-link">Dashboard</a>
                <a href="<?= ROOT_URL ?>logout.php" class="list-link">Logout</a>
              </li>
            </ul>
          </div>
        <?php else : ?>
          <div class="main-nav screen-sm-hidden">
            <a href="#0" class="list-link cd-signin">Sign in</a>
            <a href="#0" class="btn sign-up-btn fancy-border cd-signup">
              <span class="cd-signup">Sign up</span>
            </a>
          </div>
        <?php endif ?>

      </div>
    </nav>
  </header>

  <?php if (isset($_SESSION['user-id'])) : ?>
    <a href=" <?= ROOT_URL . "admin/" ?>add-post.php" class="add-post"><i class="ri-add-circle-fill"></i></a>
  <?php endif ?>

  <?php require "includes/registration.php"; ?>