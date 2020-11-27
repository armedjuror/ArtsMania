<?php
$connection = mysqli_connect('localhost', 'phpmyadmin', 'fathima11', 'artsmania');

if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit;
}

mysqli_set_charset($connection, 'utf8');
