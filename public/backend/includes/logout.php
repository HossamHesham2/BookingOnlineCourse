<?php

session_start();
if (isset($_SESSION["role"])) {
  session_unset();
  session_destroy();
  header("Location: /fullstackProject/dashboard/auth/login.php");
}
