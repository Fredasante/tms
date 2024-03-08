<?php

$con = new mysqli('localhost', 'alfred', 'fRED6996@', 'tractor_management_system');

if ($con->connect_error) {
  die('Connection failed: ' . $con->connect_error);
} else {
  echo '';
}

?>