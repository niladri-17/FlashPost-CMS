<?php
require "constants.php";

$connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if (!$connection) {
    die('Connection Failed: ' . mysqli_error($connection));
}
