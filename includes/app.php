<?php

require 'funciones.php';
require 'config/db.php';
require __DIR__ . '/../vendor/autoload.php';

$db = conectarDB();

use App\Entidad;

Entidad::setDB($db);