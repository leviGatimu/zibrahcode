<?php
require_once __DIR__ . '/../includes/bootstrap.php';
unset($_SESSION['admin_id']);
redirectTo('/admin/login.php');
