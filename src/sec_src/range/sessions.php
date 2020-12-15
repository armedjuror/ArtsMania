<?php
require_once '../../../configs/artsmania-config.php';
session_start();
if (!isset($_SESSION['range-id'])) {
    header('location: logout.php');
    exit();
}
$session_id = $_SESSION['range-id'];