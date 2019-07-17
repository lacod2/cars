<?php
class Db { //Ez az a class amire "require_once "classes/$class.php" " mutat az edit fájlban
  protected function connect()
  {
    //connection
    try {
    $conn = new PDO("mysql:host=localhost;dbname=cars", 'root', 'root');
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected successfully";
    return $conn;

    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }
  }
}
