<?php
session_start();
$_SESSION['abn'] = "{$_GET['abn']}";
$_SESSION['businessName'] = "{$_GET['businessName']}";
header("location: ../../login.php");
?>