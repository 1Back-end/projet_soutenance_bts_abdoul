
<?php
$role_user = $_SESSION['role'] ?? '';
$is_admin = ($role_user == "admin");
$is_system  = ($role_user == "system");
$is_user = ($role_user == "user");
?>