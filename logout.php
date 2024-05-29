<?php
session_start();
require "config/constants.php";
session_destroy();

// header('Location: ' . ROOT_URL);
header('Location: ' . $_SERVER['HTTP_REFERER']);
die();
