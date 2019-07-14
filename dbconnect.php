<?php
  require_once('./core/config.php');

  $mysqli = new mysqli($host, $username, $pass, $dbname);
  if ($mysqli->connect_error) {
  error_log($mysqli->connect_error);
  exit;
}
