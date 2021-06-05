<?php 

if (!isset($_SESSION)) {
  session_start();
} 

$_SESSION = [];

header('Location: /8_crud/');