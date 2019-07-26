<?php
session_start(); //Ennek előtte kell lennie mindennek
//Fileok hozzácsatolása az index.php-hoz
function __autoload($class)
{
require_once "classes/db.php";
}

if (isset($_POST['submit'])) {

$brand = $_POST['brand'];
$model = $_POST['model'];
$year = $_POST['year'];
//! a nemet jelenti. !empty()-Ha nem üres  &&-logikai operátor
if(!empty($brand) && !empty($model) && !empty($year)){
//Ha HTML tagel írják be az inputba a szöveget, akkor azt leszedi
$brand = filter_var($brand, FILTER_SANITIZE_STRING);//php oldaláról van bemásolva, a HTML tag-et szedi le
$model = filter_var($model, FILTER_SANITIZE_STRING);
$year = filter_var($year, FILTER_SANITIZE_STRING);
  //Ez egy array. Amikor több változó van egy "alatt"
  $fields = [
    'brand'=>$brand,
    'model'=>$model,
    'year'=>$year,
  ];

  $cars = new Cars();

  $cars->insert($fields);

} else {
$cars = new Cars();
$cars->handleErrors();


}



}

?>
<!--HTML itt kezdődik-->
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Cars</title>
    <!--Bootstrap CSS-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>

<!--Fejléc-->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Japanese Cars</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
      </li>
    </ul>
  </div>
</nav>

<!--Tábla neve-->
<div class="container mt-4">
  <div class="row">
    <div class="col-lg-12">
     <div class="jumbotron">
       <h4 class="mb-4">Add cars</h4>
<!--Ha a form actiont üresen hagyod akkor ugyanerre az oldalra menti el az adatot-->
       <form action="" method="post">
         <div class="form-group">
           <label for="brand">Brand:</label>                    <!--Ez szerintem kitörölhető!!!-->
           <input type="text" class="form-control" name="brand" aria-describedby="emailHelp" placeholder="Enter brand">
           <?php
              if(isset($_SESSION['errors["brandError"]'])){
                ?>


                  <div class="alert alert-danger mt-2" role="alert">
                      <?php echo $_SESSION['errors["brandError"]']; ?>
                    </div>

              <?php
                  }
               ?>
         </div>
         <div class="form-group">
           <label for="model">Model:</label>
           <input type="text" name="model" class="form-control"  placeholder="Enter model">
           <?php //A felirathoz kell ha nem írnak be semmit az input fieldbe
              if(isset($_SESSION['errors["modelError"]'])){
                ?>


                  <div class="alert alert-danger mt-2" role="alert">
                      <?php echo $_SESSION['errors["modelError"]']; ?>
                    </div>

              <?php
                  }
               ?>
         </div>
         <div class="form-group">
           <label for="year">Year:</label>
           <input type="number" name="year" class="form-control"  placeholder="Enter year">
           <?php
              if(isset($_SESSION['errors["yearError"]'])){
                ?>


                  <div class="alert alert-danger mt-2" role="alert">
                      <?php echo $_SESSION['errors["yearError"]']; ?>
                    </div>

              <?php //Ez megint csak azért kellett mert HTML van közbe szúrva
                }
               ?>

               <?php
              session_unset(); //Ez tünti el a szöveget, hogy csak akkor írja ki ha tényleg üres
               ?>
         </div>
        <input type="submit" name="submit" class="btn btn-primary">
       </form>


     </div>
</div>

  </body>
</html>
