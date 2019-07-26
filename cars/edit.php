<?php
//Fileok hozzá csatolása az index.php-hoz
function __autoload($class)
{
require_once "classes/db.php";
}

if (isset($_GET['id'])){
  $uid = $_GET['id'];

  $cars = new Cars();

  $result = $cars->selectOne($uid);

}

if (isset($_POST['submit'])) {

$brand = $_POST['brand'];
$model = $_POST['model'];
$year = $_POST['year'];

//Ez egy array. Amikor több változó van egy "alatt"
$fields = [
  'brand'=>$brand,
  'model'=>$model,
  'year'=>$year,
];

$id = $_POST['id'];

$cars = new Cars();
$cars->update($fields,$id);

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
       <h4 class="mb-4">Edit cars</h4>
<!--Ha a form actiont üresen van hagyva akkor ugyanerre az oldalra menti el az adatot-->
       <form action="" method="post">
         <input type="hidden" name="id" value="<?php echo $result['id'];?>">
         <div class="form-group">
           <label for="brand">Brand:</label>                    <!--Ez szerintem kitörölhető!!!-->
           <input type="text" class="form-control" name="brand" aria-describedby="emailHelp" placeholder="Enter brand"
           value="<?php echo $result['brand'];?>">
         </div>
         <div class="form-group">
           <label for="model">Model:</label>
           <input type="text" name="model" class="form-control"  placeholder="Enter model"
           value="<?php echo $result['model'];?>">
         </div>
         <div class="form-group">
           <label for="year">Year:</label>
           <input type="number" name="year" class="form-control"  placeholder="Enter year"
           value="<?php echo $result['year'];?>">
         </div>
        <input type="submit" name="submit" class="btn btn-primary">
       </form>


     </div>
</div>

  </body>
</html>
