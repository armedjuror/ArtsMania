<?php
include_once '../../configs/examify-config.php';
session_start();
session_unset();
session_destroy();
header('location: login.php');