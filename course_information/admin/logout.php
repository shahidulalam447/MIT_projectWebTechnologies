<?php
require('login.php');
session_destroy();
header('location:login.php');
?>