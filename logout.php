<?php
session_start();
unset($_SESSION['user']);
if (isset($_COOKIE['user'])) {
    setcookie('user', '', time() - 1, '/');
}
header('location:login.php');
