<?php
session_start();

if (isset($_SESSION['authenticated'])){
    //It's all good!
} else {
    header('Location: login.php');
}