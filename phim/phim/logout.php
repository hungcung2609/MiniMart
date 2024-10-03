<?php
session_start();

// Hủy bỏ tất cả các biến session
$_SESSION = array();

// Hủy bỏ session
session_destroy();

// Chuyển hướng người dùng đến trang index.php sau khi đăng xuất
header("Location: index.php");
exit;
?>
