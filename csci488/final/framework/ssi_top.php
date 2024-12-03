<?php
if (!isset($security)){
  $security = false;
}
if($security){
  require_once "framework/security.php";
}
?>
<!DOCTYPE html>
<html>

<head>
  <title>CSCI 488</title>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <meta name="keywords" content="CS 488">
  <meta name="description" content="CS 488 Home Page">

  <!-- base sets url for all relative urls -->
  <base href="/~cherepanovds/csci488/">

  <link rel="stylesheet" type="text/css" href="css/normalize.css">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>

  <link rel="stylesheet" type="text/css" href="css/styles.css">

</head>

<body class="bg-dark text-white">
  <div class="container-lg gx-0">
    <nav class="navbar navbar-expand-sm sticky-top navbar-dark bg-primary">
      <div class="container-fluid">
        <a class="navbar-brand" href="#"><img src="image/lfclogo.png" height="30" width="30"><b>&nbsp;CS 488</b></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-sm-center" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link active" href="#">Home</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown">
                Homework
              </a>
              <div class="dropdown-menu">
                <a class="dropdown-item" href="homework/CSS_worksheet.html">CSS Worksheet</a>
                <a class="dropdown-item" href="homework/dhtml_json.html">DHTML JSON</a>
                <a class="dropdown-item" href="homework/hw_jquery_tabs/jquery_tabs.html">jquery_tabs</a>
                <a class="dropdown-item" href="homework/api_fetch.html">API fetch</a>
                <a class="dropdown-item" href="homework/html_form.html">HTML Form</a>
                <a class="dropdown-item" href="homework/form_summary.html">Form Summary</a>
                <a class="dropdown-item" href="homework/crud/page_listing.php">CRUD</a>
                <a class="dropdown-item" href="app/signup.php">App Sign Up</a>
                <a class="dropdown-item" href="homework/session/hw_page1.php">Sign Up</a>
                <a class="dropdown-item" href="final/index.php">Final</a>
              </div>
            </li>
            <?php if (logon_state::check_valid_state()) { ?>
            <!-- New Account Profile Section -->
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown">
                <?= logon_state::get_account_from_state()->values["acc_email"] ?>
              </a>
              <div class="dropdown-menu">
                <a class="dropdown-item" href="final/account.php">Home</a>
                <a class="dropdown-item" href="final/signup.php?task=edit">Edit Profile</a>
                <a class="dropdown-item" href="final/stats.php">Stats</a>
                <a class="dropdown-item" href="final/logout.php">Logout</a>
              </div>
            </li>
            <?php } ?>
          </ul>
        </div>
      </div>
    </nav>
  </div>

  <br class="gap">
  <main class="container-lg">
