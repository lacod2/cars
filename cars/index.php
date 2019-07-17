<?php
//Fileok hozzácsatolása az index.php-hoz
function __autoload($class)
{
require_once "classes/$class.php";
}
//Delete funkcióhoz kell
if(isset($_GET['del'])){
  $id = $_GET['del'];

  $cars = new Cars();
  $cars->destroy($id);
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
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">About</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Contact</a>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>

<!--Tábla neve-->
<div class="container mt-4">
  <div class="row">
    <div class="col-lg-12">
     <div class="jumbotron"> <!--Ez a szürkés box a szöveg mögött-->
       <a href="create.php" class="float-right btn btn-success">Add cars</a> <!--href csatolja össze a két oldalt-->
        <h4 class="mb-4">All cars</h4>

<!--Tábla-->
       <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Brand</th>
      <th scope="col">Model</th>
      <th scope="col">Year</th>
      <th scope="col">Action</th>

    </tr>
  </thead>
  <tbody>
    <!--Hozzáférést ad a cars.php-ban lévő kódhoz-->
    <?php
       $cars = new Cars();
       //Az adatok a sorban $rows. A $cars->select() pedig erre mutat "$SQL = "SELECT * FROM cars";"
       $rows = $cars->select();

       foreach ($rows ? $rows : [] as $row) { // A kérdőjel, kettőspont és a négyzetes zárójel azért kell, hogyha nincs egy adat se adva a táblához akkor ne dobjon ki errort. (Nullnak veszi az arrayt)

    ?>
         <tr> <!--Oszlopok, hogy az adatbázisnak megfelőlen legyenek így kell kitölteni-->
           <th scope="row"><?php echo $row['id']; ?></th>
           <td><?php echo $row['brand'];?></td>
           <td><?php echo $row['model'];?></td>
           <td><?php echo $row['year'];?></td>
           <td><a class="btn btn-sm btn-primary" href="edit.php?id=<?php echo $row['id'];?>">Edit</a> &nbsp; <a class="btn btn-sm btn-danger" href="index.php?del=<?php echo $row['id'];?>">Delete</a></td>
         </tr>
         <!--Mivel HTMLben van a felső pár sor ezért be ke kellett zárni a php kódot és nyitni egy újat.-->
      <?php
       }
      ?>



  </tbody>
</table>

     </div>
</div>

  </body>
</html>
