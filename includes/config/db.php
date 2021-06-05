<?php 

function conectarDB($dbName = 'crud_tienda', $user = 'root', $password = '')
{
  $db = new PDO("mysql:host=localhost; dbname={$dbName}", $user, $password);

  if (!$db) {
    echo "Error: No se pudo conectar la base de datos";
    exit;
  }

  return $db;
}


// $query = "SELECT title FROM propiedades";

// // Consultar bd
// $propiedades = $db->query($query)->fetchAll();

// $statement = $db->prepare($query);

// $statement->execute();

// $resultado = $statement->fetch( PDO::FETCH_ASSOC );

// var_dump($resultado);

?>