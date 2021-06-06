<?php 

function conectarDB()
{
  //Get Heroku ClearDB connection information
  $cleardb_url = parse_url(getenv("CLEARDB_DATABASE_URL"));
  $cleardb_server = $cleardb_url["host"];
  $cleardb_username = $cleardb_url["user"];
  $cleardb_password = $cleardb_url["pass"];
  $cleardb_db = substr($cleardb_url["path"],1);
  $active_group = 'default';
  $query_builder = TRUE;
  
  $db = new PDO("mysql:host={$cleardb_server}; dbname={$cleardb_db}", $cleardb_username, $cleardb_password);
  
  if (!$db) {
    echo "Error: No se pudo conectar la base de datos";
    exit;
  }
  
  return $db;
}
?>