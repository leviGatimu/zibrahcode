<?php
require_once __DIR__ . '/includes/bootstrap.php';
unset($_SESSION['user_id']);
redirectTo('/index.php');
