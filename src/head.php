<?php
require_once '../configs/artsmania-config.php';
require 'sessions.php';
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
          integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="canonical" href="https://getbootstrap.com/docs/4.1/examples/sticky-footer-navbar/">
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="images/logo-min.png" type="image/x-icon">
    <title>ARTS MANIA |  SKJM, SKSBV KOZHIKODE DISTRCT</title>
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">

        <a class="navbar-brand" href="#">Arts Mania</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02"
                aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="participants.php">Participants</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="events.php">Events</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Final List</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Certificate</a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="logout.php" style="color: black;"><i class="fas fa-sign-out-alt"></i>Logout</a></li>
            </ul>

        </div>
    </nav>
</header>
<div class="loader" id="AjaxLoader" style="display:none;">
    <div class="strip-holder">
        <div class="strip-1"></div>
        <div class="strip-2"></div>
        <div class="strip-3"></div>
    </div>
</div>
