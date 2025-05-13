<?php

session_start();
if (isset($_SESSION["studentName"])) {
  session_unset();
  session_destroy();
  header("Location: /fullstackProject/auth/login.php");
}
