<?php 

if (!isset($_SESSION)) {
  session_start();
} 

$_SESSION = [];

header('Location: /');