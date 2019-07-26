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


class Cars extends Db {

  //select all data from the database

  public function select()
  {
     $SQL = "SELECT * FROM cars";

     $result = $this->connect()->query($SQL);
//rowCount-sorok számolása a táblán
     if($result->rowCount() >0 ){
//Addig megy a loup amennyi adat van az adatbázisban
       while ($row = $result->fetch()) {

          $data[] = $row;
       }

       return $data;

     }
  }

  public function insert($fields){

    //"INSERT INTO cars (brand, model, year) VALES (:brand,:model,:year)";

    $implodeColumns = implode(', ',array_keys($fields));

    $implodePlaceholder = implode(", :",array_keys($fields));

    $SQL = "INSERT INTO cars ($implodeColumns) VALUES (:".$implodePlaceholder.")";

    $stmt = $this->connect()->prepare($SQL); //stmt helyett bármi más név is lehetne (prepared statement)

    foreach ($fields as $key => $value) {

      $stmt->bindValue(':'.$key,$value);
    }
    $stmtExec = $stmt->execute();

    if($stmtExec){
      header('Location: index.php');
    }
  }

  public function selectOne($id)
  {
                    //A kettős pont placeholdernek felel meg!!
    $SQL = "SELECT * FROM cars WHERE id = :id";
    $stmt = $this->connect()->prepare($SQL);
    $stmt->bindValue(":id",$id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC); //$resultnak ez lesz az array-a
    return $result;
  }
  public function update($fields,$id){
    //$SQL = "Update cars SET brand=:brand,model=:model,year=:year";

    $st = "";
    $counter = 1;
    $total_fields = count($fields); //összes elem ami a táblán van
    foreach($fields as $key => $value){
      if($counter === $total_fields){
        $set = "$key = :".$key;
        $st = $st.$set;
      } else{
           $set = "$key = :".$key.",";
           $st = $st.$set;
           $counter++;
      }
      }

      $SQL = "";
      $SQL.= "UPDATE cars SET ".$st;
      $SQL.=" WHERE id = ".$id;

      $stmt = $this->connect()->prepare($SQL);

      foreach ($fields as $key => $value) {
        $stmt->bindValue(':'.$key, $value);
      }

      $stmtExec = $stmt->execute();

      if($stmtExec){
        header('Location: index.php');
      }
    }

    public function destroy($id){
      $SQL = "DELETE FROM cars WHERE id = :id";

      $stmt = $this->connect()->prepare($SQL);
      $stmt->bindValue(":id", $id);
      $stmt->execute();
    }

    public function handleErrors(){
      if(empty($brand)){
        $_SESSION['errors["brandError"]'] = "The Brand field is required";//Egy felső vonás után csak kettőst lehet használni
      }
      if(empty($model)){
        $_SESSION['errors["modelError"]'] = "The Model field is required";
      }
      if(empty($year)){
        $_SESSION['errors["yearError"]'] = "The Year field is required";
      }
      header('Location:create.php');
      exit();
   }

}
